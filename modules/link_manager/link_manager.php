<?php
class linkManager
{
    public function __construct()
    {
        add_action("template_redirect", array($this, "createEndpoint"));
    }


    public function createEndpoint()
    {
        if($_GET['shorten_link'] == 1)
        {
            $this->processEndpoint();

            die();
        }
    }

    private function processEndpoint()
    {


        $url = "https://api.awe.sm/url.json";

        if($_GET['callback'])
        {
            $data['callback'] = $_GET['callback'];
            $data['v'] =$_POST['v'];
            $data['url'] = $_POST['url'];




            $data['key'] = "8058019345dc96c4f792c283cbac995b83c80cfdb047c940fd7a41ea68298866";
            $data['tool'] =$_POST['tool'];
            $data['channel'] = $_POST['channel'];


            $data['tag'] = "";
            $data['tag_2'] = $_POST['tag_2'];
            $data['tag_3'] = $_POST['tag_3'];
            $data['tag_4'] = $_POST['tag_4'];
            $data['tag_5'] = $_POST['tag_5'];


            $modifiers = array();
            $modifiers=apply_filters("se_shared_link_modifiers", $modifiers);
            $data['url'] = $data['url']."?{$data['tag_5']}={$data['tag_4']}";
            if(!empty($modifiers))
            {
                $affiliate = $_POST['tag_4'];

                $user = get_user_by( 'login',$affiliate );
                $user_id = $user->ID;

                foreach($modifiers as $mod)
                {
                    $data['url'] = str_replace("[url]", $data['url'], $mod["url"]);

                    if(!empty($mod['affiliate_params']))
                    {
                        // affiliate user parameters
                        foreach($mod['affiliate_params'] as $param)
                        {
                            $data['url'] = str_replace("[$param]",  esc_attr( get_user_meta( $user_id, $param, true ) ), $data['url']);

                        }
                    }
                }
            }

            $data['url'] = urldecode($data['url']);
            $query = http_build_query($data);
            $url = $url."?".$query;

           // print_r($url);


            //$url = "https://api.awe.sm/url.json?callback=jQuery111003145963167307847_1408201494636&v=3&url=http%3A%2F%2Furl.com&key=8058019345dc96c4f792c283cbac995b83c80cfdb047c940fd7a41ea68298866&tool=6fFz17&channel=twitter&tag=&tag_2=http%3A%2F%2Flocalhost%2Fwordpress&tag_4=admin&tag_5=test&_=1408201494637";
            $content = file_get_contents($url);

            header('content-type: application/json; charset=utf-8');
            echo $content;
        }


    }

}

$linkManager = new linkManager();