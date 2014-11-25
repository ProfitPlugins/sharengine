<?php
    class seAdminShortcodesDropdown
    {
        public function __construct()
        {
            add_action('admin_head', array($this, 'dropdownButoon'));
            add_action('admin_head', array($this, 'loadShortcodes'));
        }
        public function dropdownButoon()
        {
            add_filter('mce_external_plugins', array($this, 'addPlugin'));
            add_filter('mce_buttons', array($this, 'addButton'));
        }
        public function addPlugin($plugin_array) {
            global $wp_version;
            if($wp_version>=3.9)
                $plugin_array['drop'] = SE_URL.'js/tinymce_dropdown.js';
            else
                $plugin_array['drop'] = SE_URL.'js/tinymce_dropdown_pre3.9.js';
            return $plugin_array;
        }

        public  function addButton($buttons) {
            array_push($buttons, 'drop');
            return $buttons;
        }
        public function loadShortcodes()
        {
            ?>
            <script type="text/javascript">
                <?php $fields = get_option(SE_FIELDS_OPTIONS);
                foreach($fields as $k =>$field)
                {
                    if($field['se_enabled'])
                    {
                        $current_field['name']= $field['se_field'];
                        $current_field['id'] =$k;
                        $shortcodes[] = $current_field;
                    }
                }

                $personalInfo['se_firstname'] = 'First Name';
                $personalInfo['se_lastname'] = 'Last Name';
                $personalInfo['se_fullname'] = 'Full Name';
                $personalInfo['se_phone'] = 'Phone Number';
                $personalInfo['se_email'] = 'Email';
                $personalInfo['se_image'] = 'Profile Image';
                $contactFields['se_facebook'] = 'Facebook';
                $contactFields['se_twitter'] = 'Twitter';
                $contactFields['se_googleplus'] = 'Google+';
                $contactFields['se_linkedin'] = 'LinkedIn';



                ?>
                var affiliate_codes =<?php echo json_encode($shortcodes);?>;
                var personal_info =<?php echo json_encode($personalInfo);?>;
                var contact_fields =<?php echo json_encode($contactFields);?>;
            </script>
        <?php
        }
    }