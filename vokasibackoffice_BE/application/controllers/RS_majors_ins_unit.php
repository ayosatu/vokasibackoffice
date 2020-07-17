<?php 

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class RS_majors_ins_unit extends REST_Controller {

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
                    $majors_ins_unit = $this->db->get('majors_ins_unit')->result_array();
                }else {
                    var_dump($keword);
                    // die;
                    # ins_unit_id...
                    $this->db->where('majors_id2',$keword);
                    $this->db->like('majors_id', strtoupper($keword));
                    $this->db->or_like('ins_unit_id', strtoupper($keword));
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
                $arrdata = ['majors_id' => $this->post('majors_id'),
                            'ins_unit_id' => $this->post('ins_unit_id'),
                            'created_date' => 'now()',
                            'created_by' => 'Admin',
                            'update_date' => 'now()',
                            'update_by' => 'Admin'
                        ];
                 $this->db->set('majors_id2', '(select coalesce(max(majors_id2),0) + 1 from majors_ins_unit)', false);
                $majors_ins_unit = $this->db->insert('majors_ins_unit',$arrdata);

                if($majors_ins_unit){
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
                $arrdata = ['majors_id' => $this->post('majors_id'),
                            'update_date' => 'now()',
                            'update_by' => 'Admin'
                            
                ];
                $majors_ins_unit = $this->db->update('majors_ins_unit',$arrdata,['majors_id2' => $this->input->post('majors_id2')]);
                    if($majors_ins_unit){
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
                $majors_id = $this->post('majors_id');
                $id = $this->post('majors_id2');
                #var_dump( $id); die;
                if ($majors_id == '' || $id == '') {
                    $this->response(['status' => false,
                    'data' => 'key missed'
                    ], REST_Controller::HTTP_BAD_REQUEST );
                } else {
                    $this->db->where('majors_id', $majors_id);
                    $this->db->where('majors_id2', $id);
                    $majors_ins_unit = $this->db->delete('majors_ins_unit');
                }
        
                if($majors_ins_unit){
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
