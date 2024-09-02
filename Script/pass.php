<?php 
include 'core.php'; 
include 'config.php'; 


if(isset($_POST['submit'])) 
{     
  $email=$_POST['email']; 
  $getinfo="SELECT login from ibwf_users where email='$email'"; 
  $getinfo2=mysql_query($getinfo) or die("Could not get info"); 
  $getinfo3=mysql_fetch_assoc($getinfo2); 
  if($getinfo3) 
  { 
     $pass = substr(preg_replace('/\W/', '', md5(rand())), 0, 8); 
     $changepass= mysql_query("update `users` SET `pass`='".md5($pass)."' WHERE `email`='".$email."'"); 
     mail("$email","From Retrivewa.co.za","Your login details login $getinfo3[login] &Password $pass");    
     print "Instruction for changing your password have been mailed to you."; 
  } 
  else 
  { 

    print "Retrieve Password"; 
    print "There is not a user with that e-mail address"; 
  } 
   
} 
else 
{ 

  print "<form method='POST' action='getpassword.php'>"; 
  print "Your e-mail:</td><td><input type='text' name='email' length='45'>"; 
  print "<input type='submit' name='submit' value='submit'>"; 
} 
?>