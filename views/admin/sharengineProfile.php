<div id="se-profile-page" id="wrap">
    <h2>Sharengine Profile</h2>

    <form method='post'>


        <?php
        /** Hook for the profile picture */
            do_action("se_show_profile", $user);
        ?>

        <h3>Personal Information</h3>
        <table class="form-table front-end-table-css">
            <tbody>
                <tr>
                    <th><label for="first_name">First Name</label></th>
                    <td><input type="text" class="regular-text" value="<?php echo esc_attr( get_user_meta( $user_id,"first_name", true ) ); ?>" id="first_name" name="first_name"></td>
                </tr>

                <tr>
                    <th><label for="last_name">Last Name</label></th>
                    <td><input type="text" class="regular-text" value="<?php echo esc_attr( get_user_meta( $user_id,"last_name", true ) ); ?>" id="last_name" name="last_name"></td>
                </tr>
                <tr>
                    <th><label for="url">Website</label></th>
                    <td><input type="text" class="regular-text code" value="<?php echo esc_attr( get_user_meta( $user_id,"url", true ) ); ?>" id="url" name="url"></td>
                </tr>
                <tr>
                    <th><label for="phone">Phone Number</label></th>
                    <td><input type="text" class="regular-text" value="<?php echo esc_attr( get_user_meta( $user_id,"se_phone", true ) ); ?>" id="phone" name="se_phone"></td>
                </tr>
                <tr>
                    <th><label for="phone">Email</label></th>
                    <td><input type="text" class="regular-text" value="<?php $user = get_userdata($user_id); echo $user->user_email; ?>" id="se_email" name="se_email"></td>
                </tr>
            </tbody>
        </table>

        <h3>Social Media</h3>

        <table class="form-table front-end-table-css">
            <tbody>
            <?php   foreach($socialFields as $key => $field) {?>
                <tr>
                    <th><label for="<?php echo $key;?>"><?php echo $field;?></label></th>
                    <td><input type="text" class="regular-text" value="<?php echo esc_attr( get_user_meta( $user_id,$key, true ) ); ?>" id="<?php echo $key;?>" name="<?php echo $key;?>">
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

        <h3>Affiliate information</h3>

        <table class="form-table front-end-table-css">
            <tbody>
            <?php foreach($affiliateFields as $key => $field)
                if($field['se_enabled'] == 1 && $permissions[$key])
            { ?>
            <tr>
                <th><label for="instruments"><?php echo $field['se_field'];?></label></th>
                <td>
                    <input type="text" class="regular-text" value="<?php echo esc_attr( get_user_meta( $user_id,'field'.$key, true ) ); ?>" id="instruments" name="field<?php echo $key;?>"><br>
                    <span class="description"><?php echo $field['se_description'];?></span>
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>



        <?php if(!empty($customCategories))
        {
            foreach($customCategories as $category)
            {
            ?>
                <h3><?php echo $category['name'];?></h3>
                <table class="form-table front-end-table-css">
                    <tbody>
                <?php foreach($category['fields'] as $field)
                {
                ?>
                    <tr>
                        <th><label for="instruments"><?php echo $field['text'];?></label></th>
                        <td>
                            <input type="text" class="regular-text" value="<?php echo esc_attr( get_user_meta( $user_id, $field['name'], true ) ); ?>" id="instruments" name="<?php echo $field['name'];?>"><br>
                            <span class="description"><?php echo $field['description'];?></span>
                        </td>
                    </tr>
                <?php
                    }
                ?>
                </tbody>
                </table>
        <?php
            }
        }
        ?>





        <input name="submit" id="submit" class="button button-primary" value="Update Profile" type="submit">
    </form>


</div>