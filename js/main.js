jQuery(document).ready(function(){



    jQuery.expr[":"].contains = jQuery.expr.createPseudo(function(arg) {
        return function( elem ) {
            return jQuery(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
        };
    });

    jQuery('#se_search_box').keyup(function() {
        jQuery('#se_modal_content .se_win').hide();

        var value = jQuery('#se_search_box').attr('value');

        if(value == '')
        {
            jQuery('.se_win_name').parent().show();
        }
        else
        {
            jQuery(".se_win_name:contains('"+value+"')").parent().show();
        }


    });
    jQuery('#se_share_button').click(function(){
        jQuery('#se_modal').bPopup({
            modalClose: true,
            easing: 'easeOutBack',
            transition: 'slideDown',
            opacity: 0.6,
            positionStyle: 'fixed', //'fixed' or 'absolute'
            onOpen: function() {
                setTimeout(function(){jQuery('#se_copy').zclip({
                    path:'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
                    copy:function(){return jQuery('#aff_link').val();}
                }); }, 1000);

            }
        });

    })

    jQuery('.se_end_of_post_add').click(function(e){
        e.preventDefault();

        url = jQuery(this).attr('data-url');
        title = jQuery(this).attr('data-title');


        // set the placeholders

        jQuery('#placeholderTitle').val(title);
        jQuery('#placeholderUrl').val(url);

        var regex = new RegExp("&?"+site_data.affiliate_variable+"=([^&]$|[^&]*)", "i");
        affiliateURL = url.replace(regex, "");

        affiliateURL +="?"+site_data.affiliate_variable+"="+cookie.get("se_affiliate");

        console.log(affiliateURL);

        jQuery('#aff_link').val(affiliateURL);

        jQuery('#se_modal').bPopup({
            modalClose: true,
            easing: 'easeOutBack',
            transition: 'slideDown',
            opacity: 0.6,
            positionStyle: 'fixed', //'fixed' or 'absolute'
            onOpen: function() {
                setTimeout(function(){jQuery('#se_copy').zclip({
                    path:'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
                    copy:function(){return jQuery('#aff_link').val();}
                }); }, 1000);

            }
        });

    });

    jQuery('.se_win').click(function(e){

        // Get the URL
        e.preventDefault();
        var regex = new RegExp("&?"+site_data.affiliate_variable+"=([^&]$|[^&]*)", "i");
        url =location.href.replace(regex, "");
        if(jQuery(this).attr('data-url')!=undefined)
        {
            url = jQuery(this).attr('data-url');
        }
        if(jQuery('#placeholderUrl').val()!=undefined && jQuery('#placeholderUrl').val()!='')
        {
            url = jQuery('#placeholderUrl').val();
        }

        console.log("OUR URL: "+url);
        key = "8058019345dc96c4f792c283cbac995b83c80cfdb047c940fd7a41ea68298866";


        title = document.getElementsByTagName("title")[0].innerHTML;
        if(jQuery(this).attr('data-title')!=undefined)
        {
            title = jQuery(this).attr('data-title');
        }
        if(jQuery('#placeholderTitle').val()!=undefined && jQuery('#placeholderTitle').val()!='')
        {
            title = jQuery('#placeholderTitle').val();
        }
        // Create the shortlink
        w = 600;
        h = 350;
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2);
        var w =window.open('about:blank', 'Share', 'height=undefined,width=undefined, width='+w+', height='+h+', top='+top+', left='+left, false);

        network = jQuery(this).attr('href');


        //
        tag = site_data.user_id;
        tag2= site_data.site_name;
        tag3 =site_data.post_id;
        tag4=site_data.username;

        site_url = site_data.site_url;

        //jQuery('.se_original_url').replaceWith(site_url+"?"+site_data.affiliate_variable+"=".site_data.username);


        body = '';



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


                // URL that will redirect
                link = site_url+"?se_redirect=1&old_url="+url+"&o&url="+newLink.awesm_url+"&title="+title+"&body="+body+"&service="+network;
               // http://sorinnunca.com/?se_redirect=1t&url=newLink.awesm_url&title=title&body=body&service=service
                w.location=link;
                console.log(newLink.awesm_url);
                console.log(link);
            }
        });


        return false;
    });



    jQuery('.shareList .se_visitors_win');
    jQuery('.se_visitors_win').click(function(e){
        // Get the URL
       e.preventDefault();

        var regex = new RegExp("&?"+site_data.affiliate_variable+"=([^&]$|[^&]*)", "i");
        url =location.href.replace(regex, "");

        if(jQuery(this).attr('data-url')!=undefined)
        {
            url = jQuery(this).attr('data-url');
        }
        key = "8058019345dc96c4f792c283cbac995b83c80cfdb047c940fd7a41ea68298866";

        title = document.getElementsByTagName("title")[0].innerHTML;

        if(jQuery(this).attr('data-title')!=undefined)
        {
            title = jQuery(this).attr('data-title');
        }
        // Create the shortlink
        w = 600;
        h = 350;
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2);
        var w =window.open('about:blank', 'Share', 'height=undefined,width=undefined, width='+w+', height='+h+', top='+top+', left='+left, false);

        network = jQuery(this).attr('href');

        //
        tag ="";
        tag2= site_data.site_name;
        tag3 =site_data.post_id;
        tag4=cookie.get("se_affiliate");

        site_url = site_data.site_url;

        //jQuery('.se_original_url').replaceWith(site_url+"?"+site_data.affiliate_variable+"=".site_data.username);


        body = '';



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
                link = site_url+"?se_redirect=1&url="+new_url+"&title="+title+"&body="+body+"&service="+network;
                // http://sorinnunca.com/?se_redirect=1t&url=newLink.awesm_url&title=title&body=body&service=service
                w.location=link;
                console.log(newLink.awesm_url);
                console.log(link);
            }
        });


        return false;
    });





})