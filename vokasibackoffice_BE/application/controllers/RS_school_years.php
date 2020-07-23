<?php 
session_start();
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class RS_school_years extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //insert data pasiens
    function index_post(){
                //$user_name=$this->session->userdata('user_name');

                $action = $this->input->post('action', true);
                $sch_years_id = ($this->post('sch_years_id') == NULL) ? NULL : $this->post('sch_years_id');;
                $code = ($this->post('code') == NULL) ? NULL : $this->post('code');
                $description = ($this->post('description') == NULL) ? NULL : $this->post('description');
                $end_period = ($this->post('end_period') == NULL) ? NULL : $this->post('end_period');
                $result_id = ($this->post('result_id') == NULL) ? NULL : $this->post('result_id');
                $start_period = ($this->post('start_period') == NULL) ? NULL : $this->post('start_period');
                $user_name = ($this->post('user_name') == NULL) ? NULL : $this->post('user_name');

                $sql = "select * from f_crud_school_years ".
                        "('" . $action . "',
                               $sch_years_id,
                          '" . $code . "',
                          '" . $description . "',
                          '" . $end_period . "',
                               $result_id,
                          '" . $start_period . "',
                          '" . $user_name . "'
                        );";
               
                $school_years = $this->db->query($sql)->row_array();
                if($school_years){
                    $this->response(['status' => true,
                            'action' => $action,
                            'data' => $school_years['ostr_msg']
                    ], REST_Controller::HTTP_OK );
                }else{
                    $this->response(['status' => false,
                            'action' => $action,
                            'data' => $school_years['ostr_msg']
                    ], REST_Controller::HTTP_BAD_REQUEST );
                }
            
                
    }

}
?>
