<?php
    define("SE_UPDATER_SETTINGS", "se_updater_settings");
    define("SE_UPGRADE_URL", "http://sharengine.com/");
    define("SE_UPDATER_VERSION", "1.5");

    class seUpdater
    {
        public $upgrade_url = SE_UPGRADE_URL;
        public $version = '1.5';
        public $share_engine_version_name = 'plugin_share_engine_version';
        public $plugin_url;



        public function __construct(seInstanceGenerator $instanceGenerator, seKeyManager $seKeyManager)
        {
            $this->seInstanceGenerator = $instanceGenerator;
            $this->seKeyManager = $seKeyManager;



            register_activation_hook(SE_PATH."Sharengine.php", array($this, "activation"));

            register_deactivation_hook( SE_PATH."Sharengine.php", array( $this, 'deactivation' ) );


            add_action("admin_menu", array($this, "menuPage"));

            $this->loadPluginSelfUpdater();

        }

        public function loadPluginSelfUpdater()
        {
            $options = get_option(SE_UPDATER_SETTINGS);

            $upgrade_url = SE_UPGRADE_URL; // URL to access the Update API Manager.
            $plugin_name = untrailingslashit( SE_UPDATE_SLUG ); // same as plugin slug. if a theme use a theme name like 'twentyeleven'
            $product_id = $options['product_id']; // Software Title
            $api_key = $options['api_key']; // API License Key
            $activation_email = $options['email']; // License Email
            $renew_license_url = 'https://sharengine.com/my-account'; // URL to renew a license
            $instance = $options['instance']; // Instance ID (unique to each blog activation)
            $domain = site_url(); // blog domain name
            $software_version = SE_UPDATER_VERSION; // The software version
            $plugin_or_theme = 'plugin'; // 'theme' or 'plugin'
            // $this->text_domain is used to defined localization for translation

            $psu = new pluginSelfUpdater( $upgrade_url, $plugin_name, $product_id, $api_key, $activation_email, $renew_license_url, $instance, $domain, $software_version, $plugin_or_theme, $this->text_domain );

        }

        public function menuPage()
        {
            $options = get_option(SE_UPDATER_SETTINGS);



            if(!isset($options['activated']) || $options['activated'] == "Deactivated")
            {
                $page = add_submenu_page(SE_SLUG, "License", "License", 'manage_options', SE_SLUG, array($this, "loadMenuPage") );
            }
        }
        public function loadMenuPage()
        {
            $data['success'] ='';
            $data['error'] = '';
            if($_POST)
            {
                $activation_email = trim($_POST['activation_email']);
                $api_key = trim($_POST['api_key']);

                $args = array(
                    'email' => $activation_email,
                    'licence_key' => $api_key,
                );
                $activate_results = $this->seKeyManager->activate( $args );





                $activate_results = json_decode($activate_results, true);

                if ( $activate_results['activated'] == true ) {

                    $globalOptions = get_option(SE_UPDATER_SETTINGS);
                    $globalOptions['activated'] = "Activated";
                    $globalOptions['api_key'] = $api_key;
                    $globalOptions['email'] =$activation_email;
                    $data['success'] = "The license key has been activated!";

                    update_option(SE_UPDATER_SETTINGS, $globalOptions);
                }

                if ( $activate_results == false ) {
                   /* $options['api_key'] = '';
                    $options['activation_email'] = '';
                    update_option( 'share_engine_activated', 'Deactivated' );*/


                    $globalOptions = get_option(SE_UPDATER_SETTINGS);
                    $globalOptions['activated'] = "Deactivated";
                    $globalOptions['api_key'] ="";
                    $globalOptions['email'] ="";
                    $data['error'] = "We could not contact the licensing server. Please try again later!";

                    update_option(SE_UPDATER_SETTINGS, $globalOptions);

                }
                if(isset($activate_results['code']))
                {
                    $globalOptions = get_option(SE_UPDATER_SETTINGS);
                    $globalOptions['activated'] = "Deactivated";
                    $globalOptions['api_key'] ="";
                    $globalOptions['email'] ="";
                    $data['error'] = $activate_results['error'] . "<br/>".$activate_results['additional_info'];

                    update_option(SE_UPDATER_SETTINGS, $globalOptions);
                }







            }
            $data['settings']=get_option(SE_UPDATER_SETTINGS);
            if($data['settings']['api_key'] =='' && $data['success'] !='')
            {
                $activation_email = trim($_POST['activation_email']);
                $api_key = trim($_POST['api_key']);

                $data['settings']['api_key'] = $api_key;
                $data['settings']['email'] = $activation_email;
            }
            echo $this->loadView("licenseView", $data);
        }

        public function loadView($view, $data = array())
        {

            ob_start();
            extract($data);
            include $view.'.php';
            $content=ob_get_clean();

            return $content;
        }

        public function activation()
        {
            // Configure the product ID in here
            $globalOptions = array(
                "api_key"=> "",
                "email"=>"",
                "product_id" => "Sharengine",  // The product Title in Woocommerce
                "deactivate_checkbox" => "false",
                "activated" => "Deactivated"

            );
            $globalOptions['instance'] = $this->seInstanceGenerator->generate(12, false);



            // Check if the options are already set
            $oldOptions = get_option(SE_UPDATER_SETTINGS);

            $curr_ver = $oldOptions['version'];

            if(!$curr_ver)
                $curr_ver = 0;
            // checks if the current plugin version is lower than the version being installed
            if ( version_compare( $this->version, $curr_ver, '>' ) ) {
                // update the version
                $globalOptions['version'] =$this->version;
                //update_option( $this->share_engine_version_name, $this->version );
            }

            update_option(SE_UPDATER_SETTINGS, $globalOptions);
        }

        public function deactivation()
        {
            // deactivate the license
            $this->deactivateLicense();
            // Delete the option
            global $wpdb, $blog_id;


            if ( is_multisite() )
            {

                switch_to_blog( $blog_id );
                delete_option(SE_UPDATER_SETTINGS );
                restore_current_blog();
            }
            else
            {
                  delete_option(SE_UPDATER_SETTINGS );

            }

        }

        private function deactivateLicense()
        {
            $options = get_option(SE_UPDATER_SETTINGS);

           // var_dump($options);

            $args['email'] = $options['email'];
            $args['licence_key']= $options['api_key'];



            /*if($args['email'] && $args['license_key'] && $options['activated'] == "Activated")
            {*/
                $this->seKeyManager->deactivate($args);
           /* }*/
        }

    }
    include "pluginSelfUpdater.php";
    include "keyManager.php";
    include "instanceGenerator.php";

    $instanceGenerator  = new seInstanceGenerator();
    $keyManager = new seKeyManager();

    $updater = new seUpdater($instanceGenerator, $keyManager);