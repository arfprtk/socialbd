<?php
session_name("PHPSESSID");
session_start();
header("Content-type: text/vnd.wap.wml");
header("Cache-Control: no-store, no-cache, must-revalidate");
echo("<?xml version=\"1.0\"?>");
echo "<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\"". " \"http://www.wapforum.org/DTD/wml_1.1.xml\">
<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";
?>
<wml>
<?php
include("config.php");
include("core.php");
connectdb();
$action = $_GET['action'];
$sid = $_SESSION['sid'];
$page = $_GET['page'];
$who = $_GET['who'];
$pmid = $_GET['pmid'];
if(islogged($sid)==false)
{
    echo "<card id=\"main\" title=\"$stitle\">";
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
      echo "</card>";
      echo "</wml>";
      exit();
}
$uid = getuid_sid($sid);
if(isbanned($uid))
    {
        echo "<card id=\"main\" title=\"$stitle\">";
      echo "<p align=\"center\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
      echo "You are <b>Banned</b><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT timeto FROM dcroxx_me_penalties WHERE uid='".$uid."' AND penalty='1'"));
      $remain = $banto[0]- time();
      $rmsg = gettimemsg($remain);
      echo "Time to finish your penalty: $rmsg<br/><br/>";
      //echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
      echo "</card>";
      echo "</wml>";
      exit();
    }


else if($action=="send")
{
addonline(getuid_sid($sid),"Sending pop-up MSG","");
echo "<card id=\"main\" title=\"sent!!\">";
echo "<p align=\"center\">";
$whonick = getnick_uid($who);
$byuid = getuid_sid($sid);
$tm = time();

$res = mysql_query("INSERT INTO fun_pops SET text='".$msg."', byuid='".$byuid."', touid='".$who."', timesent='".$tm."'");



    echo "<img src=\"images/sent.gif\" alt=\"O\"/><br/>";
    echo "Popup Message Sent to $whonick!<br/>";

    
echo "<br/>---<br/><a href=\"index.php?action=main\">Home</a>";
echo "</p>";
echo "</card>";
echo "</wml>";
exit();

}
else if($action=="sendto"){

$who = $_get['who'];

addonline(getuid_sid($sid),"Sending pop-up MSG","");
echo "<card id=\"main\" title=\"popups\">";
echo "<p align=\"center\">";
echo "$getbuttons <br/>";

$who = $_get['who'];


$whonick = getnick_uid($who);
$byuid = getuid_sid($sid);

echo "<input name=\"msg\" maxlength=\"150\"/><br/>";
echo "<anchor>SEND<go href=\"popus.php?action=send&amp;who=$who\" method=\"post\">";
echo "<postfield name=\"msg\" value=\"$(msg)\"/>";
echo "</go></anchor><br/>";


echo "
<br/>-
<br/><a href=\"index.php?action=main\">Home</a>";
echo "</p>";
echo "</card>";
    exit();
    }

?>
</wml>
