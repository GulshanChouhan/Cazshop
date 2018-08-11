<div class="bread_parent">
<ul class="breadcrumb">
    <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
    <li><a href="<?php echo base_url('backend/slider/sliders'); ?>">Home Page Setting</a></li>
     <li><a href="<?php echo base_url('backend/content/client_feedback'); ?>">Client Feedback</a></li>
      <li><a href=""><b>Add Client Feedback</b> </a></li>             
</ul>
</div><br>

  <div class="panel-body">
       <form role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post">
          <?php echo $this->session->flashdata('msg_error');?>
          <div class="form-body">

             <div class="form-group">
              <label class="col-md-2 control-label">Client Name<span class="mandatory">*</span></label>
              <div class="col-md-9">
                <input type="text" placeholder="Client Name" class="form-control" name="name" value="<?php echo set_value('name');?>"><?php echo form_error('name'); ?>
              </div>
            </div> 
            <div class="form-group">
              <label class="col-md-2 control-label">Designation and company name<span class="mandatory">*</span></label>
              <div class="col-md-9">
                <input type="text" placeholder="Eg :Hamptons Chamber of Commerce, Secretary" class="form-control" name="designation" value="<?php echo set_value('designation');?>"><?php echo form_error('designation'); ?>
              </div>
            </div>             
            <div class="form-group">
              <label class="col-md-2 control-label">Client Image<span class="mandatory">*</span></label>
              <div class="col-md-9">
                <input type="file"  name="client_image" value="<?php echo set_value('client_image');?>"><?php echo form_error('client_image'); ?>
                 <b>Client Image must be atleast 260 X 260 px and at max 300 X 300 px. And allowed file type is jpeg,jpg and png.</b> 
              </div>
            </div>

             <div class="form-group">
              <label class="col-md-2 control-label">Feedback<span class="mandatory">*</span></label>
              <div class="col-md-9">
                <div class="input-group">
                  <textarea class=" form-control" cols="100" rows="5" id="feedback" maxlength="230" name="feedback" placeholder="Provide the client feedback here..."><?php echo set_value('feedback');?></textarea>
                  <?php echo form_error('feedback'); ?>
                  <b>Please add the feedback in maximum 200 characters or maximum 30-35 words</b>
                </div>
              </div>
            </div>         
       
             <div class="form-group">
              <label class="col-md-2 control-label">Order Sequence<span class="mandatory">*</span></label>
              <div class="col-md-10">
                <div class="input-group">
                   <input type="text" placeholder="Arrange order No" class="form-control" name="order" value="" data-bvalidator="number,required" data-bvalidator-msg="Order No is required and must be a number">
                  <?php echo form_error('order'); ?>                
                </div>
              </div>
            </div>

          
          </div>
          <div class="form-actiosns fluid">
            <div class="col-md-offset-2 col-md-10">
              <button  class="btn btn-primary" type="submit">Submit</button>
              <a class="btn btn-danger" href="<?php echo base_url()?>backend/content/client_feedback">
               Cancel</a>                              
              </div>
            </div>
          </form>
          <!-- END FORM--> 
        </div>


    <script language="javascript" type="text/javascript">
    $(document).ready( function () {
  maxLength = $("textarea#feedback").attr("maxlength");
        $("textarea#feedback").after("<div><span id='remainingLengthTempId'><small>" 
                  + maxLength + "</small></span> <small>Character limit</small></div>");
        $("textarea#feedback").bind("keyup change", function(){checkMaxLength(this.id,  maxLength); } )
    });
    function checkMaxLength(textareaID, maxLength){
        currentLengthInTextarea = $("#"+textareaID).val().length;
        $(remainingLengthTempId).text(parseInt(maxLength) - parseInt(currentLengthInTextarea));
    if (currentLengthInTextarea > (maxLength)) { 
      // Trim the field current length over the maxlength.
      $("textarea#feedback").val($("textarea#feedback").val().slice(0, maxLength));
      $(remainingLengthTempId).text(0);
    }
    }
</script>    

