<?php
    include_once "seCacheInterface.php";

    class seCacheWP implements seCacheInterface
    {

        public function __construct()
        {
            global $wpdb;
            $this->wpdb = &$wpdb;

            //All the cache items are valid for 1 day
            $this->cacheTime = 24 * 60 * 60;
        }
        public function set($user, $cacheKey, $value)
        {
            $this->delete($user, $cacheKey);


            $data['user_id'] = $user;
            $data['cache_key'] = $cacheKey;
            $data['value']= $value;
            $data['timestamp'] = time();
            $this->wpdb->insert($this->wpdb->prefix.SE_CACHE_TABLE, $data);

            //var_dump($this->wpdb->last_error);
        }
        public function get($user, $cacheKey)
        {
            $row = $this->wpdb->get_row("SELECT * FROM ".$this->wpdb->prefix.SE_CACHE_TABLE." WHERE user_id='{$user}' AND cache_key='{$cacheKey}'", ARRAY_A);

            $now = time();

            if($now - $this->cacheTime > $row['timestamp'])
            {
                //caching time has expired, delete it and return NULL
                $this->delete($user, $cacheKey);
                return NULL;

            }
            else
            {
                return $row['value'];
            }
        }

        public function delete($user, $cacheKey)
        {
            $where['user_id'] = $user;
            $where['cache_key'] = $cacheKey;

            $this->wpdb->delete($this->wpdb->prefix.SE_CACHE_TABLE, $where);

        }
        // Deletes all cache for a specific user
        public function delete_all($user)
        {
            $where['user_id'] = $user;
            $this->wpdb->delete($this->wpdb->prefix.SE_CACHE_TABLE, $where);
        }

        public function getTime($user)
        {

            $row = $this->wpdb->get_row("SELECT timestamp FROM ".$this->wpdb->prefix.SE_CACHE_TABLE." WHERE user_id='{$user}' ORDER BY id DESC LIMIT 1");

            return $row->timestamp;
        }
    }