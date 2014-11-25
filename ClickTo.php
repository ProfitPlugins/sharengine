<?php

    class ClickTo
    {

        public function __construct($sharableContent)
        {
            $this->sharableContent = $sharableContent;
            add_action("admin_menu", array($this, "loadMenu"));


            add_action('wp_ajax_filterSharable', array($this, 'filterSharable'));
            add_action('wp_ajax_filterSharableFacebook', array($this, 'filterSharableFacebook'));


            add_shortcode("se_tweet_page", array($this, "clickToTweetFrontend"));


        }
        public function clickToTweetFrontend()
        {
            wp_register_style("se_tagmanger", SE_URL."css/tagmanager.css");
            wp_enqueue_style("se_tagmanger");

            wp_register_style("se_click_to", SE_URL."css/front_end/sharable.css");
            wp_enqueue_style("se_click_to");

            if( is_user_logged_in())
            {
                $this->clickToStyle();
                ob_start();
                $this->loadClickToPage();
                $content=ob_get_clean();

                $content = str_replace('<h1>Sharengine Click To Tweet</h1>','', $content);

                return $content;
            }
            else
            {
                return "You must be logged in before accesing this page.";
            }

        }
        public function filterSharable()
        {
           // var_dump($_POST);

            $original_tags = $_POST['tags'];
            $tags = explode(',',$original_tags);
            if($original_tags)
            {
                foreach($tags as $tag)
                {
                    $tags_array[] = $this->sharableContent->tagNameToID($tag);

                }
            }
            else
            {
                $tags_array="";
            }
            $tweets = $this->sharableContent->getPosts($tags_array);
            $data['se_tweets'] = $tweets;
            foreach($data['se_tweets'] as $tweet)
            {

                $data['se_tags'][$tweet['id']]=$this->sharableContent->getTags($tweet['id']);
            }
            //var_dump($data['se_tags']);
           // $data['se_tags'] = $tags;
            echo $this->view("admin/clickToAjax", $data);
            die();

        }
        public function filterSharableFacebook()
        {
            // var_dump($_POST);

            $this->sharableContent->setType('facebook');

            $original_tags = $_POST['tags'];
            $tags = explode(',',$original_tags);
            if($original_tags)
            {
                foreach($tags as $tag)
                {
                    $tags_array[] = $this->sharableContent->tagNameToID($tag);

                }
            }
            else
            {
                $tags_array="";
            }
            $tweets = $this->sharableContent->getPosts($tags_array);
            $data['se_tweets'] = $tweets;
            foreach($data['se_tweets'] as $tweet)
            {

                $data['se_tags'][$tweet['id']]=$this->sharableContent->getTags($tweet['id']);
            }
            //var_dump($data['se_tags']);
            // $data['se_tags'] = $tags;
            echo $this->view("admin/clickToFacebookAjax", $data);
            die();

        }
        public function loadMenu()
        {
            $options = get_option( SE_UPDATER_SETTINGS );
            if(!empty($options['activated']) && $options['activated'] == "Activated")
            {
                //$userStatsPage = add_users_page("Sharengine Click To Tweet", "Sharengine Click To Tweet", "read",SE_SLUG."_user_click_to", array($this, "loadClickToPage"));
                //add_action('admin_print_styles-'.$userStatsPage, array($this, "clickToStyle") );

                /*$userStatsPage = add_users_page("Sharengine Click To Share", "Sharengine Click To Share", "read",SE_SLUG."_user_click_to_share", array($this, "loadClickToSharePage"));
                add_action('admin_print_styles-'.$userStatsPage, array($this, "clickToStyle") );*/

            }
        }
        public function view($view, $data=array())
        {

            ob_start();
            extract($data);
            include $this->path.'views/'.$view.'.php';
            $content=ob_get_clean();

            return $content;
        }
        public function clickToStyle()
        {
            wp_register_style("se_admin_stats", SE_URL."css/admin_stats.css");
            wp_enqueue_style("se_admin_stats");

            wp_register_script("se_tagmanager", SE_URL.'js/tagmanager.js', array('jquery'));
            wp_enqueue_script("se_tagmanager");

            wp_register_script("se_click_to", SE_URL.'js/clickTo.js', array('jquery','se_tagmanager'));
            wp_enqueue_script("se_click_to");




            // Shortcodes Javascript



            wp_register_script("ShortcodesJS", SE_URL."js/ShortcodesJS.js", array('jquery', 'seCookies'));
            wp_enqueue_script("ShortcodesJS");


            // @TODO: Refactor This ASAP
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

        public function loadClickToPage()
        {
           // echo $this->load

            $data['se_tweets']= $this->sharableContent->getPosts();

            foreach($data['se_tweets'] as $tweet)
            {
                $data['se_tags'][$tweet['id']] = $this->sharableContent->getTags($tweet['id']);
            }
            echo $this->view("admin/clickToTweet", $data);
        }
        public function loadClickToSharePage()
        {
            // echo $this->load
            $this->sharableContent->setType('facebook');

            $data['se_tweets']= $this->sharableContent->getPosts();

            foreach($data['se_tweets'] as $tweet)
            {
                $data['se_tags'][$tweet['id']] = $this->sharableContent->getTags($tweet['id']);
            }
            echo $this->view("admin/clickToShare", $data);
        }
        public function addScheme($url, $scheme = 'http://')
        {
            return parse_url($url, PHP_URL_SCHEME) === null ?
                $scheme . $url : $url;
        }

    }