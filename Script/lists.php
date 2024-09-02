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
if($action=="quizlist")
{
 $pstyle = gettheme($sid);
      echo xhtmlhead("Quiz List",$pstyle);
$judg = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_judges WHERE uid='".getuid_sid($sid)."'"));
   if(isadmin(getuid_sid($sid))||$judg[0]>0)
   {



    //////ALL LISTS SCRIPT <<
    $who = $_GET["who"];

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_quiz"));
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, question, answer FROM dcroxx_me_quiz ORDER BY id LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);

    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {


      echo "Question: $item[1]<br/>Answer: $item[2] <a href=\"genproc.php?action=delquiz&amp;id=$item[0]\">[x]</a><br/>---<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
        $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
        $rets .= "</form>";


        echo $rets;
    }
    echo "</p>";

  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
}else{
    echo "Not authorized";
  }
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo "</body>";
    exit();
    }
/////////////////////////////////////smooch
else if($action=="comments2")
{
    $who = $_GET["who"];
$gid = $_GET["gid"];
    $whonick = getnick_uid($who);
 addonline(getuid_sid($sid),"Viewing Photo Comments of $whonick","lists.php?action=$action&amp;who=$who&amp;gid=$gid");
    addplace(getuid_sid($sid),"lists.php?action=$action&amp;who=$who&amp;gid=$gid","");
 echo "<title>Photo Comments</title>";
    $uid = getuid_sid($sid);

    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_galcom WHERE pid='".$gid."'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;


       $sql = "SELECT id, pid, text, byuser, time FROM dcroxx_me_galcom WHERE pid='".$gid."' ORDER BY id DESC LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {

          if(isonline($item[3]))
  {
    $iml = "<img src=\"images/onl.gif\" alt=\"+\"/>";

  }else{
    $iml = "<img src=\"images/ofl.gif\" alt=\"-\"/>";
  }
    $snick = getnick_uid($item[3]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[3]\">$iml$snick</a>:";
      $bs = date("d m y-H:i:s",$item[4]);
      echo "$lnk<br/><small>";

$me = getuid_sid($sid);
if($who=="$me") {
$can = "a";
}else{
$can = "b";
}
  if(ismod($uid)||$can=="a")
  {
   $delnk = "<a href=\"genproc.php?action=delcmt&amp;id=$item[0]\">[x]</a>";
      }else{
        $delnk = "";
      }
      $text = parsepm($item[2], $sid);
      echo "$text $delnk<br/>";
echo "$bs";
echo "<br/>";
      echo "</small>";

    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;who=$who&amp;gid=$gid\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;who=$who&amp;gid=$gid\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {

        $rets .= "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
   $me = getuid_sid($sid);
if($me!="$who") {
    echo "<a href=\"index.php?action=addcom&amp;who=$who&amp;gid=$gid\">Add Comment</a><br/>";
}

echo "<a href=\"index.php?action=usergal\">User Gallery</a><br/>";
    echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
  echo "</p>";

}


else if($action=="quiz")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Quiz/Contest",$pstyle);
    addonline((getuid_sid($sid)),"Viewing Quiz/Contests","lists.php?action=$action");
    echo "<card id=\"main\" title=\"Quiz/Contest\">";
   /* echo "<p align=\"center\"><small>";
    echo "<b>Quiz/Contest</b>";
    echo "</small></p>";*/
    //////ALL LISTS SCRIPT <<
    $rqc = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_quizc"));
    if($page=="" || $page<=0)$page=1;
    $num_items = $rqc[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql


        $sql = "SELECT id, qtitle, qby, qdes, qstatus, qtid,  who, time FROM ibwfrr_quizc ORDER BY qstatus='o' AND time DESC LIMIT $limit_start, $items_per_page";


    echo "<p><small>";
	if(ismod(isnum((int)getuid_sid($sid)))){
	echo "<b><a href=\"mcppl.php?action=adq\">Add New Quiz</a> [Staffs Only]</b><br/><br/>";
    }else{}
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
   //  $tpc = mysql_fetch_array(mysql_query("SELECT name, authorid, closed FROM dcroxx_me_topics WHERE id='".$item[1]."'"));
      $nick = getnick_uid($item[2]);
      if($item[4]=="o")
      {
        $op = "Open";
      }else{
        $op = "Closed";
      }
	  
	      if(ismod(isnum((int)getuid_sid($sid))))
      {
	$del = "<a href=\"mcppl.php?action=editquiz&amp;id=$item[0]\">[Edit]</a>
	<a href=\"mprocpl.php?action=delquiz&amp;id=$item[0]\">[Delete]</a>";
      }  
	  
     $remain = time() - $item[7];
     $idle = gettimemsg($remain);

if($item[4]=="o"){
      $lnk = "<div class=\"mblock1\"><b>($item[0])</b> Quiz: <a href=\"index.php?action=viewtpc&amp;tid=$item[5]\"><b>$item[1]</b></a> By <b>$item[2]</b><br/>
	  Short Description: <b>$item[3]</b><br/>Status: <b>$op</b><br/>Last Update: <b>$idle ago</b> $del<br/><br/></div>";
}else{
      $lnk = "<br/><b>($item[0])</b> Quiz: <a href=\"index.php?action=viewtpc&amp;tid=$item[5]\"><b>$item[1]</b></a> By <b>$item[2]</b><br/>
	  Short Description: <b>$item[3]</b><br/>Status: <b>$op</b><br/>Last Update: <b>$idle ago</b> $del<br/>";
}


      echo "$lnk";
    }
    }
    echo "</small></p>";
    echo "<p align=\"center\"><small>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
   /* if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"lists.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor><br/>";

        echo $rets;
    }*/
    echo "</small></p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\"><small>";
    if(ismod(getuid_sid($sid))){
	echo "<a href=\"attach.php?action=attach\"><b>#Attach A Photo#</b></a><br/><br/>";
    }
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</small></p>";
    echo "</card>";
}

else if($action=="rp")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Quiz/Contest",$pstyle);
    addonline(isnum((int)getuid_sid($sid)),"Quiz Winners List","");
    echo "<card id=\"main\" title=\"Quiz/Contest Winners\">";
    echo "<p align=\"left\"><small>";
	if(ismod(getuid_sid($sid))){
	echo "<b><a href=\"mcppl.php?action=adqw\">Add Owner of a Quiz</a> [Staffs Only]</b><br/><br/>";
    }else{}
    echo "</small></p>";
    $do = isnum((int)$_GET["do"]);
    if($do>0){
	if(!isowner(getuid_sid($sid))){
	    echo "<b>x</b> PERMISSION DENIED <b>x</b><br/>";
	}else{
	    $res= mysql_query("DELETE FROM ibwfrr_quizw WHERE id='".isnum((int)$_GET["wid"])."'");
	    if($res){
		echo "<img src=\"images/ok.gif\" alt=\"o\" />Deleted successfully<br/>";
	    }else{
		echo "<b>Delete Error</b><br/>";
	    }
	}
    }
    //////ALL LISTS SCRIPT <<
    $quizw = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_quizw"));
    if($page=="" || $page<=0)$page=1;
    $num_items = $quizw[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql


        $sql = "SELECT id, qid, qrp, qpls, qwid, qnm, qp, who, time, app FROM ibwfrr_quizw ORDER BY time DESC LIMIT $limit_start, $items_per_page";


    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $nick = getnick_uid($item[4]);
      $bynick = getnick_uid($item[1]);
      $lnk1 = "&#187;$bynick: <b>$item[2]</b> reputation points/<b>$item[3]</b> plusses has been added to <b>$nick's</b> account<br/>";
      if($item[9]>0){
        $status = "Completed";
      }else{
        $status = "Pending";
      }
      if(isowner(getuid_sid($sid)) && $item[9]==0)
      {
        $update = "<a href=\"ownerproc.php?action=qrps&amp;wid=$item[0]\">[&#187;&#187;]</a>";
      }
      else
      {
        $update = "";
      }
      if(isowner(getuid_sid($sid))){
	$del2 = " | <a href=\"lists.php?action=$action&amp;wid=$item[0]&amp;do=1\">(X)</a>";
      }else{
	$del2 = "";
      }
      $lnk2 = "Quiz/Contest Name: <b>$item[5]</b><br/>
	  Position: <b>$item[6]</b><br/>
	  Authorization: <b>$status</b> $update$del2<br/>";
      $remain = time() - $item[8];
      $idle = gettimemsg($remain);
      $lnk3 = "Time: ".date("l, dS F Y - h:i:s a", $item[8])." <b>($idle ago)</b><br/>";
      echo "$lnk1$lnk2$lnk3<br/>";
    }
    }
    echo "</small></p>";
    echo "<p align=\"center\"><small>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
  /*  if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"lists.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor><br/>";

        echo $rets;
    }*/
    echo "</small></p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\"><small>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</small></p>";
    echo "</card>";
}
/////////////////////////////////////SocialBD.NeTos
else if($action=="boys")
{
      addonline(getuid_sid($sid),"Viewing Boys Gallery","lists.php?action=$action");
      addplace(getuid_sid($sid),"lists.php?action=$action","lists.php?action=$action");

    $uid = getuid_sid($sid);



    //////ALL gallery SCRIPT <<

    if($page=="" || $page<=0)$page=1;


    if($who!="")
    {
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT uid) FROM dcroxx_me_gallery3 WHERE sex='M'"));
    }else{
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT uid) FROM dcroxx_me_gallery3 WHERE sex='M'"));
    }

    $num_items = $noi[0]; //changable
    $items_per_page= 8;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

$sql = "SELECT DISTINCT uid FROM dcroxx_me_gallery3 WHERE sex='M' ORDER BY uid ASC LIMIT $limit_start, $items_per_page";

 echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();

    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
$who = $item[0];
$user=getnick_uid($who);

$countpics = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM dcroxx_me_gallery3 WHERE uid='".$who."'"));
        $lnk = "<a href=\"lists.php?action=viewuser&amp;who=$who\">$user($countpics[0])</a><br/>";
       echo "$lnk";
   }
    }else{
echo "Boys gallery is empty";
}
    echo "</small></p>";
echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
   if($num_pages>2)
    {
        $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
        $rets .= "</form>";


        echo $rets;
    }
   $unreadinbox=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE unread='1' AND touid='".$uid."'"));
        $pmtotl=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE touid='".$uid."'"));
        $unrd="".$unreadinbox[0]."";
        if ($unreadinbox[0]>0)
        {
        echo "<a href=\"inbox.php?action=main&amp;type=send\">$unrd new pm</a>";
      }
echo "<br/><a href=\"index.php?action=pkgal\">User Gallery</a><br/>";
echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
    echo "</p>";

    echo "</body>";

}
/////////////////////////////////////SocialBD.NeTas
else if($action=="girls")
{
     addonline(getuid_sid($sid),"Viewing Girls Gallery","lists.php?action=$action");
     addplace(getuid_sid($sid),"lists.php?action=$action","lists.php?action=$action");

    $uid = getuid_sid($sid);


    //////ALL gallery SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    if($who!="")
    {
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT uid) FROM dcroxx_me_gallery3 WHERE sex='F'"));
    }else{
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT uid) FROM dcroxx_me_gallery3 WHERE sex='F'"));
    }

    $num_items = $noi[0]; //changable
    $items_per_page= 8;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

$sql = "SELECT DISTINCT uid FROM dcroxx_me_gallery3 WHERE sex='F' ORDER BY uid ASC LIMIT $limit_start, $items_per_page";

 echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
$who = $item[0];
$user=getnick_uid($who);
$countpics = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM dcroxx_me_gallery3 WHERE uid='".$who."'"));
        $lnk = "<a href=\"lists.php?action=viewuser&amp;who=$who\">$user($countpics[0])</a><br/>";

 echo "$lnk";

    }
    }else{
echo "Girls gallery is empty";
}
    echo "</small></p>";
echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
     if($num_pages>2)
    {
        $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
        $rets .= "</form>";


        echo $rets;
    }
   $unreadinbox=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE unread='1' AND touid='".$uid."'"));
        $pmtotl=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE touid='".$uid."'"));
        $unrd="".$unreadinbox[0]."";
        if ($unreadinbox[0]>0)
        {
        echo "<a href=\"inbox.php?action=main&amp;type=send\">$unrd New MSG</a>";
      }
echo "<br/><a href=\"index.php?action=pkgal\">Users Gallery</a><br/>";
echo "<a href=\"index.php?action=main\">";
echo "Main</a>";
    echo "</p>";

    echo "</body>";
}
/////////////////////////////////Profile Moods

else if($action=="pmoods")
{
 $pstyle = gettheme($sid);
      echo xhtmlhead("Profile Moods",$pstyle);
    addonline(getuid_sid($sid),"Viwing The Profile Moods List","");
  echo "<head><title>$site_name</title>";
      
      echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
      <meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
      <meta name=\"description\" content=\"Riderz wap dating portal and community containg chat, forums, blogs and much more\" />
      <meta name=\"keywords\" content=\"chat, forums, wap, dating, games, blogs, polls, quiz, lavalair, news, rap, goth\" /></head>";

      echo "<body>";

    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_profilemood"));
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, pmoodlink FROM dcroxx_me_profilemood ORDER BY id DESC LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
   {
        echo "<img src=\"$item[1]\" width=\"119\" height=\"30\" alt=\"Profile Moods\"/><br/>";
        echo "<a href=\"genproc.php?action=uppmoods&pmoodid=$item[0]\">SELECT</a><br/>";
        echo "<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=pmoods&page=$ppage&view=$view\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=pmoods&page=$npage&view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
        $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "<input name=\"page\" style=\"-wap-input-format: '*N'\" size=\"2\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"submit\" value=\"Go To Page\"/>";
        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=cpanel\">Settings</a><br/>";
  echo "<b>0 </b><a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p>";
    echo "</body>";

}
/////////////////////////////////////////////////////
else if($action=="kicklist")
{ $pstyle = gettheme($sid);
      echo xhtmlhead("Kicked Lists",$pstyle);
  addonline(getuid_sid($sid),"Tools","index.php?action=main");

      echo "<p align=\"center\">";
    $uid = getuid_sid($sid);
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_kick"));
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql
        $sql = " SELECT uid FROM dcroxx_me_kick WHERE kick='1' AND rid='".$rid."' ORDER BY uid DESC LIMIT $limit_start, $items_per_page";

    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
$unick = getnick_uid($item[0]);
    $lnk = "<a href=\"chat.php?action=say2&amp;who=$item[0]&amp;rid=$rid&amp;type=sendrpw=$rpw\">$unick</a>";

      echo "$lnk<br/>";
}
    }
    echo "</p>";
    echo "<p align=\"center\">";

     if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
        $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
        $rets .= "</form>";


        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
echo "<a href=\"chat.php?sid=$sid&amp;rid=$rid\">";
echo "BACK TO ROOM</a><br/>";
    echo "<a href=\"index.php?action=main&amp;type=send\">";
echo "Main menu</a>";
  echo "</p>";
    echo "</body>";
 exit();
    }
/////////////////////////////////////all gal
else if($action=="viewuser")
{
      $who = $_GET["who"];
    $whonick = getnick_uid($who);
    addonline(getuid_sid($sid),"Viewing Photos of $whonick","lists.php?action=$action&amp;who=$who");
     addplace(getuid_sid($sid),"lists.php?action=$action&amp;who=$who","");

    $uid = getuid_sid($sid);



    //////ALL gallery SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    if($who!="")
    {
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_gallery3 WHERE uid='".$who."'"));
    }else{
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_gallery3"));
    }
    $num_items = $noi[0]; //changable
    $items_per_page= 1;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    if($who!="")
    {
        $sql = "SELECT id, sex, itemurl FROM dcroxx_me_gallery3 WHERE uid='".$who."' ORDER BY id DESC LIMIT $limit_start, $items_per_page";
        }else{
$sql = "SELECT id, sex, itemurl, uid FROM dcroxx_me_gallery3  ORDER BY id DESC LIMIT $limit_start, $items_per_page";
        }

echo "<p align=\"center\">";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $id = $item[0];
        $img = $item[2];


        $lnk = "<img src=\"$img\" alt=\"$id\" width=\"100\" height=\"80\"/><br/>";
    $rinfo = mysql_fetch_array(mysql_query("SELECT COUNT(*) as nofr, SUM(prate) as nofp FROM dcroxx_me_prate WHERE pid='".$id."'"));
$counts = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_prate WHERE pid='".$id."'"));
if($counts[0]>0) {
    $ther = $rinfo[1]/$rinfo[0];
    $rating = "Rating: $ther/$rinfo[1] votes <b>($counts[0])</b><br/>";
}else{
$rating = "";
}

         $gall = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_galcom WHERE pid='".$id."'"));
$me = getuid_sid($sid);
if($who=="$me") {
$use = "<a href=\"genproc.php?action=upav2&amp;gid=$item[0]\">Use as Avatar</a> | ";
}else{
$use = "";
}
      if(candelgal($uid, $item[0]))
      {
        $delnk = "<a href=\"genproc.php?action=delgal&amp;gid=$item[0]\">Remove Photo</a>";
      }else{
        $delnk = "";
      }
      echo "$lnk$rating<a href=\"$img\">Download</a><br/> $use$delnk<br/><a href=\"lists.php?who=$who&amp;action=comments2&amp;gid=$item[0]\">Comments($gall[0])</a><br/>";


    }
    }
    echo "</p>";
echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
     if($num_pages>2)
    {
        $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
        $rets .= "</form>";


        echo $rets;
    }

echo "<a href=\"index.php?action=pkgal\">Users Gallery</a><br/>";
  echo "<a href=\"index.php?action=main\">Main menu</a>";

    echo "</p>";
    echo "</body>";

}

/////////////////////////////////////////////////////////Members List

if($action=="members")
{
    addonline(getuid_sid($sid),"Members List","");
    $view = $_GET["view"];
    if($view=="")$view="date";
    $pstyle = gettheme($sid);
      echo xhtmlhead("Members List",$pstyle);
    echo "<p align=\"center\">";
    echo "<img src=\"images/bdy.gif\" alt=\"*\"/><br/>";
    echo "<a href=\"lists.php?action=members&amp;view=name\">Order By Name</a><br/>";
    echo "<a href=\"lists.php?action=members&amp;view=date\">Order By Join Date</a><br/>";
    echo "</p>";
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $num_items = regmemcount(); //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql
    if($view=="name")
    {
        $sql = "SELECT id, name, regdate FROM dcroxx_me_users ORDER BY name LIMIT $limit_start, $items_per_page";
    }else{
        $sql = "SELECT id, name, regdate FROM dcroxx_me_users ORDER BY regdate DESC LIMIT $limit_start, $items_per_page";
    }

    echo "<p>";
    $items = mysql_query($sql);

    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $jdt = date("d-m-y", $item[2]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a> <small>joined: $jdt</small>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=members&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=members&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
        $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
 exit();
    }
////////////////////////////////////////////////////////List users by IP

if($action=="byip")
{
    addonline(getuid_sid($sid),"Mods CP","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Mods CP",$pstyle);
    //////ALL LISTS SCRIPT <<
    $who = $_GET["who"];
    $whoinfo = mysql_fetch_array(mysql_query("SELECT ipadd, browserm FROM dcroxx_me_users WHERE id='".$who."'"));
    if(ismod(getuid_sid($sid))){
    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE ipadd='".$whoinfo[0]."' AND browserm='".$whoinfo[1]."'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, name FROM dcroxx_me_users WHERE ipadd='".$whoinfo[0]."' AND browserm='".$whoinfo[1]."' ORDER BY name  LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);

    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {

      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
        $rets .= "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
    }else{
      echo "<p align=\"center\">";
      echo "You can't view this list";
      echo "</p>";
    }
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
 exit();
    }
///////////////////////////////////////////////////////User Popup(owner)

else if($action=="readpopup")
{
boxstart("Posts Per Page");
  $who = $_GET["who"];
    addonline(getuid_sid($sid),"Owner Tools","");
if(!isowner(getuid_sid($sid)))
  {
      boxstart("Error!");
      echo "<p align=\"center\">";
      echo "You are not an owner<br/>";
      echo "<br/>";
      echo "<a href=\"index.php\">Home</a>";
      echo "</p>";
      boxend();
    }else{

      boxstart("Reading Popup!");
    $uid = getuid_sid($sid);
    if($page=="" || $page<=0)$page=1;
    $myid = getuid_sid($sid);
    $pms = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_popup WHERE byuid=$who ORDER BY id"));
    echo mysql_error();
    $num_items = $pms[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if($page>$num_pages)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    if($num_items>0)
    {
      echo "<p>";
      $pms = mysql_query("SELECT byuid, touid, text, timesent FROM dcroxx_me_popup WHERE byuid=$who ORDER BY id LIMIT $limit_start, $items_per_page");
      while($pm=mysql_fetch_array($pms))
      {
            if(isonline($pm[0]))
  {
    $onlby = "<img src=\"../images/onl.gif\" alt=\"+\"/>";
  }else{
    $onlby = "<img src=\"../images/ofl.gif\" alt=\"-\"/>";
  }
            if(isonline($pm[1]))
  {
    $onlto = "<img src=\"../images/onl.gif\" alt=\"+\"/>";
  }else{
    $onlto = "<img src=\"../images/ofl.gif\" alt=\"-\"/>";
  }
  $bylnk = "<a href=\"index.php?action=viewuser&amp;who=$pm[0]\">$onlby".getnick_uid($pm[0])."</a>";
  $tolnk = "<a href=\"index.php?action=viewuser&amp;who=$pm[1]\">$onlto".getnick_uid($pm[1])."</a>";
  echo "$bylnk <img src=\"../moods/in.gif\" alt=\"-\"/> $tolnk";
  $tmopm = date("d m y - h:i:s",$pm[3]);
  echo " $tmopm<br/>";
  echo parsepm($pm[2], $sid);
  echo "<br/>--------------<br/>";
      }
      echo "</p><p align=\"center\">";
      if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=readmsgs&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=readmsgs&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
    $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "<input name=\"page\" style=\"-wap-input-format: '*N'\" size=\"2\"/>";
      $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\">";
      $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\">";
      $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\">";
      $rets .= "<input type=\"Submit\" name=\"Submit\" Value=\"Go To Page\"></form>";
      echo $rets;
      }
      }else{
        echo "<p align=\"center\">";
        echo "NO DATA";
      }
    echo "<p align=\"center\">";
    $unick = getnick_uid($who);
    echo "<a href=\"index.php?action=viewuser&amp;who=$who\">$whonick's Profile</a><br/>";
 boxend();
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
    boxend();

}
 exit();
    }
//////////////////////////////////////////////////////User MMS(owner)

else if($action=="readmms")
{
boxstart("Posts Per Page");
  $who = $_GET["who"];
    addonline(getuid_sid($sid),"Owner Tools","");
if(!isowner(getuid_sid($sid)))
  {
      boxstart("Error!");
      echo "<p align=\"center\">";
      echo "You are not an owner<br/>";
      echo "<br/>";
      echo "<a href=\"index.php\">Home</a>";
      echo "</p>";
      boxend();
    }else{

      boxstart("Reading MMS!");
    $uid = getuid_sid($sid);
    if($page=="" || $page<=0)$page=1;
    $myid = getuid_sid($sid);
    $pms = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM mms WHERE byuid=$who ORDER BY id"));
    echo mysql_error();
    $num_items = $pms[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if($page>$num_pages)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    if($num_items>0)
    {
      echo "<p>";
      $pms = mysql_query("SELECT byuid, touid, pmtext, timesent, size, extension, filename FROM mms WHERE byuid=$who ORDER BY id LIMIT $limit_start, $items_per_page");
      while($pm=mysql_fetch_array($pms))
      {
            if(isonline($pm[0]))
  {
    $onlby = "<img src=\"../images/onl.gif\" alt=\"+\"/>";
  }else{
    $onlby = "<img src=\"../images/ofl.gif\" alt=\"-\"/>";
  }
            if(isonline($pm[1]))
  {
    $onlto = "<img src=\"../images/onl.gif\" alt=\"+\"/>";
  }else{
    $onlto = "<img src=\"../images/ofl.gif\" alt=\"-\"/>";
  }
  $bylnk = "<a href=\"index.php?action=viewuser&amp;who=$pm[0]\">$onlby".getnick_uid($pm[0])."</a>";
  $tolnk = "<a href=\"index.php?action=viewuser&amp;who=$pm[1]\">$onlto".getnick_uid($pm[1])."</a>";
  echo "$bylnk <img src=\"../moods/in.gif\" alt=\"-\"/> $tolnk";
  $tmopm = date("d m y - h:i:s",$pm[3]);
  echo " $tmopm<br/>";
  echo parsepm($pm[2], $sid);
  echo "<br/>--------------<br/>";
      }
      echo "</p><p align=\"center\">";
      if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=readmsgs&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=readmsgs&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
    $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "<input name=\"page\" style=\"-wap-input-format: '*N'\" size=\"2\"/>";
      $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\">";
      $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\">";
      $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\">";
      $rets .= "<input type=\"Submit\" name=\"Submit\" Value=\"Go To Page\"></form>";
      echo $rets;
      }
      }else{
        echo "<p align=\"center\">";
        echo "NO DATA";
      }
    echo "<p align=\"center\">";
    $unick = getnick_uid($who);
    echo "<a href=\"index.php?action=viewuser&amp;who=$who\">$whonick's Profile</a><br/>";
 boxend();
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
    boxend();

}
 exit();
    }
///////////////////////////////////////////////////////User Inboxes(owner)

else if($action=="readmsgs")
{
//boxstart("Posts Per Page");
echo"<title>Read Inbox</title>";
  $who = $_GET["who"];
    addonline(getuid_sid($sid),"Owner Tools","");
if(getuid_sid($sid)!=1 && getuid_sid($sid)!=2)
  {
     // boxstart("Error!");
      echo "<p align=\"center\">";
      echo "Sorry, we have currently disable this feature<br/>";
      echo "<br/>";
      echo "<img src=\"images/home.gif\" alt=\"*\"/><a href=\"index.php\">Home</a>";
      echo "</p>";
      boxend();
    }else{

      boxstart("Reading Inbox!");
    $uid = getuid_sid($sid);
    if($page=="" || $page<=0)$page=1;
    $myid = getuid_sid($sid);
    $pms = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE byuid=$who ORDER BY timesent"));
    echo mysql_error();
    $num_items = $pms[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if($page>$num_pages)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    if($num_items>0)
    {
      echo "<p>";
      $pms = mysql_query("SELECT byuid, touid, text, timesent FROM dcroxx_me_private WHERE byuid=$who ORDER BY timesent LIMIT $limit_start, $items_per_page");
      while($pm=mysql_fetch_array($pms))
      {
            if(isonline($pm[0]))
  {
    $onlby = "<img src=\"../images/onl.gif\" alt=\"+\"/>";
  }else{
    $onlby = "<img src=\"../images/ofl.gif\" alt=\"-\"/>";
  }
            if(isonline($pm[1]))
  {
    $onlto = "<img src=\"../images/onl.gif\" alt=\"+\"/>";
  }else{
    $onlto = "<img src=\"../images/ofl.gif\" alt=\"-\"/>";
  }
  $bylnk = "<a href=\"index.php?action=viewuser&amp;who=$pm[0]\">$onlby".getnick_uid($pm[0])."</a>";
  $tolnk = "<a href=\"index.php?action=viewuser&amp;who=$pm[1]\">$onlto".getnick_uid($pm[1])."</a>";
  echo "$bylnk <img src=\"../moods/in.gif\" alt=\"-\"/> $tolnk";
  $tmopm = date("d m y - h:i:s",$pm[3]);
  echo " $tmopm<br/>";
  echo parsepm($pm[2], $sid);
  echo "<br/>--------------<br/>";
      }
      echo "</p><p align=\"center\">";
      if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=readmsgs&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=readmsgs&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
	$rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "<input name=\"page\" style=\"-wap-input-format: '*N'\" size=\"2\"/>";
      $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\">";
      $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\">";
      $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\">";
      $rets .= "<input type=\"Submit\" name=\"Submit\" Value=\"Go To Page\"></form>";
      echo $rets;
      }
      }else{
        echo "<p align=\"center\">";
        echo "NO DATA";
      }
    echo "<p align=\"center\">";
    $unick = getnick_uid($who);
    echo "<a href=\"index.php?action=viewuser&amp;who=$who\">$whonick's Profile</a><br/>";
 boxend();
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
    boxend();

}
 exit();
    }
////////////////////////////////////////////////////////Most Credits List

else if($action=="mostc")
{
    addonline(getuid_sid($sid),"Most Credits","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Most Credits",$pstyle);
    echo "<p align=\"center\">";
    echo "<b>Most Credits (Top Ten)</b>";
    echo "</p>";
    //////ALL LISTS SCRIPT <<

        if($page=="" || $page<=0)$page=1;
    $num_items = regmemcount(); //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, name, plusses FROM dcroxx_me_users WHERE perm='0' ORDER BY plusses DESC LIMIT $limit_start, $items_per_page";

    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a> <small>Credits: $item[2]</small>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";

  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
 exit();
    }
//////////////////////////////////Longest Online

else if($action=="longon")
{
    addonline(getuid_sid($sid),"Longest Online","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Longest Online",$pstyle);

    //////ALL LISTS SCRIPT <<
   // $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE tottimeonl>'0'"));
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE totaltime>'0'"));

    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

  $sql = "SELECT id, name, totaltime FROM dcroxx_me_users WHERE totaltime>'0' ORDER BY totaltime DESC LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {


    $num = $item[2]/86400;
$days = intval($num);
$num2 = ($num - $days)*24;
$hours = intval($num2);
$num3 = ($num2 - $hours)*60;
$mins = intval($num3);
$num4 = ($num3 - $mins)*60;
$secs = intval($num4);

      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a>: 
	  <b>$days</b> days <b>$hours</b> hours <b>$mins</b> mins <b>$secs</b> seconds";
      echo "<small>$lnk</small><br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=longon&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=longon&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
        $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page: <input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";

exit();
    }
//////////////////////////////////WapLive Millionaire

else if($action=="mmillionaire")
{
    addonline(getuid_sid($sid),"Millionaire List","");
    $pstyle = gettheme($sid);
        echo xhtmlhead("Millionaire",$pstyle);

    //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE specialid='1'"));

    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, name, specialid FROM dcroxx_me_users WHERE specialid='1' ORDER BY name LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=staff&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=staff&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
        $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page: <input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
   boxend();

echo "Home</a>";
  echo "</p>";
 exit();
    }

//////////////////////////////////Upcomeing Star

else if($action=="mstar1")
{

    addonline(getuid_sid($sid),"Upcomeing Stars List","");
    $pstyle = gettheme($sid);
         echo xhtmlhead("Upcomeing Stars",$pstyle);

    //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE specialid='10'"));

    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, name, specialid FROM dcroxx_me_users WHERE specialid='10' ORDER BY name LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=staff&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=staff&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
        $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page: <input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
   boxend();

echo "Home</a>";
  echo "</p>";
 exit();
    }
//////////////////////////////////Super Star

else if($action=="mstar2")
{
    addonline(getuid_sid($sid),"Super Star List","");
    $pstyle = gettheme($sid);
     echo xhtmlhead("Super Star",$pstyle);

    //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE specialid='11'"));

    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, name, specialid FROM dcroxx_me_users WHERE specialid='11' ORDER BY name LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=staff&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=staff&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
        $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page: <input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
   boxend();

echo "Home</a>";
  echo "</p>";
 exit();
    }

//////////////////////////////////Reaper

else if($action=="mreaper")
{
    addonline(getuid_sid($sid),"Reapers List","");
    $pstyle = gettheme($sid);
    echo xhtmlhead("Reapers",$pstyle);

    //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE specialid='12'"));

    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, name, specialid FROM dcroxx_me_users WHERE specialid='12' ORDER BY name LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=staff&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=staff&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
        $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page: <input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
   boxend();

echo "Home</a>";
  echo "</p>";
 exit();
    }
//////////////////////////////////Director

else if($action=="mdirector")
{
    addonline(getuid_sid($sid),"Directors List","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Directors",$pstyle);

    //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE specialid='13'"));

    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, name, specialid FROM dcroxx_me_users WHERE specialid='13' ORDER BY name LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=staff&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=staff&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
        $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page: <input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
   boxend();

echo "Home</a>";
  echo "</p>";
 exit();
    }
//////////////////////////////////Spy

else if($action=="mspy")
{
    addonline(getuid_sid($sid),"Spys List","");
    $pstyle = gettheme($sid);
     echo xhtmlhead("Spys",$pstyle);

    //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE specialid='14'"));

    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, name, specialid FROM dcroxx_me_users WHERE specialid='14' ORDER BY name LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=staff&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=staff&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
        $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page: <input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
   boxend();

echo "Home</a>";
  echo "</p>";
 exit();
    }
//////////////////////////////////Killer

else if($action=="mkiller")
{
    addonline(getuid_sid($sid),"Killers List","");
    $pstyle = gettheme($sid);
     echo xhtmlhead("Killers",$pstyle);

    //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE specialid='15'"));

    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, name, specialid FROM dcroxx_me_users WHERE specialid='15' ORDER BY name LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=staff&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=staff&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
        $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page: <input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
   boxend();

echo "Home</a>";
  echo "</p>";
 exit();
    }
//////////////////////////////////Assassin

else if($action=="massassin")
{
    addonline(getuid_sid($sid),"Assassins List","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Assassins",$pstyle);

    //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE specialid='16'"));

    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, name, specialid FROM dcroxx_me_users WHERE specialid='16' ORDER BY name LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=staff&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=staff&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
        $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page: <input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
   boxend();

echo "Home</a>";
  echo "</p>";
 exit();
    }


//////////////////////////////////Partner

else if($action=="mpartner")
{
    addonline(getuid_sid($sid),"Partners List","");
    $pstyle = gettheme($sid);
    echo xhtmlhead("Partners",$pstyle);

    //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE specialid='17'"));

    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, name, specialid FROM dcroxx_me_users WHERE specialid='17' ORDER BY name LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=staff&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=staff&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
        $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page: <input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
   boxend();

echo "Home</a>";
  echo "</p>";

exit();
    }
//////////////////////////////////WapLive Quiz Master

else if($action=="mquizm")
{
    addonline(getuid_sid($sid),"Quiz Masters","");
    $pstyle = gettheme($sid);
    echo xhtmlhead("Quiz Masters",$pstyle);

    //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE specialid='2'"));

    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, name, specialid FROM dcroxx_me_users WHERE specialid='2' ORDER BY name LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=staff&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=staff&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
        $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page: <input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
   boxend();

echo "Home</a>";
  echo "</p>";
 exit();
    }
//////////////////////////////////WapLive Prince and Princess

else if($action=="mpandps")
{
    addonline(getuid_sid($sid),"Prince and Princess","");
    $pstyle = gettheme($sid);
     echo xhtmlhead("Prince and Princess",$pstyle);

    //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE specialid>'7'"));

    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, name, specialid FROM dcroxx_me_users WHERE specialid>'7' ORDER BY name LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
        if($item[2]=='8')
        {
          $tit = "Prince!";
        }
        if($item[2]=='9')
        {
          $tit = "Princess!";
        }
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a> <small>$tit</small>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=staff&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=staff&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
        $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page: <input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
   boxend();

echo "Home</a>";
  echo "</p>";

 exit();
    }
///////////////////////////////////////////////////////MARRIED COUPLE
else if($action=="marry")
{
    addonline(getuid_sid($sid),"Wappied List","");
 $pstyle = gettheme($sid);
      echo xhtmlhead("Couple",$pstyle);
echo "<head>";
      echo "<title>MARRIED LIST</title>";
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";


      echo "</head>";
      //echo "<body>";

   //////ALL LISTS SCRIPT <<

     $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM couple WHERE accept='1'"));
  if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, who, partner, FROM couple WHERE accept='1' ORDER BY accept DESC LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
$unick = getnick_uid($item[2]);
$wnick = getnick_uid($item[1]);
$lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[2]\">$unick </a><b>is Wappied To </b><a href=\"index.php?action=viewuser&amp;who=$item[1]\">$wnick </a><br/>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=marry&amp;page=$ppage\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=marry&amp;page=$npage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    echo "</p>";
    if($num_pages>2)
    {
        $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "<input name=\"page\" style=\"-wap-input-format: '*N'\" size=\"2\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"submit\" value=\"Go To Page\"/>";
        $rets .= "</form>";
        echo $rets;
    }

  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"chapel.php?action=main\">";
echo "Chapel</a><br/><br/>";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
   boxend();
 echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";

 exit();
    }
//////////////////////////////////////////////////////Top Posters List


else if($action=="topp")
{
    addonline(getuid_sid($sid),"Top Posters","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Top Posters",$pstyle);
    echo "<p align=\"center\">";
    echo "<b>Our Top Posters</b><br/><small>Thank you all for keeping this site alive<br/>";
    $weekago = ((time() - $timeadjust)  );
    $weekago -= 7*24*60*60;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT uid) FROM dcroxx_me_posts WHERE dtpost>'".$weekago."';"));
    echo "<a href=\"lists.php?action=tpweek\">This week($noi[0])</a><br/>";
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT uid)  FROM dcroxx_me_posts ;"));
    echo "<a href=\"lists.php?action=tptime\">All the time($noi[0])</a></small><br/>";
    echo "</p>";
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $num_items = regmemcount(); //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, name, posts FROM dcroxx_me_users ORDER BY posts DESC LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {

      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a> <small>Posts: $item[2]</small>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=topp&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=topp&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
        $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page: <input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
///////////////////////////////////////////////////////Most online daily list

else if($action=="moto")
{
    addonline(getuid_sid($sid),"Daily Most Online","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Daily Most online",$pstyle);
    echo "<p align=\"center\">";
    echo "<small>Maximum number of users was online in the last 10 Days<br/>";


    echo "</small>";
    echo "</p>";
    //////ALL LISTS SCRIPT <<







    //changable sql

        $sql = "SELECT ddt, dtm, ppl FROM dcroxx_me_mpot ORDER BY id DESC LIMIT 10";


    echo "<p>";
    $items = mysql_query($sql);

    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {

      $lnk = "<small>$item[0]($item[1]) Members: $item[2]</small>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";


  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
///////////////////////////////////////////////////////Top Chatters

else if($action=="tchat")
{
    addonline(getuid_sid($sid),"Top Chatters","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Top Chatters",$pstyle);
    echo "<p align=\"center\">";
    echo "<b>Top Chatters</b>";
    echo "</p>";
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $num_items = regmemcount(); //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, name, chmsgs FROM dcroxx_me_users ORDER BY chmsgs DESC LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {

      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a> <small>Chat Posts: $item[2]</small>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=tchat&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=tchat&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
        $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
///////////////////////////////////////////////////////requists

else if($action=="reqs")
{
    addonline(getuid_sid($sid),"Requests List","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Requests",$pstyle);
    echo "<p align=\"center\">";
    global $max_buds;
    $uid = getuid_sid($sid);
    echo "<small>The following members want you to add them to your buddy list<br/>";
    $remp = $max_buds - getnbuds($uid);
    echo "you have <b>$remp</b> Places left</small>";
    echo "</p>";
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $nor = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_buddies WHERE tid='".$uid."' AND agreed='0'"));
    $num_items = $nor[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT uid  FROM dcroxx_me_buddies WHERE tid='".$uid."' AND agreed='0' ORDER BY reqdt DESC LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
        $rnick = getnick_uid($item[0]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$rnick</a>: <a href=\"genproc.php?action=bud&amp;who=$item[0]&amp;todo=add\">Accept</a>, <a href=\"genproc.php?action=bud&amp;who=$item[0]&amp;todo=del\">Decline</a>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
  $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
         $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
         $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
         $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
/*
///////////////////////////////////////////////////////shouts

else if($action=="shouts")
{
    addonline(getuid_sid($sid),"Shouts","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Shouts",$pstyle);
    $who = $_GET["who"];
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    if($who=="")
    {
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_shouts"));
    }else{
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_shouts WHERE shouter='".$who."'"));
    }
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql
    if($who =="")
    {
        $sql = "SELECT id, shout, shouter, shtime  FROM dcroxx_me_shouts ORDER BY shtime DESC LIMIT $limit_start, $items_per_page";
}else{
    $sql = "SELECT id, shout, shouter, shtime  FROM dcroxx_me_shouts  WHERE shouter='".$who."'ORDER BY shtime DESC LIMIT $limit_start, $items_per_page";
}

    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
        $shnick = getnick_uid($item[2]);
        $sht = htmlspecialchars($item[1]);
        $shdt = date("d m y-H:i", $item[3]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[2]\">$shnick</a>: $sht<br/>$shdt";
      if(ismod(getuid_sid($sid)))
      {
      $dlsh = "<a href=\"mprocpl.php?action=delsh&amp;shid=$item[0]\">[x]</a>";
      }else{
        $dlsh = "";
      }
      echo "$lnk $dlsh<br/>";
    }
    }
    echo "</small></p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=shouts&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=shouts&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
  $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
         $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
         $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
         $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
         $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }*/
/////////////////////////////shouts
else if($action=="shouts")
{$pstyle = gettheme($sid);
      echo xhtmlhead("Shout",$pstyle);
  echo "<head><title>$site_name</title>";
      echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
      <meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
      <meta name=\"description\" content=\"Riderz wap dating portal and community containg chat, forums, blogs and much more\" />
      <meta name=\"keywords\" content=\"chat, forums, wap, dating, games, blogs, polls, quiz, lavalair, news, rap, goth\" /></head>";

      echo "<body>";
  addonline(getuid_sid($sid),"Shouts","lists.php?action=$action");

echo "<h5><center><big>Shout History</big></center></h5>";
include("pm_by.php");



     $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_disable_shout"));
  if($noi[0]==1){
	  echo"<center><br/>Shoutbox disable by <b>Staff Team</b><br/><br/></center>";
  }else{
echo"<center><small>ShoutBox Message:</small><br/>
<form action=\"genproc.php?action=shout\" method=\"post\">
<textarea id=\"inputText\" name=\"shtxt\" style=\"height:50px;width: 270px;\" ></textarea><br/>";
echo "<input id=\"inputButton\" type=\"submit\" value=\"Add Shout\"/></form></center><br/>";
echo"<center><small><b><a href=\"lists.php?action=smilies\">Smilies</a> || <a href=\"lists.php?action=bbcode\">BBCodes</a></b></small></center><br/>";
}
//echo"<br/>";
     $who = $_GET["who"];
     if($page=="" || $page<=0)$page=1;
     if($who=="")
     {
     $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_shouts"));
     }else{
     $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_shouts WHERE shouter='".$who."'"));
     }
     $num_items = $noi[0]; //changable
     $items_per_page= 10;
     $num_pages = ceil($num_items/$items_per_page);
     if(($page>$num_pages)&&$page!=1)$page= $num_pages;
     $limit_start = ($page-1)*$items_per_page;
      //changable sql
     if($who =="")
     {
         $sql = "SELECT id, shout, shouter, shtime, l_id, act_cat, act_id, img_id FROM dcroxx_me_shouts ORDER BY shtime DESC LIMIT $limit_start, $items_per_page";
}else{
     $sql = "SELECT id, shout, shouter, shtime, l_id, act_cat, act_id, img_id FROM dcroxx_me_shouts  WHERE shouter='".$who."'ORDER BY shtime DESC LIMIT $limit_start, $items_per_page";
}
      $items = mysql_query($sql);
     echo mysql_error();
     if(mysql_num_rows($items)>0)
     {
     while ($item = mysql_fetch_array($items))
     {
         $shnick = getnick_uid($item[2]);
/*    if(isonline($item[2])){
$iml = "<img src=\"images/onl.gif\" alt=\"+\"/>";
}else{
$iml = "<img src=\"images/ofl.gif\" alt=\"-\"/>";
}*/
$avlink = getavatar($item[2]);
if($avlink==""){
$iml = "<img src=\"images/nopic.jpg\" alt=\"Nopic\" height=\"30\" width=\"25\"/>";
}else{
$iml = "<img src=\"phpthumb.php?image=$avlink&h=30&w=25 alt=\"avatar\"/>";
}


        $sht = htmlspecialchars($item[1]);
         $shdt = date("d/m/Y h:i:s A", $item[3]+(addhours()));
		 
$tremain = time()-$item[3];
$tmdt = gettimemsg($tremain)." ago";
//echo "<b>($tmdt)</b><br/><br/>";


$s = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_mention WHERE shid='".$item[0]."'"));
$lst = mysql_fetch_array(mysql_query("SELECT tag_id FROM dcroxx_me_mention WHERE shid='".$item[0]."'"));
$lnck = getnick_uid($lst[0]);
$ck = getnick_uid($lst[0]);
$cos = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_mention WHERE shid='".$item[0]."'"));
$pip = $cos[0]-1;
if($cos[0]==1){ $lk = "<font color=\"#4c5157\">with</font> <a href=\"$ck\">$lnck</a>"; }
else if($cos[0]>1) {$lk = "<font color=\"#4c5157\">with</font> <a href=\"$ck\">$lnck</a> <font color=\"#4c5157\">and</font> <a href=\"tag_mention.php?action=tag_peoples&shid=$item[0]\">$pip others</a>";}
else if ($cos[0]==0){ $lk = "";}


//Start Activity & Feelings
if ($item[6]=="" || $item[6]=="0"){
$activity = "";
}else{
if ($item[5]=="0"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$item[6]."'"));
$activity = "<img src=\"$i[2]\"> <font color=\"#9397a0\">$i[0]</font>";
}else if ($item[5]=="1"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$item[6]."'"));
$activity = "<img src=\"$i[2]\"> feeling <font color=\"#9397a0\">$i[0]</font>";
}else if ($item[5]=="2"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$item[6]."'"));
$activity = "<img src=\"$i[2]\"> watching <font color=\"#9397a0\">$i[0]</font>";
}else if ($item[5]=="3"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$item[6]."'"));
$activity = "<img src=\"$i[2]\"> reading <font color=\"#9397a0\">$i[0]</font>";
}else if ($item[5]=="4"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$item[6]."'"));
$activity = "<img src=\"$i[2]\"> listening <font color=\"#899bc4\">$i[0]</font>";
}else if ($item[5]=="5"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$item[6]."'"));
$activity = "<img src=\"$i[2]\"> drinking <font color=\"#9397a0\">$i[0]</font>";
}else if ($item[5]=="6"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$item[6]."'"));
$activity = "<img src=\"$i[2]\"> eating <font color=\"#9397a0\">$i[0]</font>";
}else if ($item[5]=="7"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$item[6]."'"));
$activity = "<img src=\"$i[2]\"> playing <font color=\"#9397a0\">$i[0]</font>";
}else if ($item[5]=="8"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$item[6]."'"));
$activity = "<img src=\"$i[2]\"> travelling to <font color=\"#9397a0\">$i[0]</font>";
}else if ($item[5]=="9"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$item[6]."'"));
$activity = "<img src=\"$i[2]\"> looking for <font color=\"#9397a0\">$i[0]</font>";
}else if ($item[5]=="10"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$item[6]."'"));
$activity = "<img src=\"$i[2]\"> exercising <font color=\"#9397a0\">$i[0]</font>";
}else if ($item[5]=="11"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$item[6]."'"));
$activity = "<img src=\"$i[2]\"> attending <font color=\"#9397a0\">$i[0]</font>";
}else if ($item[5]=="12"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$item[6]."'"));
$activity = "<img src=\"$i[2]\"> supporting <font color=\"#9397a0\">$i[0]</font>";
}else if ($item[5]=="13"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$item[6]."'"));
$activity = "<img src=\"$i[2]\"> celebrating <font color=\"#9397a0\">$i[0]</font>";
}else if ($item[5]=="14"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$item[6]."'"));
$activity = "<img src=\"$i[2]\"> meeting <font color=\"#9397a0\">$i[0]</font>";
}else if ($item[5]=="15"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$item[6]."'"));
$activity = "<img src=\"$i[2]\"> getting <font color=\"#9397a0\">$i[0]</font>";
}else if ($item[5]=="16"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$item[6]."'"));
$activity = "<img src=\"$i[2]\"> making <font color=\"#9397a0\">$i[0]</font>";
}else if ($item[5]=="17"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$item[6]."'"));
$activity = "<img src=\"$i[2]\"> thinking about <font color=\"#9397a0\">$i[0]</font>";
}else if ($item[5]=="18"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$item[6]."'"));
$activity = "<img src=\"$i[2]\"> remembering <font color=\"#9397a0\">$i[0]</font>";
}
}

if ($item[4]=="" || $item[4]=="0"){
$location = "";
}else{
$l_name = mysql_fetch_array(mysql_query("SELECT title, img FROM dcroxx_me_s_location WHERE id='".$item[4]."'"));
$location = "<img src=\"$l_name[1]\"> at <font color=\"#07a851\">$l_name[0]</font><br/>";
}

if(isowner($item[2]))
//{$lnk = "$iml<a href=\"index.php?action=viewuser&who=$item[2]\"><font color='red'>$shnick</font></a>: ".getbbcode(getsmilies($sht))."<br/>$tmdt";}
{$lnk = "$iml<a href=\"index.php?action=viewuser&who=$item[2]\"><font color='red'>$shnick</font></a> $activity $location $lk<br/> ";}
else if(isadmin($item[2]))
//{$lnk = "$iml<a href=\"index.php?action=viewuser&who=$item[2]\"><font color='purple'>$shnick</font></a>: ".getbbcode(getsmilies($sht))."<br/>$tmdt";}
{$lnk = "$iml<a href=\"index.php?action=viewuser&who=$item[2]\"><font color='purple'>$shnick</font></a> $activity $location $lk<br/> ";}
else if(ismod($item[2]))
//{$lnk = "$iml<a href=\"index.php?action=viewuser&who=$item[2]\"><font color='blue'>$shnick</font></a>: ".getbbcode(getsmilies($sht))."<br/>$tmdt";}
{$lnk = "$iml<a href=\"index.php?action=viewuser&who=$item[2]\"><font color='blue'>$shnick</font></a> $activity $location $lk<br/> ";}
else
//{$lnk = "$iml<a href=\"index.php?action=viewuser&who=$item[2]\">$shnick</a>: ".getbbcode(parsemsg($sht))."<br/>$tmdt";}
{$lnk = "$iml<a href=\"index.php?action=viewuser&who=$item[2]\">$shnick</a> $activity $location $lk<br/> ";}
   
if ($item[7]==""){
$shimg = "";
}else{
$shimg = "<img src=\"$item[7]\" alt=\"\">";
}
 
$fshout = htmlspecialchars($item[1]);
$fshout = getsmilies($fshout);
$fshout = findimage($fshout);
$shout = parsemsg($item[1],$sid);
$fshout = getbbcode($fshout,$sid);
$shbox = $fshout;

   
   
   
if(ismod(getuid_sid($sid))){
$dlsh = "<br/><b>Tools:</b> <a href=\"lists.php?action=chilmit&shid=$item[0]\">Delete</a>";
}
if(isowner(getuid_sid($sid))){
$dlsh0 = " / <a href=\"lists.php?action=chiledit&shid=$item[0]\">Edit</a>";
}else{
$dlsh0 = "";
}
//////////////////////////////////////////////////////////////	  
echo "<small>$lnk $shbox<br/>$shimg <br/>$tmdt</small><br/>"; 
$lstlike = mysql_fetch_array(mysql_query("SELECT uid FROM ibwfrr_like WHERE shoutid='".$item[0]."' ORDER BY ltime DESC LIMIT 1"));
$lstdislike = mysql_fetch_array(mysql_query("SELECT uid FROM ibwfrr_dislike WHERE shoutid='".$item[0]."' ORDER BY ltime DESC LIMIT 1"));
$lnick = getnick_uid($lstlike[0]);
$dlnick = getnick_uid($lstdislike[0]);
$counts = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_like WHERE shoutid='".$item[0]."'"));
$counts1 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_dislike WHERE shoutid='".$item[0]."'"));
$others = $counts[0]-1;
if($counts[0]>0 && $counts[0]<2){echo "<small><b>$lnick liked this</b></small><br/>";}
else if($counts[0]>1){echo "<small><b>$lnick and $others others liked this</b></small><br/>";}else{echo "";}
$others1 = $counts1[0]-1;
if($counts1[0]>0 && $counts1[0]<2){echo "<small><b>$dlnick disliked this</b></small><br/>";}
else if($counts1[0]>1){echo "<small><b>$dlnick and $others1 others disliked this</b></small><br/>";}else{echo "";}
$vb = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_like WHERE uid='".$uid."' AND shoutid='".$item[0]."'"));
$vb1 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_dislike WHERE uid='".$uid."' AND shoutid='".$item[0]."'"));
if($vb[0]==0 && $vb1[0]==0){

$i = mysql_fetch_array(mysql_query("SELECT shouter FROM dcroxx_me_shouts WHERE id='".$item[0]."'"));
if (ismod(getuid_sid($sid)) || $i[0]==$uid){
$sh = "<a href=\"tag_mention.php?shid=$item[0]\">Mention</a>/";
}else{
$sh = "Mention/";
}
$cos = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_mention WHERE shid='".$item[0]."'"));

$ge = "<a href=\"genproc.php?action=like&amp;shid=$item[0]\">Like</a>/<a href=\"genproc.php?action=dislike&amp;shid=$item[0]\">Dislike</a>";   
}else{$ge = "Like/Dislike";}
$ge0 = " [<a href=\"tag_mention.php?action=tag_peoples&amp;shid=$item[0]\">$cos[0]</a>/<a href=\"like.php?action=main&amp;shid=$item[0]\">$counts[0]</a>/<a href=\"dislike.php?action=main&amp;shid=$item[0]\">$counts1[0]</a>]<br/>";

/////////////////////////////////////////////////////////////	   
       echo "<small>$sh$ge$ge0$dlsh$dlsh0</small><hr/>";
     }
     }
     echo "<p align=\"center\">";
     if($page>1)
     {
      $ppage = $page-1;
       echo "<a href=\"lists.php?action=shouts&page=$ppage&who=$who\">&#171;Prev</a> ";
     }
     if($page<$num_pages)
     {
       $npage = $page+1;
       echo "<a href=\"lists.php?action=shouts&page=$npage&who=$who\">Next&#187;</a>";
     }
     echo "<br/>Page $page of $num_pages<br/>";
     if($num_pages>2)
     {
       $rets = "<center>Jump to page<form action=\"lists.php\" method=\"get\"><input id=\"inputText\" name=\"page\" format=\"*N\" size=\"3\"/>";
          $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
         $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
     $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
         $rets .= "<input id=\"inputButton\" type=\"submit\" value=\"[Go]\"/></form></center>";
         echo $rets;
     }
     ////// UNTILL HERE >>

    echo "<p align=\"center\">";

    echo "<a href=\"index.php?action=main\">";

echo "Back</a><br/>";

     echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo "</body>";
  }

////////////////////////Edit Shout
else if($action=="chiledit"){
$pstyle = gettheme($sid);
      echo xhtmlhead("Shout",$pstyle);
  echo "<head><title>$site_name</title>";
      
      echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
      <meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
      <meta name=\"description\" content=\"Riderz wap dating portal and community containg chat, forums, blogs and much more\" />
      <meta name=\"keywords\" content=\"chat, forums, wap, dating, games, blogs, polls, quiz, lavalair, news, rap, goth\" /></head>";

      echo "<body>";
$shid = $_GET["shid"];
$getsht = mysql_fetch_array(mysql_query("SELECT shout FROM dcroxx_me_shouts WHERE id = '".$shid."'"));
echo "<p>";
  echo "<br/>Edit:<br/> ";
echo "<form action=\"lists.php?action=chileditfin&id=$shid\" method=\"post\"><textarea id=\"inputText\" name=\"shtxt\">$getsht[0]</textarea> ";
echo "<br/><input id=\"inputButton\" type=\"submit\" value=\"Edit\"/>";
echo "</form>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo "</body>";
  }
///////////////////////////////////////Delete shout

else if($action=="chilmit"){
$pstyle = gettheme($sid);
      echo xhtmlhead("Shout",$pstyle);
  echo "<head><title>$site_name</title>";
      
      echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
      <meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
      <meta name=\"description\" content=\"Riderz wap dating portal and community containg chat, forums, blogs and much more\" />
      <meta name=\"keywords\" content=\"chat, forums, wap, dating, games, blogs, polls, quiz, lavalair, news, rap, goth\" /></head>";

      echo "<body>";
$shid = $_GET["shid"];
echo "<p align=\"center\">";
$res = mysql_query("DELETE FROM dcroxx_me_shouts WHERE id ='".$shid."'");
if($res){
$sql = mysql_fetch_array(mysql_query("SELECT shout, shouter FROM dcroxx_me_shouts WHERE id='".$shid."'"));
$modname = getnick_uid(getuid_sid($sid));
$shouter = getnick_uid($sql[1]);
$shout = substr("$sql[0]", 0, 30);
mysql_query("INSERT INTO dcroxx_me_mlog SET action='shouts', details='<b>".$modname."</b> Deleted Shout Number <b>".$shid."</b>', actdt='".time()."'");
echo "<img src=\"images/ok.gif\" alt=\"O\"/>Shout deleted";
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
}
echo "<br/><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo "</body>";

}
//////////////////////////Edit Shout/////////////////////////////
else if($action=="chileditfin"){
$pstyle = gettheme($sid);
      echo xhtmlhead("Shout",$pstyle);
  echo "<head><title>$site_name</title>";
      
      echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
      <meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
      <meta name=\"description\" content=\"Riderz wap dating portal and community containg chat, forums, blogs and much more\" />
      <meta name=\"keywords\" content=\"chat, forums, wap, dating, games, blogs, polls, quiz, lavalair, news, rap, goth\" /></head>";

      echo "<body>";
$shid = $_GET["id"];
$shtxt = $_POST["shtxt"];
echo "<p align=\"center\">";
$res = mysql_query("UPDATE dcroxx_me_shouts SET shout='".$shtxt."' WHERE id='".$shid."'");
if($res){
$sql = mysql_fetch_array(mysql_query("SELECT shout, shouter FROM dcroxx_me_shouts WHERE id='".$shid."'"));
$modname = getnick_uid(getuid_sid($sid));
$shouter = getnick_uid($sql[1]);
$shout = substr("$sql[0]", 0, 30);
mysql_query("INSERT INTO dcroxx_me_mlog SET action='shouts', details='<b>".$modname."</b> Edited <b>".$shouter."</b>\'s Shout <b><i>".$shout."...</i></b>', actdt='".time()."'");
echo "<img src=\"images/ok.gif\" alt=\"O\"/>Shout Edited!<br/><br/><a href=\"lists.php?action=shouts\">Shouts</a>";
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error!<br/><br/><a href=\"lists.php?action=shouts\">Shouts</a>";
}
echo "<br/><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo "</body>";
}
////////////////////////////////////////////////
else if($action=="file")
{
$who = $_GET["who"];
addonline(getuid_sid($sid),"Vip download HTML","");
$pstyle = gettheme($sid);
echo xhtmlhead("Vault",$pstyle);
$uid = getuid_sid($sid);

//////ALL LISTS SCRIPT <<

if($page=="" || $page<=0)$page=1;
if($who!="")
{
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_file WHERE uid='".$who."'"));
}else{
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_file"));
}
$num_items = $noi[0]; //changable
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
if(($page>$num_pages)&&$page!=1)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;

if($who!="")
{
$sql = "SELECT id, title, itemurl FROM dcroxx_me_file WHERE uid='".$who."' ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
}else{
$sql = "SELECT id, title, itemurl, uid FROM dcroxx_me_file ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
}

echo "<p align=\"left\">";
//echo "<small>";
$items = mysql_query($sql);
echo mysql_error();
if(mysql_num_rows($items)>0)
{
while ($item = mysql_fetch_array($items))
{
$ext = getext($item[2]);
$ime = getextimg($ext);
$lnk = "<a href=\"$item[2]\">$ime".htmlspecialchars($item[1])."</a>";

if(candelvl($uid, $item[0]))
{
$delnk = "[<a href=\"genproc.php?action=delfile&amp;vid=$item[0]\">Del</a>]";
}else{
$delnk = "";
}
if($who!="")
{
$byusr="";
}else{
$unick = getnick_uid($item[3]);
$ulnk = "<a href=\"index.php?action=viewuser&amp; who=$item[3]\">$unick</a>";
$byusr = "- By: $ulnk";
}
echo "$lnk $byusr $delnk<br/>";


}
}
//echo "</small></p>";
echo "</p>";
echo "<p align=\"center\">";
if($page>1)
{
$ppage = $page-1;
echo "<a href=\"lists.php?action=$action&amp;page=$ppage&am p;sid=$sid&amp;who=$who\">&#171;Back</a> ";
}
if($page<$num_pages)
{
$npage = $page+1;
echo "<a href=\"lists.php?action=$action&amp;page=$npage&am p;sid=$sid&amp;who=$who\">Next&#187;</a>";
}
echo "<br/>$page/$num_pages<br/>";
 if($num_pages>2)
    {
 $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
 $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
 $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
 $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "</form>";
        echo $rets;
    }
echo "</p>";
////// UNTILL HERE >>
echo "<p align=\"center\">";
if($uid==$who && getplusses($uid)>25){
//echo "<a href=\"index.php?action=addfile\">Add file via url</a><br/>";
echo "<a href=\"index.php?action=uploadfile\"> Upload file via Browser</a><br/>";
}
if($who!="")
{
echo "<a href=\"index.php?action=viewuser&amp; who=$who\">";
$whonick = getnick_uid($who);
echo "$whonick Profile</a><br/>";
}else{
//echo "<a href=\"index.php?action=addfile\">Add file via url</a><br/>";
echo "<a href=\"index.php?action=uploadfile\"> Upload file via Browser</a><br/>";

if (isvip(getuid_sid($sid)))

echo "<a href=\"index.php?action=vipcp\">VIP PANEL</a><br/>";

}

$thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
$themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'")); 
echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
echo "</p>";
echo xhtmlfoot();
}
///////////////Upload avatar///////////////

else if($action=="upavat")
{ $pstyle = gettheme($sid);
      echo xhtmlhead("Avatar Uploader",$pstyle);
 echo "<head><title>$site_name</title>";
      
      echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
      <meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
      <meta name=\"description\" content=\"Riderz wap dating portal and community containg chat, forums, blogs and much more\" />
      <meta name=\"keywords\" content=\"chat, forums, wap, dating, games, blogs, polls, quiz, lavalair, news, rap, goth\" /></head>";

      echo "<body>";
        addonline(getuid_sid($sid),"Uploading avatar image","lists.php?action=$action");
        $whonick = getnick_uid($who);
          //  echo "<h2><center><b>Upload Avatar</b></center></h2>";
/*			echo "<p><small><u>Choose the pic:</u></small><br/>
        <form enctype=\"multipart/form-data\" action=\"genproc.php?action=upavat\" method=\"post\">
        <small>Image(JPG/JPEG image only):<br/>Size limit: 512KB<br/>Image will be resized to fit its width to 128 pixels.</small><br/>
        <input type=\"file\" name=\"attach\"/><br/>
        <input id=\"inputButton\" type=\"submit\" name=\"submit\" value=\"UPLOAD\"/></form></p>";*/
		
echo "  
<p><small><u>Choose the pic:</u></small><br/>
<form enctype=\"multipart/form-data\" method=\"post\" action=\"genproc.php?action=upavat\">
<small>Image(JPG/JPEG image only):<br/>Size limit: 512KB<br/>Image will be resized to fit its width to 128 pixels.</small><br/>
<input type=\"file\" name=\"my_field\" /><br/>
<input type=\"hidden\" name=\"action\" value=\"image\" />
<small>Filter:</small><br/>
<select name=\"filter_x\" value=\"1\">
<option value=\"1\">Logo (Default)</option>
<option value=\"2\">Swirls_Vector_Green</option>
<option value=\"3\">Swirls_Vector_Pink</option>
<option value=\"4\">Swirls_Vector_Orange</option>
<option value=\"5\">Swirls_Vector_Blue</option>
<option value=\"6\">Rose_Love</option>
<option value=\"7\">Love_Parrot</option>
<option value=\"8\">New_Year</option>
<option value=\"9\">Marry_Christmas</option>
<option value=\"10\">Butterflies</option>
<option value=\"11\">Bangladesh</option>
<option value=\"12\">Apple</option>
</select><br/>
<INPUT TYPE=\"submit\" name=\"upl\" VALUE=\"UPLOAD\"></form><br/><br/>";
		
		
echo"
<b><u><small>Photo Filter Demo:</small></u></b><br/>

<a href=\"filter_x/demo/Logo (Default).jpg\"><img src=\"filter_x/demo/Logo (Default).jpg\" alt=\"Logo (Default)\" height=\"80\" width=\"50\" title=\"Zoom In\"/></a>
<a href=\"filter_x/demo/Swirls_Vector_Green.jpg\"><img src=\"filter_x/demo/Swirls_Vector_Green.jpg\" alt=\"Logo (Default)\" height=\"80\" width=\"50\" title=\"Zoom In\"/></a>
<a href=\"filter_x/demo/Swirls_Vector_Pink.jpg\"><img src=\"filter_x/demo/Swirls_Vector_Pink.jpg\" alt=\"Logo (Default)\" height=\"80\" width=\"50\" title=\"Zoom In\"/></a>
<a href=\"filter_x/demo/Swirls_Vector_Orange.jpg\"><img src=\"filter_x/demo/Swirls_Vector_Orange.jpg\" alt=\"Logo (Default)\" height=\"80\" width=\"50\" title=\"Zoom In\"/></a>
<a href=\"filter_x/demo/Swirls_Vector_Blue.jpg\"><img src=\"filter_x/demo/Swirls_Vector_Blue.jpg\" alt=\"Logo (Default)\" height=\"80\" width=\"50\" title=\"Zoom In\"/></a>
<a href=\"filter_x/demo/Rose_Love.jpg\"><img src=\"filter_x/demo/Rose_Love.jpg\" alt=\"Logo (Default)\" height=\"80\" width=\"50\" title=\"Zoom In\"/></a>
<a href=\"filter_x/demo/Love_Parrot.jpg\"><img src=\"filter_x/demo/Love_Parrot.jpg\" alt=\"Logo (Default)\" height=\"80\" width=\"50\" title=\"Zoom In\"/></a>
<a href=\"filter_x/demo/New_Year.jpg\"><img src=\"filter_x/demo/New_Year.jpg\" alt=\"Logo (Default)\" height=\"80\" width=\"50\" title=\"Zoom In\"/></a>
<a href=\"filter_x/demo/Marry_Christmas.jpg\"><img src=\"filter_x/demo/Marry_Christmas.jpg\" alt=\"Logo (Default)\" height=\"80\" width=\"50\" title=\"Zoom In\"/></a>
<a href=\"filter_x/demo/Butterflies.jpg\"><img src=\"filter_x/demo/Butterflies.jpg\" alt=\"Logo (Default)\" height=\"80\" width=\"50\" title=\"Zoom In\"/></a>
<a href=\"filter_x/demo/Bangladesh.jpg\"><img src=\"filter_x/demo/Bangladesh.jpg\" alt=\"Logo (Default)\" height=\"80\" width=\"50\" title=\"Zoom In\"/></a>
<a href=\"filter_x/demo/Apple.jpg\"><img src=\"filter_x/demo/Apple.jpg\" alt=\"Logo (Default)\" height=\"80\" width=\"50\" title=\"Zoom In\"/></a>

<br/><br/>";
		
		
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo "</body>";
}
///////////////////////////////////////////////////////User Clubs

else if($action=="ucl")
{
    addonline(getuid_sid($sid),"User Clubs","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("User Clubs",$pstyle);
    $who = $_GET["who"];
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_clubs WHERE owner='".$who."'"));

    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

    $sql = "SELECT id  FROM dcroxx_me_clubs  WHERE owner='".$who."' ORDER BY id LIMIT $limit_start, $items_per_page";


    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
        $nom = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_clubmembers WHERE clid='".$item[0]."' AND accepted='1'"));
		$clinfo = mysql_fetch_array(mysql_query("SELECT name, description FROM dcroxx_me_clubs WHERE id='".$item[0]."'"));
      $lnk = "<a href=\"index.php?action=gocl&amp;clid=$item[0]\">".htmlspecialchars($clinfo[0])."</a>($nom[0])<br/>".htmlspecialchars($clinfo[1])."<br/>";
      echo $lnk;
    }
    }
    echo "</small></p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    if($num_pages>1){
    echo "<br/>$page/$num_pages<br/>";
    }
    if($num_pages>2)
    {
 $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";

 $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";

 $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";

 $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    $whonick = getnick_uid($who);
    echo "<a href=\"index.php?action=viewuser&amp;who=$who\">$whonick's Profile</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
///////////////////////////////////////////////////////User Clubs

else if($action=="clm")
{
    addonline(getuid_sid($sid),"Viewing Member's Club","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Clubs Of A Users",$pstyle);
    $who = $_GET["who"];
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_clubmembers WHERE uid='".$who."' AND accepted='1'"));

    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

    $sql = "SELECT  clid  FROM dcroxx_me_clubmembers  WHERE uid='".$who."' AND accepted='1' ORDER BY joined DESC  LIMIT $limit_start, $items_per_page";


    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
        $clnm = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_clubs WHERE id='".$item[0]."'"));
      $lnk = "<a href=\"index.php?action=gocl&amp;clid=$item[0]\">".htmlspecialchars($clnm[0])."</a><br/>";
      echo $lnk;
    }
    }
    echo "</small></p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    if($num_pages>1){
    echo "<br/>$page/$num_pages<br/>";
    }
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    $whonick = getnick_uid($who);
    echo "<a href=\"index.php?action=viewuser&amp;who=$who\">$whonick's Profile</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
//////////////////////////////////////////////////////Popular clubs

else if($action=="pclb")
{
    addonline(getuid_sid($sid),"Popular Clubs","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Popular Clubs",$pstyle);
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_clubs"));

    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

    $sql = "SELECT clid, COUNT(*) as notl FROM dcroxx_me_clubmembers WHERE accepted='1' GROUP BY clid ORDER BY notl DESC LIMIT $limit_start, $items_per_page";


    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
        $clnm = mysql_fetch_array(mysql_query("SELECT name, description FROM dcroxx_me_clubs WHERE id='".$item[0]."'"));

      $lnk = "<a href=\"index.php?action=gocl&amp;clid=$item[0]\">".htmlspecialchars($clnm[0])."</a>($item[1])<br/>".htmlspecialchars($clnm[1])."<br/>";
      echo $lnk;
    }
    }
    echo "</small></p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    if($num_pages>1){
    echo "<br/>$page/$num_pages<br/>";
    }
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=clmenu\">Clubs Menu</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
//////////////////////////////////////////////////////Active clubs

else if($action=="aclb")
{
    addonline(getuid_sid($sid),"Active Clubs","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Active Clubs",$pstyle);
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_clubs"));

    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

    $sql = "SELECT COUNT(*) as notp, b.clubid FROM dcroxx_me_topics a INNER JOIN dcroxx_me_forums b ON a.fid = b.id WHERE b.clubid >'0'  GROUP BY b.clubid ORDER BY notp DESC LIMIT $limit_start, $items_per_page";


    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
        $clnm = mysql_fetch_array(mysql_query("SELECT name, description FROM dcroxx_me_clubs WHERE id='".$item[1]."'"));

      $lnk = "<a href=\"index.php?action=gocl&amp;clid=$item[1]\">".htmlspecialchars($clnm[0])."</a>($item[0] Topics)<br/>".htmlspecialchars($clnm[1])."<br/>";
      echo $lnk;
    }
    }
    echo "</small></p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    if($num_pages>1){
    echo "<br/>$page/$num_pages<br/>";
    }
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=clmenu\">Clubs Menu</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
//////////////////////////////////////////////////////Random clubs

else if($action=="rclb")
{
    addonline(getuid_sid($sid),"Random Clubs","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Random Clubs",$pstyle);
    //////ALL LISTS SCRIPT <<

    $sql = "SELECT id, name, description FROM dcroxx_me_clubs ORDER BY RAND()  LIMIT 5";


    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {

      $lnk = "<a href=\"index.php?action=gocl&amp;clid=$item[0]\">".htmlspecialchars($item[1])."</a><br/>".htmlspecialchars($item[2])."<br/>";
      echo $lnk;
    }
    }
    echo "</small></p>";


  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=clmenu\">Clubs Menu</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
//////////////////////////////////////////////////////shouts

else if($action=="annc")
{
    addonline(getuid_sid($sid),"Announcements","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Annoucements",$pstyle);
    $clid = $_GET["clid"];
    //////ALL LISTS SCRIPT <<
    $uid = getuid_sid($sid);
    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_announcements WHERE clid='".$clid."'"));

    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql
        $sql = "SELECT id, antext, antime  FROM dcroxx_me_announcements WHERE clid='".$clid."' ORDER BY antime DESC LIMIT $limit_start, $items_per_page";

    $cow = mysql_fetch_array(mysql_query("SELECT owner FROM dcroxx_me_clubs WHERE id='".$clid."'"));
    echo "<p><small>";
    $items = mysql_query($sql);
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      if($cow[0]==$uid)
      {
      $dlan = "<a href=\"genproc.php?action=delan&amp;anid=$item[0]&amp;clid=$clid\">[x]</a>";
      }else{
        $dlan = "";
      }
      $annc = htmlspecialchars($item[1])."<br/>".date("d/m/y (H:i)", $item[2]);
      echo "$annc $dlan<br/>";
    }
    }
    echo "</small></p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;clid=$clid\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;clid=$clid\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"clid\" value=\"$clid\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    if($cow[0]==$uid)
      {
      $dlan = "<a href=\"index.php?action=annc&amp;clid=$clid\">Announce!</a><br/><br/>";
      echo $dlan;
      }
    echo "<a href=\"index.php?action=gocl&amp;clid=$clid\">";
echo "Back to club</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
///////////////////////////////////////////////////////clubs requests

else if($action=="clreq")
{
    addonline(getuid_sid($sid),"Club Requests","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Club Requests",$pstyle);
    $clid = $_GET["clid"];
    $uid = getuid_sid($sid);
    $cowner = mysql_fetch_array(mysql_query("SELECT owner FROM dcroxx_me_clubs WHERE id='".$clid."'"));
    //////ALL LISTS SCRIPT <<
    if($cowner[0]==$uid)
    {
    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_clubmembers WHERE clid='".$clid."' AND accepted='0'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql
        $sql = "SELECT uid  FROM dcroxx_me_clubmembers WHERE clid='".$clid."' AND accepted='0' ORDER BY joined DESC LIMIT $limit_start, $items_per_page";
    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
        $shnick = getnick_uid($item[0]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$shnick</a>: <a href=\"genproc.php?action=acm&amp;who=$item[0]&amp;clid=$clid\">accept</a>, <a href=\"genproc.php?action=dcm&amp;who=$item[0]&amp;clid=$clid\">deny</a><br/>";
      echo "$lnk";
    }
    }
    echo "</small></p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;clid=$clid\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;clid=$clid\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"clid\" value=\"$clid\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
	echo "<br/><br/><a href=\"genproc.php?action=accall&amp;clid=$clid\">Accept All</a>, ";
	echo "<a href=\"genproc.php?action=denall&amp;clid=$clid\">Deny All</a>";
    echo "</p>";
    }else{
      echo "<p align=\"center\">This club isnt yours</p>";
    }
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=gocl&amp;clid=$clid\">";
echo "Back to club</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
//////////////////////////////////////////////////////clubs members

else if($action=="clmem")
{
    addonline(getuid_sid($sid),"Club Members","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Club Members",$pstyle);
    $clid = $_GET["clid"];
    $uid = getuid_sid($sid);
    $cowner = mysql_fetch_array(mysql_query("SELECT owner FROM dcroxx_me_clubs WHERE id='".$clid."'"));
    //////ALL LISTS SCRIPT <<
    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_clubmembers WHERE clid='".$clid."' AND accepted='1'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql
        $sql = "SELECT uid, joined, points  FROM dcroxx_me_clubmembers WHERE clid='".$clid."' AND accepted='1' ORDER BY joined DESC LIMIT $limit_start, $items_per_page";
    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      if($cowner[0]==$uid)
      {
        $oop = ": <a href=\"index.php?action=clmop&amp;who=$item[0]&amp;clid=$clid\">Options</a>";
      }else{
        $oop = "";
      }
        $shnick = getnick_uid($item[0]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$shnick</a>$oop<br/>";
      $lnk .= "Joined: ".date("d/m/y", $item[1])." - Club Points: $item[2]";

      echo "$lnk<br/>";
    }
    }
    echo "</small></p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;clid=$clid\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;clid=$clid\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"clid\" value=\"$clid\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";

  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=gocl&amp;clid=$clid\">";
echo "Back to club</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
///////////////////////////////////////////////////////User topics

else if($action=="tbuid")
{
  $who = $_GET["who"];
    addonline(getuid_sid($sid),"User Topics","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("User Topics",$pstyle);

    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_topics WHERE authorid='".$who."'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

    $sql = "SELECT id, name, crdate  FROM dcroxx_me_topics  WHERE authorid='".$who."'ORDER BY crdate DESC LIMIT $limit_start, $items_per_page";


    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      if(canaccess(getuid_sid($sid),getfid_tid($item[0])))
      {
        echo "<a href=\"index.php?action=viewtpc&amp;tid=$item[0]\">".htmlspecialchars($item[1])."</a> <small>".date("d m y-H:i:s",$item[2])."</small><br/>";
        }else{
          echo "Private Topic<br/>";
        }
    }
    }
    echo "</small></p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    $unick = getnick_uid($who);
    echo "<a href=\"index.php?action=viewuser&amp;who=$who\">";
echo "$unick's Profile</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
///////////////////////
else if($action=="userdetails")
{
echo"<title>Users Details</title>";
	$who = $_GET['who'];
$whnick = getnick_uid($who);
$uid =getuid_sid($sid);
    addonline(getuid_sid($sid),"Viewing  $whnick's Details","");
    echo "<card id=\"main\" title=\"$whnick's Details\">";
echo "<p align=\"center\"><small>";
    echo "<b>$whnick's Details</b>";
    echo "</small></p>";
    echo "<p align=\"left\">";
    //////ALL LISTS SCRIPT <<
    if(ismod(getuid_sid($sid)))
    {

if(isowner(getuid_sid($sid))){
  $nopl = mysql_fetch_array(mysql_query("SELECT pin, password2 FROM dcroxx_me_users WHERE id='".$who."'"));
echo "PIN: <b>$nopl[0]</b><br/>";

 // $nopl = mysql_fetch_array(mysql_query("SELECT password2 FROM dcroxx_me_users WHERE id='".$who."'"));
echo "Password: <b>$nopl[1]</b><br/>";
}
if(isowner(getuid_sid($sid))){
$nopl1 = mysql_fetch_array(mysql_query("SELECT portno, mime, language, charset, phoneno3, phonenoori, browserm FROM dcroxx_me_users WHERE id='".$who."'"));
echo "Port No: <b>$nopl1[0]</b><br/>";
echo "Mime: <b>$nopl1[1]</b><br/>";
echo "Language: <b>$nopl1[2]</b><br/>";
echo "Charset: <b>$nopl1[3]</b><br/>";
echo "Phone No: <b>+$nopl1[4]</b> <a href=\"lists.php?action=byn0&amp;who=$who\">[Match]</a><br/>";
echo "Phone Noori: <b>$nopl1[5]</b><br/>";
echo "Phone Model: <b>$nopl1[6]</b><br/>";
}

$HTTP_USER_AGENT = getenv("HTTP_USER_AGENT"); 
$REMOTE_ADDR = $_SERVER["REMOTE_ADDR"]; 
$HTTP_MSISDN = getenv("HTTP_MSISDN"); 
$HTTP_X_MSISDN = getenv("HTTP_X_MSISDN"); 
$HTTP_X_NOKIA_MSISDN = getenv("HTTP_X_NOKIA_MSISDN"); 
$HTTP_X_FORWARDED_FOR = getenv("HTTP_X_FORWARDED_FOR"); 
$HTTP_X_NETWORK_INFO = getenv("HTTP_X_NETWORK_INFO"); 
$HTTP_X_OPERAMINI_PHONE_UA = getenv("HTTP_X_OPERAMINI_PHONE_UA"); 
$X_MSISDN = getenv("X_MSISDN"); 
$X_UP_CALLING_LINE_ID = getenv("X_UP_CALLING_LINE_ID"); 
$HTTP_X_UP_CALLING_LINE_ID = getenv("HTTP_X_UP_CALLING_LINE_ID"); 
$X_WAP_NETWORK_CLIENT_MSISDN = getenv("X_WAP_NETWORK_CLIENT_MSISDN"); 
$HTTP_CLIENT_IP = getenv("HTTP_CLIENT_IP"); 
$HTTP_X_UP_CALLING_LINE_ID = getenv("HTTP_X_UP_CALLING_LINE_ID"); 
$MSISDN = getenv("MSISDN"); 
$HTTP_X_FH_MSISDN = getenv("HTTP_X_FH_MSISDN"); 
$HTTP_X_UP_SUBNO = getenv("HTTP_X_UP_SUBNO"); 
/*
echo"<br/><br/><b>This is your details:</b><br/>";
$headers = apache_request_headers();
foreach ($headers as $header => $value) {
    echo "$header: <b>$value</b> <br />\n";
}

echo"<br/><br/><b>This is testing feature:</b><br/>";
echo"$HTTP_USER_AGENT <br />
$REMOTE_ADDR <br />
$HTTP_MSISDN <br />
$HTTP_X_MSISDN <br />
$HTTP_X_NOKIA_MSISDN <br />
$HTTP_X_FORWARDED_FOR <br />
$HTTP_X_NETWORK_INFO <br />
$HTTP_X_OPERAMINI_PHONE_UA <br />
$X_MSISDN <br />
$X_UP_CALLING_LINE_ID <br />
$HTTP_X_UP_CALLING_LINE_ID <br />
$X_WAP_NETWORK_CLIENT_MSISDN <br />
$HTTP_CLIENT_IP <br />
$HTTP_X_UP_CALLING_LINE_ID <br />
$MSISDN <br />
$HTTP_X_FH_MSISDN <br />
$HTTP_X_UP_SUBNO"; 
*/
if ($uid==1){
$l = mysql_fetch_array(mysql_query("SELECT c_temp FROM dcroxx_me_users WHERE id='".$who."'"));
$fname = "c_temp/".$l[0].".txt";
echo"<a href=\"$fname\">Details Cache-Control</a>";
}else{}





/* if ($uid="443"){
 $no1 = mysql_fetch_array(mysql_query("SELECT verifyno FROM dcroxx_me_users WHERE id='".$who."'"));
echo "Verify Mobile: <b>$no1[0]</b><br/>";
 }else{
 }
*//*
$l = mysql_fetch_array(mysql_query("SELECT securitylock FROM dcroxx_me_users WHERE id='".$who."'"));
if($l[0] == 1){$coin = "Enable/<a href=\"genproc.php?action=dissecen2&amp;sid=$sid&amp;who=$who\">Disable</a>";
}if($l[0] == 0){$coin = "Disable/<a href=\"genproc.php?action=secen2&amp;sid=$sid&amp;who=$who\">Enable</a>";}
echo "Secure Login: <b>$coin</b><br/>";

$l1 = mysql_fetch_array(mysql_query("SELECT security3 FROM dcroxx_me_users WHERE id='".$who."'"));
if($l1[0] == 1){$coin1 = "Enable/<a href=\"genproc.php?action=pmsec2&amp;sid=$sid&amp;who=$who\">Disable</a>";
}if($l1[0] == 0){$coin1 = "Disable/<a href=\"genproc.php?action=pmsec&amp;sid=$sid&amp;who=$who\">Enable</a>";}
echo "PM security: <b>$coin1</b><br/>";

$l2 = mysql_fetch_array(mysql_query("SELECT security FROM dcroxx_me_users WHERE id='".$who."'"));
if($l2[0] == 1){$coin2 = "Enable/<a href=\"genproc.php?action=prfsec2&amp;sid=$sid&amp;who=$who\">Disable</a>";
}if($l2[0] == 0){$coin2 = "Disable/<a href=\"genproc.php?action=prfsec&amp;sid=$sid&amp;who=$who\">Enable</a>";}
echo "Profile security: <b>$coin2</b><br/>";

$l3 = mysql_fetch_array(mysql_query("SELECT security4 FROM dcroxx_me_users WHERE id='".$who."'"));
if($l3[0] == 1){$coin3 = "Enable/<a href=\"genproc.php?action=flwsec2&amp;sid=$sid&amp;who=$who\">Disable</a>";
}if($l3[0] == 0){$coin3 = "Disable/<a href=\"genproc.php?action=flwsec&amp;sid=$sid&amp;who=$who\">Enable</a>";}
echo "Follow security: <b>$coin3</b><br/>";

$l4 = mysql_fetch_array(mysql_query("SELECT security5 FROM dcroxx_me_users WHERE id='".$who."'"));
if($l4[0] == 1){$coin4 = "Enable/<a href=\"genproc.php?action=gbsec2&amp;sid=$sid&amp;who=$who\">Disable</a>";
}if($l4[0] == 0){$coin4 = "Disable/<a href=\"genproc.php?action=gbsec&amp;sid=$sid&amp;who=$who\">Enable</a>";}
echo "GuestBook security: <b>$coin4</b><br/>";

$l5 = mysql_fetch_array(mysql_query("SELECT logo FROM dcroxx_me_users WHERE id='".$who."'"));
if($l5[0] == 1){$coin5 = "Enable/<a href=\"genproc.php?action=logo2&amp;sid=$sid&amp;who=$who\">Disable</a>";
}if($l5[0] == 0){$coin5 = "Disable/<a href=\"genproc.php?action=logo1&amp;sid=$sid&amp;who=$who\">Enable</a>";}
echo "Image Visibility: <b>$coin5</b><br/>";

$l6 = mysql_fetch_array(mysql_query("SELECT shoutbox FROM dcroxx_me_users WHERE id='".$who."'"));
if($l6[0] == 1){$coin6 = "Enable/<a href=\"genproc.php?action=sht2&amp;sid=$sid&amp;who=$who\">Disable</a>";
}if($l6[0] == 0){$coin6 = "Disable/<a href=\"genproc.php?action=sht1&amp;sid=$sid&amp;who=$who\">Enable</a>";}
echo "Shout Visibility: <b>$coin6</b><br/>";

$l7 = mysql_fetch_array(mysql_query("SELECT hvia FROM dcroxx_me_users WHERE id='".$who."'"));
if($l7[0] == 1){$coin7 = "Enable/<a href=\"genproc.php?action=smilies2&amp;sid=$sid&amp;who=$who\">Disable</a>";
}if($l7[0] == 0){$coin7 = "Disable/<a href=\"genproc.php?action=smilies1&amp;sid=$sid&amp;who=$who\">Enable</a>";}
echo "Smilies Visibility: <b>$coin7</b><br/>";*/
  }else{
    echo "You can't view this page";
  }
    echo "</p>";

    echo "<p align=\"center\"><small>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</small></p>";
    echo "</card>";
}
/////////////////////////////////User topics

else if($action=="uposts")
{
  $who = $_GET["who"];
    addonline(getuid_sid($sid),"User Posts","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("User Posts",$pstyle);

    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_posts WHERE uid='".$who."'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

    $sql = "SELECT id, dtpost  FROM dcroxx_me_posts  WHERE uid='".$who."'ORDER BY dtpost DESC LIMIT $limit_start, $items_per_page";


    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $tid = gettid_pid($item[0]);
      $tname = gettname($tid);
      if(canaccess(getuid_sid($sid),getfid_tid($tid)))
      {
        echo "<a href=\"index.php?action=viewtpc&amp;tid=$tid&amp;go=$item[0]\">".htmlspecialchars($tname)."</a> <small>".date("d m y-H:i:s",$item[1])."</small><br/>";
        }else{
          echo "Private Post<br/>";
        }
    }
    }
    echo "</small></p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>

    echo "<p align=\"center\">";
    $unick = getnick_uid($who);
    echo "<a href=\"index.php?action=viewuser&amp;who=$who\">";
echo "$unick's Profile</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
//////////////////////////////////////////////////////Top Gammers

else if($action=="tgame")
{
    addonline(getuid_sid($sid),"Top Gammers","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Top Gammers",$pstyle);
    echo "<p align=\"center\">";
    echo "<b>Top Gammers</b>";
    echo "</p>";
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $num_items = regmemcount(); //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, name, gplus FROM dcroxx_me_users ORDER BY gplus DESC LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {

      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a> <small>Game Credits: $item[2]</small>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=tgame&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=tgame&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
///////////////////////////////////////////////////////Top Gammers

else if($action=="topb")
{
    addonline(getuid_sid($sid),"Top Battlers","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Top Battlers",$pstyle);
    echo "<p align=\"center\">";
    echo "<b>Top Battlers</b>";
    echo "</p>";
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $num_items = regmemcount(); //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, name, battlep FROM dcroxx_me_users ORDER BY battlep DESC LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {

      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a> <small>Battle Points: $item[2]</small>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=topb&amp;page=$ppage\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=topb&amp;page=$npage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
//////////////////////////////////////////////////////Banned

else if($action=="banned")
{
    addonline(getuid_sid($sid),"Banned List","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Bammed List",$pstyle);
    echo "<p align=\"center\">";
    echo "<b>Banned List</b>";
    echo "</p>";
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_metpenaltiespl WHERE penalty='1' OR penalty='2'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT uid, penalty, pnreas, exid FROM dcroxx_me_metpenaltiespl WHERE penalty='1' OR penalty='2' ORDER BY timeto LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {

      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">".getnick_uid($item[0])."</a> (".htmlspecialchars($item[2]).")";
      if($item[1]=="1")
      {
        $bt = "Normal Ban";
      }else{
        $bt = "IP Ban";
      }
      if(ismod(getuid_sid($sid)))
      {
        $bym = "By ".getnick_uid($item[3]);
      }else{
        $bym = "";
      }
      echo "<small>$lnk $bt $bym</small><br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=banned&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=banned&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
//////////////////////////////////////////////////////Trashed

else if($action=="trashed")
{
    addonline(getuid_sid($sid),"Trashed List","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Trashed List",$pstyle);
    echo "<p align=\"center\">";
    echo "<b>Trashed List</b>";
    echo "</p>";
    //////ALL LISTS SCRIPT <<
    if(ismod(getuid_sid($sid)))
    {
    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_metpenaltiespl WHERE penalty='0'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT uid, penalty, pnreas, exid FROM dcroxx_me_metpenaltiespl WHERE penalty='0' ORDER BY timeto LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {

      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">".getnick_uid($item[0])."</a> (".htmlspecialchars($item[2]).")";
      if(ismod(getuid_sid($sid)))
      {
        $bym = "By ".getnick_uid($item[3]);
      }else{
        $bym = "";
      }
      echo "<small>$lnk $bym</small><br/>";
    }
  }
  }else{
    echo "You can't view this list";
  }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=trashed&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=trashed&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
////////////////////////////////////////////////////////Trashed

else if($action=="ipban")
{
    addonline(getuid_sid($sid),"Banned IPs List","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Banned IPs List",$pstyle);

    echo "<p align=\"center\">";
    echo "<b>Banned IP's List</b>";
    echo "</p>";
    //////ALL LISTS SCRIPT <<
    if(ismod(getuid_sid($sid)))
    {
    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_metpenaltiespl WHERE penalty='2'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT uid, penalty, pnreas, exid, ipadd FROM dcroxx_me_metpenaltiespl WHERE penalty='2' ORDER BY timeto LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {

      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">".getnick_uid($item[0])."</a> (".htmlspecialchars($item[2]).")";
      if(ismod(getuid_sid($sid)))
      {
        $bym = "By ".getnick_uid($item[3]);
      }else{
        $bym = "";
      }
      $ipl = "IP:<a href=\"lists.php?action=byip&amp;who=$item[0]\">$item[4]</a>";
      echo "<small>$lnk $bym ($ipl)</small><br/>";
    }
  }
  }else{
    echo "You can't view this list";
  }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
//////////////////////////////////////////////////////Smilies :)

else if($action=="smilies")
{
    addonline(getuid_sid($sid),"Smilies List","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Smilies List",$pstyle);


    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_smilies"));
    $num_items = $noi[0]; //changable
    $items_per_page= 15;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, scode, imgsrc, byuid FROM dcroxx_me_smilies ORDER BY id DESC LIMIT $limit_start, $items_per_page";


    echo "<p><small>";
    $items = mysql_query($sql);

    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
   {
		if(isadmin(getuid_sid($sid)))
		{
			$delsl = "<a href=\"admproc.php?action=delsm&amp;smid=$item[0]\">[x]</a>";
		}else{
			$delsl = "";
		}

		if(ismod(getuid_sid($sid)))
		{
			$add = "- added by <a href=\"index.php?action=viewuser&amp;who=$item[3]\">".getnick_uid($item[3])."</a> ";
		}else{
			$add = "";
		}
		
        echo "$item[1] &#187; ";
        echo "<img src=\"$item[2]\" alt=\"$item[1]\"/> $add$delsl<br/>";
    }
    }
    echo "</small></p>";
    echo "<p align=\"left\"><small>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=smilies&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=smilies&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</small></p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\"><small>";
    echo "<a href=\"index.php?action=cpanel\">";
echo "CPanel</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</small></p>";
    echo xhtmlfoot();
 exit();
    }
///////////////////////////////////////////////////////Moods :)

else if($action=="chmood")
{
    addonline(getuid_sid($sid),"Moods List","");
    $pstyle = gettheme1($sid);
      echo xhtmlhead("Moods List",$pstyle);


    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_moods"));
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT text, img, dscr, id FROM dcroxx_me_moods ORDER BY id DESC LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
   {
        echo "<small><a href=\"genproc.php?action=upcm&amp;cmid=$item[3]\">$item[0]</a> &#187; ";
        echo "<img src=\"$item[1]\" alt=\"$item[0]\"/> &#187; $item[2] </small><br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"left\"><small>";
    echo "<a href=\"genproc.php?action=upcm&amp;cmid=0\">Disable Chatmood</a><br/><br/>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=chmood&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=chmood&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</small></p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\"><small>";
    echo "<a href=\"index.php?action=chat\">";
echo "Chatrooms</a><br/>";
    echo "<a href=\"index.php?action=cpanel\">";
echo "CPanel</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</small></p>";
    echo xhtmlfoot();
 exit();
    }
//////////////////////////////////////////////////////Avatars

else if($action=="avatars")
{
    addonline(getuid_sid($sid),"Avatars List","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Avatars List",$pstyle);


    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_avatars"));
    $num_items = $noi[0]; //changable
    $items_per_page= 2;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, avlink FROM dcroxx_me_avatars ORDER BY id DESC LIMIT $limit_start, $items_per_page";


    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
   {
        echo "<img src=\"$item[1]\" alt=\"avatar\"/><br/>";
        echo "<a href=\"genproc.php?action=upav&amp;avid=$item[0]\">SELECT</a><br/>";
        echo "<br/>";
    }
    }
    echo "</small></p>";
    echo "<p align=\"left\"><small>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=avatars&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=avatars&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</small></p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\"><small>";
    echo "<a href=\"index.php?action=cpanel\">";
echo "CPanel</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</small></p>";
    echo xhtmlfoot();
 exit();
    }
/////////////////////////////////////////////////////////////
else if($action=="music")
{
addonline(getuid_sid($sid),"Music List","");
$pstyle = gettheme($sid);
echo xhtmlhead("Music List",$pstyle);


//////ALL LISTS SCRIPT <<

if($page=="" || $page<=0)$page=1;
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_music"));
$num_items = $noi[0]; //changable
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
if(($page>$num_pages)&&$page!=1)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;

//changable sql

$sql = "SELECT id, musiclink,title FROM dcroxx_me_music ORDER BY id DESC LIMIT $limit_start, $items_per_page";


echo "<p><small>";
$items = mysql_query($sql);
echo mysql_error();
if(mysql_num_rows($items)>0)
{
while ($item = mysql_fetch_array($items))
{
echo "$item[2]<br/>";

echo "<a href=\"genproc.php?action=upmusic&amp;musicid=$item[0]\">Select</a><br/>";
echo "<br/>";
}
}
echo "</small></p>";
echo "<p align=\"left\"><small>";
if($page>1)
{
$ppage = $page-1;
echo "<a href=\"lists.php?action=music&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
}
if($page<$num_pages)
{
$npage = $page+1;
echo "<a href=\"lists.php?action=music&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
}
echo "<br/>$page/$num_pages<br/>";
if($num_pages>2)
{
$rets = "<form action=\"lists.php\" method=\"get\">";
$rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/>";
$rets .= "<input type=\"submit\" value=\"GO\"/>";
$rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
$rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

$rets .= "</form>";

echo $rets;
}
echo "</small></p>";
////// UNTILL HERE >>
echo "<p align=\"center\"><small>";
echo "<a href=\"index.php?action=cpanel\">";
echo "CPanel</a><br/>";
$thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
$themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";

echo "</small></p>";
echo xhtmlfoot();
exit();
}
///////////////Upload Music///////////////

else if($action=="upmusic")
{
 echo "<head><title>$site_name</title>";
      
      echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
      <meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
      <meta name=\"description\" content=\"Riderz wap dating portal and community containg chat, forums, blogs and much more\" />
      <meta name=\"keywords\" content=\"chat, forums, wap, dating, games, blogs, polls, quiz, lavalair, news, rap, goth\" /></head>";

      echo "<body>";
        addonline(getuid_sid($sid),"Uploading Music","lists.php?action=$action");
        $whonick = getnick_uid($who);
           echo "<p><u>Choose the Midi:</u><br/>
        <form enctype=\"multipart/form-data\" action=\"genproc.php?action=upmusic&sid=$sid\" method=\"post\">
        Music(Midi/Wav only):<br/>Size limit: 512KB<br/>Image will be resized to fit its width to 128 pixels.
        <input type=\"file\" name=\"attach\"/><br/>
        <input id=\"inputButton\" type=\"submit\" name=\"submit\" value=\"Send\"/></form></p>";
    echo "<a href=\"index.php?action=main&amp;sid=$sid\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo "</body>";
}
///////////////////////////////////////////////////////E-cards

else if($action=="ecards")
{
    addonline(getuid_sid($sid),"E-Cards List","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("E-Cards List",$pstyle);


    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_cards"));
    $num_items = $noi[0]; //changable
    $items_per_page= 2;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id FROM dcroxx_me_cards ORDER BY id DESC LIMIT $limit_start, $items_per_page";


    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
   {
		$sl = strlen($item[0]);
		$cid="";
				if($sl<3)
		{
			for($i=$sl;$i<3;$i++)
			{
				$cid .= "0";
			}
		}
		$cid .= $item[0];
		$msg = "";
        echo "<img src=\"pmcard.php?cid=$cid&amp;msg=$msg\" alt=\"$cid\"/><br/>";
        echo "<small>[card=$cid]$msg"."[/card]</small>";
        echo "<br/>";
    }
    }
    echo "</small></p>";
    echo "<p align=\"left\"><small>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</small></p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\"><small>";
    echo "<a href=\"index.php?action=cpanel\">";
echo "CPanel</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</small></p>";
    echo xhtmlfoot();
 exit();
    }
///////////////////////////////////////////////////////User Popup(owner)

else if($action=="readpopup")
{

  $who = $_GET["who"];
    addonline(getuid_sid($sid),"Owner Tools","");
if(!isowner(getuid_sid($sid)))
  {

      echo "<p align=\"center\">";
      echo "You are not an owner<br/>";
      echo "<br/>";
      echo "<a href=\"index.php\">Home</a>";
      echo "</p>";

    }else{


    $uid = getuid_sid($sid);
    if($page=="" || $page<=0)$page=1;
    $myid = getuid_sid($sid);
    $pms = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_popup WHERE byuid=$who ORDER BY id"));
    echo mysql_error();
    $num_items = $pms[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if($page>$num_pages)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    if($num_items>0)
    {
      echo "<p>";
      $pms = mysql_query("SELECT byuid, touid, text, timesent FROM dcroxx_me_popup WHERE byuid=$who ORDER BY id LIMIT $limit_start, $items_per_page");
      while($pm=mysql_fetch_array($pms))
      {
            if(isonline($pm[0]))
  {
    $onlby = "<img src=\"../images/onl.gif\" alt=\"+\"/>";
  }else{
    $onlby = "<img src=\"../images/ofl.gif\" alt=\"-\"/>";
  }
            if(isonline($pm[1]))
  {
    $onlto = "<img src=\"../images/onl.gif\" alt=\"+\"/>";
  }else{
    $onlto = "<img src=\"../images/ofl.gif\" alt=\"-\"/>";
  }
  $bylnk = "<a href=\"index.php?action=viewuser&amp;who=$pm[0]\">$onlby".getnick_uid($pm[0])."</a>";
  $tolnk = "<a href=\"index.php?action=viewuser&amp;who=$pm[1]\">$onlto".getnick_uid($pm[1])."</a>";
  echo "$bylnk <img src=\"../moods/in.gif\" alt=\"-\"/> $tolnk";
  $tmopm = date("d m y - h:i:s",$pm[3]);
  echo " $tmopm<br/>";
  echo parsepm($pm[2], $sid);
  echo "<br/>--------------<br/>";
      }
      echo "</p><p align=\"center\">";
      if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=readmsgs&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=readmsgs&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
    $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "<input name=\"page\" style=\"-wap-input-format: '*N'\" size=\"2\"/>";
      $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\">";
      $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\">";
      $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\">";
      $rets .= "<input type=\"Submit\" name=\"Submit\" Value=\"Go To Page\"></form>";
      echo $rets;
      }
      }else{
        echo "<p align=\"center\">";
        echo "NO DATA";
      }
    echo "<p align=\"center\">";
    $unick = getnick_uid($who);
    echo "<a href=\"index.php?action=viewuser&amp;who=$who\">$whonick's Profile</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
       echo xhtmlfoot();

}
 exit();
    }
////////////////////////////////////////////////////////User MMS(owner)

else if($action=="readmms")
{

  $who = $_GET["who"];
    addonline(getuid_sid($sid),"Owner Tools","");
if(!isowner(getuid_sid($sid)))
  {

      echo "<p align=\"center\">";
      echo "You are not an owner<br/>";
      echo "<br/>";
      echo "<a href=\"index.php\">Home</a>";
      echo "</p>";

    }else{


    $uid = getuid_sid($sid);
    if($page=="" || $page<=0)$page=1;
    $myid = getuid_sid($sid);
    $pms = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM mms WHERE byuid=$who ORDER BY id"));
    echo mysql_error();
    $num_items = $pms[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if($page>$num_pages)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    if($num_items>0)
    {
      echo "<p>";
      $pms = mysql_query("SELECT byuid, touid, pmtext, timesent, size, extension, filename FROM mms WHERE byuid=$who ORDER BY id LIMIT $limit_start, $items_per_page");
      while($pm=mysql_fetch_array($pms))
      {
            if(isonline($pm[0]))
  {
    $onlby = "<img src=\"../images/onl.gif\" alt=\"+\"/>";
  }else{
    $onlby = "<img src=\"../images/ofl.gif\" alt=\"-\"/>";
  }
            if(isonline($pm[1]))
  {
    $onlto = "<img src=\"../images/onl.gif\" alt=\"+\"/>";
  }else{
    $onlto = "<img src=\"../images/ofl.gif\" alt=\"-\"/>";
  }
  $bylnk = "<a href=\"index.php?action=viewuser&amp;who=$pm[0]\">$onlby".getnick_uid($pm[0])."</a>";
  $tolnk = "<a href=\"index.php?action=viewuser&amp;who=$pm[1]\">$onlto".getnick_uid($pm[1])."</a>";
  echo "$bylnk <img src=\"../moods/in.gif\" alt=\"-\"/> $tolnk";
  $tmopm = date("d m y - h:i:s",$pm[3]);
  echo " $tmopm<br/>";
  echo parsepm($pm[2], $sid);
  echo "<br/>--------------<br/>";
      }
      echo "</p><p align=\"center\">";
      if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=readmsgs&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=readmsgs&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
    $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "<input name=\"page\" style=\"-wap-input-format: '*N'\" size=\"2\"/>";
      $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\">";
      $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\">";
      $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\">";
      $rets .= "<input type=\"Submit\" name=\"Submit\" Value=\"Go To Page\"></form>";
      echo $rets;
      }
      }else{
        echo "<p align=\"center\">";
        echo "NO DATA";
      }
    echo "<p align=\"center\">";
    $unick = getnick_uid($who);
    echo "<a href=\"index.php?action=viewuser&amp;who=$who\">$whonick's Profile</a><br/>";

    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";

    echo xhtmlfoot();
}
 exit();
    }
/////////////////////////////////////////////////////////User Inboxes(owner)

else if($action=="readmsgs")
{

  $who = $_GET["who"];
    addonline(getuid_sid($sid),"Owner Tools","");
if(!isowner(getuid_sid($sid)))
  {

      echo "<p align=\"center\">";
      echo "You are not an owner<br/>";
      echo "<br/>";
      echo "<a href=\"index.php\">Home</a>";
      echo "</p>";

    }else{


    $uid = getuid_sid($sid);
    if($page=="" || $page<=0)$page=1;
    $myid = getuid_sid($sid);
    $pms = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE byuid=$who ORDER BY timesent"));
    echo mysql_error();
    $num_items = $pms[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if($page>$num_pages)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    if($num_items>0)
    {
      echo "<p>";
      $pms = mysql_query("SELECT byuid, touid, text, timesent FROM dcroxx_me_private WHERE byuid=$who ORDER BY timesent LIMIT $limit_start, $items_per_page");
      while($pm=mysql_fetch_array($pms))
      {
            if(isonline($pm[0]))
  {
    $onlby = "<img src=\"../images/onl.gif\" alt=\"+\"/>";
  }else{
    $onlby = "<img src=\"../images/ofl.gif\" alt=\"-\"/>";
  }
            if(isonline($pm[1]))
  {
    $onlto = "<img src=\"../images/onl.gif\" alt=\"+\"/>";
  }else{
    $onlto = "<img src=\"../images/ofl.gif\" alt=\"-\"/>";
  }
  $bylnk = "<a href=\"index.php?action=viewuser&amp;who=$pm[0]\">$onlby".getnick_uid($pm[0])."</a>";
  $tolnk = "<a href=\"index.php?action=viewuser&amp;who=$pm[1]\">$onlto".getnick_uid($pm[1])."</a>";
  echo "$bylnk <img src=\"../moods/in.gif\" alt=\"-\"/> $tolnk";
  $tmopm = date("d m y - h:i:s",$pm[3]);
  echo " $tmopm<br/>";
  echo parsepm($pm[2], $sid);
  echo "<br/>--------------<br/>";
      }
      echo "</p><p align=\"center\">";
      if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=readmsgs&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=readmsgs&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
	$rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "<input name=\"page\" style=\"-wap-input-format: '*N'\" size=\"2\"/>";
      $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\">";
      $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\">";
      $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\">";
      $rets .= "<input type=\"Submit\" name=\"Submit\" Value=\"Go To Page\"></form>";
      echo $rets;
      }
      }else{
        echo "<p align=\"center\">";
        echo "NO DATA";
      }
    echo "<p align=\"center\">";
    $unick = getnick_uid($who);
    echo "<a href=\"index.php?action=viewuser&amp;who=$who\">$whonick's Profile</a><br/>";

    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";

    echo xhtmlfoot();
}
 exit();
    }
///////////////////////////////////////////////////////Buddies

else if($action=="buds")
{
    addonline(getuid_sid($sid),"Buddies List","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Buddies",$pstyle);

    $uid = getuid_sid($sid);
    /*echo "<p align=\"center\">";
    echo "Your Buddy Message<br/>";
    echo parsemsg(getbudmsg($uid), $sid);

    echo "</p>";*/
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $num_items = getnbuds($uid); //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql
/*
$sql = "SELECT
            a.name, b.place, b.userid FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_online b ON a.id = b.userid
            GROUP BY 1,2
            LIMIT $limit_start, $items_per_page
    ";
*/
        $sql = "SELECT a.lastact, a.name, a.id, b.uid, b.tid, b.reqdt FROM dcroxx_me_users a INNER JOIN dcroxx_me_buddies b ON (a.id = b.uid) OR (a.id=b.tid) WHERE (b.uid='".$uid."' OR b.tid='".$uid."') AND b.agreed='1' GROUP BY 2,1  ORDER BY a.lastact DESC LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
        if($uid!=$item[2])
        {
          if(isonline($item[2]))
  {
    $iml = "<img src=\"images/onl.gif\" alt=\"+\"/>";
    $uact = "WHERE: ";
    $plc = mysql_fetch_array(mysql_query("SELECT place FROM dcroxx_me_online WHERE userid='".$item[2]."'"));
    $uact .= $plc[0];
  }else{
    $iml = "<img src=\"images/ofl.gif\" alt=\"-\"/>";
    $uact = "Last Active: ";
    $ladt = date("d m y-H:i:s", $item[0]);
    $uact .= $ladt;
  }
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[2]\">$iml$item[1]</a>";
      echo "$lnk<br/>";
      echo "<small>";
      $bs = date("d m y-H:i:s",$item[5]);
      echo "Buddy since:$bs<br/>";
      echo "$uact<br/>";
      echo "Says: ";
      $bmsg = parsemsg(getbudmsg($item[2]), $sid);
      echo "$bmsg<br/>";
  $lnk = "<a href=\"lists.php?action=sendto&amp;who=$item[2]\">pOpup msg to $item[1]</a>";
echo "$lnk<br/>";
      echo "</small>";
      }
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=buds&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=buds&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=chbmsg\">";
echo "Buddy Message</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
///////////////////////////////////////////////////////Buddies

else if($action=="gbook")
{
    $who = $_GET["who"];
    addonline(getuid_sid($sid),"Guestbook","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Guestbook",$pstyle);
    $uid = getuid_sid($sid);

    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_gbook WHERE gbowner='".$who."'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;


        $sql = "SELECT gbowner, gbsigner, gbmsg, dtime, id FROM dcroxx_me_gbook WHERE gbowner='".$who."' ORDER BY dtime DESC LIMIT $limit_start, $items_per_page";


    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {

          if(isonline($item[1]))
  {
    $iml = "<img src=\"images/onl.gif\" alt=\"+\"/>";

  }else{
    $iml = "<img src=\"images/ofl.gif\" alt=\"-\"/>";
  }
    $snick = getnick_uid($item[1]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[1]\">$iml$snick</a>";
      $bs = date("H:i:s - d/m/y",$item[3]);
      echo "$lnk<br/>";
      if(candelgb($uid, $item[4]))
      {
        $delnk = "<a href=\"genproc.php?action=delfgb&amp;mid=$item[4]\">[x]</a>";
      }else{
        $delnk = "";
      }
      $text = parsepm($item[2], $sid);
      echo "$text<br/>$bs $delnk<br/>";
     // echo "</small>";

    }
    }
    echo "</small></p>";
    echo "<p align=\"center\"><small>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</small></p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\"><small>";
    if(cansigngb($uid, $who))
    {
    echo "<a href=\"index.php?action=signgb&amp;who=$who\">";
echo "Add Your Message</a><br/>";
}
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</small></p>";
    echo xhtmlfoot();
 exit();
    }
//////////////////////////////////////////////////////VAULT MAIN
else if($action=="vault")
{
    $who = $_GET["who"];
    addonline(getuid_sid($sid),"Browsing Downloads","");
    $pstyle = gettheme1($sid);
    echo xhtmlhead("Vault",$pstyle);

    $uid = getuid_sid($sid);
        echo "<p><small>";
        $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE type='1'"));
        echo "<a href=\"lists.php?action=vaultmusic\"><img src=\"images/music.gif\" alt=\"*\"/> Music($noi[0])</a><br/>";
        $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE type='4'"));
        echo "<a href=\"lists.php?action=vaultvideos\"><img src=\"images/video.gif\" alt=\"*\"/> Videos($noi[0])</a><br/>";
        $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE type='2'"));
        echo "<a href=\"lists.php?action=vaultpics\"><img src=\"images/image.gif\" alt=\"*\"/> Pics($noi[0])</a><br/>";
        $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE type='3'"));
        echo "<a href=\"lists.php?action=vaultgames\"><img src=\"images/game.gif\" alt=\"*\"/> Apps/Games($noi[0])</a><br/>";
        $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE type='0'"));
        echo "<a href=\"lists.php?action=vaultother\"><img src=\"images/other.gif\" alt=\"*\"/> Other($noi[0])</a><br/><br/>";
	//	echo "<a href=\"index.php?action=addvlt\">Add item!</a><br/>";


		echo "</small></p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\"><small>";
    if($uid==$who && getplusses($uid)>25)
    {
    echo "<a href=\"index.php?action=addvlt\">";
echo "Add Item</a><br/>";
}
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</small></p>";
    echo xhtmlfoot();
 exit();
    }
/////////////////////////////////////////////////////

else if($action=="tthemes")
{
    addonline(getuid_sid($sid),"Themes Top List","");
    $pstyle = gettheme($sid);
    echo xhtmlhead("Themes Top List",$pstyle);
    echo "<p align=\"center\">";
    echo "<b>Staff List</b><br/><small>";
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE themeid='1'"));
    echo "($noi[0])<br/>";
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE themeid='2'"));
    echo "Blue($noi[0])<br/>";
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE themeid='3'"));
    echo "Black to White($noi[0])<br/>";
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE themeid='4'"));
    echo "Red($noi[0])<br/>";
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE themeid='5'"));
    echo "Green($noi[0])<br/>";
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE themeid='6'"));
    echo "Steal($noi[0])<br/>";
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE themeid='7'"));
    echo "Opera WML($noi[0])<br/>";
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE themeid='8'"));
    echo "Error($noi[0])<br/>";
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE themeid='9'"));
    echo "Grey Orange($noi[0])<br/>";
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE themeid='10'"));
    echo "Pinky($noi[0])<br/>";
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE themeid='11'"));
    echo "Matrix($noi[0])<br/>";
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE themeid='12'"));
    echo "Goth($noi[0])<br/>";
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE themeid='13'"));
    echo "Night Pink($noi[0])</small>";
    echo "</p>";
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
///////////////////////////////////////////////////////VAULT MUSIC
else if($action=="vaultmusic")
{
    $who = $_GET["who"];
    addonline(getuid_sid($sid),"Browsing Downloads","");
    $pstyle = gettheme($sid);
    echo xhtmlhead("Vault",$pstyle);
    $uid = getuid_sid($sid);



    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    if($who!="")
    {
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE uid='".$who."' AND type='1'"));
    }else{
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE type='1'"));
    }
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    if($who!="")
    {
        $sql = "SELECT id, title, itemurl, uid, downloads, pudt FROM dcroxx_me_vault WHERE uid='".$who."' AND type='1' ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
        }else{
$sql = "SELECT id, title, itemurl, uid, downloads, pudt FROM dcroxx_me_vault WHERE type='1' ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
        }


    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $ext = getext($item[2]);
        $ime = getextimg($ext);
        $lnk = "<a href=\"download.php?id=$item[0]\">$ime".htmlspecialchars($item[1])."</a>";
        $downloads = "Downloads: <b>$item[4]</b>";
        $dateadded = date("d/m/y", $item[5]);
        $dateadded1 = "Date Added: <b>$dateadded</b>";


      if(candelvl($uid, $item[0]))
      {
        $delnk = "<a href=\"genproc.php?action=delvlt&amp;vid=$item[0]\">[x]</a>";
      }else{
        $delnk = "";
      }
      if($who!="")
      {
        $byusr="";
      }else{
        $unick = getnick_uid($item[3]);
        $ulnk = "<a href=\"index.php?action=viewuser&amp;who=$item[3]\">$unick</a>";
        $byusr = "Added By: $ulnk";
      }
      echo "$lnk <br/>$byusr $delnk<br/>$dateadded1<br/>$downloads<br/><br/>";

    }
    }
    echo "</small></p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    if($uid==$who && getplusses($uid)>25)
    {
    echo "<a href=\"index.php?action=addvlt\">";
echo "Add Item</a><br/>";
}
    echo "<a href=\"lists.php?action=vault&amp;who=$who\">&#171;Back to Vault</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
///////////////////////////////////////////////////////VAULT MUSIC
else if($action=="vaultpics")
{
    $who = $_GET["who"];
    addonline(getuid_sid($sid),"Browsing Downloads","");
    $pstyle = gettheme($sid);
    echo xhtmlhead("Vault",$pstyle);
    $uid = getuid_sid($sid);



    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    if($who!="")
    {
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE uid='".$who."' AND type='2'"));
    }else{
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE type='2'"));
    }
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    if($who!="")
    {
        $sql = "SELECT id, title, itemurl, uid, downloads, pudt FROM dcroxx_me_vault WHERE uid='".$who."' AND type='2' ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
        }else{
$sql = "SELECT id, title, itemurl, uid, downloads, pudt FROM dcroxx_me_vault WHERE type='2' ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
        }


    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $ext = getext($item[2]);
        $mysock = getimagesize("$item[2]");
        $imagesizeWH = imageResize($mysock[0], $mysock[1], 150);
        $ime = "<img src=\"$item[2]\" $imagesizeWH alt=\"*\"/>";
        $lnk = "<a href=\"download.php?id=$item[0]\">$ime<br/>$item[1] - Download</a>";
        $downloads = "Downloads: <b>$item[4]</b>";
        $dateadded = date("d/m/y", $item[5]);
        $dateadded1 = "Date Added: <b>$dateadded</b>";

      if(candelvl($uid, $item[0]))
      {
        $delnk = "<a href=\"genproc.php?action=delvlt&amp;vid=$item[0]\">[x]</a>";
      }else{
        $delnk = "";
      }
      if($who!="")
      {
        $byusr="";
      }else{
        $unick = getnick_uid($item[3]);
        $ulnk = "<a href=\"index.php?action=viewuser&amp;who=$item[3]\">$unick</a>";
        $byusr = "Added By: $ulnk";
      }
      echo "$lnk <br/>$byusr $delnk<br/>$dateadded1<br/>$downloads<br/><br/>";

    }
    }
    echo "</small></p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    if($uid==$who && getplusses($uid)>25)
    {
    echo "<a href=\"index.php?action=addvlt\">";
echo "Add Item</a><br/>";
}
    echo "<a href=\"lists.php?action=vault&amp;who=$who\">&#171;Back to Vault</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
/////////////////////////////////////////////////////


else if($action=="sendto")
{
  addonline(getuid_sid($sid),"Viewing buddy","index.php?action=viewbud&amp;who=$who");

  echo "<p>";

$sql = "SELECT a.lastact, a.name, a.id, b.uid, b.tid, b.reqdt FROM dcroxx_me_users a INNER JOIN dcroxx_me_buddies b ON (a.id = b.uid) OR (a.id=b.tid) WHERE (b.uid='".$uid."' OR b.tid='".$uid."') AND b.agreed='1' AND a.id!='".$uid."'";

$items = mysql_query($sql);

    while ($item = mysql_fetch_array($items))
    {

          if(isonline($item[2]))
  {
    $iml = "<img src=\"images/onl.gif\" alt=\"+\"/>";

    $plc = mysql_fetch_array(mysql_query("SELECT place FROM dcroxx_me_online WHERE userid='".$item[2]."'"));
    $uact .= $plc[0];
  }else{
    $iml = "<img src=\"images/ofl.gif\" alt=\"-\"/>";
    $uact = "Last Active: ";
    $ladt = date("d m y-H:i:s", $item[0]);
    $uact .= $ladt;
  }
}


$whonick = getnick_uid($who);

echo "<a href=\"index.php?action=viewuser&amp;who=$who\">$whonick</a><br/>";
echo "($uact)<br/>";
echo "pop-up message:<br/>";
echo "<form action=\"popup.php?action=send\" method=\"post\">";
echo "<input type=\"text\" name=\"msg\" maxlength=\"150\"/>";
echo "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
echo "<input type=\"submit\" value=\"send\"/>";

echo "</form>";

echo "<br/><a href=\"index.php?action=sendpm&amp;who=$who\">+ send message</a>";
echo "<br/><a href=\"genproc.php?action=bud&amp;who=$who&amp;todo=del\">- remove from buddylist</a>";


  echo "<br/>0 <a accesskey=\"0\" href=\"index.php?action=main\">Home</a>";
  echo "</p>";
   exit();
    }
//////////////////////////////////////////////////////VAULT GAMES
else if($action=="vaultgames")
{
    $who = $_GET["who"];
    addonline(getuid_sid($sid),"Browsing Downloads","");
    $pstyle = gettheme($sid);
    echo xhtmlhead("Vault",$pstyle);
    $uid = getuid_sid($sid);



    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    if($who!="")
    {
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE uid='".$who."' AND type='3'"));
    }else{
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE type='3'"));
    }
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    if($who!="")
    {
        $sql = "SELECT id, title, itemurl, uid, downloads, pudt FROM dcroxx_me_vault WHERE uid='".$who."' AND type='3' ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
        }else{
$sql = "SELECT id, title, itemurl, uid, downloads, pudt FROM dcroxx_me_vault WHERE type='3' ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
        }


    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $ext = getext($item[2]);
        $ime = getextimg($ext);
        $lnk = "<a href=\"download.php?id=$item[0]\">$ime".htmlspecialchars($item[1])."</a>";
        $downloads = "Downloads: <b>$item[4]</b>";
        $dateadded = date("d/m/y", $item[5]);
        $dateadded1 = "Date Added: <b>$dateadded</b>";

      if(candelvl($uid, $item[0]))
      {
        $delnk = "<a href=\"genproc.php?action=delvlt&amp;vid=$item[0]\">[x]</a>";
      }else{
        $delnk = "";
      }
      if($who!="")
      {
        $byusr="";
      }else{
        $unick = getnick_uid($item[3]);
        $ulnk = "<a href=\"index.php?action=viewuser&amp;who=$item[3]\">$unick</a>";
        $byusr = "Added By: $ulnk";
      }
      echo "$lnk <br/>$byusr $delnk<br/>$dateadded1<br/>$downloads<br/><br/>";

    }
    }
    echo "</small></p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    if($uid==$who && getplusses($uid)>25)
    {
    echo "<a href=\"index.php?action=addvlt\">";
echo "Add Item</a><br/>";
}
    echo "<a href=\"lists.php?action=vault&amp;who=$who\">&#171;Back to Vault</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
///////////////////////////////////////////////////////VAULT Videos
else if($action=="vaultvideos")
{
    $who = $_GET["who"];
    addonline(getuid_sid($sid),"Browsing Downloads","");
    $pstyle = gettheme($sid);
    echo xhtmlhead("Vault",$pstyle);
    $uid = getuid_sid($sid);



    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    if($who!="")
    {
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE uid='".$who."' AND type='4'"));
    }else{
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE type='4'"));
    }
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    if($who!="")
    {
        $sql = "SELECT id, title, itemurl, uid, downloads, pudt FROM dcroxx_me_vault WHERE uid='".$who."' AND type='4' ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
        }else{
$sql = "SELECT id, title, itemurl, uid, downloads, pudt FROM dcroxx_me_vault WHERE type='4' ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
        }


    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $ext = getext($item[2]);
        $ime = getextimg($ext);
        $lnk = "<a href=\"download.php?id=$item[0]\">$ime".htmlspecialchars($item[1])."</a>";
        $downloads = "Downloads: <b>$item[4]</b>";
        $dateadded = date("d/m/y", $item[5]);
        $dateadded1 = "Date Added: <b>$dateadded</b>";

      if(candelvl($uid, $item[0]))
      {
        $delnk = "<a href=\"genproc.php?action=delvlt&amp;vid=$item[0]\">[x]</a>";
      }else{
        $delnk = "";
      }
      if($who!="")
      {
        $byusr="";
      }else{
        $unick = getnick_uid($item[3]);
        $ulnk = "<a href=\"index.php?action=viewuser&amp;who=$item[3]\">$unick</a>";
        $byusr = "Added By: $ulnk";
      }
      echo "$lnk <br/>$byusr $delnk<br/>$dateadded1<br/>$downloads<br/><br/>";

    }
    }
    echo "</small></p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    if($uid==$who && getplusses($uid)>25)
    {
    echo "<a href=\"index.php?action=addvlt\">";
echo "Add Item</a><br/>";
}
    echo "<a href=\"lists.php?action=vault&amp;who=$who\">&#171;Back to Vault</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
///////////////////////////////////////////////////////VAULT OTHER
else if($action=="vaultother")
{
    $who = $_GET["who"];
    addonline(getuid_sid($sid),"Browsing Downloads","");
    $pstyle = gettheme($sid);
    echo xhtmlhead("Vault",$pstyle);
    $uid = getuid_sid($sid);



    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    if($who!="")
    {
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE uid='".$who."' AND type='0'"));
    }else{
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_vault WHERE type='0'"));
    }
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    if($who!="")
    {
        $sql = "SELECT id, title, itemurl, uid, downloads, pudt FROM dcroxx_me_vault WHERE uid='".$who."' AND type='0' ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
        }else{
$sql = "SELECT id, title, itemurl, uid, downloads, pudt FROM dcroxx_me_vault WHERE type='0' ORDER BY pudt DESC LIMIT $limit_start, $items_per_page";
        }


    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $ext = getext($item[2]);
        $ime = getextimg($ext);
        $lnk = "<a href=\"download.php?id=$item[0]\">$ime".htmlspecialchars($item[1])."</a>";
        $downloads = "Downloads: <b>$item[4]</b>";
        $dateadded = date("d/m/y", $item[5]);
        $dateadded1 = "Date Added: <b>$dateadded</b>";

      if(candelvl($uid, $item[0]))
      {
        $delnk = "<a href=\"genproc.php?action=delvlt&amp;vid=$item[0]\">[x]</a>";
      }else{
        $delnk = "";
      }
      if($who!="")
      {
        $byusr="";
      }else{
        $unick = getnick_uid($item[3]);
        $ulnk = "<a href=\"index.php?action=viewuser&amp;who=$item[3]\">$unick</a>";
        $byusr = "Added By: $ulnk";
      }
      echo "$lnk <br/>$byusr $delnk<br/>$dateadded1<br/>$downloads<br/><br/>";

    }
    }
    echo "</small></p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    if($uid==$who && getplusses($uid)>25)
    {
    echo "<a href=\"index.php?action=addvlt\">";
echo "Add Item</a><br/>";
}
    echo "<a href=\"lists.php?action=vault&amp;who=$who\">&#171;Back to Vault</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
////////////////////////////////////////////////////////Ignore list

else if($action=="ignl")
{
    addonline(getuid_sid($sid),"Ignore List","");
    $pstyle = gettheme1($sid);
    echo xhtmlhead("Ignore List",$pstyle);;
    $uid = getuid_sid($sid);
    echo "<p align=\"center\"><small>";
    echo "<b>Ignore List</b>";

    echo "</small></p>";
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_ignore WHERE name='".$uid."'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql
/*
$sql = "SELECT
            a.name, b.place, b.userid FROM dcroxx_me_users a
            INNER JOIN dcroxx_me_online b ON a.id = b.userid
            GROUP BY 1,2
            LIMIT $limit_start, $items_per_page
    ";
*/
        $sql = "SELECT target FROM dcroxx_me_ignore WHERE name='".$uid."' LIMIT $limit_start, $items_per_page";


    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
        $tnick = getnick_uid($item[0]);
          if(isonline($item[0]))
  {
    $iml = "<img src=\"images/onl.gif\" alt=\"+\"/>";

  }else{
    $iml = "<img src=\"images/ofl.gif\" alt=\"-\"/>";

  }
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$iml$tnick</a>";
      echo "$lnk: ";
      echo "<a href=\"genproc.php?action=ign&amp;who=$item[0]&amp;todo=del\">Remove From Ignore list</a><br/>";
    }
    }
    echo "</small></p>";
    echo "<p align=\"center\"><small>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=ignl&amp;page=$ppage\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=ignl&amp;page=$npage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</small></p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\"><small>";
    echo "<a href=\"index.php?action=cpanel\">";
echo "CPanel</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</small></p>";
    echo xhtmlfoot();
 exit();
    }
///////////////////////////////////////////////////////Blogs

else if($action=="blogs")
{
    addonline(getuid_sid($sid),"Viewing User Blogs","");
    $pstyle = gettheme1($sid);
    echo xhtmlhead("Blogs List",$pstyle);
    $uid = getuid_sid($sid);
    $who = $_GET["who"];
    $tnick = getnick_uid($who);
    echo "<p align=\"center\">";
	    echo "<small><b>$tnick's Blogs</b></small>";
   echo "<b></b>";

   // echo "</p>";
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_blogs WHERE bowner='".$who."'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

        $sql = "SELECT id, bname FROM dcroxx_me_blogs WHERE bowner='".$who."' ORDER BY bgdate DESC LIMIT $limit_start, $items_per_page";


    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
        $bname = htmlspecialchars($item[1]);
    if(candelbl($uid,$item[0]))
    {
      $dl = "<a href=\"genproc.php?action=delbl&amp;bid=$item[0]\">[X]</a>";
    }else{
      $dl = "";
    }
      $lnk = "<a href=\"index.php?action=viewblog&amp;bid=$item[0]\">&#187;$bname</a>";
      echo "$lnk $dl<br/>";
    }
    }
    echo "</small></p>";
    echo "<p align=\"center\"><small>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</small></p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\"><small>";
    if($who==$uid)
    {
        echo "<a href=\"index.php?action=addblg\">";
echo "Add a blog</a><br/>";
echo "<a href=\"index.php?action=cpanel\">";
echo "CPanel</a><br/>";
    }
    echo "<a href=\"lists.php?action=allbl\">";
echo "All Blogs</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</small></p>";
    echo xhtmlfoot();
 exit();
    }
//////////////////////////////////////////////////////Blogs

else if($action=="allbl")
{
    addonline(getuid_sid($sid),"Blogs list","");
    $pstyle = gettheme($sid);
    echo xhtmlhead("Event List",$pstyle);
    $uid = getuid_sid($sid);
    $view = $_GET["view"];
    if($view =="")$view="time";
   /* echo "<p align=\"center\"><small>";
    if($view!="time")
    {
      echo "<a href=\"lists.php?action=allbl&amp;view=time\">View Newest</a><br/>";
    }
    if($view!="points")
    {
      echo "<a href=\"lists.php?action=allbl&amp;view=points\">View by points</a><br/>";
    }
    if($view!="rate")
    {
      echo "<a href=\"lists.php?action=allbl&amp;view=rate\">View most rated</a><br/>";
    }
    if($view!="votes")
    {
      echo "<a href=\"lists.php?action=allbl&amp;view=votes\">View most voted</a>";
    }
    echo "</small></p>";*/
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_blogs"));
    $num_items = $noi[0]; //changable
    $items_per_page= 7;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
if($view=="time")
{
  $ord = "a.bgdate";
}else if($view=="votes")
{
  $ord = "nofv";
}else if($view=="rate")
{
  $ord = "avv";
}else if($view=="points")
{
  $ord = "nofp";
}
if ($view=="time"){
  $sql = "SELECT id, bname, bowner FROM dcroxx_me_blogs ORDER by bgdate DESC LIMIT $limit_start, $items_per_page";
}else{
        $sql = "SELECT a.id, a.bname, a.bowner, COUNT(b.id) as nofv, SUM(b.brate) as nofp, AVG(b.brate) as avv FROM dcroxx_me_blogs a INNER JOIN dcroxx_me_brate b ON a.id = b.blogid GROUP BY a.id ORDER BY $ord DESC LIMIT $limit_start, $items_per_page";
}
    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $bname = htmlspecialchars($item[1]);
      if($view=="time")
      {
      $bonick = getnick_uid($item[2]);

        $byview = "| <a href=\"index.php?action=viewuser&amp;who=$item[2]\">$bonick</a>";
        }else if($view=="votes")
        {
          $byview = "Votes: $item[3]";
        }else if($view=="rate")
        {
          $byview = "Rate: $item[5]";
        }else if($view=="points")
        {
          $byview = "Points: $item[4]";
        }
      $lnk = "<b>($item[0])</b> <a href=\"index.php?action=viewblog&amp;bid=$item[0]\">$bname</a>";
      echo "$lnk<br/>";
    }
    }
    echo "</small></p>";
    echo "<p align=\"center\"><small>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
        $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</small></p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\"><small>";

    echo "<a href=\"index.php?action=addblg\">Write a Event</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</small></p>";
    echo xhtmlfoot();
 exit();
    }
///////////////////////////////////////////////////////Blogs

else if($action=="polls")
{
    addonline(getuid_sid($sid),"Polls list","");
    $pstyle = gettheme($sid);
    echo xhtmlhead("Polls List",$pstyle);
    $uid = getuid_sid($sid);
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE pollid>'0'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

  $sql = "SELECT id, name FROM dcroxx_me_users WHERE pollid>'0' ORDER by pollid DESC LIMIT $limit_start, $items_per_page";

    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      echo "By <a href=\"index.php?action=viewpl&amp;who=$item[0]\">$item[1]</a><br/>";
    }
    }
    echo "</small></p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"view\" value=\"$view\"/>";
        $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";

    echo "<a href=\"index.php?action=stats\">";
echo "<img src=\"images/stat.gif\" alt=\"*\"/>Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
/////////////////////////////////////////////////////

else if($action=="casino")

{

   addonline(getuid_sid($sid),"WAP - Playing Casino","lists.php?action=$action");


    $pstyle = gettheme($sid);
    echo xhtmlhead("Casino",$pstyle);


   echo "<p align=\"center\">";



   //////ALL LISTS SCRIPT <<



$num1 = rand(1, 9);

$num2 = rand(1, 9);

$num3 = rand(1, 9);

 $uid = mysql_fetch_array(mysql_query("SELECT uid FROM dcroxx_me_ses WHERE
id='".$sid."'"));

 $uid = $uid[0];

$usrid = $uid;
 $plss = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".getuid_sid($sid)."'"));
  echo "<i>You have $plss[0] Credits</i><br/>";

echo "<b><u>These Are Your Cards:</u></b><br/>";

echo "<b>[$num1][$num2][$num3]</b><br/>";

if ($num1 == 7 and $num2 == 7 and $num3 == 7) {

 $num = rand(1, 5);

 echo "Congratz! You've Won 100 Credits";

                       $ugpl = mysql_fetch_array(mysql_query("SELECT
plusses FROM dcroxx_me_users WHERE id='".$uid."'"));

                       $ugpl = $ugpl[0];

                                                       $ugpl2 = $ugpl +
"100";

                       mysql_query("UPDATE dcroxx_me_users SET
plusses='".$ugpl2."' WHERE id='".$uid."'");



echo "<br/>";

}

if ($num1 == 1 and $num2 == 1 and $num3 == 1) {

 $num = rand(1, 10);

 echo "Sorry You've Lost 80 Credits";

                       $ugpl = mysql_fetch_array(mysql_query("SELECT
plusses FROM dcroxx_me_users WHERE id='".$uid."'"));

                       $ugpl = $ugpl[0];

                       $ugpl2 = $ugpl - "80";

                       mysql_query("UPDATE dcroxx_me_users SET
plusses='".$ugpl2."' WHERE id='".$uid."'");



echo "<br/>";

}

if ($num2 == 1 and $num3 == 1) {

 $num = rand(1, 10);

 echo "Sorry You've Lost 20 Credits";

                       $ugpl = mysql_fetch_array(mysql_query("SELECT
plusses FROM dcroxx_me_users WHERE id='".$uid."'"));

                       $ugpl = $ugpl[0];

                       $ugpl2 = $ugpl - "20";

                       mysql_query("UPDATE dcroxx_me_users SET
plusses='".$ugpl2."' WHERE id='".$uid."'");



echo "<br/>";

}

if ($num3 == 1) {

 $num = rand(1, 10);

 echo "Sorry You've Lost 3 Credits";;

                       $ugpl = mysql_fetch_array(mysql_query("SELECT
plusses FROM dcroxx_me_users WHERE id='".$uid."'"));

                       $ugpl = $ugpl[0];

                       $ugpl2 = $ugpl - "3";

                       mysql_query("UPDATE dcroxx_me_users SET
plusses='".$ugpl2."' WHERE id='".$uid."'");



echo "<br/>";
}

if ($num1 == 3 and $num2 == 3 and $num3 == 3) {

 $num = rand(1, 10);

   echo "Congratz! You've Won 30 Credits";

                       $ugpl = mysql_fetch_array(mysql_query("SELECT
plusses FROM dcroxx_me_users WHERE id='".$uid."'"));

                       $ugpl = $ugpl[0];

                       $ugpl2 = $ugpl + "30";

                       mysql_query("UPDATE dcroxx_me_users SET
plusses='".$ugpl2."' WHERE id='".$uid."'");



echo "<br/>";

}

if ($num2 == 7 and $num3 == 7) {

 $num = rand(1, 15);

   echo "Congratz! You've Won 10 Credits";

                       $ugpl = mysql_fetch_array(mysql_query("SELECT
plusses FROM dcroxx_me_users WHERE id='".$uid."'"));

                       $ugpl = $ugpl[0];

                       $ugpl2 = $ugpl + "10";

                       mysql_query("UPDATE dcroxx_me_users SET
plusses='".$ugpl2."' WHERE id='".$uid."'");



echo "<br/>";

}

if ($num3 == 7) {

 $num = rand(1, 15);

 echo "Congratz! You've Won 5 Credits";

                       $ugpl = mysql_fetch_array(mysql_query("SELECT
plusses FROM dcroxx_me_users WHERE id='".$uid."'"));

                       $ugpl = $ugpl[0];

                       $ugpl2 = $ugpl + "5";

                       mysql_query("UPDATE dcroxx_me_users SET
plusses='".$ugpl2."' WHERE id='".$uid."'");

echo "<br/>";

}

echo "<b><a href=\"lists.php?action=casino&amp;time=";

       echo date('dmHis');

       echo "\">Spin The Wheel!</a></b><br/><br/>";
echo "<small><a href=\"helpcas.php?\">Help</a></small><br/>";

echo "<small><a href=\"index.php?action=funm\">Back To Fun
Zone</a></small>";



echo "<a href=\"index.php?action=main\"><img
src=\"images/home.gif\" alt=\"*\"/>";

echo "Home</a><br/>";


  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
/////////////////////////////////////////////////////////Top Gammers

else if($action=="tshout")
{
    addonline(getuid_sid($sid),"Top Shouters","");
    $pstyle = gettheme($sid);
    echo xhtmlhead("Top Shouters",$pstyle);
    echo "<p align=\"center\">";
    echo "<b>Top Shouters</b>";
    echo "</p>";
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $num_items = regmemcount(); //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, name, shouts FROM dcroxx_me_users ORDER BY shouts DESC LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {

      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a> <small>Shouts: $item[2]</small>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=tshout&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=tshout&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
 exit();
    }
////////////////////////////////////////////////////////Top Gammers

else if($action=="bbcode")
{
    addonline(getuid_sid($sid),"BBcode List","");
   $pstyle = gettheme($sid);
    echo xhtmlhead("BBcode List",$pstyle);
    echo "<p align=\"center\">";
    echo "<b>BBcode</b>";
    echo "</p>";
    echo "<p>";
    echo "<b>WARNING:</b> Misusing the bbcodes may cause display errors<br/><br/>";
    echo "[b]TEXT[/b]: <b>TEXT</b><br/>";
    echo "[i]TEXT[/i]: <i>TEXT</i><br/>";
    echo "[u]TEXT[/u]: <u>TEXT</u><br/>";
    echo "[big]TEXT[/big]: <big>TEXT</big><br/>";
    echo "[small]TEXT[/small]: <small>TEXT</small><br/><br/>";

    echo "[img=<i>http://SocialBD.NeT/images/home.gif</i>]: <img src=\"images/home.gif\"><br/>";
    echo "<small>replace http://SocialBD.NeT/images/home.gif with any image url. NOTE: don't use large images!</small><br/><br/>";

    echo "[clr=<i>red</i>]<i>TEXT</i>[/clr]: <font color=\"red\">TEXT</font><br/>";
    echo "<small>replace red with any other colour, and replace TEXT with any word you want</small><br/><br/>";

   /* echo "[url=<i>http://SocialBD.NeT</i>]<i>.tk</i>[/url]: <a href=\"http://SocialBD.NeT\">.tk</a><br/>";
    echo "<small>replace http://SocialBD.NeT with any other link, and replace .tk with any word you want</small><br/><br/>";*/

    echo "[topic=<i>1501</i>]<i>Topic Name</i>[/topic]: <a href=\"index.php?action=viewtpc&amp;tid=1501\">Topic Name</a><br/>";
    echo "<small>replace 1501 with the topic id, and replace Topic Name with any word you want</small><br/><br/>";

    echo "[blog=<i>1</i>]<i>Blog Name</i>[/blog]: <a href=\"index.php?action=viewblog&amp;bid=1\">Blog Name</a><br/>";
    echo "<small>replace 1 with the blog id, and replace Blog Name with any word you want</small><br/><br/>";

    echo "[club=<i>1</i>]<i>Club Name</i>[/club]: <a href=\"index.php?action=gocl&amp;clid=1501\">Club Name</a><br/>";
    echo "<small>replace 1 with the club id, and replace Club Name with any word you want</small><br/><br/>";
  echo "[user=FardIn420]FardIn420[/user]: <a href=\"index.php?action=viewuser&amp;who=$1\">FardIn420</a><br/>";
    echo "<small>replace rider with the user name, and replace </small><br/><br/>";

 // echo "[rep]: <a href=\"repicons.php?sid=$sid\">Reputation Icons</a><br/><br/>";

echo "[pmoods]: <a href=\"lists.php?action=pmoods\">Profile Moods</a><br/><br/>";

echo "[avatar]: <a href=\"lists.php?action=upavat\">Upload Avatar</a><br/><br/>";

echo "[inbox]: <a href=\"inbox.php?action=main\">Inbox $unrd</a><br/><br/>";

echo "[updatepro]: <a href=\"index.php?action=uset\">Update Profie</a><br/><br/>";

    echo "[br/]: to insert new line, like:";
    echo "hello[br/]world!:<br/>hello<br/>world!<br/><br/>";

    echo "/rwfaqs: <a href=\"lists.php?action=faqs\">F.A.Qs</a> <small>in PMs only</small>";

    echo "</p>";
    echo "<p align=\"center\"><small>";
    echo "<a href=\"index.php?action=cpanel\">";
echo "CPanel</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</small></p>";
    echo xhtmlfoot();
 exit();
    }
/////////////////////////////////////////////
//Top Gammers

else if($action=="faqs")
{
    addonline(getuid_sid($sid),"F.A.Qs","");
    $pstyle = gettheme($sid);
    echo xhtmlhead("F.A.Qs",$pstyle);
    echo "<p align=\"center\">";
    echo "<b>F.A.Qs</b>";
    echo "</p>";
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_faqs"));
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT question, answer FROM dcroxx_me_faqs ORDER BY id LIMIT $limit_start, $items_per_page";


    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
        $item[0] = parsepm($item[0], $sid);
        $item[1] = parsepm($item[1], $sid);
      echo "<b>Q. $item[0]</b><br/>";
      echo "A. $item[1]<br/>";
    }
    }
    echo "</small></p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
  exit();
    }
/////////////////////////////////////////////
///Staff



else if($action=="staff")

{
addonline(getuid_sid($sid),"Staff list","");
    $pstyle = gettheme($sid);
    echo xhtmlhead("Staff List",$pstyle);

    echo "<p align=\"center\">";

    echo "<img src=\"smilies/order.gif\" alt=\"*\"/><br/>";

    echo "<b>Staff List</b><br/><small>";

    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE perm='4'"));
    echo "<a href=\"lists.php?action=owns\">Owners($noi[0])</a><br/>";
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE perm='3'"));
    echo "<a href=\"lists.php?action=hadms\">Head Admins($noi[0])</a><br/>";
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE perm='2'"));

    echo "<a href=\"lists.php?action=admns\">Admins($noi[0])</a><br/>";

    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE perm='1'"));

    echo "<a href=\"lists.php?action=modr\">Moderators($noi[0])</a></small>";

    echo "</p>";

    //////ALL LISTS SCRIPT <<

    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE perm>'0'"));



    if($page=="" || $page<=0)$page=1;

    $num_items = $noi[0]; //changable

    $items_per_page= 10;

    $num_pages = ceil($num_items/$items_per_page);

    if(($page>$num_pages)&&$page!=1)$page= $num_pages;

    $limit_start = ($page-1)*$items_per_page;



    //changable sql



        $sql = "SELECT id, name, perm FROM dcroxx_me_users WHERE perm>'0' ORDER BY name LIMIT $limit_start, $items_per_page";





    echo "<p>";

    $items = mysql_query($sql);

    echo mysql_error();

    if(mysql_num_rows($items)>0)

    {

    while ($item = mysql_fetch_array($items))

    {

          if($item[2]=='1')
      {
        $tit = "Moderator";
      }else if($item[2]=='2')
      {
        $tit = "Admin";
      }else if($item[2]=='3')
      {
        $tit = "Head Admin";
      }else if($item[2]=='4')
      {
        $tit = "Owner";
      }
        /*if($item[2]=='1')

        {

          $tit = "Moderator";

        }else{

          $tit = "Admin";

        }
*/
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a> <small>$tit</small>";

      echo "$lnk<br/>";

    }

    }

    echo "</p>";

    echo "<p align=\"center\">";

    if($page>1)

    {

      $ppage = $page-1;

      echo "<a href=\"lists.php?action=staff&amp;page=$ppage&amp;view=$view\">&#171;PREV</a> ";

    }

    if($page<$num_pages)

    {

      $npage = $page+1;

      echo "<a href=\"lists.php?action=staff&amp;page=$npage&amp;view=$view\">Next&#187;</a>";

    }

     echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";



        echo $rets;







    }

    echo "</p>";

  ////// UNTILL HERE >>

    echo "<p align=\"center\">";

    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";

echo "Site Stats</a><br/>";

    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";

echo "Home</a>";

  echo "</p>";

 echo xhtmlfoot();

  exit();
    }
/////////////////////////////////////////////
//Staff



else if($action=="owns")
{
    addonline(getuid_sid($sid),"Owners list","");
    $pstyle = gettheme($sid);
    echo xhtmlhead("Owners List",$pstyle);
    echo "<p align=\"center\">";
    echo "<img src=\"smilies/order.gif\" alt=\"*\"/><br/>";
    echo "<b>Owners List</b><br/>";
    echo "</p>";
    //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE perm='4'"));
    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, name FROM dcroxx_me_users WHERE perm='4' ORDER BY name LIMIT $limit_start, $items_per_page";

    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {

      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=owns&amp;page=$ppage&amp;view=$view\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=owns&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
     echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";
        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
   echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
  exit();
    }
/////////////////////////////////////////////
else if($action=="hadms")
{
    addonline(getuid_sid($sid),"xhtml-Head Admin list","");
    $pstyle = gettheme($sid);
    echo xhtmlhead("Head Admin List",$pstyle);
    echo "<p align=\"center\">";
    echo "<img src=\"smilies/order.gif\" alt=\"*\"/><br/>";
    echo "<b>Head Admins List</b><br/>";
    echo "</p>";
    //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE perm='3'"));
    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, name FROM dcroxx_me_users WHERE perm='3' ORDER BY name LIMIT $limit_start, $items_per_page";

    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {

      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=hadmns&amp;page=$ppage&amp;view=$view\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=hadmns&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
     echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";
        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
   echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
    exit();
    }
/////////////////////////////////////////////
else if($action=="admns")

{

 addonline(getuid_sid($sid),"xhtml-Admin list","");
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin List",$pstyle);

    echo "<p align=\"center\">";

    echo "<img src=\"smilies/order.gif\" alt=\"*\"/><br/>";

    echo "<b>Admins List</b><br/>";

    echo "</p>";

    //////ALL LISTS SCRIPT <<

    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE perm='2'"));



    if($page=="" || $page<=0)$page=1;

    $num_items = $noi[0]; //changable

    $items_per_page= 10;

    $num_pages = ceil($num_items/$items_per_page);

    if(($page>$num_pages)&&$page!=1)$page= $num_pages;

    $limit_start = ($page-1)*$items_per_page;



    //changable sql



        $sql = "SELECT id, name FROM dcroxx_me_users WHERE perm='2' ORDER BY name LIMIT $limit_start, $items_per_page";





    echo "<p>";

    $items = mysql_query($sql);

    echo mysql_error();

    if(mysql_num_rows($items)>0)

    {

    while ($item = mysql_fetch_array($items))

    {



      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a>";

      echo "$lnk<br/>";

    }

    }

    echo "</p>";

    echo "<p align=\"center\">";

    if($page>1)

    {

      $ppage = $page-1;

      echo "<a href=\"lists.php?action=admns&amp;page=$ppage&amp;view=$view\">&#171;PREV</a> ";

    }

    if($page<$num_pages)

    {

      $npage = $page+1;

      echo "<a href=\"lists.php?action=admns&amp;page=$npage&amp;view=$view\">Next&#187;</a>";

    }

     echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";



        echo $rets;

    }

    echo "</p>";

  ////// UNTILL HERE >>

    echo "<p align=\"center\">";

    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";

echo "Site Stats</a><br/>";

    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";

echo "Home</a>";

  echo "</p>";

    echo xhtmlfoot();

exit();
    }
//////////////////////////////////vip

else if($action=="vip")
{ $pstyle = gettheme($sid);
    echo xhtmlhead("V.I.P List",$pstyle);
    addonline(getuid_sid($sid),"<b>Gledam ko su Vip Chlanovi!</b>","");
   
    echo "<p align=\"center\">";
    echo "<img src=\"images/riba.gif\" alt=\"*\"/><br/>";
	$noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE vip='1'"));
    echo "<small><b>Vip Online ($noi[0])</b></small><br/><br/>";
    echo "</p>";
    //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE vip>'0'"));
    
    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, name, vip FROM dcroxx_me_users WHERE vip>'0' ORDER BY name LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
        if($item[2]=='1')
        {
          $tit = "<img src=\"images/vip.jpg\" alt=\"V\"/>";
        }else{
          $tit = "<img src=\"images/vip.jpg\" alt=\"V\"/>";

        }
      $lnk = "<small>$tit</small><a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a> ";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=vip&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=vip&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
     if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Statistika</a><br/>";
    echo "<img src=\"images/home.gif\" alt=\"*\"/> <a href=\"index.php?action=main\">";
echo "Home</a>";
  echo "</p>";

}

//////////////////////////////////////////////////Vips

else if($action=="vips")
{
    addonline(getuid_sid($sid),"V.I.P list","");
    $pstyle = gettheme($sid);
    echo xhtmlhead("V.I.P List",$pstyle);

    //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE specialid>'0'"));

    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, name, specialid FROM dcroxx_me_users WHERE specialid>'0' ORDER BY name LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
        if($item[2]=='1')
        {
          $tit = " Millionaire!";
        }
        if($item[2]=='2')
        {
          $tit = " Quiz Master!";
        }
        if($item[2]=='8')
        {
          $tit = " Prince!";
        }
        if($item[2]=='9')
        {
          $tit = " Princess!";
        }

      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a> <small>$tit</small>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=staff&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=staff&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
exit();
    }
//////////////////////////////////////////////judges

else if($action=="judg")
{
    addonline(getuid_sid($sid),"Chat mods list","");
    $pstyle = gettheme($sid);
    echo xhtmlhead("Chat Moderators List",$pstyle);
    echo "<p align=\"center\">";
    echo "<b>Chat Moderators </b><br/>";
    echo "</p>";
    //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_judges"));

    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT uid FROM dcroxx_me_judges LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {

      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">".getnick_uid($item[0])."</a>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=judg&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=judg&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
exit();
    }
//////////////////////////////////////////////Staff

else if($action=="modr")
{
    addonline(getuid_sid($sid),"Mods list","");
    $pstyle = gettheme($sid);
    echo xhtmlhead("Mods List",$pstyle);
    echo "<p align=\"center\">";
    echo "<b>Moderators List</b><br/>";
    echo "</p>";
    //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE perm='1'"));

    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, name FROM dcroxx_me_users WHERE perm='1' ORDER BY name LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {

      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=modr&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=modr&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
exit();
    }
/////////////////////////////////////////////Top Posters List

else if($action=="tpweek")
{
    addonline(getuid_sid($sid),"Top Posters of the week","");
    $pstyle = gettheme($sid);
    echo xhtmlhead("Top Posters",$pstyle);
    echo "<p align=\"center\">";
    echo "Top Posters of The week<br/><small>Thank you, you brought the life to this site in the last 7 days</small>";
    echo "</p>";
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $weekago = ((time() - $timeadjust)  );
    $weekago -= 7*24*60*60;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT uid)  FROM dcroxx_me_posts WHERE dtpost>'".$weekago."';"));
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql


        $sql = "SELECT uid, COUNT(*) as nops FROM dcroxx_me_posts  WHERE dtpost>'".$weekago."'  GROUP BY uid ORDER BY nops DESC LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
        $unick = getnick_uid($item[0]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$unick</a> <small>Posts: $item[1]</small>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=tpweek&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=tpweek&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
  $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
exit();
    }
///////////////////////////////////////////////Top Posters List

else if($action=="tptime")
{
    addonline(getuid_sid($sid),"Top Posters all the time","");
    $pstyle = gettheme($sid);
    echo xhtmlhead("Top Posters",$pstyle);
    echo "<p align=\"center\">";
    echo "Top Posters of all the time";
    echo "</p>";
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;

    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT uid)  FROM dcroxx_me_posts ;"));
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql


        $sql = "SELECT uid, COUNT(*) as nops FROM dcroxx_me_posts   GROUP BY uid ORDER BY nops DESC LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
        $unick = getnick_uid($item[0]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$unick</a> <small>Posts: $item[1]</small>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=tptime&amp;page=$ppage&amp;view=$view\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=tptime&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "<form action=\"lists.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
exit();
    }
///////////////////////////////////////////////Males List

else if($action=="males")
{
    addonline(getuid_sid($sid),"Males List","");

    $pstyle = gettheme($sid);
    echo xhtmlhead("Males List",$pstyle);
    echo "<p align=\"center\">";
    echo "<img src=\"images/male.gif\" alt=\"*\"/><br/>";
    echo "<b>Males</b>";
    echo "</p>";
    //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE sex='M'"));
    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql
        $sql = "SELECT id, name, birthday FROM dcroxx_me_users WHERE sex='M' ORDER BY name LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $uage = getage($item[2]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a> <small>Age: $uage</small>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=males&amp;page=$ppage\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=males&amp;page=$npage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
        $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";


 $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
exit();
    }
///////////////////////////////////////////////Males List

else if($action=="fems")
{
    addonline(getuid_sid($sid),"Females List","");

    $pstyle = gettheme($sid);
    echo xhtmlhead("Females List",$pstyle);
    echo "<p align=\"center\">";
    echo "<img src=\"images/female.gif\" alt=\"*\"/><br/>";
    echo "<b>Females</b>";
    echo "</p>";
    //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE sex='F'"));
    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql
        $sql = "SELECT id, name, birthday FROM dcroxx_me_users WHERE sex='F' ORDER BY name LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $uage = getage($item[2]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a> <small>Age: $uage</small>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=fems&amp;page=$ppage\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=fems&amp;page=$npage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
        $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";


 $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
exit();
    }
///////////////////////////////////////////////Today's Birthday'

else if($action=="bdy")
{
    addonline(getuid_sid($sid),"Today's Birthday","");

    $pstyle = gettheme($sid);
    echo xhtmlhead("Today's Birthday",$pstyle);
    echo "<p align=\"center\">";
    echo "<img src=\"images/cake.gif\" alt=\"*\"/><br/>";
    echo "Happy Birthday to:";
    echo "</p>";
    //////ALL LISTS SCRIPT <<
    $noi =mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users where month(`birthday`) = month(curdate()) and dayofmonth(`birthday`) = dayofmonth(curdate());"));
    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql
        $sql = "SELECT id, name, birthday  FROM dcroxx_me_users where month(`birthday`) = month(curdate()) and dayofmonth(`birthday`) = dayofmonth(curdate()) ORDER BY name LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $uage = getage($item[2]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a> <small>Age: $uage</small>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=bdy&amp;page=$ppage\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=bdy&amp;page=$npage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
 $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
         $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
         $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

 $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
exit();
    }
///////////////////////////////////////////////Browsers

else if($action=="brows")
{
    addonline(getuid_sid($sid),"Browsers List","");

    $pstyle = gettheme($sid);
    echo xhtmlhead("Browser List",$pstyle);
    echo "<p align=\"center\">";
    echo "<b>browsers List</b>";
    echo "</p>";
    //////ALL LISTS SCRIPT <<
    $noi=mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT browserm) FROM dcroxx_me_users WHERE browserm IS NOT NULL "));
    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql
        $sql = "SELECT browserm, COUNT(*) as notl FROM dcroxx_me_users    WHERE browserm!='' GROUP BY browserm ORDER BY notl DESC LIMIT $limit_start, $items_per_page";
//$moderatorz=mysql_query("SELECT tlphone, COUNT(*) as notl FROM users GROUP BY tlphone ORDER BY notl DESC LIMIT  ".$pagest.",5");
    $cou = $limit_start;
    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {

    while ($item = mysql_fetch_array($items))
    {
      $cou++;
      $lnk = "$cou-$item[0] <b>$item[1]</b>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=brows&amp;page=$ppage\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=brows&amp;page=$npage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
       $rets = "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
         $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
         $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";


$rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=stats\"><img src=\"images/stat.gif\" alt=\"*\"/>";
echo "Site Stats</a><br/>";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
exit();
    }

?>