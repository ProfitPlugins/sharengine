<div class="wrap">
    <!-- Screen icons are no longer used as of WordPress 3.8. -->
    <h2><?php echo SE_NAME;?> Licensing</h2>

    <?php
    if($error)
    {
        echo '<div id="message" class="error"><p>'.$error.'</p></div>';
    }
    else
        if($success)
        {
            echo '<div id="message" class="updated"><p>'.$success.' <meta http-equiv="refresh" content="1"></p></div>';
        }

    ?>


    <h2 class="nav-tab-wrapper">
        <a href="#" class="nav-tab nav-tab-active">Activate License</a>

    </h2>


    <form method="post">
        <div class="main">
           <h3>License Information</h3>
            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row">License Key</th>
                        <td>
                            <input type="text" value="" size="25" value='<?php echo $settings['api_key'];?>' name="api_key" id="api_key">

                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">License email</th>
                        <td>
                            <input type="text" value="" value='<?php echo $settings['email'];?>' size="25" name="activation_email" id="activation_email">

                        </td>
                    </tr>
                </tbody>
            </table>
            <p class="submit"><input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit"></p>
        </div>


        <!--  <div class="sidebar">
          <h3>Prevent Comment Spam</h3>
<ul class="celist">
<li><a href="http://www.toddlahman.com/shop/simple-comments/" target="_blank">Simple Comments</a></li>
</ul>
        </div>-->
    </form>
</div>