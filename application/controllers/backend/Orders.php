<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Orders extends CI_Controller
{
  public function __construct(){
      parent::__construct();
      $this->load->model("seller_model");
  }
  private function _check_login(){
    if(superadmin_logged_in()===FALSE)
      redirect('behindthescreen');
  }
  public function index($status='', $offset=0){   
    $this->_check_login(); //check login authentication
    if(!empty($status))    
      $data['title']= (orderStatusName($status)) ? orderStatusName($status)." Orders" : "Orders";    
    else
      $data['title']= "All Orders";
    $statusArr = (!empty($status)) ? array($status) : "";
    $search=array();
    if(!empty($_GET))
    {
      if(!empty($_GET['title']))
      $search[]=' od.product_details like "%'.trim($_GET['title']).'%"';
      if(!empty($_GET['order_id']))
      $search[]=' o.order_id = "'.trim($_GET['order_id']).'"';
      if(!empty($_GET['user_name']))
      $search[]=' o.shipping_address like "%'.trim($_GET['user_name']).'%"';
      if(!empty($_GET['orderstatus']))
      $search[]=' od.order_status = "'.trim($_GET['orderstatus']).'"';
    }

    $data['orders'] = $this->common_model->get_orderInfo($offset, PER_PAGE, $search, $statusArr, '', 0); 
    $config=backend_pagination(); 
       
    if(!empty($status)){
      $config['base_url'] = base_url().'backend/orders/index/'.$status;
    }else{
      $config['base_url'] = base_url().'backend/orders/index/0';   
    }
 
    $config['total_rows'] = $this->common_model->get_orderInfo(0, 0, $search, $statusArr, '', 0);  
    $config['per_page'] = PER_PAGE;
    $config['uri_segment'] = 5;
    
    if(!empty($_SERVER['QUERY_STRING']))
      $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
    else
      $config['suffix'] ='';

    $config['first_url'] = $config['base_url'].$config['suffix'];
    if((int) $offset < 0){
      $this->session->set_flashdata('msg_warning','Something went wrong! Please try again');    
      redirect($config['base_url']);
    }else if($config['total_rows'] < $offset){
      $this->session->set_flashdata('msg_warning','Something went wrong! Please try again');    
      redirect($config['base_url']);
    }

    $this->pagination->initialize($config);
    $data['pagination']=$this->pagination->create_links();
    $data['template']='backend/orders/index';
    $data['offset']=$offset;
    $data['status']=$status;
    $this->load->view('templates/superadmin_template',$data);
  }

  public function order_details($order_detail_id=''){     
    $this->_check_login(); //check login authentication
    $data['title']='Order Details';
    $order_detail_id = base64_decode($order_detail_id);   
    $data['order_info'] = $order_info = $this->common_model->get_orderdetails($order_detail_id, 0, superadmin_id());
    /*p($data['order_info']);
    die;*/
    if(empty($order_info)) redirect($_SERVER['HTTP_REFERER']);
    $data['order_detail_id'] = $order_detail_id;
    $data['template']='backend/orders/order_details';
    $this->load->view('templates/superadmin_template',$data);
  }

  public function invoice($order_detail_id='', $status=''){
    //die;    
    $this->_check_login(); //check login authentication
    $data['title']='Customer Invoice';
    $order_detail_id = base64_decode($order_detail_id);
    $data['order_info'] = $order_info = $this->common_model->get_orderdetails($order_detail_id, 0, superadmin_id());
    if(empty($order_info)) redirect($_SERVER['HTTP_REFERER']);
    $data['order_detail_id'] = $order_detail_id;
    $data['status'] = $status;
    $this->load->view('order-invoices',$data);

  }


  public function packing_slip($order_detail_id='', $status=''){
    //die;    
    $this->_check_login(); //check login authentication
    $data['title']='Packing Slip';
    $order_detail_id = base64_decode($order_detail_id);
    $data['order_info'] = $order_info = $this->common_model->get_orderdetails($order_detail_id, 0, superadmin_id());
    if(empty($order_info)) redirect($_SERVER['HTTP_REFERER']);
    $data['order_detail_id'] = $order_detail_id;
    $data['status'] = $status;
    $this->load->view('print_packing_slip',$data);

  }

  /* Seller has changed the status to packed for shipping */
  public function packedForShipping_process($order_status='', $order_detail_id='', $tracking_id='', $tracking_url='', $tracking_description='')
  {

    $this->_check_login(); //check login authentication
    $this->_check_stepForm(); //check registration step authentication
    $seller_id = seller_id();
    $date = date('Y-m-d H:i:s A');

    if(isset($_POST)){
      $order_status = $_POST['order_status'];
      $order_detail_id = base64_decode($_POST['order_detail_id']);
      $tracking_id = $_POST['tracking_id'];
      $tracking_url = $_POST['tracking_url'];
      $tracking_description = $_POST['tracking_description'];
      $successStatusID = array();

      $status_array=array(1,2,3);
      $key=array_keys($status_array, $order_status);
      if(empty($key)){
        $data = json_encode(array('status'=>'failed', 'msg'=>'Something went wrong! Please try again'));
        echo $data; 
      }

      $data = array("order_status"=>$order_status);
      if($this->common_model->update('order_details', $data, array('order_detail_id'=>$order_detail_id))){

        foreach ($status_array as $key){
          $statusData=$this->common_model->get_row('order_status',array('order_detail_id'=>$order_detail_id, 'status'=>$key),array('order_status_id'));
          if(empty($statusData) && $key<=$order_status)
          {
            $orderStatusData = array(
              'user_role'         => 1,
              'user_id'           => $seller_id,
              'order_detail_id'   => $order_detail_id,
              'status'            => $key,
              'created'           => $date
            );

            if($key==$order_status){
              $orderStatusData['tracking_id']           = $tracking_id;
              $orderStatusData['tracking_url']          = $tracking_url;
              $orderStatusData['tracking_description']  = $tracking_description;
            }
            $successStatusID[] = $this->common_model->insert('order_status', $orderStatusData);
            $this->sendEmailForOrderStatus($orderStatusData);
          }
        }

        if(!empty($successStatusID)){
          $data = json_encode(array('status'=>'success', 'msg'=>'Order status has been changed successfully'));
          echo $data;
        }else{
          $data = json_encode(array('status'=>'failed', 'msg'=>'Sorry! Order status changing process has been failed. please try again'));
          echo $data;
        }
      }else{
        $data = json_encode(array('status'=>'failed', 'msg'=>'Sorry! Order status changing process has been failed. please try again'));
        echo $data; 
      }
    }else{
      $data = json_encode(array('status'=>'failed', 'msg'=>'Something went wrong! Please try again'));
      echo $data; 
    }

  }
  
  public function change_all_status($tablename='')
  {     
      $this->_check_login(); //check login authentication   
      $data['title']='Change Status';
      $tablename = base64_decode($_POST['table_name']);
      $col_name  = base64_decode($_POST['col_name']);
      $default_arr=array('status'=>FALSE); 
      $status='';            
      $count= count($_POST['row_id']);
      $rowfalse = 0;

      for ($i=0; $i < $count ; $i++){

          $statusData = $this->common_model->get_row('order_details',array('order_detail_id'=>$_POST['row_id'][$i]),array('order_status'));
          if(!empty($statusData)){
            if($statusData->order_status >=$_POST['order_status'] || $statusData->order_status<=4){
              $rowfalse++;
            }
          }

          if($rowfalse == 0){
            if($_POST['order_status']==2){
              $update_status= array('order_status'=>2);
            }elseif($_POST['order_status']==4){                     
                $update_status= array('order_status'=>4);
            }
            elseif($_POST['order_status']==5){                     
                $update_status= array('order_status'=>5);
            }
            $this->common_model->update($tablename,$update_status,array($col_name=>$_POST['row_id'][$i]));
            $default_arr=array('status'=>TRUE);
          }else{
            $default_arr=array('status'=>FALSE);
          }
      }
      header('Content-Type: application/json');
      echo json_encode($default_arr);        
  }

  /* Seller has changed the status to packed for shipping */
  public function admin_delivered($order_detail_id='', $status='')
  {
    $this->_check_login(); //check login authentication
    $date = date('Y-m-d H:i:s A');
    $order_detail_id = base64_decode($order_detail_id);

    if(isset($_POST)){

      $data = array("admin_delivered_confirmation"=>1);
      if($this->common_model->update('order_details', $data, array('order_detail_id'=>$order_detail_id))){

        $orderStatusData = array(
          'user_role'         => 0,
          'user_id'           => superadmin_id(),
          'order_detail_id'   => $order_detail_id,
          'status'            => 4,
          'created'           => $date
        );
        $successStatusID = $this->common_model->insert('order_status', $orderStatusData);

        if($successStatusID){

          //-------------For Send email AND SMS-----------
          $email_template = $this->common_model->get_row('email_templates', array('id'=>16));
          if(!empty($email_template)){
            
            $data['orders_details'] =  $this->common_model->get_result('order_details',array('order_detail_id'=>$order_detail_id));
            if(!empty($data['orders_details'])){
              $data['order_info'] =  $this->common_model->get_row('orders',array('o_id'=>$data['orders_details'][0]->order_table_id)); 
              if(!empty($data['order_info'])){

                $sellerInfo =  $this->common_model->get_row('users',array('user_id'=>$data['orders_details'][0]->seller_id),array('email','mobile','country_code'));
                //==-----------===Send Email==-----------
                if($email_template->template_email_enable==1){

                    $userRole  = 2; //for Customer
                    $to        = $sellerInfo->email;
                    $param     = array(
                        'site_name'           => SITE_NAME,
                        'user_role'           => "Seller",
                        'item_details'        => trim($this->load->view('templates/email/order_placed',$data,true))
                    );
                    $sendEmail = sendEmail($email_template, $to, $param, $userRole);
                }

                //==-----------===Send SMS==-----------===
                if($email_template->template_sms_enable==1){

                  $userRole  = 2; //for Customer
                  $to      = ($seller_info->country_code) ? '+'.$seller_info->country_code.''.$seller_info->mobile : $seller_info->mobile;
                  $param     = array(
                        'site_name'           => SITE_NAME,
                        'user_role'           => "Seller",
                        'item_details'        => trim($this->load->view('templates/email/order_placed',$data,true))
                    );
                  $sendSMS = sendSMS($email_template, $to, $param, $userRole);

                }
              }
            }
          }
          //-------------**For Send email AND SMS-----------

          $this->session->set_flashdata('msg_success', 'Order status has been changed successfully');    
          redirect($_SERVER['HTTP_REFERER']);
        }else{
          $this->session->set_flashdata('msg_error', 'Sorry! Order status changing process has been failed. Please try again'); 
          redirect($_SERVER['HTTP_REFERER']);
        }
      }else{
        $this->session->set_flashdata('msg_error','Sorry! Order status changing process has been failed. Please try again'); 
        redirect($_SERVER['HTTP_REFERER']); 
      }
    }else{
      $this->session->set_flashdata('msg_error','Something went wrong. please try again'); 
      redirect($_SERVER['HTTP_REFERER']); 
    }

  }

  public function changeStatus($order_status='', $order_detail_id=''){  
    $this->_check_login(); //check login authentication
    $date = date('Y-m-d H:i:s A');
    $orderStatusMsg = orderStatusMsg1($order_status);
    if(!empty($orderStatusMsg)){
      $ordersuccessMsg = $orderStatusMsg;
    }else{
      $ordersuccessMsg = "Order status has been changed successfully";
    }

    $orderRecord = $this->common_model->get_row('order_details',array('order_detail_id'=>$order_detail_id),array('order_detail_id','seller_id'));
    if(!empty($orderRecord)){
      if($order_status >4){
        $data = array("order_status"=>$order_status);
        if($this->common_model->update('order_details', $data, array('order_detail_id'=>$order_detail_id))){

          $orderStatusData = array(
            'user_role'         => 1,
            'user_id'           => $orderRecord->seller_id,
            'order_detail_id'   => $order_detail_id,
            'status'            => $order_status,
            'created'           => date('Y-m-d H:i:s A')
          );

          $successStatusID = $this->common_model->insert('order_status', $orderStatusData);
          if($successStatusID){
            $this->sendEmailForOrderStatus($orderStatusData);
            $this->session->set_flashdata('msg_success', $ordersuccessMsg); 
            redirect($_SERVER['HTTP_REFERER']);
          }else{
            $this->session->set_flashdata('msg_error', 'Sorry! Order status changing process has been failed. please try again'); 
            redirect($_SERVER['HTTP_REFERER']); 
          } 
        }else{
          $this->session->set_flashdata('msg_error', 'Sorry! Order status changing process has been failed. please try again'); 
          redirect($_SERVER['HTTP_REFERER']); 
        }
      }else{

        $status_array=array(1,2,3,4);
        $key=array_keys($status_array, $order_status);
        if(empty($key))
        {
          $this->session->set_flashdata('msg_warning', 'Something went wrong! Please try again');
          redirect($_SERVER["HTTP_REFERER"]);
        }

        $data = array("order_status"=>$order_status);
        if($this->common_model->update('order_details', $data, array('order_detail_id'=>$order_detail_id))){

          foreach ($status_array as $key){
            $statusData=$this->common_model->get_row('order_status',array('order_detail_id'=>$order_detail_id, 'status'=>$key),array('order_status_id'));
            if(empty($statusData) && $key<=$order_status)
            {
              $orderStatusData = array(
                'user_role'         => 1,
                'user_id'           => $orderRecord->seller_id,
                'order_detail_id'   => $order_detail_id,
                'status'            => $key,
                'created'           => $date
              );
              $successStatusID = $this->common_model->insert('order_status', $orderStatusData);
              $this->sendEmailForOrderStatus($orderStatusData);
            }
          }

          if($successStatusID){
            $this->session->set_flashdata('msg_success', $ordersuccessMsg); 
            redirect($_SERVER['HTTP_REFERER']);
          }else{
            $this->session->set_flashdata('msg_error', 'Sorry! Order status changing process has been failed. please try again'); 
            redirect($_SERVER['HTTP_REFERER']); 
          }
        }else{
          $this->session->set_flashdata('msg_error', 'Sorry! Order status changing process has been failed. please try again'); 
          redirect($_SERVER['HTTP_REFERER']); 
        }
      }
    }else{
      $this->session->set_flashdata('msg_error', 'Something went wrong! Please try again'); 
      redirect(base_url('backend/orders/index'));
    }
  }


  public function sendEmailForOrderStatus($orderStatusData=array()){
    if(!empty($orderStatusData)){

      //-------------For Send email AND SMS to customer and Admin-----------

      $data['orders_details'] = $orders_details = $this->common_model->get_result('order_details',array('order_detail_id'=>$orderStatusData['order_detail_id']));
      if(!empty($data['orders_details'])){

        $email_template = $this->common_model->get_row('email_templates', array('id'=>19));
        if(!empty($email_template)){

          $data['order_info'] =  $this->common_model->get_row('orders',array('o_id'=>$orders_details[0]->order_table_id)); 
          
          if(!empty($data['order_info'])){

            $orderStatusName    = orderStatusName($orderStatusData['status']);
            $shipping_addresess = json_decode($data['order_info']->shipping_address);

            //==-----------===Send Email==-----------
            if($email_template->template_email_enable==1){

                $userRole  = 2; //for Customer
                $to        = $shipping_addresess->email_id;
                $param     = array(
                  'site_name'           => SITE_NAME,
                  'user_role'           => "Customer",
                  'order_status'        => $orderStatusName,
                  'item_details'        => trim($this->load->view('templates/email/order_placed',$data,true))
                );
                $sendEmail = sendEmail($email_template, $to, $param, $userRole);


                $userRole  = 0; //for Admin
                $adminEMAIl= get_option_url('EMAIl');
                $to      = (!empty($adminEMAIl)) ? $adminEMAIl : SUPPORT_EMAIL;
                $param     = array(
                  'site_name'           => SITE_NAME,
                  'user_role'           => SITE_NAME." Administrator",
                  'order_status'        => $orderStatusName,
                  'item_details'        => trim($this->load->view('templates/email/order_placed',$data,true))
                );
                $sendEmailAdmin = sendEmail($email_template, $to, $param, $userRole);
            }

            //==-----------===Send SMS==-----------===
            if($email_template->template_sms_enable==1){

              $userRole  = 2; //for Customer
              $to      = ($shipping_addresess->country_code) ? '+'.$shipping_addresess->country_code.''.$shipping_addresess->phone_no : $shipping_addresess->phone_no;
              $param     = array(
                  'site_name'           => SITE_NAME,
                  'user_role'           => "Customer",
                  'order_status'        => $orderStatusName,
                  'item_details'        => trim($this->load->view('templates/email/order_placed',$data,true))
              );
              $sendSMS = sendSMS($email_template, $to, $param, $userRole);


              $userRole  = 0; //for Admin
              $to      = get_option_url('PHONE');
              $param     = array(
                  'site_name'           => SITE_NAME,
                  'user_role'           => SITE_NAME." Administrator",
                  'order_status'        => $orderStatusName,
                  'item_details'        => trim($this->load->view('templates/email/order_placed',$data,true))
              );
              $sendSMSAdmin = sendSMS($email_template, $to, $param, $userRole);
            }
            
          }
        }

      }
      
      //-------------**For Send email AND SMS to admin and customer-----------

    }
  }

}   