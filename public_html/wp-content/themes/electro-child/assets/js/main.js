// jQuery(".checkout .digcon #username").on('click', function () {
//     alert('12345');
// })


jQuery('.woocommerce-billing-fields__field-wrapper #billing_phone').on('keyup', function () {
    let value = jQuery(this).val();
    jQuery(".digcon #username").val(value);
});

jQuery('.digcon #username').on('keyup', function () {
    let value = jQuery(this).val();
    jQuery('.woocommerce-billing-fields__field-wrapper #billing_phone').val(value);
});