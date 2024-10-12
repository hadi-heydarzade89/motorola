<?php defined('ABSPATH') || exit;
if (!is_admin()) {
    exit;
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="MahdiY">
    <title>فاکتور<?= $order->ID ?></title>
    <link href="<?= get_theme_file_uri('/assets/css/admin/admin-styles.css') ?>" rel="stylesheet">
    <style>
        body {
            font-family: !important;
            color: ;
            font-size: 11px;
        }

        .content.factor th {
            background: ;
            font-size: 13px;
        }

        @page {
            margin: 0;
        }

        @media print {
            .no-print, .no-print * {
                display: none !important;
            }
        }

    </style>
</head>
<body>
<div class="thermal content factor">
    <div class="header">
        <img src="" style="max-width: 100%;display:flex;margin:0 auto" alt="">
        <h2 class="centerp"></h2>

        <p>شماره فاکتور: <?= $order->ID ?> - تاریخ: <?= $createdDatetime ?><p>
        <p>||</p>
    </div>
    <table width="300">

        <tr>
            <td>
                <p>
                    <b>خریدار: </b>
                    <?= $order->get_formatted_shipping_full_name() ?>
                    <b>کد ملی: </b><?= get_user_meta($customerId, 'national_id', true) ?>
                </p>
                <p>
                    <b>نشانی: </b><?= $shippingAddress ?>
                    <b>کد پستی: </b> <?= $shippingPostcode ?>
                    <b>تلفن: </b><?= $billingPhone ?>
                </p>

            </td>
        </tr>
        <tr style="display: none;">
            <th>حمل و نقل</th>
        </tr>
        <tr style="display: none;">
            <td>
                <p>
                    <b>خریدار: </b>
                    <?= $order->get_formatted_shipping_full_name() ?>

                </p>
                <p>
                    <b>نشانی: </b><?= $shippingAddress ?>
                    <b>کد پستی: </b><?= $shippingPostcode ?></p>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <th>عنوان</th>
            <th>تعداد</th>
            <th>مبلغ واحد<br/>(<?= $currencySymbol ?>)</th>
            <th>مبلغ کل<br/>(<?= $currencySymbol ?>)</th>
        </tr>

        <?php
        foreach ($order->get_items() as $orderItemId => $value) {
            $orderItem = $order->get_item($orderItemId);
            ?>
            <tr>
                <td>
                    <?= $orderItem->get_name() ?>

                </td>
                <td class="centerp">
                    <?= $orderItem->get_quantity() ?>
                </td>
                <td class="centerp">
                <span class="woocommerce-Price-amount amount"><bdi><span
                                class="woocommerce-Price-currencySymbol"></span><?= number_format($orderItem->get_subtotal()) ?></bdi></span>
                </td>
                <td class="centerp"><span class="woocommerce-Price-amount amount"><bdi><span
                                    class="woocommerce-Price-currencySymbol"></span><?= number_format($orderItem->get_total()) ?></bdi></span>
                </td>
            </tr>
            <?php
        }
        ?>
        <!----->
        <tr>
            <td colspan="1" class="leftp">مجموع:</td>
            <td colspan="1" class="centerp"><?= $order->get_item_count() ?></td>
            <td colspan="2" class="centerp"><span class="woocommerce-Price-amount amount"><bdi><span
                                class="woocommerce-Price-currencySymbol"></span><?= number_format($order->get_subtotal()) ?></bdi></span>
                <?= $currencySymbol ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="leftp">هزینه ارسال - <?= $order->get_shipping_method() ?>:</td>
            <td colspan="2" class="centerp"><span class="woocommerce-Price-amount amount"><bdi><span
                                class="woocommerce-Price-currencySymbol"></span><?= number_format($order->get_shipping_total()) ?></bdi></span>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="leftp">مالیات:</td>
            <td colspan="2" class="centerp"><span class="woocommerce-Price-amount amount"><bdi><span
                                class="woocommerce-Price-currencySymbol"></span><?= number_format($order->get_total_tax()) ?></bdi></span>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="leftp">روش پرداخت:</td>
            <td colspan="2" class="centerp"><?= $order->get_payment_method_title() ?></td>
        </tr>
        <tr>
            <th colspan="2">مجموع مبلغ نهایی</th>
            <th colspan="2"
                class="centerp"><span class="woocommerce-Price-amount amount"><bdi><span
                                class="woocommerce-Price-currencySymbol"></span><?= number_format($order->get_total()) ?></bdi></span> <?= $currencySymbol ?>
            </th>
        </tr>
    </table>
    <div class="emza centerp" style="display: none;">

    </div>
    <div class="emza centerp" style="display: none;" style="display: none;">

    </div>
</div>
</body>
</html>
<button class="print_btn no-print" onclick="print();">پرینت</button>
