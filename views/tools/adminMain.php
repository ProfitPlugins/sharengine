<form id="acera-settings" method="post">
    <?php require SE_PATH."views/admin/template/header.php"?>

    <?php echo $sidebar;?>

    <?php if($_POST) { ?>
        <meta http-equiv="refresh" content="0">
    <?php } ?>

    <div id="main" style="width:89.5%;min-height:400px">
        <div class="topTabs">

            <div id="topTabs-container-home" data-easytabs="true">
                <div class="topTabs-header clearfix">

                    <div class="secInfo sec-dashboard">
                        <h1 style="display:inline-block" class="secTitle">Tools Management</h1>
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
                        <br/>
                        <p>
                            Enable or disable the extra tools for Sharengine
                        </p>
                        <?php foreach($tools as $k=>$tool) { ?>
                        <h4 style="display:inline-block" class="sePromotionHeader"> <?php echo $tool['name'];?> </h4>
                        <input type="checkbox" name="tools[<?php echo $k?>]" id="slider-commtwitter" class="sl" <?php if($enabled_tools[$k]) {?>checked="checked" <?php }?>><label for="slider-commtwitter" class="slider blue"></label>
                            <p class="description"><?php echo $tool['description'];?></p>
                        <?php } ?>
                    </div>

                </div>
            </div>



</form>





</div>
</div>  <!-- /widget -->


</div>





<?php include "template/footer.php"; ?>
















