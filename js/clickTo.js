jQuery(document).ready(function(){

    window.changeShortcodes();
    jQuery('.click-to-header').click(function(){
       // jQuery(this).parent().children(".click-to-content").toggle()
    });

    var beforeAjax = function()
    {

        jQuery('.sharableContainer').css('opacity', 0.5);
    }
    var changePage = function(response)    {


        jQuery('.sharableContainer').html(response);
        jQuery('.sharableContainer').css('opacity',1);

        window.changeShortcodes();

    }
    jQuery('.se_filter').tagsManager({
        AjaxPushAllTags: true,
        AjaxPush: ajaxurl,
        AjaxCallback: changePage,
        BeforeAjaxCallback: beforeAjax,
        AjaxPushParameters: {action: 'filterSharable'}
    });

    jQuery('.se_filter_facebook').tagsManager({
        AjaxPushAllTags: true,
        AjaxPush: ajaxurl,
        AjaxCallback: changePage,
        BeforeAjaxCallback: beforeAjax,
        AjaxPushParameters: {action: 'filterSharableFacebook'}
    });

    jQuery('.se_twitter_sharable').live('click',function(){

        var content = jQuery(this).closest('.module-content').find('.se_twitter_content').html();
        var url = jQuery(this).closest('.module-content').find('.se_twitter_url').html();

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

                // URL that will redirect
                link = site_url+"?se_redirect=1&url="+new_url+"&title="+content+"&body="+content+"&service="+network;
                // http://sorinnunca.com/?se_redirect=1t&url=newLink.awesm_url&title=title&body=body&service=service
                w.location=link;
                console.log(newLink.awesm_url);
                console.log(link);
            }
        });


        console.log(url);

    });

    jQuery('.se_facebook_sharable').live('click',function(){

        var content = jQuery(this).closest('.module-content').find('.se_twitter_content').html();
        var url = jQuery(this).closest('.module-content').find('.se_twitter_url').html();
        var image = jQuery(this).closest('.module-content').find('.se_twitter_image').attr('src');

        title = document.getElementsByTagName("title")[0].innerHTML;
        // Create the shortlink
        w = 600;
        h = 350;
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2);
        var w =window.open('about:blank', 'Share', 'height=undefined,width=undefined, width='+w+', height='+h+', top='+top+', left='+left, false);

        var network = "facebook";
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

                // URL that will redirect
                link = site_url+"?se_redirect=1&url="+new_url+"&title="+content+"&body="+content+"&service="+network+"&image="+image;
                // http://sorinnunca.com/?se_redirect=1t&url=newLink.awesm_url&title=title&body=body&service=service
                w.location=link;
                console.log(newLink.awesm_url);
                console.log(link);
            }
        });


        console.log(url);

    });
});