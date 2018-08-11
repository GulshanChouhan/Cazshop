<div class="join-now-container">
  <div class="container">
    <div class="row">
      <div class="">
        <div class="login-wrapper">
          <h2>Reset <b>Password</b></h2>
           <form id="resetform" method="post" class="" role="form" action="<?php echo current_url(); ?>" data-bvalidator-validate> 
            <div class="input-group form-group">
              <span class="fld-icon input-group-addon"><i class="fa fa-key"></i></span>
              <input type="password" class="form-control" name="password" id="password" placeholder="john@123" value="<?php echo set_value('password'); ?>" data-bvalidator="minlen[6],required" data-bvalidator-msg="Please enter a Min 6 characters password">
              <?php echo form_error('password'); ?>
            </div>
            <div class="input-group form-group">
              <span class="fld-icon input-group-addon"><i class="fa fa-key"></i></span>
              <input type="password" class="form-control" name="confpassword" id="confpassword" placeholder="john@123" value="<?php echo set_value('confpassword'); ?>" data-bvalidator="equal[password],required" data-bvalidator-msg="Please enter the same password again">
              <?php echo form_error('confpassword'); ?>
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
      $('#resetform').bValidator();
   });
</script>