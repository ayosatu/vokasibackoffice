<?php 
session_start();
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class RS_Majors extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //insert data pasiens
    function index_post(){
                //$user_name=$this->session->userdata('user_name');

                $action = $this->input->post('action', true);
                $majors_id = ($this->post('majors_id') == NULL) ? NULL : $this->post('majors_id');;
                $code = ($this->post('code') == NULL) ? NULL : $this->post('code');
                $description = ($this->post('description') == NULL) ? NULL : $this->post('description');
                $user_name = ($this->post('user_name') == NULL) ? NULL : $this->post('user_name');

                $sql = "select * from f_crud_majors ".
                        "('" . $action . "',
                               $majors_id,
                          '" . $code . "',
                          '" . $description . "',
                          '" . $user_name . "'
                        );";
               
                $majors = $this->db->query($sql)->row_array();
                if($majors){
                    $this->response(['status' => true,
                            'action' => $action,
                            'data' => $majors['ostr_msg']
                    ], REST_Controller::HTTP_OK );
                }else{
                    $this->response(['status' => false,
                            'action' => $action,
                            'data' => $majors['ostr_msg']
                    ], REST_Controller::HTTP_BAD_REQUEST );
                }
            
                
    }

}
?>
