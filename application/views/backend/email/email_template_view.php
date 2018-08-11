<div class="box paint color_0">
   <div class="title">
      <h4> <i class="icon-envelope-alt"></i> <span>View Email & SMS Template</span> </h4>
   </div>
   <div class="content">

      <div class="form-row control-group row-fluid">
         <label class="control-label span3" for="normal-field">Template Name</label>
         <div class="controls span9">
            <?php if(!empty($email_template->template_name)) echo $email_template->template_name ;?>
         </div>
      </div>
      <div class="form-row control-group row-fluid">
         <label class="control-label span3" for="normal-field">Subject</label>
         <div class="controls span9">
            <?php if(!empty($email_template->template_subject)) echo $email_template->template_subject ;?>
         </div>
      </div>
      <div class="form-row control-group row-fluid">
         <label class="control-label span3" for="normal-field">Body</label>
         <div class="controls span9">
            <?php if(!empty($email_template->template_body))  echo $email_template->template_body; ?>
         </div>
      </div>

      <div class="clearfix"></div>

      <div class="form-row control-group row-fluid">
         <div class="span3 visible-desktop">
            <div class="span4">
            </div>
         </div>
      </div>
   </div>
   <!-- End .content-->
</div>
<!-- End .box -->