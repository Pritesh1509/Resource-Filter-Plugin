jQuery(document).ready(function(){
    function resource_filter_data(){
        var resource_type = jQuery('#r_filter').val();
        var resource_topic = jQuery('#t_filter').val();

        jQuery.ajax({
            url:ajaxs_obj.ajax_url,
            action:'resource_data',
            type: 'POST',
            data:{
                resource_type:resource_type,
                resource_topic:resource_topic,
            },
            success: function(data) {
                jQuery('#response').html(data); // insert data
            }

        });
    }
   
    jQuery('#r_filter').change(function(){
        resource_filter_data();
    });

    jQuery('#t_filter').change(function(){
        resource_filter_data();
    });

});