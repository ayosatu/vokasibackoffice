<?php 
session_start();
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class RS_ins_unit extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //insert data pasiens
    function index_post(){
                //$user_name=$this->session->userdata('user_name');

                $action = $this->input->post('action', true);
                $ins_unit_id = ($this->post('ins_unit_id') == NULL) ? NULL : $this->post('ins_unit_id');
                $ins_id = ($this->post('ins_id') == NULL) ? NULL : $this->post('ins_id');
                $ins_unit_type_id = ($this->post('ins_unit_type_id') == NULL) ? NULL : $this->post('ins_unit_type_id');;
                $name = ($this->post('name') == NULL) ? NULL : $this->post('name');
                $period = ($this->post('since_period') == NULL) ? NULL : $this->post('since_period');
                // die(var_dump($this->post('f_date')));
                $npwp = ($this->post('npwp') == NULL) ? NULL : $this->post('npwp');
                $no_permit = ($this->post('no_permit') == NULL) ? NULL : $this->post('no_permit');
                $img_path = ($this->post('img_path') == NULL) ? NULL : $this->post('img_path');
                $address = ($this->post('address') == NULL) ? NULL : $this->post('address');
                $no_tlp = ($this->post('no_tlp') == NULL) ? NULL : $this->post('no_tlp');
                $email = ($this->post('email') == NULL) ? NULL : $this->post('email');
                $no_hp = ($this->post('no_hp') == NULL) ? NULL : $this->post('no_hp');
                $user_name = ($this->post('user_name') == NULL) ? NULL : $this->post('user_name');

                $sql = "select * from f_crud_ins_unit ".
                        "('".$action."',  $ins_id ,"."'$name',"."'$period',"."'$f_date',"."'$npwp',"."'$no_permit',".
                        "'$img_path',"."'$no_tlp',"."'$no_fax',"."'$email',"."'$no_hp',"."'$address',"."'". $user_name."')";
               
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

}
?>
