jQuery(function ($) {

    function pws_selectWoo(element) {
        let select2_args = {
            placeholder: element.attr('data-placeholder') || element.attr('placeholder') || '',
            width: '100%'
        };

        element.selectWoo(select2_args);
    }

    function pws_state_changed(type, state_id) {
        let city_element = $('select#' + type + '_city');

        city_element.html('<option value="0">در حال بارگزاری لیست شهرها...</option>');

        city_element.html(pws_pro_get_cities(state_id, pws_settings.city));

        pws_selectWoo(city_element);
    }

    $(document.body).on('select2:select', "select[id$='_state']", function (e) {
        let type = $(this).attr('id').indexOf('billing') !== -1 ? 'billing' : 'shipping';
        let data = e.params.data;
        pws_state_changed(type, data.id);
    });

    pws_settings.types.forEach(type => {
        pws_selectWoo($('select#' + type + '_state'));
        pws_selectWoo($('select#' + type + '_city'));

        if ($(`#${type}_country`).is('input[type=hidden]')) {
            $(`#${type}_country_field`).hide();
        }
    });

})

