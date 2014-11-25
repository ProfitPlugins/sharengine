<?php

    class seStats
    {
        public function __construct($highCharts, $awesmClient)
        {
            $this->highCharts = $highCharts;
            $this->awesmClient = $awesmClient;
            // Stats for this blog only




            if($_POST['se_start_date'])
                $this->start_date = $_POST['se_start_date'];
            else
                $this->start_date = date("m/d/Y", strtotime("yesterday"));

            if($_POST['se_end_date'])
                $this->end_date = $_POST['se_end_date'];
            else
                $this->end_date = date("m/d/Y", strtotime("today"));

            $this->computeIntervals();



            // Add a user profile subpage
            add_action('admin_menu', array($this, 'addUsersPage'));
          //  add_action("admin_enqueue_scripts", array($this, "adminLoadStyles"));

            // Test the charts

            $theme = new seHighchartOption();
            $theme->colors = array('#FFFFFF', '#FFFFFF', '#FFFFFF');
            seHighchart::setOptions($theme);
            $this->highCharts->chart->height = 300;
            $this->highCharts->chart->width  = 770;
            $this->highCharts->chart->renderTo = "chart1";
            $this->highCharts->title ="";
            $this->highCharts->yAxis->title->text="";
            $this->highCharts->yAxis->min=0;

            $this->highCharts->plotOptions->series->marker->enable=false;
            //$this->highCharts->xAxis->tickInterval=3600*1000*24*$this->xTick;
            $this->highCharts->xAxis->type="datetime";
            //
            $this->awesmClient->setEndPoint("range/intervals");




            $this->awesmClient->setDefaultOptions(array(
                "interval"=>$this->interval,
                "with_metadata"=>"true",
                "with_conversions"=>"false",
                "with_zeros"=>"true",
                "start_date"=>$this->start_date."T00:00:00-08:00",
                "end_date"=>$this->end_date."T23:59:59-08:00"
            ));


            add_shortcode("se_stats_page", array($this, "statsPageFrontend")) ;

        }

        public function statsPageFrontend()
        {
            $this->adminLoadStyles();

            wp_enqueue_style("se_stats_frontend", SE_URL."css/front_end/stats.css");
            wp_register_style("se_stats_frontend");

            if(is_user_logged_in())
            {
                ob_start();

                $this->loadUsersPage();

                $content=ob_get_clean();

                $content = str_replace('<h1>Sharengine Statistics</h1>', '', $content);

                return $content;
            }
            else
            {
                return "You must be logged in before accesing this page.";
            }
        }
        public function computeIntervals()
        {



            $start_date = new DateTime($this->start_date);

            $end_date = new DateTime($this->end_date);

           // $days = $end_date->diff($start_date)->days;
            // hack to work around a php diff bug
            $y1 = $start_date->format('Y');
            $y2 = $end_date->format('Y');
            $z1 = $start_date->format('z');
            $z2 = $end_date->format('z');

            $diff = abs(intval($y1 * 365.2425 + $z1) - intval($y2 * 365.2425 + $z2));

            if($diff<5)
            {
                $this->interval = "hour";
                $this->hours = 1;
            }
            else
                if($diff<=32)
                {
                    $this->interval="day";
                    $this->hours = 24;
                }
                else
                {
                    $this->interval="week";
                    $this->hours = 7*24;
                }





        }
        public function adminLoadStyles()
        {
            wp_register_script("se_highcharts", SE_URL.'js/highcharts.js');
            wp_enqueue_script("se_highcharts");

            wp_register_script("se_admin_graphs", SE_URL.'js/se_admin_graphs.js', array('jquery', 'se_highcharts', 'se_datejs', 'se_tablePaginator'));
            wp_enqueue_script("se_admin_graphs");

            // load the styles for the stats page

            wp_register_style("se_admin_stats", SE_URL."css/admin_stats.css");
            wp_enqueue_style("se_admin_stats");

       //    wp_enqueue_style('jquery-ui-datepicker', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.3/themes/base/ui.datepicker.css');

            wp_enqueue_script('jquery-ui-datepicker');
          /*  wp_enqueue_style('jquery-ui-core');
            wp_enqueue_style('jquery-ui-datepicker ');*/
           // wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/base/jquery-ui.css');

            wp_register_style('jquery-ui-datepicker', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.3/themes/base/jquery-ui.css');
            wp_enqueue_style('jquery-ui-datepicker');

            wp_register_script("se_datejs", SE_URL."js/datejs.js");
            wp_enqueue_script("se_datejs");

            wp_register_script("se_tablePaginator", SE_URL."js/tablePaginator.js", array('jquery'));
            wp_enqueue_script("se_tablePaginator");
        }
        public function addUsersPage()
        {
            //admin only for now
            $options = get_option( SE_UPDATER_SETTINGS );

            if(!empty($options['activated']) && $options['activated'] == "Activated")
            {
                $page = add_submenu_page(SE_SLUG, ' Statistics',  'Statistics', 'manage_options', SE_SLUG.'_stats', array($this, 'loadUsersPage'));

                add_action('admin_print_styles-'.$page, array($this, "adminLoadStyles") );

                $userStatsPage = add_users_page("Sharengine Statistics", "Sharengine Statistics", "read","sharengine_user_stats", array($this, "loadUsersPage"));
                add_action('admin_print_styles-'.$userStatsPage, array($this, "adminLoadStyles") );


            }




        }

        public function view($view, $data=array())
        {

            ob_start();
            extract($data);
            include $this->path.'views/'.$view.'.php';
            $content=ob_get_clean();

            return $content;
        }

        public function loadUsersPage()
        {

            $defaultOptions['tag_2']=  addslashes(get_bloginfo('url'));
            // If this is a regular user, show the stats for himself only

            if(!current_user_can("manage_options"))
            {
                // tag stores the user id
                $defaultOptions['tag'] = get_current_user_id();
            }
            if($_GET['view_as'])
                $defaultOptions['tag']=$_GET['view_as'];
            //$defaultOptions['tag']=get_current_user_id();
            $this->awesmClient->setDefaultOptions($defaultOptions);



            if($_POST['delete_cache'])
            {
                $this->awesmClient->getCache()->delete_all( get_current_user_id() );

            }
            // load the top pages

            $options = array(
                "group_by"=>"undefined",
                "sort_type"=>"clicks",
                "sort_order"=>"undefined",
            );
            $this->awesmClient->setOptions($options);
            $clicks_json=json_decode($this->awesmClient->getResults());
            $start_date = $clicks_json->start_date;
            // format the start date
            /*$start_date = str_replace("T", " ", $start_date);
            $start_date 0= str_replace("Z", "", $start_date);*/
            //$start_date = $start_date." UTC";
            $this->clicks_today = 0;
            $this->shares_today = 0;
            $start_date = strtotime($start_date);
            $start_date = strtotime("midnight", $start_date);
            $max_value = 0;

            $found=0;
            foreach($clicks_json->totals->intervals as $interval)
            {
                // Hack to remove starting line;
                /*if($interval->clicks==0 && $found == 0 )
                { // $data[]=NULL;
                }
                else
                {
                    $data[] = $interval->clicks;
                    $found = 1;
                }*/
                $data[]=$interval->clicks;
                if($interval->clicks>$max_value)
                    $max_value=$interval->clicks;

                $this->clicks_today+=$interval->clicks;
                $this->shares_today+=$interval->shares;
            }


            $this->highCharts->yAxis->max=$max_value;
            $this->highCharts->series[] = array('showInLegend'=>false, 'name' => 'Clicks', 'data' => $data, 'pointStart'=>$start_date*1000, 'pointInterval'=>3600*1000 * $this->hours, 'marker'=>array('enabled'=>false));





            $this->awesmClient->setEndPoint("range");
            $topOptions = array(
                "group_by"=>"original_url",
                "sort_type"=>"clicks",
                "sort_order"=>"desc",
            );
            $this->awesmClient->setOptions($topOptions);
            $data['top_pages'] = json_decode($this->awesmClient->getResults());


            $socialOptions =$topOptions;
            $socialOptions['group_by'] = "service";
            $this->awesmClient->setOptions($socialOptions);

            //$data['social_networks'] = json_decode(file_get_contents("https://api.awe.sm/stats/range.json?group_by=service&sort_type=clicks&sort_order=desc&interval=hour&key=8058019345dc96c4f792c283cbac995b83c80cfdb047c940fd7a41ea68298866&with_metadata=true&with_conversions=false&per_page=25&v=3&start_date=2014-02-02T00%3A00%3A00-08%3A00&end_date=2014-02-03T23%3A59%3A59-08%3A00"));
            $data['social_networks'] = json_decode($this->awesmClient->getResults());


            $shareOptions = $topOptions;
            $shareOptions['group_by'] = 'awesm_id';

            $this->awesmClient->setOptions($shareOptions);

           // $data['shares'] = json_decode(file_get_contents("https://api.awe.sm/stats/range.json?group_by=awesm_id&sort_type=clicks&sort_order=desc&interval=hour&key=8058019345dc96c4f792c283cbac995b83c80cfdb047c940fd7a41ea68298866&with_metadata=true&with_conversions=false&per_page=25&v=3&start_date=2014-02-02T00%3A00%3A00-08%3A00&end_date=2014-02-03T23%3A59%3A59-08%3A00"));

            $data['shares'] = json_decode($this->awesmClient->getResults());


            $topUsersOptions['group_by'] ='tag';


            $this->awesmClient->setOptions($topUsersOptions);
            $data['top_users']= json_decode($this->awesmClient->getResults());


            $data['clicks_today'] = $this->clicks_today;
            $data['shares_today']=$this->shares_today;
            $data['start_date']=$this->start_date;
            $data['end_date'] = $this->end_date;

            //Get the latest cache time:


            $data['cache_time']=$this->awesmClient->getCache()->getTime(get_current_user_id());


            echo $this->view('admin/stats', $data);
        }
    }