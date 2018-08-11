<div class="body-container clearfix">
<div class="bread_parent">
  <ul class="breadcrumb">
    <li><a href="<?php echo base_url('seller/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
    <li><a href="<?php echo base_url('seller/products/index'); ?>">Products</a></li>
    <li><b>Product Variations</b></li>
  </ul>
  <div class="clearfix"></div>
</div>

<div class="theme-container clearfix">
  <div class="clearfix"></div>
  <div class="col-md-12 col-lg-12">
    <div class="common-tab-wrapper">
      <div class="common-tab-system partners clearfix">
        <?php $this->load->view('seller/products/tabMenus'); ?>
      </div>
      <div class="clearfix"></div>
      <div class="common-contain-wrapper clearfix">
        <div class="">
          <div class="">
            <div class="">
              <div class="common-panel panel">
                <div class="panel-heading">
                  <div class="panel-title"><i class="icofont icofont-document-search"></i> Product Variations Information <?php if(!empty($product_info->title)) echo ' - "'.ucfirst($product_info->title).'"'; ?></div>
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
                <?php 
                  if(empty($product_offer)){ 
                ?>
                <div class="panel-body">

                  <?php if(empty($product_variation_details)){ ?>
                  <div class="highlight-info-box">
                    <h4 class="color-red">You must have to select variation theme first :</h4>
                      <ul>
                        <li>Fields will be appear as per the selection of variation theme.</li>
                        <li>Selection of the variation theme should be as per the basis of product's nature. <br><b>For example - </b> if any product's  specification needs the attributes for color & size then you should select the theme which is belong to needed attributes.</li>
                        <li>Once you submitted the variation details of the products then the sections of <b>Offer</b> and <b>Image</b> will be hided.</li>
                      </ul> 
                  </div><br>
                  <?php } ?>


                  <div class="col-sm-12">
                    <form  autocomplete="off" role="form" class="form-horizontal tasi-form" action="<?php echo current_url(); ?>" enctype="multipart/form-data" method="post" data-bvalidator-validate>
                      <?php echo $this->session->flashdata('msg_error');?>

                      <?php if(empty($product_variation_details)){ ?>
                      <div class="col-sm-6 center-block">
                        <div class="form-group">
                          <label class="col-md-4 control-label">Variation Theme :</label>
                          <div class="col-md-8">
                            <select class="form-control variation_theme" name="variation_theme" onchange="variation_theme_change(this)" data-bvalidator="required">
                               <option value="">--Select Theme--</option>
                               <?php 
                               if(!empty($variation_themes)){ 
                                foreach ($variation_themes as $row) { 
                               ?>
                                  <option value="<?php echo $row->product_theme_id; ?>"><?php echo $row->product_theme_title; ?></option>
                               <?php } } ?>
                            </select>
                            <span class="error"><?php echo form_error('variation_theme'); ?> </span>
                          </div>
                        </div>
                      </div>
                      <?php } ?>
                      <br>
                      <!-- ===========Start=========== -->
                      <div class="row inside-common-panel panel panel-info variationUsingTheme" style="display: none;">
                        <div class="panel-heading">
                          <div class="panel-title"><?php if(empty($product_variation_details)){ ?>Add Variations<?php }else{ ?>All Variation Terms Information<?php } ?>
                          </div>
                        </div>
                        <div class="panel-body">
                          <div class="clearfix"></div>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="highlight-info-box">
                                  <h4 class="color-red"><?php if(empty($product_variation_details)){ ?>Fill all your variation terms for the theme below.<?php }else{ ?>Below is the Variations terms according to theme.<?php } ?></h4>
                                  <ul>
                                    <li>You can make the variations of the product with the combinations of color, size, material and many more.</li>
                                    <li>The product will be appear on the website with your provided combinations. For the fields below, list the variations that exist for your products. For example, if you're selling Pirate Shirts in the sizes Small, Medium, and Large, and in the colors White and Black, list all those terms</li>
                                    <li>In the case that you have add the variation with invalid or incorrect information by mistake, then you can also update the information in individual variation.</li>
                                    <li>You also able to add multiple variations for the same product at a time by clicking on <b>Add more variation</b> button.</li>
                                  </ul> 
                                </div><br>

                              </div>
                            </div>
                            <div class="table-responsive variation-theme-table" tabindex="1">
                                <table class="table-bordered table table-striped table-hover">
                                    <thead class="tHead_container">
                                        <?php
                                        if(!empty($product_variation_details)){
                                        ?>
                                        <tr>
                                            <?php
                                            $product_variation_info = product_variation_info($product_info_id);
                                            $variation_info = json_decode($product_variation_info->product_variation_info);
                                            foreach ($variation_info as $key => $value) {
                                            ?>
                                            <th><?php echo ucfirst($key); ?> <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="<?php $tooltipContent = getData('attributes',array('attribute_code',$key)); if($tooltipContent) echo $tooltipContent->tooltip_content; ?>"></span></th>
                                            <?php }
                                            ?>
                                            <th class="variation-seller-sku">Seller SKU <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="<?php if(empty($product_variation_details)){ ?>Enter the unique Seller SKU with atleast 5 characters.<?php }else{ ?>Unique Seller SKU with atleast 5 characters.<?php } ?>"></span></th>
                                            <th class="variation-productid">Product ID <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="<?php if(empty($product_variation_details)){ ?>Enter the unique Product ID with atleast 8 characters.<?php }else{ ?>Unique Product ID with atleast 8 characters.<?php } ?>"></span></th>
                                            <th class="variation-productid-type">Product ID Type <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="<?php if(empty($product_variation_details)){ ?>Select the unique Product ID type.<?php }else{ ?>Unique Product ID type<?php } ?>"></span></th>
                                            <th class="variation-sell">Sell Price <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="<?php if(empty($product_variation_details)){ ?>Enter the Product Sell Price (In Dollar Currency)<?php }else{ ?>Product Sell Price (In Dollar Currency)<?php } ?>"></span></th>
                                            <th class="variation-retail">Retail Price(MRP) <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="<?php if(empty($product_variation_details)){ ?>Enter the Product Retail Price (In Dollar Currency). Retail price should be greater than the Sell price.<?php }else{ ?>Product Retail Price (In Dollar Currency). Retail price should be greater than the Sell price.<?php } ?>"></span></th>
                                            <th class="variation-quantity">Quantity <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="<?php if(empty($product_variation_details)){ ?>Enter the Quantity of your product<?php }else{ ?>Quantity of your product<?php } ?>"></span></th>
                                            <th class="variation-action">Action</th>
                                        </tr>
                                        <?php } ?>
                                    </thead>
                                    <tbody class="input_fields_container">
                                        <?php
                                        if(!empty($product_variation_details)){
                                        $i=1;
                                        foreach ($product_variation_details as $row) {
                                        ?>
                                        <tr>
                                            <?php $variation_info = json_decode($row->product_variation_info);
                                            foreach ($variation_info as $key => $value) { ?>
                                            <td><?php if($value){ echo $value; } ?></td>
                                            <?php } ?>
                                            <td><?php if($row->seller_SKU){ echo $row->seller_SKU; } ?></td>
                                            <td><?php if($row->product_ID){ echo $row->product_ID; } ?></td>
                                            <td>
                                                <?php
                                                $product_ID_type = product_ID_type($row->product_ID_type);
                                                echo $product_ID_type;
                                                ?>
                                            </td>
                                            <td><?php if($row->base_price){ echo '$'.number_format($row->base_price,2); } ?></td>
                                            <td><?php if($row->sell_price){ echo '$'.number_format($row->sell_price,2); } ?></td>
                                            <td><?php if($row->quantity){ echo $row->quantity; } ?></td>
                                            <td><a href="<?php echo base_url().'seller/products/product_offer/'.$row->product_info_id.'/'.$row->product_variation_id.'/2'; ?>" target="_blank" class="btn btn-primary btn-xs common-btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Want to edit the details or its images, click here"><i class="icon-pencil"></i>
                                            </a></td>
                                        </tr>
                                        <?php $i++; } } ?>
                                    </tbody>
                                </table>

                               
                            </div>
                             <?php if(empty($product_variation_details)){ ?>
                                  <div class="col-md-3 pull-right">
                                    <a href="javascript:void(0);" class="add_more_button btn btn-primary margin-top-10 margin-bottom-10 pull-right"><i class="icofont icofont-plus"></i> Add More Variations</a>
                                  </div>
                                <?php } ?>
                        </div>
                      </div>
                    <!-- ===========End======== -->
                      <div class="form-actiosns form-btn-block text-center">
                        <?php if(empty($product_variation_details)){ ?>
                          <button  class="btn btn-red" type="submit">Continue</button>
                        <?php } ?>
                        <a class="btn btn-default-white" href="<?php echo base_url('seller/products/edit_product_basic_info/'.$product_info_id.'/'.$product_variation_id.'/'.$type); ?>">Back</a>
                      </div>
                    </form>
                    <!-- END FORM--> 
                    <?php }else{ ?>
                      <div class="col-md-12 text-center">
                        <h4><b><i class="fa fa-info-circle" aria-hidden="true"></i> Variations are not available for this category</b></h4>
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




<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script>
   var SITE_URL         = "<?php echo base_url(); ?>";
   var ProductVariation = <?php echo json_encode($product_variation_details); ?>;
   if(!ProductVariation){
      $(".variation_theme").val("");
      $(".variationUsingTheme").hide();
   }else{
      if(!ProductVariation[0].product_theme_id){
         $(".variation_theme").val("");
         $(".variationUsingTheme").hide();
      }else{
         $(".variation_theme").val(ProductVariation[0].product_theme_id);
         $(".variationUsingTheme").show();
      }
   }

   var attributeInfo = "";
   function variation_theme_change(obj){
      $('.tHead_container').empty();
      $(".input_fields_container").empty();
      var variation_themeVal   = $(obj).val();
      if(!variation_themeVal){
         $(".variationUsingTheme").hide();
      }else{
         $(".variationUsingTheme").show();
         $.ajax({
            url: SITE_URL+'seller/products/getVariationThemeVariation', 
            type: 'POST',
            data: {
               variation_themeVal : variation_themeVal
            },
            cache: false,
            success:function(result){               
              var data = JSON.parse(result);
              var attributesData = data.attributesData;
              var attributeHeadInfo = "";
              attributeInfo = "";

              if(attributesData.length!=0){
            
                for (var i = 0; i < attributesData.length; i++) {

                  attributeHeadInfo += '<th class="variationColumn">'+attributesData[i]['name'].charAt(0).toUpperCase() + attributesData[i]['name'].slice(1)+' <span class="fa fa-info-circle tooltips" rel="tooltip"  data-placement="top" data-original-title="'+attributesData[i]['tooltip_content']+'"></span></th>';
                    if(attributesData[i]['file_type']==1)
                    {
                        attributeInfo += '<td><input data-bvalidator="required" placeholder="'+attributesData[i]['placeholder_content'].charAt(0).toUpperCase()+ attributesData[i]['placeholder_content'].slice(1)+'" type="text" name="product_variation_info['+attributesData[i]['attribute_code']+'][]" class="form-control"></td>';
                        
                    }else if(attributesData[i]['file_type']==2){
                        attributeInfo += '<td><textarea data-bvalidator="required" placeholder="'+attributesData[i]['placeholder_content'].charAt(0).toUpperCase()+ attributesData[i]['placeholder_content'].slice(1)+'" type="text" name="product_variation_info['+attributesData[i]['attribute_code']+'][]" class="form-control"></textarea></td>';
                    }else if(attributesData[i]['file_type']==3){
                          attributeInfo += '<td><select class="form-control" placeholder="'+attributesData[i]['placeholder_content'].charAt(0).toUpperCase()+ attributesData[i]['placeholder_content'].slice(1)+'" name="product_variation_info['+attributesData[i]['attribute_code']+'][]" ><option value="">Select</option>';
                            var value=jQuery.parseJSON(attributesData[i]['attribute_value']);
                              for(var j=0;j<value.length;j++)
                              {
                                attributeInfo +='<option value="'+value[j]+'">'+value[j]+'</oprion>'; 
                              }
                          attributeInfo +='</select></td>';
                    }else if(attributesData[i]['file_type']==5){
                          attributeInfo += '<td><select class="form-control" placeholder="'+attributesData[i]['placeholder_content'].charAt(0).toUpperCase()+ attributesData[i]['placeholder_content'].slice(1)+'" name="product_variation_info['+attributesData[i]['attribute_code']+'][]"  multiple><option value="">Select</option>';
                            var value=jQuery.parseJSON(attributesData[i]['attribute_value']);
                              for(var j=0;j<value.length;j++)
                              {
                                attributeInfo +='<option value="'+value[j]+'">'+value[j]+'</oprion>'; 
                              }
                          attributeInfo +='</select></td>';
                      
                    }else if(attributesData[i]['file_type']==8){
                          attributeInfo += '<td><input data-bvalidator="required" maxlength="50" placeholder="'+attributesData[i]['placeholder_content'].charAt(0).toUpperCase()+ attributesData[i]['placeholder_content'].slice(1)+'" type="text" name="product_variation_info['+attributesData[i]['attribute_code']+'][]" class="form-control default_date date"></td>';
                      
                    }else if(attributesData[i]['file_type']==9){
                        attributeInfo += '<td><input data-bvalidator="required" placeholder="'+attributesData[i]['placeholder_content'].charAt(0).toUpperCase()+ attributesData[i]['placeholder_content'].slice(1)+'" type="text" name="product_variation_info['+attributesData[i]['attribute_code']+'-9][]" class="form-control">';
                        
                        attributeInfo += '<td><select class="form-control" placeholder="'+attributesData[i]['placeholder_content'].charAt(0).toUpperCase()+ attributesData[i]['placeholder_content'].slice(1)+'" name="product_variation_info['+attributesData[i]['attribute_code']+'][]"  multiple><option value="">Select</option>';
                            var value=jQuery.parseJSON(attributesData[i]['attribute_value']);
                              for(var j=0;j<value.length;j++)
                              {
                                attributeInfo +='<option value="'+value[j]+'">'+value[j]+'</oprion>'; 
                              }
                          attributeInfo +='</select>';  
                          attributeInfo += '</td>';
                    }else if(attributesData[i]['file_type']==10){
                          attributeInfo += '<td><input data-bvalidator="required" maxlength="500" placeholder="'+attributesData[i]['placeholder_content'].charAt(0).toUpperCase()+ attributesData[i]['placeholder_content'].slice(1)+'"  main="'+attributesData[i]['attribute_code']+'" type="text" name="product_variation_info['+attributesData[i]['attribute_code']+'][]" class="form-control typeahead"></td>';
                    }
                }
              }else{
                attributeInfo="";
              }
              
             // window.sessionStorage.setItem("attributeInfo",attributeInfo);

              $('.tHead_container').append('<tr>'+attributeHeadInfo+'</th><th class="variation-seller-sku">Seller SKU <span class="fa fa-info-circle tooltips" rel="tooltip"  data-placement="top" data-original-title="Enter the unique Seller SKU with atleast 5 characters."></span></th><th class="variation-productid">Product ID <span class="fa fa-info-circle tooltips" rel="tooltip"  data-placement="top" data-original-title="Enter the unique Product ID with atleast 8 characters."></span></th><th class="variation-productid-type">Product ID Type <span class="fa fa-info-circle tooltips" rel="tooltip"  data-placement="top" data-original-title="Select the Product ID type."></span></th><th class="variation-sell">Sell price <span class="fa fa-info-circle tooltips" rel="tooltip"  data-placement="top" data-original-title="Enter the Product Sell Price (In Dollar Currency)"></span></th><th class="variation-retail">Retail Price(MRP) <span class="fa fa-info-circle tooltips" rel="tooltip"  data-placement="top" data-original-title="Enter the Product Retail Price (In Dollar Currency). Retail price should be greater than the Sell price."></span></th><th class="variation-quantity">Quantity <span class="fa fa-info-circle tooltips" rel="tooltip"  data-placement="top" data-original-title="Enter the Quantity of your product"></span></th><th class="variation-action">Action</th></tr>');

              $('.input_fields_container').append('<tr>'+attributeInfo+'<td><input placeholder="S12T-Gec-RM" data-bvalidator="checkSellerSKU,minlen[5],maxlen[20]" type="text" name="seller_sku[]" data-bvalidator-msg="Enter the unique Seller SKU with atleast 5 characters." class="form-control"></td><td><input placeholder="00012345" data-bvalidator="checkProductID,minlen[8],maxlen[15],required" data-bvalidator-msg="Enter the unique Product ID with atleast 8 characters." type="text" name="product_id[]" class="form-control"></td><td><?php $product_ID_type = product_ID_type(""); ?><select class="form-control" name="product_id_type[]" data-bvalidator="required"><option value="">Select</option><?php foreach ($product_ID_type as $key => $value) { ?><option value="<?php echo $key; ?>"><?php echo $value; ?></option><?php } ?></select></td><td><div class=""><div class="input-group"><span style="" class="input-group-addon"><i class="fa fa-usd" aria-hidden="true"></i></span><div class="num-input-container"><input placeholder="10.00" data-bvalidator="number,required" type="text" name="base_price[]" class="form-control"></div></div></div></td><td><div class=""><div class="input-group"><span style="" class="input-group-addon"><i class="fa fa-usd" aria-hidden="true"></i></span><div class="num-input-container"><input placeholder="12.00" type="text" data-bvalidator="checkGreaterSellPrice,required" data-bvalidator-msg="The Retail price should be greater than sell price." name="sell_price[]" class="form-control"></div></div></div></td><td><input placeholder="7" data-bvalidator="required" type="number" min="0" name="quantity[]" class="form-control"></td><td></td></tr>');
                $.getScript("<?php echo SELLER_THEME_URL; ?>js/bootstrap.min.js", function() {
                          $('.tooltips').tooltip();
               });
                
              
              //tool_tip();
            },
         });
      }
   }
  
   $(document).ready(function(){
    $('form').bValidator();
    var max_fields_limit      = 10; //set limit for maximum input fields
       var x = "<?php if(!empty($product_variation_details)){ echo count($product_variation_details); }else{ echo "1"; } ?>"; //initialize counter for text box
       $('.add_more_button').click(function(e){ //click event on add more fields button
           e.preventDefault();
            x++; //counter increment
            $('.input_fields_container').append('<tr>'+attributeInfo+'<td><input placeholder="S12T-Gec-RM" type="text" name="seller_sku[]" data-bvalidator="checkSellerSKU,minlen[5],maxlen[20]" data-bvalidator-msg="Enter the unique Seller SKU with atleast 5 characters." class="form-control"></td><td><input placeholder="00012345" data-bvalidator="checkProductID,minlen[8],maxlen[15],required" data-bvalidator-msg="Enter the unique Product ID with atleast 8 characters." type="text" data-bvalidator="required" name="product_id[]" class="form-control"></td><td><?php $product_ID_type = product_ID_type(""); ?><select class="form-control" name="product_id_type[]" data-bvalidator="required">><option value="">Select</option><?php foreach ($product_ID_type as $key => $value) { ?><option value="<?php echo $key; ?>"><?php echo $value; ?></option><?php } ?></select></td><td><div class=""><div class="input-group"><span style="" class="input-group-addon"><i class="fa fa-usd" aria-hidden="true"></i></span><div class="num-input-container"><input placeholder="10.00" data-bvalidator="number,required" type="text" name="base_price[]" class="form-control"></div></div></div></td><td><div class=""><div class="input-group"><span style="" class="input-group-addon"><i class="fa fa-usd" aria-hidden="true"></i></span><div class="num-input-container"><input placeholder="12.00" data-bvalidator="checkGreaterSellPrice,required" data-bvalidator-msg="The Retail price should be greater than sell price." type="text" name="sell_price[]" class="form-control"></div></div></div></td><td><input placeholder="7" type="number" min="0" name="quantity[]" data-bvalidator="required" class="form-control"></td><td><a href="javascript:void(0);" class="remove_field btn btn-danger btn-sm"><i class="fa fa-times" aria-hidden="true"></i></a></td></tr>'); //add input field
           
       });  
       $('.input_fields_container').on("click",".remove_field", function(e){ //click on remove text links
           e.preventDefault(); $(this).closest('tr').remove(); x--;
       });
      
   });
    
   function hasDuplicates(array) {
        var valuesSoFar = [];
        for (var i = 0; i < array.length; ++i) {
            var value = $.trim(array[i]);
            if (valuesSoFar.indexOf(value) !== -1) {
                return true;
            }
            valuesSoFar.push(value);
        }
        return false;
   }

   function checkSellerSKU(sku){
      var ret = false;

      var values = $("input[name='seller_sku[]']").map(function(){return $(this).val();}).get();
      if(hasDuplicates(values)){
        return ret;
      }else{
      
        $.ajax({
          type: 'POST',
          url: SITE_URL+'seller/products/checkSellerSKU',
          async: false,
          data: {'sku':sku},
          success: function(data){
            data = jQuery.parseJSON(data);
            if(data.status == 'success')
              ret = true
          }
        });
        return ret;
      }
   }

   function checkProductID(product_id){
      var ret = false;

      var values = $("input[name='product_id[]']").map(function(){return $(this).val();}).get();
      if(hasDuplicates(values)){
        return ret;
      }else{

        $.ajax({
          type: 'POST',
          url: SITE_URL+'seller/products/checkProductID',
          async: false,
          data: {'product_id':product_id},
          success: function(data){
            data = jQuery.parseJSON(data);
            if(data.status == 'success')
              ret = true
          }
        });
        return ret;
      }
   }

   function checkGreaterSellPrice(sell_price){
      var base_price = $("input[name='base_price[]']").map(function(){return $(this).val();}).get();
      if(parseInt(base_price) > parseInt(sell_price)){
        return false;
      }else{
        return true;
      }
   }

$('body').on('keypress','input.typeahead',function(){
    $('input.typeahead').typeahead({
       source:  function (query, process) {
         var attr=this.$element.attr('main');
         return $.get('<?php echo base_url(); ?>backend/common/autocomplete', { query: query,attribute_code:attr }, function (data) {
            data = $.parseJSON(data);
               return process(data);
           });
       }
    });
});

</script>

