<div class="bread_parent">
   <div class="col-md-12">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
         <li><a href="<?php echo base_url('backend/products/index'); ?>">Products</a></li>
         <li>Product Meta Info</li>
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
 
        <?php if($showForm==1){ ?>
         <form autocomplete="off" role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post">
            <?php echo $this->session->flashdata('msg_error');?>
            <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i> Product SEO Information :</header>
            <br>
             <div class="form-group">
               <label class="col-md-2 control-label">Meta Title :</label>
               <div class="col-md-9">
                  <?php if(!empty($product_seo_info->meta_title)){ echo ucfirst($product_seo_info->meta_title); }else{ echo "-"; } ?>
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-2 control-label">Meta Keywords:</label>
               <div class="col-md-9">
                  <?php if(!empty($product_seo_info->meta_keywords)){ echo ucfirst($product_seo_info->meta_keywords); }else{ echo "-"; } ?>
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-2 control-label">Meta Description :</label>
               <div class="col-md-9">
                  <?php if(!empty($product_seo_info->meta_description)){ echo ucfirst($product_seo_info->meta_description); }else{ echo "-"; } ?>
               </div>
            </div>
            <div class="form-actiosns fluid">
                <div class="form-btn-block">
                   <div class="col-md-12 text-center">
                      <a class="btn btn-danger" href="<?php echo base_url('backend/products/product_descriptions/'.$product_info_id.'/'.$product_variation_id.'/'.$type); ?>">Back</a>
                   </div>
                </div>
             </div>
         </form>
         <!-- END FORM--> 
         <?php }else{ ?>
         <div class="col-md-12 text-center">
            <h4><b><i class="fa fa-info-circle" aria-hidden="true"></i> We have not permitted you to edit the Product SEO Information</b></h4>
         </div>
         <?php } ?>
      </div>
   </div>
</div>