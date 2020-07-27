<?php

/****
 * Author : Pratama .R
 * Original Author : Pratama. R
 * Function : Connect Oracle
 * ***/

 //conection oracle dev
/* $username = 'MG_BOT';
 $passwd = 'MG_BOT';
 $tns ='ORCL';
*/

 //conection oracle prod
 $username = 'usrticket';
 $passwd = 'Telkom#2017';
 $tns ='TIBSRET'; 

 //open connection
 function openconnection(){
    /*Open Connection Oracle*/
    global $username , $passwd, $tns;
    $conn = oci_connect($username , $passwd, $tns);
    return $conn;
 }

 // close connection
 function closeconnection($conn , $stmt){
    /*Close Connection*/
    oci_free_statement($stmt);
    oci_close($conn);
 }


?>
