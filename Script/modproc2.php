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

  echo "<card id=\"main\" title=\"$sitename\">";

  echo "<p align=\"center\"><small>";

  echo "<b>permission Denied!</b><br/>";

  echo "<br/>Only mod/admin can use this page...<br/>";

  echo "<a href=\"index.php\">Home</a>";

  echo "</small></p>";

  echo "</card>";

  echo "</wml>";

  exit();

}



if(islogged($sid)==false)

{

  echo "<card id=\"main\" title=\"$sitename\">";

  echo "<p align=\"center\"><small>";

  echo "You are not logged in<br/>";

  echo "Or Your session has been expired<br/><br/>";

  echo "<a href=\"index.php\">Login</a>";

  echo "</small></p>";

  echo "</card>";

  echo "</wml>";

  exit();

}



addonline(getuid_sid($sid),"Admin Tools","");



if($action=="delp")

{

  $pid = $_GET["pid"];

  $tid = gettid_pid($pid);

  $fid = getfid_tid($tid);

 echo "<card id=\"main\" title=\"Admin Tools\">";

  echo "<p align=\"center\"><small>";

  $res = mysql_query("DELETE FROM dcroxx_me_posts WHERE id='".$pid."'");

  if($res)

          {

            $tname = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_topics WHERE id='".$tid."'"));

            mysql_query("INSERT INTO dcroxx_me_mlog SET action='posts', details='<b>".getnick_uid(getuid_sid($sid))."</b> Deleted Post Number $pid Of the thread ".mysql_escape_string($tname[0])." at the forum ".getfname($fid)."', actdt='".time()."'");

            

            echo "<img src=\"images/ok.gif\" alt=\"O\"/>Post Message Deleted";

          }else{

            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";

          }

  

  echo "<br/><br/><a href=\"index.php?action=viewtpc&amp;tid=$tid&amp;page=1000\">View Topic</a><br/>";

$fname = getfname($fid);

      echo "<a href=\"index.php?action=viewfrm&amp;fid=$fid\">$fname</a><br/>";

  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}



////////////////////////////////////////////Edit Post



else if($action=="edtpst")

{

  $pid = $_GET["pid"];

  $ptext = $_POST["ptext"];

  $tid = gettid_pid($pid);

  $fid = getfid_tid($tid);

 echo "<card id=\"main\" title=\"Admin Tools\">";

  echo "<p align=\"center\"><small>";

  $res = mysql_query("UPDATE dcroxx_me_posts SET text='"

  .$ptext."' WHERE id='".$pid."'");

  if($res)

          {

            $tname = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_topics WHERE id='".$tid."'"));

            mysql_query("INSERT INTO dcroxx_me_mlog SET action='posts', details='<b>".getnick_uid(getuid_sid($sid))."</b> Edited Post Number $pid Of the thread ".mysql_escape_string($tname[0])." at the forum ".getfname($fid)."', actdt='".time()."'");

            echo "<img src=\"images/ok.gif\" alt=\"O\"/>Post Message Edited";

          }else{

            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";

          }

  echo "<br/><br/>";

  echo "<a href=\"index.php?action=viewtpc&amp;tid=$tid\">View Topic</a><br/>";

$fname = getfname($fid);

      echo "<a href=\"index.php?action=viewfrm&amp;fid=$fid\">$fname</a><br/>";

  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}



////////////////////////////////////////////Edit Post



else if($action=="edttpc")

{

  $tid = $_GET["tid"];

  $ttext = $_POST["ttext"];

  $fid = getfid_tid($tid);

 echo "<card id=\"main\" title=\"Admin Tools\">";

  echo "<p align=\"center\"><small>";

  $res = mysql_query("UPDATE dcroxx_me_topics SET text='"

  .$ttext."' WHERE id='".$tid."'");

  if($res)

          {

            mysql_query("INSERT INTO dcroxx_me_mlog SET action='topics', details='<b>".getnick_uid(getuid_sid($sid))."</b> Edited the text Of the thread ".mysql_escape_string(gettname($tid))." at the forum ".getfname($fid)."', actdt='".time()."'");

            echo "<img src=\"images/ok.gif\" alt=\"O\"/>Topic Message Edited";

          }else{

            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";

          }

  echo "<br/><br/>";

  echo "<a href=\"index.php?action=viewtpc&amp;tid=$tid\">View Topic</a><br/>";

$fname = getfname($fid);

      echo "<a href=\"index.php?action=viewfrm&amp;fid=$fid\">$fname</a><br/>";

  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}



///////////////////////////////////////Close/ Open Topic



else if($action=="clot")

{

  $tid = $_GET["tid"];

  $tdo = $_GET["tdo"];

  $fid = getfid_tid($tid);

 echo "<card id=\"main\" title=\"Admin Tools\">";

  echo "<p align=\"center\"><small>";

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

            mysql_query("INSERT INTO dcroxx_me_mlog SET action='topics', details='<b>".getnick_uid(getuid_sid($sid))."</b> Closed The thread ".mysql_escape_string(gettname($tid))." at the forum ".getfname($fid)."', actdt='".time()."'");

            echo "<img src=\"images/ok.gif\" alt=\"O\"/>Topic $msg";

			$tpci = mysql_fetch_array(mysql_query("SELECT name, authorid FROM dcroxx_me_topics WHERE id='".$tid."'"));

			$tname = htmlspecialchars($tpci[0]);

			$msg = "your thread [topic=$tid]$tname"."[/topic] is $msg"."[br/][small][i]p.s: this is an automatic pm[/i][/small]";

			autopm($msg, $tpci[1]);

          }else{

            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";

          }

  echo "<br/><br/>";

  

$fname = getfname($fid);

      echo "<a href=\"index.php?action=viewfrm&amp;fid=$fid\">";

echo "$fname</a><br/>";

  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}

else if($action=="quiz")

{

  $qtitle = safe_query($_POST["qtitle"]);
  $qby = safe_query($_POST["qby"]);
  $qdes = safe_query($_POST["qdes"]);
  $qstatus = safe_query($_POST["qstatus"]);
  $qtid = safe_query($_POST["qtid"]);
  $uid = getuid_sid($sid);
 echo "<card id=\"main\" title=\"Admin Tools\">";
  echo "<p align=\"center\"><small>";

  //  if(trim($pres)==""){
	      $count = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_quizc WHERE qtid='".$qtid."'"));
    if($count[0]>0){
		  echo "<img src=\"images/notok.gif\" alt=\"X\"/>This is already on our quiz database.";
	}else{
	if((empty($qtitle))&&(empty($qby))&&(empty($qdes))&&(empty($qtid))){
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>All fields are required to fill up.";
  }else{
	  
$res = mysql_query("INSERT INTO dcroxx_me_quizc SET qtitle='".$qtitle."', qby='".$qby."', qdes='".$qdes."', qstatus='".$qstatus."', qtid='".$qtid."',  who='".$uid."', time='".time()."'");

  if($res){
echo "<img src=\"images/ok.gif\" alt=\"O\"/>Quiz Added successfully";
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
}
  }
	}

  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}
else if($action=="quizw")

{

  $qid = safe_query($_POST["qid"]);
  $qrp = safe_query($_POST["qrp"]);
  $qpls = safe_query($_POST["qpls"]);
  $qwid = safe_query($_POST["qwid"]);
  $qnm = safe_query($_POST["qnm"]);
  $qp = safe_query($_POST["qp"]);
  $uid = getuid_sid($sid);
 echo "<card id=\"main\" title=\"Admin Tools\">";
  echo "<p align=\"center\"><small>";

  //  if(trim($pres)==""){

	if((empty($qid))&&(empty($qwid))&&(empty($qnm))&&(empty($qp))){
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>All fields are required to fill up.";
  }else{
	  
$res = mysql_query("INSERT INTO dcroxx_me_quizw SET qid='".$qid."', qrp='".$qrp."', qpls='".$qpls."', qwid='".$qwid."',
 qnm='".$qnm."', qp='".$qp."', who='".$uid."', time='".time()."'");

  if($res){
echo "<img src=\"images/ok.gif\" alt=\"O\"/>Quiz winner added successfully and waiting for Admins approval";

	$nick = getnick_uid($qwid);
mysql_query("INSERT INTO dcroxx_me_private SET text='[u]Approval Needs:[/u][br/]".$nick." will get ".$qrp." rp/".$qpls." plusses for  ".$qp." level winner of ".$qnm." quiz/contest if you approve now from [b]Quiz/Contests[/b] Menu', byuid='3', touid='1', timesent='".time()."'");
mysql_query("INSERT INTO dcroxx_me_private SET text='[u]Approval Needs:[/u][br/]".$nick." will get ".$qrp." rp/".$qpls." plusses for  ".$qp." level winner of ".$qnm." quiz/contest if you approve now from [b]Quiz/Contests[/b] Menu', byuid='3', touid='443', timesent='".time()."'");

}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
}
	}

  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}
else if($action=="editquiz")

{
  $id = safe_query($_GET["id"]);
  $qtitle = safe_query($_POST["qtitle"]);
  $qby = safe_query($_POST["qby"]);
  $qdes = safe_query($_POST["qdes"]);
  $qstatus = safe_query($_POST["qstatus"]);
  $qtid = safe_query($_POST["qtid"]);
  $uid = getuid_sid($sid);
 echo "<card id=\"main\" title=\"Admin Tools\">";
  echo "<p align=\"center\"><small>";

  //  if(trim($pres)==""){
	if((empty($qtitle))&&(empty($qby))&&(empty($qdes))){
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>All fields are required to fill up.";
  }else{
	  
$res = mysql_query("UPDATE dcroxx_me_quizc SET qtitle='".$qtitle."', qby='".$qby."', qdes='".$qdes."',
 qstatus='".$qstatus."', who='".$uid."', time='".time()."' WHERE id='".$id."'");

  if($res){
echo "<img src=\"images/ok.gif\" alt=\"O\"/>Quiz Edited Successfully";
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
}
  }
	

  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}
else if($action=="quizadv")

{
  $tid = isnum((int)$_POST["tid"]);
  $des = $_POST["des"];
  
   $pds = $_POST["pds"];
  $phr = $_POST["phr"];
  $pmn = $_POST["pmn"];
  $psc = $_POST["psc"];
  
  echo "<card id=\"main\" title=\"Admin Tools\">";
  echo "<p align=\"center\"><small>";
   $timeto = $pds*24*60*60;
  $timeto += $phr*60*60;
  $timeto += $pmn*60;
  $timeto += $psc;
  $ptime = $timeto + time();
  $res = mysql_query("INSERT INTO dcroxx_me_adv SET topicid='".$tid."', host='".getuid_sid($sid)."', time='".time()."', det='".$des."', qtime='".$ptime."'");
  if($res)
  {
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Quiz Advertised successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
  }
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
///////////////////////////////////////Untrash user



else if($action=="untr")

{

  $who = $_GET["who"];

 echo "<card id=\"main\" title=\"Admin Tools\">";

  echo "<p align=\"center\"><small>";

  /*$res = mysql_query("DELETE FROM dcroxx_me_penalties WHERE penalty='0' AND uid='".$who."'");

  if($res)

          {

            $unick = getnick_uid($who);

            mysql_query("INSERT INTO dcroxx_me_mlog SET action='penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> Untrashed The user <b>".$unick."', actdt='".time()."'");

            echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick Untrashed";

          }else{

            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";

          }*/
		  
	  $res = mysql_query("DELETE FROM dcroxx_me_metpenaltiespl WHERE penalty='0' AND uid='".$who."'");
  if($res)
          {
            $unick = getnick_uid($who);
            mysql_query("INSERT INTO dcroxx_me_mlog SET action='penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> Untrashed The user <b>".$unick."', actdt='".time()."'");
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick Untrashed";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
          }	  
		  
		  
		  

  echo "<br/><br/>";





  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}



///////////////////////////////////////Unban user



else if($action=="unbn")

{

  $who = $_GET["who"];

 echo "<card id=\"main\" title=\"Admin Tools\">";

  echo "<p align=\"center\"><small>";

  if(!isadmin(getuid_sid($sid)))

  {

  echo "permission Denied!";

  }else{

  $res = mysql_query("DELETE FROM dcroxx_me_penalties WHERE (penalty='1' OR penalty='2') AND uid='".$who."'");

  if($res)

          {

            $unick = getnick_uid($who);

            mysql_query("INSERT INTO dcroxx_me_mlog SET action='penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> Unbanned The user <b>".$unick."</b>', actdt='".time()."'");

            echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick Unbanned";

          }else{

            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";

          }

  }

  echo "<br/><br/>";

  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}



///////////////////////////////////////Delete shout



else if($action=="delsh")

{

  $shid = $_GET["shid"];

 echo "<card id=\"main\" title=\"Admin Tools\">";

  echo "<p align=\"center\"><small>";

  if(!ismod(getuid_sid($sid)))

  {

  echo "permission Denied!";

  }else{

  $sht = mysql_fetch_array(mysql_query("SELECT shouter, shout FROM dcroxx_me_shouts WHERE id='".$shid."'"));

  $msg = getnick_uid($sht[0]);

  $msg .= ": ".htmlspecialchars((strlen($sht[1])<20?$sht[1]:substr($sht[1], 0, 20)));

  $res = mysql_query("DELETE FROM dcroxx_me_shouts WHERE id ='".$shid."'");

  if($res)

          {

		  mysql_query("INSERT INTO dcroxx_me_mlog SET action='shouts', details='<b>".getnick_uid(getuid_sid($sid))."</b> Deleted the shout <b>".$shid."</b> - $msg', actdt='".time()."'");

            echo "<img src=\"images/ok.gif\" alt=\"O\"/>Shout deleted";

          }else{

            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";

          }

  }

  echo "<br/><br/>";





  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}

else if($action=="delstatus")
{
  $shid = $_GET["shid"];
 echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\">";
  $sht = mysql_fetch_array(mysql_query("SELECT uid, status FROM dcroxx_me_status WHERE id='".$shid."'"));
  $msg = getnick_uid($sht[0]);
  $msg .= ": ".htmlspecialchars((strlen($sht[1])<20?$sht[1]:substr($sht[1], 0, 20)));
  $res = mysql_query("DELETE FROM dcroxx_me_status WHERE id ='".$shid."'");
  if($res)
          {
		  mysql_query("INSERT INTO dcroxx_me_mlog SET action='status', details='<b>".getnick_uid(getuid_sid($sid))."</b> Deleted the status <b>".$shid."</b> - $msg', actdt='".time()."'");
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>Status deleted";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
          }
  echo "<br/><br/>";


  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}
/////////////
else if($action=="delquiz")
{
  $id = isnum((int)$_GET["id"]);
  echo "<card id=\"main\" title=\"Admin Tools\">";
  echo "<p align=\"center\"><small>";
  $res = mysql_query("DELETE FROM dcroxx_me_quizc WHERE id='".$id."'");
  if($res)
  {
    mysql_query("INSERT INTO dcroxx_me_mlog SET action='Quiz', details='<b>".getnick_uid(getuid_sid($sid))."</b> deleted a quiz topic', actdt='".time()."'");
    echo "<img src=\"images/ok.gif\" alt=\"O\"/><b>Quiz deleted successfully</b><br/>";
  }
  else
  {
    echo "<img src=\"images/notok.gif\" alt=\"X\"/><b>Database Error</b><br/>";
  }
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
else if($action=="deladv")
{
  $ad = isnum((int)$_GET["ad"]);
  echo "<card id=\"main\" title=\"Admin Tools\">";
  echo "<p align=\"center\"><small>";
  $res = mysql_query("DELETE FROM dcroxx_me_adv WHERE id='".$ad."'");
  if($res)
  {
    mysql_query("INSERT INTO dcroxx_me_mlog SET action='Advertisem', details='<b>".getnick_uid(getuid_sid($sid))."</b> deleted a advertisement topic. AdID: <b>".$ad."</b>', actdt='".time()."'");
    echo "<img src=\"images/ok.gif\" alt=\"O\"/><b>Deleted successfully</b><br/>";
  }
  else
  {
    echo "<img src=\"images/notok.gif\" alt=\"X\"/><b>Database Error</b><br/>";
  }
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
///////////////////////////////////////Pin/ Unpin Topic



else if($action=="pint")

{

  $tid = $_GET["tid"];

  $tdo = $_GET["tdo"];

  $fid = getfid_tid($tid);

 echo "<card id=\"main\" title=\"Admin Tools\">";

  echo "<p align=\"center\"><small>";

  $pnd = getpinned($fid);

  if($pnd<=5)

  {

  $res = mysql_query("UPDATE dcroxx_me_topics SET pinned='"

  .$tdo."' WHERE id='".$tid."'");

  if($res)

          {

            if($tdo==1)

            {

              $msg = "Pinned";

            }else{

                $msg = "Unpinned";

            }

            mysql_query("INSERT INTO dcroxx_me_mlog SET action='topics', details='<b>".getnick_uid(getuid_sid($sid))."</b> $msg The thread ".mysql_escape_string(gettname($tid))." at the forum ".getfname($fid)."', actdt='".time()."'");

            echo "<img src=\"images/ok.gif\" alt=\"O\"/>Topic $msg";

          }else{

            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";

          }

          }else{

            echo "<img src=\"images/notok.gif\" alt=\"X\"/>You can only pin 5 topics in every forum";

          }

  echo "<br/><br/>";



$fname = getfname($fid);

      echo "<a href=\"index.php?action=viewfrm&amp;fid=$fid\">$fname</a><br/>";

  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}



///////////////////////////////////Delete the damn thing



else if($action=="delt")

{

  $tid = $_GET["tid"];

  $fid = getfid_tid($tid);

 echo "<card id=\"main\" title=\"Admin Tools\">";

  echo "<p align=\"center\"><small>";

  $tname=gettname($tid);

  $res = mysql_query("DELETE FROM dcroxx_me_topics WHERE id='".$tid."'");

  if($res)

          {

            mysql_query("DELETE FROM dcroxx_me_posts WHERE tid='".$tid."'");

            mysql_query("INSERT INTO dcroxx_me_mlog SET action='topics', details='<b>".getnick_uid(getuid_sid($sid))."</b> Deleted The thread ".mysql_escape_string($tname)." at the forum ".getfname($fid)."', actdt='".time()."'");

            echo "<img src=\"images/ok.gif\" alt=\"O\"/>Topic Deleted";

          }else{

            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";

          }

  echo "<br/><br/>";

  

$fname = getfname($fid);

      echo "<a href=\"index.php?action=viewfrm&amp;fid=$fid\">$fname</a><br/>";

  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}





////////////////////////////////////////////Edit Post



else if($action=="rentpc")

{

  $tid = $_GET["tid"];

  $tname = $_POST["tname"];

  $fid = getfid_tid($tid);

 echo "<card id=\"main\" title=\"Admin Tools\">";

  echo "<p align=\"center\"><small>";

  $otname = gettname($tid);

  if(trim($tname!=""))

  {

    $not = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_topics WHERE name LIKE '".$tname."' AND fid='".$fid."'"));

    if($not[0]==0)

    {

  $res = mysql_query("UPDATE dcroxx_me_topics SET name='"

  .$tname."' WHERE id='".$tid."'");

  if($res)

          {

            mysql_query("INSERT INTO dcroxx_me_mlog SET action='topics', details='<b>".getnick_uid(getuid_sid($sid))."</b> Renamed The thread ".mysql_escape_string($otname)." to ".mysql_escape_string($tname)." at the forum ".getfname($fid)."', actdt='".time()."'");

            echo "<img src=\"images/ok.gif\" alt=\"O\"/>Topic  Renamed";

          }else{

            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";

          }

  }else{

    echo "<img src=\"images/notok.gif\" alt=\"X\"/>Topic Name already exist";

  }

    

  }else{

    echo "<img src=\"images/notok.gif\" alt=\"X\"/>You must specify a name for the topic";

  }

  echo "<br/><br/>";

  echo "<a href=\"index.php?action=viewtpc&amp;tid=$tid\">View Topic</a><br/>";

$fname = getfname($fid);

      echo "<a href=\"index.php?action=viewfrm&amp;fid=$fid\">$fname</a><br/>";

  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";

  echo "</small></p></card>";

}



///////////////////////////////////////////////////Move topic







else if($action=="mvt")

{

  $tid = $_GET["tid"];

  $mtf = $_POST["mtf"];

  $fname = htmlspecialchars(getfname($mtf));

  //$fid = getfid_tid($tid);

 echo "<card id=\"main\" title=\"Admin Tools\">";

  echo "<p align=\"center\"><small>";

  

    $not = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_topics WHERE name LIKE '".$tname."' AND fid='".$mtf."'"));

    if($not[0]==0)

    {

  $res = mysql_query("UPDATE dcroxx_me_topics SET fid='"

  .$mtf."', moved='1' WHERE id='".$tid."'");

  if($res)

          {

            mysql_query("INSERT INTO dcroxx_me_mlog SET action='topics', details='<b>".getnick_uid(getuid_sid($sid))."</b> Moved The thread ".mysql_escape_string($tname)." to forum ".getfname($fid)."', actdt='".time()."'");

			$tpci = mysql_fetch_array(mysql_query("SELECT name, authorid FROM dcroxx_me_topics WHERE id='".$tid."'"));

			$tname = htmlspecialchars($tpci[0]);

			$msg = "your thread [topic=$tid]$tname"."[/topic] Was moved to $fname forum[br/][small][i]p.s: this is an automatic pm[/i][/small]";

			autopm($msg, $tpci[1]);

            echo "<img src=\"images/ok.gif\" alt=\"O\"/>Topic Moved";

          }else{

            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";

          }

  }else{

    echo "<img src=\"images/notok.gif\" alt=\"X\"/>Topic Name already exist";

  }





  echo "<br/><br/>";

  



      echo "<a href=\"index.php?action=viewfrm&amp;fid=$mtf\">$fname</a><br/>";

  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";

  echo "</small></p></card>";

}



//////////////////////////////////////////Handle PM



else if($action=="hpm")

{

  $pid = $_GET["pid"];

  

 echo "<card id=\"main\" title=\"Admin Tools\">";

  echo "<p align=\"center\"><small>";

  if(!ismod(getuid_sid($sid)))

  {

  echo "permission Denied!";

  }else{

    $info = mysql_fetch_array(mysql_query("SELECT byuid, touid FROM dcroxx_me_private WHERE id='".$pid."'"));

  $res = mysql_query("UPDATE dcroxx_me_private SET reported='2' WHERE id='".$pid."'");

  if($res)

          {

            mysql_query("INSERT INTO dcroxx_me_mlog SET action='handling', details='<b>".getnick_uid(getuid_sid($sid))."</b> handled The PM ".$pid."', actdt='".time()."'");

            echo "<img src=\"images/ok.gif\" alt=\"O\"/>PM Handled";

          }else{

            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";

          }

  }

  echo "<br/><br/>";

    echo "<a href=\"index.php?action=viewuser&amp;who=$info[0]\">PM Sender's Profile</a><br/>";

      echo "<a href=\"index.php?action=viewuser&amp;who=$info[1]\">PM Reporter's Profile</a><br/><br/>";

      echo "<a href=\"modcp2.php?action=main\">Reports/Logs</a><br/>";

  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}

else if($action=="hchmsg")

{

  $pid = $_GET["pid"];

  

 echo "<card id=\"main\" title=\"Admin Tools\">";

  echo "<p align=\"center\"><small>";

  if(!ismod(getuid_sid($sid)))

  {

  echo "permission Denied!";

  }else{

    $info = mysql_fetch_array(mysql_query("SELECT chatter, reportedby FROM dcroxx_me_chat WHERE id='".$pid."'"));

  $res = mysql_query("UPDATE dcroxx_me_chat SET reported='2' WHERE id='".$pid."'");

  if($res)

          {

            mysql_query("INSERT INTO dcroxx_me_mlog SET action='handling', details='<b>".getnick_uid(getuid_sid($sid))."</b> handled The Chat MSG ".$pid."', actdt='".time()."'");

            echo "<img src=\"images/ok.gif\" alt=\"O\"/>Reporte Handled";

          }else{

            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";

          }

  }

  echo "<br/><br/>";

    echo "<a href=\"index.php?action=viewuser&amp;who=$info[0]\">PM Sender's Profile</a><br/>";

      echo "<a href=\"index.php?action=viewuser&amp;who=$info[1]\">PM Reporter's Profile</a><br/><br/>";

      echo "<a href=\"modcp2.php?action=main\">Reports/Logs</a><br/>";

  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}

//////////////////////////////////////////Handle Popup



else if($action=="hpop")

{

  $pid = $_GET["pid"];

   echo "<card id=\"main\" title=\"Admin Tools\">";

  echo "<p align=\"center\"><small>";

  if(!ismod(getuid_sid($sid)))

  {

  echo "permission Denied!";

  }else{

    $info = mysql_fetch_array(mysql_query("SELECT byuid, touid FROM dcroxx_me_popups WHERE id='".$pid."'"));

  $res = mysql_query("UPDATE dcroxx_me_popups SET reported='2' WHERE id='".$pid."'");

  if($res)

          {

            mysql_query("INSERT INTO dcroxx_me_mlog SET action='handling', details='<b>".getnick_uid(getuid_sid($sid))."</b> handled The Popup ".$pid."', actdt='".time()."'");

            echo "<img src=\"images/ok.gif\" alt=\"O\"/>Popup Handled";

          }else{

            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";

          }





  }

  echo "<br/><br/>";

    echo "<a href=\"index.php?action=viewuser&amp;who=$info[0]\">PM Sender's Profile</a><br/>";

      echo "<a href=\"index.php?action=viewuser&amp;who=$info[1]\">PM Reporter's Profile</a><br/><br/>";

      echo "<a href=\"modcp2.php?action=main\">Reports/Logs</a><br/>";

  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}



//////////////////////////////////////////Handle Post



else if($action=="hps")

{

  $pid = $_GET["pid"];



 echo "<card id=\"main\" title=\"Admin Tools\">";

  echo "<p align=\"center\"><small>";

  if(!ismod(getuid_sid($sid)))

  {

  echo "permission Denied!";

  }else{

    $info = mysql_fetch_array(mysql_query("SELECT uid, tid FROM dcroxx_me_posts WHERE id='".$pid."'"));

  $res = mysql_query("UPDATE dcroxx_me_posts SET reported='2' WHERE id='".$pid."'");

  if($res)

          {

            mysql_query("INSERT INTO dcroxx_me_mlog SET action='handling', details='<b>".getnick_uid(getuid_sid($sid))."</b> handled The Post ".$pid."', actdt='".time()."'");

            echo "<img src=\"images/ok.gif\" alt=\"O\"/>Post Handled";

          }else{

            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";

          }

  }

  echo "<br/><br/>";

    $poster = getnick_uid($info[0]);

    echo "<a href=\"index.php?action=viewuser&amp;who=$info[0]\">$poster's Profile</a><br/>";

      echo "<a href=\"index.php?action=viewtpc&amp;tid=$info[1]\">View Topic</a><br/><br/>";

      echo "<a href=\"modcp2.php?action=main\">Reports/Logs</a><br/>";

  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}



//////////////////////////////////////////Handle Topic



else if($action=="htp")

{

  $pid = $_GET["tid"];



 echo "<card id=\"main\" title=\"Admin Tools\">";

  echo "<p align=\"center\"><small>";

  if(!ismod(getuid_sid($sid)))

  {

  echo "permission Denied!";

  }else{

    $info = mysql_fetch_array(mysql_query("SELECT authorid FROM dcroxx_me_topics WHERE id='".$pid."'"));

  $res = mysql_query("UPDATE dcroxx_me_topics SET reported='2' WHERE id='".$pid."'");

  if($res)

          {

            mysql_query("INSERT INTO dcroxx_me_mlog SET action='handling', details='<b>".getnick_uid(getuid_sid($sid))."</b> handled The topic ".mysql_escape_string(gettname($pid))."', actdt='".time()."'");

            echo "<img src=\"images/ok.gif\" alt=\"O\"/>Topic Handled";

          }else{

            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";

          }

  }

  echo "<br/><br/>";

    $poster = getnick_uid($info[0]);

    echo "<a href=\"index.php?action=viewuser&amp;who=$info[0]\">$poster's Profile</a><br/>";

      echo "<a href=\"index.php?action=viewtpc&amp;tid=$pid\">View Topic</a><br/><br/>";

      echo "<a href=\"modcp2.php?action=main\">Reports/Logs</a><br/>";

  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}



////////////////////////////////////////plusses

else if($action=="pls")

{

    $pid = $_POST["pid"];

    $who = $_POST["who"];

    $pres = $_POST["pres"];

    $pval = $_POST["pval"];

    echo "<card id=\"main\" title=\"Admin Tools\">";

  echo "<p align=\"center\"><small>";

  if(!ismod(getuid_sid($sid)))

  {

  echo "permission Denied!";

  }else{

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

            mysql_query("INSERT INTO dcroxx_me_mlog SET action='penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> Updated <b>".$unick."</b> plusses from ".$opl[0]." to $npl', actdt='".time()."'");
            $tm = time()+6*60*60;
		$uid = getuid_sid($sid);
	$nick = getnick_uid($uid);
        $user = getnick_sid($sid);
	mysql_query("INSERT INTO ibwf_plusseslogs SET res='".mysql_escape_string($pres)."', byuid='".$uid."', touid='".$who."', beforeplusses='".$opl[0]."', atmplusses='".$npl."', time='".$tm."'");
        mysql_query("INSERT INTO dcroxx_me_private SET text='[b]NOTIFICATION:[/b][br/]I have updated your plusses from ".$opl[0]." to ".$npl."[br/][small]p.s: this is an automated pm[/small]', byuid='".getuid_sid($sid)."', touid='".$who."', timesent='".time()."'");

            echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick's Plusses Updated From $opl[0] to $npl";

          }else{

            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";

          }

  }

  }

  echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}
else if($action=="bdt")

{

    $pid = $_POST["pid"];

    $who = $_POST["who"];

    $pres = $_POST["pres"];

    $pval = $_POST["pval"];

    echo "<card id=\"main\" title=\"Admin Tools\">";

  echo "<p align=\"center\"><small>";

  if(!ismod(getuid_sid($sid)))

  {

  echo "permission Denied!";

  }else{

$unick = getnick_uid($who);

$opl = mysql_fetch_array(mysql_query("SELECT balance FROM dcroxx_me_users WHERE id='".$who."'"));



if($pid=='0')

{

  $npl = $opl[0] + $pval;

}else{

    $npl = $opl[0] - $pval;

}

if($npl<0)

{

  $npl=0;

}

  if(trim($pres)=="")

  {

    echo "<img src=\"images/notok.gif\" alt=\"X\"/>You must Specify a reson for updating $unick's balance";

  }else{

    

    $res = mysql_query("UPDATE dcroxx_me_users SET lastplreas='BDT:".mysql_escape_string($pres)."', balance='".$npl."' WHERE id='".$who."'");

    if($res)

          {

            mysql_query("INSERT INTO dcroxx_me_mlog SET action='Balance', details='<b>".getnick_uid(getuid_sid($sid))."</b> Updated <b>".$unick."</b> balance from ".$opl[0]." to $npl', actdt='".time()."'");
            $tm = time()+6*60*60;
		$uid = getuid_sid($sid);
	$nick = getnick_uid($uid);
        $user = getnick_sid($sid);
	//mysql_query("INSERT INTO ibwf_plusseslogs SET res='".mysql_escape_string($pres)."', byuid='".$uid."', touid='".$who."', beforeplusses='".$opl[0]."', atmplusses='".$npl."', time='".$tm."'");
        mysql_query("INSERT INTO dcroxx_me_private SET text='[b]NOTIFICATION:[/b][br/]I have updated your balance from ".$opl[0]." to ".$npl." for ".mysql_escape_string($pres)."[br/][small]p.s: this is an automated pm[/small]', byuid='".getuid_sid($sid)."', touid='".$who."', timesent='".time()."'");

            echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick's balance Updated From $opl[0] to $npl";

          }else{

            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";

          }

  }

  }

  echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}else if($action=="bdt_with")

{

    $pid = $_POST["pid"];

    $who = $_POST["who"];

    $pres = $_POST["pres"];

    $pval = $_POST["pval"];

    echo "<card id=\"main\" title=\"Admin Tools\">";

  echo "<p align=\"center\"><small>";

  if(!ismod(getuid_sid($sid)))

  {

  echo "permission Denied!";

  }else{

$unick = getnick_uid($who);

$opl = mysql_fetch_array(mysql_query("SELECT withdraw_balance FROM dcroxx_me_users WHERE id='".$who."'"));



if($pid=='0')

{

  $npl = $opl[0] + $pval;

}else{

    $npl = $opl[0] - $pval;

}

if($npl<0)

{

  $npl=0;

}

  if(trim($pres)=="")

  {

    echo "<img src=\"images/notok.gif\" alt=\"X\"/>You must Specify a reson for updating $unick's withdraw balance";

  }else{

    

    $res = mysql_query("UPDATE dcroxx_me_users SET lastplreas='BDT:".mysql_escape_string($pres)."', withdraw_balance='".$npl."' WHERE id='".$who."'");

    if($res)

          {

            mysql_query("INSERT INTO dcroxx_me_mlog SET action='With_balance', details='<b>".getnick_uid(getuid_sid($sid))."</b> Updated <b>".$unick."</b> withdraw_balance from ".$opl[0]." to $npl', actdt='".time()."'");
            $tm = time()+6*60*60;
		$uid = getuid_sid($sid);
	$nick = getnick_uid($uid);
        $user = getnick_sid($sid);
	//mysql_query("INSERT INTO ibwf_plusseslogs SET res='".mysql_escape_string($pres)."', byuid='".$uid."', touid='".$who."', beforeplusses='".$opl[0]."', atmplusses='".$npl."', time='".$tm."'");
        mysql_query("INSERT INTO dcroxx_me_private SET text='[b]NOTIFICATION:[/b][br/]I have updated your withdraw balance from ".$opl[0]." to ".$npl." for ".mysql_escape_string($pres)."[br/][small]p.s: this is an automated pm[/small]', byuid='".getuid_sid($sid)."', touid='".$who."', timesent='".time()."'");

            echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick's balance Updated From $opl[0] to $npl";

          }else{

            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";

          }

  }

  }

  echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}
else if($action=="rp")

{

    $pid = $_POST["pid"];

    $who = isnum((int)$_POST["who"]);

    $pres = $_POST["pres"];

    $pval = isnum((int)$_POST["pval"]);

    echo "<card id=\"main\" title=\"Admin Tools\">";

  echo "<p align=\"center\"><small>";

  if(!isadmin(getuid_sid($sid)) && !isowner(getuid_sid($sid)))

  {

  echo "permission Denied!";

  }else{

$unick = getnick_uid($who);

$opl = mysql_fetch_array(mysql_query("SELECT rp, totalrps FROM dcroxx_me_users WHERE id='".$who."'"));

    $npl = $opl[0] + $pval;
if($npl<0)
{
  $npl=0;
}

  if(trim($pres)=="")

  {

    echo "<img src=\"images/notok.gif\" alt=\"X\"/>You must Specify a quiz name for updating $unick's RP";

  }else{   

    $res = mysql_query("UPDATE dcroxx_me_users SET rp='".$npl."' WHERE id='".$who."'");

    if($res)

          {

            mysql_query("INSERT INTO dcroxx_me_quizw SET uid='".$uid."', des='<b>".getnick_uid(getuid_sid($sid))."</b> updated <b>".$unick."</b> RP from ".$opl[0]." to $npl', pos='".$pid."', cname='".$pres."', time='".time()."'");

            echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick's RP Updated From $opl[0] to $npl";
            mysql_query("INSERT INTO dcroxx_me_private SET text='[b]NOTIFICATION:[/b][br/]I have updated your RP from ".$opl[0]." to ".$npl."[br/][small]p.s: this is an automated pm[/small]', byuid='".getuid_sid($sid)."', touid='".$who."', timesent='".time()."'");

          }else{

            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";

          }

  }

  }

  echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}
else if($action=="war")

{

    $who = $_POST["who"];

    $pres = $_POST["pres"];

    $pval = $_POST["pval"];

    echo "<card id=\"main\" title=\"Admin Tools\">";

  echo "<p align=\"center\"><small>";

  if(!isadmin(getuid_sid($sid)))

  {

  echo "permission Denied!";

  }else{

$unick = getnick_uid($who);

$opl = mysql_fetch_array(mysql_query("SELECT warning FROM dcroxx_me_users WHERE id='".$who."'"));

    $npl = $opl[0] + $pval;

if($npl<0)

{

  $npl=0;

}

  if(trim($pres)=="")

  {

    echo "<img src=\"images/notok.gif\" alt=\"X\"/>You must Specify a reson for warning to $unick";

  }else{

    $res = mysql_query("UPDATE dcroxx_me_users SET warning='".$npl."' WHERE id='".$who."'");

    if($res)

          {

            mysql_query("INSERT INTO ibwf_warlog SET uid='".$uid."', toid='".$who."', res='".$pres."', time='".time()."'");

            echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick's warning level Updated From $opl[0] to $npl";

          }else{

            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";

          }

  }

  }

  echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}
else if($action=="quizrp")
{
  $who = isnum((int)$_POST["who"]);
  $quizname = $_POST["quizname"]; $pos = $_POST["pos"]; $pval = $_POST["pval"];
  echo "<card id=\"main\" title=\"Admin Tools\">";
  echo "<p align=\"center\"><small>";
  $res = mysql_query("INSERT INTO dcroxx_me_quizw SET uid='".$who."', byuid='".getuid_sid($sid)."', pos='".$pos."', qname='".$quizname."', rps='".$pval."', time='".time()."'");
  if($res)
  {
    echo "<img src=\"images/ok.gif\" alt=\"O\"/>Quiz Reputation Updated Successfully<br/>";
  }else
  {
    echo "<img src=\"images/notok.gif\" alt=\"X\"/><b>Database Error</b><br/>";
  }
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
else if($action=="pmbans")
{
  $who = isnum((int)$_GET['who']);
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"ModCP\">";
  echo "<p align=\"center\">";
  if(ispmbaned($who)){
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>$user is already pm banned by staff team";
  }else{
  $res = mysql_query("UPDATE dcroxx_me_users SET xpmban2x='1' WHERE id='".$who."'");
  if($res)
  {
    mysql_query("INSERT INTO dcroxx_me_private SET text='[b]NOTIFICATION:[/b][br/]You are now PM Banned by [b]Staff Team[/b][br/][small]p.s: this is an automated pm[/small]', byuid='3', touid='".$who."', timesent='".time()."'");
 mysql_query("INSERT INTO dcroxx_me_mlog SET action='pmban', details='<b>".getnick_uid(getuid_sid($sid))."</b> pm banned the user: <b>".$user."</b>', actdt='".time()."'");
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>$user is PM banned";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
  }
  }
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"ownercp.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"\"/>President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p></card>";
}
else if($action=="pmunbans")
{
  $who = isnum((int)$_GET['who']);
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"ModCP\">"; 
  echo "<p align=\"center\">";
  if(!ispmbaned($who)){
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>$user is not banned yet for unbanning pm";
  }else{
  $res = mysql_query("UPDATE dcroxx_me_users SET xpmban2x='0' WHERE id='".$who."'");
  if($res)
  {
    mysql_query("INSERT INTO dcroxx_me_private SET text='[b]NOTIFICATION:[/b][br/]You are now PM Unbanned by [b]Staff Team[/b][br/][small]p.s: this is an automated pm[/small]', byuid='3', touid='".$who."', timesent='".time()."'");
 mysql_query("INSERT INTO dcroxx_me_mlog SET action='pmban', details='<b>".getnick_uid(getuid_sid($sid))."</b> pm banned the user: <b>".$user."</b>', actdt='".time()."'");
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>$user is PM Unbanned";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
  }
  }
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"ownercp.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"\"/>President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p></card>";
}
////////////////hide posts
else if($action=="hidetopic")
{
  $who = isnum((int)$_GET["who"]);
  $user = getnick_uid($who);
  $tid = isnum((int)$_GET['tid']);
      echo "<card id=\"main\" title=\"Admin Tools\">";
      echo "<p align=\"center\">";
$tinfo = mysql_fetch_array(mysql_query("SELECT name, text, authorid, crdate, views, fid, pollid from dcroxx_me_topics WHERE id='".$tid."'"));
$tnm = htmlspecialchars($tinfo[0]);
	$res = mysql_query("UPDATE dcroxx_me_posts SET hidden='1' WHERE tid='".$tid."'");
        if($res)
      {
        $res = mysql_query("UPDATE dcroxx_me_topics SET hiddenby='".getuid_sid($sid)."' WHERE id='".$tid."'");
mysql_query("INSERT INTO dcroxx_me_mlog SET action='Hide Topic', details='<b>".getnick_uid(getuid_sid($sid))."</b> Hide The Topic<b> ".htmlspecialchars($tinfo[0])."</b>', actdt='".time()."'");
   echo "<img src=\"images/ok.gif\" alt=\"O\"/>Topic Hidden successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database error";
      }
 echo "<br/><br/><a href=\"home.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

      echo "</p></card>";
}

else if($action=="showtopic")
{
  $who = isnum((int)$_GET["who"]);
  $user = getnick_uid($who);
  $tid = isnum((int)$_GET['tid']);

      echo "<card id=\"main\" title=\"Admin Tools\">";
      echo "<p align=\"center\">";
	  $tinfo = mysql_fetch_array(mysql_query("SELECT name, text, authorid, crdate, views, fid, pollid from dcroxx_me_topics WHERE id='".$tid."'"));
$tnm = htmlspecialchars($tinfo[0]);
  $res = mysql_query("UPDATE dcroxx_me_posts SET hidden='0' WHERE tid='".$tid."'");
  
        if($res)
      {
        $res = mysql_query("UPDATE dcroxx_me_topics SET hiddenby='0' WHERE id='".$tid."'");
mysql_query("INSERT INTO dcroxx_me_mlog SET action='Show Topic', details='<b>".getnick_uid(getuid_sid($sid))."</b> Show The Topic<b> ".htmlspecialchars($tinfo[0])."</b>', actdt='".time()."'");

        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Topic showed successfully";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
      }
 echo "<br/><br/><a href=\"home.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

      echo "</p></card>";
}
////////////////account disable
else if($action=="disableac")
{
  $who = $_GET['who'];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"ModCP\">"; 
  echo "<p align=\"left\"><small>";
  if(isdisabled($who)){
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>This account is already disabled";
  }else{
  echo "Disable <b>$user</b>'s account<br/></small>";

  /*echo "<input name=\"shtxt\" maxlength=\"500\" size=\"30\"/><br/>";
echo "<anchor><small>Disable</small>";
echo "<go href=\"modproc2.php?action=disableacc&amp;who=$who\" method=\"post\">
<postfield name=\"shtxt\" value=\"$(shtxt)\"/>";
echo "</go></anchor>";
echo "<small>";*/
 echo"
<form action=\"?action=disableacc&amp;who=$who\" method=\"post\">
Disable reasons:<br/></small>
<textarea id=\"inputText\" name=\"shtxt\" style=\"height:50px;width: 270px;\" ></textarea><br/>";
echo "<input id=\"inputButton\" type=\"submit\" value=\"Disable\"/></form></center><br/>";


//echo "<input name=\"shtxt\" maxlength=\"500\" size=\"30\"/><br/>";
//echo "<anchor><small>Disable</small>";
//echo "<go href=\"modproc.php?action=disableacc&amp;who=$who\" method=\"post\"><postfield name=\"shtxt\" value=\"$(shtxt)\"/>";
//echo "</go></anchor>";
echo "<small>";
  }
  echo"</small></p><p align=\"center\"><small>";
  echo "<br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"ownercp.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"\"/>President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
else if($action=="disableacc")
{
  $who = isnum((int)$_GET['who']);
  $shtxt = $_POST['shtxt'];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"ModCP\">"; 
  echo "<p align=\"center\">";
  if(isdisabled($who)){
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>This account is already disabled";
  }else{
	  $pex = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE 2x_disable_reas LIKE '".$shtxt."'"));
if($pex[0]==0)
{
/////////////
  $res = mysql_query("UPDATE dcroxx_me_users SET 2x_disabl_acc='1', 2x_disable_reas='".$shtxt."', 2x_disable_uid='".$uid."' WHERE id='".$who."'");
  if($res)
  {
    $res = mysql_query("DELETE FROM dcroxx_me_ses WHERE uid='".$who."'");
    mysql_query("INSERT INTO dcroxx_me_private SET text='[b]NOTIFICATION:[/b][br/]Your account is disabled by [b]Staff Team[/b][br/][small]p.s: this is an automated pm[/small]', byuid='3', touid='".$who."', timesent='".time()."'");
 mysql_query("INSERT INTO dcroxx_me_mlog SET action='disabled', details='<b>".getnick_uid(getuid_sid($sid))."</b> disabled the account of <b>".$user."</b>', actdt='".time()."'");
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Disabled Successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
  }
  }else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>a previous disable reason is match with you disable reason. So, please change the disable reason for this account.";
}
  }
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"ownercp.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"\"/>President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p></card>";
}
/////////////////account enable
else if($action=="enableacc")
{
  $who = isnum((int)$_GET['who']);
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"ModCP\">"; 
  echo "<p align=\"center\">";
  if(!isdisabled($who)){
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>This account is not disabled for enabling";
  }else{
  $res = mysql_query("UPDATE dcroxx_me_users SET 2x_disabl_acc='0' WHERE id='".$who."'");
  if($res)
  {
    mysql_query("INSERT INTO dcroxx_me_private SET text='[b]NOTIFICATION:[/b][br/]Your account is enabled by [b]Staff Team[/b][br/][small]p.s: this is an automated pm[/small]', byuid='3', touid='".$who."', timesent='".time()."'");
 mysql_query("INSERT INTO dcroxx_me_mlog SET action='enabled', details='<b>".getnick_uid(getuid_sid($sid))."</b> enabled the account of <b>".$user."</b>', actdt='".time()."'");
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Enabled Successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
  }
  }
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"ownercp.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"\"/>President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p></card>";
}
else
{
  echo "<card id=\"main\" title=\"Admin Tools\">";
  echo "<p align=\"center\"><small>";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}

?>

</wml>
