<?php
require APPPATH . 'libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

class RS_emp_details extends REST_Controller
{
    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
    }
    
    function index_post()
    {   
            $action = $this->input->post('action');
            $id = $this->input->post('emp_details_id');
            $valid_from = $this->input->post('valid_from');
            $valid_until = $this->input->post('valid_until');
            $created_date = now();
            $adm_user = $this->input->post('admin');
            $position_id = ($this->input->post('position_id') == NULL) ? NULL : $this->input->post('position_id') ;
            $emp_id = ($this->input->post('emp_id') == NULL) ? NULL : $this->input->post('emp_id') ;
    
                $sql = " select * from f_crud_emp_details
                (
                    '" . $action . "',
                    $id,
                    $ins_unit_id,
                    $position_id,
                    $emp_id,
                    '" . $valid_from . "',
                    '" . $valid_until . "',
                    '" . $created_date . "',
                    '" . $created_date . "',
                    '" . $adm_user . "',
                    '" . $adm_user . "'
                ); ";
                $data = $this->db->query($sql)->row_array();
                $this->response([
                    'status' => $data['oint_res'],
                    'message' => $data['ostr_msg']
                ], REST_Controller::HTTP_OK);
            
                
    }
}
?>