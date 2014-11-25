<?php
/*
    Plugin Name: Instant Rotator
    Author: Sorin Nunca & Cristi Nunca
    Version: 0.1
    Description: Instant Rotator
 */

    define("NAME", "Instant Rotator");

    define("SLUG", "ir_admin");
    define("MANAGE_SLUG", "ir_campaign_manage");
    define("STATS_SLUG", "ir_campaign_stats");


    define("IR_DB_VERSION", "0.2.1" );
    define("IR_CAMPAIGN_DATABASE", "IR_CAMPAIGNS");
    define("IR_LINKS_DATABASE", "ir_links");
    define("IR_VISITORS_DATABASE", "ir_visitors");
    define("IR_CONVERSIONS_DATABASE", "ir_conversions");

    define("IR_IMAGES_URL", plugins_url('images', __FILE__).'/');
    define("IR_URL", plugin_dir_url(__FILE__));
    define("IR_PATH", plugin_dir_path(__FILE__));

    include 'libraries/ip2location/IP2Location.php';
    include "libraries/googleVisualization/googleVisualization.php";

register_activation_hook(__FILE__, array("irMain", "activation_hook"));
    class irMain
    {
        public function __construct()
        {
            add_action("init", array($this, "update_database"));


            add_action("wp_ajax_sluggify", array($this, "sluggify"));

        }

        public function sluggify()
        {
            $text = $_POST['text'];

            echo sluggify($text);
            die();
        }



        public static function activation_hook()
        {
            global $wpdb;
            $sql = "CREATE TABLE ".$wpdb->prefix.IR_CAMPAIGNS." (
          id int(20) NOT NULL AUTO_INCREMENT,
          name varchar(140) NOT NULL,
          slug varchar(140) NOT NULL,
          mode int(1),
          current_link varchar(20) DEFAULT '1',
          PRIMARY KEY  (id)
        );";
            $linksDatabase = "CREATE TABLE ".$wpdb->prefix.IR_LINKS_DATABASE." (
          id int(20) NOT NULL AUTO_INCREMENT,
          campaign_id int(20) NOT NULL,
          url varchar(500) NOT NULL,
          weight int(20),
          hits int(20) DEFAULT 0,
          max_hits int(20) DEFAULT 0,
          conversions int(20) DEFAULT 0,
          PRIMARY KEY  (id)
        );";
            $visitorsDatabase = "CREATE TABLE ".$wpdb->prefix.IR_VISITORS_DATABASE." (
          id int(20) NOT NULL AUTO_INCREMENT,
          ip varchar(200) NOT NULL,
          link_id int(20) NOT NULL,
          campaign_id int(20) NOT NULL,
          ref varchar(1000),
          country_code varchar(10) NOT NULL,
          time DATETIME NOT NULL,
          PRIMARY KEY  (id)
        );";

            $conversionsDatabase = "CREATE TABLE ".$wpdb->prefix.IR_CONVERSIONS_DATABASE." (
          id int(20) NOT NULL AUTO_INCREMENT,
          ip varchar(200) NOT NULL,
          link_id int(20) NOT NULL,
          campaign_id int(20) NOT NULL,
          PRIMARY KEY  (id)
        );";



            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

            dbDelta($sql);
            dbDelta($linksDatabase);
            dbDelta($visitorsDatabase);
            dbDelta($conversionsDatabase);

            update_option("ir_current_version", IR_DB_VERSION);
        }

        public function update_database()
        {
            $currentVersion = get_option("ir_current_version");

            if($currentVersion != IR_DB_VERSION)
            {
                // run the activation function

                self::activation_hook();
            }
        }
    }
    include "helperFunctions.php";
    include "InstantRotatorAdmin.php";
    include "RouteRequest.php";


    $irAdmin = new irAdmin();

    $irMain = new irMain();



    $irRouteRequest = new irRouteRequest();