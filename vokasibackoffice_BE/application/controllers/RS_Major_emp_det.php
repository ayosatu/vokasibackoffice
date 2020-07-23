<?php 
session_start();
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class RS_Major_emp_det extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //insert data pasiens
    function index_post(){
                //$user_name=$this->session->userdata('user_name');

                $action = $this->input->post('action', true);
                $keyword =  $this->input->post('keyword');
                $major_emp_det_id = ($this->post('major_emp_det_id') == NULL) ? NULL : $this->post('major_emp_det_id');
                $emp_id = ($this->post('emp_id') == NULL) ? NULL : $this->post('emp_id');
                $majors_id2 = ($this->post('majors_id2') == NULL) ? NULL : $this->post('majors_id2');
                $valid_from = ($this->post('valid_from') == NULL) ? NULL : $this->post('valid_from');
                $valid_until = ($this->post('valid_until') == NULL) ? NULL : $this->post('valid_until');
                $user_name = ($this->post('user_name') == NULL) ? NULL : $this->post('user_name');

                if ($action == 'QR') {
                    $sql = "select * from f_search_major_emp_det ('".$keyword."');";
                    $data = $this->db->query($sql)->row_array();
                    $this->response(['data' => $data,
                                     REST_Controller::HTTP_OK ]);
                }else{
                    $sql = "select * from f_crud_majors_emp_det ".
                        "('" . $action . "',
                               $major_emp_det_id,
                               $emp_id ,
                               $majors_id2,
                          '" . $valid_from . "',
                          '" . $valid_until . "',
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

