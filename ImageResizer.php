<?php
    // class meant to be used in the WordPress Environment
    class seImageResizer
    {
        public function __construct()
        {
            $wp_upload_dir = wp_upload_dir();
            $this->cacheDir = $wp_upload_dir['basedir'].'/cache';

            add_action("template_redirect", array($this, "template_redirect"));
        }

        public function template_redirect()
        {
            if($_GET['do'] == 'image_resize')
            {

                $w = $_GET['w'];
                $h = $_GET['h'];
                $src =$_GET['image'];
                //@TODO: make sure the image is ours;

                $img = wp_get_image_editor($src);
                var_dump($img);
                if(!is_wp_error($img))
                {
                    $img->resize($w,$h, false);
                    $img->stream();
                }


                die();

            }
        }
    }

    $seImageResizer = new seImageResizer();