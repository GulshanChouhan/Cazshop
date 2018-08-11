<div class="join-now-container">
    <div class="container">
      <div class="row">
        <div class="">
          <div class="login-wrapper">
            <h2>Login to <b>Seller Central</b></h2>
            <form id="loginform" method="post" class="" role="form" action="<?php echo current_url(); ?>" data-bvalidator-validate>
                <div class="input-group form-group">
                  <span class="fld-icon input-group-addon"><i class="fa fa-envelope"></i></span>
                  <input id="login-username" type="text" class="form-control" name="email" value="<?php echo set_value('email'); ?>" placeholder="john@example.com" data-bvalidator="required,email" data-bvalidator-msg="Please enter a valid email address">
                  <?php echo form_error('email'); ?>
                </div>
                <div class="input-group form-group">
                  <span class="fld-icon input-group-addon"><i class="fa fa-key"></i></span>
                  <input id="login-password" type="password" class="form-control" name="password" value="<?php echo set_value('password'); ?>" placeholder="john@123" data-bvalidator="required" data-bvalidator-msg="Please enter a password">
                  <?php echo form_error('password'); ?>
              </div>              
              <div class="form-group text-center">
                <button type="submit" class="btn btn-block btn-red">Sign In</button>
              </div>
              <div class="login-extras clearfix">
                <!-- <div class="pull-left">
                  <div class="checkbox-input">
                    <input id="remember-me" type="checkbox" class="styled">
                      <label for="remember-me">
                        Remember me?
                      </label>
                  </div>
                </div> -->
                <div class="pull-left">
                  <div class="forgot-block">
                    <a class="forgot-link" href="<?php echo base_url('page/contact'); ?>">Need Help?</a>
                  </div>
                </div>
                <div class="pull-right">
                  <div class="forgot-block">
                    <a class="forgot-link" href="<?php echo base_url('seller/forgot_password'); ?>">Forgot Password?</a>
                  </div>
                </div>
              </div>
              <div class="divider-with-text">
                <span>Don't have a seller account ?</span>
              </div>
              <div class="create-account-link">
                <a href="<?php echo base_url('seller/register'); ?>" class="btn btn-default-white btn-block">Create your account</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
<style>
  .forgot-link:hover{
    text-decoration: underline;
  }
</style>
<script>
   SITE_URL = "<?php echo base_url(); ?>";
   $(document).ready(function(){
      $('#loginform').bValidator();
   });
</script>