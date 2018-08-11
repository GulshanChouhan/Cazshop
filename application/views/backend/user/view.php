<div class="bread_parent">
   <div class="col-md-6">
      <ul class="breadcrumb">

         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
         <li><a href="<?php echo base_url('backend/user/index/'.$user_role); ?>"><?php if($user_role==1) echo "List Of Sellers"; else if($user_role==2) echo "List Of Customers"; ?></a></li>
         <li><b><?php if($user_role==1) echo "View Seller Details"; else if($user_role==2) echo "View Customer Details"; ?></b></li>

      </ul>
   </div>
   <div class="col-md-6">
      
      <div class="pull-right">
         <?php if($user_role==1 && !empty($signAndLicenceInfo)){ ?>
         <div class="btn-group tooltips" style="">
            <a href="javascript:void(0)" onclick="return confirmBox('<?php if($signAndLicenceInfo->verification_status==2) echo "Do you want to verify this seller account ?"; else if($signAndLicenceInfo->verification_status==1) echo "Do you want to unverify this seller account ?"; ?>','<?php echo base_url().'backend/user/verify_account/'.$user_role.'/'.$user_id; ?>')" class="btn btn-<?php if($signAndLicenceInfo->verification_status==2) echo "danger"; else echo "success" ?> tooltips"  type="button"  rel="tooltip" data-placement="top" data-original-title="Click to <?php if($signAndLicenceInfo->verification_status==2) echo 'verify'; else echo "unverify" ?> <?php  echo ucfirst($BasicInfo->user_name)."'s"; ?> Account "><i class="fa fa-user" aria-hidden="true"></i> <?php if($signAndLicenceInfo->verification_status==2) echo 'Unverified'; else echo "Verified" ?></a>
         </div>
         <?php } ?>

         <div class="btn-group tooltips" style="">
            <a href="<?php echo base_url().'backend/user/proxy_login/'.$user_role.'/'.$user_id; ?>" class="btn btn-primary tooltips"  target="_new"  type="button"  rel="tooltip" data-placement="top" data-original-title="Login to <?php  echo ucfirst($BasicInfo->user_name)."'s"; ?> Account "><i class="fa fa-sign-in" aria-hidden="true"></i> Login To <?php  echo ucwords($BasicInfo->user_name)."'s"; ?> Profile</a>
         </div>
      </div>

   </div>
   <div class="clearfix"></div>
</div>


<section class="panel">
   <div class="panel-body">
      <div class="table-responsive">
         <div class="panel-heading colum">
            <i class="icon-user"></i> Profile Information
         </div>
         <!-- <table  width="100%" class="table table-striped table-hover">
            <tr> -->
               <br>
               <div class="col-md-4 ">
               <div class="info-view">
                  <h5 class="heading"><span><i class="fa fa-info-circle" aria-hidden="true"></i> </span><b>Basic Information </b></h5>
                  <table class="table">
                     <tr>
                        <th>ID</th>
                        <td> <font class="colon">: &nbsp;</font><?php if(!empty($BasicInfo->user_id)){ echo '# '.$BasicInfo->user_id; } ?></td>
                     </tr>
                     <tr>
                        <th>Full Name</th>
                        <td> <font class="colon">: &nbsp;</font><?php if(!empty($BasicInfo->user_name)){ echo ucfirst($BasicInfo->user_name); } ?></td>
                     </tr>
                     <tr>
                        <th>Email</th>
                        <td> <font class="colon">: &nbsp;</font><a href="mailto:<?php echo $BasicInfo->email; ?>"><?php if(!empty($BasicInfo->email)){ echo $BasicInfo->email; } ?></a></td>
                     </tr>
                     <tr>
                        <th>Phone No.</th>
                        <td> <font class="colon">: &nbsp;</font><?php if(!empty($BasicInfo->country_code)){ echo $BasicInfo->country_code.' '; } if(!empty($BasicInfo->mobile)){ echo $BasicInfo->mobile; } ?></td>
                     </tr>

                     <?php
                        if($user_role==1){
                         $activate = "Do you want to activate this Seller  ?";
                         $deactivate = "Do you want to deactivate this Seller ?";
                        }else if($user_role==2){
                         $activate = "Do you want to activate this Customer ?";
                         $deactivate = "Do you want to deactivate this Customer ?";
                        }
                     ?>

                     <tr>
                        <th>Status</th>
                        <td class="btn00 btn-xs00 cursor-text"> <font class="colon">: &nbsp;</font>   

                           <a href="javascript:void(0);" onclick="return confirmBox('<?php if($BasicInfo->status==2) echo $activate; else if($BasicInfo->status==1) echo $deactivate; ?>','<?php echo base_url().'backend/user/change_status/users/user_id/'.$BasicInfo->user_id.'/'; if($BasicInfo->status==2) echo '1'; else echo '2'; ?>')" class="btn btn-<?php if($BasicInfo->status==2) echo 'danger'; else echo 'success';  ?> btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Click to <?php if($BasicInfo->status==2) echo 'Active'; else echo 'Deactive';  ?>"><?php if($BasicInfo->status==2) echo 'Deactive'; else echo 'Active';  ?>
                           </a> 

                        </td>
                     </tr>
                  </table>
               </div>
               </div>
               <div class="col-md-4 ">
               <div class="info-view">
                  <h5 class="heading"><span><i class="fa fa-map-marker" aria-hidden="true"></i> </span><b>Address </b></h5>
                  <table class="table">

                     <tr>
                        <th>Address</th>
                        <td> <font class="colon">: &nbsp;</font><?php if(!empty($BasicInfo->address)){ echo $BasicInfo->address; }else{ echo "-"; } ?></td>
                     </tr>

                     <tr>
                        <th>City</th>
                        <td> <font class="colon">: &nbsp;</font>
                             <?php 
                                 $getCityData = getData('cities', array('id',$BasicInfo->city));
                                 if(!empty($getCityData)){
                                    echo $getCityData->name; 
                                 }else{
                                    echo "-";
                                 } 
                             ?>
                        </td>
                     </tr>

                     <tr>
                        <th>Province</th>
                        <td> <font class="colon">: &nbsp;</font>
                             <?php 
                                 $getProvinceData = getData('states', array('id',$BasicInfo->province));
                                 if(!empty($getProvinceData)){
                                    echo $getProvinceData->name; 
                                 }else{
                                    echo "-";
                                 } 
                             ?>
                        </td>
                     </tr>

                     <tr>
                        <th>Country</th>
                        <td> <font class="colon">: &nbsp;</font>
                             <?php 
                                 $getCountryData = getData('countries', array('id',$BasicInfo->country));
                                 if(!empty($getCountryData)){
                                    echo $getCountryData->name; 
                                 }else{
                                    echo "-";
                                 } 
                             ?>
                        </td>
                     </tr>

                     <tr>
                        <th>Postal Code</th>
                        <td> <font class="colon">: &nbsp;</font><?php if(!empty($BasicInfo->zip)){ echo $BasicInfo->zip; }else{ echo "-"; } ?></td>
                     </tr>
                     
                  </table>
               </div>
               </div>
               <div class="col-md-4 ">
               <div class="info-view">
                  <h5 class="heading"><span><i class="fa fa-unlock" aria-hidden="true"></i> </span><b>Account Access </b></h5>
                  <table class="table">
                     <?php  if(!empty($BasicInfo->created)){ ?>
                     <tr>
                        <th>
                           Account Created
                        </th>
                        <td> <font class="colon">: &nbsp;</font><i class="fa fa-calendar"></i>
                           <?php echo date('d M Y,H:i ',strtotime($BasicInfo->created)); ?><br>
                        </td>
                     </tr>
                     <?php } ?>
                     <?php  if(!empty($BasicInfo->modified)){ ?>
                     <tr>
                        <th> 
                           Account Updated
                        </th>
                        <td> <font class="colon">: &nbsp;</font><i class="fa fa-calendar"></i>
                           <?php echo date('d M Y,H:i ',strtotime($BasicInfo->modified)); ?><br>
                        </td>
                     </tr>
                     <?php } ?>
                     <?php  if(!empty($BasicInfo->last_login)){ ?>
                     <tr>
                        <th> 
                           Last Login
                        </th>
                        <td> <font class="colon">: &nbsp;</font><i class="fa fa-calendar"></i>
                           <?php echo date('d M Y,H:i ',strtotime($BasicInfo->last_login)); ?><br>
                        </td>
                     </tr>
                     <?php } ?>
                     <?php  if(!empty($BasicInfo->last_ip)){ ?>
                     <tr>
                        <th> 
                           Last Login IP :
                        </th>
                        <td> <font class="colon">: &nbsp;</font>
                           <?php echo $BasicInfo->last_ip; ?><br>
                        </td>
                     </tr>
                     <?php } ?>
                  </table>
               </div>
               </div><!-- 
            </tr>
         </table> -->
      </div>

      <div class="clearfix"></div>

      <?php if($user_role==1){ ?>
         <?php if(!empty($sellerBusinessInfo)){ ?>
         <div class="table-responsive">
            <div class="panel-heading colum">
               <i class="fa fa-university" aria-hidden="true"></i> Store Information
            </div>
            <!-- <table  width="100%" class="table table-striped table-hover">
               <tr> -->
                  <br>
                  <div class="col-md-6">
                  <div class="info-view">
                     <h5 class="heading"><span><i class="fa fa-info-circle" aria-hidden="true"></i> </span><b>Store Information</b></h5>
                     <table class="table">
                        <tr>
                           <th>Full Name</th>
                           <td> <font class="colon">: &nbsp;</font><?php if(!empty($sellerBusinessInfo->store_name)){ echo $sellerBusinessInfo->store_name; }else{ echo "-"; } ?></td>
                        </tr>
                        <tr>
                           <th>Categories</th>
                           <td> <font class="colon">: &nbsp;</font>
                                <?php
                                    $getCategory = array();
                                    if(!empty($sellerBusinessInfo->category)){ 
                                       $category = json_decode($sellerBusinessInfo->category); 
                                       if(!empty($category)){
                                          foreach ($category as $row) {
                                             $getCategoryData = getData('category', array('category_id',$row));
                                             if(isset($getCategoryData) && !empty($getCategoryData)){   
                                                $getCategory[]   = $getCategoryData->category_name;
                                             }
                                          }
                                          if(!empty($getCategory)){
                                             echo implode("<b>,</b> ", $getCategory);
                                          }else{
                                             echo "-";
                                          }
                                       }else{ 
                                          echo "-"; 
                                       }
                                    }else{ 
                                       echo "-"; 
                                    } 
                                ?>
                           </td>
                        </tr>
                        <tr>
                           <th>Owner Name</th>
                           <td> <font class="colon">: &nbsp;</font><?php if(!empty($sellerBusinessInfo->owner_name)){ echo ucfirst($sellerBusinessInfo->owner_name); }else{ echo "-"; } ?></td>
                        </tr>
                        <tr>
                           <th>Email Address</th>
                           <td> <font class="colon">: &nbsp;</font><?php if(!empty($sellerBusinessInfo->contact_email)){ echo $sellerBusinessInfo->contact_email; }else{ echo "-"; } ?></td>
                        </tr>
                        <tr>
                           <th>Mobile No.</th>
                           <td> <font class="colon">: &nbsp;</font><?php if(!empty($sellerBusinessInfo->mobile)){ echo $sellerBusinessInfo->country_code.' '.$sellerBusinessInfo->mobile; }else{ echo "-"; } ?></td>
                        </tr>
                        <tr>
                           <th>Alternate No</th>
                           <td> <font class="colon">: &nbsp;</font><?php if(!empty($sellerBusinessInfo->alternate_no)){ echo $sellerBusinessInfo->alternate_no; }else{ echo "-"; } ?></td>
                        </tr>
                     </table>
                  </div>
                  </div>
                  <div class="col-md-6">
                  <div class="info-view">
                     <h5 class="heading"><span><i class="fa fa-map-marker" aria-hidden="true"></i> </span><b>Store Address </b></h5>
                     <table class="table">
                        <tr>
                           <th>Address</th>
                           <td> <font class="colon">: &nbsp;</font><?php if(!empty($sellerBusinessInfo->address)){ echo $sellerBusinessInfo->address; }else{ echo "-"; } ?></td>
                        </tr>

                        <tr>
                           <th>City</th>
                           <td> <font class="colon">: &nbsp;</font>
                                <?php 
                                    $getCityData = getData('cities', array('id',$sellerBusinessInfo->city));
                                    if(!empty($getCityData)){
                                       echo $getCityData->name; 
                                    }else{
                                       echo "-";
                                    } 
                                ?>
                           </td>
                        </tr>

                        <tr>
                           <th>Province</th>
                           <td> <font class="colon">: &nbsp;</font>
                                <?php 
                                    $getProvinceData = getData('states', array('id',$sellerBusinessInfo->state));
                                    if(!empty($getProvinceData)){
                                       echo $getProvinceData->name; 
                                    }else{
                                       echo "-";
                                    } 
                                ?>
                           </td>
                        </tr>

                        <tr>
                           <th>Country</th>
                           <td> <font class="colon">: &nbsp;</font>
                                <?php 
                                    $getCountryData = getData('countries', array('id',$sellerBusinessInfo->country));
                                    if(!empty($getCountryData)){
                                       echo $getCountryData->name; 
                                    }else{
                                       echo "-";
                                    } 
                                ?>
                           </td>
                        </tr>

                        <tr>
                           <th>Postal Code</th>
                           <td> <font class="colon">: &nbsp;</font><?php if(!empty($sellerBusinessInfo->zip)){ echo $sellerBusinessInfo->zip; }else{ echo "-"; } ?></td>
                        </tr>

                     </table>
                  </div>
                  </div><!-- 
               </tr>
            </table> -->
         </div>
         <?php } ?>
         <div class="clearfix"></div>
         <?php if(!empty($sellerInterviewInfo)){ //p($sellerInterviewInfo); die; ?>
         <div class="table-responsive">
            <div class="panel-heading colum">
               <i class="fa fa-truck" aria-hidden="true"></i> Seller Interview & Shipment Option
            </div>
            <!-- <table  width="100%" class="table table-striped table-hover">
               <tr> -->
                  <br>
                  <div class="col-md-6">
                  <div class="info-view">
                     <h5 class="heading"><span><i class="fa fa-info-circle" aria-hidden="true"></i> </span><b>Interview Information</b></h5>
                     <table class="table">
                        <tr>
                           <th>Categories you wish to sell</th>
                           <td> <font class="colon">: &nbsp;</font>
                           <?php
                              $getcategoryInter = array();
                              if(!empty($sellerInterviewInfo->categories)){ 
                                 $categoryInter = json_decode($sellerInterviewInfo->categories);
                                 if(!empty($categoryInter)){
                                    foreach ($categoryInter as $row) {
                                       $getcategoryInterData = getData('category', array('category_id',$row));
                                       if(!empty($getcategoryInterData)){
                                          $getcategoryInter[] = $getcategoryInterData->category_name;
                                       }
                                    }
                                    if(!empty($getcategoryInter)){
                                       echo implode("<b>,</b> ", $getcategoryInter);
                                    }else{
                                       echo "-";
                                    }
                                 }else{ 
                                    echo "-"; 
                                 } 
                              }else{ 
                                 echo "-"; 
                              } 
                           ?>
                           </td>
                        </tr>
                        <tr>
                           <th>Where do you get products from?</th>
                           <td> <font class="colon">: &nbsp;</font>
                           <?php
                              $getProductFrom = array();
                              if(!empty($sellerInterviewInfo->get_product_from)){ 
                                 $get_product_from = json_decode($sellerInterviewInfo->get_product_from);
                                 if(!empty($get_product_from)){
                                    foreach ($get_product_from as $row) {
                                       $getProductFrom[] = getProductFrom($row);
                                    }
                                    if(!empty($getProductFrom)){
                                       echo implode("<b>,</b> ", $getProductFrom);
                                    }else{
                                       echo "-";
                                    }
                                 }else{ 
                                    echo "-"; 
                                 } 
                              }else{ 
                                 echo "-"; 
                              } 
                           ?>
                           </td>
                        </tr>
                        <tr>
                           <th>What is your annual turnover ?</th>
                           <td> <font class="colon">: &nbsp;</font><?php if(!empty($sellerInterviewInfo->annual_turnover)){ echo $sellerInterviewInfo->annual_turnover; }else{ echo "-"; } ?></td>
                        </tr>
                        <tr>
                           <th>How many products do you sell ?</th>
                           <td> <font class="colon">: &nbsp;</font><?php if(!empty($sellerInterviewInfo->how_much_sell)){ echo $sellerInterviewInfo->how_much_sell; }else{ echo "-"; } ?></td>
                        </tr>
                        <tr>
                           <th>Do you sell in other websites ?</th>
                           <td> <font class="colon">: &nbsp;</font><?php if(!empty($sellerInterviewInfo->sell_in_otherwebsite)){ echo $sellerInterviewInfo->sell_in_otherwebsite; }else{ echo "-"; } ?></td>
                        </tr>
                     </table>
                  </div>
                  </div>
                  <?php if(!empty($sellerBusinessInfo)){ ?>
                  <div class="col-md-6">
                  <div class="info-view">
                     <h5 class="heading"><span><i class="fa fa-map-marker" aria-hidden="true"></i> </span><b>Shipment Option & Bitcoin Address</b></h5>
                     <table class="table">
                        <tr>
                           <th>Shipment Option</th>
                           <td> <font class="colon">: &nbsp;</font><?php if($sellerBusinessInfo->shipment_option==1){ echo "Local Shipping"; }else if($sellerBusinessInfo->shipment_option==2){ echo "International Shipping"; } ?></td>
                        </tr>
                        <tr>
                           <th>Bitcoin Address</th>
                           <td> <font class="colon">: &nbsp;</font><?php if(!empty($sellerBusinessInfo->bitcoin_address)){ echo $sellerBusinessInfo->bitcoin_address; }else{ echo "-"; } ?></td>
                        </tr>
                        <tr>
                           <th>Ethereum Address</th>
                           <td> <font class="colon">: &nbsp;</font><?php if(!empty($sellerBusinessInfo->ethereum_address)){ echo $sellerBusinessInfo->ethereum_address; }else{ echo "-"; } ?></td>
                        </tr>
                     </table>
                  </div>
                  </div>
                  <?php } ?>
                  <!-- 
               </tr>
            </table> -->
         </div>
         <?php } ?>
         <div class="clearfix"></div>
         <?php if(!empty($signAndLicenceInfo)){ //p($sellerInterviewInfo); die; ?>
         <div class="table-responsive">
            <div class="panel-heading colum">
               <i class="fa fa-link" aria-hidden="true"></i> Signature And Licence
            </div>
            <!-- <table  width="100%" class="table table-striped table-hover">
               <tr> -->
                  <br>
                  <div class="col-md-12">
                  <div class="info-view">
                     <h5 class="heading"><span><i class="fa fa-info-circle" aria-hidden="true"></i> </span><b>Signature And Licence Information</b></h5>
                     <table class="table">
                        <tr>
                           <th>Proof of Name and D.O.B</th>
                           <td> <font class="colon">: &nbsp;</font><?php if(!empty($signAndLicenceInfo->proof_of_name)){ echo proof_of_name_and_dob($signAndLicenceInfo->proof_of_name); }else{ echo "-"; } ?>
                           </td>
                        </tr>
                        <tr>
                           <th>Attachment (Proof of Name and D.O.B) Link</th>
                           <td> <font class="colon">: &nbsp;</font>
                           <?php if(!empty($signAndLicenceInfo) && !empty($signAndLicenceInfo->proof_of_name_attachment) && file_exists("./assets/uploads/seller/signature_or_licence_copy/proof_of_name_and_DOB/".$signAndLicenceInfo->proof_of_name_attachment)){ 
                           ?>
                              <a target="_blank" href="<?php echo base_url().'assets/uploads/seller/signature_or_licence_copy/proof_of_name_and_DOB/'.$signAndLicenceInfo->proof_of_name_attachment; ?>">Preview/Download the Attachment (Proof of Name and D.O.B)</a>
                           <?php } ?>
                           </td>
                        </tr>
                        <tr>
                           <th>Proof of Address (issued within the last three months)</th>
                           <td> <font class="colon">: &nbsp;</font><?php if(!empty($signAndLicenceInfo->proof_of_address)){ echo proof_of_address($signAndLicenceInfo->proof_of_address); }else{ echo "-"; } ?>
                           </td>
                        </tr>
                        <tr>
                           <th>Attachment (Proof of Address (issued within the last three months)) Link</th>
                           <td> <font class="colon">: &nbsp;</font>
                              <?php if(!empty($signAndLicenceInfo) && !empty($signAndLicenceInfo->proof_of_address_attachment) && file_exists("./assets/uploads/seller/signature_or_licence_copy/proof_of_address/".$signAndLicenceInfo->proof_of_address_attachment)){ 
                              ?>
                              <a target="_blank" href="<?php echo base_url().'assets/uploads/seller/signature_or_licence_copy/proof_of_address/'.$signAndLicenceInfo->proof_of_address_attachment; ?>">Preview/Download the Attachment (Proof of Address (issued within the last three months))</a>
                              <?php } ?>
                           </td>
                        </tr>
                     </table>
                  </div>
                  </div>
                  <!-- 
               </tr>
            </table> -->
         </div>
         <?php } ?>
         <div class="clearfix"></div>
      <?php } ?>
   </div>
   <div class="clearfix"></div>
</section>
