        


            jQuery(document).ready(function($){

                setTimeout(function () {

                    $('#ui-datepicker-div').wrap('<div class="ui-datepicker-div-wrapper"></div>');

                }, 1000)
            });

        

        	
	

	jQuery(document).ready(function($){


		
		if($('.wpcf7-form-control.wpcf7-repeater-add').length>0){
			$('.wpcf7-form-control.wpcf7-repeater-add').on('click', function(){
				wpdp_refresh_1343(jQuery, true);
			});
		}
		
	
});
var wpdp_refresh_first_1343 = 'yes';
var wpdp_intv_1343;
var wpdp_counter_1343 = 0;
var wpdp_month_array_1343 = [];
var wpdp_dateFormat = "mm/dd/yy";
var wpdp_defaultDate = "";
var wpdp_changeMonth = false;
var wpdp_changeYear = false;
var wpdp_firstDay = "";
var wpdp_closeText = "";
var wpdp_currentText = "";
var wpdp_minDate = "";
var wpdp_maxDate = "";
var wpdp_yearRange = "";
var wpdp_showButtonPanel = false;
var wpdp_stepMonths = "";
function wpdp_refresh_1343($, force){
if(typeof wpdp_obj!='undefined'){
	
			var wpml_code = wpdp_obj.wpml_current_language;
			
			wpml_code = (wpml_code?wpml_code:"en-GB");
			switch(wpml_code){
				case "en":
					wpml_code = "en-US";
				break;
			}
	
	
			
				if(typeof $.datepicker!='undefined' && typeof $.datepicker.regional[wpml_code]!='undefined'){
					
				wpdp_month_array_1343 = $.datepicker.regional[wpml_code].monthNames;
									
				}
				
				
}
				


				if($("#from-date").length>0){
					
				$("#from-date").attr("autocomplete", "off");
					
				//document.title = wpdp_refresh_first=='yes';
				//force = true;
								$('body').on('mouseover, mousemove', function(){//
				
			
				
				if ($("#from-date").length>0) {
					$.each($("#from-date"), function(wp_si, wp_sv){
						if($(this).val()!=''){
							$(this).attr('data-default-val', $(this).val());
						}
					});
				}		
				
				
								
				
					
				if($("#from-date.hasDatepicker").length!=$("#from-date").length){

				
					
				$("#from-date").datepicker($.extend(  
					{},  // empty object  
					$.datepicker.regional[ wpml_code ],       // Dynamically  
					{  
 					dateFormat: wpdp_dateFormat
					}
				)).on( "change", function() {
						
				}); 
				
				
				
				
				
				$("#from-date").datepicker( "option", "dateFormat", "mm/dd/yy" );


setTimeout(function(){ 

	 $.each($("#from-date"), function(){

        
            $(this).prop('autocomplete', 'on');


         		 		
		var expected_default = $(this).data('default');		

		
		var expected_stamp = $(this).data('default_stamp');
		var expected_stamp_date = new Date(expected_stamp*1000);
		var expected_stamp_str = $.datepicker.formatDate('mm/dd/yy', expected_stamp_date);		 
	 
		if(expected_default != undefined && expected_default!=''){ $(this).datepicker().datepicker('setDate', expected_default); }
		if(expected_stamp != undefined && expected_stamp!=''){ $(this).datepicker().datepicker('setDate', expected_stamp_str); }		
		
	});
	
}, 100);
	
				$("#from-date").datepicker( "option", "changeMonth", false );

				$("#from-date").datepicker( "option", "changeYear", false );

				$("#from-date").datepicker( "option", "showButtonPanel", false );







					$.each($("#from-date"), function(){
						var this_selector = $(this);
						var parent_form = this_selector.closest('form');
						
						parent_form.on('reset', function(){
							if(this_selector.data('default-val')!= ""){
								setTimeout(function(){
									if(this_selector.val() == ''){
										this_selector.val(this_selector.data('default-val'));
									}
								});
							}
						});
						if($(this).data('default-val')!= ""){
							$(this).val($(this).data('default-val'));
						}
						
					});
						
				
				}
				
				
				
				});
				}
		


		
		$('.ui-datepicker').addClass('notranslate');
}
	wpdp_intv_1343 = setInterval(function(){
		wpdp_counter_1343++;
		wpdp_refresh_1343(jQuery, true);
		
	}, 1500);

	                jQuery(document).ready(function($){

                        $("#from-date").on('click', function(){

                            $('.ui-datepicker-div-wrapper').prop('class', 'ui-datepicker-div-wrapper wp_datepicker_option-1 ');

                        });

                        setTimeout(function () {
                                $("#from-date").click();
                                //$("//").focusout();
                        }, 1000);



                });

            
    //wpdp_refresh_//(jQuery, false);
	
	    
	
	

	jQuery(document).ready(function($){


		
		if($('.wpcf7-form-control.wpcf7-repeater-add').length>0){
			$('.wpcf7-form-control.wpcf7-repeater-add').on('click', function(){
				wpdp_refresh_1367(jQuery, true);
			});
		}
		
	
});
var wpdp_refresh_first_1367 = 'yes';
var wpdp_intv_1367;
var wpdp_counter_1367 = 0;
var wpdp_month_array_1367 = [];
var wpdp_dateFormat = "mm/dd/yy";
var wpdp_defaultDate = "";
var wpdp_changeMonth = false;
var wpdp_changeYear = false;
var wpdp_firstDay = "";
var wpdp_closeText = "";
var wpdp_currentText = "";
var wpdp_minDate = "";
var wpdp_maxDate = "";
var wpdp_yearRange = "";
var wpdp_showButtonPanel = false;
var wpdp_stepMonths = "";
function wpdp_refresh_1367($, force){
if(typeof wpdp_obj!='undefined'){
	
			var wpml_code = wpdp_obj.wpml_current_language;
			
			wpml_code = (wpml_code?wpml_code:"en-GB");
			switch(wpml_code){
				case "en":
					wpml_code = "en-US";
				break;
			}
	
	
			
				if(typeof $.datepicker!='undefined' && typeof $.datepicker.regional[wpml_code]!='undefined'){
					
				wpdp_month_array_1367 = $.datepicker.regional[wpml_code].monthNames;
									
				}
				
				
}
				


				if($("#to-date").length>0){
					
				$("#to-date").attr("autocomplete", "off");
					
				//document.title = wpdp_refresh_first=='yes';
				//force = true;
								if(wpdp_refresh_first_1367 == 'yes' || force){
					
					
					
										
					if(typeof $.datepicker!='undefined')
					$("#to-date").datepicker( "destroy" );
					
					
					$("#to-date").removeClass("hasDatepicker");
					wpdp_refresh_first_1367 = 'done';
					
				}
								$('body').on('mouseover, mousemove', function(){//
				
			
				
				if ($("#to-date").length>0) {
					$.each($("#to-date"), function(wp_si, wp_sv){
						if($(this).val()!=''){
							$(this).attr('data-default-val', $(this).val());
						}
					});
				}		
				
				
								if(wpdp_counter_1367 > 2)
				clearInterval(wpdp_intv_1367);
								
				
					
				if($("#to-date.hasDatepicker").length!=$("#to-date").length){

				
					
				$("#to-date").datepicker($.extend(  
					{},  // empty object  
					$.datepicker.regional[ wpml_code ],       // Dynamically  
					{  
 					dateFormat: wpdp_dateFormat
					}
				)).on( "change", function() {
						
				}); 
				
				$("#to-date").attr('readonly', 'readonly');
				
				
				
				
				$("#to-date").datepicker( "option", "dateFormat", "mm/dd/yy" );


setTimeout(function(){ 

	 $.each($("#to-date"), function(){

        
            $(this).prop('autocomplete', 'on');


         		 		
		var expected_default = $(this).data('default');		

		
		var expected_stamp = $(this).data('default_stamp');
		var expected_stamp_date = new Date(expected_stamp*1000);
		var expected_stamp_str = $.datepicker.formatDate('mm/dd/yy', expected_stamp_date);		 
	 
		if(expected_default != undefined && expected_default!=''){ $(this).datepicker().datepicker('setDate', expected_default); }
		if(expected_stamp != undefined && expected_stamp!=''){ $(this).datepicker().datepicker('setDate', expected_stamp_str); }		
		
	});
	
}, 100);
	
				$("#to-date").datepicker( "option", "changeMonth", false );

				$("#to-date").datepicker( "option", "changeYear", false );

				$("#to-date").datepicker( "option", "showButtonPanel", false );







					$.each($("#to-date"), function(){
						var this_selector = $(this);
						var parent_form = this_selector.closest('form');
						
						parent_form.on('reset', function(){
							if(this_selector.data('default-val')!= ""){
								setTimeout(function(){
									if(this_selector.val() == ''){
										this_selector.val(this_selector.data('default-val'));
									}
								});
							}
						});
						if($(this).data('default-val')!= ""){
							$(this).val($(this).data('default-val'));
						}
						
					});
						
				
				}
				
				
				
				});
				}
		


		
		$('.ui-datepicker').addClass('notranslate');
}
	wpdp_intv_1367 = setInterval(function(){
		wpdp_counter_1367++;
		wpdp_refresh_1367(jQuery, false);
		
	}, 500);

	                jQuery(document).ready(function($){

                        $("#to-date").on('click', function(){

                            $('.ui-datepicker-div-wrapper').prop('class', 'ui-datepicker-div-wrapper wp_datepicker_option-2 ');

                        });

                        setTimeout(function () {
                                $("#to-date").click();
                                //$("//").focusout();
                        }, 1000);



                });

            
    //wpdp_refresh_//(jQuery, false);
	
	    
