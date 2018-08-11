<div class="theme-background">
<!--Home Page main slider-->
<!-- <div class="container-fluid no-padding"> 
	<div class="home-banner-slider">
	 	<?php if(!empty($slider)){
	 		foreach ($slider as $key => $value) { ?>
	 	<div class="slide">
			<a href="<?php echo base_url($value->slider_img_link); ?>">
				<img data-lazy="<?php echo base_url($value->slider_img) ?>" width="100%">
				<img class="loader-spiner" data-lazy="<?php echo base_url($value->slider_img) ?>" width="100%" herf="<?php echo FRONTEND_THEME_URL ?>img/Spinner-loader-banner.gif">
				<img src="<?php echo FRONTEND_THEME_URL ?>img/Spinner-loader-banner.gif" class="ajax-loader"> 
			</a>
		</div>	
	 	<?php } } ?>
	</div>
</div> -->

<div class="container-fluid no-padding"> 
	<div class="home-slider-wrap">
		<div class="loader-new">
  			<img src="<?php echo FRONTEND_THEME_URL ?>/img/slider-loader.gif" style="max-width: 100%;width:100%;">
		</div>
		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		  <!-- Indicators -->
		  <ol class="carousel-indicators">
		  	<?php 
		  		if(!empty($slider)){
		  		$j = 0;
			 	foreach ($slider as $key => $value) { 
			?>
		    <li data-target="#carousel-example-generic" data-slide-to="<?php echo $j; ?>" class="<?php if($j==0) echo "active"; ?>"></li>
			<?php $j++; } } ?>
		  </ol>

		  <!-- Wrapper for slides -->
		  <div class="carousel-inner" role="listbox">
		  	<?php if(!empty($slider)){
		  		$i = 0;
			 	foreach ($slider as $key => $value) { ?>
				    <div class="item <?php if($i==0) echo "active"; ?>">
					 	<div class="">
							<a href="<?php echo base_url($value->slider_img_link); ?>">
								<img  onload="doneLoading()" src="<?php echo base_url($value->slider_img) ?>" width="100%">
							</a>
						</div>	
				    </div>
		    <?php $i++; } } ?>
		    <!-- Controls -->
		  	<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
		    	<span class="icofont icofont-thin-left" aria-hidden="true"></span>
		 	 </a>
		  	<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
		    	<span class="icofont icofont-thin-right" aria-hidden="true"></span>
		  	</a>
		</div>
	</div>
</div>

<?php msg_alert(); ?>
 <!--Home Page main slider End-->
<div class="" id="result"></div>
<!--popular-catg-section start-->
<?php if(!empty($popular_category)){ ?>
 <div class="container-fluid home-section popular-catg-section">
   <h2 class="text-center heading">Popular Categories</h2>
   <div class="catg-grid">
   	<ul class="list-unstyled clearfix">
   		<?php 
   			foreach ($popular_category as $row){
   				if(!empty($row->logo_image) && file_exists('assets/uploads/backend/category_img/logo/'.$row->logo_image)){ 
   		?>
	   		<li class="tile">   			
	   			<div class="catg-tile">		   		
	   		  		<div class="catg-info clearfix">   		  			
		   		  		<div class="img-block">
		   		  			<img src="<?php echo base_url().'assets/uploads/backend/category_img/logo/'.$row->logo_image; ?>">
		   		  		</div>
			   		  	<div class="short-description">
					   		<h3 class="catg-head">
				   		  		<a href="<?php echo base_url('p/'.$row->category_slug) ?>"><?php echo ucwords($row->category_name); ?></a>
				   		  	</h3>		   		  	
			   		  		<p><?php echo $row->short_description; ?></p>
			   		  	</div>	
			   		  	<div class="show-all"><a href="<?php echo base_url('p/'.$row->category_slug) ?>" class="check-link">Show All <i class="fa fa-caret-right" aria-hidden="true"></i></a></div>	   		    
	   		  		</div>
	   			</div>
	   		</li>
   		<?php } } ?>   				   		   		   		   		
   	</ul>
   </div>
 </div>
 <?php } ?>
<!--popular-catg-section end-->
<?php 
	$btc=getCryptocurrencyRate('usd-btc');
	$eth=getCryptocurrencyRate('usd-eth');
?>
<?php if(!empty($most_rated_or_discounted)){ ?>
<div class="container-fluid home-section new-changes">
	<h2 class="basic-heading"><?php echo $most_ratedDiscounted_heading; ?></h2>
	<div class="product-slider">
		<?php foreach($most_rated_or_discounted as $product){ ?>
		<div class="product-tile">
			<div class="image-block <?php if(empty($product->second_image)) echo 'signle-image'; ?>">
				<a class="image-without-hover" href="<?php echo base_url('pd/'.$product->slug.'/'.base64_encode($product->product_variation_id)); ?>">
					<img src="<?php if($product->image) echo base_url('assets/uploads/seller/products/small_thumbnail/'.$product->image); ?>">
				</a>
				<?php if(!empty($product->second_image)){ ?>
				<a class="image-on-hover" href="<?php echo base_url('pd/'.$product->slug.'/'.base64_encode($product->product_variation_id)); ?>">
					<img src="<?php if($product->second_image) echo base_url('assets/uploads/seller/products/small_thumbnail/'.$product->second_image); ?>">
				</a>
				<?php } ?>
				<?php $offer=round((($product->sell_price-$product->base_price)/$product->sell_price)*100);
				if($offer>0){
				 ?>
				<span class="offer-sticker-tag offer-tag-overflow new-offertag"><?php echo $offer; ?>%</span>
				<?php } ?>		
				<?php if($product->brand_name){ ?>		
				<div class="product-name">
					<a href="<?php echo base_url('pd/'.$product->slug.'/'.base64_encode($product->product_variation_id)); ?>"><?php echo ucfirst($product->brand_name); ?></a>
				</div>			
				<?php } ?>				
			</div>
			<div class="product-desc">
				<!-- <span class="rating">
					<div class="rating-btn">3.3 ★</div> <span>(25)</span>
				</span> -->				
				<div class="short-desc">
					<a class="" href="<?php echo base_url('pd/'.$product->slug.'/'.base64_encode($product->product_variation_id)); ?>"><?php echo ucfirst($product->title); ?> </a>
				</div>
				<div class="pricing-block clearfix">
					<div class="price-tag clearfix">
						<div class="doller-price">
							<span class="base-price">
								<span class="small-base-price-symbol">$</span><?php echo number_format($product->base_price,2); ?>
							</span>								
							 <?php if($product->base_price<$product->sell_price){
								echo '<span class="shell-price"><span class="small-base-price-symbol">$</span><del>'.number_format($product->sell_price,2).'<del></span>';
							} ?> 
						</div>
						<div class="cripto-price">
							<!-- <span class="bitcoin" data-toggle="tooltip" data-placement="top" title="<?php echo number_format($btc*$product->base_price,8); ?> BTC">
								<img src="<?php echo FRONTEND_THEME_URL ?>img/icons/bitcoin35.svg">
							</span>
							<span class="ethereum" data-toggle="tooltip" data-placement="top" title="<?php echo number_format($eth*$product->base_price,8); ?>  ETH">
								<img src="<?php echo FRONTEND_THEME_URL ?>img/icons/ethereum35.svg">
							</span> -->
							<?php 
								$wishListProduct = getRow('wish_list',array('user_id'=>user_id(), 'product_variation_id'=>$product->product_variation_id), array('wish_list_id'));
								if(!empty($wishListProduct)){
							?>
							<div class="wishlist-icon" data-toggle="tooltip" data-placement="top" title="Remove from Wishlist">	
								<a href="javascript:void(0)">
									<span class="heart-icon">
										<img class="removeFromWishlist" pID="<?php echo base64_encode($product->product_variation_id); ?>" src="<?php echo FRONTEND_THEME_URL ?>img/icons/heart-full.svg" width="22">
									</span> 
								</a>				
							</div>
							<?php }else{ ?>
							<div class="wishlist-icon" data-toggle="tooltip" data-placement="top" title="Add to Wishlist">
								<a href="javascript:void(0)">
									<span class="heart-icon">
										<img class="addToWishlist" pID="<?php echo base64_encode($product->product_variation_id); ?>" src="<?php echo FRONTEND_THEME_URL ?>img/icons/heart-empty.svg" width="22">
									</span>  	
								</a>													
							</div>
							<?php } ?>							
						</div>
					</div>
					<?php if($product->total_rating>0){ ?>
					<div class="rating">
						<span class="event_star star_small" data-starnum="<?php echo number_format($product->sum_rating,1); ?>"><i></i></span>
						<span class="rating-number">(<?php echo $product->total_rating; ?>)</span>
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
					<?php } ?>
					<!-- end rating section-->					
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
<?php } ?>

<?php if($page=get_page_content(2)){ ?>
<div class="home-section full-width-container-fluid">
	<!-- <div class="container-fluid ">
		<h2 class="basic-heading">Featured Brands</h2>
	</div> -->
	<div class="featured-banner-section">
		<div class="row">
			<?php echo $page->description; ?>			
		</div>
	</div>
</div>
<?php } ?>

<!--Most popular and recent viewd-->

<?php if(!empty($recentview_or_latest)){ ?>
<div class="container-fluid home-section new-changes">
	<h2 class="basic-heading"><?php echo $recentview_or_latest_heading; ?></h2>
	<div class="product-slider">
		<?php foreach($recentview_or_latest as $product){ ?>
		<div class="product-tile">
			<div class="image-block <?php if(empty($product->second_image)) echo 'signle-image'; ?>">
				<a class="image-without-hover" href="<?php echo base_url('pd/'.$product->slug.'/'.base64_encode($product->product_variation_id)); ?>">
					<img src="<?php if($product->image) echo base_url('assets/uploads/seller/products/small_thumbnail/'.$product->image); ?>">
				</a>
				<?php if(!empty($product->second_image)){ ?>
				<a class="image-on-hover" href="<?php echo base_url('pd/'.$product->slug.'/'.base64_encode($product->product_variation_id)); ?>">
					<img src="<?php if($product->second_image) echo base_url('assets/uploads/seller/products/small_thumbnail/'.$product->second_image); ?>">
				</a>
				<?php } ?>
				<?php $offer=round((($product->sell_price-$product->base_price)/$product->sell_price)*100);
				if($offer>0){
				 ?>
				<span class="offer-sticker-tag offer-tag-overflow"><?php echo $offer; ?>%</span>
				<?php } ?>		
				<?php if($product->brand_name){ ?>		
				<div class="product-name">
					<a href="<?php echo base_url('pd/'.$product->slug.'/'.base64_encode($product->product_variation_id)); ?>"><?php echo ucfirst($product->brand_name); ?></a>
				</div>			
				<?php } ?>				
			</div>
			<div class="product-desc">
				<!-- <span class="rating">
					<div class="rating-btn">3.3 ★</div> <span>(25)</span>
				</span> -->				
				<div class="short-desc">
					<a class="" href="<?php echo base_url('pd/'.$product->slug.'/'.base64_encode($product->product_variation_id)); ?>"><?php echo ucfirst($product->title); ?> </a>
				</div>
				<div class="pricing-block clearfix">
					<div class="price-tag clearfix">
						<div class="doller-price">
							<span class="base-price">
								<span class="small-base-price-symbol">$</span><?php echo number_format($product->base_price,2); ?>
							</span>								
							 <?php if($product->base_price<$product->sell_price){
								echo '<span class="shell-price"><span class="small-base-price-symbol">$</span><del>'.number_format($product->sell_price,2).'<del></span>';
							} ?> 
						</div>
						<div class="cripto-price">
							<!-- <span class="bitcoin" data-toggle="tooltip" data-placement="top" title="<?php echo number_format($btc*$product->base_price,8); ?> BTC">
								<img src="<?php echo FRONTEND_THEME_URL ?>img/icons/bitcoin35.svg">
							</span>
							<span class="ethereum" data-toggle="tooltip" data-placement="top" title="<?php echo number_format($eth*$product->base_price,8); ?> ETH">
								<img src="<?php echo FRONTEND_THEME_URL ?>img/icons/ethereum35.svg">
							</span> -->
							<?php 
								$wishListProduct = getRow('wish_list',array('user_id'=>user_id(), 'product_variation_id'=>$product->product_variation_id), array('wish_list_id'));
								if(!empty($wishListProduct)){
							?>
							<div class="wishlist-icon" data-toggle="tooltip" data-placement="top" title="Remove from Wishlist">	
								<a href="javascript:void(0)">
									<span class="heart-icon">
										<img class="removeFromWishlist" pID="<?php echo base64_encode($product->product_variation_id); ?>" src="<?php echo FRONTEND_THEME_URL ?>img/icons/heart-full.svg" width="22">
									</span> 
								</a>				
							</div>
							<?php }else{ ?>
							<div class="wishlist-icon" data-toggle="tooltip" data-placement="top" title="Add to Wishlist">
								<a href="javascript:void(0)">
									<span class="heart-icon">
										<img class="addToWishlist" pID="<?php echo base64_encode($product->product_variation_id); ?>" src="<?php echo FRONTEND_THEME_URL ?>img/icons/heart-empty.svg" width="22">
									</span>  	
								</a>													
							</div>
							<?php } ?>							
						</div>
					</div>
					<?php if($product->total_rating>0){ ?>
					<div class="rating">
						<span class="event_star star_small" data-starnum="<?php echo number_format($product->sum_rating,1); ?>"><i></i></span>
						<span class="rating-number">(<?php echo $product->total_rating; ?>)</span>
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
					<?php } ?>
					<!-- end rating section-->					
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
<?php } ?>
<?php if($page=get_page_content(1)){ ?>
<div class="full-width-container-fluid home-section">
	<div class="featured-banner-section">
		<div class="row">
			<?php echo $page->description; ?>		
		</div>
	</div>
</div>
<?php } ?>

<?php if($brand){ ?>		
<div class="container-fluid home-section">
	<div class="top-brand-block">
		<!-- <h3 class="text-center weather-font"><b></b></h3> -->
		<div class="row">
			<div class="top-brands-slider">
			<?php foreach($brand as $row){ ?>				
				<div class="brand-block">
				  <a href="<?php echo base_url('p?brand='.$row->brand_name);  ?>">
					<img src="<?php echo base_url('assets/uploads/backend/category_img/brand/'.$row->brand_image) ?>" class="img-responsive">	
				  </a>
				</div>
			<?php } ?>		
																			
			</div>
		</div>
	</div>
</div>
<?php } ?>


</div>
<script type="text/javascript">
	  // SCRIPT WORKS FOR HOME PAGE SLIDER
  var startTime = new Date().getTime();
  var loadtime=0;
  function doneLoading() {
    loadtime = new Date().getTime() - startTime;
      console.log("image took " + loadtime + "ms to load");
  };   
  $(document).ready(function(){
    setTimeout(function(){
        $(".loader-new").fadeOut("slow");
        $('body').css("overflow-y","");
        $('body').css("overflow-y","auto");
        $('.home-slider-wrap').css("min-height","");
      },loadtime);
  });
</script>