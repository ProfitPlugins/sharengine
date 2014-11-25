<?php
    class SharengineAdmin
    {
        public function __construct(seTemplater $templater, SharableContent $sharableContent)
        {
            //load admin css
            $this->templater = $templater;
            $this->templater->setType("shareBoxVisitors");


            $this->sharableContent = $sharableContent;


            add_action("admin_enqueue_scripts", array($this, "adminLoadStyles"));

            add_action('admin_menu', array($this, "adminMenu"));


            add_action('wp_ajax_addNewField', array($this, 'addNewField'));
            add_action('wp_ajax_addNewTweet', array($this, 'addNewTweet'));
            add_action('wp_ajax_addNewShare', array($this, 'addNewShare'));

            add_action('wp_logout', array($this, 'wpLogoutRedirect'));

            add_action("wp_ajax_se_permissions", array($this,"permissionsAjax"));
        }

        public function wpLogoutRedirect()
        {


            wp_redirect(home_url());
            exit();
        }
        public function addNewField()
        {

            $data['field_nr'] = $_POST['field_nr'];
            echo $this->view('admin/addNewField', $data);

            die();
        }
        public function addNewTweet()
        {

            $data['field_nr'] = $_POST['field_nr'];
            echo $this->view('admin/addNewTweet', $data);

            die();
        }
        public function addNewShare()
        {
            $data['field_nr'] = $_POST['field_nr'];
            echo $this->view('admin/addNewShare', $data);

            die();
        }
        public function view($view, $data=array())
        {

            ob_start();
            extract($data);
            include $this->path.'views/'.$view.'.php';
            $content=ob_get_clean();

            return $content;
        }

        public function adminLoadStyles()
        {
            wp_enqueue_media();
            if(strstr($_GET['page'], "nds_sharengine") !==FALSE)
            {
                wp_register_style("se_admin_main", SE_URL.'css/admin.css');
                wp_enqueue_style("se_admin_main");

                // Load the new CSS
                wp_register_style("se_bootstrap_all", SE_URL.'css/new_admin/bootstrap.css');
                wp_enqueue_style("se_bootstrap_all");

                wp_register_style("se_font-awesome", SE_URL.'css/new_admin/font-awesome.css');
                wp_enqueue_style("se_font-awesome");

                wp_register_style("se_jquery-ui", SE_URL.'css/new_admin/jquery-ui.css');
                wp_enqueue_style("se_jquery-ui");


                    wp_register_style("se_new-style", SE_URL.'css/new_admin/style.css');
                    wp_enqueue_style("se_new-style");



                wp_register_style("se_toastr", SE_URL.'css/new_admin/toastr.css');
                wp_enqueue_style("se_toastr");

                // Load the new  JS



                wp_register_script("se_bootstrap", SE_URL.'js/new_admin/bootstrap.min.js');
                wp_enqueue_script("se_bootstrap");

                wp_register_script("se_excanvas", SE_URL.'js/new_admin/excanvas.min.js');
                wp_enqueue_script("se_excanvas");

                wp_register_script("se_flot", SE_URL.'js/new_admin/jquery.flot.js');
                wp_enqueue_script("se_flot");

                wp_register_script("se_sparkline", SE_URL.'js/new_admin/jquery.sparkline.min.js');
                wp_enqueue_script("se_sparkline");

                wp_register_script("se_jquery_ui", SE_URL.'js/new_admin/jquery-ui.min.js');
                wp_enqueue_script("se_jquery_ui");

                wp_register_script("se_admin_new", SE_URL.'js/new_admin/main.js');
                wp_enqueue_script("se_admin_new");

                wp_register_script("se_toastr", SE_URL.'js/new_admin/toastr.min.js');
                wp_enqueue_script("se_toastr");


                wp_register_script("se_admin_main", SE_URL.'js/se_admin_main.js');
                wp_enqueue_script("se_admin_main", array('se_livequery'));

                wp_register_script("se_typeahead", SE_URL.'js/typeahead.js');
                wp_enqueue_script("se_typeahead");

                wp_register_script("se_tagmanager", SE_URL.'js/tagmanager.js');
                wp_enqueue_script("se_tagmanager");

                wp_register_style("se_tagmanager", SE_URL.'css/tagmanager.css');
                wp_enqueue_style("se_tagmanager");

                wp_register_script("se_livequery", SE_URL.'js/livequery.js');
                wp_enqueue_script("se_livequery");

            }




        }
        public function adminMenu()
        {

            $options = get_option( SE_UPDATER_SETTINGS );




            if(!empty($options['activated']) && $options['activated'] == "Activated")
            {

               $page = add_menu_page( SE_NAME, SE_NAME, "manage_options", SE_SLUG, array($this, "renderAdminPage"), SE_IMAGES_URL.'icon.png' );
               $page = add_submenu_page(SE_SLUG, "Dashboard", "Dashboard", 'manage_options', SE_SLUG );
            }
            else{
                $page = add_menu_page( SE_NAME, SE_NAME, "manage_options", SE_SLUG, '', SE_IMAGES_URL.'icon.png' );
            }
        }



        public function permissionsAjax($custom_user="")
        {

            $user = $_POST['user'];

            if($custom_user)
                $user = $custom_user;


            $data['fields'] = get_option(SE_FIELDS_OPTIONS);
            $data['user_id'] = $user;


            $permissions = get_option(SE_PERMISSIONS);
            $permissions = $permissions[$user];

           // var_dump($permissions);

            foreach($data['fields'] as $k=>$v)
            {
                $default_permissions[$k] = $v['se_default'];
            }


            if(is_array($permissions) && !empty($permissions))
            {
                $data['permissions'] = $permissions;
            }
            else
            {
                $data['permissions'] = $default_permissions;
            }

            if($custom_user)
            {
                return $this->view("admin/fieldPermissions", $data);
            }
            else
            {
                echo $this->view("admin/fieldPermissions", $data);

            }

            die();
        }


        public function integrationPage()
        {
            $options = get_option( SE_OPTIONS );

            if($_POST)
            {
                $options['integrations'] = $_POST['integrations'];
                update_option(SE_OPTIONS, $options);

                //print_r($_POST);
            }
            $option = get_option( SE_UPDATER_SETTINGS );
            $data['integrations'] = $options['integrations'];
            $data['sidebar'] = $this->view('admin/sidebar');


            echo $this->view("admin/adminIntegrations", $data);
        }
        public function permissionsManagement()
        {
            if($_POST)
            {
                $user_id = $_POST['user_id'];

                $existing_fields = get_option(SE_FIELDS_OPTIONS);

                foreach($existing_fields as $k=>$efield)
                {
                    if($efield['se_enabled'])
                    {
                        if(isset($_POST['enabled'][$k]))
                        {
                            $fields[$k] = 1;
                        }
                        else
                        {
                            $fields[$k] = 0;
                        }
                    }
                }

//                $fields = $_POST['enabled'];

                $permissions = get_option(SE_PERMISSIONS);

                $permissions[$user_id] = $fields;
                update_option(SE_PERMISSIONS, $permissions);
            }
            if(!empty($user_id))
            {


                $data['user_id'] = $user_id;
                $data['loaded_content'] =  $this->permissionsAjax($user_id);
            }
            $data['sidebar'] = $this->view('admin/sidebar');
            echo $this->view("admin/adminUserManagement", $data);
        }
        public function renderAdminPage()
        {
            $page = $_GET['se_page'];

           // var_dump($this->templater->getTemplates());

            $data['templates'] = $this->templater->getTemplates();

            $data['sidebar'] = $this->view('admin/sidebar');

            switch($page)
            {
                case "nds_sharengine_integration":
                    $this->integrationPage();
                break;

                case "click_to_share":

                    $this->sharableContent->setType('facebook');
                    if($_POST)
                    {

                        $existing_tags = $_POST['hidden-se_existing_shares'];
                        $new_tags = $_POST['hidden-se_new_shares'];

                        foreach($_POST['se_new_shares'] as $new_key => $new_value)
                        {
                            $tweetID= $this->sharableContent->insertTweet($new_value['content'], $new_value['link'], $new_value['image']);
                            $current_tags = explode(',', $new_tags[$new_key]['tags'] );

                            foreach($current_tags as $k => $tag)
                            {
                                if($tag)
                                {
                                    // insert them if they dont' exist
                                    $tag_id = $this->sharableContent->insertTag($tag);
                                    // Link them to this tweet
                                    $this->sharableContent->link($tweetID, $tag_id);
                                }

                            }

                        }

                        // Update the Old Ones
                        foreach($_POST['se_existing_shares'] as $k=>$v)
                        {
                            // Existing post, just update it

                            $tweetID = $v['id'];
                            $this->sharableContent->updateTweet($v['id'], $v['content'], $v['link'], $v['image']);

                            // Remove all the existing tag links

                            $this->sharableContent->deleteLinks($tweetID);

                            // parse the new tags

                            $current_tags = explode(',', $existing_tags[$k]['tags'] );

                            foreach($current_tags as $tk => $tag)
                            {
                                if($tag)
                                {
                                    // insert them if they dont' exist
                                    $tag_id = $this->sharableContent->insertTag($tag);

                                    // Link them to this tweet
                                    $this->sharableContent->link($tweetID, $tag_id);
                                }

                            }


                        }


                    }

                    $data['se_existing_shares'] = $this->sharableContent->getPosts();



                    foreach($data['se_existing_shares'] as $k=>$tweet)
                    {
                        // var_dump($tweet);


                        $tags = $this->sharableContent->getTags($tweet['id']);

                        $tag_names = array();
                        foreach($tags as $tags_key =>$tags_value)
                        {
                            $tag_names[]=$tags_value['tag'];
                        }

                        // var_dump($tag_names);

                        $tags_list = implode($tag_names, ',');



                        //  $tags_list = "Test";

                        $data['se_existing_shares'][$k]['tags']= $tags_list;


                    }
                    // $data['se_tweets'][0]['tags']="What";

                    $last_tweet = count($data['se_existing_shares'])-1;
                    $data['fields_nr'] = $data['se_existing_shares'][$last_tweet]['id'];

                    echo $this->view("admin/adminClickToShare", $data);

                break;

                case "click_to_tweet":
                    $this->sharableContent->setType("twitter");
                    if($_POST)
                    {
                        //var_dump($_POST);
                        /*$fields = array();

                        $se_tweets = $_POST['se_tweets'];

                        update_option("se_tweets", $se_tweets);*/

                        $existing_tags = $_POST['hidden-se_existing_tweets'];
                        $new_tags = $_POST['hidden-se_new_tweets'];

                        //Insert the new Tweets
                        foreach($_POST['se_new_tweets'] as $new_key => $new_value)
                        {
                            $tweetID= $this->sharableContent->insertTweet($new_value['content'], $new_value['link']);
                            $current_tags = explode(',', $new_tags[$new_key]['tags'] );

                            foreach($current_tags as $k => $tag)
                            {
                                if($tag)
                                {
                                    // insert them if they dont' exist
                                    $tag_id = $this->sharableContent->insertTag($tag);
                                    // Link them to this tweet
                                    $this->sharableContent->link($tweetID, $tag_id);
                                }

                            }

                        }

                        // Update the Old Ones
                        foreach($_POST['se_existing_tweets'] as $k=>$v)
                        {
                            // Existing post, just update it
                            /*if($v['id'])
                            {*/
                                $tweetID = $v['id'];
                                $this->sharableContent->updateTweet($v['id'], $v['content'], $v['link']);

                            /*}*/
                            /*else
                            {
                                $tweetID= $this->sharableContent->insertTweet($v['content'], $v['link']);
                            }*/

                            // Remove all the existing tag links

                            $this->sharableContent->deleteLinks($tweetID);

                            // parse the new tags



                            $current_tags = explode(',', $existing_tags[$k]['tags'] );



                            //var_dump($current_tags);

                            foreach($current_tags as $tk => $tag)
                            {
                                if($tag)
                                {
                                    // insert them if they dont' exist
                                    $tag_id = $this->sharableContent->insertTag($tag);

                                    // Link them to this tweet
                                    $this->sharableContent->link($tweetID, $tag_id);
                                }



                            }


                        }


                    }

                   // $data['se_tweets'] = get_option('se_tweets');

                    $data['se_existing_tweets'] = $this->sharableContent->getPosts();



                    foreach($data['se_existing_tweets'] as $k=>$tweet)
                    {
                       // var_dump($tweet);


                        $tags = $this->sharableContent->getTags($tweet['id']);

                        $tag_names = array();
                        foreach($tags as $tags_key =>$tags_value)
                        {
                            $tag_names[]=$tags_value['tag'];
                        }

                       // var_dump($tag_names);

                        $tags_list = implode($tag_names, ',');



                      //  $tags_list = "Test";

                        $data['se_existing_tweets'][$k]['tags']= $tags_list;


                    }
                   // $data['se_tweets'][0]['tags']="What";

                    $last_tweet = count($data['se_existing_tweets'])-1;
                    $data['fields_nr'] = $data['se_existing_tweets'][$last_tweet]['id'];

                   // var_dump($data);
                   // var_dump($data['se_existing_tweets']);
                    echo $this->view("admin/adminClickToTweet", $data);
                break;
                case "profile_fields":

                    //get the current fields;
                    if($_POST)
                    {
                        $fields = array();


                        $se_field = $_POST['se_field'];
                        $se_description = $_POST['se_description'];

                        $se_enabled = $_POST['se_enabled'];
                        $se_default = $_POST['se_default'];


                        foreach($se_field as $k=>$v)
                        {
                            $current_data = array();
                            if(isset($se_enabled[$k]))
                            {
                                $current_data['se_enabled']=1;
                            }
                            else
                                $current_data['se_enabled']=0;

                            if(isset($se_default[$k]))
                            {
                                $current_data['se_default']=1;
                            }
                            else
                                $current_data['se_default']=0;


                            $current_data['se_field'] = $v;

                            $current_data['se_description'] = $se_description[$k];

                            $fields[]=$current_data;
                        }

                        update_option(SE_FIELDS_OPTIONS, $fields);


                    }


                    $data['fields'] = get_option(SE_FIELDS_OPTIONS);
                    if($data['fields'])
                        $data['fields_nr'] = count($data['fields']);
                    else
                        $data['fields_nr'] = 0;




                   echo $this->view('admin/adminFields', $data);
                break;

                case "custom_profile_fields":

                    $this->permissionsManagement();

                break;

                default:
                    if($_POST)
                    {
                        if(isset($_POST['enable_visitors']))
                        {
                            $_POST['enable_visitors'] = 1;
                        }
                        else
                        {
                            $_POST['enable_visitors'] = 0;
                        }
                        if(isset($_POST['enable_end']))
                        {
                            $_POST['enable_end'] = 1;
                        }
                        else
                        {
                            $_POST['enable_end'] = 0;
                        }

                        if(isset($_POST['enable_sharengine_button']))
                        {
                            $_POST['enable_sharengine_button'] = 1;
                        }
                        else
                        {
                            $_POST['enable_sharengine_button'] = 0;
                        }
                        if(isset($_POST['enable_beginning']))
                        {
                            $_POST['enable_beginning'] = 1;
                        }
                        else
                        {
                            $_POST['enable_beginning'] = 0;
                        }



                        update_option(SE_OPTIONS, $_POST);
                    }
                    $data['settings'] = get_option(SE_OPTIONS);
                    echo $this->view('admin/adminDashboard', $data);
                break;

            }







        }


    }