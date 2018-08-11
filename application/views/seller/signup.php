<div class="join-now-container">
    <div class="container">
      <div class="row">
        <div class="">
          <div class="login-wrapper">
            <h2>Sign Up <b><?php echo ucwords(SITE_NAME); ?> Seller</b></h2>
            <form id="signupform" class="" role="form" method="post" action="<?php echo current_url(); ?>" data-bvalidator-validate>
                <div class="input-group form-group">
                  <span class="fld-icon input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="text" class="form-control" name="name" id="name" placeholder="John Doe" value="<?php echo set_value('name'); ?>" data-bvalidator="required" data-bvalidator-msg="Please enter your full name">
                  <?php echo form_error('name'); ?>
                </div>
                <div class="input-group form-group">
                  <span class="fld-icon input-group-addon"><i class="fa fa-envelope"></i></span>
                  <input type="text" class="form-control" name="email" id="email" placeholder="john@example.com" value="<?php echo set_value('email'); ?>" data-bvalidator="required,email" data-bvalidator-msg="Please enter a valid email address">
                    <?php echo form_error('email'); ?>
                </div>
                <div class="input-group form-group">
                  <span class="fld-icon input-group-addon"><i class="fa fa-key"></i></span>
                  <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo set_value('password'); ?>" data-bvalidator="minlen[6],required" data-bvalidator-msg="Please enter the password with minimum 6 characters">
                  <?php echo form_error('password'); ?>
                </div>
                <div class="input-group form-group">
                  <span class="fld-icon input-group-addon"><i class="fa fa-key"></i></span>
                  <input type="password" class="form-control" name="re_password" id="re_password" placeholder="Confirm Password" value="<?php echo set_value('re_password'); ?>" data-bvalidator="equal[password],required" data-bvalidator-msg="Please enter the same password again">
                  <?php echo form_error('re_password'); ?>
                </div>            
              <div class="form-group text-center">
                <button id="btn-signup" type="submit" class="btn btn-block btn-red">Sign Up</button>
              </div>
              <br>
              <div class="divider-with-text">
                <span>Already have an account!</span>
              </div>
              <div class="create-account-link">
                <a href="<?php echo base_url('seller/login'); ?>" class="btn btn-default-white btn-block">Sign In Here</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

<script>
    SITE_URL = "<?php echo base_url(); ?>";

    $(document).ready(function(){
      $('#signupform').bValidator();
    });

</script>