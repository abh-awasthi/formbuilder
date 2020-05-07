<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends CI_Controller {

	function __construct() {
		parent::__construct();
		if ( ! $this->session->userdata('identity') ) {
      $this->session->set_flashdata('msg', 'Please login to continue!');
			redirect(base_url().'auth/login');
		} else {
      $this->load->library(['ion_auth', 'form_validation','email']);
 
      $this->load->model('Form_model');

		}
    $this->tables = $this->config->item('tables', 'ion_auth');
	}

  function index() {
	
  	$this->load->view('auth/header2.php');
	//$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'index', $this->data);
    $this->load->view('auth/footer.php');


  }

  function create(){


  	$this->load->view('auth/header2.php');
	$this->load->view('form' . DIRECTORY_SEPARATOR . 'create');
    $this->load->view('auth/footer.php');


  }

  function saveForm(){
 
    
    $form_data = isset($_POST['formData']) ? $_POST['formData'] : FALSE;
    $form_post_decode = json_decode(trim($_POST['formData']));
   // print_r($form_post_decode);  exit;
    $uid = $this->session->userdata('user_id');
    $form_title = $form_post_decode->title;
    $form_start = trim($form_post_decode->validfrom);
    if (empty($form_start)) {
       $form_start = date('Y-m-d H:i');
    }
    $form_end = trim($form_post_decode->validtill);
    $slug = strtolower(str_replace(' ', '-', $form_title));
    $slug = $slug."-".$uid.rand(99,999);
    $form_header = json_encode($form_post_decode->fields);



//  print_r($form_post_decode->fields); exit;

    if(empty($form_data)) {
         $response['status']=FALSE;
         $response['message'] = FORM_NOT_UPDATED;
         echo  json_encode($response);
    }else{

      $data=array(
            'form_json'=>$form_data,
            'slug'=>$slug,
            'user_id'=>$this->session->userdata('user_id'),
            'title'=>$form_title,
            'start_time'=>$form_start,
            'end_time'=>$form_end,
            'form_header'=>$form_header,
            'created_on'=>time()
      );
      $this->db->where('slug',$slug);
      $query=$this->db->get('forms');
      $result =  $query->result();
     // print_r($result);  exit;
      if (!empty($result)) {
         //print_r($data); exit;
         $this->db->where('slug',$slug);
         $query=$this->db->update('forms',$data);
      }else{
         
         $this->db->insert('forms',$data); 
      }

      
     $form_id = $this->db->insert_id();
      if ($form_id > 0 || $this->db->affected_rows()>0) {
        foreach ($form_post_decode->fields as $key => $field) {

          $data_h = array(
          'form_id'=>$form_id,
          'element_label'=>$field->title
          );
          $this->db->insert('form_header',$data_h);

         }
         $response['status']=TRUE;
         $response['message'] = FORM_UPDATED;
         $response['slug']=$slug;
         echo  json_encode($response);
      }else{

         $response['status']=FALSE;
         $response['message'] = FORM_NOT_UPDATED;
         $response['slug']=$slug;
         echo  json_encode($response);

      }

    }


  }


   function editForm($slug){

    $form_data = isset($_POST['formData']) ? $_POST['formData'] : FALSE;
    $form_post_decode = json_decode(trim($_POST['formData']));
    $uid = $this->session->userdata('user_id');
    $form_title = $form_post_decode->title;
    $form_start = trim($form_post_decode->validfrom);
    if (empty($form_start)) {
       $form_start = date('Y-m-d H:i');
    }
    $form_end = trim($form_post_decode->validtill);
    $form_header = json_encode($form_post_decode->fields);
    if(empty($form_data)) {
         $response['status']=FALSE;
         $response['message'] = FORM_NOT_UPDATED;
         echo  json_encode($response);
    }else{

      $data=array(
            'form_json'=>$form_data,
            'slug'=>$slug,
            'user_id'=>$this->session->userdata('user_id'),
            'title'=>$form_title,
            'start_time'=>$form_start,
            'end_time'=>$form_end,
            'form_header'=>$form_header,
            'created_on'=>time()
      );
      $this->db->where('slug',$slug);
      $query=$this->db->get('forms');
      $result =  $query->result();

      if (!empty($result)) {

        $this->db->where('slug',$slug);
        $fquery= $this->db->get('forms_data');
        $form_data_res = $fquery->result();
        if (!empty($form_data_res)) {
          
         $response['status']=FALSE;
         $response['message'] = "Can not edit as form has already response recorded";
         $response['slug']=$slug;
         echo  json_encode($response);
        }else{

         $this->db->where('slug',$slug);
         $query=$this->db->update('forms',$data);
         if ($this->db->affected_rows()>0) {
         $response['status']=TRUE;
         $response['message'] = FORM_UPDATED;
         $response['slug']=$slug;
         echo  json_encode($response);
         }else{

         $response['status']=FALSE;
         $response['message'] = FORM_NOT_UPDATED;
         $response['slug']=$slug;
         echo  json_encode($response);

      }

        }


      }


    }


  }


  function render($slug){

      $this->db->where('slug',$slug);
      $query=$this->db->get('forms');
      $result =  $query->result();
      $json = $result[0]->form_json;
      $action='form/submit/'.$slug;
      $config=array(
        'json'=>$json,
        'action'=>$action
      );

     $this->load->library('formloader',$config);
     $data['form'] =  $this->formloader->render_form(); 

     $this->load->view('auth/header.php');
     $this->load->view('form' . DIRECTORY_SEPARATOR . 'render',$data);
     

  }

  function submit($slug){

  $data=array();
  $json_array=array();

  foreach ($_POST as $post_key => $post_value) {
    
    if (is_array($post_value)) {
     $data[$post_key]=trim(implode(",",$post_value));
    }else{
      $data[$post_key]=trim($post_value);
    }
    

  }

   if (isset($_FILES) && !empty($_FILES)) {
    

         foreach ($_FILES as $fkey => $file_value) {


         	$file = "./uploads/".$slug."/";
            if(is_dir($file)) {
             echo ("$file is a directory");
           } else {
           	mkdir($file, 0777, true);
              echo ("$file is not a directory");
            }

           $config['upload_path']   = './uploads/'.$slug."/"; 
           $config['allowed_types'] = '*'; 
         //$config['max_size']      = 100;
           $config['file_name'] = $slug.time();  
           $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload($fkey)) {
            $error = array('error' => $this->upload->display_errors()); 
            print_r($error);
            //$this->load->view('upload_form', $error); 
            }else { 
            $data_file = $this->upload->data();
            //print_r($data_file);
            $data[$fkey]=$data_file['file_name']; 
            //$this->load->view('upload_success', $data); 
           } 

         }

         print_r($data);
         $json_array = array(
          'json'=>json_encode($data),
          'slug'=>$slug
         );
         
      

 
   }else{

   
         $json_array = array(
          'json'=>json_encode($data),
          'slug'=>$slug
         );
         


   }

$this->db->insert('forms_data',$json_array);



  }


function real(){
$this->load->view('form' . DIRECTORY_SEPARATOR . 'r_real');

}


    function render_real($slug){

      $this->db->where('slug',$slug);
      $query=$this->db->get('forms');
      $result =  $query->result();
      $json = $result[0]->form_json;
      $action='submit.php';
      $config=array(
        'json'=>$json,
        'action'=>$action
      );

     $this->load->library('formloader',$config);
     echo  $this->formloader->render_form_embed(); 
    // $this->load->view('auth/header.php');
     

  }


function preview($slug){

      $this->db->where('slug',$slug);
      $query=$this->db->get('forms');
      $result =  $query->result();
      $json = $result[0]->form_json;
      $action='submit.php';
      $config=array(
        'json'=>$json,
        'action'=>$action
      );



     $this->load->library('formloader',$config);
 
     $data['form'] =  $this->formloader->render_form(); 
     $this->load->view('auth/header.php');
     $this->load->view('form' . DIRECTORY_SEPARATOR . 'preview',$data);
     $this->load->view('auth/footer.php'); 


}




function generate_embed_code($slug){


$result = $this->Form_model->generate_embed($slug);
if ($result) {
  $response['status'] = TRUE;
  $response['message'] = "Embed code generated";
  $response['embed'] = $result;
  echo json_encode($response);

}else{

  $response['status'] = FALSE;
  $response['message'] = "Embed code not generated";
  echo json_encode($response);

}

}

function edit($slug){

     $this->db->where('slug',$slug);
      $query=$this->db->get('forms');
      $result =  $query->result();
      $json = $result[0]->form_json;
      $action='submit.php';
      $config=array(
        'json'=>$json,
        'action'=>$action
      );

     
     $data['json'] =  $json; 
     $data['slug'] =  $result[0]->slug;

     $this->load->view('auth/header2.php');
     $this->load->view('form' . DIRECTORY_SEPARATOR . 'edit',$data); 
     $this->load->view('auth/footer.php');

}



function editnew($slug){

     $this->db->where('slug',$slug);
      $query=$this->db->get('forms');
      $result =  $query->result();
      //print_r($result[0]->form_json); exit;
      $json = $result[0]->form_json;
      //echo $json;  exit;
      $action='submit.php';
      $config=array(
        'json'=>$json,
        'action'=>$action
      );

     
     $data['json'] =  $json; 
     $data['slug'] =  $result[0]->slug;
     
     $this->load->view('auth/header2.php');
     $this->load->view('form' . DIRECTORY_SEPARATOR . 'editnew',$data); 
     $this->load->view('auth/footer.php');

}






 function getFormJSON($slug){

       $this->db->where('slug',$slug);
      $query=$this->db->get('forms');
      $result =  $query->result();
      $json = $result[0]->form_json;
      echo $json;

 }



function forms(){

    $this->load->view('auth/header2.php');
    $this->load->view('form/forms.php');
    $this->load->view('auth/footer.php');
}


function all_forms(){

 
    $select="form_id,slug,title,user_id,from_unixtime(created_on, '%d-%M-%Y %H:%i:%s') as created_on,active,deleted,DATE_FORMAT(start_time,'%d-%M-%Y  %r') as start_time,DATE_FORMAT(end_time,'%d-%M-%Y  %r') as end_time";
    $search = array('title');
    $this->Form_model->get_allForms($select,$search);



}




  public function deactivate($id = NULL)
  {
    if (!$this->ion_auth->logged_in())
    {
      // redirect them to the home page because they must be an administrator to view this
      $response['status']=FALSE;
      $response['message']=FORM_DEACTIVATED_ID_NOT_FOUND;
      echo json_encode($response);
      exit;
    }

    $id = (int)$id;
          // do we really want to deactivate?
        if ($this->ion_auth->logged_in())
        {
          $response = $this->Form_model->deactivate($id);
        }
        echo json_encode($response);
     
  }




  public function activate($id, $code = FALSE)
  {
 
     $response = $this->Form_model->activate($id);
     echo json_encode($response);

  }



  function delete($id){

     $response = $this->Form_model->delete_form($id);
     echo json_encode($response);

  }


  function get_form_data($slug){


  	$this->Form_model->get_form_data($slug);


  }


  function view($slug){


  	$data['slug'] =$slug;
    $data['last_10_entry'] = $this->Form_model->getLast10Data($slug);
    $data['form_header'] = $this->Form_model->getFormHeader($slug);

    $this->load->view('auth/header2.php');
    $this->load->view('form/view.php',$data);
    $this->load->view('auth/footer.php');

  }





    
  
}