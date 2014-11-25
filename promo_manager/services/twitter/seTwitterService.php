<?php
    class seTwitterService
    {
        public function __construct()
        {
            $this->name ="Twitter";
            $this->key = "twitter";

            add_filter("se_services", array($this, "addFilter"));
        }

        public function addFilter($services)
        {
            $services[$this->key] = $this;

            return $services;
        }
        public function displayRegular()
        {
            $html = $this->view('displayRegular');

            return $html;
        }
        public function displayFilled($data)
        {
            $html = $this->view('displayFilled', $data);

            return $html;
        }
        public function displayFrontEnd($data)
        {
            $unserialized_content = unserialize($data['content']);
            $new_data['tweet']['content']= $unserialized_content['content'];
            $new_data['tweet']['link'] = $unserialized_content['link'];
            $html = $this->view('displayFrontEnd', $new_data);

            return $html;
        }
        public function view($view, $data = array())
        {
            ob_start();
            extract($data);
            include SE_PATH."promo_manager/services/twitter/views/" . $view . '.php';
            $content = ob_get_clean();

            return $content;
        }
        public function addScheme($url, $scheme = 'http://')
        {
            return parse_url($url, PHP_URL_SCHEME) === null ?
                $scheme . $url : $url;
        }
    }