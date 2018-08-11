<?php
   $url=current_url();
   if(isset($product) && !empty($product) && !empty($product->meta_description))
      $description=str_replace("'","\'",$product->meta_description);
   else
      $description=str_replace("'","\'",$product->short_description);

   $btc=getCryptocurrencyRate('usd-btc');
   $eth=getCryptocurrencyRate('usd-eth');
?>
<div class="theme-background">
   <div class="container-fluid">
      <div class="product-detail-container ">
         <div class="row">
            <div class="left-fillter-grid bradcrum-left-fillter-grid">
               <?php
                  $bread=array();
                     if(!empty($product) && !empty($product->category_id)) {
                        $category=explode(',',$product->category_id);
                        $bread=get_category_bread_crumb_front($category[sizeof($category)-1]);
                        if(!empty($bread))
                        {
                           $bread=array_reverse($bread);
                           echo '<a href="'.base_url().'"> Home </a><span class="a-list-item a-color-tertiary"><img src="'.FRONTEND_THEME_URL.'img/icons/bradcrum-right-arrow.svg" width="30"></span>';
                           echo implode('<span class="a-list-item a-color-tertiary"><img src="'.FRONTEND_THEME_URL.'img/icons/bradcrum-right-arrow.svg" width="30"></span>',$bread);
                        
                        }
                     }
               ?>
            </div>
            <form action="<?php echo base_url('cart/add_to_cart') ?>" method="post" id="add_to_cart">
               <input type="hidden" name="pid" id="pid" value="<?php echo base64_encode($product->product_variation_id); ?>">
               <div class="detailpage-top-wrapper clearfix">
                  <div class="col-md-10 detail-left-sidebar">
                     <div class="theme-box">
                        <div class="col-md-5 detail-left-sidebar-img" id="product_image">
                           <div class="product-block">
                              <?php
                                 $image = ''; 
                                 $p_imgLink = '';
                                 $p_imgstatus = '';

                                 if($product->image){
                                 $images        = explode(',',$product->image);
                                 $pImgLinkArr   = explode(',',$product->link);
                                 $pImgstatusArr = explode(',',$product->pimg_status);
                                 $thumbImgCount = count($images);
                              ?>
                              <div class="product-nav">
                                 <div class="product-preview-nav <?php if($thumbImgCount > 5) echo "active"; ?>">
                                    <button type="button" class="top-arrow slick-arrow">
                                    <div><i class="fa fa-angle-up" aria-hidden="true"></i></div>
                                    </button>
                                    <ul class="nav-slider list-unstyled" id="gallery_01">
                                       <?php
                                          foreach($images as $key =>$value){ 
                                             if($pImgstatusArr[$key]==1) {
                                       ?>
                                       <li>

                                          <div class="side-img-block">
                                             <a href="javascript:void(0)" class="image_gallery center-block elevatezoom-gallery <?php if($key==0) echo 'active'; ?>" data-image="<?php echo base_url('assets/uploads/seller/products/thumbnail/'.$value); ?>" data-zoom-image="<?php echo base_url('assets/uploads/seller/products/'.$value); ?>">
                                                <img alt="<?=$product->title?>" src="<?php echo base_url('assets/uploads/seller/products/small_thumbnail/'.$value); ?>" />
                                             </a>
                                          </div>
                                       </li>
                                       <?php }} ?>
                                    </ul>
                                     <ul class="nav-slider list-unstyled" >
                                       <?php
                                          foreach($images as $key =>$value){ 
                                          if($pImgstatusArr[$key]==2) {
                                       ?>
                                       <li>
                                          
                                          <div class="side-img-block">
                                             <a href="javascript:void(0)"  class="video_image center-block elevatezoom-gallery <?php if($key==0) echo 'active'; ?>" data-image="<?php echo base_url('assets/uploads/seller/products/thumbnail/'.$value); ?>" data-zoom-image="<?php echo base_url('assets/uploads/seller/products/'.$value); ?>" vedio_url="<?=  $pImgLinkArr[$key] ?>">
                                                <img alt="<?=$product->title?>" src="<?php echo base_url('assets/uploads/seller/products/small_thumbnail/'.$value); ?>" />
                                             </a>
                                          </div>
                                       </li>
                                       <?php } } ?>
                                    </ul>
                                    <button type="button" class="bottom-arrow slick-arrow">
                                    <div><i class="fa fa-angle-down" aria-hidden="true"></i></div>
                                    </button>
                                 </div>
                                 <!-- Start Mobile Wishlist design -->
                                 <div class="mobile-wishlist">
                                    <div class="mobile-favourite wishListdiv-btn">
                                       <?php
                                          if(!empty($wishListProduct)){
                                       ?>
                                       <div class="mob-wishlist-icon" data-toggle="tooltip" data-placement="top" title="Remove from Wishlist">   
                                          <a href="javascript:void(0)">
                                             <span class="heart-icon">
                                                <img class="removeFromWishlist wishListRemove" pRWID="" src="<?php echo FRONTEND_THEME_URL ?>img/icons/heart-full.svg" width="22">
                                             </span> 
                                          </a>           
                                       </div>
                                       <?php }else{ ?>
                                       <div class="mob-wishlist-icon" data-toggle="tooltip" data-placement="top" title="Add to Wishlist">
                                          <a href="javascript:void(0)">
                                             <span class="mob-heart-icon">
                                                <img class="addToWishlist wishListAdd" pAWID="" src="<?php echo FRONTEND_THEME_URL ?>img/icons/heart-empty.svg" width="22">
                                             </span>     
                                          </a>                                      
                                       </div>
                                       <?php } ?>
                                    </div>
                                 </div>
                                 <!-- End Mobile Wishlist design -->
                              </div>
                              <div class="img-cover">
                                 <div class="loading main-loader product-cat-loader" style="display: none;">
                                    <div class="loader">
                                       <svg class="circular-loader" viewBox="25 25 50 50" >
                                          <circle class="loader-path" cx="50" cy="50" r="20" fill="none" stroke="#0a8ae2" stroke-width="2.5" />
                                       </svg>
                                    </div>
                                 </div>
                                 <div class="slide-for">
                                    <?php $image=base_url('assets/uploads/seller/products/'.$images[0]); ?>
                                    <img id="zoom_01" src='<?php echo base_url('assets/uploads/seller/products/thumbnail/'.$images[0]); ?>' data-zoom-image="<?php echo base_url('assets/uploads/seller/products/'.$images[0]); ?>" class="">
                                    
                                 </div>
                                 <div class="slide-for2">
                                    <img id="zoom_02" src='<?php echo base_url('assets/uploads/seller/products/thumbnail/'.$images[0]); ?>' vedio_url="" class="">
                                 </div>
                              </div>
                              <?php }else{ ?>
                              <div class="img-cover">
                                 <div class="slide-for">
                                    <img src="<?php echo FRONTEND_THEME_URL ?>img/mobile.jpg" class="center-block">
                                 </div>
                              </div>
                              <?php } ?>
                           </div>
                        </div>
                        <div class="col-md-7 detail-left-sidebar-info">
                           <div class="product-detail-block">
                              <div  id="product_price">
                                 <div class="product-detail-heading">
                                    <h2><?php
                                    $title=str_replace("'","\'",ucwords($product->title));
                                    echo ucwords($product->title) ?></h2>
                                    <?php if($product->total_rating>0){ ?>
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
                                    <?php }else{ ?>
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
                                    if($product->sale_start_date!='' && $product->sale_start_date<=date('Y-m-d') && $product->sale_end_date!='' && $product->sale_end_date>=date('Y-m-d')){
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
                                                <span class="price-text">
                                                   <span class="dollar-icon-bold">$</span>
                                                   <?php 
                                                      if(!empty($product->base_price))
                                                         echo number_format($product->base_price,2);
                                                      else
                                                         echo "0.00"; 
                                                   ?>
                                                </span>
                                                <span class="price-text mrp-price">
                                                   <span class="dollar-icon-normal">$</span>
                                                   <del>
                                                   <?php 
                                                      if(!empty($product->sell_price))
                                                         echo number_format($product->sell_price,2);
                                                      else
                                                         echo "0.00"; 
                                                   ?> 
                                                   </del>
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
                                             <!-- <div class="currency-converter">
                                                <div class="bitcoin">
                                                   <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/bitcoinlgo-35.svg">
                                                      <span><?php echo number_format($btc*$product->base_price,8); ?> BTC</span>
                                                </div>
                                                <div class="ethereum">
                                                   <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/ethereum35.svg">
                                                      <span><?php echo number_format($eth*$product->base_price,8); ?> ETH</span>
                                                </div>
                                             </div> -->
                                             <div class="crypto-currencies-table">
                                                <div class="crypto-tile">
                                                   <div class="crypto-price-icon">
                                                      <img src="<?php echo FRONTEND_THEME_URL ?>img/footer-icon/cazcoinlogo.png">
                                                      <span>0.00070550 CZC</span>
                                                   </div>
                                                </div>
                                                <div class="crypto-tile">
                                                   <div class="crypto-price-icon">
                                                      <img src="<?php echo FRONTEND_THEME_URL ?>img/footer-icon/Bitcoin-logo.png">
                                                      <span>0.00070550 BTC</span>
                                                   </div>
                                                </div>
                                                <div class="crypto-tile">
                                                   <div class="crypto-price-icon">
                                                      <img src="<?php echo FRONTEND_THEME_URL ?>img/footer-icon/ethereum-logo-circle.png">
                                                      <span>0.00070550 ETH</span>
                                                   </div>
                                                </div>
                                                <div class="crypto-tile">
                                                   <div class="crypto-price-icon">
                                                      <img src="<?php echo FRONTEND_THEME_URL ?>img/footer-icon/litecoin.png">
                                                      <span>0.00070550 LTC</span>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="putShipmentRateDiv addressShipment detial-delivery-address">
                                             <div class="your-address-delivery">
                                                <span class="guaranteed-title">Guaranteed</span>
                                                <span class="">Delivery to <?php echo $shippingCharge['yourAddress']; ?>.</span>
                                             </div>
                                              <div class="address-status">
                                                <?php
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
                                                         echo ' ( Not available for delivery at your location )';
                                                      }
                                                   }else{
                                                      echo ' ( Not available for delivery at your location )';
                                                   }
                                                ?>
                                              </div>
                                          </div>
                                       </div>
                                    </div>
                                    <?php } ?>
                                 </div>
                              </div>
                              <div class="product-detail">
                                 <div id="variations_section">
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
                                    <?php    }  }
                                    }
                                    ?>
                                 </div>
                                 <div class="error_atrribute" style="display:none;">Select above drop down first..</div>
                                 <div class="product-variation-block">
                                    <?php
                                    $colour='';
                                       $product_info=(array) json_decode($product->product_other_info);
                                    $product_variation=(array) json_decode($product->product_variation_info);
                                    if($product->product_variation_info!='' && !empty($product_variation) && !empty($product_variation['colour'])){
                                       $colour=$product_variation['colour'];
                                       echo '<div class="color-label "><span class="title-label ">Color:</span> <font class="color-title color_name">'.ucfirst($product_variation['colour']).'</font></div>';
                                    
                                    }else if($product->product_other_info!='' && !empty($product_info) && !empty($product_info['colour'])){
                                          $colour=$product_info['colour'];
                                          echo '<div class="color-label"><span class="title-label ">Color:</span> <font class="color-title">'.ucfirst($product_info['colour']).'</font></div>';
                                    } ?>
                                    <?php if(!empty($variations) && !empty($variations['colour'])){ ?>
                                    <div class="variation-entity-product">
                                       <ul class="color-list list-inline">
                                          <?php foreach($variations['colour'] as $key=>$value){ ?>
                                          <li class="select-colour select <?php if($variations['colour'][$key]==$colour) echo 'swatchSelect'; ?> ">
                                             <div class="color-img-thumb">
                                                <div class="inner-button">
                                                   <?php $images_small=get_product_variation_image($product->product_info_id, $variations['colour'][$key]); ?>
                                                   <a href="javascript:void(0)" class="product_colour" main="<?php echo $variations['colour'][$key]; ?>" pId="<?php if(!empty($images_small) && !empty($images_small->product_variation_id)) echo $images_small->product_variation_id; ?>">
                                                      <span class="overlay"></span>
                                                      <div class="color-img">
                                                         <?php if(!empty($images_small) && !empty($images_small->image)){
                                                            echo '<img src="'.base_url('assets/uploads/seller/products/small_thumbnail/'.$images_small->image).'">';
                                                         }else{ ?>
                                                         <img src="<?php echo FRONTEND_THEME_URL ?>img/Colour-mob-1.jpg">
                                                         <?php } ?>
                                                      </div>
                                                   </a>
                                                </div>
                                             </div>
                                          </li>
                                          <?php } ?>
                                       </ul>
                                    </div>
                                    <?php } ?>
                                 </div>
                                 <?php if($product->quantity!='' && $product->quantity > 0){ ?>
                                 
                                    <!-- <span class="stock-status in-stock">In Stock</span> -->
                                    <?php }else{ ?>
                                    <div class="product-variation-block">
                                       <span class="stock-status-available">Availability:</span>
                                       <span class="stock-status out-stock">Out of Stock</span>
                                    </div>
                                    <?php } ?>
                                 <div class="product-variation-block">
                                    <div class="stockist-info">
                                       <?php $seller_rating=explode(',', $product->seller_rating); ?>
                                       Product Sold by <a style="cursor: text;" class="link-text" href="javascript:void(0)"><?php echo ucfirst($product->user_name); ?></a>
                                       <?php if(!empty($product->seller_rating) && !empty($seller_rating)){
                                       echo '('.number_format(($seller_rating[1]/$seller_rating[0]),1).' out of 5 | '.$seller_rating[0].' ratings)';
                                       } ?>
                                       <!--<a href="#">return and replacement</a>-->
                                       <?php $offers=getOfferavailable($product->product_variation_id);
                                             if(sizeof($offers)>0){
                                       ?>
                                       <div><a href="#"><?php echo sizeof($offers); ?> offer also available </a></div>
                                       <?php } ?>
                                    </div>
                                 </div>
                                 <div class="short-description">
                                    <?php echo $product->short_description; ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="clearfix"></div>
                     </div>
                  </div>
                  <div class="col-md-2 detail-sidebar-bg detail-right-sidebar">
                     <!-- ==== Start Mobile Buy Now btn ==== -->
                     <div class="mobile-buynow-wrap">
                        <div class="mob-cart-btn">
                           <button class="btn btn-red btn-block">Buy for 
                              <span class="dollar-icon-bold">$</span><span class="number-icon-bold">
                                 <?php 
                                    if(!empty($product->base_price))
                                       echo number_format($product->base_price,2);
                                    else
                                       echo "0.00"; 
                                 ?>
                              </span>
                             <!--  <span class="mob-block mob-btn-currency">
                                 <span class="bitcoin">
                                    <span class="bitcoin-img">
                                       <img src="<?php echo FRONTEND_THEME_URL ?>/img/icons/bitcoin35.svg">
                                    </span>
                                    <span class="currency-no">
                                       <?php echo number_format($btc*$product->base_price,8); ?> BTC
                                    </span>
                                 </span>
                                 <span class="ethereum">
                                    <span class="ethereum-img">
                                       <img src="<?php echo FRONTEND_THEME_URL ?>/img/icons/ethereum35.svg">
                                    </span>
                                    <span class="currency-no">
                                       <?php echo number_format($eth*$product->base_price,8); ?> ETH
                                    </span>
                                 </span>
                              </span> -->
                              <span class="next-arrow">
                                 <img src="<?php echo FRONTEND_THEME_URL ?>/img/icons/right-arrow.svg" width="30">
                              </span>
                           </button>
                        </div>
                     </div>
                     <!-- ==== End Mobile Buy Now btn ==== -->
                     <div class="tell-a-friend">
                        <div class="share">
                           Share
                        </div>
                        <div class="social-links">
                           <span>
                              <a  href="https://plusone.google.com/share?hl=<?php echo $url; ?>" onclick="return popitup('google')" class="email google_share" title="email">
                                 <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/google-plus.svg">
                              </a>
                           </span>
                           <span>
                              <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>" onclick="return popitup('facebook')" class="facebook facebook_share" title="facebook">
                                 <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/facebook.svg">
                              </a>
                           </span>
                           <span>
                              <a href="https://twitter.com/intent/tweet?text=<?php echo $url; ?>" onclick="return popitup('twitter')" class="twitter twitter_share" title="twitter">
                                 <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/twitter.svg">
                              </a>
                           </span>
                           <span>
                              <a onclick="return popitup('linkedin')" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url; ?>" class="instagram linkedin_share" title="linkedin">
                                 <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/linkedin.svg">
                              </a>
                           </span>
                           <span>
                              <a href="https://pinterest.com/pin/create/button/?url=<?php echo $url; ?>" onclick="return popitup('pinterest')" class="pinterest pinterest_share" title="pinterest">
                                 <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/pinterest.svg">
                              </a>
                           </span>
                        </div>
                     </div>
                     <div class="theme-box buy-now-box" style="display:<?php if($product->quantity!='' && $product->quantity > 0) echo 'block'; else echo 'none'; ?>">
                        <?php
                           if(!empty(user_id())){
                        ?>
                        <div class="product-qty">
                           <span class="qty-label">
                              <a href="javascript:void(0)" data-toggle="modal" data-target="#myDeliveryLocation">
                                 <i class="icofont icofont-social-google-map"></i> Delivery to <?php if(!empty(user_name())) echo ucfirst(user_name()); else echo " your location"; ?>
                              </a>
                           </span>
                        </div>
                        <?php }
                        ?>

                        <div class="product-qty">
                           <span class="qty-label">Quantity : </span>
                           <span class="select-box">1</span>
                        </div>

                        <?php if($product->accepted_returnpolicy==1){ ?>
                        <div class="product-return-policy">
                           <span><img src="<?php echo base_url('assets/frontend/img/icons/return_icon.png'); ?>" alt="Return Policy"></span>
                           <span class=""><?php echo $product->return_policydays; ?> Days Return/Replacement Policy <a class="link-text" style="text-decoration: underline;" href="javascript:void(0)" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-content="<?php echo $product->returnpolicy_description; ?>">Know more</a></span>
                        </div>
                        <?php } ?>

                        <div class="detail-button-block">
                           <div class="buy-now-btn">
                              <button class="btn btn-cart btn-block">
                                 <span><img src="<?php echo FRONTEND_THEME_URL ?>img/icons/push-button.svg" width="22"></span> Buy Now
                              </button>
                              <div class="wishListdiv-btn">
                                 <?php
                                    if(empty($wishListProduct)){
                                 ?>
                                    <button type="button" pAWID="" class="btn btn-default-white btn-block btn-wishlist wishListAdd">
                                       <span><img src="<?php echo FRONTEND_THEME_URL ?>img/icons/heart-empty.svg" width="22"></span> Add to Wishlist
                                    </button>
                                 <?php }else{ ?>
                                    <button type="button" pRWID="" class="btn btn-default-white btn-block btn-wishlist wishListRemove">
                                       <span><img src="<?php echo FRONTEND_THEME_URL ?>img/icons/heart-full.svg" width="22"></span> Remove from Wishlist
                                    </button>
                                 <?php } ?>
                              </div>
                           </div>
                        </div>
                     </div>
                     <?php if(!empty($offers)){ ?>
                     <div class="theme-box other-seller-block">
                        <div class="panel panel-default">
                           <div class="panel-heading">
                              <h3 class="panel-title text-center">Other Sellers</h3>
                           </div>
                           <div class="panel-body">
                              <ul class="list-group no-margin">
                                 <?php foreach($offers as $offer){ ?>
                                 <li class="seller-tile">
                                    <div class="seller-info-block">
                                       <h4 class="price">
                                       <b>$ <?php echo number_format($offer->base_price,2); ?></b>
                                       <button class="btn btn-xs btn-warning cart-btn">Add to Cart</button>
                                       </h4>
                                       <!-- <div class="content">
                                          <div><b>Delivery : </b> Free</div>
                                          <div><b>Delivery : </b> Free</div>
                                       </div> -->
                                       <h5 class="seller-name">
                                       Sold by : <a href="#"><?php echo ucwords($offer->user_name); ?></a>
                                       </h5>
                                    </div>
                                 </li>
                                 <?php } ?>
                              </ul>
                           </div>
                        </div>
                     </div>
                     <?php }else if(!empty($product_right)){ ?>
                     <br>
                     <div class="theme-box seller-releted-product">
                        <ul class="product_list_widget">
                           <?php
                                 foreach ($product_right as $key => $p_right) {
                           ?>
                           <li class="firstItem">
                              <div class="media">
                                 <div class="media-left">
                                    <a class="avtar" href="<?php echo base_url('pd/'.$p_right->slug.'/'.base64_encode($p_right->product_variation_id)); ?>" title="<?php echo ucfirst($p_right->title); ?>">
                                       <img alt="<?php echo ucfirst($p_right->title); ?>" src="<?php if($p_right->image) echo base_url('assets/uploads/seller/products/small_thumbnail/'.$p_right->image); ?>" class="releted-post-image" alt="045">
                                    </a>
                                 </div>
                                 <div class="media-body">
                                    <h4 class="media-heading"><a href="<?php echo base_url('pd/'.$p_right->slug.'/'.base64_encode($p_right->product_variation_id)); ?>"><?php echo ucfirst($p_right->title); ?></a></h4>
                                    <div class="price-tag clearfix">
                                       <div class="dollar-price">
                                          <span class="base-price">
                                             <span class="small-base-price-symbol">$</span><?php echo number_format($p_right->base_price,2); ?>
                                          </span>
                                          <?php if($p_right->base_price<$p_right->sell_price){
                                          echo '<span class="shell-price"><span class="small-base-price-symbol">$</span><del>'.number_format($p_right->sell_price,2).'</del></span>';
                                          } ?>
                                       </div>
                                      <!--  <div class="cripto-price">
                                          <span class="bitcoin" data-toggle="tooltip" data-placement="top" title="<?php echo number_format($btc*$p_right->base_price,8); ?> BTC">
                                             <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/bitcoin35.svg">
                                          </span>
                                          <span class="ethereum" data-toggle="tooltip" data-placement="top" title="<?php echo number_format($eth*$p_right->base_price,8); ?> ETH">
                                             <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/ethereum35.svg">
                                          </span>
                                       </div> -->
                                    </div>
                                    
                                    <?php if($p_right->total_rating>0){ ?>
                                    <div class="rating">
                                       <span class="event_star star_small" data-starnum="<?php echo number_format($p_right->sum_rating,1); ?>"><i></i></span>
                                       <span class="rating-number"><a href="<?php echo base_url('rating/'.base64_encode($p_right->product_variation_id)); ?>"><?php echo $p_right->total_rating; ?> Review</a></span>
                                    </div>
                                    <?php } ?>
                                 </div>
                              </div>
                           </li>
                           <?php } ?>
                        </ul>
                     </div>
                     <?php }?>
                  </div>
               </div>
            </form>
         </div>
         <br>
         <div class="">
            <div class="theme-box">
               <div class="">
                  <section class="product-description col-md-12">
                     <div class="">
                        <ul role="tablist" class="nav nav-tabs">
                           <li class="nav-item active"><a data-toggle="tab" href="#description" role="tab" class="nav-link active" aria-selected="true">Product Description</a></li>
                           <li class="nav-item"><a data-toggle="tab" href="#sellerdescription" role="tab" class="nav-link" aria-selected="true">Seller Description</a></li>
                           <li class="nav-item"><a data-toggle="tab" href="#additional-information" role="tab" class="nav-link" aria-selected="false">Rating & Reviews</a></li>
                           <li class="nav-item"><a data-toggle="tab" href="#customer-questions" role="tab" class="nav-link" aria-selected="false">Customer Questions & Answers</a></li>
                        </ul>
                        <div class="tab-content clearfix">
                           <div id="description" role="tabpanel" class="tab-pane active">
                              <div class="ads-details-info">
                                 <?php if($product->description) echo $product->description; else echo "Product Description not available."; ?>
                              </div>
                           </div>
                           <div id="sellerdescription" role="tabpanel" class="tab-pane">
                              <div class="ads-details-info">
                                 <?php if($product->seller_description) echo $product->seller_description; else echo "Seller Description not available."; ?>
                              </div>
                           </div>
                           <div id="additional-information" role="tabpanel" class="tab-pane">
                              <div class="row">
                                 <div class="col-sm-3 rating-left">
                                    <div class="rating-block">
                                       <h4 class="rating-head-title">Average user rating</h4>
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
                                 <div class="col-sm-3 rating-right">
                                    <h4 class="rating-head-title">Rating breakdown</h4>
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
                                 <div class="rating-wrapper clearfix">
                                    <div class="col-sm-12">
                                       <div class="review-block clearfix">
                                          <?php if(!empty($ratings)) { foreach ($ratings as $key => $value) { ?>
                                          <div class="customer-review clearfix">
                                             <div class="left-side-review">
                                                <div class="review-avtar">
                                                   <img src="<?php echo FRONTEND_THEME_URL ?>/img/icons/review-default.png" class="img-rounded">
                                                </div>
                                                <div class="review-customer-info">
                                                   <div class="review-block-name">
                                                      <?php echo ucwords($value->user_name); ?>
                                                   </div>
                                                   <div class="review-block-date">
                                                      <?php
                                                         $now = time(); // or your date as well
                                                         $your_date = strtotime($value->created_at);
                                                         $datediff = $now - $your_date;
                                                      ?>
                                                      <span class="comment-date"><?php echo date("M ,d Y", strtotime($value->created_at)); ?></span>
                                                      <span class="day-ago"><?php echo floor($datediff / (60 * 60 * 24)); ?> day ago</span>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="right-side-review">
                                                <div class="rating-star-block">
                                                   <span class="event_star star_big" data-starnum="<?php echo $value->rating; ?>"><i></i></span>
                                                </div>
                                                <div class="review-block-description"><?php echo $value->description; ?></div>
                                             </div>
                                          </div>
                                          <hr>
                                          <?php } } ?>
                                       </div>
                                    </div>
                                    <div class="col-sm-12">
                                       <div class="pagination-type-block"></div>
                                    </div>
                                 </div>
                                 <div class="clearfix"></div>
                              </div>
                              <?php
                              if(count($ratings)>10)
                              {
                              ?>
                              <a href="<?php echo base_url('rating/'.base64_encode($product->product_variation_id)); ?>">See All</a>
                              <?php } }?>
                           </div>
                           <div id="customer-questions" role="tabpanel" class="tab-pane">
                              <div class="customer-questions-answers">
                              
                                 <?php if(!empty($product_faq)){ ?>
                                 <!-- <div class="search-box">
                                    <div class="input-group">
                                       <input type="text" class="form-control" placeholder="Have a question? Search for answers" aria-describedby="basic-addon1">
                                       <span class="input-group-addon" id="basic-addon1">
                                          <i class="icofont icofont-search"></i>
                                       </span>
                                    </div>
                                 </div> -->
                                 <?php } ?>

                                 <div class="ask-teaser-questions-wrapper">
                                    <div class="ask-question-titl">
                                    <?php 
                                    if(!empty($product_faq)){ 
                                       $i=0; 
                                       foreach ($product_faq as $row) { 
                                          $i++;
                                    ?>
                                       <div class="a-row ans-question-inner">
                                          <div class="ans-col-left">
                                             <ul class="vote">
                                                <!-- <li>
                                                   <form class="up">
                                                      <input type="submit" value="Vote up">
                                                   </form>
                                                </li>
                                                <li class="label">
                                                   <span class="count">1</span>
                                                   <span class="one"><br>
                                                   vote</span>
                                                    <span class="more"><br>
                                                   votes</span>
                                                </li>
                                                <li>
                                                   <form class="down">
                                                      <input type="submit" value="Vote down">
                                                   </form>
                                                </li> -->
                                                <li>
                                                   <?php echo $i."."; ?>
                                                </li>
                                             </ul>
                                          </div>

                                          <div class="ans-col-right">
                                             <div class="a-row question-block-section">
                                                <div class="a-row inner-comman-tile">
                                                   <div class="col-left-section">
                                                      <span class="color-title">Question:</span>
                                                   </div>
                                                   <div class="question-right">
                                                      <span class="color-title"><?php echo $row->question; ?></span>
                                                   </div>
                                                </div>
                                                <div class="a-row inner-comman-tile">
                                                   <div class="col-left-section">
                                                      <span class="color-title">Answer:</span>
                                                   </div>
                                                   <div class="answer-right">
                                                      <span>
                                                         <?php echo $row->answer; ?>
                                                      </span>
                                                      <div class="comment-by">
                                                         By <?php $user_name = getRow('users', array('user_id'=>$row->seller_id),array('user_name'))->user_name; echo $user_name; ?> on <?php echo date('d M Y',strtotime($row->created_at)); ?>
                                                      </div>
                                                      <!-- <div class="show-more-answer">
                                                         <a href="#" class="link-text"><i class="icofont icofont-double-left"></i> show-more-answer (17)</a>
                                                      </div> -->
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <?php } }else{ ?>
                                          <div>Product FAQs not available.</div>
                                       <?php } ?>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </section>
               </div>
               <div class="clearfix"></div>
            </div>
         </div>
         <br>
         <div class="technical-details-wrapper">
            <div class="theme-box clearfix">
               <div class="heading">
                  <h2><?php echo ucwords($product->title) ?></h2>
               </div>
               <div class="technical-inside-wrap">

                  <?php 
                  if(!empty($product->product_other_info)|| $product->product_basic_info!='null'){

                   ?>
                  <div class="col-sm-6">
                     <div class="inside-heading">
                        <h2>Other Details</h2>
                     </div>
                     <div class="inside-content">
                        <table cellspacing="0" cellpadding="0" border="0">
                           <tbody>
                              <?php
                                 if($product->product_basic_info!='' && !empty($product->product_basic_info) && $product->product_basic_info!='null'){
                                    foreach(json_decode($product->product_basic_info) as $key=>$row){
                                       if(!empty($row)){
                                          $attrCode = ucwords(str_replace('-9','',$key));
                                          if(!empty($attrCode)){
                                             $attributesData = getData('attributes',array('attribute_code',$attrCode));
                                             if(!empty($attributesData)){
                              ?>
                                                <tr>
                                                   <td class="label-tittle">
                                                   <?php
                                                      echo ucwords($attributesData->name);
                                                   ?>
                                                   </td>
                                                   <td class="value">
                                                      <?php if(is_array($row)) echo implode(', ', $row); else echo $row; ?>
                                                   </td>
                                                </tr>
                              <?php          } 
                                          } 
                                       } 
                                    } 
                                 }
                              ?>

                              <?php
                                 if($product->product_other_info!=''){
                                    foreach(json_decode($product->product_other_info) as $key=>$row){
                                       if(!empty($key) && !empty($row)){
                                       $attrCode = ucwords(str_replace('-9','',$key));
                                          if(!empty($attrCode)){
                                          $attributesData = getData('attributes',array('attribute_code',$attrCode));
                                             if(!empty($attributesData)){
                              ?>
                                                <tr>
                                                   <td class="label-tittle">
                                                      <?php
                                                      echo ucwords($attributesData->name);
                                                      ?>
                                                   </td>
                                                   <td class="value">
                                                      <?php if(is_array($row)) echo implode(', ', $row); else echo $row; ?> 
                                                   </td>
                                                </tr>
                              <?php          } 
                                          } 
                                       } 
                                    } 
                                 } 
                              ?>
                              <tr>
                                 <td class="">&nbsp;</td>
                                 <td class="">&nbsp;</td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <?php } ?>

                  <div class="col-sm-6">
                     <div class="inside-heading">
                        <h2>Additional Information</h2>
                     </div>
                     <div class="inside-content">
                        <table cellspacing="0" cellpadding="0" border="0">
                           <tbody>
                              <tr id="product_number">
                                 <td class="label-tittle"><?php echo strtoupper($product->product_ID_type); ?></td>
                                 <td class="value"><?php echo $product->product_ID; ?></td>
                              </tr>
                              <?php if($product->total_rating>0){ ?>
                              <tr class="average_customer_reviews">
                                 <td class="label-tittle">Customer Reviews</td>
                                 <td class="value">
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
                                 </td>
                              </tr>
                              <?php } ?>
                              <tr id="SalesRank">
                                 <td class="label-tittle">Product Category</td>
                                 <td class="value">
                                    <ul class="sellers-rank">
                                       <li class="">
                                          <span class="cat-link"><?php
                                             if(!empty($product) && !empty($product->category_id)) {
                                                if(!empty($bread))
                                                {
                                                   echo implode('<span class="a-list-item a-color-tertiary"> › </span>',$bread);
                                                }
                                             }
                                          ?></span>
                                       </li>
                                    </ul>
                                 </td>
                              </tr>
                              <tr class="date-first-available">
                                 <td class="label-tittle">Date First Available</td>
                                 <td class="value"><?php echo date("d M Y", strtotime($product->created_at))?></td>
                              </tr>
                              <tr>
                                 <td class="">&nbsp;</td>
                                 <td class="">&nbsp;</td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                     <?php if($product->warranty_description){ ?>
                     <div class="inside-heading margin-botttom-15">
                        <h2>Warranty & Support</h2>
                        <p><span id="warranty_description"> </span></p>
                     </div>
                     <?php } ?>
                     <div class="inside-heading margin-botttom-15">
                        <h2>Feedback</h2>
                        <!-- <p class="no-margin">Would you like to <a class="link-text" href="#">tell us about a lower price?</a></p> -->
                        <p class="no-margin">If you are a seller for this product, would you like to <a class="link-text" href="<?php echo base_url('seller/support/messages'); ?>">suggest updates through seller support?</a></p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php if(!empty($related_or_discount_products)){ ?>
   <div class="container-fluid home-section">
      <h2 class="basic-heading text-center"><?php echo $related_or_discount_products_heading; ?></h2>
      <div class="product-slider">
         <?php foreach($related_or_discount_products as $product_fea){ ?>
         <div class="product-tile">
            <div class="image-block <?php if(empty($product_fea->second_image)) echo 'signle-image'; ?>">
               <a class="image-without-hover" href="<?php echo base_url('pd/'.$product_fea->slug.'/'.base64_encode($product_fea->product_variation_id)); ?>">
                  <img src="<?php if($product_fea->image) echo base_url('assets/uploads/seller/products/small_thumbnail/'.$product_fea->image); ?>">
               </a>
               <?php if(!empty($product_fea->second_image)){ ?>
               <a class="image-on-hover" href="<?php echo base_url('pd/'.$product_fea->slug.'/'.base64_encode($product_fea->product_variation_id)); ?>">
                  <img src="<?php if($product_fea->second_image) echo base_url('assets/uploads/seller/products/small_thumbnail/'.$product_fea->second_image); ?>">
               </a>
               <?php } ?>
               <?php $offer=round((($product_fea->sell_price-$product_fea->base_price)/$product_fea->sell_price)*100);
               if($offer>0){
               ?>
               <span class="offer-sticker-tag offer-tag-overflow"><?php echo $offer; ?>%</span>
               <?php } ?>
               <?php if($product_fea->brand_name){ ?>
               <div class="product-name">
                  <a href="<?php echo base_url('pd/'.$product_fea->slug.'/'.base64_encode($product_fea->product_variation_id)); ?>"><?php echo ucfirst($product_fea->brand_name); ?></a>
               </div>
               <?php } ?>
            </div>
            <div class="product-desc">
               <!-- <span class="rating">
                  <div class="rating-btn">3.3 ★</div> <span>(25)</span>
               </span> -->
               <div class="short-desc">
                  <a class="" href="<?php echo base_url('pd/'.$product_fea->slug.'/'.base64_encode($product_fea->product_variation_id)); ?>"><?php echo ucfirst($product_fea->title); ?> </a>
               </div>
               <div class="pricing-block clearfix">
                  <div class="price-tag clearfix">
                     <div class="dollar-price">
                        <span class="base-price">
                           <span class="small-base-price-symbol">$</span><?php echo number_format($product_fea->base_price,2); ?>
                        </span>
                        <?php if($product_fea->base_price<$product_fea->sell_price){
                        echo '<span class="shell-price"><span class="small-base-price-symbol">$</span><del>'.number_format($product_fea->sell_price,2).'</del></span>';
                        } ?>
                     </div>
                     <div class="cripto-price">
                       <!--  <span class="bitcoin" data-toggle="tooltip" data-placement="top" title="<?php echo number_format($btc*$product->base_price,8); ?> BTC">
                           <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/bitcoin35.svg">
                        </span>
                        <span class="ethereum" data-toggle="tooltip" data-placement="top" title="<?php echo number_format($eth*$product->base_price,8); ?> ETH">
                           <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/ethereum35.svg">
                        </span> -->
                        <?php 
                          $wishListProduct = getRow('wish_list',array('user_id'=>user_id(), 'product_variation_id'=>$product_fea->product_variation_id), array('wish_list_id'));
                          if(!empty($wishListProduct)){
                        ?>
                        <div class="wishlist-icon" data-toggle="tooltip" data-placement="top" title="Remove from Wishlist"> 
                          <a href="javascript:void(0)">
                            <span class="heart-icon">
                              <img class="removeFromWishlist" pID="<?php echo base64_encode($product_fea->product_variation_id); ?>" src="<?php echo FRONTEND_THEME_URL ?>img/icons/heart-full.svg" width="22">
                            </span> 
                          </a>        
                        </div>
                        <?php }else{ ?>
                        <div class="wishlist-icon" data-toggle="tooltip" data-placement="top" title="Add to Wishlist">
                          <a href="javascript:void(0)">
                            <span class="heart-icon">
                              <img class="addToWishlist" pID="<?php echo base64_encode($product_fea->product_variation_id); ?>" src="<?php echo FRONTEND_THEME_URL ?>img/icons/heart-empty.svg" width="22">
                            </span>   
                          </a>                          
                        </div>
                        <?php } ?>
                     </div>
                  </div>
                  <?php if($product_fea->total_rating>0){ ?>
                  <div class="rating">
                     <span class="event_star star_small" data-starnum="<?php echo number_format($product_fea->sum_rating,1); ?>"><i></i></span>
                     <span class="rating-number">(<?php echo $product_fea->total_rating; ?>)</span>
                     <div class="rating-tooltip-tile-hover">
                        <div class="rating-tooltip-inner clearfix">
                           <div class="rating-tooltip-content clearfix">
                              <div class="col-sm-4 no-padding left-side">
                                 <div class="rating-view text-center">
                                    <div class="number"><?php echo number_format($product_fea->sum_rating,1); ?></div>
                                    <div class="start">★</div>
                                 </div>
                                 <div class="number-of-ratings">
                                    <span><?php echo $product_fea->total_rating; ?> Ratings </span>
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
                                             <div class="review-number"><?php echo ($product_fea->rating5) ? $product_fea->rating5 :0; ?></div>
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
                                             <div class="review-number"><?php echo ($product_fea->rating4) ? $product_fea->rating4 :0; ?></div>
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
                                             <div class="review-number"><?php echo ($product_fea->rating3) ? $product_fea->rating3 :0; ?></div>
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
                                             <div class="review-number"><?php echo ($product_fea->rating2) ? $product_fea->rating2 :0; ?></div>
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
                                             <div class="review-number"><?php echo ($product_fea->rating1) ? $product_fea->rating1 :0; ?></div>
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
</div>
<?php if(!empty(user_id())){ ?>
<!-- Modal -->
<div id="myDeliveryLocation" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content comman-modal">
         <div class="modal-header comman-header-modal">
            <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">
                  <img src="<?php echo FRONTEND_THEME_URL ?>/img/Icon_Basic_Close.svg" width="18">
               </span>
            </button>
            <h4 class="modal-title text-center">
               <i class="icofont icofont-social-google-map"></i>Choose your delivery location
            </h4>
         </div>
         <div class="modal-body comman-body-modal clearfix">
            <?php
            $shippingAddress = getDataResult('shipping_addresess', array('user_id'=>user_id(), 'status'=>1));
               if(!empty($shippingAddress)){
            ?>
            <p class="font-16">Select a delivery location to see product availability and delivery options</p>
            <?php
            $i=0;
            foreach ($shippingAddress as $row) {
               $i++;
               $city = getData('cities',array('id',$row->city))->name;
            ?>
            <div class="theme-box margin-bottom-10 clearfix">
               <div class="select-location-modalbox">
                  <div class="radio-input">
                     <input type="radio" name="chooseAddressForShip" id="chooseAddressForShip<?php echo $row->shipping_address_id; ?>" class="chooseAddressForShip" value="<?php echo $row->shipping_address_id; ?>" <?php if($i==1) echo "checked"; ?>>
                     <label for="chooseAddressForShip<?php echo $row->shipping_address_id; ?>">
                        <div class="address-devliver">
                           <div><span><?php echo ucwords($row->first_name.' '.$row->last_name); ?></span></div>
                           <div><?php echo $row->address; ?> - <?php echo $city; ?></div>
                        </div>
                     </label>
                  </div>
               </div>
            </div>
            <?php } }else{
            ?>
            <div align="center">No Shipping Address Found.</div>
            <?php }
            ?>
            <div class="a-row text-center padding-top-bottom-15">
               <?php
               $shippingAddress = getDataResult('shipping_addresess', array('user_id'=>user_id(), 'status'=>1));
                  if(!empty($shippingAddress)){
               ?>
               <button type="button" class="btn btn-red submitAddress">Continue</button>
               <?php } ?>
            </div>
         </div>
      </div>
   </div>
</div>
<?php } ?>
<div class="modal fade" id="video_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
        <iframe src="demo_iframe.htm" height="300" width="535" id="vedio_iframe"></iframe>
      </div>
      <div class="modal-footer">
      
      </div>
    </div>
  </div>
</div>

<div class="remove_slider_javascript">

<script src='<?php echo base_url('assets/frontend/js/jquery.elevatezoom.js') ?>'></script>
<script type="text/javascript">

    $(document).ready(function(){
       $('[data-toggle="popover"]').popover(); 
         $('.video_image').click(function(){
             $('#zoom_02').attr('src',$(this).attr('data-image'));
             $('#zoom_02').attr('vedio_url',$(this).attr('vedio_url'));
             $('.slide-for').hide();
             $('.slide-for2').show();
             $('.zoomContainer').hide();
             
         });
         $("#zoom_02").click(function(){
              console.log($(this).attr('vedio_url'));
              var src= $(this).attr('vedio_url');
             src=src.split("/");
               $('#vedio_iframe').attr('src','https://www.youtube.com/embed/'+$(src).get(-1));
               $('#video_model').modal('show');

         });
         
         $('.image_gallery').click(function(){
               $('.slide-for2').hide();
                $('.zoomContainer').show();
             $('.slide-for').show();
         });

    });

        $('.close').click(function(e){

        $("#vedio_iframe").attr("src",'');
        }
        );

    
    var screensize = document.documentElement.clientWidth;
    if (screensize <= 1100) {


        $("#zoom_01").elevateZoom({
            zoomType: "inner",
            cursor: "crosshair",
            zoomWindowFadeIn: 500,
            zoomWindowFadeOut: 750,
            gallery: $.trim('gallery_01'),
            cursor: $.trim('pointer'),
            galleryActiveClass: $.trim('active'),
            imageCrossfade: true,
            //loadingIcon: 'http://www.girlsgotit.org/images/ajax-loader.gif'
        });

    } else {
        $("#zoom_01").elevateZoom({
            cursor: "crosshair",
            zoomWindowFadeIn: 500,
            zoomWindowFadeOut: 750,
            gallery: $.trim('gallery_01'),
            cursor: $.trim('pointer'),
            galleryActiveClass: $.trim('active'),
            imageCrossfade: true,
            ///loadingIcon: 'http://www.girlsgotit.org/images/ajax-loader.gif'
        });
    }
    $('.nav-slider').slick({
       slidesToShow: 5,
        slidesToScroll: 1,
        vertical: true,
        dots: false,
        centerMode: true,
        focusOnSelect: true,
        prevArrow: $('.top-arrow'),
        nextArrow: $('.bottom-arrow'),
        responsive: [
         {
           breakpoint: 481,
           settings: {
              vertical: false,
              slidesToShow: 1,
              dots: true,
           }
         }
      ]
   });

</script>
</div>
<script type="text/javascript">
    var url = '<?php echo $url; ?>';
    var title = '<?php echo $title; ?>';
    var image = '<?php echo $image; ?>';
    var description = '<?php echo trim(preg_replace('/\s+/', ' ',$description)); ?>';

    function popitup(type) {
        var url = '';
        if (type == 'facebook') {
            url = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(url) + "&description=" + encodeURIComponent(description) + "&title=" + encodeURIComponent(title) + "&picture=" + encodeURIComponent(image) + "&data-href=" + encodeURIComponent(url);
        } else if (type == 'twitter') {
            url = "https://twitter.com/intent/tweet?text=" + encodeURIComponent(description) + "&url=" + encodeURIComponent(url) + "&hashtags=" + encodeURIComponent(title) + "," + encodeURIComponent(image);
        } else if (type == 'google') {
            url = "https://plusone.google.com/share?hl=" + url + "&text=" + encodeURIComponent(title) + "&url=" + encodeURIComponent(url) + "&description=" + encodeURIComponent(description) + "&image=" + encodeURIComponent(image);
        } else if (type == 'pinterest') {
            url = 'https://pinterest.com/pin/create/button/?url=' + encodeURIComponent(url) + '&media=' + encodeURIComponent(image) + '&title=' + encodeURIComponent(title) + '&description=' + encodeURIComponent(description);
        } else if (type == 'linkedin') {
            url = 'http://www.linkedin.com/shareArticle?mini=true&url=' + encodeURIComponent(image) + '&title=' + encodeURIComponent(title) +
                '&summary=' + encodeURIComponent(description) + '&submitted-url=' + encodeURIComponent(url);
        }
        var left = (screen.width / 2) - (550 / 2);
        var top = (screen.height / 2) - (450 / 2);
        newwindow = window.open(url, 'Share', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no,height=450,width=550,top=' + top + ', left=' + left);
        if (window.focus) {
            newwindow.focus()
        }
        return false;
    }
    var available_attr = '<?php echo implode(',', array_keys($variations)); ?>';
    var product_info_id = "<?php echo $product->product_info_id; ?>";
    var colour = "<?php echo $colour; ?>";

    $('.product_colour').click(function(event) {
        //var attr=$(this).attr('main');
        var shipmentAddress = $("input[name='chooseAddressForShip']:checked").val();
        if (shipmentAddress == undefined || shipmentAddress == '') {
            shipmentAddress = "";
        }

        $('.product_attribute').removeClass('error_atrribute_border');
        $('.select-colour').removeClass('swatchSelect');
        $(this).parents("li:first").addClass('swatchSelect');
        colour = $(this).attr('main');
        $('.color_name').text(colour);
        var pid = $(this).attr('pid');
    
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>products/ajaxProductVariation/',
            data: 'product_info_id=' + product_info_id + '&colour=' + colour + '&available_attr=' + available_attr + '&product_variation_id=' + pid + '&shipmentAddress=' + shipmentAddress,
            beforeSend: function() {
                $('.loading').show();
            },
            success: function(result) {
                var data = jQuery.parseJSON(result);
                if (data['status']) {
                    data = data['data'];
                    $(".zoomContainer").remove();
                    $('.remove_slider_javascript').remove();

                    if($(window).width() <= 1050){
                        $('.wishListdiv-btn').html(data['wishList_divm']);
                    }else{
                        $('.wishListdiv-btn').html(data['wishList_div']);
                    }

                    $('#product_image').html(data['product_image']);
                    $('#product_price').html(data['product_price']);
                    $('#seller_description').html(data['seller_description']);
                    $('#warranty_description').html(data['warranty_description']);
                    $('#variations_section').html(data['variations_section']);
                    image = data['image'];
                    url = data['url'];

                    $("meta[property='og\\:url']").attr("content", url);
                    $("meta[property='og\\:image']").attr("content", image);
                    $('#product_number').html(data['product_number']);
                    $('.stock-status').removeClass('in-stock');
                    $('.stock-status').removeClass('out-stock');
                    if (data['available_quantity'] > 0) {
                        $('.stock-status').addClass('in-stock');
                        $('.stock-status').text('In Stock');
                        $('.buy-now-box').show();
                    } else {
                        $('.stock-status').addClass('out-stock');
                        $('.stock-status').text('Out Of Stock');
                        $('.buy-now-box').hide();
                    }
                    $('#pid').val(data['product_ID']);
                    $('.loading').fadeOut("slow");
                    window.history.pushState("title", "Product List", url);
                } else {
                    errorMsg('Something went wrong. please try again');
                    return false;
                }
            }
        });
    });


    $('.buyItem').click(function() {
        $('.product_attribute').removeClass('error_atrribute_border');
        if (available_attr == '') {
            return true;
        } else {
            var count = 1;
            $(".product_attribute").each(function(i, el) {
                if ($(el).val() == '') {
                    $(el).addClass('error_atrribute_border');
                    count--;
                    windowSizeAutoScroll();
                    return false;
                }
            });
            if (count){
                return true;
            }else{
                windowSizeAutoScroll();
                return false;
            }
        }
        windowSizeAutoScroll();
        return false;
    });


    $(".submitAddress").on('click', function() {

        var PID = $("#pid").val();
        var shipmentAddress = $("input[name='chooseAddressForShip']:checked").val();
        if (shipmentAddress == undefined || shipmentAddress == '') {
            shipmentAddress = "";
        }

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>products/getShippingRateData/',
            data: {
               product_variation_id : PID,
               shipmentAddress: shipmentAddress,
               shipping_method: ''
            },
            beforeSend: function() {
                $('.loading').show();
            },
            success: function(result) {
                var data = jQuery.parseJSON(result);
                $('.loading').hide();
                if (data.status == 'success') {
                    $('.putShipmentRateDiv').html(data.data);
                    $('#myDeliveryLocation').modal('hide');
                } else {
                    errorMsg('Something went wrong! Please try again');
                    $('.putShipmentRateDiv').html("");
                }
            }
        });
    });

    $('body').on('click','.wishListAdd',function(){
        user_id = "<?php echo user_id(); ?>";
        if(!user_id) window.location.replace("<?php echo base_url('page/login'); ?>");

        var curr = $(this);
        $('.product_attribute').removeClass('error_atrribute_border');
        if (available_attr == '') {
            var PID = $("#pid").val();
            if (PID!= ''){
                $.ajax({
                     type: 'POST',
                     url: '<?php echo base_url(); ?>order/add_to_wishlist_using_ajax',
                     data: {
                        product_variation_id : PID
                     },
                     success: function(result) {
                         var data = jQuery.parseJSON(result);
                         if (data.status=='success'){
                             curr.html("<span><img src='"+ SITE_URL +"assets/frontend/img/icons/heart-full.svg' width='22'></span> Remove from Wishlist");
                             curr.removeClass('wishListAdd').addClass('wishListRemove');
                             successMsg(data.msg);
                         } else {
                             errorMsg(data.msg);
                             return false;
                         }
                     }
                });
            }else{
                errorMsg('Something went wrong! Please try again');
                return false;
            }
        }else{
            var count = 1;
            $(".product_attribute").each(function(i, el) {
                if ($(el).val() == '') {
                    $(el).addClass('error_atrribute_border');
                    count--;
                    windowSizeAutoScroll();
                    return false;
                }
            });
            
            if (count) {
                var PID = $("#pid").val();
                if (PID != '') {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>order/add_to_wishlist_using_ajax',
                        data: {
                           product_variation_id : PID
                        },
                        success: function(result) {
                            var data = jQuery.parseJSON(result);
                            if (data.status=='success'){
                                curr.html("<span><img src='"+ SITE_URL +"assets/frontend/img/icons/heart-full.svg' width='22'></span> Remove from Wishlist");
                                curr.removeClass('wishListAdd').addClass('wishListRemove');
                                successMsg(data.msg);
                            } else {
                                errorMsg(data.msg);
                                return false;
                            }
                        }
                   });
                }else{
                    errorMsg('Something went wrong! Please try again');
                    return false;
                }
            }else{
               windowSizeAutoScroll();
                return false;
            }
        }
        windowSizeAutoScroll();
        return false;

    });

    $('body').on('click','.wishListRemove',function(){
        user_id = "<?php echo user_id(); ?>";
        if(!user_id) window.location.replace("<?php echo base_url('page/login'); ?>");

        var curr = $(this);
        $('.product_attribute').removeClass('error_atrribute_border');
        if (available_attr == '') {
            var PID = $("#pid").val();
            if (PID != '') {
                $.ajax({
                     type: 'POST',
                     url: '<?php echo base_url(); ?>order/remove_from_wishlist_using_ajax',
                     data: {
                        product_variation_id : PID
                     },
                     success: function(result) {
                         var data = jQuery.parseJSON(result);
                         if (data.status=='success') {
                             curr.html("<span><img src='"+ SITE_URL +"assets/frontend/img/icons/heart-empty.svg' width='22'></span> Add to Wishlist");
                             curr.removeClass('wishListRemove').addClass('wishListAdd');
                             successMsg(data.msg);
                         } else {
                             errorMsg(data.msg);
                             return false;
                         }
                     }
                });
            } else {
                errorMsg('Something went wrong! Please try again');
                return false;
            }
        } else {
            var count = 1;
            $(".product_attribute").each(function(i, el) {
                if ($(el).val() == '') {
                    $(el).addClass('error_atrribute_border');
                    count--;
                    windowSizeAutoScroll();
                    return false;
                }
            });
            if (count) {
                var PID = $("#pid").val();
                if (PID != '') {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>order/remove_from_wishlist_using_ajax',
                        data: {
                           product_variation_id : PID
                        },
                        success: function(result) {
                            var data = jQuery.parseJSON(result);
                            if (data.status=='success') {
                                curr.html("<span><img src='"+ SITE_URL +"assets/frontend/img/icons/heart-empty.svg' width='22'></span> Add to Wishlist");
                                curr.removeClass('wishListRemove').addClass('wishListAdd');
                                successMsg(data.msg);
                            } else {
                                errorMsg(data.msg);
                                return false;
                            }
                        }
                    });
                } else {
                    errorMsg('Something went wrong! Please try again');
                    return false;
                }
            } else {
                windowSizeAutoScroll();
                return false;
            }
        }
        windowSizeAutoScroll();
        return false;
    });


    $('#add_to_cart').submit(function() {

        $('.product_attribute').removeClass('error_atrribute_border');
        if (available_attr == '') {
            return true;
        } else {
            var count = 1;
            $(".product_attribute").each(function(i, el) {
                if ($(el).val() == '') {
                    $(el).addClass('error_atrribute_border');
                    count--;
                    windowSizeAutoScroll();
                    return false;
                }
            });
            if (count){
                return true;
            }else{
                windowSizeAutoScroll();
                return false;
            }
        }
        windowSizeAutoScroll();
        return false;
    });


    <?php if(!empty($variations) && !empty($variations['colour'])){ ?>
    $("document").ready(function() {
        $("ul.color-list li:first-child .product_colour").trigger('click');
    });
    <?php } ?>


    $('body').on('change', '.product_attribute', function() {
        var shipmentAddress = $("input[name='chooseAddressForShip']:checked").val();
        if (shipmentAddress == undefined || shipmentAddress == '') {
            shipmentAddress = "";
        }
        $('.product_attribute').removeClass('error_atrribute_border');
        $('.error_atrribute').hide();
        var check = $(this).attr('main');
        var attr = [];
        var select_attr = [];
        var count = 1;
        $(".product_attribute").each(function(i, el) {
            attr.push('json_contains(product_variations.product_variation_info,\'{"' + $(el).attr('main') + '" : "' + $(el).val() + '"}\')==');
            select_attr.push($(el).attr('main'));
            if ($(el).val() != '' && check == $(el).attr('main'))
                return false;
            if ($(el).val() == '') {
                count--;
                $('.error_atrribute').show();
                windowSizeAutoScroll();
                return false;
            }
        });
        if (count) {
            //console.log(data);
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>products/ajaxProductattribute/',
                data: 'product_info_id=' + product_info_id + '&colour=' + colour + '&available_attr=' + available_attr + '&attribute=' + attr + '&select_attr=' + select_attr + '&shipmentAddress=' + shipmentAddress,
                beforeSend: function() {
                    $('.loading').show();
                },
                success: function(result) {
                    var data = jQuery.parseJSON(result);
                    if (data['status']) {
                        data = data['data'];

                        if($(window).width() <= 1050){
                           $('.wishListdiv-btn').html(data['wishList_divm']);
                        }else{
                           $('.wishListdiv-btn').html(data['wishList_div']);
                        }

                        $('#product_price').html(data['product_price']);
                        $('#seller_description').html(data['seller_description']);
                        $('#warranty_description').html(data['warranty_description']);
                        for (var i = 0; i < data['remove_drop'].length; i++) {
                            $('.' + data['remove_drop'][i]).remove();
                        }
                        url = data['url'];

                        $("meta[property='og\\:url']").attr("content", url);
                        $('#variations_section').append(data['variations_section']);
                        $('#product_number').html(data['product_number']);
                        $('.loading').fadeOut("slow");
                        $('.stock-status').removeClass('in-stock');
                        $('.stock-status').removeClass('out-stock');
                        $('#pid').val(data['product_ID']);
                        if (data['available_quantity'] > 0) {
                            $('.stock-status').addClass('in-stock');
                            $('.stock-status').text('In Stock');
                            $('.buy-now-box').show();
                        } else {
                            $('.stock-status').addClass('out-stock');
                            $('.stock-status').text('Out Of Stock');
                            $('.buy-now-box').hide();
                        }
                        window.history.pushState("title", "Product List", url);
                    } else {
                        errorMsg('Something went wrong! Please try again');
                        return false;
                    }
                }
            });
        }
    });
</script>