<?php
  $url=current_url();
  if(isset($product) && !empty($product) && !empty($product->meta_description)){
    $description=str_replace("'","\'",$product->meta_description);
  }else{
    $description=str_replace("'","\'",$product->short_description);
  }

  $btc=getCryptocurrencyRate('usd-btc');
  $eth=getCryptocurrencyRate('usd-eth');
?>
<div class="comman-page-wrapper">
  <div class="container-fluid">
    <div class="row">
      <form action="<?php echo base_url('cart/add_to_cart') ?>" method="post" id="add_to_cart">
        <input type="hidden" name="pid" id="pid" value="<?php echo base64_encode($product->product_variation_id); ?>">
        <div class="ratingpage-top-wrapper clearfix">
          <div class="col-md-10 rating-left-sidebar">
            <div class="a-row theme-box rating-wrapper-page">
              <div class="col-md-12 padding-top-bottom-15">
                <div class="rating-product-block">
                  <div class="rating-product-head clearfix">
                    <?php $image=''; if($product->image){
                    $images=explode(',',$product->image);
                    ?>
                    <div class="rating-product-img">
                      <img id="zoom_01" src='<?php echo base_url('assets/uploads/seller/products/small_thumbnail/'.$images[0]); ?>' class="">
                    </div>
                    <?php }else{ ?>
                    <div class="rating-product-img">
                      <img src="<?php echo FRONTEND_THEME_URL ?>img/defult-product-img.jpg" class="">
                    </div>
                    <?php } ?>
                    <div class="rating-product-title">
                      <a href="<?php echo base_url('pd/'.$product->slug.'/'.base64_encode($product->product_variation_id)); ?>"><?php $title=str_replace("'","\'",ucwords($product->title));
                      echo ucwords($product->title) ?></a>
                    </div>
                    <div class="product-price">
                      <?php
                      if($product->sale_start_date!='' && $product->sale_start_date<=date('Y-m-d') && $product->sale_end_date!='' && $product->sale_end_date>=date('Y-m-d')){
                         $product->base_price=$product->sale_price;
                      }
                      if($product->base_price<=$product->sell_price){ ?>
                      <div class="main-price">
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
                         </div>
                      </div>
                      <?php } ?>
                   </div>
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
                      <?php $seller_rating = explode(',', $product->seller_rating); ?>
                      Product Sold by <a href="javascript:void(0)"><?php echo ucfirst($product->user_name); ?></a>
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

              <?php
                if(!empty($ratings)){
              ?>

              <div class="col-md-12">
                <div class="rating-left-side clearfix">
                  <div class="col-sm-5 no-padding">
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
                  <div class="col-sm-7 no-padding">
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
              </div>
              <div class="clearfix"></div>
              <div class="rating-wrapper clearfix">
                <div class="">
                  <div class="col-sm-12">
                    <div class="review-block clearfix">
                      <?php foreach ($ratings as $key => $value) {
                      ?>
                      <div class="customer-review clearfix">
                        <div class="left-side-review">
                          <div class="review-avtar">
                            <img src="<?php echo FRONTEND_THEME_URL ?>/img/icons/review-default.svg" class="img-rounded" width="50">
                          </div>
                          <?php
                          $now = time(); // or your date as well
                          $your_date = strtotime($value->created_at);
                          $datediff = $now - $your_date;
                          ?>
                          <div class="review-customer-info">
                            <div class="review-block-name">
                              <?php echo ucwords($value->user_name); ?>
                            </div>
                            <div class="review-block-date">
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
                      <?php }?>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="pagination-type-block">
                      <?php if(!empty($pagination))  echo $pagination;?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
              <?php }else{ ?>
                <div class="no-rating-available">
                  <div class="col-md-12">
                    <br><br>
                    <div class="noresult-block text-center">
                      <div class="noresult-img">
                        <img src="<?php echo base_url('assets/frontend/img/empty-icon/large-exclamation-mark.svg'); ?>">
                      </div>
                      <div class="noresult-content">
                        <h4>No rating and review available</h4>
                      </div>
                    </div>
                    <br><br>
                  </div>
                </div>
                <?php } ?>
            </div>
          </div>
          <div class="col-md-2 rating-right-sidebar">
            <!-- ==== Start Mobile Buy Now btn ==== -->
             <div class="mobile-buynow-wrap">
                <div class="mob-cart-btn">
                   <button class="btn btn-red btn-block">Buy for 
                      <span class="dollar-icon-bold">$</span>
                      <span class="number-icon-bold">
                         <?php 
                            if(!empty($product->base_price))
                               echo number_format($product->base_price,2);
                            else
                               echo "0.00"; 
                         ?>
                      </span>
                      <span class="mob-block mob-btn-currency">
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
                      </span>
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
                  <a onclick="return popitup('linkedin')" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url; ?>" class="instagram linkedin_share" title="instagram">
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
              <?php
                }
              ?>
              <div class="product-qty">
                <span class="qty-label">Quantity : </span>
                <span class="select-box">
                  1
                  <!-- <select name="quantity" class="form-control">
                    <option value="1" selected="">1</option>
                  </select> -->
                </span>
              </div>
              <div class="detail-button-block">
                <div class="buy-now-btn">
                  <button class="btn btn-cart btn-block">
                  <span><img src="<?php echo FRONTEND_THEME_URL ?>img/icons/push-button.svg" width="22"></span> Buy Now
                  </button>
                  <?php
                    $wishListProduct = getRow('wish_list',array('user_id'=>user_id(), 'product_variation_id'=>$product->product_variation_id), array('wish_list_id'));
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
                <?php foreach ($product_right as $key => $p_right) {
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
                      <div class="price">
                        <span class="small-coast">
                          <span class="base-price"><span class="dollar-icon-bold">$</span><span class="number-icon-bold"><?php echo number_format($p_right->base_price,2); ?></span></span>
                          <?php if($p_right->base_price<$p_right->sell_price){
                          echo '<span class="sell-price"><span class="dollar-icon-normal">$</span><del class="number-icon-normal">'.number_format($p_right->sell_price,2).'</del></span>';
                          } ?>
                        </span>
                      </div>
                      <?php if($product->total_rating>0){ ?>
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
      </div>      
    </div>
    <br>
    <?php if(!empty($related_or_discount_products)){ ?>
    <div class="container-fluid home-section">
      <h2 class="basic-heading text-center"><?php echo $related_or_discount_products_heading; ?></h2>
      <div class="product-slider">
        <?php foreach($related_or_discount_products as $product){ ?>
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
        </form>
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
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Choose your delivery location</h4>
      </div>
      <div class="modal-body">
        <?php
        $shippingAddress = getDataResult('shipping_addresess', array('user_id'=>user_id(), 'status'=>1));
          if(!empty($shippingAddress)){
        ?>
        <p>Select a delivery location to see product availability and delivery options</p>
        <?php
        $i=0;
        foreach ($shippingAddress as $row) {
          $i++;
          $city = getData('cities',array('id',$row->city))->name;
        ?>
        <div class="panel panel-default">
          <div class="panel-body" style="word-wrap: break-word;"><input type="radio" name="chooseAddressForShip" class="chooseAddressForShip" value="<?php echo $row->shipping_address_id; ?>" <?php if($i==1) echo "checked"; ?>> <b><?php echo $row->first_name.' '.$row->last_name; ?> - <?php echo $row->address; ?></b> - <?php echo $city; ?></div>
        </div>
        <?php } }else{
        ?>
        <div align="center">No Shipping Address Found.</div>
        <?php }
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <?php
        $shippingAddress = getDataResult('shipping_addresess', array('user_id'=>user_id(), 'status'=>1));
          if(!empty($shippingAddress)){
        ?>
        <button type="button" class="btn btn-primary submitAddress">Submit</button>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<?php } ?>
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
                return false;
            }
        });
        if (count)
            return true;
        else
            return false;
    }
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
        data: 'product_variation_id=' + PID + '&shipmentAddress=' + shipmentAddress,
        beforeSend: function() {
            $('.loading').show();
        },
        success: function(result) {
            var data = jQuery.parseJSON(result);
            if (data.status == 'success') {
                var shipmentRate = "Delivery to " + data.yourAddress;
                if (data.type == 1 && data.data != '' && data.data != null) {
                    shipmentRate += " <b>( FREE Delivery )</b>";
                } else if ((data.type == 2 || data.type == 3) && data.data != '' && data.data != null) {
                    shipmentRate += ' <b>( Applied $' + data.data.toFixed(2) + ' shipping charge )</b>';
                } else {
                    shipmentRate += ' <b>( Delivery not applicable )</b>';
                }
                $('.putShipmentRateDiv').html(shipmentRate);
                $('#myDeliveryLocation').modal('hide');
            } else {
                alert("try again..");
                $('.putShipmentRateDiv').html("");
            }

        }
    });
});

$('body').on('click','.wishListAdd',function(){
    user_id = "<?php echo user_id(); ?>";
    if(!user_id) window.location.replace("<?php echo base_url('page/login'); ?>");

    var curr = $(this);
    var PID = $("#pid").val();
    if (PID!= ''){
        $.ajax({
             type: 'POST',
             url: '<?php echo base_url(); ?>order/add_to_wishlist_using_ajax',
             data: {
                product_variation_id : PID
             },
             beforeSend: function() {
                 $('.loading').show();
             },
             success: function(result) {
                 var data = jQuery.parseJSON(result);
                 $('.loading').hide();
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
});

$('body').on('click','.wishListRemove',function(){
    user_id = "<?php echo user_id(); ?>";
    if(!user_id) window.location.replace("<?php echo base_url('page/login'); ?>");

    var curr = $(this);
    var PID = $("#pid").val();
    if (PID != '') {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>order/remove_from_wishlist_using_ajax',
            data: {
               product_variation_id : PID
            },
            beforeSend: function() {
                $('.loading').show();
            },
            success: function(result) {
                var data = jQuery.parseJSON(result);
                $('.loading').hide();
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
                return false;
            }
        });
        if (count)
            return true;
        else
            return false;
    }
    return false;
});
</script>