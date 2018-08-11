<div class="body-container clearfix">
<div class="bread_parent">
  <ul class="breadcrumb">
    <li><a href="<?php echo base_url('seller/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
    <li><a href="<?php echo base_url('seller/products/index'); ?>">Products</a></li>
    <li><b>Add Product Category</b></li>
  </ul>
  <div class="clearfix"></div>
</div>

<div class="theme-container clearfix">
  <div class="clearfix"></div>
  <div class="col-md-12 col-lg-12">
    <div class="common-tab-wrapper">
      <div class="common-tab-system partners clearfix">
        <ul class="nav-common-tabs" role="tablist">
          <li class="active">
            <a href="<?php echo base_url().'seller/products/product_category'; ?>">
              <div><i class="icofont icofont-chart-flow-alt-1"></i></div>Product Categories</a>
          </li>
          <li <?php if($this->session->userdata('productcat_info')['status']==1) echo ""; else echo "class='disabled' style='pointer-events:none;'"; ?>>
            <a href="<?php echo base_url().'seller/products/product_basic_info'; ?>"><div><i class="icofont icofont-info-square"></i></div>Vital Info</a>
          </li>
          <li class='disabled' style='pointer-events:none;'>
            <a href="javascript:void(0)" ><div><i class="icofont icofont-document-search"></i></div>Variation</a>
          </li>
          <li class='disabled' style='pointer-events:none;'>
            <a href="javascript:void(0)" >
              <div><i class="icofont icofont-gift"></i></div>Offer</a>
          </li>
          <li class='disabled' style='pointer-events:none;'>
            <a href="javascript:void(0)" ><div><i class="icofont icofont-presentation-alt"></i></div>Compliance</a>
          </li>
          <li class='disabled' style='pointer-events:none;'>
            <a href="javascript:void(0)" ><div><i class="icofont icofont-image"></i></div>Images</a>
          </li>
          <li class='disabled' style='pointer-events:none;'>
            <a href="javascript:void(0)" ><div><i class="icofont icofont-list"></i></div>Product Description</a>
          </li>
          <li class='disabled' style='pointer-events:none;'><a href="javascript:void(0)" ><div><i class="icofont icofont-key"></i></div>Keywords</a>
          </li>
          <li class='disabled' style='pointer-events:none;'><a href="javascript:void(0)" ><div>
            <i class="icofont icofont-stock-search"></i></div>Meta Information</a>
          </li>
        </ul>
      </div>
      <div class="clearfix"></div>
      <div class="common-contain-wrapper clearfix">
        <div class="">
          <div class="">
            <div class="">
              <div class="common-panel panel">
                <div class="panel-heading">
                  <div class="panel-title"><i class="icofont icofont-chart-flow-alt-1"></i> Choose Product Categories</div>
                </div>
                <div class="panel-body">
                  <div class="col-sm-6 center-block">
                    <form role="form" autocomplete="off" class="product_cat" action="<?php echo current_url()?>" method="post" data-bvalidator-validate>
                      <div class="form-group">
                          <select class="form-control productcategory" name="productcategory[]" main="0" onchange="getsubcat(this);" data-bvalidator="required">
                            <option value="">--Select Category--</option>
                            <?php foreach ($main_category as $row) { ?>
                              <option value="<?php echo $row->category_id; ?>"><?php echo ucfirst($row->category_name); ?></option>
                            <?php } ?>
                          </select>
                         <div class="clearfix"></div>
                         <?php echo form_error('productcategory'); ?>
                      </div>
                      <div class="subcat0"></div>
                      <div class="form-actiosns form-btn-block text-center">
                        <input class="btn btn-red selectProductCat" type="submit" name="selectProductCat" id="selectProductCat" value="Continue">
                      </div>
                    </form>
                  </div>
                  <div class="choose-product-categorie-wrap">
                    <div class="flex-product-wrapper">
                      <div class="flex-block" style="flex: 0 1 0%;">
                        <div class="flex-tile">
                          <div class="choose-product-block flex-block">
                            <div class="choose-product-block-inner">
                              <div class="choose-product-tile">
                                <ul class="choose-product-list" id="scrollbar-design">
                                  <?php foreach ($main_category as $row) { ?>
                                  <li catval="<?php echo $row->category_id; ?>" class="choose-product-name"><?php echo ucfirst($row->category_name); ?></li>
                                  <?php } ?>
                                  <li class="choose-product-name">Electronic</li>
                                </ul>
                              </div>
                            </div>
                          </div>
                          <div class="choose-product-block flex-block" style="display: none;">
                            <div class="choose-product-block-inner">
                              <div class="choose-product-tile">
                                <ul class="choose-product-list" id="scrollbar-design">
                                  <li class="choose-product-name">Kids & Baby products</li>
                                  <li class="choose-product-name active">Men's Fashion</li>
                                  <li class="choose-product-name">Women's Fashion</li>
                                </ul>
                              </div>
                            </div>
                            <div class="arrow-shadow"></div>
                          </div>
                          <div class="choose-product-block flex-block" style="display: none;">
                            <div class="choose-product-block-inner">
                              <div class="choose-product-tile">
                                <ul class="choose-product-list" id="scrollbar-design">
                                  <li class="choose-product-name">Accessories</li>
                                  <li class="choose-product-name">Men's Clothing</li>
                                  <li class="choose-product-name active">Stores</li>
                                </ul>
                              </div>
                            </div>
                            <div class="arrow-shadow"></div>
                          </div>
                          <div class="choose-product-block flex-block" style="display: none;">
                            <div class="choose-product-block-inner">
                              <div class="choose-product-tile">
                                <ul class="choose-product-list" id="scrollbar-design">
                                  <li class="choose-product-name"><?php echo ucwords(SITE_NAME); ?> Fashion</li>
                                  <li class="choose-product-name">Fashion sales & deals</li>
                                  <li class="choose-product-name">Men's Fashion</li>
                                  <li class="choose-product-name">Sportswear</li>
                                  <li class="choose-product-name active">The designer boutique</li>
                                </ul>
                              </div>
                            </div>
                            <div class="arrow-shadow"></div>
                          </div>
                        </div>
                      </div>
                      <div class="flex-block">
                        <div class="select-product-catg-wrap">
                          <div class="arrow-shadow"></div>
                          <div class="select-product-catg-inner">
                            <div class="choose-product-tile">
                              <div class="chosse-product-bradcrum" style="display: none;">
                                  <span class="heading">category</span>
                                  <span class="current">The designer boutique</span>
                              </div>
                              <div class="select-box-content">
                                <i class="icofont icofont-chart-flow-alt-1"></i>
                                <div>Select the category you wish to sell.</div>
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
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<script>
  var SITE_URL = "<?php echo base_url(); ?>";
  window.sessionStorage.removeItem('chooseProductType');
  
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