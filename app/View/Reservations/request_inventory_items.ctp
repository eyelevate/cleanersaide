<select class="packagesInventorySelect" name="data[Reservation][<?php echo $index;?>][vehicle][0][inventory_item_id]">
<?php
foreach ($optgroups as $key => $value) {
	?>
	<optgroup label="<?php echo $value['name'];?>">
		<?php
		foreach ($options as $opt) {
			$inv_name = $opt['Inventory_item']['name'];
			$inv_id = $opt['Inventory_item']['id'];
			?>
			<option value="<?php echo $inv_id;?>"><?php echo $inv_name;?></option>
			<?php
		}
		?>
	</optgroup>
	<?php
}
?>
</select>