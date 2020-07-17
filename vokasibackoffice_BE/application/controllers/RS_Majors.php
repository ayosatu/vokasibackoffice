<?php 
session_start();
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class RS_majors extends REST_Controller {

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
            'data' => 'Bad Request'
            ], REST_Controller::HTTP_BAD_REQUEST );
        }else{
            //QR : Query, IN : Insert , DL : Delete, UP : Update
            if($action == 'QR'){
                $keword = $this->input->post('keyword');
                if($keword == ''){
                    $majors = $this->db->get('majors')->result_array();
                }else {
                   // var_dump($keword);
                    // die;
                    # since_period...
                    $this->db->where('majors_id',$keword);
                    $this->db->or_like('upper(created_by)', strtoupper($keword));
                    $this->db->or_like('upper(code)', strtoupper($keword));
                    $this->db->or_like('upper(description)', strtoupper($keword));
                    $majors = $this->db->get('majors')->result_array();
                }

                if($majors){
                    $this->response(['status' => true,
                            'action' => $action,
                            'keyword' => $keword,
                            'Message' => $majors
                    ], REST_Controller::HTTP_OK );
                }else{
                    $this->response(['status' => false,
                            'action' => $action,
                            'Message' => 'data not found'
                    ], REST_Controller::HTTP_NOT_FOUND );
                }
            // action QR
            } 
            //IN : insert 
            else if($action == 'IN'){
                $code = $this->post('code');
                $description = $this->post('description');

                $sql = " select * from f_crud_majors " . 
                        "( 'I' , NULL , "."'$code'," . "'$description',"."'". $_SESSION['user_name']."')";
                
                $majors = $this->db->query($sql)->row_array();
                if($majors){
                    $this->response(['status' => true,
                            'action' => $action,
                            'Message' => $majors['ostr_msg']
                    ], REST_Controller::HTTP_OK );
                }else{
                    $this->response(['status' => false,
                            'action' => $action,
                            'Message' => $majors['ostr_msg']
                    ], REST_Controller::HTTP_BAD_REQUEST );
                }
            }
            else if ($action == 'UP'){
                $id = $this->post('majors_id');
                $code = $this->post('code');
                $description = $this->post('description');

                $sql = " select * from f_crud_majors " . 
                        "( 'U' , "."$id,"."'$code',". "'$description',"."'". $_SESSION['user_name']."')";

                $majors = $this->db->query($sql)->row_array();
                if($majors){
                    $this->response(['status' => true,
                            'action' => $action,
                            'Message' => $majors['ostr_msg']
                    ], REST_Controller::HTTP_OK );
                }else{
                    $this->response(['status' => false,
                            'action' => $action,
                            'Message' => $majors['ostr_msg']
                    ], REST_Controller::HTTP_BAD_REQUEST );
                }
                
            } else if($action == 'DL'){
                $id = $this->post('majors_id');

                $sql = " select * from f_crud_majors " . 
                        "( 'D' , "."$id,NULL,NULL,NULL)";
                $majors = $this->db->query($sql)->row_array();
                if($majors){
                    $this->response(['status' => true,
                            'action' => $action,
                            'Message' => $majors['ostr_msg']
                    ], REST_Controller::HTTP_OK );
                }else{
                    $this->response(['status' => false,
                            'action' => $action,
                            'Message' => $majors['ostr_msg']
                    ], REST_Controller::HTTP_BAD_REQUEST );
                }
            }else{
                $this->response(['status' => false,
                'data' => 'Bad Request',
                'action' => 'Not Have Action'
                ], REST_Controller::HTTP_BAD_REQUEST );
            }

        }
    }

}
?>
