<?php

    class seSocialNetworks
    {
        public $links, $titles;

        public function __construct()
        {

            //  Load the network links and titles

            $links = file_get_contents(SE_PATH.'network_links.json');
            $titles = file_get_contents(SE_PATH.'network_names.json');

            $this->links = json_decode($links, true);
            $this->titles = json_decode($titles, true);


            //Redirect  to a specific social networks
            add_action("template_redirect", array($this, "redirect"));
        }


        public function redirect()
        {


            if($_GET['se_redirect']==1)
            {
                $url = $_GET['url'];
                $title = stripslashes($_GET['title']);
                $body = stripslashes($_GET['body']);
                $service = $_GET['service'];

                $image =$_GET['image'];


                $link = $this->getLink($service, $url, $title, $body, $image);



                header("Location: $link");

                echo '<meta http-equiv="refresh" content="0;'.$link.'"/>';

                die();
            }
        }

        private function getLink($service, $url, $title, $body, $custom_image='')
        {



            // Add HTTP if it doesn't have it already
            if(strpos($url, "http://") === FALSE)
            {
                $url = "http://".$url;
            }
            $post_id = url_to_postid($_GET['old_url']);
            $post = get_post( $post_id );

            $ret_url = $this->links[$service];


                if (has_post_thumbnail( $post->ID ) )
                {

                    $image =  wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );

                    if(isset($image[0]) && !empty($image[0]))
                    {
                        $image = urlencode($image[0]);
                    }




                }
                else
                {

                    if($custom_image)
                        $image = $custom_image;
                    else
                        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
                        if($matches[1][0])
                            $image = urlencode($matches[1][0]);
                        else
                            $image = "";
                }

            if($service == "stumbleupon")
            {
                $url = $_GET['old_url'];
                $options = get_option("SE_OPTIONS");
                $key = $options['affiliate_variable'];


                // remove existing variable
                $url = preg_replace('/(.*)(?|&)' . $key . '=[^&]+?(&)(.*)/i', '$1$2$4', $url . '&');
                $url = substr($url, 0, -1);
                // add it again
                $separator = (parse_url($url, PHP_URL_QUERY) == NULL) ? '?' : '&';
                $url .= $separator .$key."=".$_COOKIE['se_affiliate'];
            }

            if($service == 'facebook')
            {

                if($custom_image)
                {
                    $summary = urlencode($body);
                    $image = $custom_image;
                }
                else
                {
                    $summary = urlencode(strip_shortcodes(wp_trim_words( $post->post_content )));
                }
                //die(var_dump($summary));



                $custom_url ="http://www.facebook.com/sharer/sharer.php?s=100&p[title]=$title&p[url]=$url&p[summary]=$summary&p[images][0]=$image";


                return $custom_url;
            }
            else
            {

            }

            // facebook-image code

            if(!empty($custom_image) && empty($image))
            {
                $image= $custom_image;
            }
            $ret_url = str_replace('[title]', urlencode($title),$ret_url );
            $ret_url = str_replace('[url]', urlencode($url), $ret_url);

            $ret_url = str_replace('[body]', urlencode($body), $ret_url);

            $ret_url = str_replace('[image]', $image, $ret_url);





            return $ret_url;
            //
        }
        public function getLinks()
        {
            return $this->links;
        }

        public function getTitles()
        {
            return $this->titles;
        }


        public function setLinkAndTitle($link, $title)
        {
            foreach($this->links as $k=>$value)
            {
                $this->links[$k] = str_replace('[title]', urlencode($title), $this->links[$k]);
                $this->links[$k] = str_replace('[url]', urlencode($link), $this->links[$k]);

            }
        }



    }