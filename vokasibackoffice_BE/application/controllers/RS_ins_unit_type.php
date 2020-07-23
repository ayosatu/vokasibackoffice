<?php 
session_start();
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class RS_ins_unit_type extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //insert data pasiens
    function index_post(){
                //$user_name=$this->session->userdata('user_name');

                $action = $this->input->post('action', true);
                $ins_unit_type_id = ($this->post('ins_unit_type_id') == NULL) ? NULL : $this->post('ins_unit_type_id');;
                $code = ($this->post('code') == NULL) ? NULL : $this->post('code');
                $description = ($this->post('description') == NULL) ? NULL : $this->post('description');
                // die(var_dump($this->post('description')));
                $user_name = ($this->post('user_name') == NULL) ? NULL : $this->post('user_name');

                $sql = "select * from f_crud_institution ".
                        "('".$action."',  $ins_unit_type_id ,"."'$code',"."'$description',"."'". $user_name."')";
               
                $ins_unit_type = $this->db->query($sql)->row_array();
                if($ins_unit_type){
                    $this->response(['status' => true,
                            'action' => $action,
                            'data' => $ins_unit_type['ostr_msg']
                    ], REST_Controller::HTTP_OK );
                }else{
                    $this->response(['status' => false,
                            'action' => $action,
                            'data' => $ins_unit_type['ostr_msg']
                    ], REST_Controller::HTTP_BAD_REQUEST );
                }
            
                
    }

}
?>
