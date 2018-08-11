<div class="body-container clearfix">
<div class="bread_parent">
   <ul class="breadcrumb">
      <li><a href="<?php echo base_url('seller/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
      <li><b>Drafts</b></li>
   </ul>
   <div class="clearfix"></div>
</div>

<div class="theme-container clearfix">
   <div class="clearfix"></div>
   <div class="col-sm-12 col-md-12 col-lg-12">
      <div class="common-tab-wrapper">
         <div class="common-tab-system partners clearfix">
            <div id="alertQuantity"></div>
         </div>
         <div class="clearfix"></div>
         <div class="common-contain-wrapper clearfix">
            <div class="">
               <div class="">
                  <div class="">
                     <div class="common-panel panel">
                        <!-- <div class="mydraft alert-default alert-dismissible " role="alert">
                           <h4 class="color-red"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Welcome to the drafts experience!</h4>
                           <p>Listings that don’t meet valid data requirements at the time of submission will now be stored as drafts. You can view and incrementally work on these listings via the Complete Your Drafts page. You can add missing data or correct invalid data for your drafts one at a time or in bulk. Click on ‘Learn More’ for detailed information.</p>
                        </div> -->
                        <div class="highlight-info-box">
                            <h4 class="color-red"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Welcome to the drafts experience!</h4>
                            <p>Listings that don’t meet valid data requirements at the time of submission will now be stored as drafts. please review the below given instructions which will help you to move your products from draft to inventory.</p>
                            <ul>
                              <li>You can view and incrementally work on these listings via the Complete Your Drafts page. You can add missing data or correct invalid data for your drafts one at a time. </li>
                              <li>Both Product types (simple/variation) which have incomplete and invalid details and information will be listed here.</li>
                              <li>If your added product is not available in the draft then it might be available in the listing of <a class="link-text" href="<?php echo base_url('seller/products/index'); ?>"><b>Inventory</b></a>. In the case when product is not available in even in the inventory then please contact to <a class="link-text" href="<?php echo base_url('seller/support/messages'); ?>"><b>Support</b></a>.</li>
                              <li>Products which is added with variation type will be appear in the draft first because you are restricted to add the images for the variations during updation.</li>
                              <li>If you don't wish to continue with this product or neither want to move it into the inventory you can remove this product from the drafts.</li>
                            </ul> 
                        </div>
                        <div class="panel-body">
                           <div class="col-sm-12 no-padding">
                              <form action="<?php echo base_url('seller/products/mydraft') ?>" method="get" role="form" class="form-horizontal">
                                <table class="responsive table_head common-table-top-section" cellpadding="5">
                                  <thead>
                                    <tr>
                                      <th width="15%">Product Title</th>
                                      <th width="20%">Categories</th>
                                      <th width="15%">Product Type</th>
                                      <th width="15%">Status</th>
                                      <th width="100px"></th>
                                      <th></th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <div class="">
                                          <input type="text" placeholder="Product Title" class="form-control" name="title" value="<?php if(!empty($_GET['title'])) echo $_GET['title']; ?>">
                                        </div>
                                      </td>
                                      <td>
                                        <div class="">
                                          <select name="category_id" class="form-control">
                                            <option value="">Select Category</option>
                                            <?php $cate=''; if(!empty($_GET['category_id'])) $cate=$_GET['category_id']; echo getcategoryDropdown($cate); ?>
                                         </select>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="">
                                          <select name="product_type" class="form-control">                  
                                            <option value="">--Select--</option> 
                                            <option value="1" <?php if(!empty($_GET['product_type']) && $_GET['product_type']=='1') echo 'selected'; ?>>Simple</option> 
                                            <option value="2" <?php if(!empty($_GET['product_type']) && $_GET['product_type']=='2') echo 'selected'; ?>>Variation</option> 
                                          </select>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="">
                                          <select name="status" class="form-control">
                                            <option value="">--Select--</option> 
                                            <option value="1" <?php if(!empty($_GET['status']) && $_GET['status']=='1') echo 'selected'; ?>>Active</option>
                                            <option value="2" <?php if(!empty($_GET['status']) && $_GET['status']=='2') echo 'selected'; ?>>Deactive</option>
                                         </select>
                                        </div>
                                      </td>

                                      <td>
                                        <button class="btn btn-primary tooltips" rel="tooltip" data-placement="top" data-original-title="Search" type="submit"><i class="icon icon-search"></i></button>
                                        <a class="btn btn-danger tooltips" rel="tooltip" data-placement="top" data-original-title="Reset your product search" type="submit" href="<?php echo base_url('seller/products/mydraft'); ?>"> <i class="icon icon-refresh"></i></a>
                                      </td>
                                      <td>
                                        <div class="pull-right" style="margin-left: 5px;">
                                           <a class="btn btn-primary tooltips" href="<?php echo base_url()?>seller/products/product_category" rel="tooltip" data-placement="top" data-original-title="Click to add a Simple/Variation Product"><i class="icon-plus"></i> Add a Product
                                           </a>
                                        </div>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </form>
                              <!-- END FORM--> 
                           </div>
                           <div class="col-sm-12 no-padding">
                             <div class="adv-table inventory-experience-wrapper" id="tab1">
                                <table id="datatable_example" class="table-bordered responsive table table-striped table-hover">
                                   <thead class="thead_color">
                                      <tr>
                                         <th class="jv no_sort checkbox-status">
                                          <div class="col-sm-12 no-padding">
                                            <span class="checkbox-input term-check">
                                              <input class="styled" type="checkbox" id="checkAll" class="" >
                                              <label class="" for="checkAll"></label>
                                            </span>
                                            <span>
                                               <select class="form-control commonstatus order-select-status">
                                                  <option value="">All</option>
                                                  <option value="1">Active</option>
                                                  <option value="2">Deactive</option>
                                                  <option value="3">Delete</option>
                                               </select>
                                            </span>
                                          </div>
                                         </th>
                                         <th class="productimg text-center">Product Image</th>
                                         <th class="producttitle">Product Title</th>
                                         <th class="sku-no text-center">SKU</th>
                                         <th class="sellprice text-center">Retail Price(MRP)</th>
                                         <th class="bestprice text-center">Sell Price</th>  
                                         <th class="quntity-no text-center">Quantity</th>
                                         <th class="freeprive text-center">Fee Preview</th>
                                         <!-- <th class="created text-center">Created </th> -->
                                         <th class="action text-center">Actions</th>
                                      </tr>
                                   </thead>
                                   <tbody>
                                      <?php
                                         if(!empty($products)){
                                         $i=0; 
                                         foreach($products as $row){
                                         $i++;
                                         ?>
                                      <tr>
                                         <td>
                                            <div class="checkbox-input">
                                              <input class="styled" type="checkbox" id="checkall<?php echo $i ?>" name="checkstatus[]" value="<?php echo $row->product_info_id; ?>">  &nbsp;&nbsp; <?php echo $offset+$i.".";?>
                                              <label class="" for="checkall<?php echo $i ?>"></label>
                                            </div>
                                         </td>
                                         <td class="image-td text-center">
                                          <div class="img-size-box">
                                            <?php
                                              $image = getFeaturedImage($row->product_info_id, $row->product_variation_id);
                                              if($row->type_of_product==1 && !empty($image) && file_exists("assets/uploads/seller/products/thumbnail/".$image)){
                                           ?>
                                              <img class="" src="<?php echo base_url('assets/uploads/seller/products/thumbnail/'.$image)?>">
                                           
                                           <?php }else{ ?>

                                              <?php if($row->type_of_product==1){ ?>
                                                <img src="<?php echo base_url('assets/backend/image/product_default_image.png'); ?>">
                                              <?php }else if($row->type_of_product==2){ ?>
                                                <img s_no="<?php echo $i; ?>" toggleShow="close" infoDetails="<?php echo $row->product_info_id; ?>" onclick="getChildVariationProducts(this)" height="auto" src="<?php echo base_url('assets/backend/image/default_image.png'); ?>">
                                              <?php }else{ ?>
                                                <img src="<?php echo base_url('assets/backend/image/product_default_image.png'); ?>">
                                              <?php } ?>

                                              <a rel="tooltip" s_no="<?php echo $i; ?>" data-placement="top" data-original-title="CLICK HERE to view the variations of this product. In case if some of the variations are not visible in the list then check them in your inventory." class="productCount tooltips" toggleShow="close" infoDetails="<?php echo $row->product_info_id; ?>" onclick="getChildVariationProducts(this)" href="javascript:void(0)"><?php if($row->type_of_product==2){ echo 'See '.$row->totalVariationCount.' variations of this product'; } ?></a>

                                           <?php } ?>
                                          </div>
                                         </td>
                                         <td>
                                          <?php echo ucwords($row->title); if($row->type_of_product==1){ echo " <b>(".$row->product_ID.")</b>"; } ?><br>
                                          <?php if($row->type_of_product==1){ if($row->admin_approvel==1){ echo "<b style='color:green'>Approved by Admin</b>"; }else{ echo "<b style='color:#ff192e'>Not Approved by Admin</b>";  } echo "<br>"; } ?>
                                          <?php if(!empty($row->type_of_product)){ ?><b>Product Type - <?php if($row->type_of_product==1) echo "Single"; else if($row->type_of_product==2) echo "Variation"; ?></b><?php } ?>
                                           <br>

                                           <?php if($row->shipment_rate_type!=0){ ?>
                                           <b style='color:green'>- Applied 
                                           <?php if($row->shipment_rate_type==1){ echo "Free Shipping"; }else if($row->shipment_rate_type==2){ echo "Custom Shipping"; }else if($row->shipment_rate_type==3){ echo "Global Shipping"; } ?></b><br>
                                           <?php } ?>

                                           <b>Created Date - </b><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo date('d M Y',strtotime($row->created_at)); ?>
                                         </td>
                                         <td class="text-center">
                                            <?php
                                               if(!empty($row->type_of_product==1)){
                                                  if(!empty($row->seller_SKU)){
                                                     echo $row->seller_SKU;
                                                  }else{
                                                     echo "-";
                                                  }
                                               }else{
                                                  echo "-";
                                               }
                                               ?>
                                         </td>                                        
                                         <td class="font-roboto text-center"><?php if(!empty($row->type_of_product==1)){ echo '$'. number_format($row->sell_price,2); }else{ echo "-"; } ?></td>
                                          <td class="font-roboto text-center"><?php if(!empty($row->type_of_product==1)){ echo '$'. number_format($row->base_price,2); }else{ echo "-"; } ?></td>
                                         <td class="text-center">
                                          <div class="update-form-quantity">
                                            <?php
                                               if(!empty($row->type_of_product==1)){
                                                  if(!empty($row->quantity)){ ?>
                                                     <input class="form-control input-update-form" type="number" onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="3" min="0" max="999" id="quantity<?php echo $row->product_variation_id; ?>" name="quantity" placeholder="01" class="quantityNo" disabled="disabled" value="<?php echo $row->quantity; ?>">
                                                  <?php }else{ ?>
                                                     <input class="form-control input-update-form" type="number" onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="3" min="0" max="999" id="quantity<?php echo $row->product_variation_id; ?>" name="quantity" placeholder="01" class="quantityNo" disabled="disabled" value="1">
                                                  <?php }
                                               }else{
                                                  echo "-";
                                               }
                                            ?>
                                            <?php if($row->type_of_product==1){ ?>
                                              <a href="javascript:void(0)" class="tooltips updateQuantity" attrId="<?php echo $row->product_variation_id; ?>" rel="tooltip" data-placement="top" data-original-title="Click to Edit Quantity">
                                                <i class="fa fa-pencil" aria-hidden="true" id="iconQuan<?php echo $row->product_variation_id; ?>"></i>
                                              </a>
                                            <?php } ?>
                                          </div>
                                         </td>
                                         <td class="font-roboto text-center">
                                           <?php
                                              if(!empty($row->type_of_product==1)){
                                                if(!empty($row->commision_fee) && !empty($row->sell_price)){
                                                   $feePreview = $row->commision_fee * $row->sell_price/100;
                                                   echo '$'.number_format($feePreview, 2);
                                                }else{
                                                   echo "-";
                                                }
                                              }else{
                                                 echo "-";
                                              }
                                           ?>
                                         </td>
                                        <!--  <td class="text-center"><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php //echo date('d M Y',strtotime($row->created_at)); ?></td> -->
                                         <td class="text-center">
                                            <?php if($row->type_of_product==1){ ?>
                                            
                                            <a href="javascript:void(0);" onclick="return confirmBox('<?php if($row->status==2) echo "Do you want to enable this product for selling ?"; else if($row->status==1) echo "Do you want to disable this product ?"; ?>','<?php echo base_url().'backend/common/change_status/product_variations/product_variation_id/'.$row->product_variation_id.'/'; if($row->status==2) echo '1'; else echo '2'; ?>')" class="btn btn-<?php if($row->status==2) echo 'danger'; else echo 'success';  ?> btn-xs common-btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Click to <?php if($row->status==2) echo 'Active'; else echo 'Deactive';  ?>"><?php if($row->status==2) echo '<i class="fa fa-times" aria-hidden="true"></i>'; else echo '<i class="fa fa-check" aria-hidden="true"></i>';  ?>
                                            </a>  

                                            <a href="<?php echo base_url().'seller/products/shipment_rate/'.$row->product_info_id.'/'.$row->product_variation_id.'/1'; ?>" class="btn btn-info btn-xs common-btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Add/Update shipment rates"><i class="icofont icofont-cur-dollar" aria-hidden="true"></i>
                                            </a>

                                            <a href="<?php echo base_url().'seller/products/product_faq/'.$row->product_variation_id; ?>" class="btn btn-warning btn-xs common-btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="List of product FAQs"><i class="fa fa-question"></i>
                                            </a>

                                            <a href="<?php echo base_url().'seller/products/edit_product_category/'.$row->product_info_id.'/'.$row->product_variation_id.'/1'; ?>" class="btn btn-primary btn-xs common-btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title=" Edit Product"><i class="icon-pencil"></i>
                                            </a>

                                            <?php }else if($row->type_of_product==2){ ?>

                                            <a href="<?php echo base_url().'seller/products/shipment_rate/'.$row->product_info_id.'/'.$row->product_variation_id.'/1'; ?>" class="btn btn-info btn-xs common-btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Add/Update shipment rates"><i class="icofont icofont-cur-dollar" aria-hidden="true"></i>
                                            </a>
                                            
                                            <a href="<?php echo base_url().'seller/products/edit_product_category/'.$row->product_info_id.'/0/2'; ?>" class="btn btn-primary btn-xs common-btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title=" Edit Product"><i class="icon-pencil"></i>
                                            </a>

                                            <?php } ?>

                                            <?php if(empty($row->type_of_product)){ ?>

                                              <a href="<?php echo base_url().'seller/products/edit_product_category/'.$row->product_info_id.'/0/3'; ?>" class="btn btn-primary btn-xs common-btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title=" Edit Product"><i class="icon-pencil"></i>
                                               </a>

                                            <?php } $pvID = ($row->product_variation_id!='' && $row->product_variation_id!=null) ? $row->product_variation_id : 0; ?>

                                            <a href="javascript:void(0);" onclick="return confirmBox('Do you want to delete ?','<?php echo base_url().'seller/products/delete_product/'.$row->product_info_id.'/'.$pvID.'/1'; ?>')" class="btn btn-danger btn-xs common-btn-xs delete-btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Delete Product"><i class="icon-trash "></i>
                                            </a>
                                         </td>
                                      </tr>
                                      <?php } ?>
                                      <?php }else{ ?>
                                      <tr>
                                         <th colspan="9">
                                            <center>No Products Available.</center>
                                         </th>
                                      </tr>
                                      <?php } ?>
                                   </tbody>
                                </table>
                                <div class="row-fluid pull-right control-group mt15 pull-right">
                                   <div class="span12">
                                      <?php if(!empty($pagination))  echo $pagination;?>
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
   var SITE_URL  = "<?php echo base_url(); ?>";
   $("#tab1 #checkAll").click(function () {
        if ($("#tab1 #checkAll").is(':checked')) {
            $("#tab1 input[type=checkbox]").each(function () {
                $(this).prop("checked", true);
            });
   
        } else {
            $("#tab1 input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
        }
   });

   $(document).on('input', '.quantityNo', function(){
    if (this.value.length > this.maxLength)
      this.value = this.value.slice(0, this.maxLength)
   }); 
</script>
<script type="text/javascript" >
   jQuery(document).ready(function($) {
      $('body').find('#tab1').on('change','.commonstatus', function(event) {      
         var row_id=[] ;  
   
         var new_status=$(this).val();
          if(new_status==1){
           var action_name = 'Active';
          }else if(new_status==2){
           var action_name = 'Deactive';
          }else if(new_status==3){
           var action_name = 'Delete';
          }else{
            return false;
          }
   
   
         if($("input:checkbox[name='checkstatus[]']").is(':checked')){    
            swal({
                title: "Do you want to "+action_name+" it!",
                type: "warning",
                padding: 0,
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                background: '#f1f1f1',
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-confirm',
                cancelButtonClass: 'btn btn-cancle',
                confirmButtonText: 'Ok',
                cancelButtonText: 'Cancel',
                animation: false
            }, function() {

                var i=0;
                $("input[type='checkbox']:checked").each(function() {
                   if($(this).val()!=''){
                      row_id[i]=$(this).val();       
                      i++; 
                   }    
                });   

                var tb_name = "<?php echo base64_encode('products_info'); ?>"; 
                var col_name = "<?php echo base64_encode('product_info_id'); ?>";     

                $.post('<?php echo base_url() ?>'+'backend/products/manage_product_status', {'type': '1', 'status': new_status, 'row_id': row_id}, function(data) {            
                   if(data.status==true){ 
                      successMsg("Your products "+action_name+" successfully"); 
                      setTimeout(function() {
                        $(location).attr('href', '<?php echo base_url('seller/products/mydraft')?>');
                      }, 1500);
                   }else{       
                      window.location.reload(true);
                      return false;
                   }
                }); 

            });

         }else{
            warningMsg("Please check the checkbox"); 
            return false;
         } 

      });

   });
   

   function getChildVariationProducts(obj){

      var toggleShow      = $(obj).attr("toggleShow");
      var product_info_id = $(obj).attr("infoDetails");
      var s_no            = $(obj).attr("s_no");
      var pageType        = 'drafts';

      if(toggleShow=='close'){
         $(obj).attr("toggleShow", "open");
         $.ajax({
            url: SITE_URL + 'seller/products/getVariationProducts',
            type: 'POST',
            data: {
                product_info_id: product_info_id,
                s_no: s_no,
                pageType: pageType,
                statusProduct: "0"
            },
            cache: false,
            success: function(result) {
               var data = JSON.parse(result);
               if(data){
                 $.getScript("<?php echo SELLER_THEME_URL; ?>js/bootstrap.min.js", function() {
                    $('.tooltips').tooltip();
                 });
                 $("#toggleVRIcon"+product_info_id).removeClass('fa fa-plus').addClass('fa fa-minus');
                 var ele = $(obj).closest('tr');
                 ele.after(data.data);
                  $(obj).parents('tr:first').next().css('display', 'none');
                  $(obj).parents('tr:first').next().fadeIn(1500);
                  $(data.data).css('display', 'none');
               }
            },
         });
      }else{
         $(".child_"+product_info_id).parent().parent().parent().remove();
         $("#toggleVRIcon"+product_info_id).removeClass('fa fa-minus').addClass('fa fa-plus');
         $(obj).attr("toggleShow", "close");
      }
   }

</script>
<style>
.modal .popover, .modal .tooltip {
    z-index:100000000;
}
</style>
