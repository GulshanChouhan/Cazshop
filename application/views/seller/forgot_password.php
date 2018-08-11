<div class="join-now-container">
    <div class="container">
      <div class="row">
        <div class="">
          <div class="login-wrapper">
            <h2>Forgot <b>Password</b></h2>
             <form id="forgotform" method="post" class="" role="form" action="<?php echo current_url(); ?>" data-bvalidator-validate>
              <div class="input-group form-group">
                <span class="fld-icon input-group-addon"><i class="fa fa-envelope"></i></span>
                <input id="login-username" type="text" class="form-control" name="email" value="<?php echo set_value('email'); ?>" placeholder="john@example.com" data-bvalidator="required,email" data-bvalidator-msg="Please enter your registered email address">    
                <?php echo form_error('email'); ?>
              </div>             
              <div class="form-group text-center">
                <button type="submit" class="btn btn-block btn-red">Continue</button>
              </div>
              <br>
              <div class="divider-with-text">
                <span>If you have remember!</span>
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
      $('#forgotform').bValidator();
   });
</script>