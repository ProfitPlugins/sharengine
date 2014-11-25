function getURLParameters(url){

    var result = {};
    var searchIndex = url.indexOf("?");
    if (searchIndex == -1 ) return result;
    var sPageURL = url.substring(searchIndex +1);
    var sURLVariables = sPageURL.split('&');


    for (var i = 0; i < sURLVariables.length; i++)
    {
        var sParameterName = sURLVariables[i].split('=');
        result[sParameterName[0].toLowerCase()] = sParameterName[1];

        return result;
    }



}
window.changeShortcodes = function(){
    var ck = cookie.get('se_affiliate');
    jQuery.post(ajaxurl, {action: "getData", affiliate: ck}, function(response){




        var data = jQuery.parseJSON(response);




        if(data.se_facebook!="" && typeof data.se_facebook!="undefined")
        {

            // Show the facebook button
            jQuery('.socialMedia .se_visitors_facebook').show();
            jQuery('.socialMedia .se_visitors_facebook a').attr("href", function(index, old){

                if(typeof old != 'undefined')
                {
                    console.log(old);
                    return old.replace('[socialmedia_facebook]', data.se_facebook);
                }
            })
        }

        if(data.se_twitter!='' && typeof data.se_twitter!="undefined")
        {
            jQuery('.socialMedia .se_visitors_twitter').show();
            jQuery('.socialMedia .se_visitors_twitter a').attr("href", function(index, old){
                if(typeof old != 'undefined')
                {
                    return old.replace("[socialmedia_twitter]", data.se_twitter);
                }
            })
        }
        if(data.se_googleplus!='' && typeof data.se_googleplus!="undefined")
        {
            console.log(data.se_visitors)
            jQuery('.socialMedia .se_visitors_googleplus').show();
            jQuery('.socialMedia .se_visitors_googleplus a').attr("href", function(index, old){
                if(typeof old != 'undefined')
                {
                    return old.replace("[socialmedia_googleplus]", data.se_googleplus);
                }
            })
        }
        if(data.se_linkedin!='' && typeof data.se_linkedin!="undefined")
        {
            jQuery('.socialMedia .se_visitors_linkedin').show();
            jQuery('.socialMedia .se_visitors_linkedin a').attr("href", function(index, old){
                if(typeof old != 'undefined')
                {
                    return old.replace("[socialmedia_linkedin]", data.se_linkedin);
                }
            })
        }

        console.log(data)
        jQuery.each(data, function(key, value){

            if(key == 'fields')
            {
                console.log(data[key]);
                if(data[key] != null)
                {
                    jQuery.each(data[key], function(key2, val2){
                        console.log(key);
                        jQuery('a').each(function() {
                            jQuery(this).attr("href", function(index, old) {
                                if(typeof old != 'undefined')
                                    return old.replace("[field"+key2+"]", val2);
                            });
                        });

                    jQuery("*").each(function () {

                        if (jQuery(this).children().length == 0) {

                            jQuery(this).text(jQuery(this).text().replace("[field"+key2+"]", val2));
                        }
                    });

                    //jQuery('body').html().replace('[', val2);
                    jQuery('.field'+key2).replaceWith(val2);
                    })
                }

            }
            else
            {

                if((key == "se_website" && value!="undefined") || key == "se_phone")
                {


                    jQuery('a').each(function() {
                        jQuery(this).attr("href", function(index, old) {
                            if(typeof old != 'undefined')
                                return old.replace("["+key+"]", value);
                        });
                    });
                    jQuery("*").each(function () {

                        if (jQuery(this).children().length == 0) {

                            jQuery(this).text(jQuery(this).text().replace("["+key+"]", value));
                        }
                    });
                }
                if(key == "se_username" && value!="undefined")
                {

                    jQuery('a').each(function() {
                        jQuery(this).attr("href", function(index, old) {
                            if(typeof old != 'undefined')
                                return old.replace("["+key+"]", value);
                        });
                    });
                    jQuery('input').each(function() {
                        jQuery(this).attr("value", function(index, old) {
                            if(typeof old != 'undefined')
                                return old.replace("["+key+"]", value);
                        });
                    });
                    jQuery("*").each(function () {

                        if (jQuery(this).children().length == 0) {

                            jQuery(this).text(jQuery(this).text().replace("["+key+"]", value));
                        }
                    });
                }


                jQuery('.'+key).replaceWith(value);
            }


        });


    })
}

jQuery(document).ready(function(){

    var url = window.location.href;

    var params = getURLParameters(url);

    if(typeof params[site_data.affiliate_variable] != 'undefined')
    {
        var affiliate = params[site_data.affiliate_variable];
    }
    else
        var affiliate = '';

    console.log(affiliate);

    //alert(affiliate);

    if(affiliate !='')
    {
        // if we get a new affiliate, set it
        cookie.set( 'se_affiliate' ,affiliate, {
            expires: 7,
            path: "/",
            secure: false
        });

    }


   // alert(params['affiliate']);


    window.changeShortcodes();




});

