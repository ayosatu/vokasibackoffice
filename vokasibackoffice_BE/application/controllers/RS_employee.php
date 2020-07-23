<?php
require APPPATH . 'libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

class RS_employee extends REST_Controller
{
    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
    }
    
    function index_post()
    {     
        $config['upload_path'] = './assets/img/';
		$config['allowed_types'] = 'gif|jpg|png';
		//$config['max_width'] = 1024;
		//$config['max_height'] = 768;
		//$config['maks_size'] = 100;
		$config['overwrite'] = true;
		$filename = null;

		$this->load->Library('upload', $config);

		if ( $this->upload->do_upload('img_path')){
			$dataupload = $this->upload->data();
			 $filename = 'assets/img/'.$dataupload['file_name'];
			
		}

            $action = $this->input->post('action');
            $id = $this->input->post('emp_id');
            $name = $this->input->post('name');
            $nik = $this->input->post('nik');
            $filename = $this->input->post('img_path');
            $email = $this->input->post('email');
            $no_hp = $this->input->post('no_hp');
            $no_tlp = $this->input->post('no_tlp');
            $npwp = $this->input->post('npwp');
            $is_owner = $this->input->post('is_owner');
            $postal_code = $this->input->post('postal_code');
            $birth_date = $this->input->post('birth_date');
            $address = $this->input->post('address');
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $birth_place = $this->input->post('birth_place');
            $emp_code = $this->input->post('emp_code');
            $created_date = now();
            $adm_user = $this->input->post('admin');
            $ins_unit_id = ($this->input->post('ins_unit_id') == NULL) ? NULL : $this->input->post('ins_unit_id') ;
            $religion_id = ($this->input->post('religion_id') == NULL) ? NULL : $this->input->post('religion_id') ;
            $gender_id = ($this->input->post('gender_id') == NULL) ? NULL : $this->input->post('gender_id') ;
           

                $sql = " select * from f_crud_employee
                (
                    '" . $action . "',
                    $id,
                    $ins_unit_id,
                    '" . $name . "',
                    '" . $nik . "',
                    '" . $filename . "',
                    '" . $email . "',
                    '" . $no_hp . "',
                    '" . $no_tlp . "',
                    '" . $npwp . "',
                    '" . $is_owner . "',
                    '" . $created_date . "',
                    '" . $created_date . "',
                    '" . $adm_user . "',
                    '" . $adm_user . "',
                    $religion_id,
                    '" . $birth_date . "',
                    '" . $postal_code . "',
                    '" . $address . "',
                    '" . $start_date . "',
                    '" . $end_date . "',
                    '" . $birth_place . "',
                    $gender_id,
                    '" . $emp_code . "'
                ); ";
                $data = $this->db->query($sql)->row_array();
                $this->response([
                    'status' => $data['oint_res'],
                    'message' => $data['ostr_msg']
                ], REST_Controller::HTTP_OK);
            
                
    }
}
?>