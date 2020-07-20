<?php 
session_start();
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class RS_majors_ins_unit extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //insert data pasiens
    function index_post(){
                //$user_name=$this->session->userdata('user_name');

                $action = $this->input->post('action', true);
                $majors_id2 = ($this->post('majors_id2') == NULL) ? NULL : $this->post('majors_id2');
                $majors_id = ($this->post('majors_id') == NULL) ? NULL : $this->post('majors_id');
                $ins_unit_id = ($this->post('ins_unit_id') == NULL) ? NULL : $this->post('ins_unit_id');
                $user_name = ($this->post('user_name') == NULL) ? NULL : $this->post('user_name');

                $sql = "select * from f_crud_majors_ins_unit ".
                        "('" .  $action ."',  
                                $majors_id2 ,
                                $majors_id,
                                $ins_unit_id,
                        '" . $user_name."')";
               //echo($sql);
               //die();
                $majors_ins_unit = $this->db->query($sql)->row_array();
                if($majors_ins_unit){
                    $this->response(['status' => true,
                            'action' => $action,
                            'data' => $majors_ins_unit['ostr_msg']
                    ], REST_Controller::HTTP_OK );
                }else{
                    $this->response(['status' => false,
                            'action' => $action,
                            'data' => $majors_ins_unit['ostr_msg']
                    ], REST_Controller::HTTP_BAD_REQUEST );
                }
            
                
    }

}
?>
