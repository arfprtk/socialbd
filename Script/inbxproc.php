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
$pmtext = $_POST["pmtext"];
$who = $_GET["who"];
$uid = getuid_sid($sid);

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
	$validated = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE id='".$uid."'  AND validated='0'"));
    if(($validated[0]>0)&&(validation()))
    {

    $pstyle = gettheme($sid);
  echo xhtmlhead("try again",$pstyle);
      echo "<p align=\"center\">";
	   $nickk = getnick_sid($sid);
  $whoo = getuid_nick($nickk);
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
	   echo "<b>Ur Account is Not Validated Yet</b><br/>";
	  $totaltimeonline = mysql_fetch_array(mysql_query("SELECT tottimeonl FROM dcroxx_me_users WHERE id='".$whoo."'"));
$num = $totaltimeonline[0]/86400;
$days = intval($num);
$num2 = ($num - $days)*24;
$hours = intval($num2);
$num3 = ($num2 - $hours)*60;
$mins = intval($num3);
$num4 = ($num3 - $mins)*60;
$secs = intval($num4);

echo "<b>Your online time:</b> ";
if(($days==0) and ($hours==0) and ($mins==0)){
  echo "$secs seconds<br/>";
}else
if(($days==0) and ($hours==0)){
  echo "$mins mins, ";
  echo "$secs seconds<br/>";
}else
if(($days==0)){
  echo "$hours hours, ";
  echo "$mins mins, ";
  echo "$secs seconds<br/>";
}else{
  echo "$days days, ";
  echo "$hours hours, ";
  echo "$mins mins, ";
  echo "$secs seconds<br/>";
}
    echo "<br/>You have to Spend at least<u> 20 mins online</u> to get validated ur account. Plz be patient try again this option after 20 Minutes online here..Untill then Explorer and Enjoy other features in $stitle.<br/>thank you!<br/><br/>";

	echo "<a href=\"index.php?action=formmenu\">Back To Forums</a><br/>";
	echo "<a href=\"downloads/xindex.php?action=main\">Back To Downloads</a><br/>";
	 echo "<a href=\"index.php?action=main\">Back To Home</a><br/><br/>";

	 echo "</p>";
   echo xhtmlfoot();
      exit();


    }
if($action=="sendpm")
{if (shad0w2($uid,$who)) {
  $pstyle = gettheme($sid);
      echo xhtmlhead("Inbox",$pstyle);
  echo "<p align=\"center\">";
  
  if(strlen($pmtext)<2){
 
	echo "<b>Blank Message</b><br/>";
      echo "Blank Or Short Message!!!<br/><br/>";   
echo "<p align=\"left\"><img src=\"images/home.gif\"><a href=\"index.php\">Home</a></p>";
echo "</body>";
      exit();
}
  $whonick = getnick_uid($who);
  $byuid = getuid_sid($sid);
  $tm = time();
  $lastpm = mysql_fetch_array(mysql_query("SELECT MAX(timesent) FROM dcroxx_me_private WHERE byuid='".$byuid."'"));
  $pmfl = $lastpm[0]+getpmaf();
  if($byuid==1)$pmfl=0;
  if($pmfl<$tm){
    if(!isblocked($pmtext,$byuid))
    {
    if((!isignored($byuid, $who))&&(!istrashed($byuid)))
    {
  $res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$pmtext."', byuid='".$byuid."', touid='".$who."', timesent='".$tm."'");
  }else{
    $res = true;
  }
  if($res)
  {
    echo "<img src=\"images/ok.gif\" alt=\"O\"/>";
    echo "PM was sent successfully to ";
	echo "<a href=\"index.php?action=viewuser&amp;who=$who\">$whonick</a><br/><br/>";
    echo parsepm($pmtext, $sid);

  }else{
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>";
    echo "Can't Send PM to $whonick<br/><br/>";
  }
  }else{
    $bantime = (time() - $timeadjust) + (7*24*60*60) ;
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>";
    echo "Can't Send PM to $whonick<br/><br/>";
    echo "You just sent a link to one of the crapiest sites on earth<br/> The members of these sites spam here a lot, so go to that site and stay there if you don't like it here<br/> as a result of your stupid action:<br/>1. you have lost your sheild<br/>2. you have lost all your Credits<br/>3. You are BANNED!";
    mysql_query("INSERT INTO dcroxx_me_metpenaltiespl SET uid='".$byuid."', penalty='1', exid='1', timeto='".$bantime."', pnreas='Banned: Automatic Ban for spamming for a crap site'");
    mysql_query("UPDATE dcroxx_me_users SET plusses='0', shield='0' WHERE id='".$byuid."'");
    mysql_query("INSERT INTO dcroxx_me_private SET text='".$pmtext."', byuid='".$byuid."', touid='1', timesent='".$tm."'");
  }
  }else{
    $rema = $pmfl - $tm;
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>";
    echo "Flood control: $rema Seconds<br/><br/>";
  }
   echo "<br/><br/>";
   if($page=="" || $page<=0)$page=1;
    $myid = getuid_sid($sid);
    $doit=false;
    $num_items = getpmcount($myid); //changable
    $items_per_page= 1
;
    $num_pages = ceil($num_items/$items_per_page);
    if($page>$num_pages)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;


$sql = "SELECT
            a.name, b.id, b.byuid, b.unread, b.starred FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_private b ON a.id = b.byuid
            WHERE b.touid='".$myid."' AND b.unread='1'
            ORDER BY b.timesent
            LIMIT $limit_start, $items_per_page
    ";

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

      $lnk = "<a href=\"inbox.php?action=readpm&amp;pmid=$item[1]\">$iml $item[0]</a>";
      echo "$lnk<br/>";
    }
}else{
echo "<b>Privacy Inbox !!!</ b> <br/> Only friends and staff can send inbox to this members<br/> ";
}
  echo "<a href=\"inbox.php?action=main\">Back to inbox</a><br/>";
   echo "<a href=\"index.php?action=chat\">Back to Chat</a><br/>";
      $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }
////////////////////////////////////////////////////
else if($action=="sendto")
{
  $pstyle = gettheme($sid);
      echo xhtmlhead("Inbox",$pstyle);
  echo "<p align=\"center\">";
 $who = $_POST["who"];
  $who = getuid_nick($who);
    if($who==0)
    {
      echo "<img src=\"images/notok.gif\" alt=\"x\"/>User Does Not exist<br/>";
    }else{
$whonick = getnick_uid($who);
  $byuid = getuid_sid($sid);
  $tm = (time() - $timeadjust) ;
  $lastpm = mysql_fetch_array(mysql_query("SELECT MAX(timesent) FROM dcroxx_me_private WHERE byuid='".$byuid."'"));
  $pmfl = $lastpm[0]+getpmaf();
  if($pmfl<$tm)
  {
    if(!isblocked($pmtext,$byuid))
    {
    if((!isignored($byuid, $who))&&(!istrashed($byuid)))
    {
 $res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$pmtext."', byuid='".$byuid."', touid='".$who."', timesent='".$tm."'");
  }else{
    $res = true;
  }
  if($res)
  {
    echo "<img src=\"images/ok.gif\" alt=\"O\"/>";
       echo "PM was sent successfully to ";
	echo "<a href=\"index.php?action=viewuser&amp;who=$who\">$whonick</a><br/><br/>";
    echo parsepm($pmtext, $sid);

  }else{
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>";
    echo "Can't Send PM to $whonick<br/><br/>";
  }
  }else{
   $bantime = (time() - $timeadjust) + (7*24*60*60) ;
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>";
    echo "Can't Send PM to $whonick<br/><br/>";
    echo "You just sent a link to one of the crapiest sites on earth<br/> The members of these sites spam here a lot, so go to that site and stay there if you don't like it here<br/> as a result of your stupid action:<br/>1. you have lost your sheild<br/>2. you have lost all your plusses<br/>3. You are BANNED!";
    mysql_query("INSERT INTO dcroxx_me_metpenaltiespl SET uid='".$byuid."', penalty='1', exid='1', timeto='".$bantime."', pnreas='Banned: Automatic Ban for spamming for a crap site'");
    mysql_query("UPDATE dcroxx_me_users SET plusses='0', shield='0' WHERE id='".$byuid."'");
    mysql_query("INSERT INTO dcroxx_me_private SET text='".$pmtext."', byuid='".$byuid."', touid='1', timesent='".$tm."', reported='1'");
  }
  }else{
    $rema = $pmfl - $tm;
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>";
    echo "Flood control: $rema Seconds<br/><br/>";
  }

    }
  echo "<br/><br/><a href=\"inbox.php?action=main\">Back to inbox</a><br/>";
      $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }
////////////////////////////////////////////////////
/*
else if($action=="sendpopup")
{
$pstyle = gettheme($sid);
      echo xhtmlhead("Inbox",$pstyle);
  echo "<p align=\"center\">";
  $pmid = $_GET["pmid"];
  $whonick = getnick_uid($who);
  $byuid = getuid_sid($sid);
  $tm = time();
  $lastpm = mysql_fetch_array(mysql_query("SELECT MAX(timesent) FROM dcroxx_me_popups WHERE byuid='".$byuid."'"));
  $pmfl = $lastpm[0]+getpmaf();
  $pmurd = mysql_query("UPDATE dcroxx_me_popups SET unread='0' WHERE id='".$pmid."'");

  if($byuid==1)$pmfl=0;
  if($pmfl>$tm)
  {
  $rema = $pmfl - $tm;
  echo "Flood control: $rema Seconds<br/><br/>";
  echo "<a accesskey=\"9\" href=\"lists.php?action=buds\">Buddylist</a><br/>";
  echo "<a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p></body></html>";
  exit();
  }
  $uid = getuid_sid($sid);
  if (!arebuds($uid, $who))
  {
  echo "$whonick is not in ur buddy list<br/><br/>";
}
  echo "<a accesskey=\"9\" href=\"lists.php?action=buds\">Buddylist</a><br/>";
  echo "<a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p></body></html>";
  exit();
  
   exit();
    }
////////////////////////////////////////////////////
*/
else if($action=="sendpopup")
{boxstart("Inbox");
  echo "<head>";
  echo "<title>Send Popup</title>";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
  echo "<body>";
  echo "<p align=\"center\">";
  $pmid = $_GET["pmid"];
  $whonick = getnick_uid($who);
  $byuid = getuid_sid($sid);
  $tm = time();
  $lastpm = mysql_fetch_array(mysql_query("SELECT MAX(timesent) FROM dcroxx_me_popups WHERE byuid='".$byuid."'"));
  $pmfl = $lastpm[0]+getpmaf();
  $pmurd = mysql_query("UPDATE dcroxx_me_popups SET unread='0' WHERE id='".$pmid."'");

  if($byuid==1)$pmfl=0;
  if($pmfl>$tm)
  {
  $rema = $pmfl - $tm;
  echo "<img src=\"../images/notok.gif\" alt=\"X\"/>";
  echo "Flood control: $rema Seconds<br/><br/>";
  echo "<b>9 </b><a accesskey=\"9\" href=\"lists.php?action=buds\">Buddylist</a><br/>";
  echo "<b>0 </b><a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p></body></html>";
  exit();
  }
  $uid = getuid_sid($sid);
  if (!arebuds($uid, $who))
  {
  echo "$whonick is not in ur buddy list<br/><br/>";
  echo "<b>9 </b><a accesskey=\"9\" href=\"lists.php?action=buds\">Buddylist</a><br/>";
  echo "<b>0 </b><a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p></body></html>";
  exit();
  }
 
if(isignored($uid, $who))
    {
    echo "<img src=\"../images/notok.gif\" alt=\"X\"/>";
    echo "Failed Sending Pop-up To $whonick they hav u on ignore...<br/><br/>";
    echo "<b>9 </b><a accesskey=\"9\" href=\"lists.php?action=buds\">Buddylist</a><br/>";
    echo "<b>0 </b><a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
    echo "</p></body></html>";
    exit();
    }
else if(isblocked($pmtext,$byuid))
    {
    $bantime = time() + (28*24*60*60);
    echo "<img src=\"../images/notok.gif\" alt=\"X\"/>";
    echo "Can't Send PM to $whonick<br/><br/>";
    echo "You just sent a link to one of the crapiest sites on earth<br/> The members of these sites spam here a lot, so go to that site and stay there if you don't like it here<br/> as a result of your stupid action:<br/>1. you have lost your sheild<br/>2. you have lost all your plusses<br/>3. You are BANNED!";
        $user = getnick_sid($sid);
    mysql_query("INSERT INTO dcroxx_me_mlog SET action='autoban', details='<b>Wap Desire</b> auto banned $user for spamming thru popups', actdt='".time()."'"); 
    mysql_query("INSERT INTO dcroxx_me_penalties SET uid='".$byuid."', penalty='1', exid='2', timeto='".$bantime."', pnreas='Banned: Automatic Ban for spamming for a crap site'");
    mysql_query("UPDATE dcroxx_me_users SET plusses='0', shield='0' WHERE id='".$byuid."'");
    mysql_query("INSERT INTO dcroxx_me_popups SET text='".$pmtext."', byuid='".$byuid."', touid='1', timesent='".$tm."'");
    mysql_query("INSERT INTO dcroxx_me_private SET text='[b](forwarded spam via popups)[/b][br/]".$pmtext."', byuid='".$byuid."', touid='1', timesent='".$tm."'");
    echo "</p></body></html>";
    exit();
    }
  $res = mysql_query("INSERT INTO dcroxx_me_popups SET text='".$pmtext."', byuid='".$byuid."', touid='".$who."', timesent='".$tm."'");

  $res = mysql_query("INSERT INTO dcroxx_me_popups2 SET text='".$pmtext."', byuid='".$byuid."', touid='".$who."', timesent='".$tm."'");
  if($res)
  {

    echo "<img src=\"../images/ok.gif\" alt=\"O\"/>";
    echo "Pop-up was sent successfully to $whonick<br/><br/>";
    echo parsepm($pmtext, $sid);
    }else{
    echo "<img src=\"../images/notok.gif\" alt=\"X\"/>";
    echo "Failed Sending Pop-up To $whonick<br/><br/>";
  }
  $uid = getuid_sid($sid);
  $location = mysql_fetch_array(mysql_query("SELECT placedet FROM dcroxx_me_online WHERE userid='".$uid."'"));
  		   $loca = $location[0];
  		   echo "<br/><b>1 </b><a accesskey=\"1\" href=\"$loca\">ok!</a><br/>";
	  echo "<br/><b>4 </b><a accesskey=\"4\" href=\"index.php?action=popdisable\">Disable Pop-Ups</a><br/>";
     if($lastloc=="cht"){
	        echo "<b>5 </b><a accesskey=\"5\" href=\"chat.php?sid=$sid&amp;rid=$rid\">Back To $rname</a><br/>";
}
  echo "<b>6 </b><a accesskey=\"6\" href=\"inbox.php?action=main\">Inbox</a><br/>";
  echo "<b>7 </b><a accesskey=\"7\" href=\"lists.php?action=buds\">BuddyList</a><br/>";
  echo "<b>8 </b><a accesskey=\"8\" href=\"index.php?action=chat\">Chat</a><br/>";
 
  echo "<b>0 </b><a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
    echo "</p></body>";
     exit();
    }
////////////////////////////////////////////////////
else if($action=="proc")
{

    $pmact = $_POST["pmact"];
    $pact = explode("-",$pmact);
    $pmid = $pact[1];
    $pact = $pact[0];
    $pstyle = gettheme($sid);
      echo xhtmlhead("Inbox",$pstyle);
    echo "<p align=\"center\">";
    $pminfo = mysql_fetch_array(mysql_query("SELECT text, byuid, touid, reported FROM dcroxx_me_private WHERE id='".$pmid."'"));
    if($pact=="rep")
    {
      addonline(getuid_sid($sid),"Sending PM","");

      $whonick = getnick_uid($pminfo[1]);
  echo "Send PM to $whonick<br/><br/>";
  echo "<form action=\"inbxproc.php?action=sendpm&amp;who=$pminfo[1]\" method=\"post\">";
  echo "<input name=\"pmtext\" maxlength=\"500\"/><br/>";
  echo "<input type=\"submit\" value=\"Send\"/>";
echo "</form>";

    }else if($pact=="del")
    {
        addonline(getuid_sid($sid),"Deleting PM","");
        if(getuid_sid($sid)==$pminfo[2])
        {
          if($pminfo[3]=="1")
          {

            echo "<img src=\"images/notok.gif\" alt=\"X\"/>This PM is reported, thus it can't be deleted";
          }else{
          $del = mysql_query("DELETE FROM dcroxx_me_private WHERE id='".$pmid."' ");
          if($del)
          {
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>PM delted successfully";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Can't Delete PM at the moment";
          }
          }

        }else{
          echo "<img src=\"images/notok.gif\" alt=\"X\"/>This PM ain't yours";
        }
    }else if($pact=="str")
    {
        addonline(getuid_sid($sid),"Starring PM","");
        if(getuid_sid($sid)==$pminfo[2])
        {
          $str = mysql_query("UPDATE dcroxx_me_private SET starred='1' WHERE id='".$pmid."' ");
          if($str)
          {
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>PM starred successfully";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Can't star PM at the moment";
          }
        }else{
          echo "<img src=\"images/notok.gif\" alt=\"X\"/>This PM ain't yours";
        }
    }else if($pact=="ust")
    {
        addonline(getuid_sid($sid),"Unstarring PM","");
        if(getuid_sid($sid)==$pminfo[2])
        {
          $str = mysql_query("UPDATE dcroxx_me_private SET starred='0' WHERE id='".$pmid."' ");
          if($str)
          {
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>PM unstarred successfully";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Can't unstar PM at the moment";
          }
        }else{
          echo "<img src=\"images/notok.gif\" alt=\"X\"/>This PM ain't yours";
        }
    }else if($pact=="rpt")
    {
        addonline(getuid_sid($sid),"Reporting PM","");
        if(getuid_sid($sid)==$pminfo[2])
        {
          if($pminfo[3]=="0")
          {
          $str = mysql_query("UPDATE dcroxx_me_private SET reported='1' WHERE id='".$pmid."' ");
          if($str)
          {
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>PM reported to mods successfully";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Can't report PM at the moment";
          }
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>This PM is already reported";
          }
        }else{
          echo "<img src=\"images/notok.gif\" alt=\"X\"/>This PM ain't yours";
        }
    }
	else if($pact=="frd")
    {
        addonline(getuid_sid($sid),"Forwarding PM","");
        if(getuid_sid($sid)==$pminfo[2]||getuid_sid($sid)==$pminfo[1])
        {

  echo "Forward to e-mail:<br/><br/>";
  echo "<input name=\"email\" maxlength=\"250\"/><br/>";
  echo "<anchor>Froward<go href=\"inbxproc.php?action=frdpm\" method=\"post\">";
  echo "<postfield name=\"email\" value=\"$(email)\"/>";
  echo "<postfield name=\"pmid\" value=\"$pmid\"/>";
  echo "</go></anchor>";
        }else{
          echo "<img src=\"images/notok.gif\" alt=\"X\"/>This PM ain't yours";
        }
    }
	else if($pact=="dnl")
    {
        addonline(getuid_sid($sid),"Downloading PM","");
        if(getuid_sid($sid)==$pminfo[2]||getuid_sid($sid)==$pminfo[1])
        {
          echo "<img src=\"images/ok.gif\" alt=\"X\"/>request processed successfully<br/><br/>";
		  echo "<a href=\"rwdpm.php?action=dpm&amp;pmid=$pmid\">Download PM</a>";
        }else{
          echo "<img src=\"images/notok.gif\" alt=\"X\"/>This PM ain't yours";
        }
    }
    echo "<br/><br/><a href=\"inbox.php?action=main\">Back to inbox</a><br/>";
      $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
    echo "</p>";
  echo xhtmlfoot();
    exit();
    }
//////////////////////////////////////////////////////Send MMS////////////////////////
else if($action=="sendmms"){
$byuid = getuid_sid($sid);
$pmtou = $_POST["pmtou"];
addonline(getuid_sid($sid),"Sending a multimedia message to $pmtou","");
 $pstyle = gettheme($sid);
      echo xhtmlhead("Inbox",$pstyle);
$pmtext = $_POST["pmtext"];
$size = $_FILES['attach']['size']/1024;
$origname = $_FILES['attach']['name'];
$ext = explode(".", strrev($origname));
switch(strtolower($ext[0])){
	case "dim":
	$res = true;
	break;
	case "3pm":
	$res = true;
	break;
	case "mr":
	$res = true;
	break;
	case "fdp":
	$res = true;
	break;
	case "4pm":
	$res = true;
	break;
	case "iva":
	$res = true;
	break;
	case "rma":
	$res = true;
	break;
	case "vaw":
	$res = true;
	break;
	  case "gpj":
	$res = true;
	break;
	case "gnp":
	$res = true;
	break;
	case "pmb":
	$res = true;
	break;
	case "fig":
	$res = true;
	break;
	case "pg3":
	$res = true;
	break;
	case "piz":
	$res = true;
	break;
	case "rar":
	$res = true;
	break;
	case "sis":
	$res = true;
	break;
	case "raj":
	$res = true;
	break;
	case "exe":
	$res = true;
	break;
	case "gepj":
	$res = true;
	break;
}
$tm = time();
$uploaddir = $mmsdir;  //can be configured in config.php
$who = getuid_nick($pmtou);
echo "<p align=\"center\">";
if($size>2048){
	echo "File is larger than 2MB";

}
else if ($res!=true){

	echo "File type not supported! Please attach only a JPG or JPEG or GIF or BMP or PNG or 3GP or MID or WAV or MP3 or MP4 or AVI or AMR or SIS or EXE or ZIP or JAR or RAR or PDF file";
}
else if(isblocked($pmtext,$byuid)){
$bantime = time() + (7*24*60*60);
echo "<img src=\"images/notok.gif\" alt=\"X\"/>";
echo "Can't Send MMS to $pmtou<br/><br/>";
echo "You just sent a link to one of the crappiest sites on earth<br/> The members of these sites spam here a lot, so go to that site and stay there if you don't like it here<br/> as a result of your stupid action:<br/>1. you have lost your sheild<br/>2. you have lost all your plusses<br/>3. You are BANNED!";
mysql_query("INSERT INTO dcroxx_me_penalties SET uid='".$byuid."', penalty='1', exid='1', timeto='".$bantime."', pnreas='Banned: Automatic Ban for spamming for a crap site'");
mysql_query("UPDATE dcroxx_me_users SET plusses='0', shield='0' WHERE id='".$byuid."'");
mysql_query("INSERT INTO dcroxx_me_private SET text='".$pmtext."', byuid='".$byuid."', touid='2', timesent='".$tm."'");
$res=false;
}
else if((isignored($byuid, $who))&&(istrashed($byuid))){
	echo "You can't send this message. Either you are in $pmtou's ignore list or any admin has trashed you and barred your outgoing messaging.";
	$res=false;
}
else{
	$name = mysql_fetch_array(mysql_query("SELECT (MAX(id)+1) FROM mms"));
	$uploadfile = $name[0].".".strrev($ext[0]);
	move_uploaded_file($_FILES['attach']['tmp_name'], "$uploaddir/$uploadfile");
	$ext=strrev($ext[0]);
		$res1 = mysql_query("INSERT INTO mms SET origname='".$origname."', pmtext='".$pmtext."', byuid='".$byuid."', unread='1', touid='".$who."', timesent='".$tm."', filename='".$uploadfile."', size='$size', extension='".$ext."'");
}
if($res1){
	echo "Your MMS was successfully sent to $pmtou";
}
else {
	echo "Message not sent! Check error messages and report to a moderator or admin if applicable.";
}
echo "<br/><br/><a href=\"inbox.php?action=mms\">Back to MMS Inbox</a></p>";
echo "<br/><br/><a href=\"inbox.php?action=main\">Back to inbox</a></p>";
      $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));  
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
    echo "</p>";
  echo xhtmlfoot();
   exit();
    }
//////////////////////////////////////////////////////////mms proc////////////////
else if($action=="mproc")
{
$pmact = $_POST["pmact"];
$pact = explode("-",$pmact);
$pmid = $pact[1];
$pact = $pact[0];
echo "<p align=\"center\">";
$pminfo = mysql_fetch_array(mysql_query("SELECT pmtext, byuid, touid, filename, reported FROM mms WHERE id='".$pmid."'"));
if($pact=="del"){
 $pstyle = gettheme($sid);
      echo xhtmlhead("Inbox",$pstyle);
addonline(getuid_sid($sid),"Deleting an MMS","");
if(getuid_sid($sid)==$pminfo[2]){
$del = mysql_query("DELETE FROM mms WHERE id='".$pmid."' ");
unlink($mmsdir."/".$pminfo[3]);
if($del){
echo "<img src=\"images/ok.gif\" alt=\"O\"/>MMS deleted successfully";
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Can't Delete MMS at the moment";
}
}
else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>This MMS ain't yours";
}
}
else if($pact=="str"){
addonline(getuid_sid($sid),"Saving MMS","");
if(getuid_sid($sid)==$pminfo[2]){
$str = mysql_query("UPDATE mms SET starred='1' WHERE id='".$pmid."' ");
if($str){
echo "<img src=\"images/ok.gif\" alt=\"O\"/>MMS saved successfully";
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Can't save MMS at the moment";
}
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>This MMS ain't yours";
}
}else if($pact=="ust"){
addonline(getuid_sid($sid),"Unsaving an MMS","");
if(getuid_sid($sid)==$pminfo[2]){
$str = mysql_query("UPDATE mms SET starred='0' WHERE id='".$pmid."' ");
if($str){
echo "<img src=\"images/ok.gif\" alt=\"O\"/>MMS unsaved successfully";
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Can't unsave MMS at the moment";
}
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>This MMS ain't yours";
}
}else if($pact=="rpt"){
addonline(getuid_sid($sid),"Reporting MMS","");
if(getuid_sid($sid)==$pminfo[2]){
if($pminfo[4]==0){
$str = mysql_query("UPDATE mms SET reported='1' WHERE id='".$pmid."' ");
if($str){
echo "<img src=\"images/ok.gif\" alt=\"O\"/>PM reported to mods successfully";
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Can't report PM at the moment";
}
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>This PM is already reported";
}
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>This PM ain't yours";
}
}
else if($pact=="frd"){
addonline(getuid_sid($sid),"Forwarding PM","");
if(getuid_sid($sid)==$pminfo[2]||getuid_sid($sid)==$pminfo[1]){
echo "Forward to e-mail address:<br/><br/>";
echo "<form action=\"inbxproc.php?action=frdpm\" method=\"post\">
<input type=\"text\" name=\"email\" maxlength=\"250\"/>
<input type=\"hidden\" name=\"pmid\" value=\"$pmid\"/><br/>";
echo "<input type=\"submit\" name=\"submit\" value=\"Send\"/>";
echo "</form>";
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>This PM ain't yours";
}
}
echo "<br/><br/><a href=\"inbox.php?action=mms\">Back to MMS Inbox</a></p>";
echo "<br/><br/><a href=\"inbox.php?action=main\">Back to inbox</a></p>";
      $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));  
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
    echo "</p>";
  echo xhtmlfoot();

   exit();
    }
////////////////////////////////////////////////////
else if($action=="sendfun")
{
  echo "<head>";
  echo "<title>Inbox</title>";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
  echo "<body>";
  echo "<p align=\"center\">";
  $pmtou = $_POST["who"];
  $who = getuid_nick($pmtou);
    if($who==0)
    {
      echo "<img src=\"../images/notok.gif\" alt=\"x\"/>User Does Not exist<br/>";
    }else{
$whonick = getnick_uid($who);
  $byuid = getuid_sid($sid);
  $tm = time();
  $lastpm = mysql_fetch_array(mysql_query("SELECT MAX(timesent) FROM dcroxx_me_private WHERE byuid='".$byuid."'"));
  $pmfl = $lastpm[0]+getpmaf();
  if($pmfl<$tm)
  {
    if(!isblocked($pmtext,$byuid))
    {
    if((!isignored($byuid, $who))&&(!istrashed($byuid)))
    {
  $res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$pmtext."', byuid='".$byuid."', touid='".$who."', timesent='".$tm."'");
  }else{
    $res = true;
  }
  if($res)
  {
    echo "<img src=\"../images/ok.gif\" alt=\"O\"/>";
    echo "Fun Alert was sent successfully to $whonick<br/><br/>";
    echo parsepm($pmtext, $sid);

  }else{
    echo "<img src=\"../images/notok.gif\" alt=\"X\"/>";
    echo "Can't Send Fun Alert to $whonick<br/><br/>";
  }
  }else{
   $bantime = time() + (7*24*60*60);
    echo "<img src=\"../images/notok.gif\" alt=\"X\"/>";
    echo "Can't Send Inbox to $whonick<br/><br/>";
    echo "You just sent a link to one of the crapiest sites on earth<br/> The members of these sites spam here a lot, so go to that site and stay there if you don't like it here<br/> as a result of your stupid action:<br/>1. you have lost your sheild<br/>2. you have lost all your plusses<br/>3. You are BANNED!";
  $user = getnick_uid($sid);
    mysql_query("INSERT INTO dcroxx_me_mlog SET action='autoban', details='<b>Wap Desire</b> auto banned $user for spamming inbox', actdt='".time()."'");
    mysql_query("INSERT INTO dcroxx_me_penalties SET uid='".$byuid."', penalty='1', exid='2', timeto='".$bantime."', pnreas='Banned: Automatic Ban for spamming for a crap site'");
    mysql_query("UPDATE dcroxx_me_users SET plusses='0', shield='0' WHERE id='".$byuid."'");
    mysql_query("INSERT INTO dcroxx_me_private SET text='".$pmtext."', byuid='".$byuid."', touid='1', timesent='".$tm."', reported='1'");
    exit();
  }
  }else{
    $rema = $pmfl - $tm;
    echo "<img src=\"../images/notok.gif\" alt=\"X\"/>";
    echo "Flood control: $rema Seconds<br/><br/>";
  }

    }
  echo "<br/><a accesskey=\"6\" href=\"inbox.php?action=main\">Inbox</a><br/>";
  echo "<a accesskey=\"7\" href=\"lists.php?action=buds\">BuddyList</a><br/>";
  echo "<a accesskey=\"8\" href=\"index.php?action=chat\">Chat</a><br/>";
  echo "<a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p>";
    echo "</body>";
   exit();
    }
////////////////////////////////////////////////////
else if($action=="proall")
{
    $pact = $_POST["pmact"];
    $pstyle = gettheme($sid);
      echo xhtmlhead("Inbox",$pstyle);
    echo "<p align=\"center\">";
    addonline(getuid_sid($sid),"Deleting PMs","");
      $uid = getuid_sid($sid);
    if($pact=="ust")
    {

      $del = mysql_query("DELETE FROM dcroxx_me_private WHERE touid='".$uid."' AND reported !='1' AND starred='0' And unread='0'");
      if($del)
          {
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>All PMS except starred and unread are deleted successfully";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Can't Delete PM at the moment";
          }
    }else if($pact=="red")
    {

        $del = mysql_query("DELETE FROM dcroxx_me_private WHERE touid='".$uid."' AND reported !='1' and unread='0'");
      if($del)
          {
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>All PMS except unread, including starred are deleted successfully";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Can't Delete PM at the moment";
          }

    }else if($pact=="all")
    {
        $del = mysql_query("DELETE FROM dcroxx_me_private WHERE touid='".$uid."' AND reported !='1'");
      if($del)
          {
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>All PMS except reported, including starred and unread are deleted successfully";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Can't Delete PM at the moment";
          }
    }

    echo "<br/><br/><a href=\"inbox.php?action=main\">Back to inbox</a><br/>";
      $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
    echo "</p>";
  echo xhtmlfoot();
   exit();
    }
////////////////////////////////////////////////////
else if($action=="frdpm")
{
	$email = $_POST["email"];
	$pmid = $_POST["pmid"];
  addonline(getuid_sid($sid),"Forwarding PM","");
  $pstyle = gettheme($sid);
      echo xhtmlhead("Inbox",$pstyle);
  echo "<p align=\"center\">";

  $pminfo = mysql_fetch_array(mysql_query("SELECT text, byuid, timesent,touid, reported FROM dcroxx_me_private WHERE id='".$pmid."'"));


  if(($pminfo[3]==getuid_sid($sid))||($pminfo[1]==getuid_sid($sid)))
  {
  $from_head = "From: noreplay@$stitle";
  $subject = "PM By ".getnick_uid($pminfo[1])." To ".getnick_uid($pminfo[3])." ($stitle)";
  $content = "Date: ".date("l d/m/y H:i:s", $pminfo[2])."\n\n";
  $content .= $pminfo[0]."\n------------------------\n";
  $content .= "$stitle: The best wap community!";
  mail($email, $subject, $content, $from_head);
 echo "<img src=\"images/ok.gif\" alt=\"X\"/>PM forwarded to $email";
  }else{
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>This PM ain't yours";
  }
  echo "<br/><br/><a href=\"inbox.php?action=main\">Back to inbox</a><br/>";
      $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }
////////////////////////////////////////////////////

  else{
    addonline(getuid_sid($sid),"Lost in inbox lol","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Inbox",$pstyle);
  echo "<p align=\"center\">";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
      $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
   exit();
    }

?>