<div class="bread_parent">
   <div class="col-md-12">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
         <li><a href="<?php echo base_url('backend/products/index'); ?>">Products</a></li>
         <li>Add Product Category</li>
      </ul>
   </div>
   <div class="clearfix"></div>
</div>
<div class="superadmin-body panel-body partners">
   <ul class="nav nav-tabs " role="tablist">
      <li class="active"><a href="<?php echo base_url().'backend/products/product_category'; ?>"><b>Product Categories</b></a></li>
      <li <?php if($this->session->userdata('productcat_info')['status']==1) echo ""; else echo "class='disabled' style='pointer-events:none;'"; ?>><a href="<?php echo base_url().'backend/products/product_basic_info'; ?>"><b>Vital Info</b></a></li>

      <li class='disabled' style='pointer-events:none;'><a href="javascript:void(0)" ><b>Variation(Variation Theme)</b></a></li>
      <li class='disabled' style='pointer-events:none;'><a href="javascript:void(0)" ><b>Offer</b></a></li>
      <li class='disabled' style='pointer-events:none;'><a href="javascript:void(0)" ><b>Compliance</b></a></li>
      <li class='disabled' style='pointer-events:none;'><a href="javascript:void(0)" ><b> Images</b></a></li>
      <li class='disabled' style='pointer-events:none;'><a href="javascript:void(0)" ><b> Product Description</b></a></li>
      <li class='disabled' style='pointer-events:none;'><a href="javascript:void(0)" ><b> Keywords</b></a></li>
      <li class='disabled' style='pointer-events:none;'><a href="javascript:void(0)" ><b>Meta Information</b></a></li>

   </ul>
   <div class="adv-table">
      <div class="panel-body">
      <header class="panel-heading colum"><i class="fa fa-globe"></i> Choose Product Categories</header>
         <form role="form" autocomplete="off" class="form-horizontal product_cat" action="<?php echo current_url()?>" method="post" data-bvalidator-validate>
            <br>
            <div class="col-md-12 form-group">
               <div class="col-md-offset-1 col-md-10">
                  <select class="form-control productcategory" name="productcategory[]" main="0" onchange="getsubcat(this);" data-bvalidator="required">
                    <option value="">--Select Category--</option>
                    <?php foreach ($main_category as $row) { ?>
                      <option value="<?php echo $row->category_id; ?>"><?php echo ucfirst($row->category_name); ?></option>
                    <?php } ?>
                  </select>
               </div>
               <div class="clearfix"></div>
               <?php echo form_error('productcategory'); ?>
            </div>
            
            <div class="subcat0"></div>


            <div class="form-actiosns fluid">
                <div class="form-btn-block">
                   <div class="col-md-12 text-center">
                      <input class="btn btn-primary selectProductCat" type="submit" name="selectProductCat" id="selectProductCat" value="Submit">&nbsp;&nbsp;
                      <a class="btn btn-danger btn-md tooltips" href="<?php echo base_url('backend/products/index'); ?>" rel="tooltip" data-placement="top" title="" data-original-title="Back to Product Listing"><i class="icon-remove"></i>Back</a> 
                   </div>
                </div>
            </div>

         </form>
      </div>
   </div>
</div>

<script>
  var SITE_URL = "<?php echo base_url(); ?>";

  function getsubcat(cat){
   var category = $(cat).val();
    var main=$(cat).attr('main');
    $('.subcat'+main).html('');
     if(category){
        $.ajax({
           url: SITE_URL + 'backend/products/getProductSubcategory',
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