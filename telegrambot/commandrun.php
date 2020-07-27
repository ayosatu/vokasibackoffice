<?php

/**********
 * Orignal Author : Pratama. R
 * Author : Pratama. R
 * Function : Telegram Bot - MATIC PRO, PT. Telkom Indonesia
 * 
 * ************/

include("connection.php");

/*List Command User*/
function listcommanduser($chatid){
    $message = "" ;
    $o_msg =""; 
    try{
        /*Open Connection*/
        $conn = openconnection() ;
        //$conn = oci_connect('MG_BOT', 'MG_BOT', 'ORCL');
        if (!$conn) {
            $message = "Conection DB Error!, Please Check";
        }

        $sql = "BEGIN "
                . " prc_get_list_command("
                . " :i_chat_id, "
                . " :o_result,"
                . " :o_code"
                . "); END;";

        $stmt = oci_parse($conn, $sql);

        //  Bind the input parameter
        oci_bind_by_name($stmt, ':i_chat_id', $chatid);

        // Bind the output parameter
        oci_bind_by_name($stmt, ':o_result', $o_result, 2000000);
        oci_bind_by_name($stmt, ':o_code', $o_code, 2000000);

        ociexecute($stmt);

        //assign message
        $message = $o_result;

    }catch (Exception $e) {
        $message = $e->getMessage();
    }

    /*Close Connection*/
    closeconnection($conn , $stmt);
    // oci_free_statement($stmt);
    // oci_close($conn);

    return str_replace("\\n","\n",$message) ;
}

/*Register to Channel MPRO BOT*/
function requestlistchannel($chatid){
    $message = "" ;
    $o_msg =""; 
    try{
        /*Open Connection*/
        $conn = openconnection() ;
        // $conn = oci_connect('MG_BOT', 'MG_BOT', 'ORCL');
        if (!$conn) {
            $message = "Conection DB Error!, Please Check";
        }

        $sql = "BEGIN "
                . " PRC_GET_LIST_CHANNEL("
                . " :i_chat_id, "
                . " :o_result,"
                . " :o_code"
                . "); END;";

        $stmt = oci_parse($conn, $sql);

        //  Bind the input parameter
        oci_bind_by_name($stmt, ':i_chat_id', $chatid);

        // Bind the output parameter
        oci_bind_by_name($stmt, ':o_result', $o_result, 2000000);
        oci_bind_by_name($stmt, ':o_code', $o_code, 2000000);

        ociexecute($stmt);

        //assign message
        $message = $o_result;

    }catch (Exception $e) {
        $message = $e->getMessage();
    }

    /*Close Connection*/
    closeconnection($conn , $stmt);
    // oci_free_statement($stmt);
    // oci_close($conn);

    return str_replace("\\n","\n",$message) ;
}

/*Direct Message Telegram*/
function directmessage(){

}

/*function ldap*/
function ldapconnection($_user_id, $_user_pwd){
	$Host = "ldap.telkom.co.id";
	$Authrealm = "User Intranet Telkom ND";
	$AuthResult = 0;
	
	$ds = ldap_connect($Host);
	$r  = ldap_search($ds, " ", "uid=" . $_user_id);

	if ($_user_id != "" && $_user_pwd != "") {
	
		if ($r) {
			$result = ldap_get_entries( $ds, $r);
			if (isset($result[0])) {
				try {
					$rbind = @ldap_bind( $ds, $result[0]["dn"], $_user_pwd);
					if($rbind) {
						$AuthResult = 1;
					}else {
						$AuthResult = 0;
					}

				}catch(Exception $e) {
					$AuthResult = 0;
				}
			}
		}else {
			$AuthResult = 0;
		}
	}
	return $AuthResult;
}

/*Run custom Command*/
function customcommand($chatid, $messageid, $text){
    $message = "" ;
    $o_msg =""; 
    try{
        /*Open Connection*/
        $conn = openconnection();
        // $conn = oci_connect('MG_BOT', 'MG_BOT', 'ORCL');
        if (!$conn) {
            return $message = "Conection DB Error!, Please Check";
        }

        $sql = "BEGIN "
                . " PRC_EXECPROC_COMMAND("
                . " :i_chat_id, "
                . " :i_msg_id, "
                . " :i_text, "
                . " :o_result,"
                . " :o_code"
                . "); END;";

        //echo  $sql;     

        $stmt = oci_parse($conn, $sql);

        //  Bind the input parameter
        oci_bind_by_name($stmt, ':i_chat_id', $chatid);
        oci_bind_by_name($stmt, ':i_msg_id', $messageid);
        oci_bind_by_name($stmt, ':i_text', $text);

        // Bind the output parameter
        oci_bind_by_name($stmt, ':o_result', $o_result, 2000000);
        oci_bind_by_name($stmt, ':o_code', $o_code, 2000000);

        ociexecute($stmt);

        //assign message
        $message = $o_result;

    }catch (Exception $e) {
        $message = $e->getMessage();
    }

    /*Close Connection*/
    closeconnection($conn , $stmt);
    // oci_free_statement($stmt);
    // oci_close($conn);

    return str_replace("\\n","\n",$message) ;
}

function chekjobstatus($cmd){
    $message = "" ;
    $o_msg =""; 
    try{
        /*Open Connection*/
        $conn = openconnection();
        // $conn = oci_connect('MG_BOT', 'MG_BOT', 'ORCL');
        if (!$conn) {
            return $message = "Conection DB Error!, Please Check";
        }

        echo $cmd;

        $sql = "BEGIN "
                . " prc_chek_status_job("
                . " :i_ref_code, "
                . " :o_result,"
                . " :o_code"
                . "); END;";

        //echo  $sql;     

        $stmt = oci_parse($conn, $sql);

        //  Bind the input parameter
        oci_bind_by_name($stmt, ':i_ref_code', $cmd);

        // Bind the output parameter
        oci_bind_by_name($stmt, ':o_result', $o_result, 2000000);
        oci_bind_by_name($stmt, ':o_code', $o_code, 2000000);

        ociexecute($stmt);

        //assign message
        $message = $o_result;

    }catch (Exception $e) {
        $message = $e->getMessage();
    }

    /*Close Connection*/
    closeconnection($conn , $stmt);
    // oci_free_statement($stmt);
    // oci_close($conn);

    return str_replace("\\n","\n",$message) ;
}

/*Register to MPRO BOT*/
function registermpro($chatid,$text){
    $message = "" ;
    $o_msg =""; 
    try{
        /*Open Connection*/
        $conn = openconnection();
        // $conn = oci_connect('MG_BOT', 'MG_BOT', 'ORCL');
        if (!$conn) {
            return $message = "Conection DB Error!, Please Check";
        }

        $str = explode(" ",$text);

        if(count($str) != 3 ){
           return $message = "Invalid parameters !, /command parameters";
        }
		
		//initiate
		$chekldap = 0;
		$chekldap = ldapconnection($str[1], $str[2]);

        $sql = "BEGIN "
                . " prc_registers_usr_bot_nw("
                . " :i_user_name, "
                . " :i_password, "
                . " :i_ldap_chek, "
                . " :i_chat_id, "
                . " :o_result,"
                . " :o_code"
                . "); END;";

        //echo  $sql;     

        $stmt = oci_parse($conn, $sql);

        //  Bind the input parameter
        oci_bind_by_name($stmt, ':i_user_name', $str[1]);
        oci_bind_by_name($stmt, ':i_password', $str[2]);
        oci_bind_by_name($stmt, ':i_ldap_chek', $chekldap);
        oci_bind_by_name($stmt, ':i_chat_id', $chatid);

        // Bind the output parameter
        oci_bind_by_name($stmt, ':o_result', $o_result, 2000000);
        oci_bind_by_name($stmt, ':o_code', $o_code, 2000000);

        ociexecute($stmt);

        //assign message
        $message = $o_result;

    }catch (Exception $e) {
        $message = $e->getMessage();
    }

    /*Close Connection*/
    closeconnection($conn , $stmt);
    // oci_free_statement($stmt);
    // oci_close($conn);

    return str_replace("\\n","\n",$message) ;
}   

?>