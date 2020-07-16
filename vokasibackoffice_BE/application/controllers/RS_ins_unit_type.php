<?php 

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class RS_ins_unit_type extends REST_Controller {

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
                    $ins_unit_type = $this->db->get('ins_unit_type')->result_array();
                }else {
                    var_dump($keword);
                    // die;
                    # since_period...
                    $this->db->where('ins_unit_type_id',$keword);
                    $this->db->like('upper(code)', strtoupper($keword));
                    $this->db->or_like('upper(description)', strtoupper($keword));
                    $ins_unit_type = $this->db->get('ins_unit_type')->result_array();
                }

                if($ins_unit_type){
                    $this->response(['status' => true,
                            'action' => $action,
                            'keyword' => $keword,
                            'data' => $ins_unit_type
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
                $arrdata = ['code' => $this->post('code'),
                            'created_date' => 'now()',
                            'update_date' => 'now()',
                            'created_by' => 'Admin',
                            'update_by' => 'Admin',
                            'description' => $this->post('description')
                        ];
                 $this->db->set('ins_unit_type_id', '(select coalesce(max(ins_unit_type_id),0) + 1 from ins_unit_type)', false);
                $ins_unit_type = $this->db->insert('ins_unit_type',$arrdata);

                if($ins_unit_type){
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
                $arrdata = ['update_date' => 'now()',
                            'update_by' => 'Admin',
                            'description' => $this->post('description')
                ];
                // $this->db->set('id_p', '(select coalesce(max(id_p),0) + 1 from pasiens)', false);
                $ins_unit_type = $this->db->update('ins_unit_type',$arrdata, ['code' => $this->input->post('code')]);

                if($ins_unit_type){
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
                #var_dump( $id); die;
                if ($code == '') {
                    $this->response(['status' => false,
                    'data' => 'key missed'
                    ], REST_Controller::HTTP_BAD_REQUEST );
                } else {
                    $this->db->where('code', $code);
                    $ins_unit_type = $this->db->delete('ins_unit_type');
                }
        
                if($ins_unit_type){
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
