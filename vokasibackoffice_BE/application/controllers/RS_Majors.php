<?php 

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class RS_majors extends REST_Controller {

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
                    $majors = $this->db->get('majors')->result_array();
                }else {
                    var_dump($keword);
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
                            'data' => $majors
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
                            'created_date' => 'now()',
                            'created_by' => 'Admin',
                            'update_date' => 'now()',
                            'update_by' => 'Admin',
                            'code' => $this->post('code'),
                            'description' => $this->post('description')
                        ];
                 $this->db->set('majors_id', '(select coalesce(max(majors_id),0) + 1 from majors)', false);
                $majors = $this->db->insert('majors',$arrdata);

                if($majors){
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
                $arrdata = [
                            'code' => $this->post('code'),
                            'description' => $this->post('description')
                            
                ];
                $majors = $this->db->update('majors',$arrdata,['majors_id' => $this->input->post('majors_id')]);
                    if($majors){
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
                $code = $this->post('code');
                $id = $this->post('majors_id');
                #var_dump( $id); die;
                if ($code == '' || $id == '') {
                    $this->response(['status' => false,
                    'data' => 'key missed'
                    ], REST_Controller::HTTP_BAD_REQUEST );
                } else {
                    $this->db->where('code', $code);
                    $this->db->where('majors_id', $id);
                    $majors = $this->db->delete('majors');
                }
        
                if($majors){
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
