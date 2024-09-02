<?php
session_name("PHPSESSID");
session_start();

include("xhtmlfunctions.php");
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";

?>
<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> 
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
addonline(getuid_sid($sid),"Invite Friends","invite.php?action=main");
if($action=="main")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Invite Friends",$pstyle);
echo "<card id=\"main\" title=\"Invite Friends\">";

echo "<p align=\"left\">";

        $sitelink = "SocialBD.NeT";
        echo "Dear users, we are always with you. So, we have decided that we will try to give you some special items for per active user on referring<br/><br/>";
	echo "We are now offering <b><font color=\"red\"><img src=\"goldencoin.png\" alt=\"Golden Coin\" height=\"20\" width=\"20\" title=\"Golden Coin\"/>9 Golden Coins</font> + 
	<font color=\"green\"><img src=\"verified_user.png\" alt=\"VIP Membership\" height=\"20\" width=\"20\" title=\"VIP Membership\"/>3 Days VIP</font> + 
	<font color=\"red\"><img src=\"earning_zone1.png\" alt=\"BDT\" height=\"20\" width=\"25\" title=\"BDT\"/>3 BDT</font></b> per invited active members! <br/>";
	echo"Here invited active member means whose total Online Time is more than <b><font color=\"red\">1 days and 12 hours</font></b><br/>";
		echo"<b>N.B: You can use your money for unlock some hidden features or can withdraw via 
		<font color=\"red\">Top Up</font>/<font color=\"magenta\">bKash</font>/<font color=\"blue\">Paypal</font>/<font color=\"green\">Payza</font></b><br/><br/>";

	echo "<b>How to invite?</b><br/>";
	echo "Simply give this invitation link- <b>http://socialbd.net/?r=$uid</b> to your friends and tell them to join and active here using this link.<br/><br/>";

	$rmc = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_invite"));
	$rm0c = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_invite WHERE invitedby='".$uid."'"));
	//echo "$sitename members have already invited <b>$rmc[0]</b> of their friends!<br/>";
	//echo "<a href=\"invite.php?action=allinvitedmembers\">List Of All Invited Members</a><br/><br/>";
if(isowner(getuid_sid($sid))){
$pff = "<a href=\"?action=allinvitedmembers\">$rmc[0] Members</a>";
}else{
$pff = "<a href=\"\">$rmc[0] Members</a>";}
	echo "Your Referral: <b><a href=\"invite.php?action=invitedmembers&who=$uid\">$rm0c[0] Members</a> Out Of $pff</b><br/>";
	$rearn = mysql_fetch_array(mysql_query("SELECT ref_goldencoin, ref_vip, ref_amount FROM dcroxx_me_users WHERE id='".$uid."'"));
	$doller = $rearn[2]/80;
	echo "Your Earn: <b><font color=\"red\"><img src=\"goldencoin.png\" alt=\"Golden Coin\" height=\"20\" width=\"20\" title=\"Golden Coin\"/>$rearn[0] Golden Coins</font> , 
	<font color=\"green\"><img src=\"verified_user.png\" alt=\"VIP Membership\" height=\"20\" width=\"20\" title=\"VIP Membership\"/>$rearn[1] Days VIP</font> , 
	<font color=\"red\"><img src=\"earning_zone1.png\" alt=\"BDT\" height=\"20\" width=\"25\" title=\"BDT\"/>$rearn[2] BDT</font>/<font color=\"red\">$doller US Doller</font></b><br/><br/>";

	echo "<b>Wanna Withdraw?</b><br/>";
	echo "Program is under processing...........<br/><br/>";

echo"<link rel=\"stylesheet\" id=\"BNS-Corner-Logo-Style-css\"  href=\"social_icons.css\" type=\"text/css\" media=\"screen\" />";
	echo "<b>Share: </b><br/>";


echo "<div class=\"social-icons\"><ul>";

echo "<li class=\"twitter\" style=\"background-color: #f0f0f0\">
<a href=\"https://twitter.com/home?status=Please%20join%20this%20awesome%20site%20and%20earn%20from%20invitation%20page%0Ahttp%3A//socialbd.net/?r=$uid\">Twitter</a>
</li>";

echo "<li class=\"facebook\" style=\"background-color: #f0f0f0\">
<a href=\"https://www.facebook.com/sharer/sharer.php?u=Please%20join%20this%20awesome%20site%20and%20earn%20from%20invitation%20page%20http%3A//socialbd.net/?r=$uid\">Facebook</a>
</li>";

echo "<li class=\"googleplus\" style=\"background-color: #f0f0f0\">
<a href=\"https://plus.google.com/share?url=Please%20join%20this%20awesome%20site%20and%20earn%20from%20invitation%20page%20http%3A//socialbd.net/?r=$uid\">Google +</a>
</li>";

//<a href=\"sms:?body=Hi Friend! Visit This Site And Join Here..http://$sitelink/?r=$uid\">Invite Via SMS</a>


echo "</ul></div>";
echo "<br/><br/><br/>Don't try to create multi ids using your invitation link cause it will return punishments to your account.<br/>";

echo "</small></p><p align=\"center\"><small>";
echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";


echo "</small></p>";
echo "</card>";
}
///////////////////////////// All invited members list
else if($action=="allinvitedmembers")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Invite Friends",$pstyle);
	addonline(getuid_sid($sid),"Viewing All Invited Members ","");
	
if(!isowner(getuid_sid($sid))){
echo "Sorry, you are not from Admin Section<br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p></card>";
exit();	
}

	echo "<card id=\"main\" title=\"All Invited Members\">";
    echo "<small><p align=\"center\">";
    echo "<b>All Invited Members</b></p><br/>";
    echo "<p align=\"left\">";
        //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $num_items = invitedmemcount(); //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    
    $sql = "SELECT id, invite, invitedby, regdate, status FROM dcroxx_me_invite ORDER BY regdate DESC LIMIT $limit_start, $items_per_page";
    $items = mysql_query($sql);
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $jdt = date("d-m-y", $item[2]);
      $refid = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$item[1]."'"));
      $lnk = "Member: <a href=\"index.php?action=viewuser&amp;who=$item[1]\">$refid[0]</a>";
      echo "$lnk<br/>";
      $refby = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$item[2]."'"));
      echo "Invited By: <a href=\"index.php?action=viewuser&amp;who=$item[2]\">$refby[0]</a><br/>";
      //$posts = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_posts WHERE uid='".$item[1]."'"));
      //echo "Posts: <b>$posts[0]</b><br/>";
    
$totaltimeonline = mysql_fetch_array(mysql_query("SELECT totaltime FROM dcroxx_me_users WHERE id='".$item[1]."'"));
$num = $totaltimeonline[0]/86400;
$days = intval($num);
$num2 = ($num - $days)*24;
$hours = intval($num2);
$num3 = ($num2 - $hours)*60;
$mins = intval($num3);
$num4 = ($num3 - $mins)*60;
$secs = intval($num4);

echo "Total Online Time: ";
if(($days==0) and ($hours==0) and ($mins==0)){
  echo "<b>$secs seconds</b><br/>";
}else
if(($days==0) and ($hours==0)){
  echo "<b>$mins mins,</b> ";
  echo "<b>$secs seconds</b><br/>";
}else
if(($days==0)){
  echo "<b>$hours hours, </b>";
  echo "<b>$mins mins,</b> ";
  echo "<b>$secs seconds</b><br/>";
}else{
  echo "<b>$days days,</b> ";
  echo "<b>$hours hours,</b> ";
  echo "<b>$mins mins,</b> ";
  echo "<b>$secs seconds</b><br/>";
}
 if(isowner(getuid_sid($sid))){
 $pff = " <a href=\"?action=inviteashweiwebnjsfrewards&amp;id=$item[0]\">[Paid&#187;&#187;]</a>";
}else{}
            if ($item[4]=="0")
      {
      	$status = "<b>Pending$pff</b>";
      }else{
      	$status= "<b>Paid</b>";
      }
      echo "Bonus Status: $status<br/>";
      $jdt = date("dS F y - h:i:s A", $item[3]);
      echo "Joined Date: <b>$jdt</b><br/>";
      
      echo "--------------<br/><br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"invite.php?action=allinvitedmembers&amp;page=$ppage\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"invite.php?action=allinvitedmembers&amp;page=$npage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"invite.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        //$rets .= "<postfield name=\"view\" value=\"$view\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
    //////////////////// Until here
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" />Home</a>";
    echo "</p></small></card>";
}
/////////////////////// <------------- Members invited by some one--------------->
else if($action=="invitedmembers")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Invited Members",$pstyle);
    $who = $_GET["who"];
    $unick = getnick_uid($who);
	addonline(getuid_sid($sid),"Viewing User Invited Members","");
	echo "<card id=\"main\" title=\"Members Invited By $unick\">";
    echo "<p align=\"center\">";
    echo "<b>Members Invited By $unick</b></p><br/>";
    echo "<p align=\"left\">";
        //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_invite WHERE invitedby='".$who."'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    
    $sql = "SELECT id, invite, invitedby, regdate, status FROM dcroxx_me_invite WHERE invitedby='".$who."' ORDER BY regdate DESC LIMIT $limit_start, $items_per_page";
    $items = mysql_query($sql);
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $jdt = date("d-m-y", $item[2]);
      $refid = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$item[1]."'"));
      $lnk = "Member: <a href=\"index.php?action=viewuser&amp;who=$item[1]\">$refid[0]</a>";
      echo "$lnk<br/>";
      $refby = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$item[2]."'"));
      echo "Invited By: <a href=\"index.php?action=viewuser&amp;who=$item[2]\">$refby[0]</a><br/>";
      //$posts = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_posts WHERE uid='".$item[1]."'"));
      //echo "Posts: <b>$posts[0]</b><br/>";
    
$totaltimeonline = mysql_fetch_array(mysql_query("SELECT totaltime FROM dcroxx_me_users WHERE id='".$item[1]."'"));
$num = $totaltimeonline[0]/86400;
$days = intval($num);
$num2 = ($num - $days)*24;
$hours = intval($num2);
$num3 = ($num2 - $hours)*60;
$mins = intval($num3);
$num4 = ($num3 - $mins)*60;
$secs = intval($num4);

echo "Total Online Time: ";
if(($days==0) and ($hours==0) and ($mins==0)){
  echo "<b>$secs seconds</b><br/>";
}else
if(($days==0) and ($hours==0)){
  echo "<b>$mins mins,</b> ";
  echo "<b>$secs seconds</b><br/>";
}else
if(($days==0)){
  echo "<b>$hours hours, </b>";
  echo "<b>$mins mins,</b> ";
  echo "<b>$secs seconds</b><br/>";
}else{
  echo "<b>$days days,</b> ";
  echo "<b>$hours hours,</b> ";
  echo "<b>$mins mins,</b> ";
  echo "<b>$secs seconds</b><br/>";
}


 if(isowner(getuid_sid($sid))){
 $pff = " <a href=\"?action=inviteashweiwebnjsfrewards&amp;id=$item[0]\">[&#187;Paid&#187;]</a>";
}else{}
            if ($item[4]=="0")
      {
      	$status = "<b>Pending$pff</b>";
      }else{
      	$status= "<b>Paid</b>";
      }
      echo "Bonus Status: $status<br/>";
      $jdt = date("dS F y - h:i:s A", $item[3]);
      echo "Joined Date: <b>$jdt</b><br/>";
      
      echo "--------------<br/><br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"invite.php?action=invitedmembers&amp;page=$ppage&amp;who=$who\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"invite.php?action=invitedmembers&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"invite.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        //$rets .= "<postfield name=\"view\" value=\"$view\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
    //////////////////// Until here
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" />Home</a>";
    echo "</p></card>";
}

else if($action=="inviteashweiwebnjsfrewards")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
	
if(!isowner(getuid_sid($sid))){
echo "Sorry, you are not from Admin Section<br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p></card>";
exit();	
}
	
  $id = $_GET["id"];
$re = mysql_fetch_array(mysql_query("SELECT id, invite, invitedby, regdate, status FROM dcroxx_me_invite WHERE id='".$id."'"));

  $whonick = getnick_uid($re[2]);
  $comment = $_GET["comment"];
  echo "<card id=\"main\" title=\"Admin Tools\">";
  echo "<p align=\"center\"><small>";
 if($comment==""){ 
  echo"Are you sure that you want to do this act for $whonick???<br/>
  <a href=\"?action=inviteashweiwebnjsfrewards&id=$id&comment=proceed\">Yeah, I'm Sure</a><br/>
  <a href=\"index.php?action=main\">No, It's a Mistake</a><br/>
  ";
  
  }else if($comment=="proceed"){
    $id = $_GET["id"];
$r0e = mysql_fetch_array(mysql_query("SELECT status FROM dcroxx_me_invite WHERE id='".$id."'"));

if ($r0e[0]>0){
echo "Sorry, this rewards has been already paid!<br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p></card>";
exit();	
}




$re = mysql_fetch_array(mysql_query("SELECT id, invite, invitedby, regdate, status FROM dcroxx_me_invite WHERE id='".$id."'"));
$res = mysql_query("UPDATE dcroxx_me_invite SET status='1' WHERE id='".$id."'");
if($res){
$re = mysql_fetch_array(mysql_query("SELECT id, invite, invitedby, regdate, status FROM dcroxx_me_invite WHERE id='".$id."'"));
$rew = mysql_fetch_array(mysql_query("SELECT ref_goldencoin, ref_vip, ref_amount, golden_coin, ptime, balance FROM dcroxx_me_users WHERE id='".$re[2]."'"));
$userr = $re[2];
$newgc = $rew[0]+9;
$newgc1 = $rew[3]+9;
$newvip = $rew[1]+3;
$newbl = $rew[2]+3;
$newbl1 = $rew[5]+3;

mysql_query("UPDATE dcroxx_me_users SET ref_goldencoin='".$newgc."', ref_vip='".$newvip."', 
ref_amount='".$newbl."', golden_coin='".$newgc1."', balance='".$newbl1."' WHERE id='".$userr."'");

if(ispu($userr)){
$opl = mysql_fetch_array(mysql_query("SELECT ptime FROM dcroxx_me_users WHERE id='".$userr."'"));
$pval = 3*24*60*60;
$npl = $opl[0] + $pval;
$vtime = $npl + time();
mysql_query("UPDATE dcroxx_me_users SET ptime='".$npl."' WHERE id='".$userr."'");
}else{
mysql_query("UPDATE dcroxx_me_users SET specialid='17' WHERE id='".$userr."'");
$timeto = 3*24*60*60;
$vtime = $timeto + time();
mysql_query("UPDATE dcroxx_me_users SET ptime='".$vtime."' WHERE id='".$userr."'");
}

echo "REWARDS:<br/>
<img src=\"images/ok.gif\" alt=\"O\"/> 9 Golden Coins Added Successfully<br/>
<img src=\"images/ok.gif\" alt=\"O\"/> 3 Days VIP Added Successfully<br/>
<img src=\"images/ok.gif\" alt=\"O\"/> 3 BDT/0.0375 Doller Added Successfully<br/>
";
  $whoick = getnick_uid($re[1]);
  $whoiick = getnick_uid($re[2]);
  $reu = $re[1];
mysql_query("INSERT INTO ibwf_notifications SET text='[image_preview=Gift-Box.png] You have successfully rewarded [b][red]9 Golden Coins[/red], [green]3 Days VIP[/green], [red]3 BDT/0.0375 Doller[/red][/b] for inviting [user=$reu]$whoick"."[/user]. Keep inviting your friends and get more rewards. :)', touid='".$userr."', timesent='".time()."'");
mysql_query("INSERT INTO dcroxx_me_mlog SET action='REWARDS', details='<b>".getnick_uid(getuid_sid($sid))."</b> rewarded 9GC+3days VIP+3BDT to <a href=\"index.php?action=viewuser&amp;who=$userr\">$whoiick</a> account', actdt='".time()."'");

  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error deleting smilie ";
  }
 // echo"OK";
  }else{
echo"Something must be went wrong. Contact with Saitano Ka Grand-Father as soon as possible.<br/>";
  }
  echo "<br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
/////////////////////error//////////////////////////

else
{
  echo "<card id=\"main\" title=\"Invite Friends\">";
  echo "<p align=\"center\"><small>";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
?>
</html>