
(function() {

    tinymce.PluginManager.add( 'drop', function( editor, url ) {

        // we need to create the 3 array of objects for affiliate codes, personal info and social media info

        var menu_affiliate = [];
        var menu_personalinfo = [];
        var menu_social = [];
        for(i in affiliate_codes)
        {
            (function(i, affiliate_codes){

                var a = {
                    text:affiliate_codes[i].name,
                    onclick: function(){
                        console.log(i)
                        editor.insertContent( "[sharengine id="+ affiliate_codes[i].id+"]" );
                    }
                }

                menu_affiliate.push(a);
            })(i, affiliate_codes);

        }

        for(k in personal_info)
        {
            (function(k){
                var b = {
                    text: personal_info[k],
                    onclick: function(){
                        editor.insertContent( "["+k+"]");
                    }
                };
                menu_personalinfo.push(b);
            })(k);


        }
        for(j in contact_fields)
        {

            (function(j){
                var c = {
                    text: contact_fields[j],
                    onclick:  function() {
                        editor.insertContent( "["+j+"]");
                    }
                };
                menu_social.push(c);
            })(j);


        }

        console.error(menu_social);
        editor.addButton( 'drop', {

            type: 'menubutton',

            text: 'Sharengine',
            tooltip: 'Sharengine shortcodes',

            icon: false,

            menu:
                [
                    // Affiliate Codes
                    {
                        text: 'Affiliate Codes',
                        menu:  menu_affiliate
                    },
                    {
                        text: 'Personal Info',
                        menu: menu_personalinfo
                    },
                    {
                        text: 'Social Media Info',
                        menu: menu_social
                    }



                ]

        } );

    });

})();

