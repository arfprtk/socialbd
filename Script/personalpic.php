<?php
    session_name("PHPSESSID");
session_start();

/*
(c)wapdesire.tk

      /\             / -------
     /     \   _   /    ----------
    / /     \[.. ]/    ---------
   ////// ' \/ `   ------
  ////  // :    : ------
 // /   /  /`    '----
//          //..\\
       ==UU==UU==
             '//||\\`
Personal Photo Upload:- By opticalpigion
*/



if($script=="wml"){
header("Content-type: text/vnd.wap.wml");
header("Cache-Control: no-store, no-cache, must-revalidate");
echo '<?xml version="1.0"?' . '>'; 
echo "<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\"". " \"http://www.wapforum.org/DTD/wml_1.1.xml\">";
}else{
header("Content-type: text/html; charset=UTF-8");
header("Cache-Control: no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
echo '<?xml version="1.0"?' . '>'; 
echo "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\" \"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\">
<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";
}

if($script=="wml"){
echo "<wml>";
}else{
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
}
include("config.php");
include("core.php");
connectdb();

$brw = $HTTP_USER_AGENT;
$brws = explode("/",$HTTP_USER_AGENT);
$ubr = $brws[0];
$uip = getip();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$page = $_GET["page"];
$who = $_GET["who"];
$uid = getuid_sid($sid);
$nick = getnick_uid($uid);
$upload = $_GET["upload"];
$theme = mysql_fetch_array(mysql_query("SELECT theme FROM dcroxx_me_users WHERE id='".$uid."'"));
$bcon = connectdb();
$script = $_GET["script"];
/////////////////////////////Database Error/////////////////////////////

if (!$bcon)
{
if($script=="wml"){
echo "<card id=\"main\" title=\"Error!!!\">";
}else{
echo "<head>";
echo "<title>Error!!!</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/white.css\">";
echo "</head>";
echo "<body>";
}
echo "<p align=\"center\">";
echo "<img src=\"images/exit.gif\" alt=\"!\"/><br/>";
echo "<b>Error! Cannot Connect To Database...</b><br/><br/>";
echo "This error happens usually when backing up the database, please be patient...";
echo "</p>";
if($script=="wml"){
echo "</card>";
echo "</wml>";
}else{
echo "</body>";
echo "</html>";
}
exit();
}

cleardata();
/////////////////////////////Ip Banned/////////////////////////////

if(isipbanned($uip,$ubr))
{
if(!isshield(getuid_sid($sid)))
{
echo "<head>";
echo "<title>Ip Block!</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme\">";
echo "</head>";
echo "<body>";
echo "<p align=\"center\">";
echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
echo "<b>This IP address is blocked!!!</b><br/>";
echo "<br/>";
echo "How ever we grant a shield against IP-Ban for our great users, you can try to see if you are shielded by trying to log-in, if you kept coming to this page that means you are not shielded, so come back when the ip-ban period is over<br/><br/>";
$banto = mysql_fetch_array(mysql_query("SELECT  timeto FROM dcroxx_me_penalties WHERE  penalty='2' AND ipadd='".$uip."' AND browserm='".$ubr."' LIMIT 1 "));
//echo mysql_error();
$remain =  $banto[0] - time();
$rmsg = gettimemsg($remain);
echo " IP: $rmsg<br/><br/>";
echo "</p>";
echo "<p>";
echo "<form action=\"../web/login.php\" method=\"get\">";
echo "<b>UserID:</b><br/><input name=\"loguid\" format=\"*x\" maxlength=\"30\"/><br/>";
echo "<b>Password:</b><br/><input type=\"password\" name=\"logpwd\"  maxlength=\"30\"/><br/>";
echo "<br/><input name=\"LOGIN\" type=\"submit\" value=\"Submit\"></form>";
echo "<img src=\"../images/banner.gif\" alt=\"\"/><br/>";
echo "<br/><br/>Not registered yet? <br/><a href=\"register.php\">SignUp</a><br/>";
echo "<a href=\"index.php?action=terms\">Site Rules</a><br/>";
echo "</p>";
echo "</body>";
echo "</html>";
exit();
}
}
/////////////////////////////Session Expired/////////////////////////////

if(($action != "") && ($action!="terms"))
{
$uid = getuid_sid($sid);
if((islogged($sid)==false)||($uid==0))
{
if($script=="wml"){
echo "<card id=\"main\" title=\"Error!!!\">";
}else{
echo "<head>";
echo "<title>Error!!!</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/white.css\">";
echo "</head>";
echo "<body>";
}
echo "<p align=\"center\">";
echo "You are not logged in<br/>";
echo "Or Your session has been expired<br/><br/>";
if($script=="wml"){
echo "<a href=\"index.php\">Login</a>";
}else{
echo "<a href=\"index.php\">Login</a>";
}
echo "</p>";
if($script=="wml"){
echo "</card>";
echo "</wml>";
}else{
echo "</body>";
echo "</html>";
}
exit();
}
}
/////////////////////////////Banned/////////////////////////////

if(isbanned($uid))
{
if($script=="wml"){
echo "<card id=\"main\" title=\"Error!!!\">";
}else{
echo "<head>";
echo "<title>Error!!!</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme\">";
echo "</head>";
echo "<body>";
}
echo "<p align=\"center\">";
echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
echo "<b>You are Banned</b><br/><br/>";
$banto = mysql_fetch_array(mysql_query("SELECT timeto, pnreas, exid FROM dcroxx_me_penalties WHERE uid='".$uid."' AND penalty='1'"));
$banres = mysql_fetch_array(mysql_query("SELECT lastpnreas FROM dcroxx_me_users WHERE id='".$uid."'"));
$remain = $banto[0]- time();
$rmsg = gettimemsg($remain);
echo "<b>Time Left: </b>$rmsg<br/>";
$nick = getnick_uid($banto[2]);
echo "<b>By: </b>$nick<br/>";
echo "<b>Reason: </b>$banto[1]";
//echo "<a href=\"index.php\">Login</a>";
echo "</p>";
if($script=="wml"){
echo "</card>";
echo "</wml>";
}else{
echo "</body>";
echo "</html>";
}
exit();
}

/////////////////////////////upload//////////////////////////////
else if($action=="main")

{

echo "<head>";
echo "<title>Personal Photo Uploader</title>";    
 echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
echo "</head>";
echo "<body>";
echo "<form enctype=\"multipart/form-data\" method=\"post\" action=\"personalpicuploader.php?action=upload\">";

	echo "<input type=\"file\" name=\"my_field\" /><br/>\n";

                  echo "UserID (in Number): <input name=\"user\" maxlength=\"100\" size=\"20\"/><br/>";
	echo "Description: <input name=\"descript\" maxlength=\"100\" size=\"20\"/>";

	echo "<input type=\"hidden\" name=\"action\" value=\"image\" /><br/>";

	echo "<INPUT TYPE=\"submit\" name=\"upl\" VALUE=\"Upload\"></form>";   
  echo "<p><small>";
  echo "<a href=\"index.php?action=main\">Home</a>";
  echo " &#62; ";
  echo "<a href=\"gallery.php?action=main\">Photo Gallery</a><br/>";
  echo " &#62; ";
echo "</body>";
echo "</html>";
}
exit();
?>
