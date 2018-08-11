<div class="body-container clearfix">
<div class="bread_parent">
  <ul class="breadcrumb">
    <li><a href="<?php echo base_url('seller/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
    <li><a href="<?php echo base_url('seller/products/index'); ?>">Products</a></li>
    <li><b>Edit Product Category</b></li>
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
                  <div class="panel-title"><i class="icofont icofont-chart-flow-alt-2"></i> Update Product Categories <?php if(!empty($product_info->title)) echo ' - "'.ucfirst($product_info->title).'"'; ?></div>
                </div>
                <div class="panel-body">
                  <div class="col-sm-6 center-block">
                    <?php if($showForm==1){ ?>
                    <form role="form" autocomplete="off" class="form-horizontal product_cat" action="<?php echo current_url()?>" method="post" data-bvalidator-validate>
                      <div class="form-group">
                        <select class="form-control productcategory subcategory0" name="productcategory[]" main="0" onchange="getsubcat(this);" data-bvalidator="required">
                          <option value="">--Select Category--</option>
                          <?php foreach ($main_category as $row) { ?>
                            <option value="<?php echo $row->category_id; ?>"><?php echo ucfirst($row->category_name); ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="subcat0"></div>
                      <div class="form-actiosns form-btn-block text-center">
                        <input class="btn btn-red selectProductCat" type="submit" name="selectProductCat" id="selectProductCat" value="Continue">
                      </div>
                    </form>
                    <?php }else{ ?>
                      <div class="col-md-12 text-center">
                        <h4><b><i class="fa fa-info-circle" aria-hidden="true"></i> We have not permitted you to edit the Product Category Information</b></h4>
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
  var arrSubCat = [];
  var SITE_URL  = "<?php echo base_url(); ?>";
  var edit_cat  = "<?php echo $product_info->category_id; ?>";
  var edit_cat  = edit_cat.split(",");

  for(var i=0;i<edit_cat.length;i++){
    $('.subcategory'+i).val(edit_cat[i]);
      $.ajax({
           url: SITE_URL + 'seller/products/getProductSubcategory',
           type: 'POST',
           async:false,
           data: {
               category: edit_cat[i],
               main:i
           },
           cache: false,
           success: function(result) {
              var data = JSON.parse(result);
              $('.subcat'+i).append(data.optionData);
           },
       });
  }

  function getsubcat(cat){
   var category = $(cat).val();
   var main=$(cat).attr('main');
    $('.subcat'+main).html('');
     if(category){
        $.ajax({
           url: SITE_URL + 'seller/products/getProductSubcategory',
           type: 'POST',
           data: {
               category: category,
               main:main
           },
           cache: false,
           success: function(result) {
              var data = JSON.parse(result);
              $('.subcat'+main).append(data.optionData);
           },
       });
     }
  }

  $(document).ready(function(){
    $('form').bValidator();
  });
  
</script>