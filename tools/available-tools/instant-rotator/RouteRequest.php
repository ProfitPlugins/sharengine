<?php
    class irRouteRequest
    {
        public function __construct()
        {
             add_action("template_redirect", array($this, "template_redirect"));

            add_action("template_redirect", array($this, "trackConversion"));
        }
        public function trackConversion()
        {
            if(isset($_GET['tracking_campaign']) && !empty($_GET['tracking_campaign']))
            {
                global $wpdb;
                $campaign_id = $_GET['tracking_campaign'];


                // generate a 1p x 1px gif transparent image


                // removing any content encoding like gzip etc.
                header('Content-encoding: none', true);

                //check to ses if request is a POST
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // the GIF should not be POSTed to, so do nothing...
                    echo ' ';
                } else {
                    // return 1x1 pixel transparent gif
                    header("Content-type: image/gif");
                    // needed to avoid cache time on browser side
                    header("Content-Length: 42");
                    header("Cache-Control: private, no-cache, no-cache=Set-Cookie, proxy-revalidate");
                    header("Expires: Wed, 11 Jan 2000 12:59:00 GMT");
                    header("Last-Modified: Wed, 11 Jan 2006 12:59:00 GMT");
                    header("Pragma: no-cache");

                    echo sprintf('%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%',71,73,70,56,57,97,1,0,1,0,128,255,0,192,192,192,0,0,0,33,249,4,1,0,0,0,0,44,0,0,0,0,1,0,1,0,0,2,2,68,1,0,59);

                    $cookie = stripslashes($_COOKIE['ir_tracker']);

                    if(!empty($cookie))
                    {

                        $cookie = json_decode($cookie, true);

                        $campaign_id = $cookie['campaign_id'];
                        $link_id = $cookie['link_id'];

                        $ip = $_SERVER['REMOTE_ADDR'];

                        $check = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM ".$wpdb->prefix.IR_CONVERSIONS_DATABASE." WHERE campaign_id='%d' AND link_id='%d'", $campaign_id, $link_id));

                        // if we didn't count this conversion before
                        if($check==0)
                        {
                            // insert it
                            $data['campaign_id'] = $campaign_id;
                            $data['link_id'] = $link_id;
                            $data['ip'] = $_SERVER['REMOTE_ADDR'];

                            $wpdb->insert($wpdb->prefix.IR_CONVERSIONS_DATABASE, $data);

                            $link = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".$wpdb->prefix.IR_LINKS_DATABASE." WHERE id='%d'", $link_id));

                            $update['conversions'] = $link->conversions+1;
                            $update_where['id'] = $link_id;

                            $wpdb->update($wpdb->prefix.IR_LINKS_DATABASE, $update, $update_where);

                        }

                    }
                }
                die();
            }
        }
        public function template_redirect()
        {
            global $wpdb;
            $request_uri = $_SERVER['REQUEST_URI'];

            $ex = explode('/', $request_uri);

            $slug = $ex[count($ex)-1];

            $ip = $_SERVER['REMOTE_ADDR'];

            // if we find the slug in the database
            $campaign = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".$wpdb->prefix.IR_CAMPAIGN_DATABASE." WHERE slug='%s'", $slug), "ARRAY_A");

            if(isset($campaign['id']) && !empty($campaign['id']))
            {
                // we found a valid campaign ID, we need to determine which link to redirect to.

                $links = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix.IR_LINKS_DATABASE." WHERE campaign_id='%d' AND( max_hits='0' OR hits<max_hits)", $campaign['id']), "ARRAY_A");

                //
                foreach($links as $link)
                {
                    $links_with_weights[$link['id']] = $link['weight'];
                }


                // Sequential
                if($campaign['mode'] == 1)
                {
                    $link_id=get_sequential_with_weight($links_with_weights, $campaign['current_link']);

                    $link = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix.IR_LINKS_DATABASE." WHERE id='{$link_id}'");

                    // increase the current link
                    $new_link = $campaign['current_link']+1;
                    if($new_link>array_sum($links_with_weights))
                        $new_link = 1;

                    $wpdb->update($wpdb->prefix.IR_CAMPAIGN_DATABASE, array("current_link"=>$new_link), array("id"=>$campaign['id']));

                }
                else
                {
                    // random with weights

                    $link_id = get_random_with_weight($links_with_weights);

                     // extract the link

                    $link = $wpdb->get_row("SELECT url FROM ".$wpdb->prefix.IR_LINKS_DATABASE." WHERE id='{$link_id}'");


                }


                $visitor['ip'] = $_SERVER['REMOTE_ADDR'];
                $visitor['link_id'] = $link_id;
                $visitor['campaign_id'] = $campaign['id'];
                $visitor['ref'] = $_SERVER['HTTP_REFERER'];


                $gi = geoip_open(IR_PATH."libraries/ip2location/GeoIP.dat", GEOIP_STANDARD);



                $visitor['country_code'] = geoip_country_code_by_addr($gi, $ip);
                $visitor['time'] = date('Y-m-d H:i:s');

                // log the visit

                $wpdb->insert($wpdb->prefix.IR_VISITORS_DATABASE, $visitor);


                // update the link hits

                $updated_link_where['id'] = $link_id;
                $updated_link_data['hits'] = $link->hits+1;
                // Redirect to $link

                $wpdb->update($wpdb->prefix.IR_LINKS_DATABASE, $updated_link_data, $updated_link_where);


                // set a cookie for this link

                $cookie['link_id'] = $link_id;
                $cookie['campaign_id'] = $campaign['id'];

                $data = json_encode($cookie, true);

                setcookie('ir_tracker', $data, time()+60*60*24*30, '/');

                header("Location: {$link->url}");

                die();
            }


        }


    }