<?php
     session_name("PHPSESSID");
session_start();

include("config.php");
include("core.php");
include("xhtmlfunctions.php");

header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";
?>

<?php

$action = $_GET["action"];
$sid = $_SESSION['sid'];

$bcon = connectdb();

if(islogged($sid)==false)
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

if($action=="add")
{
  addonline(getuid_sid($sid),"Adding a Shortcut","");
  $pstyle = gettheme($sid);
  echo xhtmlhead("Adding a Shortcut",$pstyle);
  
  $scid = $_GET["scid"];
  
  echo "<p align=\"center\"><small>";
  echo "<i><b><u>Add a Shortcut</u></b></i><br/>";
  echo "<br/>";
  echo "</small></p>";
  
  echo "<p><small>";
    echo "<form method=\"post\" action=\"shortcut.php?action=addsc&amp;scid=$scid\">";
    echo "Shortcut Name: <input name=\"scname\" maxlength=\"25\"/><br/>"; 
    echo "<input type=\"submit\" name=\"Submit\" value=\"Add Shortcut\"/>";
    echo "</form><br/>";
  echo "</small></p>";
  
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  
  echo xhtmlfoot();
}

else
if($action=="addsc")
{
  addonline(getuid_sid($sid),"Adding a Shortcut","");
  $pstyle = gettheme($sid);
  echo xhtmlhead("Adding a Shortcut",$pstyle);
  
  $scname = $_POST["scname"];
  $scid = $_GET["scid"];
  $uid = getuid_sid($sid);  
  
  echo "<p align=\"center\"><small>";
  echo "<i><b><u>Add a Shortcut</u></b></i><br/>";
  echo "<br/>";
  echo "</small></p>";
  
  echo "<p><small>";
    $reg = mysql_query("INSERT INTO dcroxx_me_shortcuts SET uid='".$uid."', scname='".$scname."', scurlid='".$scid."'");
    
    if($reg)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Shortcut added Successfully<br/><br/>";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error adding shortcut<br/><br/>";
      }
  echo "</small></p>";
  
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  
  echo xhtmlfoot();
    exit();
    }
//////////////////////////////////

else
{
  addonline(getuid_sid($sid),"Lost!!!!","");
  $pstyle = gettheme($sid);
  echo xhtmlhead("Lost",$pstyle);
  echo "<p align=\"center\">";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
    exit();
    }


?>
