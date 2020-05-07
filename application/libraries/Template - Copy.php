<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emailtracker {
		


	public function __construct()
	{
		//$this->My_CI = & get_instance();
		$this->config->load('ion_auth', TRUE);
		$this->load->library(['email']);
		$this->lang->load('ion_auth');
		$this->load->helper(['cookie', 'language','url']);
		$this->load->library('session');
		$this->load->model('Email_model');



	}



	function saveEmailRecord(){

		$response = $this->Email_model->saveEmailRecord($data);
		if ($response) {
			return TRUE;
		}else{
			return FALSE;
		}



	}



}

/* End of file Emailtracker.php */
/* Location: ./system/application/libraries/Emailtracker.php */