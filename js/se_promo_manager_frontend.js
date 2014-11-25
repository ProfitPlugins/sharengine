jQuery(document).ready(function(){


    jQuery('.module-header').live('click', function(){
        var $container = jQuery(this).parent();

        $container.find(".se-click-to-show").toggle();
    });
    var beforeAjax = function()
    {

        jQuery('.promo_container').css('opacity', 0.5);
    }
    var changePage = function(response)    {


        jQuery('.promo_container').html(response);
        jQuery('.promo_container').css('opacity',1);

        window.changeShortcodes();

    }

    jQuery('.se_filter').tagsManager({
        AjaxPushAllTags: true,
        AjaxPush: ajaxurl,
        AjaxCallback: changePage,
        BeforeAjaxCallback: beforeAjax,
        AjaxPushParameters: {action: 'ajaxFilterPromotions'}
    });

    jQuery(".module-title .tm-tag").live('click',function(){
        tag = jQuery(this).find("span").html();
        jQuery('.se_filter').tagsManager('pushTag', tag);
    });


    // Extract the data. PopUp a window. Redirect to the networks share page
    jQuery(".se_promotion_action").live("click", function(){
        parent = jQuery(this).closest(".se_unit_parent");
        inputs = parent.find(".se_data");

       var inputs_object = new Array();

        jQuery.each(inputs, function(index){


            inputs_object.push({name:jQuery(this).attr("sharengine-share"), value:jQuery(this).text()});

            //inputs_object.push(local_element);
        });
        console.log(inputs_object);
       // inputs_object = inputs.serializeArray();

        // extract the url ( must be called URL)
        jQuery.each(inputs_object, function(index, element){
            if(element.name == "url")
                url = element.value;
        });

        title = document.getElementsByTagName("title")[0].innerHTML;
        // Create the shortlink
        w = 600;
        h = 350;
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2);
        var w =window.open('about:blank', 'Share', 'height=undefined,width=undefined, width='+w+', height='+h+', top='+top+', left='+left, false);

        var network = "twitter";
        tag ="";
        tag2= site_data.site_name;
        tag3 =site_data.post_id;
        tag4=cookie.get("se_affiliate");
        key = "8058019345dc96c4f792c283cbac995b83c80cfdb047c940fd7a41ea68298866";

        site_url = site_data.site_url;

        //@TODO : Implememnt Parent tag
        jQuery.ajax({
            type: "POST",
            async: false,
            url: tag2+"/?shorten_link=1",
            data: {
                v: 3,
                url: url,
                key: key,
                tool: "6fFz17",
                channel: network,
                tag:tag,
                tag_2:tag2,
                tag_3:tag3,
                tag_4:tag4,
                tag_5:site_data.affiliate_variable

            },
            dataType: "jsonp",
            success: function(newLink) {

                var new_url = newLink.awesm_url.replace("http://", "");

                jQuery.each(inputs_object, function(index, element){
                    if(element.name == "url")
                        inputs_object[index].value = new_url

                    //inputs_object[index].value = escape(element.value);
                });

                inputs_object.push({name:"se_redirect", value:1});

                console.log("BEFORE jQery Param");
                console.log(inputs_object);
                inputs_object.description  = escape( inputs_object.description);
                params = jQuery.param(inputs_object);




                // URL that will redirect
                //link = site_url+"?se_redirect=1&url="+new_url+"&title="+content+"&body="+content+"&service="+network;
                link = site_url+"?"+params;

                // http://sorinnunca.com/?se_redirect=1t&url=newLink.awesm_url&title=title&body=body&service=service
                w.location=link;
                console.log(newLink.awesm_url);
                console.log(link);
            }
        });

    })
});