<div class="bread_parent">
  <ul class="breadcrumb">
    <li><a href="<?php echo base_url('seller/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
    <li><a href="<?php echo base_url('seller/products/index'); ?>">List of Products</a></li>
    <li><a href="<?php echo base_url('seller/products/product_faq/'.$product_variation_id); ?>">Product FAQs</a></li>
    <li>Add Product FAQs Info</li>
  </ul>
  <div class="clearfix"></div>
</div>

<div class="theme-container clearfix">
  <div class="clearfix"></div>
  <div class="col-md-12 col-lg-12">
    <div class="common-tab-wrapper">
      <div class="common-contain-wrapper clearfix">
        <div class="">
          <div class="">
            <div class="">
              <div class="common-panel panel">
                <div class="panel-heading">
                  <div class="panel-title"><i class="icofont icofont-stock-search"></i> Product FAQs Information</div>
                </div>
                <div class="panel-body">
                  <div class="col-sm-8 center-block">
                    <form autocomplete="off" role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post" data-bvalidator-validate>
                      <?php echo $this->session->flashdata('msg_error');?>

                      <div class="form-group">
                        <label class="col-md-4 control-label">Question<span class="mandatory">*</span> :</label>
                        <div class="col-md-8">
                          <input data-bvalidator="required" type="text" placeholder="Enter your question here" class="form-control" name="question" value="<?php echo set_value('question');?>" > <span class="error"><?php echo form_error('question'); ?> </span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label">Answer<span class="mandatory">*</span> :</label>
                        <div class="col-md-8">
                          <textarea data-bvalidator="required" class="form-control" placeholder="Enter your answer here" name="answer" rows="5" cols="10"></textarea>
                            <span class="error"><?php echo form_error('answer'); ?> </span>
                        </div>
                      </div>
                      <div class="col-md-4"></div>
                      <div class="col-md-8">
                        <div class="form-actiosns form-btn-block text-center">
                          <button  class="btn btn-red" type="submit">Submit</button>
                          <a class="btn btn-default-white" href="<?php echo base_url('seller/products/product_faq/'.$product_variation_id)?>">Back</a>
                        </div>
                      </div>
                    </form>
                    <!-- END FORM--> 
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){
    $('form').bValidator();
  });
</script>