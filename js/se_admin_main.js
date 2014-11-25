jQuery('document').ready(function(){


    jQuery(".se_default").live("click", function(e){

        if(e.which)
        {
            // is checked already, uncheck the other one too
            if(jQuery(this).prop("checked"))
            {
                jQuery(this).parent().parent().find(".se_activate").prop("checked", true).trigger("change");
            }


        }

    });
    jQuery(".se_activate").live("click", function(e){

        if(e.which)
        {
            // if its already checked do nothing
            if(jQuery(this).prop("checked"))
            {
                jQuery(this).parent().parent().find(".se_default").prop("checked",true).trigger("change");
            }
            else
            {
                jQuery(this).parent().parent().find(".se_default").prop("checked",false).trigger("change");

                //jQuery(this).parent().parent().find(".se_activate").prop("checked", true);
            }


        }

    });



    jQuery(".tm-input").livequery(function(){
        jQuery(this).tagsManager({
            prefilled: jQuery(this).val()
        });



    });

    updateCountdownAll();
    jQuery('.message').live('input', updateCountdown);

    jQuery('.show_hide').live('change', function()
    {
        console.log(jQuery(this).prop("checked"));
        if(jQuery(this).prop("checked"))
            jQuery("div[rel="+jQuery(this).attr('id')+"]").fadeIn();
        else
            jQuery("div[rel="+jQuery(this).attr('id')+"]").fadeOut();
    });


    jQuery('#addNewField').click(function(){
        jQuery('#fieldsCount').val( function(i, oldval) {
            return ++oldval;
        });
        jQuery.post(ajaxurl, {action: 'addNewField', field_nr: jQuery('#fieldsCount').val()-1}, function(success){

           jQuery('#fieldsPlaceholder').append(success);

           // jQuery(this).find(".tm-input").tagsManager();


        });


    });

    jQuery('#addNewShare').click(function(){
        jQuery('#fieldsCount').val( function(i, oldval) {
            return ++oldval;
        });
        jQuery.post(ajaxurl, {action: 'addNewShare', field_nr: jQuery('#fieldsCount').val()-1}, function(success){

            jQuery('#sharesPlaceholder').append(success);




        });


    });

    jQuery('#addNewTweet').click(function(){
        jQuery('#fieldsCount').val( function(i, oldval) {
            return ++oldval;
        });
        jQuery.post(ajaxurl, {action: 'addNewTweet', field_nr: jQuery('#fieldsCount').val()-1}, function(success){

            jQuery('#tweetsPlaceholder').append(success);




        });


    });

    var custom_uploader;


    jQuery('.upload_image_button').live("click", function(e) {

        e.preventDefault();

        $el = jQuery(this);


        console.log( $el.parent());
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }

        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();


            $el.closest(".settings-content").find('.upload_image').val(attachment.url);
        });

        //Open the uploader dialog
        custom_uploader.open();

    });


});

function updateCountdownAll() {

    jQuery('.message').each(function () {

        updateCountdown(this);
    });
}

function updateCountdown(e) {



    var currentElement;
    if (e.target) {
        currentElement = e.target;
    } else {
        currentElement = e;
    }

    var maxLenght = jQuery(currentElement).attr('maxlength');

   // alert(maxLenght);
    var remaining = maxLenght - jQuery(currentElement).val().length;

    if(remaining<=50)
    {
        console.log(remaining);
       // jQuery(currentElement).nextAll('.counter:first').show();
        jQuery(currentElement).nextAll('.counter:first').text(remaining + ' characters remaining.');
    }
    else
    {
        jQuery(currentElement).nextAll('.counter:first').text("");
    }
}