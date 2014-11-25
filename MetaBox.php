<?php
    class seMetabox
    {
        public function __construct()
        {
            add_action('add_meta_boxes', array($this, 'addMetaBox'));
            add_action('save_post', array($this, 'save'));
        }

        public function addMetaBox($post_type)
        {
            $post_types = array('post', 'page');     //limit meta box to certain post types
            if ( in_array( $post_type, $post_types )) {
                add_meta_box(
                    SE_NAME
                    ,SE_NAME
                    ,array( $this, 'renderMetaBox' )
                    ,$post_type
                    ,'advanced'
                    ,'high'
                );
            }
        }

        public function save($post_id)
        {

            if(!isset($_POST['nds_sharengine_meta']))
                return $post_id;

            $nonce = $_POST['nds_sharengine_meta'];

            if(!wp_verify_nonce($nonce, 'nds_sharengine_meta'))
                return $post_id;
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
                return $post_id;

            if ( 'page' == $_POST['post_type'] ) {
                if ( ! current_user_can( 'edit_page', $post_id ) )
                    return $post_id;
            } else {
                if ( ! current_user_can( 'edit_post', $post_id ) )
                    return $post_id;
            }

            if($_POST['se_enabled'])
                $se_enabled =1;
            else
                $se_enabled =0;



            update_post_meta($post_id, 'se_enabled', $se_enabled);
        }

        public function renderMetaBox($post)
        {

            wp_nonce_field('nds_sharengine_meta', 'nds_sharengine_meta');

            $data['se_enabled'] = get_post_meta($post->ID, 'se_enabled', true);





            echo $this->view('admin/metabox', $data);
        }
        public function view($view, $data=array())
        {

            ob_start();
            extract($data);
            include $this->path.'views/'.$view.'.php';
            $content=ob_get_clean();

            return $content;
        }
    }