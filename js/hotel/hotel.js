/**
 * Load more hotel items
 * @author TinVM
 * @since May27 2015
 */
function load_more_hotel_items(button) {

    $( button ).click(function( e ) {
    var $btn = $(this).button('loading')
    e.preventDefault();
    var limit = 10;

    var num_hotel = $('.hotel-ids').size();

    var destination_id = $("#btn_see_more").attr("destination-id");

    // load data
    show_loading_data();

    $.ajax({
        url: "ajax/hotel_ajax/get_more_hotel_list_destination/",
        type: "POST",
        data: { destination_id: destination_id, offset: num_hotel },
        success:function(value) {
            show_loading_data(false);
            $btn.button('reset')

            if(value != '') {
                $('.list_hotels').append(value);

                get_hotel_price_from();

                check_btn_show_more(button, 'number-hotels', '.bpt-mb-item');
            } else {
                $(this).remove();
            }

        },
        error:function(var1, var2, var3){
            // do nothing
            show_loading_data(false);
        }
    });
    });
}


/**
 * Get hotel price froms
 *
 * @author TinVM
 * @since May27 2015
 */
function get_hotel_price_from(){
    var post_data = '';
    var is_first = true;

    $('.hotel-ids').each(function(){

        var hotel_id = $(this).attr('data-id');

        if(!is_first){
            post_data = post_data + '&';
        }

        post_data = post_data + 'hotel-ids[]='+ hotel_id;

        is_first = false;
    });

    $.ajax({
        url: '/hotel-price-from/',
        type: "POST",
        dataType:'json',
        data: post_data,
        success:function(value){
            for(var i = 0; i < value.length; i++){

                var price = value[i];
                var hotel_id = price.id;
                if(price.price_origin != price.price_from){
                    $('.h-origin-'+ hotel_id).html('$'+price.price_origin);
                }
                $('.h-from-'+hotel_id).html('$'+price.price_from);
                $('.h-from-'+hotel_id).show();
                $('.h-unit-'+hotel_id).show();
            }
        }
    });
}