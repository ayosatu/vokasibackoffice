<?php

/**********
 * Orignal Author : https://cintaprogramming.com
 * Author : Pratama. R
 * Function : Telegram Bot - MATIC PRO, PT. Telkom Indonesia
 * 
 * ************/

include("token.php");
include("commandrun.php");

//request url
function request_url($method)
{
	global $TOKEN;
	return "https://api.telegram.org/bot" . $TOKEN . "/". $method;
}

// send message chat id
function send_message($chatid, $text,$msgid)
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
    // print_r($result);
}


//call send message
function callsendmessage(){
    if (isset($_GET['chatid']) && isset($_GET['textmsg']) && isset($_GET['messageid']) ) {
        if (empty($_GET['chatid']) && empty($_GET['textmsg']) && empty($_GET['messageid']) ) {
            echo "Complete your chatid / text !";
        } else { 
            $chatid = $_GET['chatid'];
            $text = $_GET['textmsg'];
            $msgid = $_GET['messageid'];
            //call send message
            send_message($chatid, $text,$msgid);
        }
    }else{
        echo "Excp, Complete your chatid / text !";
    }
}

// execute function
callsendmessage();

?>