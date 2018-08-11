<style type="text/css">
   hr.style1{
   border:none;
   border-left:1px solid hsla(200, 10%, 50%,100);
   height:100vh;
   width:1px;
   }
</style>
<div class="bread_parent">
   <ul class="breadcrumb">
      <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
      <li><a href="<?php echo base_url('backend/products/variation_themes'); ?>">Product Variation Theme </a></li>
      <li><b>Add Product Variation Theme</b></li>
   </ul>
</div>


<div class="col-sm-12">
   <div class="panel-body">
      <form role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post">
         <?php //echo validation_errors(); ?>
         <?php echo $this->session->flashdata('msg_error');?>
         <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i>Product Variation Theme information :</header>
         <br>
         <div class="form-group">
            <label class="col-md-2 control-label">Variation Theme Title <span class="mandatory">*</span></label>
            <div class="col-md-9">
               <input type="text" placeholder="Variation Theme Title" class="form-control" name="product_theme_title" value="<?php echo set_value('product_theme_title');?>" > <span class="error"><?php echo form_error('product_theme_title'); ?> </span>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Category <span class="mandatory">*</span></label>
            <div class="col-md-9">
               <select name="category" class="form-control main-search-catg" onchange="getAttrDataUsingCategory(this.value)">  
                  <option value="" >--Select Category--</option>
                   <?php 
                      $cate=''; 
                      if(!empty($_GET['category'])) 
                        $cate=$_GET['category'];

                      echo getcategoryDropdown($cate); 
                   ?>
               </select>
               <span class="error"><?php echo form_error('category'); ?> </span>
            </div>
         </div>
         
         <div class="form-group atrributeData" style="display: none;">
            <label class="col-md-2 control-label">Choose Atrribute <span class="mandatory">*</span></label>
            <div class="col-md-9 attributesUsingCat">
               <span class="error"><?php echo form_error('attributesUsingCat[]'); ?> </span>
            </div>
         </div>

         <div class="form-group">
            <label class="col-md-2 control-label">Status</label>
            <div class="col-md-9">
               <select class="form-control" name="status" >
                  <option value="1" <?php if(set_value('status')==1) echo 'selected'; ?>>Active</option>
                  <option value="2" <?php if(set_value('status')==2) echo 'selected'; ?>>Inactive</option>
               </select>
               <span class="error"><?php echo form_error('status'); ?> </span>
            </div>
         </div>

         <br>
         <div class="form-actions fluid">
            <div class="col-md-offset-2 col-md-10">
               <button  class="btn btn-primary" type="submit">Submit</button>
               <a class="btn btn-danger" href="<?php echo base_url()?>backend/products/variation_themes">
               Back</a>
            </div>
         </div>
      </form>
      <!-- END FORM--> 
   </div>
</div>

<script>
   var SITE_URL = "<?php echo base_url(); ?>";
   function getAttrDataUsingCategory(category){
      if(category){
         $(".atrributeData").show();
         $.ajax({
            url: SITE_URL+'backend/products/getAttrDataUsingCategory', 
            type: 'POST',
            data: {
               catID      : category,
               attributes : ""
            },
            cache: false,
            success:function(result){               
              var data = JSON.parse(result);
              $('.attributesUsingCat').html(data.optionData);
            },
         });
      }else{
         $(".atrributeData").hide();
      }
   }
</script>