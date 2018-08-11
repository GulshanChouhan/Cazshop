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
                  <div class="panel-title"><i class="icofont icofont-chart-flow-alt-1"></i> Update Product Categories <?php if(!empty($product_info->title)) echo ' - "'.ucfirst($product_info->title).'"'; ?></div>
                </div>
                <div class="panel-body">
                  <?php if($showForm==1){ ?>

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
                                    <input type="submit" name="selectProductCat" class="btn btn-red selectProductCat" value="Continue">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
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

<script>
  var arrSubCat = [];
  var SITE_URL  = "<?php echo base_url(); ?>";
  var edit_cat  = "<?php echo $product_info->category_id; ?>";
  var edit_cat  = edit_cat.split(",");

  $(document).ready(function(){
    $('form').bValidator();
  });


  /*====---------------------------New Code for edit product category---------------------------====*/

  for(var i=0;i<edit_cat.length;i++){
    $(".choose-product-block").find("[catval='"+edit_cat[i]+"']").addClass('active');
    var curVal = $(".choose-product-block").find("[catval='"+edit_cat[i]+"']").text();

    $.ajax({
      url: SITE_URL + 'seller/products/getProductSubcategoryNew',
      type: 'POST',
      async: false,
      data: {
         category: edit_cat[i],
         mainnew: i
      },
      cache: false,
      success: function(result) {
        var data = JSON.parse(result);
        for (var i = data.level + 1; i < 15; i++) {
          $(".bdc"+i).remove();
        }
        $(".choose-product-block:last").after(data.optionData);

        if(curVal){ //for showing breadcrumb cats name
          $('.cat-selection').hide();
          var cloneData = $(".chosse-product-bradcrum").clone().html();
          $(".chosse-product-bradcrum").html(cloneData+'<span class="bdccn bdc'+data.level+' current">'+curVal+'<i class="icofont icofont-simple-right"></i></span>');
          $(".bdc"+data.level+':not(:last)').remove();
          $(".bdc"+data.level).nextAll('.bdccn').remove();
          $(".chosse-product-bradcrum").children().removeClass('current').addClass('heading');
          $(".bdccn:last").addClass('current');
          $('.chosse-product-bradcrum .selectedcatslabel').remove();
          $('.chosse-product-bradcrum').prepend('<p class="selectedcatslabel">You have selected -</p> ');
        }

      },
    });

  }

  
  $(document).on('click','.getsubcatnew', function(){
    var thisCls   = $(this);
    if(thisCls){

      var category = thisCls.attr('catval');
      var mainnew  = thisCls.attr('mainnew');
      var curVal   = thisCls.text();

      parentCls = thisCls.parents('.choose-product-block:first');
      thisCls.addClass('active').siblings().removeClass('active');
      thisCls.addClass('active');

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
              parentCls.nextAll('.choose-product-block').remove();
              parentCls.after(data.optionData);
            }else{
              parentCls.nextAll('.choose-product-block').remove();
            }

            if(curVal){ //for showing breadcrumb cats name
              var cloneData = $(".chosse-product-bradcrum").clone().html();
              $(".chosse-product-bradcrum").html(cloneData+'<span class="bdccn bdc'+data.level+' current">'+curVal+'<i class="icofont icofont-simple-right"></i></span>');
              $(".bdc"+data.level+':not(:last)').remove();
              $(".bdc"+data.level).nextAll('.bdccn').remove();
              $(".chosse-product-bradcrum").children().removeClass('current').addClass('heading');
              $(".bdccn:last").addClass('current');
              $('.chosse-product-bradcrum .selectedcatslabel').remove();
              $('.chosse-product-bradcrum').prepend('<p class="selectedcatslabel">You have Selected -</p> ');
            }

          },
        });
      }
    }
  });
  /*----====================-----*/

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