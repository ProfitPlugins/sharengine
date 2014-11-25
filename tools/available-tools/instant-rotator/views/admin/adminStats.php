
<div class="wrap">

    <div id="icon-options-general" class="icon32"></div>
    <h2><?php echo NAME;?></h2>

    <h3>
        <?php echo $campaign['name'];?> -
        <a style="text-decoration:none" href="admin.php?page=<?php echo SLUG;?>&sub_page=<?php echo MANAGE_SLUG?>&id=<?php echo $campaign['id'];?>">Manage Campaign</a> -
        <a style="text-decoration:none" href="admin.php?page=<?php echo SLUG;?>">Back</a></h3>

    <div id="poststuff">

        <div id="post-body" class="metabox-holder columns-2" style="width:100%">

            <!-- main content @TODO: check if campaigns exists, if they do, show the box-->
            <div id="post-body-content" >

                <div class="meta-box-sortables ui-sortable" >

                    <div class="postbox" style="float:left;width:46%;display:inline-block">

                        <h3><span>Visitors</span></h3>
                        <div class="inside" style="height:220px;">

                            <?php echo $visitorsChart;?>

                            </form>
                        </div> <!-- .inside -->

                    </div> <!-- .postbox -->

                    <div class="postbox" style="float:left;width:46%;display:inline-block;margin-left:30px">

                        <h3><span>Top 5 Referrers</span></h3>
                        <div class="inside" style="height:220px;">
                            <div style="display:inline-block">
                                <table class="wp-list-table widefat fixed tags">
                                    <thead>
                                    <tr>
                                        <th>URL</th>
                                        <th width="10%">Hits</th>
                                    </tr>

                                    </thead>
                                    <tbody>
                                    <?php foreach($topRefs as $topRef)
                                    {?>
                                        <tr style="border-bottom:1px">
                                            <th><span title="<?php echo $topRef['ref'];?>"><?php if(isset($topRef)){ if(!empty($topRef['ref'])){ echo substr($topRef['ref'],0, 90); if(strlen(substr($topRef['ref'],0, 90)) != strlen($topRef['ref'])) echo "..."; } else echo "No Referrer";} else echo "No Data Yet;";?></span></th>
                                            <th><?php if(isset($topRef)){echo $topRef['total_count'];} else echo "&nbsp;";?></th>
                                        </tr>
                                    <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- .inside -->

                    </div> <!-- .postbox -->


                    <div class="postbox" style="float:left;width:46%;display:inline-block">

                        <h3><span>Countries Graph</span></h3>
                        <div class="inside" style="height:220px;">
                            <div style="width:100%;display:inline-block">
                                <?php echo $countriesGraph;?>
                            </div>
                        </div> <!-- .inside -->

                    </div> <!-- .postbox -->

                    <div class="postbox" style="float:left;width:46%;display:inline-block;margin-left:30px">

                        <h3><span>Top 5 Hours Today</span></h3>
                        <div class="inside" style="height:220px;">
                            <div style="display:inline-block">
                                <table class="wp-list-table widefat fixed tags">
                                    <thead>
                                    <tr>
                                        <th>Hour</th>
                                        <th  width="10%">Hits</th>
                                    </tr>

                                    </thead>
                                    <tbody>

                                    <?php foreach($hours as $hour)
                                    {?>
                                        <tr style="border-bottom:1px">
                                            <th><?php if(isset($hour)){ if(!empty($hour['hour'])) echo number_to_hour($hour['hour']); else echo "No Data Yet";} else echo "No Data Yet;";?></th>
                                            <th><?php if(isset($hour)){echo $hour['count'];} else echo "&nbsp;";?></th>
                                        </tr>
                                    <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- .inside -->

                    </div> <!-- .postbox -->


                </div> <!-- .meta-box-sortables .ui-sortable -->

            </div> <!-- post-body-content -->





        </div> <!-- #post-body .metabox-holder .columns-2 -->

        <br class="clear">
    </div> <!-- #poststuff -->

</div> <!-- .wrap -->

