<?php

    add_action( 'wp_ajax_nopriv_ajaxlogin', 'seAjaxLogin' );
    function seAjaxLogin(){

        // Nonce is checked, get the POST data and sign user on
        $info = array();
        $info['user_login'] = $_POST['username'];
        $info['user_password'] = $_POST['password'];
        $info['remember'] = true;

        $user_signon = wp_signon( $info, false );
        if ( is_wp_error($user_signon) ){
            echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
        } else {
            echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...')));
        }

        die();
    }

    function seLoginForm( $login_only  = 0 ) {
        global $user_ID, $user_identity, $user_level;
        ob_start();
        if ( $user_ID ) : ?>
            <?php if( empty( $login_only ) ): ?>
            <div id="user-login">
                <p class="welcome-text"><?php echo __( 'Welcome') ?> <strong><?php echo $user_identity ?></strong> .</p>
                <span class="author-avatar"><?php echo get_avatar( $user_ID, $size = '85'); ?></span>
                <ul>
                    <li><a href="<?php echo home_url() ?>/wp-admin/"><?php echo __( 'Dashboard' ) ?> </a></li>
                    <li><a href="<?php echo home_url() ?>/wp-admin/profile.php"><?php echo __( 'Your Profile' ) ?> </a></li>
                    <li><a href="<?php echo wp_logout_url(); ?>"><?php echo __( 'Logout' ) ?> </a></li>
                </ul>
            </div>
        <?php endif; ?>
        <?php else: ?>
        <?php
        $id = time();
        ?>
            <div id="login-form" style="position:relative">
                <div id="login_loading_<?php echo $id;?>" class="loading hide"></div>
                <div id="errordiv_<?php echo $id;?>" class="hide loginerror"></div>
                <form method="post">
                    <p id="log-username"><input type="text" name="seusername" id="seusername_<?php echo $id;?>" value="<?php echo __( 'Username'  ) ?>" onfocus="if (this.value == '<?php echo __( 'Username'  ) ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo __( 'Username'  ) ?>';}"  size="33" /></p>
                    <p id="log-pass"><input type="password" name="sepassword" id="sepassword_<?php echo $id;?>" value="<?php echo __( 'Password'  ) ?>" onfocus="if (this.value == '<?php echo __( 'Password'  ) ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo __( 'Password'  ) ?>';}" size="33" /></p>
                    <input type="button" name="loginsubmit" id="loginbutton_<?php echo $id;?>" value="<?php echo __( 'Log in'  ) ?>" class="login-button" />
                    <label for="rememberme"><input name="rememberme" id="rememberme_<?php echo $id;?>" type="checkbox" checked="checked" value="forever" /> <?php echo __( 'Remember Me'  ) ?></label>
                </form>
                <ul class="login-links">
                    <?php if ( get_option('users_can_register') ) : ?><?php echo wp_register() ?><?php endif; ?>
                    <li><a href="<?php echo home_url() ?>/wp-login.php?action=lostpassword"><?php echo __( 'Lost your password?'  ) ?></a></li>
                </ul>
            </div>
            <script>
                jQuery(document).ready(function($) {
                    $('#loginbutton_<?php echo $id;?>').unbind('click');
                    $('#loginbutton_<?php echo $id;?>').click(function(){
                        $('#login_loading_<?php echo $id;?>').show();
                        $('#errordiv_<?php echo $id;?>').hide();
                        var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' );?>';
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: ajaxurl,
                            data: {
                                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                                'username': $('#seusername_<?php echo $id;?>').val(),
                                'password': $('#sepassword_<?php echo $id;?>').val()
                            },
                            success: function(data){
                                if (data.loggedin == true){
                                    document.location.reload();
                                } else {
                                    $('#errordiv_<?php echo $id;?>').show();
                                    $('#errordiv_<?php echo $id;?>').html(data.message);
                                }
                                $('#login_loading_<?php echo $id;?>').hide();
                            }
                        });
                    });
                });
            </script>
        <?php endif;
        return ob_get_clean();
    }




    class seLoginWidget extends WP_Widget
    {
        public function __construct()
        {
            parent::__construct('seLoginWidget', 'Sharengine - Login', array('description'=>'Sharengine - Login'));
        }
        public function widget($args, $instance)
        {
            // frontend code here
            extract( $args );

            $title = apply_filters('widget_title', $instance['title'] );

            echo $before_widget;
            echo $before_title;
            echo $title ;
            echo $after_title;
            $loginform = seLoginForm();
            echo apply_filters('widget_text', $loginform);
            echo $after_widget;
        }
        public function form ($instance)
        {
            // Backend code


            if(isset($instance['title']))
            {
                $title = $instance ['title'];
            }
            else
            {
                $title = "Login";
            }
            ?>
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Titles:' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' );?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>
        <?php
        }
        public function update($new_instance, $old_instance)
        {
            return $new_instance;
        }

        static public function registerWidget()
        {
            register_widget('seLoginWidget');
        }


    }

    add_action('widgets_init', array('seLoginWidget', 'registerWidget'));
