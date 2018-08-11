<?php 
	$btc=getCryptocurrencyRate('usd-btc');
	$eth=getCryptocurrencyRate('usd-eth');
?>
<div class="col-sm-12">
	<?php if(!empty($category) && (count($category) > 10000)){ ?>
		<div class="cat-title-block">
			<h3><b>Shop by category</b></h3>
		</div>
		<ul class="list-unstyled catgory-list-grid row">
			<?php foreach($category as $row){ ?>
				<li>
					<!-- <div class="product-tile">
						<div class="image-block">
							<a href="<?php  //echo base_url('p/'.$row->category_slug);  ?>">
								<img alt="<?php //echo $row->category_name ?>" src="<?php if($row->logo_image) //echo base_url('assets/uploads/backend/category_img/logo/'.$row->logo_image); else echo FRONTEND_THEME_URL.'img/product-1.png'; ?>">
							</a>
						</div>
						<div class="product-desc">
							<div class="product-name">
								<a href="<?php  //echo base_url('p/'.$row->category_slug);  ?>"><?php //echo ucwords(trim($row->category_name)); ?></a>
							</div>
						</div>
					</div> -->
					<div class="category-block-list-page">
						<div class="category-image-block">
							<a href="<?php  echo base_url('p/'.$row->category_slug);  ?>">
								<img alt="<?php echo $row->category_name ?>" src="<?php if($row->logo_image) echo base_url('assets/uploads/backend/category_img/logo/'.$row->logo_image); else echo FRONTEND_THEME_URL.'img/product-1.png'; ?>">
							</a>
						</div>
						<div class="category-product-desc">
							<div class="category-product-name">
								<a href="<?php  echo base_url('p/'.$row->category_slug);  ?>"><?php echo ucwords(trim($row->category_name)); ?></a>
							</div>
						</div>
					</div>
				</li>
			<?php } ?>
		</ul>
	<?php } 
	 if(!empty($_GET)){ ?>		
		<div class="applied-filter">
			<ul class="applied-filter-list">
				<?php 

					if(!empty($_GET) &&  !empty($_GET['na'])){
						$na=explode(',',$_GET['na']);
						for($i=0;$i<sizeof($na);$i++)
						{
							if($na[$i]!=0){
								echo '<li><a href="javascript:void(0)"  class="filtered-brand">Last '.$na[$i].' days <span class="remove-icon remove-tag-filter" main="na" attr_value="'.$na[$i].'">x</span></a></li>';
							}
						}
					}

					if(!empty($_GET) &&  (isset($_GET['min']) || isset($_GET['max'])) && ($_GET['min']!=0 || $_GET['max']!=0)){

						if(!empty($_GET['min']))
							$price= $_GET['min'];
						else 
							$price='0'; 

						$price.=' - ';
						if(!empty($_GET['max']))												
							$price.= $_GET['max'];
						else 
							$price.='0'; 

						echo '<li><a href="javascript:void(0)"  class="filtered-brand">'.$price.' <span class="remove-icon remove-tag-filter" main="pricefilter" attr_value="'.$price.'">x</span></a></li>';	
					}

					if(!empty($_GET) &&  !empty($_GET['brand'])){
						$na=explode(',',$_GET['brand']);
						for($i=0;$i<sizeof($na);$i++)
						{
							echo '<li><a href="javascript:void(0)"  class="filtered-brand">'.$na[$i].' <span main="brand" attr_value="'.$na[$i].'" class="remove-icon remove-tag-filter">x</span></a></li>';
						}
					}

					if(!empty($_GET) &&  !empty($_GET['pr'])){
						echo '<li><a href="javascript:void(0)"  class="filtered-brand">'.$_GET['pr'].' Stars & Up <span class="remove-icon remove-tag-filter" main="review" attr_value="'.$_GET['pr'].'">x</span></a></li>';
					}

					if(!empty($_GET) &&  !empty($_GET['o'])){
						echo '<li><a href="javascript:void(0)"  class="filtered-brand">'.$_GET['o'].' Off or more <span main="offer" attr_value="'.$_GET['o'].'" class="remove-icon remove-tag-filter">x</span></a></li>';
					}

					$attr_value=array();
					if(!empty($_GET) && !empty($_GET['ab'])){
						$ab=$_GET['ab'];	
						$attribute=explode('__',$ab);
						for($i=0;$i<sizeof($attribute);$i++)
						{
							if(!empty($attribute[$i]))
							{
								$attr=explode('--A,',$attribute[$i]);
								if(sizeof($attr)==2){
									$attr_value[$attr[0]]=explode(',', $attr[1]);
								}
							}	
						}	
					}

					if(!empty($attr_value))
					{
						foreach($attr_value as $key=>$row){
							if(!empty($row)){
								for($i=0;$i<sizeof($row);$i++)
								{
									echo '<li><a href="javascript:void(0)"  class="filtered-brand">'.$row[$i].' <span class="remove-icon remove-tag-filter" main="'.$key.'" attr_value="'.$row[$i].'">x</span></a></li>';
								}
							}
						}
					}
				?>
				<?php if(!empty($_GET['o']) || !empty($_GET['pr']) || !empty($_GET['key']) || !empty($_GET['ab']) || !empty($_GET['brand']) || $_GET['min']!=0 || $_GET['max']!=0 || $_GET['na']!="0,0"){ ?>
					<li class="clear-all-list"><a href="<?php echo base_url('p/'.$category_slug); ?>" class="clear-all">Clear All</a></li>
				<?php } ?>
			</ul>
		</div>
		<?php } ?>
	<div class="clearfix"></div>
	<div class="a-row">
	<div class="well well-sm grid-well-section clearfix">
		<?php if(!empty($category_info) && !empty($category_info->category_name)){ ?>
			<div class="cat-title-block">
				<h2><?php echo ucwords($category_info->category_name); ?></h2>
			</div>
		<?php } ?>	
		<div class="right-fillter-grid">
			<span class="sort-by">Sort By</span>
			<select class="form-control" id="sortBy" onchange="searchFilter()">
				<option value="1" <?php if(!empty($search) && !empty($search['s']) && $search['s']==1) echo 'selected'; ?>>New &amp; Popular</option>
                <option value="2" <?php if(!empty($search) && !empty($search['s']) && $search['s']==2) echo 'selected'; ?>>Price: Low to High</option>
                <option value="3" <?php if(!empty($search) && !empty($search['s']) && $search['s']==3) echo 'selected'; ?>>Price: High to Low</option>
                <option value="4" <?php if(!empty($search) && !empty($search['s']) && $search['s']==4) echo 'selected'; ?>>Avg. Customer Review</option>
                <option value="5" <?php if(!empty($search) && !empty($search['s']) && $search['s']==5) echo 'selected'; ?>>Newest Arrivals</option>	
			</select>	
			<div class="grid-box-change">
				<a href="javascript:void(0)" id="list" class="list-box product-list <?php if($gird) echo 'active'; ?>">
					<i class="fa fa-th-large" aria-hidden="true"></i>
				</a>
				<a href="javascript:void(0)" id="grid" class="grid-box product-list <?php if(!$gird) echo 'active'; ?>">
					<i class="fa fa-th" aria-hidden="true"></i>
				</a>
			</div>
		</div>
	</div>
	</div>
	<div id="products" class="a-row list-group brands-products">
		<?php if(!empty($products)): foreach($products as $product): ?>
			<div class="item width-product-list grid-group-item <?php if($gird) echo 'list-group-item'; ?>">
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
								<div class="dollar-price">
									<span class="base-price">
										<span class="small-base-price-symbol">$</span><?php echo number_format($product->base_price,2); ?>
									</span>								
									 <?php if($product->base_price<$product->sell_price){
										echo '<span class="shell-price"><span class="small-base-price-symbol">$</span><del>'.number_format($product->sell_price,2).'</del></span>';
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
			</div>				
		<?php endforeach; else: ?>
			<div class="no-product-found">
				<div class="noresult-block">
                    <div class="noresult-img no-result-img-block">
                    	<img src="<?php echo base_url('assets/frontend/img/empty-icon/no-product-found.png'); ?>">
                    </div>
                    <div class="noresult-content">
                        <h4>No Product available</h4>
                    </div>
                  </div>
					<!-- <img src="<?php //echo FRONTEND_THEME_URL.'img/icons/no-roduct-found.png' ?>"/>
				<p>No Product available.</p> -->
			</div>
		<?php endif; ?>									
	</div>
	<!-- <div class="loading" style="display: none;">
		<div class="content">
			<img src="<?php //echo base_url().'assets/frontend/img/loading.gif'; ?>"/>
		</div>
	</div> -->
	<div class="loading main-loader product-cat-loader" style="display: none;">
        <div class="loader">
           <svg class="circular-loader" viewBox="25 25 50 50" >
             <circle class="loader-path" cx="50" cy="50" r="20" fill="none" stroke="#0a8ae2" stroke-width="2.5" />
           </svg>
        </div>
    </div>
	<?php echo $this->ajax_pagination->create_links();  ?>
	
	<div class="clearfix"></div>
</div>
						