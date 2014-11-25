jQuery(document).ready(function(){

    jQuery('.confirm').click(function(e){
        if(!confirm("Are you sure?"))
        {
            e.preventDefault();
        }
    })

    var $name = jQuery('#campaign_name');
    var $url = jQuery('#campaign_url');
    jQuery('#campaign_name').typing({
        start: function(){},
        stop:function(){

            jQuery.post(ajaxurl, {action:"sluggify", text: $name.val()}, function(response){

                    $url.val(response);
            })
        },
        delay:400
    })

    jQuery('#campaign_url').typing({
        start: function(){},
        stop:function(){

            jQuery.post(ajaxurl, {action:"sluggify", text: $url.val()}, function(response){


                    $url.val(response);
            })
        },
        delay:800
    })
});