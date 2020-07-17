<?php 

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class RS_student extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //insert data pasiens
    function index_post(){

        $action = $this->input->post('action', true);

        if($action == '' || $action == NULL || $action == ""){
            $this->response(['status' => false,
            'data' => 'Bad Request'
            ], REST_Controller::HTTP_BAD_REQUEST );
        }else{
            //QR : Query, IN : Insert , DL : Delete, UP : Update
            if($action == 'QR'){
                $keword = $this->input->post('keyword');
                if($keword == ''){
                    $student = $this->db->get('student')->result_array();
                }else {
                    var_dump($keword);
                    // die;
                    # description...
                    $this->db->where('student_id',$keword);
                    $this->db->like('generation_unit_id', strtoupper($keword));
                    $this->db->or_like('majors_id2', $keword);
                     $this->db->or_like('upper(name)', strtoupper($keword));
                     $this->db->or_like('upper(nim)', strtoupper($keword));
                     $this->db->or_like('upper(email)', strtoupper($keword));
                    $this->db->or_like('birth_date',$keword);
                    $this->db->or_like('upper(birth_place)', strtoupper($keword));
                    $this->db->or_like('upper(nik)', strtoupper($keword));
                    $this->db->or_like('upper(address)', strtoupper($keword));
                    $this->db->or_like('upper(no_tlp)', strtoupper($keword));
                    $this->db->or_like('upper(no_hp)', strtoupper($keword));
                    $this->db->or_like('upper(img_path)', strtoupper($keword));
                    $this->db->or_like('upper(update_by)', strtoupper($keword));
                    $this->db->or_like('result_id',$keword);
                    $this->db->or_like('start_date',$keword);
                    $this->db->or_like('end_date',$keword);
                    $this->db->or_like('gender_id',$keword);
                    $this->db->or_like('religion_id',$keword);
                    $student = $this->db->get('student')->result_array();
                }

                if($student){
                    $this->response(['status' => true,
                            'action' => $action,
                            'keyword' => $keword,
                            'data' => $student
                    ], REST_Controller::HTTP_OK );
                }else{
                    $this->response(['status' => false,
                            'action' => $action,
                            'data' => 'data not found'
                    ], REST_Controller::HTTP_NOT_FOUND );
                }
            // action QR
            } 
            //IN : insert 
            else if($action == 'IN'){
                $arrdata = [
                            'generation_unit_id' => $this->post('generation_unit_id'),
                            'majors_id2' => $this->post('majors_id2'),
                            'name' => $this->post('name'),
                            'nim' => $this->post('nim'),
                            'email' => $this->post('email'),
                            'birth_date' => $this->post('birth_date'),
                            'birth_place' => $this->post('birth_place'),
                            'nik' => $this->post('nik'),
                            'address' => $this->post('address'),
                            'no_tlp' => $this->post('no_tlp'),
                            'no_hp' => $this->post('no_hp'),
                            'img_path' => $this->post('img_path'),
                            'created_date' => 'now()',
                            'update_date' => 'now()',
                            'created_by' => 'Admin',
                            'update_by' => 'Admin',
                            'result_id' => $this->post('result_id'),
                            'start_date' => $this->post('start_date'),
                            'end_date' => $this->post('end_date'),
                            'gender_id' => $this->post('gender_id'),
                            'religion_id' => $this->post('religion_id'),
                            
                        ];
                 $this->db->set('student_id', '(select coalesce(max(student_id),0) + 1 from student)', false);
                $student = $this->db->insert('student',$arrdata);

                if($student){
                    $this->response(['status' => true,
                            'action' => $action,
                            'data' => 'OK, Data Inserted.'
                    ], REST_Controller::HTTP_OK );
                }else{
                    $this->response(['status' => false,
                            'action' => $action,
                            'data' => 'Bad Request'
                    ], REST_Controller::HTTP_BAD_REQUEST );
                }
            }
            else if ($action == 'UP'){
                $arrdata = ['majors_id2' => $this->post('majors_id2'),
                            'update_date' => 'now()',
                            'update_by' => 'Admin'
                            
                ];
                $student = $this->db->update('student',$arrdata,['student_id' => $this->input->post('student_id')]);
                    if($student){
                        $this->response(['status' => true,
                                'action' => $action,
                                'data' => 'OK, Data Updated.'
                        ], REST_Controller::HTTP_OK );
                    }else{
                        $this->response(['status' => false,
                                'action' => $action,
                                'data' => 'Bad Request'
                        ], REST_Controller::HTTP_BAD_REQUEST );
                    }
               
                
            } else if($action == 'DL'){
                // DL : Delete
                $majors_id2 = $this->post('majors_id2');
                $id = $this->post('student_id');
                #var_dump( $id); die;
                if ($majors_id2 == '' || $id == '') {
                    $this->response(['status' => false,
                    'data' => 'key missed'
                    ], REST_Controller::HTTP_BAD_REQUEST );
                } else {
                    $this->db->where('majors_id2', $majors_id2);
                    $this->db->where('student_id', $id);
                    $student = $this->db->delete('student');
                }
        
                if($student){
                    $this->response(['status' => true,
                            'data' => 'Data Deleted',
                            'action' => $action
                    ], REST_Controller::HTTP_OK );
                }else{
                    $this->response(['status' => false,
                    'data' => 'data not found'
                     ], REST_Controller::HTTP_NOT_FOUND );
                }    
            }else{
                $this->response(['status' => false,
                'data' => 'Bad Request',
                'action' => $action
                ], REST_Controller::HTTP_BAD_REQUEST );
            }

        }
    }

}
?>
