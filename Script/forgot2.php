<?php 
session_name("PHPSESSID");
session_start();
$sid = $_SESSION['sid'];
$nick = getnick_sid($sid); 


/* 
this deals with the errors the page is suppose to give off! 
*/ 
$error1 = "<small>Please go back and write your email!</small>"; 
$error2 = "<small>Please go back and write your name!</small>"; 
$errorlnk = "<small>Go Back</small>"; 
////End of Errors!///////////////////////////////////// 

/* 
this deals with the page appearance :P 
*/ 

$invmsg = "You are invited to join http://SocialBD.NeT chat by your friend, $nick. 
This chat site has great chat friends online. 
Click on this link http://SocialBD.NeT to meet alot of people world wide and also in your country."; 

$admin = "<small>Enter you registered details</small>"; 
$image = "images/logo.gif"; 
$homet = "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
$title = "Password Recovery"; 

/////The End! 



?>
