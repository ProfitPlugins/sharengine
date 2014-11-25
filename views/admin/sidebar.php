
<?php
    global $wpdb;
    // Promotions count
    $count = $wpdb->get_col("SELECT COUNT(*) FROM ".$wpdb->prefix.SE_PROMOS);
    $count = $count[0];


?>
<div id="sidebar">
    <ul class="mainNav">
        <li <?php if(!$_GET['se_page'] && $_GET['page']!=SE_SLUG."_promotions") echo "class='active'";?>>
            <a href="admin.php?page=<?php echo SE_SLUG;?>"><i class="fa fa-dashboard"></i><br>Dashboard</a>
        </li>
        <li  <?php if($_GET['se_page']=="profile_fields") echo "class='active'";?>>
            <a href="admin.php?page=<?php echo SE_SLUG;?>&se_page=profile_fields"><i class="fa fa-users"></i><br>Affiliate Fields</a>
        </li>
        <li  <?php if($_GET['se_page']=="custom_profile_fields") echo "class='active'";?>>
            <a href="admin.php?page=<?php echo SE_SLUG;?>&se_page=custom_profile_fields"><i class="fa fa-user"></i><br>Permissions</a>
        </li>
<!--        <li>-->
<!--            <a href="admin.php?page=--><?php //echo SE_SLUG;?><!--&se_page=profile_fields"><i class="fa fa-bar-chart-o"></i><br>Statistics</a>-->
<!--        </li>-->
        <li  <?php if(!$_GET['page'] == SE_SLUG."_promotions") echo "class='active'";?>>
            <a href="admin.php?page=<?php echo SE_SLUG;?>_promotions"><i class="fa fa-comments"></i><br>Promotions</a>
            <span class="badge badge-mNav"><?php echo $count;?></span>
        </li>

<!--        <li  --><?php //if(!$_GET['page'] == SE_SLUG."tools") echo "class='active'";?><!-->
<!--            <a href="admin.php?page=--><?php //echo SE_SLUG;?><!--_tools"><i class="fa fa-cog"></i><br>Tools</a>-->
<!---->
<!--        </li>-->




        <li  <?php if(!$_GET['page'] == SE_SLUG && $_GET['se_page']==SE_SLUG."_integration") echo "class='active'";?>>
            <a href="admin.php?page=<?php echo SE_SLUG;?>&se_page=<?php echo SE_SLUG;?>_integration"><i class="fa fa-cog"></i><br>Integrations</a>

        </li>

    </ul>
</div> <!-- /sidebar -->