<section class="account-page" id="autoScrollDiv">
   <div class="join-now-bg text-center">
      <h1 class="heading">Welcome to <?php echo SITE_NAME; ?></h1>
      <h3 class="sub-heading">New Ways to Choose Your Product and Ignore the Rest</h3>
   </div>
   <div class="join-now-container">
      <div class="">
         <div class="row signInNow">
            <div class="col-sm-6">
               <div class="login-left-section">
                  <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/login-page-bg.svg" width="100%">
               </div>
            </div>
            <div class="col-sm-6">
               <div class="login-wrapper">
                  <h2>Sign <b>In</b></h2>
                  <form id="loginform" method="POST" data-bvalidator-validate>
                     <?php msg_alert(); ?>
                     <div class="form-group">
                        <label for="Email">Email Address</label>
                        <input type="text" class="form-control" id="Email" name="email" placeholder="Email Address" data-bvalidator="required,email" data-bvalidator-msg="Please enter a valid email address">
                        <?php echo form_error('email'); ?>
                     </div>
                     <div class="form-group">
                        <label for="Password">Password</label>
                        <input type="password" class="form-control" id="Password" name="password" placeholder="Password" data-bvalidator="required" data-bvalidator-msg="Please enter a password">
                        <?php echo form_error('password'); ?>
                     </div>
                     <div class="form-group">
                        <input type="submit" class="btn btn-cart btn-block" name="sign_in" value="Submit">
                     </div>
                     <div class="login-extras clearfix">
                        <div class="pull-left">
                           <div class="checkbox-input">
                              <input id="remember-me" type="checkbox" class="styled">
                              <label for="remember-me">
                              Remember me?
                              </label>
                           </div>
                        </div>
                        <div class="pull-right">
                           <div class="forgot-block">
                              <a class="forgot-link" href="<?php echo base_url('page/forgotpassword'); ?>">Forgot Password</a>
                           </div>
                        </div>
                     </div>
                     <div class="divider-with-text">
                        <span>New to Copico?</span>
                     </div>
                     <div class="create-account-link">
                        <a href="javascript:void(0)" class="btn btn-default btn-block signUpNowBtn">Create your account</a>
                     </div>
                  </form>
               </div>
            </div>
         </div>
         <div class="row signUpNow" style="display: none;">
            <div class="col-sm-6">
               <div class="login-left-section">
                  <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/signup-account-bg.svg" width="100%">
               </div>
            </div>
            <div class="col-sm-6">
               <div class="login-wrapper">
                  <h2>Sign <b>Up</b></h2>
                  <form id="signupform" method="POST" data-bvalidator-validate>
                     <?php msg_alert(); ?>
                     <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name'); ?>" placeholder="Your Name" data-bvalidator="required" data-bvalidator-msg="Please enter a full name">
                        <?php echo form_error('name'); ?>
                     </div>
                     <div class="form-group">
                        <label for="number">Mobile number</label>
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
                              <input type="text" class="form-control" id="mobile" value="<?php echo set_value('mobile'); ?>" name="mobile" placeholder="xxxxxxxxxx" data-bvalidator="maxlen[13],minlen[9],number,required" data-bvalidator-msg="Please enter a 10 digit Mobile No.">
                           </div>
                        </div>
                        <?php echo form_error('mobile'); ?>
                     </div>
                     <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" value="<?php echo set_value('email'); ?>" name="email" placeholder="Email Address" data-bvalidator="required,email" data-bvalidator-msg="Please enter a valid email address">
                        <?php echo form_error('email'); ?>
                     </div>
                     <div class="form-group">
                        <label for="Password">Password</label>
                        <input type="Password" class="form-control" id="password" value="<?php echo set_value('password'); ?>" name="password" placeholder="Password" data-bvalidator="minlen[6],required" data-bvalidator-msg="Please enter a Min 6 characters password">
                        <?php echo form_error('password'); ?>
                     </div>
                     <div class="form-group">
                        <label for="Password">Confirm Password</label>
                        <input type="Password" class="form-control" id="confirm_password" value="<?php echo set_value('confirm_password'); ?>" name="confirm_password" placeholder="Confirm Password" data-bvalidator="equal[password],required" data-bvalidator-msg="Please enter the same password again">
                        <?php echo form_error('confirm_password'); ?>
                     </div>
                     <div class="form-group">
                        <input type="submit" class="btn btn-cart btn-block" name="sign_up" value="Continue">
                     </div>
                     <div class="already-account-link">
                        <p>Already have an account? <a href="javascript:void(0)" class="sign-in-link signInNowBtn">Sign in <i class="icofont icofont-caret-right"></i></a></p>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<script>
   SITE_URL = "<?php echo base_url(); ?>";
   
   $(document).ready(function () {
   	$('#signupform').bValidator();
   	$('#loginform').bValidator();
    // Handler for .ready() called.
    $('html, body').animate({
        scrollTop: $('#autoScrollDiv').offset().top
    }, 'slow');
   
    $(".signInNowBtn").click(function(){
     $(".signUpNow").hide();
     $(".signInNow").show();
   });
   
   $(".signUpNowBtn").click(function(){
     $(".signInNow").hide();
     $(".signUpNow").show();
   });
   
   });
</script>