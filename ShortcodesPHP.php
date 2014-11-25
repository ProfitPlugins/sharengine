<?php
    class seShortcodesPHP extends seShortcodes
    {
        public function __construct()
        {
            //TODO: refactor this properly




         /*   //  $this->affiliate = $this->getAffiliate($_GET[$this->data['affiliate_variable']]);
            $this->affiliate = $this->getAffiliate($_GET['affiliate']);*/

            parent::__construct();



            add_action('init', array($this, 'setAffiliate'));



        }


        public function getData()
        {

        }


        public function seEmail()
        {
            $username = $this->affiliate;
            $user = get_user_by('login', $username);
            $email = $user->data->user_email;




            return $email;
        }
        public function seLastName()
        {
            $username = $this->affiliate;
            $user = get_user_by('login', $username);
            $userID= $user->data->ID;


            $last_name = get_user_meta($userID, 'last_name', true);

            return $last_name;
        }
        public function seFirstName()
        {
            $username = $this->affiliate;
            $user = get_user_by('login', $username);
            $userID= $user->data->ID;


            $first_name = get_user_meta($userID, 'first_name', true);

            return $first_name;
        }

        public function seImage()
        {
            $username = $this->affiliate;



            $user = get_user_by('login', $username);


            $userID= $user->data->ID;

            return se_user_avatar_get_avatar($userID, 150);



        }
        public function seGoogleplus()
        {
            $username = $this->affiliate;



            $user = get_user_by('login', $username);


            $userID= $user->data->ID;

            $linkedin = get_user_meta($userID, 'se_googleplus', true);


            return $linkedin;
        }
        public function seLinkedin()
        {
            $username = $this->affiliate;



            $user = get_user_by('login', $username);


            $userID= $user->data->ID;

            $linkedin = get_user_meta($userID, 'se_linkedin', true);


            return $linkedin;
        }
        public function sePhone()
        {
            $username = $this->affiliate;



            $user = get_user_by('login', $username);


            $userID= $user->data->ID;

            $phone = get_user_meta($userID, 'phone', true);


            return $phone;
        }
        public function seFacebook()
        {
            $username = $this->affiliate;
            $user = get_user_by('login', $username);
            $userID= $user->data->ID;
            $facebook = get_user_meta($userID, 'facebook', true);
            return $facebook;
        }


        public function seTwitter()
        {
            $username = $this->affiliate;



            $user = get_user_by('login', $username);


            $userID= $user->data->ID;

            $twitter = get_user_meta($userID, 'twitter', true);


            return $twitter;
        }



        public function seName()
        {
            $username = $this->affiliate;



            $user = get_user_by('login', $username);


            $userID= $user->data->ID;

            $first_name = get_user_meta($userID, 'first_name', true);
            $last_name = get_user_meta($userID, 'last_name', true);

            return $first_name." ".$last_name;

           // return get_user_meta($userID, $fieldName, true);
        }
        public function seWebsite()
        {
            $username = $this->affiliate;



            $user = get_user_by('login', $username);


            $website = $user->data->user_url;

            return $website;
        }

        public function seUsername()
        {
            return $this->affiliate;
        }




        public function setAffiliate()
        {


            if(isset($_GET['affiliate']))
            {
                $affiliate = $_GET['affiliate'];
            }
            else
                $affiliate ='';
            // If the visitor is logged_in, the site belongs to him
            if($this->is_user_logged_in())
            {
                global $current_user;
                get_currentuserinfo();

                $this->affiliate = $current_user->user_login;

                setcookie('se_affiliate', $this->affiliate, time()+30*24*3600, '/');
                $_COOKIE['se_affiliate']=$this->affiliate;
            }
            else
            {
                //If there's an affiliate code in the link, use that.
                //TODO: Set a cookie here
                if($affiliate !='')
                {
                    $this->affiliate = $affiliate;
                    setcookie('se_affiliate', $this->affiliate, time()+30*24*3600, '/');
                    $_COOKIE['se_affiliate']=$this->affiliate;
                }
                else
                {
                    //if there's a cookie set use that
                    if(isset($_COOKIE['se_affiliate']) && $_COOKIE['se_affiliate']!='')
                    {
                        $this->affiliate = $_COOKIE['se_affiliate'];
                    }
                    else
                    {

                        //if there's a default user set use that
                        if($this->data['no_affiliate'] == 0)
                        {

                            $this->affiliate= $this->data['default_user'];
                            setcookie('se_affiliate', $this->affiliate, time()+30*24*3600, '/');
                            $_COOKIE['se_affiliate']=$this->affiliate;

                        }
                        else
                        {
                            // random a user
                            $users = get_users(array('fields' =>array('user_login')));

                            $rand = rand(0, count($users)-1);

                            $this->affiliate = $users[$rand]->user_login;
                            setcookie('se_affiliate', $this->affiliate, time()+30*24*3600, '/');
                            $_COOKIE['se_affiliate']=$this->affiliate;
                        }
                    }
                }
            }

        }

        public function registerShortcode($atts)
        {
            $id = $atts['id'];
            $username = $this->affiliate;
            $user = get_user_by('login', $username);
            $fieldName = 'field'.$id;
            $userID= $user->data->ID;
            return get_user_meta($userID, $fieldName, true);
        }

        public function seSocialMedia($atts)
        {
            //TODO: Implement this for regular users
        }

    }

//Enable shortcodes in the widgets
add_filter('widget_text', 'do_shortcode');