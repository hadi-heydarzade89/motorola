jQuery(function ($) {

    function pws_selectWoo(element) {
        let select2_args = {
            placeholder: element.attr('data-placeholder') || element.attr('placeholder') || '',
            width: '100%'
        };

        element.selectWoo(select2_args);
    }

    function pws_state_changed(type, state_id, selected = 0) {

        let city_element = $('select#' + type + '_city');

        city_element.html("<option value='0'>لطفا شهر خود را انتخاب نمایید </option>");

        city_element.append(pws_pro_get_cities(state_id, selected));

        pws_selectWoo(city_element);
    }

    $(document.body).on('change', "select[id$='_state']", function (e) {
        let type = $(this).attr('id').indexOf('billing') !== -1 ? 'billing' : 'shipping';
        pws_state_changed(type, $(this).val());
    });

    $(document.body).on('change', "select[id$='_city']", function (e) {
        $('body').trigger('update_checkout');

        let type = $(this).attr('id').indexOf('billing') !== -1 ? 'billing' : 'shipping';
        pws_city_changed(type, $(this).val());
    });

    function pws_city_changed(type, city_id) {

        let district_element = $('select#' + type + '_district');

        district_element.html('<option value="0">در حال بارگزاری لیست محله‌ها...</option>');

        let data = {
            'action': 'mahdiy_load_districts',
            'city_id': city_id,
            'type': type
        };

        $.post(pws_settings.ajax_url, data, function (response) {
            if (response.trim() === "") {
                $('p#' + type + '_district_field').slideUp();
            } else {
                $('p#' + type + '_district_field').slideDown();
            }

            district_element.html(response);
            $('body').trigger('update_checkout');
        });

        pws_selectWoo(district_element);
    }

    let is_cod = pws_settings.is_cod;

    $('form.checkout').on('change', 'input[name^="payment_method"]', function () {
        $('body').trigger('update_checkout');
        is_cod = ($(this).val() === 'cod');
    });

    $(document.body).on('change', "select[id$='_district']", function (e) {
        $('body').trigger('update_checkout');
    });

    pws_settings.types.forEach(type => {
        pws_selectWoo($('select#' + type + '_state'));
        pws_selectWoo($('select#' + type + '_city'));
        pws_selectWoo($('select#' + type + '_district'));
    });

});