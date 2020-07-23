<?php
require APPPATH . 'libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

class RS_emp_doccument_list extends REST_Controller
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
            $id = $this->input->post('emp_doc_list_id2');
            $path = $this->input->post('path');
            $code = $this->input->post('code');
            $description = $this->input->post('description');
            $created_date = now();
            $adm_user = $this->input->post('admin');
            $emp_id = ($this->input->post('emp_id') == NULL) ? NULL : $this->input->post('emp_id') ;
           

                $sql = " select * from f_crud_bot_command_user
                (
                    '" . $action . "',
                    $id,
                    $emp_id,
                    '" . $path . "',
                    '" . $created_date . "',
                    '" . $created_date . "',
                    '" . $adm_user . "',
                    '" . $adm_user . "',
                    '" . $code . "',
                    '" . $description . "'
                ); ";
                $data = $this->db->query($sql)->row_array();
                $this->response([
                    'status' => $data['oint_res'],
                    'message' => $data['ostr_msg']
                ], REST_Controller::HTTP_OK);
            
                
    }
}
?>