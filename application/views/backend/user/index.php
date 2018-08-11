<?php
   if($user_role==1){
    $activate = "Do you want to activate this Seller  ?";
    $deactivate = "Do you want to deactivate this Seller ?";
    $userRoleName = "Sellers";
   }else if($user_role==2){
    $activate = "Do you want to activate this Customer ?";
    $deactivate = "Do you want to deactivate this Customer ?";
    $userRoleName = "Customers";
   }
?>
<div class="bread_parent">
   <div class="col-md-9">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
         <li><b><?php if($user_role==1) echo "List Of Sellers"; else if($user_role==2) echo "List Of Customers"; ?></b></li>
      </ul>
   </div>
   <div class="clearfix"></div>
</div>
<div class="panel-body no-padding-top">
   <header class="tabel-head-section">
      <form action="<?php echo base_url('backend/user/index/'.$user_role) ?>" method="get" role="form" class="form-horizontal">
         <div class="">
            <table class="responsive table_head" cellpadding="5">          
               <thead>
                  <tr>
                     <th width="15%"><?php if($user_role==1){ echo "Seller"; }else if($user_role==2){ echo "Customer"; }else{ echo "User"; } ?> Name</th>
                     <th width="20%">Email Address</th>  
                     <th width="10%">Country Code</th>
                     <th width="15%">Phone No.</th>
                     <th width="15%">Status</th>
                     <th></th>
                  </tr>
               </thead>
               <tbody>
               <tr>
                 <td>
                    <div class="">                
                       <input type="text" placeholder="<?php if($user_role==1){ echo "Seller"; }else if($user_role==2){ echo "Customer"; }else{ echo "User"; } ?> Name" class="form-control" name="user_name" value="<?php if(!empty($_GET['user_name'])) echo $_GET['user_name']; ?>">
                    </div> 
                 </td>
                 <td> 
                    <div class="">                
                       <input type="text" placeholder="Email Address" class="form-control" name="email" value="<?php if(!empty($_GET['email'])) echo $_GET['email']; ?>">
                    </div> 
                 </td>
                 <td> 
                    <div class="">                
                       <select name="country_code" id="country_code" class="form-control">
                        <option value="">--Select--</option>
                        <?php
                         if(!empty($phnCode)){
                         foreach ($phnCode as $row){
                         ?>
                         <option <?php if(!empty($_GET['country_code'])){ if($_GET['country_code']==$row->phonecode){ echo "selected"; } }else if($row->phonecode=='91'){ echo "selected"; } ?> value="<?php echo $row->phonecode; ?>"><?php echo $row->sortname.' +'.$row->phonecode; ?></option>
                         <?php
                         } }
                        ?>
                      </select>
                    </div> 
                 </td>
                 <td> 
                    <div class="">                
                       <input type="text" placeholder="Phone No." class="form-control" name="mobile" value="<?php if(!empty($_GET['mobile'])) echo $_GET['mobile']; ?>">
                    </div> 
                 </td>
                 <td>
                    <div class="">              
                       <select name="status" class="form-control">                  
                            <option value="">--All <?php echo $userRoleName; ?>--</option> 
                            <option value="1" <?php if(!empty($_GET['status']) && $_GET['status']=='1') echo 'selected'; ?>>Active <?php echo $userRoleName; ?></option> 
                            <option value="2" <?php if(!empty($_GET['status']) && $_GET['status']=='2') echo 'selected'; ?>>Deactive <?php echo $userRoleName; ?></option> 
                       </select>
                    </div>     
                 </td>
                 
                 <td> 
                    <button class="btn btn-primary tooltips" rel="tooltip" data-placement="top" data-original-title="Search <?php echo $userRoleName; ?>" type="submit"><i class="icon icon-search"></i></button>
                    <a class="btn btn-danger tooltips" rel="tooltip" data-placement="top" data-original-title="Reset your search" type="submit" href="<?php echo base_url('backend/user/index/'.$user_role); ?>"> <i class="icon icon-refresh"></i></a>
                 </td>
               </tr> 
              </tbody>
            </table>
         </div>
      </form>
   </header>   
   <div class="adv-table" id="tab1">
      <table id="datatable_example" class="table-bordered responsive table table-striped table-hover">
         <thead class="thead_color">
            <tr>
               <th class="jv no_sort" width="8%">
                  <div class="col-md-12 no-padding-left">
                     <span class="checkboxli term-check">
                     <input type="checkbox" id="checkAll" class="" >
                     <label class="" for="checkAll"></label>
                     </span>
                     <select class="form-control commonstatus order-select-status" >
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="2">Deactive</option>
                        <option value="3">Delete</option>                     
                     </select>
                  </div>
               </th>
               <th><?php if($user_role==1){ echo "Seller"; }else if($user_role==2){ echo "Customer"; }else{ echo "User"; } ?> Name</th>
               <?php if($user_role==1) echo "<th>Name Of Business</th>"; ?>
               <th>Email Address</th>
               <th>Phone No.</th>
               <th>Country</th>
               <th>City</th>
               <th>Status</th>
               <th>Actions</th>
            </tr>
         </thead>
         <tbody>
            <?php
               if(!empty($users)):
               $i=0; 
               foreach($users as $row){ 
                $i++;
            ?>
            <tr>
               <td>
                  <span class="checkboxli term-check">
                  <input type="checkbox" id="checkall<?php echo $i ?>" name="checkstatus[]" value="<?php echo $row->user_id; ?>">  &nbsp;&nbsp; <?php echo $offset+$i.".";?>
                  <label class="" for="checkall<?php echo $i ?>">
                  </label>
                  </span>
               </td>
               <td>
                <?php 
                if($user_role==1){ 
                  $verification = getRow('seller_signature_and_licence',array('seller_id'=>$row->user_id),array('verification_status'));
                  if(empty($verification)){ ?>
                  <a href="<?php echo base_url().'backend/user/view/'.$row->user_role.'/'.$row->user_id; ?>" class="tooltips" rel="tooltip" data-placement="top"  title="Seller didn't entered the primary details yet. You can verify the account when the seller completed the remaining steps"> 
                    <?php echo ucwords($row->user_name); ?>
                  </a> 
                 <?php 
                  }else{ 
                  if($verification->verification_status==1){ ?>
                  <a href="<?php echo base_url().'backend/user/view/'.$row->user_role.'/'.$row->user_id; ?>" class="verified_seller tooltips" rel="tooltip" data-placement="top"  title="This is a verified seller, If you want to unverified it. Go to view details page and click on verified button">
                    <img width="30" height="30" src="https://www.autodealer.co.za/images/verified-seller.png"> 
                    <?php echo ucwords($row->user_name); ?>
                  </a>
                 <?php }else{ ?>
                  <a href="<?php echo base_url().'backend/user/view/'.$row->user_role.'/'.$row->user_id; ?>" class="tooltips" rel="tooltip" data-placement="top"  title="This is a Unverified seller, If you want to verify it. Go to view details page and click on unverified button"> 
                    <?php echo ucwords($row->user_name); ?>
                  </a> 
                <?php 
                  } } }else{ 
                ?>
                  <a href="<?php echo base_url().'backend/user/view/'.$row->user_role.'/'.$row->user_id; ?>" class=""> 
                    <?php echo ucwords($row->user_name); ?>
                  </a>
                <?php } ?>
               </td>
               <?php 
                if($user_role==1){ 
                  $businessName = ($row->business_name) ? $row->business_name : "-"; 
                  echo "<td>".$businessName."</td>"; 
                } 
               ?>
               <td><?php echo $row->email; ?></td>
               <td><?php if(!empty($row->mobile) && $row->confirmation_code=='verified'){ if($row->country_code){ echo '+'.$row->country_code; } echo ' '.$row->mobile; }else{ echo "-"; }  ?></td>
               <td>
                <?php 
                   $getCountryData = getData('countries', array('id',$row->country));
                   if(!empty($getCountryData)){
                      echo $getCountryData->name; 
                   }else{
                      echo "-";
                   } 
                ?>
               </td>
               <td>
                <?php 
                   $getCityData = getData('cities', array('id',$row->city));
                   if(!empty($getCityData)){
                      echo $getCityData->name; 
                   }else{
                      echo "-";
                   } 
                ?>
               </td>

               <td>
                <a href="javascript:void(0);" onclick="return confirmBox('<?php if($row->status==2) echo $activate; else if($row->status==1) echo $deactivate; ?>','<?php echo base_url().'backend/user/change_status/users/user_id/'.$row->user_id.'/'; if($row->status==2) echo '1'; else echo '2'; ?>')" class="btn btn-<?php if($row->status==2) echo 'danger'; else echo 'success';  ?> btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Click to <?php if($row->status==2) echo 'Active'; else echo 'Deactive';  ?>"><?php if($row->status==2) echo 'Deactive'; else echo 'Active';  ?>
                  </a> 
               </td>
               <td>

                  <a target="_blank" href="<?php echo base_url().'backend/user/proxy_login/'.$row->user_role.'/'.$row->user_id; ?>" class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top"  title="Login to <?php if(!empty($row->user_name)){ echo ucfirst($row->user_name); } ?> Account" target="new" html/data-html="true"><i class="icon-lock"></i></a>  

                  <a href="javascript:void(0)" data-id="<?php echo $row->user_id; ?>" class="btn btn-warning btn-xs tooltips change_password" rel="tooltip" data-placement="top"  title="Change password of <?php if(!empty($row->user_name)){ echo ucfirst($row->user_name)."'s"; } ?> Account" html/data-html="true"><i class="fa fa-key"></i></a>

                  <a href="<?php echo base_url().'backend/user/view/'.$row->user_role.'/'.$row->user_id; ?>" class="btn btn-info btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="View the details of <?php echo ucwords($row->user_name); ?>"><i class="fa fa-eye"></i>
                  </a>   

                  <a onclick="return confirmBox('Do you want to delete it ?','<?php echo base_url().'backend/user/delete/'.$row->user_id.'/'.$user_role; ?>')" class="btn btn-danger btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Delete  <?php echo ucwords($row->user_name); ?>"><i class="icon-trash "></i>
                  </a>
               </td>
            </tr>
            <?php } ?>
            <?php else: ?>
            <tr>
               <th colspan="9">
                  <center>No users found.</center>
               </th>
            </tr>
            <?php endif; ?>
         </tbody>
      </table>
      <div class="row-fluid  control-group mt15">
         <div class="span12 pull-right">
            <?php if(!empty($pagination))  echo $pagination;?>
         </div>
      </div>
   </div>
   <!-- End .content -->
</div>


<div class="modal fade" id="myModal" role="dialog">
   <div class="modal-dialog modal-sm">
      <form  method="post" name="myform" action ="<?php echo base_url('backend/user/changepassword') ?>" data-bvalidator-validate>
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
               <h4 class="modal-title text-center">Change Password</h4>
            </div>
            <div class="modal-body">
               <div class="row">
                  <label class="col-md-3 col-md-offset-1 control-label text-right"><strong>Password<span class="error">*</span></strong></label>
                  <div class="col-md-6">
                     <input type="password" name="password" value="" tabindex="1" placeholder="Password" class="form-control cp" data-bvalidator="minlen[6],required" data-bvalidator-msg="Please enter a Min 6 characters password">
                     <input type="hidden" name="userID" id="passwordID" value="">
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-primary" rel="tooltip" data-placement="top" data-original-title="Update Password" type="submit"><i class="icon-repeat"></i> Update</button>
               <button type="button" data-dismiss="modal" class="btn btn-danger btn-md tooltips"><i class="icon-remove"></i> Close</button>
            </div>
         </div>
      </form>
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

                var tb_name = "<?php echo base64_encode('users'); ?>"; 
                var col_name = "<?php echo base64_encode('user_id'); ?>";     

                $.post('<?php echo base_url() ?>'+'backend/pages/change_all_status', {'table_name': tb_name, 'col_name': col_name, 'status': new_status, 'row_id': row_id}, function(data) {            
                   if(data.status==true){  
                      $(location).attr('href', '<?php echo base_url('backend/user/index/'.$user_role); ?>');
                   }else{       
                      window.location.reload(true);
                      return false;
                   }
                });

            });    
         }else{
            errorMsg('Please check the checkbox');
            return false;
         } 

      });

   });

   $(".change_password").click(function(){
      $("#error").css("display", "none");
      var id = $(this).attr('data-id');
      $("#passwordID").val(id);
      $('#myModal').modal('show');
      $(".cp").val("");
   });

</script>
<style>
.verified_seller{
  font-weight: 600;
  color: #189457;
}
</style>