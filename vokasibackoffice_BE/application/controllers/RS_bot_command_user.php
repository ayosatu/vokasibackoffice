<?php
require APPPATH . 'libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

class RS_bot_command_user extends REST_Controller
{
    function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->database();
    }
    
    function index_post()
    {   
            $action = $this->input->post('action');
            $id = $this->input->post('bot_com_user_id');
            $valid_from = $this->input->post('valid_from');
            $valid_until = $this->input->post('valid_until');
            $adm_user = $this->input->post('admin');
            $bot_command_id = ($this->input->post('bot_command_id') == NULL) ? NULL : $this->input->post('candidate_id') ;
            $user_id = ($this->input->post('user_id') == NULL) ? NULL : $this->input->post('user_id') ;
           

                $sql = " select * from f_crud_bot_command_user
                (
                    '" . $action . "',
                    $id,
                    '" . $bot_command_id . "',
                    '" . $user_id . "',
                    '" . $valid_from . "',
                    '" . $valid_until . "',
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