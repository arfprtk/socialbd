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
//-----------------> ALL STATUS

if($action=="view")
{
     $pstyle = gettheme($sid);
      echo xhtmlhead("Status Updates",$pstyle);
    addonline(getuid_sid($sid),"Status Updates","statusupdates.php?action=$action");
    echo "<card id=\"main\" title=\"Status Updates\">";
	//echo "<p align=\"left\">"; 

    $who = $_GET["who"];
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    if($who=="")
    {
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_status"));
    }else{
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_status WHERE byuid='".$who."'"));
    }
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql
    if($who =="")
    {
        $sql = "SELECT id, status, uid, time, smood  FROM ibwfrr_status ORDER BY time DESC LIMIT $limit_start, $items_per_page";
}else{
    $sql = "SELECT id, status, uid, time, smood  FROM ibwfrr_status  WHERE uid='".$who."'ORDER BY time DESC LIMIT $limit_start, $items_per_page";
}

    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
        $shnick = getnick_uid($item[2]);
        $sht = findimage(getbbcode($item[1], $sid, 0));
        $shdt = date("d m y-H:i", $item[3]);
        $tremain = time() - $item[3];
        $tmdt = gettimemsg($tremain);
      //  if(ispu($item[2])) {$ppu = "<b>(Premium User!)</b>";} else {$ppu = "";}
        $sc = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_scomments WHERE statusid='".$item[0]."'"));
$comm = $sc[0];
$cmnt = "<a href=\"scomments.php?action=main&amp;statusid=$item[0]\">Comments</a> [$comm]";
/*if($item[4]>0)
{
    $smd = mysql_fetch_array(mysql_query("SELECT img, details FROM ibwf_sactivity WHERE id='".$item[4]."'"));
    $shows = " - <img src=\"$smd[0]\" alt=\"*\" /> <b>$smd[1]</b>";
}
else
{
    $shows = "";
}*/
  
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[2]\">$shnick</a> (".getstatus($item[2]).") $ppu $shows<br/>$sht<br/>$cmnt<br/>$tmdt ago";
      if($item[2]==$uid || ismod(getuid_sid($sid)))
      {
      $dlsh = "<a href=\"genproc.php?action=delstatus&amp;shid=$item[0]\">(x)</a>";
      }else{
        $dlsh = "";
      }
      $avlink = getavatar($item[2]);
if($avlink=="")
{
$avl = "<img src=\"images/nopic.jpg\" height=\"28\" width=\"25\" alt=\"x\"/>";
}else{
$avl = "<img src=\"$avlink\" height=\"28\" width=\"25\" alt=\"0\"/>";
}
if(isonline($item[2]))
  {
    $iml = "[o] ";
    
  }else{
    $iml = "[x] ";
  }
      echo "$avl $lnk $dlsh<br/>";
        $lstlike = mysql_fetch_array(mysql_query("SELECT uid FROM ibwf_statuslike WHERE rate='1' AND statusid='".$item[0]."' ORDER BY time DESC LIMIT 1"));
        $lstdislike = mysql_fetch_array(mysql_query("SELECT uid FROM ibwf_statuslike WHERE rate='0' AND statusid='".$item[0]."' ORDER BY time DESC LIMIT 1"));
        $lnick = getnick_uid($lstlike[0]);
        $dlnick = getnick_uid($lstdislike[0]);
        
      $likes = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_statuslike WHERE rate='1' AND statusid='".$item[0]."'"));
      $dislikes = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_statuslike WHERE rate='0' AND statusid='".$item[0]."'"));
      if($likes[0]==1) {echo "<b>$lnick likes this</b><br/>";}else if($likes[0]>1){$eto= $likes[0]-1; echo "<b>$lnick and $eto others like this</b><br/>";}
      if($dislikes[0]==1) {echo "<b>$dlnick dislikes this</b><br/>";}else if($dislikes[0]>1){$eto= $dislikes[0]-1; echo "<b>$dlnick and $eto others dislike this</b><br/>";}
      echo "<a href=\"genproc.php?action=statuslike&amp;shid=$item[0]\">Like</a>/<a href=\"genproc.php?action=statusdislike&amp;shid=$item[0]\">Dislike</a>";
      echo " [<a href=\"statusupdates.php?action=statuslike&amp;shid=$item[0]\">$likes[0]</a>/<a href=\"statusupdates.php?action=statusdislike&amp;shid=$item[0]\">$dislikes[0]</a>]<br/>--------<br/>";
    }
    }
    echo "</small></p>";
    echo "<p align=\"center\"><small>";
    //echo getnormalad($sid);
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"statusupdates.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"statusupdates.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"statusupdates.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"who\" value=\"$who\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "<br/>";
    echo "</small></p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\"><small>";
echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a><br/><br/>";
echo "</small></p>";
echo "</card>";
}

//////////////////////update status
else if($action=="update"){
  $pstyle = gettheme($sid);
    echo xhtmlhead("Status Updates",$pstyle);
  $shtxt = $_POST["shtxt"];
  //$smood = isnum((int)$_POST["smood"]);
    addonline(getuid_sid($sid),"Updating Status","");
if(strlen($shtxt)<10){
 echo "<card id=\"main\" title=\"$sitename\">"; 
       echo "<p align=\"center\"><small>";
      echo "Status is blank or short. Your status must contain at least 10 characters.<br/>";
echo"<br/>";
      echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\" />Home</a>";
      echo "</small></p>";
echo "</card>";
      echo "</wml>";
      exit();
}

    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"center\"><small>";
    if(getplusses(getuid_sid($sid))<10)
{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>You should have at least 10 plusses to update your status!<br/><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</p>";
echo "</card>";
echo "</wml>";
exit();
}
/*if(isblocked($shtxt,$uid))
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
mysql_query("insert into ibwfrr_shouts (shout,shouter,shtime) values ('Member: [b]".$user."[/b] auto banned by [b]ChatGirl[/b] for spamming in status','3','$w3btime')");
//--------------------------> Auto Shout BY CybeR_PrinCe
   //mysql_query("INSERT INTO ibwfrr_private SET text='<b>(forwarded spam via inbox)</b>[br/]".$pmtext."', byuid='".$byuid."', touid='1', timesent='".$tm."',reported='1'");
 mysql_query("INSERT INTO ibwfrr_private SET text='[b](forwarded spam via status comments)[/b][br/]".$shtxt."', byuid='".$uid."', touid='1', timesent='".$tm."',reported='1'");  
  echo "<br/><a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
   echo "</small></p></card>";
      echo "</wml>";
      exit();
  }*/

$q = mysql_fetch_assoc(mysql_query("SELECT time FROM ibwfrr_status ORDER BY id DESC LIMIT 1"));
$st = $q['time'];
$now = time();
$dif=$now - $st;
$wait= 30 - $dif;
if($dif<'30')
{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>A status has been added recently.<br/>So you have to wait $wait seconds to add your status!<br/><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p>";
echo "</card>";
echo "</wml>";
exit();
}
      $shtxt = $shtxt;
    //$uid = getuid_sid($sid);
    $shtm = time();
    $res = mysql_query("INSERT INTO ibwfrr_status SET status='".$shtxt."', uid='".$uid."', smood='".$smood."', time='".$shtm."'");
    if($res)
    {
        ///---------------> RECENT ACTIVITIES
        $ibwf = time();
$nick = getnick_uid($uid);
mysql_query("insert into ibwfrr_events (uid,event,time) values ('$uid','<b>$nick</b> updated his/her status','$ibwf')");
/*$txt = htmlspecialchars(substr(parsepm($shtxt), 0, 20));
$note2 = "[user=$uid]$nick"."[/user] updated his/her status - [aFardin=statusupdates.php?action=view&who=$uid]$txt..."."[/aFardin]";
followersnotity($note2, $uid);*/
    echo "<img src=\"images/ok.gif\" alt=\"O\"/>Status added successfully";
    }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
    }
echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a><br/><br/>";
echo "</small></p>";
echo "</card>";
}

else if($action=="statuslike")
{
    $shid = $_GET['shid'];
    addonline(getuid_sid($sid),"Status likers","statusupdates.php?action=$action&amp;shid=$shid");
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"center\"><small>";
    echo "<b>Users Who Like This Status</b><br/><br/>";
    $shout = mysql_fetch_array(mysql_query("SELECT id, status, uid FROM ibwfrr_status WHERE id='".$shid."'"));
    echo getnick_uid($shout[2]);
    echo ": $shout[1]<br/><br/>";
    $vb = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_statuslike WHERE uid='".$uid."' AND statusid='".$shid."'"));
    if($vb[0]>0){echo "";}
    else {
        echo "<a href=\"genproc.php?action=statuslike&amp;shid=$shid\">Like</a>/<a href=\"genproc.php?action=statusdislike&amp;shid=$shid\">Dislike</a><br/>";
    }
    echo "</small></p>";
    //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM ibwf_statuslike WHERE rate='1' AND statusid='".$shid."'"));
    
    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT uid, time FROM ibwf_statuslike WHERE rate='1' AND statusid='".$shid."' ORDER BY time DESC LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $tremain = time() - $item[1];
      $tmdt = gettimemsg($tremain)." ago";
      $lnk = "<small><a href=\"member.php?action=viewuser&amp;who=$item[0]\">".getnick_uid($item[0])."</a> ($tmdt)</small>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"statusupdates.php?action=$action&amp;page=$ppage\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"statusupdates.php?action=$action&amp;page=$npage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"statusupdates.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
  echo "<p align=\"center\"><small>";
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a><br/><br/>";
echo "</small></p>";
echo "</card>";
}
else if($action=="statusdislike")
{
    $shid = $_REQUEST['shid'];
    addonline(getuid_sid($sid),"Status dislikers","status.php?action=$action&amp;shid=$shid");
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"center\"><small>";
    echo "<b>Users Who Dislike This Status</b><br/><br/>";
    $shout = mysql_fetch_array(mysql_query("SELECT id, status, uid FROM ibwfrr_status WHERE id='".$shid."'"));
    echo getnick_uid($shout[2]);
    echo ": $shout[1]<br/><br/>";
    $vb = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_statuslike WHERE uid='".$uid."' AND statusid='".$shid."'"));
    if($vb[0]>0){echo "";}
    else {
        echo "<a href=\"genproc.php?action=statuslike&amp;shid=$shid\">Like</a>/<a href=\"genproc.php?action=statusdislike&amp;shid=$shid\">Dislike</a><br/>";
    }
    echo "</small></p>";
    //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM ibwf_statuslike WHERE rate='0' AND statusid='".$shid."'"));
    
    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT uid, time FROM ibwf_statuslike WHERE rate='0' AND statusid='".$shid."' ORDER BY time DESC LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $tremain = time() - $item[1];
      $tmdt = gettimemsg($tremain)." ago";
      $lnk = "<small><a href=\"member.php?action=viewuser&amp;who=$item[0]\">".getnick_uid($item[0])."</a> ($tmdt)</small>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"statusupdates.php?action=$action&amp;page=$ppage\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"statusupdates.php?action=$action&amp;page=$npage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"statusupdates.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
  echo "<p align=\"center\"><small>";
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a><br/><br/>";
echo "</small></p>";
echo "</card>";

}

?>
</html>
