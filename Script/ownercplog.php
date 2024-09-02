<?php
   session_name("PHPSESSID");
session_start();

//session_start();
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\"\"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\">";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";

echo "<head><title>SocialBD</title>";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/style.css\" />";
echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
<meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
<meta name=\"description\" content=\"Chatheaven :)\">
<meta name=\"keywords\" content=\"free, community, forums, chat, wap, communicate\">
<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> </head>";
echo "<body>";
include("config.php");
include("core.php");
include("xhtmlfunctions.php");
connectdb();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$apwd = $_GET["apwd"];
$page = $_GET["page"];
$who = $_GET["who"];
$pmid = $_GET["pmid"];
$whonick = getnick_uid($who);
$byuid = getuid_sid($sid);
$uid = getuid_sid($sid);
$sitename = mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE name='sitename'"));
$sitename = $sitename[0];
$ubrw = explode(" ",$HTTP_USER_AGENT);
$ubrw = $ubrw[0];
$ipad = getip();
if(!isowner(getuid_sid($sid)))
  {
    $pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "You are not an owner<br/>";
      echo "<br/>";
      echo "<a href=\"index.php\">Home</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
if(islogged($sid)==false)
    {$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }


$sitename = mysql_fetch_array(mysql_query("SELECT value FROM ibwfrr_settings WHERE name='sitename'"));
$sitename = $sitename[0];

if(!isowner(getuid_sid($sid)))
{
  echo "<card id=\"main\" title=\"Error!!!\">";
  echo "<p align=\"center\"><small>";
  echo "<b>permission Denied!</b><br/>";
  echo "<br/>Only owner can use this page...<br/>";
  echo "<a href=\"index.php\">Home</a>";
  echo "</small></p>";
  echo "</card>";
  echo "</wml>";
  exit();
}

if(islogged($sid)==false)
{
  echo "<card id=\"main\" title=\"Error!!!\">";
  echo "<p align=\"center\"><small>";
  echo "You are not logged in<br/>";
  echo "Or Your session has been expired<br/><br/>";
  echo "<a href=\"index.php\">Login</a>";
  echo "</small></p>";
  echo "</card>";
  echo "</wml>";
  exit();
}

if($action=="main"){
		echo "<card id=\"main\" title=\"$sitename\">";
echo "<p align=\"left\"><small>";
 // if(isloggedtools($uid)==false)
  if(!isloggedtools($uid))
{
	$nick = getnick_sid($sid);
  	/*echo "Sorry <b>$nick</b>, you are not logged in to your site panel.<br/>
	Please login in first for use your tools/power<br/><br/>";*/
	
	
echo" <center>Sorry <b>$nick</b>, you are not logged in to your site panel.<br/>
Please login in first for use your tools/power<br/><br/>
Tools Pass:<br/>
<form action=\"ownercplogs.php?action=main\" method=\"get\">
<input type=\"password\" name=\"apwd\" format=\"*x\" maxlength=\"35\"/><br/>";
//echo "<postfield name=\"apwd\" value=\"$(apwd)\"/>";
echo "<input type=\"hidden\" name=\"action\" value=\"main\"/>";
echo"<input type=\"submit\" name=\"Submit\" value=\"Login Now\"/><br/>
</form></center>";
	
	
  /*	echo "Tools Pass:<br/>
	<input type=\"password\" name=\"apwd\" format=\"*x\" maxlength=\"35\"/><br/>";
  	echo "<anchor>Login Now";
  echo "<go href=\"ownercplogs.php?action=main&amp;sid=$sid\" method=\"get\">";
  echo "<postfield name=\"apwd\" value=\"$(apwd)\"/>";
  echo "<postfield name=\"action\" value=\"main\"/>";
  echo "<postfield name=\"sid\" value=\"$sid\"/>";
  echo "</go></anchor><br/><br/>";*/
  echo "<br/><br/>";
  
      echo "<a href=\"index.php?action=main&amp;sid=$sid\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  /*  echo "</small></p>";
  echo "</card>";
  echo "</wml>";*/
 // exit();
}else{
	 echo "<img src=\"images/ok.gif\" alt=\"X\"/>You are already logged in to your panel.<br/>
	 <a href=\"ownercp2.php?action=ownercp\">Access Owner Panel</a><br/><br/>
	 <a href=\"ownercp2.php?action=own_cp_log_out\">Logout Panel</a><br/><br/>";
	 echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  /*  echo "</small></p>";
  echo "</card>";
  echo "</wml>";*/
}
}
else{

  addonline(getuid_sid($sid),"ERROR","");
echo "<card id=\"main\" title=\"ERROR\">";
   echo "<p align=\"center\"><small>";

echo "Nothing Here";

  echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"../icons/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "";
  echo "</small></p>";
    echo "</card>";
}
  
echo "</small></p></card>";



?>

</html>