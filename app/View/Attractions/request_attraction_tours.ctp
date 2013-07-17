<?php
if($_REQUEST['attraction_id'] && $_REQUEST['start']){
	$time = 0;
	$notime = 0;
	if(count($tour_rates)>0){
		
		foreach ($tour_rates as $tour) {
			
			foreach ($tour as $r) {

				$time_tour = $r['time_tour'];
				if($time_tour == 'Yes'){
					$time++;
				} else {
					$notime++;
				}	
			}
		}
	}
	if(count($tour_rates)>0){

		if($time > 0 && $notime == 0 || $time > 0 && $notime > 0){
			//tour ticket time selection
			?>
			<li class="twelve columns alpha well well-large clearfix" style="padding-right:0px; padding-left:0px;">
				<div style="padding-left:20px;">
					<h3>Choose Tour</h3>
					<?php
					//debug($tour_rates);
					foreach ($tour_rates as $tr) {

						foreach ($tr as $tt) {
							$t_tour_id = $tt['tour_id'];
							$t_tour_name = $tt['tour_name'];
							$t_time = $tt['time'];
							$t_time_tour = $tt['time_tour'];
							$t_tour_inventory = $tt['tour_inventory'];
							$t_inventory = 0;
							$t_reserved = 0;
							switch ($t_time_tour) {
								case 'No':
									$t_title = $t_tour_name; 	
									$t_checked = 'checked="checked"';
									foreach ($t_tour_inventory as $tinKey => $tinValue) {
										$tinventory = $t_tour_inventory[$tinKey]['inventory'];
										$treserved = $t_tour_inventory[$tinKey]['reserved'];
										$t_inventory = $t_inventory + $tinventory;
										$t_reserved = $t_reserved + $treserved;	

									}									
									//if there are no more reservations then disable the input
									if($t_reserved >= $t_inventory){
										?>
										<div class="control-group error twelve columns alpha">
											<label class="radio"><input id="tourTime-<?php echo $t_tour_id;?>" timed="No" class="tourTime"  type="radio" name="timedRadio" value="<?php echo $t_tour_id;?>" disabled="disabled"/>[SOLD OUT] <?php echo $t_title;?></label>
										</div>
										<?php										
									} else {
										?>
										<div class="control-group twelve columns alpha">
											<label class="radio"><input id="tourTime-<?php echo $t_tour_id;?>" timed="No" class="tourTime" type="radio" name="timedRadio" value="<?php echo $t_tour_id;?>" title="<?php echo $t_title;?>" checked="checked" /> <?php echo $t_title;?></label>
										</div>
										<?php	
										
									}		
									break;
								
								default:
									foreach ($t_tour_inventory as $tinKey => $tinValue) {
										$tour_time = $tinKey;
										$t_title = $t_tour_name.' @ '.$tour_time; 
										$t_checked = '';
										foreach($t_tour_inventory[$tinKey] as $tin){
											$tinventory = $tin['inventory'];
											$treserved = $tin['reserved'];
											$t_inventory = $t_inventory + $tinventory;
											$t_reserved = $t_reserved + $treserved;		
						
										}

										//if there are no more reservations then disable the input
										if($t_reserved >= $t_inventory){
											?>
											<div class="control-group error twelve columns alpha">
												<label class="radio"><input id="tourTime-<?php echo $t_tour_id;?>" class="tourTime" time="<?php echo $tour_time;?>" timed="Yes" type="radio" name="timedRadio" value="<?php echo $t_tour_id;?>" disabled="disabled"/>[SOLD OUT] <?php echo $t_title;?></label>
											</div>
											<?php										
										} else {
											?>
											<div class="control-group twelve columns alpha">
												<label class="radio"><input id="tourTime-<?php echo $t_tour_id;?>" class="tourTime" time="<?php echo $tour_time;?>" timed="Yes" type="radio" name="timedRadio" value="<?php echo $t_tour_id;?>" title="<?php echo $t_title;?>" /> <?php echo $t_title;?></label>
											</div>
											<?php	
											
										}
		
									}									

									break;
							}
							
			
						}
					}
					
					?>				
				</div>
	
			</li>
			
			<?php
		}
	}	
	if(count($tour_rates)>0){
		$idx=-1;
		foreach ($tour_rates as $tour) {

			foreach ($tour as $r) {
				
			$idx++;
			$tour_id = $r['tour_id'];

			$date = $r['date'];
			$blackout = $r['blackout'];
			$blackout_string = $r['blackout_dates'];
			$tour_name = $r['tour_name'];
			$tour_desc = $r['tour_desc'];
			$tour_primary_image = $r['tour_primary_image'];
			$tour_sorted_images = $r['tour_sorted_images'];
			$taxes = $r['taxes'];
			$tax_rate= $r['tax_rate'];
			$status	 = $r['status'];
			$time = $r['time'];
			$time_tour = $r['time_tour'];
			$tour_inventory = $r['tour_inventory'];

			
			if($blackout_string == ''){
				$label_status = '<span class="label label-success">Available</label>';
				$blackout_dates = '';
				$disabled = '';
			} else {
				$label_status = '<span class="label label-important">Not Available</span>';
				$blackout_dates = '<em>Warning: There are blackout dates on '.$blackout_string.'<em>';
				$disabled='hide';
			}
			
				if(!empty($tour_inventory)>0){
					switch($time_tour){
						case 'Yes':
							foreach ($tour_inventory as $tinKey => $tinValue) {
								$tour_time = $tinKey;
								foreach ($tour_inventory[$tinKey] as $ti) {
									$age_range = $ti['age_range'];
									$inventory = $ti['inventory'];
									$net = $ti['net'];
									$markup = $ti['markup'];
									$gross = $ti['gross'];	
									$tour_hide = 'style="display:none;"';
									$timedLi = 'time="'.$time.'"';
									$title = $tour_name.' @ '.$tour_time; 						
									
								}
								?>
								
								<li id="tourLi-<?php echo $tour_id;?>" time="<?php echo $tour_time;?>"  class="tourLi twelve columns alpha" <?php echo $tour_hide.$timedLi;?> title="<?php echo $title;?>">
									<form method="post" action="/attractions/processing_frontend_attractions">
									<a href="#" class="two columns alpha" style="height:100%;">
										<img class="media-object img-border" src="/img/attractions/<? echo $tour_primary_image; ?>" style="width:75px"/>
									</a>
									<div class="ten columns omega" >
										<div class="seven columns alpha">
											<h4 class="media-heading"><?php echo $title;?></h4>
											<p><?php echo $tour_desc;?></p>	
											<!-- tour ticket information -->
											<div id="tourTicketInfoDiv">
												<table class="table table-bordered table-hovered table-striped" style="width:50%;">
													<thead>
														<tr>
															<th><strong>Ticket Type</strong></th>
															<th><strong>Price</strong></th>
														</tr>
													</thead>
													<tbody>
													<?php
													
													switch($time_tour){
														case 'No':
															$idx = -1;
															foreach ($tour_inventory as $tinKey => $tinValue) {
																$idx++;
																foreach ($tour_inventory as $t) {
																	
																	$age_range = $t['age_range'];
																	$gross = $t['gross'];
																	if($idx==0){
																	?>
																	<tr>
																		<td><?php echo $age_range;?> </td>
																		<td>$<?php echo $gross;?></td>
																	</tr>
																	<?php													
																	}												
																	
																}
						
					
															}											
														break;
															
														default:
															$idx = -1;
															foreach ($tour_inventory as $tinKey => $tinValue) {
																$idx++;
																$tour_time = $tinKey;
																foreach ($tour_inventory[$tinKey] as $t) {
																	$age_range = $t['age_range'];
																	$gross = $t['gross'];		
																	if($idx==0){
																	?>
																	<tr>
																		<td><?php echo $age_range;?> </td>
																		<td>$<?php echo $gross;?></td>
																	</tr>
																	<?php												
																	}								
																}
															}										
														break;
													}
					
													?>									
													</tbody>
												</table>							
											</div>
											<!-- tour ticketing -->
											<div id="tourAmountDiv" class="clearfix">
											<?php
											foreach ($tour_inventory as $tiKey =>$tiValue) {
												$tour_time = $tiKey;		
													if($time_tour == 'Yes'){
														if($tour_time == $time){
															foreach ($tour_inventory[$tiKey] as $t) {
																$age_range = $t['age_range'];
																$reserved = $t['reserved'];
																$inventory_limit = $t['inventory'];
																$net = $t['net'];
																$markup = $t['markup'];
																$gross = $t['gross'];
																if($reserved >= $inventory_limit){
																?>
																<div class="control-group error pull-left span3">
																	<label><?php echo $age_range;?></label>
																	<input type="text" class="typePrice span12" age_range="<?php echo $age_range;?>" inventory="<?php echo $inventory_limit;?>" gross="<?php echo $gross;?>" placeholder="SOLD OUT"disabled="disabled"/>

																	<span class="help-block"></span>
																</div>
																<?php									
																} else {
																?>
																<div class="control-group pull-left span3">
																	<label><?php echo $age_range;?></label>
																	<input type="text" class="typePrice span12" name="data[Attraction_reservation][purchase_info][<?php echo $age_range;?>][amount]" age_range="<?php echo $age_range;?>" reserved="<?php echo $reserved;?>" inventory="<?php echo $inventory_limit;?>" tax_rate="<?php echo ($tax_rate/100); ?>" gross="<?php echo $gross;?>"/>
																	<input type="hidden" name="data[Attraction_reservation][purchase_info][<?php echo $age_range;?>][name]" value="<?php echo $age_range;?>"/>
																	<input type="hidden" name="data[Attraction_reservation][purchase_info][<?php echo $age_range;?>][gross]" value="<?php echo $gross;?>"/>
																	<input type="hidden" name="data[Attraction_reservation][purchase_info][<?php echo $age_range;?>][inventory]" value="<?php echo $inventory_limit;?>"/>																	
																	
																	<span class="help-block"></span>
																</div>
																<?php									
																}										
															}
															
														}
													} else {
														$age_range = $tour_inventory[$tiKey]['age_range'];
														$reserved = $tour_inventory[$tiKey]['reserved'];
													
														$inventory_limit =$tour_inventory[$tiKey]['inventory'];
														$net = $tour_inventory[$tiKey]['net'];
														$markup = $tour_inventory[$tiKey]['markup'];
														$gross = $tour_inventory[$tiKey]['gross'];
					
														if($reserved >= $inventory_limit){
														?>
														<div class="control-group error pull-left span3">
															<label><?php echo $age_range;?></label>
															<input type="text" class="typePrice span12" age_range="<?php echo $age_range;?>" inventory="<?php echo $inventory_limit;?>" gross="<?php echo $gross;?>" disabled="disabled" placeholder="SOLD OUT"/>
															<span class="help-block"></span>
														</div>
														<?php
														} else {
														?>
														<div class="control-group pull-left span3">
															<label><?php echo $age_range;?></label>
															<input type="text" class="typePrice span12" name="data[Attraction_reservation][purchase_info][<?php echo $age_range;?>][amount]" age_range="<?php echo $age_range;?>" reserved="<?php echo $reserved;?>" inventory="<?php echo $inventory_limit;?>" tax_rate="<?php echo ($tax_rate/100); ?>" gross="<?php echo $gross;?>"/>
															<input type="hidden" name="data[Attraction_reservation][purchase_info][<?php echo $age_range;?>][name]" value="<?php echo $age_range;?>"/>
															<input type="hidden" name="data[Attraction_reservation][purchase_info][<?php echo $age_range;?>][gross]" value="<?php echo $gross;?>"/>
															<input type="hidden" name="data[Attraction_reservation][purchase_info][<?php echo $age_range;?>][inventory]" value="<?php echo $inventory_limit;?>"/>	
															<span class="help-block"></span>
														</div>
														<?php									
														}
													}
												
												
											}					
											?>	
											
											</div>
											<div class="four columns alpha">
												<span id="errorMessage" class="text text-error"></span>	
											</div>						
										</div>
						
										<div class="three columns omega pull-right">
											<ul>
												<li><?php echo $label_status;?></li>
												<li id="summaryLi">
													<table id="summaryTable" width="100%" class="hide">
														<tbody>
					
														</tbody>
														<tfoot style="border-top:1px solid #5e5e5e;">
															<tr>
																<td>Total Pretax</td>
																<td id="total_pretax" style="text-align:right"></td>
															</tr>
															<tr>
																<td>Total Tax</td>
																<td id="total_tax" style="text-align:right"></td>
															</tr>
															<tr style="border-top:1px solid #5e5e5e">
																<td><strong>Total Due</strong></td>
																<td id="total_after_tax" style="text-align:right; font-weight:bolder"></td>
															</tr>
														</tfoot>
													</table>
												</li>
												<li>
													<input type="hidden" value="<?php echo $attraction_id;?>" name="data[Attraction_reservation][attraction_id]"/>
													<input type="hidden" value="<?php echo $tour_id;?>" name="data[Attraction_reservation][tour_id]"/>
													<input type="hidden" value="<?php echo $date;?>" name="data[Attraction_reservation][date]"/>
													<input id="timeSelected" type="hidden" value="" name="data[Attraction_reservation][time]"/>
													<button type="button" id="bookTour-<?php echo $tour_id;?>" class="bookTour <?php echo $disabled;?> btn btn-success btn-block" time="<?php echo $time;?>"  date="<?php echo $date;?>" <?php echo $disabled;?>>BOOK NOW</button>
												</li>
											</ul>
										</div>
									</div>
									</form>
								</li>						
								<?php
							}	
						break;
							
						default:

							foreach ($tour_inventory as $tinKey => $tinValue) {
								foreach ($tour_inventory[$tinKey] as $ti) {
									$age_range = $ti['age_range'];
									$inventory = $ti['inventory'];
									$net = $ti['net'];
									$markup = $ti['markup'];
									$gross = $ti['gross'];
									$tour_hide = '';
									$timedLi = '';
									$title = $tour_name; 										
								}
							}						
							?>
								
								<li id="tourLi-<?php echo $tour_id;?>"   class="tourLi twelve columns alpha" <?php echo $tour_hide.$timedLi;?> title="<?php echo $title;?>">
									<form method="post" action="/attractions/processing_frontend_attractions">

									<a href="#" class="two columns alpha" style="height:100%;">
										<img class="media-object img-border" src="/img/attractions/<? echo $tour_primary_image; ?>" style="width:75px"/>
									</a>
									<div class="ten columns omega" >
										<div class="seven columns alpha">
											<h4 class="media-heading"><?php echo $title;?></h4>
											<p><?php echo $tour_desc;?></p>	
											<!-- tour ticket information -->
											<div id="tourTicketInfoDiv">
												<table class="table table-bordered table-hovered table-striped" style="width:50%;">
													<thead>
														<tr>
															<th><strong>Ticket Type</strong></th>
															<th><strong>Price</strong></th>
														</tr>
													</thead>
													<tbody>
													<?php
													
													switch($time_tour){
														case 'No':
															$idx = -1;
															foreach ($tour_inventory as $tinKey => $tinValue) {
																$idx++;
																foreach ($tour_inventory as $t) {
																	
																	$age_range = $t['age_range'];
																	$gross = $t['gross'];
																	if($idx==0){
																	?>
																	<tr>
																		<td><?php echo $age_range;?> </td>
																		<td>$<?php echo $gross;?></td>
																	</tr>
																	<?php													
																	}												
																	
																}
						
					
															}											
														break;
															
														default:
															$idx = -1;
															foreach ($tour_inventory as $tinKey => $tinValue) {
																$idx++;
																$tour_time = $tinKey;
																foreach ($tour_inventory[$tinKey] as $t) {
																	$age_range = $t['age_range'];
																	$gross = $t['gross'];		
																	if($idx==0){
																	?>
																	<tr>
																		<td><?php echo $age_range;?> </td>
																		<td>$<?php echo $gross;?></td>
																	</tr>
																	<?php												
																	}								
																}
															}										
														break;
													}
					
													?>									
													</tbody>
												</table>							
											</div>
											<!-- tour ticketing -->
											<div id="tourAmountDiv">
											<?php
											foreach ($tour_inventory as $tiKey =>$tiValue) {
												$tour_time = $tiKey;		
													if($time_tour == 'Yes'){
														if($tour_time == $time){
															$chosen_time = $tour_time;
															foreach ($tour_inventory[$tiKey] as $t) {
																$age_range = $t['age_range'];
																$reserved = $t['reserved'];
																$inventory_limit = $t['inventory'];
																$net = $t['net'];
																$markup = $t['markup'];
																$gross = $t['gross'];
																if($reserved >= $inventory_limit){
																?>
																<div class="control-group error pull-left span3">
																	<label><?php echo $age_range;?></label>
																	<input type="text" class="typePrice span12" age_range="<?php echo $age_range;?>" inventory="<?php echo $inventory_limit;?>" gross="<?php echo $gross;?>" placeholder="SOLD OUT"disabled="disabled"/>
																	<span class="help-block"></span>
																</div>
																<?php									
																} else {
																?>
																<div class="control-group pull-left span3">
																	<label><?php echo $age_range;?></label>
																	<input type="text" class="typePrice span12" name="data[Attraction_reservation][purchase_info][<?php echo $age_range;?>][amount]" age_range="<?php echo $age_range;?>" reserved="<?php echo $reserved;?>" inventory="<?php echo $inventory_limit;?>" tax_rate="<?php echo ($tax_rate/100); ?>" gross="<?php echo $gross;?>"/>
																	<input type="hidden" name="data[Attraction_reservation][purchase_info][<?php echo $age_range;?>][name]" value="<?php echo $age_range;?>"/>
																	<input type="hidden" name="data[Attraction_reservation][purchase_info][<?php echo $age_range;?>][gross]" value="<?php echo $gross;?>"/>
																	<input type="hidden" name="data[Attraction_reservation][purchase_info][<?php echo $age_range;?>][inventory]" value="<?php echo $inventory_limit;?>"/>	
																	<span class="help-block"></span>
																</div>
																<?php									
																}										
															}
															
														}
													} else {
														$age_range = $tour_inventory[$tiKey]['age_range'];
														$reserved = $tour_inventory[$tiKey]['reserved'];
													
														$inventory_limit =$tour_inventory[$tiKey]['inventory'];
														$net = $tour_inventory[$tiKey]['net'];
														$markup = $tour_inventory[$tiKey]['markup'];
														$gross = $tour_inventory[$tiKey]['gross'];
					
														if($reserved >= $inventory_limit){
														?>
														<div class="control-group error pull-left span3">
															<label><?php echo $age_range;?></label>
															<input type="text" class="typePrice span12" age_range="<?php echo $age_range;?>" inventory="<?php echo $inventory_limit;?>" gross="<?php echo $gross;?>" disabled="disabled" placeholder="SOLD OUT"/>
															<span class="help-block"></span>
														</div>
														<?php
														} else {
														?>
														<div class="control-group pull-left span3">
															<label><?php echo $age_range;?></label>
															<input type="text" class="typePrice span12" name="data[Attraction_reservation][purchase_info][<?php echo $age_range;?>][amount]" age_range="<?php echo $age_range;?>" reserved="<?php echo $reserved;?>" inventory="<?php echo $inventory_limit;?>" tax_rate="<?php echo ($tax_rate/100); ?>" gross="<?php echo $gross;?>"/>
															<input type="hidden" name="data[Attraction_reservation][purchase_info][<?php echo $age_range;?>][name]" value="<?php echo $age_range;?>"/>
															<input type="hidden" name="data[Attraction_reservation][purchase_info][<?php echo $age_range;?>][gross]" value="<?php echo $gross;?>"/>
															<input type="hidden" name="data[Attraction_reservation][purchase_info][<?php echo $age_range;?>][inventory]" value="<?php echo $inventory_limit;?>"/>	
															<span class="help-block"></span>
														</div>
														<?php									
														}
													}

											}					
											?>	
											</div>
											<div class="four columns alpha">
												<span id="errorMessage" class="text text-error"></span>	
											</div>	
																	
										</div>
						
										<div class="three columns omega pull-right">
											<ul>
												<li><?php echo $label_status;?></li>
												<li id="summaryLi">
													<table id="summaryTable" width="100%" class="hide">
														<tbody>
					
														</tbody>
														<tfoot style="border-top:1px solid #5e5e5e;">
															<tr>
																<td>Total Pretax</td>
																<td id="total_pretax" style="text-align:right"></td>
															</tr>
															<tr>
																<td>Total Tax</td>
																<td id="total_tax" style="text-align:right"></td>
															</tr>
															<tr style="border-top:1px solid #5e5e5e">
																<td><strong>Total Due</strong></td>
																<td id="total_after_tax" style="text-align:right; font-weight:bolder"></td>
															</tr>
														</tfoot>
													</table>
												</li>
												<li>
													<input type="hidden" value="<?php echo $attraction_id;?>" name="data[Attraction_reservation][attraction_id]"/>
													<input type="hidden" value="<?php echo $tour_id;?>" name="data[Attraction_reservation][tour_id]"/>
													<input type="hidden" value="<?php echo $date;?>" name="data[Attraction_reservation][date]"/>
													<input id="timeSelected" type="hidden" value="" name="data[Attraction_reservation][time]"/>
													<button type="button" id="bookTour-<?php echo $tour_id;?>" class="bookTour <?php echo $disabled;?> btn btn-success btn-block" time="<?php echo $time;?>"  date="<?php echo $date;?>" <?php echo $disabled;?>>BOOK NOW</button>
													
												</li>
											</ul>
										</div>
									</div>
									</form>
								</li>						
								<?php	
						break;
					}
					
				}
			
			}
		}
	} else {
		?>
		<li class="twelve columns alpha"><strong class="text text-error">There are no tours on this selected date. Please select another date!</strong></li>
		<?php
	}		
}
?>