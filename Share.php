<?php
    class seShare
    {
        public function __construct(seSocialNetworks $networks)
        {
            $this->networks = $networks;
            add_action('wp_footer', array($this, 'loadShareButton'));

            add_action('wp_footer', array($this, "loadRegularShareButtons"));


            //set the current template
            //TODO: Add a template selecter
            $options = get_option(SE_OPTIONS);
            if($options['vsb_template']=='')
                $this->template='light';
            else
                $this->template=$options['vsb_template'];

            add_filter("template_css", array($this, "template_css"));
            add_filter("template_js", array($this, "template_js"));
        }
        public function template_css($css)
        {
            $css['light_template'] = SE_URL."templates/shareBoxVisitors/".$this->template."/style.css";
            return $css;
        }

        public function template_js($js)
        {
            $js['light_template'] = SE_URL."templates/shareBoxVisitors/".$this->template."/script.js";
            return $js;
        }
        public function loadRegularShareButtons()
        {
            // load the share buttons for the non logged in users
            // @TODO: refactor this into its own thing

            $options = get_option(SE_OPTIONS);

            if($options['enable_visitors'] == 1 && (is_singular() || is_single() || is_page()) && !is_user_logged_in() )
            {
                $data = array();



                //load the view for the template




                //echo $this->template_view('shareBoxVisitors/'.$this->template.'/main', $data);
            }

        }

        public function loadShareButton()
        {
            global $post;

            $se_enabled = get_post_meta($post->ID, 'se_enabled', true);


            //TODO: check if it's a ShareEngine enabled page
            if(/*!is_home() && $se_enabled == 1 && */is_user_logged_in())
            {
                $options = get_option(SE_OPTIONS);



                $title = get_the_title($post->ID);
                $permalink = get_permalink($post->ID);



                $this->networks->setLinkAndTitle($permalink, $title);

                //Pass the network titles and links to the view
                $data['titles']= $this->networks->getTitles();
                $data['links']= $this->networks->getLinks();
                $data['permalink'] = $permalink;
                $data['affiliate_variable']= $options['affiliate_variable'];

                    echo $this->view('shareBox', $data);


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

        public function template_view($view, $data=array())
        {
            ob_start();
            extract($data);
            include $this->path.'templates/'.$view.'.php';
            $content=ob_get_clean();

            return $content;
        }
    }
