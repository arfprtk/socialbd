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
include("_x_core_tags_.php");
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
////////////////////////////////// Uploader By IT Development Center :)
if($action=="")
{
          $pstyle = gettheme($sid);
      echo xhtmlhead("Tag Friends",$pstyle);
    addonline(getuid_sid($sid),"Attact a Photo","attach.php?action=$action");
	    echo "<head>";
    echo "<title>Tag Friends</title>";
    echo "</head>";
    echo "<body>";
echo"<div class=\"penanda\"><small>";
$shid = $_GET["shid"];
$i = mysql_fetch_array(mysql_query("SELECT shouter FROM dcroxx_me_shouts WHERE id='".$shid."'"));
if (ismod(getuid_sid($sid)) || $i[0]==$uid){

if(isset($_POST['done'])){
if(!empty($_POST['check_list'])) {
foreach($_POST['check_list'] as $selected) {

if ($selected==getuid_sid($sid)){
echo "<center><img src=\"dwarf.gif\" alt=\"\"><br/><strong>You can't mention your self dear</strong><br/><br/> </center>";}else{
$vb = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_mention WHERE tag_id='".$selected."' AND shid='".$shid."'"));
if($vb[0]==0){

$shnick = getnick_uid($selected);
$sex = mysql_fetch_array(mysql_query("SELECT sex FROM dcroxx_me_users WHERE id='".$selected."'"));
if($sex[0]=="M"){$nicks = "<font color=\"blue\"><b>$shnick</b></font>";}
if($sex[0]=="F"){$nicks = "<font color=\"deeppink\"><b>$shnick</b></font>";}
if($sex[0]==""){$nicks = "";}
$i = mysql_fetch_array(mysql_query("SELECT shouter FROM dcroxx_me_shouts WHERE id='".$shid."'"));

echo "<a href=\"profile.php?who=$selected\">".$nicks."</a>, ";
 //header("Location: index.php");
mysql_query("INSERT INTO  dcroxx_me_mention SET shid='".$shid."', tag_id='".$selected."', tag_user='".$shnick."', time='".time()."', shouter='".$i[0]."'");
$liker = getnick_sid($sid);

$sex = mysql_fetch_array(mysql_query("SELECT sex FROM dcroxx_me_users WHERE id='".$uid."'"));
if($sex[0]=="M"){mysql_query("INSERT INTO ibwf_notifications SET text='[image_preview=FNcFEVynZ6Y.png][user=$uid]$liker"."[/user] mention you on his [aFardin=like.php?action=main&shid=$shid]shout[/aFardin]', touid='".$selected."', timesent='".time()."'");}
if($sex[0]=="F"){mysql_query("INSERT INTO ibwf_notifications SET text='[image_preview=FNcFEVynZ6Y.png][user=$uid]$liker"."[/user] mention you on her [aFardin=like.php?action=main&shid=$shid]shout[/aFardin]', touid='".$selected."', timesent='".time()."'");}
if($sex[0]=="") {mysql_query("INSERT INTO ibwf_notifications SET text='[image_preview=FNcFEVynZ6Y.png][user=$uid]$liker"."[/user] mention you on his/her [aFardin=like.php?action=main&shid=$shid]shout[/aFardin]', touid='".$selected."', timesent='".time()."'");}

//echo "".$selected .",";
}else{
echo "";
}}}
echo"are successfully mentioned and a notification has been sent to their menu.";
}else{
echo "<center><img src=\"dwarf.gif\" alt=\"\"><br/><strong>Hey what are you doing? Select persons first to mention.</strong><br/><br/> </center>";
}}

}else{echo "<center><img src=\"dwarf.gif\" alt=\"\"><br/><strong>Hey stupid, is this your post? Why are you here?</strong><br/><br/> </center>";}
  echo"</small><center><small>";
echo"<img src=\"images/home.gif\" alt=\"\"><a href=\"index.php\">Home</a>";
echo"</small></center>";
echo "</body>";
exit();
}

?>
</html>