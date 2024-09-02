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
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$uid=getuid_sid($sid);


if(islogged($sid)==false)
    {
        $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or<br/>Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
       echo xhtmlfoot();
      exit();
    }
    addonline(getuid_sid($sid),"editing Topic","");
	
	
if($action=="rentpc")
{
  $tid = $_GET["tid"];
  $tname = $_POST["tname"];
  $fid = getfid_tid($tid);
 $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\">";
  $otname = gettname($tid);
   $tinfo= mysql_fetch_array(mysql_query("SELECT name,fid, authorid, text, pinned, closed  FROM dcroxx_me_topics WHERE id='".$tid."'"));
if($tinfo[2]==getuid_sid($sid))
  {
  if(trim($tname!=""))
  {
    $not = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_topics WHERE name LIKE '".$tname."' AND fid='".$fid."'"));
    if($not[0]==0)
    {
  $res = mysql_query("UPDATE dcroxx_me_topics SET name='".$tname."' WHERE id='".$tid."'");
  if($res)
          {
            //mysql_query("INSERT INTO dcroxx_me_mlog SET action='topics', details='<b>".getnick_uid(getuid_sid($sid))."</b> Renamed The thread ".mysql_escape_string($otname)." to ".mysql_escape_string($tname)." at the forum ".getfname($fid)."', actdt='".time()."'");
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>Topic  Renamed";
          }}
		  else
		  {
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Topic Name already exist";
          }
  }
  else
  {
    echo "<img src=\"images/notok.gif\" alt=\"X\"/> You must specify a name for the topic";
  }
    
  }
  else{
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>  Wata shame! Dont be an Ass hole to rename others topic!! Fuck u off from $stitle b4 $stitle kick u out!!";
	$wintext = "".getnick_uid($uid)." Tried to Rename others topic!!";
	$res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$wintext."', byuid='".$uid."', touid='1', timesent='".time()."'");
  }
  echo "<br/><br/>";
  echo "<a href=\"index.php?action=viewtpc&amp;tid=$tid\">";
echo "View Topic</a><br/>";
$fname = getfname($fid);
      echo "<a href=\"index.php?action=viewfrm&amp;fid=$fid\">";
echo "$fname</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
    exit();
    }
//////////////////////////////////
else if($action=="edttpc")
{
$uid=getuid_sid($sid);
  $tid = $_GET["tid"];
  $ttext = $_POST["ttext"];
  $fid = getfid_tid($tid);
 $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\">";
  $tinfo= mysql_fetch_array(mysql_query("SELECT name,fid, authorid, text, pinned, closed  FROM dcroxx_me_topics WHERE id='".$tid."'"));
if($tinfo[2]==getuid_sid($sid))
  {
  $res = mysql_query("UPDATE dcroxx_me_topics SET text='"
  .$ttext."' WHERE id='".$tid."'");
  if($res)
          {
            //mysql_query("INSERT INTO dcroxx_me_mlog SET action='topics', details='<b>".getnick_uid(getuid_sid($sid))."</b> Edited the text Of the thread ".mysql_escape_string(gettname($tid))." at the forum ".getfname($fid)."', actdt='".time()."'");
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>Topic Message Edited";
          }}else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Wata shame! Dont be an Ass hole to edit others topic!! Fuck u off from $stitle b4 $stitle kick u out!";
			$wintext = "".getnick_uid($uid)." Tried to edit others topic!!";
	$res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$wintext."', byuid='".$uid."', touid='1', timesent='".time()."'");
          }
  echo "<br/><br/>";
  echo "<a href=\"index.php?action=viewtpc&amp;tid=$tid\">";
echo "View Topic</a><br/>";
$fname = getfname($fid);
      echo "<a href=\"index.php?action=viewfrm&amp;fid=$fid\">";
echo "$fname</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
    exit();
    }
//////////////////////////////////
else if($action=="delt")
{

  $tid = $_GET["tid"];
  $fid = getfid_tid($tid);
 $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\">";
  $tname=gettname($tid);
  $tinfo= mysql_fetch_array(mysql_query("SELECT name,fid, authorid, text, pinned, closed  FROM dcroxx_me_topics WHERE id='".$tid."'"));
if($tinfo[2]==getuid_sid($sid))
  {
  $res = mysql_query("DELETE FROM dcroxx_me_topics WHERE id='".$tid."'");
  if($res)
          {
            mysql_query("DELETE FROM dcroxx_me_posts WHERE tid='".$tid."'");
            //mysql_query("INSERT INTO dcroxx_me_mlog SET action='topics', details='<b>".getnick_uid(getuid_sid($sid))."</b> Deleted The thread ".mysql_escape_string($tname)." at the forum ".getfname($fid)."', actdt='".time()."'");
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>Topic Deleted";
          }}else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Wata shame! Dont be an Ass hole to Delete others topic!! Fuck u off from $stitle b4 $stitle kick u out!";
			$wintext = "".getnick_uid($uid)." Tried to delete others topic!!";
	$res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$wintext."', byuid='".$uid."', touid='1', timesent='".time()."'");
          }
  echo "<br/><br/>";
  
$fname = getfname($fid);
      echo "<a href=\"index.php?action=viewfrm&amp;fid=$fid\">";
echo "$fname</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
    exit();
    }
/////////////////////////////////////////////////////////////////////////Edit Post

else if($action=="edtpst")
{
  $pid = $_GET["pid"];
  $ptext = $_POST["ptext"];
  $tid = gettid_pid($pid);
  $fid = getfid_tid($tid);
 $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\">";
   $pinfo= mysql_fetch_array(mysql_query("SELECT uid,tid, text  FROM dcroxx_me_posts WHERE id='".$pid."'"));
  if($pinfo[0]==getuid_sid($sid))
  {
  $res = mysql_query("UPDATE dcroxx_me_posts SET text='"
  .$ptext."' WHERE id='".$pid."'");
  if($res)
          {
            $tname = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_topics WHERE id='".$tid."'"));
            //mysql_query("INSERT INTO dcroxx_me_mlog SET action='posts', details='<b>".getnick_uid(getuid_sid($sid))."</b> Edited Post Number $pid Of the thread ".mysql_escape_string($tname[0])." at the forum ".getfname($fid)."', actdt='".time()."'");
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>Post Message Edited";
          }}else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Wata shame! Dont be an Ass hole to Delete others Posts!! Fuck u off from $stitle b4 $stitle kick u out!";
			$wintext = "".getnick_uid($uid)." Tried to delete others posts!!";
	$res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$wintext."', byuid='".$uid."', touid='1', timesent='".time()."'");
          }
  echo "<br/><br/>";
  echo "<a href=\"index.php?action=viewtpc&amp;tid=$tid\">";
echo "View Topic</a><br/>";
$fname = getfname($fid);
      echo "<a href=\"index.php?action=viewfrm&amp;fid=$fid\">";
echo "$fname</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
    exit();
    }
//////////////////////////////////
else if($action=="clot")
{
  $tid = $_GET["tid"];
  $tdo = $_GET["tdo"];
  $fid = getfid_tid($tid);
 $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\">";
  $tinfo= mysql_fetch_array(mysql_query("SELECT name,fid, authorid, text, pinned, closed  FROM dcroxx_me_topics WHERE id='".$tid."'"));
if($tinfo[2]==getuid_sid($sid))
  {
  $res = mysql_query("UPDATE dcroxx_me_topics SET closed='"
  .$tdo."' WHERE id='".$tid."'");
  if($res)
          {
            if($tdo==1)
            {
              $msg = "Closed";
            }else{
                $msg = "Opened";
            }
            //mysql_query("INSERT INTO dcroxx_me_mlog SET action='topics', details='<b>".getnick_uid(getuid_sid($sid))."</b> Closed The thread ".mysql_escape_string(gettname($tid))." at the forum ".getfname($fid)."', actdt='".time()."'");
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>Topic $msg";
			$tpci = mysql_fetch_array(mysql_query("SELECT name, authorid FROM dcroxx_me_topics WHERE id='".$tid."'"));
			$tname = htmlspecialchars($tpci[0]);
			$msg = "your thread [topic=$tid]$tname"."[/topic] is $msg"."[br/][small][i]p.s: this is an automatic pm[/i][/small]";
			autopm($msg, $tpci[1]);
          }}else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Wata shame! Dont be an Ass hole to close others topic!! Fuck u off from $stitle b4 $stitle kick u out!";
			$wintext = "".getnick_uid($uid)." Tried to close others topic!!";
	$res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$wintext."', byuid='".$uid."', touid='1', timesent='".time()."'");
          }
  echo "<br/><br/>";
  
$fname = getfname($fid);
      echo "<a href=\"index.php?action=viewfrm&amp;fid=$fid\">";
echo "$fname</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
    exit();
    }

?>
