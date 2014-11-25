jQuery('document').ready(function(){

    jQuery('#addNewPromotion').click(function(e){
        // show bootstrap modal here

        jQuery('#popModal').modal('show');
        e.preventDefault();


    })
    jQuery('.service_toggle').iphoneStyle({onChange:function(){
        console.log(jQuery(this));
        if(this.elem.prop('checked'))
        {
            console.log(this.elem.closest('.tab-content'));
            this.elem.closest('.se_service_wrapper').find('.service_content').show();
        }
        else
        {
            this.elem.closest('.se_service_wrapper').find('.service_content').hide();
        }
    }});

    jQuery('.service_toggle').change(function(){
        console.log(jQuery(this).attr('checked'));

    })

    jQuery('.deletePromotion').click(function(e){
        id = jQuery(this).prop('id');

        var parent_tr = jQuery(this).closest('tr');


        if(confirm("Are you sure? This will delete everything related to the promotion."))
        {
            parent_tr.toggle();
            jQuery.post(ajaxurl, {action:"deletePromotion", id:id}, function(response){



            });

        }
        e.preventDefault();

    });



    // Filtering


});