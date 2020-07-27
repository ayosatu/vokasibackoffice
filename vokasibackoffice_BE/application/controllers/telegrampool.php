<?php
defined('BASEPATH') or exit('No direct script access allowed');

class commandrun extends CI_Controller
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
        $this->load->model('commandrun', 'commandrun');
        // 
    }
    function request_url($method)
    {
        global $TOKEN;
        return "https://api.telegram.org/bot" . $TOKEN . "/". $method;
    }

    function get_updates($offset) 
    {
        $url = request_url("getUpdates")."?offset=".$offset;
            $resp = file_get_contents($url);
            $result = json_decode($resp, true);
            if ($result["ok"]==1)
                return $result["result"];
            return array();
    }

    function send_reply($chatid, $msgid, $text)
    {
        // echo request_url("getUpdates");
        $data = array(
            'chat_id' => $chatid,
            'text'  => $text,
            'reply_to_message_id' => $msgid
        );
        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context  = stream_context_create($options);

        $result = file_get_contents(request_url('sendMessage')."?parse_mode=markdown", false, $context);
        print_r($result);
    }

    //get message id 
    function getmessageid($chatid){
        return "This is your chat id : *".$chatid."*";
    }

    /*Execute message info MPRO*/
    function messagecommanmpro($cmd,$message_id, $chatid, $updateid){
        if (strpos($cmd, '/') === 0) {
            //custom command : registermpro($chatid,$text);
            $str = explode(" ",$cmd);
        
                //if($str[0]== "/mprobotreg"){
                //   return registermpro($chatid,$cmd);
                //}
                
            if ($str[0]== "/chekjobstatus"){
                return chekjobstatus($str[1]);
                }
                else{
                return customcommand($chatid, $message_id, $cmd);
                }
            
        }else{
            return "Please, Start comments with the following sign '/'";  
        }   
    }

    //send help info
    function sendhelpinfo(){
        return "Before you acces command BOTPRO, you must register the chat-id first, for more information, you can contact the administrator";
    }

    // send about info
    function sendabout(){
        return "BOT Telegram MATIC PRO @2019, PT Telkom Indonesia";
    }

    /*Create message respon reply*/
    function create_response($text,$message_id, $chatid, $updateid)
    {
        //clear command bot
        $text =  str_replace( '@maticprotelkomBot', '', $text);
        switch($text) {
        case "/start":
                return "*Wellcome to MaticPro BOT Telegram, Enjoy :)*";
                break;
            case "/whoiam":
                return getmessageid($chatid);
                break;
            case "/help":
                return sendhelpinfo();
                break;
            case "/about":
                return sendabout();
                break;
            case "/listchannel":
                return requestlistchannel($chatid);
                break; 
            case "/listcommand":
                return listcommanduser($chatid);
                break;
            default: 
                return messagecommanmpro($text,$message_id, $chatid, $updateid);
        }
    }


    function process_message($message)
    {
        $updateid = $message["update_id"];
        $message_data = $message["message"];
        if (isset($message_data["text"])) {
        $chatid = $message_data["chat"]["id"];
            $message_id = $message_data["message_id"];
            $text = $message_data["text"];
            $response = create_response($text,$message_id, $chatid, $updateid);
            send_reply($chatid, $message_id, $response);
        }
        return $updateid;
    }


    function process_one()
    {
        $update_id  = 0;

        if (file_exists("last_update_id")) {
            $update_id = (int)file_get_contents("last_update_id");
        }

        $updates = get_updates($update_id);

        foreach ($updates as $message)
        {
                $update_id = process_message($message);
        }
        file_put_contents("last_update_id", $update_id + 1);

    }

    while (true) {
        process_one();
    }
}
