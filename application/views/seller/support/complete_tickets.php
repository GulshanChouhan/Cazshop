<div class="body-container clearfix">
   <div class="bread_parent">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('seller/dashboard'); ?>"><i class="icon-home"></i> Dashboard  </a></li>
         <li>Support</li>
         <li><b> Completed Tickets</b></li>
      </ul>
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
                              <div class="panel-title"><i class="icofont icofont-live-support"></i> Completed Tickets</div>
                           </div>
                           <div class="dashboard-right section-white support-page">
                              <div class="col-lg-12 col-md-12 no-padding">
                                 <?php echo msg_alert(); ?>
                                 <div class="assitance-block">
                                    <div class="assitance-info-line text-left col-md-6 col-sm-6 col-xs-6 pull-right">
                                       <h4> Need Assistance?</h4>
                                       <!-- <div class="link"><b><i class="fa fa-phone" aria-hidden="true"></i><?php if($phone=get_option_url('PHONE')){ ?><a href="tel:<?php echo $phone ?>"><?php echo $phone; ?></a><?php } ?></b></div> -->
                                       <div class="link"><i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto: <?php if($email=get_option_url('EMAIl')){ echo $email; } ?>" style="text-decoration: underline;"><b><?php if($email=get_option_url('EMAIl')){ echo $email; } ?></b></a>
                                       </div>
                                    </div>
                                    <div class="assitance-info text-center col-md-6 col-sm-6 col-xs-6 no-padding-left">
                                       <div class="assist-block pull-right00">
                                          <div class="assist-icon">
                                             <a href="javascript:void(0)" data-toggle="modal" data-target="#support_popup">
                                                <i class="fa fa-phone" aria-hidden="true"></i>
                                                <div><b>Support</b></div>
                                             </a>
                                          </div>
                                          <div class="assist-text"> Submit a support ticket and we will get back to you shortly.</div>
                                       </div>
                                       <div class="clearfix"></div>
                                    </div>
                                    <div class="clearfix"></div>
                                 </div>
                                 <?php if(!empty($support)){ ?>
                                 <div class="col-md-6 col-lg-6 col-sm-6 tickets-box tickets-box-left no-left-padding">
                                    <div class="tab-sub-warp-head">
                                       <i class="fa fa-ticket" aria-hidden="true"></i><span>&nbsp; Completed Tickets</span>
                                       <div class="clearfix"></div>
                                    </div>
                                    <div class="dashboard-tab-sub-warp">
                                       <div class="support-message-warp">
                                          <table class="table">
                                             <?php if(!empty($support)){
                                                foreach ($support as $row) {  ?>
                                             <tr class="">
                                                <td>
                                                   <div class="message-block <?php if($row->support_id==$message_id){ echo'info';}?>">
                                                      <div class="header-block">
                                                         <div class="ticket-title pull-left">
                                                            <i class="fa fa-ticket"></i>&nbsp;  Ticket ID :<b><a href="<?php echo base_url().'seller/support/complete_tickets/'.$row->support_id ?>">
                                                            #<?php echo $row->support_id; ?></a></b>
                                                         </div>
                                                         <div class="pull-right">
                                                            <a href="<?php echo base_url().'seller/support/complete_tickets/'.$row->support_id ?>" class="btn btn-xs btn-orange">View Ticket</a>
                                                         </div>
                                                         <div class="clearfix"></div>
                                                      </div>
                                                      <div class="messagebody">
                                                         <div class="pull-left">
                                                            <div class="subject-text">
                                                               <?php  if(!empty($row->reason)){
                                                                  $feedback_subject_status='';
                                                                  $feedback_subject_status=feedback_subject_status($row->reason); } ?>
                                                               <span class="message-headings">Subject :</span> <a href="<?php echo base_url().'seller/support/complete_tickets/'.$row->support_id ?>"><?php if(!empty($row->reason)){ echo $feedback_subject_status; } ?></a>
                                                            </div>
                                                            <div class="message-text">
                                                               <span class="message-headings">Message :</span> <a href="<?php echo base_url().'seller/support/complete_tickets/'.$row->support_id ?>">
                                                               <?php if(!empty($row->message)){ echo character_limiter($row->message,60); } ?></a>
                                                            </div>
                                                            <?php if(get_unread_msg($row->support_id,seller_id())){?>
                                                            <a href="<?php echo base_url().'seller/support/complete_tickets/'.$row->support_id ?>" style="color: red;">New Message Received </a>
                                                            <?php }?>
                                                         </div>
                                                         <div class="date-info">
                                                            <div class="status-text"></div>
                                                            <?php if(!empty($row->created)) { echo'<span class="status-headings"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;</span>'. date('d M Y,H:i ',strtotime($row->created));} ?>
                                                         </div>
                                                         <div class="clearfix"></div>
                                                      </div>
                                                   </div>
                                                </td>
                                             </tr>
                                             <?php } } else{
                                                ?>
                                             <tr>
                                                <td class="text-center">
                                                   <div style="font-size: 18px;">
                                                      <div>No Previous Tickets were Found</div>
                                                      <br>
                                                      <a href="<?php echo base_url('seller/support/support')?>" class="btn btn-primary">Support</a>
                                                   </div>
                                                </td>
                                             </tr>
                                             <?php
                                                }?>
                                          </table>
                                       </div>
                                    </div>
                                 </div>
                                 <?php } ?>
                                 <div class=" <?php if(!empty($support)){ ?>col-md-6 col-lg-6 col-sm-6 support-box no-right-padding <?php }else echo 'col-md-12 col-lg-12 col-sm-12 support-box support-box-right no-padding';   ?>">
                                    <div class="tab-sub-warp-head">
                                       <?php if(!empty($message_id)){ echo 'Ticket ID : <b>#'.$message_id.'</b>'; } ?>
                                    </div>
                                    <div class="dashboard-tab-sub-warp">
                                       <?php if(!empty($support_detail)){
                                          $feedback_subject_status = "";
                                          if(!empty($row->reason))
                                             $feedback_subject_status=feedback_subject_status($row->reason);
                                          ?>
                                       <div class="support-chats">
                                          <?php
                                             foreach ($support_detail as $row) { ?>
                                          <?php  if(!empty($row->reason)){
                                             $feedback_subject_status='';
                                             $feedback_subject_status=feedback_subject_status($row->reason); } ?>
                                          <div class="clearfix">
                                             <div class='<?php
                                                if($row->user_role==1){ echo " alert alert-info"; }else{ echo " alert alert-success"; } ?>'>
                                                <?php if(!empty($row->message)){ ?>
                                                <div class="chats-content">
                                                   <p class="">
                                                      <?php echo "<b> Subject : </b>".$feedback_subject_status.""; ?>
                                                   </p>
                                                   <p>
                                                      <?php echo "<b> Message : </b>".$row->message; ?>
                                                   </p>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="chat-time">
                                                   <i class="fa fa-calendar"></i>&nbsp;
                                                   <?php echo date('d M Y,H:i ',strtotime($row->created)); ?>
                                                </div>
                                                <?php } ?>
                                                <?php if($row->user_role==1){ ?>
                                                <div class="clearfix"></div>
                                                <?php } ?>
                                             </div>
                                          </div>
                                          <?php } ?>
                                       </div>
                                       <?php }else{ ?>
                                       <div class="noresult-block no-chatresult-block">
                                          <h4>No old completed tickets were found</h4>
                                          <a href="javascript:void(0)" data-toggle="modal" data-target="#support_popup" class="">Click To Contact customer support </a><br>
                                       </div>
                                       <?php } ?>
                                    </div>
                                 </div>
                              </div>
                              <div class="clearfix"></div>
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
<?php $feedback_subject=''; 
   $feedback_subject=feedback_subject_status(); ?>
<!-- Modal -->
<div class="modal fade" id="support_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content support-ticket-modal comman-modal">
         <div class="modal-header comman-header-modal">
            <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><img src="<?php echo SELLER_THEME_URL; ?>/img/Icon_Basic_Close.svg" width="18"></span>
            </button>
            <h4 class="modal-title text-center" id="myModalLabel">Submit a support ticket</h4>
         </div>
         <div class="modal-body comman-body-modal">
            <form role="form" action="<?php echo base_url('seller/support/support_account_popup'); ?>" method="post" id="form_valid1">
               <div class="form-body contact-support-form ">
                  <div class="col-md-5">
                     <?php  if(seller_logged_in()!=1){  ?> 
                     <div class="row">
                        <div class="col-md-12 col-sm-12">      
                           <label for="" class="label">First Name<span class="front_error">*</span></label>                        
                        </div>
                        <div class=" form-group col-md-12 col-sm-12">      
                           <input type="text" class="form-control text-capitalize" name="firstname" id="" placeholder="First Name" value="<?php if(seller_logged_in()==1){  if(!empty($user_info->first_name)){ echo ucfirst($user_info->first_name); } }else{ echo set_value('firstname'); }  ?>" data-bvalidator="required">
                           <?php echo form_error('firstname') ?>
                        </div>
                        <div class="col-md-12 col-sm-12">  
                           <label for="" class="label">Last Name<span class="front_error">*</span></label>                                
                        </div>
                        <div class=" form-group col-md-12 col-sm-12">
                           <input type="text" class="form-control text-capitalize" name="lastname" id="" placeholder="Last Name" value="<?php if(seller_logged_in()==1){  if(!empty($user_info->last_name)){ echo ucfirst($user_info->last_name); } }else{ echo set_value('lastname'); }  ?>" data-bvalidator="required">
                           <?php echo form_error('lastname') ?>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12 col-sm-12">    
                           <label for="" class="label">Email ID<span class="front_error">*</span></label>   
                        </div>
                        <div class="form-group col-md-12 col-sm-12">    
                           <input type="text" name="email" class="form-control" id="" value="<?php if(seller_logged_in()==1){  if(!empty($user_info->email)){ echo $user_info->email; } }else{ echo set_value('email'); }  ?>" placeholder="Email ID" data-bvalidator="required,email">
                           <?php echo form_error('email') ?>
                        </div>
                        <div class="col-md-12 col-sm-12">     
                           <label for="" class="label">Phone No.<span class="front_error">*</span></label>    
                        </div>
                        <div class="form-group col-md-12 col-sm-12">    
                           <input type="text"  name="mobile" class="form-control" id="" value="<?php if(!empty($user_info->mobile)){ echo $user_info->mobile;  }else{ echo set_value('mobile'); } ?>" placeholder="Phone No." data-bvalidator="maxlen[13],minlen[9],number,required"> 
                           <?php echo form_error('mobile') ?> 
                        </div>
                     </div>
                     <?php } ?> 
                  </div>
                  <div class="right-side <?php  if(seller_logged_in()!=1) echo 'col-md-7'; else echo 'col-md-12'; ?>">
                     <div class="">
                        <div class="col-md-12 col-sm-12">     
                           <label><b>Subject<span style="color: red;" class="front_error">*</span></b></label>
                        </div>
                        <div class="form-group col-md-12 col-sm-12">
                           <select name="reason" class="form-control" data-bvalidator="required">
                              <option value="">Select the Subject </option>
                              <?php if(!empty($feedback_subject)){ 
                                 foreach ($feedback_subject as $key => $value) { 
                                 /* if($reason) { ?>
                              <option <?php if($reason==$key){ echo "selected"; } ?> value="<?php echo $key ?>"><?php echo $value ?></option>
                              <?php } else { */ ?>
                              <option <?php if(!empty($_POST['reason']) && ($_POST['reason']==$key)){ echo "selected"; } ?> value="<?php echo $key ?>"><?php echo $value ?></option>
                              <?php //}   
                                 }
                                 }  ?>
                           </select>
                           <?php echo form_error('reason') ?>
                        </div>
                     </div>
                     <div class="">
                        <div class="col-md-12 col-sm-12">    
                           <label><b>Message<span style="color: red;" class="front_error">*</span></b></label>  
                        </div>
                        <div class="form-group col-md-12 col-sm-12">        
                           <textarea name="message" class="form-control tooltips" data-bvalidator="required" rel="tooltip" maxlength="500" data-placement="top right" rows="6" placeholder="Type your message here"><?php echo set_value('message'); ?></textarea>
                           <?php echo form_error('message') ?>
                        </div>
                     </div>
                     <div class="">
                        <div class="col-md-12 col-sm-12">    
                           <label for="" class="label"></label>  
                        </div>
                        <div class="col-md-12 col-sm-12 text-center">
                           <button type="submit" class="btn btn-lg btn-red contact-submit">Submit</button>
                        </div>
                        <div class="clearfix"></div>
                     </div>
                  </div>
               </div>
               <div class="clearfix"></div>
            </form>
         </div>
      </div>
   </div>
</div>
<script>
   $('#form_valid1').bValidator();
   $(".support-chats").animate({ scrollTop: $(document).height() }, "slow");
   $(document).ready( function () {
       $('#form_valid1').bValidator();
       maxLength = $("textarea#msg_reply").attr("maxlength");
       $("textarea#msg_reply").bind("keyup change", function(){checkMaxLength1(this.id,  maxLength); } )
   });
   
   function checkMaxLength1(textareaID, maxLength){
      currentLengthInTextarea = $("#"+textareaID).val().length;
      $(remainingLengthTempId1).text(parseInt(maxLength) - parseInt(currentLengthInTextarea));
   
      if (currentLengthInTextarea >= (maxLength)) { 
        $("textarea#msg_reply").val($("textarea#msg_reply").val().slice(0, maxLength));
        $(remainingLengthTempId1).text(0);
      }
   }
   
</script>