<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct() {
		parent::__construct();
 
      $this->load->library(['ion_auth', 'form_validation','email']);
 
      $this->load->model('Form_model');
      $this->load->model('Users_model');
 
     $this->tables = $this->config->item('tables', 'ion_auth');
	}


  function index() {
	


  	$this->load->view('auth/header2.php');
    $data['user'] = $this->Users_model->getUser($this->session->userdata('user_id'));
	  $this->load->view('users' . DIRECTORY_SEPARATOR . 'profile',$data);
    $this->load->view('auth/footer.php');


  }

  
  function do_upload()
{

    $uid = $this->session->userdata('user_id');
    $config['upload_path'] = './uploads/profiles/';
    $config['allowed_types'] = 'gif|jpg|png';
    // $config['max_width']  = '1024';
    // $config['max_height']  = '768';
    $config['overwrite'] = TRUE;
    $config['encrypt_name'] = FALSE;
    $config['remove_spaces'] = TRUE;
    $config['file_name'] = $uid;
    if ( ! is_dir($config['upload_path']) ) die("THE UPLOAD DIRECTORY DOES NOT EXIST");
    $this->load->library('upload', $config);
    if ( ! $this->upload->do_upload('userfile')) {
        //print_r($this->upload->display_errors());
        $response['status']=FALSE;
        $response['message']=$this->upload->display_errors();
        echo json_encode($response);
    } else {

     $upload = $this->upload->data();
     $dataupdate = array(
      'profile_pic'=>$upload['file_name']
     );
     $result = $this->Users_model->updateUserPic($dataupdate,array('id'=>$uid));
     if ($result) {
        $response['status']=TRUE;
        $response['message']="User Pic Updated.";
        echo json_encode($response);
     }else{

        $response['status']=FALSE;
        $response['message']="User Not Pic Updated.";
        echo json_encode($response);
     }
    }
}


function sendBrocastMail(){

    $this->load->view('auth/header2.php');
    $data['user'] = $this->Users_model->getUser($this->session->userdata('user_id'));
    $this->load->view('users' . DIRECTORY_SEPARATOR . 'sendmail',$data);
    $this->load->view('auth/footer.php');

}
  


    
  
}