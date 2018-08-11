<div class="bread_parent">
   <div class="col-md-12">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
         <li><a href="<?php echo base_url('backend/products/index'); ?>">Products</a></li>
         <li>Product Variations</li>
      </ul>
   </div>
   <div class="clearfix"></div>
</div>

<div class="superadmin-body panel-body partners">
   
   <?php $this->load->view('backend/products/tabMenus'); ?>

   <div class="adv-table">
      <div class="panel-body">   

         <form  autocomplete="off" role="form" class="form-horizontal tasi-form" action="<?php echo current_url(); ?>" enctype="multipart/form-data" method="post" data-bvalidator-validate>
            <?php echo $this->session->flashdata('msg_error');?>
            <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i> Product Variations Information :</header>
            <br>

            <div class="form-group">
              <label class="col-md-2 control-label">Variation Theme :</label>
              <div class="col-md-9">
              <?php 
                if(!empty($variation_themes)){ 
                  foreach ($variation_themes as $row) { 
                    if($product_variation_details[0]->product_theme_id==$row->product_theme_id){
                      echo $row->product_theme_title;
                    }
                  } 
                }
              ?>
              </div>
            </div>

            <div class="panel panel-info variationUsingTheme" style="display: none;">
                 <div class="panel-heading"><?php if(empty($product_variation_details)){ ?>Add Variations<?php }else{ ?>All Variation Terms Information<?php } ?></div>
                 <div class="panel-body">
                     <div class="row">
                        <div class="col-md-6">
                           <h4><b><?php if(empty($product_variation_details)){ ?>Fill all your variation terms for the themes below.<?php }else{ ?>Below is the Variations terms according to theme.<?php } ?></b></h4>
                        </div>
                        <?php if(empty($product_variation_details)){ ?>
                        <div class="col-md-6 pull-right">
                           <a href="javascript:void(0);" class="add_more_button btn btn-primary pull-right">Add More Variations</a>
                        </div>
                        <?php }
                        ?>
                     </div>
                     <div class="clearfix"></div>
                    <!--  <div class="row">
                        <div class="col-md-12">
                           <p>For the fields below, list the variations that exist for your products. For example, if you're selling Pirate Shirts in the sizes Small, Medium, and Large, and in the colors White and Black, list all those terms. This is necessary even if you don't carry every combination, or are temporarily out of stock on some. On the next page, you'll be able to remove any invalid variations.</p>
                        </div>
                     </div> -->

                     <div class="table-responsive variation_theme_table" tabindex="1" style="overflow: hidden; outline: none;">
                         <table class="table table-bordered">
                             <thead class="tHead_container">
                             <?php 
                              if(!empty($product_variation_details)){ 
                             ?>
                             <tr>
                                 <th>#</th>
                                 <?php
                                  $product_variation_info = product_variation_info($product_info_id);
                                  $variation_info = json_decode($product_variation_info->product_variation_info);
                                  foreach ($variation_info as $key => $value) { 
                                 ?>
                                 <th><?php echo ucfirst($key); ?></th>
                                 <?php }
                                 ?>
                                 <th>Seller SKU</th>
                                 <th>Product ID</th>
                                 <th>Product ID Type</th>
                                 <th>Base price</th>
                                 <th>Sell price</th>
                                 <th>Quantity</th>
                                 <th>Action</th>
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
                                 <td scope="row"><?php echo $i; ?></td>

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

                                 <td><a href="<?php echo base_url().'backend/products/product_offer/'.$row->product_info_id.'/'.$row->product_variation_id.'/2'; ?>" target="_blank" class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="View details or its images"><i class="fa fa-eye"></i>
                                 </a></td>
                             </tr>
                             <?php $i++; } } ?>

                             </tbody>
                         </table>
                     </div>

                 </div>
            </div>
         
            <div class="form-actiosns fluid">
                <div class="form-btn-block">
                   <div class="col-md-12 text-center">
                      <?php if(empty($product_variation_details)){ ?>
                      <button  class="btn btn-primary" type="submit">Submit</button>
                      <?php } ?>
                      <a class="btn btn-danger" href="<?php echo base_url('backend/products/edit_product_basic_info/'.$product_info_id.'/'.$product_variation_id.'/'.$type); ?>">Back</a>
                   </div>
                </div>
             </div>

         </form>
         <!-- END FORM--> 
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
</script>

