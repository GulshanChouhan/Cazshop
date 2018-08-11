<?php //p($variations);
	if(!empty($variations))
	{
		foreach ($variations as $key => $value) {
			if(!in_array($key, array('product_variations_id','colour'))){
 ?>
	<div class="product-variation-block size-variation-block <?php echo  $key ?>">
		<span class="price-lable title-label"> <?php echo  $key ?>:</span>
			<span class="variation-entity">
				<select class="product_attribute form-control" main="<?php echo $key; ?>" id="<?php echo $key; ?>">
					<option value="">Select <?php echo $key; ?></option>	
					<?php foreach($value as $k=>$v){
						echo '<option value="'.$v.'">'.$v.'</option>';
					} ?>
				</select>		
			</span>
	</div>		
<?php	}	}	}?>	