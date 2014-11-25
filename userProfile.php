<?php

    class seUserProfile
    {

        public function __construct()
        {


           /* add_filter('user_contactmethods', array($this, 'addContactFields'));

            add_action( 'show_user_profile', array($this, 'addAffiliateFields') );
            add_action( 'edit_user_profile', array($this, 'addAffiliateFields') );

            add_action( 'personal_options_update', array($this, 'saveAffiliateFields') );
            add_action( 'edit_user_profile_update', array($this, 'saveAffiliateFields') );*/


            add_action("admin_menu", array($this, "createSharenginePage"));


            add_shortcode("se_profile_page", array($this, "frontEndProfile"));

            // hook the thickbox into the page

            add_action("init", array($this, 'loadThickbox'));
        }
        public function loadThickbox()
        {
            add_thickbox();
        }
        public function frontEndProfile($atts = array())
        {

            wp_enqueue_style("se_profile_frontend", SE_URL."css/front_end/profile.css");
            wp_register_style("se_profile_frontend");


            if( is_user_logged_in())
            {
                // add_thickbox();
                ob_start();


                $this->loadSharenginePage();
                $content=ob_get_clean();

                $content = str_replace('<h2>Sharengine Profile</h2>', '', $content);

                //
                if($atts['disabled'])
                {
                    $disabledFields = explode(",", $atts['disabled']);

                    foreach($disabledFields as $disabledField)
                    {
                        $content = str_replace('name="'.$disabledField.'"', "readonly='readonly' ".'name="'.$disabledField.'"', $content);
                    }
                }

                return $content;
            }
            else
            {
                return "You must be logged in before accesing this page.";
            }

        }
        public function createSharenginePage()
        {

            $sharenginePage = add_users_page("Sharengine Profile", "Sharengine Profile", "read","sharengine_profile", array($this, "loadSharenginePage"));





        }


        public function loadSharenginePage()
        {
            if($_POST)
            {

                unset($_POST['submit']);
                foreach($_POST as $k => $v) {
                    $user_id = get_current_user_id();
                    if ($k == "se_email") {
                        if(!email_exists($v))
                        {
                            // make sure you can't change your email to another user's
                            $data = array(
                                'ID'=>$user_id,
                                'user_email'=>$v
                            );
                            wp_update_user($data);
                        }

                    }
                    else
                    {
                        update_user_meta($user_id, $k, $v);
                    }

                }
                echo "<div class='updated'><p>Fields Updated!</p></div>";
            }
            $data = array();

            $socialFields = array(
                //'se_phone' => 'Phone Number',
                'se_facebook' =>'Facebook Username',
                'se_twitter' => 'Twitter Username',
                'se_googleplus' => "Google+ Username",
                'se_linkedin' =>"LinkedIn ID:"
            );
            $data['socialFields'] = $socialFields;

            $data['user_id'] = get_current_user_id();

            $integrationFields = array();

            $data['customCategories'] = apply_filters("se_custom_categories", $integrationFields);



            $affiliateFields = get_option(SE_FIELDS_OPTIONS);
            $data['affiliateFields'] = $affiliateFields;
            $data['permissions'] = get_permissions($data['user_id']);
            $data['user'] = wp_get_current_user();
            echo $this->view("admin/sharengineProfile", $data);
        }

       /*
        *  @TODO:  Remove this
        *  public function addContactFields($contactFields)
        {


            $contactFields['phone'] = 'Phone Number';
            $contactFields['facebook'] = 'Facebook';
            $contactFields['twitter'] = 'Twitter';
            $contactFields['googleplus'] = 'Google+';
            $contactFields['linkedin'] = 'LinkedIn';




            return $contactFields;

        }

        public function addAffiliateFields($user)
        {
            //Get the fields
            $fields = get_option(SE_FIELDS_OPTIONS);


?>
        <h3>Sharengine Affiliate information</h3>

        <table class="form-table">
            <?php foreach($fields as $k=>$field){
                if($field['se_enabled'] ==1){
                ?>
                <tr>
                <th><label for="instruments"><?php echo $field['se_field'];?></label></th>
                <td>
                    <input type="text" name="field<?php echo $k;?>" id="instruments" value="<?php echo esc_attr( get_user_meta(  $user->ID,'field'.$k, true ) ); ?>" class="regular-text" /><br />
                    <span class="description"><?php echo $field['se_description'];?></span>
                </td>
            </tr>
            <?php }} ?>

        </table>
<?php
        }

        public function saveAffiliateFields($user_id)
        {

            foreach($_POST as $k=>$v)
            {
                if(strpos($k, 'field')!==FALSE)

                {
                    update_user_meta($user_id, $k, $v);
                }
            }

        }*/
        public function view($view, $data=array())
        {

            ob_start();
            extract($data);
            include $this->path.'views/'.$view.'.php';
            $content=ob_get_clean();

            return $content;
        }

    }