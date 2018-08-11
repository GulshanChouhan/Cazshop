<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="icon" type="image/png" href="<?php echo FRONTEND_THEME_URL; ?>img/cazshoppe_favicon.png"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name='viewport'/>
    <title><?php echo $title.' | '.SITE_NAME; ?></title>
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
    <!-- ============== End Desktop Header Section =============== -->
    <section class="login-pages account-page">
      <div class="modal-block container-fluid">
        <div class="text-center">
          <h1 class="heading">Welcome to <?php echo SITE_NAME; ?></h1>
          <h3 class="sub-heading">New Ways to Choose Your Product and Ignore the Rest</h3>
        </div>
        <div class="join-now-container1">
          <div class="">
            <div class="col-sm-6 center-block">
              <div class="login-wrapper">
                <div class="login-head">
                  <h2>Forgot Password ?</h2>
                  <p>Enter the email address associated with your <?php echo SITE_NAME; ?> account.</p>
                </div>
                <form id="forgotform" method="POST" class="account-from" data-bvalidator-validate>
                  <?php msg_alert(); ?>
                  <div class="form-group">
                    <label for="Email">Email Address <span class="mandatory">*</span></label>
                    <input type="text" class="form-control" name="email" value="<?php echo set_value('email'); ?>" placeholder="john@example.com" data-bvalidator="required,email" data-bvalidator-msg="Please enter your registered email address">
                      <?php echo form_error('email'); ?>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-red btn-block">Continue</button>
                  </div>
                  <div class="already-account-link">
                    <p>If you have remember? <a href="<?php echo base_url('page/login'); ?>" class="sign-in-link">Sign in <i class="icofont icofont-caret-right"></i></a></p>
                  </div>
                  <div class="forgot-bottom-wrapper">
                    <h3>Has your email address changed?</h3>
                    <p>If you no longer use the e-mail address associated with your <?php echo SITE_NAME; ?> account, you may contact <a href="<?php echo base_url('page/contact'); ?>">Customer Service</a> for help restoring access to your account.</p>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="bold-border"></div>
      <div class="container-fluid">
        <div class="footer-top-bar fix-row clearfix">
          <div class="text-center copy-right">
            <p class=""><a class="view-more" href="<?php echo base_url('page/privacy-policy'); ?>">Privacy Policy</a> - <a class="view-more" href="<?php echo base_url('page/terms-and-condition'); ?>" rel="nofollow"> Terms of Use</a> © <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved. </p>
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
    </section>
    <script>
    SITE_URL = "<?php echo base_url(); ?>";
    $(document).ready(function(){
    $('#loginform').bValidator();
    });
    </script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>validator/bvalidator/jquery.bvalidator.js"></script>
    <script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>validator/bvalidator/themes/presenters/default.min.js"></script>
    <script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>validator/bvalidator/themes/gray/gray.js"></script>
    <link href="<?php echo BACKEND_THEME_URL ?>validator/bvalidator/themes/gray/gray.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo FRONTEND_THEME_URL ?>js/bootstrap.min.js"></script>
    <script src="<?php echo BACKEND_THEME_URL; ?>js/sweetalert.js" type="text/javascript"></script>
    <script src="<?php echo FRONTEND_THEME_URL ?>js/jquery.stickr.min.js" type="text/javascript"></script>
    <script src="<?php echo FRONTEND_THEME_URL ?>js/theme-script.js" type="text/javascript"></script>
    
    <script>
    SITE_URL = "<?php echo base_url(); ?>";
    $(document).ready(function(){
    $('#signupform').bValidator();
     $('#form_valid').bValidator();
    });
    </script>
    <script type="text/javascript">
    //    tool tips
    $('.tooltips').tooltip();
    //    popovers
    $('.popovers').popover();
    </script>
    <script>
    function confirmBox(msg,url){
    swal({
    customClass:'swal-custom-modal-box',
    title: msg,
    padding: 0,
    showCloseButton: true,
    showCancelButton: true,
    focusConfirm: false,
    background:'#f1f1f1',
    buttonsStyling: false,
    confirmButtonClass:'btn btn-confirm',
    cancelButtonClass:'btn btn-cancle',
    confirmButtonText:'Ok',
    cancelButtonText:'Cancel',
    animation:false
    }, function() {
    window.location.href = url;
    });
    }
    function check_email_exists_footer() {
    var email = $("#emailfooter").val();
    $.ajax({
    type:"post",
    url: "<?php echo base_url(); ?>page/email_exists",
    data:{ email:email},
    success:function(response)
    {
    //alert(response);
    if (response ==1)
    {
      warningMsg("This email is already registered");
      return false;
    }
    }
    });
    }
    </script>
  </body>
</html>