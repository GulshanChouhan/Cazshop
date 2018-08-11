
<?php $offset =0; ?>
<div class="bread_parent">
   <div class="col-md-9">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
         <li><a href="<?php echo base_url('backend/pages/faq_category');?>">FAQs Categories  </a></li>
         <li><b>FAQs Subcategory of <?php if(!empty($page_category->category_name)) echo $page_category->category_name; ?> </b></li>
      </ul>
   </div>
   
   <div class="col-md-3">
      <div class="btn-group pull-right">
         <a class="btn btn-primary btn-toggle-link tooltips" data-toggle="collapse" data-target="#subtogg" id="add" data-original-title="Click to add FAQs Subcategory in <?php if(!empty($page_category->category_name)) echo $page_category->category_name; ?>">
         Add FAQs Subcategory &nbsp;<i class="fa fa-chevron-down"></i>
         </a>
      </div>
   </div>
   <div class="clearfix"></div>
</div>

 <div class="tab-pane row-fluid fade in active toggle-inner-panel" id="subtogg" >
  <!-- <form role="form" class="form-horizontal tasi-form" name="frm1" action="<?php echo current_url()?>" enctype="multipart/form-data" id="form_valid" method="post">
      <input type="hidden" name="type_action" value="1">
      <div class="form-body">
         <div class="form-group">
            <div class="col-md-3">
               <input type="text" placeholder="FAQs Subcategory Name" class="form-control" name="category_name" value="<?php echo set_value('category_name');?>" data-bvalidator="required" data-bvalidator-msg="Page Sub Category is required">
               <?php echo form_error('category_name'); ?>
            </div>
            <div class="col-md-4" id="input_field_to_search">
               <input type="text" placeholder="Search by Name like state, countries" class="form-control" name="sub_category_name" value="<?php echo set_value('sub_category_name');?>">
            </div>
            <div class="col-md-2">
               <button  class="btn btn-primary tooltips" rel="tooltip" data-placement="top" data-original-title="Add Subcategory under <?php if(!empty($page_category->category_name)) echo $page_category->category_name; ?>" name="add" type="submit">Add Subcategory</button>
            </div>
         </div>
      </div>
   </form> -->

 <form role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post" id="form_valid">
   <div class="form-body">
      <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i>FAQs Subcategory information:</header>
      <br>
      <div class="form-group">
         <label class="col-md-3 control-label">FAQs Subcategory Name <span class="mandatory">*</span></label>
         <div class="col-md-6">
            <input type="text" placeholder="FAQs Subcategory Name" class="form-control" name="category_name" value="<?php echo set_value('category_name');?>" data-bvalidator="required" data-bvalidator-msg="Page Sub Category is required">
               <?php echo form_error('category_name'); ?>
         </div>
      </div>
      <div class="form-group">
         <label class="col-md-3 control-label">Description <span class="mandatory">*</span></label>
         <div class="col-md-6">
            <textarea  class="tinymce_edittor form-control" name="description"  placeholder="Description" data-bvalidator="required" data-bvalidator-msg="Description required" ><?php echo set_value('description');?></textarea> 
            <?php echo form_error('description'); ?>
         </div>
      </div>
      <div class="form-actions fluid">
         <div class="col-md-offset-3 col-md-10">
            <button  class="btn btn-primary tooltips" rel="tooltip" data-placement="left" data-original-title="Add FAQs Subcategory" type="submit"><i class="icon-plus"></i> Add Subcategory</button>
                                         
         </div>
      </div>
      <div class="clearfix"></div>
   </div>
</form>
 


   <!-- END FORM-->   
</div>


<!--table -->
<div class="panel-body">
   <div class="adv-table">
      <?php echo form_error('sub_category_name_edit');
         if(!empty($page_sub_category)):
         ?> 
      <table id="datatable_example" class="table-bordered responsive table table-striped table-hover">
         <thead class="thead_color">
            <tr>
               <th width="5%" class="jv no_sort">#</th>
               <th width="15%">Subcategory Name</th>
               <th width="15%">Status</th>
               <th width="15%">Created</th>
               <th width="8%">Actions</th>
            </tr>
         </thead>
         <?php  
            // if(empty($store_sub_category)):
              $i=0; foreach($page_sub_category as $row): 
            $i++;?>
         <tbody>
            <tr>
               <td><?php echo $offset+$i.".";?></td>
               <td class=""> 
                  ID : <?php  if(!empty($row->faq_sub_category_id)) echo $row->faq_sub_category_id; ?><br>
                  <?php if(!empty($row->sub_category_name)) echo $row->sub_category_name; ?>
               </td>
               <td class=""> 
                  <?php if($row->status==1){ ?>
                  <a onclick="return confirmBox('<?php if($row->status==2) echo "Do you want to activate ?"; else if($row->status==1) echo "Do you want to deactivate ?"; ?>','<?php echo base_url('backend/pages/changeuserstatus_t/'.$row->faq_sub_category_id.'/'.$row->status.'/'.$offset.'/faq_sub_category'.'/faq_sub_category_id')?>')" class="btn btn-<?php if($row->status==2) echo 'danger'; else echo 'success';  ?> btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Click to <?php if($row->status==2) echo 'Active'; else echo 'Deactive';  ?>"><?php if($row->status==2) echo 'Deactive'; else echo 'Active';  ?>
                  </a>  
                  <?php } else if($row->status==2){ ?>
                  <a onclick="return confirmBox('<?php if($row->status==2) echo "Do you want to activate ?"; else if($row->status==1) echo "Do you want to deactivate ?"; ?>','<?php echo base_url('backend/pages/changeuserstatus_t/'.$row->faq_sub_category_id.'/'.$row->status.'/'.$offset.'/faq_sub_category'.'/faq_sub_category_id')?>')" class="btn btn-<?php if($row->status==2) echo 'danger'; else echo 'success';  ?> btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Click to <?php if($row->status==2) echo 'Active'; else echo 'Deactive';  ?>"><?php if($row->status==2) echo 'Deactive'; else echo 'Active';  ?>
                  </a>  
                  <?php } ?>
               </td>
               <td class="to_hide_phone"><i class="fa fa-calendar"></i>&nbsp;<?php echo date('d M Y,h:i  A',strtotime($row->created)); ?></td>
               <td class="ms">
                  <a href="<?php echo base_url().'backend/pages/faq_sub_category_edit/'.$row->faq_sub_category_id?>"  class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top" title="Edit <?php if(!empty($row->sub_category_name)) echo $row->sub_category_name; ?>">
                  <i class="icon-pencil"></i> 
                  </a> 
               </td>
            </tr>
         </tbody>
         <?php  endforeach; ?>
         <?php else: ?>
         <div class="alert alert-info">
            <center>
            <strong>No Page Sub Categories are available in the system </strong> <br>
            Click the above button to add Sub category 
            <center>
         </div>
         <?php endif; ?> 
      </table>
   </div>
</div>
<div class="row-fluid  control-group mt15">
   <div class="span12">
      <?php  if(!empty($pagination))  echo $pagination; ?>              
   </div>
</div>

<style type="text/css">
   .img_size{
   max-height: 100px;
   max-width: 100px;
   }
</style>
<script type="text/javascript">
    $(function () {
        $("[rel='tooltip']").tooltip();
        $('body').on('click', '.togglesubcat', function(){
            $('.toggle-inner-panel').toggle(1000);
        });
    });
</script>