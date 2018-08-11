<section class="admin-background admin-page">
	<div class="container-fluid">
		<div class="row dashboard">
		    <div class="clearfix dashboard-width-wrap">
			    <?php $this->load->view('frontend/account/left_menus'); ?>
			    <div class="col-md-10 col-sm-9 dashboard-right-warp">
			        <div class="col-lg-12 col-md-12">
			         	<div class="dashboaed-breadcrumb-wrapper">
			         		<nav aria-label="breadcrumb">
							  <ul class="breadcrumb">
							    <li class="breadcrumb-item">
							    	<a href="<?php echo base_url('account/dashboard'); ?>">Dashboard</a>
							    </li>
							    <li class="breadcrumb-item active" aria-current="page">Wish List</li>
							  </ul>
							</nav>
			         	</div>
			         	<div class="clearfix"></div>
		      		</div>
		      		<div class="clearfix"></div>
               		<?php msg_alert(); ?>
			    	<div class="dashboard-right section-white no-padding-top">
			    		<div class="col-lg-12 col-md-12">
				            <div class="heading">
				            	<img src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/wishlist-gray.svg" width="25"> 
				            	My Wish List
				         	</div>
				         	<div class="clearfix"></div>
			      		</div>

			      		<?php 
			      			if(!empty($wishListInfo)){ 
			      				foreach ($wishListInfo as $row) { 
			      					$product_details = json_decode($row->product_variation_info);
			      					$userName   = getData('users',array('user_id',$product_details->seller_id));
			      					if($product_details->sale_start_date!='' && $product_details->sale_start_date<=date('Y-m-d') && $product_details->sale_end_date!='' && $product_details->sale_end_date>=date('Y-m-d')){
                                        $product_details->base_price = $product_details->sale_price;
                                    }
			      					$Image = $product_details->image;
                                    $Image = explode(',', $Image);
			      		?>

					    <div class="col-lg-12 col-md-12">
					      	<div class="order-common-panel wishlist-panel-body">
			        			<div class="order-panel-body clearfix">
			        				<div class="left-sdie">
			        					<div class="order-item-view">
			        						<div class="a-row">
			        							<div class="order-item-box clearfix">
			        								<div class="order-item-left">
			        									<div class="order-item-left-inner">
			        										<a href="#">
			        											<img src="<?php echo base_url(); ?>/assets/uploads/seller/products/small_thumbnail/<?php echo $Image[0]; ?>">
			        										</a>
			        									</div>
			        								</div>
			        								<div class="order-item-right">
			        									<div class="a-row">
			        										<a class="product-order-heading" href="<?php echo base_url('pd/'.$product_details->slug.'/'.base64_encode($product_details->product_variation_id)); ?>"><?php echo $product_details->title; ?></a>
			        									</div>
			        									<?php if($product_details->total_rating > 0){ ?>
															<div class="rating">
						                                       <span class="event_star star_small" data-starnum="<?php echo number_format($product_details->sum_rating,0); ?>"><i></i></span>
						                                       <span class="rating-number"><a href="<?php echo base_url('rating/'.base64_encode($product_details->product_variation_id)); ?>"><?php echo $product_details->total_rating; ?> Review</a></span>
						                                    </div>
														<?php } ?>
			        									<div class="product-property">
				                                            <?php
				                                                 $tempMore = ""; 
				                                                 $product_variation_info = $product_details->product_variation_info;
				                                                 $product_basic_info = $product_details->product_basic_info;
				                                                 if(!empty($product_variation_info) && $product_variation_info!=''){
				                                                    $tempMore = "";
				                                                    $product_variation_info = json_decode($product_variation_info);
				                                                    if(!empty($product_variation_info)){
				                                                       foreach ($product_variation_info as $key => $value) {
				                                                          if(!empty($key) && !empty($value)){
				                                                       	  	$tempMore .= "<span> <label>".ucfirst($key).":</label> &nbsp;".ucfirst($value)."</span>";
				                                                       	  }
				                                                       }
				                                                    }
				                                                 }else if(!empty($product_basic_info)){
				                                                 	$tempMore = "";
				                                                    $product_basic_info = json_decode($product_basic_info);
				                                                    if(!empty($product_basic_info)){
				                                                       foreach ($product_basic_info as $key => $value){
				                                                       	  if(!empty($key) && !empty($value)){
				                                                       	  	$tempMore .= "<span> <label>".ucfirst($key).":</label> &nbsp;".ucfirst($value)."</span>";
				                                                       	  }
				                                                       }
				                                                    }
				                                                 }
				                                                 echo $tempMore;
				                                            ?>
				                                        </div>
			        									<div class="a-row">
			        										<div class="left-label">Sold by:</div>
			                                                <div class="right-label"><?php if(!empty($userName->user_name)) echo ucwords($userName->user_name); else echo "-"; ?>
			                                                </div>
			        									</div>
			        									<div class="clearfix"></div>
			        									<div class="a-row font-roboto">
			        										<span class="price-label">$<?php echo number_format($product_details->base_price, 2); ?></span>
			        										<del><span class="discount-price-label">$<?php echo number_format($product_details->sell_price, 2); ?></span></del>
			        									</div>
			        									<!-- <div class="a-row buy-it-again-btn">
			        										<a href="#" class="btn btn-default">Buy it again</a>
			        									</div> -->
			        								</div>
			        							</div>
			        						</div>
			        					</div>
			        				</div>
			        				<div class="right-sdie">
			        					<div class="right-btn-wrapper right-btn-wishlist-wrapper">
			        						<div class="a-row margin-bottom-20">
												<a href="<?php echo base_url('cart/add_to_cart_using_wishList/'.base64_encode($product_details->product_variation_id)); ?>" class="btn btn-default-new btn-block"><!-- <i class="icofont icofont-shopping-cart"></i> -->
												<img class="icofont active" src="<?php echo FRONTEND_THEME_URL ?>img/shopping-bag-solid-black.svg" width="21"> 
												<img class="icofont hover" src="<?php echo FRONTEND_THEME_URL ?>img/shopping-bag-solid-red.svg" width="21"> Add To Bag</a>
											</div>
				        					<div class="a-row margin-bottom-20">
												<a class="btn btn-default-new btn-block" href="javascript:void(0)" onclick="return confirmBox('Do you want to remove this product from wishlist ?','<?php echo base_url('order/remove_from_wishlist/'.base64_encode($product_details->product_variation_id)); ?>')"><i class="icofont icofont-heart-alt"></i> Remove from Wishlist</a>
											</div>
										</div>
			        				</div>
			        			</div>
					      	</div>
					    </div>

					    <?php } }else{ ?>
					    <div class="col-md-12">
	                        <br><br><br>
	                        <div class="noresult-block text-center">
	                          <div class="noresult-img">
	                            <img src="<?php echo base_url('assets/frontend/img/empty-icon/favorite-heart-button.svg'); ?>">
	                          </div>
	                          <div class="noresult-content">
	                            <h4>Empty Wishlist</h4>
	                            <p>You have no items in your wishlist. <a href="<?php echo base_url('p'); ?>">Start Adding!</a></p>
	                          </div>
	                        </div>
		                </div>
					    <?php } ?>
				    </div>
			    </div>
			</div>
	    </div>
	</div>
</section>

<script>
if($('.dashboard').length != 0){
	$(window).on("load resize", function () {
	winWidthnew = $('body').width();
	if(winWidthnew >=768){
		var dashboard_left = $('.dashboard-left').outerHeight();
		var dashboard_right  = $('.dashboard-right').outerHeight();
		if(dashboard_left <= dashboard_right){
			$('.dashboard-left').css('height' , dashboard_right);
		}
		else{
			$('.dashboard-left').css('height' , '400px;');
		}
	}
	}).resize();
}
</script>
