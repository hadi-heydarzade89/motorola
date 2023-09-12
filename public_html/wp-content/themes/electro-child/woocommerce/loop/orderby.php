<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */

if (!defined('ABSPATH')) {
    exit;
}
$detect = new \Detection\MobileDetect;

if (!$detect->isMobile()) {
    ?>

    <form method="get">
        <div class="electro-orderby">
            <label><i class="fas fa-sort-amount-down-alt"></i><?= __('Order By', 'electro') ?></label>
            <?php
            foreach ($catalog_orderby_options as $id => $name) {

                if (isset($_GET['orderby']) && in_array($_GET['orderby'], ['date', 'menu_order', 'popularity', 'rating', 'price', 'price-desc'])) {
                    $checked = $_GET['orderby'];
                } else {
                    $checked = 'date';
                }
                ?>

                <div class="checkbox <?= $checked === $id ? 'checked' : '' ?>">

                    <label for="<?php echo esc_attr($id); ?>">
                        <input id="<?php echo esc_attr($id); ?>" onChange="this.form.submit()"
                               value="<?php echo esc_attr($id); ?>" type="radio"
                               name="orderby"><?php echo esc_html($name); ?>
                    </label>
                </div>
            <?php } ?>
        </div>
        <input type="hidden" name="paged" value="1"/>
        <?php wc_query_string_form_fields(null, array('orderby', 'submit', 'paged', 'product-page')); ?>
    </form>
    <?php
} else {
    ?>
    <form class="woocommerce-ordering" method="get">
        <select name="orderby" class="orderby" aria-label="<?php esc_attr_e('Shop order', 'woocommerce'); ?>">
            <?php foreach ($catalog_orderby_options as $id => $name) : ?>
                <option value="<?php echo esc_attr($id); ?>" <?php selected($orderby, $id); ?>><?php echo esc_html($name); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="hidden" name="paged" value="1"/>
        <?php wc_query_string_form_fields(null, array('orderby', 'submit', 'paged', 'product-page')); ?>
    </form>
    <?php
}