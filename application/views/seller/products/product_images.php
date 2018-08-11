<div class="body-container clearfix">
<div class="bread_parent">
   <ul class="breadcrumb">
      <li><a href="<?php echo base_url('seller/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
      <li><a href="<?php echo base_url('seller/products/index'); ?>">Products</a></li>
      <li><b>Product Images/Videos</b></li>
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
                           <div class="panel-title"><i class="icofont icofont-image"></i> Product Images/Videos <?php if(!empty($product_info->title)) echo ' - "'.ucfirst($product_info->title).'"'; ?></div>
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
                        <div class="image-upload-infornation">
                          <div class="highlight-info-box ">
                            <h4 class="color-red">Images must meet the following requirements :</h4>
                              <ul>
                                <li>Products must fill at least 85% of the image. Images must show only the product that is for sale, with few or no props and with no logos, watermarks, or inset images. Images may only contain text that is a part of the product.</li>
                                <li>Main images must have a pure white background, must be a photo (not a drawing), and must not contain excluded accessories.</li>
                                <li>Images must be at least 500 pixels on the longest side and at least 500 pixels on the shortest side to be zoom-able.</li>
                                <li>Images must not exceed 10000 pixels on the longest side.</li>
                                <li>JPEG is the preferred image format, but you also may use png and GIF files.</li>
                                <li>The Default featured image of the product would be the image which is selected by you on click of checkbox button.</li>
                                <li>You can able to add product video by their link i.e. Youtube Videos or any other video link.</li>
                                <?php 
                                  if($type==2 && !empty($product_variationsData)){
                                  $tempMore = ""; 
                                  $product_variation_info = $product_variationsData->product_variation_info;
                                  if(!empty($product_variation_info) && $product_variation_info!=''){
                                    $tempMore = "";
                                    $product_variation_info = json_decode($product_variation_info);
                                    if(!empty($product_variation_info)){
                                       foreach ($product_variation_info as $key => $value) {
                                          $tempMore .= "&nbsp;&nbsp;".ucfirst($key)."- &nbsp;".ucfirst($value).", &nbsp;&nbsp;";
                                       }
                                    }
                                  }

                                  if($tempMore!='' && !empty($tempMore)){ 
                                ?>
                                <li><b>The Variation details of this product - <?php echo $tempMore ?></b></li>
                                <?php } } ?>
                            </ul>
                          </div>
                        </div>
                        <div class="panel-body">
                           <div class="col-sm-12">
                                                      <form role="form" autocomplete="off" class="form-horizontal tasi-form" action="<?= base_url('seller/products/featured_image_change/'.$product_info_id.'/'.$product_variation_id.'/'.$type); ?>" enctype="multipart/form-data" method="post" >
                             <?php echo $this->session->flashdata('msg_error');?>
                             <br>
                             <input type="hidden" name="pfi" id="pfi" value="0">
                             <div class="input_fields_containerss image-flex-box">
                                <?php 
                                   $featured_image_status=0;  
                                    $indexing = 0;
                                   if(!empty($product_images)){
                                      
                                      foreach ($product_images as $row) {


                                      ?>
                                <div class="col-md-3 image-upload-box">
                                   <div class="image-upload-preview">
                                      <div class="fileinput fileinput-new" data-provides="fileinput">
                                         <div class="fileinput-preview thumbnail" data-trigger="fileinput">
                                           <?php $image_url=base_url('assets/uploads/seller/products/thumbnail/'.$row->image);
                                           ?>
                                            <img id="<?=$row->link?>" src="<?=$image_url?>" <?php echo ($row->status==2)?"onclick='video_show(this.id)'":'';?> data-src="holder.js/100%x100%" alt="...">
                                         </div>
                                         <br>
                                         <?php if($row->status==1) { ?>
                                         <div class="checkbox-input">
                                            <input type="hidden" name="featured_image[<?php echo $indexing; ?>]" value="0" >
                                            <input class="styled featured_image tooltips" <?php if($row->featured_image==1){ echo "checked='checked'"; $featured_image_status++; } ?> id="featured_image<?php echo $row->product_img_id; ?>" type="checkbox" name="featured_image[<?php echo $indexing; ?>]" value="0" data-bvalidator="required" data-bvalidator-msg="If you want to make this image as a featured, please click on it." img="<?php echo $row->product_img_id; ?>" rel="tooltip" data-placement="top" data-original-title="If you want to make this image as a featured, please click on it.">
                                            <label for="featured_image<?php echo $row->product_img_id; ?>"><?php if($row->featured_image==1){ ?>This is featured image<?php }else{ ?>Want to make featured image<?php } ?></label>
                                         </div>
                                       <?php } ?>

                                         <div class="image-upload-footer">
                                            <a <?php if($row->featured_image==1 && count($product_images) > 0){ ?> onclick="warnFeature()" <?php }else{ ?> onclick="return confirmBox('Do you want to delete it ?','<?php echo base_url('seller/products/delete_image/'.$row->product_img_id.'/'.$product_info_id); ?>')" <?php } ?> class="btn btn-danger btn-xs">Delete</a>
                                         </div>
                                      </div>
                                      <div class="clearfix"></div>
                                   </div>
                                </div>
                                <?php $indexing++; } }else{ ?>
                       
                                <?php } ?>
                                <div class="col-md-3 image-upload-box last-img-up-box">
                                   <div class="image-upload-preview">
                                      <div class="fileinput-preview thumbnail">
                                         <a href="javatpoint:void(0)" class="add-more-button-box" data-action='0' id="img_vid_popup">
                                            <div class="add-more-link">
                                               <div class="icon">+</div>
                                               <div>Add Image / Video</div>
                                            </div>
                                         </a>
                                      </div>
                                   </div>
                                </div>
                             </div>

                             <div class="clearfix"></div>
                         <!--     <div class="col-md-12">
                                <span class="error"><?php echo form_error('image'); ?> </span>
                             </div> -->
                             <div class="clearfix"></div>
                             <div class="form-actiosns form-btn-block text-center">
                                <button  class="btn btn-red" id="btnImg" type="submit">Continue</button>
                                <?php if($type!=2){ ?>
                                <a class="btn btn-default-white" href="<?php echo base_url('seller/products/product_other_info/'.$product_info_id.'/'.$product_variation_id.'/'.$type); ?>">Back</a>
                                <?php }else{ ?>
                                <a class="btn btn-default-white" href="<?php echo base_url('seller/products/product_offer/'.$product_info_id.'/'.$product_variation_id.'/'.$type); ?>">Back</a>
                                <?php } ?>
                             </div>
                            </form>
                              <!-- END FORM--> 
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

<!-- image video chooser popup -->
<div class="modal fade" id="image_videopopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content support-ticket-modal comman-modal">
         <div class="modal-header comman-header-modal">
            <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><img src="<?php echo SELLER_THEME_URL; ?>/img/Icon_Basic_Close.svg" width="18"></span>
            </button>
            <h4 class="modal-title text-center" id="myModalLabel">Choose Image OR Video</h4>
         </div>
         <div class="modal-body comman-body-modal">
            <ul class="nav nav-pills">
              
              <li><a href="javascipt:void(0)" id="image_acton" data-action='1'>Image</a></li>
              <li><a href="javascipt:void(0)" id="video_action" data-action='2'>Video</a></li>
            
           </ul>
            <div class="panel-body">
           <div class="col-sm-12">
             
          <form role="form" id="image_section"  autocomplete="off" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post" data-bvalidator-validate>
               <?php echo $this->session->flashdata('msg_error');?>
                <p class="image-upload-note-top"><span class="mandatory">Note*</span> Images must be at least 500 pixels on the longest side and at least 500 pixels on the shortest side to be zoom-able.
Images must not exceed 10000 pixels on the longest side and accept only jpg, jpeg, png, gif.</p>
               <br>
               <input type="hidden" name="pfi" id="pfi" value="0">
                 
               <div class="input_fields_container image-flex-box row">

                  <?php 
                     $featured_image_status=0;  
                     $indexing = 0;
                     ?>
                  <div class="col-md-3 image-upload-box">
                     <div class="image-upload-preview">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                           <div class="fileinput-preview thumbnail" data-trigger="fileinput">
                              <input class="imgUpload" type="file" data-bvalidator="extension[jpg:png:jpeg:gif],required" data-bvalidator-msg="choose an image file and <br> the accepted file type is jpg, jpeg, gif , png" name="image[]">
                              <img class="upload-default-image" id="upload-default-image" src="<?php echo SELLER_THEME_URL ?>img/default-upload-image.png" data-src="holder.js/100%x100%" alt="...">
                           </div>
                           <br>
                        </div>
                        <div class="clearfix"></div>
                     </div>
                  </div>
                  <div class="col-md-3 image-upload-box last-img-up-box">
                     <div class="image-upload-preview">
                        <div class="fileinput-preview thumbnail">
                           <a href="javatpoint:void(0)" class="add-more-button-box" data-action='0' id="add_more_button">
                              <div class="add-more-link">
                                 <div class="icon">+</div>
                                 <div>Add more</div>
                              </div>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-12">
                  <span class="error"><?php echo form_error('image'); ?> </span>
               </div>
               <div class="clearfix"></div>
            
             <div class="form-actiosns form-btn-block text-center">
               <button  class="btn btn-red" id="btnImg" type="submit">Add Image</button>
            </div>
      </form>
               
               <div class="clearfix"></div>

                  <form role="form" id="video_section" style="display:none;" autocomplete="off" class="form-horizontal tasi-form" action="<?php echo base_url('seller/products/product_video/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6))?>" enctype="multipart/form-data" method="post" data-bvalidator-validate>
           
                 <div class="form-group ">
                    <div class="col-md-12">
                    <label>Video Share URL <span class="mandatory">*</span></label>
                     
                    </div>
    
                  <div class="col-md-12">
                    <input type="url" class="form-control" placeholder="Enter youtube share URL" data-validation="url" data-bvalidator="required"  name="video_link"></div>
                </div>
                 <div class="clearfix"></div>
                    <div class="form-group img-choozen brand-img-upload">
                        <div class="col-md-3 col-sm-6">
                          <label>Upload Mirror Image <span class="mandatory">*</span></label>
                        </div>
                         <div class="col-md-9 col-sm-6 video_mirror_image">
                          <div class="row">
                            <div class="col-lg-6">
                          <div class="image-upload-box">
                             <div class="image-upload-preview image-upload-preview-mirror">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                   <div class="fileinput-preview fileinput-preview-mirror thumbnail" data-trigger="fileinput"><input type="file" class="imgUpload" name="mirror_image" data-bvalidator="extension[jpg:png:gif:jpeg],required" data-bvalidator-msg="choose an image file and <br> the accepted file type is jpg,gif,jpeg,png" ><img class="upload-default-image upload-default-image-mirror" id="upload-default-image-mirror" src="http://192.168.2.137/marketplace/assets/seller/img/default-upload-image.png" data-src="holder.js/100%x100%" alt="..."></div>
                                </div>
                             </div>
                          </div>
                          </div>
                          <div class="col-lg-6">
                                <p class="image-upload-note"><span class="mandatory">Note*</span> Images must be at least 500 pixels on the longest side and at least 500 pixels on the shortest side to be zoom-able.
                                Images must not exceed 10000 pixels on the longest side and accept only jpg,jpeg,png,gif.
                               </p>
                         </div>
                       </div>
                        </div>
                                <span class="error"><?php echo form_error('mirror_image'); ?> </span>
                    </div>
                      <div class="col-md-12">
          
               </div>
               <div class="form-actiosns form-btn-block text-center">
               <button  class="btn btn-red" id="btnImg" type="submit">Add Video</button>
              </div>
            </form>

         
                              <!-- END FORM--> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="video_show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content support-ticket-modal comman-modal">
         <div class="modal-header comman-header-modal">
            <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><img src="<?php echo SELLER_THEME_URL; ?>/img/Icon_Basic_Close.svg" width="18"></span>
            </button>
            <h4 class="modal-title text-center" id="myModalLabel"></h4>
         </div>
         <div class="modal-body comman-body-modal">
     
            <div class="panel-body">
           <div class="col-sm-12">
  

           
           <iframe id="video_src" width="480" height="300" src="" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
         
                          
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- image video chooser popup -->
<script>
$(document).ready(function(){
  <?php if(form_error('image')!=''){ ?>
    $('#image_videopopup').modal('show');
  <?php } ?>
});

  function video_show(val){
        $("#video_src").attr("src",'');
        var src=val.split("/");
        $("#video_src").attr("src",'https://www.youtube.com/embed/'+$(src).get(-1));
        $('#video_show').modal('show');
    }

    $(document).ready(function(){
      $('#image_section,#video_section').bValidator();
      var count=parseInt(<?php echo $indexing; ?>);
      var max_fields_limit      = 10; //set limit for maximum input fields
        var x = 1; //initialize counter for text box

        $('.btn-close-modal').click(function(e){

        $("#video_src").attr("src",'');
        }
        );
        $('#img_vid_popup,#image_acton,#video_action').click(function(e){

           var data_action=$(this).attr('data-action');
          if(data_action==0)
            { 
            $('#image_videopopup').modal('show');
            $('#image_section').show();
            $('#video_section').hide();
            } 
           else if(data_action==1){
             $('#image_section').show();
            $('#video_section').hide();
           }
           else {
             $('#image_section').hide();
            $('#video_section').show();
           }

         });

        $('#add_more_button').click(function(e){ //click event on add more fields button having class add_more_button
           e.preventDefault();
            count++;
         
            x++; //counter increment
            $('.input_fields_container .last-img-up-box').before('<div class="col-md-3 image-upload-box"><div class="image-upload-preview"><div class="fileinput fileinput-new" data-provides="fileinput"><div class="fileinput-preview thumbnail" data-trigger="fileinput"><input type="file" class="imgUpload" data-bvalidator="extension[jpg:png:gif:jpeg],required" data-bvalidator-msg="choose an image file and <br> the accepted file type is jpg, jpeg, png" name="image[]"><img class="upload-default-image" id="upload-default-image" src="<?php echo SELLER_THEME_URL ?>img/default-upload-image.png" data-src="holder.js/100%x100%" alt="..."></div><br><div><div class="image-upload-footer"></span><div><a href="#" class="btn btn-danger remove_field btn-xs" data-dismiss="fileinput">Remove</a></div></div><div class="clearfix"></div></div></div>'); //add input field
    
    
        });  
      
        $('.input_fields_container').on("click",".remove_field", function(e){ //user click on remove text links
           e.preventDefault(); $(this).parents('div.image-upload-box').remove(); x--;
        });

        $('#btnImg').click(function(){ 
         if($('form').data('bValidator').isValid()){
            $(this).attr("disabled", 'disabled');
            $("form").submit();
         }
       }); 

    });

    function warnFeature() {
      warningMsg("This image is a featured image of your product. If you want to delete it, please make the other image as featured.");
      return false;
    }

    function readURL(input) {

      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $(".fileinput-preview p").text('');
          $(input).closest('.image-upload-preview').find('.upload-default-image').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }

    function mirrorreadURL(input) {

      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $(".fileinput-preview-mirror p").text('');
          $(input).closest('.image-upload-preview-mirror').find('.upload-default-image-mirror').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }


    $(".input_fields_container").on('change',".imgUpload",function() {
      readURL(this);
    });

      $(".video_mirror_image").on('change',".imgUpload",function() {
      mirrorreadURL(this);
    });

    $('.input_fields_containerss').on('change', '.featured_image', function(){
      var imgId = $(this).attr('img');
      $(".featured_image").val('0');
      $(this).val('1');
      $('.featured_image').prop('checked', false);
      $(this).prop('checked',true);
      $("#pfi").val(imgId);
    });

</script>
<style>
.checkbox-input label{
  font-size: 12px;
  font-weight: 600;
}
</style>