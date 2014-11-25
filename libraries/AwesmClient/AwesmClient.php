<?php
/*
 * Awe.sm API wrapper
 * The AwesmClient class focuses on stats retrieval
 *
 *
 */
    class seAwesmClient
    {
        public $baseUrl;
        /*
         * string endPoint
         * Possible values: range, range/intervals, active, totals and others.
         * To read on all available values : http://developers.awe.sm/apis/stats/
         */
        public $endPoint;

        private $defaultOptions;
        private $userOptions;

        private $wpUser;

        public function __construct($apiKey, seCacheInterface $cache,  $endPoint='')
        {
            $this->wpUser = get_current_user_id();
            $this->baseUrl = "https://api.awe.sm/stats/";
            $this->cache = $cache;
            $this->defaultOptions['key']= $apiKey;
            $this->defaultOptions['v'] = 3;


            // localize the client to this WP site and this username


            if($endPoint!='')
            {
                $this->setEndPoint($endPoint);
            }

            //localize the client to this username and this site

            //$this->defaultOptions['tag_2'] = addslashes(get_bloginfo('url'));
           // $this->defaultOptions['tag_2'] = addslashes("http://blog.myleadsystempro.com");
        }

        public function setEndPoint($endPoint)
        {
            $this->endPoint = $endPoint;
        }

        public function getUrl()
        {


            return $this->baseUrl.$this->endPoint.".json";
        }

        public function setOptions($options)
        {
            $this->userOptions = $options;
        }
        public function setDefaultOptions($options)
        {
            /*if(count($this->defaultOptions)>2)
            {
                throw new ErrorException("You can set the default options only once");
            }
            else
            {*/
                $this->defaultOptions=array_merge($this->defaultOptions, $options);
            /*}*/
        }

        /**
         * Check if a cached version of the request is available, if not, send a request.
         *
         */
        public function getResults()
        {
            //use the cache

            $user_id = get_current_user_id();


            $cacheKey = $this->getCacheKey();

            $result = $this->cache->get($user_id, $cacheKey);

            if($result)
            {
                return $result;
            }
            else
            {

                $result = $this->requestResults();
                $this->cache->set($user_id, $cacheKey, $result);

                return $result;
            }

        }

        private function requestResults()
        {
            $options = array_merge($this->defaultOptions, $this->userOptions);

            $queryData = http_build_query($options);

            $url = $this->getUrl();

            $url.="?".$queryData;




            $content = file_get_contents($url);



            // drop the userOptions after getting the data you require
            $this->userOptions=array();

            return $content;
        }

        // cache related methods

        private function getCacheKey()
        {
            $options = array_merge($this->defaultOptions, $this->userOptions);
            return base64_encode(http_build_query($options));
        }

        public function getCache()
        {
            return $this->cache;
        }



    }