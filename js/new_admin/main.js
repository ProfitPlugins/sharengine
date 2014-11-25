jQuery(window).load(function(){
	jQuery('#loading').fadeOut(1000);

    jQuery("#goPermissions").click(function(e){
        e.preventDefault();
        var user = jQuery("#userDropdown").val();

        jQuery.post(ajaxurl, { action:"se_permissions", user:user}, function(response){
            jQuery('.se_container').html(response);
        })



    })

	jQuery('#stats_visits').sparkline('html', { 
		type: 'bar',
		chartRangeMin: 0,
		height: '40px',
		barWidth: '5px',
		barColor: '#3e3e3e',
		tooltipClassname:'tooltip-sp'
	});
	jQuery('#stats_balance').sparkline('html', { 
		type: 'bar',
		chartRangeMin: 0,
		height: '40px',
		barWidth: '5px',
		barColor: '#ffffff',
		tooltipClassname:'tooltip-sp'
	});

  // checkbox slider change -> hide the widget
      jQuery('.widget-controls .sl').change(function(){
        var thisRoot = jQuery(this).closest('.se_service_wrapper');

        if(this.checked){
          thisRoot.find('.service_content').show();
        } else {
            thisRoot.find('.service_content').hide();
        }
      })

  jQuery('.icon-nav-mobile').click(function(){
    jQuery('.mainNav').toggleClass('open');
  })

	/*jQuery('#topTabs-container-docs, #statsTabs-container').easytabs({
		updateHash: false,
		tabs: "ul.etabs > li"
	});
	jQuery('#topTabs-container-home').easytabs({
		updateHash: false,
		tabs: "ul.etabs > li",
		animate: true,
  		transitionIn: 'slideDown',
  		transitionOut: 'slideUp'
	});

	
	jQuery('.small-calendar').datepicker({
		showOtherMonths: true,
			selectOtherMonths: true,
			altField: "#calendar-date",
			dateFormat:"dd/mm/yy"
	});
    */
	jQuery('.ttip').hover(
		function(){
			var ttip_c = jQuery(this).data('ttip');
			var ttip_h = jQuery(this).height();
			jQuery(this).append('<div class="ttip_t">' + ttip_c + '</div>');
			jQuery('.ttip_t').css({ 'top' : ttip_h + ttip_h/2 + 10 });
			jQuery('.ttip_t').fadeIn();
		},
		function(){
			jQuery('.ttip_t').fadeOut(function(){
				jQuery(this).remove()
			});
		}
	);
    jQuery('#se_unaffiliated_traffic0').click(function(){
        // hide the showRandom div
        jQuery('#showRandom').hide();
    })
    jQuery('#se_unaffiliated_traffic1').click(function(){
        jQuery('#showRandom').show();
    })
    jQuery('#addExclude').click(function(){

        //get the value of the users list

        var users_list = jQuery('#users_list option:selected').text();

        jQuery('#excludeList').tagsManager("pushTag", users_list);
    })

    jQuery('#addInclude').click(function(){

        //get the value of the users list

        var users_list = jQuery('#users_list_include option:selected').text();

        jQuery('#includeList').tagsManager("pushTag", users_list);
    })



    console.log('here');
    // Get the excluded values
    excluded_prefilled = jQuery('#excludeListValues').prop('value');
    included_prefilled = jQuery('#includeListValues').prop('value');



    jQuery('#excludeList').tagsManager({prefilled:excluded_prefilled});
    jQuery('#includeList').tagsManager({prefilled:included_prefilled});

}) //.Ready