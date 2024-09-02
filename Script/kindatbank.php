<?php

     session_name("PHPSESSID");
session_start();

header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\"\"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\">";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";

	echo "<head>";

	echo "<title>SocialBD</title>";
	echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/style.css\" />
	<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";
	echo "</head>";

	echo "<body>";
include("config.php");
include("core.php");
include("xhtmlfunctions.php");
$bcon = connectdb();
if (!$bcon)
{

    echo "<p align=\"center\">";
    echo "Site is busy<br/><br/>";
    echo "Our database is busy. Please try again later!<br/>";
    echo "</p>";
    echo "</body>";
     echo "</html>";
    exit();
}
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$page = $_GET["page"];
$uid = getuid_sid($sid);
if($action != "")
{
    if(islogged($sid)==false)
    {

      echo "<p align=\"left\">";
   
      echo "Your session has been expired<br/>";
echo "<a href=\"index.php\">Login</a>";
  echo "</go></anchor>";
  echo "</p>";
      echo "</body>";
       echo "</html>";
      exit();
  
    }
}
if(isbanned($uid))
    {

      echo "<p align=\"center\">";
     echo "<img src=\"images/exit2.gif\" alt=\"*\"/><br/>";
      echo "You are <b>Banned</b><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT timeto FROM dcroxx_me_penalties WHERE uid='".$uid."' AND penalty='1'"));
      $remain = $banto[0]- time();
      $rmsg = gettimemsg($remain);
      echo "Time to finish your penalty: $rmsg<br/><br/>";
      //echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
      echo "</body>";
       echo "</html>";
      exit();
    }

if($action=="main")
{
   $who = $_GET["who"];
    $uid = getuid_sid($sid);
 $unick = getnick_uid($who);
  addonline(getuid_sid($sid)," BANK","");
		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
    echo "<p align=\"center\">";
 echo "Welcome to  Bank, here you can maximize your earnings with your plusses and even double";
 echo "</p><p align=\"left\">";
if(!bank($uid))
    {
echo "<a href=\"kindatbank.php?action=reg\">Register</a>";
}else{
echo "<a href=\"kindatbank.php?action=login\">Login</a><br/>-----<br/>";
echo "<a href=\"kindatbank.php?action=reset\">Forgot Password</a><br/>";
}
echo "</p><p align=\"center\">"; 
echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
  echo "</p>";
    echo "</body>";
   exit();
    }
/////////////////////////////////////////////////////////requists

else if($action=="login")
{
    addonline(getuid_sid($sid),"Logging Bank Account","ran.php?action=$action");

    echo "<p align=\"center\">";
 
echo "<form action=\"kindatbank2.php\" method=\"get\">";
  echo "<input name=\"pass\" format=\"*x\"  maxlength=\"30\"/><br/>";
  echo "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
  echo "<input type=\"hidden\" name=\"uid\" value=\"$uid\"/>";
echo "<input type=\"submit\" value=\"Login &#187;\"/>";
echo "</form>";
    echo "</p>";
 ////// UNTILL HERE >>
    echo "<p align=\"center\">";
   
    echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
  echo "</p>";
    echo "</body>";
   exit();
    }
/////////////////////////////////////////////////////////requists

else if($action=="reset")
{
    addonline(getuid_sid($sid),"Forgot password","ran.php?action=$action");

    echo "<p align=\"left\">";
  
echo "<form action=\"kindatbank.php?action=reset2\" method=\"post\">";
 echo "Security Question: What was your first teacher's name?<br/>";   
echo "Security answer: <input name=\"secure\" maxlength=\"300\"/>";
 echo "<input type=\"submit\" value=\"SUBMIT\"/>";
           echo "</form>";
 echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
   
    echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
  echo "</p>";
    echo "</body>";
   exit();
    }
///////////////////////////////////////////////////////shout
else if($action=="reset2")
{
 addonline(getuid_sid($sid),"Getting new password","index.php?action=main");

    echo "<p align=\"center\">";
   $secure = $_POST["secure"];
    $tid = getuid_hint($secure);
  
 if($tid==0)
    {
      echo "Security answer doesn't match!<br/>";
    }else{
$uid = getuid_sid($sid);
       echo "We already sent your bank account password.Check your inbox!<br/>";
$pass = mysql_fetch_array(mysql_query("SELECT pass FROM dcroxx_me_bank WHERE uid='".$uid."'"));
    $uid = getuid_sid($sid);
   $msg = "".getnick_uid(getuid_sid($sid))." your $msg password is $pass[0]!"."[br/][small]Note: Dont share your password to anyone![/small]";
			autopm($msg, $uid);
    }
  echo "<br/><br/><a href=\"index.php?action=main\">";
echo "Main menu</a>";
    echo "</p>";
    echo "</body>";
   exit();
    }
//////////////////////////////////////////////////////requists

else if($action=="reg")
{
    addonline(getuid_sid($sid),"Creating Bank Account","ran.php?action=$action");

    echo "<p align=\"center\">";
  echo "<form action=\"kindatbank.php?action=reg2\" method=\"post\">";
echo "PASSWORD: <input name=\"rpass\" maxlength=\"60\"/><br/>";
 echo "Security Question: What was your first teacher's name?<br/>";     
echo "Security answer: <input name=\"secure\" maxlength=\"300\"/><br/>";
 echo "<input type=\"submit\" value=\"SUBMIT\"/>";
           echo "</form>";
  echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
   
    echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
  echo "</p>";
    echo "</body>";
   exit();
    }
////////////////////////////////////////////////////
else if($action=="reg2")
{
        $rpass = trim($_POST["rpass"]);
        $secure = trim($_POST["secure"]);
         addonline(getuid_sid($sid),"Creating Bank Account","index.php?action=main");

        echo "<p align=\"center\">";
         //$uid = getuid_sid($sid);
      if(($rpass=="")||($secure==""))
        {
       echo "Don't them blank!<b/>";
       }else{
        $res = mysql_query("INSERT INTO dcroxx_me_bank SET uid='".$uid."' , pass='".$rpass."', hint='".$secure."', done='1',actime='".time()."'");
        if($res)
        {
          echo "Bank Account Created succesfully!<br/><br/>";
        }else{
            echo "Database Error!<br/><br/>";
        }
      }
          echo "<a href=\"kindatbank.php?action=main\">Bank main</a><br/>";
        echo "<a href=\"index.php?action=main\">Main menu</a>";
        echo "</p>";
        echo "</body>";
        
   exit();
    }


?>

</html>
