<?php if ( ! defined( 'ABSPATH' ) ) exit;

    global $wpdp_option_name;

    $wpdp_option_name ='wp_datepicker_option-';

    // Only options named wp_datepicker_option-{number} are datepicker instances, nothing else may be read/written/deleted through the plugin.
    if(!function_exists('wpdp_is_valid_instance_name')){

        function wpdp_is_valid_instance_name($option_name){

            return (is_string($option_name) && preg_match('/^wp_datepicker_option-[0-9]+$/', $option_name) === 1);

        }
    }

    if(!function_exists('wpdp_is_css_color')){

        function wpdp_is_css_color($value){

            $value = trim((string)$value);

            return (preg_match('/^(#?[0-9a-fA-F]{3,8}|[a-zA-Z]{3,30}|(rgb|hsl)a?\(\s*[0-9.%\s,\/-]+\))$/', $value) === 1);

        }
    }

    // Validates the values of a datepicker instance before it is stored (and therefore before it is printed into generated JS/CSS files).
    if(!function_exists('wpdp_validate_instance_values')){

        function wpdp_validate_instance_values($data){

            global $wpdp_dir, $wpdp_styles, $wpdp_fonts;

            if(!is_array($data)){ return array(); }

            if(isset($data['wp_datepicker_language']) && is_string($data['wp_datepicker_language']) && strpos($data['wp_datepicker_language'], '|') !== false){

                $lang_parts = explode('|', wpdp_slashes($data['wp_datepicker_language']));

                if(count($lang_parts) != 2 || !preg_match('/^datepicker-[A-Za-z-]+\.js$/', $lang_parts[1]) || !file_exists($wpdp_dir.'js/i18n/'.$lang_parts[1])){
                    $data['wp_datepicker_language'] = '';
                }
            }

            if(isset($data['wpdp_fonts']) && $data['wpdp_fonts'] !== ''){

                $font_ok = false;

                if(is_string($data['wpdp_fonts']) && is_string($wpdp_fonts)){

                    $fonts_list = wpdp_decode_fonts($wpdp_fonts);
                    $font_wanted = base64_decode($data['wpdp_fonts']);

                    foreach($fonts_list as $font_item){
                        if(isset($font_item['font-family']) && $font_item['font-family'] === $font_wanted){
                            $font_ok = true;
                            break;
                        }
                    }
                }

                if(!$font_ok){ $data['wpdp_fonts'] = ''; }
            }

            if(isset($data['wpdp_options']) && is_array($data['wpdp_options'])){

                $opts = $data['wpdp_options'];

                if(isset($opts['use_custom_style1']) && $opts['use_custom_style1'] !== ''){

                    $allowed_styles = array_merge(is_array($wpdp_styles) ? $wpdp_styles : array(), array('default', 'custom-colors'));

                    if(!in_array($opts['use_custom_style1'], $allowed_styles, true)){
                        $opts['use_custom_style1'] = '';
                    }
                }

                foreach(array('color1', 'color2', 'color3', 'color4', 'color5') as $color_key){

                    if(isset($opts[$color_key]) && $opts[$color_key] !== '' && !wpdp_is_css_color($opts[$color_key])){
                        $opts[$color_key] = '';
                    }
                }

                $data['wpdp_options'] = apply_filters('wpdp_validate_wpdp_options', $opts);
            }

            return $data;
        }
    }

    if(!function_exists('wpdp_new_option_name')){

        function wpdp_new_option_name(){

            global  $wpdb, $wpdp_option_name;

            $wpdp_option_name = 'wp_datepicker_option-';



            $wpdp_option_query = "SELECT * FROM {$wpdb->prefix}options WHERE option_name LIKE '" . $wpdp_option_name . "%'";

            //pree($wpdp_option_query);exit;

            $get_results = $wpdb->get_results($wpdp_option_query, OBJECT);

            //pree($get_results);exit;

            if (!empty($get_results)) {

                //if already have some custom wpdp than get max number wpdp increment 1 and add new wpdp option
                $wpdp_id_array = array();



                foreach ($get_results as $key => $value) {
                    $option = $value->option_name;
                    $array = explode('-', $option);
                    array_push($wpdp_id_array, end($array));
                }


                $max_wpdp_id = max($wpdp_id_array);
                $new_wpdp_id = $max_wpdp_id + 1;
                $wpdp_id = $wpdp_option_name . $new_wpdp_id;


            } else {

                //if custom wpdp not exist than add new wpdp
                $wpdp_id = $wpdp_option_name . '1';
            }

            return $wpdp_id;
        }
    }

   if(!function_exists('wpdp_get_datepicker_list')){

       function wpdp_get_datepicker_list($sort = 'ASC'){

           global  $wpdb, $wpdp_option_name;

           $results =  $wpdb->get_results("SELECT * FROM {$wpdb->prefix}options WHERE option_name LIKE '" . $wpdp_option_name . "%';", OBJECT);


           usort($results, function ($a, $b)use($sort){

               $option_a = $a->option_name;
               $option_b = $b->option_name;

               $option_a = explode('-', $option_a);
               $option_b = explode('-', $option_b);

               $option_a = $option_a[1];
               $option_b = $option_b[1];

               if($sort == 'ASC'){

                   return ($option_a > $option_b) ? 1 : -1;

               }elseif($sort == 'DESC'){

                   return ($option_a > $option_b) ? -1 : 1;

               }else{
                   return 0;
               }


           });

           return $results;
       }
   }

   if(!function_exists('wpdp_init_datepicker_list')){

       function wpdp_init_datepicker_list(){

           $wpdp_get_datepicker_list = wpdp_get_datepicker_list();

           if(empty($wpdp_get_datepicker_list)){

               update_option(wpdp_new_option_name(), array());

               $wpdp_get_datepicker_list = wpdp_get_datepicker_list();
           }


           return current($wpdp_get_datepicker_list)->option_name;

       }
   }

   if(!function_exists('wpdp_get_datepicker_by_id')){

       function wpdp_get_datepicker_by_id($option_id, $default = false){

           global  $wpdb;
           $result =  $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}options WHERE option_id = %d", (int)$option_id), OBJECT);

           if(!empty($result)){
               return (maybe_unserialize(current($result)->option_value));
           }else{
               return $default;
           }



       }
   }

   if(!function_exists('wpdp_get_current_option_name')){

       function wpdp_get_current_option_name(){

         return  wpdp_init_datepicker_list();

       }
   }

   if(!function_exists('wpdp_add_new_datepicker_ajax')){
       function wpdp_add_new_datepicker_ajax(){

			global $wpdp_premium_link, $wpdp_dir, $wpdp_url, $wpdp_pro, $wpdp_data, $wpdp_options, $wpdp_styles, $wpdp_gen_file, $wpdp_option_name;
			
			$proceed = true;

			$arr = array('msg'=>'');
			
			$wpdp_allowed_inputs = array("wp_datepicker_alive_scripts","wp_datepicker","wp_datepicker_language","wp_datepicker_readonly","wp_datepicker_weekends","wp_datepicker_autocomplete","wp_datepicker_beforeShowDay","wp_datepicker_months","wpdp_fonts","wpdp_options");
			$wpdp_allowed_inputs["wpdp_options"] = apply_filters('wpdp_allowed_wpdp_options', array("use_custom_style1","use_custom_colors","wpdp_inline","changeMonth","changeYear","showButtonPanel","color1","color2","color5","color4","color3","dateFormat","defaultDate","firstDay","closeText","currentText","minDate","maxDate","yearRange","stepMonths"));

			if(isset($_POST['wpdp_add_new_datepicker']) || isset($_POST['wpdp_get_selected_datepicker']) || isset($_POST['wpdp_form_data'])){
			
			
			   if (
						! isset( $_POST['wpdp_nonce_action_field'] )
				   || 
						! wp_verify_nonce( $_POST['wpdp_nonce_action_field'], 'wpdp_nonce_action' )
						
					
			   ) {
			
						$arr['msg'] = __('Sorry, your nonce did not verify.', 'wp-datepicker');
						$proceed = false;
			
			   } else {
				   
					if(!current_user_can( 'manage_options' )){
						$arr['msg'] = __('Sorry, your have not sufficient privileges to make changes.', 'wp-datepicker');
						$proceed = false;
					}
					//pree(current_user_can( 'manage_options' ));pree($_POST);exit;
					
					if($proceed){
						
						if(isset($_POST['wpdp_add_new_datepicker'])){
						
							$wpdp_new_option_name = wpdp_new_option_name();
							update_option($wpdp_new_option_name, array());
							
							$arr['option_name'] = $wpdp_new_option_name;
							$arr['default_img'] = $wpdp_url.'pro/img.default.jpg';
						   
						   
						
						}elseif (isset($_POST['wpdp_get_selected_datepicker'])){
							
							$option_name = sanitize_wpdp_data($_POST['wpdp_get_selected_datepicker']);

							if(!wpdp_is_valid_instance_name($option_name)){
								$arr['msg'] = __('Invalid datepicker instance.', 'wp-datepicker');
								echo json_encode($arr);
								wp_die();
							}
							
							ob_start();
							
							include_once ('wpdp_settings.php');
							
							$content = ob_get_contents();
							
							ob_clean();
							
							$arr['content'] = $content;
						  
						  
						
						
						}elseif(isset($_POST['wpdp_form_data'])){
						
						
						
							parse_str($_POST['wpdp_form_data'], $wpdp_form_data);
						
						
						
							if(isset($wpdp_form_data['wpdp'])){
							
								$wpdp_data_post = sanitize_wpdp_data($wpdp_form_data['wpdp']);
								
								//pree($wpdp_data_post);exit;
								
								$option_name = current(array_keys($wpdp_data_post));
								
								$valid_option_name = (substr($option_name, 0, strlen($wpdp_option_name))==$wpdp_option_name);
								
								//pree($option_name);exit;
								
								$options_data_array = current($wpdp_data_post);
								
								//echo '"'.implode('","', array_keys($options_data_array)).'"';exit;
								//pree($wpdp_allowed_inputs);
								//pree($options_data_array);
								if(!empty($options_data_array)){
									foreach($options_data_array as $options_data_key=>$options_data_value){
										if(!in_array($options_data_key, $wpdp_allowed_inputs)){
											unset($options_data_array[$options_data_key]);
										}
										if(is_array($options_data_value) && array_key_exists($options_data_key, $wpdp_allowed_inputs)){
											foreach($options_data_value as $options_data_inner_key=>$options_data_inner_value){
												if(!in_array($options_data_inner_key, $wpdp_allowed_inputs[$options_data_key])){
													unset($options_data_array[$options_data_key][$options_data_inner_key]);
												}
											}
										}
									}
								}
								//pree($options_data_array);exit;
								//pree($options_data_array['wpdp_options']);
								//echo '"'.implode('","', array_keys($options_data_array['wpdp_options'])).'"';exit;
								
								//pree($option_name);exit;
								if(strlen($option_name) && $valid_option_name && wpdp_is_valid_instance_name($option_name)){
									//pree('Done');exit;
									update_option($option_name, wpdp_validate_instance_values($options_data_array));
								
								}
							
							}
						
						}
						
					}
					
					if(function_exists('wpdp_generate_js_file')){					
					
						wpdp_generate_js_file();
					
					}
					
					if(function_exists('wpdp_generate_css_file')){
					
						wpdp_generate_css_file();
					
					}
			
			
			   }
			}
			echo json_encode($arr);
			wp_die();
       }
   }

   add_action('wp_ajax_wpdp_add_new_datepicker_ajax', 'wpdp_add_new_datepicker_ajax');
   add_action('init', 'wpdp_update_previous_version');

    if(!function_exists('wpdp_update_previous_version')){

        function wpdp_update_previous_version(){

            $wpdp_get_datepicker_list = wpdp_get_datepicker_list();
            $wpdp_previous_version_compatible = get_option('wpdp_previous_version_compatible');

            if(!$wpdp_previous_version_compatible && empty($wpdp_get_datepicker_list)){

                $updated_array = array();

                $wpdp_selectors = get_option('wp_datepicker');
                $wp_datepicker_language = get_option( 'wp_datepicker_language');
                $wp_datepicker_weekends = get_option( 'wp_datepicker_weekends');
				$wp_datepicker_autocomplete = get_option( 'wp_datepicker_autocomplete', true);
                $wp_datepicker_beforeShowDay = get_option( 'wp_datepicker_beforeShowDay');
                $wp_datepicker_months = get_option( 'wp_datepicker_months');
                $wp_datepicker_wpadmin = get_option( 'wp_datepicker_wpadmin');
                $wp_datepicker_readonly = get_option( 'wp_datepicker_readonly');
                $wpdp_options = get_option('wpdp_options', array());
                $wpdp_fonts = get_option('wpdp_fonts');

                $updated_array['wp_datepicker'] = $wpdp_selectors ? $wpdp_selectors : '';
                $updated_array['wp_datepicker_language'] = $wp_datepicker_language ? $wp_datepicker_language : '';
                $updated_array['wp_datepicker_weekends'] = $wp_datepicker_weekends ? $wp_datepicker_weekends : '';
				$updated_array['wp_datepicker_autocomplete'] = $wp_datepicker_autocomplete ? $wp_datepicker_autocomplete : '';
                $updated_array['wp_datepicker_beforeShowDay'] = $wp_datepicker_beforeShowDay ? $wp_datepicker_beforeShowDay : '';
                $updated_array['wp_datepicker_months'] = $wp_datepicker_months ? $wp_datepicker_months : '';
                $updated_array['wp_datepicker_wpadmin'] = $wp_datepicker_wpadmin ? $wp_datepicker_wpadmin : '';
                $updated_array['wp_datepicker_readonly'] = $wp_datepicker_readonly ? $wp_datepicker_readonly : '';
                $updated_array['wpdp_fonts'] = $wpdp_fonts ? $wpdp_fonts : '';
                $updated_array['wpdp_options'] = !empty($wpdp_options) ? $wpdp_options : '';

                $status = update_option(wpdp_new_option_name(), $updated_array);

                if($status){

                    foreach ($updated_array as $option_name => $option_value){
                        delete_option($option_name);
                    }

                    update_option('wpdp_previous_version_compatible', true);

                }



            }


        }

    }