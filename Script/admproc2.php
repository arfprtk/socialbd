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

if(!ismod(getuid_sid($sid)))
{
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  echo "<b>permission Denied!</b><br/>";
  echo "<br/>Only mod/admin can use this page...<br/>";
  echo "<a href=\"index.php\">Home</a>";
  echo "</small></p>";
  echo "</card>";
  echo "</html>";
  exit();
}

if(islogged($sid)==false)
{
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  echo "You are not logged in<br/>";
  echo "Or Your session has been expired<br/><br/>";
  echo "<a href=\"index.php\">Login</a>";
  echo "</small></p>";
  echo "</card>";
  echo "</html>";
  exit();
}

addonline(getuid_sid($sid),"Prime Minister/Minister Tools","");

//////////////////////////boot user//////////////////////////

if($action=="boot")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
  $who = $_GET["who"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
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
  echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  }
  echo "</card>";
}
//////////////////delete session
else if($action=="delsess")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
  $who = $_GET["who"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"Admin Tools\">";
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
  $res = mysql_query("DELETE FROM dcroxx_me_ses WHERE uid='".$who."'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>User sessions deleted";
  mysql_query("DELETE FROM dcroxx_me_session_drop WHERE uid='".$who."'");
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error deleting";
  }
  echo "<br/><a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Admin Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  }
  echo "</small></p></card>";
}
//////////////////////////trash user//////////////////////////

else if($action=="trash")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
  $who = $_POST["who"];
  $pds = $_POST["pds"];
  $phr = $_POST["phr"];
  $pmn = $_POST["pmn"];
  $psc = $_POST["psc"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
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
 // $res = mysql_query("INSERT INTO dcroxx_me_penalties SET uid='".$who."', penalty='0', exid='".getuid_sid($sid)."', timeto='".$ptime."', pnreas='', ipadd='', browserm=''");
    $res = mysql_query("INSERT INTO dcroxx_me_metpenaltiespl SET uid='".$who."', penalty='0', exid='".getuid_sid($sid)."', timeto='".$ptime."', pnreas='".mysql_escape_string($pres)."', ipadd='".$uip."', browserm='".$ubr."'");

  if($res)
  {
//  mysql_query("INSERT INTO dcroxx_me_mlog SET action='trash', details='<b>".getnick_uid(getuid_sid($sid))."</b> Trashed The user <b>".$user."</b> For ".gettimemsg($timeto)."', actdt='".time()."'");
 mysql_query("UPDATE dcroxx_me_users SET lastpnreas='".mysql_escape_string($pres)."' WHERE id='".$who."'");
mysql_query("INSERT INTO dcroxx_me_mlog SET action='penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> $pmsg[$pid] The user <b>".$unick."</b> For ".$timeto." Seconds', actdt='".time()."'");

 echo "<img src=\"images/ok.gif\" alt=\"O\"/>$user trashed successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error trashing $user";
  }
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  }
  echo "</card>";
}

//////////////////////////ban user//////////////////////////

else if($action=="disablesht")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
  $who = $_POST["who"];
  $pres = $_POST["pres"];
  $pmn = $_POST["pmn"];
  $psc = $_POST["psc"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
 /* if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{*/
  $uid = getuid_sid($sid);
  echo "<br/>";
  if(trim($pres)=="")
  {
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>You must Specify a reson for disable shout";
  }else{
  $timeto += $pmn*60;
  $timeto += $psc;
  $ptime = $timeto + time();
  $res = mysql_query("INSERT INTO ibwfrr_disable_shout SET uid='".$uid."', timeto='".$ptime."', pnreas='".mysql_escape_string($pres)."'");
  if($res)
  {
  mysql_query("INSERT INTO dcroxx_me_mlog SET action='Shouts', details='<b>".getnick_uid(getuid_sid($sid))."</b> disable shoutbox ".gettimemsg($timeto)." For ".mysql_escape_string($pres)."', actdt='".time()."'");
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Shoutbox disable successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error disable shoutbox";
  }
  }
  //}
  echo "<br/><br/><a href=\"admincp2.php?action=admncp\"><img src=\"images/admn.gif\" alt=\"\"/>Admin Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
 // }
  echo "</card>";
}

else if($action=="enablesht")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
  $who = $_POST["who"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  $uid = getuid_sid($sid);
  $res = mysql_query("DELETE FROM dcroxx_me_disable_shout");
  if($res)
  {
  mysql_query("INSERT INTO dcroxx_me_mlog SET action='Shouts', details='<b>".getnick_uid(getuid_sid($sid))."</b> enable shoutbox', actdt='".time()."'");
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Shoutbox enable successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error enable shoutbox";
  }

  echo "<br/><br/><a href=\"admincp2.php?action=admncp\"><img src=\"images/admn.gif\" alt=\"\"/>Admin Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}
else if($action=="ban")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
  $who = $_POST["who"];
  $pres = $_POST["pres"];
  $pds = $_POST["pds"];
  $phr = $_POST["phr"];
  $pmn = $_POST["pmn"];
  $psc = $_POST["psc"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
 /* if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{*/
  $uid = getuid_sid($sid);
  $pRmxX = mysql_fetch_array(mysql_query("SELECT pRmxX FROM dcroxx_me_users WHERE id='".$uid."'"));
  $trgtpRmxX = mysql_fetch_array(mysql_query("SELECT pRmxX FROM dcroxx_me_users WHERE name='".$user."'"));
  if($trgtpRmxX>$pRmxX){ 
  echo "<b><img src=\"images/notok.gif\" alt=\"x\"/><br/>Error!!!<br/>permission Denied...</b><br/>";
  echo "<br/>U Cannot Ban $user<br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  exit;
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
 // $res = mysql_query("INSERT INTO dcroxx_me_penalties SET uid='".$who."', penalty='1', exid='".getuid_sid($sid)."', timeto='".$ptime."', pnreas='".mysql_escape_string($pres)."', ipadd='', browserm=''");
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
  //}
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"admincp2.php?action=admncp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  }
  echo "</card>";
}


else if($action=="unbn")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
  $who = $_GET["who"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"Admin Tools\">";
  echo "<p align=\"center\"><small>";
 /* $res = mysql_query("DELETE FROM dcroxx_me_penalties WHERE (penalty='1' OR penalty='2') AND uid='".$who."'");
  if($res)
  {
  $unick = getnick_uid($who);
  mysql_query("INSERT INTO dcroxx_me_mlog SET action='unbanned', details='<b>".getnick_uid(getuid_sid($sid))."</b> Unbanned The user <b>".$unick."</b>', actdt='".time()."'");
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick Unbanned";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
  }*/
  
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
  echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Admin Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////add site link//////////////////////////

else if($action=="addlink")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  $url = $_POST["url"];
  $title = $_POST["title"];
  echo $site;
  $res = mysql_query("INSERT INTO dcroxx_me_links SET url='".$url."', title='".$title."'");
  if($res)
  {
  echo mysql_error();
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Site $title Added Successfully<br/>";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error Adding Link<br/>";
  }
  echo "<br/>";
  echo "<a href=\"linksites.php?sid=$sid\">Links</a><br/>";
  echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
  }
//////////////////////////delete site link//////////////////////////

else if($action=="linkdel")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  $link=$_GET["link"];
  $sitena = mysql_query("SELECT title FROM dcroxx_me_links WHERE url='".$link."'");
  $site = mysql_fetch_array($sitena);
  $site=$site[0];
  $res = mysql_query("DELETE FROM dcroxx_me_links WHERE url='".$link."'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>$site deleted Successfully from links<br/>";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error deleting $site<br/>";
  }
  echo "<br/>";
  echo "<a href=\"linksites.php?sid=$sid\">Links</a><br/>";
  echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////

else if($action=="delclub")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
  $clid = $_GET["clid"];
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!<br/>";
  }else{
  $res = deleteClub($clid);
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Club Deleted<br/>";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error<br/>";
  }
  }
  echo "<br/><a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////

else if($action=="gccp")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
  $clid = $_GET["clid"];
  $plss = $_POST["plss"];
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!<br/>";
  }else{
  $nop = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_clubs WHERE id='".$clid."'"));
  $newpl = $nop[0] + $plss;
  $res = mysql_query("UPDATE dcroxx_me_clubs SET plusses='".$newpl."' WHERE id='".$clid."'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Club plusses updated<br/>";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error<br/>";
  }
  }
  echo "<br/><a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////

else if($action=="addcat")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
  $fcname = $_POST["fcname"];
  $fcpos = $_POST["fcpos"];
      echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
      echo "<p align=\"center\"><small>";
  if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{
        echo $fcname;
        echo "<br/>";
        $res = mysql_query("INSERT INTO dcroxx_me_fcats SET name='".$fcname."', position='".$fcpos."'");
        
        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Forum Category added successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error adding Forum Category";
      }
      }
      echo "<br/><br/><a  href=\"admincp2.php?action=fcats\">Forum Categories</a><br/>";
  echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

      echo "</small></p></card>";
}
//////////////////////////

else if($action=="addfrm")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
  $frname = $_POST["frname"];
  $frpos = $_POST["frpos"];
  $fcid = $_POST["fcid"];
      echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
      echo "<p align=\"center\"><small>";
  if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{
        echo $frname;
        echo "<br/>";
        $res = mysql_query("INSERT INTO dcroxx_me_forums SET name='".$frname."', position='".$frpos."', cid='".$fcid."'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Forum  added successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error adding Forum ";
      }
      }
      echo "<br/><br/><a href=\"admincp2.php?action=forums\">Forums</a><br/>";
      echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
      echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
      echo "</small></p></card>";
}
//////////////////////////

else if($action=="addchr")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
  $chrnm = $_POST["chrnm"];
  $chrage = $_POST["chrage"];
  $maxage = $_POST["maxage"];
  $chrpst = $_POST["chrpst"];
  $chrprm = $_POST["chrprm"];
  $chrcns = $_POST["chrcns"];
  $chrfun = $_POST["chrfun"];
      
      echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
      echo "<p align=\"center\"><small>";
  /*if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{*/
        echo $chrnm;
        echo "<br/>";
        $res = mysql_query("INSERT INTO dcroxx_me_rooms SET name='".$chrnm."', static='1', pass='', mage='".$chrage."', maxage='".$maxage."', chposts='".$chrpst."', pRmxXs='".$chrprm."', censord='".$chrcns."' , freaky='".$chrfun."'");
echo mysql_error();
        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Chatroom added successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error adding Chat room";
      }
    //  }
      echo "<br/><br/><a href=\"admincp2.php?action=chrooms\">Chatrooms</a><br/>";
      echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
      echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
      echo "</small></p></card>";
}
//////////////////////////

else if($action=="addpRmxX")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
  $fid = $_POST["fid"];
  $gid = $_POST["gid"];
      
      echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
      echo "<p align=\"center\"><small>";
  /*if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{*/
        echo "<br/>";
        $res = mysql_query("INSERT INTO dcroxx_me_acc SET fid='".$fid."', gid='".$gid."'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>permission  added successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error adding permission ";
      }
    //  }
      echo "<br/><br/><a href=\"admincp2.php?action=addpRmxX\">Add permission</a><br/>";
      echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
      echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
      echo "</small></p></card>";
}
//////////////////////////

else if($action=="addgrp")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
  $ugname = $_POST["ugname"];
  $ugaa = $_POST["ugaa"];
  $allus = $_POST["allus"];
  $mage = $_POST["mage"];
  $maxage = $_POST["maxage"];
  $mpst = $_POST["mpst"];
  $mpls = $_POST["mpls"];
  
      
      echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
      echo "<p align=\"center\"><small>";
 /* if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{*/
        echo $ugname;
        echo "<br/>";
        $res = mysql_query("INSERT INTO dcroxx_me_groups SET name='".$ugname."', autoass='".$ugaa."', userst='".$allus."', mage='".$mage."', maxage='".$maxage."', posts='".$mpst."', plusses='".$mpls."'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>User group  added successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error adding User group";
      }
     // }
      echo "<br/><br/><a href=\"admincp2.php?action=ugroups\">UGroups</a><br/>";
      echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
      echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
      echo "</small></p></card>";
}
//////////////////////////

else if($action=="edtfrm")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
  $fid = $_POST["fid"];
  $frname = $_POST["frname"];
  $frpos = $_POST["frpos"];
  $fcid = $_POST["fcid"];
      
      echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
      echo "<p align=\"center\"><small>";
  if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{
        echo $frname;
        echo "<br/>";
        $res = mysql_query("UPDATE dcroxx_me_forums SET name='".$frname."', position='".$frpos."', cid='".$fcid."' WHERE id='".$fid."'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Forum  updated successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error updating Forum ";
      }
      }
      echo "<br/><br/><a href=\"admincp2.php?action=forums\">Forums</a><br/>";
      echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
      echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
      echo "</small></p></card>";
}
//////////////////////////

else if($action=="edtcat")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
  $fcid = $_POST["fcid"];
  $fcname = $_POST["fcname"];
  $fcpos = $_POST["fcpos"];
      
      echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
      echo "<p align=\"center\"><small>";
  if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{
        echo $fcname;
        echo "<br/>";
        $res = mysql_query("UPDATE dcroxx_me_fcats SET name='".$fcname."', position='".$fcpos."' WHERE id='".$fcid."'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Forum Category updated successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error updating Forum Category";
      }
      }
      echo "<br/><br/><a  href=\"admincp2.php?action=fcats\">Forum Categories</a><br/>";
      echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
      echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
      echo "</small></p></card>";
}
//////////////////////////

else if($action=="delfrm")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
  $fid = $_POST["fid"];
      
      echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
      echo "<p align=\"center\"><small>";
  if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{
        echo "<br/>";
        $res = mysql_query("DELETE FROM dcroxx_me_forums WHERE id='".$fid."'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Forum  deleted successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error deleting Forum ";
      }
      }
      echo "<br/><br/><a href=\"admincp2.php?action=forums\">Forums</a><br/>";
      echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
      echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
      echo "</small></p></card>";
}
//////////////////////////

else if($action=="delgrp")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
  $ugid = $_POST["ugid"];
      
      echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
      echo "<p align=\"center\"><small>";
  /*if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{*/
        echo "<br/>";
        $res = mysql_query("DELETE FROM dcroxx_me_groups WHERE id='".$ugid."'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>UGroup  deleted successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error deleting UGroup";
      }
    //  }
      echo "<br/><br/><a href=\"admincp2.php?action=ugroups\">UGroups</a><br/>";
      echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
      echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
      echo "</small></p></card>";
}

else if($action=="validate")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
  $who = $_GET["who"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"Admin Tools\">";
  echo "<p align=\"center\"><small>";
  $res = mysql_query("Update dcroxx_me_users SET validated='1' WHERE id='".$who."'");
  if($res)
  {
  mysql_query("INSERT INTO dcroxx_me_private SET text='[b]NOTIFICATION:[/b][br/]Your account is validated by [b]Staff Team[/b]. You can enjoy our full features from now...[br/]Enjoy :)[br/][small]p.s: this is an automated pm[/small]', byuid='3', touid='".$who."', timesent='".time()."'");
  mysql_query("INSERT INTO dcroxx_me_mlog SET action='validation', details='<b>".getnick_uid(getuid_sid($sid))."</b> validated $user', actdt='".time()."'");
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>$user validated successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error validating $user";
  }
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Admin Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}
else if($action=="addsml")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
  $smlcde = $_POST["smlcde"];
  $smlsrc = $_POST["smlsrc"];
  echo "<card id=\"main\" title=\"Admin Tools\">";
  echo "<p align=\"center\"><small>";
  echo "<br/>";
  $res = mysql_query("INSERT INTO dcroxx_me_smilies SET scode='".$smlcde."', imgsrc='".$smlsrc."', hidden='0'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Smilie  added successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error adding Smilie ";
  }
  echo "<br/><br/><a href=\"admincp2.php?action=addsml\">Add Another Smilie</a><br/>";
  echo "<br/><a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Admin Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////delete smilie//////////////////////////

else if($action=="delsm")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
  $smid = $_GET["smid"];
  echo "<card id=\"main\" title=\"Admin Tools\">";
  echo "<p align=\"center\"><small>";
  echo "<br/>";
  $res = mysql_query("DELETE FROM dcroxx_me_smilies WHERE id='".$smid."'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Smilie  deleted successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error deleting smilie ";
  }
  echo "<br/><br/><a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Admin Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}

//////////////////////////

else if($action=="delchr")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
  $chrid = $_POST["chrid"];
      
      echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
      echo "<p align=\"center\"><small>";
  /*if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{*/
        echo "<br/>";
        $res = mysql_query("DELETE FROM dcroxx_me_rooms WHERE id='".$chrid."'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Room  deleted successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
      }
   //   }
      echo "<br/><br/><a href=\"admincp2.php?action=chrooms\">Chatrooms</a><br/>";
      echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
      echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
      echo "</small></p></card>";
}
//////////////////////////

else if($action=="delcat")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
  $fcid = $_POST["fcid"];
      
      echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
      echo "<p align=\"center\"><small>";
  if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{
        echo $fcname;
        echo "<br/>";
        $res = mysql_query("DELETE FROM dcroxx_me_fcats WHERE id='".$fcid."'");

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Forum Category deleted successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error deleting Forum Category";
      }
      }
      echo "<br/><br/><a  href=\"admincp2.php?action=fcats\">Forum Categories</a><br/>";
      echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
      echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
      echo "</small></p></card>";
}
//////////////////////////

else
{
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
?>
</html>

