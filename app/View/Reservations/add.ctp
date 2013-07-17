<?php
//load scripts to layout
echo $this->Html->script(array(
	'admin/reservation_add.js'
	),
	FALSE
);
?>

<div class="reservations form">
<h2><?php echo __('Add Reservation'); ?></h2>

<div id="side_accordion3" class="accordion">
	<div class="accordion-group">
		<div class="accordion-heading">
			<a href="#collapse-ferry" data-parent="#side_accordion3" data-toggle="collapse" class="accordion-toggle collapsed"> Ferry Reservation</a>
		</div>
		<div class="accordion-body collapse" id="collapse-ferry">
			<div class="accordion-inner">	
	
				<h3 class="heading">Ferry Setup</h3>
				<div class="control-group">
					<form action="/reservations/processing_ferry_backend_finish" method="post">
					<?php
					echo $this->element('reservations/reservation_ferry',array());
					?>						
					</form>

				</div>
			</div>
		</div>
	</div>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a href="#collapse-hotel" data-parent="#side_accordion3" data-toggle="collapse" class="accordion-toggle collapsed"> Hotel Reservation</a>
		</div>
		<div class="accordion-body collapse" id="collapse-hotel">
			<div class="accordion-inner">	
	
				<h3 class="heading">Hotel Setup</h3>
				<div class="control-group">
					<form action="/reservations/processing_hotel_backend_finish" method="post">
					<?php
					echo $this->element('reservations/reservation_hotel',array(
						'hotels',$hotels
					));
					?>						
					</form>

				</div>
			</div>
		</div>	
	</div>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a href="#collapse-attraction" data-parent="#side_accordion3" data-toggle="collapse" class="accordion-toggle collapsed"> Attraction Reservation</a>
		</div>
		<div class="accordion-body collapse" id="collapse-attraction">
			<div class="accordion-inner">	
	
				<h3 class="heading">Attraction Setup</h3>
				<div class="control-group">
					<form action="/reservations/processing_attraction_backend_finish" method="post">
					<?php
					echo $this->element('reservations/reservation_attraction',array(
						'attractions',$attractions
					));
					?>
					</form>
				</div>
			</div>
		</div>	
	</div>
	<div class="accordion-group">
		<div class="accordion-heading">
			<a href="#collapse-package" data-parent="#side_accordion3" data-toggle="collapse" class="accordion-toggle collapsed"> Package Reservation</a>
		</div>
		<div class="accordion-body collapse" id="collapse-package">
			<div class="accordion-inner">	
	
				<h3 class="heading">Package Setup</h3>
				<div class="control-group">
					<form class="formPackage" method="post" action="/reservations/processing_package_backend_finish">
						<?php
						echo $this->element('reservations/reservation_package',array(
							'packages'=>$packages
						));
						?>						
					</form>

				</div>
			</div>
		</div>	
	</div>
</div>

</div>

<!-- used for javascript purposes -->
<div id="extraFormElements" class="hide">
	<div id="inventoryOptgroups">
		<?php
		foreach ($inventories as $inventory) {
			$inventory_name = $inventory['Inventory']['name'];
			$inventory_id = $inventory['Inventory']['id'];
			
			?>
			<optgroup inventory_id="<?php echo $inventory_id;?>" label="<?php echo $inventory_name;?>">
				
			<?php
			foreach ($inventory_items as $ii) {
				$ii_name = $ii['Inventory_item']['name'];
				$ii_id = $ii['Inventory_item']['id'];
				$ii_inventory_id = $ii['Inventory_item']['inventory_id'];
				
				if($ii_inventory_id == $inventory_id){
					
					?>
					<option inventory_id="<?php echo $ii_inventory_id;?>" value="<?php echo $ii_id;?>"><?php echo $ii_name;?></option>
					<?php	
				}
			}
			?>
			</optgroup>
			
			
			<?php
		}
		?>		
	</div>	
	<div id="packageSelection">
		<?php
		foreach ($packages as $p) {
			$package_id = $p['Package']['id'];
			$package_name = $p['Package']['name'];
			$package_location = $p['Package']['location'];
			$package_status = $p['Package']['status'];
			$package_start = date('n/d/Y',strtotime($p['Package']['start_date']));
			$package_end = date('n/d/Y',strtotime($p['Package']['end_date']));
			
			switch ($package_status) {
				case '1':
					$oackage_status = 'Draft';
					break;
				case '2':
					$package_status = '';
					break;
				case '3':
					$package_status = '';
					break;
				case '4':
					$package_status = '';
					break;	
				case '5':
					$package_status = '';
					break;
				default:
					$package_status = 'Bookable & Public';
					break;
			}						
			
			
			?>
			<option start="<?php echo strtotime($p['Package']['start_date']);?>" end="<?php echo strtotime($p['Package']['end_date']);?>" value="<?php echo $package_id;?>"><?php echo $package_name.' - ['.$package_start.' - '.$package_end.'] ['.$package_status.']';?></option>
			<?php
		}
		?>		
	</div>
</div>
