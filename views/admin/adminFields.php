<form id="acera-settings" method="post">
    <?php include "template/header.php"?>

    <?php echo $sidebar;?>



    <div id="main">
        <div class="topTabs">

            <div id="topTabs-container-home" data-easytabs="true">
                <div class="topTabs-header clearfix">

                    <div class="secInfo sec-dashboard">
                        <h1 style="display:inline-block" class="secTitle">Affiliate Fields Management</h1>
                        <input style='float:right' name="save" class="btn" type="submit" value="Save changes" />
                        <!--<span class="secExtra">Welcome</span>
                    </div> <!-- /SecInfo -->
                    </div>

                </div><!-- /topTabs-header -->



            </div> <!-- /tab-container -->

            <!-- </div> -->
        </div>

<div class="fluid">
    <div class="widget leftcontent grid12">

        <div class="widget-content pad20">

        <div class="tab-content" id="se-define-parameters">



            <?php
                foreach($data['fields'] as $field_nr=>$v)
                {
                    if($v['se_enabled'])
                        $display='block';
                    else
                        $display='none';
                    ?>

                    <div class="separator">
                        <h4>Enable Affiliate Field #<?php echo $field_nr+1;?></h4>

                        <div class="settings-content">
                            <div class="acera_image_preview">
                            </div>
                            <label for="se_enable_user_field_<?php echo $field_nr+1;?>">
                                <input type="checkbox"  id="se_enable_user_field_<?php echo $field_nr+1;?>" name="se_enabled[<?php echo $field_nr+1;?>]" class="show_hide se_activate" <?php checked($v['se_enabled']);?>>
                                Activate
                            </label>

                            <label for="se_enable_default_user_field_<?php echo $field_nr+1;?>">
                                <input type="checkbox"  id="se_enable_default_user_field_<?php echo $field_nr+1;?>" name="se_default[<?php echo $field_nr+1;?>]" class="se_default" <?php checked($v['se_default']);?>>
                                Enable  As Default
                            </label>
                            <p class="description">Enable Sharengine affiliate field #<?php echo $field_nr+1;?>.</p>
                        </div>
                    </div>
                    <div rel="se_enable_user_field_<?php echo $field_nr+1;?>" style="display: <?php echo $display;?>;">
                        <div class="separator">
                            <h4>Affiliate Field #<?php echo $field_nr+1;?></h4>
                            <div class="settings-content">
                                <div class="acera_image_preview">
                                </div>
                                <input type="text" value="<?php echo $v['se_field'];?>" name="se_field[<?php echo $field_nr+1;?>]" id="se_user_field1" class="acera-fullwidth">
                                <p class="description">Enter the heading you would like to show in the affiliate members profile.<br>This heading should clearly indicate the affiliate program that this field will represent on your blog.</p>
                            </div>
                        </div>
                        <div class="separator">
                            <h4>Affiliate Field #<?php echo $field_nr+1;?> - Description</h4>

                            <div class="settings-content">
                                <div class="acera_image_preview">
                                </div>
                                <input type="text" value="<?php echo $v['se_description'];?>" name="se_description[<?php echo $field_nr+1;?>]" id="se_user_field1_desc" class="acera-fullwidth">
                                <p class="description">Enter a description detailing the type of information needed to place in your links.</p>
                            </div>
                        </div>
                    </div>



            <?php
                }
            ?>


        </div>
        <div id='fieldsPlaceholder'></div>


        <input type='hidden' id='fieldsCount' name='fieldsCount'value ='<?php echo $fields_nr;?>' />

        <a href='#' id='addNewField' ><img src='<?php echo SE_IMAGES_URL;?>admin/twitter_add.png'/> </a>
</form>





</div>
</div>  <!-- /widget -->


</div>





<?php include "template/footer.php"; ?>















