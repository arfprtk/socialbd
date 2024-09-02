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
$res = mysql_query("UPDATE dcroxx_me_users SET browserm='".$ubr."', ipadd='".$uip."' WHERE id='".getuid_sid($sid)."'");


  addonline(getuid_sid($sid),"Shout Likers","");

 $pstyle = gettheme($sid);
      echo xhtmlhead("Likers",$pstyle);
	  
$shid = $_GET['shid'];

if($page=="" || $page<=0) {$page=1;}
$count = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) page FROM ibwfrr_like WHERE shoutid='".$shid."'"));

$num_items = $count['page']; //changable
$event_per_page= 10;
$num_pages = ceil($num_items/$event_per_page);
if(($page>$num_pages)&&$page!=1) {$page= $num_pages;}
$limit_start = ($page-1)*$event_per_page;


$lshout = mysql_fetch_array(mysql_query("SELECT shout, shouter, shtime FROM dcroxx_me_shouts WHERE id='".$shid."'"));
$shnick = getnick_uid($lshout[1]);
$text = parsepm($lshout[0],$sid);
echo '<center><small><b>Users Who Liked This Shout</b><br/><br/>';

$s = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_mention WHERE shid='".$shid."'"));
$lst = mysql_fetch_array(mysql_query("SELECT tag_id FROM dcroxx_me_mention WHERE shid='".$shid."'"));
$lnck = getnick_uid($lst[0]);
$ck = getnick_uid($lst[0]);
$cos = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_mention WHERE shid='".$shid."'"));
$pip = $cos[0]-1;
if($cos[0]==1){ $lk = "<font color=\"#4c5157\">with</font> <a href=\"$ck\">$lnck</a>"; }
else if($cos[0]>1) {$lk = "<font color=\"#4c5157\">with</font> <a href=\"$ck\">$lnck</a> <font color=\"#4c5157\">and</font> <a href=\"tag_mention.php?action=tag_peoples&shid=$item[0]\">$pip others</a>";}
else if ($cos[0]==0){ $lk = "";}


$avlink = getavatar($lshout[1]);
if($avlink==""){
$iml = "<img src=\"images/nopic.jpg\" alt=\"Nopic\" height=\"30\" width=\"25\"/>";
}else{
$iml = "<img src=\"$avlink\" alt=\"avatar\" height=\"30\" width=\"25\"/>";
}
$shdt = date("d/m/Y h:i:s A", $lshout[2]+(addhours()));	 
$tremain = time()-$lshout[2];
$tmdt = gettimemsg($tremain)." ago";
echo "$iml <a href=\"index.php?action=viewuser&amp;who=$lshout[1]\">$shnick</a> $lk <br/> ";
echo "$text<br/><small>($tmdt)</small>";

echo '';  


$results = mysql_query("SELECT * FROM ibwfrr_like WHERE shoutid='".$shid."' ORDER BY ltime ASC LIMIT $limit_start, $event_per_page");
while ($event = mysql_fetch_assoc($results)){
$user = $event['uid'];
$unick = getnick_uid($user);

echo "<a href=\"index.php?action=viewuser&amp;who=$user\">$unick</a>, ";
//echo getbbcode($event[shcomments],$sid,1)."<br/>";
//echo "&#187; ".gmstrftime("%d %B,%Y - %H:%M:%S %p",$event['shtime'])."<br/><br/>";
  
}






echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";


echo "</p>";
echo "</card>";
?>
</html>
