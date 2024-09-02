 <?php
   session_name("PHPSESSID");
session_start();
include("config.php");
include("core.php");
include("xhtmlfunctions.php");
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";


?>
<html xmlns="http://www.w3.org/1999/xhtml">
<meta name="description" content="LDS Christian Social Community on Mobile" />
<meta name="keywords" content="lds, mormon, wapsite, christian, social community" />
<link rel="shortcut icon" href="/images/favicon.ico" />
<link rel="icon" href="/images/favicon.gif" type="image/gif" />

<?php


$bcon = connectdb();
$uid = getuid_sid($sid);

if (!$bcon)
{
    $pstyle = gettheme1("1");
    echo xhtmlhead("$stitle (ERROR!)",$pstyle);
    echo "<p align=\"center\">";
    echo "<img src=\"images/exit.gif\" alt=\"*\"/><br/>";
    echo "ERROR! cannot connect to database<br/><br/>";
    echo "This error happens usually when backing up the database, please be patient, The site will be up any minute<br/><br/>";
    echo "<b>THANK YOU VERY MUCH</b>";
    echo "</p>";
  echo xhtmlfoot();
      exit();
}
$brws = explode("/",$_SERVER['HTTP_USER_AGENT']);
$ubr = $brws[0];
$uip = getip();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$page = $_GET["page"];
$who = $_GET["who"];

cleardata();
if(isipbanned($uip,$ubr))
    {
      if(!isshield(getuid_sid($sid)))
      {
      $pstyle = gettheme1("1");
      echo xhtmlhead("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
      echo "This IP address is blocked<br/>";
      echo "<br/>";
      echo "How ever we grant a shield against IP-Ban for our great users, you can try to see if you are shielded by trying to log-in, if you kept coming to this page that means you are not shielded, so come back when the ip-ban period is over<br/><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT  timeto FROM dcroxx_me_metpenaltiespl WHERE  penalty='2' AND ipadd='".$uip."' AND browserm='".$ubr."' LIMIT 1 "));
      //echo mysql_error();
      $remain =  $banto[0] - (time() - $timeadjust) ;
      $rmsg = gettimemsg($remain);
      echo "Time to unblock the IP: $rmsg<br/><br/>";

      echo "</p>";
      echo "<p>";
  echo "<form action=\"login.php\" method=\"get\">";
  echo "Username:<br/> <input name=\"loguid\" format=\"*x\" size=\"8\" maxlength=\"30\"/><br/>";
  echo "Password:<br/> <input type=\"password\" name=\"logpwd\" size=\"8\" maxlength=\"30\"/><br/>";
echo "<input type=\"submit\" value=\"Login\"/>";
echo "</form>";
  echo "</p>";
  echo xhtmlfoot();
      exit();
      }
    }
if(($action != "") && ($action!="terms"))
{
    $uid = getuid_sid($sid);
    if((islogged($sid)==false)||($uid==0))
    {
      $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
  echo xhtmlfoot();
      exit();
    }



}
//echo isbanned($uid);
if(isbanned($uid))
    {
      $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
      echo "You are <b>Banned</b><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT timeto FROM dcroxx_me_metpenaltiespl WHERE uid='".$uid."' AND penalty='1'"));
	  $banres = mysql_fetch_array(mysql_query("SELECT lastpnreas FROM dcroxx_me_users WHERE id='".$uid."'"));

      $remain = $banto[0]- (time() - $timeadjust) ;
      $rmsg = gettimemsg($remain);
      echo "Time to finish your penalty: $rmsg<br/><br/>";
	  echo "Ban Reason: $banres[0]";
      //echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
  echo xhtmlfoot();
      exit();
    }
if($sid == "$sid")
{
$uid =getuid_sid($sid);
  $whonick = getnick_uid($uid);
  addonline(getuid_sid($sid),"Wants to Log Out - xHTML","");
        $pstyle = gettheme($sid);
    echo xhtmlhead("Log Out",$pstyle);
$logoutses = mysql_query("DELETE FROM dcroxx_me_ses WHERE uid='".$uid."'");
  $logoutonline = mysql_query("DELETE FROM dcroxx_me_online WHERE userid='".$uid."'");
}else{

  echo "<p align=\"center\">";
  echo "Good bye <b>$whonick</b><br/><br/>";
  echo "<small>Whe hope you had a great time here, and hope to see you soon</small>";
  echo "<br/><br/><a href=\"$_GET[url]\"><img src=\"images/ok.gif\" alt=\"OK\"/>";
  echo "Click Here To Continue</a>";
  echo "</p>";
}
  echo xhtmlfoot();
exit;
die();
?>
