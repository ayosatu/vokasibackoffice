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
        $username = $this->input->post('user_name');

        if($action == '' || $action == NULL || $action == ""){
            $this->response(['status' => false,
            'data' => 'Bad Request'
            ], REST_Controller::HTTP_BAD_REQUEST );
        }else{  
            if ($action == 'getOTP') {
                $data = ['user_name' => $username];
                $users = $this->db->get_where('users',$data)->row_array();
                
                if ($users == null) {
                    $this->response(['status' => false, 'data' => 'Not Found']);
                }else{
                    // $session_user = ['user_name',$username];
                    // $this->session->set_userdata($session_user);
                    $this->sendMessageTelegram($users['chat_id']);
                }
            }else if($action == 'Login'){
                $password = $this->input->post('user_password');
                $otp = $this->input->post('otp_val');

                $data = [
                    'user_name' => $username,
                    'otp_val' => $otp
                ];
                $user = $this->db->get_where('users',$data)->row_array();
                if ($user == null) {
                    $this->response(['status' => false, 'data' => 'Not Found']);
                }else{
                    if ($password == $user['user_password']) {
                        $this->response(['status' => true,'data'=> 'success']);
                    }else{
                        $this->response(['status' => false, 'data' => 'Wrong Password']);
                    }
                }
            }
        }
    }
    public function sendMessageTelegram($chat_id){
        $chatid = $chat_id; 
        $token = '1183864220:AAF8WVDIrIsnfXh7Fo-YO-8nWz6ABYcKv0o';
        $message = rand();
        $message2 = 'Your OTP Code is ' . $message;
        
        try {
            
            /*Config data query*/
            $data = [
                'text' =>  $message2,
                'chat_id' => $chatid
            ];


             $execfgc = file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data) );
             if(!$execfgc)
              {
                 throw new Exception( 'Something really gone wrong');  
              }else{
                echo json_encode(array('success' => true, 'msg' => 'Chat Has been send'));
                $this->db->query("UPDATE users 
                                         set otp_val = '$message' , 
                                         otp_date = 'now()'
                                         WHERE chat_id = '$chatid'");
              }

            } catch (Exception $e) {
                echo json_encode(array('success' => false, 
                                        'msg' => 'Chat fail to send')

                                    );
            }  
    }
}
?>
