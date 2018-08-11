<div class="body-container clearfix">
<div class="bread_parent">
  <ul class="breadcrumb">
    <li><a href="<?php echo base_url('seller/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
    <li><a href="<?php echo base_url('seller/products/index'); ?>">Products</a></li>
    <li><b>Product Keywords</b></li>
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
                  <div class="panel-title"><i class="icofont icofont-key"></i> Search term of product <?php if(!empty($product_info->title)) echo ' - "'.ucfirst($product_info->title).'"'; ?></div>
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
                  <div class="col-sm-6 center-block">
                    <?php if($showForm==1){ ?>
                    <form role="form" autocomplete="off" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post" data-bvalidator-validate>
                      <div class="input_fields_container">
                      <?php 
                       if(empty($_POST))
                        $keywords = json_decode($product_info->keywords);
                        if(!empty($keywords)){
                          $keywords = implode(", ", $keywords);
                      ?>
                      
                        <div class="form-group">
                          <label class="col-md-4 control-label">Search Terms   <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Enter the keywords for your product. These keywords will help the users to search your product easily."></span> : </label>
                          <div class="input-group col-md-8 keyField">
                             <input autocomplete="off" data-bvalidator="required" class="form-control tags"  name="keywords" value="<?php echo $keywords; ?>" type="text" />
                          </div>
                        </div>
                      <?php 
                         }else{
                        if(empty($bread)){ 
                      ?>
                        <div class="form-group">
                          <label class="col-md-4 control-label">Search Terms <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Enter the keywords for your product. These keywords will help the users to search your product easily."></span> :</label>
                          <div class="input-group col-md-8">
                             <input autocomplete="off" data-bvalidator="required" class="form-control tags"  name="keywords" type="text" />
                          </div>
                        </div>
                      <?php }else{
                        $numItems = count($bread);
                        $keywords = implode(", ", $bread);
                        $i = 0;
                      ?>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Search Terms <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Enter the keywords for your product. These keywords will help the users to search your product easily."></span> :</label>
                            <div class="input-group col-md-8">
                               <input autocomplete="off" data-bvalidator="required" class="form-control tags"  name="keywords" type="text" value="<?php echo $keywords; ?>" data-items="8"/>
                            </div>
                        </div>
                      <?php }
                        } ?>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label"></label>
                        <div class="input-group col-md-8">
                          <span class="error"><?php echo form_error('keywords'); ?> </span>
                        </div>
                      </div>                      
                      <div class="col-md-4"></div>
                      <div class="col-md-8">
                        <div class="form-actiosns form-btn-block text-center">
                          <button  class="btn btn-red" type="submit">Continue</button>
                          <a class="btn btn-default-white" href="<?php echo base_url('seller/products/product_descriptions/'.$product_info_id.'/'.$product_variation_id.'/'.$type)?>">Back</a>
                        </div>
                      </div>
                 
                    </form>
                    <!-- END FORM--> 
                    <?php }else{ ?>
                      <div class="col-md-12 text-center">
                        <h4><b><i class="fa fa-info-circle" aria-hidden="true"></i> We have not permitted you to edit the Product Keywords Information</b></h4>
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
<script src="<?php echo SELLER_THEME_URL; ?>js/bootstrap-tagsinput.min.js"></script>
<link rel="stylesheet" href="<?php echo SELLER_THEME_URL; ?>css/bootstrap-tagsinput.css" />
<script>
  $(document).ready(function(){

    var max_fields_limit      = 10; //set limit for maximum input fields
    var x = 1; //initialize counter for text box
    $('body').on('click', '.add_more_button', function(e){ //click event on add more fields button having class add_more_button

      e.preventDefault();
      x++; //counter increment

      
      $(this).parent('.input-group-addon').append('<a href="javatpoint:void(0)" class="remove_field color-red"><i class="icofont icofont-ui-remove"></i> Remove</a>'); //add input field
      $(this).remove();


      $('.input_fields_container').append('<div class="form-group"><label class="col-md-4 control-label">Search Terms <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Enter the keywords for your product. These keywords will help the users to search your product easily."></span> :</label><div class="input-group col-md-8 keyField"><input data-bvalidator="required" autocomplete="off" class="input form-control" placeholder="Example: Jeans"  name="keywords[]" type="text"><div class="input-group-addon"><a href="javatpoint:void(0)" class="add_more_button color-red"><i class="icofont icofont-ui-add"></i> Add More Fields</a></div></div></div>'); //add input field

      $.getScript("<?php echo SELLER_THEME_URL; ?>js/bootstrap.min.js", function() {
          $('.tooltips').tooltip();
      });

    });  

    $('.input_fields_container').on("click",".remove_field", function(e){ //user click on remove text links
      e.preventDefault(); $(this).parents('div.form-group').remove(); x--;
    });

    $('form').bValidator();

    $('.tags').tagsinput({
      allowDuplicates: false
    });

  });
</script>   