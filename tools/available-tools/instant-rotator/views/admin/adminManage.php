
<div class="wrap">

    <div id="icon-options-general" class="icon32"></div>
    <h2><?php echo NAME;?></h2>

    <div id="poststuff">

        <div id="post-body" class="metabox-holder columns-2" style="width:80%">

            <!-- main content @TODO: check if campaigns exists, if they do, show the box-->
            <div id="post-body-content">

                <div class="meta-box-sortables ui-sortable" >

                    <div class="postbox">

                        <h3><span>Campaign Settings: <?php echo stripslashes($campaign['name']);?></span></h3>
                        <div class="inside">

                                <div class="form-field form-required">
                                    <label for="tag-name">Link</label><br/>
                                    <input type="text" value="<?php echo esc_attr(get_bloginfo("url")."/".$campaign['slug']);?>" readonly="readonly" style="width:400px" aria-required="true"  name="url">
                                </div>
                            <form method="post">
                                Rotator Type:
                                <fieldset><legend class="screen-reader-text"><span>input type="radio"</span></legend>
                                    <label title="g:i a"><input type="radio" value="1" <?php checked($campaign['mode'], 1);?>name="mode"> <span>Sequential</span></label><br>
                                    <label title="g:i a"><input type="radio" value="2" <?php checked($campaign['mode'], 2);?>name="mode"> <span>Random </span></label>
                                </fieldset>
                                <input type="hidden" name="campaign_id" value="<?php echo $campaign['id'];?>"/>
                                <p class="submit">
                                    <input type="submit" value="Update" class="button button-primary" id="submit" name="update_mode">
                                </p>

                            </form>
                        </div> <!-- .inside -->

                    </div> <!-- .postbox -->

                </div> <!-- .meta-box-sortables .ui-sortable -->

            </div> <!-- post-body-content -->



            <!-- main content -->
            <div id="post-body-content">

                <div class="meta-box-sortables ui-sortable" >

                    <div class="postbox">


                        <h3><span> Link Management</span></h3>
                        <div class="inside">
                        <form method="post">
                            <table class="wp-list-table widefat fixed tags">
                                <thead>
                                <tr>
                                    <th style="width:3%">ID</th>
                                    <th>URL</th>
                                    <th width="5%">Hits</th>
                                    <th width="10%">Unique Visitors</th>
                                    <th>Conversions</th>
                                    <th>Chances</th>
                                    <th>Max Hits</th>
                                    <th style="width:10%">Actions</th>
                                </tr>
                                </thead>
                                <tbody data-wp-lists="list:tag" id="the-list">
                                <?php if(count($links) == 0) {?>
                                    <tr class="no-items"><td colspan="5" class="colspanchange">No links Found.</td></tr>
                                <?php } else foreach($links as $link) {?>

                                    <tr <?php if($link['max_hits']!=0 && $link_stats[$link['id']]['hits']>= $link['max_hits']) echo "class='ir_red'";?>>
                                        <td><?php echo $link['id'];?></td>
                                        <td><a target="_blank" href="<?php echo $link['url'];?>"><?php echo $link['url'];?></a></td>
                                        <td><?php echo $link_stats[$link['id']]['hits'];?></td>
                                        <td><?php echo $link_stats[$link['id']]['unique'];?></td>
                                        <td><?php echo $link['conversions'];?></td>
                                        <td><input type="text" name="chances[<?php echo $link['id'];?>]" size="2" value="<?php echo $link['weight'];?>"/></td>
                                        <td><input type="text" name="max_hits[<?php echo $link['id'];?>]" size="2" value="<?php echo $link['max_hits'];?>"/></td>
                                        <td>

                                            <form method="post" style="display:inline">
                                                <input type="hidden" name="delete_link" value="<?php echo $link['id'];?>"/>
                                                <input type="submit" class="button-primary confirm"  name="delete" value="Delete">&nbsp;
                                            </form>

                                        </td>
                                    </tr>

                                <?php } ?>
                                </tbody>
                            </table>
                            <p class="submit">
                                <input type="submit" value="Update" class="button button-primary" id="submit" name="update_chances">
                            </p>
                        </form>


                        </div> <!-- .inside -->

                    </div> <!-- .postbox -->

                </div> <!-- .meta-box-sortables .ui-sortable -->

            </div> <!-- post-body-content -->

            <!-- main content-->
            <div id="post-body-content">

                <div class="meta-box-sortables ui-sortable" >

                    <div class="postbox">

                        <h3><span>Add new Link</span></h3>
                        <div class="inside">
                            <form method="post">
                                <div class="form-field form-required">
                                    <label for="tag-name">New Link</label><br/>
                                    <input type="text" style="width:400px" aria-required="true"  name="url">
                                </div>
                                <p class="submit">
                                    <input type="submit" value="Add Link" class="button button-primary" id="submit" name="submit">
                                </p>

                            </form>
                        </div> <!-- .inside -->

                    </div> <!-- .postbox -->

                </div> <!-- .meta-box-sortables .ui-sortable -->

            </div> <!-- post-body-content -->


            <!-- main content-->
            <div id="post-body-content">

                <div class="meta-box-sortables ui-sortable" >

                    <div class="postbox">

                        <h3><span>Bulk Import</span></h3>
                        <div class="inside">
                            <p>Copy and paste the URL's one per line in the following comma delimited format:<br/>
                            <b>Link, Chances, Max Hits</b></p>
                            <p> The URL must be valid ( must contain http://)</p>
                            <p> Chances - How many chances should the link have - default is 1</p>
                            <p> Max Hits - How many hits a link can receive before it's taken out of the rotation - 0 for unlimited</p>
                            <form method="post">
                                <div class="form-field form-required">
                                    <label for="tag-name"><b>Link, Chances, Max Hits</b></label><br/>
                                    <textarea style="width:80%;height:200px" name="bulk_import"></textarea>

                                </div>
                                <p class="submit">
                                    <input type="submit" value="Bulk Import" class="button button-primary" id="submit" name="bulk_submit">
                                </p>

                            </form>
                        </div> <!-- .inside -->

                    </div> <!-- .postbox -->

                </div> <!-- .meta-box-sortables .ui-sortable -->

            </div> <!-- post-body-content -->


            <!-- pixel tracking box-->
            <div id="post-body-content">

                <div class="meta-box-sortables ui-sortable" >

                    <div class="postbox">

                        <h3><span>Tracking Pixel</span></h3>
                        <div class="inside">
                            <p>Copy and paste the code on your Thank You page:</p>


                            <form method="post">
                                <div class="form-field form-required">
                                    <label for="tag-name"><b>Tracking Code</b></label><br/>
                                    <textarea style="width:80%;height:100px" name="tracking_code"><img src='<?php echo site_url();?>/?tracking_campaign=<?php echo $campaign['id'];?>'/></textarea>

                                </div>


                            </form>
                        </div> <!-- .inside -->

                    </div> <!-- .postbox -->

                </div> <!-- .meta-box-sortables .ui-sortable -->

            </div> <!-- post-body-content -->



        </div> <!-- #post-body .metabox-holder .columns-2 -->

        <br class="clear">
    </div> <!-- #poststuff -->

</div> <!-- .wrap -->

