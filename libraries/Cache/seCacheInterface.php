<?php
    interface seCacheInterface
    {
        public function set($user, $cacheKey, $data);
        public function get($user, $cacheKey);
        public function delete($user, $cacheKey);
        public function delete_all($user);

        // Last cache time for a specific user
        public function getTime($user);
    }
