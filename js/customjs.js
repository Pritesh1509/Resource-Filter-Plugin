jQuery(document).ready(function(){
    function resource_filter_data(){
        var resource_type = jQuery('#r_filter').val();
        var resource_topic = jQuery('#t_filter').val();
        var search = jQuery('#search').val();

        jQuery.ajax({
            url:my_object.ajax_url,
            type: 'POST',
            data:{
                action:'resource_data',
                resource_type:resource_type,
                resource_topic:resource_topic,
                search:search,
            },
            success: function(data) {
                jQuery('#resource_listing').hide();
                jQuery('#response_data').html(data); // insert data
            }

        });
    }
   
    jQuery('#r_filter').change(function(){
        resource_filter_data();
    });

    jQuery('#t_filter').change(function(){
        resource_filter_data();
    });

    /*jQuery('#search').on('keyup change', function() {
        resource_filter_data();
    });*/

});