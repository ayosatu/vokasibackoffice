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
        $_SESSION['user_name'] = 'Admin';
        $action = $this->input->post('action', true);

        if($action == '' || $action == NULL || $action == ""){
            $this->response(['status' => false,
            'data' => 'Not Have Action'
            ], REST_Controller::HTTP_BAD_REQUEST );
        }else{
            //QR : Query, IN : Insert , DL : Delete, UP : Update
            if($action == 'QR'){
                $keword = $this->input->post('keyword');
                if($keword == ''){
                    $majors_ins_unit = $this->db->get('majors_ins_unit')->result_array();
                }else {
                   // var_dump($keword);
                    // die;
                    # ins_unit_id...
                    $this->db->where('majors_id2',$keword);
                    $this->db->where('majors_id',$keword);
                    $this->db->where('ins_unit_id',$keword);
                    $this->db->or_like('upper(created_by)', strtoupper($keword));
                    $majors_ins_unit = $this->db->get('majors_ins_unit')->result_array();
                }

                if($majors_ins_unit){
                    $this->response(['status' => true,
                            'action' => $action,
                            'keyword' => $keword,
                            'data' => $majors_ins_unit
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
                $majors_id = $this->post('majors_id');
                $ins_unit_id = $this->post('ins_unit_id');
                
                $sql = "select * from f_crud_majors_ins_unit " . 
                        "('I', NULL,"."$majors_id,$ins_unit_id,"."'".$_SESSION['user_name']."')";
                $majors_ins_unit = $this->db->query($sql)->row_array();

                if($majors_ins_unit){
                    $this->response(['status' => true,
                            'action' => $action,
                            'Message' => $majors_ins_unit['ostr_msg']
                    ], REST_Controller::HTTP_OK );
                }else{
                    $this->response(['status' => false,
                            'action' => $action,
                            'Message' => $majors_ins_unit['ostr_msg']
                    ], REST_Controller::HTTP_BAD_REQUEST );
                }
            }
            else if ($action == 'UP'){
                $majors_id2 = $this->post('majors_id2');
                $majors_id = $this->post('majors_id');
                $ins_unit_id = $this->post('ins_unit_id');
                
                $sql = "select * from f_crud_majors_ins_unit " . 
                        "('U',"."$majors_id2".","."$majors_id,$ins_unit_id,"."'".$_SESSION['user_name']."')";
                $majors_ins_unit = $this->db->query($sql)->row_array();

                if($majors_ins_unit){
                    $this->response(['status' => true,
                            'action' => $action,
                            'Message' => $majors_ins_unit['ostr_msg']
                    ], REST_Controller::HTTP_OK );
                }else{
                    $this->response(['status' => false,
                            'action' => $action,
                            'Message' => $majors_ins_unit['ostr_msg']
                    ], REST_Controller::HTTP_BAD_REQUEST );
                }
                
            } else if($action == 'DL'){
                $majors_id2 = $this->post('majors_id2');
                
                $sql = "select * from f_crud_majors_ins_unit " . 
                        "'D',NULL,NULL,NULL,NULL)";
                $majors_ins_unit = $this->db->query($sql)->row_array();

                if($majors_ins_unit){
                    $this->response(['status' => true,
                            'action' => $action,
                            'Message' => $majors_ins_unit['ostr_msg']
                    ], REST_Controller::HTTP_OK );
                }else{
                    $this->response(['status' => false,
                            'action' => $action,
                            'Message' => $majors_ins_unit['ostr_msg']
                    ], REST_Controller::HTTP_BAD_REQUEST );
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
