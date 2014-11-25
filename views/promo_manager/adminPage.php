<form id="acera-settings" method="post">
    <?php require SE_PATH."views/admin/template/header.php"?>

    <?php echo $sidebar;?>



    <div id="main" style="width:89.5%">
        <div class="topTabs">

            <div id="topTabs-container-home" data-easytabs="true">
                <div class="topTabs-header clearfix">

                    <div class="secInfo sec-dashboard">
                        <h1 style="display:inline-block" class="secTitle">Promotions Management</h1>
<!--                        <input style='float:right' name="save" class="btn" type="submit" value="Save changes" />-->
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




                    <?php if($table) echo $table;?>
            </div>

        <a href='?add_new_page=1' id='addNewPromotion' ><img src='<?php echo SE_IMAGES_URL;?>admin/twitter_add.png'/> </a>
        </div>
    </div>


    <div class="modal fade" id='popModal'>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Add a new Promotion</h3>
        </div>
        <form method="post">
        <div class="modal-body">
            <p>Promotion Name: <input type="text" placeholder="Enter the promotion name" class="modalInput" style="width:50%" name="promotion_name"/></p>
            <p>Tags:  <input type="text" class='tm-input tm-input-info modalInput' placeholder="Tags for this promotion" style='width:50%' name="promotion_tags" id="promotion_tags"  class="form-control acera-fullwidth"></p>
        </div>
        <div class="modal-footer">

            <input type="submit" value="Save changes" class="btn"></a>
        </div>
        </form>
    </div>
</form>





</div>
</div>  <!-- /widget -->


</div>





<?php include "template/footer.php"; ?>
















