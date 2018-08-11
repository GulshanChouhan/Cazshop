<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model {
	public function insert($table_name='',  $data=''){
		$query=$this->db->insert($table_name, $data);
		if($query)
			return $this->db->insert_id();
		else
			return FALSE;		
	}
	public function get_result($table_name='', $id_array='',$columns=array()){
		if(!empty($columns)):
			$all_columns = implode(",", $columns);
			$this->db->select($all_columns);
		endif; 
		if(!empty($id_array)):		
			foreach ($id_array as $key => $value){
				$this->db->where($key, $value);
			}
		endif;		
		$query=$this->db->get($table_name);
		if($query->num_rows()>0)
			return $query->result();
		else
			return FALSE;
	}
	public function get_row($table_name='', $id_array='',$columns=array()){
		if(!empty($columns)):
			$all_columns = implode(",", $columns);
			$this->db->select($all_columns);
		endif; 
		if(!empty($id_array)):		
			foreach ($id_array as $key => $value){
				$this->db->where($key, $value);
			}
		endif;
		$query=$this->db->get($table_name);
		if($query->num_rows()>0)
			return $query->row();
		else
			return FALSE;
	}
	public function update($table_name='', $data='', $id_array=''){
		if(!empty($id_array)):
			foreach ($id_array as $key => $value){
				$this->db->where($key, $value);
			}
		endif;
		return $this->db->update($table_name, $data);		
	}
	public function delete($table_name='', $id_array=''){		
	 	return $this->db->delete($table_name, $id_array);
	}


	// all user login
	public function login($email,$password,$user_type=FALSE){	

		$data  = array('email'=>$email);	
		$query_get = $this->db->get_where('users',$data);
		$count = $query_get->num_rows();
		$res = $query_get->row_array();
		$salt = $res['salt'];
		if($count==1){

			if($user_type=='superadmin'){
				$ur = 0;
			}else if($user_type=='seller'){
				$ur = 1;
			}else if($user_type=='customers'){
				$ur = 2;
			}

			$query = "SELECT * FROM `users` WHERE `email` ='".$email."' AND `password` = '".sha1($salt.sha1($salt.sha1($password)))."' AND `user_role` = '".$ur."'";
			
			$sql= $this->db->query($query);
			$check_count = $sql->num_rows();
			$result = $sql->row();

			if($check_count == 1)
			{
				//p('fdsFD'); die;
				if($result->status==1){

					$user_data = array(
						'id' 			=> $sql->row()->user_id,
						'user_role' 	=> $sql->row()->user_role,
						'first_name' 	=> $sql->row()->first_name,
						'last_name'		=> $sql->row()->last_name,
						'email'			=> $sql->row()->email,
						'last_ip' 		=> $sql->row()->last_ip,
						'last_login' 	=> $sql->row()->last_login,
						'user_name' 	=> $sql->row()->user_name,
						'mobile' 		=> $sql->row()->mobile,
						'country_code' 	=> $sql->row()->country_code,
						'logged_in' 	=> TRUE
					);

					if($user_type=='superadmin'){
						$this->session->unset_userdata('superadmin_info');
						$this->session->set_userdata('superadmin_info',$user_data);
					}else if($user_type=='seller'){

						$this->session->unset_userdata('seller_info');
						$this->session->set_userdata('seller_info',$user_data);

						$selleradmin_name = ucwords(selleradmin_name());
						$this->session->set_flashdata('msg_success', 'Welcome '.$selleradmin_name.', You have logged in successfully');

						if(empty($result->skipped)) 
							redirect(base_url('seller/agreement_step/'.base64_encode($result->user_id)));

						if($result->confirmation_code!='verified') 
							redirect(base_url('seller/phone_verification/'.base64_encode($result->user_id)));

						if(!empty($result->skipped)){
							$skipped = json_decode($result->skipped);
							$status = $skipped->status;
							if($status==0){
								$lastPage = end($skipped->skipped_pages);
								redirect(base_url('seller/'.$lastPage.'/'.base64_encode($result->user_id)));
							}else{
								redirect(base_url('seller/dashboard'));
							}
						}
						
						
					}else if($user_type=='customers'){
						$this->session->unset_userdata('user_info');
						$this->session->set_userdata('user_info',$user_data);

						/*---Store cart data in cart session--*/
						$this->setCartData($user_data['id']);
						$user_name = ucfirst(user_name());
						$this->session->set_flashdata('msg_success', 'Welcome '.$user_name.', You have logged in successfully');
					}

					$this->update('users',array('last_ip' => $this->input->ip_address(),
							'last_login' => date('Y-m-d h:i:s')),array('user_id'=>$sql->row()->user_id));
					return TRUE;

				}else{
					$this->session->set_flashdata('msg_error', 'Your account is not activated yet. Please contact to administrator');
					return FALSE;
				}
				
			}else{
				$this->session->set_flashdata('msg_error', 'Incorrect Email Or Password');
				return FALSE;
			}	
		}else{
			$this->session->set_flashdata('msg_error', 'Incorrect Email Or Password');
			return FALSE;
		}
	}
		
	
	public function login_though_sellerDashboard($email,$password){	
		$query = "SELECT * FROM `users` WHERE `email` ='".$email."' AND `password` = '".$password."'";
			
		$sql= $this->db->query($query);
		$check_count = $sql->num_rows();
		$result = $sql->row();
		if($check_count == 1)
		{
			$user_data = array(
				'id' 			=> $sql->row()->user_id,
				'user_role' 	=> $sql->row()->user_role,
				'first_name' 	=> $sql->row()->first_name,
				'last_name'		=> $sql->row()->last_name,
				'email'			=> $sql->row()->email,
				'last_ip' 		=> $sql->row()->last_ip,
				'last_login' 	=> $sql->row()->last_login,
				'user_name' 	=> $sql->row()->user_name,
				'mobile' 		=> $sql->row()->mobile,
				'country_code' 	=> $sql->row()->country_code,
				'logged_in' 	=> TRUE
			);

			$this->session->set_userdata('seller_info',$user_data);
			$this->update('users',array('last_ip' => $this->input->ip_address(),
					'last_login' => date('Y-m-d h:i:s')),array('user_id'=>$sql->row()->user_id));
			return TRUE;
		}else{
			return FALSE;
		}
	}


	// all user login
	public function proxy_login($data=array()){	

		$query_get = $this->db->get_where('users',$data);
		$count = $query_get->num_rows();
		$res = $query_get->row_array();

		$status = $res['status'];
		$user_role = $res['user_role'];

		if($count==1){
			if($status==1){
				$user_data = array(
					'id' 				=> $res['user_id'],
					'user_role' 		=> $res['user_role'],
					'first_name' 		=> $res['first_name'],
					'last_name'			=> $res['last_name'],
					'email'				=> $res['email'],
					'last_ip' 			=> $res['last_ip'],
					'last_login' 		=> $res['last_login'],
					'user_name' 		=> $res['user_name'],
					'business_name' 	=> $res['business_name'],
					'confirmation_code' => $res['confirmation_code'],
					'mobile' 			=> $res['mobile'],
					'country_code' 		=> $res['country_code'],
					'logged_in' 		=> TRUE
				);
				return $user_data;
			}else{
				return FALSE;
			}	
		}else{
			return FALSE;
		}
	}


	private function setCartData($user_id=''){

		$cart_DB_info = $this->common_model->get_row('user_cartinfo',array('user_id'=>$user_id));
		if(!empty($cart_DB_info)){

			$insertArr = array();
			$cartDBData = json_decode($cart_DB_info->cart_data);
			foreach ($cartDBData as $key => $value){
				if(!empty($value)){
					$insertArr = (Array) $value;
					$cartInfo = $this->cart->insert($insertArr);
				}	
			}
		}
		return true;
	}

}
//user_model end