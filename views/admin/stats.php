<div id='wrap'>
<h1><?php echo SE_NAME;?> Statistics</h1>

<?php if(current_user_can("manage_options")): ?>
    <?php if(isset($_GET['view_as'])):?>
        <?php

        $user = get_user_by('id', $_GET['view_as']);

        $username = $user->user_login;

        ?>
        Viewing Statistics as: <strong><?php echo $username;?></strong>
        <?php
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $base_link = strtok($actual_link, '?');

        $view_as_admin = $base_link."?page=".SE_SLUG."_stats";


        ?>

        <a href='<?php /*echo admin_url("admin.php?page=".SE_SLUG."_stats");*/ echo $view_as_admin;?>'>View as admin</a>
    <?php else: ?>
        <h2 class="inline-title" >View as:</h2>
       <form style='display:inline' method='get' action='<?php echo $view_as_admin;?>'>
        <?php wp_dropdown_users("name=view_as");?>
         <input type='hidden' name='page' value='<?PHP echo SE_SLUG;?>_stats'/>
        <input type='submit' value='Go' class='button-primary'/>
       </form>
    <?php endif;?>


<?php endif;?>

<div class="report-date-controls">


    <nav class="iblock tab-bar-wrapper">
        <div class="tab-bar">
            <div class="tab-element grey date-range-select <?php if($start_date == date("m/d/Y")) echo 'active';?>" id='se_day' >
                <a href="#" data-span="day" class="tab-link">Day</a>
            </div>
            <div class="tab-element grey date-range-select" id='se_week'>
                <a href="#" data-span="week" class="tab-link">Week</a>
            </div>
            <div class="tab-element grey date-range-select" id='se_month'>
                <a href="#" data-span="month" class="tab-link">Month</a>
            </div>
        </div>
    </nav>
    <form method='post' style='display:inline'>
    <div class="date_range iblock">
        <div class="datepicker">
            <input type="text" name='se_start_date' value="<?php echo $start_date;?>" class="custom_date" id="se_start_date">
        </div>
        <img alt="Select a date range" src="<?php echo SE_IMAGES_URL;?>calendar_arrow.png">
        <div class="datepicker">
            <input type="text" name='se_end_date' value="<?php echo $end_date;?>" class="custom_date" id="se_end_date">
        </div>
    </div>
        <input class='button-primary' type='submit' value='Go' style='margin-top:4px'/>
    </form>
</div> <br/><br/><br/>
<div id='se_reports'>

    <?php
    ?>


    <div id="c45" class="module wide"><div class="header module-header">
            <h3 class="module-title" data-tooltip="3f,y,30,2p,3d,33,39,38,y,1m,y,38,2t,3c,38,y,18,y,38,2t,3c,38,y,1m,y,1v,30,2x,2r,2z,37,y,3h" aria-describedby="ui-tooltip-0">Clicks</h3>
           <!-- <div class="module-menu-container"><ul class="module-menu"><li class="dropdown">
                        <a data-role="explore" class="ui-magnify" href="#"><span></span></a>
                        <a data-role="open" class="settings" href="#"><span></span></a>
                        <ul class="dropdown-menu menu">
                            <li class="first edit">
                                <span data-role="config">Edit</span>
                            </li>
                            <li class="duplicate">
                                <span data-role="duplicate">Duplicate</span>
                            </li>
                            <li class="export">
                                <span data-role="export">Export</span>
                            </li>
                            <li class="last delete">
                                <span data-role="destroy">Delete</span>
                            </li>
                        </ul>
                    </li>
                </ul></div> -->
        </div>

        <div class="module-content"><div class="highcharts-container" id="highcharts-0" style="position: relative; overflow: hidden; width: 778px; height: 285px; text-align: left; line-height: normal; z-index: 0; font-family: &quot;Lucida Grande&quot;,&quot;Lucida Sans Unicode&quot;,Verdana,Arial,Helvetica,sans-serif; font-size: 12px; left: 0.5px; top: 0px;">
                <div id='chart1' class='chart'></div>

                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="778" height="285"><defs><clipPath id="highcharts-1"><rect fill="none" x="0" y="0" width="778" height="275"/></clipPath></defs><rect rx="5" ry="5" fill="#FFFFFF" x="0" y="0" width="778" height="285" stroke-width="0"/><g class="highcharts-grid" zIndex="1"><path fill="none" d="M 98.5 10 L 98.5 285" stroke="#D8D8D8" stroke-width="1" stroke-dasharray="1,3" zIndex="1"/><path fill="none" d="M 198.5 10 L 198.5 285" stroke="#D8D8D8" stroke-width="1" stroke-dasharray="1,3" zIndex="1"/><path fill="none" d="M 297.5 10 L 297.5 285" stroke="#D8D8D8" stroke-width="1" stroke-dasharray="1,3" zIndex="1"/><path fill="none" d="M 396.5 10 L 396.5 285" stroke="#D8D8D8" stroke-width="1" stroke-dasharray="1,3" zIndex="1"/><path fill="none" d="M 496.5 10 L 496.5 285" stroke="#D8D8D8" stroke-width="1" stroke-dasharray="1,3" zIndex="1"/><path fill="none" d="M 595.5 10 L 595.5 285" stroke="#D8D8D8" stroke-width="1" stroke-dasharray="1,3" zIndex="1"/><path fill="none" d="M 694.5 10 L 694.5 285" stroke="#D8D8D8" stroke-width="1" stroke-dasharray="1,3" zIndex="1"/><path fill="none" d="M -0.5 10 L -0.5 285" stroke="#D8D8D8" stroke-width="1" stroke-dasharray="1,3" zIndex="1"/></g><g class="highcharts-grid" zIndex="1"><path fill="none" d="M 0 220.5 L 778 220.5" stroke="#D8D8D8" stroke-width="1" stroke-dasharray="1,3" zIndex="1"/><path fill="none" d="M 0 154.5 L 778 154.5" stroke="#D8D8D8" stroke-width="1" stroke-dasharray="1,3" zIndex="1"/><path fill="none" d="M 0 89.5 L 778 89.5" stroke="#D8D8D8" stroke-width="1" stroke-dasharray="1,3" zIndex="1"/><path fill="none" d="M 0 23.5 L 778 23.5" stroke="#D8D8D8" stroke-width="1" stroke-dasharray="1,3" zIndex="1"/><path fill="none" d="M 0 285.5 L 778 285.5" stroke="#D8D8D8" stroke-width="1" stroke-dasharray="1,3" zIndex="1"/></g><g class="highcharts-axis" zIndex="2"><path fill="none" d="M 0 285.5 L 778 285.5" stroke="#E8E8E8" stroke-width="1" zIndex="7" visibility="visible"/></g><g class="highcharts-axis" zIndex="2"><path fill="none" d="M -0.5 10 L -0.5 285" stroke="#E8E8E8" stroke-width="1" zIndex="7" visibility="visible"/></g><g class="highcharts-series-group" zIndex="3"><g class="highcharts-series" visibility="visible" zIndex="0.1" transform="translate(0,10)" clip-path="url(#highcharts-1)"><path fill="none" d="M 0 275 L 16.5531914893617 275 L 33.1063829787234 275 L 49.659574468085104 209.5 L 66.2127659574468 275 L 82.7659574468085 275 L 99.31914893617021 275 L 115.8723404255319 275 L 132.4255319148936 13.1 L 148.9787234042553 275 L 165.531914893617 275 L 182.08510638297872 275 L 198.63829787234042 209.5 L 215.1914893617021 275 L 231.7446808510638 275 L 248.29787234042553 275 L 264.8510638297872 78.6 L 281.40425531914894 144 L 297.9574468085106 275 L 314.51063829787233 209.5 L 331.063829787234 275 L 347.6170212765957 13.1 L 364.17021276595744 275 L 380.7234042553191 275 L 397.27659574468083 275 L 413.82978723404256 275 L 430.3829787234042 275 L 446.93617021276594 275 L 463.4893617021276 275 L 480.04255319148933 275 L 496.59574468085106 275 L 513.1489361702128 275 L 529.7021276595744 275 L 546.2553191489361 275 L 562.8085106382979 275 L 579.3617021276596 275 L 595.9148936170212 275 L 612.468085106383 275 L 629.0212765957447 275 L 645.5744680851063 275 L 662.127659574468 275 L 678.6808510638298 275 L 695.2340425531914 275 L 711.7872340425531 275 L 728.3404255319149 275 L 744.8936170212766 275 L 761.4468085106382 275 L 778 275" stroke="#B40617" stroke-width="2" zIndex="1"/></g><g class="highcharts-markers" visibility="visible" zIndex="0.1" transform="translate(0,10)" clip-path="none"><path fill="#B40617" d="M 314.51063829787233 204.5 C 321.17063829787236 204.5 321.17063829787236 214.5 314.51063829787233 214.5 C 307.8506382978723 214.5 307.8506382978723 204.5 314.51063829787233 204.5 Z" stroke="#FFFFFF" stroke-width="1" visibility="hidden"/></g></g><g class="highcharts-axis-labels" zIndex="7"><text x="5" y="280" style="font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Verdana, Arial, Helvetica, sans-serif;font-size:11px;color:#AAAAAA;line-height:14px;font-size:9px;fill:#AAAAAA;" text-anchor="start" visibility="visible"><tspan x="5">00:00</tspan></text><text x="104.31914893617021" y="280" style="font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Verdana, Arial, Helvetica, sans-serif;font-size:11px;color:#AAAAAA;line-height:14px;font-size:9px;fill:#AAAAAA;" text-anchor="start" visibility="visible"><tspan x="104.31914893617021">06:00</tspan></text><text x="203.63829787234042" y="280" style="font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Verdana, Arial, Helvetica, sans-serif;font-size:11px;color:#AAAAAA;line-height:14px;font-size:9px;fill:#AAAAAA;" text-anchor="start" visibility="visible"><tspan x="203.63829787234042">12:00</tspan></text><text x="302.9574468085106" y="280" style="font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Verdana, Arial, Helvetica, sans-serif;font-size:11px;color:#AAAAAA;line-height:14px;font-size:9px;fill:#AAAAAA;" text-anchor="start" visibility="visible"><tspan x="302.9574468085106">18:00</tspan></text><text x="402.27659574468083" y="280" style="font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Verdana, Arial, Helvetica, sans-serif;font-size:11px;color:#AAAAAA;line-height:14px;font-size:9px;fill:#AAAAAA;" text-anchor="start" visibility="visible"><tspan x="402.27659574468083">02/3</tspan></text><text x="501.59574468085106" y="280" style="font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Verdana, Arial, Helvetica, sans-serif;font-size:11px;color:#AAAAAA;line-height:14px;font-size:9px;fill:#AAAAAA;" text-anchor="start" visibility="visible"><tspan x="501.59574468085106">06:00</tspan></text><text x="600.9148936170212" y="280" style="font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Verdana, Arial, Helvetica, sans-serif;font-size:11px;color:#AAAAAA;line-height:14px;font-size:9px;fill:#AAAAAA;" text-anchor="start" visibility="visible"><tspan x="600.9148936170212">12:00</tspan></text><text x="0" y="0" style="font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Verdana, Arial, Helvetica, sans-serif;font-size:11px;color:#AAAAAA;line-height:14px;font-size:9px;fill:#AAAAAA;" text-anchor="start" visibility="hidden"><tspan x="0">18:00</tspan></text></g><g class="highcharts-axis-labels" zIndex="7"><text x="0" y="0" style="font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Verdana, Arial, Helvetica, sans-serif;font-size:11px;width:369px;color:#AAAAAA;line-height:14px;font-size:9px;fill:#AAAAAA;" text-anchor="end" visibility="hidden"><tspan x="0">0</tspan></text><text x="15" y="214.52380952380952" style="font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Verdana, Arial, Helvetica, sans-serif;font-size:11px;width:369px;color:#AAAAAA;line-height:14px;font-size:9px;fill:#AAAAAA;" text-anchor="end" visibility="visible"><tspan x="15">1</tspan></text><text x="15" y="149.04761904761907" style="font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Verdana, Arial, Helvetica, sans-serif;font-size:11px;width:369px;color:#AAAAAA;line-height:14px;font-size:9px;fill:#AAAAAA;" text-anchor="end" visibility="visible"><tspan x="15">2</tspan></text><text x="15" y="83.57142857142861" style="font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Verdana, Arial, Helvetica, sans-serif;font-size:11px;width:369px;color:#AAAAAA;line-height:14px;font-size:9px;fill:#AAAAAA;" text-anchor="end" visibility="visible"><tspan x="15">3</tspan></text><text x="15" y="18.09523809523813" style="font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Verdana, Arial, Helvetica, sans-serif;font-size:11px;width:369px;color:#AAAAAA;line-height:14px;font-size:9px;fill:#AAAAAA;" text-anchor="end" visibility="visible"><tspan x="15">4</tspan></text></g><g class="highcharts-tooltip" zIndex="8" style="padding:0;white-space:nowrap;display:none;" visibility="hidden" transform="translate(293,225)"><rect rx="5" ry="5" fill="none" x="0" y="0" width="10" height="10" stroke-width="5" fill-opacity="0.85" isShadow="true" stroke="black" stroke-opacity="0.049999999999999996" transform="translate(1, 1)"/><rect rx="5" ry="5" fill="none" x="0" y="0" width="10" height="10" stroke-width="3" fill-opacity="0.85" isShadow="true" stroke="black" stroke-opacity="0.09999999999999999" transform="translate(1, 1)"/><rect rx="5" ry="5" fill="none" x="0" y="0" width="10" height="10" stroke-width="1" fill-opacity="0.85" isShadow="true" stroke="black" stroke-opacity="0.15" transform="translate(1, 1)"/><rect rx="5" ry="5" fill="rgb(255,255,255)" x="0" y="0" width="10" height="10" stroke-width="2" fill-opacity="0.85" stroke="#B40617" anchorX="22" anchorY="-5"/><text x="5" y="18" style="font-family:&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, Verdana, Arial, Helvetica, sans-serif;font-size:12px;color:#333333;fill:#333333;" zIndex="1"><tspan style="font-size: 10px" x="5">Sunday, Feb 2, 19:00</tspan><tspan style="fill:#B40617" dy="14" x="5">Clicks</tspan><tspan dx="3">: </tspan><tspan style="font-weight:bold" dx="3">1</tspan></text></g><g class="highcharts-tracker" zIndex="9"><g visibility="visible" zIndex="1" transform="translate(0,10)" clip-path="url(#highcharts-1)"><path fill="none" d="M -10 275 L 0 275 L 16.5531914893617 275 L 33.1063829787234 275 L 49.659574468085104 209.5 L 66.2127659574468 275 L 82.7659574468085 275 L 99.31914893617021 275 L 115.8723404255319 275 L 132.4255319148936 13.1 L 148.9787234042553 275 L 165.531914893617 275 L 182.08510638297872 275 L 198.63829787234042 209.5 L 215.1914893617021 275 L 231.7446808510638 275 L 248.29787234042553 275 L 264.8510638297872 78.6 L 281.40425531914894 144 L 297.9574468085106 275 L 314.51063829787233 209.5 L 331.063829787234 275 L 347.6170212765957 13.1 L 364.17021276595744 275 L 380.7234042553191 275 L 397.27659574468083 275 L 413.82978723404256 275 L 430.3829787234042 275 L 446.93617021276594 275 L 463.4893617021276 275 L 480.04255319148933 275 L 496.59574468085106 275 L 513.1489361702128 275 L 529.7021276595744 275 L 546.2553191489361 275 L 562.8085106382979 275 L 579.3617021276596 275 L 595.9148936170212 275 L 612.468085106383 275 L 629.0212765957447 275 L 645.5744680851063 275 L 662.127659574468 275 L 678.6808510638298 275 L 695.2340425531914 275 L 711.7872340425531 275 L 728.3404255319149 275 L 744.8936170212766 275 L 761.4468085106382 275 L 778 275 L 788 275" isTracker="true" stroke-linejoin="bevel" visibility="visible" stroke-opacity="0.000001" stroke="rgb(192,192,192)" stroke-width="22" style=""/></g></g></svg></div>

           <script type='text/javascript' src="<?php echo SE_URL;?>js/highcharts.js"></script>

            <script type='text/javascript'>



                <?php echo $this->highCharts->render("toChart");?>
            </script>



        </div>
    </div>


    <div id="c47" class="module"><div class="header module-header">
            <h3 class="module-title" data-tooltip="3f,y,30,2p,3d,33,39,38,y,1m,y,38,2t,3c,38,y,18,y,38,2t,3c,38,y,1m,y,29,39,2x,2r,2z,w,24,33,33,2z,y,3h" aria-describedby="ui-tooltip-16">Quick Look</h3>
            <div class="module-menu-container"><ul class="module-menu"><li class="dropdown">
                        <a data-role="explore" class="ui-magnify" href="#"><span></span></a>
                        <a data-role="open" class="settings" href="#"><span></span></a>
                        <ul class="dropdown-menu menu">
                            <li class="first edit">
                                <span data-role="config">Edit</span>
                            </li>
                            <li class="duplicate">
                                <span data-role="duplicate">Duplicate</span>
                            </li>
                            <li class="export">
                                <span data-role="export">Export</span>
                            </li>
                            <li class="last delete">
                                <span data-role="destroy">Delete</span>
                            </li>
                        </ul>
                    </li>
                </ul></div>
        </div>

        <div class="module-content">
            <div class="sparkline-content">
                <div class="module-chart sparkline-chart"><div class="highcharts-container" id="highcharts-2" style="position: relative; overflow: hidden; width: 162px; height: 130px; text-align: left; line-height: normal; z-index: 0; font-family: &quot;Lucida Grande&quot;,&quot;Lucida Sans Unicode&quot;,Verdana,Arial,Helvetica,sans-serif; font-size: 12px; left: 0.5px; top: 0px;"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="162" height="130"><defs><clipPath id="highcharts-3"><rect fill="none" x="0" y="0" width="162" height="130"/></clipPath></defs><g class="highcharts-grid" zIndex="1"/><g class="highcharts-grid" zIndex="1"/><g class="highcharts-axis" zIndex="2"/><g class="highcharts-axis" zIndex="2"/><g class="highcharts-series-group" zIndex="3"><g class="highcharts-series" visibility="visible" zIndex="0.1" clip-path="url(#highcharts-3)"><path fill="rgb(38,136,146)" d="M 0 6.2 L 162 106.8 162 130 0 130" fill-opacity="0.75" zIndex="0"/><path fill="none" d="M 0 6.2 L 162 106.8" stroke="#268892" stroke-width="2" zIndex="1"/></g><g class="highcharts-markers" visibility="visible" zIndex="0.1" clip-path="none"><path fill="#268892" d="M 0 1.2000000000000002 C 6.66 1.2000000000000002 6.66 11.2 0 11.2 C -6.66 11.2 -6.66 1.2000000000000002 0 1.2000000000000002 Z" stroke="#FFFFFF" stroke-width="1" visibility="hidden"/></g></g><g class="highcharts-axis-labels" zIndex="7"/><g class="highcharts-axis-labels" zIndex="7"/><g class="highcharts-tracker" zIndex="9"><g visibility="visible" zIndex="1" clip-path="url(#highcharts-3)"><path fill="none" d="M -10 6.2 L 0 6.2 L 162 106.8 L 172 106.8" isTracker="true" stroke-linejoin="bevel" visibility="visible" stroke-opacity="0.000001" stroke="rgb(192,192,192)" stroke-width="22" style=""/></g></g></svg></div></div>
                <div class="sparkline-data-wrapper">
                    <p class="sparkline-data nowrap">
                        <span class="sparkline-data-count"><?php echo $clicks_today;?></span>
                        <span class="sparkline-data-label">Clicks</span>
                    </p>

                    <!--<p class="sparkline-data nowrap">
                        <span class="sparkline-data-change">-21%</span> this day
                    </p>-->

                </div>
            </div>

            <div class="sparkline-divider"></div>


            <div class="sparkline-content">
                <div class="module-chart sparkline-chart"><div class="highcharts-container" id="highcharts-4" style="position: relative; overflow: hidden; width: 162px; height: 130px; text-align: left; line-height: normal; z-index: 0; font-family: &quot;Lucida Grande&quot;,&quot;Lucida Sans Unicode&quot;,Verdana,Arial,Helvetica,sans-serif; font-size: 12px; left: 0.5px; top: 0px;"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="162" height="130"><defs><clipPath id="highcharts-5"><rect fill="none" x="0" y="0" width="162" height="130"/></clipPath></defs><g class="highcharts-grid" zIndex="1"/><g class="highcharts-grid" zIndex="1"/><g class="highcharts-axis" zIndex="2"/><g class="highcharts-axis" zIndex="2"/><g class="highcharts-series-group" zIndex="3"><g class="highcharts-series" visibility="visible" zIndex="0.1" clip-path="url(#highcharts-5)"><path fill="rgb(203,145,159)" d="M 0 6.2 L 162 96.2 162 130 0 130" fill-opacity="0.75" zIndex="0"/><path fill="none" d="M 0 6.2 L 162 96.2" stroke="#CB919F" stroke-width="2" zIndex="1"/></g><g class="highcharts-markers" visibility="visible" zIndex="0.1" clip-path="none"><path fill="#CB919F" d="M 0 1.2000000000000002 C 6.66 1.2000000000000002 6.66 11.2 0 11.2 C -6.66 11.2 -6.66 1.2000000000000002 0 1.2000000000000002 Z" stroke="#FFFFFF" stroke-width="1" visibility="hidden"/></g></g><g class="highcharts-axis-labels" zIndex="7"/><g class="highcharts-axis-labels" zIndex="7"/><g class="highcharts-tracker" zIndex="9"><g visibility="visible" zIndex="1" clip-path="url(#highcharts-5)"><path fill="none" d="M -10 6.2 L 0 6.2 L 162 96.2 L 172 96.2" isTracker="true" stroke-linejoin="bevel" visibility="visible" stroke-opacity="0.000001" stroke="rgb(192,192,192)" stroke-width="22" style=""/></g></g></svg></div></div>
                <div class="sparkline-data-wrapper">
                    <p class="sparkline-data nowrap">
                        <span class="sparkline-data-count"><?php echo $shares_today;?></span>
                        <span class="sparkline-data-label">Shares</span>
                    </p>

                    <!--<p class="sparkline-data nowrap">
                        <span class="sparkline-data-change">+0%</span> this day
                    </p>-->

                </div>
            </div>




        </div>
    </div>


    <div id="c49" class="module"><div class="header module-header">
            <h3 class="module-title" data-tooltip="3f,y,30,2p,3d,33,39,38,y,1m,y,38,2t,3c,38,y,18,y,38,2t,3c,38,y,1m,y,2c,33,34,w,1v,33,32,38,2t,32,38,y,3h" aria-describedby="ui-tooltip-12">Top Content</h3>
            <div class="module-menu-container"><ul class="module-menu"><li class="dropdown">
                        <a data-role="explore" class="ui-magnify" href="#"><span></span></a>
                        <a data-role="open" class="settings" href="#"><span></span></a>
                        <ul class="dropdown-menu menu">
                            <li class="first edit">
                                <span data-role="config">Edit</span>
                            </li>
                            <li class="duplicate">
                                <span data-role="duplicate">Duplicate</span>
                            </li>
                            <li class="export">
                                <span data-role="export">Export</span>
                            </li>
                            <li class="last delete">
                                <span data-role="destroy">Delete</span>
                            </li>
                        </ul>
                    </li>
                </ul></div>
        </div>

        <div class="module-content"><table class="module-table" id='se_clicks_module'>
                <thead>
                <tr class="module-table-header-wrapper">
                    <th class="module-table-text module-table-header">Original URL</th>
                    <th class="module-table-text module-table-header">Clicks</th>
                </tr>
                </thead>
                <tbody>
                <?php

                foreach($top_pages->groups as $page) {?>
                <tr class="striped">
                    <td  class="module-table-text module-explorable">

                        <div class="text">
                            <div class="primary-text">

                            </div>

                            <div class="secondary-text">
                                <a href="<?php echo $page->original_url;?>"><?php echo substr($page->original_url, 0, 50);?>..</a>
                            </div>

                        </div>
                    </td><td class="module-table-text module-table-value"><?php echo $page->clicks;?></td>
                </tr>
                <?php

                } ?>



                </tbody>
            </table>

        </div>
    </div>

    <!-- Module Social Networks -->
    <div id="c53" class="module"><div class="header module-header">
            <h3 class="module-title" data-tooltip="3f,y,30,2p,3d,33,39,38,y,1m,y,38,2t,3c,38,y,18,y,38,2t,3c,38,y,1m,y,2c,33,34,w,2b,33,2r,2x,2p,30,w,26,2t,38,3b,33,36,2z,37,y,3h" aria-describedby="ui-tooltip-98">Top Social Networks</h3>
            <div class="module-menu-container"><ul class="module-menu"><li class="dropdown">
                        <a data-role="explore" class="ui-magnify" href="#"><span></span></a>
                        <a data-role="open" class="settings" href="#"><span></span></a>
                        <ul class="dropdown-menu menu">
                            <li class="first edit">
                                <span data-role="config">Edit</span>
                            </li>
                            <li class="duplicate">
                                <span data-role="duplicate">Duplicate</span>
                            </li>
                            <li class="export">
                                <span data-role="export">Export</span>
                            </li>
                            <li class="last delete">
                                <span data-role="destroy">Delete</span>
                            </li>
                        </ul>
                    </li>
                </ul></div>
        </div>

        <div class="module-content"><table class="module-table" id='se_networks_module'>
                <thead>
                <tr class="module-table-header-wrapper">
                    <th class="module-table-text module-table-header">service</th>
                    <th class="module-table-text module-table-header">Clicks</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($social_networks->groups as $network) {
                    if($network->service == "google_plusone_share")
                        $serviceName = "google+";
                    else
                        $serviceName = $network->service;
                    ?>
                <tr data-tooltip="3f,3h" class="striped">
                    <td data-group-name="twitter" class="module-table-text module-explorable">

                        <img src="<?php echo SE_IMAGES_URL;?>awesm_icons/<?php echo $serviceName;?>.png" class="module-table-icon">

                        <div class="text">
                            <div class="primary-text">
                                <?php echo ucfirst($serviceName);?>
                            </div>

                        </div>
                    </td><td class="module-table-text module-table-value"><?php echo $network->clicks;?></td>
                </tr>
                <?php } ?>


                </tbody>
            </table>

        </div>
    </div>
    <!-- module social networks end-->

    <!--module shares start-->
    <div id="c59" class="module"><div class="header module-header">
        <h3 class="module-title" data-tooltip="3f,y,30,2p,3d,33,39,38,y,1m,y,38,2t,3c,38,y,18,y,38,2t,3c,38,y,1m,y,2c,33,34,w,2b,2w,2p,36,2t,37,y,3h" aria-describedby="ui-tooltip-97">Top Shares</h3>
        <div class="module-menu-container"><ul class="module-menu"><li class="dropdown">
                    <a data-role="explore" class="ui-magnify" href="#"><span></span></a>
                    <a data-role="open" class="settings" href="#"><span></span></a>
                    <ul class="dropdown-menu menu">
                        <li class="first edit">
                            <span data-role="config">Edit</span>
                        </li>
                        <li class="duplicate">
                            <span data-role="duplicate">Duplicate</span>
                        </li>
                        <li class="export">
                            <span data-role="export">Export</span>
                        </li>
                        <li class="last delete">
                            <span data-role="destroy">Delete</span>
                        </li>
                    </ul>
                </li>
            </ul></div>
    </div>

    <div class="module-content"><table class="module-table" id='se_shares_module'>
    <thead>
    <tr class="module-table-header-wrapper">
        <th class="module-table-text module-table-header">Share</th>
        <th class="module-table-text module-table-header">Clicks</th>
    </tr>
    </thead>
    <tbody>
    <?php


    foreach($shares->groups as $share) {?>
    <tr class="stripped">
        <td data-group-name="shrn.it_fu" class="module-table-text module-explorable">

            <div class="text">
                <div class="primary-text">

                </div>

                <div class="secondary-text">
                    <a href="<?php echo $share->original_url;?>"><?php echo substr($share->metadata->original_url, 0 , 50);?>..</a>
                </div>

            </div>
        </td><td class="module-table-text module-table-value"><?php echo $share->clicks;?></td>
    </tr>
    <?php } ?>

    </tbody>
    </table>

    </div>
    </div>
    <!-- module shares end -->

<!-- module top users -->
<?php if(current_user_can("manage_options")): ?>
    <!--module shares start-->
    <div id="c59" class="module"><div class="header module-header">
            <h3 class="module-title">Top Users Clicks</h3>

        </div>

        <div class="module-content"><table class="module-table" id='se_top_clicks'>
                <thead>
                <tr class="module-table-header-wrapper">
                    <th class="module-table-text module-table-header">User</th>
                    <th class="module-table-text module-table-header">Clicks</th>
                </tr>
                </thead>
                <tbody>
                <?php


                foreach($top_users->groups as $top_user) {

                    $user = get_user_by('id', $top_user->tag);

                    $username = $user->user_login;

                    $usernames[$top_user->tag] = $username;
                    if($username) {
                    ?>
                    <tr class="stripped">
                        <td data-group-name="shrn.it_fu" class="module-table-text module-explorable">

                            <div class="text">
                                <div class="primary-text">

                                </div>

                                <div class="secondary-text">
                                    <a href="<?php echo admin_url("admin.php?page=".SE_SLUG."_stats&view_as={$top_user->tag}");?>"><?php echo $username;?></a>
                                </div>

                            </div>
                        </td><td class="module-table-text module-table-value"><?php echo $top_user->clicks;?></td>
                    </tr>
                <?php }} ?>

                </tbody>
            </table>

        </div>
    </div>
    <!-- module shares end -->

    <!--module shares start-->
    <div id="c59" class="module"><div class="header module-header">
            <h3 class="module-title">Top Users Shares</h3>

        </div>

        <div class="module-content"><table class="module-table" id='se_top_shares'>
                <thead>
                <tr class="module-table-header-wrapper">
                    <th class="module-table-text module-table-header">User</th>
                    <th class="module-table-text module-table-header">Shares</th>
                </tr>
                </thead>
                <tbody>
                <?php


                foreach($top_users->groups as $top_user) {



                    $username = $usernames[$top_user->tag];
                    if($username){
                    ?>
                    <tr class="stripped">
                        <td data-group-name="shrn.it_fu" class="module-table-text module-explorable">

                            <div class="text">
                                <div class="primary-text">

                                </div>

                                <div class="secondary-text">
                                    <a href="<?php echo admin_url("admin.php?page=".SE_SLUG."_stats&view_as={$top_user->tag}");?>"><?php echo $username;?></a>
                                </div>

                            </div>
                        </td><td class="module-table-text module-table-value"><?php echo $top_user->shares;?></td>
                    </tr>
                <?php }}?>

                </tbody>
            </table>

        </div>
    </div>
    <!-- module shares end -->

<?php endif;?>
</div>

<!-- Container -->
</div>



<?php


?>
<div style='text-align:center; width:1200px'><!-- Delete cache -->
<form method='post'>
    Stats accurate as of: <strong><?php echo date("m/d/Y H:i A",$cache_time);?></strong>&nbsp;&nbsp;<input class='button-primary' type='submit' name='delete_cache' value='Delete Cache!' style='margin-top:4px'/>
</form></div>