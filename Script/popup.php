<?php
session_name("PHPSESSID");
session_start();
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\"\"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\">";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";

	echo "<head>";

	echo "<title>$stitle</title>";
	echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/style.css\" />";
echo "
<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
<meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
<meta name=\"description\" content=\"Fun mobile :)\">
<meta name=\"keywords\" content=\"free, community, forums, chat, wap, communicate\">
<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> 
";
	echo "</head>";

	echo "<body>";
include("core.php");
include("config.php");

connectdb();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$text = $_POST["text"];
$who = $_POST["who"];

if(islogged($sid)==false)
{

      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";

      exit();
}

else if($action=="send")
{
$who=$_POST["who"];
$msg=$_POST["msg"];

addonline(getuid_sid($sid),"Sending pop-up MSG","");

    echo "<p align=\"center\">";
$whonick = getnick_uid($who);
$byuid = getuid_sid($sid);
$tm = time();
$res = mysql_query("INSERT INTO dcroxx_me_pops SET text='".$msg."', byuid='".$byuid."', touid='".$who."', timesent='".$tm."'");
if($res)
  {
include("pops.php");
    echo "<img src=\"images/sent.gif\" alt=\"O\"/><br/>";
    echo "Popup Message Sent to $whonick!<br/>";
  }else{
    echo "<img src=\"images/notok.gif\" alt=\"X\"/><br/>";
    echo "Can't Send Message to $whonick<br/><br/>";
   echo "<br/>---<br/><a href=\"index.php?action=main\">Home</a>";
    echo "</p>";
  }
    exit();
    }
//////////////////////////////////
else if($action=="archive")
{


  }

  else{
    addonline(getuid_sid($sid),"Lost in inbox lol","");

  echo "<p align=\"center\">";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
   
echo "</body>";
	echo "</html>";
 exit();
    }
?>
