<?php
      session_name("PHPSESSID");
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
echo "<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";
?>
<html>
<?php
include("config.php");
include("core.php");
include("xhtmlfunctions.php");
connectdb();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
if(!ismod(getuid_sid($sid)))
  {
    echo "<card id=\"main\" title=\"$stitle\">";
      echo "<p align=\"center\">";
      echo "You are not a mod<br/>";
      echo "<br/>";
      echo "<a href=\"index.php\">Home</a>";
      echo "</p>";
      echo "</card>";
      exit();
    }
if(islogged($sid)==false)
    {
        echo "<card id=\"main\" title=\"$stitle\">";
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
      echo "</card>";
	  exit();
    }
    addonline(getuid_sid($sid),"Mod CP","");
if($action=="delp")
{
  $pid = $_GET["pid"];
  $tid = gettid_pid($pid);
  $fid = getfid_tid($tid);
 echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\">";
  $res = mysql_query("DELETE FROM dcroxx_me_posts WHERE id='".$pid."'");
  if($res)
          {
            $tname = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_topics WHERE id='".$tid."'"));
            mysql_query("INSERT INTO dcroxx_me_mlog SET action='posts', details='<b>".getnick_uid(getuid_sid($sid))."</b> Deleted Post Number $pid Of the thread ".mysql_escape_string($tname[0])." at the forum ".getfname($fid)."', actdt='".time()."'");
            
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>Post Message Deleted";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
          }
  
  echo "<br/><br/><a href=\"index.php?action=viewtpc&amp;tid=$tid&amp;page=1000\">";
echo "View Topic</a><br/>";
$fname = getfname($fid);
      echo "<a href=\"index.php?action=viewfrm&amp;fid=$fid\">";
echo "$fname</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}

////////////////////////////////////////////Edit Post
////////////////account disable
else if($action=="disableac")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Disable Account",$pstyle);
  $who = $_GET['who'];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"ModCP\">"; 
  echo "<p align=\"left\"><small>";
  if(isdisabled($who)){
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>This account is already disabled";
  }else{
  echo "Disable <b>$user</b>'s account<br/>";
  
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
  echo "<br/><a href=\"member.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"ownercp.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"\"/>President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
else if($action=="disableacc")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Disable Account",$pstyle);
  $who = $_GET['who'];
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
echo "<img src=\"images/notok.gif\" alt=\"X\"/>a previous disable reason is match with your disable reason. So, please change the disable reason for this account.";
}
  }
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  //echo "<a href=\"ownercp.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"\"/>President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p></card>";
}
/////////////////account enable
else if($action=="enableacc")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Enable Account",$pstyle);
  $who = $_GET['who'];
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
  //echo "<a href=\"ownercp.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"\"/>President Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p></card>";
}



else if($action=="gc")

{

    $pid = $_POST["pid"];
    $who = $_POST["who"];

    $who = $_POST["who"];

    $pres = $_POST["pres"];

    $pval = $_POST["pval"];

    echo "<card id=\"main\" title=\"Admin Tools\">";

  echo "<p align=\"center\"><small>";


  
  if ($who==getuid_sid($sid)){
 
      echo "You can't do this action with your own.<br/>";
      echo "<a href=\"index.php?action=main\">Home</a>";
      echo "</p>";
      echo "</card>";
  exit();
  }
  
  
  

$unick = getnick_uid($who);

$opl = mysql_fetch_array(mysql_query("SELECT golden_coin FROM dcroxx_me_users WHERE id='".$who."'"));



if($pid==0)

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

    echo "<img src=\"images/notok.gif\" alt=\"X\"/>You must Specify a reson for updating $unick's GC";

  }else{

    

    $res = mysql_query("UPDATE dcroxx_me_users SET lastplreas='".mysql_escape_string($pres)."', golden_coin='".$npl."' WHERE id='".$who."'");

    if($res)

          {

            mysql_query("INSERT INTO dcroxx_me_mlog SET action='penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> Updated <b>".$unick."</b> GC from ".$opl[0]." to $npl', actdt='".time()."'");
            $tm = time()+6*60*60;
		$uid = getuid_sid($sid);
	$nick = getnick_uid($uid);
        $user = getnick_sid($sid);
	//mysql_query("INSERT INTO dcroxx_me_plusseslogs SET res='".mysql_escape_string($pres)."', byuid='".$uid."', touid='".$who."', beforeplusses='".$opl[0]."', atmplusses='".$npl."', time='".$tm."'");
        mysql_query("INSERT INTO dcroxx_me_private SET text='[b]NOTIFICATION:[/b][br/]I have updated your GC from ".$opl[0]." to ".$npl."[br/][small]p.s: this is an automated pm[/small]', byuid='".getuid_sid($sid)."', touid='".$who."', timesent='".time()."'");

            echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick's GC Updated From $opl[0] to $npl";

          }else{

            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";

          }

  }

  

  echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}



else if($action=="edtpst")
{
  $pid = $_GET["pid"];
  $ptext = $_POST["ptext"];
  $tid = gettid_pid($pid);
  $fid = getfid_tid($tid);
 echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\">";
  $res = mysql_query("UPDATE dcroxx_me_posts SET text='".$ptext."' WHERE id='".$pid."'");
  if($res)
          {
            $tname = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_topics WHERE id='".$tid."'"));
            mysql_query("INSERT INTO dcroxx_me_mlog SET action='posts', details='<b>".getnick_uid(getuid_sid($sid))."</b> Edited Post Number $pid Of the thread ".mysql_escape_string($tname[0])." at the forum ".getfname($fid)."', actdt='".time()."'");
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>Post Message Edited";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
          }
  echo "<br/><br/>";
  echo "<a href=\"index.php?action=viewtpc&amp;tid=$tid\">";
echo "View Topic</a><br/>";
$fname = getfname($fid);
      echo "<a href=\"index.php?action=viewfrm&amp;fid=$fid\">";
echo "$fname</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}

else if($action=="delstatus")
{
  $shid = $_GET["shid"];
 echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\">";
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


  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}

else if($action=="validate")
{

$uid = getuid_sid($sid);
$who = $_GET["who"];
$user = getnick_uid($who);
echo "<card id=\"main\" title=\"modTools\">";
echo "<p align=\"center\">";
$res = mysql_query("Update dcroxx_me_users SET validated='1' WHERE id='".$who."'");
if($res)
{
mysql_query("INSERT INTO dcroxx_me_mlog SET action='validation', details='<b>".getnick_uid(getuid_sid($sid))."</b> validated $user', actdt='".time()."'");


 $ug = mysql_fetch_array(mysql_query("SELECT battlep FROM dcroxx_me_users WHERE id='".$uid."'"));
  $ugp = $ug[0] + 2;
  mysql_query("UPDATE dcroxx_me_users SET battlep='".$ugp."' WHERE id='".$uid."'");

echo "<img src=\"../images/ok.gif\" alt=\"O\"/>$user validated successfully";
 
}else{
echo "<img src=\"../images/notok.gif\" alt=\"X\"/>Error validating $user";
}
echo "<br/>Plz Now Send a Pm to $user asking if  $user needs any help from u..";
echo "<br/><br/><a href=\"inbox.php?action=sendpm&amp;who=$who\">Send a Pm to $user</a><br/>";
echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
//echo "<a href=\"admincp.php?action=admincp\"><img src=\"../images/admn.gif\" alt=\"\"/>admin Tools</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
echo "</p>";
echo "</card>";
}

else if($action=="quiz")

{

  $qtitle = $_POST["qtitle"];
  $qby = $_POST["qby"];
  $qdes = $_POST["qdes"];
  $qstatus = $_POST["qstatus"];
  $qtid = $_POST["qtid"];
  $uid = getuid_sid($sid);
 echo "<card id=\"main\" title=\"Admin Tools\">";
  echo "<p align=\"center\"><small>";

  //  if(trim($pres)==""){
	      $count = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_quizc WHERE qtid='".$qtid."'"));
    if($count[0]>0){
		  echo "<img src=\"images/notok.gif\" alt=\"X\"/>This is already on our quiz database.";
	}else{
	if((empty($qtitle))&&(empty($qby))&&(empty($qdes))&&(empty($qtid))){
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>All fields are required to fill up.";
  }else{
	  
$res = mysql_query("INSERT INTO ibwfrr_quizc SET qtitle='".$qtitle."', qby='".$qby."', qdes='".$qdes."', qstatus='".$qstatus."', qtid='".$qtid."',  who='".$uid."', time='".time()."'");

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

  $qid = $_POST["qid"];
  $qrp = $_POST["qrp"];
  $qpls = $_POST["qpls"];
  $qwid = $_POST["qwid"];
  $qnm = $_POST["qnm"];
  $qp = $_POST["qp"];
  $uid = getuid_sid($sid);
 echo "<card id=\"main\" title=\"Admin Tools\">";
  echo "<p align=\"center\"><small>";

  //  if(trim($pres)==""){

	if((empty($qid))&&(empty($qwid))&&(empty($qnm))&&(empty($qp))){
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>All fields are required to fill up.";
  }else{
	  
$res = mysql_query("INSERT INTO ibwfrr_quizw SET qid='".$qid."', qrp='".$qrp."', qpls='".$qpls."', qwid='".$qwid."',
 qnm='".$qnm."', qp='".$qp."', who='".$uid."', time='".time()."'");

  if($res){
echo "<img src=\"images/ok.gif\" alt=\"O\"/>Quiz winner added successfully and waiting for Admins approval";

	$nick = getnick_uid($qwid);
mysql_query("INSERT INTO dcroxx_me_private SET text='[u]Approval Needs:[/u][br/]".$nick." will get ".$qrp." rp/".$qpls." plusses for  ".$qp." level winner of ".$qnm." quiz/contest if you approve now from [url=lists.php?action=rp]Quiz/Contests[/url] Menu', byuid='3', touid='1', timesent='".time()."'");
mysql_query("INSERT INTO dcroxx_me_private SET text='[u]Approval Needs:[/u][br/]".$nick." will get ".$qrp." rp/".$qpls." plusses for  ".$qp." level winner of ".$qnm." quiz/contest if you approve now from [url=lists.php?action=rp]Quiz/Contests[/url] Menu', byuid='3', touid='2', timesent='".time()."'");

}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
}
	}

  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}
else if($action=="editquiz")

{
  $id = $_GET["id"];
  $qtitle = $_POST["qtitle"];
  $qby = $_POST["qby"];
  $qdes = $_POST["qdes"];
  $qstatus = $_POST["qstatus"];
  $qtid = $_POST["qtid"];
  $uid = getuid_sid($sid);
 echo "<card id=\"main\" title=\"Admin Tools\">";
  echo "<p align=\"center\"><small>";

  //  if(trim($pres)==""){
	if((empty($qtitle))&&(empty($qby))&&(empty($qdes))){
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>All fields are required to fill up.";
  }else{
	  
$res = mysql_query("UPDATE ibwfrr_quizc SET qtitle='".$qtitle."', qby='".$qby."', qdes='".$qdes."',
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

else if($action=="delquiz")
{
  $id = $_GET["id"];
  echo "<card id=\"main\" title=\"Admin Tools\">";
  echo "<p align=\"center\"><small>";
  $res = mysql_query("DELETE FROM ibwfrr_quizc WHERE id='".$id."'");
  if($res)
  {
    mysql_query("INSERT INTO dcroxx_me_mlog SET action='Quiz', details='<b>".getnick_uid(getuid_sid($sid))."</b> deleted a quiz topic. QuizID: <b>".$id."</b>', actdt='".time()."'");
    echo "<img src=\"images/ok.gif\" alt=\"O\"/><b>Quiz deleted successfully</b><br/>";
  }
  else
  {
    echo "<img src=\"images/notok.gif\" alt=\"X\"/><b>Database Error</b><br/>";
  }
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}

////////////////////////////////////////////Edit Post

else if($action=="edttpc")
{
  $tid = $_GET["tid"];
  $ttext = $_POST["ttext"];
  $fid = getfid_tid($tid);
 echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\">";
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
  echo "<a href=\"index.php?action=viewtpc&amp;tid=$tid\">";
echo "View Topic</a><br/>";
$fname = getfname($fid);
      echo "<a href=\"index.php?action=viewfrm&amp;fid=$fid\">";
echo "$fname</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}


if($action=="mbrl")
{
    addonline(getuid_sid($sid),"Members search by IP","");
    echo "<card id=\"main\" title=\"Search\">";
    echo "<p>";
	echo "Some ppl change their browser and do naughty things in $stitle. but their IP is same. just pick up their Ips n paste here n get the result<br/>";
    echo "Suspectors IP: <input name=\"stext\" maxlength=\"15\"/><br/>";
    echo "Order: <select name=\"sor\">";
    echo "<option value=\"1\">name(A-Z)</option>";
    echo "<option value=\"2\">Last Active</option>";
    echo "<option value=\"3\">Join Date</option>";
    echo "</select><br/>";
    echo "<anchor>Find It";
    echo "<go href=\"mprocpl.php?action=smbr\" method=\"post\">";
    echo "<postfield name=\"stext\" value=\"$(stext)\"/>";
    echo "<postfield name=\"sin\" value=\"2\"/>";
    echo "<postfield name=\"sor\" value=\"$(sor)\"/>";
    echo "</go></anchor>";
    echo "</p>";
  echo "<p align=\"center\">";
  //echo "<a href=\"index.php?action=search\"><img src=\"images/search.gif\" alt=\"*\"/>";
//echo "Search Menu</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}
else if($action=="smbr")
{
	$stext = $_POST["stext"];
  $sin = $_POST["sin"];
  $sor = $_POST["sor"];
    addonline(getuid_sid($sid),"Member search","");
    echo "<card id=\"main\" title=\"Search\">";
    echo "<p>";

    
        if(trim($stext)=="")
        {
            echo "<br/>Failed to search for Members";
        }else{
          //begin search
          if($page=="" || $page<1)$page=1;
          
            $where_table = "dcroxx_me_users";
			if($sin=="1")
            $cond = "name";
			else if($sin=="2")
			$cond = "ipadd";
            $select_fields = "id, name";
            if($sor=="1")
            {
				if($sin=="1")
              $ord_fields = "name";
			  else if($sin=="2")
			  $ord_fields = "ipadd";
            }else if($sor=="2"){
                $ord_fields = "lastact DESC";
            }else if($sor=="3"){
                $ord_fields = "regdate";
            }
     
          $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ".$where_table." WHERE ".$cond." LIKE '%".$stext."%'"));
		  
          $num_items = $noi[0];
          $items_per_page = 10;
          $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    $sql = "SELECT ".$select_fields." FROM ".$where_table." WHERE ".$cond." LIKE '%".$stext."%' ORDER BY ".$ord_fields." LIMIT $limit_start, $items_per_page";
          $items = mysql_query($sql);
          while($item=mysql_fetch_array($items))
          {
              $tlink = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">".htmlspecialchars($item[1])."</a><br/>";

                echo  $tlink;

          }
          echo "<p align=\"center\">";
		  if($page>1)
    {
      $ppage = $page-1;
      $rets = "<anchor>&#171;PREV";
        $rets .= "<go href=\"mprocpl.php?action=$action&amp;page=$ppage\" method=\"post\">";
        $rets .= "<postfield name=\"stext\" value=\"$stext\"/>";
        $rets .= "<postfield name=\"sin\" value=\"$sin\"/>";
        $rets .= "<postfield name=\"sor\" value=\"$sor\"/>";
        $rets .= "</go></anchor> ";

        echo $rets;
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      $rets = "<anchor>Next&#187;";
        $rets .= "<go href=\"mprocpl.php?action=$action&amp;page=$npage\" method=\"post\">";
        $rets .= "<postfield name=\"stext\" value=\"$stext\"/>";
        $rets .= "<postfield name=\"sin\" value=\"$sin\"/>";
        $rets .= "<postfield name=\"sor\" value=\"$sor\"/>";
        $rets .= "</go></anchor> ";

        echo $rets;
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page: <input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"mprocpl.php?action=$action&amp;page=$(pg)\" method=\"post\">";
        $rets .= "<postfield name=\"stext\" value=\"$stext\"/>";
        $rets .= "<postfield name=\"sin\" value=\"$sin\"/>";
        $rets .= "<postfield name=\"sor\" value=\"$sor\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
        }
    
echo "</p>";
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=search\"><img src=\"images/search.gif\" alt=\"*\"/>";
echo "Search Menu</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}




if($action=="4n")
{
    addonline(getuid_sid($sid),"Members search by 4n model","");
    echo "<card id=\"main\" title=\"Search\">";
    echo "<p>";
	echo "Some ppl change their browser and do naughty things in $stitle. but u can type the browser name and get all the users who in u typed browser name<br/>";
  
echo"<form action=\"mprocpl.php?action=4n2\" method=\"post\">
Suspectors browser: <input name=\"stext\" maxlength=\"15\"/><br/>";
   echo "Select Order: <select name=\"sor\">";
    echo "<option value=\"1\">name(A-Z)</option>";
    echo "<option value=\"2\">Last Active</option>";
    echo "<option value=\"3\">Join Date</option>";
    echo "</select><br/>";
	
echo"<input type=\"submit\" name=\"Submit\" value=\"Find It\"/><br/>
</form></center>";

 /* echo "Suspectors browser: <input name=\"stext\" maxlength=\"15\"/><br/>";
    echo "Select Order: <select name=\"sor\">";
    echo "<option value=\"1\">name(A-Z)</option>";
    echo "<option value=\"2\">Last Active</option>";
    echo "<option value=\"3\">Join Date</option>";
    echo "</select><br/>";
    echo "<anchor>Find It";
    echo "<go href=\"mprocpl.php?action=4n2\" method=\"post\">";
    echo "<postfield name=\"stext\" value=\"$(stext)\"/>";
    echo "<postfield name=\"sin\" value=\"2\"/>";
    echo "<postfield name=\"sor\" value=\"$(sor)\"/>";
    echo "</go></anchor>";*/
    echo "</p>";
  echo "<p align=\"center\">";
  //echo "<a href=\"index.php?action=search\"><img src=\"images/search.gif\" alt=\"*\"/>";
//echo "Search Menu</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}
else if($action=="4n2")
{
	$stext = $_POST["stext"];
  $sin = $_POST["sin"];
  $sor = $_POST["sor"];
    addonline(getuid_sid($sid),"Member search by 4n model","");
    echo "<card id=\"main\" title=\"Search\">";
    echo "<p>";

    
        if(trim($stext)=="")
        {
            echo "<br/>Failed to search for Members";
        }else{
          //begin search
          if($page=="" || $page<1)$page=1;
          
            $where_table = "dcroxx_me_users";
			if($sin=="1")
            $cond = "name";
			else if($sin=="2")
			$cond = "omphone";
            $select_fields = "id, name";
            if($sor=="1")
            {
				if($sin=="1")
              $ord_fields = "name";
			  else if($sin=="2")
			  $ord_fields = "omphone";
            }else if($sor=="2"){
                $ord_fields = "lastact DESC";
            }else if($sor=="3"){
                $ord_fields = "regdate";
            }
     
          $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ".$where_table." WHERE ".$cond." LIKE '%".$stext."%'"));
		  
          $num_items = $noi[0];
          $items_per_page = 10;
          $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    $sql = "SELECT ".$select_fields." FROM ".$where_table." WHERE ".$cond." LIKE '%".$stext."%' ORDER BY ".$ord_fields." LIMIT $limit_start, $items_per_page";
          $items = mysql_query($sql);
          while($item=mysql_fetch_array($items))
          {
              $tlink = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">".htmlspecialchars($item[1])."</a><br/>";

                echo  $tlink;

          }
          echo "<p align=\"center\">";
		  if($page>1)
    {
      $ppage = $page-1;
      $rets = "<anchor>&#171;PREV";
        $rets .= "<go href=\"mprocpl.php?action=$action&amp;page=$ppage\" method=\"post\">";
        $rets .= "<postfield name=\"stext\" value=\"$stext\"/>";
        $rets .= "<postfield name=\"sin\" value=\"$sin\"/>";
        $rets .= "<postfield name=\"sor\" value=\"$sor\"/>";
        $rets .= "</go></anchor> ";

        echo $rets;
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      $rets = "<anchor>Next&#187;";
        $rets .= "<go href=\"mprocpl.php?action=$action&amp;page=$npage\" method=\"post\">";
        $rets .= "<postfield name=\"stext\" value=\"$stext\"/>";
        $rets .= "<postfield name=\"sin\" value=\"$sin\"/>";
        $rets .= "<postfield name=\"sor\" value=\"$sor\"/>";
        $rets .= "</go></anchor> ";

        echo $rets;
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page: <input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"mprocpl.php?action=$action&amp;page=$(pg)\" method=\"post\">";
        $rets .= "<postfield name=\"stext\" value=\"$stext\"/>";
        $rets .= "<postfield name=\"sin\" value=\"$sin\"/>";
        $rets .= "<postfield name=\"sor\" value=\"$sor\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
        }
    
echo "</p>";
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=search\"><img src=\"images/search.gif\" alt=\"*\"/>";
echo "Search Menu</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}
///////////////////////////////////////Close/ Open Topic

else if($action=="clot")
{
  $tid = $_GET["tid"];
  $tdo = $_GET["tdo"];
  $fid = getfid_tid($tid);
 echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\">";
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
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}

///////////////////////////////////////Untrash user

else if($action=="untr")
{
  $who = $_GET["who"];
 echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\">";
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


  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}

///////////////////////////////////////Unban user

else if($action=="unbanonley")
{
  $who = $_GET["who"];
 echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\">";
  $res = mysql_query("DELETE FROM dcroxx_me_metpenaltiespl WHERE (penalty='1' OR penalty='2') AND uid='".$who."'");
  if($res)
          {
            $unick = getnick_uid($who);
            mysql_query("INSERT INTO dcroxx_me_mlog SET action='penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> Unbanned The user <b>".$unick."</b>', actdt='".time()."'");
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick Unbanned";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
          }
  echo "<br/><br/>";


  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}

///////////////////////////////////////Delete shout

else if($action=="delsh")
{
  $shid = $_GET["shid"];
 echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\">";
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
  echo "<br/><br/>";


  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}


///////////////////////////////////////Unban user

else if($action=="shld")
{
  $who = $_GET["who"];
 echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\">";
  $res = mysql_query("Update dcroxx_me_users SET shield='1' WHERE id='".$who."'");
  if($res)
          {
            $unick = getnick_uid($who);
            mysql_query("INSERT INTO dcroxx_me_mlog SET action='penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> Shielded The user <b>".$unick."</b>', actdt='".time()."'");
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick is Shielded";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
          }
  echo "<br/><br/>";


  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}

///////////////////////////////////////Unban user

else if($action=="ushld")
{
  $who = $_GET["who"];
 echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\">";
  $res = mysql_query("Update dcroxx_me_users SET shield='0' WHERE id='".$who."'");
  if($res)
          {
            $unick = getnick_uid($who);
            mysql_query("INSERT INTO dcroxx_me_mlog SET action='penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> Unshielded The user <b>".$unick."</b>', actdt='".time()."'");
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick is Unshielded";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
          }
  echo "<br/><br/>";


  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}

///////////////////////////////////////Pin/ Unpin Topic

else if($action=="pint")
{
  $tid = $_GET["tid"];
  $tdo = $_GET["tdo"];
  $fid = getfid_tid($tid);
 echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\">";
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
      echo "<a href=\"index.php?action=viewfrm&amp;fid=$fid\">";
echo "$fname</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}

///////////////////////////////////Delete the damn thing

else if($action=="delt")
{
  $tid = $_GET["tid"];
  $fid = getfid_tid($tid);
 echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\">";
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
      echo "<a href=\"index.php?action=viewfrm&amp;fid=$fid\">";
echo "$fname</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}


////////////////////////////////////////////Edit Post

else if($action=="rentpc")
{
  $tid = $_GET["tid"];
  $tname = $_POST["tname"];
  $fid = getfid_tid($tid);
 echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\">";
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
  echo "<a href=\"index.php?action=viewtpc&amp;tid=$tid\">";
echo "View Topic</a><br/>";
$fname = getfname($fid);
      echo "<a href=\"index.php?action=viewfrm&amp;fid=$fid\">";
echo "$fname</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}

///////////////////////////////////////////////////Move topic



else if($action=="mvt")
{
  $tid = $_GET["tid"];
  $mtf = $_POST["mtf"];
  $fname = htmlspecialchars(getfname($mtf));
  //$fid = getfid_tid($tid);
 echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\">";
  
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
  

      echo "<a href=\"index.php?action=viewfrm&amp;fid=$mtf\">";
echo "$fname</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}

//////////////////////////////////////////Handle PM

else if($action=="hpm")
{
  $pid = $_GET["pid"];
  
 echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\">";

    $info = mysql_fetch_array(mysql_query("SELECT byuid, touid FROM dcroxx_me_private WHERE id='".$pid."'"));
  $res = mysql_query("UPDATE dcroxx_me_private SET reported='2' WHERE id='".$pid."'");
  if($res)
          {
            mysql_query("INSERT INTO dcroxx_me_mlog SET action='handling', details='<b>".getnick_uid(getuid_sid($sid))."</b> handled The PM ".$pid."', actdt='".time()."'");
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>PM Handled";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
          }



  echo "<br/><br/>";
    
    echo "<a href=\"index.php?action=viewuser&amp;who=$info[0]\">PM Sender's Profile</a><br/>";
      echo "<a href=\"index.php?action=viewuser&amp;who=$info[1]\">PM Reporter's Profile</a><br/><br/>";
      echo "<a href=\"modcp.php?action=main\">";
echo "Mod R/L</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}

//////////////////////////////////////////Handle Post

else if($action=="hps")
{
  $pid = $_GET["pid"];

 echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\">";

    $info = mysql_fetch_array(mysql_query("SELECT uid, tid FROM dcroxx_me_posts WHERE id='".$pid."'"));
  $res = mysql_query("UPDATE dcroxx_me_posts SET reported='2' WHERE id='".$pid."'");
  if($res)
          {
            mysql_query("INSERT INTO dcroxx_me_mlog SET action='handling', details='<b>".getnick_uid(getuid_sid($sid))."</b> handled The Post ".$pid."', actdt='".time()."'");
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>Post Handled";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
          }



  echo "<br/><br/>";
    $poster = getnick_uid($info[0]);
    echo "<a href=\"index.php?action=viewuser&amp;who=$info[0]\">$poster's Profile</a><br/>";
      echo "<a href=\"index.php?action=viewtpc&amp;tid=$info[1]\">View Topic</a><br/><br/>";
      echo "<a href=\"modcp.php?action=main\">";
echo "Mod R/L</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}

//////////////////////////////////////////Handle Topic

else if($action=="htp")
{
  $pid = $_GET["tid"];

 echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\">";

    $info = mysql_fetch_array(mysql_query("SELECT authorid FROM dcroxx_me_topics WHERE id='".$pid."'"));
  $res = mysql_query("UPDATE dcroxx_me_topics SET reported='2' WHERE id='".$pid."'");
  if($res)
          {
            mysql_query("INSERT INTO dcroxx_me_mlog SET action='handling', details='<b>".getnick_uid(getuid_sid($sid))."</b> handled The topic ".mysql_escape_string(gettname($pid))."', actdt='".time()."'");
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>Topic Handled";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
          }



  echo "<br/><br/>";
    $poster = getnick_uid($info[0]);
    echo "<a href=\"index.php?action=viewuser&amp;who=$info[0]\">$poster's Profile</a><br/>";
      echo "<a href=\"index.php?action=viewtpc&amp;tid=$pid\">View Topic</a><br/><br/>";
      echo "<a href=\"modcp.php?action=main\">";
echo "Mod R/L</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}

////////////////////////////////////////Punish

else if($action=="pun1")
{
    $pid = $_POST["pid"];
    $who = $_POST["who"];
    $pres = $_POST["pres"];
    $pds = $_POST["pds"];
    $phr = $_POST["phr"];
    $pmn = $_POST["pmn"];
    $psc = $_POST["psc"];
    echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\">";
  
  $uip = "";
  $ubr = "";
  $pmsg[0]="Trashed";
  $pmsg[1]="Banned";
  $pmsg[2]="IP-Banned";
  if($pid=='2')
  {
    //ip ban
    $uip = getip_uid($who);
    $ubr = getbr_uid($who);
  }
  if(trim($pres)=="")
  {
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>You must Specify a reson for punishing the user";
  }else{
    $timeto = $pds*24*60*60;
    $timeto += $phr*60*60;
    $timeto += $pmn*60;
    $timeto += $psc;
    $ptime = $timeto + time();
    $unick = getnick_uid($who);
    $res = mysql_query("INSERT INTO dcroxx_me_metpenaltiespl SET uid='".$who."', penalty='".$pid."', exid='".getuid_sid($sid)."', timeto='".$ptime."', pnreas='".mysql_escape_string($pres)."', ipadd='".$uip."', browserm='".$ubr."'");
    if($res)
          {
            mysql_query("UPDATE dcroxx_me_users SET lastpnreas='".$pmsg[$pid].": ".mysql_escape_string($pres)."' WHERE id='".$who."'");
            mysql_query("INSERT INTO dcroxx_me_mlog SET action='penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> $pmsg[$pid] The user <b>".$unick."</b> For ".$timeto." Seconds', actdt='".time()."'");
            
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick is $pmsg[$pid] for $timeto Seconds";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
          }
  }
    echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}

////////////////////////////////////////Punish

else if($action=="pls")
{
    $pid = $_POST["pid"];
    $who = $_POST["who"];
    $pres = $_POST["pres"];
    $pval = $_POST["pval"];
    echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\">";

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
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick's Plusses Updated From $opl[0] to $npl";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
          }
  }
    echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}



////////////////////////////////////////Punish

else if($action=="bnk")
{
    $pid = $_POST["pid"];
    $who = $_POST["who"];
    $pres = $_POST["pres"];
    $pval = $_POST["pval"];
    echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\">";

$unick = getnick_uid($who);
$opl = mysql_fetch_array(mysql_query("SELECT arabank FROM dcroxx_me_users WHERE id='".$who."'"));

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
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>You must Specify a reson for updating $unick's Bank credits";
  }else{
    
    $res = mysql_query("UPDATE dcroxx_me_users SET lastplreas='".mysql_escape_string($pres)."', arabank='".$npl."' WHERE id='".$who."'");
    if($res)
          {
            mysql_query("INSERT INTO dcroxx_me_mlog SET action='penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> Updated <b>".$unick."</b> bank credits from ".$opl[0]." to $npl', actdt='".time()."'");
            echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick's bank credits Updated From $opl[0] to $npl";
          }else{
            echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
          }
  }
    echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}
/*else{
    echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\">";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}*/
?></html>
