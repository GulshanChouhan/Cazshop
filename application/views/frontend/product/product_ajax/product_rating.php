<div class="row">
		<div class="col-sm-3">
			<div class="rating-block">
				<h4>Average user rating</h4>
				<h2 class="average-user-rating">
					<?php echo number_format($product->sum_rating,1); ?> 
					<small>/ 5</small>
				</h2>
				<div class="rating-star-block">
					<span class="event_star star_big" data-starnum="<?php echo number_format($product->sum_rating,1); ?>"><i></i>
					</span>
				</div>
			</div>
		</div>
		<div class="col-sm-3">
			<h4>Rating breakdown</h4>
			<div class="progress-rating-bar progress-rating-block">
				<ul class="rating-full-view">
					<li class="rating-bar-list">
						<div class="ranking-points">
							<div class="number">5</div>
							<div class="start">★</div>
						</div>
						<div class="progress progress-slider">
							<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: 100%;">
							</div>
						</div>
						<div class="review-count">
							<div class="review-number"><?php echo ($product->rating5) ? $product->rating5 :0; ?></div>
						</div>
					</li>
					<li class="rating-bar-list">
						<div class="ranking-points">
							<div class="number">4</div>
							<div class="start">★</div>
						</div>
						<div class="progress progress-slider">
							<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: 80%;">
							</div>
						</div>
						<div class="review-count">
							<div class="review-number"><?php echo ($product->rating4) ? $product->rating4 :0; ?></div>
						</div>
					</li>
					<li class="rating-bar-list">
						<div class="ranking-points">
							<div class="number">3</div>
							<div class="start">★</div>
						</div>
						<div class="progress progress-slider">
							<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: 60%;">
							</div>
						</div>
						<div class="review-count">
							<div class="review-number"><?php echo ($product->rating3) ? $product->rating3 :0; ?></div>
						</div>
					</li>
					<li class="rating-bar-list">
						<div class="ranking-points">
							<div class="number">2</div>
							<div class="start">★</div>
						</div>
						<div class="progress progress-slider">
							<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: 20%;">
							</div>
						</div>
						<div class="review-count">
							<div class="review-number"><?php echo ($product->rating2) ? $product->rating2 :0; ?></div>
						</div>
					</li>
					<li class="rating-bar-list">
						<div class="ranking-points">
							<div class="number">1</div>
							<div class="start">★</div>
						</div>
						<div class="progress progress-slider">
							<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: 10%;">
							</div>
						</div>
						<div class="review-count">
							<div class="review-number"><?php echo ($product->rating1) ? $product->rating1 :0; ?></div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<?php $ratings=getratingList($product->product_variation_id);
	if(!empty($ratings)){	
	 ?>
	<div class="row">
		<div class="col-sm-7">
			<hr/>
			<div class="review-block">
			<?php foreach ($ratings as $key => $value) {
			 ?>		
				<div class="row">
					<div class="col-sm-3">
						<img src="http://dummyimage.com/60x60/666/ffffff&text=No+Image" class="img-rounded">
						<div class="review-block-name"><?php echo ucwords($value->user_name); ?></div>
						<?php
							$now = time(); // or your date as well
							$your_date = strtotime($value->created_at);
							$datediff = $now - $your_date;
						 ?>
						<div class="review-block-date"><?php echo date("M ,d Y", strtotime($value->created_at)); ?><br/><?php echo floor($datediff / (60 * 60 * 24)); ?> day ago</div>
					</div>
					<div class="col-sm-9">
						<div class="review-block-rate">
							<span class="event_star star_big" data-starnum="<?php echo $value->rating; ?>"><i></i></span>
						</div>
						
						<div class="review-block-description"><?php echo $value->description; ?></div>
					</div>
				</div>
				<hr/>
			<?php }?>	
				
			</div>
		</div>
	</div>
	<a href="<?php echo base_url('rating/'.base64_encode($product->product_variation_id)); ?>">See All</a>
<?php } ?>	