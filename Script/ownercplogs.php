 <?
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



if($action=="main"){

echo "<card id=\"main\" title=\"$sitename\">";
echo "<p align=\"left\"><small>";

	$nick = getnick_sid($sid);
    //check for pwd
    $uinf = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE id='".$uid."' AND tools_pass='".$apwd."'"));
    if($uinf[0]==0)
    {
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>Your tools pass is incorrect<br/><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
    echo "</small></p>";
    echo "</card>";
    echo "</wml>";
    exit();
    }
	
	    $uinf = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_toolses WHERE uid='".$uid."'"));
    if($uinf[0]>0)
    {
    echo "<img src=\"images/ok.gif\" alt=\"X\"/>You are already logged in. 
	<a href=\"ownercp2.php?action=ownercp\">Enter Your Panel Now</a><br/><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
    echo "</small></p>";
    echo "</card>";
    echo "</wml>";
    exit();
    }
  //////////////////////
        $tm = time();
      $xtm = $tm + (30*60);
        $res = mysql_query("INSERT INTO dcroxx_me_toolses SET uid='".$uid."', pass='".$apwd."', expiretm='".$xtm."'");
      if($res){
   echo "<img src=\"images/ok.gif\" alt=\"X\"/>Congratulation! $nick, you are successfully logged in to your panel.<br/>
   Now you are approved for access your tools. <a href=\"ownercp2.php?action=ownercp\">Access Now</a><br/><br/>
   <b>Please logged out before you go out from tools</b><br/><br/>";
       echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
	  }
 //////////////////////
}
else{

  addonline(getuid_sid($sid),"ERROR","");
echo "<card id=\"main\" title=\"ERROR\">";
   echo "<p align=\"center\"><small>";

echo "Nothing Here";

  echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "";
  echo "</small></p>";
    echo "</card>";
}
echo "</small></p></card>";



?>

</html>