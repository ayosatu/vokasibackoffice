<?php 

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class RS_ins_unit extends REST_Controller {

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
                    $ins_unit = $this->db->get('ins_unit')->result_array();
                }else {
                    var_dump($keword);
                    // die;
                    $this->db->like('upper(name)', strtoupper($keword));
                    $this->db->or_like('upper(since_period)', strtoupper($keword));
                    $this->db->or_like('upper(npwp)', strtoupper($keword));
                    $this->db->or_like('upper(no_permit)', strtoupper($keword));
                    $this->db->or_like('upper(created_by)', strtoupper($keword));
                    $this->db->or_like('upper(no_tlp)', strtoupper($keword));
                    $this->db->or_like('upper(no_hp)', strtoupper($keword));
                    $this->db->or_like('upper(email)', strtoupper($keword));
                    $this->db->or_like('upper(address)', strtoupper($keword));
                    $ins_unit = $this->db->get('ins_unit')->result_array();
                }

                if($ins_unit){
                    $this->response(['status' => true,
                            'action' => $action,
                            'keyword' => $keword,
                            'data' => $ins_unit
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
                $arrdata = ['ins_id' => $this->post('ins_id'),
                            'ins_unit_type_id' => $this->post('ins_unit_type_id'),
                            'name' => $this->post('name'),
                            'since_period' => $this->post('since_period'),
                            'npwp' => $this->post('npwp'),
                            'no_permit' => $this->post('no_permit'),
                            'img_path' => $this->post('img_path'),
                            'address' => $this->post('address'),
                            'no_tlp' => $this->post('no_tlp'),
                            'no_hp' => $this->post('no_hp'),
                            'email' => $this->post('email'),
                            'created_date' => 'now()',
                            'update_date' => 'now()',
                            'created_by' => 'Admin',
                            'update_by' => 'Admin'
                        ];
                 $this->db->set('ins_unit_id', '(select coalesce(max(ins_unit_id),0) + 1 from ins_unit)', false);
                $ins_unit = $this->db->insert('ins_unit',$arrdata);

                if($ins_unit){
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
                $arrdata = ['name' => $this->post('name'),
                            'img_path' => $this->post('img_path'),
                            'no_permit' => $this->post('no_permit'),
                            'no_tlp' => $this->post('no_tlp'),
                            'no_hp' => $this->post('no_hp'),
                            'email' => $this->post('email'),
                            'no_hp' => $this->post('no_hp'),
                            'address' => $this->post('address'),
                            'update_date' => 'now()',
                            'update_by' => 'Admin'
                ];
                $ins_unit = $this->db->update('ins_unit',$arrdata,['ins_unit_id' => $this->input->post('ins_unit_id')]);
                    if($ins_unit){
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
                $name = $this->post('name');
                #var_dump( $id); die;
                if ($name == '' || $id == '') {
                    $this->response(['status' => false,
                    'data' => 'key missed'
                    ], REST_Controller::HTTP_BAD_REQUEST );
                } else {
                    $this->db->where('name', $name);
                    $ins_unit = $this->db->delete('ins_unit');
                }
        
                if($ins_unit){
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
