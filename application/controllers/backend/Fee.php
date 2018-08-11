<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Fee extends CI_Controller
{

  public function __construct(){
      parent::__construct();
      $this->load->model("seller_model");
  }

  private function _check_login(){
    if(superadmin_logged_in()===FALSE)
      redirect('behindthescreen');
  }

  public function index($offset=0){
    $this->_check_login(); //check login authentication
    $data['title']='Fee Preview';
    $search=array();

    if(!empty($_GET))
    {
      if(!empty($_GET['seller_id']))
      $search[]=' users.user_id="'.trim($_GET['seller_id']).'"';
    }

    $data['sellers'] = $this->common_model->getSellersFeeStructure($offset,PER_PAGE,$search);
    $config=backend_pagination();
    $config['base_url'] = base_url().'backend/fee/index/';
    $config['total_rows'] = $this->common_model->getSellersFeeStructure(0,0,$search);
    
    $config['per_page'] = PER_PAGE;
    $config['uri_segment'] = 4;
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
    $data['template']='backend/fee/index';
    $data['offset']=$offset;
    $this->load->view('templates/superadmin_template',$data);
  }

  public function transaction($seller_id='', $offset=0){    
    $this->_check_login(); //check login authentication
    $data['title']='Seller Transaction History';

    $get=array('seller_id'=>$seller_id);  
    $data['fee_preview'] = $this->common_model->getTransactionDetails($seller_id, $offset, PER_PAGE);
    $config=backend_pagination();
    $config['base_url'] = base_url().'backend/fee/transaction/'.$seller_id;
    $config['total_rows'] = $this->common_model->getTransactionDetails($seller_id, 0, 0);

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
    $data['template']='backend/fee/transaction';
    $data['offset']=$offset;
    $data['seller_id']=$seller_id;
    $this->load->view('templates/superadmin_template',$data);

  }
  

  public function getPaymentData($odi='', $user_id='')
  {
    $odi          = base64_decode($_POST['odi']);
    $user_id      = $_POST['user_id'];
    if(!empty($odi)){
      $getFeePreviewDetails = getFeePreviewDetails($user_id, 1, $odi);
      if(!empty($getFeePreviewDetails)){
        $product_details = json_decode($getFeePreviewDetails->product_details);
        echo json_encode(array('status'=>'success', 'data'=> $getFeePreviewDetails, 'pd'=>$product_details, 'msg'=>'No order information found'));
      }else{
        echo json_encode(array('status'=>'failed', 'data'=>array(), 'msg'=>'No order information found'));
      }
    }else{
      echo json_encode(array('status'=>'failed', 'data'=>array(), 'msg'=>'No order information found'));
    }
  }


  public function paymentconfirm($order_detail_id='', $user_id='')
  {

    $order_detail_id  = base64_decode($_POST['order_detail_id']);
    $seller_id        = $_POST['seller_id'];
    $pay_comment        = $_POST['pay_comment'];

    if(!empty($order_detail_id) && !empty($seller_id)){
      $getFeePreviewDetails = getFeePreviewDetails($seller_id, 1, $order_detail_id);
      if(!empty($getFeePreviewDetails)){

        $payData = array(
          'seller_id'         => $seller_id,
          'order_detail_id'   => $order_detail_id,
          'paid_amount'       => $getFeePreviewDetails->pay_to_seller,
          'comment'           => $pay_comment,
          'created'           => date('Y-m-d H:i:s A')
        );

        $payDataID = $this->common_model->insert('payout_history', $payData);
        if($payDataID){
          
          //-------------For Send email AND SMS-----------
          $email_template = $this->common_model->get_row('email_templates', array('id'=>20));
          if(!empty($email_template)){

            $data['orders_details'] = $orders_details = $this->common_model->get_result('order_details',array('order_detail_id'=>$payData['order_detail_id']));
            if(!empty($data['orders_details'])){

                $data['order_info'] =  $this->common_model->get_row('orders',array('o_id'=>$orders_details[0]->order_table_id)); 
                $seller_info = $this->common_model->get_row('users', array('user_id' => $payData['seller_id']));

                if(!empty($data['order_info']) && !empty($seller_info)){

                  //==-----------===Send Email==-----------
                  if($email_template->template_email_enable==1){

                      $userRole  = 1; //for Seller
                      $to        = $seller_info->email;
                      $param     = array(
                          'site_name'           => SITE_NAME,
                          'user_role'           => "Seller",
                          'seller_name'         => ucfirst($seller_info->user_name),
                          'item_amount'         => $getFeePreviewDetails->total_amount,
                          'admin_fee'           => $getFeePreviewDetails->fee_preview,
                          'seller_paid_amount'  => $getFeePreviewDetails->pay_to_seller,
                          'msg'                 => $payData['comment'],
                          'item_details'        => trim($this->load->view('templates/email/order_placed',$data,true)),
                          'support_link'        => "<a href='".base_url('seller/support/messages')."'>Click here</a>"
                      );
                      $sendEmail = sendEmail($email_template, $to, $param, $userRole);


                      $userRole  = 0; //for Admin
                      $adminEMAIl= get_option_url('EMAIl');
                      $to      = (!empty($adminEMAIl)) ? $adminEMAIl : SUPPORT_EMAIL;
                      $param     = array(
                          'site_name'           => SITE_NAME,
                          'user_role'           => "Seller",
                          'seller_name'         => ucfirst($seller_info->user_name),
                          'item_amount'         => $getFeePreviewDetails->total_amount,
                          'your_fee'            => $getFeePreviewDetails->fee_preview,
                          'seller_paid_amount'  => $getFeePreviewDetails->pay_to_seller,
                          'your_msg'            => $payData['comment'],
                          'item_details'        => trim($this->load->view('templates/email/order_placed',$data,true))
                      );
                      $sendEmailAdmin = sendEmail($email_template, $to, $param, $userRole);
                  }

                  //==-----------===Send SMS==-----------===
                  if($email_template->template_sms_enable==1){

                    $userRole  = 1; //for Customer
                    $to      = ($seller_info->country_code) ? '+'.$seller_info->country_code.''.$seller_info->mobile : $seller_info->mobile;
                    $param     = array(
                          'site_name'           => SITE_NAME,
                          'user_role'           => "Seller",
                          'seller_name'         => ucfirst($seller_info->user_name),
                          'item_amount'         => $getFeePreviewDetails->total_amount,
                          'admin_fee'           => $getFeePreviewDetails->fee_preview,
                          'seller_paid_amount'  => $getFeePreviewDetails->pay_to_seller,
                          'msg'                 => $payData['comment'],
                          'item_details'        => trim($this->load->view('templates/email/order_placed',$data,true)),
                          'support_link'        => "<a href='".base_url('seller/support/messages')."'>Click here</a>"
                    );
                    $sendSMS = sendSMS($email_template, $to, $param, $userRole);


                    $userRole  = 0; //for Admin
                    $to      = get_option_url('PHONE');
                    $param     = array(
                          'site_name'           => SITE_NAME,
                          'user_role'           => "Seller",
                          'seller_name'         => ucfirst($seller_info->user_name),
                          'item_amount'         => $getFeePreviewDetails->total_amount,
                          'your_fee'            => $getFeePreviewDetails->fee_preview,
                          'seller_paid_amount'  => $getFeePreviewDetails->pay_to_seller,
                          'your_msg'            => $payData['comment'],
                          'item_details'        => trim($this->load->view('templates/email/order_placed',$data,true))
                    );
                    $sendSMSAdmin = sendSMS($email_template, $to, $param, $userRole);
                  }

                }

            }
          }
          //-------------**For Send email AND SMS-----------
          
          $data = json_encode(array('status'=>'success', 'msg'=>'Payment has been sent successfully'));
          echo $data;
        }else{
          $data = json_encode(array('status'=>'failed', 'msg'=>'Something went wrong in your payment process. please try again'));
          echo $data;
        }
      }else{
        echo json_encode(array('status'=>'failed', 'msg'=>'No order information found'));
      }
    }else{
      echo json_encode(array('status'=>'failed', 'msg'=>'No order information found'));
    }
  }


}