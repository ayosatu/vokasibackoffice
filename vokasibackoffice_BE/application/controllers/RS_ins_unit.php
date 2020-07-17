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
                $ins_id = $this->post('ins_id');
                $ins_unit_type_id = $this->post('ins_type_id');
                $name = $this->post('name');
                $period = $this->post('since_period');
                $npwp = $this->post('npwp');
                $no_permit = $this->post('no_permit');
                $img_path = $this->post('img_path');
                $address = $this->post('address');
                $no_tlp = $this->post('no_tlp');
                $no_hp = $this->post('no_hp');
                $email = $this->post('email');

                $sql = "select * from f_crud_ins_unit ".
                        "('I',  NULL ,"."'$name',"."'$period',"."'$f_date',"."'$npwp',"."'$no_permit',".
                        "'$img_path',"."'$no_tlp',"."'$no_fax',"."'$email',"."'$no_hp',"."'$address',"."'". $_SESSION['user_name']."')";
               
                $institution = $this->db->query($sql)->row_array();
                if($institution){
                    $this->response(['status' => true,
                            'action' => $action,
                            'data' => $institution['ostr_msg']
                    ], REST_Controller::HTTP_OK );
                }else{
                    $this->response(['status' => false,
                            'action' => $action,
                            'data' => $institution['ostr_msg']
                    ], REST_Controller::HTTP_BAD_REQUEST );
                }
            }
            else if ($action == 'UP'){
                $id = $this->post('ins_id');
                $name = $this->post('name');
                $img_path = $this->post('img_path');
                $no_tlp = $this->post('no_tlp');
                $no_fax = $this->post('no_fax');
                $email = $this->post('email');
                $no_hp = $this->post('no_hp');
                $address = $this->post('address');
                
                $sql = "select * from f_crud_institution ".
                        "('U',"."$id,"."'$name',"."NULL,NULL,NULL,NULL,".
                        "'$img_path',"."'$no_tlp',"."'$no_fax',"."'$email',"."'$no_hp',"."'$address',"."'". $_SESSION['user_name']."')";

                $institution = $this->db->query($sql)->row_array();
                    if($institution){
                        $this->response(['status' => true,
                                'action' => $action,
                                'data' => $institution['ostr_msg']
                        ], REST_Controller::HTTP_OK );
                    }else{
                        $this->response(['status' => false,
                                'action' => $action,
                                'data' => $institution['ostr_msg']
                        ], REST_Controller::HTTP_BAD_REQUEST );
                    }
               
                
            } else if($action == 'DL'){
                $id = $this->post('ins_id');

                $sql = "select * from f_crud_institution ".
                        "('D',"."$id,"."NULL,NULL,NULL,NULL,NULL,".
                        "NULL,NULL,NULL,NULL,NULL,NULL,NULL)";

                $institution = $this->db->query($sql)->row_array();

                if($institution){
                    $this->response(['status' => true,
                            'data' => 'Data Deleted',
                            'action' => $institution['ostr_msg']
                    ], REST_Controller::HTTP_OK );
                }else{
                    $this->response(['status' => false,
                    'data' => $institution['ostr_msg']
                     ], REST_Controller::HTTP_NOT_FOUND );
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