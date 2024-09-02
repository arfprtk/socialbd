<?php
   session_name("PHPSESSID");
session_start();

include("xhtmlfunctions.php");
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";
?>


<?php
include("config.php");
include("core.php");
connectdb();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$who = $_GET["who"];

$itemid = $_GET["itemid"];
    if(islogged($sid)==false)
    {
     $pstyle = gettheme($sid);
      echo xhtmlhead(" shop",$pstyle);
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
       echo xhtmlfoot();
      exit();
    }
$uid = getuid_sid($sid);
if(isbanned($uid))
    {
     $pstyle = gettheme($sid);
      echo xhtmlhead(" shop",$pstyle);
      echo "<p align=\"center\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
      echo "You are <b>Banned</b><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT timeto FROM dcroxx_me_metpenaltiespl WHERE uid='".$uid."' AND penalty='1'"));
      $remain = $banto[0]- (time()  );
      $rmsg = gettimemsg($remain);
      echo "Time to finish your penalty: $rmsg<br/><br/>";
      //echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
       echo xhtmlfoot();
      exit();
    }

if($action=="main")
{
  addonline(getuid_sid($sid),"Here are some Radio Stations","");
$pstyle = gettheme($sid);
      echo xhtmlhead("Radio",$pstyle);
  echo "<p align=\"center\">";
  


  echo "<p align=\"center\"><br/>";
 echo "<b>RADIO STATIONS<br/><br/>";


  echo "<b><a href=\"radio/83.9.php\">&#171; 83.9</a><br/>";
echo "<b><a href=\"radio/89.9.php\">&#171; 89.9</a><br/>";
echo "<b><a href=\"radio/90.7.php\">&#171; 90.7</a><br/>";
echo "<b><a href=\"radio/91.5.php\">&#171; 91.5</a><br/>";
echo "<b><a href=\"radio/93.1.php\">&#171; 93.1</a><br/>";
echo "<b><a href=\"radio/97.9.php\">&#171; 97.9</a><br/>";
 
        echo "<br/><a href=\"fardin.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Enter (+online radio)</a><br/>";


  echo "<a href=\"http://SocialBD.NeT/index.php?action=main\">-HOME-</a></b><br/><br/>";


 echo "&#xA9; <br/>";
  echo "</p>";
    echo xhtmlfoot();
exit();
}

?>
