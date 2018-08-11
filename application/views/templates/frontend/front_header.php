<!DOCTYPE html>
<html lang="en">
   <head>
      <link rel="icon" type="image/png" href="<?php echo FRONTEND_THEME_URL; ?>img/cazshoppe_favicon.png"/>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name='viewport'/>
      <meta name="alfacoins-site-verification" content="5af42677a61845af42677a61ba5af42677a61f1_ALFAcoins">
      <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
      <?php 
      if(isset($category_info) && !empty($category_info) && !empty($category_info->meta_title)){
         $title= (!empty($category_info->meta_title) && $category_info->meta_title!='NULL') ? $category_info->meta_title : $category_info->category_name;
      }else if(isset($product) && !empty($product) && !empty($product->meta_title)){
         $title= (!empty($product->meta_title)  && $product->meta_title!='NULL') ? $product->meta_title : $product->title;
      } 
      $meta_description = SITE_NAME_WITH_EXTENTION." : Online Shopping - Buy mobiles, laptops, cameras, watches. Free Shipping & Cash on Delivery Available.";
      if(isset($category_info) && !empty($category_info) && !empty($category_info->meta_description)){
            $meta_description=$category_info->meta_description; 
      }else if(isset($product) && !empty($product) && !empty($product->meta_description)){
            $meta_description=$product->meta_description;  
      } 
      $meta_keyword="caz shop, Online Shopping, online shopping india, india shopping online, caz shop india, buy online, buy mobiles online, buy books online, buy movie dvd's online, kindle, kindle fire hd, kindle computers, laptop, trimmers, watches, fashion jewellery, home, kitchen, small appliances, beauty, Sports, Fitness & Outdoors";
      if(isset($category_info) && !empty($category_info) && !empty($category_info->meta_keyword)){
         $meta_keyword=$category_info->meta_keyword; 
      }else if(isset($product) && !empty($product) && !empty($product->meta_keyword)){
           $meta_keyword=$product->meta_keyword; 
      }  ?>

      <title><?php echo ucfirst($title).' | '.SITE_NAME; ?></title>
      <meta name="keywords" content="<?php echo $meta_keyword ?>">
      <meta name="description" content="<?php echo $meta_description ?>">
      <meta property="og:image:width" content="3523" >
      <meta property="og:image:height" content="2372" >
      <meta property="og:url" content="<?php echo $meta_keyword ?>">
      <meta property="og:title" content="<?php echo $title; ?>"  > 
      <meta property="og:site_name" content="caz shoppe" />
      <meta property="og:description" content="<?php echo $meta_description ?>" > 
      <?php if(isset($product) && !empty($product) && !empty($product->image)){
         $images=explode(',',$product->image);
         $image=base_url('assets/uploads/seller/products/'.$images[0]);
         echo  '<meta property="og:image" content="'.$image.'">';
      } ?>
      <link rel="stylesheet" type="text/css" href="<?php echo FRONTEND_THEME_URL ?>css/font-awesome.min.css">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,500,600,800" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,600,700" rel="stylesheet">
      <link href="<?php echo FRONTEND_THEME_URL ?>css/icofont.css" rel="stylesheet">
      <link href="<?php echo FRONTEND_THEME_URL ?>css/bootstrap.min.css" rel="stylesheet">
      <link href="<?php echo FRONTEND_THEME_URL ?>css/slick.css" rel="stylesheet">
      <link href="<?php echo FRONTEND_THEME_URL ?>css/slick-theme.css" rel="stylesheet">
      <link href="<?php echo FRONTEND_THEME_URL ?>css/style.css" rel="stylesheet">
      <link href="<?php echo FRONTEND_THEME_URL ?>css/cart-section.css" rel="stylesheet">
      <script src="<?php echo FRONTEND_THEME_URL ?>js/jquery.min.js"></script>
      <script src="<?php echo FRONTEND_THEME_URL ?>js/slick.min.js"></script>
      <link rel="stylesheet" href="<?php echo FRONTEND_THEME_URL ?>css/voteStar.css">
      <link href="<?php echo SELLER_THEME_URL; ?>css/cryptofont.min.css" rel="stylesheet">
      <link href="<?php echo BACKEND_THEME_URL; ?>css/sweetalert.css" rel="stylesheet" type="text/css"/>
      <script src="<?php echo FRONTEND_THEME_URL ?>js/jquery.voteStar.js"></script>
      <script src="<?php echo base_url(); ?>assets/backend/admin/js/notify.min.js"></script>
      <script src="<?php echo FRONTEND_THEME_URL ?>js/jquery-ui.js"></script>
      <link rel="stylesheet" href="<?php echo FRONTEND_THEME_URL ?>css/jquery-ui.css">
      <link href="<?php echo FRONTEND_THEME_URL ?>css/animate.min.css" rel="stylesheet">
      <script src="<?php echo FRONTEND_THEME_URL ?>js/theme-script.js" type="text/javascript"></script>
      <!-- Global site tag (gtag.js) - Google Analytics -->
      <script async src="https://www.googletagmanager.com/gtag/js?id=UA-120545672-1"></script>
      
      <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-120545672-1');
      </script>
      <script>
         SITE_URL = "<?php echo base_url(); ?>";
         CUSTOMER_ID = "<?php echo user_id(); ?>";
      </script>
      <script>
         $(function(){
            $.ui.autocomplete.prototype._renderItem = function (ul, item) {
                item.label = item.label.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + $.ui.autocomplete.escapeRegex(this.term) + ")(?![^<>]*>)(?![^&;]+;)", "gi"), "<strong>$1</strong>");
                return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<a>" + item.label + "</a>")
                        .appendTo(ul);
            };

            $("#searchPro").autocomplete({
                minLength: 1,
                source: 
                function(req, add){
                    $.ajax({
                        url: "<?php echo base_url(); ?>page/header_autocomplete",
                        dataType: 'json',
                        type: 'POST',
                        data: req,
                        success:    
                        function(data){
                            if(data.response =="true"){
                                add(data.message);
                            }
                        },
                    });
                },      
            });

         });
      </script>
      <style>
         .no-rating{
            color: #979191;
         }
      </style>
   </head>
   <body>
      <?php 
         /*$getdata=$this->common_model->get_result('cart_data',array('user_id'=>user_id()));
         foreach ($getdata as $key => $value) {
            $cartdatacount=$value['cart_data'];
         }
         echo $cartcount=count($cartdatacount);
         die;*/

         $headermenu=getHeaderMenu();
         $cartcount = count($this->cart->contents()); 
      ?>
      <!-- ============== Start Desktop Header Section =============== -->
      <div class="theme-header clearfix">
         <div class="theme-top-header">
            <div class="container-fluid">
               <div class="header-contact-info">
                  <ul class="list-inline no-margin">
                     <li>
                        <a href="<?php echo 'mailto:'.get_option_url('EMAIl'); ?>">
                        <i class="icofont icofont-envelope"></i> <?php echo get_option_url('EMAIl'); ?>
                        </a>
                     </li>
                     <!-- <li class="divider-line">&nbsp;</li> -->
                     <!-- <li>
                        <a href="<?php //echo 'tel:'.get_option_url('PHONE'); ?>">
                        <i class="icofont icofont-telephone"></i> <?php //echo get_option_url('PHONE'); ?>
                        </a>
                     </li> -->
                  </ul>
               </div>
              <!--  <div class="crypto-head">
                  <ul>
                     <li>
                        <div class="crypto-block">
                           <img class="crypto-icon" src="<?php echo FRONTEND_THEME_URL ?>img/footer-icon/cazcoinlogo.png" width="">
                           <span>$120</span>
                        </div>
                     </li>
                     <li>
                        <div class="crypto-block">
                           <img class="crypto-icon" src="<?php echo FRONTEND_THEME_URL ?>img/footer-icon/Bitcoin-logo.png" width="">
                           <span>$120</span>
                        </div>
                     </li>
                     <li>
                        <div class="crypto-block">
                           <img class="crypto-icon" src="<?php echo FRONTEND_THEME_URL ?>img/footer-icon/ethereum-circle-logo.png" width="">
                           <span>$120</span>
                        </div>
                     </li>
                     <li>
                        <div class="crypto-block">
                           <img class="crypto-icon" src="<?php echo FRONTEND_THEME_URL ?>img/footer-icon/litecoin.png" width="">
                           <span>$120</span>
                        </div>
                     </li>
                  </ul>
               </div> -->
               <div class="header-link pull-right">
                  <ul class="list-inline no-margin">
                     <li><a href=""><i class="icofont icofont-diamond"></i> offers</a></li>
                     <li class="divider-line">&nbsp;</li>
                     <li class="merchant-link-li"><i class="icofont icofont-crown"></i> Merchant <a href="<?php echo base_url('seller/login'); ?>">Login</a>&nbsp;/&nbsp;<a href="<?=base_url('seller/register')?>">Register</a></li>
                  </ul>
               </div>
               <!-- <div class="header-promo-block text-center">
                  <p><?php //echo get_option_url('OFFER'); ?></p>
               </div> -->
            </div>
         </div>
         <div class="main-header header-sticky">
            <div class="container-fluid">
               <div class="site-logo">
                  <a href="<?php echo base_url(); ?>"><img src="<?php echo FRONTEND_THEME_URL ?>img/new-logo.svg"></a>
               </div>
               <div class="nav-tools">
                  <ul class="list-inline no-margin">
                     <li class="tool-link">
                        <div class="dropdown my-cart-dropdown">
                           <a href="<?php echo base_url('cart/index'); ?>">
                              <div class="tool-block">
                                 <div class="tool-icon cart-icon <?php if($cartcount!='' && $cartcount!=0){ ?>cart-price-icon<?php } ?>">
                                    <img src="<?php echo FRONTEND_THEME_URL ?>img/shopping-bag-solid.svg" width="30">
                                    <!-- <i class="icofont icofont-shopping-cart"></i> --> 
                                    <?php 
                                       if($cartcount!='' && $cartcount!=0){ 
                                    ?>
                                       <div class="cart-count">
                                          <span><?php echo $cartcount; ?></span>
                                       </div>
                                    <?php } ?>
                                 </div>
                                 <div class="tool-element cartname <?php if($cartcount!='' && $cartcount!=0){ ?>cart-price<?php } ?>">
                                    <?php 
                                       $grand_total = 0.00; $shipping_total = 0.00;
                                       $cart = $this->cart->contents(); 
                                       foreach ($cart as $cartRowId => $item){
                                          $product_infoItem = json_decode($item['product_info']);
                                          $grand_total = $grand_total + $item['subtotal'];
                                          if(isset($item['shipping_charges']) && !empty($item['shipping_charges'])){
                                             $shipping_total = $shipping_total + $item['shipping_charges'];
                                          }
                                       }

                                       $grand_total = $grand_total + $shipping_total;
                                       if($grand_total==0 || $grand_total==''){
                                          echo "No Items in <br> the Bag";
                                       }else{
                                          echo '<span class="dollar-icon-normal">$</span><span class="number-icon-normal">'.number_format($grand_total, 2).'</span>';
                                       }
                                    ?>
                                 </div>
                              </div>
                           </a>
                           <?php 
                              $segment1 = $this->uri->segment(1);
                              if(!empty($this->cart->contents()) && $segment1!='cart'){ 
                           ?>
                           <div class="cart-dropdown-open">
                              <div class="dropdown-menu reset-dropdown">
                                 <ul class="">
                                    <?php 
                                       $cart = $this->cart->contents(); 
                                       $grand_total = 0.00; $shipping_total = 0.00; $i = 1;
                                       foreach ($cart as $item){
                                          $product_infoItem = json_decode($item['product_info']);
                                          $Image = $item['image'];
                                          $Image = explode(',', $Image);
                                    ?>
                                    <li>
                                       <div class="cart-product-wrapper">
                                          <div class="cart-product-img">
                                             <a href="<?php echo base_url('pd/'.$item['slug'].'/'.base64_encode($item['id'])); ?>">
                                                <img src="<?php echo base_url(); ?>assets/uploads/seller/products/thumbnail/<?php echo $Image[0]; ?>">
                                             </a>
                                          </div>
                                          <div class="cart-product-title">
                                             <h5><a href="<?php echo base_url('pd/'.$item['slug'].'/'.base64_encode($item['id'])); ?>" class=""><?php echo ucfirst($item['name']); ?></a></h5>
                                             <div class="cart-product-quantity">
                                                <div class="number-icon-bold">Quantity: 1</div>
                                             </div>
                                          </div>
                                          <div class="cart-product-price">
                                             <div><span class="dollar-icon-bold">$</span><span class="number-icon-bold"><?php echo number_format($item['base_price'],2); ?></span></div>
                                             <div class="cart-product-delete">
                                                <a href="javascript:void(0)" onclick="return confirmBox('Do you want to remove it ?','<?php echo base_url('cart/remove/'.$item['rowid']); ?>')"><i class="icofont icofont-trash"></i></a>
                                             </div>
                                          </div>
                                       </div>
                                    </li>
                                    <?php } ?>
                                 </ul>
                                 <div class="proced-checkout-btn">
                                    <a class="btn btn-red btn-block" href="<?php echo base_url('cart/index'); ?>"> Proceed To Checkout</a>
                                 </div>
                                 <!-- <div class="proced-checkout-msg">
                                    1 item in your cart is out of stock. Please modify your cart in order to continue.
                                 </div> -->
                              </div>
                           </div>
                           <?php } ?>
                        </div>
                     </li>
                     <li class="tool-link">
                        <div class="tool-block">
                           <div class="tool-icon">
                              <i class="icofont icofont-user-alt-5"></i>
                           </div>
                           <div class="tool-element">
                              <?php if(user_logged_in()==FALSE){ ?>
                              <div class="account-link">
                                 <a href="<?php echo base_url('page/login'); ?>">Sign In </a> | <a href="<?php echo base_url('page/signup'); ?>">Join Free</a>
                              </div>
                              <div class="my-account-dropdown">
                                 <a href="<?php echo base_url('page/login'); ?>">My Account </a>
                              </div>
                              <?php }else{ ?>
                              <div class="dropdown my-account-dropdown">
                                 <a href="<?php echo base_url('account/profile'); ?>">
                                    <?php
                                       $username = ucfirst(user_name());
                                       $userfirstname = strstr($username, ' ', true);
                                       if(!empty($userfirstname)){
                                          $username = $userfirstname;
                                       }

                                       if (strlen($username) <=10) {
                                         $username = $username;
                                       } else {
                                         $username = substr($username, 0, 10) . '..';
                                       }
                                    ?>
                                    <div class="user-name">Hello, <?php echo $username; ?></div>
                                    <div class="">My Account</div>
                                 </a>
                                 <div class="account-dropdown-open">
                                    <ul class="dropdown-menu reset-dropdown">
                                       <li><a href="<?php echo base_url('account/dashboard'); ?>"><span class="icon"><img src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/speedometer-gray.svg"></span>Dashboard</a></li>
                                       <li><a href="<?php echo base_url('account/open_orders'); ?>"><span class="icon"><img src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/closed-cardboard-gray.svg"></span>Your Orders</a></li>
                                       <li><a href="<?php echo base_url('account/wish_list'); ?>"><span class="icon"><img class="active-img" src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/wishlist-gray.svg"></span>Your Wishlist</a></li>
                                       <li><a href="<?php echo base_url('account/profile'); ?>"><span class="icon"><img src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/my-profile-gray.svg"></span>Your Account</a></li>
                                       <li><a href="<?php echo base_url('account/change_password'); ?>"><span class="icon"><img src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/lock-gray.svg"></span>Change Password</a></li>
                                       <li><a href="<?php echo base_url('account/logout'); ?>"><span class="icon"><img src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/logout-or-send-gray.svg"></span>Sign Out</a></li>
                                    </ul>
                                 </div>
                              </div>
                              <?php } ?>
                           </div>
                        </div>
                     </li>
                  </ul>
               </div>
               <div class="main-search-block">
                  <form action="<?php echo base_url('p') ?>" method="get">
                     <div class="input-group">
                        <div class="input-group-btn">
                           <select name="slug" class="form-control main-search-catg" id="artCategoryId">
                              <option value="">All</option>
                              <?php $cate=''; if(!empty($_GET['slug'])) $cate=$_GET['slug']; echo getcategoryDropdownMenu($cate); ?>
                           </select>
                        </div>
                        <input type="text" class="form-control" id="searchPro" name="key" placeholder="Search for a Product keywords or Category" value="<?php if(!empty($_GET['key'])) echo $_GET['key']; ?>">
                        <span class="input-group-btn">
                        <button class="btn btn-default btn-serach" type="submit">
                        <img src="<?php echo FRONTEND_THEME_URL ?>svgicons/Icon_Search.svg" width="18">
                        </button>
                        </span>
                     </div>
                  </form>
               </div>
            </div>
         </div>
         <div class="site-navigation clearfix">
            <div class="container-fluid">
               <div class="department-block">
                  <!-- <div class="btn-group"> -->
                  <a href="#" class="btn  dropdown-toggle btn-catg-dropnav">
                  <i class="icofont icofont-align-left icon-catg"></i> Categories <i class="fa fa-angle-down down-icon" aria-hidden="true"></i> 
                  </a>
                  <ul class="department-dropdown">
                     <?php  if(!empty(getMegamenu(0))){ foreach(getMegamenu(0) as $row){ ?>
                     <li class="has-sub">
                        <h4 class="catg-link-block">
                           <a href="<?php if($row->subCategory) echo base_url($row->category_slug); else echo base_url('p/'.$row->category_slug); ?>" class="catg-link">
                              <?php if(!empty($row->menu_icon) && file_exists('assets/uploads/backend/category_img/icon/'.$row->menu_icon)){ ?>
                                 <img src="<?php echo base_url().'assets/uploads/backend/category_img/icon/'.$row->menu_icon; ?>" class="catg-icon">
                              <?php } ?>
                              <?php echo ucwords($row->category_name); ?>
                           </a>
                           <span class="catg-toggle-icon">
                              <i class="icofont icofont-simple-down"></i>
                           </span>
                        </h4>
                        <div class="mega-menu" style="background-image: url('<?php echo base_url().'assets/uploads/backend/category_img/menu/'.$row->menu_image; ?>')">
                           <?php if(!empty(getMegamenu($row->category_id))){ foreach(getMegamenu($row->category_id) as $sub){ ?>
                           <div class="col-md-6 mega-menu-column">
                              <div class="menu-list">
                                 <h4 class="heading"><a href="<?php /*if($sub->subCategory) echo base_url($sub->category_slug); else*/ echo base_url('p/'.$sub->category_slug); ?>"><?php echo ucwords($sub->category_name); ?></a>
                                    <span class="toggle-menu-icon">
                                       <i class="icofont icofont-plus"></i>
                                    </span>
                                 </h4>
                                 <ul class="list-unstyled">
                                    <?php if(!empty(getMegamenu($sub->category_id))){ foreach(getMegamenu($sub->category_id) as $subCat){ ?>
                                    <li><a href="<?php /*if($subCat->subCategory) echo base_url($subCat->category_slug); else*/ echo base_url('p/'.$subCat->category_slug); ?>"><?php echo ucwords($subCat->category_name); ?></a></li>
                                    <?php } } ?>
                                 </ul>
                              </div>
                           </div>
                           <?php } } ?>                          
                        </div>
                     </li>
                     <?php } } ?>
                  </ul>
                  <!-- </div> -->
               </div>
               <nav class="theme-menu">
                  <div class="twelve columns filter-wrapper">
                      <ul class="list-inline no-margin nav-bar-filter" id="nav-bar-filter">
                        <?php if(!empty($headermenu) && !empty($headermenu['category'])){
                           foreach ($headermenu['category'] as $key => $value) {
                        ?>
                           <li class="nav-link <?php if($value->category_slug==$this->uri->segment(1)) echo 'active'; ?>">
                              <a href="<?php if($value->parent_id==0) echo base_url($value->category_slug); else echo base_url('p/'.$value->category_slug); ?>"><?php echo ucwords($value->category_name); ?>
                              </a>
                           </li>
                        <?php } } ?>
                      </ul>
                      <ul class="nav-link dropdown more-nav-dropdown" id="more-nav">
                          <li>
                           <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">More
                           <i class="fa fa-angle-down down-icon" aria-hidden="true"></i>
                           </button> 
                              <ul class="dropdown-menu more-nav-menu subfilter"></ul>
                          </li>
                      </ul>
                  </div>
               </nav>
            </div>
         </div>
      </div>
      <!-- ============== End Desktop Header Section =============== -->

      <!-- ============== Start Mobile Header Section =============== -->
      <div class="mobile-theme-header header-sticky">
         <div class="mobile-main-header">
            <div class="toggle-bar-icon">
               <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/menu-bar.svg" width="50">
            </div>
            <div class="mob-site-logo">
               <a href="<?php echo base_url(); ?>"><img src="<?php echo FRONTEND_THEME_URL ?>img/icons/copico-logo-white.png" width="150"></a>
            </div>
            <div class="mob-log-cart-wrap">
               <div class="mob-login-block">
                  <a href="<?php echo base_url('account/dashboard'); ?>">
                     <i class="icofont icofont-user-alt-5"></i>
                  </a>
               </div>
               <div class="mob-cart-block">
                  <a href="<?php echo base_url('cart/index'); ?>">
                     <img src="<?php echo FRONTEND_THEME_URL ?>img/shopping-bag-solid.svg" width="30">
                     <!-- <i class="icofont icofont-shopping-cart"></i> -->
                     <?php 
                        if($cartcount!='' && $cartcount!=0){ 
                     ?>
                        <div class="cart-count">
                           <span><?php echo $cartcount; ?></span>
                        </div>
                     <?php } ?>
                  </a>
               </div>
            </div>
         </div>
         <div class="mob-search-wrap">
            <form action="<?php echo base_url('p') ?>" method="get">
               <div class="mob-input-group">
                  <input type="text" class="form-control" id="searchPro1" name="key" placeholder="Search for a Product keywords or Category" value="<?php if(!empty($_GET['key'])) echo $_GET['key']; ?>">
                  <span class="mob-input-group-btn">
                     <button class="btn mob-btn-serach" type="submit">
                        <img src="<?php echo FRONTEND_THEME_URL ?>/img/icons/Icon_Search_Gray.svg" width="18">
                     </button>
                  </span>
               </div>
            </form>
         </div>
      </div>

      <div class="mob-left-toggle-wrapper">
         <div class="mob-toggle-section">
            <span class="close-toggle-btn toggle-bar-icon">
               <i class="icofont icofont-close"></i>
            </span>
            <div class="mob-toggle-section-inner">
               <div class="mob-user-info">
                  <span class="user-icon">
                     <img src="<?php echo FRONTEND_THEME_URL ?>/img/icons/user-in-circle.svg" width="30">
                  </span>
                  <div class="user-name-wrap">
                     <?php if(!empty(user_id())){ ?>
                     <div class="name">Hello,<br> <?php echo ucfirst(user_name()); ?></div>
                     <?php }else{ ?>
                     <div class="name">Hello,<br><a class="link-text" href="<?php echo base_url('page/login'); ?>">Login to <?php echo SITE_NAME; ?></a></div>
                     <?php } ?>
                  </div>
               </div>
               <div class="mob-dashboard-info clearfix">
                  <ul class="a-row mob-dashboard-list">
                     <li>
                        <a href="<?php echo base_url('account/dashboard'); ?>">
                           <div class="account-icon">
                              <img src="<?php echo FRONTEND_THEME_URL ?>/img/icons/dashboard-icons/speedometer-gray.svg" width="30">
                           </div>
                           <div class="mob-account-name">Dashboard</div>
                        </a>
                     </li>
                     <li>
                        <a href="<?php echo base_url('account/open_orders'); ?>">
                           <div class="account-icon">
                              <img src="<?php echo FRONTEND_THEME_URL ?>/img/icons/dashboard-icons/closed-cardboard-gray.svg" width="30">
                           </div>
                           <div class="mob-account-name">Your Orders</div>
                        </a>
                     </li>
                     <li>
                        <a href="<?php echo base_url('account/wish_list'); ?>">
                           <div class="account-icon">
                              <img src="<?php echo FRONTEND_THEME_URL ?>/img/icons/dashboard-icons/wishlist-gray.svg" width="30">
                           </div>
                           <div class="mob-account-name">Wishlist</div>
                        </a>
                     </li>
                     <?php if(!empty(user_id())){ ?>
                     <li>
                        <a href="<?php echo base_url('account/logout'); ?>">
                           <div class="account-icon">
                              <img src="<?php echo FRONTEND_THEME_URL ?>/img/icons/dashboard-icons/logout-or-send-gray.svg" width="30">
                           </div>
                           <div class="mob-account-name">Sign Out</div>
                        </a>
                     </li>
                     <?php }else{ ?>
                     <li>
                        <a href="<?php echo base_url('page/contact'); ?>">
                           <div class="account-icon">
                              <img src="<?php echo FRONTEND_THEME_URL ?>/img/icons/dashboard-icons/support-system-gray.svg" width="30">
                           </div>
                           <div class="mob-account-name">Contact Us</div>
                        </a>
                     </li>
                     <?php } ?>
                  </ul>
               </div>
               <div class="mob-categories-wrap">
                  <div class="heading">
                     Explore Categories
                  </div>
                  <div class="mob-catg-name-wrap">
                     <div class="mob-inner-catg">
                        <ul class="department-dropdown">
                           <?php  foreach(getMegamenu(0) as $row){ ?>
                           <li class="has-sub">
                              <h4 class="catg-link-block">
                                 <a href="<?php if($row->subCategory) echo base_url($row->category_slug); else echo base_url('p/'.$row->category_slug); ?>" class="catg-link">
                                    <img src="<?php echo base_url().'assets/uploads/backend/category_img/icon/'.$row->menu_icon; ?>" class="catg-icon"><?php echo ucwords($row->category_name); ?>
                                 </a>
                                 <span class="catg-toggle-icon">
                                    <i class="icofont icofont-simple-down"></i>
                                 </span>
                              </h4>
                              <div class="mega-menu" style="background-image: url('<?php echo base_url().'assets/uploads/backend/category_img/menu/'.$row->menu_image; ?>')">
                                 <?php foreach(getMegamenu($row->category_id) as $sub){ ?>
                                 <div class="col-md-6 mega-menu-column">
                                    <div class="menu-list">
                                       <h4 class="heading"><a href="<?php /*if($sub->subCategory) echo base_url($sub->category_slug); else*/ echo base_url('p/'.$sub->category_slug); ?>"><?php echo ucwords($sub->category_name); ?></a>
                                          <span class="toggle-menu-icon">
                                             <i class="icofont icofont-plus"></i>
                                          </span>
                                       </h4>
                                       <ul class="list-unstyled">
                                          <?php foreach(getMegamenu($sub->category_id) as $subCat){ ?>
                                          <li><a href="<?php /*if($subCat->subCategory) echo base_url($subCat->category_slug); else*/ echo base_url('p/'.$subCat->category_slug); ?>"><?php echo ucwords($subCat->category_name); ?></a></li>
                                          <?php } ?>
                                       </ul>
                                    </div>
                                 </div>
                                 <?php } ?>                          
                              </div>
                           </li>
                           <?php } ?>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- ============== End Mobile Header Section =============== -->
      <div class="body-container">
         <?php echo msg_alert(); ?>
      <!--class="body-container"  this used only for future page height managment -->
