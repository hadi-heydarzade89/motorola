<?php

if (!defined('ABSPATH')) {
    exit;
}

add_action('digits_activation_hooks', 'digits_create_req_logs_db');

function digits_create_req_logs_db()
{
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    $tb = $wpdb->prefix . 'digits_request_logs';
    if ($wpdb->get_var("SHOW TABLES LIKE '$tb'") != $tb) {
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $tb (
                  request_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
		          phone VARCHAR(40) NOT NULL,
		          email VARCHAR(100) NOT NULL,
		          mode VARCHAR(100) NOT NULL,
		          request_type VARCHAR(100) NOT NULL,
		          user_agent VARCHAR(255) NULL,
		          ip VARCHAR(50) NOT NULL,
		          time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
		          PRIMARY KEY  (request_id)
	            ) $charset_collate;";
    }

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta(array($sql));
}

function digits_add_request_log($phone, $mode)
{
    global $wpdb;
    $table = $wpdb->prefix . 'digits_request_logs';
    $data = array();
    $data['ip'] = digits_get_ip();
    $data['phone'] = $phone;
    $data['mode'] = $mode;
    $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

    return $wpdb->insert($table, $data);
}


function digits_check_request($phone)
{

    $ip = digits_get_ip();

    $brute_force_allowed_ip = get_option("dig_brute_force_allowed_ip");
    if (is_array($brute_force_allowed_ip) && in_array($ip, $brute_force_allowed_ip)) {
        return true;
    }

    $requests = digits_count_req_in_time('phone', $phone, 12, 'hour', false);
    $total_requests = sizeof($requests);
    if ($total_requests > 3) {
        /*count -> minute*/
        $gap_required = array(
            4 => 1,
            5 => 4,
            6 => 8,
            7 => 20,
            8 => 40,
            9 => 60,
            10 => 180,
            11 => 360
        );
        $last_request = reset($requests);
        $last_request_time = strtotime($last_request->time);
        $time_difference = (time() - $last_request_time) / 60;

        $block = true;
        if (isset($gap_required[$total_requests])) {
            $required_gap = $gap_required[$total_requests];
            if ($required_gap < $time_difference) {
                $block = false;
            }

        }
        if ($block) {
            return new WP_Error('limit_exceed', __('OTP limit has exceeded since you made too many attempts, Please try again after some time!', 'digits'));
        }
    }


    $limits = array(
        array(
            'duration_type' => 'day',
            'duration' => 1,
            'max' => 18,
            'type' => 'phone'
        ),
        array(
            'duration_type' => 'day',
            'duration' => 30,
            'max' => 50,
            'type' => 'phone'
        ),
        array(
            'duration_type' => 'day',
            'duration' => 365,
            'max' => 365,
            'type' => 'phone'
        ),
        array(
            'duration_type' => 'minute',
            'duration' => 10,
            'max' => 6,
            'type' => 'ip'
        ),
        array(
            'duration_type' => 'hour',
            'duration' => 1,
            'max' => 20,
            'type' => 'ip'
        ),
        array(
            'duration_type' => 'day',
            'duration' => 1,
            'max' => 90,
            'type' => 'ip'
        ),
        array(
            'duration_type' => 'day',
            'duration' => 30,
            'max' => 300,
            'type' => 'ip'
        ),
        array(
            'duration_type' => 'day',
            'duration' => 365,
            'max' => 1000,
            'type' => 'ip'
        ),
    );

    foreach ($limits as $limit) {
        $duration_type = $limit['duration_type'];
        $duration = $limit['duration'];
        $type = $limit['type'];
        $max = $limit['max'];

        if ($type == 'ip') {
            $key = 'ip';
            $value = $ip;
        } else {
            $key = 'phone';
            $value = $phone;
        }
        $count = digits_count_req_in_time($key, $value, $duration, $duration_type, true);

        if ($count > $max) {
            return new WP_Error('limit_exceed', __('OTP limit has exceeded since you made too many attempts, Please try again after some time!', 'digits'));
        }
    }
    return true;
}

function digits_count_req_in_time($key, $value, $days, $duration_type, $count = true)
{
    global $wpdb;
    $table = $wpdb->prefix . 'digits_request_logs';
    $days = absint($days);

    if (empty($days)) {
        return 0;
    }

    $key = filter_var($key, FILTER_SANITIZE_STRING);

    if ($duration_type == 'hour') {
        $diff = 'TIMESTAMPDIFF(HOUR, time, CURDATE())';
    } elseif ($duration_type == 'minute') {
        $diff = 'TIMESTAMPDIFF(MINUTE, time, CURDATE())';
    } else {
        $diff = 'DATEDIFF(CURDATE(), time)';
    }

    $select = "count(*)";
    if (!$count) {
        $select = "*";
    }
    $query = $wpdb->prepare("select " . $select . " from " . $table . " where " . $key . "='%s' AND " . $diff . " <= " . $days . " ORDER BY time DESC", $value);
    if ($count) {
        $results = $wpdb->get_var($query);
    } else {
        $results = $wpdb->get_results($query);
    }
    return $results;
}
