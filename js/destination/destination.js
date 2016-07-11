function load_see_more(classname, destination_id, btn_name, count_all_attractions, function_name, url_title){
    var numItems = $('.'+classname).length;
    show_loading_data();
    $.ajax({
        url: "ajax/destination_ajax/" +function_name+"/",
        type: "POST",
        data: {end_value: numItems, destination_id:destination_id, url_title:url_title},
        success:function(value){
            show_loading_data(false);

            $( "#"+classname ).append( value ); //container id must be same classname

            // check if all list then hide button see more
            numItems = $('.'+classname).length;
            if(count_all_attractions == numItems){
                var btn_id = $(btn_name).attr("id");
                $('.'+btn_id).hide();
            }
        }
    });
}

