<?php

require_once __DIR__ . '/vendor/autoload.php';

use ElectroApp\Hooks\ThemeInitHook;

if (!\function_exists('getElectroThemeImageUrl')) {
    function getElectroThemeImageUrl(string $imageName): string
    {
        if (get_theme_file_path('assets/images/' . $imageName)) {
            return get_stylesheet_directory_uri() . '/assets/images/' . $imageName;
        } else {
            return '';
        }

    }
}
$instance = new ThemeInitHook();
$instance();


add_action(
    'wp_enqueue_scripts',
    function () {
        wp_enqueue_script('elector-child-main', get_theme_file_uri('assets/js/main.js'), [], wp_get_theme()->get('Version'), true);
    },
    100
);

add_action('register_form', function () {

    $year = !empty($_POST['register_national_id']) ? intval($_POST['register_national_id']) : '';

    ?>
    <div id="dig_cs_mobilenumber" class="minput">
        <div class="minput_inner">
            <div class="digits-input-wrapper empty">
                <input type="text" class="mobile_field mobile_format digits_reg_email empty" name="register_national_id"
                       data-type="2" value="" aster="1" style="padding-left: 3px;">
            </div>
            <label>کد ملی<span class="optional"></span> *</label>
            <span class="bgdark"></span>
        </div>
    </div>
    <?php
});

function nationalIdIsExist(string $nationalId): bool
{
    global $wpdb;
    $query = "select * from {$wpdb->prefix}usermeta where meta_key='national_id' and meta_value='{$nationalId}';";
    $result = $wpdb->get_results(
        $wpdb->prepare($query)
        , ARRAY_A
    );
    return count($result) > 0;
}

function checkNationalCode($value): bool
{
    if (!preg_match('/^[0-9]{10}$/', $value)) {
        return false;
    }

    for ($i = 0; $i < 10; $i++)
        if (preg_match('/^' . $i . '{10}$/', $value)) {
            return false;
        }

    for ($i = 0, $sum = 0; $i < 9; $i++)
        $sum += ((10 - $i) * intval(substr($value, $i, 1)));
    $ret = $sum % 11;
    $parity = intval(substr($value, 9, 1));
    if (($ret < 2 && $ret == $parity) || ($ret >= 2 && $ret == 11 - $parity)) {
        return true;
    }

    return false;

}

remove_action("wp_ajax_nopriv_digits_check_mob", "digits_check_mob");
remove_action("wp_ajax_", "digits_check_mob");

add_action("wp_ajax_nopriv_digits_check_mob", "digitsCheckMob", 10);
add_action("wp_ajax_", "digitsCheckMob", 10);


if (!function_exists('digitsCheckMob')) {

    function digitsCheckMob(): void
    {

        if (session_id() == '') {
            session_start();
        }

        $data = array();

        $dig_login_details = digit_get_login_fields();
        $mobileaccp = $dig_login_details['dig_login_mobilenumber'];
        $otpaccp = $dig_login_details['dig_login_otp'];
        $countrycode = sanitize_text_field($_REQUEST['countrycode']);


        if (!empty($countrycode) &&
            (!is_numeric($countrycode) ||
                strpos($countrycode, '+') !== 0)) {
            wp_send_json_error(array('message' => __('Please enter a valid country code!', 'digits')));
            die();
        }

        $digit_gateway = dig_gatewayToUse($countrycode);
        if (dig_isWhatsAppEnabled()) {
            if (isset($_POST['whatsapp'])) {
                if ($_POST['whatsapp'] == 1) {
                    $digit_gateway = -1;
                }
            }
        }
        if ($digit_gateway == 1) {
            $data['accountkit'] = 1;
        } else {
            $data['accountkit'] = 0;
        }

        if ($digit_gateway == 13) {
            $data['firebase'] = 1;
        } else {
            $data['firebase'] = 0;
        }

        $mobileno = sanitize_mobile_field_dig($_REQUEST['mobileNo']);
        $csrf = $_REQUEST['csrf'];
        $login = $_REQUEST['login'];


        if (!wp_verify_nonce($csrf, 'dig_form')) {
            $data['code'] = 0;
            digit_send_json_status($data);
            die();
        }

        if (isset($_POST['register_national_id']) && !checkNationalCode($_POST['register_national_id'])) {
            wp_send_json_error(['message' => 'کد ملی شما معتبر نمی باشد.' /*__('Your national id is invalid!', 'elctro')*/]);
            die();
        }
        if (isset($_POST['register_national_id']) && nationalIdIsExist(str_replace(' ', '', $_POST['register_national_id']))) {
            wp_send_json_error(['message' => 'کد ملی درخواستی توسط شخص دیگری ثبت شده است.'/*__('Your national id taken.', 'elctro')*/]);
            die();
        }

        if (isset($_POST['captcha']) && isset($_POST['captcha_ses'])) {
            $ses = filter_var($_POST['captcha_ses'], FILTER_SANITIZE_NUMBER_FLOAT);
            if (isset($_SESSION['dig_captcha' . $ses])) {
                if ($_POST['captcha'] != $_SESSION['dig_captcha' . $ses]) {
                    wp_send_json_error(array('message' => __('Please enter a valid captcha!', 'digits')));
                    die();
                }
            }
        }

        $users_can_register = get_option('dig_enable_registration', 1);
        $digforgotpass = get_option('digforgotpass', 1);
        if ($users_can_register == 0 && $login == 2) {
            $data['code'] = 0;
            wp_send_json_error(array('message' => __('Registration is disabled!', 'digits')));
            die();
        }

        if ($digforgotpass == 0 && $login == 3) {
            $data['code'] = 0;
            wp_send_json_error(array('message' => __('Forgot Password is disabled!', 'digits')));
            die();
        }

        if ($login == 2 || $login == 11) {
            $result = false;
            if (isset($_POST['username']) && !empty($_POST['username'])) {
                $username = sanitize_text_field($_POST['username']);
                if (username_exists($username)) {
                    wp_send_json_error(array('message' => __('Username is already in use!', 'digits')));
                    die();
                }
                $result = true;
            }
            if (isset($_POST['email']) && !empty($_POST['email'])) {
                $email = sanitize_text_field($_POST['email']);

                $validation_error = new WP_Error();
                $validation_error = apply_filters('digits_validate_email', $validation_error, $email);

                if ($validation_error->get_error_code()) {
                    wp_send_json_error(array('message' => $validation_error->get_error_message()));
                    die();
                }


                if (email_exists($email)) {
                    if ($login == 11) {
                        $user = get_user_by('email', $email);
                        if ($user->ID != get_current_user_id()) {
                            wp_send_json_error(array('message' => __('Email is already in use!', 'digits')));
                            die();
                        }

                    } else {
                        wp_send_json_error(array('message' => __('Email is already in use!', 'digits')));
                        die();
                    }
                }
                $result = true;

            }

            if (empty($mobileno) && $result = true) {
                $data['code'] = 1;
                digit_send_json_status($data);
                die();
            }


        }


        if (($otpaccp == 0 && $login == 1) || ($mobileaccp == 0 && $login == 1)) {
            $data['code'] = -99;
            $data['message'] = __('Error', ' digits');
            digit_send_json_status($data);
            die();
        }

        if (!checkwhitelistcode($countrycode) || empty($countrycode)) {
            $data['code'] = -99;
            $data['message'] = __('At the moment, we do not allow users from your country', ' digits');
            digit_send_json_status($data);
            die();
        }

        $is_phone_allowed = dig_is_phone_no_allowed($countrycode . $mobileno);
        if (!$is_phone_allowed) {
            $data['code'] = -1;
            $data['message'] = __('Mobile Number not allowed!', ' digits');
            digit_send_json_status($data);
            die();
        }

        $user1 = getUserFromPhone($countrycode . $mobileno);
        if (($user1 != null && $login == 11) || ($user1 != null && $login == 2)) {

            $data['code'] = -1;
            $data['message'] = __('Mobile Number already in use!', ' digits');
            digit_send_json_status($data);
            die();
        }

        if ($user1 != null) {
            $validate_user = new WP_Error();

            if ($login == 1) {
                $validate_user = apply_filters('digits_check_user_login', $validate_user, $user1);
            } else if ($login == 3) {
                $validate_user = apply_filters('digits_check_user_forgotpass', $validate_user, $user1);
            }
            if (!empty($validate_user->get_error_code())) {
                $data['code'] = -1;
                $data['message'] = $validate_user->get_error_message();
                if ($validate_user->get_error_code() == 'notice') {
                    $data['notice'] = 1;
                }
                wp_send_json_error($data);
                die();
            }
        }


        if ($user1 != null || $login == 2 || $login == 11 || $login == 101) {

            if (!digits_validate_phone($countrycode . $mobileno)) {
                wp_send_json_error(array('message' => __('Please enter a valid mobile number', 'digits')));
            }

            if ($login == 101) {
                $allow = apply_filters('digits_allow_only_mobile_verfication', false, $login);
                if (is_wp_error($allow) || !$allow) {
                    $data['code'] = 0;
                    if (is_wp_error($allow)) {
                        $data['message'] = $allow->get_error_message();
                        if ($allow->get_error_code() == 'notice') {
                            $data['notice'] = 1;
                        }
                    } else {
                        $data['message'] = __('Error', ' digits');
                    }
                    wp_send_json_error($data);
                }
            }

            $check_request = digits_check_request($countrycode . $mobileno);

            if ($check_request instanceof WP_Error) {
                wp_send_json_error(array('message' => $check_request->get_error_message()));
            }

            if ($digit_gateway == 1 || $digit_gateway == 13) {
                $result = 1;
            } else {
                if (isset($_POST['register_national_id'])) {
                    $nationalId = $_POST['register_national_id'];
                } else {
                    $nationalId = get_user_meta($user1->ID, 'national_id');
                    if (count($nationalId) > 0) {
                        $nationalId = $nationalId[0];
                    } else {
                        $nationalId = 0;
                    }

                }
                $result = digitCreateOtp($countrycode, $mobileno, $nationalId);
            }
            $data['code'] = $result;
            digit_send_json_status($data);


            die();
        } else {
            digit_send_json_status(array(
                'code' => -11,
                'message' => __('Please signup before logging in.', 'digits')
            ));
            die();
        }

        digit_send_json_status(array('code' => 0));
        die();

    }
}

if (!function_exists('digitCreateOtp')) {
    function digitCreateOtp(string $countryCode, string $mobileNo, string $nationId): string
    {
        $digit_gateway = dig_gatewayToUse($countryCode);

        $mode = 'sms';
        if (dig_isWhatsAppEnabled()) {
            if (isset($_POST['whatsapp'])) {
                if ($_POST['whatsapp'] == 1) {
                    $digit_gateway = -1;
                    $mode = 'whatsapp';
                }
            }
        }
        digits_add_request_log($countryCode . $mobileNo, $mode);

        if ($digit_gateway != 13) {

            if (OTPexists($countryCode, $mobileNo)) {
                return "1";

            }

            $code = dig_get_otp();


            if (!digit_send_otp($digit_gateway, $countryCode, $mobileNo, $code)) {
                return "0";
            }


            $mobileVerificationCode = md5($code);

            global $wpdb;
            $table_name = $wpdb->prefix . "digits_mobile_otp";

            $db = $wpdb->replace($table_name, [
                'countrycode' => $countryCode,
                'mobileno' => $mobileNo,
                'otp' => $mobileVerificationCode,
                'time' => date("Y-m-d H:i:s", strtotime("now")),
                'national_id' => $nationId
            ], [
                    '%d',
                    '%s',
                    '%s',
                    '%s',
                    '%s'
                ]
            );

            if (!$db) {
                return "0";

            }

        }

        return "1";

    }
}

function addNationIdColumnOnDigitsOtpTable(): void
{
    global $wpdb;
    $columnName = 'national_id';
    $tableName = "{$wpdb->prefix}digits_mobile_otp";
    $column = $wpdb->get_results("show columns from $tableName like '$columnName'");
    if (empty($column)) {
        $wpdb->query("alter table $tableName add column $columnName varchar(50) not null");
    }
}

addNationIdColumnOnDigitsOtpTable();

remove_action("wp_ajax_nopriv_digits_verifyotp_login", "digits_verifyotp_login", 10);
remove_action("wp_ajax_digits_verifyotp_login", "digits_verifyotp_login", 10);

add_action("wp_ajax_nopriv_digits_verifyotp_login", "digitsVerifyOtpLogin", 10);

add_action("wp_ajax_digits_verifyotp_login", "digitsVerifyOtpLogin", 10);

if (!function_exists('digitsVerifyOtpLogin')) {
    function digitsVerifyOtpLogin(): void
    {


        $countrycode = sanitize_text_field($_REQUEST['countrycode']);

        if (dig_gatewayToUse($countrycode) == 1) {
            die();
        }


        if (!checkwhitelistcode($countrycode)) {
            echo "-99";
            die();
        }


        $mobileno = sanitize_mobile_field_dig($_REQUEST['mobileNo']);
        $csrf = $_REQUEST['csrf'];
        $otp = sanitize_text_field($_REQUEST['otp']);
        $del = false;


        $users_can_register = get_option('dig_enable_registration', 1);
        $digforgotpass = get_option('digforgotpass', 1);
        if (($users_can_register == 0 && $_REQUEST['dtype'] == 2) || ($digforgotpass == 0 && $_REQUEST['dtype'] == 3)
            || !wp_verify_nonce($csrf, 'dig_form')
        ) {
            wp_send_json(array(
                'success' => false,
                'data' => array('msg' => __('Error', 'digits'), 'level' => 2)
            ));
            die();
        }


        if ($_REQUEST['dtype'] == 1) {
            $del = true;
        }

        $rememberMe = false;
        if (isset($_REQUEST['rememberMe']) && $_REQUEST['rememberMe'] == 'true') {
            $rememberMe = true;
        }

        $nationalId = getNationalIdWhileRegisteringUser($countrycode, $mobileno, $otp);
        if (is_null($nationalId) && isset($_POST['register_national_id'])) {
            $nationalId = $_POST['register_national_id'];
        }
        if (verifyOTP($countrycode, $mobileno, $otp, $del)) {

            $user1 = getUserFromPhone($countrycode . $mobileno);
            if ($user1) {

                if ($_REQUEST['dtype'] == 1) {
                    wp_set_current_user($user1->ID, $user1->user_login);
                    wp_set_auth_cookie($user1->ID, $rememberMe);
                    do_action('wp_login', $user1->user_login, $user1);

                    $redirect_url = apply_filters('digits_login_redirect', '');
                    if (!is_null($nationalId)) {
                        update_user_meta($user1->ID, 'national_id', $nationalId);
                    }
                    if (!empty($redirect_url)) {
                        wp_send_json(array(
                            'success' => true,
                            'data' => array(
                                'code' => 1,
                                'msg' => __('Login Successful, Redirecting..', 'digits'),
                                'redirect' => $redirect_url
                            )
                        ));
                    }

                    wp_send_json(array(
                        'success' => true,
                        'data' => array(
                            'code' => 11
                        )
                    ));

                    die();

                } else {
                    if (!is_null($nationalId)) {
                        update_user_meta($user1->ID, 'national_id', $nationalId);
                    }
                    wp_send_json(array(
                        'success' => true,
                        'data' => array(
                            'code' => 1
                        )
                    ));

                    die();
                }

            } else {
                wp_send_json(array(
                    'success' => true,
                    'data' => array(
                        'code' => -1
                    )
                ));

                die();
            }


        } else {
            wp_send_json(array(
                'success' => false,
                'data' => array(
                    'code' => 0
                )
            ));

            die();
        }

    }
}

function getNationalIdWhileRegisteringUser($countryCode, $phone): ?string
{
    global $wpdb;

    $tableName = $wpdb->prefix . "digits_mobile_otp";
    $userRow = $wpdb->get_results(
        $wpdb->prepare(
            'SELECT * FROM ' . $tableName . '
        WHERE countrycode = %s AND mobileno= %s ORDER BY time DESC LIMIT 1',
            $countryCode, $phone
        ),
        ARRAY_A
    );
    if (!empty($userRow)) {
        return $userRow[0]['national_id'];
    } else {
        return null;
    }
}

remove_action('wp_ajax_nopriv_digits_submit_form', 'digits_process_form');
add_action('wp_ajax_nopriv_digits_submit_form', 'digitsProcessForm');

function digitsProcessForm()
{
    _digitsProcessForm(true);
}

function _digitsProcessForm($additionalFields = true)
{
    $data = array();
    if (isset($_POST['dig_reg_mail']) ||
        isset($_POST['digits_reg_mail']) || isset($_POST['digits_reg_username'])) {
        $data = digitsProcessRegister();
        if ($data['success'] == true) {
            unset($data['data']['user_id']);
        }
    } else if (isset($_POST['mobmail'])) {
        $data = digits_process_login($additionalFields);
    } else if (isset($_POST['forgotmail'])) {
        $data = digits_process_forgotpassword();
    }
    if (dig_is_doing_ajax()) {
        wp_send_json($data);
        die();
    } else {
        return $data;
    }
}

function digitsProcessRegister()
{
    return digitsCreateUser();
}

function digitsCreateUser()
{
    $users_can_register = get_option('dig_enable_registration', 1);

    $validation_error = new WP_Error();
    if (isset($_POST['dig_nounce']) && $users_can_register == 1) {

        $nounce = $_POST['dig_nounce'];
        if (!wp_verify_nonce($nounce, 'dig_form')) {
            return array('success' => false, 'data' => array('msg' => __('Error', 'digits'), 'level' => 2));
        }

        $page = 2;


        $dig_reg_details = apply_filters('digits_registration_default_fields', digit_get_reg_fields());
        $user_id = null;

        $nameaccep = $dig_reg_details['dig_reg_name'];
        $usernameaccep = $dig_reg_details['dig_reg_uname'];
        $emailaccep = $dig_reg_details['dig_reg_email'];
        $passaccep = $dig_reg_details['dig_reg_password'];
        $mobileaccp = $dig_reg_details['dig_reg_mobilenumber'];

        if ($emailaccep == 1 && $mobileaccp == 1) {
            $emailmob = __("Email/Mobile Number", "digits");
        } else if ($mobileaccp > 0) {
            $emailmob = __("Mobile Number", "digits");
        } else if ($emailaccep > 0) {
            $emailmob = __("Email", "digits");
        } else if ($usernameaccep == 0) {
            $usernameaccep = 1;
            $emailmob = __("Username", "digits");
        }


        $m = '';
        $name = '';
        $mail = '';
        $password = '';
        $username = '';

        if ($nameaccep > 0) {
            if (!empty($_POST['digits_reg_firstname'])) {
                $name = sanitize_text_field($_POST['digits_reg_firstname']);
            } else {
                $name = sanitize_text_field($_POST['digits_reg_name']);
            }
        }
        if ($emailaccep > 0) {
            $mail = sanitize_email($_POST['dig_reg_mail']);
        }
        if ($passaccep > 0) {
            $password = sanitize_text_field($_POST['digits_reg_password']);
        }
        if ($usernameaccep > 0) {
            $username = sanitize_text_field($_POST['digits_reg_username']);
        }


        $code = sanitize_text_field(dig_get_var('code'));
        $csrf = sanitize_text_field(dig_get_var('csrf'));
        $otp = sanitize_text_field(dig_get_var('dig_otp'));

        if ($mobileaccp > 0) {
            $m = sanitize_text_field($_POST['digits_reg_mail']);
        }


        if (empty($name) && $nameaccep == 2) {
            $validation_error->add("invalidname", __("Invalid Name!", "digits"));
        }

        if (empty($username) && $usernameaccep == 2) {
            $validation_error->add("invalidusername", __("Invalid Username!", "digits"));
        }


        if ($passaccep == 0) {
            $password = wp_generate_password();
        } else if ($passaccep == 2 && empty($password)) {
            $validation_error->add("invalidpassword", __("Invalid Password!", "digits"));
        } else {
            if (empty($code) && empty($otp) && empty(dig_get_var('ftoken')) && empty($password) && $passaccep > 0) {
                $validation_error->add("invalidpassword", __("Invalid Password!", "digits"));
            } else {
                if (empty($password)) {
                    $password = wp_generate_password();
                }
            }
        }

        if ($mobileaccp == 1 && !is_numeric($m) && stripslashes($m) == $mail) {
            $m = '';
        }


        if ($mobileaccp == 2) {
            $m = sanitize_mobile_field_dig($m);

            if (empty($m) || !is_numeric($m)) {
                $validation_error->add("Mobile", __("Please enter a valid Mobile Number!", "digits"));
            }
            if (empty($code) && empty($otp) && empty(dig_get_var('ftoken'))) {
                $validation_error->add("Mobile", __("Please enter a valid OTP!", "digits"));
            }

        } else if ($mobileaccp == 1 && !empty($m)) {
            $m = sanitize_mobile_field_dig($m);
            if (!is_numeric($m) || (empty($code) && empty($otp) && empty(dig_get_var('ftoken')))) {
                $validation_error->add("Mobile", __("Please enter a valid Mobile Number!", "digits"));
            }
            if (empty($code) && empty($otp) && empty(dig_get_var('ftoken'))) {
                $validation_error->add("Mobile", __("Please enter a valid OTP!", "digits"));
            }

        }

        if ($emailaccep == 2) {
            if (empty($mail) || !isValidEmail($mail)) {
                $validation_error->add("Mail", __("Please enter a valid Email!", "digits"));
            }
        } else if ($emailaccep == 1 && !empty($mail)) {
            if (!isValidEmail($mail)) {
                $validation_error->add("Mail", __("Please enter a valid Email!", "digits"));
            }
        }


        if ($mobileaccp == 1 && $emailaccep == 1) {
            if (!is_numeric($m) && $emailaccep == 0) {
                $validation_error->add("Mobile", __("Please enter a valid Mobile Number!", "digits"));
            }

            if (empty($code) && empty($otp) && empty(dig_get_var('ftoken')) && empty($mail)) {
                $validation_error->add("invalidmailormob", __("Invalid Email or Mobile Number", "digits"));
            }

            if (!empty($mail) && !isValidEmail($mail)) {
                $validation_error->add("Mail", __("Invalid Email!", "digits"));
            }
            if (!empty($mail) && email_exists($mail)) {
                $validation_error->add("MailinUse", __("Email already in use!", "digits"));
            }

        }

        if (!empty($mail) && email_exists($mail)) {
            $validation_error->add("MailinUse", __("Email already in use!", "digits"));
        }

        $validation_error = apply_filters('digits_validate_email', $validation_error, $mail);


        $useMobAsUname = get_option('dig_mobilein_uname', 0);

        if ($useMobAsUname == 3 && empty($username)) {
            $username = $mail;
        }

        if (empty($username)) {

            $m2 = sanitize_mobile_field_dig(dig_get_var('mobmail2'));

            if (is_numeric($m)) {
                $countrycode = $_POST['digregcode'];
            } else if (is_numeric($m2)) {
                $countrycode = $_POST['digregscode2'];
            }


            $auto = 0;
            if (in_array($useMobAsUname, array(1, 4, 5, 6)) && !empty($m)) {


                $tname = $m;


                if ($useMobAsUname == 1 || $useMobAsUname == 4) {
                    $tname = '';
                    if (!empty($countrycode)) {
                        $tname = $countrycode;
                    }

                    $tname = $tname . $m;

                    if ($useMobAsUname == 1) {
                        $tname = str_replace("+", "", $tname);
                    }
                } else if ($useMobAsUname == 5) {
                    $tname = $m;
                } else if ($useMobAsUname == 6) {
                    $tname = '0' . $m;
                }

            } else if ((!empty($name) || !empty($mail)) && $useMobAsUname == 0) {
                $auto = 1;

                if (!empty($name)) {
                    $tname = digits_filter_username($name);
                } else if (!empty($mail)) {
                    $tname = strstr($mail, '@', true);
                }
            } else {

                $tname = apply_filters('digits_username', '');
            }


            if (empty($tname) || $auto == 1) {
                if (empty($tname)) {
                    if (!empty($mail)) {
                        $tname = strstr($mail, '@', true);
                    } else if (!empty($m)) {
                        $tname = $m;
                    }
                }

                if (empty($tname)) {
                    $validation_error->add("username", __("Error while generating username!", "digits"));
                } else {


                    $check = username_exists($tname);
                    if ($tname == $m && $check) {
                        $validation_error->add("MobinUse", __("Mobile number already in use!", "digits"));
                    }

                    if (!empty($check)) {
                        $suffix = 2;
                        while (!empty($check)) {
                            $alt_ulogin = $tname . $suffix;
                            $check = username_exists($alt_ulogin);
                            $suffix++;
                        }
                        $ulogin = $alt_ulogin;
                    } else {
                        $ulogin = $tname;
                    }

                }


            } else {


                $check = username_exists($tname);

                if (!empty($check)) {
                    $suffix = 2;
                    while (!empty($check)) {
                        $alt_ulogin = $tname . $suffix;
                        $check = username_exists($alt_ulogin);
                        $suffix++;
                    }
                    $ulogin = $alt_ulogin;
                } else {
                    $ulogin = $tname;
                }
            }


        } else {
            if (username_exists($username)) {
                $validation_error->add("UsernameinUse", __("Username is already in use!", "digits"));
            } else {
                $ulogin = $username;
            }
        }


        $reg_custom_fields = stripslashes(base64_decode(get_option("dig_reg_custom_field_data", "e30=")));
        $reg_custom_fields = json_decode($reg_custom_fields, true);
        $reg_custom_fields = apply_filters('digits_registration_fields', $reg_custom_fields);
        $validation_error = validate_digp_reg_fields($reg_custom_fields, $validation_error);

        if ((!empty($code) || !empty($otp) || !empty(dig_get_var('ftoken'))) && $mobileaccp > 0) {


            $m = sanitize_text_field(dig_get_var('digits_reg_mail'));
            $m2 = sanitize_text_field(dig_get_var('mobmail2'));

            if (is_numeric(sanitize_mobile_field_dig($m))) {
                $countrycode = sanitize_text_field($_POST['digregcode']);
            } else if (is_numeric(sanitize_mobile_field_dig($m2))) {
                $countrycode = sanitize_text_field($_POST['digregscode2']);
            }

            if (dig_gatewayToUse($countrycode) == 1) {

                if (!wp_verify_nonce($csrf, 'crsf-otp')) {
                    $validation_error->add("Error", __("Error", "digits"));
                }
                $json = getUserPhoneFromAccountkit($code);

                $phoneJson = json_decode($json, true);

                $mob = $phoneJson['phone'];
                $phone = $phoneJson['nationalNumber'];
                $countrycode = $phoneJson['countrycode'];

                if ($json == null) {
                    $validation_error->add("apifail", __("Invalid API credentials!", "digits"));

                }

            } else {
                $m = sanitize_text_field(dig_get_var('digits_reg_mail'));
                $m2 = sanitize_text_field(dig_get_var('mobmail2'));
                if (is_numeric(sanitize_mobile_field_dig($m))) {
                    $m = sanitize_mobile_field_dig($m);
                    $countrycode = sanitize_text_field($_POST['digregcode']);
                    if (verifyOTP($countrycode, $m, $otp, true)) {
                        $mob = $countrycode . $m;
                        $phone = $m;
                    }
                } else if (is_numeric(sanitize_mobile_field_dig($m2))) {
                    $countrycode = sanitize_text_field($_POST['digregscode2']);
                    $m2 = sanitize_mobile_field_dig($m2);
                    if (verifyOTP($countrycode, $m2, $otp, true)) {
                        $mob = $countrycode . $m2;
                        $phone = $m2;
                    }
                }

            }


            if (empty($ulogin)) {
                $mobu = str_replace("+", "", $mob);
                $check = username_exists($mobu);
                if (!empty($check)) {
                    $validation_error->add("MobinUse", __("Mobile number already in use!", "digits"));
                } else {
                    $ulogin = $mobu;
                }
            }


            $mobuser = getUserFromPhone($mob);
            if ($mobuser != null) {
                $validation_error->add("MobinUse", __("Mobile Number already in use!", "digits"));
            } else if (username_exists($mob)) {
                $validation_error->add("MobinUse", __("Mobile Number already in use!", "digits"));
            } else if ($mob == null) {
                $validation_error->add("MobinUse", __("Invalid Mobile Number", "digits"));
            }

            if (empty($ulogin)) {
                $validation_error->add("username", __("Error while generating username!", "digits"));
            }


            $validation_error = apply_filters('digits_registration_errors', $validation_error, $ulogin, $mail);

            if (!$validation_error->get_error_code()) {
                $ulogin = sanitize_user($ulogin, true);
                $user_id = wp_create_user($ulogin, $password, $mail);
                $userd = get_user_by('ID', $user_id);


                if (!is_wp_error($user_id)) {
                    if (checkNationalCode($_POST['register_national_id'])) {
                        update_user_meta($user_id, 'national_id', $_POST['register_national_id']);
                    }

                    update_user_meta($user_id, 'digits_phone', $mob);
                    update_user_meta($user_id, 'digt_countrycode', $countrycode);
                    update_user_meta($user_id, 'digits_phone_no', $phone);

                } else {

                    $validation_error->add("Error", implode(", ", $user_id->get_error_messages()));

                }


                $page = 2;
            }
        } else if ($emailaccep > 0) {

            if (empty($ulogin)) {
                $ulogin = strstr($mail, '@', true);
                if (username_exists($ulogin)) {
                    $validation_error->add("MailinUse", __("Email is already in use!", "digits"));
                }

            }
            $validation_error = apply_filters('digits_registration_errors', $validation_error, $ulogin, $mail);

            if (!$validation_error->get_error_code()) {
                $ulogin = sanitize_user($ulogin, true);
                $user_id = wp_create_user($ulogin, $password, $mail);
                $userd = get_user_by('ID', $user_id);


                $page = 2;
            }


        } else {
            if (empty($ulogin)) {
                $validation_error->add("username", __("Invalid Username!", "digits"));
            }
            $validation_error = apply_filters('digits_registration_errors', $validation_error, $ulogin, '');

            if (!$validation_error->get_error_code()) {
                $ulogin = sanitize_user($ulogin, true);
                $user_id = wp_create_user($ulogin, $password);
                $userd = get_user_by('ID', $user_id);

            }

        }
        $page = 2;

        if (!is_wp_error($user_id) && !$validation_error->get_error_code()) {

            $defaultuserrole = get_option('defaultuserrole', "customer");


            $user_role = apply_filters('digits_register_user_role', $defaultuserrole);

            wp_update_user(array(
                'ID' => $user_id,
                'role' => $user_role,
                'first_name' => $name,
                'display_name' => $name
            ));


            update_digp_reg_fields($reg_custom_fields, $user_id);

            if (class_exists('WooCommerce')) {
                // code that requires WooCommerce

                $userdata = array(
                    'user_login' => $ulogin,
                    'user_pass' => $password,
                    'user_email' => $mail,
                    'role' => $user_role,
                );
                do_action('woocommerce_created_customer', $user_id, $userdata, $password);
            } else {
                do_action('register_new_user', $user_id);
            }

            do_action('digits_user_created', $user_id);
            wp_set_current_user($userd->ID, $userd->user_login);

            wp_set_auth_cookie($userd->ID);

            if (dig_is_doing_ajax()) {
                $current_url = '-1';
            } else {
                $current_url = "//" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                $current_url = dig_removeStringParameter($current_url, "login");
                $current_url = dig_removeStringParameter($current_url, "page");
            }
            $t = get_option("digits_regred");
            if (!empty($t)) {
                $current_url = $t;
            }

            $redirect_url = $current_url;

            $custom_redirect = dig_lgr_custom();
            if (!empty($custom_redirect)) {
                $redirect_url = $custom_redirect;
            }
            if (dig_output_json_response()) {
                $redirect_url = apply_filters('digits_register_redirect', $redirect_url);
                $data = array(
                    'success' => true,
                    'data' => array(
                        'user_id' => $userd->ID,
                        'code' => '1',
                        'msg' => __('Registration Successful, Redirecting..', 'digits'),
                        'redirect' => $redirect_url
                    )
                );
                return apply_filters('digits_user_created_response', $data, $user_id);

            } else {
                wp_safe_redirect($redirect_url);
            }
            exit();
        } else {

            if (is_wp_error($user_id) && !$validation_error->get_error_code()) {
                $validation_error = $user_id;
            }

            if (dig_output_json_response()) {
                if (is_wp_error($validation_error)) {
                    $msg = implode('<br />', $validation_error->get_error_messages());
                } else {
                    $msg = __('Error', 'digits');
                }

                return array(
                    'success' => false,
                    'data' => array('code' => '0', 'msg' => $msg, 'level' => 2)
                );
            }

        }


    }

}

add_action('woocommerce_add_to_cart_validation', 'addToCartValidation');
function addToCartValidation($passed)
{
    $error_notice = [];

    if (is_user_logged_in()) {
        if (empty(getNationalId(get_current_user_id()))) {
            $passed = false;
            $error_notice[] = 'کد ملی شما ثبت نشده است. کد ملی خود را ثبت نمایید.';
        }

        if (!empty($error_notice)) {
            wc_add_notice(implode('<br>', $error_notice), 'error');
        }
    }

    return $passed;
}

add_action('user_new_form', 'nationalIdInAdminPage');
add_action('profile_personal_options', 'nationalIdInAdminPage');
add_action('personal_options', 'nationalIdInAdminPage');
function nationalIdInAdminPage($user): void
{
    ?>
    <table class="form-table" role="presentation">
        <tr>
            <th>
                <label for="admin_nation_id">کد ملی</label>
            </th>
            <td>
                <input type="text" name="admin_nation_id" id="admin_nation_id" value="<?= getNationalId($user->ID) ?>"
                       class="regular-text">
                <p class="description"></p>
            </td>
        </tr>
    </table>
    <?php
}

add_action('personal_options_update', 'storeNationalId');
add_action('edit_user_profile_update', 'storeNationalId');

function storeNationalId($userId): bool
{
    if (isset($_POST['admin_nation_id']) && current_user_can('edit_user', $userId) && checkNationalCode($_POST['admin_nation_id'])) {
        update_user_meta($userId, 'national_id', $_POST['admin_nation_id']);
    }
    return true;
}

function getNationalId($userId): string
{
    $nationalIdArray = get_user_meta($userId, 'national_id');
    $nationalId = '';

    if (is_array($nationalIdArray) && count($nationalIdArray) === 1) {
        $nationalId = $nationalIdArray[0];
    }
    return $nationalId;
}

add_action('woocommerce_save_account_details', 'storeNationalIdInMyAccountPage');
function storeNationalIdInMyAccountPage($customerId): void
{
    $nationalId = getNationalId($customerId);
    if (isset($_POST['user_account_national_id']) && empty($nationalId)) {
        update_user_meta($customerId, 'national_id', $_POST['user_account_national_id']);
    }

}

add_filter('woocommerce_save_account_details_required_fields', 'misha_make_field_required');
function misha_make_field_required($required_fields)
{
    $required_fields['user_account_national_id'] = 'کد ملی';
    return $required_fields;
}


add_action('woocommerce_save_account_details_errors', 'validateNationalIdInMyAccountPage', 999);
add_action('woocommerce_after_save_address_validation', 'validateNationalIdInMyAccountPage');
function validateNationalIdInMyAccountPage(): void
{

    if (isset($_POST['user_account_national_id'])) {

        if (empty($_POST['user_account_national_id'])) {
            wc_add_notice('کد ملی اجباری می باشد.', 'error');
        }
        if (nationalIdIsExist($_POST['user_account_national_id'])) {
            wc_add_notice('کد ملی شما توسط حساب دیگری وارد شده است.', 'error');
        }
        if (!checkNationalCode($_POST['user_account_national_id'])) {

            wc_add_notice('کد ملی اشتباه وارد شده است.', 'error');
        }
    }

}

add_filter('woocommerce_checkout_fields', 'wc_remove_checkout_fields');
/**
 * Remove all possible fields
 **/
function wc_remove_checkout_fields($fields)
{


    $fields['billing']['billing_city']['priority'] = 85;
    $fields['shipping']['shipping_city']['priority'] = 85;
    $fields['account']['account_national_id'] = [
        'required' => true,
        'id' => 'checkout_register_national_id',
        'priority' => 20,
        'placeholder' => 'کد ملی خود را وارد نمایید.',
        'label' => 'کد ملی',
        'class' => ['test']
    ];
    return $fields;
}

remove_action("wp_ajax_nopriv_digits_resendotp", "digits_resendotp");

remove_action("wp_ajax_digits_resendotp", "digits_resendotp");

add_action("wp_ajax_nopriv_digits_resendotp", "digitsResendOTP");

add_action("wp_ajax_digits_resendotp", "digitsResendOTP");

function digitsResendOTP()
{

    $countrycode = sanitize_text_field($_REQUEST['countrycode']);
    $mobileno = sanitize_mobile_field_dig($_REQUEST['mobileNo']);
    $csrf = $_REQUEST['csrf'];
    $login = $_REQUEST['login'];

    if (dig_gatewayToUse($countrycode) == 1) {
        die();
    }
    if (!checkwhitelistcode($countrycode)) {
        echo "-99";
        die();
    }

    if (!wp_verify_nonce($csrf, 'dig_form')) {
        echo '0';
        die();
    }

    $users_can_register = get_option('dig_enable_registration', 1);
    $digforgotpass = get_option('digforgotpass', 1);
    if ($users_can_register == 0 && $login == 2) {
        echo "0";
        die();
    }
    if ($digforgotpass == 1 && $login == 3) {
        echo "0";
        die();
    }

    if (OTPexists($countrycode, $mobileno, true)) {
        digitsCheckMob();
    }
    echo "0";
    die();

}

add_action('woocommerce_checkout_process', function () {
    $countryCode = $phoneNumber = null;
    if (isset($_POST['digt_countrycode'])) {
        $countryCode = (int)$_POST['digt_countrycode'];
    }

    if (isset($_POST['billing_phone'])) {
        $phoneNumber = sanitize_mobile_field_dig($_POST['billing_phone']);
    }
    $nationalId = getNationalIdWhileRegisteringUser($countryCode, $phoneNumber);

    update_option("digits_new_user_{$phoneNumber}", $nationalId);
});


add_action('woocommerce_checkout_update_user_meta', function ($customerId) {

    $phoneConfig = get_user_meta($customerId, 'digits_phone_no');
    if (count($phoneConfig) > 0) {
        $nationalConfig = get_option("digits_new_user_{$phoneConfig[0]}");
        if (strlen($nationalConfig) === 10) {
            add_user_meta($customerId, 'national_id', $nationalConfig);
            delete_option("digits_new_user_{$phoneConfig[0]}");
        }
    }
});

if (!function_exists('woocommerce_mini_cart')) {
    function woocommerce_mini_cart($args = array())
    {

        $defaults = [
            'list_class' => '',
        ];

        $args = wp_parse_args($args, $defaults);

        get_template_part('templates/cart/mini', 'cart', $args);
    }
}

add_action('add_meta_boxes', 'addShippingTrackingCodeMetaBox');
function addShippingTrackingCodeMetaBox(): void
{


    add_meta_box('shipping_tracking_code', 'کد پیگیری پست',

        'shippingTrackingCodeInput'
        , [
            'shop_order',
            wc_get_page_screen_id('shop-order'),
        ], 'side', 'high');


}

function shippingTrackingCodeInput($post): void
{
    $value = get_post_meta($post->ID, 'shipping_tracking_code', true);
    ?>
    <label for="tracking_code">کد رهگیری</label>
    <input type="text" name="tracking_code" id="tracking_code" class="postbox" value="<?= $value ?? '' ?>">

    <?php
}

function saveShippingTrackingCode($post_id): void
{
    if (array_key_exists('tracking_code', $_POST)) {
        update_post_meta(
            $post_id,
            'shipping_tracking_code',
            $_POST['tracking_code']
        );
    }
}

add_action('save_post', 'saveShippingTrackingCode');


add_filter('pwoosms_shortcodes_list', function () {
    return "<strong>مقادیر سفارشی : </strong><br>"
        . "<code>{tracking_code}</code> = شماره پیگیری مرسوله پست   ،";
});

add_filter('pwoosms_order_sms_body_after_replace', function ($content, $orderId, $order, $allProductIds, $vendorProductIds) {
    if (strpos($content, '{tracking_code}')) {
        $content = str_replace('{tracking_code}', get_post_meta($orderId, 'shipping_tracking_code', true), $content);
        return $content;
    } else {
        return $content;
    }
}, 10, 5);