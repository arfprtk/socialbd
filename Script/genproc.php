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
$uid = getuid_sid($sid);
    if((islogged($sid)==false)||($uid==0))
    {
      $pstyle = gettheme($sid);
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
	   echo "<b>Account is Not Validated Yet</b><br/>";
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
    echo "<b>Account Not Validated yet</b><br/>This could take up to 3 hrs(normally 15 minutes) pls be patient and try again soon<br/>..Untill then browse and Enjoy other features in wap.weblk.tk.<br/>thank you!<br/><br/>";

	echo "<a href=\"index.php?action=formmenu\">Back To Forums</a><br/>";
	echo "<a href=\"downloads/xindex.php?action=main\">Back To Downloads</a><br/>";
	 echo "<a href=\"index.php?action=main\">Back To Home</a><br/><br/>";

	 echo "</p>";
   echo xhtmlfoot();
      exit();


    }
////////////////////////////////////////////////////////////////
else if($action=="shtpc")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Shout a Topic",$pstyle);
$tid = $_GET["tid"];
addonline(getuid_sid($sid),"Shout a Topic","");
echo "<card id=\"main\" title=\"Shout a Topic\">";
echo "<p align=\"center\">";
    if((ispu(getuid_sid($sid)))||(ismod(getuid_sid($sid)))||(isowner(getuid_sid($sid))))
	{
$uid = getuid_sid($sid);
echo "<b>Attention!!!</b><br/>You'll be charge 3 plusses per shout topic.<br/><br/>";
echo "<a href=\"genproc.php?action=shtpc2&amp;tid=$tid\">Do you agree?</a><br/>
<a href=\"index.php?action=viewtpc&amp;tid=$tid\">No, Thanks</a><br/>";
}else{
 echo "<img src=\"images/notok.gif\" alt=\"X\"/><br/><b>Access Denied!!</b><br/><br/>
 You aren't a Premium User or not in our Staff Panel<br/>
 Upgade your profile for unlock this feature.
";
}
//echo mobads();
echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
echo "";
echo "</p>";
echo "</card>";

}
else if($action=="shtpc2")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Shout a Topic",$pstyle);
$tid = $_GET["tid"];
addonline(getuid_sid($sid),"Shout a Topic","");
echo "<card id=\"main\" title=\"Shout a Topic\">";
echo "<p align=\"center\"><small>";
    if((ispu(getuid_sid($sid)))||(ismod(getuid_sid($sid)))||(isowner(getuid_sid($sid)))){
$uid = getuid_sid($sid);

    $tinfo = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_topics WHERE id='".$tid."'"));
    $tnm = htmlspecialchars($tinfo[0]);
$txt = "[br/]Hello [nick], you are highly requested to view [red][topic=$tid]$tnm"."[/topic][/red]. Please view the topic and post your comment now.";
$res = mysql_query("INSERT INTO dcroxx_me_shouts SET  shout='".$txt."', shouter='".$uid."', shtime='".time()."'");
if($res)
{
echo "<img src=\"images/ok.gif\" alt=\"o\"/>Topic ID: <b>$tid</b> added into shoutbox and one time <b>3</b> Plusses charged from you account<br/>";
$hehe=mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
$totl = $hehe[0]-3;
}else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!<br/>";
}

}else{
 echo "<img src=\"images/notok.gif\" alt=\"X\"/><br/><b>Access Denied!!</b><br/><br/>
 You aren't a Premium User or not in our Staff Panel<br/>
 Upgade your profile for unlock this feature.
";
}

//echo mobads();
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
echo "";
echo "</small></p>";
echo "</card>";

}

else if($action=="delstatus")
{
  $shid = $_GET["shid"];
 echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\">";

$item = mysql_fetch_array(mysql_query("SELECT id, status, uid, time, smood  FROM ibwfrr_status WHERE id='".$shid."'"));
if($item[2]==$uid || ismod(getuid_sid($sid))){
  
  $sht = mysql_fetch_array(mysql_query("SELECT uid, status FROM ibwfrr_status WHERE id='".$shid."'"));
  $msg = getnick_uid($sht[0]);
  $msg .= ": ".htmlspecialchars((strlen($sht[1])<20?$sht[1]:substr($sht[1], 0, 20)));
  $res = mysql_query("DELETE FROM ibwfrr_status WHERE id ='".$shid."'");
  if($res)
          {
		  mysql_query("INSERT INTO dcroxx_me_mlog SET action='status', details='<b>".getnick_uid(getuid_sid($sid))."</b> Deleted the status <b>".$shid."</b> - $msg', actdt='".time()."'");
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>Status deleted";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
          }
  echo "<br/><br/>";
}else{
echo"You are not able to take this action";
}

  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}

else if($action=="updtthme")
{

  addonline(getuid_sid($sid),"Update Profile theme","");
  $theme = $_POST["thms"];
  $size = $_POST["size"];
  $uid = getuid_sid($sid);
  $exist = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE id='".$uid."'"));
if ($exist[0]>0)
  {
  $res = mysql_query("UPDATE dcroxx_me_users SET theme='".$theme.".css' WHERE id='".$uid."'");
  }else{
  $res = mysql_query("UPDATE dcroxx_me_users SET theme='".$theme.".css' WHERE id='".$uid."'");
  }
  echo "<p align=\"center\">";
  echo mysql_error();
if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"o\"/>Updated<br/><br/><br/>";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!<br/><br/>";
  }
  echo "<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p>";
  echo "</body>";
  echo "</html>";
  exit();
}
////////////////////////////////////////////////////////////////
if($action=="newtopic")
{
  $fid = $_POST["fid"];
  $ntitle = $_POST["ntitle"];
  $tpctxt = $_POST["tpctxt"];
  if(!canaccess(getuid_sid($sid), $fid))
    {
  $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "You Don't Have A Permission To View The Contents Of This Forum<br/><br/>";
      echo "<a href=\"index.php?action=main\">Home</a>";
      echo "</p>";
  echo xhtmlfoot();
      exit();
    }
  addonline(getuid_sid($sid),"Created New Topic","");
  $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
      echo "<p align=\"center\">";
      $crdate = (time() - $timeadjust) + $timeadjust;
      //$uid = getuid_sid($sid);
      $texst = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_topics WHERE name LIKE '".$ntitle."' AND fid='".$fid."'"));
      if($texst[0]==0)
      {
        $res = false;

        $ltopic = mysql_fetch_array(mysql_query("SELECT crdate FROM dcroxx_me_topics WHERE authorid='".$uid."' ORDER BY crdate DESC LIMIT 1"));
        global $topic_af;
        $antiflood = (time() - $timeadjust)-$ltopic[0] + $timeadjust;
        if($antiflood>$topic_af)
{
  if((trim($ntitle)!="")||(trim($tpctxt)!=""))
      {
      $res = mysql_query("INSERT INTO dcroxx_me_topics SET name='".$ntitle."', fid='".$fid."', authorid='".$uid."', text='".$tpctxt."', crdate='".$crdate."', lastpost='".$crdate."'");
     }
       if($res)
      {
        $usts = mysql_fetch_array(mysql_query("SELECT posts, plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
        $ups = $usts[0]+1;
        $upl = $usts[1]+1;
        mysql_query("UPDATE dcroxx_me_users SET posts='".$ups."', plusses='".$upl."' WHERE id='".$uid."'");
        $tnm = htmlspecialchars($ntitle);
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Topic <b>$tnm</b> Created Successfully";
        $tid = mysql_fetch_array(mysql_query("SELECT id FROM dcroxx_me_topics WHERE name='".$ntitle."' AND fid='".$fid."'"));
        echo "<br/><br/><a href=\"index.php?action=viewtpc&amp;tid=$tid[0]\">";
echo "View Topic</a>";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error Creating New Thread";
      }
      }else{
        $af = $topic_af -$antiflood;
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Antiflood Control: $af";
      }
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Topic Name already Exist";
      }





      $fname = getfname($fid);
      echo "<br/><br/><a href=\"index.php?action=viewfrm&amp;fid=$fid\">";
echo "$fname</a><br/>";
          $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
      echo "</p>";
  echo xhtmlfoot();
   exit();
    }
////////////////////////////////////////////////////////////////
else if($action=="post")
{
    $tid = $_POST["tid"];
    $tfid = mysql_fetch_array(mysql_query("SELECT fid FROM dcroxx_me_topics WHERE id='".$tid."'"));
if(!canaccess(getuid_sid($sid), $tfid[0]))
    {
  $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "You Don't Have A Permission To View The Contents Of This Forum<br/><br/>";
      echo "<a href=\"index.php?action=main\">Home</a>";
      echo "</p>";
   echo xhtmlfoot();
      exit();
    }
  $reptxt = $_POST["reptxt"];
  $qut = $_POST["qut"];
  addonline(getuid_sid($sid),"Posted A reply","");
  $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
      echo "<p align=\"center\">";
      $crdate = (time() - $timeadjust) + $timeadjust;
      $fid = getfid($tid);
      //$uid = getuid_sid($sid);
      $res = false;
      $closed = mysql_fetch_array(mysql_query("SELECT closed FROM dcroxx_me_topics WHERE id='".$tid."'"));

      if(($closed[0]!='1')||(ismod($uid)))
      {

        $lpost = mysql_fetch_array(mysql_query("SELECT dtpost FROM dcroxx_me_posts WHERE uid='".$uid."' ORDER BY dtpost DESC LIMIT 1"));
        global $post_af;
        $antiflood = (time() - $timeadjust)-$lpost[0] + $timeadjust;
        if($antiflood>$post_af)
{
  if(trim($reptxt)!="")
      {
      $res = mysql_query("INSERT INTO dcroxx_me_posts SET text='".$reptxt."', tid='".$tid."', uid='".$uid."', dtpost='".$crdate."', quote='".$qut."'");
}
      if($res)
      {
        $usts = mysql_fetch_array(mysql_query("SELECT posts, plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
        $ups = $usts[0]+1;
        $upl = $usts[1]+1;
        mysql_query("UPDATE dcroxx_me_users SET posts='".$ups."', plusses='".$upl."' WHERE id='".$uid."'");
        mysql_query("UPDATE dcroxx_me_topics SET lastpost='".$crdate."' WHERE id='".$tid."'");
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Message Posted Successfully";
        echo "<br/><br/><a href=\"index.php?action=viewtpc&amp;tid=$tid&amp;go=last\">View Topic</a>";

$nick = getnick_sid($sid);
$shtx = mysql_fetch_array(mysql_query("SELECT name, authorid FROM dcroxx_me_topics WHERE id='".$tid."'"));
$txt = htmlspecialchars(substr(parsepm($shtx[0]), 0, 20));
$note = "[user=$uid]$nick"."[/user] reply a post on your topic - [aFardin=index.php?action=viewtpc&tid=$tid]$txt..."."[/aFardin]";
notify($note,$uid,$shtx[1]);

      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error Posting Message";
      }
      }else{
$af = $post_af -$antiflood;
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Antiflood Control: $af";
      }
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Topic is closed for posting";
      }

      $fname = getfname($fid);
      echo "<br/><br/><a href=\"index.php?action=viewfrm&amp;fid=$fid\">";
echo "$fname</a><br/>";
          $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
      echo "</p>";
  echo xhtmlfoot();
   exit();
    }
////////////////////////////////////////////////////////////////
else if($action=="upmood")
{$pstyle = gettheme($sid);

      echo xhtmlhead("$stitle",$pstyle);
     addonline(getuid_sid($sid),"Updating My Mood","");
$mmsg = $_POST["mmsg"];

      echo "<head>";
    echo "<title>Set OnlineList Mood</title>";
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/style.css\">";
    echo "</head>";
    echo "<body>";
    echo "<p align=\"center\">";
       $res = mysql_query("UPDATE dcroxx_me_users SET setmood='".$mmsg."' WHERE id='".$uid."'");
  if($res)
        {
            echo "<img src=\"images/ok.gif\" alt=\"o\"/>Mood updated successfully<br/>";
        }else{
          echo "<img src=\"images/notok.gif\" alt=\"x\"/>Can't update your Mood<br/>";
        }
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p>";
    echo "</body>";
}

else if($action=="statuslike")
{
$pstyle = gettheme($sid);
echo xhtmlhead("$stitle",$pstyle);
    $shid = $_REQUEST['shid'];
    addonline(getuid_sid($sid),"Liking Status","");
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"center\">";
    $vb = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_statuslike WHERE uid='".getuid_sid($sid)."' AND statusid='".$shid."'"));
    if($vb[0]>0)
    {
        echo "<img src=\"images/notok.gif\" alt=\"x\"/>You have already liked/disliked this status.<br/>";
    }
    else
    {
    $res = mysql_query("INSERT INTO ibwf_statuslike SET uid='".$uid."', statusid='".$shid."', rate='1', time='".time()."'");
    if($res)
    {
        echo "<img src=\"images/ok.gif\" alt=\"o\"/>Liked successfully<br/>";
        ///////////////// <----------------Notification By Tufan420-------------->
/*$nick = getnick_sid($sid);
$shtx = mysql_fetch_array(mysql_query("SELECT status, uid FROM ibwfrr_status WHERE id='".$shid."'"));
$txt = htmlspecialchars(substr(parsepm($shtx[0]), 0, 20));
$note = "[user=$uid]$nick"."[/user] liked your status - [aTufan420=statusupdates.php?action=statuslike&shid=$shid]$txt..."."[/aTufan420]";
notify($note,$uid,$shtx[1]);
$note2 = "[user=$uid]$nick"."[/user] liked the status of [user=".$shtx[1]."]".getnick_uid($shtx[1])."[/user] - [aTufan420=statusupdates.php?action=statuslike&shid=$shid]$txt..."."[/aTufan420]";
followersnotity($note2, $uid);*/
///////////////// <----------------Notification By Tufan420-------------->
        ///---------------> RECENT ACTIVITIES
        $ibwf = time()+6*60*60;
$nick = getnick_uid($uid);
mysql_query("insert into ibwfrr_events (uid,event,time) values ('$uid','<b>$nick</b> liked a status','$ibwf')");
    }
    else
    {
        echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!<br/>";
    }
    }
    
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
    echo "Home</a>";
    echo "</p></card>";
}
//////////////// shout dislike
else if($action=="statusdislike")
{
$pstyle = gettheme($sid);
echo xhtmlhead("$stitle",$pstyle);
    $shid = $_REQUEST['shid'];
    addonline(getuid_sid($sid),"Disliking Status","");
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"center\">";
    $vb = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_statuslike WHERE uid='".$uid."' AND statusid='".$shid."'"));
    if($vb[0]>0)
    {
        echo "<img src=\"images/notok.gif\" alt=\"x\"/>You have already liked/disliked this status.<br/>";
    }
    else
    {
    $res = mysql_query("INSERT INTO ibwf_statuslike SET uid='".$uid."', statusid='".$shid."', rate='0', time='".time()."'");
    if($res)
    {
        echo "<img src=\"images/ok.gif\" alt=\"o\"/>Disliked successfully<br/>";
        ///////////////// <----------------Notification By Tufan420-------------->
/*$nick = getnick_sid($sid);
$shtx = mysql_fetch_array(mysql_query("SELECT status, uid FROM ibwfrr_status WHERE id='".$shid."'"));
$txt = htmlspecialchars(substr(parsepm($shtx[0]), 0, 20));
$note = "[user=$uid]$nick"."[/user] disliked your status - [aTufan420=statusupdates.php?action=statusdislike&shid=$shid]$txt..."."[/aTufan420]";
notify($note,$uid,$shtx[1]);
$note2 = "[user=$uid]$nick"."[/user] disliked the status of [user=".$shtx[1]."]".getnick_uid($shtx[1])."[/user] - [aTufan420=statusupdates.php?action=statusdislike&shid=$shid]$txt..."."[/aTufan420]";
followersnotity($note2, $uid);*/
///////////////// <----------------Notification By Tufan420-------------->
        ///---------------> RECENT ACTIVITIES
    $ibwf = time()+6*60*60;
$nick = getnick_uid($uid);
mysql_query("insert into ibwfrr_events (uid,event,time) values ('$uid','<b>$nick</b> disliked a status','$ibwf')");
    }
    else
    {
        echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!<br/>";
    }
    }
    
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
    echo "Home</a>";
    echo "</p></card>";
}


////////////////////////////////////////////////////////////////
else if ($action=="uadd")
{
    $ucon = $_POST["ucon"];
    $ucit = $_POST["ucit"];
    $ustr = $_POST["ustr"];
    $utzn = $_POST["utzn"];
    $uphn = $_POST["uphn"];
    addonline(getuid_sid($sid),"My Address","");
  $pstyle = gettheme($sid);
      echo xhtmlhead("My Address",$pstyle);
    echo "<p align=\"center\">";
    $uid = getuid_sid($sid);
    $exs = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_xinfo WHERE uid='".$uid."'"));
    if($exs[0]>0)
    {
        $res = mysql_query("UPDATE dcroxx_me_xinfo SET country='".$ucon."', city='".$ucit."', street='".$ustr."', timezone='".$utzn."', phoneno='".$uphn."' WHERE uid='".$uid."'");
        if($res)
        {
          echo "<img src=\"images/ok.gif\" alt=\"O\"/>Address Updated Successfully<br/><br/>";
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"O\"/>Database Error!<br/><br/>";
        }
    }else{
        $res = mysql_query("INSERT INTO dcroxx_me_xinfo SET uid='".$uid."', country='".$ucon."', city='".$ucit."', street='".$ustr."', timezone='".$utzn."', phoneno='".$uphn."'");
        if($res)
        {
          echo "<img src=\"images/ok.gif\" alt=\"O\"/>Address Updated Successfully<br/><br/>";
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"O\"/>Database Error!<br/><br/>";
        }
    }
    echo "<a href=\"index.php?action=uxset\">";
echo "Extended Settings</a><br/>";
        $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }
////////////////////////////////////////////////////////////////
else if($action=="gcp")
{
    $clid = $_GET["clid"];
    $who = $_GET["who"];
    $giv = $_POST["giv"];
    $pnt = $_POST["pnt"];
    addonline(getuid_sid($sid),"Moderating Club Member","");
  $pstyle = gettheme($sid);
      echo xhtmlhead("Moderate Member",$pstyle);
    echo "<p align=\"center\">";
    $whnick = getnick_uid($who);
    echo "<b>$whnick</b>";
    echo "</p>";
    echo "<p>";
    $exs = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_clubmembers WHERE uid='".$who."' AND clid=".$clid.""));
$cow = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_clubs WHERE owner='".$uid."' AND id=".$clid.""));
if($exs[0]>0 && $cow[0]>0)
{
    $mpt = mysql_fetch_array(mysql_query("SELECT points FROM dcroxx_me_clubmembers WHERE uid='".$who."' AND clid='".$clid."'"));
    if($giv=="1")
    {
      $pnt = $mpt[0]+$pnt;
    }else{
        $pnt = $mpt[0]-$pnt;
        if($pnt<0)$pnt=0;
    }
    $res = mysql_query("UPDATE dcroxx_me_clubmembers SET points='".$pnt."' WHERE uid='".$who."' AND clid='".$clid."'");
    if($res)
    {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Club points updated successfully!";
    }else{
      echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error!";
    }
    }else{
      echo "<img src=\"images/notok.gif\" alt=\"X\"/>Missing Info!";
    }
    echo "</p>";

    echo "<p align=\"center\">";

        $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }
////////////////////////////////////////////////////////////////
else if($action=="rate")
{
  $rate= mysql_real_escape_string( $_REQUEST["rate"] );
  $bid = mysql_real_escape_string( $_REQUEST["bid"] );
  $who = mysql_real_escape_string( $_REQUEST["who"] );

   addonline(getuid_sid($sid),"Rating a member","");


if ($uid==$who)
{
       $pstyle = gettheme($sid);
      echo xhtmlhead("Rate User",$pstyle);
      echo "<body>";
      echo "<p align=\"center\">";
      echo "You Cant Rate Yourself Silly<br/>";
  echo "<a href=\"index.php?action=main\">";
echo "Main Page</a><br/>";
      echo "</p></body></html>";
      exit();
}

   $pstyle = gettheme($sid);
      echo xhtmlhead("Rate User",$pstyle);
      echo "<body>";
       echo "<p align=\"center\">";

$addplus = mysql_fetch_array(mysql_query("SELECT rate FROM dcroxx_me_users WHERE id='".$who."'"));


$add = $rate;
$addplus = $add + $addplus[0];
$res = mysql_query("UPDATE dcroxx_me_users SET rate= '".$addplus."' WHERE id='".$who."'");
  if($res)
   {
        echo "<img src=\"../images/ok.gif\" alt=\"o\"/> rated successfully<br/>";
   }else {
        echo "<img src=\"../images/notok.gif\" alt=\"x\"/>You have rated this user before<br/>";
   }

    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=main\">";
echo "Main Page</a><br/>";
        $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }
////////////////////////////////////////////////////////////////
else if($action=="gpl")
{
    $clid = $_GET["clid"];
    $who = $_GET["who"];
    $pnt = $_POST["pnt"];
    addonline(getuid_sid($sid),"Moderating Club Member","");
  $pstyle = gettheme($sid);
      echo xhtmlhead("Moderate Member",$pstyle);
    echo "<p align=\"center\">";
    $whnick = getnick_uid($who);
    echo "<b>$whnick</b>";
    echo "</p>";
    echo "<p>";
      echo "<img src=\"images/notok.gif\" alt=\"X\"/>Because people misused the plusses thing, clubs owners cant give plusses anymore";

    echo "</p>";

    echo "<p align=\"center\">";

        $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }
////////////////////////////////////////////////////////////////
else if ($action=="upre")
{
    $usds = $_POST["usds"];
    $usds = str_replace('"', "", $usds);
    $usds = str_replace("'", "", $usds);
    $ubon = $_POST["ubon"];
    $usxp = $_POST["usxp"];
    addonline(getuid_sid($sid),"Preferences","");
  $pstyle = gettheme($sid);
      echo xhtmlhead("Preferences",$pstyle);
    echo "<p align=\"center\">";
    $uid = getuid_sid($sid);
    $exs = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_xinfo WHERE uid='".$uid."'"));
    if($exs[0]>0)
    {
        $res = mysql_query("UPDATE dcroxx_me_xinfo SET sitedscr='".$usds."', budsonly='".$ubon."', sexpre='".$usxp."' WHERE uid='".$uid."'");
        if($res)
        {
          echo "<img src=\"images/ok.gif\" alt=\"O\"/>Preferences Updated Successfully<br/><br/>";
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"O\"/>Database Error!<br/><br/>";
        }
    }else{
        $res = mysql_query("INSERT INTO dcroxx_me_xinfo SET uid='".$uid."', sitedscr='".$usds."', budsonly='".$ubon."', sexpre='".$usxp."'");
        if($res)
        {
          echo "<img src=\"images/ok.gif\" alt=\"O\"/>Preferences Updated Successfully<br/><br/>";
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"O\"/>Database Error!<br/><br/>";
        }
    }
    echo "<a href=\"index.php?action=uxset\">";
echo "Extended Settings</a><br/>";
        $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }
////////////////////////////////////////////////////////////////

else if ($action=="gmset")
{
    $ugun = $_POST["ugun"];
    $ugpw = $_POST["ugpw"];
    $ugch = $_POST["ugch"];
    addonline(getuid_sid($sid),"G-Mail Settings","");
  $pstyle = gettheme($sid);
      echo xhtmlhead("G-Mail Settings",$pstyle);
    echo "<p align=\"center\">";
    $uid = getuid_sid($sid);
    $exs = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_xinfo WHERE uid='".$uid."'"));
    if($exs[0]>0)
    {
        $res = mysql_query("UPDATE dcroxx_me_xinfo SET gmailun='".$ugun."', gmailpw='".$ugpw."', gmailchk='".$ugch."', gmaillch='".((time() - $timeadjust) + (10*60*60))."' WHERE uid='".$uid."'");
        if($res)
        {
          echo "<img src=\"images/ok.gif\" alt=\"O\"/>Gmail Settings Updated Successfully<br/><br/>";
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"O\"/>Database Error!<br/><br/>";
        }
    }else{
        $res = mysql_query("INSERT INTO dcroxx_me_xinfo SET uid='".$uid."', gmailun='".$ugun."', gmailpw='".$ugpw."', gmailchk='".$ugch."', gmaillch='".((time() - $timeadjust) + (10*60*60))."'");
        if($res)
        {
          echo "<img src=\"images/ok.gif\" alt=\"O\"/>G-Mail Settings Updated Successfully<br/><br/>";
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"O\"/>Database Error!<br/><br/>";
        }
    }
    echo "<a href=\"index.php?action=uxset\">";
echo "Extended Settings</a><br/>";
        $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }

////////////////////////////////////////////////////////////////
else if ($action=="uper")
{
    $uhig = $_POST["uhig"];
    $uwgt = $_POST["uwgt"];
    $urln = $_POST["urln"];
    $ueor = $_POST["ueor"];
    $ueys = $_POST["ueys"];
    $uher = $_POST["uher"];
    $upro = $_POST["upro"];

    addonline(getuid_sid($sid),"Personality","");
  $pstyle = gettheme($sid);
      echo xhtmlhead("Personality",$pstyle);
    echo "<p align=\"center\">";
    $uid = getuid_sid($sid);
    $exs = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_xinfo WHERE uid='".$uid."'"));
    if($exs[0]>0)
    {
        $res = mysql_query("UPDATE dcroxx_me_xinfo SET height='".$uhig."', weight='".$uwgt."', realname='".$urln."', eyescolor='".$ueys."', profession='".$upro."', racerel='".$ueor."',hairtype='".$uher."'  WHERE uid='".$uid."'");
        if($res)
        {
          echo "<img src=\"images/ok.gif\" alt=\"O\"/>Personal Info Updated Successfully<br/><br/>";
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"O\"/>Database Error!<br/><br/>";
        }
    }else{
        $res = mysql_query("INSERT INTO dcroxx_me_xinfo SET uid='".$uid."', height='".$uhig."', weight='".$uwgt."', realname='".$urln."', eyescolor='".$ueys."', profession='".$upro."', racerel='".$ueor."',hairtype='".$uher."'");
        if($res)
        {
          echo "<img src=\"images/ok.gif\" alt=\"O\"/>Personal Info Updated Successfully<br/><br/>";
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"O\"/>Database Error!<br/><br/>";
        }
    }
    echo "<a href=\"index.php?action=uxset\">";
echo "Extended Settings</a><br/>";
        $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }

////////////////////////////////////////////////////////////////
else if ($action=="umin")
{
    $ulik = $_POST["ulik"];
    $ulik = str_replace('"', "", $ulik);
    $ulik = str_replace("'", "", $ulik);
    $udlk = $_POST["udlk"];
    $udlk = str_replace('"', "", $udlk);
    $udlk = str_replace("'", "", $udlk);
    $ubht = $_POST["ubht"];
    $ubht = str_replace('"', "", $ubht);
    $ubht = str_replace("'", "", $ubht);
    $ught = $_POST["ught"];
    $ught = str_replace('"', "", $ught);
    $ught = str_replace("'", "", $ught);
    $ufsp = $_POST["ufsp"];
    $ufsp = str_replace('"', "", $ufsp);
    $ufsp = str_replace("'", "", $ufsp);
    $ufmc = $_POST["ufmc"];
    $ufmc = str_replace('"', "", $ufmc);
    $ufmc = str_replace("'", "", $ufmc);
    $umtx = $_POST["umtx"];
    $umtx = str_replace('"', "", $umtx);
    $umtx = str_replace("'", "", $umtx);
    addonline(getuid_sid($sid),"More about me","");
  $pstyle = gettheme($sid);
      echo xhtmlhead("More About Me",$pstyle);
    echo "<p align=\"center\">";
    $uid = getuid_sid($sid);
    $exs = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_xinfo WHERE uid='".$uid."'"));
    if($exs[0]>0)
    {
        $res = mysql_query("UPDATE dcroxx_me_xinfo SET likes='".$ulik."', deslikes='".$udlk."', habitsb='".$ubht."', habitsg='".$ught."', favsport='".$ufsp."', favmusic='".$ufmc."',moretext='".$umtx."'  WHERE uid='".$uid."'");
        if($res)
        {
          echo "<img src=\"images/ok.gif\" alt=\"O\"/>Info Updated Successfully<br/><br/>";
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"O\"/>Database Error!<br/><br/>";
        }
    }else{
        $res = mysql_query("INSERT INTO dcroxx_me_xinfo SET uid='".$uid."', likes='".$ulik."', deslikes='".$udlk."', habitsb='".$ubht."', habitsg=';;".$ught."', favsport='".$ufsp."', favmusic='".$ufmc."',moretext='".$umtx."'");
        if($res)
        {
          echo "<img src=\"images/ok.gif\" alt=\"O\"/>Info Updated Successfully<br/><br/>";
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"O\"/>Database Error!<br/><br/>";
        }
    }
    echo "<a href=\"index.php?action=uxset\">";
echo "Extended Settings</a><br/>";
        $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }

//////////////////////////////////////////Bookmark Topic/////////////////////////

else if($action=="bkmrk")

{
addonline(getuid_sid($sid),"Bookmarking a Topic","");
 $pstyle = gettheme($sid);
      echo xhtmlhead("Bookmarks",$pstyle);
    $tpcid = $_GET["tid"];

    $uid = getuid_sid($sid);

    $indiatime = time() + (addhours());

    $blah = "SELECT name FROM dcroxx_me_topics WHERE id = '".$tpcid."'";

    $blah2 = mysql_query($blah);

    while($blah3=mysql_fetch_array($blah2)){

    $topicname=$blah3[0];

    }



    $sql = "SELECT COUNT(*) FROM dcroxx_me_bookmarks WHERE userid='".$uid."'";

    $result = mysql_query($sql);

    while($blah4=mysql_fetch_array($result))

{

    $used=$blah4[0];

}





  if($used=='50')



{

     echo "<img src=\"images/notok.gif\" alt=\"x\"/><b> Unable To Bookmark Topic!</b><br/>";



    echo "<br/>You have reached the limit of total Bookmarks Allowed!<br/>Delete existing bookmarks if you want to bookmark more topics!";;;;;

    echo "<br/><br/><a href=\"index.php?action=viewtpc&amp;tid=$tpcid\">Back To Topic</a><br/><br/>";





    echo "</div></div></font></body></html>";

    exit();

}

else {

  $res = "INSERT INTO `dcroxx_me_bookmarks` (`userid` ,`topic` ,`name` ,`time`) VALUES ('".$uid."', '".$tpcid."', '".$topicname."', '".$indiatime."')";

  $result = mysql_query($res) or die("<img src=\"images/notok.gif\" alt=\"x\"/><b>Unable To Bookmark Topic!</b><br/><br/>

  <b>Possible Reasons could be -</b> <br/>&#187;You Have Already Bookmarked This Topic!<br/>

  &#187;You Have Reached The Limit Of Total Allowed Bookmarks!<br/>

 &#187;Other Unknown Error!<br/>

 <br/><a href=\"index.php?action=viewtpc&amp;tid=$tpcid\">Back To Topic</a><br/><br/>

</center></div></div></font></body></html>

 ");



  if($res)

 {

            echo "<img src=\"images/ok.gif\" alt=\"o\"/>Topic Bookmarked successfully!<br/>";

            echo "<br/><a href=\"index.php?action=viewtpc&amp;tid=$tpcid\">Back To Topic</a>";

            echo "<br/><br/><a href=\"index.php?action=bookmarks\">Go To Bookmarks</a><br/>";



 }

    else

        {

            echo "<img src=\"images/notok.gif\" alt=\"x\"/>Unable To Bookmark Topic!<br/>";

            echo "<br/><a href=\"index.php?action=viewtpc&amp;tid=$tpcid\">Back To Topic</a>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
        echo "</p>";
  echo xhtmlfoot();
          exit();
    }




}}



/////////////////////////Delete Bookmark////////////////////////

else if($action=="kaltibkmrk")

{
 $pstyle = gettheme($sid);
      echo xhtmlhead("Bookmarks",$pstyle);
addonline(getuid_sid($sid),"Deleting a Bookmark","");

$tpcid=$_GET["tpcid"];

$sql="DELETE FROM `dcroxx_me_bookmarks` WHERE `id`='$tpcid'";

$res = mysql_query($sql);

if($res){

echo "<img src=\"images/ok.gif\" alt=\"O\"/>Bookmark deleted!";

}else{

echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error Deleting Bookmark!";

}

echo "<br/><br/><center><a href=\"index.php?action=bookmarks\">Back To Bookmarks</a></center><br/><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
        echo "</p>";
  echo xhtmlfoot();
   exit();
    }

/////////////////////////////////////////////
else if($action=="viewgallery")
{
 $pstyle = gettheme($sid);
      echo xhtmlhead("View Gallery",$pstyle);
addonline(getuid_sid($sid),"Gallery","");
$act = $_GET["act"];
$acts = ($act=="dis" ? 0 : 1);
echo "<p align=\"center\">";
//$uid = getuid_sid($sid);
$res = mysql_query("UPDATE dcroxx_me_users SET viewgallery='".$acts."' WHERE id='".$uid."'");
if($res)
{
echo "<img src=\"images/ok.gif\" alt=\"o\"/>Gallery Made Private!<br/>";
}else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>
Gallery cant be made private!<br/>";
}
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
        echo "</p>";
  echo xhtmlfoot();
   exit();
    }

/////////////////////////////////////////////
else if($action=="viewinbox")
{ 
$pstyle = gettheme($sid);
      echo xhtmlhead("View Inbox",$pstyle);
addonline(getuid_sid($sid),"Inbox","");
$act = $_GET["act"];
$acts = ($act=="dis" ? 0 : 1);
echo "<p align=\"center\">";
//$uid = getuid_sid($sid);
$res = mysql_query("UPDATE dcroxx_me_users SET viewinbox='".$acts."' WHERE id='".$uid."'");
if($res)
{
echo "<img src=\"images/ok.gif\" alt=\"o\"/>Inbox Made private!<br/>";
}else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>
You cant make profile private!<br/>";
}
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
        echo "</p>";
  echo xhtmlfoot();
   exit();
    }

/////////////////////////////////////////////
else if($action=="viewpro")
{
 $pstyle = gettheme($sid);
      echo xhtmlhead("View Profile",$pstyle);
addonline(getuid_sid($sid),"Profil","");
$act = $_GET["act"];
$acts = ($act=="dis" ? 0 : 1);
echo "<p align=\"center\">";
//$uid = getuid_sid($sid);
$res = mysql_query("UPDATE dcroxx_me_users SET viewpro='".$acts."' WHERE id='".$uid."'");
if($res)
{
echo "<img src=\"images/ok.gif\" alt=\"o\"/>Profile changed!<br/>";
}else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>
It's impossible to update your profile!<br/>";
}
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
        echo "</p>";
  echo xhtmlfoot();
   exit();
    }

///////////////////////////////////////////////////////////
else if($action=="mkroom")
{
        $rname = mysql_escape_string($_POST["rname"]);
        $rpass = trim($_POST["rpass"]);
        addonline(getuid_sid($sid),"Creating Chatroom","");
  $pstyle = gettheme($sid);
      echo xhtmlhead("Create Room",$pstyle);
        echo "<p align=\"center\">";
        if ($rpass=="")
        {
          $cns = 1;
        }else{
            $cns = 0;
        }
        $prooms = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_rooms WHERE static='0'"));
        if($prooms[0]<10)
        {
        $res = mysql_query("INSERT INTO dcroxx_me_rooms SET name='".$rname."', pass='".$rpass."', censord='".$cns."', static='0', lastmsg='".((time() - $timeadjust) + (10*60*60))."'");
        if($res)
        {
          echo "<img src=\"images/ok.gif\" alt=\"O\"/>Room created successfully<br/><br/>";
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error!<br/><br/>";
        }
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>There's already 10 users rooms<br/><br/>";
        }
        echo "<a href=\"index.php?action=uchat\"><img src=\"images/chat.gif\" alt=\"*\"/>Chatrooms</a><br/>";
        echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
        echo "</p>";
  echo xhtmlfoot();

   exit();
    }

else if($action=="addfile")
{

if(!getplusses(getuid_sid($sid))>24)
{
echo "<card id=\"main\" title=\"Dodaj fajl\">";
echo "<p align=\"center\">";
echo "Only 25+ plusses can add a vault item<br/><br/>";
echo "<a href=\"index.php?action=main\">Home</a>";
echo "</p>";
echo xhtmlfoot();
}
$viname = $_POST["viname"];
$vilink = $_POST["vilink"];
//$qut = $_POST["qut"];
addonline(getuid_sid($sid),"Unos Fajla u Vip panel","");
echo "<card id=\"main\" title=\"Forum\">";
echo "<p align=\"center\">";
$crdate = time();
//$uid = getuid_sid($sid);
$res = false;

if((trim($vilink)!="")&&(trim($viname)!=""))
{
$res = mysql_query("INSERT INTO dcroxx_me_file SET uid='".$uid."', title='".mysql_escape_string($viname)."', pudt='".$crdate."', itemurl='".$vilink."'");
}
if($res)
{
echo "<img src=\"images/ok.gif\" alt=\"O\"/>Fajl je uspesno dodat!";
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Nemougce uneti fajl!";
}


echo "<br/><br/>";
echo "<a href=\"lists.php?action=file\">VIP Download</a><br/>";
$thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
$themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'")); 
echo "<img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/> <a href=\"index.php?action=main\">";
echo "Home</a>";
echo "</p>";
echo xhtmlfoot();

}

else if($action=="uploadfile"){

    $pstyle = gettheme($sid);
    echo xhtmlhead("V.I.P CP!",$pstyle);
$flname = $_POST["flname"];
$myfile = $_POST["myfile"];
addonline(getuid_sid($sid),"Uploaduje fajl","");
echo "<card id=\"main\" title=\"Forum\">";
echo "<p align=\"center\">";
$crdate = time();
$res = false;

if(trim($flname) != "")
{
$FileName = $_FILES["myfile"]["name"];
$TempName = $_FILES["myfile"]["tmp_name"];
$MoveTheFile = @move_uploaded_file($TempName, "./files/" . $FileName . "");
if($MoveTheFile){
echo "".$FileName." has been successfully uploaded!";
mysql_query("INSERT INTO dcroxx_me_file SET uid='".$uid."', title='".mysql_escape_string($flname)."', pudt='".$crdate."', itemurl='files/" . $FileName . "'");
} else {
echo "Failed to upload!";
}}

echo "<br/><br/>";
echo "<a href=\"lists.php?action=file\">VIP Download</a><br/>";
$thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
$themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'")); 
echo "<img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/> <a href=\"index.php?action=main\">";
echo "Home</a>";
echo "</p>";
echo xhtmlfoot();

}
/////////////////Upload avatar////////////////////////
/*else if($action=="upavat")
{
 $pstyle = gettheme($sid);
      echo xhtmlhead("Upload Avatar",$pstyle);
addonline(getuid_sid($sid),"Uploading avatar image","");
$size = $_FILES['attach']['size']/1024;
$origname = $_FILES['attach']['name'];
$res = false;
$ext = explode(".", strrev($origname));
switch(strtolower($ext[0])){
        case "gpj":
    $res = true;
    break;
    case "gepj":
    $res = true;
    break;
}
$tm = time();
$uploaddir = "./avatars";
if($size>512){
    echo "<small>File is larger than 512KB</small><br/>";
}
else if ($res!=true){
    echo "<small>File type not supported! Please attach only a JPG/JPEG.</small><br/>";
}
else{
    $name = getuid_sid($sid);
    $uploadfile = $name.".".$ext;
    $uppath=$uploaddir."/".$uploadfile;
    move_uploaded_file($_FILES['attach']['tmp_name'], $uppath);
    $filewa=$uppath;
    list($width, $height, $type, $attr) = getimagesize($filewa);
    $newname=$uploaddir."/".$name."_SocialBD.jpg";
    $newheight = ($height*150)/$width;
    $newimg=imagecreatetruecolor(150, $newheight);
    $largeimg=imagecreatefromjpeg($filewa);
    imagecopyresampled($newimg, $largeimg, 0, 0, 0, 0, 150, $newheight, $width, $height);
    imagejpeg($newimg, $newname);
    imagedestroy($newimg);
    imagedestroy($largeimg);
    $file1=$name."_SocialBD.jpg";
    unlink($filewa);
       $res1 = mysql_query("UPDATE dcroxx_me_users SET avatar='./avatars/$file1' WHERE id='".$name."'");
}
if($res1){
    echo "<small>Your file $origname was successfully uploaded and set to your profile!</small>";
}
else {
    echo "<small>File couldn't be processed! Check error messages and report to a moderator or admin if applicable.</small>";
}
 echo "<small><br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a></small>";
  echo "</p>";
    echo "</body>";

}*/
else if($action=="upavat"){
 $pstyle = gettheme($sid);
      echo xhtmlhead("Upload Avatar",$pstyle);
addonline(getuid_sid($sid),"Uploading avatar image","");
include('class.upload.php');
  $userinfo = mysql_fetch_array(mysql_query("SELECT name, sex FROM dcroxx_me_users WHERE id='".$uid."'"));
  $membername = $userinfo[0];
  // we have three forms on the test page, so we redirect accordingly
  if ($_POST['action'] == 'image') {
        $pstyle = gettheme($sid);
        echo xhtmlhead("",$pstyle);
        echo "<p align=\"center\">";
      // ---------- IMAGE UPLOAD ----------
      // we create an instance of the class, giving as argument the PHP object
      // corresponding to the file field from the form
      // All the uploads are accessible from the PHP object $_FILES
      $handle = new Upload($_FILES['my_field']);
        // then we check if the file has been uploaded properly
      // in its *temporary* location in the server (often, it is /tmp)
      if ($handle->uploaded) {
            // yes, the file is on the server
          // below are some example settings which can be used if the uploaded file is an image.
          $handle->image_resize            = true;
          $handle->image_ratio_y           = true;
          $handle->image_x                 = 200;
         /* $handle->image_x                 = 189;
          $handle->image_y                 = 150;*/
       $handle->image_bevel = 10;
          $handle->image_bevel_color1 = '#FFFFFF';
$handle->image_bevel_color1 = '#000000';
//$handle->image_watermark = 'images/watermark.png';
if ($_POST['filter_x'] == '1') {
$handle->image_watermark = 'images/watermark.png';
}else if ($_POST['filter_x'] == '2') {
$handle->image_watermark = 'filter_x/Swirls_Vector_Green.png';
}else if ($_POST['filter_x'] == '3') {
$handle->image_watermark = 'filter_x/Swirls_Vector_Pink.png';
}else if ($_POST['filter_x'] == '4') {
$handle->image_watermark = 'filter_x/Swirls_Vector_Orange.png';
}else if ($_POST['filter_x'] == '5') {
$handle->image_watermark = 'filter_x/Swirls_Vector_Blue.png';
}else if ($_POST['filter_x'] == '6') {
$handle->image_watermark = 'filter_x/Rose_Love.png';
}else if ($_POST['filter_x'] == '7') {
$handle->image_watermark = 'filter_x/Love_Parrot.png';
}else if ($_POST['filter_x'] == '8') {
$handle->image_watermark = 'filter_x/New_Year.png';
}else if ($_POST['filter_x'] == '9') {
$handle->image_watermark = 'filter_x/Marry_Christmas.png';
}else if ($_POST['filter_x'] == '10') {
$handle->image_watermark = 'filter_x/Butterflies.png';
}else if ($_POST['filter_x'] == '11') {
$handle->image_watermark = 'filter_x/Bangladesh.png';
}else if ($_POST['filter_x'] == '12') {
$handle->image_watermark = 'filter_x/Apple.png';
}
$handle->image_watermark_x = 1;
$handle->image_watermark_position = 'BR';
            // now, we start the upload 'process'. That is, to copy the uploaded file
          // from its temporary location to the wanted location
          // It could be something like $handle->Process('/home/www/');
          $handle->Process('avatars/');
          // we check if everything went OK
         if ($handle->processed) {
              // everything was fine !
                echo '  Your profile picture changed!<br/>';
            //  echo '  <img src="avatars/' . $handle->file_dst_name . '" /><br/>';

              $info = getimagesize($handle->file_dst_pathname);
              echo '  link to the file just uploaded: <a href="avatars/' . $handle->file_dst_name . '">' . $handle->file_dst_name . '</a><br/>';
              $imageurl = "avatars/$handle->file_dst_name";
mysql_query("UPDATE dcroxx_me_users SET avatar='".$imageurl."' WHERE id='".$uid."'");
$reg = mysql_query("INSERT INTO dcroxx_me_usergallery SET uid='".$uid."', imageurl='".$imageurl."', sex='".$userinfo[1]."', time='".(time() - $timeadjust)."'");
            } else {
              // one error occured
              echo '  file not uploaded to the wanted location<br/>';
              echo '  Error: ' . $handle->error . '<br/>';
           }
          // we delete the temporary files
          $handle-> Clean();
       } else {
          // if we're here, the upload file failed for some reasons
          // i.e. the server didn't receive the file
            echo '  file not uploaded on the server<br/>';
          echo '  Error: ' . $handle->error . '';
      }
	  }
 echo "<br/><a href=\"index.php?action=viewuser&amp;who=$uid\">Go Back To Profile</a><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo "</body>";

}
else if($action=="musi")
{
addonline(getuid_sid($sid),"Add music","");
$act = $_GET["act"];
$acts = ($act=="dis" ? 0 : 1);
$pstyle = gettheme($sid);
echo xhtmlhead("$nazivsajta",$pstyle);
echo "<p align=\"center\">";
//$uid = getuid_sid($sid);
$res = mysql_query("UPDATE dcroxx_me_users SET showmusic='".$acts."' WHERE id='".$uid."'");
if($res)
{
echo "<img src=\"images/ok.gif\" alt=\"o\"/>Music Are Activated!<br/>";



}else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>Error Adding music to profile!<br/>";
}
echo "<br/><img src=\"images/home.gif\" alt=\"*\"/> <a href=\"index.php?action=main\">";
echo "Home</a>";
echo "</p>";
echo xhtmlfoot();
exit();
}
//////////////////////////////////////////
else if($action=="upmusic")
{
addonline(getuid_sid($sid),"Updating music","");
$musicid = $_GET["musicid"];

$musiclink = $_POST["musiclink"];
$pstyle = gettheme($sid);
echo xhtmlhead("$stitle",$pstyle);
echo "<p align=\"center\">";
//$uid = getuid_sid($sid);
$musiclink = mysql_fetch_array(mysql_query("SELECT musiclink FROM dcroxx_me_music WHERE id='".$musicid."'"));
$res = mysql_query("UPDATE dcroxx_me_users SET music='".$musiclink[0]."' WHERE id='".$uid."'");
if($res)
{
echo "<img src=\"images/ok.gif\" alt=\"o\"/>Music Selected<br/>";
}else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>Error!<br/>";
}
echo "<br/>";

$thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
$themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";

echo "</p>";
echo xhtmlfoot();
exit();
}
////////////////////////////////////////////////////////////////
else if($action=="signgb")
{
    $who = $_POST["who"];

if(!cansigngb(getuid_sid($sid), $who))
    {
  $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "You cant Sign this user guestbook<br/><br/>";
      echo "<a href=\"index.php?action=main\">Home</a>";
      echo "</p>";
  echo xhtmlfoot();
      exit();
    }
	
  $tm = time();
  $lastpm = mysql_fetch_array(mysql_query("SELECT MAX(dtime) FROM dcroxx_me_gbook WHERE gbsigner='".$uid."' AND gbowner='".$who."'"));
  $pmfl = $lastpm[0]+60;
  if($byuid==1)$pmfl=0;
  if($pmfl>$tm)
  {
  $rema = $pmfl - $tm;
    $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<img src=\"../images/notok.gif\" alt=\"X\"/>";
  echo "Flood control: $rema Seconds<br/><br/>";
  echo "<img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/><a href=\"index.php?action=main\">Home</a>";
  echo "</small></p></card></wml>";
  exit();
  }
  $msgtxt = $_POST["msgtxt"];
  //$qut = $_POST["qut"];
  addonline(getuid_sid($sid),"Signing a guestbook","");
  $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
      echo "<p align=\"center\">";
      $crdate = (time() - $timeadjust) + $timeadjust;
      //$uid = getuid_sid($sid);
      $res = false;

    if(trim($msgtxt)!="")
      {

      $res = mysql_query("INSERT INTO dcroxx_me_gbook SET gbowner='".$who."', gbsigner='".$uid."', dtime='".$crdate."', gbmsg='".$msgtxt."'");
      }
      if($res)
      {
	  $whonick = getnick_uid($who);
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Message successfully added!";
$pmtext = "$whonick have been signed in your guest book  [br/][br/][small][b][i]    This is an automated message and do not respond to it[/i][/b] [/small]";
$tm = time();
$res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$pmtext."', byuid='".$uid."', touid='".$who."', timesent='".$tm."'");


      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Impossible to enter a message!";
      }
      echo "<br/><br/>";
          $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
      echo "</p>";
  echo xhtmlfoot();

   exit();
    }
////////////////////////////////////////////////////////////////
else if($action=="votepl")
{
  //$uid = getuid_sid($sid);
  $plid = $_GET["plid"];
  $ans = $_GET["ans"];
  addonline(getuid_sid($sid),"Poll Voting ;)","");
  $pstyle = gettheme($sid);
      echo xhtmlhead("Poll Voting",$pstyle);
    echo "<p align=\"center\">";
    $voted = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_presults WHERE uid='".$uid."' AND pid='".$plid."'"));
    if($voted[0]==0)
    {
        $res = mysql_query("INSERT INTO dcroxx_me_presults SET uid='".$uid."', pid='".$plid."', ans='".$ans."'");
        if($res)
        {
            echo "<img src=\"images/ok.gif\" alt=\"o\"/>Thanx for your voting";
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!";
        }
    }else{
        echo "<img src=\"images/notok.gif\" alt=\"x\"/>You already voted for this poll";
    }
    echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }
////////////////////////////////////////////////////////////////
else if($action=="dlpoll")
{
  //$uid = getuid_sid($sid);
  addonline(getuid_sid($sid),"Deleting Poll","");
  $pstyle = gettheme($sid);
      echo xhtmlhead("Delete Poll",$pstyle);
    echo "<p align=\"center\">";
    $pid = mysql_fetch_array(mysql_query("SELECT pollid FROM dcroxx_me_users WHERE id='".$uid."'"));
        $res = mysql_query("UPDATE dcroxx_me_users SET pollid='0' WHERE id='".$uid."'");
        if($res)
        {
          $res = mysql_query("DELETE FROM dcroxx_me_presults WHERE pid='".$pid[0]."'");
		  $res = mysql_query("DELETE FROM dcroxx_me_pp_pres WHERE pid='".$pid[0]."'");
          $res = mysql_query("DELETE FROM dcroxx_me_polls WHERE id='".$pid[0]."'");
            echo "<img src=\"images/ok.gif\" alt=\"o\"/>Poll Deleted";
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!";
        }
    echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }

////////////////////////////////////////////////////////////////
else if($action=="delan")
{
  //$uid = getuid_sid($sid);
  addonline(getuid_sid($sid),"Deleting Announcement","");
  $pstyle = gettheme($sid);
      echo xhtmlhead("Delete Announcement",$pstyle);

  $clid = $_GET["clid"];
  $anid = $_GET["anid"];
  $uid = getuid_sid($sid);
    echo "<p align=\"center\">";
    $pid = mysql_fetch_array(mysql_query("SELECT owner FROM dcroxx_me_clubs WHERE id='".$clid."'"));
    $exs = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_announcements WHERE id='".$anid."' AND clid='".$clid."'"));
    if(($uid==$pid[0])&&($exs[0]>0))
    {
        $res = mysql_query("DELETE FROM dcroxx_me_announcements WHERE id='".$anid."'");
        if($res)
        {

            echo "<img src=\"images/ok.gif\" alt=\"o\"/>Announcement Deleted";
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!";
        }
    }else{
        echo "<img src=\"images/notok.gif\" alt=\"x\"/>Yo can't delete this announcement!";
    }
    echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }
////////////////////////////////////////////////////////////////

else if($action=="dlcl")
{
  //$uid = getuid_sid($sid);
  addonline(getuid_sid($sid),"Deleting Club","");
$pstyle = gettheme($sid);
      echo xhtmlhead("Delete Club",$pstyle);
  $clid = $_GET["clid"];
  $uid = getuid_sid($sid);
    echo "<p align=\"center\">";
    $pid = mysql_fetch_array(mysql_query("SELECT owner FROM dcroxx_me_clubs WHERE id='".$clid."'"));
    if($uid==$pid[0])
    {
        $res = deleteClub($clid);
        if($res)
        {

            echo "<img src=\"images/ok.gif\" alt=\"o\"/>Club Deleted";
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!";
        }
    }else{
        echo "<img src=\"images/notok.gif\" alt=\"x\"/>Yo can't delete this club!";
    }
    echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }
////////////////////////////////////////////////////////////////
else if($action=="quizpanel")
{
$pstyle = gettheme($sid);
      echo xhtmlhead("Quiz",$pstyle);
   $question = $_POST["question"];
   $answer = $_POST["answer"];

     echo "<p align=\"center\">";

   $res = mysql_query("INSERT INTO dcroxx_me_quiz SET question='".$question."', answer='".$answer."'");
      if($res)
      {
        echo "Question Added<br/>";
      }else{
        echo "Database Error<br/>";
      }
  echo "<a href=\"index.php?action=quizpanel&amp;type=send&amp;browse?start\">";
echo "Quiz Panel</a><br/>";
   echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }
////////////////////////////////////////////////////////////////
else if($action=="delquiz")
{$pstyle = gettheme($sid);
      echo xhtmlhead("Quiz",$pstyle);
    $id = $_GET["id"];
 
  echo "<p align=\"center\">";
  
    $res = mysql_query("DELETE FROM dcroxx_me_quiz WHERE id='".$id."'");

    if($res)
        {
            echo "Quiz Deleted<br/>";
        }else{
          echo "Database Error!<br/>";
        }
  
  echo "<br/><br/>";
echo "<a href=\"index.php?action=quizpanel&amp;type=send&amp;browse?start\">";
echo "Quiz Panel</a><br/>";
   echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }

//////////////////////////////////////////Select Profile Moods
else if($action=="uppmoods")
{
    addonline(getuid_sid($sid),"Updating Profile Moods","");
    $pmoodid = $_GET["pmoodid"];
      echo "<head>";
      echo "<title>$sitename</title>";
      echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
      echo "</head>";
$pstyle = gettheme($sid);
      echo xhtmlhead("Moods",$pstyle);
      echo "<body>";
  echo "<p align=\"center\">";
  //$uid = getuid_sid($sid);
  $pmoodlnk = mysql_fetch_array(mysql_query("SELECT pmoodlink FROM dcroxx_me_profilemood WHERE id='".$pmoodid."'"));
  $res = mysql_query("UPDATE dcroxx_me_users SET pmood='".$pmoodlnk[0]."' WHERE id='".$uid."'");
  if($res)
        {
            echo "<img src=\"../images/ok.gif\" alt=\"o\"/>Profile Mood Selected<br/>";
        }else{
          echo "<img src=\"../images/notok.gif\" alt=\"x\"/>Database Error!<br/>";
        }
        echo "<br/>";

   echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }

///////////////////////////////////////Unban user

else if($action=="kick")
{
  $who = $_GET["who"];
  $rid = $_GET["rid"];
if(!iscowner(getuid_sid($sid), $rid))
    {
  
      echo "<p align=\"center\">";
      echo "lolz! Wotz ur doing? chuchu<br/><br/>";
      echo "<a href=\"index.php?action=main&amp;type=send&amp;browse?start\">Main</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
 echo "<p align=\"center\">";
  if($uid==$who)
			{
     echo "Lolz You cant kick your own profile!<br/>";
 }else{
$res = mysql_query("INSERT INTO dcroxx_me_kick SET kick='1', rid='".$rid."', uid='".$who."', actime='".time()."'");
  if($res)
          {
            $unick = getnick_uid($who);
           
            echo "$unick has been kicked!";
          }else{
            echo "NAME ALREADY INSERTED";
          }
  }
echo "<br/><br/>";

  echo "<a href=\"index.php?action=chat&amp;browse?start\">";
echo "Chat index</a><br/>";

  echo "<a href=\"index.php?action=main&amp;browse?start\">";
echo "Home</a>";
  echo "</p></body>";
   exit();
    }

///////////////////////////////////////Unban user

else if($action=="unkick")
{
  $who = $_GET["who"];
 $rid = $_GET["rid"];
 if(!iscowner(getuid_sid($sid), $rid))
    {
      echo "<title></title>";
      echo "<p align=\"center\">";
      echo "lolz! Wotz ur doing? chuchu<br/><br/>";
      echo "<a href=\"index.php?action=main&amp;type=send&amp;browse?start\">Main</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
echo "<p align=\"center\">";
  $res = mysql_query("DELETE FROM dcroxx_me_kick WHERE uid='".$who."'");
  if($res)
          {
            $unick = getnick_uid($who);
          
            echo "$unick has been unkicked!";
          }else{
            echo "Database Error";
          }
  echo "<br/><br/>";

 echo "<a href=\"index.php?action=chat&amp;browse?start\">";
echo "Chat index</a><br/>";

   echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }

///////////////////////////////////////Unban user

else if($action=="lock")
{
  $rid = $_GET["rid"];
if(!iscowner(getuid_sid($sid), $rid))
    {
      echo "<title></title>";
      echo "<p align=\"center\">";
      echo "lolz! Wotz ur doing? chuchu<br/><br/>";
      echo "<a href=\"index.php?action=main&amp;type=send&amp;browse?start\">Main</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
 echo "<p align=\"center\">";
  $res = mysql_query("UPDATE dcroxx_me_rooms SET locked='1' WHERE id='".$rid."'");
  if($res)
          {
            $unick = getnick_uid($who);
           
            echo "Room has been locked!";
          }else{
            echo "NAME ALREADY INSERTED";
          }
  echo "<br/><br/>";

 echo "<a href=\"index.php?action=chat&amp;browse?start\">";
echo "Chat index</a><br/>";
   echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }

///////////////////////////////////////Unban user

else if($action=="unlock")
{
 
 $rid = $_GET["rid"];
 if(!iscowner(getuid_sid($sid), $rid))
    {
      echo "<title></title>";
      echo "<p align=\"center\">";
      echo "lolz! Wotz ur doing? chuchu<br/><br/>";
      echo "<a href=\"index.php?action=main&amp;type=send&amp;browse?start\">Main</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
  echo "<p align=\"center\">";
  $res = mysql_query("UPDATE dcroxx_me_rooms SET locked='0' WHERE id='".$rid."'");
  if($res)
          {
            
          
            echo "Room has been unlocked!";
          }else{
            echo "Database Error";
          }
  echo "<br/><br/>";

 echo "<a href=\"index.php?action=chat&amp;browse?start\">";
echo "Chat index</a><br/>";

     echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }
////////////////////////////////////////////////////////////////
else if($action=="pws")
{
  //$uid = getuid_sid($sid);
  addonline(getuid_sid($sid),"Updating PWS","");
$pstyle = gettheme($sid);
      echo xhtmlhead("P.W.S",$pstyle);
  $imgt = $_POST["imgt"];
  $imgo = $_POST["imgo"];
  $smsg = $_POST["smsg"];
  $thms = $_POST["thms"];

  $uid = getuid_sid($sid);
    echo "<p align=\"center\">";
    if($imgt=="idc")
	{
		$imgo = "http://$stitle.tk/rwidc.php?id=$uid";
	}else if($imgt == "avt")
	{
		$av = mysql_fetch_array(mysql_query("SELECT avatar FROM dcroxx_me_users WHERE id='".$uid."'"));
		if(strpos($av[0], "http://")===false)
		{
			$av[0] = "../".$av[0];
		}
		$imgo = $av[0];
	}else if($imgt=="sml")
	{
		$sml = mysql_fetch_array(mysql_query("SELECT imgsrc FROM dcroxx_me_smilies WHERE scode='".strtolower(trim($imgo))."'"));
		$imgo = "../".$sml[0];
	}else
	{
		$imgo = strtolower(trim($imgo));
	}
    $smsg = trim($smsg);
	$isu = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_mypage WHERE uid='".$uid."'"));
	if ($isu[0]>0)
	{
		$res = mysql_query("UPDATE dcroxx_me_mypage SET thid='".$thms."', mimg='".$imgo."', msg='".$smsg."' WHERE uid='".$uid."'");
	}else{
		$res = mysql_query("INSERT INTO dcroxx_me_mypage SET uid='".$uid."', thid='".$thms."', mimg='".$imgo."', msg='".$smsg."'");
	}
	echo mysql_error();
    if($res)
    {
    echo "<img src=\"images/ok.gif\" alt=\"o\"/>Your Site updated successfully<br/><br/>";
	echo "<a href=\"users?".getnick_uid($uid)."\">View Your Site</a>";
    }else{
        echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!";
    }
    echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }
////////////////////////////////////////////////////////////////
else if($action=="dltpl")
{
  //$uid = getuid_sid($sid);
  $tid = $_GET["tid"];
  addonline(getuid_sid($sid),"Deleting Poll","");
$pstyle = gettheme($sid);
      echo xhtmlhead("Delete Poll",$pstyle);
    echo "<p align=\"center\">";
    $pid = mysql_fetch_array(mysql_query("SELECT pollid FROM dcroxx_me_topics WHERE id='".$tid."'"));
        $res = mysql_query("UPDATE dcroxx_me_topics SET pollid='0' WHERE id='".$tid."'");
        if($res)
        {
          $res = mysql_query("DELETE FROM dcroxx_me_presults WHERE pid='".$pid[0]."'");
          $res = mysql_query("DELETE FROM dcroxx_me_polls WHERE id='".$pid[0]."'");
            echo "<img src=\"images/ok.gif\" alt=\"o\"/>Poll Deleted";
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!";
        }
    echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }
////////////////////////////////////////////////////////////////
/*
else if($action=="reqjc")
{
  //$uid = getuid_sid($sid);
  $clid = $_GET["clid"];
  addonline(getuid_sid($sid),"Joining A Club","");
$pstyle = gettheme($sid);
      echo xhtmlhead("Join Club",$pstyle);
    echo "<p align=\"center\">";
    $uid = getuid_sid($sid);
    $isin = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_clubmembers WHERE uid='".$uid."' AND clid='".$clid."'"));
    if($isin[0]==0){
        $res = mysql_query("INSERT INTO dcroxx_me_clubmembers SET uid='".$uid."', clid='".$clid."', accepted='0', points='0', joined='".((time() - $timeadjust) + (10*60*60))."'");
        if($res)
        {
            echo "<img src=\"images/ok.gif\" alt=\"o\"/>Request sent! the club owner should accept your request";
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!";
        }
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"x\"/>You already in this club or request sent and waiting for acception";
        }
    echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }
*/
//////////////////////////////////////////////////////////////
else if($action=="reqjc")
{
$uid = getuid_sid($sid);
$clid = $_GET["clid"];
addonline(getuid_sid($sid),"Joining A Club","");
echo "<head>";
echo "<title>$sitename</title>";
echo "</head>";
echo "<body>";
echo "<p align=\"center\">";
$uid = getuid_sid($sid);
$isin = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_clubmembers WHERE uid='".$uid."' AND clid='".$clid."'"));
if($isin[0]==0){
$res = mysql_query("INSERT INTO dcroxx_me_clubmembers SET uid='".$uid."', clid='".$clid."', accepted='0', points='0', joined='".time()."'");
if($res)
{
echo "<img src=\"images/ok.gif\" alt=\"o\"/>Request sent! The club owner should accept your request";
$clinfo = mysql_fetch_array(mysql_query("SELECT name, owner FROM dcroxx_me_clubs WHERE id='".$clid."'"));
$pmtext = "I wanna join your [club=$clid]$clinfo[0] [/club] club[br/][br/][small](this is an auto pm)[/small]";
$tm = time();
$res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$pmtext."', byuid='".$uid."', touid='".$clinfo[1]."', timesent='".$tm."'");
}else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!";
}
}else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>You are already in this club or request sent and waiting for acception";
}
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
echo "</p>";
echo "</body>";
 exit();
}
///////////////////////////////////////////////////////////
else if($action=="unjc")
{
  //$uid = getuid_sid($sid);
  $clid = $_GET["clid"];
  addonline(getuid_sid($sid),"Unjoining club","");
$pstyle = gettheme($sid);
      echo xhtmlhead("Join Club",$pstyle);
    echo "<p align=\"center\">";
    $uid = getuid_sid($sid);
    $isin = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_clubmembers WHERE uid='".$uid."' AND clid='".$clid."'"));
    if($isin[0]>0){
        $res = mysql_query("DELETE FROM dcroxx_me_clubmembers WHERE uid='".$uid."' AND clid='".$clid."'");
        if($res)
        {
            echo "<img src=\"images/ok.gif\" alt=\"o\"/>Unjoined club successfully";
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!";
        }
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"x\"/>You're not a member of this club!";
        }
    echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }
////////////////////////////////////////////////////////////////
/*
else if($action=="acm")
{
  //$uid = getuid_sid($sid);
  $clid = $_GET["clid"];
  $who = $_GET["who"];
  addonline(getuid_sid($sid),"Adding a member to club","");
$pstyle = gettheme($sid);
      echo xhtmlhead("Add Member",$pstyle);
    echo "<p align=\"center\">";
    $uid = getuid_sid($sid);
    $cowner = mysql_fetch_array(mysql_query("SELECT owner FROM dcroxx_me_clubs WHERE id='".$clid."'"));
    if($cowner[0]==$uid){
        $res = mysql_query("UPDATE dcroxx_me_clubmembers SET accepted='1' WHERE clid='".$clid."' AND uid='".$who."'");
        if($res)
        {
            echo "<img src=\"images/ok.gif\" alt=\"o\"/>Member added to your club";
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!";
        }
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"x\"/>This club ain't yours";
        }
    echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }
////////////////////////////////////////////////////////////////
*/
else if($action=="delvlt")
{
     $vid = $_GET["vid"];
  addonline(getuid_sid($sid),"Deleting Vault Item","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\">";
  $itemowner = mysql_fetch_array(mysql_query("SELECT uid FROM dcroxx_me_vault WHERE id='".$vid."'"));
  if(ismod(getuid_sid($sid))||getuid_sid($sid)==$itemowner[0])
  {
    $res = mysql_query("DELETE FROM dcroxx_me_vault WHERE id='".$vid."'");
   
    if($res)
        {
            echo "<img src=\"images/ok.gif\" alt=\"o\"/>Item Deleted From Vault<br/>";
        }else{
          echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!<br/>";
        }
  }else{
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>You can't delete this item";
  }
  echo "<br/><br/>";
      $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }
////////////////////////////////////////////////////////////////
/*
else if($action=="delvlt")
{
    $vid = $_GET["vid"];
  addonline(getuid_sid($sid),"Deleting Vault Item","");
  echo "<p align=\"center\">";
  $itemowner = mysql_fetch_array(mysql_query("SELECT uid FROM dcroxx_me_vault WHERE id='".$vid."'"));
  if(ismod(getuid_sid($sid))||getuid_sid($sid)==$itemowner[0])
  {
    $res = mysql_query("DELETE FROM dcroxx_me_vault WHERE id='".$vid."'");
    if($res)
        {
            echo "<img src=\"../images/ok.gif\" alt=\"o\"/>Item Deleted From Vault<br/>";
        }else{
          echo "<img src=\"../images/notok.gif\" alt=\"x\"/>Database Error!<br/>";
        }
  }else{
    echo "<img src=\"../images/notok.gif\" alt=\"X\"/>You can't delete this item";
  }
  echo "<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></body>";
   exit();
    }
////////////////////////////////////////////////////////////////
       */
else if($action=="acm")
{
$pstyle = gettheme($sid);
      echo xhtmlhead("Add Member",$pstyle);
$clid = $_GET["clid"];
$who = $_GET["who"];
addonline(getuid_sid($sid),"Adding a member to club","");
echo "<head>";
echo "<title>$sitename</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
echo "</head>";
echo "<body>";
echo "<p align=\"center\">";
$uid = getuid_sid($sid);
$cowner = mysql_fetch_array(mysql_query("SELECT owner, name FROM dcroxx_me_clubs WHERE id='".$clid."'"));
if($cowner[0]==$uid){
$res = mysql_query("UPDATE dcroxx_me_clubmembers SET accepted='1' WHERE clid='".$clid."' AND uid='".$who."'");
if($res)
{
echo "<img src=\"../images/ok.gif\" alt=\"o\"/>Member added to your club";

$pmtext = "You are now a member of the [club=$clid]$cowner[1] [/club] club[br/][br/][small](this is an auto pm)[/small]";
$tm = time();
$res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$pmtext."', byuid='".$uid."', touid='".$who."', timesent='".$tm."'");



}else{
echo "<img src=\"../images/notok.gif\" alt=\"x\"/>Database Error!";
}
}else{
echo "<img src=\"../images/notok.gif\" alt=\"x\"/>This club ain't yours";
}
echo "

0 <a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
echo "</p>";
echo "</body>";
   exit();
    }

////////////////////////////////////////////////////////////////
else if($action=="accall")
{
  //$uid = getuid_sid($sid);
  $clid = $_GET["clid"];

  addonline(getuid_sid($sid),"Adding a member to club","");
$pstyle = gettheme($sid);
      echo xhtmlhead("Add Member",$pstyle);
    echo "<p align=\"center\">";
    $uid = getuid_sid($sid);
    $cowner = mysql_fetch_array(mysql_query("SELECT owner FROM dcroxx_me_clubs WHERE id='".$clid."'"));
    if($cowner[0]==$uid){
        $res = mysql_query("UPDATE dcroxx_me_clubmembers SET accepted='1' WHERE clid='".$clid."'");
        if($res)
        {
            echo "<img src=\"images/ok.gif\" alt=\"o\"/>All Members Accepted";
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!";
        }
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"x\"/>This club ain't yours";
        }
    echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }
////////////////////////////////////////////////////////////////
/*
else if($action=="accall")
{

$clid = $_GET["clid"];

addonline(getuid_sid($sid),"Adding a member to club","");
echo "<head>";
echo "<title>$sitename</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
echo "</head>";
echo "<body>";
echo "<p align=\"center\">";
$uid = getuid_sid($sid);
$cowner = mysql_fetch_array(mysql_query("SELECT owner, name FROM dcroxx_me_clubs WHERE id='".$clid."'"));
if($cowner[0]==$uid){

$sql = "SELECT $uid FROM dcroxx_me_clubmembers WHERE clid='".$clid."' AND accepted='0'";
$items = mysql_query($sql);
while ($item = mysql_fetch_array($items))
{

$pmtext = "You are now a member of the [club=$clid]$cowner[1] [/club] club[br/][br/][small](this is an auto pm)[/small]";
$tm = time();
$res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$pmtext."', byuid='".$uid."', touid='".$item[0]."', timesent='".$tm."'");
}
if($res){
$res = mysql_query("UPDATE dcroxx_me_clubmembers SET accepted='1' WHERE clid='".$clid."'");
if($res)
{
echo "<img src=\"../images/ok.gif\" alt=\"o\"/>All Members Accepted";
}else{
echo "<img src=\"../images/notok.gif\" alt=\"x\"/>Database Error!";
}
}else{
echo "<img src=\"../images/notok.gif\" alt=\"x\"/>This club ain't yours";
}
}
echo "

0 <a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
echo "</p>";
echo "</body>";
   exit();
    }
*/
////////////////////////////////////////////////////////////////
else if($action=="denall")
{
  //$uid = getuid_sid($sid);
  $clid = $_GET["clid"];

  addonline(getuid_sid($sid),"Adding a member to club","");
$pstyle = gettheme($sid);
      echo xhtmlhead("Add Member",$pstyle);
    echo "<p align=\"center\">";
    $uid = getuid_sid($sid);
    $cowner = mysql_fetch_array(mysql_query("SELECT owner FROM dcroxx_me_clubs WHERE id='".$clid."'"));
    if($cowner[0]==$uid){
        $res = mysql_query("DELETE FROM dcroxx_me_clubmembers WHERE accepted='0' AND clid='".$clid."'");
        if($res)
        {
            echo "<img src=\"images/ok.gif\" alt=\"o\"/>All Members Denied";
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!";
        }
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"x\"/>This club ain't yours";
        }
    echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }
////////////////////////////////////////////////////////////////
else if($action=="dcm")
{
  //$uid = getuid_sid($sid);
  $clid = $_GET["clid"];
  $who = $_GET["who"];
  addonline(getuid_sid($sid),"Deleting a member from club","");
$pstyle = gettheme($sid);
      echo xhtmlhead("Delete Member",$pstyle);
    echo "<p align=\"center\">";
    $uid = getuid_sid($sid);
    $cowner = mysql_fetch_array(mysql_query("SELECT owner FROM dcroxx_me_clubs WHERE id='".$clid."'"));
    if($cowner[0]==$uid){
        $res = mysql_query("DELETE FROM dcroxx_me_clubmembers  WHERE clid='".$clid."' AND uid='".$who."'");
        if($res)
        {
            echo "<img src=\"images/ok.gif\" alt=\"o\"/>Member deleted from your club";
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!";
        }
        }else{
            echo "<img src=\"images/notok.gif\" alt=\"x\"/>This club ain't yours";
        }
    echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }
////////////////////////////////////////////////////////////////

else if($action=="crpoll")
{
  addonline(getuid_sid($sid),"Creating Poll","");
$pstyle = gettheme($sid);
      echo xhtmlhead("Create Poll",$pstyle);
    echo "<p align=\"center\">";
    //$uid = getuid_sid($sid);
    if(getplusses(getuid_sid($sid))>=50)
    {
    $pid = mysql_fetch_array(mysql_query("SELECT pollid FROM dcroxx_me_users WHERE id='".$uid."'"));
        if($pid[0] == 0)
        {
          $pques = $_POST["pques"];
          $opt1 = $_POST["opt1"];
          $opt2 = $_POST["opt2"];
          $opt3 = $_POST["opt3"];
          $opt4 = $_POST["opt4"];
          $opt5 = $_POST["opt5"];
          if((trim($pques)!="")&&(trim($opt1)!="")&&(trim($opt2)!=""))
          {
            $pex = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_polls WHERE pqst LIKE '".$pques."'"));
            if($pex[0]==0)
            {
              $res = mysql_query("INSERT INTO dcroxx_me_polls SET pqst='".$pques."', opt1='".$opt1."', opt2='".$opt2."', opt3='".$opt3."', opt4='".$opt4."', opt5='".$opt5."', pdt='".((time() - $timeadjust) + (10*60*60))."'");
              if($res)
              {
                $pollid = mysql_fetch_array(mysql_query("SELECT id FROM dcroxx_me_polls WHERE pqst='".$pques."' "));
                mysql_query("UPDATE dcroxx_me_users SET pollid='".$pollid[0]."' WHERE id='".$uid."'");
                echo "<img src=\"images/ok.gif\" alt=\"O\"/>Your poll created successfully";
              }else{
                echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Eroor!";
              }
                }else{
            echo "<img src=\"images/notok.gif\" alt=\"x\"/>There's already a poll with the same question";
          }

          }else{
             echo "<img src=\"images/notok.gif\" alt=\"x\"/>The poll must have a question, and at least 2 options";
          }
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"x\"/>You already have a poll";
          }
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"x\"/>You should have at least 50 plusses to create a poll";

          }
          echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }
////////////////////////////////////////////////////////////////
else if($action=="pltpc")
{
  $tid = $_GET["tid"];
  addonline(getuid_sid($sid),"Creating Poll","");
$pstyle = gettheme($sid);
      echo xhtmlhead("Create Poll",$pstyle);
    echo "<p align=\"center\">";
    //$uid = getuid_sid($sid);
    if((getplusses(getuid_sid($sid))>=500)||ismod($uid))
    {
    $pid = mysql_fetch_array(mysql_query("SELECT pollid FROM dcroxx_me_topics WHERE id='".$tid."'"));
        if($pid[0] == 0)
        {
          $pques = $_POST["pques"];
          $opt1 = $_POST["opt1"];
          $opt2 = $_POST["opt2"];
          $opt3 = $_POST["opt3"];
          $opt4 = $_POST["opt4"];
          $opt5 = $_POST["opt5"];
          if((trim($pques)!="")&&(trim($opt1)!="")&&(trim($opt2)!=""))
          {
            $pex = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_polls WHERE pqst LIKE '".$pques."'"));
            if($pex[0]==0)
            {
              $res = mysql_query("INSERT INTO dcroxx_me_polls SET pqst='".$pques."', opt1='".$opt1."', opt2='".$opt2."', opt3='".$opt3."', opt4='".$opt4."', opt5='".$opt5."', pdt='".((time() - $timeadjust) + (10*60*60))."'");
              if($res)
              {
                $pollid = mysql_fetch_array(mysql_query("SELECT id FROM dcroxx_me_polls WHERE pqst='".$pques."' "));
                mysql_query("UPDATE dcroxx_me_topics SET pollid='".$pollid[0]."' WHERE id='".$tid."'");
                echo "<img src=\"images/ok.gif\" alt=\"O\"/>Your poll created successfully";
              }else{
                echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Eroor!";
              }
                }else{
            echo "<img src=\"images/notok.gif\" alt=\"x\"/>There's already a poll with the same question";
          }

          }else{
             echo "<img src=\"images/notok.gif\" alt=\"x\"/>The poll must have a question, and at least 2 options";
          }
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"x\"/>This Topic Already Have A poll";
          }
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"x\"/>You should have at least 500 plusses to create a poll";

          }
          echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }

/////////////////////////////////////////////////////////////////

else if($action=="addblg")

{$pstyle = gettheme($sid);

      echo xhtmlhead("$stitle",$pstyle);
boxstart("Add Blog");
   if(!getplusses(getuid_sid($sid))>50)
       {
            echo "Only 50+ points can add blogs<br/><br/>";
         echo "<a href=\"index.php?action=main\">Main Menu</a>";
         echo "</center></div></div></font></body></html>";
         exit();
       }
     $btitle = $_POST["btitle"];
     $msgtxt = $_POST["msgtxt"];
     //$qut = $_POST["qut"];
     addonline(getuid_sid($sid),"Adding a blog","");
            $crdate = time() + 12.5*60*60;
         $uid = getuid_sid($sid);
        $res = false;
            if((trim($msgtxt)!="")&&(trim($btitle)!=""))
         {
         $res = mysql_query("INSERT INTO dcroxx_me_blogs SET bowner='".$uid."', bname='".$btitle."', bgdate='".$crdate."', btext='".$msgtxt."'");
         }
         if($res)
         {
           echo "<img src=\"images/ok.gif\" alt=\"O\"/>Message Posted Successfully";
         }else{
           echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error Posting Message";
         }
               echo "<br/><br/>";
          $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
      echo "</p>";
  echo xhtmlfoot();
   exit();
    }
////////////////////////////////////////////////////////////////
else if($action=="addvlt2")
{
 $pstyle = gettheme($sid);
      echo xhtmlhead("Vault",$pstyle);
if(!getplusses(getuid_sid($sid))>25)
    {
      echo "<title></title>";
      echo "<p align=\"center\">";
      echo "Only the user of 25+ plusses can add a vault item<br/><br/>";
      echo "<a href=\"index.php?action=main\">Home</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
  $viname = $_POST["viname"];
  $vilink = $_POST["vilink"];
$videsc = $_POST["videsc"];
  $did = $_POST["did"];
 //$qut = $_POST["qut"];
$vid = $_POST["vid"];
 $fname= array_reverse(explode("/",$vilink));
  addonline(getuid_sid($sid),"Adding A Vault Item","index.php?action=main");

error_reporting(0);
 if(strlen($viname)<5)
{
      echo "<title></title>";
      echo "<p align=\"center\">";
        echo "5 minimum letters for the title!";
  echo "<br/><a href=\"index.php?action=main\">";
  echo "Main menu</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
 if(strlen($vilink)<5)
{
      echo "<title></title>";
      echo "<p align=\"center\">";
        echo "5 minimum letters for the link!";
  echo "<br/><a href=\"index.php?action=main\">";
  echo "Main menu</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
 if(strlen($videsc)<5)
{
      echo "<title></title>";
      echo "<p align=\"center\">";
        echo "5 minimum letters for the description!";
  echo "<br/><a href=\"index.php?action=main\">";
  echo "Main menu</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
if(spacesin($vilink))
{
      echo "<card id=\"main\" title=\"Error adding\">";
      echo "<p align=\"center\">";
      echo "No space input!<br/>";
      echo "<a href=\"index.php?action=main\">Main menu</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
$fname= array_reverse(explode("/",$vilink));

if (!eregi("\.(mid|gif|bmp|mid|midi|3gp|mp3|mp4|wav|mpn|nth|mpc|jar|jad|jpeg|jpg|sis|mmf|amr|thm|png|wbmp|rar|zip)$",$fname[0]))
{
echo "<card id=\"main\" title=\"Error adding\">";
      echo "<p align=\"center\">";
echo "<b>Unsuported File extention!</b><br/>";
echo "<a href=\"index.php?action=main\">Main menu</a>";
                    echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
echo "<title></title>";
      echo "<p align=\"center\">";
      $crdate = time();
      //$uid = getuid_sid($sid);

   $res = false;

$defaultDest = "$dir";
$slash       = "/";

$dest        = "./pkfiles/";
 $fname= array_reverse(explode("/",$vilink));
$ds = array($dest, $slash, $fname[0]);
		$ds = implode("", $ds);
  if (!copy($vilink, $ds))
{
 echo "Dead link is not allowed!(<br/>";
}else{
  $fname= array_reverse(explode("/",$vilink));
$ext = getext($fname[0]);
        $mime = getextfile($ext);
$fname= array_reverse(explode("/",$vilink));
   $filesize = filesize($ds);
$filesize = $filesize / 1048576;
$fsize = 0;
$fsizetxt = "";
  if ($filesize < 1)
  {
     $fsize = round($filesize*1024,0);
     $fsizetxt = "".$fsize."KB";
    $check1 = "KB";
  }else{
     $fsize = round($filesize,2);
     $fsizetxt = "".$fsize." MB";
$check1 = "MB";
  }
  $res = mysql_query("INSERT INTO dcroxx_me_vault SET uid='".$uid."', title='".mysql_escape_string($viname)."', pudt='".$crdate."', did='".$did."', info='".$videsc."',filesize='".$fsizetxt."', mime='".$mime."', itemurl='".$fname[0]."'");
  
 if($res)
      {
mysql_query("UPDATE dcroxx_me_users SET plusses=plusses-'5' WHERE id='".$uid."'");
 echo "File added successfully!";
      }else{

      }
}
      echo "<br/><br/>";
      echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
      echo "</p>";
      echo "</body>";

   exit();
    }
////////////////////////////////////////////////////////////////
else if($action=="addvlt")
{

if(!getplusses(getuid_sid($sid))>24)
    {
       $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "Only 25+ plusses can add a vault item<br/><br/>";
      echo "<a href=\"index.php?action=main\">Home</a>";
      echo "</p>";
  echo xhtmlfoot();
      exit();
    }
  $viname = $_POST["viname"];
  $vilink = $_POST["vilink"];
  //$qut = $_POST["qut"];
  addonline(getuid_sid($sid),"Adding a vault item","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
      echo "<p align=\"center\">";
      $crdate = (time() - $timeadjust);
      //$uid = getuid_sid($sid);
      $res = false;

      $ext = getext($vilink);
      if ($ext=="mp3" or $ext=="amr" or $ext=="wav") {
      $type = 1;
      }
      if ($ext=="jpg" or $ext=="gif" or $ext=="png" or $ext=="bmp") {
      $type = 2;
      }
      if ($ext=="jad" or $ext=="jar") {
      $type = 3;
      }
      if ($ext=="mpg" or $ext=="3gp" or $ext=="mp4") {
      $type = 4;
      }
      if((trim($vilink)!="")&&(trim($viname)!=""))
      {
      $res = mysql_query("INSERT INTO dcroxx_me_vault SET uid='".$uid."', title='".mysql_escape_string($viname)."', pudt='".(time() - $timeadjust)."', itemurl='".$vilink."', type='".$type."'");
      }
      if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Item added Successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error adding an item";
      }

      echo "<br/><br/>";
          $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
      echo "</p>";
  echo xhtmlfoot();
   exit();
    }

//////////////////////////////////////////shout

else if($action=="shout")
{
  $shtxt = $_POST["shtxt"];
    addonline(getuid_sid($sid),"Shouting","");

$pstyle = gettheme($sid);
      echo xhtmlhead("Shout",$pstyle);
    echo "<p align=\"center\">";
	
	if(isshoutbaned($uid)){
    echo "Sorry you are shout banned by <b>Staff Team</b><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\" />Home</a>";
    echo "</p>";
    echo "</card>";
    echo "</wml>";
    exit();
}

	if(strlen($shtxt)<5)
{
    echo "Shout is blank or short. Your shouts must contain at least 5 characters.<br/>";
    echo"<br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\" />Home</a>";
    echo "</p>";
    echo "</card>";
    echo "</wml>";
    exit();
}

$nrom = substr_count($shtxt,"@");
if($nrom>6){
echo "";
echo "You can mention just only 3 people per shout<br/><br/>";
echo "<a href=\"index.php?action=main\">Home</a>";
echo "</p>";
echo "</card>";
echo "</wml>";
exit();
}

$q=mysql_fetch_assoc(mysql_query("SELECT shtime, shouter FROM dcroxx_me_shouts WHERE shouter='".$uid."'  ORDER BY id DESC LIMIT 1"));
$st=$q['shtime'];
$now=time();
$dif=$now - $st;
$wait= 10 - $dif;
if($dif<'25'){
echo "<img src=\"images/notok.gif\" alt=\"X\"/>A shout has been added recently.<br/>So you have to wait $wait seconds to add your shout!<br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</card>";
echo "</wml>";
exit();
}
  /*  if(getplusses(getuid_sid($sid))<75)
    {
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>You should have at least 75 plusses to shout!";
    }else{*/
$shtxt = $shtxt;
//$uid = getuid_sid($sid);
$shtm = time();
$res = mysql_query("INSERT INTO dcroxx_me_shouts SET shout='".$shtxt."', shouter='".$uid."', shtime='".$shtm."'");
if($res)
{
$shts = mysql_fetch_array(mysql_query("SELECT shouts, shouts_50, shouts_75, shouts_100 from dcroxx_me_users WHERE id='".$uid."'"));
$shts1 = $shts[0]+1;
$hts = $shts[1]+1;
$shs = $shts[2]+1;
$sts = $shts[3]+1;
mysql_query("UPDATE dcroxx_me_users SET shouts='".$shts1."', shouts_50='".$hts."', shouts_75='".$shs."', shouts_100='".$sts."' WHERE id='".$uid."'");


////////////@username@ mention by Tufan
preg_match_all('/@(\w+)|\s+([(\w+)\s|.|,|!|?]+)@/', $shtxt, $result);
for ($i = 0; $i < count($result[0]); $i++){
$mention[$i]= $result[1][$i];
$message[$i]= $result[2][$i];
}
for ($j = 0; $j< $i; $j++){
//echo $mention[$j],'<br/>';
$oy = mysql_fetch_array(mysql_query("SELECT id FROM dcroxx_me_users WHERE name='".$mention[$j]."'"));
//echo getuid_sid($mention[$j]);
//echo "$oy[0]<br/>";
$liker = getnick_sid($sid);
//mysql_query("INSERT INTO ibwfrr_notificare SET text='".getnick_uid(getuid_sid($sid))." has mention you on his/her shout', byuid='2', touid='".$oy[0]."', timesent='".time()."'");
$shd = mysql_fetch_array(mysql_query("SELECT id FROM dcroxx_me_shouts WHERE shouter='".$uid."' ORDER BY shtime DESC LIMIT 0, 1"));
$sex = mysql_fetch_array(mysql_query("SELECT sex FROM dcroxx_me_users WHERE id='".getuid_sid($sid)."'"));
if($sex[0]=="M"){mysql_query("INSERT INTO ibwf_notifications SET text='[image_preview=FNcFEVynZ6Y.png][user=$uid]$liker"."[/user] tag you on his [aFardin=like.php?action=main&shid=$shd[0]]shout[/aFardin]', touid='".$oy[0]."', timesent='".time()."'");}
if($sex[0]=="F"){mysql_query("INSERT INTO ibwf_notifications SET text='[image_preview=FNcFEVynZ6Y.png][user=$uid]$liker"."[/user] tag you on her [aFardin=like.php?action=main&shid=$shd[0]]shout[/aFardin]', touid='".$oy[0]."', timesent='".time()."'");}
if($sex[0]=="") {mysql_query("INSERT INTO ibwf_notifications SET text='[image_preview=FNcFEVynZ6Y.png][user=$uid]$liker"."[/user] tag you on his/her [aFardin=like.php?action=main&shid=$shd[0]]shout[/aFardin]', touid='".$oy[0]."', timesent='".time()."'");}
}


/*

         //a variable ($string) that I thought might look like what you are describing
         $string='@steve how are you? @tom nice to hear from you. So happy that you joined @joe, cool! @mike sweeet!';
         //regex to pull out the mentions and the messages 
         preg_match_all('/@(\w+)|\s+([(\w+)\s|.|,|!|?]+)/', $string, $result, PREG_PATTERN_ORDER);
         for ($i = 0; $i < count($result[0]); $i++) {
            $mention[$i]= $result[1][$i];
            $message[$i]= $result[2][$i];
         }
         //test to make sure that all mentions are stored
         for ($j = 0; $j< $i; $j++){
            echo $mention[$j],'<br/>';
         }
         //test to make sure that all messages are stored
         for ($k = 0; $k< $j; $k++){
            echo $message[$k],'<br/>';
         }
    
*/


//$cow = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
//$cow = $cow[0]+3;
//mysql_query("UPDATE dcroxx_me_users SET plusses='".$cow."' WHERE id='".$uid."'");
//  echo "3 plusses added to you account";
echo "<b>TIPS:</b> Makes more shout and get more plusses. :)<br/>";
$shid = mysql_fetch_array(mysql_query("SELECT id FROM dcroxx_me_shouts WHERE shouter='".$uid."' ORDER BY shtime DESC LIMIT 0, 1"));
    echo "<img src=\"images/ok.gif\" alt=\"O\"/>Shout has added successfully to public front page<br/>
	<a href=\"tag_mention.php?shid=$shid[0]\">Wanna Mention?</a>";
    }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
    }
           // }
         echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
    echo "</p>";
  echo xhtmlfoot();
   exit();
    }

	//////////////////////////like
else if($action=="like")
{
$who = $_GET["who"];
$shid = $_GET['shid'];
addonline(getuid_sid($sid),"Liking Shout","");

echo "<card id=\"main\" title=\"$sitename\">";
echo "<p align=\"center\"><small>";
$vb = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_like WHERE uid='".$uid."' AND shoutid='".$shid."'"));
$vb1 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_dislike WHERE uid='".$uid."' AND shoutid='".$shid."'"));
if($vb[0]==0 && $vb1[0]==0)
{
$res = mysql_query("INSERT INTO ibwfrr_like SET uid='".$uid."', shoutid='".$shid."', ltime='".time()."'");
if($res)
{
echo "<img src=\"images/ok.gif\" alt=\"o\"/>Liked Successfully<br/>";
///////////////// <----------------Notification By Fardin-------------->
$nick = getnick_sid($sid);
$shtx = mysql_fetch_array(mysql_query("SELECT shout, shouter FROM dcroxx_me_shouts WHERE id='".$shid."'"));
$txt = htmlspecialchars(substr(parsepm($shtx[0]), 0, 20));
$note = "[user=$uid]$nick"."[/user] liked your shout - [aFardin=like.php?action=main&shid=$shid]$txt..."."[/aFardin]";
notify($note,$uid,$shtx[1]);
//autopm($note, $shtx[1]);
/*$note2 = "[user=$uid]$nick"."[/user] liked the shout of [user=".$shtx[1]."]".getnick_uid($shtx[1])."[/user] - [aFardin=like.php?action=main&shid=$shid]$txt..."."[/aFardin]";
followersnotity($note2, $uid);*/
///////////////// <----------------Notification By Fardin-------------->
}else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!<br/>";
}
}else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>You have liked/disliked this Shout before<br/>";
}
echo "<br/><br/>";
echo "<a href=\"index.php?action=main&amp;sid=$sid\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
echo "</small></p></card>";

}
//////////////////////////like
else if($action=="dislike")
{
$who = $_GET["who"];
$shid = $_GET['shid'];
addonline(getuid_sid($sid),"Disliking Shout","");

echo "<card id=\"main\" title=\"$sitename\">";
echo "<p align=\"center\"><small>";
$vb = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_dislike WHERE uid='".$uid."' AND shoutid='".$shid."'"));
$vb1 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_like WHERE uid='".$uid."' AND shoutid='".$shid."'"));
if($vb[0]==0 && $vb1[0]==0)
{
$res = mysql_query("INSERT INTO ibwfrr_dislike SET uid='".$uid."', shoutid='".$shid."', ltime='".time()."'");
if($res)
{
echo "<img src=\"images/ok.gif\" alt=\"o\"/>Disliked Successfully<br/>";
///////////////// <----------------Notification By Fardin-------------->
$nick = getnick_sid($sid);
$shtx = mysql_fetch_array(mysql_query("SELECT shout, shouter FROM dcroxx_me_shouts WHERE id='".$shid."'"));
$txt = htmlspecialchars(substr(parsepm($shtx[0]), 0, 20));
$note = "[user=$uid]$nick"."[/user] disliked your shout - [aFardin=like.php?action=main&shid=$shid]$txt..."."[/aFardin]";
notify($note,$uid,$shtx[1]);
//autopm($note, $shtx[1]);
/*$note2 = "[user=$uid]$nick"."[/user] disliked the shout of [user=".$shtx[1]."]".getnick_uid($shtx[1])."[/user] - [aFardin=like.php?action=main&shid=$shid]$txt..."."[/aFardin]";
followersnotity($note2, $uid);*/
///////////////// <----------------Notification By Fardin-------------->
}else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!<br/>";
}
}else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>You have liked/disliked this Shout before<br/>";
}
echo "<br/><br/>";
echo "<a href=\"index.php?action=main&amp;sid=$sid\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
echo "</small></p></card>";

}

//////////////////////////////////////////Announce

else if($action=="annc")
{
  $antx = $_POST["antx"];
  $clid = $_GET["clid"];
    addonline(getuid_sid($sid),"Announcing","");
$cow = mysql_fetch_array(mysql_query("SELECT owner FROM dcroxx_me_clubs WHERE id='".$clid."'"));
    $uid = getuid_sid($sid);
$pstyle = gettheme($sid);
      echo xhtmlhead("Announce",$pstyle);
    echo "<p align=\"center\">";
    if($cow[0]!=$uid)
    {
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>This is not your club!";
    }else{
      $shtxt = $shtxt;
    //$uid = getuid_sid($sid);
    $shtm = (time() - $timeadjust) + $timeadjust;
    $res = mysql_query("INSERT INTO dcroxx_me_announcements SET antext='".$antx."', clid='".$clid."', antime='".$shtm."'");
    if($res)
    {
    echo "<img src=\"images/ok.gif\" alt=\"O\"/>Announcement Added!";
    }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
    }
            }
         echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
    echo "</p>";
  echo xhtmlfoot();
   exit();
    }

	else if($action=="hideannc")
{
    addonline(getuid_sid($sid),"Hide Announcement","");
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"center\"><small>";
    $res = mysql_query("UPDATE dcroxx_me_users SET annc='1' WHERE id='".$uid."'");
    if($res){
        echo "<img src=\"images/ok.gif\" alt=\"o\"/>Announcements are now hidden from your index.<br/>";
    }else{
        echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!<br/>";
    }
    echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
echo "</small></p></card>";
}
else if($action=="showannc")
{
    addonline(getuid_sid($sid),"Show Announcement","");
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"center\"><small>";
    $res = mysql_query("UPDATE dcroxx_me_users SET annc='0' WHERE id='".$uid."'");
    if($res){
        echo "<img src=\"images/ok.gif\" alt=\"o\"/>Announcements are now visible.<br/>";
    }else{
        echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!<br/>";
    }
    echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
echo "</small></p></card>";
}
	else if($action=="hidese")
{
    addonline(getuid_sid($sid),"Hide Announcement","");
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"center\"><small>";
    $res = mysql_query("UPDATE dcroxx_me_users SET seev='1' WHERE id='".$uid."'");
    if($res){
        echo "<img src=\"images/ok.gif\" alt=\"o\"/>Simple Emotions are now hidden from your index.<br/>";
    }else{
        echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!<br/>";
    }
    echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
echo "</small></p></card>";
}
else if($action=="showse")
{
    addonline(getuid_sid($sid),"Show Announcement","");
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"center\"><small>";
    $res = mysql_query("UPDATE dcroxx_me_users SET seev='0' WHERE id='".$uid."'");
    if($res){
        echo "<img src=\"images/ok.gif\" alt=\"o\"/>Simple Emotions are now visible.<br/>";
    }else{
        echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!<br/>";
    }
    echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
echo "</small></p></card>";
}
	else if($action=="hidespd")
{
    addonline(getuid_sid($sid),"Hide Announcement","");
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"center\"><small>";
    $res = mysql_query("UPDATE dcroxx_me_users SET scimg='1' WHERE id='".$uid."'");
    if($res){
        echo "<img src=\"images/ok.gif\" alt=\"o\"/>Speed Dial Images are now hidden from your index.<br/>";
    }else{
        echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!<br/>";
    }
    echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
echo "</small></p></card>";
}
else if($action=="showspd")
{
    addonline(getuid_sid($sid),"Show Announcement","");
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"center\"><small>";
    $res = mysql_query("UPDATE dcroxx_me_users SET scimg='0' WHERE id='".$uid."'");
    if($res){
        echo "<img src=\"images/ok.gif\" alt=\"o\"/>Speed Dial Images are now visible.<br/>";
    }else{
        echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!<br/>";
    }
    echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
echo "</small></p></card>";
}
else if($action=="rateb")
{
  $brate = $_POST["brate"];
  $bid = $_GET["bid"];
  addonline(getuid_sid($sid),"Rating a blog","");
  //$uid = getuid_sid($sid);

$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\">";
  $vb = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_brate WHERE uid='".$uid."' AND blogid='".$bid."'"));
  if($vb[0]==0)
  {
    $res = mysql_query("INSERT INTO dcroxx_me_brate SET uid='".$uid."', blogid='".$bid."', brate='".$brate."'");
    if($res)
    {
        echo "<img src=\"images/ok.gif\" alt=\"o\"/>Blog rated successfully<br/>";
    }else{
        echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!<br/>";
    }
  }else{
    echo "<img src=\"images/notok.gif\" alt=\"x\"/>You have rated this blog before<br/>";
  }
  echo "<br/><br/>";
      $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }


else if($action=="delfgb")
{
    $mid = $_GET["mid"];
  addonline(getuid_sid($sid),"Deleting GB Message","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\">";
  if(candelgb(getuid_sid($sid), $mid))
  {
    $res = mysql_query("DELETE FROM dcroxx_me_gbook WHERE id='".$mid."'");
    if($res)
        {
            echo "<img src=\"images/ok.gif\" alt=\"o\"/>Message Deleted From Guestbook<br/>";
        }else{
          echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!<br/>";
        }
  }else{
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>You can't delete this message";
  }
  echo "<br/><br/>";
      $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }

else if($action=="delbl")
{
    $bid = $_GET["bid"];
  addonline(getuid_sid($sid),"Deleting A Blog","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\">";
  if(candelbl(getuid_sid($sid), $bid))
  {
    $res = mysql_query("DELETE FROM dcroxx_me_blogs WHERE id='".$bid."'");
    if($res)
        {
            echo "<img src=\"images/ok.gif\" alt=\"o\"/>Blog Deleted<br/>";
        }else{
          echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!<br/>";
        }
  }else{
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>You can't delete this blog";
  }
  echo "<br/><br/>";
      $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }

else if($action=="rpost")
{
  $pid = $_GET["pid"];
  addonline(getuid_sid($sid),"Reporting Post","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\">";
  $pinfo = mysql_fetch_array(mysql_query("SELECT reported FROM dcroxx_me_posts WHERE id='".$pid."'"));
          if($pinfo[0]=="0")
          {
          $str = mysql_query("UPDATE dcroxx_me_posts SET reported='1' WHERE id='".$pid."' ");
          if($str)
          {
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>Post reported to mods successfully";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Can't report post at the moment";
          }
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>This Post is already reported";
          }
          echo "<br/><br/>";
      $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();

   exit();
    }



else if($action=="rtpc")
{
  $tid = $_GET["tid"];
  addonline(getuid_sid($sid),"Reporting Topic","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\">";
  $pinfo = mysql_fetch_array(mysql_query("SELECT reported FROM dcroxx_me_topics WHERE id='".$tid."'"));
          if($pinfo[0]=="0")
          {
          $str = mysql_query("UPDATE dcroxx_me_topics SET reported='1' WHERE id='".$tid."' ");
          if($str)
          {
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>Topic reported to mods successfully";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Can't report topic at the moment";
          }
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>This Topic is already reported";
          }
          echo "<br/><br/>";
      $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
   exit();
    }
///////////////////////////////////////////////////
else if($action=="delgal")
{
$gid = $_GET["gid"];
echo "<title>Gallery</title>";
echo "<p align=\"center\">";
echo "<br/>";
$res = mysql_query("DELETE FROM dcroxx_me_gallery3 WHERE id='".$gid."'");
if($res){
echo "Deleted successfully";
}else{
echo ">Error! Please Try again!";
}
echo "<br/><a href=\"index.php?action=main\">";
echo "Main menu</a>";
echo "</p>";
}
////////////////////////////////////////////////////////////////
else if($action=="addgal")
{
     $itemurl = $_POST["itemurl"];
  $description = $_POST["description"];
   $uid = getuid_sid($sid);
  $nopl = mysql_fetch_array(mysql_query("SELECT sex FROM dcroxx_me_users WHERE id='".$uid."'"));
  if($nopl[0]=='M')
  {
    $usex = "M";
  }else if($nopl[0]=='F'){
    $usex = "F";
  }else{
    $usex = "M";
  }

        echo "<head>";
  echo "<title>AddGal</title>";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
  echo "<body>";
       echo "<p align=\"center\">";
       // disabled itemurl
     $res = mysql_query("INSERT INTO dcroxx_me_usergallery SET uid='".$uid."', itemurl='".$itemurl."', sex='".$usex."', description='".$description."'");
       $res = mysql_query("INSERT INTO dcroxx_me_usergallery SET uid='".$uid."', file='".$file."', sex='".$usex."'");
      if($res)
      {
        echo "<img src=\"../images/ok.gif\" alt=\"O\"/>User Photo Added<br/>";
      }else{
        echo "<img src=\"../images/ok.gif\" alt=\"X\"/>User Photo Added<br/>";
      }

      echo "<a href=\"index.php?action=pkgal\">User Gallery</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  echo "</body>";
 exit();
    }
/////////////////////////////////////////////
else if($action=="addcom2")
{
    $text = $_POST["text"];
   $prate = $_POST["prate"];

  $gid = $_GET["gid"];
  addonline(getuid_sid($sid),"Adding Photo Comment","index.php?action=main");
   echo "<card id=\"main\" title=\"Add Photo\">";
      echo "<p align=\"center\">";
      $crdate = time();
      $uid = getuid_sid($sid);
      $res = false;

      if(trim($text)!="")
      {
        
      $res = mysql_query("INSERT INTO dcroxx_me_galcom SET text='".$text."', byuser='".$uid."', time='".$crdate."', pid='".$gid."'");
      }
      if($res)
      {
        echo "Comment Added Successfully<br/>";
      }else{
        echo "Error Adding Comment<br/>";
      }
if($prate!="") {
$res2 = mysql_query("INSERT INTO dcroxx_me_prate SET uid='".$uid."', pid='".$gid."', prate='".$prate."'");
    if($res2)
    {
        echo "Photo rated successfully<br/>";
    }else{
        echo "Database Error!<br/>";
    }
  }      

      
echo "<a href=\"index.php?action=pkgal\">Users Gallery</a><br/>";
      echo "<a href=\"index.php?action=main\">";
echo "Main</a>";
      echo "</p>";
      echo "</body>";

}
////////////////////////////////////////////////////////////////
else if($action=="bud")
{
  $todo = $_GET["todo"];
  $who = $_GET["who"];
  addonline(getuid_sid($sid),"Adding/Removing Buddy","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\">";
  //$uid = getuid_sid($sid);
    $unick = getnick_uid($uid);
    $tnick = getnick_uid($who);
  if($todo=="add")
  {
    if(budres($uid,$who)!=3){
    if(arebuds($uid,$who))
    {
      echo "<img src=\"images/notok.gif\" alt=\"x\"/>$tnick is already your buddy<br/>";
    }else if(budres($uid, $who)==0)
    {
        $res = mysql_query("INSERT INTO dcroxx_me_buddies SET uid='".$uid."', tid='".$who."', reqdt='".((time() - $timeadjust) + (1*60*60))."'");
        if($res)
        {
            echo "<img src=\"images/ok.gif\" alt=\"o\"/>A request has been sent to $tnick<br/>";
        }else{
          echo "<img src=\"images/notok.gif\" alt=\"x\"/>You can't add $tnick to your buddy list<br/>";
        }
    }
else if(budres($uid, $who)==1)
{
$res = mysql_query("UPDATE dcroxx_me_buddies SET agreed='1' WHERE uid='".$who."' AND tid='".$uid."'");
if($res)
{
echo "<img src=\"images/ok.gif\" alt=\"o\"/>$tnick Have accepted your request!";
$pmtext = "Your Buddy Request Have been Accepted** [br/][br/]";
$tm = time();
$res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$pmtext."', byuid='".$uid."', touid='".$who."', timesent='".$tm."'");
}else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>Added to your buddy list successfully!";
}
}
else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>You can't add $tnick to your buddy list!";
}
}else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>You can't add $tnick to your buddy list!";
}
}else if($todo="del")
{
$res= mysql_query("DELETE FROM dcroxx_me_buddies WHERE (uid='".$uid."' AND tid='".$who."') OR (uid='".$who."' AND tid='".$uid."')");
if($res)
{
echo "<img src=\"images/ok.gif\" alt=\"o\"/>$tnick Is no longer your friend";
$pmtext = "Dont wona be friends!** [br/][br/]";
$tm = time();
$res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$pmtext."', byuid='".$uid."', touid='".$who."', timesent='".$tm."'");
}else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>can't remove $tnick from your buddy list!";
}

}
      $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
 exit();
    }
/////////////////////////////////////////////////////////////////Update buddy message
else if($action=="upbmsg")
{
    addonline(getuid_sid($sid),"Updating Buddy message","");
    $bmsg = $_POST["bmsg"];
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\">";
  //$uid = getuid_sid($sid);
  $res = mysql_query("UPDATE dcroxx_me_users SET budmsg='".$bmsg."' WHERE id='".$uid."'");
  if($res)
        {
            echo "<img src=\"images/ok.gif\" alt=\"o\"/>Buddy message updated successfully<br/>";
        }else{
          echo "<img src=\"images/notok.gif\" alt=\"x\"/>can't update your buddy message<br/>";
        }
        echo "<br/>";
  echo "<a href=\"lists.php?action=buds\">";
echo "Buddies List</a><br/>";
         $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
 exit();
    }
///////////////////////////////////////////////////////////////////Select Avatar
else if($action=="upav")
{
    addonline(getuid_sid($sid),"Updating Avatar","");
    $avid = $_GET["avid"];
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\">";
  //$uid = getuid_sid($sid);
  $avlnk = mysql_fetch_array(mysql_query("SELECT avlink FROM dcroxx_me_avatars WHERE id='".$avid."'"));
  $res = mysql_query("UPDATE dcroxx_me_users SET avatar='".$avlnk[0]."' WHERE id='".$uid."'");
  if($res)
        {
            echo "<img src=\"images/ok.gif\" alt=\"o\"/>Avatar Selected<br/>";
        }else{
          echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!<br/>";
        }
        echo "<br/>";

         $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
 exit();
    }
///////////////////////////////////////////////////////////////////////Select Avatar
else if($action=="upavg")
{
    addonline(getuid_sid($sid),"Updating Avatar","");
    $avsrc = $_GET["avsrc"];
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\">";
  //$uid = getuid_sid($sid);
  $res = mysql_query("UPDATE dcroxx_me_users SET avatar='".$avsrc."' WHERE id='".$uid."'");
  if($res)
        {
            echo "<img src=\"images/ok.gif\" alt=\"o\"/>Avatar Selected<br/>";
        }else{
          echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!<br/>";
        }
        echo "<br/>";

         $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
 exit();
    }
////////////////////////////////////////////////////////////////////Select Avatar
else if($action=="upcm")
{
    addonline(getuid_sid($sid),"Updating Chatmood","");
    $cmid = $_GET["cmid"];
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\">";
  //$uid = getuid_sid($sid);
  $res = mysql_query("UPDATE dcroxx_me_users SET chmood='".$cmid."' WHERE id='".$uid."'");
  if($res)
        {
            echo "<img src=\"images/ok.gif\" alt=\"o\"/>Mood Selected<br/>";
        }else{
          echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!<br/>";
        }
        echo "<br/>";
echo "<a href=\"index.php?action=chat\">";
echo "Chatrooms</a><br/>";
         $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
 exit();
    }
//////////////////////////////////////////////////////////////////////Give credits
else if($action=="plusses")
{
    addonline(getuid_sid($sid),"Sharing Credits","");
    $who = $_GET["who"];
  	     $ptg1 = $_POST["ptg"];


$ptg = preg_replace("/[^0-9]/", "", $ptg1);
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\">";
  //$uid = getuid_sid($sid);
  $gpsf = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
  $gpst = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
  if($gpsf[0]>=$ptg){
    $gpsf = $gpsf[0]-$ptg;
    $gpst = $gpst[0]+$ptg;
    $res = mysql_query("UPDATE dcroxx_me_users SET plusses='".$gpst."' WHERE id='".$who."'");
  if($res)
        {
          $ad = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
          $res = mysql_query("UPDATE dcroxx_me_users SET plusses='".$gpsf."' WHERE id='".$uid."'");
            echo "<img src=\"images/ok.gif\" alt=\"o\"/>Credits Updated Successfully<br/>";

				$wintext = "".getnick_uid($uid)." Shared  $ptg Credits With u..Now U hv $gpst  credits![br/][i] p.s. note: This is an automatic pm from $stitle service centre[/i]";
				$res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$wintext."', byuid='".$uid."', touid='".$who."', timesent='".time()."'");
        }else{
          echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!<br/>";
        }
      }else{
          echo "<img src=\"images/notok.gif\" alt=\"x\"/>You don't have enough Credits to give<br/>";
        }

        echo "<br/>";

         $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
 exit();
    }
////////////////////////////////////////////////////////////////////Give GPs
else if($action=="givegp")
{
    addonline(getuid_sid($sid),"Giving Game Plusses","");
    $who = $_GET["who"];
  	     $ptg1 = $_POST["ptg"];


$ptg = preg_replace("/[^0-9]/", "", $ptg1);
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\">";
  //$uid = getuid_sid($sid);
  $gpsf = mysql_fetch_array(mysql_query("SELECT gplus FROM dcroxx_me_users WHERE id='".$uid."'"));
  $gpst = mysql_fetch_array(mysql_query("SELECT gplus FROM dcroxx_me_users WHERE id='".$who."'"));
  if($gpsf[0]>=$ptg){
    $gpsf = $gpsf[0]-$ptg;
    $gpst = $gpst[0]+$ptg;
    $res = mysql_query("UPDATE dcroxx_me_users SET gplus='".$gpst."' WHERE id='".$who."'");
  if($res)
        {
          $res = mysql_query("UPDATE dcroxx_me_users SET gplus='".$gpsf."' WHERE id='".$uid."'");
            echo "<img src=\"images/ok.gif\" alt=\"o\"/>Game Plusses Updated Successfully<br/>";
        }else{
          echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!<br/>";
        }
      }else{
          echo "<img src=\"images/notok.gif\" alt=\"x\"/>You don't have enough GPs to give<br/>";
        }

        echo "<br/>";

         $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
 exit();
    }
//////////////////////////////////////////////////////////////// add club

else if($action=="addcl")
{
    addonline(getuid_sid($sid),"Adding Club","");
    $clnm = trim($_POST["clnm"]);
    $clnm = str_replace("$", "", $clnm);
    $clds = trim($_POST["clds"]);
    $clds = str_replace("$", "", $clds);
    $clrl = trim($_POST["clrl"]);
    $clrl = str_replace("$", "", $clrl);
    $cllg = trim($_POST["cllg"]);
    $cllg = str_replace("$", "", $cllg);
$pstyle = gettheme($sid);
      echo xhtmlhead("Adding Club",$pstyle);
    echo "<p align=\"center\">";
    $uid = getuid_sid($sid);
    if(getplusses($uid)>=500)
    {
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_clubs WHERE owner='".$uid."'"));
      if($noi[0]<2)
      {
        if(($clnm=="")||($clds=="")||($clrl==""))
        {
          echo "<img src=\"images/notok.gif\" alt=\"X\"/>Please be sure to fill, club name, description and rules";
        }else{
          $nmex = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_clubs WHERE name LIKE '".$clnm."'"));
          if($nmex[0]>0)
          {
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Club Name Already exist";
          }else{
            $res = mysql_query("INSERT INTO dcroxx_me_clubs SET name='".$clnm."', owner='".$uid."', description='".$clds."', rules='".$clrl."', logo='".$cllg."', plusses='0', created='".((time() - $timeadjust) + (10*60*60))."'");
            if($res)
            {
              $clid = mysql_fetch_array(mysql_query("SELECT id FROM dcroxx_me_clubs WHERE owner='".$uid."' AND name='".$clnm."'"));
                echo "<img src=\"images/ok.gif\" alt=\"O\"/>Congratulations! you have your own club, your own rules, message board, chatroom, announcements board, 50 club points also for you";
                mysql_query("INSERT INTO dcroxx_me_clubmembers SET uid='".$uid."', clid='".$clid[0]."', accepted='1', points='50', joined='".((time() - $timeadjust) + (10*60*60))."'");
                //$ups = getplusses($uid);
                //$ups += 5;
                //mysql_query("UPDATE dcroxx_me_users SET plusses='".$ups."' WHERE id='".$uid."'");
                $fnm = $clnm;
                $cnm = $clnm;
                mysql_query("INSERT INTO dcroxx_me_forums SET name='".$fnm."', position='0', cid='0', clubid='".$clid[0]."'");
                mysql_query("INSERT INTO dcroxx_me_rooms SET name='".$cnm."', pass='', static='1', mage='0', chposts='0', perms='0', censord='0', freaky='0', lastmsg='".((time() - $timeadjust) + (10*60*60))."', clubid='".$clid[0]."'");
            }else{
                echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error!";
            }
          }
        }
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>You already have 5 clubs";
      }
      }else{

      echo "<img src=\"images/notok.gif\" alt=\"X\"/>You cant add clubs";
      }


    echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
 exit();
    }
//////////////////////////////////////////////////////////////////////////Give GPs
else if($action=="batp")
{
    addonline(getuid_sid($sid),"Giving Game Plusses","");
    $who = $_GET["who"];
    $ptg = $_POST["ptbp"];
    $giv = $_POST["giv"];
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\">";
  //$uid = getuid_sid($sid);
  $judg = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_judges WHERE uid='".getuid_sid($sid)."'"));
  $gpst = mysql_fetch_array(mysql_query("SELECT battlep FROM dcroxx_me_users WHERE id='".$who."'"));
  if(ismod(getuid_sid($sid))||$judg[0]>0)
  {
    if ($giv=="1")
    {
        $gpst = $gpst[0]+$ptg;
    }else{
        $gpst = $gpst[0]-$ptg;
        if($gpst<0)$gpst=0;
    }
    $res = mysql_query("UPDATE dcroxx_me_users SET battlep='".$gpst."' WHERE id='".$who."'");
  if($res)
        {
          $vnick = getnick_uid($who);
          if ($giv=="1")
          {
            $ms1 = " Added $ptg points to ";
          }else{
            $ms1 = " removed $ptg points from ";
          }

          mysql_query("INSERT INTO dcroxx_me_mlog SET action='bpoints', details='<b>".getnick_uid(getuid_sid($sid))."</b> $ms1  $vnick', actdt='".((time() - $timeadjust) + (10*60*60))."'");
            echo "<img src=\"images/ok.gif\" alt=\"o\"/>Battle Points Updated Successfully<br/>";
        }else{
          echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!<br/>";
        }
      }else{
          echo "<img src=\"images/notok.gif\" alt=\"x\"/>You can't do this<br/>";
        }

        echo "<br/>";

         $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
 exit();
    }
//////////////////////////////////////////////////////////////////Add remove from ignoire list

else if($action=="ign")
{
    addonline(getuid_sid($sid),"Updating ignore list","");
    $todo = $_GET["todo"];
    $who = $_GET["who"];
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\">";
  //$uid = getuid_sid($sid);
  $tnick = getnick_uid($who);
  if($todo=="add")
  {
    if(ignoreres($uid, $who)==1)
    {
      $res= mysql_query("INSERT INTO dcroxx_me_ignore SET name='".$uid."', target='".$who."'");
    if($res)
        {
            echo "<img src=\"images/ok.gif\" alt=\"o\"/>$tnick was added successfully to your ignore list<br/>";
        }else{
          echo "<img src=\"images/notok.gif\" alt=\"x\"/>Error Updating Database<br/>";
        }
    }else{
        echo "<img src=\"images/notok.gif\" alt=\"x\"/>You can't Add $tnick to your ignore list<br/>";
    }
  }else if($todo="del")
  {
    if(ignoreres($uid, $who)==2)
    {
      $res= mysql_query("DELETE FROM dcroxx_me_ignore WHERE name='".$uid."' AND target='".$who."'");
      if($res)
        {
            echo "<img src=\"images/ok.gif\" alt=\"o\"/>$tnick was deleted successfully from your ignore list<br/>";
        }else{
          echo "<img src=\"images/notok.gif\" alt=\"x\"/>Error Updating Database<br/>";
        }
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"x\"/>$tnick is not ignored by you<br/>";
      }
  }
  echo "<br/><a href=\"lists.php?action=ignl\">";
echo "Ignore List</a><br/>";
         $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
 exit();
    }
//////////////////////////////////////////////////////////////////////Update profile
else if($action=="uprof")
{
    addonline(getuid_sid($sid),"Updating Settings","");
   // $savat = $_POST["savat"];
    //$semail = $_POST["semail"];
    $usite = $_POST["usite"];
    $ubday = $_POST["ubday"];
    $uloc = $_POST["uloc"];
    $usig = $_POST["usig"];
    $usex = $_POST["usex"];
   $rmsg = $_POST["rmsg"];
	$umood = $_POST["umood"];
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\">";
  //$uid = getuid_sid($sid);
  $res = mysql_query("UPDATE dcroxx_me_users SET site='".$usite."', birthday='".$ubday."', location='".$uloc."',fmsg='".$rmsg."', signature='".$usig."', sex='".$usex."', mood='".$umood."' WHERE id='".$uid."'");
  if($res)
  {
    echo "<img src=\"images/ok.gif\" alt=\"o\"/>Your profile was updated $umood successfully<br/>";
  }else{
    echo "<img src=\"images/notok.gif\" alt=\"x\"/>Error updating your profile<br/>";
  }
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home";
  echo "</p>";
  echo xhtmlfoot();
 exit();
    }
	
else if($action=="uverify"){
    addonline(getuid_sid($sid),"Verify Settings","");

    $rlcountry = $_POST["rlcountry"];
    $rldivision = $_POST["rldivision"];
    $rldistrict = $_POST["rldistrict"];
    $rlisp = $_POST["rlisp"];
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\">";
  //$uid = getuid_sid($sid);
  $res = mysql_query("UPDATE dcroxx_me_users SET rlcountry='".$rlcountry."', rldivision='".$rldivision."', rldistrict='".$rldistrict."',rlisp='".$rlisp."', r_verify='1' WHERE id='".$uid."'");
  if($res)
  {
    echo "<img src=\"images/ok.gif\" alt=\"o\"/>Your verification process is complete!<br/>
	Please verify your <a href=\"sms.php?action=number\">Phone Number</a> and <a href=\"email.php?action=emailpage\">Email Address</a> if you won't complete these.<br/>";
  }else{
    echo "<img src=\"images/notok.gif\" alt=\"x\"/>Error verification process<br/>";
  }
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home";
  echo "</p>";
  echo xhtmlfoot();
 exit();
    }
/////////////////////////////////////////////////////////////////Update Site Settings
else if($action=="ustset")
{
    addonline(getuid_sid($sid),"Updating Settings","");

    $showcons = $_POST["showcons"];
    $showtime = $_POST["showtime"];
    $showshout = $_POST["showshout"];
    $theme = $_POST["theme"];
    $sitelang = $_POST["sitelang"];
    $showshortkey = $_POST["showshortkey"];

    $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\">";
  //$uid = getuid_sid($sid);

  $res = mysql_query("UPDATE dcroxx_me_users SET showicon='".$showcons."' WHERE id='".$uid."'");
  $res = mysql_query("UPDATE dcroxx_me_users SET showtime='".$showtime."' WHERE id='".$uid."'");
  $res = mysql_query("UPDATE dcroxx_me_users SET showshout='".$showshout."' WHERE id='".$uid."'");
  $res = mysql_query("UPDATE dcroxx_me_users SET themeid='".$theme."' WHERE id='".$uid."'");
  $res = mysql_query("UPDATE dcroxx_me_users SET lang='".$sitelang."' WHERE id='".$uid."'");
  $res = mysql_query("UPDATE dcroxx_me_users SET showshortkey='".$showshortkey."' WHERE id='".$uid."'");


  if($res)
  {
    echo "<img src=\"images/ok.gif\" alt=\"o\"/>Your Site Settings was updated successfully<br/>";
  }else{
    echo "<img src=\"images/notok.gif\" alt=\"x\"/>Error updating your Site Settings<br/>";
  }
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
 exit();
    }
///////////////////////////////////////////////////////////////////Update profile
else if($action=="shsml")
{
    addonline(getuid_sid($sid),"Updating Smilies","");
    $act = $_GET["act"];
    $acts = ($act=="dis" ? 0 : 1);
    $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\">";
  //$uid = getuid_sid($sid);
  $res = mysql_query("UPDATE dcroxx_me_users SET hvia='".$acts."' WHERE id='".$uid."'");
  if($res)
  {
    echo "<img src=\"images/ok.gif\" alt=\"o\"/>Smilies Visibility updated successfully<br/>";
  }else{
    echo "<img src=\"images/notok.gif\" alt=\"x\"/>Error updating your profile<br/>";
  }
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
 exit();
    }
////////////////////////////////////////////////////////////////////Change Password

else if($action=="upwd")
{
    addonline(getuid_sid($sid),"Updating Settings","");
    $npwd = $_POST["npwd"];
    $cpwd = $_POST["cpwd"];
    $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\">";
  //$uid = getuid_sid($sid);
  if($npwd!=$cpwd)
  {
    echo "<img src=\"images/notok.gif\" alt=\"x\"/>Your Password and Confirm Password Doesn't match<br/>";

  }else if((strlen($npwd)<4) || (strlen($npwd)>15)){
    echo "<img src=\"images/notok.gif\" alt=\"x\"/>Your password should be between 4 and 15 letters only<br/>";

  }else{
    $pwd = md5($npwd);
    $res = mysql_query("UPDATE dcroxx_me_users SET pass='".$pwd."' WHERE id='".$uid."'");
    if($res)
  {
    echo "<img src=\"images/ok.gif\" alt=\"o\"/>Your password was updated successfully<br/>";
  }else{
    echo "<img src=\"images/notok.gif\" alt=\"x\"/>Error updating your password<br/>";
  }
  }
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
 echo "</p>";
  echo xhtmlfoot();
 exit();
    }
////////////////////////////////////////////////////////////////
/*else{
   $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\">";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
      $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
 exit();
    }*/


?>
