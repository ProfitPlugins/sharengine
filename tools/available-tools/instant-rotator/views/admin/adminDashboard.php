
<div class="wrap">

    <div id="icon-options-general" class="icon32"></div>
    <h2><?php echo NAME;?></h2>

    <div id="poststuff">

        <div id="post-body" class="metabox-holder columns-2" style="width:80%">

            <!-- main content @TODO: check if campaigns exists, if they do, show the box-->
            <div id="post-body-content">

                <div class="meta-box-sortables ui-sortable" >

                    <div class="postbox">

                        <h3><span>Campaigns</span></h3>
                        <div class="inside">

                            <table class="wp-list-table widefat fixed tags">
                                <thead>
                                    <tr>
                                        <th style="width:10%">ID</th>
                                        <th>Name</th>
                                        <th style="width:40%">Actions</th>
                                    </tr>
                              </thead>
                                <tbody data-wp-lists="list:tag" id="the-list">
                                    <?php if(count($campaigns) == 0) {?>
                                        <tr class="no-items"><td colspan="5" class="colspanchange">No campaings Found.</td></tr>
                                    <?php } else foreach($campaigns as $campaign) {?>

                                        <tr>
                                            <td><?php echo $campaign['id'];?></td>
                                            <td><?php echo stripslashes($campaign['name']);?></td>
                                            <td>
                                                <a href="admin.php?page=<?php echo SLUG;?>&sub_page=<?php echo MANAGE_SLUG?>&id=<?php echo $campaign['id'];?>" class="button-primary" >Manage</a>&nbsp;
                                                <a href="admin.php?page=<?php echo SLUG;?>&sub_page=<?php echo STATS_SLUG?>&id=<?php echo $campaign['id'];?>" class="button-secondary">View Stats</a>&nbsp;
                                                <form method="post" style="display:inline">
                                                    <input type="hidden" name="delete_id" value="<?php echo $campaign['id'];?>"/>
                                               <input type="submit" class="button-primary confirm"  name="delete" value="Delete">&nbsp;
                                                </form>
                                                <a href="<?php echo get_bloginfo('url').'/'.$campaign['slug'];?>" target="_blank" class="button-secondary">Link</a>&nbsp;
                                            </td>
                                        </tr>

                                    <?php } ?>
                                </tbody>
                            </table>




                        </div> <!-- .inside -->

                    </div> <!-- .postbox -->

                </div> <!-- .meta-box-sortables .ui-sortable -->

            </div> <!-- post-body-content -->

            <!-- main content @TODO: check if campaigns exists, if they do, show the box-->
            <div id="post-body-content">

                <div class="meta-box-sortables ui-sortable" >

                    <div class="postbox">

                        <h3><span>Add new campaign</span></h3>
                        <div class="inside">
                            <form method="post">
                                <div class="form-field form-required">
                                    <label for="tag-name">Campaign Name</label><br/>
                                    <input type="text" style="width:200px" aria-required="true" id="campaign_name" name="campaign_name">
                                </div>
                                <div class="form-field form-required">
                                    <label for="tag-name">Campaign URL</label><br/>
                                    <?php echo get_bloginfo('url');?>/<input type="text" style="width:200px" aria-required="true" id="campaign_url" name="campaign_url">
                                </div>
                                <p class="submit">
                                    <input type="submit" value="Add Campaign" class="button button-primary" id="submit" name="submit">
                                </p>

                            </form>
                        </div> <!-- .inside -->

                    </div> <!-- .postbox -->

                </div> <!-- .meta-box-sortables .ui-sortable -->

            </div> <!-- post-body-content -->



        </div> <!-- #post-body .metabox-holder .columns-2 -->

        <br class="clear">
    </div> <!-- #poststuff -->

</div> <!-- .wrap -->

