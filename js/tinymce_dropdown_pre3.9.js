

(function() {
    tinymce.create('tinymce.plugins.drop', {

        init : function(ed, url) {
        },
        createControl : function(n, cm) {

            if(n=='drop'){
                var mlb = cm.createListBox('drop', {
                    title : 'Sharengine',
                    onselect : function(v) {
                        if(v != ''){
                            tinyMCE.activeEditor.selection.setContent( v )
                        }
                    }
                });
                mlb.add("<center> -- Affiliate Codes --</center>", '');
                for(var i in affiliate_codes)
                    mlb.add(affiliate_codes[i].name,"[sharengine id="+ affiliate_codes[i].id+"]");

                mlb.add("<center> -- Personal Info --</center>", '');
                for(i in personal_info)
                {
                    mlb.add(personal_info[i],"["+i+"]");

                }
                mlb.add("<center> -- Social Media Info --</center>", '');
                for(i in contact_fields)
                {
                    mlb.add(contact_fields[i],"["+i+"]");

                }

                return mlb;
            }
            return null;
        }


    });
    tinymce.PluginManager.add('drop', tinymce.plugins.drop);
})();