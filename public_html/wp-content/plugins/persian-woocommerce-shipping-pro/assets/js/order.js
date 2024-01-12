jQuery(function ($) {


    function pws_state_changed(type, state_id, selected = 0) {

        let city_element = $('select#_' + type + '_pws_city');

        if (parseInt(state_id) > 0) {
            city_element.html(pws_pro_get_cities(state_id, selected));
        }
    }

    $(document.body).on('change', "select[id$='_pws_state']", function () {
        let type = $(this).attr('id').indexOf('billing') !== -1 ? 'billing' : 'shipping';
        pws_state_changed(type, $(this).val());
    });

});