</div>
<!--class="body-container" Closed, this used only for future page height managment -->
<footer class="theme-footer">
    <div class="theme-container cmsinfo-container-wrap">
        <div class="row">
            <div class="cmsinfo-wrapper clearfix">
                <div class="col-xs-6 col-md-4 cmsinfo_block">
                    <div class="item">
                        <h4 class="icon-truck">CAZCOIN</h4>
                        <p>Pay with Cazcoin</p>
                        <!--  <i class="icofont icofont-truck-loaded"></i> -->
                        <img class="icofont" src="<?php echo FRONTEND_THEME_URL ?>img/footer-icon/cazcoinlogo.png" width="">
                    </div>
                </div>
                <div class="col-xs-6 col-md-4 cmsinfo_block">
                    <div class="item">
                        <h4 class="icon-cash-dollar">BITCOIN</h4>
                        <p>Pay with Bitcoin</p>
                        <!-- <i class="icofont icofont-cur-bitcoin"></i> -->
                        <img class="icofont" src="<?php echo FRONTEND_THEME_URL ?>img/footer-icon/Bitcoin-logo.png" width="">
                    </div>
                </div>
                <div class="col-xs-6 col-md-4 cmsinfo_block">
                    <div class="item ethrm">
                        <h4 class="icon-gift">Ethereum</h4>
                        <p>Pay with Ethereum</p>
                        <!-- <i class="icofont icofont-gift"></i> -->
                        <img class="icofont" src="<?php echo FRONTEND_THEME_URL ?>img/footer-icon/ethereum-circle-logo.png" width="">
                    </div>
                </div>
                <div class="col-xs-6 col-md-4 cmsinfo_block">
                    <div class="item">
                        <h4 class="icon-phone-in-out">Litecoin</h4>
                        <p>Pay with Litecoin</p>
                        <!-- <i class="icofont icofont-telephone"></i> -->
                        <img class="icofont" src="<?php echo FRONTEND_THEME_URL ?>img/footer-icon/litecoin.png" width="">
                    </div>
                </div>
                <div class="col-xs-6 col-md-4 cmsinfo_block">
                    <div class="item">
                        <h4 class="icon-users2">Paypal</h4>
                        <p>Pay with Paypal</p>
                        <!-- <i class="icofont icofont-users-alt-3"></i> -->
                        <img class="icofont" src="<?php echo FRONTEND_THEME_URL ?>img/footer-icon/paypal-circle-icon.png" width="">
                    </div>
                </div>
            </div>
            <div class="divide-line"></div>
        </div>
    </div>

    <div class="theme-container">

        <div class="row">
            <!-- row -->

            <div class="col-sm-4 col-lg-3 col-md-3 footer-widget-block policy-information-widget">
                <!-- widgets -->
                <div class="list-unstyled clear-margins">
                    <!-- widgets -->
                    <div class="footer-widget">
                        <!-- widgets list -->
                        <h1 class="title">Policy Information</h1>
                        <ul class="list-unstyled link-list">
                            <li><a href="<?php echo base_url('page/privacy-policy'); ?>" class="widget-link"> Privacy Policy</a></li>
                            <li><a href="<?php echo base_url('page/terms-and-condition'); ?>" class="widget-link"> Terms and Condition</a></li>
                            <li><a href="<?php echo base_url('page/cancellation-and-returns'); ?>" class="widget-link"> Cancellation & Returns</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- widgets end -->

            <div class="col-sm-4 col-lg-3 col-md-3 footer-widget-block help-you-widget">
                <!-- widgets -->
                <div class="list-unstyled clear-margins">
                    <!-- widgets -->
                    <div class="footer-widget">
                        <!-- widgets list -->
                        <h1 class="title">Let Us Help You</h1>
                        <ul class="list-unstyled link-list">
                            <li><a href="<?php echo base_url('page/login'); ?>" class="widget-link"> Your Account</a></li>
                            <li><a target="_blank" href="<?php echo base_url('seller/login'); ?>" class="widget-link"> Sell on 
                            <?php echo ucwords(SITE_NAME); ?></a></li>
                            <!-- <li><a href="javascript:void(0)" class="widget-link"> Track your order</a></li> -->
                            <li><a href="<?php echo base_url('page/faq'); ?>" class="widget-link"> FAQs</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- widgets end -->

            <div class="col-sm-4 col-lg-3 col-md-3 footer-widget-block know-us-widget">
                <!-- widgets -->
                <div class="list-unstyled clear-margins">
                    <!-- widgets -->
                    <div class="footer-widget">
                        <!-- widgets list -->
                        <h1 class="title">Get to Know Us</h1>
                        <ul class="list-unstyled link-list">
                            <li><a href="<?php echo base_url('page/aboutus'); ?>" class="widget-link"> About Us</a></li>
                            <li><a href="<?php echo base_url('page/how_it_work'); ?>" class="widget-link"> How it works</a></li>
                            <li><a href="<?php echo base_url('page/contact'); ?>" class="widget-link"> Contact Us</a></li>
                            <li><a href="javascript:void(0)" class="widget-link"> Sitemap</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- widgets end -->

            <div class="col-sm-4 col-lg-3 col-md-3 footer-widget-block stay-connected-widget">
                <!-- widgets -->
                <div class="list-unstyled clear-margins">
                    <!-- widgets -->
                    <div class="footer-widget">
                        <!-- widgets list -->
                        <h1 class="title">Stay Connected</h1>
                        <div class="footer-address-section">
                            <ul class="list-unstyled link-list">
                                <li class="email-id">
                                    <a href="<?php echo 'mailto:'.get_option_url('EMAIl'); ?>">
                                        <?php echo get_option_url('EMAIl'); ?>
                                    </a>
                                    <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/close-envelope.svg" width="16">
                                </li>
                                <!-- <li class="phone-no">
                                    <a href="<?php echo 'tel:'.get_option_url('PHONE'); ?>">
                                        <?php echo get_option_url('PHONE'); ?>
                                    </a>
                                    <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/phone-receiver.svg" width="16">
                                </li> -->
                                <li class="subscription">
                                    <form method="post" id="emailSubscriptionForm" action="/" data-bvalidator-validate>
                                        <div class="input-group">
                                            <input aria-describedby="basic-addon2" class="form-control" name="email" id="emailfooter" placeholder="Email address" type="text" value="" data-bvalidator="required,email">
                                            <?php echo form_error('email'); ?>
                                            <input aria-describedby="basic-addon2" class="form-control" name="subscription_type" id="subscription_type" type="hidden" value="1">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" id="btnsubmit" type="submit">Join</button>
                                            </span>
                                        </div>
                                        <div id="errormsgshow"></div>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        <div class="footer-social-media">
                            <ul class="list-unstyled link-list">
                                <li>
                                    <a target="_blank" href="<?php echo get_option_url('FACEBOOK_URL'); ?>" title="Facebook">
                                        <i class="fa fa-facebook" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li>
                                    <a target="_blank" href="<?php echo get_option_url('TWITTER_URL'); ?>" title="twitter">
                                        <i class="fa fa-twitter" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li>
                                    <a target="_blank" href="<?php echo get_option_url('INSTAGRAM_URL'); ?>" title="instagram">
                                        <i class="fa fa-instagram" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li>
                                    <a target="_blank" href="<?php echo get_option_url('PINTEREST_URL'); ?>" title="pinterest">
                                        <i class="fa fa-pinterest" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li>
                                    <a target="_blank" href="<?php echo get_option_url('RSS_URL'); ?>" title="Rss">
                                        <i class="fa fa-rss" aria-hidden="true"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- widgets end -->

        </div>

        <?php 
            if(current_url()==base_url() || current_url()==base_url('index.php')){ 
                $footerDescription = getRow("pages", array("slug"=>"footer-site-description", "status"=>1));
                if(!empty($footerDescription)){
                    echo $footerDescription->description;
                }                
            } 
        ?>
        <div class="footer-bottom">
           <!--  <div class="copyright">
                
                <div class="strip-img">
                    <div class="cripto-price">
                        <span class="bitcoin" title="Bitcoin">
                            <img src="<?php echo FRONTEND_THEME_URL ?>/img/icons/bitcoin35.svg">
                        </span>
                        <span class="ethereum" title="Ethereum">
                            <img src="<?php echo FRONTEND_THEME_URL ?>/img/icons/ethereum35.svg">
                        </span>                     
                    </div>
                </div> 
            </div>-->
            <div class="design-by text-center">
                <span><?php echo date('Y'); ?> &copy; <?php echo ucwords(SITE_NAME); ?> All Rights Reserved.</span>&nbsp;|&nbsp;
                <span>Designed &amp; Developed By <a href="http://www.chapter247.com/" target="_blank"><img src="<?php echo base_url(); ?>/assets/frontend/img/chapter_logo.png"></a></span>
            </div>
        </div>
    </div>
    <a id="back_top" href="#">
        <i class="fa fa-angle-up" aria-hidden="true"></i>
    </a>
</footer>
<!--header-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>validator/bvalidator/jquery.bvalidator.js"></script>
<script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>validator/bvalidator/themes/presenters/default.min.js"></script>
<script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>validator/bvalidator/themes/gray/gray.js"></script>
<link href="<?php echo BACKEND_THEME_URL ?>validator/bvalidator/themes/gray/gray.css" rel="stylesheet" type="text/css" />
<script src="<?php echo FRONTEND_THEME_URL ?>js/bootstrap.min.js"></script>
<script src="<?php echo BACKEND_THEME_URL; ?>js/sweetalert.js" type="text/javascript"></script>
<script src="<?php echo FRONTEND_THEME_URL ?>js/jquery.stickr.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/seller/js/custom.js" type="text/javascript"></script>
<script src="<?php echo FRONTEND_THEME_URL ?>js/wow.min.js" type="text/javascript"></script>
<script type="text/javascript">
    /*$(document).ready(function () {
      setInterval(function() {
        $('.alert').fadeOut('slow');
      }, 10000);
    });*/
</script>
<script type="text/javascript">
      var wow = new WOW(
        {
          boxClass:     'wow',  
          animateClass: 'animated', 
          offset:       0,         
          mobile:       false,    
          live:         true,    
          callback:     function(box) {

          },
          scrollContainer: null
        }
      );
      wow.init();
</script>
<script>
    SITE_URL = "<?php echo base_url(); ?>";

    $(document).ready(function() {
        $('#signupform').bValidator();
        $('#emailSubscriptionForm').bValidator();

    });
    $("#btnsubmit").click(function() {
        $('#emailSubscriptionForm').bValidator();

        if($('#emailSubscriptionForm').data('bValidator').isValid()){
            var email = $("#emailfooter").val();
            var subscription_type = $("#subscription_type").val();
            // AJAX Code To Submit Form.
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>page/add_email_subscription",
                data: {
                    email: email,
                    subscription_type: subscription_type
                },
                success: function(result) {
                    var data = JSON.parse(result);
                    if (data.status == 'failed') {
                        errorMsg(data.msg);
                        $("#emailfooter").val('');
                      } else if(data.status == 'success') {
                        successMsg(data.msg);
                        $("#emailfooter").val('');
                    }else if(data.status == 'validationfailed')
                    {
                      errorMsg(data.msg.email);
                      $("#emailfooter").val('');
                    }
                }
            });
            return false;
        }
    });
</script>

<script type="text/javascript">
    if ($(window).width() <= 1050) {
        jQuery('.department-block').on('click', function(event) {
            $(this).toggleClass('open');
            event.stopPropagation();
        });
        //for sub Categories open/close settings
        var divs = $('.menu-list .list-unstyled').hide(); //Hide/close all containers

        var h2s = $('.toggle-menu-icon').click(function() {
            h2s.not(this).parent('.heading').removeClass('active')
            $(this).parent('.heading').toggleClass('active')
            divs.not($(this).parent('.heading').next()).slideUp()
            $(this).parent('.heading').next().slideToggle()
            return false; //Prevent the browser jump to the link anchor

        });

        $('.has-sub .catg-toggle-icon').click(function(event) {
            $(this).parents('.catg-link-block').parents('.has-sub').toggleClass('in', 500);
            event.stopPropagation();
        });

    } else {
        $('.department-block').hover(
            function() {
                $(this).addClass('open');
            },
            function() {
                $(this).removeClass('open');
            }
        );

        $('.department-dropdown li').hover(
            function() {
                $(this).addClass('active');
            },
            function() {
                $(this).removeClass('active');
            }
        );
    }

    // rating 
    $('.event_star').voteStar()

    //    tool tips
    $('[data-toggle="tooltip"]').tooltip();
    //    popovers
    $('[data-toggle="popover"]').popover();

    $('body').on("touchstart", function(e){

    $('[data-toggle="tooltip"]').each(function () {
            if($(this).is(e.target)){
                $(this).tooltip('show');
            }
            else{
                $(this).tooltip('hide');
            }
            
        });

        $('[data-toggle="popover"]').each(function () {
            if($(this).is(e.target)){
                $(this).popover('show');
            }
            else{
                $(this).popover('hide');
            }
        });
    });

    // BACK TO TOP BUTTON 
    $(document).ready(function() {
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 300) {
                $('#back_top').fadeIn("slow");
            } else {
                $('#back_top').fadeOut("slow");
            };
        });

        $('#back_top').on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, 800);
            $('#back_top').fadeOut("slow").stop();
        });

    });
    //===desktop Header fixed
    $(window).scroll(function() {
        var sticky = $('.header-sticky'),
            scroll = $(window).scrollTop();

        if (scroll >= 150) sticky.addClass('header-fixed');
        else sticky.removeClass('header-fixed');

    });

    //===autocomplite search
    $(window).scroll(function() {
        var auto_sticky = $('.ui-autocomplete'),
            scroll = $(window).scrollTop();

        if (scroll >= 150) auto_sticky.addClass('remove-auto');
        else auto_sticky.removeClass('remove-auto');

    });

   /* //===filter fixed
    $(window).scroll(function() {
        var sticky = $('.applied-filter'),
            scroll = $(window).scrollTop();

        if (scroll >= 150) sticky.addClass('fixed');
        else sticky.removeClass('fixed');

    });*/

</script>
<script>

    function confirmBox(msg, url) {
        swal({
            title: msg,
            type: "warning",
            padding: 0,
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: false,
            background: '#f1f1f1',
            buttonsStyling: false,
            confirmButtonClass: 'btn btn-confirm',
            cancelButtonClass: 'btn btn-cancle',
            confirmButtonText: 'Ok',
            cancelButtonText: 'Cancel',
            animation: false
        }, function() {
            window.location.href = url;
        });

    }

    function check_email_exists_footer() {
        var email = $("#emailfooter").val();
        $.ajax({
            type: "post",
            url: "<?php echo base_url(); ?>page/email_exists",
            data: {
                email: email
            },
            success: function(response) {
                if (response == 1) {
                    warningMsg("This email is already registered");
                    return false;
                }
            }
        });
    }

    function fixSize() {
        var highestBox = 0;
        $('.popular-catg-section .tile').each(function() {
            var boxHeight = $(this).height();
            if (boxHeight > highestBox) {
                highestBox = boxHeight;
            }
        });

        $('.popular-catg-section .tile').css('height', highestBox + 'px');
    }

    function productlistSize() {
        var decsmaxHeight = 0;
        $(".product-tile .product-desc").each(function() {
            if ($(this).height() > decsmaxHeight) {
                decsmaxHeight = $(this).height();
            }
        });
        
        $(".product-tile .product-desc").height(decsmaxHeight);
    }

    $(document).ready(function(){
        fixSize();
        productlistSize();
    });

    $(window).resize(function(){
        fixSize();
        productlistSize();
    });


</script>
</body>

</html>