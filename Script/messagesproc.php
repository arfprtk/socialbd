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
$page = $_GET["page"];
$who = $_GET["who"];
$pmid = $_GET["pmid"];
$pmtext = $_POST["pmtext"];
$whonick = getnick_uid($who);
$byuid = getuid_sid($sid);
$sitename = mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE name='sitename'"));
$sitename = $sitename[0];
$ubrw = explode(" ",$HTTP_USER_AGENT);
$ubrw = $ubrw[0];
$ipad = getip();
$uid = getuid_sid($sid);

if($action != "")
{
if(islogged($sid)==false)
{
      $pstyle = gettheme1("1");
      echo xhtmlhead("",$pstyle);
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
  echo xhtmlfoot();
      exit();
    }
}
if(isbanned($uid))
    {
      $pstyle = gettheme($sid);
      echo xhtmlhead("",$pstyle);
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
else if($action=="mkroom")
{
        $rname = mysql_escape_string($_POST["rname"]);
        $rpass = trim($_POST["rpass"]);
        addonline(getuid_sid($sid),"Creating Private Chatroom","chat.php?action=ucht");
	    echo "<head>";
    echo "<title>Create Room</title>";
echo "</head>";
    echo "<body>";
echo "<div class=\"mblock1\" align=\"left\">";
include("header.php");
            echo "</div>";
			echo "<div class=\"header\" align=\"center\">";
			echo "<b>Create Private Room</b></div>";
  echo "<div class=\"shout2\" align=\"center\">";
        if ($rpass=="")
        {
          $cns = 1;
        }else{
            $cns = 0;
        }
        $prooms = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_rooms WHERE static='0'"));
        if($prooms[0]<10)
        {
        $res = mysql_query("INSERT INTO dcroxx_me_rooms SET name='".$rname."', pass='".$rpass."', censord='".$cns."', static='0', lastmsg='".time()."'");
        if($res)
        {
          echo "<img src=\"avatars/ok.gif\" alt=\"O\"/>Room created Successfully!<br/><br/>";
        }else{
            echo "<img src=\"avatars/notok.gif\" alt=\"X\"/>Unknown Error!!!<br/><br/>";
        }
        }else{
            echo "<img src=\"avatars/notok.gif\" alt=\"X\"/>There's already 10 users rooms<br/><br/>";
        }
echo "</div>";
echo "<p align=\"left\"><img src=\"avatars/menu.gif\"><a href=\"index.php\">Menu</a></p>";
echo "<div class=\"footer\" align=\"center\">";
include("footer.php");
echo "</div>";
      exit();
  }
?>
</html>