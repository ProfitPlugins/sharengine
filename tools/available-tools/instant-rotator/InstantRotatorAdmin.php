<?php
/**
 * Created by PhpStorm.
 * User: Sorin
 * Date: 5/20/2014
 * Time: 9:22 PM
 */

    class irAdmin
    {
        public function __construct()
        {


            add_action("admin_menu", array($this, "admin_menu"));

            add_action("admin_enqueue_scripts", array($this, "adminLoadStyles"));
        }

        public function adminLoadStyles()
        {
            wp_register_script("ir_admin", IR_URL.'js/admin.js', array("ir_typing"));
            wp_enqueue_script("ir_admin");


            wp_register_style("ir_admin", IR_URL.'css/admin.css');
            wp_enqueue_style("ir_admin");
            // plugin for the done typing event

            wp_register_script("ir_typing", IR_URL."js/jquery.typing-0.3.0.js");
            wp_enqueue_script("ir_typing");
        }

        public function admin_menu()
        {

            add_menu_page(NAME, NAME, "manage_options", SLUG, array($this, "admin_page_content"));
        }

        public function admin_stats_page()
        {
            global $wpdb;
            // Get the data for this campaign

            $campaign_id = $_GET['id'];


            $data['campaign'] = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".$wpdb->prefix.IR_CAMPAIGN_DATABASE." WHERE id='%d'", $campaign_id), "ARRAY_A");

            $data['links']= $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix.IR_LINKS_DATABASE." WHERE campaign_id='%d'", $campaign_id), "ARRAY_A");





            $v = new Google_Visualization("Table_Format");
            $c = new Google_Config("ColumnChart");
            $c->setProperty("width", "100%");
            $c->setProperty("height", "100%");

            // data
            $o = Google_Data::getInstance()->getDataObject();



            $o->addColumn("0","Visitors Chart","string");
            $o->addColumn("1","Unique","number");
            $o->addColumn("1","Hits","number");


            $campaignHits = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM ".$wpdb->prefix.IR_VISITORS_DATABASE." WHERE campaign_id='%d'", $campaign_id));
            $campaignUnique = $wpdb->get_var($wpdb->prepare("SELECT COUNT(DISTINCT ip) FROM ".$wpdb->prefix.IR_VISITORS_DATABASE." WHERE campaign_id='%d'", $campaign_id));

            // get the top 5 referrers

            $data['topRefs'] = $wpdb->get_results($wpdb->prepare("SELECT ref, count(ref) as total_count from ".$wpdb->prefix.IR_VISITORS_DATABASE." WHERE campaign_id='%d' GROUP BY ref ORDER BY total_count DESC LIMIT 5", $campaign_id), "ARRAY_A");
            $o->addNewRow();
            $o->addStringCellToRow("Visitors Chart");
            $o->addNumberCellToRow($campaignUnique, $campaignUnique);
            $o->addNumberCellToRow($campaignHits, "$campaignHits");

            $v->setConfig($c);
            $v->setData($o);

            $data['visitorsChart'] = $v->render();



            //Countries Chart
            $countries = $wpdb->get_results($wpdb->prepare("SELECT country_code, count(country_code) as total_count from ".$wpdb->prefix.IR_VISITORS_DATABASE." WHERE campaign_id='%d' GROUP BY country_code ORDER BY total_count DESC", $campaign_id), "ARRAY_A");

            $v = new Google_Visualization("Table_Format");
            $c = new Google_Config("GeoMap");
            $c->setProperty("width", "100%");
            $c->setProperty("height", "100%");

            // data
            $o = Google_Data::getInstance()->getDataObject();


            $o->addColumn("1","Country","string");
            $o->addColumn("1","Hits","number");

            foreach($countries as $country)
            {
                $o->addNewRow();
                $o->addStringCellToRow($country['country_code'], $country['country_code']);
                $o->addNumberCellToRow($country['total_count'], $country['total_count']);
            }


//            $o->addNewRow();
//            $o->addStringCellToRow("RO", "RO");
//            $o->addNumberCellToRow(188, "2");

            $v->setConfig($c);
            $v->setData($o);


            $data['countriesGraph'] = $v->render();


            // get the hits data by hour today
            $data['hours'] = $wpdb->get_results($wpdb->prepare("SELECT COUNT(id) as count, HOUR(time) as hour from ".$wpdb->prefix.IR_VISITORS_DATABASE." WHERE campaign_id='%d' GROUP BY hour ORDER BY count DESC LIMIT 5", $campaign_id), "ARRAY_A");


            foreach($data['links'] as $link)
            {
                $id = $link['id'];
                $data['link_stats'][$id]['hits'] = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM ".$wpdb->prefix.IR_VISITORS_DATABASE." WHERE campaign_id='%d' AND link_id='%d'", $campaign_id, $id));
                //var_dump()
                if(empty($data['link_stats'][$id]['hits']))
                    $data['link_stats'][$id]['hits'] = 0;

                $data['link_stats'][$id]['unique'] = $wpdb->get_var($wpdb->prepare("SELECT COUNT(DISTINCT ip) FROM ".$wpdb->prefix.IR_VISITORS_DATABASE." WHERE campaign_id='%d' AND link_id='%d'", $campaign_id, $id));
                if(empty($data['link_stats'][$id]['unique']))
                    $data['link_stats'][$id]['unique'] = 0;
            }

            echo load_view("admin/adminStats", $data);
        }

        public function admin_page_content()
        {
            if($_GET['sub_page'] ==MANAGE_SLUG)
            {
                $this->admin_page_manage();
            }
            else
            {
                if($_GET['sub_page'] ==STATS_SLUG)
                {
                   $this->admin_stats_page();
                }
                else
                {
                    $this->admin_page_dashboard();
                }

            }
        }

        public function admin_page_manage()
        {

            global $wpdb;
            // Get the data for this campaign

            $campaign_id = $_GET['id'];

            if($_POST['update_chances'])
            {
                foreach($_POST['chances'] as $k=>$chance)
                {
                    $data = array();
                    $where = array();

                    $data['weight'] = (int) $chance;
                    $where['campaign_id'] = $campaign_id;
                    $where['id'] = $k;

                    $wpdb->update($wpdb->prefix.IR_LINKS_DATABASE, $data, $where);


                }
                // update the max hits
                foreach($_POST['max_hits'] as $k=>$hits)
                {
                    $data = array();
                    $where = array();

                    $data['max_hits'] = (int) $hits;
                    $where['campaign_id'] = $campaign_id;
                    $where['id'] = $k;

                    $wpdb->update($wpdb->prefix.IR_LINKS_DATABASE, $data, $where);
                }
                echo '<div class="updated" style="width:99%; padding: 5px;"><p>Chances Updated!</p></div>';
            }
            if($_POST['update_mode'])
            {


                $where['id'] = $_POST['campaign_id'];

                $data['mode'] = $_POST['mode'];

                $wpdb->update($wpdb->prefix.IR_CAMPAIGN_DATABASE, $data, $where);
            }
            if($_POST['delete'])
            {
                $where['id'] = $_POST['delete_link'];

                $wpdb->delete($wpdb->prefix.IR_LINKS_DATABASE, $where);

                echo '<div class="updated" style="width:99%; padding: 5px;"><p>The link has been deleted</p></div>';

            }



            //var_dump($data['links']);
            // if we received a new link
            if($_POST['bulk_import'])
            {
                $insert = array();
                $import = $_POST['bulk_import'];

                $ex = explode("\n", $import);

                foreach($ex as $line)
                {
                    // if there's text on this line
                    if(trim($line)!='')
                    {
                        $link_data = explode(',', $line);

                        // if we have a url
                        if(trim($link_data[0])!='')
                        {
                            $insert['url'] = trim($link_data[0]);
                            $insert['campaign_id'] = $campaign_id;

                            if(isset($link_data[1]) && is_numeric($link_data[1]))
                            {
                                $insert['weight']= trim($link_data[1]);
                            }
                            else
                            {
                                $insert['weight']= 1;
                            }
                            // max hits
                            if(isset($link_data[2]) && is_numeric($link_data[2]))
                            {
                                $insert['max_hits']= trim($link_data[2]);
                            }
                            else
                            {
                                $insert['max_hits']= 0;
                            }

                            $wpdb->insert($wpdb->prefix.IR_LINKS_DATABASE, $insert);

                        }

                    }
                }
                echo '<div class="updated" style="width:99%; padding: 5px;"><p>The links have been inserted</p></div>';

            }
            if($_POST['url'])
            {
                $insert['url']= $_POST['url'];
                $insert['campaign_id'] = $campaign_id;
                $insert['weight']= 1;

                $wpdb->insert($wpdb->prefix.IR_LINKS_DATABASE, $insert);



                echo '<div class="updated" style="width:99%; padding: 5px;"><p>The link has been inserted</p></div>';

            }

            $data['campaign'] = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".$wpdb->prefix.IR_CAMPAIGN_DATABASE." WHERE id='%d'", $campaign_id), "ARRAY_A");

            $data['links']= $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix.IR_LINKS_DATABASE." WHERE campaign_id='%d'", $campaign_id), "ARRAY_A");

            foreach($data['links'] as $link)
            {
                $id = $link['id'];
                $data['link_stats'][$id]['hits'] = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM ".$wpdb->prefix.IR_VISITORS_DATABASE." WHERE campaign_id='%d' AND link_id='%d'", $campaign_id, $id));
               //var_dump()
                if(empty($data['link_stats'][$id]['hits']))
                    $data['link_stats'][$id]['hits'] = 0;

                $data['link_stats'][$id]['unique'] = $wpdb->get_var($wpdb->prepare("SELECT COUNT(DISTINCT ip) FROM ".$wpdb->prefix.IR_VISITORS_DATABASE." WHERE campaign_id='%d' AND link_id='%d'", $campaign_id, $id));
                if(empty($data['link_stats'][$id]['unique']))
                    $data['link_stats'][$id]['unique'] = 0;
            }

            echo load_view("admin/adminManage", $data);

        }
        public function admin_page_dashboard()
        {

            global $wpdb;

            if($_POST['submit'])
            {

                if(!empty($_POST['campaign_name']) && !empty($_POST['campaign_url']))
                {
                    $campaign_name = $_POST['campaign_name'];

                    $data['name'] = $campaign_name;
                    $data['slug'] = sluggify($_POST['campaign_url']);

                    // Random mode
                    $data['mode'] = 2;
                    $same_campaign = $wpdb->get_var( "SELECT COUNT(*) FROM ".$wpdb->prefix.IR_CAMPAIGN_DATABASE." WHERE name='{$campaign_name}'" );
                    $same_slug = $wpdb->get_var( "SELECT COUNT(*) FROM ".$wpdb->prefix.IR_CAMPAIGN_DATABASE." WHERE slug='{$data['slug']}'" );
                    if($same_campaign==0 && $same_slug == 0)
                    {
                        $wpdb->insert($wpdb->prefix.IR_CAMPAIGN_DATABASE, $data);
                        echo '<div class="updated" style="width:99%; padding: 5px;"><p>The campaign has been inserted</p></div>';
                    }
                    else
                    {
                        echo '<div class="error" style="width:99%; padding: 5px;"><p>Another campaign with the same name/slug exists</p></div>';
                    }
                }
                else
                {
                    echo '<div class="error" style="width:99%; padding: 5px;"><p>You must fill in the fields.</p></div>';
                }


            }
            if($_POST['delete'])
            {
                $data['id'] = $_POST['delete_id'];

                $wpdb->delete($wpdb->prefix.IR_CAMPAIGN_DATABASE, $data);
                //@TODO: add code to delete the links too
                echo '<div class="updated" style="width:99%; padding: 5px;"><p>The campaign has been deleted</p></div>';
            }

            // Retrieve the campaigns
            $view_data['campaigns'] = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix.IR_CAMPAIGN_DATABASE, "ARRAY_A");

            echo load_view("admin/adminDashboard", $view_data);
        }
    }

