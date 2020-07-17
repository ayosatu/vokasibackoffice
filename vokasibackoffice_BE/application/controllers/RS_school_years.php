<?php 

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class RS_school_years extends REST_Controller {

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
                    $school_years = $this->db->get('school_years')->result_array();
                }else {
                    var_dump($keword);
                    // die;
                    # description...
                    $this->db->where('sch_years_id',$keword);
                    $this->db->like('upper(code)', strtoupper($keword));
                    $this->db->or_like('upper(description)', strtoupper($keword));
                    $this->db->or_like('upper(created_by)', strtoupper($keword));
                    $this->db->or_like('upper(end_period)', strtoupper($keword));
                    $this->db->or_like('upper(result_id)', strtoupper($keword));
                    $this->db->or_like('upper(start_period)', strtoupper($keword));
                    $school_years = $this->db->get('school_years')->result_array();
                }

                if($school_years){
                    $this->response(['status' => true,
                            'action' => $action,
                            'keyword' => $keword,
                            'data' => $school_years
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
                            'description' => $this->post('description'),
                            'created_date' => 'now()',
                            'update_date' => 'now()',
                            'created_by' => 'Admin',
                            'update_by' => 'Admin',
                            'end_period' => $this->post('end_period'),
                            'result_id' => $this->post('result_id'),
                            'start_period' => $this->post('start_period')
                        ];
                 $this->db->set('sch_years_id', '(select coalesce(max(sch_years_id),0) + 1 from school_years)', false);
                $school_years = $this->db->insert('school_years',$arrdata);

                if($school_years){
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
                $arrdata = ['code' => $this->post('code'),
                            'update_date' => 'now()',
                            'update_by' => 'Admin'
                            
                ];
                $school_years = $this->db->update('school_years',$arrdata,['sch_years_id' => $this->input->post('sch_years_id')]);
                    if($school_years){
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
                $id = $this->post('sch_years_id');
                #var_dump( $id); die;
                if ($code == '' || $id == '') {
                    $this->response(['status' => false,
                    'data' => 'key missed'
                    ], REST_Controller::HTTP_BAD_REQUEST );
                } else {
                    $this->db->where('code', $code);
                    $this->db->where('sch_years_id', $id);
                    $school_years = $this->db->delete('school_years');
                }
        
                if($school_years){
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
