<form id="acera-settings" method="post">
    <?php include "template/header.php"?>

    <?php echo $sidebar;?>



    <div id="main">
        <div class="topTabs">

            <div id="topTabs-container-home" data-easytabs="true">
                <div class="topTabs-header clearfix">

                    <div class="secInfo sec-dashboard">
                        <h1 style="display:inline-block" class="secTitle">Individual Permissions</h1>
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

                        <?php// var_dump($integrations);?>




                        <div class="separator">
                            <h4>Select a User</h4>


                            <?php
                            if(isset($user_id))
                            {
                                wp_dropdown_users(array("class"=>"userSelect", "id"=>"userDropdown", "selected"=>$user_id));
                            }
                            else
                            {
                                wp_dropdown_users(array("class"=>"userSelect", "id"=>"userDropdown"));
                            }
                           ?> <input style="display:inline-block" type="submit" value="Go" id="goPermissions" class="btn btn-info"/>

                           <br/><br/>
                        </div>
                        <div rel="se_enable_user_field_<?php echo $field_nr+1;?>" class="se_container">
                        <?php if(!empty($loaded_content)) echo $loaded_content;?>



                        </div>






                    </div>

</form>





</div>
</div>  <!-- /widget -->


</div>





<?php include "template/footer.php"; ?>















