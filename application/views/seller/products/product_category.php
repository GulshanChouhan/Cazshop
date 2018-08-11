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
              <div><i class="icofont icofont-gift"></i></div>Product Definition/Offer</a>
          </li>
          <li class='disabled' style='pointer-events:none;'>
            <a href="javascript:void(0)" ><div><i class="icofont icofont-presentation-alt"></i></div>Compliance</a>
          </li>
          <li class='disabled' style='pointer-events:none;'>
            <a href="javascript:void(0)" ><div><i class="icofont icofont-image"></i></div>Images/Videos</a>
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
        <div class="common-panel panel">
          <div class="panel-heading">
            <div class="panel-title"><i class="icofont icofont-chart-flow-alt-1"></i> Choose Product Categories</div>
          </div>
          <div class="panel-body">
            <form role="form" autocomplete="off" class="product_cats" action="<?php echo current_url()?>" method="post">
              <p><b>Note -</b> If the categories are not appearing here in which you wish to sell your products, then <a target="_blank" href="<?php echo base_url('seller/seller_information/'.base64_encode(seller_id())); ?>" class="link-text"><b>Click Here</b></a> to add them.</p>
              <input type="hidden" name="productcategories" id="productcategories" value="">
              <div class="choose-product-categorie-wrap" style="overflow-y: hidden;">
                <div class="flex-product-wrapper">
                  <div class="flex-block" style="flex: 0 1 0%;">
                    <div class="flex-tile">
                      <div class="choose-product-block flex-block">
                        <div class="choose-product-block-inner">
                          <div class="choose-product-tile">
                            <ul class="choose-product-list" id="scrollbar-design">
                              <?php 
                                foreach ($main_category as $row) {
                                  $subcategoryExist = "";
                                  $dataCats = getRow('category',array('parent_id'=>$row->category_id));
                                  if(!empty($dataCats)) $subcategoryExist = "<i class='icofont icofont-simple-right'></i>"; 
                              ?>
                              <li mainnew="0" catval="<?php echo $row->category_id; ?>" class="choose-product-name getsubcatnew"><?php echo ucfirst($row->category_name).''.$subcategoryExist; ?></li>
                              <?php } ?>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="flex-block">
                    <div class="select-product-catg-wrap">
                      <div class="arrow-shadow"></div>
                      <div class="select-product-catg-inner">
                        <div class="choose-product-tile">
                          <div class="chosse-product-bradcrum">
                          </div>
                          <div class="select-box-content">
                            <span class="cat-selection">
                              <i class="icofont icofont-chart-flow-alt-1"></i>
                              <div>Select the category you wish to sell.</div><br>
                            </span>
                            <input disabled="disabled" type="submit" name="selectProductCat" class="btn btn-red selectProductCat" value="Continue">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
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

<script>

  var SITE_URL = "<?php echo base_url(); ?>";
  window.sessionStorage.removeItem('chooseProductType');
  
  $(document).ready(function(){
    $('form').bValidator();
  });


  /*====---------------------------New Code for product category---------------------------====*/
  $(document).on('click','.getsubcatnew', function(){
    var thisCls   = $(this);
    if(thisCls){

      var category = thisCls.attr('catval');
      var mainnew  = thisCls.attr('mainnew');
      var curVal   = thisCls.text();

      parentCls = thisCls.parents('.choose-product-block:first');
      thisCls.addClass('active').siblings().removeClass('active');
      thisCls.addClass('active');
      $('.selectProductCat').removeAttr('disabled');

      if(category){
        $.ajax({
          url: SITE_URL + 'seller/products/getProductSubcategoryNew',
          type: 'POST',
          data: {
             category: category,
             mainnew: mainnew
          },
          cache: false,
          success: function(result) {
            var data = JSON.parse(result);
            for (var i = data.level + 1; i < 15; i++) {
              $(".bdc"+i).remove();
            }
            if(data.status=='success'){
              $('.cat-selection').hide();
              parentCls.nextAll('.choose-product-block').remove();
              parentCls.after(data.optionData);
            }else{
              parentCls.nextAll('.choose-product-block').remove();
            }

            $('.choose-product-categorie-wrap').css('overflowY', 'auto'); 

            if(curVal){ //for showing breadcrumb cats name
              var cloneData = $(".chosse-product-bradcrum").clone().html();
              $(".chosse-product-bradcrum").html(cloneData+'<span class="bdccn bdc'+data.level+' current">'+curVal+'<i class="icofont icofont-simple-right"></i></span>');
              $(".bdc"+data.level+':not(:last)').remove();
              $(".bdc"+data.level).nextAll('.bdccn').remove();
              $(".chosse-product-bradcrum").children().removeClass('current').addClass('heading');
              $(".bdccn:last").addClass('current');
              $('.chosse-product-bradcrum .selectedcatslabel').remove();
              $('.chosse-product-bradcrum').prepend('<p class="selectedcatslabel">You have Selected  -</p> ');
            }

          },
        });
      }
    }
  });

  $(document).on('click','.selectProductCat', function(){
    var s1 = [];
        $("ul.choose-product-list").each(function(){
        row = $(this).find('li.active').attr('catval');
        s1.push(row);
    });

    if(s1){
      $('#productcategories').val(s1.toString());
      $('.product_cats').submit();
    }else{
      return false;
    }

  });
</script>