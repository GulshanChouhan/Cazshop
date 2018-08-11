<?php
$btc=getCryptocurrencyRate('usd-btc');
$eth=getCryptocurrencyRate('usd-eth');
?>
<div class="product-detail-heading">
<h2><?php $title=str_replace("'","\'",ucwords($product->title));
	echo ucwords($product->title); ?></h2>
	<?php if($product->total_rating>0){  ?>
	<div class="rating">
		<span class="event_star star_small" data-starnum="<?php echo number_format($product->sum_rating,1); ?>"><i></i></span>
		
		<span class="rating-number"><a href="<?php echo base_url('rating/'.base64_encode($product->product_variation_id)); ?>"><?php echo $product->total_rating; ?> Review</a></span>
		<div class="rating-tooltip-tile-hover">
			<div class="rating-tooltip-inner clearfix">
				<div class="rating-tooltip-content clearfix">
					<div class="col-sm-4 no-padding left-side">
						<div class="rating-view text-center">
							<div class="number"><?php echo number_format($product->sum_rating,1); ?></div>
							<div class="start">★</div>
						</div>
						<div class="number-of-ratings">
							<span><?php echo $product->total_rating; ?> Ratings </span>
						</div>
						
					</div>
					<div class="col-sm-8 no-padding right-side">
						<div class="progress-rating-bar">
							<ul>
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
			</div>
		</div>
	</div>	
	<?php }else{  ?>
		<!-- <div class="rating">
			<span class="event_star star_small" data-starnum="<?php echo number_format($product->sum_rating,0); ?>"><i></i></span>
			
			<span class="rating-number"><a href="<?php echo base_url('rating/'.base64_encode($product->product_variation_id)); ?>"><?php echo $product->total_rating,0 ?> Review</a></span>
			<span class="no-rating"><span>No rating available</span></span>
		</div> -->
	<?php } ?>
	<!-- end rating section-->		
	<div class="clearfix"></div>
</div>
<div class="product-price">
	<?php
	if($product->sale_start_date!='' && $product->sale_start_date>=date('Y-m-d H:i:s A') && $product->sale_end_date!='' && $product->sale_end_date<=date('Y-m-d H:i:s A')){
		$product->base_price=$product->sale_price;
	}
	if($product->base_price<=$product->sell_price){ ?>
	<div class="main-price">
		<!-- <div class="title-label-left">
			<span class="price-lable title-label">Price :</span>
		</div> -->
		<div class="title-label-right">
			<div class="detail-price-wraperr clearfix">
                <div class="dollar-price-left">
					<span class="price-text"><span class="dollar-icon-bold">$</span><?php echo number_format($product->base_price,2); ?>
					</span>
					<span class="price-text mrp-price"><span class="dollar-icon-normal">$</span><del><?php echo number_format($product->sell_price,2); ?></del>
					</span>
					<?php if($product->base_price<$product->sell_price){ ?>
					<div class="taxes-inclusive">
						<span class="">Inclusive of all taxes</span>
						<span class="price-text save-price">(<?php echo round((($product->sell_price-$product->base_price)/$product->sell_price)*100) ?>%) Off
						</span>
					</div>
					<?php } ?>
				</div>
				<!--==========OFFER PRICE COMMENTED===============-->
				<div class="currency-converter">
					<div class="bitcoin">
						<img src="<?php echo FRONTEND_THEME_URL ?>img/icons/bitcoinlgo-35.svg">
						<span><?php echo number_format($btc*$product->base_price,8); ?> BTC</span>
					</div>
					<div class="ethereum">
						<img src="<?php echo FRONTEND_THEME_URL ?>img/icons/ethereum35.svg">
						<span><?php echo number_format($eth*$product->base_price,8); ?> ETH</span>
					</div>
				</div>
			</div>
			<div class="putShipmentRateDiv addressShipment detial-delivery-address">
				<div class="your-address-delivery">
	             	<span class="guaranteed-title">Guaranteed</span>
	                <span class="">
		                Delivery to <?php echo $shippingCharge['yourAddress']; ?>.
		            </span>
	        	</div>
                <div class="address-status">
	                <?php
	                   	$notApplicable = ' ( Not available for delivery at your location )';
	                   	if($shippingCharge['type']==1){
	                      echo "( FREE Delivery )";
	                   	}else if(($shippingCharge['type']==2 || $shippingCharge['type']==3) && !empty($shippingCharge['data'])){
	                      	if(!empty($shippingCharge['data']) && $shippingCharge['data']!=0.00 && $shippingCharge['data']!=0){
		                      	foreach ($shippingCharge['data'] as $key => $value) {
		                      		if(!empty($value->price) && !empty($value->price) && !empty($value->price)){

		                      			echo '<div class="shipping-method"><div class="title">'.str_replace("_"," ",$key).' - </div><div class="shipping-method-info"><span class="charge-price"><span class="dollar-icon-bold">$</span>'.number_format($value->price, 2).'</span> delivered within <strong>'.$value->min_day.' - '.$value->max_day.' Business Days.</strong></div></div>';

		                      		}
			                    }
	                      	}else{
	                      		echo $notApplicable;
	                      	}
	                   	}else{
	                      echo $notApplicable;
	                   	}
	                ?>
                </div>
	        </div>
		</div>
	</div>
	<?php } ?>
</div>	
