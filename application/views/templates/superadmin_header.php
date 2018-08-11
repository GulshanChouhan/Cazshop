<?php  
   $main_segment  = $this->uri->segment(2); 
   $segment       = $this->uri->segment(3);
   $segment4      = $this->uri->segment(4); 
   
   if($segment=='dashboard') $dashboard='active'; else $dashboard='';

   if($main_segment=='category' || $main_segment=='attribute' || ($main_segment=='products' && ($segment=='variation_themes' || $segment=='add_variation_theme' || $segment=='edit_variation_theme'))) $catalog='active'; else $catalog='';
   if($main_segment=='category' && ($segment=='add_category' || $segment=='edit' || $segment=='index' || $segment=='add_subcategory' && $segment=='')) $Categories='active'; else $Categories='';
   if($main_segment=='attribute' && ($segment=='index' || $segment=='add' || $segment=='edit')) $Attributes='active'; else $Attributes='';
   if($main_segment=='category' && $segment=='brands' ) $brands='active'; else $brands='';

    if($main_segment=='fee' && ($segment=='index' || $segment='transaction')) $fee_preview='active'; else $fee_preview='';
    if($main_segment=='fee' && ($segment=='index' || $segment=='edit' || $segment='transaction')) $your_fee='active'; else $your_fee='';


   if($main_segment=='products' && ($segment=='variation_themes' || $segment=='add_variation_theme' || $segment=='edit_variation_theme')) $VariationTheme='active'; else $VariationTheme=''; ;

   if($main_segment=='products' && ($segment=='index' || $segment=='edit' || $segment=='product_basic_info' || $segment=='edit_product_basic_info' || $segment=='product_category' || $segment=='edit_product_category' || $segment=='product_variations' || $segment=='product_offer' || $segment=='product_other_info' || $segment=='product_images' || $segment=='product_descriptions' || $segment=='product_keywords' || $segment=='product_seo')) $Products='active'; else $Products='';
   
   if($main_segment=='products' && ($segment=='index' || $segment=='edit')) $View_Products='active'; else $View_Products='';
   if($main_segment=='products' && ($segment=='product_basic_info' || $segment=='product_category')) $Add_Product='active'; else $Add_Product='';

   if($main_segment=='orders' && ($segment=='order_details' || $segment=='index')) $manage_orders='active'; else $manage_orders='';
   if($main_segment=='orders' && $segment=='orders') $orders='active'; else $orders='';
   if($main_segment=='orders' && $segment=='open_orders') $open_orders='active'; else $open_orders='';
   if($main_segment=='orders' && $segment=='cancel_orders') $cancelled_orders='active'; else $cancelled_orders='';


   if($main_segment=='report' && ($segment=='orders' || $segment=='inventory')) $report='active'; else $report='';
   if($main_segment=='report' && $segment=='orders') $view_order_report='active'; else $view_order_report='';
   if($main_segment=='report' && $segment=='inventory') $view_inventory_report='active'; else $view_inventory_report='';


   if($main_segment=='user' && ($segment=='index' || $segment=='view')) $users='active'; else $users='';
   if($main_segment=='user' && (($segment=='index' || $segment=='view') && $segment4==1)) $view_sellers='active'; else $view_sellers='';
   if($main_segment=='user' && (($segment=='index' || $segment=='view') && $segment4==2)) $view_customers='active'; else $view_customers='';
   
   if($main_segment=='pages' || $main_segment=='slider') $Content_Management='active'; else $Content_Management='';
   if($main_segment=='pages' && ($segment=='index' || $segment=='add' || $segment=='edit')) $content_mgmt_staticPages='active'; else $content_mgmt_staticPages='';
   if($main_segment=='pages' && ($segment=='index' || $segment=='edit' ||$segment=='faq_sub_category')) $content_mgmt_staticPages_views='active'; else $content_mgmt_staticPages_views='';
   if($main_segment=='pages' && $segment=='add') $content_mgmt_staticPages_add='active'; else $content_mgmt_staticPages_add='';
   if($main_segment=='slider') $slider='active'; else $slider='';

   if($main_segment=='pages' && ($segment=='faq_category' || $segment=='faq' || $segment=='faq_add' || $segment=='faq_edit' ||$segment=='faq_sub_category_edit' || $segment=='category_add' ||$segment=='faq_category_edit'||$segment=='faq_sub_category_edit'|| $segment=='faq_sub_category')) $content_mgmt_FAQs='active'; else $content_mgmt_FAQs='';
   if($main_segment=='pages' && ($segment=='faq_category' ||$segment=='faq_sub_category_edit'||$segment=='category_add' || $segment=='faq_sub_category' ||$segment=='faq_category_edit')) $content_mgmt_FAQs_view='active'; else $content_mgmt_FAQs_view='';
   if($main_segment=='pages' && ($segment=='faq' || $segment=='faq_add' || $segment=='faq_edit')) $content_mgmt_FAQs_add='active'; else $content_mgmt_FAQs_add='';

   if($main_segment=='email_template' && ($segment=='email_templates' || $segment=='email_template_add' || $segment=='email_template_edit')) $email_template='active'; else $email_template='';
   if($main_segment=='email_template' && $segment=='email_template_add') $add_emailTemp='active'; else $add_emailTemp='';
   if($main_segment=='email_template' && $segment=='email_templates') $view_emailTemp='active'; else $view_emailTemp='';
   if($segment=='user_contactus' || $segment=='user_contactus_reply' || $main_segment=='notification') $contact_us='active'; else $contact_us='';
   
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <link rel="icon" type="image/png" href="<?php echo FRONTEND_THEME_URL; ?>img/cazshoppe_favicon.png"/>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="Mosaddek">
      <meta name="keyword" content="">
      <title><?php if(isset($title)){ echo ucfirst($title)." | "; } ?><?php echo SITE_NAME;?></title>
      <!-- Bootstrap core CSS -->
      <link href='https://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
      <link href="<?php echo BACKEND_THEME_URL ?>css/bootstrap.min.css" rel="stylesheet">
      <link href="<?php echo BACKEND_THEME_URL ?>css/bootstrap-reset.css" rel="stylesheet">
      <link rel="stylesheet" href="<?php echo BACKEND_THEME_URL ?>css/bootstrap-datetimepicker.min.css" />
      <!--external css-->
      <link href="<?php echo BACKEND_THEME_URL ?>plugin/font-awesome/css/font-awesome.css" rel="stylesheet" />
      <link href="<?php echo BACKEND_THEME_URL ?>plugin/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
      <link rel="stylesheet" href="<?php echo BACKEND_THEME_URL ?>css/owl.carousel.css" type="text/css">
      <!-- Custom styles for this template -->
      <link href="<?php echo BACKEND_THEME_URL ?>css/style.css" rel="stylesheet">
      <link href="<?php echo BACKEND_THEME_URL ?>css/style-responsive.css" rel="stylesheet" />
      <link href="<?php echo BACKEND_THEME_URL; ?>css/sweetalert.css" rel="stylesheet" type="text/css"/>
      
      <link rel="stylesheet" type="text/css" media="all" href="<?php echo BACKEND_THEME_URL ?>css/easyzoom.css">
      <script src="<?php echo BACKEND_THEME_URL ?>js/jquery.js"></script>
      <!--fancy box -->
      <link href="<?php echo BACKEND_THEME_URL ?>css/rating.css" rel="stylesheet">
      <link href="<?php echo BACKEND_THEME_URL ?>css/jasny-bootstrap.min.css" rel="stylesheet">
      <link href="<?php echo SELLER_THEME_URL; ?>css/cryptofont.min.css" rel="stylesheet">
      <link rel="stylesheet" href="<?php echo BACKEND_THEME_URL ?>font-awesome/css/font-awesome.min.css">
      <script src="<?php echo BACKEND_THEME_URL; ?>js/sweetalert.js" type="text/javascript"></script>
      <script src="<?php echo BACKEND_THEME_URL ?>js/rating.js"></script>
      <script src="<?php echo base_url(); ?>assets/backend/admin/js/notify.min.js"></script>
      <script src="<?php echo BACKEND_THEME_URL; ?>js/moment.min.js"></script>  
      <script src="<?php echo BACKEND_THEME_URL; ?>js/bootstrap-datetimepicker.min.js"></script>   

      <script>
         SITE_URL = "<?php echo base_url(); ?>";
      </script>
      <style>
         .form-group .col-md-9{
            margin-top: 8px;
         }
      </style>
   </head>
   <body>
      <section id="container" >
      <!--header start-->
      <header class="header">
         <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2 no-padding">
            <div class="sidebar-toggle-box">
               <div data-original-title="Toggle Navigation" data-placement="right" class="icon-reorder tooltips"></div>
            </div>
            <!--logo start-->
            <a href="<?php echo base_url('backend/superadmin')?>" class="logo">caz<span>shop</span></a>
            <!--logo end-->
         </div>
         <!-- <div class="col-md-8 col-lg-8"> -->
         <div class="top-nav col-md-10 col-lg-10 col-sm-10 col-xs-10">
            <div class="col-md-10 col-lg-10 col-sm-8 col-xs-8 padding-left">
               <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button>
               <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <div class="nav notify-row yamm" id="top_menu">
                     <!--  notification start -->
                     <!--  notification end -->
                  </div>
               </div>
            </div>
            <!--search & user info start-->
            <div class="col-md-2 col-lg-2 col-sm-4 col-xs-4 no-padding">
               <ul class="nav pull-right ">
                  <li class="dropdown">
                     <a data-toggle="dropdown" class="dropdown-toggle admin-logout" href="#">
                     <img alt="" src="<?php echo BACKEND_THEME_URL ?>images/favicon.ico" style="width: 18px;">
                     <span class="username" style="vertical-align: middle;"><?php echo ucwords(superadmin_name()); ?></span>
                     <b class="caret"></b>
                     </a>
                     <ul class="dropdown-menu extended logout">
                        <div class="log-arrow-up"></div>
                        <li><a href="<?php echo base_url()?>" target="_blank"><i class="fa fa-globe" aria-hidden="true"></i>Go to the Website</a></li>
                        <li><a href="<?php echo base_url()?>backend/superadmin/profile"><i class="fa fa-user"></i>My Profile</a></li>
                        <li><a href="<?php echo base_url()?>backend/superadmin/change_password"><i class="fa fa-key"></i>Change Password</a></li>
                        <li><a href="<?php echo base_url()?>backend/superadmin/logout"><i class="fa fa-sign-out"></i> Log Out</a></li>
                     </ul>
                  </li>
                  <!-- user login dropdown end -->
               </ul>
               <!--search & user info end-->
            </div>
         </div>
      </header>
      <!--header end-->
      <!--sidebar start-->
      <aside>
         <div id="sidebar"  class="nav-collapse ">
            <!-- sidebar menu start-->
            <ul class="sidebar-menu" id="nav-accordion">
               <li>
                  <a class="<?php echo $dashboard ?>" href="<?php echo base_url('backend/superadmin/dashboard') ?>">
                  <i class="icon-dashboard"></i>
                  <span>Dashboard</span>
                  </a>
               </li>
               
                <li class="sub-menu dcjq-parent-li">
                  <a  href="javascript:;" class="<?php echo $users; ?>">
                  <i class="fa fa-users" aria-hidden="true"></i>
                  <span>Manage Users</span>
                  </a>
                  <ul class="sub">
                     <li class="sub-menu">
                        <a class="<?php echo $view_sellers; ?>"  href="<?php echo base_url('backend/user/index/1') ?>" >  <i class="fa fa-list" aria-hidden="true"></i>List Of Sellers</a>
                     </li>

                     <li class="sub-menu">
                        <a class="<?php echo $view_customers; ?>"  href="<?php echo base_url('backend/user/index/2') ?>" > <i class="fa fa-list" aria-hidden="true"></i>List Of Customers</a>
                     </li>

                  </ul>
               </li>


              

               <li class="sub-menu dcjq-parent-li">
                  <a  href="javascript:;" class="<?php echo $catalog; ?>">
                  <i class="icon-bar-chart"></i>
                  <span>Manage Catalog</span>
                  </a>
                  <ul class="sub">

                     <li class="sub-menu"><a class="<?php echo $Categories; ?>"  href="<?php echo base_url('backend/category/index') ?>" ><i class="fa fa-sitemap" aria-hidden="true"></i> Product Categories</a></li>

                     <li class="<?php echo $Attributes; ?>"><a href="<?php echo base_url(); ?>backend/attribute/index"><i class="fa fa-sun-o"></i>List Of Attributes</a></li>

                     <li class="<?php echo $VariationTheme; ?>"><a href="<?php echo base_url(); ?>backend/products/variation_themes"><i class="fa fa-upload" aria-hidden="true"></i> Variation Themes</a></li>

                     <li class="<?php echo $brands; ?>"><a href="<?php echo base_url(); ?>backend/category/brands"><i class="fa fa-dribbble" aria-hidden="true"></i> Brands</a></li>  
                      
                  </ul>
               </li>

               <li class="sub-menu dcjq-parent-li">
                  <a  href="javascript:;" class="<?php echo $manage_orders; ?>">
                  <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                  <span>Manage Orders</span>
                  </a>
                  <ul class="sub">
                     <?php 
                        $orderStatusPages = orderStatusDD();
                        foreach ($orderStatusPages as $key => $value) {
                     ?> 
                     <li class="sub-menu">
                        <a class="<?php if($segment4==$key) echo "active"; ?>"  href="<?php echo base_url('backend/orders/index/'.$key); ?>" >  <i class="fa fa-list" aria-hidden="true"></i> <?php echo $value; ?></a>
                     </li>
                     <?php } ?>
                     <li class="sub-menu">
                        <a class="active" href="<?php echo base_url('backend/orders/index/'); ?>" >  <i class="fa fa-list" aria-hidden="true"></i>All Orders</a>
                     </li>
                  </ul>
               </li>

               <li class="sub-menu dcjq-parent-li">
                  <a  href="javascript:;" class="<?php echo $report; ?>">
                  <i class="fa fa-download" aria-hidden="true"></i>
                  <span>Manage Reports</span>
                  </a>
                  <ul class="sub">
                     <li class="sub-menu">
                        <a class="<?php echo $view_order_report; ?>"  href="<?php echo base_url('backend/report/orders') ?>" >  <i class="fa fa-shopping-cart" aria-hidden="true"></i> Order Report</a>
                     </li>

                     <li class="sub-menu">
                        <a class="<?php echo $view_inventory_report; ?>"  href="<?php echo base_url('backend/report/inventory') ?>" > <i class="fa fa-cube" aria-hidden="true"></i> Inventory Report</a>
                     </li>

                  </ul>
               </li>

               <li class="sub-menu dcjq-parent-li">
                  <a  href="javascript:;" class="<?php echo $Products; ?>">
                  <i class="fa fa-cubes" aria-hidden="true"></i>
                  <span>Manage Products</span>
                  </a>
                  <ul class="sub">
                     <li class="sub-menu">
                        <a class="<?php echo $View_Products; ?>"  href="<?php echo base_url('backend/products/index') ?>" >  <i class="fa fa-list" aria-hidden="true"></i> List Of Products</a>
                     </li>
                  </ul>
               </li>

               <li class="sub-menu dcjq-parent-li">
                  <a  href="javascript:;" class="<?php echo $fee_preview; ?>">
                  <i class="fa fa-money" aria-hidden="true"></i>
                  <span>Fee Preview</span>
                  </a>
                  <ul class="sub">
                     <li class="sub-menu">
                        <a class="<?php echo $your_fee; ?>"  href="<?php echo base_url('backend/fee/index') ?>" >  <i class="fa fa-user"></i> Your Fee</a>
                     </li>
                 </ul>
               </li>   

               <li class="sub-menu dcjq-parent-li">
                  <a  href="javascript:;" class="<?php echo $Content_Management; ?>">
                  <i class="fa fa-desktop" aria-hidden="true"></i>
                  <span>Content Management</span>
                  </a>
                  <ul class="sub">
                     <li class="sub-menu">
                        <a class="<?php echo $content_mgmt_staticPages ?>" href="javascript:;"> <i class="fa fa-file"></i> Static Pages</a>
                        <ul class="sub">
                           <li><a class="<?php echo $content_mgmt_staticPages_views ?>" href="<?php echo base_url('backend/pages/index') ?>"><i class="icon-list-ol"></i>List Of Pages</a></li>
                           <li><a class="<?php echo $content_mgmt_staticPages_add ?>" href="<?php echo base_url('backend/pages/add') ?>"><i class="icon-plus"></i>Add Page</a></li>
                        </ul>
                     </li>
                     <li class="sub-menu">
                        <a  class="<?php echo $content_mgmt_FAQs ?>" href="javascript:;"> <i class="fa fa-question"></i> FAQs</a>
                        <ul class="sub">
                           <li><a class="<?php echo $content_mgmt_FAQs_view ?>" href="<?php echo base_url('backend/pages/faq_category') ?>"><i class="icon-list-ol"></i>FAQs Categories</a></li>
                           <li><a class="<?php echo $content_mgmt_FAQs_add ?>"  href="<?php echo base_url('backend/pages/faq') ?>"><i class="icon-list-ol"></i>List Of FAQs</a></li>
                        </ul>
                     </li>
                     <li>
                        <a class="<?php echo $slider; ?>" href="<?php echo base_url('backend/slider') ?>"><i class="fa fa-cogs"></i>HomePage Banners</a>
                     </li>   
                  </ul>
               </li>

               <li class='sub-menu' >
                  <a href="javascript:;" class="<?php echo $contact_us; ?>" >     
                  <i class="icon-phone-sign"></i>
                  <span class="title">Notification / Support</span>
                  </a>
                  <ul class="sub">
                     <li><a href="<?php echo base_url() ?>backend/support/user_contactus"> <i class="icon-phone"></i> Support</a>
                     </li>
                 <!--    <li><a href="javascript:void(0);"> <i class="icon-envelope"></i> Notification</a>
                     </li>-->
                  </ul>
               </li>

               <li class="sub-menu">
                  <a  href="javascript:;" class="<?php echo $email_template ?>">
                  <i class="icon-envelope"></i>
                  <span>Email & SMS Template</span>
                  </a>
                  <ul class="sub">
                     <li class="sub-menu">
                        <a class="<?php echo $view_emailTemp ?>" href="<?php echo base_url('backend/email_template/email_templates') ?>"><i class="icon-list-ol"></i>Email & SMS Template</a>
                     </li>
                     <li class="sub-menu">
                        <a class="<?php echo $add_emailTemp ?>"  href="<?php echo base_url('backend/email_template/email_template_add') ?>"><i class="icon-plus"></i>Add Email & SMS Template</a>
                     </li>
                  </ul>
               </li>

               <li>
                  <a class="<?php if($main_segment=='settings') echo 'active'; ?>" href="<?php echo base_url('backend/settings') ?>"><i class="fa fa-cogs"></i>Settings</a>
               </li>
               <!--multi level menu end-->
            </ul>
            <!-- sidebar menu end-->
         </div>
      </aside>
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
         <section class="wrapper">
         <!-- page start-->
         <div class="row">
            <div class="col-lg-12">
            <?php msg_alert(); ?>  
               <section class="panel">