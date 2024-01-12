jQuery(function ($) {

    function pws_selectWoo(element) {
        let select2_args = {
            placeholder: element.attr('data-placeholder') || element.attr('placeholder') || '',
        };

        element.selectWoo(select2_args);
    }

    function pws_state_changed(type, state_id) {
        let city_element = $('select#' + type + '_city');

        city_element.html(pws_pro_get_cities(state_id));

        pws_selectWoo(city_element);
    }

    $(document.body).on('select2:select', "select[id$='_state']", function (e) {
        let type = $(this).attr('id').indexOf('billing') !== -1 ? 'billing' : 'shipping';
        let data = e.params.data;
        pws_state_changed(type, data.id);
    });

    pws_selectWoo($('select.pws_field'));

})

