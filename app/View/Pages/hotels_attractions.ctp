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
	'frontend/reservation_hotels_attractions.js',
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
      });
</script>



<div class="container">

	<div class="row">
		<div class="sixteen columns alpha">
		   
			<div class="page_heading"><h1>Hotels + Attractions</h1></div>

		</div>		
	</div>
	
	<div class="row">
			<!-- Wide Column -->
			<div class="twelve columns alpha">
				<div class="form-actions" style="margin-top:0px;">
					<h3>Filter Search</h3>
					<div>
						<table style="width:100%; margin-bottom: 10px;">
							<thead>
								<tr>
									<th><label>By Type</label></th>
									<th><label>By Rating</label></th>
									<th><label>Order By</label></th>
								</tr>
							</thead>
							<tbody id="filteredSearchTbody">
								<tr>
									<td>
										<!-- <label class="radio" for="searchByType"><input class="byType" type="radio" name="searchByType" value="both" checked="checked"/> Hotels + Attractions</label>
										<label class="radio" for="searchByType"><input class="byType" type="radio" name="searchByType" value="Hotel"/> Hotels Only</label>
										<label class="radio" for="searchByType"><input class="byType" type="radio" name="searchByType" value="Attraction"/> Attractions Only</label>
										 -->
										 <select name="searchByType" class="byType"  style="width:90%">
											<option value="both">Hotels + Attractions</option>
											<option value="Hotel">Hotels only</option>
											<option value="Attraction">Attractions only</option>
										</select>
									</td>
									<td>
										<select class="byRating" style="width:90%">
											<option value="5" selected="selected">All Ratings</option>
											<option value="1">1 Star</option>
											<option value="1.5">1.5 Stars & below</option>
											<option value="2">2 Stars & below</option>
											<option value="2.5">2.5 Stars & below</option>
											<option value="3">3 Stars & below</option>
											<option value="3.5">3.5 Stars & below</option>
											<option value="4">4 Stars & below</option>
											<option value="4.5">4.5 Stars & below</option>
											<option value="5">5 Stars & below</option>
										</select>
									</td>
									<td>
										
										<select class="orderBy" style="width:90%">
											<option value="1" >By Name A-Z</option>
											<option value="2">By Name Z-A</option>
											<option value="3">By Rating (lowest to highest)</option>
											<option value="4">By Rating (highest to lowest)</option>
											<option value="5" selected="selected">By Starting Price (lowest to highest)</option>
											<option value="6">By Starting Price (highest to lowest)</option>
										</select>
									</td>
								</tr>								
							</tbody>
						</table>
						<div>
							<!-- <label>By City</label> -->
							<?php
							//if there is no location in the url then by default select "all"

							foreach ($locations as $l) {
								$loc_name = $l['Location']['name'];
								$loc_city = $l['Location']['city'];
								$loc_state = $l['Location']['state'];
								$loc_country = $l['Location']['country'];
								if($selected_location == $loc_name || $selected_location == 'NO'){
									$loc_checked = 'checked="checked"';
								} else {
									$loc_checked = '';
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
				<div>
					<h3>Featured <span id="featuredHeader">Hotels + Attractions</span></h3>		
					<div style="margin-left:-15px; width:730px;">
						<ul id="featuredUl" class="media-list" style="max-height: 615px; overflow: hidden;">
						<?php
						$name_order = -1;
						foreach ($featured as $key => $value) {
							$name_order++;
							$featured_id = $featured[$key]['id'];
							$featured_type = $featured[$key]['type'];
							switch($featured_type){
								case 'Hotel':
									$address_type = 'hotels';
									$address_method = 'hotel_pages';
									break;
									
								case 'Attraction':
									$address_type = 'attractions';
									$address_method = 'attraction_pages';
									break;	
							}
							$featured_name = $featured[$key]['name'];
							$remove_string = array("&","%26","'","%27"," ","%2C");
							$replace_string = array("and","and","","","-","");			
							$address_name = str_replace($remove_string,$replace_string,strtolower($featured_name));
							$featured_desc = $featured[$key]['description'];
							if(strlen($featured_desc) > 250){
								$featured_desc = substr($featured_desc, 0,250).'...';
							}
							$featured_url = $featured[$key]['url'];
							$featured_location = $featured[$key]['location'];
							$address_location = str_replace(' ','-',strtolower($featured_location));
							$featured_starting = $featured[$key]['starting'];
							if($featured_starting == ''){
								$featured_starting = null;
							}
							$featured_rating = $featured[$key]['rating'];
							if($featured_rating == ''){
								$featured_rating = 0;
							}
							$featured_city = $featured[$key]['city'];
							$featured_state = $featured[$key]['state'];
							if($featured[$key]['image'] ==''){
								$featured_primary_image = 'http://placehold.it/350x300';
							} else if ($featured_type == "Hotel" ){
								$featured_primary_image = "/img/hotels/".$featured[$key]['image'];
							} else if ($featured_type == "Attraction" ) {
								$featured_primary_image = "/img/attractions/".$featured[$key]['image'];
							} else {$featured_primary_image = 'http://placehold.it/350x300';}
							$featured_images = $featured[$key]['images'];
							if($selected_location == 'NO'){
								$selected_hide = '';
							} else{
								if($selected_location != $featured_location){
									$selected_hide = 'hide';
								} else {
									$selected_hide = '';
								}
							}
							?>
<!-- 							<li style="padding:15px 0; border-bottom: 1px dashed #aaa;" id="featuredLi-<?php echo $featured_id;?>" class="featuredLi media clearfix <?php echo $selected_hide;?>" order="<?php echo $name_order;?>" type="<?php echo $featured_type;?>" location="<?php echo $featured_location;?>" starting="<?php echo $featured_starting;?>" rating="<?php echo $featured_rating;?>">
								<a href="#" class="three columns alpha" style="height:100%;">
									<img class="media-object" src="<?php echo $featured_primary_image;?>"/>
								</a>
								<div class="seven columns">
									<h4 class="media-heading" style="margin-bottom: 2px; font-size:21px; line-height:21px; font-family: 'Open Sans Condensed', arial, serif; text-transform: uppercase;">
										<?php echo $this->Html->link($featured_name, array('controller'=>$address_type,'action'=>$address_method,$address_location,$address_name));?>
										<?php //echo $featured_name;?>
										</h4>
									<div style="margin-bottom: 10px; height: 16px;">
										<div class="star<?php echo preg_replace('/[^0-9]+/i', '', $featured_rating);?>"></div>
										<div style="float:left; margin-left:15px;"><label><?php echo $featured_city.', '.$featured_state;?></label></div>
									</div>
									
									<p><?php echo $featured_desc;?></p>
								</div>
									
								<div class="two columns omega">
									<div style="height: 100%; background-color: #f9f9f9; text-align: center; position: relative; display: block; box-shadow: 0px 1px 1px #aaa; padding: 10px 0; font-size: 11px; color: #999;">
									Prices from
									<span style="display: block; font-size: 30px; margin: 10px; color: #333;">$<?php echo round($featured_starting); ?></span>
									<? switch($featured_type){
										case 'Hotel':
											echo "USD including tax";
											break;
											
										case 'Attraction':
											echo "per person avg.";
											break;	
									}?>
									</div>
									<?php echo $this->Html->link('More Info', array('controller'=>$address_type,'action'=>$address_method,$address_location,$address_name), array('class'=>'btn btn-bbfl', 'style'=>'display:block;margin-top:10px;'));?>
								</div>
								
							</li> -->
							
							<li style="position:relative; background-size:cover; width:350px; height: 300px; margin-left:15px; float:left; background-image: url(<?php echo $featured_primary_image;?>);" id="featuredLi-<?php echo $featured_id;?>" class="featuredLi media clearfix <?php echo $selected_hide;?>" order="<?php echo $name_order;?>" type="<?php echo $featured_type;?>" location="<?php echo $featured_location;?>" starting="<?php echo $featured_starting;?>" rating="<?php echo $featured_rating;?>">
								<a style="width: 100%; height: 100%; display: block;" href="<?php echo $this->Html->url(array('controller'=>$address_type,'action'=>$address_method,$address_location,$address_name));?>">
									<h4 class="media-heading" style="color: #fff; margin-bottom: 2px; font-size:18px; line-height:21px; font-family: 'Open Sans Condensed', arial, serif; text-transform: uppercase; display: block; background: rgba(0, 0, 0, .5); margin: 0; padding: 10px;">
										<? echo $featured_name?> 
									</h4>
									<div style="background: rgba(0, 0, 0, .5); margin: 0; padding: 10px; height: 109px; text-align: center; position: absolute; display: inline-block; font-size: 24px; color: #FFF; font-family: 'Open Sans Condensed', arial, serif;bottom: 0px;right: 0px;text-transform: uppercase;text-shadow: 0 1px 0px #333;">									Prices from
										<span style="display: block; font-size: 85px; margin: 10px;line-height: 60px;">$<?php echo round($featured_starting); ?></span>
									</div>
								</a>						
							</li>
							<?php
						}
						?>	
						</ul>
						<div style="clear:both;"></div>
					</div>
				</div>
				<div>
					<h3>More <span id="moreHeader">Hotels + Attractions</span></h3>
					<div>
						<ul id="nonfeaturedUl" class="media-list">
						<?php
						$name_order = -1;
						foreach ($nonfeatured as $key => $value) {
							$name_order++;
							$nonfeatured_id = $nonfeatured[$key]['id'];
							$nonfeatured_type = $nonfeatured[$key]['type'];
							switch($nonfeatured_type){
								case 'Hotel':
									$address_type = 'hotels';
									$address_method = 'hotel_pages';
									break;
									
								case 'Attraction':
									$address_type = 'attractions';
									$address_method = 'attraction_pages';
									break;
								
							}
							$nonfeatured_name = $nonfeatured[$key]['name'];
							$remove_string = array("&","%26","'","%27"," ","%2C",",");
							$replace_string = array("and","and","","","-","",'');	
							$address_name = strtolower(str_replace($remove_string,$replace_string,$nonfeatured_name));
							$nonfeatured_desc = $nonfeatured[$key]['description'];
							if(strlen($nonfeatured_desc) > 250){
								$nonfeatured_desc = substr($nonfeatured_desc, 0,250).'...';
							}
							$nonfeatured_url = $nonfeatured[$key]['url'];
							$nonfeatured_location = $nonfeatured[$key]['location'];
							$address_location = str_replace(' ','-',strtolower($nonfeatured_location));
							$nonfeatured_starting = $nonfeatured[$key]['starting'];
							if($nonfeatured_starting == ''){
								$nonfeatured_starting = null;
							}
							$nonfeatured_rating = $nonfeatured[$key]['rating'];
							if($nonfeatured_rating == ''){
								$nonfeatured_rating = 0;
							}						
							if($nonfeatured[$key]['image'] ==''){
								$nonfeatured_primary_image = 'http://placehold.it/150x150';
							} else if ($nonfeatured_type == "Hotel" ){
								$nonfeatured_primary_image = "/img/hotels/".$nonfeatured[$key]['image'];
							} else if ($nonfeatured_type == "Attraction" ) {
								$nonfeatured_primary_image = "/img/attractions/".$nonfeatured[$key]['image'];
							} else {$nonfeatured_primary_image = 'http://placehold.it/350x300';}
							$nonfeatured_images = $nonfeatured[$key]['images'];
							$nonfeatured_city = $nonfeatured[$key]['city'];
							$nonfeatured_state = $nonfeatured[$key]['state'];
							if($selected_location == 'NO'){
								$selected_hide = '';
							} else{
								if($selected_location != $nonfeatured_location){
									$selected_hide = 'hide';
								} else {
									$selected_hide = '';
								}
							}
							?>
<!-- 							<li style="padding:30px 0; border-bottom: 1px dashed #aaa; margin-bottom: 0;" id="nonfeaturedLi-<?php echo $nonfeatured_id;?>" class="nonfeaturedLi media clearfix <?php echo $selected_hide;?>" type="<?php echo $nonfeatured_type;?>" order="<?php echo $name_order;?>" location="<?php echo $nonfeatured_location;?>" starting="<?php echo $nonfeatured_starting;?>" rating="<?php echo $nonfeatured_rating;?>">
								<a href="#" class="two columns alpha" style="height:100%;">
									<img class="media-object" src="<?php echo $nonfeatured_primary_image;?>"/>
								</a>
								<div class="ten colums omega">
									<h4 class="media-heading" style="margin-bottom: 2px; font-size: 16px; line-height: 16px; font-family: 'Open Sans Condensed', arial, serif; text-transform: uppercase;"><?php echo $this->Html->link($nonfeatured_name , array('controller'=>$address_type,'action'=>$address_method,$address_location, $address_name));?></h4>
									<p style="color: #888"><?php echo $nonfeatured_desc;?></p>
								</div>

								<div class="twelve columns alpha" style="background-color: #eee; padding: 10px 0;">
									<div class="star<?php echo preg_replace('/[^0-9]+/i', '', $nonfeatured_rating);?>" style="margin-top:3px;"></div>
									<label></label>
									<p style="font-size:14px; margin-left: 10px; float: left; margin-bottom: 0px; color:#666; line-height: 22px; ">
										<?php echo $nonfeatured_city.', '.$featured_state;?> | 
										Prices from <span style="font-weight:bold;">$<?php echo round($nonfeatured_starting); ?></span>
									<? switch($nonfeatured_type){
										case 'Hotel':
											echo "per night avg.";
											break;
											
										case 'Attraction':
											echo "per person avg.";
											break;	
									}?>
									</p>
									<?php
									echo $this->Html->link('More Info →', array('controller'=>$address_type,'action'=>$address_method,$address_location, $address_name), array('class'=>'pull-right btn btn-mini', 'style' => 'margin-right:10px;'));
									?>
								</div>

							</li> -->
							
							
							<li style="padding:15px 0; border-bottom: 1px dashed #aaa;" id="featuredLi-<?php echo $nonfeatured_id;?>" class="featuredLi media clearfix <?php echo $selected_hide;?>" order="<?php echo $name_order;?>" type="<?php echo $nonfeatured_type;?>" location="<?php echo $nonfeatured_location;?>" starting="<?php echo $nonfeatured_starting;?>" rating="<?php echo $nonfeatured_rating;?>">
								<a href="<?php echo $this->Html->url(array('controller'=>$address_type,'action'=>$address_method,$address_location,$address_name));?>" class="three columns alpha" style="height:100%;">
									<img class="media-object" src="<?php echo $nonfeatured_primary_image;?>" style="width:150px;"/>
								</a>
								<div class="seven columns">
									<h4 class="media-heading" style="margin-bottom: 2px; font-size:21px; line-height:21px; font-family: 'Open Sans Condensed', arial, serif; text-transform: uppercase;">
										<?php echo $this->Html->link($nonfeatured_name, array('controller'=>$address_type,'action'=>$address_method,$address_location,$address_name));?>
										<?php //echo $featured_name;?>
										</h4>
									<div style="margin-bottom: 10px; height: 16px;">
										<div class="star<?php echo preg_replace('/[^0-9]+/i', '', $nonfeatured_rating);?>"></div>
										<div style="float:left; margin-left:15px;"><label><?php echo $nonfeatured_city.', '.$nonfeatured_state;?></label></div>
									</div>
									
									<p><?php echo $nonfeatured_desc;?></p>
								</div>
									
								<div class="two columns omega">
									<div style="height: 100%; background-color: #f9f9f9; text-align: center; position: relative; display: block; box-shadow: 0px 1px 1px #aaa; padding: 10px 0; font-size: 11px; color: #999;">
									Prices from
									<span style="display: block; font-size: 30px; margin: 10px; color: #333;">$<?php echo round($nonfeatured_starting); ?></span>
									<? switch($nonfeatured_type){
										case 'Hotel':
											echo "USD including tax";
											break;
											
										case 'Attraction':
											echo "per person avg.";
											break;	
									}?>
									</div>
									<?php echo $this->Html->link('More Info', array('controller'=>$address_type,'action'=>$address_method,$address_location,$address_name), array('class'=>'btn btn-bbfl', 'style'=>'display:block;margin-top:10px;'));?>
								</div>
								
							</li>
							<?php
						}
						?>	
						</ul>
					</div>
				</div>

				
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
				'package_sidebar'=>$package_sidebar,
			)); 
			?>
				
		</div>	