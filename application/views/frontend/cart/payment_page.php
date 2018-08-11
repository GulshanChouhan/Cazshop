<!DOCTYPE html>
<html lang="en">
   <head>
      <link rel="icon" type="image/png" href="<?php echo FRONTEND_THEME_URL; ?>img/cazshoppe_favicon.png"/>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name='viewport'/>

      <title><?php echo $title.' | '; ?><?php echo ucwords(SITE_NAME); ?></title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta property="og:image:width" content="3523" >
      <meta property="og:image:height" content="2372" >
      <meta property="og:url" content=">">
      <meta property="og:title" content=""  > 
      <meta property="og:site_name" content="<?php echo ucwords(SITE_NAME); ?>" />
      <meta property="og:description" content="" > 

      <link rel="stylesheet" type="text/css" href="<?php echo FRONTEND_THEME_URL ?>css/font-awesome.min.css">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,500,600,800" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,600,700" rel="stylesheet">
      <link href="<?php echo FRONTEND_THEME_URL ?>css/icofont.css" rel="stylesheet">
      <link href="<?php echo FRONTEND_THEME_URL ?>css/bootstrap.min.css" rel="stylesheet">
      <link href="<?php echo FRONTEND_THEME_URL ?>css/style.css" rel="stylesheet">
      <link href="<?php echo FRONTEND_THEME_URL ?>css/cart-section.css" rel="stylesheet">
      <script src="<?php echo FRONTEND_THEME_URL ?>js/jquery.min.js"></script>
      <link href="<?php echo BACKEND_THEME_URL; ?>css/sweetalert.css" rel="stylesheet" type="text/css"/>
      <script src="<?php echo base_url(); ?>assets/backend/admin/js/notify.min.js"></script>
      <script src="<?php echo FRONTEND_THEME_URL ?>js/jquery-ui.js"></script>
      <link rel="stylesheet" href="<?php echo FRONTEND_THEME_URL ?>css/jquery-ui.css">

      <script>
         SITE_URL = "<?php echo base_url(); ?>";
      </script>
   </head>

   <body>
    <div class="login-main-header">
      <div class="container-fluid">
        <div class="login-site-logo text-center">
          <a href="<?php echo base_url(); ?>"><img src="<?php echo FRONTEND_THEME_URL ?>img/icons/copico-logo-black.png"></a>
        </div>
      </div>
    </div>

    <section class="login-pages account-page" id="autoScrollDiv" style="padding-bottom: 0;">
      <div class="theme-background">
         <section class="cart-page-warp payment-page-wrap">
            <div class="container-fluid">
              <div class="col-sm-12">
                <div class="highlight-info-box">
                   <p><b>Note -</b> We are requesting you, Please don't close this window while doing payment process</p>
                </div>
              </div>
              <div class="clearfix" style="margin-bottom: 40px;"></div>
              <div class="col-md-6">
                <div class="theme-box cart-prodcut-deatil-box">
                  <?php
                    $cart = (array) json_decode($tempary_paymentinfo->cart_info);
                    $grand_total = 0.00; $shipping_total = 0.00; $i = 1;
                    foreach ($cart as $cartRowId => $item){
                     $item = (array) $item;
                     $product_infoItem = json_decode($item['product_info']);
                     $Image = $item['image'];
                     $Image = explode(',', $Image);
                  ?>

                     <div class="cart-product-tile">
                        <div class="cart-product">
                           <div class="no-padding-left img-view-box col-sm-3 col-md-3">
                              <a href="<?php echo base_url('pd/'.$item['slug'].'/'.base64_encode($item['id'])); ?>">
                              <img src="<?php echo base_url(); ?>assets/uploads/seller/products/thumbnail/<?php echo $Image[0]; ?>">
                              </a>
                           </div>
                           <div class="details-view-box col-sm-7 col-md-7">
                              <h4><a href="<?php echo base_url('pd/'.$item['slug'].'/'.base64_encode($item['id'])); ?>"><?php echo ucfirst($item['name']); ?></a></h4>
                              <div class="product-property">
                                 <?php
                                     $tempMore = ""; 
                                     $product_variation_info = (isset($item['product_variation_info'])) ? $item['product_variation_info'] : array();
                                     $product_basic_info = (isset($item['product_basic_info'])) ? $item['product_basic_info'] : array();
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

                           </div>
                           <div class="price-view-box">
                              <div class="price-label">
                                 <span class="dollar-icon-bold">$</span><span class="number-icon-bold"><?php echo number_format($item['base_price'],2); ?></span>
                              </div>
                              <div class="discount-price-label">
                                 <span class="percantage">-<?php echo round((($item['sell_price']-$item['base_price'])/$item['sell_price'])*100, 2) ?>%</span>
                                 <span class="dollar-icon-normal">$</span><del class="number-icon-normal"><?php echo number_format($item['sell_price'],2); ?></del>
                              </div>

                              <?php 
                                 $grand_total = $grand_total + $item['subtotal'];
                                 if(isset($item['shipping_charges']) && !empty($item['shipping_charges'])){
                                    $shipping_total = $shipping_total + $item['shipping_charges'];
                                 }
                              ?>
                           </div>
                           <div class="clearfix"></div>
                        </div>
                     </div>
                 <?php } ?>
                </div>
              </div>
              <div class="col-md-6">
                <div class="theme-box">
                  <?php 
                    if(!empty($tempary_paymentinfo)){ 
                      $responce = json_decode($tempary_paymentinfo->payment_info);
                      if(isset($responce->iframe)){
                  ?>
                  <iframe frameborder="0" src="<?php echo $responce->iframe; ?>" height="450" width="100%"></iframe>
                  <?php } } ?>
                </div>
              </div>
            </div>
         </section>
      </div>
      <div class="clearfix"  style="background: #ffffff;padding-bottom: 40px;">
        <div class="bold-border"></div>
        <div class="continer-fluid">
          <div class="footer-top-bar fix-row clearfix">
            <div class="text-center copy-right">
              <p class=""><a class="view-more" href="<?php echo base_url('page/privacy-policy'); ?>">Privacy Policy</a> - <a class="view-more" href="<?php echo base_url('page/terms-and-condition'); ?>" rel="nofollow"> Terms of Use</a> © <?php echo date('Y'); ?> <?php echo ucwords(SITE_NAME); ?>. All rights reserved. </p>
            </div>
            <div class="text-center social-links-shear">
              <div class="tell-a-friend">
                <div class="share">
                  Keep in touch
                </div>
                <?php 
                    $FACEBOOK_URL = get_option_url('FACEBOOK_URL');
                    $TWITTER_URL = get_option_url('TWITTER_URL');
                    $INSTAGRAM_URL = get_option_url('INSTAGRAM_URL');
                    $PINTEREST_URL = get_option_url('PINTEREST_URL');
                    $RSS_URL = get_option_url('RSS_URL');
                ?>
                <div class="social-links">
                   <?php if($FACEBOOK_URL){ ?>
                   <span>
                      <a target="_blank" href="<?php echo $FACEBOOK_URL; ?>" class="facebook facebook_share" title="facebook">
                         <img src="<?php echo FRONTEND_THEME_URL ?>/img/icons/facebook.svg">
                      </a>
                   </span>
                   <?php } if($TWITTER_URL){ ?>
                   <span>
                      <a target="_blank" href="<?php echo $TWITTER_URL; ?>" class="twitter twitter_share" title="twitter">
                         <img src="<?php echo FRONTEND_THEME_URL ?>/img/icons/twitter.svg">
                      </a>
                   </span>
                   <?php } if($INSTAGRAM_URL){ ?>
                   <span>
                      <a target="_blank" href="<?php echo $INSTAGRAM_URL; ?>" class="email google_share" title="email">
                         <img src="<?php echo FRONTEND_THEME_URL ?>/img/icons/google-plus.svg">
                      </a>
                   </span>
                   <?php } if($PINTEREST_URL){ ?>
                   <span>
                      <a target="_blank" href="<?php echo $PINTEREST_URL; ?>" class="instagram linkedin_share" title="instagram">
                         <img src="<?php echo FRONTEND_THEME_URL ?>/img/icons/linkedin.svg">
                      </a>
                   </span>
                   <?php } if($RSS_URL){ ?>
                   <span>
                      <a target="_blank" href="<?php echo $RSS_URL; ?>" class="pinterest pinterest_share" title="pinterest">
                         <img src="<?php echo FRONTEND_THEME_URL ?>/img/icons/pinterest.svg">
                      </a>
                   </span>
                   <?php } ?>
                </div>
             </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>