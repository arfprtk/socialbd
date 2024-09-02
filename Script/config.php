<?php
$dbname = "socialbd_v_5"; //change to your mysql database name
$dbhost = "localhost"; //database host name
$dbuser = "socialbd_v_5";
$dbpass = "o1,%l&]ZBopT";
$pkfiles = "./pkfiles";
$mmsdir = "./mmsloads";
$stitle = "SocialBD.NeT";  //maximum number of buds
$max_buds=1000; //maximum number of buds
$topic_af = 5; //topic antiflood
$post_af = 5; //post antiflood
$onver = true; //isonline versoion
date_default_timezone_set('UTC');
$timeadjust = (6 * 60 * 60); // 4 hours
//putenv("TZ=Dhaka/Asia");


//WEB BROWSER PROTECTION
$HTTP_USER_AGENT = getenv("HTTP_USER_AGENT"); 
$REMOTE_ADDR = $_SERVER["REMOTE_ADDR"]; 
$HTTP_MSISDN = getenv("HTTP_MSISDN"); 
$HTTP_X_MSISDN = getenv("HTTP_X_MSISDN"); 
$HTTP_X_NOKIA_MSISDN = getenv("HTTP_X_NOKIA_MSISDN"); 
$HTTP_X_FORWARDED_FOR = getenv("HTTP_X_FORWARDED_FOR"); 
$HTTP_X_NETWORK_INFO = getenv("HTTP_X_NETWORK_INFO"); 
$HTTP_X_OPERAMINI_PHONE_UA = getenv("HTTP_X_OPERAMINI_PHONE_UA"); 
$user = explode (' ', $HTTP_USER_AGENT);
//HERE U CAN ADD BROWSER TYPES TO DENY ACCESS WITH
if($user[0]=="Opera/9.50"||$user[0]=="SonyEricssonW900i/R5BC"||$user[0]=="SonyEricssonV600i/R2H"){
//HERE THE REDIRECTION URL
//header ('Location: note.php');}
}
?>
