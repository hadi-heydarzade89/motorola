<?php
defined('ABSPATH') || exit;

require_once __DIR__ . '/vendor/autoload.php';

use ElectroApp\Hooks\ThemeInitHook;
use Morilog\Jalali\Jalalian;

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    add_filter('posts_clauses', 'orderByStockStatus', 10);
}
function orderByStockStatus($posts_clauses)
{
    global $wpdb;

    if (is_woocommerce() && (is_shop() || is_product_category() || is_product_tag())) {
        $posts_clauses['join'] .= " INNER JOIN $wpdb->postmeta istockstatus ON ($wpdb->posts.ID = istockstatus.post_id) ";
        $posts_clauses['orderby'] = " istockstatus.meta_value ASC, " . $posts_clauses['orderby'];
        $posts_clauses['where'] = " AND istockstatus.meta_key = '_stock_status' AND istockstatus.meta_value <> '' " . $posts_clauses['where'];
    }

    return $posts_clauses;
}

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

function nationalIdIsExist(string $nationalId): bool
{
    global $wpdb;
    $query = "select * from {$wpdb->prefix}usermeta where meta_key='national_id' and meta_value='{$nationalId}';";
    $result = $wpdb->get_results(
        $wpdb->prepare($query)
        , ARRAY_A
    );
    return false/*count($result) > 0*/ ;
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


//add_action('woocommerce_add_to_cart_validation', 'addToCartValidation');
function addToCartValidation($passed)
{
    $error_notice = [];

    if (is_user_logged_in()) {
        if (empty(getNationalId(get_current_user_id()))) {
            $passed = false;
            $pageLink = get_permalink(get_option('woocommerce_myaccount_page_id'));
            $error_notice[] = 'کد ملی شما ثبت نشده است. کد ملی خود را ثبت نمایید.' . " <a class='electro-error-link' href='{$pageLink}/edit-account/'>برای افزودن کد ملی کلیک نمایید.</a>";
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
    if (isset($_POST['admin_nation_id']) && current_user_can('edit_user', $userId)) {
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
        if ((isset($_POST['account_first_name']) && !isPersianWord($_POST['account_first_name'])) || (isset($_POST['account_last_name']) && !isPersianWord($_POST['account_last_name']))) {
            wc_add_notice('نام و نام خانوادگی را با حروف فارسی وارد نمایید.', 'error');
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

add_action('woocommerce_checkout_create_order', function () {
    global $wp_object_cache;
    try {
        $wp_object_cache->redis_instance()->del('wp:orders:order-count-shop_order');
    } catch (Throwable $e) {

    }
}, 20, 2);

add_action('template_redirect', 'woocommerceCustomRedirections');
/**
 * @return void
 */
function woocommerceCustomRedirections(): void
{
    if (!is_user_logged_in() && is_checkout()) {
        wp_redirect(get_permalink(get_option('woocommerce_myaccount_page_id')));
    }
}

function wcElectroChildPrintColumn($columns)
{
    $columns['electro_print_column'] = 'فاکتور';
    return $columns;
}

add_filter('manage_edit-shop_order_columns', 'wcElectroChildPrintColumn');


function addElectroPrintColumnContent($column)
{
    global $post;
    if ('electro_print_column' === $column && is_admin()) {
        ?>
        <a href="<?= get_admin_url() . 'admin.php?electro_woo_invoice_type=thermal&electro_woo_invoice=' . $post->ID ?>"
           target="_blank"
           title="پرینت حرارتی">
            <div class="wooi"
                 style="background: #ff64b1; display: inline-block; margin-top: 5px; padding: 6px 10px;color: white;border-radius: 5px;">
                <span class="dashicons dashicons-text-page" style="line-height: 25px;"></span></div>
        </a>
        <!--        <a href="--><?php //= get_admin_url() . 'admin.php?electro_woo_invoice_type=invoice&electro_woo_invoice=' . $post->ID ?><!--"-->
        <!--           target="_blank" title="فاکتور">-->
        <!--            <div class="wooi"-->
        <!--                 style="background: #98b4c7; display: inline-block; margin-top: 5px; padding: 6px 10px;color: white;border-radius: 5px;">-->
        <!--                <span class="dashicons dashicons-media-spreadsheet" style="line-height: 25px;"></span></div>-->
        <!--        </a>-->
        <?php
    }
}

add_action('manage_shop_order_posts_custom_column', 'addElectroPrintColumnContent');

add_action('admin_init', 'loadOrderInvoiceData');

function loadOrderInvoiceData(): void
{
    if ($_GET['electro_woo_invoice'] && is_admin()) {
        $order = wc_get_order($_GET['electro_woo_invoice']);
        if ($order === false) {
            wp_redirect(admin_url());
            exit();
        }
        $customerId = $order->get_customer_id();
        $billingPhone = $order->get_billing_phone();

        $shippingAddress = $order->get_shipping_address_1();
        $shippingPostcode = $order->get_shipping_postcode();

        $currencySymbol = get_woocommerce_currency_symbol($order->get_currency());
        $createdDatetime = Jalalian::forge((new DateTime(date('Y-m-d H:i:s')))->getTimestamp())->format('Y/m/d');
        if ($_GET['electro_woo_invoice_type'] === 'thermal') {
            include plugin_dir_path(__FILE__) . 'templates/invoice/a5.php';
        } elseif ($_GET['electro_woo_invoice_type'] === 'invoice') {
//            include plugin_dir_path(__FILE__) . 'templates/invoice/ticket.php';
        }
    }
}

function validateNationalCodeAfterCheckoutValidation($posted): void
{

    if (!checkNationalCode($posted['billing_national_code'])) {
        wc_add_notice("کد ملی وارد شده معتبر نمیباشد لطفا از صحت کد ملی وارد شده اطمینان حاصل نمایید.", 'error');
    } else {
        if (is_user_logged_in()) {
            update_user_meta(get_current_user_id(), 'nationalcode', $posted['billing_national_code']);
        }
    }
    if (!isPersianWord($posted['billing_first_name']) || !isPersianWord($posted['billing_last_name'])) {
        wc_add_notice('لطفا از حروف فارسی برای نام و نام خانوادگی استفاده نمایید.', 'error');
    }

}

add_action('woocommerce_after_checkout_validation', 'validateNationalCodeAfterCheckoutValidation');

add_filter('woocommerce_billing_fields', 'addNationalCodeFieldOnCheckoutPage');
function addNationalCodeFieldOnCheckoutPage($fields)
{
    $fields['billing_national_code'] = [
        'label' => 'کد ملی',
        'required' => true,
        'autocomplete' => 'nationalcode',
        'priority' => 9,
        'class' => ['form-row-wide']
    ];
    $fields['billing_last_name']['class'] = $fields['billing_first_name']['class'] = ['form-row-wide'];
    return $fields;
}


remove_action('woocommerce_account_content', 'woocommerce_output_all_notices', 5);
add_action('woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10);
add_action('woocommerce_account_content', 'customWooError', 5);

function customWooError(): void
{
    echo '<div id="woo-custom-error" class="woocommerce-notices-wrapper">';
    wc_print_notices();
    echo '</div>';
}

function isPersianWord($word): bool
{
    // Persian Unicode range
    $pattern = '/[^\u0600-\u06FF\s]/u';
    return preg_match($pattern, $word);
}