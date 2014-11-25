;
jQuery(document).ready(function(){


        jQuery('.custom_date').datepicker({
            dateFormat : 'mm/dd/yy',
            maxDate : new Date()
        });
        jQuery('#ui-datepicker-div').css('clip', 'auto');

        jQuery('#se_day').click(function(){
            jQuery(".tab-element").removeClass("active");
            jQuery(this).addClass('active');


            td =Date.parse('yesterday').toString("MM/dd/yyyy");

            jQuery('#se_start_date').val(td);

        });
        jQuery('#se_week').click(function(){
            jQuery(".tab-element").removeClass("active");
            jQuery(this).addClass('active');

            week =new  Date().last().week().toString("MM/dd/yyyy");
            jQuery('#se_start_date').val(week);
        });
        jQuery('#se_month').click(function(){
            jQuery(".tab-element").removeClass("active");
            jQuery(this).addClass('active');

            month = new Date().last().month().toString("MM/dd/yyyy");
            jQuery('#se_start_date').val(month);
        });

        jQuery('.ui-state-default').click(function(){
            jQuery(".tab-element").removeClass("active");
        });



    jQuery('#se_networks_module').tablePaginator();
    jQuery('#se_clicks_module').tablePaginator();
    jQuery('#se_shares_module').tablePaginator();
    jQuery('#se_top_clicks').tablePaginator();
    jQuery('#se_top_shares').tablePaginator();


    /*
    // Shares
    jQuery.ajax({
        type: "POST",
        url: "http://api.awe.sm/stats/range/intervals.json",
        data: {
            v: 3,
            key: "8058019345dc96c4f792c283cbac995b83c80cfdb047c940fd7a41ea68298866",
            start_date: "2013-12-01",
            end_date: "2014-01-01",
            with_zeros: true
        },
        dataType: "jsonp",
        success: function (awesmResponse) {
            console.log(awesmResponse);
            // Reformat awe.sm Stats API output into a Highcharts series
            var hcSeriesIntervals = [];
            for (var i = 0, iMax = awesmResponse["totals"]["intervals"].length; i < iMax; i++) {
                hcSeriesIntervals.push(awesmResponse["totals"]["intervals"][i]["shares"]);
            }
            // Create a new Highcharts chart with the reformatted data
            var graph = new Highcharts.Chart({
                chart: {
                    renderTo: "graphHolder1",
                    defaultSeriesType: "line"
                },
                title : {
                    text: "Active shares this month"
                },
                xAxis: {
                    type: "datetime",
                    title: {
                        text: "Date"
                    }
                },
                yAxis: {
                    title: {
                        text: "Shares"
                    },
                    min: 0
                },
                legend: {
                    enabled: false
                },
                series: [{
                    name: 'Shares',
                    pointInterval: 24 * 60 * 60 * 1000, // 1 day in milliseconds
                    pointStart: Date.UTC(2013, 11, 01),
                    data: hcSeriesIntervals
                }]
            });
        }
    });

    jQuery.ajax({
        type: "POST",
        url: "http://api.awe.sm/stats/range/intervals.json",
        data: {
            v: 3,
            key: "8058019345dc96c4f792c283cbac995b83c80cfdb047c940fd7a41ea68298866",
            start_date: "2013-12-01",
            end_date: "2014-01-01",
            with_zeros: true
        },
        dataType: "jsonp",
        success: function (awesmResponse) {
            console.log(awesmResponse);
            // Reformat awe.sm Stats API output into a Highcharts series
            var hcSeriesIntervals = [];
            for (var i = 0, iMax = awesmResponse["totals"]["intervals"].length; i < iMax; i++) {
                hcSeriesIntervals.push(awesmResponse["totals"]["intervals"][i]["clicks"]);
            }
            // Create a new Highcharts chart with the reformatted data
            var graph = new Highcharts.Chart({
                chart: {
                    renderTo: "clicksHolder",
                    defaultSeriesType: "line"
                },
                title : {
                    text: "Clicks this month"
                },
                xAxis: {
                    type: "datetime",
                    title: {
                        text: "Date"
                    }
                },
                yAxis: {
                    title: {
                        text: "Clicks"
                    },
                    min: 0
                },
                legend: {
                    enabled: false
                },
                series: [{
                    name: 'Clicks',
                    pointInterval: 24 * 60 * 60 * 1000, // 1 day in milliseconds
                    pointStart: Date.UTC(2013, 11, 01),
                    data: hcSeriesIntervals
                }]
            });
        }
    });*/
});

