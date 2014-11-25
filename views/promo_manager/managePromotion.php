<form id="acera-settings" method="post">
    <?php require SE_PATH."views/admin/template/header.php"?>

    <?php echo $sidebar;?>





    <div id="main">

        <div class="topTabs">

            <div id="topTabs-container-home" data-easytabs="true">
                <div class="topTabs-header clearfix">

                    <div class="secInfo sec-dashboard">
                        <h1 style="display:inline-block" class="secTitle"><?php echo $name;?> Management</h1>
                        <input style='float:right' name="save" class="btn" type="submit" value="Save changes" />
                        <!--<span class="secExtra">Welcome</span>
                    </div> <!-- /SecInfo -->
                    </div>

                </div><!-- /topTabs-header -->



            </div> <!-- /tab-container -->

            <!-- </div> -->
        </div>
        <br/>
        <div class="fluid">
            <div class="widget leftcontent grid12">

                <div class="widget-content pad20">



                <div class="tab-content" id="se-define-parameters">



                <?php
                foreach($services as $key=>$service) {
                    echo "<div class='se_service_wrapper'>";
                    if($existing_services[$key])
                    {
                        if($existing_services[$key]['enabled'] == 1)
                            $checked = "checked=checked";
                        else
                            $checked = "";
                        ?>
                        <h4 class="sePromotionHeader" style="display:inline-block"> <?php echo $service->name;?> </h4><div class="widget-controls"><input type='checkbox' <?php echo $checked;?> class="sl" id="slider-comm<?php echo $service->key?>" name="enabled[<?php echo $service->key?>]"><label class="slider blue" for="slider-comm<?php echo $service->key?>"></label></div><br/>
                       <div class='service_content' style="<?php if(!$checked) echo 'display:none';?>"><?php echo $service->displayFilled($existing_services[$key]);?></div><br/><br/>
                        <?php
                    }
                    else{
                    ?>
                       <h4 class="sePromotionHeader" style="display:inline-block"> <?php echo $service->name;?> </h4> <div class="widget-controls"><input type='checkbox' class='sl' id="slider-comm<?php echo $service->key?>" name="enabled[<?php echo $service->key?>]"><label class="slider blue" for="slider-comm<?php echo $service->key?>"></label></div><br/>
                       <div class='service_content' style="display:none"><?php echo $service->displayRegular();?></div> <br/><br/>
                <?php }
                    echo "</div>";
                }?>

        </div>
    </div>



</form>



</div>
</div>  <!-- /widget -->


</div>





<?php include "template/footer.php"; ?>

