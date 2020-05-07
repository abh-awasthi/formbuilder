<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Email_model extends CI_Model {

  public $emailTable = "email_record";
  //public $examinersTable = "oes_examiners";

  function __construct() {
    parent:: __construct();
    date_default_timezone_set('Asia/Kolkata');
  } 




    function saveEmailRecord($data){

      $this->db->insert($emailTable, $data);
      if ($this->db->insert_id() >0 ) {
         return TRUE;
      }else{
        return FALSE;
      }

    }

   
  
}