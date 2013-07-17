<?php
	switch($location){
		case 'All':
			$loc_summary = '';
			break;
			
		default:
			$loc_summary = 'within '.$location;
			break;
	}
?>
<!-- Featured Packages -->
<div>
	<!-- <h3>(2) Select your desired package</h3> -->
	<h3>Featured <span id="featuredHeader">Packages</span></h3>		
	<div style="margin-left:-15px; width:730px;">
		<ul id="featuredUl" class="media-list" style="max-height: 615px; overflow: hidden;">
		<?php
		$name_order = -1;
		//debug($featured);
		foreach ($featured as $key => $value) {
			$name_order++;
			$featured_id = $featured[$key]['Package']['id'];
			$featured_url = $featured[$key]['Package']['url'];
			$featured_location = $featured[$key]['Package']['location'];
			$featured_url_location = strtolower($featured_location);
			$featured_url_location = str_replace(array(' ','%20','%26',"'",'&','%2C',','),array('-','','','','and','',''), $featured_url_location);
			$featured_city = $featured[$key]['Package']['city'];
			$featured_state = $featured[$key]['Package']['state'];
			$featured_name = $featured[$key]['Package']['name'];
			$featured_url_name = strtolower($featured_name);
			$featured_url_name = str_replace(array(' ','%20','%26',"'",'&','%2C',','),array('-','','','','and','',''), $featured_url_name);
			$featured_desc = $featured[$key]['Package']['description'];
			if(strlen($featured_desc) > 250){
				$featured_desc = substr($featured_desc, 0,250).'...';
			}
			$featured_image_main = $featured[$key]['Package']['image_main'];
			$featured_image_sort = $featured[$key]['Package']['image_sort'];
			if($featured[$key]['Package']['image_main'] ==''){
				$featured_primary_image = 'http://placehold.it/150x150';
			} else {
				$featured_primary_image = '/img/packages/'.$featured_image_main;
			}
			$featured_starting_price = $featured[$key]['Package']['starting_price'];
			$featured_inventory = $featured[$key]['Package']['inventory'];
			$featured_start_date = $featured[$key]['Package']['start_date'];
			$featured_end_date = $featured[$key]['Package']['end_date'];
			$featured_cutoff = $featured[$key]['Package']['cutoff'];
			$featured_cutoff_by = $featured[$key]['Package']['cutoff_by'];
			$featured_starting_point = $featured[$key]['Package']['starting_point'];
			$featured_created = $featured[$key]['Package']['created'];
			$featured_modified = $featured[$key]['Package']['modified'];
			$featured_status = $featured[$key]['Package']['status'];
			if($selected_location == 'NO'){
				$selected_hide = '';
			} else{
				if($selected_location != $featured_location){
					$selected_hide = 'hide';
				} else {
					$selected_hide = '';
				}
			}			
			$featured_rt_walkon = sprintf('%.2f',round($featured[$key]['Package']['rtWalkon'] / 2,2)); 
			$featured_rt_vehicle = sprintf('%.2f',round($featured[$key]['Package']['rtVehicle']/2,2));	
			
			$featured_transportation = json_decode($featured[$key]['Package']['transportation'],true);
			
			$base_passenger_check = 0;
			$base_vehicle_check = 0;
			foreach ($featured_transportation  as $ftpkey => $ftpvalue) {
				$item_id = $ftpkey;
				if($item_id == 19){
					$base_passenger_check++;
				}
				if($item_id == 22){
					$base_vehicle_check++;
				}
			}			
			if($base_passenger_check >0){
				$display_rtWalkon = 'Yes';
			} else {
				$display_rtWalkon = 'No';
			}
			if($base_vehicle_check >0){
				$display_rtVehicle = 'Yes';
			} else {
				$display_rtVehicle = 'No';
			}
			
				
			?>
										
			<li style="position: relative; background-size:cover; width:350px; height: 300px; margin-left:15px; float:left; background-image: url(<?php echo $featured_primary_image;?>);" id="featuredLi-<?php echo $featured_id;?>" class="featuredLi media clearfix <?php echo $selected_hide;?>" name="<?php echo $featured_url_name;?>" order="<?php echo $name_order;?>" location="<?php echo $featured_location;?>" starting="<?php echo $featured_rt_walkon;?>" >
				<a class="packageDetailsLink" package_id="<?php echo $featured_id;?>" style="width: 100%; height: 100%; display: block; cursor:pointer" href="/packages/details<?php echo $featured_url;?>">
					<h4 class="media-heading" style="color: #fff; margin-bottom: 2px; font-size:18px; line-height:21px; font-family: 'Open Sans Condensed', arial, serif; text-transform: uppercase; display: block; background: rgba(0, 0, 0, .5); margin: 0; padding: 10px;">
						<?php echo $featured_name?> 
					</h4>
					<div style="padding:10px 0; display: block; background: rgba(0, 0, 0, .5); position: absolute; bottom: 0px;left: 0px;">
						<?php
						if($display_rtWalkon =='Yes'){
						?>
						<div style="height: 90px; text-align: center; display: inline-block; font-size: 16px; color: #FFF; font-family: 'Open Sans Condensed', arial, serif; width: 170px;text-transform: uppercase;text-shadow: 0 1px 0px #333;">									
							Walk-on price from
							<span style="display: block; font-size: 60px; margin: 5px;line-height: 45px; height: 50px">$<?php echo round($featured_rt_walkon); ?></span>
							per person
						</div>
						<?php
						}
						if($display_rtVehicle =='Yes'){
						?>
						<div style="height: 90px; text-align: center; display: inline-block; font-size: 16px; color: #FFF; font-family: 'Open Sans Condensed', arial, serif; width: 175px;text-transform: uppercase;text-shadow: 0 1px 0px #333;">									
							Drive-on price from
							<span style="display: block; font-size: 60px; margin: 5px;line-height: 45px; height: 50px">$<?php echo round($featured_rt_vehicle); ?></span>
							per person
						</div>
						<?php
						}
						?>
						<div style="clear:both;"></div>
					</div>
				</a>						
			</li>
			
			<?php
		}
		?>
		</ul>		
	</div>
		<?php
		
		if($count_sf ==0){ //if the count is 0 for featured packages then show this message
		?>	
		<p id="featuredP" class="text text-error">There are no featured packages for <?php echo $date.' '.$loc_summary;?></p>
		<?php	
		}
		?>		
</div>
<!-- non featured packages -->
<div>
	<h3>More <span id="moreHeader">Packages</span></h3>
	<div>
		<ul id="nonfeaturedUl" class="media-list">
		<?php
		$name_order = -1;

		foreach ($nonfeatured as $key => $value) {
			$name_order++;
			$nonfeatured_id = $nonfeatured[$key]['Package']['id'];
			$nonfeatured_url = $nonfeatured[$key]['Package']['url'];

			$nonfeatured_location = $nonfeatured[$key]['Package']['location'];
			
			$nonfeatured_url_location = strtolower($nonfeatured_location);
			$nonfeatured_url_location = str_replace(array(' ','%20','%26',"'",'&','%2C',','),array('-','','','','and','',''),$nonfeatured_url_location);
			if(!empty($nonfeatured[$key]['Package']['city'])){
				$nonfeatured_city = $nonfeatured[$key]['Package']['city'];
			} else {
				$nonfeatured_city = '';
			}
			if(!empty($nonfeatured[$key]['Package']['state'])){
				$nonfeatured_state = $nonfeatured[$key]['Package']['state'];
			} else {
				$nonfeatured_state = '';
			}


			$nonfeatured_name = $nonfeatured[$key]['Package']['name'];
			$nonfeatured_url_name = strtolower($nonfeatured_name);
			$nonfeatured_url_name = str_replace(array(' ','%20','%26',"'",'&','%2C',','),array('-','','','','and','',''), $nonfeatured_url_name);
			$nonfeatured_desc = $nonfeatured[$key]['Package']['description'];
			if(strlen($nonfeatured_desc) > 250){
				$nonfeatured_desc = substr($nonfeatured_desc, 0,250).'...';
			}
			$nonfeatured_image_main = $nonfeatured[$key]['Package']['image_main'];
			$nonfeatured_image_sort = $nonfeatured[$key]['Package']['image_sort'];
			if($nonfeatured[$key]['Package']['image_main'] ==''){
				$nonfeatured_primary_image = 'http://placehold.it/100x100';
			} else {
				$nonfeatured_primary_image = '/img/packages/'.$nonfeatured_image_main;
			}
			$nonfeatured_inventory = $nonfeatured[$key]['Package']['inventory'];
			$nonfeatured_start_date = $nonfeatured[$key]['Package']['start_date'];
			$nonfeatured_end_date = $nonfeatured[$key]['Package']['end_date'];
			$nonfeatured_cutoff = $nonfeatured[$key]['Package']['cutoff'];
			$nonfeatured_cutoff_by = $nonfeatured[$key]['Package']['cutoff_by'];
			$nonfeatured_starting_point = $nonfeatured[$key]['Package']['starting_point'];

			$nonfeatured_created = $nonfeatured[$key]['Package']['created'];
			$nonfeatured_modified = $nonfeatured[$key]['Package']['modified'];
			$nonfeatured_status = $nonfeatured[$key]['Package']['status'];							
			if($selected_location == 'NO'){
				$selected_hide = '';
			} else{
				if($selected_location != $nonfeatured_location){
					$selected_hide = 'hide';
				} else {
					$selected_hide = '';
				}
			}		
			$nonfeatured_rt_walkon = sprintf('%.2f',round($nonfeatured[$key]['Package']['rtWalkon'] / 2,2)); 
			$nonfeatured_rt_vehicle = sprintf('%.2f',round($nonfeatured[$key]['Package']['rtVehicle']/2,2));							
			$nonfeatured_transportation = json_decode($nonfeatured[$key]['Package']['transportation'],true);
			$base_passenger_check = 0;
			$base_vehicle_check = 0;
			foreach ($nonfeatured_transportation as $nftpkey => $nftpvalue) {
				$item_id = $nftpkey;
				if($item_id == 19){
					$base_passenger_check++;
				}
				if($item_id == 22){
					$base_vehicle_check++;
				}
			}			
			if($base_passenger_check >0){
				$display_rtWalkon = 'Yes';
			} else {
				$display_rtWalkon = 'No';
			}
			if($base_vehicle_check >0){
				$display_rtVehicle = 'Yes';
			} else {
				$display_rtVehicle = 'No';
			}								
			?>
	
			<li style="padding:30px 0; border-bottom: 1px dashed #aaa; margin-bottom: 0;" id="nonfeaturedLi-<?php echo $nonfeatured_id;?>" class="nonfeaturedLi media clearfix <?php echo $selected_hide;?>" name="<?php echo $nonfeatured_url_name;?>" order="<?php echo $name_order;?>" location="<?php echo $nonfeatured_location;?>" starting="<?php echo $nonfeatured_rt_walkon;?>">
				<a package_id="<?php echo $nonfeatured_id;?>" href="/packages/details<?php echo $nonfeatured_url;?>" class="packageDetailsLink three columns alpha" style="height:100%; cursor:pointer;">
					<img class="media-object" src="<?php echo $nonfeatured_primary_image;?>" style="width:150px;"/>
				</a>
				<div class="seven columns">
					<h4 class="media-heading" style="margin-bottom: 2px; font-size: 16px; line-height: 16px; font-family: 'Open Sans Condensed', arial, serif; text-transform: uppercase;">
						<a class="packageDetailsLink" package_id="<?php echo $nonfeatured_id;?>" href="/packages/details<?php echo $nonfeatured_url;?>" style="cursor:pointer;"><?php echo $nonfeatured_name;?></a>
						
					</h4>
					<p style="color: #888"><?php echo $nonfeatured_desc;?></p>
				</div>

				<div class="two columns omega">
					<?php
					if($display_rtWalkon =='Yes'){
					?>
					<div style="line-height:12px; height: 100%; background-color: #f9f9f9; text-align: center; position: relative; display: block; box-shadow: 0px 1px 1px #aaa; padding: 10px 0; font-size: 11px; color: #999;">
					<span style="display: block; font-size: 22px; color: #333; line-height: 20px;">$<?php echo $nonfeatured_rt_walkon;?></span>
					walk-on reservation per person
					</div>	
					<?php
					}
					if($display_rtVehicle=='Yes'){
					?>
					<div style="line-height:12px; height: 100%; background-color: #f9f9f9; text-align: center; position: relative; display: block; box-shadow: 0px 1px 1px #aaa; padding: 10px 0; font-size: 11px; color: #999;">
					<span style="display: block; font-size: 22px; color: #333; line-height: 20px;">$<?php echo $nonfeatured_rt_vehicle;?></span>
					drive-on reservation per person
					</div>
					<?php
					}
					?>
					<a package_id="<?php echo $nonfeatured_id;?>" href="/packages/details<?php echo $nonfeatured_url;?>" class="packageDetailsLink pull-right btn btn-bbfl btn-block" style="cursor:pointer; margin-top:10px">More Info</a>
					<?php
					
					//echo $this->Html->link('More Info', array('controller'=>'packages','action'=>'details',str_replace(' ','-',strtolower($nonfeatured_location)),$nonfeatured_id), array('class'=>'pull-right btn btn-bbfl btn-block', 'style' => 'margin-top:10px;'));
					?>
				</div>

			</li>
			
			<?php
		}

		?>	
		</ul>
	</div>
	<?php
	if($count_nsf==0){ //if the count of the search is 0 then show this message for non featured

	?>
		<p id="nonfeaturedP" class="text text-error">There are no non-featured packages for <?php echo $date.' '.$loc_summary;?></p>
	<?php
	}
	?>
</div>
