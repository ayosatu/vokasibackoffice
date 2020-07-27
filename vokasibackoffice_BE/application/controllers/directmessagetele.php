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

// send message chat id
function send_message($chatid, $text)
{
    // echo request_url("getUpdates");
    $data = array(
        'chat_id' => $chatid,
        'text'  => $text
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
    // print_r($result);
}


//call send message
function callsendmessage(){
    if (isset($_GET['chatid']) && isset($_GET['textmsg'])) {
        if (empty($_GET['chatid']) && empty($_GET['textmsg']) ) {
            echo "Complete your chatid / text !";
        } else { 
            $chatid = $_GET['chatid'];
            $text = $_GET['textmsg'];
            //call send message
            send_message($chatid, $text);
        }
    }else{
        echo "Excp, Complete your chatid / text !";
    }
}

// execute function
callsendmessage();
}
