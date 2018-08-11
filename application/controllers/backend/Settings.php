<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Settings extends CI_Controller{

    public function index()
    {
       if(superadmin_logged_in()==FALSE)
       {
        redirect('backend/login'); 
       } //check login authentication
       $this->load->model('Common_model');
        $options_data = $this->Common_model->get_result('options',array('status'=>1));
        $int_array = array(14,15,16);

        foreach ($options_data as $row)
        {
            $this->form_validation->set_rules("".$row->option_name."","".$row->option_name."",'trim|required');
        }
        if ($this->form_validation->run() == TRUE)
        {
            foreach ($options_data as $row){
                $post_data=array('option_value' =>trim($_POST[$row->option_name]));
                $this->Common_model->update('options',$post_data,array('option_name'=>$row->option_name));
                if($row->option_id==33){
                    $this->Common_model->update('category',array('commision'=>$_POST[$row->option_name]));
                }
            }
            $this->session->set_flashdata('msg_success','Option setting has been updated successfully');
            redirect('backend/settings');
        }

        $data['title'] =  "Setting";
        $data['options'] =  $options_data;
        $data['template']='backend/options';
        $this->load->view('templates/superadmin_template', $data);
    }
}