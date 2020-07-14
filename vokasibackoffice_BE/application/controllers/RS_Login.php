<?php 

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class RS_Login extends REST_Controller {
    
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
            if ($action == 'Login') {
                $username = $this->post('user_name');
                $password = $this->post('user_password');
                $data = ['user_name' => $username];
                $users = $this->db->get_where('users',$data)->row_array();
                
                if ($users == null) {
                    $this->response(['status' => false, 'data' => 'Not Found']);
                }else{
                    if ($password == $users['user_password']) {
                        $this->response(['status' => true,'data'=> $users]);
                    }
                }
            }
        }
    }
}
?>
