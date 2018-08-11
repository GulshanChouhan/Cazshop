<?php
   $segment1 = $this->uri->segment(1);
   $segment2 = $this->uri->segment(2);
   $segment3 = $this->uri->segment(3);
   $segment4 = $this->uri->segment(4);

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title><?php echo ucfirst($title); ?> | <?php echo SITE_NAME ?></title>
      <link rel="icon" type="image/png" href="<?php echo FRONTEND_THEME_URL; ?>img/cazshoppe_favicon.png"/>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- Navigation -->
      <!-- Bootstrap Core CSS -->
      <link href="<?php echo SELLER_THEME_URL; ?>css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="<?php echo BACKEND_THEME_URL; ?>css/bootstrap-datetimepicker.min.css" />
      <!-- Custom CSS -->
      <link href="<?php echo SELLER_THEME_URL; ?>css/modern-business.css" rel="stylesheet">
      <link href="<?php echo SELLER_THEME_URL; ?>css/style.css" rel="stylesheet">
      <!-- Custom Fonts -->
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,500,600,700" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,600,700" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="<?php echo FRONTEND_THEME_URL ?>css/font-awesome.min.css">
      <link href="<?php echo FRONTEND_THEME_URL; ?>css/icofont.css" rel="stylesheet">
      <link href="<?php echo SELLER_THEME_URL; ?>css/cryptofont.min.css" rel="stylesheet">
      <link href="<?php echo BACKEND_THEME_URL; ?>plugin/font-awesome/css/font-awesome.css" rel="stylesheet" />
      <link rel="stylesheet" href="<?php echo FRONTEND_THEME_URL;?>css/chosen.css">
      <script src="<?php echo base_url(); ?>assets/backend/admin/js/jquery.js"></script>
      <script src="<?php echo base_url(); ?>assets/backend/admin/js/notify.min.js"></script>
      <script src="<?php echo BACKEND_THEME_URL; ?>js/moment.min.js"></script>  
      <script src="<?php echo BACKEND_THEME_URL; ?>js/bootstrap-datetimepicker.min.js"></script>
      <link href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700" rel="stylesheet">
      <link href="<?php echo FRONTEND_THEME_URL ?>css/animate.min.css" rel="stylesheet">
      <script src="<?php echo FRONTEND_THEME_URL ?>js/wow.min.js" type="text/javascript"></script>
      <script>
         SITE_URL = "<?php echo base_url(); ?>";
      </script>
      <style>
         input::-webkit-input-placeholder {
             font-size: 12px;
         }
      </style>
   </head>
   <body class="theme-background" id="scrollbar-design">
      <nav class="navbar navbar-inverse navbar-fixed-top row" role="navigation">
         <div class="container-fluid">
            <div class="col-md-12">
               <!-- Brand and toggle get grouped for better mobile display -->
               <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="<?php echo base_url('seller/dashboard'); ?>"><img src="<?php echo SELLER_THEME_URL; ?>/img/copico-logo-white.png"><span>SELLER CENTRAL</span></a>
               </div>
               <!-- Collect the nav links, forms, and other content for toggling -->
               <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav navbar-right">
                  
                  <?php if(empty(seller_id())){ ?>

                     <li class="dropdown custom-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Account </a>
                        <ul class="dropdown-menu custom-dropdown-menu">
                           <li><a href="<?php echo base_url('seller/login'); ?>">Sign In</a></li>
                           <li><a href="<?php echo base_url('seller/register'); ?>">Sign Up</a></li>
                        </ul>
                     </li>

                  <?php }else{ ?>

                     <li><a style="cursor: text;" href="javascript:void(0)"><i class="fa fa-user" aria-hidden="true"></i> Welcome <?php echo ucwords(selleradmin_name()); ?>
                        <span class="sc-nav-arrow"></span>
                     </a></li>

                     <?php 
                        $getAccessToken = getAccessToken(seller_id());
                        if($getAccessToken){
                     ?>

                     <li class="dropdown custom-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Catalogue
                           <span class="sc-nav-arrow"></span>
                        </a>
                        <ul class="dropdown-menu custom-dropdown-menu">
                           <li><a href="<?php echo base_url('seller/products/product_category'); ?>">Add a Product</a></li>
                           <li><a href="<?php echo base_url('seller/products/mydraft'); ?>">Drafts</a></li>
                        </ul>
                     </li>

                     <li class="dropdown custom-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Inventory 
                           <span class="sc-nav-arrow"></span>
                        </a>
                        <ul class="dropdown-menu custom-dropdown-menu">
                           <li><a href="<?php echo base_url('seller/products/index'); ?>">Manage Inventory</a></li>
                           <!-- <li><a href="javascript:void(0)">Inventory Planning</a></li> -->
                           <li><a href="<?php echo base_url('seller/products/product_category'); ?>">Add a Product</a></li>
                            <li><a href="<?php echo base_url('seller/products/managePricing'); ?>">Manage Pricing</a></li>
                           <!-- <li><a href="javascript:void(0)">Inventory Reports</a></li> -->
                        </ul>
                     </li>


                     <?php if(site_access()===TRUE){ ?>
                     <li class="dropdown custom-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Orders 
                           <span class="sc-nav-arrow"></span>
                        </a>
                        <ul class="dropdown-menu custom-dropdown-menu">
                           <li><a href="<?php echo base_url('seller/orders/index'); ?>">Manage Orders</a>
                           </li>
                           <li><a href="<?php echo base_url('seller/orders/payout_history?order_status=&paid_status=1'); ?>">Payout History</a>
                           </li>
                        </ul>
                     </li>


                     <li class="dropdown custom-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Reports 
                           <span class="sc-nav-arrow"></span>
                        </a>
                        <ul class="dropdown-menu custom-dropdown-menu">
                           <li><a href="<?php echo base_url('seller/report/orders'); ?>">Orders Report</a>
                           </li>

                           <li><a href="<?php echo base_url('seller/report/inventory'); ?>">Inventory Report</a>
                           </li>
                        </ul>
                     </li>
                     <?php } ?>

                     <li class="dropdown custom-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Support 
                           <span class="sc-nav-arrow"></span>
                        </a>
                        <ul class="dropdown-menu custom-dropdown-menu">
                           <li><a href="<?php echo base_url('seller/support/messages'); ?>">In Process</a></li>
                           <li><a href="<?php echo base_url('seller/support/complete_tickets'); ?>">Completed Tickets</a></li>
                        </ul>
                     </li>

                     <li class="dropdown custom-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> My Account 
                           <span class="sc-nav-arrow"></span>
                        </a>
                        <ul class="dropdown-menu custom-dropdown-menu">
                           <?php if(site_access()===TRUE){ ?>
                           <li><a href="<?php echo base_url(); ?>" target="_blank">Go to the Website</a></li>
                           <li><a href="<?php echo base_url('seller/country_rates'); ?>">Shipping Rates</a></li>
                           <?php } ?>
                           <li><a href="<?php echo base_url('seller/profile'); ?>">My Profile</a></li>
                           <li><a href="<?php echo base_url('seller/change_password'); ?>">Change Password</a></li>
                           <li><a href="<?php echo base_url('seller/seller_dashboard/'.base64_encode(seller_id())); ?>">Primary Details</a></li>
                           <li><a href="<?php echo base_url('seller/logout'); ?>">Log Out</a></li>
                        </ul>
                     </li>

                  <?php }else{ ?>

                     <li class="dropdown custom-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> My Account 
                           <span class="sc-nav-arrow"></span>
                        </a>
                        <ul class="dropdown-menu custom-dropdown-menu">
                           <li><a href="<?php echo base_url('seller/logout'); ?>">Log Out</a></li>
                        </ul>
                     </li>

                  <?php } } ?>

                  </ul>
               </div>
               <!-- /.navbar-collapse -->
            </div>
         </div>
         <!-- /.container -->
      </nav>
         <?php msg_alert(); ?>