<?php
    session_name("PHPSESSID");
session_start();
include("xhtmlfunctions.php");
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
?>
<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> 
<link href="SocialBD.css" media="screen, handheld" rel="stylesheet" type="text/css" />
<?php
include("config.php");
include("core.php");
connectdb();
$sid = $_SESSION["sid"];
$page = $_GET["page"];
$who = $_GET["who"];
$pmid = $_GET["pmid"];
$whonick = getnick_uid($who);
$byuid = getuid_sid($sid);
$uid = getuid_sid($sid);
$action = $_GET["action"];
$sitename = mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE name='sitename'"));
$sitename = $sitename[0];
$ubrw = explode(" ",$HTTP_USER_AGENT);
$ubrw = $ubrw[0];
$ipad = getip();
if(islogged($sid)==false)
{
      $pstyle = gettheme1("1");
      echo xhtmlhead("$stitle",$pstyle);
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
      echo xhtmlhead("$stitle",$pstyle);
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

$amount = mysql_fetch_array(mysql_query("SELECT balance FROM dcroxx_me_users WHERE id='".getuid_sid($sid)."'"));
  if($amount[0] < 1){
    $pstyle = gettheme($sid);
      echo xhtmlhead("Messages Service",$pstyle);
      echo "<p align=\"center\"><small>";
      echo "[x]<br/>Insufficient Balance<br/>";
            echo "You need atleast <b>1 BDT</b> for unlock message service<br/>
            Make shouts and friendship with others and stay 1hour for earn <b>1 BDT</b>";
            echo "</small></p>";
                echo"<p align=\"center\"><small>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a><br/><br/>";
  echo "</small></p>";
    echo "</card>";
    exit();
  }

/////////////////////Inbox Updated By IT Development Center :)
if($action=="sendpm")
{
 $whonick = getnick_uid($who);
$pminfo = mysql_fetch_array(mysql_query("SELECT text, byuid, timesent,touid, reported FROM dcroxx_me_private WHERE id='".$pmid."'"));
addonline(getuid_sid($sid),"Sending Messege","?");
 	    echo "<head>";
    echo "<title>Compose Messege</title>";
    echo "</head>";
    echo "<body>";
echo "<div class=\"mblock1\" align=\"left\">";
include("header.php");
            echo "</div>";
      echo "<div class=\"header\" align=\"center\">";
	echo "<b>Compose Messages</b></div>";
    echo "<div class=\"shout2\" align=\"left\">";
include("pm_by.php");
echo "<form action=\"inbxproc.php?action=touhid\" method=\"post\">";
 echo "<b>User:</b><br/><input name=\"who\" format=\"*x\" maxlength=\"15\"/><br/>";
  echo "<b>Message:</b><br/><input name=\"pmtext\" maxlength=\"500\"/><br/>";
  echo "<input type=\"submit\" value=\"Send\">";
$tmsg = getpmcount($uid);
 echo "</form><br/><img src=\"avatars/prev.gif\" alt=\"<\"><a href=\"?\">Inbox Messages</a> [$umsg/$tmsg]<br/><br/>";
$outbox = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE byuid='".$uid."'"));
echo "<img src=\"avatars/next.gif\" alt=\"&#187;\"> <a href=\"??view=snt\">Outbox Messages</a> [$umsg/$outbox[0]]<br/>";
echo "</div>";
echo "<p align=\"left\"><img src=\"avatars/menu.gif\"><a href=\"index.php\">Menu</a></p>";
echo "<div class=\"footer\" align=\"center\">";
include("footer.php");
echo "</div>";
echo "</body>";
}
else if($action=="")
{
  $whonick = getnick_uid($who);
addonline(getuid_sid($sid),"Viewing Messages","inbox.php?action=$action");
	    echo "<head>";
    echo "<title>Messages</title>";
    echo "</head>";
    echo "<body>";
include("header.php");
?>
<!-- G&R_250x250 -->
<script id="GNR36434">
    (function (i,g,b,d,c) {
        i[g]=i[g]||function(){(i[g].q=i[g].q||[]).push(arguments)};
        var s=d.createElement(b);s.async=true;s.src=c;
        var x=d.getElementsByTagName(b)[0];
        x.parentNode.insertBefore(s, x);
    })(window,'gandrad','script',document,'//content.green-red.com/lib/display.js');
    gandrad({siteid:11444,slot:36434});
</script>
<!-- End of G&R_250x250 -->
<?
echo "<div class=\"likebox\">";
echo"<center>
<div class=\"tab4\"><a href=\"\">New Message</a></div>
<div class=\"tab4\"><a href=\"conferance.php\">New Group</a></div>
</center>";
//echo"<a href=\"search.php?action=message\">Search for messages</a></div><hr/>";
echo"</div><hr/>";



    $myid = getuid_sid($sid);
  $count = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users a INNER JOIN dcroxx_me_private b ON a.id = b.byuid WHERE b.touid='".$myid."' AND b.starred='1'"));
  $cot = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM alien_war_rooms WHERE byuid='".$myid."' OR touid='".$myid."'"));
    $view = $_GET["view"];
   if($view=="")$view="all";
    if($page=="" || $page<=0)$page=1;
    $myid = getuid_sid($sid);
    $doit=false;
   // $num_items = getpmcount($myid,$view);
    $num_items = $cot[0];
    $items_per_page= 7;
    $num_pages = ceil($num_items/$items_per_page);
    if($page>$num_pages)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    if($num_items>0)
    {
      if($doit)
      {
        $exp = "&amp;rwho=$myid";
      }else{
        $exp = "";
      }
	  
/*	$sql = "SELECT
            id, text, byuid, touid, unread, timesent, starred, reported FROM dcroxx_me_private 
            WHERE touid='".$myid."' OR byuid='".$myid."' 
            ORDER BY timesent DESC LIMIT $limit_start, $items_per_page
    ";  */

	$sql = "SELECT id, byuid, touid, timesent FROM alien_war_rooms 
            WHERE touid='".$myid."' OR byuid='".$myid."' 
            ORDER BY timesent DESC LIMIT $limit_start, $items_per_page
    ";
	
	
echo "<div class=\"penanda\" align=\"left\">";

    $items = mysql_query($sql);
   while ($item = mysql_fetch_array($items))
    {
      if($item[3]=="1")
      {
        $iml = "<img src=\"../avatars/unread.gif\" alt=\"New!\"/> ";
      }else{
        if($item[4]=="1")
        {
            $iml = "<img src=\"../avatars/acrived.gif\" alt=\"*\"/> ";
        }else{
        $iml = "<img src=\"../avatars/read.gif\" alt=\"Old!\"/> ";
        }
      }
	  $pminfo = mysql_fetch_array(mysql_query("SELECT id, text, byuid FROM dcroxx_me_private WHERE folderid='".$item[0]."' ORDER BY timesent DESC LIMIT 1"));
	  $pmtext = htmlspecialchars($pminfo[1]);
	  $pmdet = substr($pmtext,0,100);
	  $text = parsepm($pmdet, $sid);
	  $neciti = mysql_fetch_array(mysql_query("SELECT unread FROM dcroxx_me_private WHERE id='".$pminfo[0]."' AND touid='".$uid."'"));
	  
	  $stext = "[image_preview=";

	  //$clrl = str_replace("[image_preview=", "<img src=\"attachment.png\">", $pminfo[0]);
      if($neciti[0]==1){
       //$tt = str_replace("[image_preview=","<img src=\"attachment.png\"> sent an attachment/sticker",$pmdet); 
	   $tt = str_replace("[image_preview=","<img src=\"tiljzJ-XLb5.png\"> [sent an attachment/sticker ",$pmdet); 
		  
       $pmex = "<small>$tt</small>";
	   }else{
		    $tt = str_replace("[image_preview=","<img src=\"tiljzJ-XLb5.png\"> [sent an attachment/sticker ",$pmdet); 
	  
	   $pmex = "<small>$tt</small>";
      }

if ($item[1]==$uid){
$i3 = $item[2];
}else if ($item[2]==$uid){
$i3 = $item[1];
}


	  $ex = substr(md5(time()),0,25);
	  $e0x = substr(md5(time()),0,35);
	  
	    $onick = getnick_uid($i3);
	 /* $po = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE touid='".$i3."' OR byuid='".$i3."'"));
	  if ($po[0]==1){*/
	  
	if(isonline($i3)){$regx = "<img src=\"DbsprgIuYE0.gif\">";}else{$regx = "";}  
	if($pminfo[2]==$uid){$rex = "<img src=\"5I2ZIDaPRB_.png\">";}else{$rex = "";}  
	if((ismod($i3)) || (ispu($i3))){$ds = "<img src=\"verified_user.png\">";}else{$ds = "";}
	
	  $remain = time() - $item[3];
$idle = gettimemsg($remain);


///////////////
$pms1 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE (byuid='".getuid_sid($sid)."' AND touid='".$i3."') OR (byuid='".$i3."' AND touid='".getuid_sid($sid)."') ORDER BY timesent"));
$num_items1 = $pms1[0];
$items_per_page1= 10;
$num_pages1 = ceil($num_items1/$items_per_page1);
////////////////


	      $lnk = "
		  <a href=\"messages.php?head_code=$e0x&who=$i3&down_code=$ex&page=$num_pages1\"> $onick</a>$ds $regx<br/> 
		  $rex $pmex<br/>
		  <small><font color=\"#9397a0\">$idle ago</font>$device</small>";
	 /* }else{
		  echo "<a href=\"chat.php?head_code=$e0x&who=$i3&down_code=$ex\"> $onick</a><br/> $pmex";
	  }*/
	   if($neciti[0]==1){
      echo "<div class=\"likebox\" align=\"left\">$lnk<hr/></div>";
	   }else{
	 echo "$lnk<hr/>"; 
	   }
    }
  //  echo "<p align=\"left\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"?action=$action&amp;page=$ppage&view=$view\">See Older Messages</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"?action=$action&page=$npage&view=$view\">See Newer Messages</a>";
    }
	/*echo "<br/>";
		  echo "<small>Page - $page/$num_pages</small>";
   if($num_pages>2)
    {
		$rets = "<form action=\"inbox.php\" method=\"get\">";
        $rets .= "<input name=\"page\" style=\"-wap-input-format: '*N'\" size=\"2\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
   $rets .= "<input type=\"submit\" value=\"Go To Page\"/>";
        $rets .= "</form>";
        echo $rets;
    }
    echo "</p>";*/
    }else{
	    if($view=="all")
  {
    echo "You Have No Inbox Messages!<br/>";
}else if($view=="snt")
	{
	echo "You Have No Outbox Messages!<br/>";
	  }else if($view=="str")
	  {
	  echo "You Have No Archived Messages!<br/>";
	  }
	  }
/*echo "<p align=\"left\">";
    if($view=="all")
  {
echo "&#187; <a href=\"inbox.php?action=$action\">Refresh</a><br/>";
echo "&#187; Delete: <a href=\"inbxproc.php?action=all\">All</a> | <a href=\"inbxproc.php?action=read\">Read</a> | <a href=\"inbxproc.php?action=unread\">Unread</a><br/>";
echo "&#187; <a href=\"inbox.php?action=sendpm\">Send New Message</a><br/>";
$umsg = getunreadpm(getuid_sid($sid));
$outbox = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE byuid='".$uid."'"));
echo "&#187; <a href=\"inbox.php?view=snt\">Outbox Messages</a> [$umsg/$outbox[0]]<br/>";
$starred = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE touid='".$uid."' AND starred='1'"));
echo "&#187; <a href=\"inbox.php?action=$action&view=str\">Archived Messages</a> [$starred[0]]<br/>";
  }else if($view=="snt")
  {
echo "&#187; <a href=\"inbox.php?action=sendpm\">Send New Message</a><br/>";
$tmsg = getpmcount(getuid_sid($sid));
$umsg = getunreadpm(getuid_sid($sid));
echo "&#187; <a href=\"inbox.php?view=all\">Inbox Messages</a> [$umsg/$tmsg]<br/>";
$starred = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE touid='".$uid."' AND starred='1'"));
echo "&#187; <a href=\"inbox.php?view=str\">Archived Messages</a> [$starred[0]]<br/>";
  }else if($view=="str")
  {
echo "&#187; <a href=\"inbox.php?action=sendpm\">Send New Message</a><br/>";
$tmsg = getpmcount(getuid_sid($sid));
$umsg = getunreadpm(getuid_sid($sid));
echo "&#187; <a href=\"inbox.php?view=all\">Inbox Messages</a> [$umsg]<br/>";
$umsg = getunreadpm(getuid_sid($sid));
$outbox = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE byuid='".$uid."'"));
echo "&#187; <a href=\"inbox.php?view=snt\">Outbox Messages</a> [$umsg/$outbox[0]]<br/>";
  }
echo "</p>";*/

echo"<br/>";
/*echo"<br/><div class=\"likebox\" align=\"left\"><font color=\"#9397a0\">SEARCH FOR MESSAGES</font></div>
<form method=\"get\" action=\"search.php?action=search\">
<input name=\"query\" placeholder=\"Search For Messages\" autocomplete=\"off\" autocorrect=\"off\" spellcheck=\"false\" type=\"text\" size=\"85%\"/>
<input value=\"Search\" type=\"submit\"  class=\"hmenu hmenubottom\"/>
</form>";*/

/*echo"<div class=\"likebox\" align=\"left\"><font color=\"#9397a0\">MORE OPTIONS</font></div>";
echo "<a href=\"?\">View Message Requests</a><hr/>";
echo "<a href=\"?\">View Filtered Requests</a><hr/>";
echo "<a href=\"?\">View Achived Requests</a><hr/>";
echo "<a href=\"?\">View Spam Requests</a>";
*/
echo "</div>";
?>
<!-- G&R_250x250 -->
<script id="GNR36434">
    (function (i,g,b,d,c) {
        i[g]=i[g]||function(){(i[g].q=i[g].q||[]).push(arguments)};
        var s=d.createElement(b);s.async=true;s.src=c;
        var x=d.getElementsByTagName(b)[0];
        x.parentNode.insertBefore(s, x);
    })(window,'gandrad','script',document,'//content.green-red.com/lib/display.js');
    gandrad({siteid:11444,slot:36434});
</script>
<!-- End of G&R_250x250 -->
<?
include("footer.php");
echo "</body>";
}
if($action=="new")
{
 $whonick = getnick_uid($who);
$pminfo = mysql_fetch_array(mysql_query("SELECT text, byuid, timesent,touid, reported FROM dcroxx_me_private WHERE id='".$pmid."'"));
addonline(getuid_sid($sid),"Sending Messege","inbox.php");
 	    echo "<head>";
    echo "<title>Compose Messege</title>";
    echo "</head>";
    echo "<body>";
echo "<div class=\"mblock1\" align=\"left\">";
include("header.php");
            echo "</div>";
$x1 = mysql_fetch_array(mysql_query("SELECT chat_visibility FROM dcroxx_me_users WHERE id='".$uid."'"));
if ($x1[0]==0){
	
    if($page=="" || $page<=0)$page=1;
    $num_items = getnumonline();
    $items_per_page= 100;
    $num_pages = ceil($num_items/$items_per_page);
    if($page>$num_pages)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    $sql = "SELECT
            a.name,a.cyberpowereragon, b.place, b.userid, a.vip, a.profilemsg, b.placedet, a.title_touhid FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_online b ON a.id = b.userid
            GROUP BY 1,2
            LIMIT $limit_start, $items_per_page
    ";
$items = mysql_query($sql);
while ($item = mysql_fetch_array($items)){
$noi = mysql_fetch_array(mysql_query("SELECT lastact FROM dcroxx_me_users WHERE id='".$item[3]."'"));
$remain = time() - $noi[0];
$idle = gettimemsg($remain);
$text = parsepm($item[5], $sid);
$sql3 = "SELECT name FROM dcroxx_me_users WHERE id=$item[3]";
$sql33 = mysql_query($sql3);
$item3 = mysql_fetch_array($sql33);{
$sex = mysql_fetch_array(mysql_query("SELECT sex FROM dcroxx_me_users WHERE name='$item3[0]'"));
if($sex[0]=="M"){$nicks = "<font color=\"blue\"><b>".subnick($item[0])."</b></font>";}
if($sex[0]=="F"){$nicks = "<font color=\"deeppink\"><b>".subnick($item[0])."</b></font>";}
if($sex[0]==""){$nicks = "";}
if((ismod($item[3])) || (touhidpu($item[3]))){
$ds = "<img src=\"verified_user.png\">";
}else{$ds = "";}
$lnk ="<a href=\"message.php?action=new_compose&amp;rndmtm=".time()."&amp;who=$item[3]\">$nicks</a>$ds";
$x = mysql_fetch_array(mysql_query("SELECT chat_visibility FROM dcroxx_me_users WHERE id='$item[3]'"));
if ($x[0]==1){echo "";}else{
if(isvalidated($item[3])){echo "";}else{
echo "$lnk<hr/>";
}}

}}

}else{echo"";}
include("footer2.php");
echo "</body>";
}
else if($action=="new_compose")
{
	
 $who = $_GET["who"];
// $whonick = subnick($who);
  $whonick = getnick_uid($who);
addonline(getuid_sid($sid),"Sending Messege","inbox.php");
 	    echo "<head>";
    echo "<title>Compose Messege</title>";
    echo "</head>";
    echo "<body>";
include("header.php");
      echo "<div class=\"div\" align=\"center\">";
	echo "<b>Compose Messages</b></div>";
	
    echo "<div class=\"penanda\" align=\"left\">";
echo "<form action=\"message.php?action=send\" method=\"post\">";
 echo "<b>To:</b><br/><input name=\"who\" maxlength=\"100\" value=\"$whonick\"/><br/>";
 // echo "<b>Message:</b><br/><input name=\"pmtext\" maxlength=\"500\"/><br/>";
    echo "<textarea name=\"pmtext\" rows=\"2\" cols=\"70%\"/></textarea>";
	   echo "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
  echo "<input type=\"submit\" value=\"Send\" class=\"div\">";
  
echo "</div>";
include("footer2.php");
echo "</body>";
}
if($action=="send"){	
 $who = $_POST["who"];
 $pmtext = $_POST["pmtext"];
	///////Email Activation Condition
$total = mysql_fetch_array(mysql_query("SELECT e_cod_v FROM dcroxx_me_users WHERE id='".$uid."'"));
if($total[0]==0){
$wh = subnick(getnick_uid($uid));
echo "<head>";
echo "<title>$wh@Online Community (Menu)</title>";
echo "</head>";
echo "<body>";
echo "</div>";
echo "<div class=\"header\" align=\"left\">";
echo "<img src=\"logo.png\" alt=\"$sitename\" type=\"logo\"/><br/>";
echo "<b>$wh@Online Community (Menu)</b></div>";
echo "<div class=\"mblock1\" align=\"left\">";
include("header.php");
echo "<div class=\"shout2\" align=\"left\">";
echo "<br/><b>Sorry <font color=\"red\">$wh</font>, we can't locate your verified email address.</b><br/>";
echo "So, please verify your email and active your account to get all features.<br/><br/>";

echo "<form action=\"emailverification.php?&who=$uid\" method=\"post\">";
echo "<b>ENTER VERIFICATION CODE:</b><br/>
<small>(which is already sent to you mail address when you register here. Check your email and collect the code to verify your account.)</small><br/>
<input name=\"ecod\"  maxlength=\"9\"/><br/>";
echo "<input type=\"Submit\" name=\"shout\" Value=\"Verify Account\"></form>";
echo "<br/>";
  echo"<a href=\"index.php\"><img src=\"avatars/menu.gif\">Home</a><br/>";
echo "</div>";
echo "<p align=\"left\"><img src=\"avatars/menu.gif\"><a href=\"index.php\">Menu</a></p>";
echo "<div class=\"footer\" align=\"center\">";
include("footer.php");
echo "</div>";
echo "</body>";
echo "</html>";
exit();
}
///////Email Activation Condition
if(strlen($pmtext)<2)
 {
    echo "<head>";
    echo "<title>Error!!!</title>";
    echo "</head>";
    echo "<body>";
echo "<div class=\"mblock1\" align=\"left\">";
include("header.php");
          echo "</div>";
       echo "<div class=\"header\" align=\"center\">";
	echo "<b>Blank Message</b></div>";
    echo "<div class=\"shout2\" align=\"left\">";
      echo "Blank Or Short Message!!!<br/><br/>";   
echo "</div>";
echo "<p align=\"left\"><img src=\"avatars/menu.gif\"><a href=\"index.php\">Menu</a></p>";
echo "<div class=\"footer\" align=\"center\">";
include("footer.php");
echo "</div>";
echo "</body>";
      exit();
}
    echo "<head>";
    echo "<title>Sending Message</title>";
   echo "</head>";
    echo "<body>";
echo "<div class=\"mblock1\" align=\"left\">";
include("header.php");
          echo "</div>";
       echo "<div class=\"header\" align=\"center\">";
	echo "<b>Send Message</b></div>";
    echo "<div class=\"shout2\" align=\"left\">";
  $whonick = getnick_uid($who);
  $byuid = getuid_sid($sid);
  $uid = getuid_sid($sid);
  $tm = time();
  $lastpm = mysql_fetch_array(mysql_query("SELECT MAX(timesent) FROM dcroxx_me_private WHERE byuid='".$byuid."'"));
  $pmfl = $lastpm[0]+getpmaf();
  if($byuid==1)$pmfl=0;
  if($pmfl>$tm){
  $rema = $pmfl - $tm;
  echo "<img src=\"avatars/notok.gif\" alt=\"X\"/>";
  echo "Flood control: $rema Seconds<br/><br/>";
    echo "</div>";
echo "<div class=\"footer\" align=\"center\">";
include("footer.php");
echo "</div>";
echo "</body>";
  exit();
  }
if(isignored($uid, $who)){
    echo "<img src=\"avatars/notok.gif\" alt=\"X\"/>";
    echo "Failed Sending inbox To $whonick. $whonick have ignored you.<br/><br/>";
echo "</div>";
echo "<p align=\"left\"><img src=\"avatars/menu.gif\"><a href=\"index.php\">Menu</a></p>";
echo "<div class=\"footer\" align=\"center\">";
include("header.php");
echo "</div>";
echo "</body>";
    exit();
    }
else if(isblocked($pmtext,$byuid)){
  echo "<p align=\"center\">";
    echo "<b><u><i>Can't Send PM!!!<br/><br/>";
   echo "You Just Tried To Spam In SocialBD via Inbox<br/>So You Are Now Inbox Banned!<br/>If You Inbox Banned By Our Mistake or Want To Be Inbox Unban<br/>Then Please With Contact <a href=\"online.php?action=stfol\">Online SocialBD Staffs</a></b></i></u><br/>";
$t = time()+(5*60);
        $user = getnick_sid($sid);
mysql_query("INSERT INTO dcroxx_me_penalties SET uid='".$uid."', penalty='1', exid='3', timeto='$t', pnreas='Spam By PM!'");
    mysql_query("INSERT INTO dcroxx_me_private SET text='[b](forwarded spam via inbox)[/b][br/]".$pmtext."', byuid='".$byuid."', touid='1', timesent='".$tm."'");
	mysql_query("INSERT INTO dcroxx_me_private SET text='[b](forwarded spam via inbox)[/b][br/]".$pmtext."', byuid='".$byuid."', touid='2', timesent='".$tm."'");
	mysql_query("INSERT INTO dcroxx_me_private SET text='[b](forwarded spam via inbox)[/b][br/]".$pmtext."', byuid='".$byuid."', touid='4', timesent='".$tm."'");
	echo "</p>";
	echo "</div>";
echo "<p align=\"left\"><img src=\"avatars/menu.gif\"><a href=\"index.php\">Menu</a></p>";
echo "<div class=\"footer\" align=\"center\">";
include("footer.php");
echo "</div>";
      echo "</body>";
      echo "</html>";
      exit();
  }
$privacy = mysql_fetch_array(mysql_query("SELECT pm FROM dcroxx_me_users WHERE id='".$who."'"));
if($privacy[0]==0 || (arebuds($uid, $who)) || (ispu(getuid_sid($sid))) || (ismod(getuid_sid($sid)))){
$u = $_GET["pid"];
$chk=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private_folders WHERE (uid='".$uid."' AND touid='".$who."') OR (uid='".$who."' AND touid='".$uid."')"));
if($chk[0]==1){
$ck=mysql_fetch_array(mysql_query("SELECT id FROM dcroxx_me_private_folders WHERE (uid='".$byuid."' AND touid='".$who."') OR (uid='".$who."' AND touid='".$byuid."')"));
$res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$pmtext."', byuid='".$byuid."', touid='".$who."', timesent='".$tm."',folderid='".$ck[0]."'");
echo mysql_error();
}else{
mysql_query("INSERT INTO dcroxx_me_private_folders SET uid='".$byuid."', touid='".$who."', foldername='".$whonick."'");
$ck=mysql_fetch_array(mysql_query("SELECT id FROM dcroxx_me_private_folders WHERE (uid='".$byuid."' AND touid='".$who."') OR (uid='".$who."' AND touid='".$byuid."')"));
$res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$pmtext."', byuid='".$byuid."', touid='".$who."', timesent='".$tm."',folderid='".$ck[0]."'");
echo mysql_error();
}
 // $res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$pmtext."', byuid='".$byuid."', touid='".$who."', timesent='".$tm."',folderid='".$u."'");
  if($res){
    echo "<img src=\"avatars/ok.gif\" alt=\"O\"/>";
$avtr = getavatar($who);
    echo "Message Was Sent Successfully To <img src=\"$avtr\" alt=\"$avtr\" width=\"18\" height=\"23\"><a href=\"$whonick\">$whonick</a>!<br/><br/>";
    $f = parsepm($pmtext, $sid);
	echo "<b>You Said:</b><br/>$f<br/><br/>";
$lastpm = mysql_fetch_array(mysql_query("SELECT byuid, text, timesent, id FROM dcroxx_me_private WHERE byuid='".$uid."' AND touid='".$who."' ORDER BY timesent DESC LIMIT 0,1"));
	     echo "&#171;<a href=\"edit.php?action=pm&pmid=$lastpm[3]\">Edit PM</a><br/><br/>";
$unr = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE (byuid='".$who."' AND touid='".$byuid."') AND unread='1'")); 
$ttl = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE (byuid='".$byuid."' AND touid='".$who."') AND (byuid='".$who."' AND touid='".$byuid."') AND unread='0' AND unread='1'"));
    echo "&#187; <a href=\"inbox.php?action=conversation&who=$who\">Conversation</a> [$unr[0]/$ttl[0]]<br/><br/>";
	$tmsg = getpmcount(getuid_sid($sid));
    $umsg = getunreadpm(getuid_sid($sid));
    echo "<img src=\"avatars/prev.gif\" alt=\"&#171;\"> <a href=\"inbox.php?view=all\">Inbox Messages</a> [$umsg/$tmsg]<br/><br/>";
}else{
    echo "<img src=\"avatars/notok.gif\" alt=\"X\"/>";
    echo "Can't Send Inbox to $whonick<br/><br/>";
  }
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"x\"/>Only Friends can send pm $unick<br/><a href=\"friendsproc.php?action=add&who=$who\">Add Friend</a><br/>";
  }
echo "</div>";
echo "<p align=\"left\"><img src=\"avatars/menu.gif\"><a href=\"index.php\">Menu</a></p>";
echo "<div class=\"footer\" align=\"center\">";
include("footer.php");
echo "</div>";
echo "</body>";
 }  
else if($action=="folderread")
{
  echo "<p align=\"center\">";
echo "<form action=\"message.php\" method=\"get\">";
    echo "View: <select name=\"view\">";
  echo "<option value=\"all\">All</option>";
  echo "<option value=\"snt\">Sent</option>";
  echo "<option value=\"str\">Starred</option>";
  echo "<option value=\"urd\">Unread</option>";
  echo "</select>";
echo "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
echo "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
echo "<input type=\"submit\" value=\"GO\"/>";
echo "</form>";
      echo "</p>";
    $view = $_GET["view"];
    //////ALL LISTS SCRIPT <<
    if($view=="")$view="all";
    if($page=="" || $page<=0)$page=1;
    $myid = getuid_sid($sid);
    $doit=false;
    $num_items = getpmcount($myid,$view); //changable
    $items_per_page= 7;
    $num_pages = ceil($num_items/$items_per_page);
    if($page>$num_pages)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    if($num_items>0)
    {
      if($doit)
      {
        $exp = "&amp;rwho=$myid";
      }else
      {
        $exp = "";
      }
    //changable sql
    if($view=="all")
  {
    $sql = "SELECT
            a.name, b.id, b.byuid, b.unread, b.starred FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_private b ON a.id = b.byuid
            WHERE b.touid='".$myid."'
            ORDER BY b.timesent DESC
            LIMIT $limit_start, $items_per_page
    ";
  }else if($view=="snt")
  {
    $sql = "SELECT
            a.name, b.id, b.touid, b.unread, b.starred FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_private b ON a.id = b.touid
            WHERE b.byuid='".$myid."'
            ORDER BY b.timesent DESC
            LIMIT $limit_start, $items_per_page
    ";
  }else if($view=="str")
  {
    $sql = "SELECT
            a.name, b.id, b.byuid, b.unread, b.starred FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_private b ON a.id = b.byuid
            WHERE b.touid='".$myid."' AND b.starred='1'
            ORDER BY b.timesent DESC
            LIMIT $limit_start, $items_per_page
    ";
  }else if($view=="urd")
  {
    $sql = "SELECT
            a.name, b.id, b.byuid, b.unread, b.starred FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_private b ON a.id = b.byuid
            WHERE b.touid='".$myid."' AND b.unread='1'
            ORDER BY b.timesent DESC
            LIMIT $limit_start, $items_per_page
    ";
  }
    
    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    while ($item = mysql_fetch_array($items))
    {
      if($item[3]=="1")
      {
        $iml = "<img src=\"/images/npm.gif\" alt=\"+\"/>";
      }else{
        if($item[4]=="1")
        {
            $iml = "<img src=\"/images/spm.gif\" alt=\"*\"/>";
        }else{

        $iml = "<img src=\"/images/opm.gif\" alt=\"-\"/>";
        }
      }
      
      $lnk = "<a href=\"message.php?action=readpm&amp;pmid=$item[1]\">$iml $item[0]</a>";
      echo "$lnk<br/>";
    }
    echo "</small></p>";
    echo "<p align=\"center\">";
    
      $npage = $page+1;
      echo "<a href=\"message.php?action=sendto\">Send to</a><br/>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"message.php?action=folderread&amp;page=$ppage&amp;view=$view$exp\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"message.php?action=folderread&amp;page=$npage&amp;view=$view$exp\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
$rets = "<form action=\"message.php\" method=\"get\">";
      $rets .= "Jump to page: <input name=\"page\" format=\"*N\" size=\"3\"/>";
$rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
         
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
$rets .= "</form>";
        echo $rets;
      echo "<br/>";
    }
    echo "<br/>";
echo "<form action=\"inbxproc.php?action=proall\" method=\"post\">";
      echo "Delete: <select name=\"pmact\">";
  echo "<option value=\"ust\">Unstarred</option>";
  echo "<option value=\"red\">Read</option>";
  echo "<option value=\"all\">All</option>";
  echo "</select>";
echo "<input type=\"submit\" value=\"GO\"/>";
echo "</form>";

    echo "</p>";
    }else{
      echo "<p align=\"center\">";
      echo "You have no Private Messages";
      echo "</p>";
    }
  ////// UNTILL HERE >>

    
    
  echo "<p align=\"center\">";
  echo "<a href=\"message.php?action=sendto\">Send to</a><br/>";
  
   echo "<p align=\"center\">";

    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"message.php?action=main\">&#171;Back to Inbox</a><br/>";
 echo "<a href=\"index.php?action=chat\">Back to Chat</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
exit();
  }


  else if($action=="folderunread")
{
  addonline(getuid_sid($sid),"User Inbox","");
    echo "<p align=\"center\">";
    echo "Unread Mail";
    echo "</p>";
    $view = $_GET["view"];
    //////ALL LISTS SCRIPT <<
    if($view=="")$view="all";
    if($page=="" || $page<=0)$page=1;
    $myid = getuid_sid($sid);
    $doit=false;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE touid='".$uid."' AND unread='1'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 7;
    $num_pages = ceil($num_items/$items_per_page);
    if($page>$num_pages)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    if($num_items>0)
    {
      if($doit)
      {
        $exp = "&amp;rwho=$myid";
      }else
      {
        $exp = "";
      }
    //changable sql

    $sql = "SELECT
            a.name, b.id, b.byuid, b.unread, b.starred FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_private b ON a.id = b.byuid
            WHERE b.touid='".$myid."' AND b.unread='1'
            ORDER BY b.timesent DESC
            LIMIT $limit_start, $items_per_page
    ";
    echo "<div class=\"mblock1\">";
    echo "<small>";
    $items = mysql_query($sql);
    echo mysql_error();
    while ($item = mysql_fetch_array($items))
    {
      if($item[3]=="1")
      {
        $iml = "<img src=\"images/npm.gif\" alt=\"+\"/>";
      }else{
        if($item[4]=="1")
        {
            $iml = "<img src=\"images/spm.gif\" alt=\"*\"/>";
        }else{

        $iml = "<img src=\"images/opm.gif\" alt=\"-\"/>";
        }
      }

      $lnk = "<a href=\"message.php?action=readpm&amp;pmid=$item[1]\">$iml $item[0]</a>";
      echo "$lnk<br/>";
    }
    echo "</small>";
    echo "</div>";
    echo "<p align=\"center\">";

      $npage = $page+1;
      echo "<a href=\"message.php?action=sendto\">Send to</a><br/>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"message.php?action=folderunread&amp;page=$ppage&amp;view=$view$exp\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"message.php?action=folderunread&amp;page=$npage&amp;view=$view$exp\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
	    $rets = "<form action=\"message.php\" method=\"get\">";
        $rets .= "Jump to page: <input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
	    $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
        $rets .= "</form>";
        echo $rets;
    }
    echo "<br/>";

     echo "</p>";
    }else{
      echo "<p align=\"center\">";
      echo "You have no Private Messages<br/>";
      echo "<a href=\"message.php?action=sendto\">Send PM</a><br/>";
      echo "</p>";
    }
  ////// UNTILL HERE >>



  echo "<p align=\"center\">";

    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"message.php?action=main\">&#171;Back to Inbox</a><br/>";
 echo "<a href=\"index.php?action=chat\">Back to Chat</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
exit();
  }


  else if($action=="folder")
{
  addonline(getuid_sid($sid),"User Inbox","");
  $folderid = $_GET["folderid"];
  $foldername = mysql_fetch_array(mysql_query("SELECT foldername FROM dcroxx_me_private_folders WHERE folderid='".$folderid."'"));
    echo "<p align=\"center\">";
    echo "Folder $foldername[0]";
    echo "</p>";
    //////ALL LISTS SCRIPT <<
    if($view=="")$view="all";
    if($page=="" || $page<=0)$page=1;
    $myid = getuid_sid($sid);
    $doit=false;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE touid='".$uid."' AND folderid='".$folderid."'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if($page>$num_pages)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    if($num_items>0)
    {
      if($doit)
      {
        $exp = "&amp;rwho=$myid";
      }else
      {
        $exp = "";
      }
    //changable sql

    $sql = "SELECT
            a.name, b.id, b.byuid, b.unread, b.starred, folderid FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_private b ON a.id = b.byuid
            WHERE b.touid='".$myid."' AND folderid='".$folderid."'
            ORDER BY b.timesent DESC
            LIMIT $limit_start, $items_per_page
    ";
    echo "<div class=\"mblock1\">";
    echo "<small>";
    $items = mysql_query($sql);
    echo mysql_error();
    while ($item = mysql_fetch_array($items))
    {
      if($item[3]=="1")
      {
        $iml = "<img src=\"images/npm.gif\" alt=\"+\"/>";
      }else{
        if($item[4]=="1")
        {
            $iml = "<img src=\"images/spm.gif\" alt=\"*\"/>";
        }else{

        $iml = "<img src=\"images/opm.gif\" alt=\"-\"/>";
        }
      }

      $lnk = "<a href=\"message.php?action=readpm&amp;pmid=$item[1]\">$iml $item[0]</a>";
      echo "$lnk<br/>";
    }
    echo "<br/>";
    echo "</small>";
    echo "<center><small><a href=\"message.php?action=delfolder&amp;fid=$folderid\">Delete Folder</a></small></center>";
    echo "<center><small><a href=\"message.php?action=renamefolder&amp;fid=$folderid\">Rename Folder</a></small></center>";
    echo "</div>";
    echo "<p align=\"center\">";

      $npage = $page+1;
      echo "<a href=\"message.php?action=sendto\">Send to</a><br/>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"message.php?action=main&amp;page=$ppage&amp;view=$view$exp\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"message.php?action=main&amp;page=$npage&amp;view=$view$exp\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
$rets = "<form action=\"message.php\" method=\"get\">";
      $rets .= "Jump to page: <input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
$rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
$rets .= "</form>";
        echo $rets;
    }
    echo "<br/>";
    echo "</p>";
    }else{
      echo "<p align=\"center\">";
      echo "You have no Private Messages<br/>";
      echo "<a href=\"message.php?action=sendto\">Send PM</a><br/>";
      echo "</p>";
    }
  ////// UNTILL HERE >>



  echo "<p align=\"center\">";

    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"message.php?action=main\">&#171;Back to Inbox</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
exit();
  }
   else if($action=="crfolder")
{
  addonline(getuid_sid($sid),"Creating Folder","");
  echo "<p align=\"center\">";

    echo "<form method=\"post\" action=\"message.php?action=crfolderdone\">";
    echo "Folder Name: <input name=\"fname\" maxlength=\"25\"/><br/>";
    echo "<input type=\"submit\" name=\"Submit\" value=\"Create\"/>";
    echo "</form><br/>";


    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"message.php?action=main\">&#171;Back to Inbox</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
    echo "Home</a>";
    echo "</p>";
exit();
}

   else if($action=="crfolderdone")
{
  addonline(getuid_sid($sid),"Creating Folder","");
  echo "<p align=\"center\">";

  $fname = $_POST["fname"];
  $uid = getuid_sid($sid);


    $reg = mysql_query("INSERT INTO dcroxx_me_private_folders SET uid='".$uid."', foldername='".$fname."'");

    if($reg)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Folder Created Successfully<br/><br/>";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error Creating Folder<br/><br/>";
      }



    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"message.php?action=main\">&#171;Back to Inbox</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
    echo "Home</a>";
    echo "</p>";
exit();
}

   else if($action=="movetofolder")
{
  addonline(getuid_sid($sid),"Moving PM to Folder","");
  echo "<p align=\"center\">";

  $movetof = $_POST["movetof"];
  $pmid = $_POST["pmid"];

  $uid = getuid_sid($sid);


    $str = mysql_query("UPDATE dcroxx_me_private SET folderid='".$movetof."' WHERE id='".$pmid."' ");
          if($str)
          {
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>PM moved successfully<br/><br/>";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Can't move PM at the moment<br/><br/>";
          }



    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"message.php?action=main\">&#171;Back to Inbox</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
    echo "Home</a>";
    echo "</p>";
exit();
}

/////////////////////////////////Froward Message By IT Development Center :)
else if($action=="forward")
{
$pmid = $_GET["pmid"];
$name = $_POST["name"];
    echo "<head>";
    echo "<title>Forwarding Message</title>";
    echo "</head>";
    echo "<body>";
echo "<div class=\"mblock1\" align=\"left\">";
include("header.php");
            echo "</div>";
			echo "<div class=\"header\" align=\"center\">";
			echo "<b>Forward Message</b></div>";
		echo "<div class=\"shout2\" align=\"left\">";
include("pm_by.php");
		echo "<br/>";
$pminfo = mysql_fetch_array(mysql_query("SELECT text, byuid, timesent,touid, reported FROM dcroxx_me_private WHERE id='".$pmid."'"));
$txt = parsepm($pminfo[0], $sid);
echo "<b>Message: </b><br/>";
echo "$txt<br/><br/>";
echo "<b>Username:</b><br/>";
echo "<form action=\"inbxproc.php?action=forwordpm&pmid=$pmid\" method=\"post\">";
echo "<input name=\"name\" maxlength=\"500\"/><br/>";
echo " <input type=\"submit\" value=\"Send\"/>";
echo "</form><br/><br/>";
echo "</div>";
echo "<p align=\"left\"><img src=\"avatars/menu.gif\"><a href=\"index.php\">Menu</a></p>";
echo "<div class=\"footer\" align=\"center\">";
include("footer.php");
echo "</div>";
echo "</body>";
}
else if($action=="readpm")
{
$pminfo = mysql_fetch_array(mysql_query("SELECT text, byuid, timesent,touid, reported FROM dcroxx_me_private WHERE id='".$pmid."'"));
$who = $_GET["who"];
$whnick = getnick_uid($who); 
addonline(getuid_sid($sid),"Reading Messages","??action=$action");  
echo "<head>";
echo "<title>Reading Messages</title>";
echo "</head>";
echo "<body>";
echo "<div class=\"mblock1\" align=\"left\">";
include("header.php");
            echo "</div>";
       echo "<div class=\"header\" align=\"center\">";
	echo "<b>Read Message</b></div>";
    echo "<div class=\"shout2\" align=\"left\">";
  $pminfo = mysql_fetch_array(mysql_query("SELECT text, byuid, timesent,touid, reported FROM dcroxx_me_private WHERE id='".$pmid."'"));
  if(getuid_sid($sid)==$pminfo[3])
  {
    $chread = mysql_query("UPDATE dcroxx_me_private SET unread='0' WHERE id='".$pmid."'");
  }
  if(($pminfo[3]==getuid_sid($sid))||($pminfo[1]==getuid_sid($sid)))
  {
  if(getuid_sid($sid)==$pminfo[3])
  {
include("pm_by.php");
if(isonline($pminfo[1]))
  {
    $iml = "<img src=\"avatars/onl.gif\">";
  }else{
    $iml = "<img src=\"avatars/ofl.gif\">";
  }
	    $sql = "SELECT name FROM dcroxx_me_users WHERE id=$pminfo[1]";
	    $sql2 = mysql_query($sql);
	    $item = mysql_fetch_array($sql2);
		{
$sex = mysql_fetch_array(mysql_query("SELECT sex FROM dcroxx_me_users WHERE name='$item[0]'"));
if($sex[0]=="M"){$icon = "<img src=\"avatars/male.gif\" alt=\"M\"/>";}
if($sex[0]=="F"){$icon = "<img src=\"avatars/female.gif\" alt=\"F\"/>";}
if($sex[0]==""){$icon = "";}
        		$avlink = getavatar($pminfo[1]);
if($avlink=="")
{
 $avt =  "$icon";
}else{
 $avt = "<img src=\"$avlink\" alt=\"$avlink\" type=\"icon\" width=\"18\" hieght=\"23\"/>";
}
	    $sql3 = "SELECT name FROM dcroxx_me_users WHERE id=$pminfo[1]";
	    $sql33 = mysql_query($sql3);
	    $item3 = mysql_fetch_array($sql33);
		{
$sex = mysql_fetch_array(mysql_query("SELECT sex FROM dcroxx_me_users WHERE name='$item3[0]'"));
if($sex[0]=="M"){$nicks = "<font color=\"blue\">".getnick_uid($pminfo[1])."</font>";}
if($sex[0]=="F"){$nicks = "<font color=\"deeppink\">".getnick_uid($pminfo[1])."</font>";}
if($sex[0]==""){$nicks = "";}
    $ptxt = "Message By ";
        $bylnk = "$iml$avt <a href=\"".getnick_uid($pminfo[1])."\">$nicks</a> (".getstatus($pminfo[1]).")";
  }
  }
  }else{
  if(isonline($pminfo[3]))
  {
    $iml = "<img src=\"avatars/onl.gif\">";
  }else{
    $iml = "<img src=\"avatars/ofl.gif\">";
  }
	    $sql2 = "SELECT name FROM dcroxx_me_users WHERE id=$pminfo[3]";
	    $sql22 = mysql_query($sql2);
	    $item2 = mysql_fetch_array($sql22);
		{
$sex = mysql_fetch_array(mysql_query("SELECT sex FROM dcroxx_me_users WHERE name='$item2[0]'"));
if($sex[0]=="M"){$icon2 = "<img src=\"avatars/male.gif\" alt=\"M\"/>";}
if($sex[0]=="F"){$icon2 = "<img src=\"avatars/female.gif\" alt=\"F\"/>";}
if($sex[0]==""){$usersex = "";}
       		$avlink = getavatar($pminfo[3]);
if($avlink=="")
{
 $avt =  "$icon2";
}else{
 $avt = "<img src=\"$avlink\" alt=\"$avlink\" type=\"icon\" width=\"23\" hieght=\"18\"/>";
}
	    $sql3 = "SELECT name FROM dcroxx_me_users WHERE id=$pminfo[3]";
	    $sql33 = mysql_query($sql3);
	    $item3 = mysql_fetch_array($sql33);
		{
$sex = mysql_fetch_array(mysql_query("SELECT sex FROM dcroxx_me_users WHERE name='$item3[0]'"));
if($sex[0]=="M"){$nicks = "<font color=\"blue\">".getnick_uid($pminfo[3])."</font>";}
if($sex[0]=="F"){$nicks = "<font color=\"deeppink\">".getnick_uid($pminfo[3])."</font>";}
if($sex[0]==""){$nicks = "";}
    $ptxt = "Message To: ";
    $bylnk = "<a href=\"".getnick_uid($pminfo[3])."\">$iml$avt$nicks</a>(".getstatus($pminfo[3]).")";
   } 
  }
  }
  echo "$ptxt $bylnk<br/>";
  $tmstamp = $pminfo[2];
  $tremain = time()-$tmstamp;
  $tmdt = gettimemsg($tremain)." ago";
  echo "<b><small> ($tmdt) </small></b><br/><br/>";
  $pmtext = parsepm($pminfo[0], $sid);
    $pmtext = str_replace("/reader",getnick_uid($pminfo[3]), $pmtext);
    if(isspam($pmtext))
    {
      if(($pminfo[4]=="0") && ($pminfo[1]!=1))
      {
        mysql_query("UPDATE dcroxx_me_private SET reported='1' WHERE id='".$pmid."'");
      }
    }
    echo $pmtext;
echo "<br/><br>";
        $lat = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE byuid='".$pminfo[3]."' AND touid='".$pminfo[1]."'  AND folderid='".$pmid."'"));
echo mysql_error();
$a = mysql_fetch_array(mysql_query("SELECT folderid FROM dcroxx_me_private WHERE id='".$_GET["pmid"]."'"));
		         $lastpmtxt = mysql_fetch_array(mysql_query("SELECT text FROM dcroxx_me_private WHERE byuid='".$uid."' AND touid='".$pminfo[1]."'  AND folderid='".$a[0]."' ORDER BY timesent DESC"));
     $lasttxt = parsepm($lastpmtxt[0]);
	 $whonick = getnick_uid($pminfo[3]); 
  if ($pminfo[1]==3)
{
  echo "<form action=\"chatbot.php?action=sendpm&who=$pminfo[1]\" method=\"post\">";
  echo "<input name=\"pmtext\" maxlength=\"500\"/><br/>";
}else{
$dxa = mysql_fetch_array(mysql_query("SELECT folderid FROM dcroxx_me_private WHERE id='".$pmid."'"));
echo mysql_error();
if($dxa[0]==0)
{
$vix = $_GET["pmid"];
}else{
$vix = $a[0];
}
  echo "<form action=\"inbxproc.php?action=sendpm&who=$pminfo[1]&pid=$vix\" method=\"post\">";
  echo "<input name=\"pmtext\" maxlength=\"500\"/><br/>";
}
  echo " <input type=\"submit\" value=\"Send\"/>";
echo "</form><br/>";
echo "<b>You Said</b>: $lasttxt<br/><br/>";
$umsg = getunreadpm(getuid_sid($sid));
$outbox = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE byuid='".$uid."'"));
echo "&#187; <a href=\"??action=conversation&who=$pminfo[1]\">Conversation</a> [$umsg/$outbox[0]]<br/>";
$pminfo = mysql_fetch_array(mysql_query("SELECT starred FROM dcroxx_me_private WHERE id='".$pmid."'"));
if($pminfo[0]=="0")
{
echo "&#187; <a href=\"inbxproc.php?action=acr&pmid=$pmid\">Archive</a><br/>";
echo "<small>(to protect auto delete)</small><br/>";
}else{
echo "&#187; <a href=\"inbxproc.php?action=unacr&pmid=$pmid\">Unarchive</a><br/>";
}
echo "&#187; <a href=\"inbxproc.php?action=delpm&pmid=$pmid\">Delete</a><br/>";
echo "&#187; <a href=\"??action=forward&pmid=$pmid\">Forward</a><br/>";
echo "&#187; <a href=\"inbxproc.php?action=rept&pmid=$pmid\">Report</a><br/>";
$tmsg = getpmcount(getuid_sid($sid));
$umsg = getunreadpm(getuid_sid($sid));
 echo "<br/><img src=\"avatars/prev.gif\" alt=\"&#171;\"> <a href=\"??view=all\">Inbox Messages</a> [$umsg/$tmsg]<br/>";
echo "</div>";
echo "<p align=\"left\"><img src=\"avatars/menu.gif\"><a href=\"index.php\">Menu</a></p>";
echo "<div class=\"footer\" align=\"center\">";
include("footer.php");
echo "</div>";
echo "</body>";
  }else{
  echo "<img src=\"avatars/notok.gif\" alt=\"X\"/>This PM Isn't Yours!<br/><br/>";
echo "</div>";
echo "<p align=\"left\"><img src=\"avatars/menu.gif\"><a href=\"index.php\">Menu</a></p>";
echo "<div class=\"footer\" align=\"center\">";
include("footer.php");
echo "</div>";
echo "</body>";
  }
}
else if($action=="conversation")
{
  addonline(getuid_sid($sid),"Viewing Conversations","??action=main");
 	    echo "<head>";
    echo "<title>Conversion</title>";
    echo "</head>";
    echo "<body>";
echo "<div class=\"mblock1\" align=\"left\">";
include("header.php");
            echo "</div>";
       echo "<div class=\"header\" align=\"center\">";
$uid = getuid_sid($sid);
;
$unick = getnick_uid($uid);
$who = $_GET["who"];
$wnick = getnick_uid($who);
	echo "<b>Conversations Between $unick And $wnick</b></div>";
    echo "<div class=\"shout2\" align=\"left\">";
include("pm_by.php");
  if($page=="" || $page<=0)$page=1;
    $pms = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE (byuid='".$uid."' AND touid='".$who."') OR (byuid='".$who."' AND touid='".$uid."') ORDER BY timesent"));
   $num_items = $pms[0];
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if($page>$num_pages)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    if($num_items>0)
    {
      echo "<p>";
      $pms = mysql_query("SELECT byuid, text, timesent FROM dcroxx_me_private WHERE ((byuid=$uid AND touid=$who) OR (byuid=$who AND touid=$uid)) ORDER BY timesent ASC LIMIT $limit_start, $items_per_page");
      while($pm=mysql_fetch_array($pms))
      {
            if(isonline($pm[0]))
  {
    $iml = "<img src=\"avatars/onl.gif\" alt=\" \"/>";
  }else{
    $iml = "<img src=\"avatars/ofl.gif\" alt=\"-\"/>";
  }
	    $sql = "SELECT name FROM dcroxx_me_users WHERE id=$pm[0]";
	    $sql2 = mysql_query($sql);
	    $item = mysql_fetch_array($sql2);
		{
$sex = mysql_fetch_array(mysql_query("SELECT sex FROM dcroxx_me_users WHERE name='$item[0]'"));
if($sex[0]=="M"){$icon = "<img src=\"avatars/male.gif\" alt=\"M\"/>";}
if($sex[0]=="F"){$icon = "<img src=\"avatars/female.gif\" alt=\"F\"/>";}
if($sex[0]==""){$icon = "";}
        		$avlink = getavatar($pm[0]);
if($avlink=="")
{
 $avt =  "$icon";
}else{
 $avt = "<img src=\"$avlink\" alt=\"$avlink\" type=\"icon\" width=\"18\" hieght=\"23\"/>";
}
	    $sql3 = "SELECT name FROM dcroxx_me_users WHERE id=$pm[0]";
	    $sql33 = mysql_query($sql3);
	    $item3 = mysql_fetch_array($sql33);
		{
$sex = mysql_fetch_array(mysql_query("SELECT sex FROM dcroxx_me_users WHERE name='$item3[0]'"));
if($sex[0]=="M"){$nicks = "<font color=\"blue\">".getnick_uid($pm[0])."</font>";}
if($sex[0]=="F"){$nicks = "<font color=\"deeppink\">".getnick_uid($pm[0])."</font>";}
if($sex[0]==""){$nicks = "";}
  $bylnk = "$iml$avt<a href=\"".getnick_uid($pm[0])."\">$nicks</a> :";
}
}
  $t = $pm[2] + (6*60*60);
  $tmopm = date("h:i A, D d M y",$t);
  echo "$tmopm<br/>";
  echo $bylnk;
        echo parsepm($pm[1], $sid);
  echo "<br/>--------------<br/>";
      }
   if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"??action=conferance&page=$ppage\">&#171;-Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"??action=conferance&page=$npage\">Next-&#187;</a>";
    }
    echo "<br/>Page - $page/$num_pages<br/>";
  if($num_pages>2)
    {
        $rets = "<form action=\"?\" method=\"get\">";
        $rets .= "<input name=\"page\" style=\"-wap-input-format: '*N'\" size=\"2\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"submit\" value=\"Go To Page\"/>";
        $rets .= "</form>";
        echo $rets;
    }
}else{
        echo "<p align=\"center\">";
        echo "NO DATA<br/><br/>";
      }
 if($who==3)
{
  echo "<form action=\"chatbot.php?action=sendpm&who=$who\" method=\"post\">";
  echo "<b>Reply:</b> <input name=\"pmtext\" maxlength=\"500\"/>";
}else{
  echo "<form action=\"inbxproc.php?action=sendpm&amp;who=$who\" method=\"post\">";
  echo "<b>Reply:</b> <input name=\"pmtext\" maxlength=\"500\"/>";
}
  echo " <input type=\"submit\" value=\"Send\"/><br/>";
echo "&#187; <a href=\"??action=conversation&who=$who\">Refresh</a><br/><br/>";
$tmsg = getpmcount(getuid_sid($sid));
$umsg = getunreadpm(getuid_sid($sid));
echo "<img src=\"avatars/prev.gif\" alt=\"&#171;\"> <a href=\"??view=all\">Inbox Messages</a> [$umsg/$tmsg]<br/>";
echo "</div>";
echo "<p align=\"left\"><img src=\"avatars/menu.gif\"><a href=\"index.php\">Menu</a></p>";
echo "<div class=\"footer\" align=\"center\">";
include("footer.php");
echo "</div>";
echo "</body>";
}

?>
</html>