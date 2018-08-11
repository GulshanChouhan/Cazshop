<div class="body-container clearfix">
<div class="bread_parent">
  <ul class="breadcrumb">
    <li><a href="<?php echo base_url('seller/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
    <li><b>Change Password</b></li>    
  </ul>
</div>

<div class="theme-container clearfix">
   <div class="clearfix"></div>
   <div class="col-md-12 col-lg-12">
      <div class="common-tab-wrapper">
         <div class="clearfix"></div>
         <div class="common-contain-wrapper clearfix">
            <div class="common-panel panel">
              <div class="panel-heading">
                <div class="panel-title"><i class="icofont icofont-lock"></i> Change Password</div>
              </div>
              <div class="panel-body">
                 <div class="col-sm-5 center-block">
                    <form id="changePassword" method="post" class="" role="form" action="<?php echo current_url(); ?>" data-bvalidator-validate>
                      <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                        <div class="form-group">
                          <label>Old Password <span class="mandatory">*</span> </label>
                          <input type="password" placeholder="Please enter your current password" class="form-control" id="oldpassword" name="oldpassword" value="<?php set_value('oldpassword'); ?>" data-bvalidator="required" data-bvalidator-msg="Please enter your current password">
                          <?php echo form_error('oldpassword'); ?>
                        </div>
                        <div class="form-group">
                          <label>New Password <span class="mandatory">*</span> </label>
                          <input type="password" placeholder="Please enter your new password with Min 6 characters" id="newpassword" class="form-control" name="newpassword" value="<?php set_value('newpassword'); ?>" data-bvalidator="minlen[6],required" data-bvalidator-msg="Please enter the password with minimum 6 characters">
                          <?php echo form_error('newpassword'); ?>
                        </div>
                        <div class="form-group">
                          <label>Confirm Password <span class="mandatory">*</span> </label>
                          <input type="password" placeholder="Please enter the same password again" class="form-control" id="confpassword" name="confpassword" value="<?php set_value('confpassword'); ?>" data-bvalidator="equal[newpassword],required" data-bvalidator-msg="Please enter the same password again">
                          <?php echo form_error('confpassword'); ?>
                        </div>
                        <br>          
                       <div class="form-group text-center">
                          <button type="submit" class="btn btn-red">Update Password</button>
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
<script>
   SITE_URL = "<?php echo base_url(); ?>";
   $(document).ready(function(){
      $('#changePassword').bValidator();
   });
</script>