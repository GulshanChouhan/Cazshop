<div class="body-container clearfix">
<div class="bread_parent">
  <ul class="breadcrumb">
    <li><a href="<?php echo base_url('seller/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
    <li><a href="<?php echo base_url('seller/products/index'); ?>">Products</a></li>
    <li><b>Product Meta Info</b></li>
  </ul>
  <div class="clearfix"></div>
</div>

<div class="theme-container clearfix">
  <div class="clearfix"></div>
  <div class="col-md-12 col-lg-12">
    <div class="common-tab-wrapper">
      <div class="common-tab-system partners clearfix">
        <?php $this->load->view('seller/products/tabMenus'); ?>
   
          <?php
            if(!empty($product_info_id) && !empty($product_variation_id)){
              if($product_variationsData->type_of_product==2){
                $showForm = 0;
              }else{
                $showForm = 1;
              }
            }else if(!empty($product_info_id)){
              $showForm = 1;
            }
          ?>
      </div>
      <div class="clearfix"></div>
      <div class="common-contain-wrapper clearfix">
        <div class="">
          <div class="">
            <div class="">
              <div class="common-panel panel">
                <div class="panel-heading">
                  <div class="panel-title"><i class="icofont icofont-stock-search"></i> Product SEO Information <?php if(!empty($product_info->title)) echo ' - "'.ucfirst($product_info->title).'"'; ?></div>
                  <div class="category-breadcrum">
                    <?php
                      $category=explode(',',$product_info->category_id);
                      $bread=get_category_bread_crumb_seller($category[sizeof($category)-1]);
                         if(!empty($bread))
                          {
                            $bread=array_reverse($bread);
                            echo implode(' / ',$bread);
                         
                          } 
                      ?>
                  </div>
                </div>
                <div class="panel-body">
                  <div class="col-sm-8 center-block">
                    <?php if($showForm==1){ ?>
                    <form autocomplete="off" role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post" data-bvalidator-validate>
                      <?php echo $this->session->flashdata('msg_error');?>

                      <?php if(empty($product_seo_info)){ ?>
                      <div class="form-group">
                        <label class="col-md-4 control-label">Meta Title <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Enter the Meta Title. (Max length 60 characters)"></span> :</label>
                        <div class="col-md-8">
                          <input data-bvalidator="maxlen[60]" type="text" placeholder="Example: Secondary Keyword | Brand Name" class="form-control" name="meta_title" value="<?php echo set_value('meta_title');?>" > <span class="error"><?php echo form_error('meta_title'); ?> </span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label">Meta Keywords <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Enter the Meta Keywords. (Max length 100 characters)"></span> :</label>
                        <div class="col-md-8">
                          <input data-bvalidator="maxlen[100]" type="text" placeholder="Example: Blue Washed Slim Fit Jeans, Moda Rapido, Clothing, Jeans" class="form-control" name="meta_keywords" value="<?php echo set_value('meta_keywords');?>" > <span class="error"><?php echo form_error('meta_keywords'); ?> </span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label">Meta Description <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Enter the Meta Description. (Max length 170 characters)"></span> :</label>
                        <div class="col-md-8">
                          <textarea data-bvalidator="maxlen[170]" class="form-control" placeholder="Example: Shop Moda Rapido Blue Washed Slim Fit Jeans online. Slim fit and soft material of these jeans will keep you at ease all day long. Jump off a roof or slide down a hilltop to taste the thrill first-hand in these jeans" name="meta_description" rows="5" cols="10"></textarea>
                            <span class="error"><?php echo form_error('meta_description'); ?> </span>
                        </div>
                      </div>
                      <div class="col-md-4"></div>
                      <div class="col-md-8">
                        <div class="form-actiosns form-btn-block text-center">
                          <button  class="btn btn-red" type="submit">Submit</button>
                          <a class="btn btn-default-white" href="<?php echo base_url('seller/products/product_keywords/'.$product_info_id.'/'.$product_variation_id.'/'.$type)?>">Back</a>
                        </div>
                      </div>
                      <?php }else{ ?>
                       <div class="form-group">
                         <label class="col-md-4 control-label">Meta Title <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Enter the Meta Title. (Max length 60 characters)"></span> :</label>
                         <div class="col-md-8">
                            <input type="text" data-bvalidator="maxlen[60]" placeholder="Meta Title" class="form-control" name="meta_title" value="<?php if(set_value('meta_title')){ echo set_value('meta_title'); }else{ echo $product_seo_info->meta_title; } ?>" > <span class="error"><?php echo form_error('meta_title'); ?> </span>
                         </div>
                      </div>
                      <div class="form-group">
                         <label class="col-md-4 control-label">Meta Keywords <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Enter the Meta Keywords. (Max length 100 characters)"></span> :</label>
                         <div class="col-md-8">
                            <input type="text" data-bvalidator="maxlen[100]" placeholder="Meta Keywords" class="form-control" name="meta_keywords" value="<?php if(set_value('meta_keywords')){ echo set_value('meta_keywords'); }else{ echo $product_seo_info->meta_keywords; } ?>" > <span class="error"><?php echo form_error('meta_keywords'); ?> </span>
                         </div>
                      </div>
                      <div class="form-group">
                         <label class="col-md-4 control-label">Meta Description <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Enter the Meta Description. (Max length 170 characters)"></span> :</label>
                         <div class="col-md-8">
                            <textarea class="form-control" data-bvalidator="maxlen[170]" placeholder="Meta Description" name="meta_description" rows="5" cols="10"><?php if(set_value('meta_description')){ echo set_value('meta_description'); }else{ echo $product_seo_info->meta_description; } ?></textarea>
                            <span class="error"><?php echo form_error('meta_description'); ?> </span>
                         </div>
                      </div>
                      <div class="col-md-4"></div>
                      <div class="col-md-8">
                        <div class="form-actiosns form-btn-block text-center">
                          <button  class="btn btn-red" type="submit">Update</button>
                          <a class="btn btn-default-white" href="<?php echo base_url('seller/products/product_keywords/'.$product_info_id.'/'.$product_variation_id.'/'.$type)?>">Back</a>
                        </div>
                      </div>
                    <?php } ?>
                    </form>
                    <!-- END FORM--> 
                    <?php }else{ ?>
                      <div class="col-md-12 text-center">
                        <h4><b><i class="fa fa-info-circle" aria-hidden="true"></i> We have not permitted you to edit the Product SEO Information</b></h4>
                      </div>
                    <?php } ?>
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
</div>
<script>
  $(document).ready(function(){
    $('form').bValidator();
  });
</script>