<div class="bread_parent row">
   <div class="col-md-12">
      <ul class="breadcrumb">
         <li><a href="<?php  echo base_url(); ?>superadmin/dashboard"><i class="icon-home"></i> Dashboard  </a></li>
         <li><a href="<?php  echo base_url(); ?>backend/user"><b><?php if($role==1) echo 'Photographer User'; else echo 'Signup User'; ?></b></a></li>
         <li><b>Edit <?php if($role==1) echo 'Photographer User'; else echo 'Signup User'; ?></b></li>
      </ul>
   </div>
</div>
<div class="panel-body">
<form role="form" class="form-horizontal" action="<?php echo current_url()?>"  method="post" id="form_valid" enctype="multipart/form-data">
   <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
   <?php echo msg_alert();?>
   <div class="form-body label-static">
      <div class="col-md-6 form-group">
         <label class="col-md-4 control-label">First Name<span class="error">*</span></label>
         <div class="col-md-8">
            <input type="text" name="first_name" value="<?php if(!empty($_POST) && $_POST['first_name'])  echo set_value('first_name'); else echo $user->first_name; ?>" tabindex="1" placeholder="First Name" tabindex='1'   class="form-control" data-bvalidator-msg="First Name is required and it should contain alphabets only" data-bvalidator="required" />
            <?php echo form_error('first_name'); ?>
         </div>
      </div>
      <div class="form-body label-static">
         <div class="col-md-6 form-group">
            <label class="col-md-4 control-label">Last Name<span class="error">*</span></label>
            <div class="col-md-8">
               <input type="text" name="last_name" value="<?php if(!empty($_POST) && $_POST['last_name'])  echo set_value('last_name'); else echo $user->last_name; ?>" tabindex="1" placeholder="Last Name" tabindex='1'   class="form-control" data-bvalidator-msg="Last name is required and it should contain alphabets only" data-bvalidator="required" />
               <?php echo form_error('last_name'); ?>
            </div>
         </div>
         <div class="col-md-6 form-group">
            <label class="col-md-4 control-label">Email<span class="error">*</span></label>
            <div class="col-md-8">
               <input type="text" value="<?php if(!empty($_POST) && $_POST['email'])  echo set_value('email'); else echo $user->email; ?>"  tabindex="3" placeholder="Email Address"  name="email" class="form-control" data-bvalidator-msg="Email is required" data-bvalidator="email,required"/>
               <?php echo form_error('email'); ?>
            </div>
         </div>
         <div class="col-md-6 form-group">
            <label class="col-md-4 control-label">Password<span class="error">*</span></label>
            <div class="col-md-8">
               <input type="text" value="<?php if(!empty($_POST) && $_POST['password'])  echo set_value('password');  ?>"  tabindex="3" placeholder="Password"  name="password" class="form-control" data-bvalidator-msg="Password is required" data-bvalidator=""/>
               <?php echo form_error('password'); ?>
            </div>
         </div>
         <div class="col-md-6 form-group">
            <label class="col-md-4 control-label">Contact Number<span class="error">*</span></label>
            <div class="col-md-8">
               <input type="text" value="<?php if(!empty($_POST) && $_POST['mobile'])  echo set_value('mobile'); else echo $user->mobile; ?>" tabindex="6" data-mask="(999) 999-9999" placeholder="999-999-9999"  name="mobile" class="form-control phone_number_format" data-bvalidator-msg="Contact Number is required" data-bvalidator="required" />
               <?php echo form_error('mobile'); ?>
            </div>
         </div>
         <div class="col-md-6 form-group">
            <label class="col-md-4 control-label">Gender<span class="error">*</span></label>
            <div class="col-md-8">
               <select name="gender"  class="form-control" id="default-select" data-bvalidator-msg="A gender is required" data-bvalidator="required" >
                  <option value="">Select Gender</option>
                  <option value="1" <?php if(!empty($_POST) && $_POST['gender']==1) echo 'selected'; else if(!empty($user) && $user->gender==1) echo 'selected'; ?>>Male</option>
                  <option value="2" <?php if(!empty($_POST) && $_POST['gender']==2) echo 'selected'; else if(!empty($user) && $user->gender==2) echo 'selected'; ?>>Female</option>
               </select>
               <?php echo form_error('gender'); ?>
            </div>
         </div>
         <div class="col-md-6 form-group">
            <label class="col-md-4 control-label">Country<span class="error">*</span></label>
            <div class="col-md-8">
               <input type="text" placeholder="Country" name="country" class="form-control" value="<?php if(!empty($_POST) && $_POST['country'])  echo set_value('country'); else echo $user->country; ?>" data-bvalidator="required" data-bvalidator-msg="A country is required">
               <?php echo form_error('country'); ?>
            </div>
         </div>
         <div class="col-md-6 form-group">
            <label class="col-md-4 control-label">Image<span class="error">*</span></label>
            <div class="col-md-4">
               <input type="file" placeholder="Country" name="image" class="form-control" value="<?php echo set_value('image') ?>" >
               <?php echo form_error('image'); ?>
            </div>
            <div class="col-md-4">
               <img src="<?php echo base_url().$user->image; ?>" width="100" height="100">
            </div>
         </div>
         <div class="clearfix"></div>
         <br>
      </div>
      <div class="clearfix"></div>
      <br><br>
      <div class="form-actions fluid">
         <div class="col-md-12 text-center">
            <button  class="btn btn-primary tooltips" rel="tooltip" data-placement="top" data-original-title="Add Affiliate User" type="submit"><i class="icon-plus"></i> Submit</button>&nbsp;&nbsp;
            <a class="btn btn-danger btn-md tooltips" href="<?php echo base_url('backend/tax/taxs'); ?>" rel="tooltip" data-placement="top" title="" data-original-title="Back to the affiliate users"><i class="icon-remove"></i>
            Back</a>                                         
         </div>
      </div>
</form>
<!-- END FORM--> 
</div>