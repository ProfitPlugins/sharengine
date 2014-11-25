<?php
if(class_exists('wpUtils'))
    return true;
class wpUtils {

    public function __construct($dir)
    {

        global $wpdb;
        $this->url=plugin_dir_url($dir."/main.php");
        $this->path=plugin_dir_path($dir."/main.php");
    }



}