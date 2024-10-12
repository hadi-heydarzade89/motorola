<?php
defined('ABSPATH') || exit;
if (!is_admin()) {
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="MahdiY">
    <title>فاکتور<?= $order->ID ?></title>
    <link href="<?= get_theme_file_uri('/assets/css/admin/admin-styles.css') ?>" rel="stylesheet">
</head>
<body>
<div class="content factor">
    <div class="header">
        <div class="logo"><?= get_custom_logo() ?></div>
        <div class="text"><?= $order->is_paid() ? 'فاکتور' : 'پیش فاکتور' ?></div>
        <div class="info">
            <p>شماره فاکتور: <?= $order->ID ?></p>
            <p>تاریخ: <?= $createdDatetime ?></p>
        </div>
    </div>
    <table>
        <tr>
            <th width="50%">فروشنده</th>
            <th width="50%">خریدار</th>
        </tr>
        <tr>
            <td>
                <p>
                    <b>فروشنده: </b>
                    {{ options.info.store_name }}
                      
                    <b>استان: </b>
                    {{ options.info.store_state }}
                    <b>شهر: </b>
                    {{ options.info.store_city }}
                    <b>کد پستی: </b>
                    {{ options.info.store_postcode | fa }}
                    <b>تلفن: </b>
                    {{ options.info.store_phone | fa }}
                    <b {{ options.info.store_economic_code | show_hide }}>کد اقتصادی: </b>
                    {{ options.info.store_economic_code }}
                    <b {{ options.info.store_registration_number | show_hide }}>شماره ثبت: </b>
                    {{ options.info.store_registration_number }}
                </p>
                <p>
                    <b>نشانی: </b>
                    {{ options.info.store_address | fa }}
                </p>
            </td>

            <td>
                <p>
                    <b>خریدار: </b>
                    <?= $order->get_formatted_billing_full_name() ?>
                      
                    <b>استان: </b>
                    <?= $order->get_billing_state() ?>
                    <b>شهر: </b>
                    <?= $order->get_billing_city() ?>
                    <b>کد پستی: </b>
                    <?= $order->get_billing_postcode() ?>
                    <b>شماره تماس: </b>
                    <?= $order->get_billing_phone() ?>
                </p>
                <p>
                    <b>نشانی: </b>
                    <?= $order->get_billing_address_1() ?>
                    <?= $order->get_billing_address_2() ?>
                </p>
            </td>
        </tr>

        <tr>
            <th colspan="2">حمل و نقل</th>
        </tr>

        <tr>
            <td colspan="2">
                <p>
                    <b>خریدار: </b> <?= $order->get_formatted_shipping_full_name() ?>
                      
                    <b>استان: </b>
                    <?= $order->get_shipping_state() ?>
                    <b>شهر: </b>
                    <?= $order->get_shipping_city() ?>
                    <b>کد پستی: </b>
                    <?= $order->get_shipping_postcode() ?>
                    <b>نشانی: </b>
                    <?= $order->get_shipping_address_1() ?>
                    <?= $order->get_shipping_address_2() ?>
                </p>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <th>ردیف</th>
            <th>کد کالا</th>
            <th style="min-width: 300px;">شرح کالا یا خدمات</th>
            <th>تعداد</th>
            <th>مبلغ واحد<br/>(<?= $currencySymbol ?>)</th>
            <th>مبلغ کل<br/>(<?= $currencySymbol ?>)</th>
        </tr>
        <?php
        $row = 1;
        foreach ($order->get_items() as $orderItemId => $value) {
            $orderItem = $order->get_item($orderItemId);
            $product = wc_get_product($orderItem->get_product_id());

            ?>

            <tr>
                <td class="centerp"><?= $row ?></td>
                <td class="centerp"><?= $product->get_sku() ?></td>
                <td>
                    <?= $orderItem->get_name() ?>
                </td>
                <td class="centerp">

                    <?= $orderItem->get_quantity() ?>

                </td>
                <td class="centerp">
                    <?= number_format($orderItem->get_subtotal()) ?>
                </td>
                <td class="centerp"><?= number_format($orderItem->get_total()) ?></td>
            </tr>

            <?php
            $row++;
        }
        ?>


        <tr>
            <td colspan="{{ options.design.show_product_image ? 4 : 3 }}" class="leftp">{{ row.label }}</td>
            <td colspan="1" class="centerp">
                {% if order.get_total_quantity_refunded() %}
                <del>{{ order.get_total_quantity() | fa }}</del>
                <ins>{{ order.get_total_quantity_without_refunded() | fa }}</ins>
                {% else %}
                {{ order.get_total_quantity() | fa }}
                {% endif %}
            </td>
            <td colspan="2" class="centerp">{{ row.value | raw }}</td>
        </tr>
        {% elseif loop.last %}
        <tr>
            <th colspan="{{ options.design.show_product_image ? 5 : 4 }}" class="leftp">{{ row.label }}</th>
            <th colspan="2" class="centerp">{{ row.value | raw }}</th>
        </tr>
        {% else %}
        <tr>
            <td colspan="{{ options.design.show_product_image ? 5 : 4 }}" class="leftp">{{ row.label }}</td>
            <td colspan="2" class="centerp">{{ row.value | raw }}</td>
        </tr>
        {% endif %}

        {% endfor %}

    </table>
    <div class="emza centerp" {{ options.info.store_description | show_hide }}>
        {{ wpautop( options.info.store_description ) }}
    </div>
    <div class="emza centerp" {{ options.design.show_customer_note | show_hide }} {{ order.get_customer_note() |
         show_hide }}>
        {{ wpautop( order.get_customer_note() ) }}
    </div>
</div>
</body>
</html>