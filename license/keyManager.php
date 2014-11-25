<?php
    class seKeyManager
    {

        public function __construct()
        {

        }
        public function create_software_api_url( $args ) {


            $api_url = add_query_arg( 'wc-api', 'am-software-api',SE_UPGRADE_URL );

            return $api_url . '&' . http_build_query( $args );
        }
        public function activate($args)
        {
            $options = get_option(SE_UPDATER_SETTINGS);


            $platform = site_url();

            $defaults = array(
                'request' => 'activation',
                'product_id' => $options['product_id'],
                'instance' => $options['instance'],
                'platform' => $platform,
                'software_version'  =>SE_UPDATER_VERSION
            );

          //  var_dump($defaults);

            $args = wp_parse_args( $defaults, $args );

            $target_url = self::create_software_api_url( $args );

           // var_dump($target_url);
           // var_dump($target_url);

            //wp_die($target_url);

            $request = wp_remote_get( $target_url );




            if( is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) != 200 ) {
                // Request failed
                return false;
            }

            $response = wp_remote_retrieve_body( $request );

            return $response;
        }
        public function deactivate($args)
        {
            $options = get_option(SE_UPDATER_SETTINGS);


            $platform = site_url();

            $defaults = array(
                'request' => 'deactivation',
                'product_id' => $options['product_id'],
                'instance' => $options['instance'],
                'platform' => $platform,
                'software_version'  =>SE_UPDATER_VERSION
            );
            $args = wp_parse_args( $defaults, $args );

            $target_url = self::create_software_api_url( $args );
           // wp_die(var_dump($target_url));
           // wp_die($target_url);

            $request = wp_remote_get( $target_url );

            if( is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) != 200 ) {
                // Request failed
                return false;
            }

            $response = wp_remote_retrieve_body( $request );

            return $response;
        }
        public  function check($args)
        {
           // $product_id = get_option( 'share_engine_product_id' );
            $options = get_option(SE_UPDATER_SETTINGS);


            $platform = site_url();


            $defaults = array(
                'request'     => 'check',
                'product_id' => $options['product_id'],
            );

            $args = wp_parse_args( $defaults, $args );

            $target_url = self::create_software_api_url( $args );

            $request = wp_remote_get( $target_url );

            if( is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) != 200 ) {
                // Request failed
                return false;
            }

            $response = wp_remote_retrieve_body( $request );

            return $response;
        }
    }
?>