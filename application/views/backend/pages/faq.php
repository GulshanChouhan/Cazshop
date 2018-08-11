  <div class="bread_parent">
   <div class="col-md-9">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
         <li><a href="<?php echo base_url('backend/page/faq');?>"><b>FAQs </b> </a></li>
      </ul>
   </div>
   <div class="col-md-3">
      <div class="btn-group tooltips pull-right">
         <a class="btn btn-primary tooltips" href="<?php echo base_url()?>backend/pages/faq_add" rel="tooltip" data-placement="left"  title="Add FAQs" >Add FAQs
         <i class="icon-plus"></i></a>   
      </div>
   </div>
   <div class="clearfix"></div>
</div>

<div class="panel-body no-padding-top">
  <header class="tabel-head-section">
     <form action="<?php echo base_url('backend/pages/faq'); ?>" method="get" role="form" class="form-horizontal">
         <div class="">
           <table class="responsive table_head" cellpadding="5">
              <thead>
                  <th width="25%">Question</th>
                  <th width="15%">Status</th>
                  <th></th>
              </thead>
              <tbody>
                 <tr>
                    <td>               
                       <input type="text" placeholder="Question" class="form-control" name="question" value="<?php if(isset($_GET['question'])){ echo $_GET['question']; }?>">              
                    </td>
                    <td>
                       <select name="status" class="form-control">
                          <option value="0"<?php if(!empty($_GET['status']) && $_GET['status']==0) echo 'selected'?>>All </option>
                          <option value="1" <?php if(!empty($_GET['status']) && $_GET['status']==1) echo 'selected'?> >Active</option>
                          <option value="2" <?php if(!empty($_GET['status']) && $_GET['status']==2) echo 'selected'?>>Deactive</option>
                       </select>
                    </td>
                    
                    <td> <button type="submit" class="btn btn-primary tooltips" rel="tooltip" data-placement="top" data-original-title="Search FAQs" type="submit"><i class="icon icon-search"></i></button>
                       <a class="btn btn-danger tooltips" href="<?php echo base_url('backend/pages/faq'); ?>" rel="tooltip" data-placement="top" data-original-title="Reset your FAQs list" type="submit"> <i class="icon icon-refresh"></i></a>
                    </td>
                 </tr>
              </tbody>
           </table>
        </div>
     </form>
  </header>


  <div class="no-padding-top">
    <div class="adv-table" id="tab1">
        <table id="datatable_example" class="table-bordered responsive table table-striped table-hover">
           <thead class="thead_color">
              <tr>
                 <th class="jv no_sort" width="10%">
                    <div class="col-md-10 no-padding-left">
                       <span class="checkboxli term-check">
                       <input type="checkbox" id="checkAll" class="" >
                       <label class="" for="checkAll"></label>
                       </span>
                       <select   class="form-control commonstatus order-select-status" >
                          <option value="">All</option>
                          <option value="1">Active</option>
                          <option value="2">Deactive</option>                
                       </select>
                    </div>
                 </th>
                 <th>Question</th>
                 <th>Categories</th>
                 <th>Sub Categories</th>
                 
                 <th>Created</th>
                 <th class="to_hide_phone ue no_sort">Status</th>
                 <th class="ms no_sort ">Actions</th>
              </tr>
           </thead>
           <?php  if(!empty($question_answer)): ?>
           <tbody>
              <?php 
                 $i=0; foreach($question_answer as $row): 
                 $i++;?>
              <tr >
                 <td>
                    <span class="checkboxli term-check">
                    <input type="checkbox" id="checkall<?php echo $i ?>" name="checkstatus[]" value="<?php echo $row->faq_id; ?>">  &nbsp;&nbsp; <?php echo $offset+$i.".";?>
                    <label class="" for="checkall<?php echo $i ?>">
                    </label>
                    </span>
                 </td>
                 <td><?php echo $row->question; ?></td>
                 <td>
                    <?php if(!empty($row->category_id)) echo getPageCategoryName($row->category_id,'faq_category','category_name', 'faq_category_id'); ?>
                 </td>
                 <td>
                    <?php if(!empty($row->sub_category_id)) echo getPageCategoryName($row->sub_category_id,'faq_sub_category','sub_category_name', 'faq_sub_category_id'); ?>
                 </td>
                 <td><?php echo date('d M Y',strtotime($row->created)); ?></td>
                 <td class="to_hide_phone">
                    <a class="btn btn-<?php if($row->status==2) echo 'danger'; else echo 'success';  ?> btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="<?php if($row->status==1) echo "Click to Deactive"; else if($row->status==2) echo "Click to Active"; ?>" onclick="return confirmBox('<?php if($row->status==1) echo "Do you want to deactivate ?"; else if($row->status==2) echo "Do you want to activate ?"; ?>','<?php echo base_url('backend/pages/changeuserstatus_t/'.$row->faq_id.'/'.$row->status.'/'.$offset.'/faq'.'/faq_id')?>')"><?php if($row->status==1) echo "Active"; else if($row->status==2) echo "Deactive"; ?></a> 
                 </td>
                 <td class="ms">
                    <a href="<?php echo base_url().'backend/pages/faq_edit/'.$row->faq_id ?>"  class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Edit FAQs" rel="tooltip" data-placement="left"   html/data-html="true" >
                    <i class="icon-pencil"></i> 
                    </a> 
                 </td>
              </tr>
              <?php  endforeach; ?>
           </tbody>
          <?php else: ?>
          <?php   if($_GET){ ?>
          <p> 
          <center class="msg_error">
             <!-- Your search did not match any documents ? -->
             Your search did not match any documents.<br>
             Suggestions:<br>
             Make sure that id is present or you have seen before.<br>
             Make sure that all words are spelled correctly.<br>
             Try to search by status.<br>
             Try to search by newer,older, A-Z or Z-A.<br>             
          </center>
          </p>
          <?php } else { ?>
          <div class="alert alert-info">
             <center><strong>No question answer Category are availbale in the system.<br><span class="validation_info"><b>Click button on right side to add new question answer category or</b> </span>  <img class="hand_icon_size" src="<?php echo BACKEND_THEME_URL ?>img/handpointRTig.gif" alt=""><a href="<?php echo base_url().'backend/pages/faq' ?>">Add New Category</a>  </strong> <br>
                <a href=""><i class="icon-arrow"></i></a>
             </center>
          </div>
          <?php } ?>    
          <?php endif; ?>
        </table>
        <div class="col-md-12 parent_pagiation ">
           <div class="row-fluid control-group mt15 pull-right">
              <div class="span12">
                 <?php if(!empty($pagination))  echo $pagination;?>              
              </div>
           </div>
        </div>
     </div>
  </div>

</div>

<script>
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
                if($(this).val()!='')
                {
                  row_id[i]=$(this).val();       
                  i++; 
                }    
              });   
              var tb_name = "<?php echo base64_encode('faq'); ?>";
              var col_name = "<?php echo base64_encode('faq_id'); ?>";      
              $.post('<?php echo base_url() ?>'+'backend/pages/change_all_status', {'table_name': tb_name, 'col_name':col_name, 'status': new_status, 'row_id': row_id}, function(data) {            
                window.location.reload(true);
                 return false;
              });

          });    
        }else{
          errorMsg("Please check the checkbox");
          return false;
        }  
      });
    });
</script>