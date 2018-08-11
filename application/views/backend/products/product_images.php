<div class="bread_parent">
   <div class="col-md-12">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
         <li><a href="<?php echo base_url('backend/products/index'); ?>">Products</a></li>
         <li>Product Images</li>
      </ul>
   </div>
   <div class="clearfix"></div>
</div>
<div class="superadmin-body panel-body partners">
   
   <?php $this->load->view('backend/products/tabMenus'); ?>

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

   <div class="adv-table">
      <div class="panel-body">

         <form role="form" autocomplete="off" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post" data-bvalidator-validate>
            <?php echo $this->session->flashdata('msg_error');?>
            <header class="panel-heading colum">
               <i class="fa fa-angle-double-right"></i> Product Images :
            </header>
            <br>

            <div class="validation_info text-center">
              <!-- <b>Images must meet the following requirements:</b>
              <p>
                <ul>
                <li>Products must fill at least 85% of the image. Images must show only the product that is for sale, with few or no props and with no logos, watermarks, or inset images. Images may only contain text that is a part of the product.</li>
                <li>Main images must have a pure white background, must be a photo (not a drawing), and must not contain excluded accessories.</li>
                <li>Images must be at least 1000 pixels on the longest side and at least 500 pixels on the shortest side to be zoom-able.</li>
                <li>Images must not exceed 10000 pixels on the longest side.</li>
                <li>JPEG is the preferred image format, but you also may use png and GIF files.</li>
              </ul>
              </p> -->
        

            <br>
            <div class="input_fields_container">

              <?php if(!empty($product_feature_img)){ ?>
                <div class="form-group col-md-3">
                    <div class="validation_info">
                      <p>This one is also featured image.</p>
                    </div>
                    <div class="col-lg-9">
                       <div class="fileinput fileinput-new" data-provides="fileinput">
                          <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 230px; height: 160px;">
                             <img src="<?php echo base_url(); ?>assets/uploads/seller/products/thumbnail/<?php echo $product_feature_img->image; ?>" data-src="holder.js/100%x100%" alt="...">
                          </div>
                          <!-- <div>
                             <span><a onclick="return confirmBox('Are you sure want to delete ?','<?php echo base_url('backend/products/delete_image/'.$product_feature_img->product_img_id.'/'.$product_info_id); ?>')" class="btn btn-danger btn-xs">Delete</a></span>  
                          </div> -->
                       </div>
                       <div class="clearfix"></div>
                    </div>
                </div>
              <?php } ?>


              <?php if(!empty($product_images)){
                $indexing = 0;
                foreach ($product_images as $row) {
              ?>
               <div class="form-group col-md-3">
                  <div class="validation_info">
                      <p><br></p>
                    </div>
                  <div class="col-lg-9">
                     <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 230px; height: 160px;">
                           <img src="<?php echo base_url(); ?>assets/uploads/seller/products/thumbnail/<?php echo $row->image; ?>" data-src="holder.js/100%x100%" alt="...">
                        </div>
                        <!-- <div>
                           <span><a onclick="return confirmBox('Are you sure want to delete ?','<?php echo base_url('backend/products/delete_image/'.$row->product_img_id.'/'.$product_info_id); ?>')" class="btn btn-danger btn-xs">Delete</a></span>  
                        </div> -->
                     </div>
                     <div class="clearfix"></div>
                  </div>
               </div>
            <?php $indexing++; } } ?>
            </div>

            <div class="clearfix"></div>
            <div class="col-md-12">
              <span class="error"><?php echo form_error('image'); ?> </span>
            </div>
            <div class="clearfix"></div>
            
            <div class="form-actiosns fluid">
                <div class="form-btn-block">
                   <div class="col-md-12 text-center">
                      <?php if($type==1){ ?>
                        <a class="btn btn-danger" href="<?php echo base_url('backend/products/product_other_info/'.$product_info_id.'/'.$product_variation_id.'/'.$type); ?>">Back</a>
                      <?php }else if($type==2){ ?>
                        <a class="btn btn-danger" href="<?php echo base_url('backend/products/product_offer/'.$product_info_id.'/'.$product_variation_id.'/'.$type); ?>">Back</a>
                      <?php } ?>
                   </div>
                </div>
            </div>

         </form>
      </div>
   </div>
</div>

<script>
   $(document).ready(function(){
    $('form').bValidator();
    var max_fields_limit      = 10; //set limit for maximum input fields
       var x = 1; //initialize counter for text box
       $('.add_more_button').click(function(e){ //click event on add more fields button having class add_more_button
            e.preventDefault();
            x++; //counter increment
            $('.input_fields_container').append('<div class="form-group col-md-3"><div class="validation_info"><p><br></p></div><div class="col-lg-9"><div class="fileinput fileinput-new" data-provides="fileinput"><div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 230px; height: 160px;"><img src="<?php echo  BACKEND_THEME_URL ?>images/default_image.png" data-src="holder.js/100%x100%" alt="..."></div><div><span class="btn btn-primary btn-file btn-xs"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" data-bvalidator="extension[jpg:png:gif:jpeg],required" data-bvalidator-msg="choose an image file and the accepted file type is jpg, jpeg, png, gif" name="image[]"></span><span><a href="#" class="btn btn-danger remove_field btn-xs" data-dismiss="fileinput" style="margin-left:5px;">Remove</a></span></div></div><div class="clearfix"></div></div></div>'); //add input field
           
       });  
       $('.input_fields_container').on("click",".remove_field", function(e){ //user click on remove text links
           e.preventDefault(); $(this).parents('div.form-group').remove(); x--;
       });

   });

   function featured_imageFun(obj){
      $(".featured_image_cls").val("0");
      $(".featured_image_cls").prop('checked', false);
      $(obj).val("1");
      $(obj).prop('checked', true);
   }
   
</script>