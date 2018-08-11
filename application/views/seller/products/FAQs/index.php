<div class="bread_parent">
   <ul class="breadcrumb">
      <li><a href="<?php echo base_url('seller/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
      <li><a href="<?php echo base_url('seller/products/index');?>"> List Of Products </a></li>
      <li>Manage Product FAQs</li>
   </ul>
   <div class="clearfix"></div>
</div>

<div class="theme-container clearfix">
   <div class="clearfix"></div>
   <div class="col-md-12 col-lg-12">
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
                        <div class="panel-heading">
                          <div class="panel-title"><i class="icofont icofont-info-square"></i> List Of FAQs 
                            <?php 
                              $productT = getRow('products_info',array('product_info_id'=>$product_variationsData->product_info_id),array('title'));
                              if(!empty($productT)) 
                                echo ' - "'.$productT->title.'"'; 
                            ?>
                          </div>
                        </div>
                        <div class="panel-body">
                           <div class="col-sm-12 no-padding">
                              <form action="<?php echo base_url('seller/products/product_faq/'.$product_variation_id) ?>" method="get" role="form" class="form-horizontal">
                                <table class="responsive table_head common-table-top-section" cellpadding="5">
                                  <thead>
                                    <tr>
                                      <th width="15%">Question</th>
                                      <th width="20%">Answer</th>
                                      <th width="15%">Status</th>
                                      <th width="100px"></th>
                                      <th></th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <div class="">
                                          <input type="text" placeholder="Question" class="form-control" name="question" value="<?php if(!empty($_GET['question'])) echo $_GET['question']; ?>">
                                        </div>
                                      </td>
                                      <td>
                                        <div class="">
                                          <input type="text" placeholder="Answer" class="form-control" name="answer" value="<?php if(!empty($_GET['answer'])) echo $_GET['answer']; ?>">
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
                                        <a class="btn btn-danger tooltips" rel="tooltip" data-placement="top" data-original-title="Reset your product FAQs search" type="submit" href="<?php echo base_url('seller/products/product_faq/'.$product_variation_id); ?>"> <i class="icon icon-refresh"></i></a>
                                      </td>
                                      <td>
                                        <div class="pull-right">
                                          <a class="btn btn-primary tooltips" href="<?php echo base_url()?>seller/products/add_product_FAQs/<?php echo $product_variation_id; ?>" rel="tooltip" data-placement="top" data-original-title=" Click to add a product FAQs"><i class="icon-plus"></i> Add Product FAQs
                                           </a>
                                        </div>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </form>
                              <!-- END FORM--> 
                           </div>

                           <div class="col-md-12 no-padding">
                             <div class="adv-table" id="tab1">
                                <table id="datatable_example" class="table-bordered responsive table table-striped table-hover">
                                   <thead class="thead_color">
                                      <tr>
                                         <th class="jv no_sort" width="8%">
                                          <div class="col-md-12 no-padding">
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
                                         <th>Question</th>
                                         <th>Answer</th>
                                         <th width="15%">Created </th>
                                         <th width="10%">Status </th>
                                         <th width="8%">Actions</th>
                                      </tr>
                                   </thead>
                                   <tbody>
                                      <?php
                                         if(!empty($product_FAQs)){
                                         $i=0; 
                                         foreach($product_FAQs as $row){
                                         $i++;
                                         ?>
                                      <tr>
                                         <td>
                                            <div class="checkbox-input">
                                              <input class="styled" type="checkbox" id="checkall<?php echo $i ?>" name="checkstatus[]" value="<?php echo $row->product_faq_id; ?>">  &nbsp;&nbsp; <?php echo $offset+$i.".";?>
                                              <label class="" for="checkall<?php echo $i ?>"></label>
                                            </div>
                                         </td>
                                         <td>
                                           <?php echo $row->question; ?>
                                          </td>
                                          <td>
                                            <?php echo $row->answer; ?>
                                          </td>
                                          <td><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo date('d M Y,h:i  A',strtotime($row->created_at)); ?>
                                          </td>
                                          <td>
                                            <a href="javascript:void(0);" onclick="return confirmBox('<?php if($row->status==2) echo "Do you want to activate it ?"; else if($row->status==1) echo "Do you want to deactivate it ?"; ?>','<?php echo base_url().'backend/common/change_status/product_faq/product_faq_id/'.$row->product_faq_id.'/'; if($row->status==2) echo '1'; else echo '2'; ?>')" class="btn btn-<?php if($row->status==2) echo 'danger'; else echo 'success';  ?> btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Click to <?php if($row->status==2) echo 'Active'; else echo 'Deactive';  ?>"><?php if($row->status==2) echo 'Deactive'; else echo 'Active';  ?>
                                               </a> 
                                          </td>
                                          <td>

                                            <a href="<?php echo base_url().'seller/products/edit_product_FAQs/'.$row->product_variation_id.'/'.$row->product_faq_id; ?>" class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title=" Edit Product FAQs"><i class="icon-pencil"></i>
                                             </a>

                                            <a href="javascript:void(0);" onclick="return confirmBox('Do you want to delete it ?','<?php echo base_url().'backend/common/delete/product_faq/product_faq_id/'.$row->product_faq_id; ?>')" class="btn btn-danger btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Delete Product FAQs"><i class="icon-trash "></i>
                                            </a>
                                            
                                         </td>
                                      </tr>
                                      <?php } ?>
                                      <?php }else{ ?>
                                      <tr>
                                         <th colspan="10">
                                            <center>No Products FAQs Available.</center>
                                         </th>
                                      </tr>
                                      <?php } ?>
                                   </tbody>
                                </table>
                                <div class="row-fluid  control-group mt15">
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

                var tb_name = "<?php echo base64_encode('product_faq'); ?>"; 
                var col_name = "<?php echo base64_encode('product_faq_id'); ?>";     

                $.post('<?php echo base_url() ?>'+'backend/pages/change_all_status', {'table_name': tb_name, 'col_name': col_name, 'status': new_status, 'row_id': row_id}, function(data) {            
                   if(data.status==true){  
                      $(location).attr('href', '<?php echo base_url('seller/products/product_faq/'.$product_variation_id)?>');
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

      if(toggleShow=='close'){
         $(obj).attr("toggleShow", "open");
         $.ajax({
              url: SITE_URL + 'seller/products/getVariationProducts',
              type: 'POST',
              data: {
                  product_info_id: product_info_id,
                  statusProduct: "1"
              },
              cache: false,
              success: function(result) {
                 var data = JSON.parse(result);
                 if(data){
                   $("#toggleVRIcon"+product_info_id).removeClass('fa fa-plus').addClass('fa fa-minus');
                   $("child_"+product_info_id).show(500);
                   $(obj).closest('tr').after(data.data);
                 }
              },
         });
      }else{
         $(".child_"+product_info_id).remove();
         $("#toggleVRIcon"+product_info_id).removeClass('fa fa-minus').addClass('fa fa-plus');
         $(obj).attr("toggleShow", "close");
      }
   }

</script>

