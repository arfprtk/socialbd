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

if(!isheadadmin(getuid_sid($sid)))
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
  echo "</html>";
  exit();
}

addonline(getuid_sid($sid),"Vice President Tools","");

//////////////////////////general settings//////////////////////////

if($action=="general")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $sitename = $_POST["sitename"];
  $xtm = $_POST["sesp"];
  $fmsg = $_POST["fmsg"];
  $areg = $_POST["areg"];
  $vldtn = $_POST["vldtn"];
  $pmaf = $_POST["pmaf"];
  $fvw = $_POST["fvw"];
  if($areg=="d")
  {
  $arv = 0;
  }else{
  $arv = 1;
  }
  if($vldtn=="d")
  {
  $valid = 0;
  }else{
  $valid = 1;
  }
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";  
  $res = mysql_query("UPDATE dcroxx_me_settings SET value='".$sitename."' WHERE name='sitename'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Site Name updated successfully<br/>";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error Updating Site Name<br/>";
  }
  $res = mysql_query("UPDATE dcroxx_me_settings SET value='".$fmsg."' WHERE name='4ummsg'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Forum Message  updated successfully<br/>";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error Updating Forum message<br/>";
  }
  $res = mysql_query("UPDATE dcroxx_me_settings SET value='".$xtm."' WHERE name='sesxp'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Session Period updated successfully<br/>";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error Updating Session Period<br/>";
  }
  $res = mysql_query("UPDATE dcroxx_me_settings SET value='".$pmaf."' WHERE name='pmaf'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>PM antiflood is $pmaf seconds<br/>";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error Updating PM antiflood value<br/>";
  }
  $res = mysql_query("UPDATE dcroxx_me_settings SET value='".$arv."' WHERE name='reg'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Registration updated successfully<br/>";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error Updating Registration<br/>";
  }
  $res = mysql_query("UPDATE dcroxx_me_settings SET value='".$fvw."' WHERE name='fview'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Forums View updated successfully<br/>";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error Updating Forums View<br/>";
  }
  $res = mysql_query("UPDATE dcroxx_me_settings SET value='".$valid."' WHERE name='vldtn'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Validation updated successfully<br/>";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error Updating Validation<br/>";
  }
  echo "<br/>";
  echo "<a href=\"headadmincp2.php?action=general\">Edit general settings</a><br/>";
  echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
else if($action=="validate")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $who = $_GET["who"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"Hea Admin Tools\">";
  echo "<p align=\"center\"><small>";
  $res = mysql_query("Update dcroxx_me_users SET validated='1' WHERE id='".$who."'");
  if($res)
  {
  mysql_query("INSERT INTO dcroxx_me_mlog SET action='validation', details='<b>".getnick_uid(getuid_sid($sid))."</b> validated $user', actdt='".time()."'");
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>$user validated successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error validating $user";
  }
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Owner Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}
////////Make VIP
else if($action=="vip")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $who = $_GET["who"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"President Tools\">";
  echo "<p align=\"center\"><small>";
  $res = mysql_query("Update dcroxx_me_users SET vip='1' WHERE id='".$who."'");
  if($res)
  {
  mysql_query("INSERT INTO dcroxx_me_mlog SET action='Certified', details='<b>".getnick_uid(getuid_sid($sid))."</b> Make certified $user', actdt='".time()."'");
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>$user make Certified successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error Certified $user";
  }
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"ownercp.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"\"/>President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}
//////////un Make VIP
else if($action=="unvip")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $who = $_GET["who"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"President Tools\">";
  echo "<p align=\"center\"><small>";
  $res = mysql_query("Update dcroxx_me_users SET vip='0' WHERE id='".$who."'");
  if($res)
  {
  mysql_query("INSERT INTO dcroxx_me_mlog SET action='Certified', details='<b>".getnick_uid(getuid_sid($sid))."</b> unmake certified $user', actdt='".time()."'");
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>$user unmake successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error unmaking $user";
  }
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"ownercp.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"\"/>President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}
//////////////////////////boot user//////////////////////////

else if($action=="boot")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $who = $_GET["who"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  $uid = getuid_sid($sid);
  $pRmxX = mysql_fetch_array(mysql_query("SELECT pRmxX FROM dcroxx_me_users WHERE id='".$uid."'"));
  $trgtpRmxX = mysql_fetch_array(mysql_query("SELECT pRmxX FROM dcroxx_me_users WHERE name='".$user."'"));

  if($trgtpRmxX>$pRmxX){ 
  echo "<b><img src=\"images/notok.gif\" alt=\"x\"/><br/>Error!!!<br/>permission Denied...</b><br/>";
  echo "<br/>U Cannot Boot $user<br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  }else{
  echo "<br/>";
  $res = mysql_query("DELETE FROM dcroxx_me_ses WHERE uid='".$who."'");
  if($res)
  {
  mysql_query("INSERT INTO dcroxx_me_mlog SET action='boot', details='<b>".getnick_uid(getuid_sid($sid))."</b> booted $user', actdt='".time()."'");
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>$user Booted successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error booting $user";
  }
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  }
  echo "</card>";
}
//////////////////////////trash user//////////////////////////

else if($action=="trash")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $who = $_POST["who"];
  $pds = $_POST["pds"];
  $phr = $_POST["phr"];
  $pmn = $_POST["pmn"];
  $psc = $_POST["psc"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  $uid = getuid_sid($sid);
  $pRmxX = mysql_fetch_array(mysql_query("SELECT pRmxX FROM dcroxx_me_users WHERE id='".$uid."'"));
  $trgtpRmxX = mysql_fetch_array(mysql_query("SELECT pRmxX FROM dcroxx_me_users WHERE name='".$user."'"));

  if($trgtpRmxX>$pRmxX){ 
  echo "<b><img src=\"images/notok.gif\" alt=\"x\"/><br/>Error!!!<br/>permission Denied...</b><br/>";
  echo "<br/>U Cannot Trash $user<br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  }else{
  echo "<br/>";
  $timeto = $pds*24*60*60;
  $timeto += $phr*60*60;
  $timeto += $pmn*60;
  $timeto += $psc;
  $ptime = $timeto + time();
    $res = mysql_query("INSERT INTO dcroxx_me_metpenaltiespl SET uid='".$who."', penalty='0', exid='".getuid_sid($sid)."', timeto='".$ptime."', pnreas='".mysql_escape_string($pres)."', ipadd='".$uip."', browserm='".$ubr."'");
 if($res)
  {
 mysql_query("UPDATE dcroxx_me_users SET lastpnreas='".mysql_escape_string($pres)."' WHERE id='".$who."'");
mysql_query("INSERT INTO dcroxx_me_mlog SET action='penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> $pmsg[$pid] The user <b>".$unick."</b> For ".$timeto." Seconds', actdt='".time()."'");


  echo "<img src=\"images/ok.gif\" alt=\"O\"/>$user trashed successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error trashing $user";
  }
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  }
  echo "</card>";
}
//////////////////////////ban user//////////////////////////

else if($action=="ban")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $who = $_POST["who"];
  $pres = $_POST["pres"];
  $pds = $_POST["pds"];
  $phr = $_POST["phr"];
  $pmn = $_POST["pmn"];
  $psc = $_POST["psc"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  $uid = getuid_sid($sid);
  $pRmxX = mysql_fetch_array(mysql_query("SELECT pRmxX FROM dcroxx_me_users WHERE id='".$uid."'"));
  $trgtpRmxX = mysql_fetch_array(mysql_query("SELECT pRmxX FROM dcroxx_me_users WHERE name='".$user."'"));

  if($trgtpRmxX>$pRmxX){ 
  echo "<b><img src=\"images/notok.gif\" alt=\"x\"/><br/>Error!!!<br/>permission Denied...</b><br/>";
  echo "<br/>U Cannot Ban $user<br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  }else{
  echo "<br/>";
    $pex = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_penalties WHERE pnreas LIKE '".mysql_escape_string($pres)."'"));
if($pex[0]==0)
{
  if(trim($pres)=="")
  {
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>You must Specify a reson for punishing the user";
  }else{
  $timeto = $pds*24*60*60;
  $timeto += $phr*60*60;
  $timeto += $pmn*60;
  $timeto += $psc;
  $ptime = $timeto + time();
/*  $res = mysql_query("INSERT INTO dcroxx_me_penalties SET uid='".$who."', penalty='1', exid='".getuid_sid($sid)."', timeto='".$ptime."', pnreas='".mysql_escape_string($pres)."', ipadd='', browserm=''");
  if($res)
  {
  $pmsg[1]="Banned";
  mysql_query("UPDATE dcroxx_me_users SET lastpnreas='".$pmsg[1].": ".mysql_escape_string($pres)."' WHERE id='".$who."'");
  mysql_query("INSERT INTO dcroxx_me_mlog SET action='banned', details='<b>".getnick_uid(getuid_sid($sid))."</b> Banned The user <b>".$user."</b> For ".gettimemsg($timeto)."', actdt='".time()."'");
*/

$res = mysql_query("INSERT INTO dcroxx_me_metpenaltiespl SET uid='".$who."', penalty='1', exid='".getuid_sid($sid)."', timeto='".$ptime."', pnreas='".mysql_escape_string($pres)."', ipadd='".$uip."', browserm='".$ubr."'");

 if($res)
  {
  $pmsg[1]="Banned";
  mysql_query("UPDATE dcroxx_me_users SET lastpnreas='".$pmsg[1].": ".mysql_escape_string($pres)."' WHERE id='".$who."'");
  mysql_query("INSERT INTO dcroxx_me_mlog SET action='banned', details='<b>".getnick_uid(getuid_sid($sid))."</b> Banned The user <b>".$user."</b> For ".gettimemsg($timeto)."', actdt='".time()."'");




  echo "<img src=\"images/ok.gif\" alt=\"O\"/>$user banned successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error banning $user";
  }
  }
      }else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>There is another account which is already banned with this reason";
}
  
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  }
  echo "</card>";
}
//////////////////////////ipban user//////////////////////////

else if($action=="ipban")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $who = $_POST["who"];
  $pres = $_POST["pres"];
  $pds = $_POST["pds"];
  $phr = $_POST["phr"];
  $pmn = $_POST["pmn"];
  $psc = $_POST["psc"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  $uid = getuid_sid($sid);
  $pRmxX = mysql_fetch_array(mysql_query("SELECT pRmxX FROM dcroxx_me_users WHERE id='".$uid."'"));
  $trgtpRmxX = mysql_fetch_array(mysql_query("SELECT pRmxX FROM dcroxx_me_users WHERE name='".$user."'"));

  if($trgtpRmxX>$pRmxX){ 
  echo "<b><img src=\"images/notok.gif\" alt=\"x\"/><br/>Error!!!<br/>permission Denied...</b><br/>";
  echo "<br/>U Cannot Ip-ban $user<br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  }else{
  echo "<br/>";
  if(trim($pres)=="")
  {
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>You must Specify a reson for punishing the user";
  }else{
  $timeto = $pds*24*60*60;
  $timeto += $phr*60*60;
  $timeto += $pmn*60;
  $timeto += $psc;
  $ptime = $timeto + time();
  $uip = getip_uid($who);
  $ubr = getbr_uid($who);
$res = mysql_query("INSERT INTO dcroxx_me_metpenaltiespl SET uid='".$who."', penalty='2', exid='".getuid_sid($sid)."', timeto='".$ptime."', pnreas='".mysql_escape_string($pres)."', ipadd='".$uip."', browserm='".$ubr."'");

 if($res)
  {
  $pmsg[1]="IP Banned";
  mysql_query("UPDATE dcroxx_me_users SET lastpnreas='".$pmsg[1].": ".mysql_escape_string($pres)."' WHERE id='".$who."'");
  mysql_query("INSERT INTO dcroxx_me_mlog SET action='banned', details='<b>".getnick_uid(getuid_sid($sid))."</b> IP Banned The user <b>".$user."</b> For ".gettimemsg($timeto)."', actdt='".time()."'");




  echo "<img src=\"images/ok.gif\" alt=\"O\"/>$user banned successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error banning $user";
  }
  }
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  }
  echo "</card>";
}
//////////////////////////shield user//////////////////////////

else if($action=="shld")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $who = $_GET["who"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  $res = mysql_query("Update dcroxx_me_users SET shield='1' WHERE id='".$who."'");
  if($res)
  {
  $unick = getnick_uid($who);
  mysql_query("INSERT INTO dcroxx_me_mlog SET action='penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> Shielded The user <b>".$unick."</b>', actdt='".time()."'");
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick is Shielded";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
  }
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////unshield user//////////////////////////

else if($action=="ushld")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $who = $_GET["who"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  $res = mysql_query("Update dcroxx_me_users SET shield='0' WHERE id='".$who."'");
  if($res)
  {
  $unick = getnick_uid($who);
  mysql_query("INSERT INTO dcroxx_me_mlog SET action='penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> Unshielded The user <b>".$unick."</b>', actdt='".time()."'");
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick is Unshielded";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
  }
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////untrash user//////////////////////////

else if($action=="untr")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $who = $_GET["who"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
	  $res = mysql_query("DELETE FROM dcroxx_me_metpenaltiespl WHERE penalty='0' AND uid='".$who."'");
  if($res)
          {
            $unick = getnick_uid($who);
            mysql_query("INSERT INTO dcroxx_me_mlog SET action='penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> Untrashed The user <b>".$unick."', actdt='".time()."'");
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick Untrashed";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
          }	  
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}

//////////////////////////unban user//////////////////////////

else if($action=="unbn")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $who = $_GET["who"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
    $res = mysql_query("DELETE FROM dcroxx_me_metpenaltiespl WHERE (penalty='1' OR penalty='2') AND uid='".$who."'");
  if($res)
          {
            $unick = getnick_uid($who);
            mysql_query("INSERT INTO dcroxx_me_mlog SET action='penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> Unbanned The user <b>".$unick."</b>', actdt='".time()."'");
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick Unbanned";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
          }
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////delete user//////////////////////////
/*
else if($action=="delu")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $who = $_GET["who"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  $uid = getuid_sid($sid);
  $pRmxX = mysql_fetch_array(mysql_query("SELECT pRmxX FROM dcroxx_me_users WHERE id='".$uid."'"));
  $trgtpRmxX = mysql_fetch_array(mysql_query("SELECT pRmxX FROM dcroxx_me_users WHERE name='".$user."'"));

  if($trgtpRmxX>$pRmxX){ 
  echo "<b><img src=\"images/notok.gif\" alt=\"x\"/><br/>Error!!!<br/>permission Denied...</b><br/>";
  echo "<br/>U Cannot Delete $user<br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  }else{

  echo "<br/>";
  $res = mysql_query("DELETE FROM dcroxx_me_buddies WHERE tid='".$who."' OR uid='".$who."'");
  $res = mysql_query("DELETE FROM dcroxx_me_gbook WHERE gbowner='".$who."' OR gbsigner='".$who."'");
  $res = mysql_query("DELETE FROM dcroxx_me_ignore WHERE name='".$who."' OR target='".$who."'");
  $res = mysql_query("DELETE FROM dcroxx_me_mangr WHERE uid='".$who."'");
  $res = mysql_query("DELETE FROM dcroxx_me_modr WHERE name='".$who."'");
  $res = mysql_query("DELETE FROM dcroxx_me_penalties WHERE uid='".$who."' OR exid='".$who."'");
  $res = mysql_query("DELETE FROM dcroxx_me_posts WHERE uid='".$who."'");
  $res = mysql_query("DELETE FROM dcroxx_me_private WHERE byuid='".$who."' OR touid='".$who."'");
  $res = mysql_query("DELETE FROM dcroxx_me_popups WHERE byuid='".$who."' OR touid='".$who."'");
  $res = mysql_query("DELETE FROM dcroxx_me_shouts WHERE shouter='".$who."'");
  $res = mysql_query("DELETE FROM dcroxx_me_topics WHERE authorid='".$who."'");
  $res = mysql_query("DELETE FROM dcroxx_me_brate WHERE uid='".$who."'");
  $res = mysql_query("DELETE FROM dcroxx_me_games WHERE uid='".$who."'");
  $res = mysql_query("DELETE FROM dcroxx_me_presults WHERE uid='".$who."'");
  $res = mysql_query("DELETE FROM dcroxx_me_vault WHERE uid='".$who."'");
  $res = mysql_query("DELETE FROM dcroxx_me_blogs WHERE bowner='".$who."'");
  $res = mysql_query("DELETE FROM dcroxx_me_chat WHERE chatter='".$who."'");
  $res = mysql_query("DELETE FROM dcroxx_me_chat WHERE who='".$who."'");
  $res = mysql_query("DELETE FROM dcroxx_me_chonline WHERE uid='".$who."'");
  $res = mysql_query("DELETE FROM dcroxx_me_online WHERE userid='".$who."'");
  $res = mysql_query("DELETE FROM dcroxx_me_ses WHERE uid='".$who."'");
  $res = mysql_query("DELETE FROM dcroxx_me_xinfo WHERE uid='".$who."'");
  deleteMClubs($who);
  $res = mysql_query("DELETE FROM dcroxx_me_users WHERE id='".$who."'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>User  deleted successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error deleting UGroup";
  }
  echo "<br/><br/><a href=\"headadmincp2.php?action=chuinfo\">User info</a><br/>";
  echo "<br/><a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  }
  echo "</small></p></card>";
}*/
//////////////////////////plusses//////////////////////////

else if($action=="pls")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $pid = $_POST["pid"];
  $who = $_POST["who"];
  $pres = $_POST["pres"];
  $pval = $_POST["pval"];
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  $unick = getnick_uid($who);
  $opl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
  if($pid=='0')
  {
  $npl = $opl[0] - $pval;
  }else{
  $npl = $opl[0] + $pval;
  }
  if($npl<0)
  {
  $npl=0;
  }
  if(trim($pres)=="")
  {
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>You must Specify a reson for updating $unick's Plusses";
  }else{
  $res = mysql_query("UPDATE dcroxx_me_users SET lastplreas='".mysql_escape_string($pres)."', plusses='".$npl."' WHERE id='".$who."'");
  if($res)
  {
  mysql_query("INSERT INTO dcroxx_me_mlog SET action='plusses', details='<b>".getnick_uid(getuid_sid($sid))."</b> Updated <b>".$unick."</b> plusses from ".$opl[0]." to $npl', actdt='".time()."'");
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick's Plusses Updated From $opl[0] to $npl";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
  }
  }
  echo "<br/><br/>";
  echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////clear reports/logs//////////////////////////

else if($action=="clrmlog")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  echo "<br/>";
  $res = mysql_query("DELETE FROM dcroxx_me_mlog");
  echo mysql_error();
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>ModLog Cleared Successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error!";
  }
  echo "<br/><br/><a href=\"headadmincp2.php?action=clrdta\">Clear Data</a><br/>";
  echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////clear inboxs//////////////////////////

else if($action=="delpms")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  echo "<br/>";
  $res = mysql_query("DELETE FROM dcroxx_me_private WHERE reported!='1' AND starred='0' AND unread='0'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>All PMS except starred, reported, and unread were deleted";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error!";
  }
  echo "<br/><br/><a href=\"headadmincp2.php?action=clrdta\">Clear Data</a><br/>";
  echo "<a href=\"headheadadmincp2.php?action=headheadadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////clear popups//////////////////////////

else if($action=="delpops")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  echo "<br/>";
  $res = mysql_query("DELETE FROM dcroxx_me_popups WHERE reported!='1' AND unread='0'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>All popups except reported, and unread were deleted";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error!";
  }
  echo "<br/><br/><a href=\"headheadadmincp2.php?action=clrdta\">Clear Data</a><br/>";
  echo "<a href=\"ownercp.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////clear shouts//////////////////////////

else if($action=="delsht")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  $altm = time()-(5*24*60*60);
  echo "<br/>";
  $res = mysql_query("DELETE FROM dcroxx_me_shouts WHERE shtime<'".$altm."'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Shouts Older Than 5 days were deleted";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error!";
  }
  echo "<br/><br/><a href=\"headheadadmincp2.php?action=clrdta\">Clear Data</a><br/>";
  echo "<a href=\"headheadadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////add blocked site//////////////////////////

else if($action=="addsite")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  $site = $_POST["site"];
  echo $site;
  $res = mysql_query("INSERT INTO dcroxx_me_blockedsite SET site='".$site."'");
  if($res)
  {
  echo mysql_error();
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Site $site Added Successfully to Blocked List<br/>";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error Adding Site<br/>";
  }
  echo "<br/>";
  echo "<a href=\"headadmincp2.php?action=blocksites\">Blocked Sites List</a><br/>";
  echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
  }
//////////////////////////delete blocked site//////////////////////////

else if($action=="delsite")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  $id=$_GET["id"];
  $sitena = mysql_query("SELECT site FROM dcroxx_me_blockedsite WHERE id='".$id."'");
  $site = mysql_fetch_array($sitena);
  $site=$site[0];
  $res = mysql_query("DELETE FROM dcroxx_me_blockedsite WHERE id='".$id."'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Site $site Removed Successfully from Blocked List<br/>";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error Removing $site <br/>";
  }
  echo "<br/>";
  echo "<a href=\"headadmincp2.php?action=blocksites\">Blocked Sites List</a><br/>";
  echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////add forum moderator//////////////////////////

else if($action=="addfmod")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $mid = $_POST["mid"];
  $fid = $_POST["fid"];
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  $res = mysql_query("INSERT INTO dcroxx_me_modr SET name='".$mid."', forum='".$fid."'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Moding Privileges Added<br/>";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error<br/>";
  }
  echo "<br/><br/><a href=\"headadmincp2.php?action=manmods\">Manage Moderators</a><br/>";
  echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////delete forum moderator//////////////////////////

else if($action=="delfmod")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $mid = $_POST["mid"];
  $fid = $_POST["fid"];
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  $res = mysql_query("DELETE FROM dcroxx_me_modr WHERE name='".$mid."' AND forum='".$fid."'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Moding Privileges Deleted<br/>";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error<br/>";
  }
  echo "<br/><br/><a href=\"headadmincp2.php?action=manmods\">Manage Moderators</a><br/>";
  echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////add smilie//////////////////////////

else if($action=="addsml")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $smlcde = $_POST["smlcde"];
  $smlsrc = $_POST["smlsrc"];
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  echo "<br/>";
  $res = mysql_query("INSERT INTO dcroxx_me_smilies SET scode='".$smlcde."', imgsrc='".$smlsrc."', hidden='0'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Smilie  added successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error adding Smilie ";
  }
  echo "<br/><br/><a href=\"headadmincp2.php?action=addsml\">Add Another Smilie</a><br/>";
  echo "<br/><a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////delete smilie//////////////////////////

else if($action=="delsm")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $smid = $_GET["smid"];
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  echo "<br/>";
  $res = mysql_query("DELETE FROM dcroxx_me_smilies WHERE id='".$smid."'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Smilie  deleted successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error deleting smilie ";
  }
  echo "<br/><br/><a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////add avartar//////////////////////////

else if($action=="addavt")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $avtsrc = $_POST["avtsrc"];
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  echo "Source: ".$avtsrc;
  echo "<br/>";
  $res = mysql_query("INSERT INTO dcroxx_me_avatars SET avlink='".$avtsrc."'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Avatar  added successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error adding Avatar ";
  }
  echo "<br/><br/><a href=\"headadmincp2.php?action=addavt\">Add Another Avatar</a><br/>";
  echo "<br/><a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////add judge//////////////////////////

else if($action=="addjdg")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $who = $_GET["who"];
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  echo "<br/>";
  $res = mysql_query("INSERT INTO dcroxx_me_judges SET uid='".$who."'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Judge  added successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error adding Judge ";
  }
  echo "<br/><br/><a href=\"headadmincp2.php?action=chuinfo\">Users Info</a><br/>";
  echo "<br/><a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////remove judge//////////////////////////

else if($action=="deljdg")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $who = $_GET["who"];
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  echo "<br/>";
  $res = mysql_query("DELETE FROM dcroxx_me_judges WHERE uid='".$who."'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Judge  deleted successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error deleting Judge ";
  }
  echo "<br/><br/><a href=\"headadmincp2.php?action=chuinfo\">Users Info</a><br/>";
  echo "<br/><a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////add rss//////////////////////////

else if($action=="addrss")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $rssnm = $_POST["rssnm"];
  $rsslnk = $_POST["rsslnk"];
  $rssimg = $_POST["rssimg"];
  $rssdsc = $_POST["rssdsc"];
  $fid = $_POST["fid"];
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  echo $rssnm;
  echo "<br/>";
  $res = mysql_query("INSERT INTO dcroxx_me_rss SET title='".$rssnm."', link='".$rsslnk."', imgsrc='".$rssimg."', dscr='".$rssdsc."', fid='".$fid."'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Source added successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error adding RSS Source";
  }
  echo "<br/><br/><a href=\"headadmincp2.php?action=manrss\">Manage RSS</a><br/>";
  echo "<br/><a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////edit rss//////////////////////////

else if($action=="edtrss")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $rssnm = $_POST["rssnm"];
  $rsslnk = $_POST["rsslnk"];
  $rssimg = $_POST["rssimg"];
  $rssdsc = $_POST["rssdsc"];
  $fid = $_POST["fid"];
  $rssid = $_POST["rssid"];
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  echo $rssnm;
  echo "<br/>";
  $res = mysql_query("UPDATE dcroxx_me_rss SET title='".$rssnm."', link='".$rsslnk."', imgsrc='".$rssimg."', dscr='".$rssdsc."', fid='".$fid."' WHERE id='".$rssid."'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Source updated successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error updating RSS Source";
  }
  echo "<br/><br/><a href=\"headadmincp2.php?action=manrss\">Manage RSS</a><br/>";
  echo "<br/><a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////delete rss//////////////////////////

else if($action=="delrss")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $rssid = $_POST["rssid"];
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  echo "<br/>";
  $res = mysql_query("DELETE FROM dcroxx_me_rss WHERE id='".$rssid."'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Source  deleted successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
  }
  echo "<br/><br/><a href=\"headadmincp2.php?action=manrss\">Manage RSS</a><br/>";
  echo "<br/><a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////add permission//////////////////////////

else if($action=="addpRmxX")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $fid = $_POST["fid"];
  $gid = $_POST["gid"];
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  echo "<br/>";
  $res = mysql_query("INSERT INTO dcroxx_me_acc SET fid='".$fid."', gid='".$gid."'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>permission  added successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error adding permission ";
  }
  echo "<br/><br/><a href=\"headadmincp2.php?action=addpRmxX\">Add permission</a><br/>";
  echo "<a href=\"index.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}

//////////////////////////edit profile//////////////////////////

else if($action=="uprof")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $who = $_GET["who"];
  $unick = $_POST["unick"];
  $pRmxX = $_POST["pRmxX"];
  $savat = $_POST["savat"];
  $semail = $_POST["semail"];
  $ubday = $_POST["ubday"];
  $uloc = $_POST["uloc"];
  $usig = $_POST["usig"];
  $usex = $_POST["usex"];
  $specialid = $_POST["specialid"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  $onk = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$who."'"));
  $exs = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE name='".$unick."'"));
  if($onk[0]!=$unick)
  {
  if($exs[0]>0)
  {
  echo "<img src=\"images/notok.gif\" alt=\"x\"/>New nickname already exist, choose another one<br/>";
  }
  $trgtpRmxX = mysql_fetch_array(mysql_query("SELECT pRmxX FROM dcroxx_me_users WHERE id='".$who."'"));
  $uidpRmxX = mysql_fetch_array(mysql_query("SELECT pRmxX FROM dcroxx_me_users WHERE id='".$uid."'"));
  if($trgtpRmxX>$uidpRmxX){ 
  echo "<p align=\"center\"><small>";
  echo "<b><img src=\"images/notok.gif\" alt=\"x\"/><br/>Error!!!<br/>permission Denied...</b><br/>";
  echo "U Cannot Edit $unick<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  }else{
  //$res = mysql_query("UPDATE dcroxx_me_users SET avatar='".$savat."', email='".$semail."', birthday='".$ubday."', location='".$uloc."', signature='".$usig."', sex='".$usex."', name='".$unick."', pRmxX='".$pRmxX."' WHERE id='".$who."'");
  $res = mysql_query("UPDATE dcroxx_me_users SET avatar='".$savat."', email='".$semail."', birthday='".$ubday."', location='".$uloc."', signature='".$usig."', sex='".$usex."', name='".$unick."', perm='".$pRmxX."', specialid='".$specialid."' WHERE id='".$who."'");
 


 if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"o\"/>$unick's profile was updated successfully<br/>";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"x\"/>Error updating $unick's profile<br/>";
  }
  }
  }else
  {
  $trgtpRmxX = mysql_fetch_array(mysql_query("SELECT pRmxX FROM dcroxx_me_users WHERE id='".$who."'"));
  $uidpRmxX = mysql_fetch_array(mysql_query("SELECT pRmxX FROM dcroxx_me_users WHERE id='".$uid."'"));
  if($trgtpRmxX>$uidpRmxX){ 
  echo "<p align=\"center\"><small>";
  echo "<b><img src=\"images/notok.gif\" alt=\"x\"/><br/>Error!!!<br/>permission Denied...</b><br/>";
  echo "U Cannot Edit $unick<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  }else{
 // $res = mysql_query("UPDATE dcroxx_me_users SET avatar='".$savat."', email='".$semail."', birthday='".$ubday."', location='".$uloc."', signature='".$usig."', sex='".$usex."', name='".$unick."', pRmxX='".$pRmxX."' WHERE id='".$who."'");
  $res = mysql_query("UPDATE dcroxx_me_users SET avatar='".$savat."', email='".$semail."', birthday='".$ubday."', location='".$uloc."', signature='".$usig."', sex='".$usex."', name='".$unick."', perm='".$pRmxX."', specialid='".$specialid."' WHERE id='".$who."'");

  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"o\"/>$unick's profile was updated successfully<br/>";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"x\"/>Error updating $unick's profile<br/>";
  }
  }
  echo "<br/><a href=\"admincp2.php?action=chuinfo\">Users Info</a><br/>";
  echo "<br/><a href=\"ownercp.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  }
  echo "</card>";
}
//////////////////////////reset password//////////////////////////

else if($action=="upwd")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $npwd = $_POST["npwd"];
  $who = $_GET["who"];
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
    if((strlen($npwd)<4) || (strlen($npwd)>15)){
  echo "<img src=\"images/notok.gif\" alt=\"x\"/>password should be between 4 and 15 letters only<br/>";
  }else{
  $pwd = md5($npwd);
  $res = mysql_query("UPDATE dcroxx_me_users SET pass='".$pwd."' WHERE id='".$who."'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"o\"/>password was updated successfully<br/>";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"x\"/>Error updating password<br/>";
  }
  }
  echo "<br/><a href=\"headadmincp2.php?action=chuinfo\">Users Info</a><br/>";
  echo "<br/><a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////Delete users posts//////////////////////////

else if($action=="delxp")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
  $who = $_GET["who"];
  echo "<card id=\"main\" title=\"Vice President Tools\">";
  echo "<p align=\"center\"><small>";
  echo "<br/>";
  $res = mysql_query("DELETE FROM dcroxx_me_posts WHERE uid='".$who."'");
  $res = mysql_query("DELETE FROM dcroxx_me_topics WHERE authorid='".$who."'");
  if($res)
  {
  mysql_query("UPDATE dcroxx_me_users SET plusses='0' where id='".$who."'");
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>User Posts deleted successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error deleting UPosts";
  }
  echo "<br/><br/><a href=\"headadmincp2.php?action=chuinfo\">User info</a><br/>";
  echo "<br/><a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////error//////////////////////////

else
{
  echo "<title>Admin Tools</title>";
  echo "<p align=\"center\"><small>";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
?>
</html>