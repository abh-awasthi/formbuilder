<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Form_model extends CI_Model {

  public $examinersTable = 'oes_examiners';
  public $usersTable  = 'users';
  public $topicsTable = 'oes_topics';




  function generate_embed($slug){

      $base = 'http://localhost/formbuilder/form/render_real/';
      $this->db->where('slug',$slug);
      $query=$this->db->get('forms');
      $result =  $query->result();
      $slug = $result[0]->slug;
      $renderurl = $base.$slug;
      $script = ' var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("formBuilder").innerHTML = this.responseText;
                console.log(this.responseText);
            }
        };
        xmlhttp.open("GET", "'.$renderurl.'", true);
        xmlhttp.send();';
       return $script;
      

  }





  function get_allForms($select,$search){

    
    $this->db->select($select);
    $this->db->where('deleted',0);
    $this->db->from('forms');

    if (isset($_GET['search'])) {

       $this->db->like('id', $_GET['search']);

       foreach ($search as   $coloumn) {

            $this->db->or_like($coloumn, $_GET['search']);
       }
       
        } else {
           $WHERE = NULL;
        }

        if (isset($_GET['limit']) && isset($_GET['offset']) ) {
          $this->db->limit($_GET['limit'],$_GET['offset']);
        }else if(isset($_GET['limit']) && !isset($_GET['offset'])){
          $this->db->limit($_GET['limit']);
        }else{
          $this->db->limit(20);
        }

        if (isset($_GET['sort']) && isset($_GET['order'])) {
          $this->db->order_by($_GET['sort'],$_GET['order']);
        }else{

          $this->db->order_by('created_on','DESC');
        }

    $data = $this->db->get()->result_array();
    $total = $this->countUsers();

    $json_data = array(
                "total"=> $total,
                "rows"=> $data
            );

    echo json_encode($json_data);


  }




  function countUsers(){
      return $this->db->count_all_results('forms');
  }


  /**
   * Updates a users row with an activation code.
   *
   * @param int|string|null $id
   *
   * @return bool
   * @author Mathew
   */
  public function deactivate($id = NULL)
  {

    $data = [
        'active'          => 0
    ];

    $this->db->update($this->tables['form'], $data, ['form_id' => $id]);

    $return = $this->db->affected_rows() == 1;
    if ($return)
    {
      $response['status']=TRUE;
      $response['message']=FORM_DEACTIVATED_SUCCESSFULLY;
    }
    else
    {
      $response['status']=TRUE;
      $response['message']=ERROR_FORM_DEACTIVATED_SUCCESSFULLY;
    }

    return $response;
  }


   function activate($id){
      $data = [
          'active'=> 1
      ];
      $this->db->where('form_id',$id);
      $this->db->update($this->tables['form'],$data);
      if ($this->db->affected_rows()>0) {
        $return['status']=TRUE;
          $return['message']=FORM_ACTIVATED;
      }else{
          $return['status']=FALSE;
          $return['message']=ERROR_FORM_ACTIVATED;
      }

     return $return;

   }



  

function delete_form($id){
      $data = [
          'deleted'=> 1
      ];
      $this->db->where('form_id',$id);
      $this->db->update($this->tables['form'],$data);
      if ($this->db->affected_rows()>0) {
        $return['status']=TRUE;
          $return['message']=FORM_DELETED;
      }else{
          $return['status']=FALSE;
          $return['message']=ERROR_FORM_DELETED;
      }

     return $return;

} 

function getLast10Data($slug){

  $this->db->where('slug',$slug);
  $query=$this->db->get('forms_data');
  $result =  $query->result();
  return $result;


}


function check_form_header($form_id,$column){





}



function get_form_data($slug){


$select ="*";
$search = array('json','phone');

    $this->db->where('slug',$slug);
    $this->db->select($select);
    $this->db->from('forms_data');

    if (isset($_GET['search'])) {

       $this->db->like('id', $_GET['search']);

       foreach ($search as   $coloumn) {

            $this->db->or_like($coloumn, $_GET['search']);
       }
       
        } else {
           $WHERE = NULL;
        }

        if (isset($_GET['limit']) && isset($_GET['offset']) ) {
          $this->db->limit($_GET['limit'],$_GET['offset']);
        }else if(isset($_GET['limit']) && !isset($_GET['offset'])){
          $this->db->limit($_GET['limit']);
        }else{
          $this->db->limit(20);
        }

        if (isset($_GET['sort']) && isset($_GET['order'])) {
          $this->db->order_by($_GET['sort'],$_GET['order']);
        }else{

          $this->db->order_by('created_on','DESC');
        }

    $data = $this->db->get()->result_array();

   

$c=0;
$array_row=array();
$data_j=array();
foreach ($data as $dkey => $dvalue) {
  $c++;
    $array_row[] = json_decode($dvalue['json']);
    //$array_row['id']=$c;
}

  //print_r($array_row);
//$data_j = $array_row;
    $total = count($array_row);

    $json_array = array(
                "total"=> $total,
                "rows"=> $array_row
            );

//print_r($json_array); exit;
    echo json_encode($json_array);
    //return $json_array;
  }

 

function getFormHeader($slug){

  $this->db->where('slug',$slug);
  $query=$this->db->get('forms');
  $result =  $query->row()->form_header;
  $header_array = json_decode($result);
  $real_header=array();
  foreach ($header_array as $key => $header) {
    $key  = str_replace(" ","_",strtolower($header->title));
   $real_header[$key] = $header->title;

  }

   //print_r($real_header);  exit;
  return $real_header;

}
 

}