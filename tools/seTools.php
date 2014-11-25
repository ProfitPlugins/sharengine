<?php
    class seTools
    {
        public function __construct()
        {
            add_action("admin_menu", array($this, 'adminMenu'));
        }

        public function adminMenu()
        {
            $options = get_option(SE_UPDATER_SETTINGS);


            if (!empty($options['activated']) && $options['activated'] == "Activated")
            {


                $page = add_submenu_page(SE_SLUG, 'Sharengine Tools', 'Tools', 'manage_options', "nds_sharengine_tools", array($this, 'adminPage'));

                add_action("admin_print_styles-{$page}", array($this, "adminPageScripts"));
            }
        }

        public function adminPage()
        {
            $tools=array();




            $data['tools'] = apply_filters("se_tools", $tools);





            // save tools
            if($_POST)
            {
                $toSave = array();
                foreach($data['tools'] as $k=>$tool)
                {
                    if(isset($_POST['tools'][$k]))
                        $toSave[$k] = 1;
                    else
                        $toSave[$k] = 0;
                }
                update_option("se_tools", $toSave);
            }


            $data['enabled_tools'] = get_option("se_tools");



            $data['sidebar'] = $this->view('admin/sidebar');
            echo $this->view("tools/adminMain", $data);
        }

        public function adminPageScripts()
        {
            wp_register_style("se_bootstrap_modal", SE_URL . "css/bootstrap_modal.css");
            wp_enqueue_style("se_bootstrap_modal");

            wp_register_script("se_bootstrap", SE_URL . "js/bootstrap_modal.js");
            wp_enqueue_script("se_bootstrap");

            wp_register_script("se_promo_manager", SE_URL . "js/se_promo_manager.js", array('se_checkboxtoggle'));
            wp_enqueue_script("se_promo_manager");

            wp_register_style("se_checkboxtoggle", SE_URL . "css/checkboxtoggle.css");
            wp_enqueue_style("se_checkboxtoggle");

            wp_register_script("se_checkboxtoggle", SE_URL . "js/checkboxtoggle.js", array('jquery'));
            wp_enqueue_script("se_checkboxtoggle");




        }

        public function view($view, $data = array())
        {

            ob_start();
            extract($data);
            include SE_PATH . 'views/' . $view . '.php';
            $content = ob_get_clean();

            return $content;
        }

    }
    $tools = new seTools();




    // include all the available tools ;

    $toolsDir =SE_PATH."tools/available-tools";

    if($dh  = opendir($toolsDir))
    {
        while (($file = readdir($dh)) !== false) {

            if($file !='.' && $file!='..')
            {
                // if this is a tool
                if(is_dir($toolsDir.'/'.$file))
                {

                    // include the bridge for that specific tool
                    if(file_exists($toolsDir.'/'.$file.'/bridge.php'))
                    {

                        include_once($toolsDir.'/'.$file.'/bridge.php');
                    }
                }
            }
        }
    }
