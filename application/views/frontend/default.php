<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <link rel="icon" type="image/png" href="<?php echo FRONTEND_THEME_URL; ?>img/cazshoppe_favicon.png"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name='viewport'/>


    <!-- Bootstrap CSS -->
    <link href="<?php echo FRONTEND_THEME_URL ?>css/bootstrap.min.css" rel="stylesheet">

    <link href="<?php echo FRONTEND_THEME_URL ?>css/style.css" rel="stylesheet">
<!--     <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,500,600,800" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700|Source+Serif+Pro:400,600,700|Spectral+SC:400,500,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700" rel="stylesheet">
    <link href="<?php echo FRONTEND_THEME_URL ?>css/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

    <title><?php echo $title; ?></title>
  </head>
  <body>
  <?php msg_alert(); ?>
    <div class="bg-primary clearfix">
      <div class="container-fluid">
        <div id="particles-js"></div>
        <div class="header-wrap">
          <div class="row flex-head">
            <div class="col-sm-6 flex-head">
              <img class="logo-img" src="<?php echo FRONTEND_THEME_URL ?>img/icons/copico-logo-white.png" width="190px">
              <div class="logo-heading">The Future of e-commerce</div>
            </div>
            <div class="col-sm-6 non-responsive">
              <div class="head-right">
                <div class="support-mail text-right">
                  <a href="mailto:support@cazshop.io">support@cazshop.io</a>
                </div>
                <div class="social-link">
                  <a href="https://t.me/CopicoOfficial" title="Telegram" target="_blank">
                    <i class="fab fa-twitter"></i>
                  </a>
                  <a href="https://twitter.com/cazproject?lang=en" title="Twitter" target="_blank">
                    <i class="fab fa-telegram-plane"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row main-contain flex-head">
          <div class="col-sm-3 commmon-width">
            <section class="wow slideInLeft" data-wow-duration="1s" data-wow-delay="0.5s" style="visibility: hidden;">
              <div class="text white-bg">
                <p>We successfully launched our <span>CazShop</span> ecommerce platform, powered by blockchain technology, in June 2018, however our Sellers are waiting to upload their products until we have fully operational payment gateways for <span>CazCoin, Bitcoin, Ethereum, Litecoin, and fiat.</span></p>
                <p>Due to this, we've decided to temporarily take the CazShop down to implement all the required gateways, to allow full and easy usage for both buyers and sellers, revolutionising ecommerce as you know it.</p>
              </div>
            </section>
          </div>
          <div class="col-sm-6 commmon-width">
            <section class="wow fadeIn" data-wow-duration="6s" data-wow-delay="2s" style="visibility: hidden;">
              <div class="text-center video-section">
                  <div class="laptop-wrapper">
                    <iframe width="100%" height="420" src="https://www.youtube.com/embed/Pf5daezN4y0?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                  </div>
              </div>
            </section>
          </div>
          <div class="col-sm-3 commmon-width">
            <section class="wow slideInRight" data-wow-duration="1s" data-wow-delay="0.5s" style="visibility: hidden;">
              <div class="text blue-bg">
                <h3>Merchant Registration</h3>
                <h4>*Free registration for new merchants - for a limited time only.</h4>
                <ul class="list-view">
                  <li>Low commissions </li>
                  <li>Access from crypto and non-crypto buyers</li>
                  <li>1 month free advertising on CazShop social media platforms ( 4 free product adverts)</li>
                  <li>Receive payment for goods in crypto or fiat</li>
                  <li>24/7 support system</li>
                </ul>
                <div class="modalbtn">
                <!-- loginModalOpen  -->
                  <a href="<?php echo base_url('seller/register'); ?>" class="btn btn-light">Click here</a>
                </div>
              </div>
            </section>
          </div>
        </div>
        <div class="row footer-contain">
          <div class="cazlogo-leftfooter">
            <img src="<?php echo FRONTEND_THEME_URL ?>img/caz-logo.png">
          </div>
            <div class="col-sm-5 commmon-width">
              <section class="wow slideInDown" data-wow-duration="2s" data-wow-delay="2s" style="visibility: hidden;">
              <div class="text">
                <p>"The CazCoin team are looking forward to the new update on CazShop to implement the full suite of payment gateways, which will allow CazProjects' first use case for CazCoin to come to fruition." <br>
                - CazCoin Team
                </p>
              </div>
              </section>
            </div>
          
          <!-- <div class="cazlogo-wrap">
            <img class="cazlogo-img" src="<?php //echo FRONTEND_THEME_URL ?>">
          </div> -->
        </div>
      </div>
    </div>


    <div class="modal fade" id="signInModal" role="dialog">
       <div class="modal-dialog account-modal">
          <!-- Modal content-->
          <div class="modal-content comman-modal">
             <div class="modal-header comman-header-modal">
                <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="<?php echo SELLER_THEME_URL; ?>/img/Icon_Basic_Close.svg" width="18"></span>
                </button>
                <h4 class="modal-title text-center popUpTitle"></h4> 
             </div>
             <div class="modal-body comman-body-modal clearfix">
                <div class="">
                   <div class="row signUpNow">
                      <div class="col-sm-12">
                         <div class="login-wrapper login-modal">
                            <div class="main-loader" style='display: none;'>
                               <div class="loader">
                                  <svg class="circular-loader" viewBox="25 25 50 50" >
                                    <circle class="loader-path" cx="50" cy="50" r="20" fill="none" stroke="#f45b69" stroke-width="2.5" />
                                  </svg>
                               </div>
                            </div>
                            <form id="signupform" method="POST" data-bvalidator-validate>
                               <div class="form-group">
                                  <label for="name">Your Name</label>
                                  <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name'); ?>" placeholder="Ex : John Doe" data-bvalidator="required" data-bvalidator-msg="Please enter a full name">
                                  <?php echo form_error('name'); ?>
                               </div>
                               <div class="form-group">
                                  <label for="email">Email Address</label>
                                  <input type="email" class="form-control" id="registrationEmail" value="<?php echo set_value('email'); ?>" name="email" placeholder="john@example.com" data-bvalidator="required,email" data-bvalidator-msg="Please enter a valid email address">
                                  <?php echo form_error('email'); ?>
                               </div>
                               <div class="form-group">
                                  <label for="number">Mobile number <span class="mandatory">*</span></label>
                                  <div class="mobile-number-wrapper">
                                    <div class="mobile-number-left">
                                      <select class="form-control" name="country_code" id="country_code">
                                        <?php
                                        if(!empty($phnCode)){
                                        foreach ($phnCode as $row){
                                        ?>
                                        <option <?php if($row->phonecode=='91') echo "selected"; ?> value="<?php echo $row->phonecode; ?>"><?php echo $row->sortname.' +'.$row->phonecode; ?></option>
                                        <?php
                                        } }
                                        ?>
                                      </select>
                                    </div>
                                    <div class="mobile-number-right">
                                      <input type="text" class="form-control" id="mobile" value="<?php echo set_value('mobile'); ?>" name="mobile" placeholder="xxxxxxxxxx" data-bvalidator="maxlen[13],minlen[9],number,required" data-bvalidator-msg="Please enter a valid Mobile No.">
                                    </div>
                                  </div>
                                  <?php echo form_error('mobile'); ?>
                               </div>
                               <div class="form-group">
                                  <input type="submit" class="btn btn-primary btn-block signUp-btn" name="sign_up" value="Continue">
                               </div>
                            </form>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="<?php echo FRONTEND_THEME_URL ?>js/wow.min.js" type="text/javascript"></script>
    <script src="<?php echo FRONTEND_THEME_URL ?>js/particles.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/seller/js/custom.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/backend/admin/js/jquery.js"></script>
    <script src="<?php echo SELLER_THEME_URL; ?>js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/admin/js/notify.min.js"></script>
    <script src="<?php echo BACKEND_THEME_URL; ?>js/moment.min.js"></script> 
    <script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>validator/bvalidator/jquery.bvalidator.js"></script>
    <script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>validator/bvalidator/themes/presenters/default.min.js"></script>
    <script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>validator/bvalidator/themes/gray/gray.js"></script>
    <link href="<?php echo BACKEND_THEME_URL ?>validator/bvalidator/themes/gray/gray.css" rel="stylesheet" type="text/css" />

    <script>
      SITE_URL = "<?php echo base_url(); ?>";
    $('.loginModalOpen').on('click', function() {
      $('#signupform')[0].reset();
      $(".alert-danger").hide();
      $(".alert-success").hide();
      $(".signUpNow").show();
      $(".popUpTitle").html("Sign <b>Up</b>");
      $('#signInModal').modal('show'); 
    });

    /*If We are click on Registration button then below code will be executed*/
     $('#signupform').submit(function() {
        $('#signupform').bValidator();
        if($('#signupform').data('bValidator').isValid()){
           
           $(".signUp-Btn").attr("disabled", true);
           var name = $("input[name=name]").val();
           var email = $("#registrationEmail").val();
           var country_code = $("#country_code").val();
           var mobile = $("#mobile").val();
           var type = 2;
     
           $.ajax({
              url: SITE_URL + 'page/registration_request',
              type: 'POST',
              data: {
                  name: name,
                  email: email,
                  country_code: country_code,
                  mobile: mobile,
                  type: type
              },
              beforeSend: function()
              {
                $('.main-loader').show();
              },
              cache: false,
              success: function(result) {
                  var data = JSON.parse(result);
                  if(data.status=='failed'){
                      $(".signUp-Btn").attr("disabled", false);  
                      $('.main-loader').hide();
                      if(data.msg!=''){
                         errorMsg(data.msg);
                      }
                  }else{
                      if(data.msg!=''){
                         successMsg(data.msg);
                      }
                      $('.main-loader').hide();
                      $('#signupform')[0].reset();
                      $('#signInModal').modal('hide'); 
                  }
              },
           });
        }
       
        return false;

     });
    </script>

    <?php if($this->session->flashdata('msg_warningsss')){ ?>
      <script type="text/javascript">
        $.notify("<?php echo $this->session->flashdata('msg_warningsss'); ?>", "warn");
        $('.notifyjs-corner').empty(); 
      </script>
    <?php } ?>

    <style type="text/css">
      html{
        height: 100%;
      }
      body{
        color: #fff;
        overflow-x: hidden;
        font-size: 15px;
        font-family: 'Montserrat', sans-serif;
        /* font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
        --font-family-sans-serif: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
        --font-family-monospace: SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace; */
        background: linear-gradient(135deg, #6247e5 0%,#42b7f5 100%);
        height: 100%;
      }
      .bg-primary {
        background: #6247e5; /* Old browsers */
        background: -moz-linear-gradient(-45deg, #6247e5 0%, #42b7f5 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(-45deg, #6247e5 0%,#42b7f5 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(135deg, #6247e5 0%,#42b7f5 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#6247e5', endColorstr='#42b7f5',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
        position: relative;
        min-height: 100vh;
      }
      /* .bg-primary::after {
            background-attachment: scroll;
            background-clip: border-box;
            background-image: url('../assets/frontend/img/bg-primary.png');
            background-origin: padding-box;
            background-position: 0 0;
            background-repeat: no-repeat;
            background-size: 100% auto;
            bottom: 0;
            content: "";
            position: absolute;
            top: 0;
            width: 100%;
            z-index: -1;
            opacity: 0.2;
        } */
        .wow{
          visibility: hidden;
        }
      a,a:hover{
        color: #fff;
      }
      .laptop-wrapper{
        position: relative;
        overflow: hidden;
      }
      .laptop-wrapper::before {
        display: block;
        content: "";
        padding-top: 56.25%;
      }
      .laptop-wrapper iframe{
        border-radius: 10px;
        border: 4px solid #fff;
        box-shadow: 0px 0px 20px aliceblue;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;
      }
      .header-wrap {
        padding: 15px 0;
        padding-bottom: 0;
      }
      .flex-head {
          display: flex;
          align-items: center;
          align-content: center;
      }
      .logo-img{
        width: 190px;
      }
      .logo-heading {
          display: inline-block;
          position: relative;
          top: 3px;
          margin-left: 15px;
          font-size: 18px;
          font-weight: 600;
      }
      .head-right {
        text-align: right;
        display: flex;
        flex-direction: row;
        flex-flow: wrap;
        justify-content: flex-end;
        align-items: center;
      }
      .support-mail {
        font-size: 17px;
        display: inline-block;
        position: relative;
        top: -4px;
        margin-right: 10px;
      }
      .social-link {
        display: inline-block;
      }
      .social-link a {
          color: #000;
          width: 35px;
          height: 35px;
          border-radius: 50%;
          background: #ffffff;
          display: inline-block;
          position: relative;
          margin: 0 3px;
      }
      .social-link a .fab {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        -webkit-transform: translate(-50%,-50%);
        -moz-transform: translate(-50%,-50%);
        -ms-transform: translate(-50%,-50%);
        font-size: 16px;
        line-height: 35px;
      }
      .social-link a .fab.fa-telegram-plane {
        font-size: 18px;
        top: 17px;
        left: 16px;
      }
      .main-contain{
        padding-top: 50px;
      }
      .footer-contain{
        padding-top: 50px;
        padding-bottom: 40px;
        display: flex;
        justify-content: center;
        background-image: url('../assets/frontend/img/caz-logo.png');
        background-repeat: no-repeat;
        background-position-x: 99%;
        background-position-y: 99%;
        background-size: contain;
        position: relative;
      }
      .cazlogo-leftfooter {
        position: absolute;
        left: 0;
        top: 0px;
      }
      .cazlogo-leftfooter img {
        width: 190px;
      }
      .text {
        font-size: 16px;
        font-weight: 500;
      }
      .main-contain.flex-head {
        align-items: initial;
      }
      ul.list-view li {
        padding: 5px 0;
      }
      ul.list-view {
        padding-left: 20px;
      }
      #particles-js {
        position: absolute;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        bottom: 0;
        right: 0;
      }
      .white-bg{
        background-color: #fff;
        color: #101010;
        font-size: 18px;
        line-height: 28px;
        border-radius: 4px;
        padding: 15px;
        box-shadow: 0 0 23px #2d2d2d85;
        font-family: 'Raleway', sans-serif;
        }
      .white-bg span{
        color: #6051e7;
        font-weight: 700;
      }
      .blue-bg{
        background: -moz-linear-gradient(-45deg, #6247e5 0%, #42b7f5 100%);
        background: -webkit-linear-gradient(-45deg, #6247e5 0%,#42b7f5 100%);
        background: linear-gradient(135deg, #6247e5 0%,#42b7f5 100%);
        color: #fff;
        font-size: 16px;
        border-radius: 4px;
        box-shadow: 0 0 23px #00000073;
        padding: 15px;
      }
      .blue-bg h3{
        margin-top: 0;
        font-weight: 800;
        border-bottom: 1px solid #000;
        padding-bottom: 10px;
        margin-bottom: 20px;
      }
      .btn {
         border-radius: 100px;
         font-size: 16px;
         font-weight: bold;
         letter-spacing: 1px;
         padding: 15px 39px;
         text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.14);
         text-transform: uppercase;
         box-shadow: 0 4px 9px 0 rgba(0, 0, 0, 0.2);
    }
     .btn-primary {
        /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#5a7ce2+0,8283e8+50,5c5de8+51,565bd8+71,575cdb+100 */
         background: #5a7ce2;
        /* Old browsers */
         background: -moz-linear-gradient(-45deg, #5a7ce2 0%, #8283e8 50%, #5c5de8 51%, #565bd8 71%, #575cdb 100%);
        /* FF3.6-15 */
         background: -webkit-linear-gradient(-45deg, #5a7ce2 0%,#8283e8 50%,#5c5de8 51%,#565bd8 71%,#575cdb 100%);
        /* Chrome10-25,Safari5.1-6 */
         background: linear-gradient(135deg, #5a7ce2 0%,#8283e8 50%,#5c5de8 51%,#565bd8 71%,#575cdb 100%);
        /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
         filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#5a7ce2', endColorstr='#575cdb',GradientType=1 );
        /* IE6-9 fallback on horizontal gradient */
         background-size: 400% 400%;
         -webkit-animation: AnimationName 3s ease infinite;
         -moz-animation: AnimationName 3s ease infinite;
         animation: AnimationName 3s ease infinite;
         -webkit-animation: AnimationName 3s ease infinite;
         -moz-animation: AnimationName 3s ease infinite;
         animation: AnimationName 3s ease infinite;
         border: medium none;
    }
     .btn-primary:hover {
         background-color: #5a7ce2;
         border-color: #5a7ce2;
         color: #fff;
    }
      .btn-light {
        /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#f2f2f2+0,dddddd+50,ffffff+51,ffffff+71,f6f8fb+100 */
        background: #f2f2f2;
        /* Old browsers */
        background: -moz-linear-gradient(-45deg, #f2f2f2 0%, #dddddd 50%, #ffffff 51%, #ffffff 71%, #f6f8fb 100%);
        /* FF3.6-15 */
        background: -webkit-linear-gradient(-45deg, #f2f2f2 0%,#dddddd 50%,#ffffff 51%,#ffffff 71%,#f6f8fb 100%);
        /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(135deg, #f2f2f2 0%,#dddddd 50%,#ffffff 51%,#ffffff 71%,#f6f8fb 100%);
        /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f2f2f2', endColorstr='#f6f8fb',GradientType=1 );
        /* IE6-9 fallback on horizontal gradient */
        color: #3f345f !important;
        background-size: 400% 400%;
        -webkit-animation: AnimationName 3s ease infinite;
        -moz-animation: AnimationName 3s ease infinite;
        animation: AnimationName 3s ease infinite;
        -webkit-animation: AnimationName 3s ease infinite;
        -moz-animation: AnimationName 3s ease infinite;
        animation: AnimationName 3s ease infinite;
        border: medium none;
        }
        .btn-light:hover {
          color: #212529;
          background-color: #e2e6ea;
          border-color: #dae0e5;
        }
        @media(max-width: 1400px){
          .white-bg{
            font-size: 14px;
            line-height: 20px;
          }
          .blue-bg h3{
            font-size: 19px;
            margin-bottom: 10px;
          }
          .blue-bg h4{
            font-size: 15px;
          }
          .blue-bg{
            font-size: 14px;
          }
          ul.list-view li {
            padding: 1px 0;
          }
          .cazlogo-leftfooter img {
            width: 212px;
          }
          .btn{
            padding: 13px 39px;
            font-size: 14px;
          }
        }
      @media(max-width: 991px){
        .main-contain.flex-head,.footer-contain {
          display: block;
        }
        .main-contain.flex-head .commmon-width ,.footer-contain .commmon-width{
          width: 100%;
        }
        .support-mail{
          text-align: left;
        }
        .header-wrap .flex-head {
          display: block;
        }
        .header-wrap .col-sm-6{
          width: 100%;
          margin-bottom: 15px;
        }
        .white-bg{
          margin-bottom: 15px;
        }
        .blue-bg{
          margin-top: 15px;
        }
        .cazlogo-leftfooter{
          display: none;
        }
        .head-right{
          justify-content: flex-start;
        }
        .main-contain {
          padding-top: 20px;
        }
        .header-wrap{
          padding-top: 0px;
        }
      }
      @media(max-width: 450px){
        .logo-heading{
          margin-left: 0;
        }
      }
    </style>
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

       // ===========Particles============
    particlesJS("particles-js", {
    "particles": {
      "number": {
        "value": 80,
        "density": {
          "enable": true,
          "value_area": 800
        }
      },
      "color": {
        "value": "#ffffff"
      },
      "shape": {
        "type": "triangle",
        "stroke": {
          "width": 0,
          "color": "#000000"
        },
        "polygon": {
          "nb_sides": 5
        },
        "image": {
          "src": "img/github.svg",
          "width": 100,
          "height": 100
        }
      },
      "opacity": {
        "value": 0.5,
        "random": false,
        "anim": {
          "enable": false,
          "speed": 1,
          "opacity_min": 0.1,
          "sync": false
        }
      },
      "size": {
        "value": 4.16725702807898,
        "random": false,
        "anim": {
          "enable": false,
          "speed": 40,
          "size_min": 0.1,
          "sync": false
        }
      },
      "line_linked": {
        "enable": true,
        "distance": 150,
        "color": "#ffffff",
        "opacity": 0.4,
        "width": 1
      },
      "move": {
        "enable": true,
        "speed": 6.667611244926368,
        "direction": "none",
        "random": false,
        "straight": false,
        "out_mode": "out",
        "bounce": false,
        "attract": {
          "enable": false,
          "rotateX": 166.6902811231592,
          "rotateY": 2667.044497970547
        }
      }
    },
    "interactivity": {
      "detect_on": "canvas",
      "events": {
        "onhover": {
          "enable": true,
          "mode": "repulse"
        },
        "onclick": {
          "enable": true,
          "mode": "push"
        },
        "resize": true
      },
      "modes": {
        "grab": {
          "distance": 400,
          "line_linked": {
            "opacity": 1
          }
        },
        "bubble": {
          "distance": 400,
          "size": 40,
          "duration": 2,
          "opacity": 8,
          "speed": 3
        },
        "repulse": {
          "distance": 200,
          "duration": 0.4
        },
        "push": {
          "particles_nb": 4
        },
        "remove": {
          "particles_nb": 2
        }
      }
    },
    "retina_detect": true
  });
    </script>
  </body>
</html>