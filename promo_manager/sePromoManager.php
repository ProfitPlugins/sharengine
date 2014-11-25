<?php
    include "sePromoTable.php";
    class sePromoManager
    {
        /*
         * Stores an array of services
         */
        public $services;

        public function __construct($sharableContent)
        {

            //load the services

            $this->services = apply_filters("se_services", $this->services);
            $this->sharableContent = $sharableContent;


            add_action("admin_menu", array($this, 'adminMenu'));


            // ajax actions

            add_action("wp_ajax_deletePromotion", array($this, "ajaxDeletePromotion"));
            add_action("wp_ajax_ajaxFilterPromotions", array($this,"ajaxFrontEndPage"));

            add_shortcode("se_promos_page", array($this, "frontEndPageShortcode"));

        }

        public function adminMenu()
        {
            $options = get_option( SE_UPDATER_SETTINGS );




            if(!empty($options['activated']) && $options['activated'] == "Activated")
            {
                $page = add_submenu_page(SE_SLUG, ' Promotions Manager', 'Promotions Manager', 'manage_options', SE_PROMO_SLUG, array($this, 'adminPage'));

                add_action("admin_print_styles-{$page}", array($this, "adminPageScripts"));

                // FrontEnd Page for the user

                $userStatsPage = add_users_page("Sharengine Promotions", "Sharengine Promos", "read",SE_SLUG."_user_promotions", array($this, "frontEndPage"));
                add_action('admin_print_styles-'.$userStatsPage, array($this, "frontEndPageScripts") );
            }

        }
        public function frontEndPageShortcode()
        {
            wp_register_style("se_click_to", SE_URL."css/front_end/sharable.css");
            wp_enqueue_style("se_click_to");

            wp_register_script("se_tagmanager", SE_URL.'js/tagmanager.js', array('jquery'));
            wp_enqueue_script("se_tagmanager");

            if( is_user_logged_in())
            {
                $this->frontEndPageScripts();
                ob_start();
                $this->frontEndPage();
                $content=ob_get_clean();

                $content = str_replace('<h1>Sharengine Promotions</h1>','', $content);

                return $content;
            }
            else
            {
                return "You must be logged in before accesing this page.";
            }


        }
        public function frontEndPage()
        {
            /*$data['se_tweets']= $this->sharableContent->getPosts();

            foreach($data['se_tweets'] as $tweet)
            {
                $data['se_tags'][$tweet['id']] = $this->sharableContent->getTags($tweet['id']);
            }*/

            // prepare the data
            $data['promotions'] = $this->sharableContent->getPromotions();

            foreach($data['promotions'] as $key=>$promotion)
            {
                $data['services'][$promotion['id']] = $this->sharableContent->getServices($promotion['id']);
            }



            echo $this->view("promo_manager/frontEndPage", $data);
        }
        public function ajaxFrontEndPage()
        {
            $tags = $_POST['tags'];

            if($tags)
            {
                $tags_array = explode(',',$_POST['tags']);

                $tags_ids = array();
                foreach($tags_array as $tag)
                {
                    $tags_ids[] = $this->sharableContent->tagNameToId($tag);
                }
                // @TODO: refactor this ASAP
                if(!empty($tags_ids)) {
                    $data['promotions'] = $this->sharableContent->getPromotions($tags_ids);
                }
            }
            else
            {
                $data['promotions'] = $this->sharableContent->getPromotions();
            }

            foreach($data['promotions'] as $key=>$promotion)
            {
                $data['services'][$promotion['id']] = $this->sharableContent->getServices($promotion['id']);
            }

            $data['ajax'] = 1;
            echo $this->view("promo_manager/frontEndPage", $data);
            die();
        }
        public function adminPagePromotionManager()
        {
            if($_POST)
            {
                $promo_id  = $_GET['manage'];
                $to_insert  = $_POST['to_insert'];
                $to_update = $_POST['to_update'];
                $enabled = $_POST['enabled'];

                //Insert the newly enabled fields
                foreach($to_insert as $ikey=>$iservice)
                {
                    if($enabled[$ikey])
                    {
                        $is_enabled = 1;
                    }
                    else
                    {
                        $is_enabled = 0;
                    }

                    $this->sharableContent->insertService($promo_id, $iservice, $ikey,  $is_enabled);
                }
                foreach($to_update as $key=>$service)
                {
                    $fields = array();
                    if($enabled[$key])
                    {
                        $is_enabled = 1;
                    }
                    else
                    {
                        $is_enabled = 0;
                    }
                    $fields['type']= $key;
                    $fields['content']= serialize($service);
                    $fields['enabled'] = $is_enabled;
                    $this->sharableContent->updateService($service['id'], $fields);
                }
            }
            $id = $_GET['manage'];

            $promotion = $this->sharableContent->getPromotion($id);

            $data['name'] = $promotion['name'];
            $data['sidebar'] = $this->view('admin/sidebar');

            $data['services']=$this->services;
            $data['existing_services'] = $this->sharableContent->getServices($id);
            echo $this->view('promo_manager/managePromotion', $data);
        }
        public function adminPage()
        {

            if($_GET['manage'])
            {
                $this->adminPagePromotionManager();

            }
            else
            {
                if ($_POST) {
                    $this->adminPagePost();
                }
                if ($_GET['add_new']) {
                    $this->adminPageAddNew();
                }

                // Load the needed data and display the admin page
                $data['sidebar'] = $this->view('admin/sidebar');
                $promotions = $this->sharableContent->getPromotions();

                foreach ($promotions as $key => $promotion) {
                    $promotions[$key]['tags'] = $this->sharableContent->getTags($promotion['id']);
                }

                require_once(ABSPATH . 'wp-admin/includes/template.php' );
                $this->sePromoTable = new sePromoTable();

                $this->sePromoTable->setData($promotions);
                $this->sePromoTable->prepare_items();


                ob_start();
                $this->sePromoTable->display();
                $data['table'] = ob_get_clean();
                echo $this->view('promo_manager/adminPage', $data);
            }


        }

        public function adminPagePost()
        {
            $promotion_name = $_POST['promotion_name'];
            $promotion_tags = $_POST['hidden-promotion_tags'];

            $success = $this->sharableContent->insertPromotion($promotion_name, $promotion_tags);

            if ($success) {
                echo '<div id="message" class="updated">
                  <p>
                    Promotion inserted!
                  </p>
                </div>';
            }
        }

        public function adminPageAddNew()
        {
            echo "add_new_page";
        }

        // sePromoManager admin page

        public function adminPageScripts()
        {
            wp_register_style("se_bootstrap_modal", SE_URL . "css/bootstrap_modal.css");
            wp_enqueue_style("se_bootstrap_modal");

            wp_register_script("se_bootstrap", SE_URL . "js/bootstrap_modal.js");
            wp_enqueue_script("se_bootstrap");

            wp_register_script("se_promo_manager", SE_URL . "js/se_promo_manager.js", array('se_checkboxtoggle'));
            wp_enqueue_script("se_promo_manager");

            wp_register_style("se_checkboxtoggle", SE_URL . "css/checkboxtoggle.css");
            wp_enqueue_style("se_checkboxtoggle");

            wp_register_script("se_checkboxtoggle", SE_URL . "js/checkboxtoggle.js", array('jquery'));
            wp_enqueue_script("se_checkboxtoggle");




        }
        public function frontEndPageScripts()
        {
            wp_register_style("se_admin_stats", SE_URL."css/admin_stats.css");
            wp_enqueue_style("se_admin_stats");

            wp_register_style("se_tagmanger", SE_URL."css/tagmanager.css");
            wp_enqueue_style("se_tagmanger");

            wp_register_style("se_click_to", SE_URL."css/front_end/sharable.css");
            wp_enqueue_style("se_click_to");

            wp_register_script("se_promo_manager_frontend", SE_URL . "js/se_promo_manager_frontend.js", array('jquery'));
            wp_enqueue_script("se_promo_manager_frontend");

            // @TODO: Refactor This ASAP

            wp_register_script("ShortcodesJS", SE_URL."js/ShortcodesJS.js", array('jquery', 'seCookies'));
            wp_enqueue_script("ShortcodesJS");
            $options = get_option("SE_OPTIONS");
            global $current_user;

            $data['affiliate_variable'] = $options['affiliate_variable'];

            $data['user_id'] =get_current_user_id();
            //
            $data['site_name'] =get_bloginfo('url');
            $data['username'] = $current_user->user_login;
            $data['site_url']=site_url();
            $data['affiliate_variable'] = $options['affiliate_variable'];

            wp_localize_script("ShortcodesJS", "site_data", $data);

            wp_register_script("seCookies", SE_URL."js/seCookies.js", array('jquery'));
            wp_enqueue_script("seCookies");
        }


        // Helper functions to load the views for the sePromoManager Class & for the components
        public function view($view, $data = array())
        {

            ob_start();
            extract($data);
            include SE_PATH . 'views/' . $view . '.php';
            $content = ob_get_clean();

            return $content;
        }



        //Ajax actions

        public function ajaxDeletePromotion()
        {
            $id = $_POST['id'];

            $this->sharableContent->deletePromotion($id);


        }
    }


    // include the services
    include "services/twitter/seTwitterService.php";
    include "services/pinterest/sePinterestService.php";
    include "services/facebook-image/seFacebookImageService.php";
    $seTwitterService = new seTwitterService();
    $sePinterestService = new sePinterestService();
    $seFacebookImageService = new seFacebookImageService();