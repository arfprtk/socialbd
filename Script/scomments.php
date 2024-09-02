<?php
  session_name("PHPSESSID");
session_start();

include("xhtmlfunctions.php");
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";
?>
<?php
include("config.php");
include("core.php");
connectdb();
$ubr=$_SERVER['HTTP_USER_AGENT'];
$uip = getip();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$who = $_GET["who"];
$uid=getuid_sid($sid);
    if(islogged($sid)==false)
    {
      $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle Bank",$pstyle);
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
      echo xhtmlhead("$stitle Bank",$pstyle);
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

$res = mysql_query("UPDATE dcroxx_me_users SET browserm='".$ubr."', ipadd='".$uip."' WHERE id='".getuid_sid($sid)."'");

if($action=="main")
{
addvisitor();
addonline(getuid_sid($sid),"Status Comments","");
$pstyle = gettheme($sid);
echo xhtmlhead("Status Comments",$pstyle);
echo "<card id=\"main\" title=\"Status Comments\">";
echo "<p align=\"left\"><small>";

//--------------------------> STATUS COMMENTS
$statusid = $_GET['statusid'];

if($page=="" || $page<=0) {$page=1;}
$count = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) page FROM ibwfrr_scomments WHERE statusid='".$statusid."'"));

$num_items = $count['page']; //changable
$event_per_page= 7;
$num_pages = ceil($num_items/$event_per_page);
if(($page>$num_pages)&&$page!=1) {$page= $num_pages;}
$limit_start = ($page-1)*$event_per_page;

$lshout = mysql_fetch_array(mysql_query("SELECT status, uid FROM ibwfrr_status WHERE id='".$statusid."'"));
$shnick = getnick_uid($lshout[1]);
$text = parsepm($lshout[0],$sid);
echo '</small></p>';
echo "<small><center><b>Status By <a href=\"index.php?action=viewuser&amp;who=$lshout[0]\">$shnick</a></b><br/>";
echo "$text</center></small><br/>";

echo '</p><p align="left"><small>';
//---------------------> STATUS COMMENT

$results = mysql_query("SELECT * FROM ibwfrr_scomments WHERE statusid='".$statusid."' ORDER BY stime ASC LIMIT $limit_start, $event_per_page");
while ($event = mysql_fetch_assoc($results)){
$user = $event['uid'];
$unick = getnick_uid($user);

echo "<a href=\"member.php?action=viewuser&amp;who=$user\">$unick</a>: ";
echo getbbcode($event[scomments],$sid,1)."<br/>";
echo "<small>(".date("jS M Y - h:i:s A",($event[stime] + (6 * 60 * 60))).")</small><br/><br/>";
}
echo "</small></p>";
echo "<p align=\"left\"><small>";
if($page>1)
{
$ppage = $page-1;
echo "<a href=\"scomments.php?action=main&amp;page=$ppage&amp;statusid=$statusid\">&#171;</a> ";
}
if($page<$num_pages)
{
$npage = $page+1;
echo "<a href=\"scomments.php?action=main&amp;page=$npage&amp;statusid=$statusid\">&#187;</a>";
}
echo "<br/>$page/$num_pages<br/>";
//echo "<p align=\"center\">";
//---------------------> STATUS COMMENT
/*echo "Comment:<br/><input type=\"text\" name=\"scomments\"/><br/>";
echo "<anchor>Add Comments";
echo "<go href=\"scomments.php?action=addcomm&amp;sid=$sid&amp;statusid=$statusid\" method=\"post\">";
echo "<postfield name=\"scomments\" value=\"$(scomments)\"/>";
echo "</go>";
echo "</anchor><br/>";*/

echo"
<form method=\"post\" action=\"scomments.php?action=addcomm&amp;statusid=$statusid\">
<b>Comment:</b><br/><textarea name=\"scomments\" style=\"height:30px;width: 270px;\" ></textarea><br/>
<input type=\"submit\" name=\"Submit\" value=\"Add Comments\"/><br/>
</form>";



echo "</p>";
}
else if($action=="addcomm")
{
addvisitor();
addonline(getuid_sid($sid),"Adding Comment","scomments.php?action=$action");
$pstyle = gettheme($sid);
echo xhtmlhead("Status Comments",$pstyle);
echo "<card id=\"main\" title=\"Adding Comments\">";
echo "<p align=\"center\"><small>";
$statusid = $_GET['statusid'];
$stext = $_POST['scomments'];
$stime = time();
$uid = getuid_sid($sid);
/*if(isblocked($stext,$uid))
  {
$bantime = time() + (1*24*60*60);
echo "<img src=\"../images/notok.gif\" alt=\"X\"/>";
echo "Can't Send Inbox to $whonick<br/><br/>";
    echo "Dont try To Spam here.otherwise u will be Banned!!";
    $user = getnick_sid($sid);
    mysql_query("INSERT INTO ibwfrr_mlog SET action='autoban', details='<b>ChatGirl</b> auto banned $user for spamming in status comments', actdt='".time()."'"); 
    mysql_query("INSERT INTO ibwfrr_mlog SET action='boot', details='<b>ChatGirl</b> booted $user', actdt='".time()."'");
    // mysql_query("INSERT INTO ibwfrr_penalties SET uid='".$byuid."', penalty='1', exid='2', timeto='".$bantime."', pnreas='Don't disturb my site beadob member'");
mysql_query("INSERT INTO ibwfrr_penalties SET uid='".$uid."', penalty='1', exid='2', timeto='".$bantime."', pnreas='Banned: Automatic Ban for spamming'");
mysql_query("DELETE FROM ibwfrr_ses WHERE uid='".$uid."'");
//--------------------------> Auto Shout BY CybeR_PrinCe
$w3btime = time();
$user = getnick_uid($uid);
mysql_query("insert into ibwfrr_shouts (shout,shouter,shtime) values ('Member: [b]".$user."[/b] auto banned by [b]ChatGirl[/b] for spamming in status comments','3','$w3btime')");
//--------------------------> Auto Shout BY CybeR_PrinCe
   //mysql_query("INSERT INTO ibwfrr_private SET text='<b>(forwarded spam via inbox)</b>[br/]".$pmtext."', byuid='".$byuid."', touid='1', timesent='".$tm."',reported='1'");
 mysql_query("INSERT INTO ibwfrr_private SET text='[b](forwarded spam via status comments)[/b][br/]".$stext."', byuid='".$uid."', touid='1', timesent='".$tm."',reported='1'");  
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
   echo "</small></p></card>";
      echo "</wml>";
      exit();
  }*/

  $q=mysql_fetch_assoc(mysql_query("SELECT stime FROM ibwfrr_scomments WHERE uid='".$uid."' ORDER BY id DESC LIMIT 1"));
$st=$q['stime'];
$now=time();
$dif=$now - $st;
$wait= 30 - $dif;
if($dif<'30')
{
echo "<img src=\"images/notok.gif\" alt=\"X\"/> You have added a comment recently.<br/>So you have to wait $wait seconds to add new comment!<br/><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p>";
echo "</card>";
echo "</wml>";
exit();
}

$pex = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_scomments WHERE scomments LIKE '".$stext."'"));
if($pex[0]==0)
{
	
if(trim($stext)!="" && strlen($stext) > "5"){
mysql_query("INSERT INTO ibwfrr_scomments SET statusid='".$statusid."', scomments='".$stext."', uid='".$uid."', stime='".$stime."'");
mysql_query("UPDATE ibwfrr_status SET lastupdate='".$stime."' WHERE id='".$statusid."'");
///////////////// <----------------Notification By Tufan420-------------->
/*$shid = $statusid;
$nick = getnick_sid($sid);
$shtx = mysql_fetch_array(mysql_query("SELECT status, uid FROM ibwfrr_status WHERE id='".$shid."'"));
$txt = htmlspecialchars(substr(parsepm($shtx[0]), 0, 20));
$note = "[user=$uid]$nick"."[/user] commented on your status - [aTufan420=scomments.php?action=main&statusid=$shid]$txt..."."[/aTufan420]";
notify($note,$uid,$shtx[1]);
$note2 = "[user=$uid]$nick"."[/user] commented on the status of [user=".$shtx[1]."]".getnick_uid($shtx[1])."[/user] - [aTufan420=scomments.php?action=main&statusid=$shid]$txt..."."[/aTufan420]";
followersnotity($note2, $uid);*/
///////////////// <----------------Notification By Tufan420-------------->
echo "<img src=\"images/ok.gif\" alt=\"O\"/>Comment Added Successfully<br/>";
} else {
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error Adding Comment<br/>";
}

}else{
echo "<img src=\"images/be2.gif\" alt=\"X\"/><br/><b>Idiot!!!</b><br/>
Don't try to flood in Comments. Same text can't be added<br/>It's anti-protection By <b>TuFaN420</b>";
}
}

echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a><br/>";

echo "</small></p>";
echo "</card>";
?>
</html>
