<?php 
session_start();
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class RS_generation_unit extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //insert data pasiens
    function index_post(){
                //$user_name=$this->session->userdata('user_name');

                $action = $this->input->post('action', true);
                $keyword =  $this->input->post('keyword');
                $generation_unit_id = ($this->post('generation_unit_id') == NULL) ? NULL : $this->post('generation_unit_id');
                $ins_unit_id = ($this->post('ins_unit_id') == NULL) ? NULL : $this->post('ins_unit_id');
                $sch_years_id = ($this->post('sch_years_id') == NULL) ? NULL : $this->post('sch_years_id');
                $code = ($this->post('code') == NULL) ? NULL : $this->post('code');
                $description = ($this->post('description') == NULL) ? NULL : $this->post('description');
                $sequence = ($this->post('sequence') == NULL) ? NULL : $this->post('sequence');
                $user_name = ($this->post('user_name') == NULL) ? NULL : $this->post('user_name');

                if ($action == 'QR') {
                    $sql = "select * from f_search_generation_unit ('".$keyword."');";
                    $data = $this->db->query($sql)->row_array();
                    $this->response(['data' => $data,
                                     REST_Controller::HTTP_OK ]);
                }else{
                    $sql = "select * from f_crud_generation_units ".
                        "('" . $action . "',
                               $generation_unit_id,
                               $ins_unit_id ,
                               $sch_years_id,
                          '" . $code . "',
                          '" . $description . "',
                               $sequence,
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

}
?>

