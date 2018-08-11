<div class="body-container clearfix">
<div class="bread_parent">
  <ul class="breadcrumb">
    <li><a href="<?php echo base_url('seller/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
    <li><b>My Profile</b></li>    
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
                <div class="panel-title"><i class="icofont icofont-user-alt-3"></i> My Profile</div>
              </div>
              <div class="panel-body">
                 <div class="col-sm-8 center-block">
                    <form id="profileform" class="" role="form" method="post" action="<?php echo current_url(); ?>" data-bvalidator-validate>
                      <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                      <div class="form-group col-sm-6">
                        <label>Full Name <span class="mandatory">*</span> </label>
                        <input type="text" placeholder="John Doe" class="form-control" name="user_name" value="<?php if(!empty($user->user_name)) echo $user->user_name ; ?>" data-bvalidator="required" data-bvalidator-msg="Please enter your full name"><?php echo form_error('user_name'); ?>
                      </div>
                      <div class="form-group col-sm-6">
                        <label for="name">Gender</label>
                        <div class="radio-block-wrap">
                          <div class="radio-input">
                            <input <?php if(!empty($user->gender)){ if($user->gender=='male'){ echo "checked='checked'"; } }else{ echo "checked='checked'"; } ?> type="radio" id="male" name="gender" value="male">
                            <label for="male">Male</label>
                          </div>
                          <div class="radio-input">
                            <input <?php if(!empty($user->gender)){ if($user->gender=='female'){ echo "checked='checked'"; } } ?> type="radio" id="female" name="gender" value="female">
                            <label for="female">Female</label>
                          </div>
                        </div>
                        <?php echo form_error('gender'); ?>
                      </div>
                      <div class="clearfix"></div>
                      <div class="form-group col-sm-12">
                        <label for="email">Business Name/Title <span class="mandatory">*</span></label>
                        <input type="text" class="form-control" id="business_name" value="<?php if(set_value('business_name')) echo set_value('business_name'); else if(!empty($user->business_name)) echo $user->business_name; ?>" name="business_name" placeholder="Example: Tessa Scott's Cupcakes" data-bvalidator="required" data-bvalidator-msg="Please enter your Legal Business Name.">
                        <?php echo form_error('business_name'); ?>
                      </div>
                      <div class="clearfix"></div>
                      <div class="form-group col-sm-6">
                        <label for="email">Email Address <span class="mandatory">*</span></label>
                        <input type="email" disabled="disabled" class="form-control" id="email" value="<?php if(set_value('email')) echo set_value('email'); else if(!empty($user->email)) echo $user->email; ?>" name="email" placeholder="john@example.com" data-bvalidator="required,email" data-bvalidator-msg="Please enter a valid email address">
                        <?php echo form_error('email'); ?>
                      </div>
                      <div class="form-group col-sm-6">
                        <label>Phone No. <span class="mandatory">*</span></label>
                        <div class="mobile-number-wrapper">
                          <div class="mobile-number-left">
                            <select name="country_code" id="country_code" class="form-control">
                              <?php
                                if(!empty($phnCode)){
                                foreach ($phnCode as $row){
                              ?>
                                <option <?php if(!empty($user->country_code)){ if($user->country_code==$row->phonecode){ echo "selected"; } }else if($row->phonecode=='91'){ echo "selected"; } ?> value="<?php echo $row->phonecode; ?>"><?php echo $row->sortname.' +'.$row->phonecode; ?></option>
                              <?php
                              } }
                              ?>
                            </select>
                          </div>
                          <div class="mobile-number-right">
                            <input type="text" class="form-control" id="mobile" value="<?php if(set_value('mobile')) echo set_value('mobile'); else if(!empty($user->mobile)) echo $user->mobile; ?>" name="mobile" placeholder="xxxxxxxxxx" data-bvalidator="maxlen[13],minlen[9],number,required" data-bvalidator-msg="Please enter a valid Phone No.">
                            <?php echo form_error('mobile'); ?>
                          </div>
                        </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="form-group col-sm-6">
                        <label>Country <span class="mandatory">*</span></label>
                        <select name="country" class="form-control" data-bvalidator="required" data-bvalidator-msg="Please select your country" id="country">
                          <option value="">--Select Country--</option>
                          <?php foreach ($country as $row) { ?>
                          <option <?php if($user->country==$row->id) echo "selected"; ?> value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                          <?php } ?>
                        </select>
                        <?php echo form_error('country'); ?>
                      </div>
                      <div class="form-group col-sm-6">
                        <label>State <span class="mandatory">*</span></label>
                        <?php
                          $getProvinceData = getDataResult('states', array('country_id'=>$user->country));
                        ?>
                        <select name="province" class="form-control" data-bvalidator="required" data-bvalidator-msg="Please select your state" id="state">
                          <option value="">--Select State--</option>
                          <?php if(!empty($getProvinceData)){ foreach ($getProvinceData as $row) { ?>
                          <option <?php if(!empty($user->province)  && $user->province!=0){ if($user->province==$row->id){ echo "selected='selected'"; } } ?> value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                          <?php } } ?>
                        </select>
                        <?php echo form_error('province'); ?>
                      </div>
                      <div class="clearfix"></div>
                      <div class="form-group col-sm-6">
                        <label>City <span class="mandatory">*</span></label>
                        <?php
                          $getCityData = getDataResult('cities', array('state_id'=>$user->province));
                        ?>
                        <select name="city" class="form-control" data-bvalidator="required" data-bvalidator-msg="Please select your city" id="city">
                          <option value="">--Select City--</option>
                          <?php if(!empty($getCityData)){ foreach ($getCityData as $row) { ?>
                          <option <?php if(!empty($user->city) && $user->city!=0){ if($user->city==$row->id){ echo "selected='selected'"; } } ?> value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                          <?php } } ?>
                        </select>
                        <?php echo form_error('city'); ?>
                      </div>
                      <div class="form-group col-sm-6">
                        <label>Postal Code</label>
                        <input autocomplete="off" type="text" data-bvalidator="maxlen[8],minlen[4]" data-bvalidator-msg="Please enter the valid postal code" class="form-control" name="zip" id="zip" value="<?php if(set_value('zip')){ echo set_value('zip'); }else if(!empty($user)){ echo $user->zip; } ?>" placeholder="452101">
                        <?php echo form_error('zip'); ?>
                      </div>
                      <div class="clearfix"></div>
                      <div class="form-group col-sm-12">
                        <label>Address</label><br>
                        <textarea name="address" placeholder="xyz street" rows="5" cols="10" class="form-control" id="address"><?php if(set_value('address')) echo set_value('address'); else if(!empty($user->address)) echo $user->address; ?></textarea>
                        <?php echo form_error('address'); ?>
                      </div>
                      <div class="form-group">
                        <div class="text-center">
                          <button id="btn-signup" type="submit" class="btn btn-red">Update Profile</button>
                        </div>
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
      $('#profileform').bValidator();
    });

    $("#tab1 #checkAll").click(function () {
        if ($("#tab1 #checkAll").is(':checked')) {
            $("#tab1 input[type=checkbox]").each(function () {
                $(this).prop("checked", true);
            });
   
        } else {
            $("#tab1 input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
        }
   });
    
</script>