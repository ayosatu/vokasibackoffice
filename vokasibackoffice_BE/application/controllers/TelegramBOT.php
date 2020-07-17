<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TelegramBOT extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    public function __construct()
    {
        parent::__construct();
        /*to hide warning message*/
        error_reporting(0);
        ini_set('display_errors', 0);
    }

    public function index()
    {
        // 
    }

    /*send message to telegram*/
    public function sendMessageTelegram(){
        $chatid = $this->input->post('chat_id', true);
        $message = $this->input->post('message', true);
        $token = $this->input->post('token', true);
        
        try {
            
            /*Config data query*/
            $data = [
                'text' =>  $message,
                'chat_id' => $chatid
            ];


             $execfgc = file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data) );
             if(!$execfgc)
              {
                 throw new Exception( 'Something really gone wrong');  
              }else{

                echo json_encode(array('success' => true, 'msg' => 'Chat Has been send'));
              }

            } catch (Exception $e) {
                echo json_encode(array('success' => false, 
                                        'msg' => 'Chat fail to send')

                                    );
            }  
    }

    /*Get list Message that have been sent to the bot*/
    public function getUpdateMessage(){

         $token = $this->input->post('token', true);

        $execfgc = file_get_contents("https://api.telegram.org/bot$token/getUpdates");

        try {
         
         if(!$execfgc)
          {
             throw new Exception( 'Something really gone wrong');  
          }else{

             echo $execfgc;
            // echo json_encode($execfgc);
          }

        } catch (Exception $e) {
            echo json_encode(array('success' => false, 'msg' => 'Chat fail to send'));
        }  
    }
}
