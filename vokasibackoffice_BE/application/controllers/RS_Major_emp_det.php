<?php 

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class RS_Major_emp_det extends REST_Controller {

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
                    $major_emp_det = $this->db->get('major_emp_det')->result_array();
                }else {
                    var_dump($keword);
                    // die;
                    # description...
                    $this->db->where('major_emp_det_id',$keword);
                    $this->db->like('emp_id', $kewor);
                    $this->db->or_like('majors_id2', $keword);
                    $this->db->or_like('valid_from', $keword);
                    $this->db->or_like('valid_until', $keword);
                    $this->db->or_like('upper(created_by)', $keword);
                    $major_emp_det = $this->db->get('major_emp_det')->result_array();
                }

                if($major_emp_det){
                    $this->response(['status' => true,
                            'action' => $action,
                            'keyword' => $keword,
                            'data' => $major_emp_det
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
                     'emp_id' => $this->post('emp_id'),
                            'majors_id2' => $this->post('majors_id2'),
                            'valid_from' => $this->post('valid_from'),
                            'valid_until' => $this->post('valid_until'),
                            'created_date' => 'now()',
                            'update_date' => 'now()',
                            'created_by' => 'Admin',
                            'update_by' => 'Admin'
                        ];
                 $this->db->set('major_emp_det_id', '(select coalesce(max(major_emp_det_id),0) + 1 from major_emp_det)', false);
                $major_emp_det = $this->db->insert('major_emp_det',$arrdata);

                if($major_emp_det){
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
                $major_emp_det = $this->db->update('major_emp_det',$arrdata,['major_emp_det_id' => $this->input->post('major_emp_det_id')]);
                    if($major_emp_det){
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
                $id = $this->post('major_emp_det_id');
                #var_dump( $id); die;
                if ($majors_id2 == '' || $id == '') {
                    $this->response(['status' => false,
                    'data' => 'key missed'
                    ], REST_Controller::HTTP_BAD_REQUEST );
                } else {
                    $this->db->where('majors_id2', $majors_id2);
                    $this->db->where('major_emp_det_id', $id);
                    $major_emp_det = $this->db->delete('major_emp_det');
                }
        
                if($major_emp_det){
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
