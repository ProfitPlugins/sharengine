<?php
    class seShortcodesJS extends seShortcodes
    {
        public function __construct()
        {
            parent::__construct();

            add_action('wp_head', array($this, 'registerAjaxurl'));

            add_action("wp_enqueue_scripts", array($this, 'loadScripts'));

            add_action('wp_ajax_getData', array($this, 'getData'));
            add_action('wp_ajax_nopriv_getData', array($this, 'getData'));
        }


        // @TODO : Need to refactor this into 2 methods : 1 to get the affiliate  and 1 to set the cookie
        public function getData()
        {
            $affiliate = $_POST['affiliate'];

            // if a user is logged in, cookie the page to him
            if(is_user_logged_in())
            {
                $user_id = get_current_user_id();
                $aff_user = get_user_by( 'id', $user_id );

                $user_login =$aff_user ->user_login;
                setcookie('se_affiliate', $user_login, time()+30*24*3600, '/');
                $_COOKIE['se_affiliate'] = $user_login;
            }
            else
            {
                if($affiliate)
                {
                    $user_login = $affiliate;
                }
                else
                {
                    if($this->data['no_affiliate'] == 0)
                    {

                      $user_login = $this->data['default_user'];
                        setcookie('se_affiliate', $user_login, time()+30*24*3600, '/');
                        $_COOKIE['se_affiliate'] = $user_login;


                    }
                    else
                    {
                        $excludedUsers = $this->data['hidden-excludeList'];

                        $includedUsers = $this->data['hidden-includeList'];


                        // if we have a white list
                        if(!empty($includedUsers))
                        {
                            $includedArray = explode(',', $includedUsers);
                            foreach($includedArray as $username)
                            {


                                global $wpdb;
                                $user = $wpdb->get_row( $wpdb->prepare(
                                    "SELECT `ID` FROM $wpdb->users WHERE `display_name` = %s", $username
                                ) );




                                //$user = get_user_by("slug", $username);
                                $includedUsersIds[] = $user->ID;
                            }

                            //var_dump($includedUsersIds);


                            $users = get_users(array('fields' =>array('user_login'), 'include'=>$includedUsersIds));
                        }
                        else if(!empty($excludedUsers))
                        {
                            $excludedArray = explode(',', $excludedUsers);
                            foreach($excludedArray as $username)
                            {
                                global $wpdb;
                                $user = $wpdb->get_row( $wpdb->prepare(
                                    "SELECT `ID` FROM $wpdb->users WHERE `display_name` = %s", $username
                                ) );
                                $excludedUsersIds[] = $user->ID;
                            }
                            $users = get_users(array('fields' =>array('user_login'), 'exclude'=>$excludedUsersIds));
                        }
                        else
                        {
                            // random a user
                            $users = get_users(array('fields' =>array('user_login')));
                        }



                        $rand = rand(0, count($users)-1);



                        $user_login = $users[$rand]->user_login;

                        setcookie('se_affiliate', $user_login, time()+30*24*3600, '/');
                        $_COOKIE['se_affiliate'] = $user_login;

                    }
                }

            }
            $current_user = get_user_by('login', $user_login);
            $current_user_id =$current_user->data->ID;

            $default_user = get_user_by('login',$this->data['default_user']);
            $default_user_id = $default_user->data->ID;

            $permissions = get_permissions($current_user_id);




            $return_data['se_email']=$current_user->data->user_email;
            $return_data['se_lastname'] = get_user_meta($current_user_id, 'last_name', true);
            $return_data['se_firstname'] = get_user_meta($current_user_id, 'first_name', true);
            $return_data['se_image'] = se_user_avatar_get_avatar($current_user_id, 150);

            $return_data['se_username'] = $current_user->data->user_login;

            $google_plus = str_replace('https://plus.google.com/u/0/+', '', get_user_meta($current_user_id, 'se_googleplus', true));
            if($google_plus)
                $return_data['se_googleplus'] = "https://plus.google.com/u/0/+".$google_plus;
            else
                $return_data['se_googleplus'] = '';
            $linked_in = str_replace('https://www.linkedin.com/profile/view?id=','', get_user_meta($current_user_id, 'se_linkedin', true));
            if($linked_in)
                $return_data['se_linkedin'] = "https://www.linkedin.com/profile/view?id=".$linked_in;
            else
                $return_data['se_linkedin'] = '';


            $return_data['se_phone'] = get_user_meta($current_user_id, 'se_phone', true);

            $facebook = str_replace('https://www.facebook.com/', '', get_user_meta($current_user_id, 'se_facebook', true));
            if($facebook)
                $return_data['se_facebook'] = "https://www.facebook.com/".$facebook;
            else
                $return_data['se_facebook'] = "";
            $twitter = str_replace('https://twitter.com/', '', get_user_meta($current_user_id, 'se_twitter', true) );
            if($twitter)
                $return_data['se_twitter'] = "https://twitter.com/".$twitter;
            else
                $return_data['se_twitter'] = '';

            $return_data['se_website'] = get_user_meta($current_user_id, 'url', true);

            $first_name = get_user_meta($current_user_id, 'first_name', true);
            $last_name = get_user_meta($current_user_id, 'last_name', true);


            $return_data['se_fullname']=$first_name." ".$last_name;


            $fields = get_option(SE_FIELDS_OPTIONS);


            foreach($fields as $k =>$field)
            {
                if($field['se_enabled'])
                {
                    $field = "";
                    if($permissions[$k])
                    {
                        $field = get_user_meta($current_user_id, "field".$k, true);


                    }
                    if(empty($field))
                    {
                        $field = get_user_meta($default_user_id, "field".$k, true);
                    }
                    $userFields[$k] = $field;
                }
            }
            $return_data['fields']=$userFields;

            echo json_encode($return_data);

            die();



        }



        public function loadScripts()
        {
            wp_register_script("ShortcodesJS", SE_URL."js/ShortcodesJS.js", array('jquery', 'seCookies'));
            wp_enqueue_script("ShortcodesJS");

            wp_register_script("seCookies", SE_URL."js/seCookies.js", array('jquery'));
            wp_enqueue_script("seCookies");
        }

        public function registerAjaxurl()
        {
            ?>
                <script type="text/javascript">
                    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
                </script>
            <?php
        }

        public function seEmail()
        {
            return "<span class='se_email'></span>";

        }
        public function seLastName()
        {
            return "<span class='se_lastname'></span>";
        }
        public function seFirstName()
        {
            return "<span class='se_firstname'></span>";
        }
        public function seImage()
        {
            return "<span class='se_image'></span>";
        }
        public function seGoogleplus()
        {
            return "<span class='se_googleplus'></span>";
        }
        public function seLinkedin()
        {
            return "<span class='se_linkedin'></span>";
        }
        public function sePhone()
        {
            return "[se_phone]";
        }
        public function seFacebook()
        {
            return "<span class='se_facebook'></span>";
        }
        public function seTwitter()
        {
            return "<span class='se_twitter'></span>";
        }
        public function seName()
        {
            return "<span class='se_fullname'></span>";
        }
        public function seUsername()
        {
            return "[se_username]";
        }

        public function seSocialMedia($atts)
        {

           if( $atts == "" || $atts['size'] && count($atts)==1)
           {
               $buttonsArray= array ("FB", "TW", "GP", "LI");
           }
            else
                foreach($atts as $k =>$v)
                {
                    if(!is_numeric($v))
                        $buttonsArray[] = $v;
                }
            if($atts['size'])
                $size=$atts['size'];
            else
                $size =48;



           $code = "<ul class='socialMedia' style='height:48px'>";

            foreach($buttonsArray as $socialNetwork)
            {
                switch($socialNetwork)
                {
                    case "FB":
                        $code.=" <li class='se_visitors_facebook'><a target='_blank' href='[socialmedia_facebook]'><img width='".$size."' src='".SE_IMAGES_URL."visitors/facebook.png'/></a></li>";
                    break;
                    case "TW":
                        $code.=" <li class='se_visitors_twitter '><a target='_blank' href='[socialmedia_twitter]'><img width='".$size."' src='".SE_IMAGES_URL."visitors/twitter.png'/> </a></li>";
                    break;

                    case "GP":
                        $code.="<li class='se_visitors_googleplus '><a target='_blank' href='[socialmedia_googleplus]'><img width='".$size."' src='".SE_IMAGES_URL."visitors/googleplus.png'/> </a></li>";
                    break;
                    case "LI":
                        $code.="<li class='se_visitors_linkedin'><a target='_blank' href='[socialmedia_linkedin]'><img width='".$size."' src='".SE_IMAGES_URL."visitors/linkedin.png'/> </a></li>";
                    break;

                   /* case "FB":
                        $code.=" <li class=\"se_visitors_facebook\"><a target=\"_blank\"  href=\"[socialmedia_facebook]\"><img width='".$size."' src='".SE_IMAGES_URL."visitors/facebook.png'/></a></li>";
                        break;
                    case "TW":
                        $code.=" <li class='se_visitors_twitter '><a target='_blank'><img width='".$size."' src='".SE_IMAGES_URL."visitors/twitter.png'/> </a></li>";
                        break;

                    case "GP":
                        $code.="<li class='se_visitors_googleplus '><a target='_blank' ><img width='".$size."' src='".SE_IMAGES_URL."visitors/googleplus.png'/> </a></li>";
                        break;
                    case "LI":
                        $code.="<li class='se_visitors_linkedin'><a target='_blank' ><img width='".$size."' src='".SE_IMAGES_URL."visitors/linkedin.png'/> </a></li>";
                        break;*/


                }
            }



            $code .=" <!--  <li class='se_visitors_pinterest '></li>--></ul> <div style='clear:both'></div>";

            return str_replace("'",'"',$code);
        }

        public function registerShortcode($atts)
        {


            if(!isset($atts['id']))
            {
               $new_atts = urldecode($atts['0']);
               parse_str($new_atts, $atts);
            }
            $id = $atts['id'];
            return "[field{$id}]";
           // return "<span class='field{$id}'></span>";
        }
        public function seWebsite()
        {
            return "[se_website]";
        }

    }