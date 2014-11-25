<?php
    abstract class seShortcodes
    {

        public function __construct()
        {
            $this->data=get_option(SE_OPTIONS);


            add_shortcode('sharengine', array($this, 'registerShortcode'));
            add_shortcode('se_fullname', array($this, 'seName'));
            add_shortcode('se_firstname', array($this, 'seFirstName'));
            add_shortcode('se_lastname', array($this, 'seLastName'));
            add_shortcode('se_email', array($this, 'seEmail'));
            add_shortcode('se_twitter', array($this, 'seTwitter'));
            add_shortcode('se_facebook', array($this, 'seFacebook'));
            add_shortcode('se_phone', array($this, 'sePhone'));
            add_shortcode('se_linkedin', array($this, 'seLinkedin'));
            add_shortcode('se_googleplus', array($this, 'seGoogleplus'));
            add_shortcode('se_image', array($this, 'seImage'));

            add_shortcode('se_socialmedia', array($this,'seSocialMedia'));


            add_shortcode('se_website', array($this, 'seWebsite'));

        }


        abstract public function seEmail();
        abstract public function seLastName();
        abstract public function seFirstName();
        abstract public function seImage();
        abstract public function seGoogleplus();
        abstract public function seLinkedin();
        abstract public function sePhone();
        abstract public function seFacebook();
        abstract public function seTwitter();
        abstract public function seName();
        abstract public function seWebsite();
        abstract public function seUsername();

        abstract public function seSocialMedia($atts);


        public function is_user_logged_in()
        {
            global $current_user;
            get_currentuserinfo();

            if ( empty( $current_user->ID ) )
                return false;

            return true;
        }





    }