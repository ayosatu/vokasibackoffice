<?php 
session_start();
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class RS_student extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //insert data pasiens
    function index_post(){
                //$user_name=$this->session->userdata('user_name');

                $action = $this->input->post('action', true);
                $student_id = ($this->post('student_id') == NULL) ? NULL : $this->post('student_id');
                $generation_unit_id = ($this->post('generation_unit_id') == NULL) ? NULL : $this->post('generation_unit_id');
                $majors_id2 = ($this->post('majors_id2') == NULL) ? NULL : $this->post('majors_id2');
                $name = ($this->post('name') == NULL) ? NULL : $this->post('name');
                $nim = ($this->post('nim') == NULL) ? NULL : $this->post('nim');
                $email = ($this->post('email') == NULL) ? NULL : $this->post('email');
                $birth_date = ($this->post('birth_date') == NULL) ? NULL : $this->post('birth_date');
                $birth_place = ($this->post('birth_place') == NULL) ? NULL : $this->post('birth_place');
                $nik = ($this->post('nik') == NULL) ? NULL : $this->post('nik');
                $address = ($this->post('address') == NULL) ? NULL : $this->post('address');
                $no_tlp = ($this->post('no_tlp') == NULL) ? NULL : $this->post('no_tlp');
                $no_hp = ($this->post('no_hp') == NULL) ? NULL : $this->post('no_hp');
                $img_path = ($this->post('img_path') == NULL) ? NULL : $this->post('img_path');
                $result_id = ($this->post('result_id') == NULL) ? NULL : $this->post('result_id');
                $start_date = ($this->post('start_date') == NULL) ? NULL : $this->post('start_date');
                $end_date = ($this->post('end_date') == NULL) ? NULL : $this->post('end_date');
                $gender_id = ($this->post('gender_id') == NULL) ? NULL : $this->post('gender_id');
                $religion_id = ($this->post('religion_id') == NULL) ? NULL : $this->post('religion_id');
                $user_name = ($this->post('user_name') == NULL) ? NULL : $this->post('user_name');


                if ($action == 'QR') {
                    $sql = "select * from f_search_majors ('".$keyword."');";
                    $data = $this->db->query($sql)->row_array();
                    $this->response(['data' => $data,
                                     REST_Controller::HTTP_OK ]);
                }else{
                    $sql = "select * from f_crud_student ".
                            "('" . $action . "',
                                $student_id,
                                $generation_unit_id,
                                $majors_id2,
                            '" . $name . "',
                            '" . $nim . "',
                            '" . $email . "',
                            '" . $birth_date . "',
                            '" . $birth_place . "',
                            '" . $nik . "',
                            '" . $address . "',
                            '" . $no_tlp . "',
                            '" . $no_hp . "',
                            '" . $img_path . "',
                            '" . $result_id . "',
                            '" . $start_date . "',
                            '" . $end_date . "',
                            '" . $gender_id . "',
                            '" . $religion_id . "',
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