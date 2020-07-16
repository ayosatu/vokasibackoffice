<?php 

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class RS_institution extends REST_Controller {

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
                    $institution = $this->db->get('institution')->result_array();
                }else {
                    var_dump($keword);
                    // die;
                    # since_period...
                    $this->db->where('ins_id',$keword);
                    $this->db->like('upper(name)', strtoupper($keword));
                    $this->db->or_like('upper(since_period)', strtoupper($keword));
                    $this->db->or_like('upper(npwp)', strtoupper($keword));
                    $this->db->or_like('upper(no_permit)', strtoupper($keword));
                    $this->db->or_like('upper(created_by)', strtoupper($keword));
                    $this->db->or_like('upper(no_tlp)', strtoupper($keword));
                    $this->db->or_like('upper(no_fax)', strtoupper($keword));
                    $this->db->or_like('upper(email)', strtoupper($keword));
                    $this->db->or_like('upper(address)', strtoupper($keword));
                    $this->db->or_like('f_date', $keword);
                    $institution = $this->db->get('institution')->result_array();
                }

                if($institution){
                    $this->response(['status' => true,
                            'action' => $action,
                            'keyword' => $keword,
                            'data' => $institution
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
                $arrdata = ['name' => $this->post('name'),
                            'since_period' => $this->post('since_period'),
                            'f_date' => $this->post('f_date'),
                            'npwp' => $this->post('npwp'),
                            'no_permit' => $this->post('no_permit'),
                            'img_path' => $this->post('img_path'),
                            'created_date' => 'now()',
                            'update_date' => 'now()',
                            'created_by' => 'Admin',
                            'update_by' => 'Admin',
                            'no_tlp' => $this->post('no_tlp'),
                            'no_fax' => $this->post('no_fax'),
                            'email' => $this->post('email'),
                            'no_hp' => $this->post('no_hp'),
                            'address' => $this->post('address')
                        ];
                 $this->db->set('ins_id', '(select coalesce(max(ins_id),0) + 1 from institution)', false);
                $institution = $this->db->insert('institution',$arrdata);

                if($institution){
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
                            'no_fax' => $this->post('no_fax'),
                            'email' => $this->post('email'),
                            'no_hp' => $this->post('no_hp'),
                            'address' => $this->post('address'),
                            'update_date' => 'now()',
                            'update_by' => 'Admin',
                            'f_date' => $this->post('f_date')
                ];
                $institution = $this->db->update('institution',$arrdata,['ins_id' => $this->input->post('ins_id')]);
                    if($institution){
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
                $id = $this->post('ins_id');
                #var_dump( $id); die;
                if ($name == '' || $id == '') {
                    $this->response(['status' => false,
                    'data' => 'key missed'
                    ], REST_Controller::HTTP_BAD_REQUEST );
                } else {
                    $this->db->where('name', $name);
                    $this->db->where('ins_id', $id);
                    $institution = $this->db->delete('institution');
                }
        
                if($institution){
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
