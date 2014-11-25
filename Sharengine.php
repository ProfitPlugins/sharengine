<?php
/*
    Plugin Name: Sharengine
    Description: Sharengine is a cutting edge content sharing platform.
    Author: The Sharengine Team
    Version: 1.5
*/
define("SE_IMAGES_URL", plugins_url('images', __FILE__).'/');
define("SE_URL", plugin_dir_url(__FILE__));
define("SE_PATH", plugin_dir_path(__FILE__));

define("SE_NAME", "Sharengine");
define("SE_SLUG", "nds_sharengine");

//Slugs Definitions

define("SE_PROMO_SLUG", SE_SLUG."_promotions");

//options holding settings
define("SE_OPTIONS", "se_options");
define("SE_FIELDS_OPTIONS", "se_fields_options");
define("SE_UPDATE_SLUG", plugin_basename( __FILE__ ));
define("SE_CACHE_TABLE", "se_cache");



//database tables
define("SE_SOCIAL_CONTENT", "se_sharable");
define("SE_TAGS", "se_tags");
define("SE_TWEETS_TAGS", "se_tweetsTags");

define("SE_PROMOS", "se_promos");
define("SE_SERVICES", "se_services");

define("SE_PERMISSIONS", "se_permissions");

define("SE_DB_VERSION", 1.84 );
/*error_reporting(E_ALL);
ini_set('display_errors', true);*/

add_filter('widget_text', 'do_shortcode', 1,1);

function get_permissions($user_id)
{
    $permissions = get_option(SE_PERMISSIONS);



    $permissions = $permissions[$user_id];



    // var_dump($permissions);
    $data['fields'] = get_option(SE_FIELDS_OPTIONS);
    foreach($data['fields'] as $k=>$v)
    {
        $default_permissions[$k] = $v['se_default'];
    }


    if(is_array($permissions) && !empty($permissions))
    {
      return $permissions;
    }
    else
    {
       return $default_permissions;
    }
}


register_activation_hook(__FILE__, array("ShareEngine", "activation_hook"));
class ShareEngine
{
    public static function activation_hook()
    {


        error_reporting(E_NONE);
        ini_set('display_errors', 0);

        //Migrate from 1.0 to 1.1.

//        $oldContactFields = array('phone', 'facebook', 'twitter', 'googleplus', 'linkedin');
//
//        $userIDS = get_users("fields=ID");

       // var_dump($userIDS);

//       / foreach($userIDS as $ID)
//        {
//            foreach($oldContactFields as $contactField)
//            {
//                $newContactField = "se_".$contactField;
//
//                update_user_meta($ID, $newContactField, get_user_meta($ID, $contactField, true));
//
//            }
//        }
        self::databaseCreation();


        update_option("se_current_version", SE_DB_VERSION);

        $options = get_option(SE_OPTIONS);
        if(!isset($options['enable_sharengine_button']))
        {
            $options['enable_sharengine_button']  = 1;

            update_option(SE_OPTIONS, $options);
        }

    }
    public static function databaseCreation()
    {


        global $wpdb;
        $sql = "CREATE TABLE ".$wpdb->prefix.SE_CACHE_TABLE." (
          id int(20) NOT NULL AUTO_INCREMENT,
          user_id int(20) NOT NULL,
          cache_key varchar(3000) NOT NULL,
          value text NOT NULL,
          timestamp int(20) NOT NULL,
          PRIMARY KEY  (id)
        );";


        $sharable = "CREATE TABLE ".$wpdb->prefix.SE_SOCIAL_CONTENT." (
            id int(20) NOT NULL AUTO_INCREMENT,
            content TEXT NOT NULL,
            link varchar(300) NOT NULL,
            image varchar(300) NOT NULL,
            type varchar(300) NOT NULL,
            PRIMARY KEY  (id)
        );";
        $tags = "CREATE TABLE ".$wpdb->prefix.SE_TAGS." (
            id int(20) NOT NULL AUTO_INCREMENT,
            tag varchar(300) NOT NULL,
            PRIMARY KEY  (id)
        );";
        $tweetsTags = "CREATE TABLE ".$wpdb->prefix.SE_TWEETS_TAGS." (
            tweet_id int(20) NOT NULL,
            tag_id int(20) NOT NULL
        );";

        $promos = "CREATE TABLE ".$wpdb->prefix.SE_PROMOS." (
            id int(20) NOT NULL AUTO_INCREMENT,
            name varchar(300) NOT NULL,
            PRIMARY KEY  (id)
        );";

        $services = "CREATE TABLE ".$wpdb->prefix.SE_SERVICES." (
            id int(20) NOT NULL AUTO_INCREMENT,
            promotion_id int(20) NOT NULL,
            type varchar(300) NOT NULL,
            content TEXT NOT NULL,
            enabled int(1) NOT NULL,
            PRIMARY KEY  (id)
        );";



        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        //Promotion Manager tables
        dbDelta($promos);
        dbDelta($services);


        dbDelta( $sql );


        dbDelta($sharable);
        dbDelta($tags);
        dbDelta($tweetsTags);
       // wp_die($wpdb->last_error );
    }

    public function __construct()
    {

        //TODO: Load everything on ShareEngine enabled pages only
        add_action("wp_enqueue_scripts", array($this, "load_styles"));

       // add_action("admin_init", array("ShareEngine", "activation_hook"));


        // init hook to update plugin

        add_action("init", array($this, "update_database"));


        add_action("wp", array($this, "add_filters"));


        add_filter( 'clean_url', array($this, 'parseMenuLinks'), 1, 3 );

        add_action('wp_loaded',array($this, "saveMenu"));
        add_filter("wp_nav_menu_items", array($this, "addShortcodesToMenu"));
    }

    public function addShortcodesToMenu($items, $args)
    {
        return do_shortcode($items);
    }

    public function saveMenu()
    {
        if(current_user_can("activate_plugins"))
        {
            add_action( 'clean_url', array($this, 'saveMenuLinksWithShortcodes'), 1, 3 );
        }
    }
    public function saveMenuLinksWithShortcodes($url, $orig_url, $context)
    {
        if($context=='db'){
            return $orig_url;
        }
        return $url;
    }

    public function parseMenuLinks($url, $orig_url, $context)
    {

        if( $context=='display' ){
            return do_shortcode($orig_url);
        }
        return $url;
    }

    public function add_filters()
    {
        global $post;
        $se_enabled=get_post_meta($post->ID, 'se_enabled', true);

       // die(var_dump($post));





            if(is_user_logged_in() && $se_enabled == 1)
            {
                add_filter("the_content", array($this, "loggedin_buttons_at_the_end_of_a_post"));
                add_action('wp_footer', array($this, 'loggedin_footer_placeholder'));
            }
            else
            {
                add_filter("the_content", array($this, "viral_buttons_at_the_end_of_a_post"));

            }



    }

    public function viral_buttons_at_the_end_of_a_post($content)
    {

        if(is_home() || is_single())
        {

            global $post;
            $networksArray = array('facebook', 'twitter', 'google_plusone_share', 'pinterest', 'linkedin');

            $shareContent ="<div style='padding-bottom:5px'><h5 style='margin-top:0.5em;margin-bottom:0.5em'>Share This Post</h5>";
            foreach($networksArray as $network)
            {
                $shareContent .=  "<a data-title='{$post->post_title}' data-url='".get_permalink($post->ID)."' class='se_visitors_win' href=\"{$network}\"><img width='33' src=\"".SE_IMAGES_URL."visitors/{$network}.png\"/></a> &nbsp;&nbsp;";

            }
            $shareContent .="</div>";
        }

        $options = get_option(SE_OPTIONS);

        if($options['enable_beginning'])
        {
            $beginningCode =str_replace("Share This Post", "", $shareContent);
            $content = $beginningCode . $content;
            //$content = $shareContent . $content;
        }

        if($options['enable_end'])
        {
            $content .= $shareContent;
        }

        return $content;
    }
    public function loggedin_footer_placeholder()
    {
        // hold the url and the title for the page

        echo "<input type='hidden' name='title' id='placeholderTitle'>
            <input type='hidden' name='url' id='placeholderUrl'/>
        ";
    }
    public function loggedin_buttons_at_the_end_of_a_post($content)
    {
        if(is_home() || is_single())
        {
            global $post;
            $networksArray = array('facebook', 'twitter', 'google_plusone_share', 'pinterest', 'linkedin');
            $shareContent ="<div style='padding-bottom:5px'><h5 style='margin-top:0.5em;margin-bottom:0.5em'>Share This Post</h5>";
            foreach($networksArray as $network)
            {
                $shareContent .=  "<a data-title='{$post->post_title}' data-url='".get_permalink($post->ID)."' class='se_win' href=\"{$network}\"><img width='33' src=\"".SE_IMAGES_URL."visitors/{$network}.png\"/></a> &nbsp;&nbsp;";

            }

            // special link for the add button
            $shareContent .=  "<a data-title='{$post->post_title}' data-url='".get_permalink($post->ID)."' class='se_end_of_post_add' href=\"{$network}\"><img width='32' src=\"".SE_IMAGES_URL."visitors/add.png\"/></a> &nbsp;&nbsp;";
            $shareContent .="</div>";

            $options = get_option(SE_OPTIONS);
            if($options['enable_beginning'])
            {
                $beginningCode =str_replace("Share This Post", "", $shareContent);
                $content = $beginningCode . $content;
            }

            if($options['enable_end'])
            {
                $content .= $shareContent;
            }

        }
        return $content;
    }

    public function update_database()
    {
        $currentVersion = get_option("se_current_version");

        if($currentVersion != SE_DB_VERSION)
        {
            // run the activation function

            self::activation_hook();
        }
    }



    // Front End CSS + JS
    public function load_styles()
    {
        $options = get_option("SE_OPTIONS");



        wp_register_style("se_main", SE_URL.'css/main.css');
        wp_enqueue_style("se_main");

        wp_register_style("se_social_networks_image", SE_URL.'css/social_networks_image.css');
        wp_enqueue_style("se_social_networks_image");

        $templates_css=array();
        $templates_css=apply_filters("template_css", $templates_css);
        if(!empty($templates_css))
        {
            foreach($templates_css as $key=>$path)
            {
                wp_register_style($key, $path);
                wp_enqueue_style($key);
            }

        }

        $templates_js=array();
        $templates_js=apply_filters("template_js", $templates_js);
        if(!empty($templates_js))
        {
            foreach($templates_js as $key=>$path)
            {
                wp_register_script($key, $path, array('jquery', 'se_main'));
                wp_enqueue_script($key);
            }
        }

        $js_array=array();
        $js_array['se_main']='main.js';
        $js_array['se_bpopup'] ='bpopup.min.js';
        $js_array['se_easing'] ='jquery.easing.js';
        $js_array['se_zclip'] = 'zclip.js';
       // $js_array['modernizr'] = 'modernizr.js';
        foreach($js_array as $key=>$value)
        {
            if($key == "se_main")
            {
                wp_register_script($key, SE_URL."js/".$value, array('jquery', 'se_zclip', 'se_bpopup'));

            }
            else
            {
                wp_register_script($key, SE_URL."js/".$value, array('jquery'));
            }


            wp_enqueue_script($key);
            if($key == 'se_main')
            {
                global $post;
                global $current_user;

                get_currentuserinfo();

                $data['post_id'] = $post->ID;
                $data['user_id'] =get_current_user_id();
                //
                $data['site_name'] =get_bloginfo('url');
                $data['username'] = $current_user->user_login;
                $data['site_url']=site_url();
                $data['affiliate_variable'] = $options['affiliate_variable'];

                wp_localize_script($key, "site_data", $data);


            }

        }
    }

}


$update_options = get_option( "se_updater_settings" );


include 'libraries/AwesmClient/AwesmClient.php';
include 'Share.php';
include 'SocialNetworks.php';

include 'SharengineAdmin.php';
include 'Shortcodes.php';
include 'ShortcodesPHP.php';
include 'ShortcodesJS.php';
include 'Stats.php';
include 'MetaBox.php';
include 'LoginWidget.php';

include 'ImageResizer.php';
// Load the profile then pass some data to the avatar
if(!empty($update_options['activated']) && $update_options['activated'] == "Activated") {
    include 'userProfile.php';
    $userProfile = new seUserProfile();
}
include 'UserAvatar.php';


include 'AdminShortcodesDropdown.php';



include "Templater.php";
if(!empty($update_options['activated']) && $update_options['activated'] == "Activated") {
    include "ClickTo.php";
}
include "models/SharableContent.php";

$shareEngine = new ShareEngine();
$socialNetworks = new seSocialNetworks();
$share = new seShare($socialNetworks);


//inject the templater into the admin

$templater = new seTemplater();


$sharableContent = new SharableContent();

$admin = new SharengineAdmin($templater, $sharableContent);





if(!empty($update_options['activated']) && $update_options['activated'] == "Activated")
{
    $shortcodes = new seShortcodesJS();

$clickTo = new ClickTo($sharableContent);



//promo manager init

include 'promo_manager/sePromoManager.php';
$promoManager = new sePromoManager($sharableContent);

// Include the HighChartsPHP library  and inject it into stats


include 'libraries/HighChartsPHP/seHighchart.php';
include "libraries/Cache/seCacheWP.php";



$cacheWP = new seCacheWP();
$highCharts = new seHighchart();

$awesmClient = new seAwesmClient("8058019345dc96c4f792c283cbac995b83c80cfdb047c940fd7a41ea68298866", $cacheWP);
$stats = new seStats($highCharts, $awesmClient);
$metabox = new seMetaBox();

$dropdown = new seAdminShortcodesDropdown();


}



$sharableContent->getPosts();


//include "tools/seTools.php";
include 'license/Updater.php';


include "modules/integrations/loader.php";
include "modules/link_manager/loader.php";