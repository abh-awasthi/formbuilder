<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

  public $usersTable = "users";
  public $examinersTable = "oes_examiners";

  function __construct() {
    parent:: __construct();
    date_default_timezone_set('Asia/Manila');
  }

  


  function getUSer($id){

    $where=array(
      'id'=>$id
    );
    return $this->db->where($where)->get($this->usersTable)->row();

  }


  function updateUserPic($data,$where){

    $this->db->where($where);
    $this->db->update($this->usersTable,$data);
    if ($this->db->affected_rows()>0) {
      return TRUE;
    }else{
      return TRUE;
    }

  }




  function updateLastLogin($userEmail) {
    $data = ['user_last_login'   =>  date("Y-m-d H:i:s")];
    $this->db->where('email', $userEmail);
    $updateLastLogin = $this->db->update($this->usersTable, $data);
    return $updateLastLogin;
  }


  function totalTestTakenByUser($where){


    return $this->db->where($where)->get($this->examinersTable)->result();


  }

  function loginWithGoogle($data) {
    $ifExists = $this->db
      ->where('email', $data['email'])
      ->where('active', 1)
      ->get($this->usersTable)
      ->num_rows();
    if ($ifExists == 0) {
      $this->session->set_userdata('userPositionSessId', 1);
      $data = [
        'user_name'         =>   $data['user_name'],
        'user_email'        =>   $data['user_email'],
        'user_uname'        =>   $data['user_uname'],
        'user_google_login' =>   1,
        'user_status'       =>   1,
        'user_position'     =>   1,
        'user_last_login'   =>  date("Y-m-d H:i:s")
      ];
      $loginWithGoogle = $this->db->insert($this->usersTable, $data);
      return $loginWithGoogle;
    } else {
      $ifAdmin = $this->db
        ->where('user_email', $data['user_email'])
        ->where('user_status', 1)
        ->get($this->usersTable)
        ->row();
      if($ifAdmin->user_position == 0) {
        $this->session->set_userdata('userIDSess', $ifAdmin->user_id);
        $this->session->set_userdata('userPositionSessId', 0);
      } else {
        $this->session->set_userdata('userIDSess', $ifAdmin->user_id);
        $this->session->set_userdata('userPositionSessId', 1);
      }
    }
  }

  
  
}