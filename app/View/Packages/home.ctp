<?php
//CSS Files
$this->Html->css(array(
	'../js/frontend/plugins/jquery-ui/css/ui-lightness/jquery-ui-1.10.1.custom', //generic jquery-ui css file (lightness)
	'frontend/bootstrap-form',
	'frontend/bootstrap-toggle-buttons'
	),
	'stylesheet',
	array('inline'=>false)
);

echo $this->Html->script(array(
	'frontend/plugins/jquery-ui/js/jquery-ui-1.10.1.custom.js', //jquery-ui file
	//'frontend/plugins/tinysort/src/opensource.min.js',
	'frontend/plugins/tinysort/src/jquery.tinysort.min.js',
	'frontend/plugins/tinysort/src/jquery.tinysort.charorder.min.js',
	//'frontend/reservation_packages.js',
	'frontend/package_home.js',
	'frontend/reservation_sidebar.js',
	'frontend/jquery.toggle.buttons.js'
	),
	FALSE
);
?>
<script>
$(document).ready(function(){
            $('.toggle-button').toggleButtons();
            $('#warning-toggle-button').toggleButtons({
                style: {
                    enabled: "warning",
                    disabled: "danger"
                }
            });
            $('#danger-toggle-button').toggleButtons({
                style: {
                    enabled: "danger",
                    disabled: "info"
                }
            });
            $('#info-toggle-button').toggleButtons({
                style: {
                    enabled: "info",
                    disabled: "success"
                }
            });
            $('#success-toggle-button').toggleButtons({
                style: {
                    enabled: "success",
                    disabled: "warning"
                }
            });
            $('#disabled-toggle-button').toggleButtons();
            $('#data-attribute-toggle-button').toggleButtons();
            
            if ( $("#searchDateInput").val() != '' ) {

					var date = $("#searchDateInput").val();
					var location = $("#searchDateInput").attr('location');
					if(location == ''){
						location = 'all';
					}
					if(date == ''){
						$(this).parent().parent().addClass('error');
						$(this).parent().parent().find('.help-block').html('Must select a valid date. Please try again.');
					} else {
						$(this).parent().parent().removeClass('error');
						$(this).parent().parent().find('.help-block').html('');			
						
						requests.getPackages(date, location);
					}			
				
			};

            
      });
</script>
<div class="container">

	<div class="row">
		<div class="sixteen columns alpha">
		   
			<div class="page_heading"><h1>Packages</h1></div>

		</div>		
	</div>

	<div class="row">
		<!-- 
		<div id="searchDiv" class="twelve columns alpha">
				<div class="form-actions" style="margin-top:0px;">
					<h3>Travel Date</h3>

					<div class="control-group">
						<div class="input-append">
							<input id="searchDateInput" type="text" placeholder="Click Here" location="<?php echo $url_location;?>" style="width:300px; cursor:pointer;"/>	
							<span id="searchCalendarSpan" class="add-on" style="cursor:pointer;"><i class="small-icon-calendar"></i></span>
						</div>
		
						<span class="help-block"></span>
						</div>
				</div>
		</div>		
		-->

		<div id="searchDiv" class="twelve columns alpha" >
			<div class="form-actions" style="margin-top:0px;">
				<h3>Package Options - Please select your desired date of travel</h3>
				<div>
		
					<div class="row-fluid" style="margin-bottom: 10px;">
						<div class="span6">
							<label>Travel Date <span class="f_req" style="color:red">*</span></label>
							<div class="input-append" style="float: left;">					
								<input id="searchDateInput" type="text" placeholder="Enter Date" value="<? if ($depart_date){echo $depart_date;} ?>" location="<?php echo ucwords(str_replace('-',' ',$url_location));?>" style="width:290px; cursor:pointer;"/>	
								<span id="searchCalendarSpan" class="add-on" style="cursor:pointer;"><i class="small-icon-calendar"></i></span>
							</div>
						</div>
	
						<div class="span6">
							<label>Order By</label>
							<select class="orderBy" style="width:90%">
								<option value="1" >By Name A-Z</option>
								<option value="2">By Name Z-A</option>
								<!-- <option value="3">By Rating (lowest to highest)</option>
								<option value="4">By Rating (highest to lowest)</option> -->
								<option value="5" selected="selected">By Starting Price (lowest to highest)</option>
								<option value="6">By Starting Price (highest to lowest)</option>
							</select>
						</div>
						
						
					</div>
					
					<div>
							<!-- <label>By City</label> -->
							<?php
							
							//if there is no location in the url then by default select "all"
							$selected_location = str_replace(array(' ',"'",'%2C',','),array('-','','',''),strtolower($selected_location));
							foreach ($locations as $l) {
								$loc_name = $l['Location']['name'];
								$loc_check_name = strtolower($loc_name);
								$loc_check_name = str_replace(array(' ',"'",'%2C',','),array('-','','',''),$loc_check_name);

								$loc_city = $l['Location']['city'];
								$loc_state = $l['Location']['state'];
								$loc_country = $l['Location']['country'];
								
								
								if($selected_location == $loc_check_name || $selected_location == 'no' || $second_location == $loc_check_name || $third_location == $loc_check_name){
									$loc_checked = 'checked="checked"';
								} else {
									$loc_checked = '';
								}
								
								if ($selected_location == "victoria-all"){
									switch ($loc_check_name) {
										case 'victoria':
											$loc_checked = 'checked="checked"';
											break;
										case 'vancouver-island':
											$loc_checked = 'checked="checked"';
											break;
										default:
											break;
									}
								} elseif ($selected_location == "pa-all"){
									switch ($loc_check_name) {
										case 'olympic-peninsula':
											$loc_checked = 'checked="checked"';
											break;
										case 'seattle':
											$loc_checked = 'checked="checked"';
											break;
										case 'portland':
											$loc_checked = 'checked="checked"';
											break;
										default:
											break;
									}
								}
								

								?>
								<div style="float:left; margin-right: 8px;">
									<label class="checkbox" for="searchByLocation"><?php echo $loc_city.', '.$loc_state;?></label>
									<div id="normal-toggle-button" class="toggle-button" data-togglebutton-transitionspeed="500%" style="width: 100px; height: 25px;">
										<input class="byLocation" type="checkbox" name="searchByLocation" value="<?php echo $loc_name;?>" <?php echo $loc_checked;?>/> 
									</div>
								</div>
								<?php
							}
							?>
							
							<!-- <div id="normal-toggle-button" class="toggle-button" style="width: 100px; height: 25px;">
				                <input type="checkbox" checked="checked">
				            </div> -->
							
						</div>
					
				</div>

				
			</div>
			
			<div id="searchResultsDiv">
				
			</div>
			<p class="six columns alpha"><span class="f_req" style="color:red;">*</span> <em>required field</em></p>	
		</div>
		<!-- Wide Column::END -->


		<!-- Side Column -->
		<?php 
		if(empty($ferry_sidebar)){
			$show_ferry = 'NO';
		} else {
			$show_ferry = 'YES';
		}
	
		echo $this->element('pages/sidebar',array(
			'current_page'=>'reservation',
			'Ferries'=>'YES',
			'Hotels'=>'YES',
			'Attractions'=>'YES',
			'Packages'=>'YES',
			'ferry_sidebar'=>$ferry_sidebar,
			'hotel-sidebar'=>$hotel_sidebar,
			'attraction_sidebar'=>$attraction_sidebar,
			'package_sidebar'=>$package_sidebar
		)); 
		?>
			
	</div>	