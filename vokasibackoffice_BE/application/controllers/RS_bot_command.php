<?php
require APPPATH . 'libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

class RS_bot_command extends REST_Controller
{
    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
    }
    
    function index_post()
    {   
            $action = $this->input->post('action');
            $id = $this->input->post('bot_command_id');
            $command = $this->input->post('command');
            $description = $this->input->post('description');
            $title = $this->input->post('title');
            $is_param = $this->input->post('is_param');
            $store_proc = $this->input->post('store_proc');
            $adm_user = $this->input->post('admin');

                $sql = " select * from f_crud_bot_command
                (
                    '" . $action . "',
                    $id,
                    '" . $command . "',
                    '" . $description . "',
                    '" . $title . "',
                    '" . $is_param . "',
                    '" . $store_proc . "',
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