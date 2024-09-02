<?php
session_name("PHPSESSID");
session_start();

include("xhtmlfunctions.php");
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> 
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<meta name=\"HandheldFriendly\" content=\"True\"/><head><title>Post Archive</title>
<link href=\"archive.css\" media=\"screen, handheld\" rel=\"stylesheet\" type=\"text/css\" />";

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

$res = mysql_query("UPDATE dcroxx_me_users SET browserm='".$ubr."', ipadd='".$uip."' WHERE id='".getuid_sid($sid)."'");

  addvisitor();
	addonline(getuid_sid($sid),"Post Archive","archive.php?action=main&amp;who=$who");
  if($action=="main")
{
echo "<body class=\"images nojs users-page users-show-page\">
<div id=\"container\"><div id=\"brand_bar\">
<table id=\"top\"><tr><td class=\"left\">
<a href=\"index.php?action=main\" class=\"brandmark\">
<img alt=\"SBD\" src=\"frendz.png\" width=\"44\" /></a></td><td class=\"right\">
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"lists.php?action=buds\">
<img alt=\"Friends\" src=\"top_buds.png\" width=\"36\" /></a>
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"inbox.php?action=main\">
<img alt=\"Inbox\" src=\"top_msg.png\" width=\"36\" /></a>
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"index.php?action=chat\"><img alt=\"Chat\" src=\"top_pop.png\" width=\"40\" /></a>
</td></tr></table></div><div class=\"disco\"><div class=\"disco-header\" align=\"center\"><span>Post Archive</span></div></div>
<div id=\"main_content\"><div class=\"w-button-more\"><a href=\"archive.php?action=submitpost\">
<strong>Submit Your Posts</strong></a></div>";
$uid =getuid_sid($sid);

$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_artpc WHERE authorid='".$uid."' AND app='1'"));
$noi1 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_artpc WHERE authorid='".$uid."' AND app='0'"));
echo"<center><a href=\"archive.php?action=myaposts\">
<strong>My Authorized Posts [$noi[0]]</strong></a></center>
<center><a href=\"archive.php?action=mypposts\">
<strong>My Pending Posts [$noi1[0]]</strong></a></center>";

if(ismod($uid)){
$noi12 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_artpc WHERE app='0'"));
echo "<center><a href=\"archive.php?action=allpposts\">
<strong>All Pending Posts [$noi12[0]]</strong></a></center>";
}else{}


    echo "<div class=\"titles\">Recent Posts</div><p><small>";
	if($page=="" || $page<=0)$page=1;if($page==1)
{$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_artpc"));
$num_items = $noi[0]; //changable
$items_per_page= 3;$num_pages = ceil($num_items/$items_per_page);
if($page>$num_pages)$page= $num_pages;$limit_start = ($page-1)*$items_per_page;if($limit_start<0)$limit_start=0;
$topics = mysql_query("SELECT id, name, authorid, arcid, views, text, pollid FROM ibwfrr_artpc WHERE app='1' ORDER BY crdate DESC, name, id LIMIT $limit_start, $items_per_page");
}while($topic = mysql_fetch_array($topics)){
$nop = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_arpost WHERE tid='".$topic[0]."'"));
$tnm = htmlspecialchars($topic[1]);

  $name55 = parsepm($topic[1], $sid);

echo"<div class=\"timeline\"><table class=\"msg\">
<tr class=\"msg-header\"><td class=\"avatar\" rowspan=\"3\">";
$avlink = getavatar($topic[2]);
if($avlink=="")
{echo "<img src=\"images/nopic.jpg\" width=\"25\" height=\"25\" alt=\"*\"/>";}else{
echo "<img src=\"$avlink\" width=\"25\" height=\"25\" alt=\"*\"/>";}
echo"</td><td class=\"user-info\">
<a href=\"index.php?action=viewuser&amp;who=$topic[2]\">";
$name = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$topic[2]."'"));
echo"<span class=\"username\"><b>$name[0]</b></span></a>
</td></tr><tr class=\"msg-container\"><td colspan=\"2\" class=\"msg-content\"><div class=\"msg-text\"><div class=\"dir-ltr\"><strong>Title: $name55</strong><br/>";
$category = mysql_fetch_array(mysql_query("SELECT name FROM ibwfrr_arcid WHERE id='".$topic[3]."'"));
echo"<strong>Category: $category[0]</strong><br/>";
	  $pmtext = htmlspecialchars($topic[5]);
	  $pmdet = substr($pmtext,0,25);
       $pmex1 = "$pmdet .......";
	 $pmex = parsepm($pmex1, $sid);
echo"Texts: $pmex <br/>";
$comment = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_arpost WHERE tid='".$topic[0]."'"));
echo"<strong>$comment[0] comments/$topic[4] views</strong></div></div>
</td></tr><tr><td colspan=\"2\" class=\"meta-and-actions\"><span class=\"metadata\"><a href=\"archive.php?action=viewarcpost&amp;postid=$topic[0]\">
Read full post</a></span><span class=\"msg-actions\"></span></td></tr></table></div>";
///////////////////////////

}


echo"
<center><a href=\"archive.php?action=recentposts\">More&#187;</a></center>
<div class=\"titles\">Recent Comments</div><p><small>";


if($page=="" || $page<=0)$page=1;if($page==1)
{$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_arpost"));
$num_items = $noi[0]; //changable
$items_per_page= 3;$num_pages = ceil($num_items/$items_per_page);
if($page>$num_pages)$page= $num_pages;$limit_start = ($page-1)*$items_per_page;if($limit_start<0)$limit_start=0;
$topics = mysql_query("SELECT id, text, tid, uid, dtpost FROM ibwfrr_arpost ORDER BY dtpost DESC, text, id LIMIT $limit_start, $items_per_page");
}while($topic = mysql_fetch_array($topics)){
$nop = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_arpost WHERE tid='".$topic[0]."'"));
$tnm = htmlspecialchars($topic[1]);
echo"<div class=\"timeline\"><table class=\"msg\"><tr class=\"msg-header\">
<td class=\"avatar\" rowspan=\"3\">";
$avlink = getavatar($topic[3]);
if($avlink=="")
{echo "<img src=\"images/nopic.jpg\" width=\"25\" height=\"25\" alt=\"*\"/>";}else{
echo "<img src=\"$avlink\" width=\"25\" height=\"25\" alt=\"*\"/>";}
echo"</td><td class=\"user-info\">
<a href=\"index.php?action=viewuser&amp;who=$topic[3]\">";
$name = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$topic[3]."'"));
$tn = mysql_fetch_array(mysql_query("SELECT name FROM ibwfrr_artpc WHERE id='".$topic[2]."'"));
  $na = parsepm($tn[0], $sid);
    $n = parsepm($topic[1], $sid);
echo"<span class=\"username\"><b>$name[0]</b></span></a>
</td></tr><tr class=\"msg-container\"><td colspan=\"2\" class=\"msg-content\"><div class=\"msg-text\">
<div class=\"dir-ltr\">$n <br/><br/>Post: <a href=\"archive.php?action=viewarcpost&amp;postid=$topic[2]\">$na</a></div>";
echo"</div></td></tr><tr><td colspan=\"2\" class=\"meta-and-actions\"></td></tr></table></div>";
///////////////////////////
}

echo" <center><a href=\"archive.php?action=recentcomments\">More&#187;</a></center>
<ul class=\"topics-list\"><div class=\"titles\">Categories</div>";

$fcats = mysql_query("SELECT id, name FROM ibwfrr_arcid ORDER BY position, id");
while($fcat=mysql_fetch_array($fcats))
{
$nop = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_artpc WHERE arcid='".$fcat[0]."'  AND app='1' "));
$catlink = "<li class=\"topic\"><a href=\"archive.php?action=authorizedposts&amp;arcid=$fcat[0]\">&#187;$fcat[1] [$nop[0]]</a></li>";echo "$catlink";
}

echo"
</div>
<div id=\"footer\"><div style=\"margin:0;padding:0;display:inline\"></div>
<table class=\"global-actions\"><tr><td><a href=\"index.php?action=main\">Home</a></td>
<td><a href=\"#top\">Top</a></td><td><a href=\"more.php?action=logout\">Log Out</a></td></tr></table></div>
</p></body></html>";
    echo "</html>";
}

else if($action=="authorizedposts")
{
echo "<body class=\"images nojs users-page users-show-page\">
<div id=\"container\"><div id=\"brand_bar\">
<table id=\"top\"><tr><td class=\"left\">
<a href=\"index.php?action=main\" class=\"brandmark\">
<img alt=\"AW\" src=\"frendz.png\" width=\"44\" /></a></td><td class=\"right\">
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"lists.php?action=buds\">
<img alt=\"Friends\" src=\"top_buds.png\" width=\"36\" /></a>
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"inbox.php?action=main\">
<img alt=\"Inbox\" src=\"top_msg.png\" width=\"36\" /></a>
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"index.php?action=chat\"><img alt=\"Chat\" src=\"top_pop.png\" width=\"40\" /></a>
</td></tr></table></div>";

$who = $_GET['who'];
$arcid = $_GET['arcid'];
addonline(getuid_sid($sid),"Viewing Forum","index.php?action=viewfrm&amp;fid=$fid");

$finfo = mysql_fetch_array(mysql_query("SELECT name from ibwfrr_arcid WHERE id='".$arcid."'"));
$fnm = htmlspecialchars($finfo[0]);

echo"<div class=\"disco\"><div class=\"disco-header\" align=\"left\">
<a href=\"index.php?action=main\">Home</a>&#187;<a href=\"archive.php?action=main\">Archive</a>&#187;$fnm
</div></div>";
echo"<div id=\"main_content\">";
    echo "<p><small>";
if($page=="" || $page<=0)$page=1;
if($page==1)
{
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_artpc WHERE arcid='".$arcid."'"));
$num_items = $noi[0]; //changable
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
if($page>$num_pages)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;
if($limit_start<0)$limit_start=0;
$topics = mysql_query("SELECT id, name, authorid, arcid, views, text, pollid FROM ibwfrr_artpc WHERE arcid='".$arcid."'  AND app='1' ORDER BY lastpost DESC, name, id LIMIT $limit_start, $items_per_page");
}
while($topic = mysql_fetch_array($topics))
{
$nop = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_arpost WHERE tid='".$topic[0]."'"));
$tnm = htmlspecialchars($topic[1]);

echo"<div class=\"timeline\"><table class=\"msg\">
<tr class=\"msg-header\"><td class=\"avatar\" rowspan=\"3\">";
$avlink = getavatar($topic[2]);
if($avlink=="")
{echo "<img src=\"images/nopic.jpg\" width=\"25\" height=\"25\" alt=\"*\"/>";}else{
echo "<img src=\"$avlink\" width=\"25\" height=\"25\" alt=\"*\"/>";}
echo"</td>
<td class=\"user-info\">
<a href=\"index.php?action=viewuser&amp;who=$topic[2]\">";
$name = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$topic[2]."'"));
echo"<span class=\"username\"><b>$name[0]</b></span></a>
</td></tr><tr class=\"msg-container\"><td colspan=\"2\" class=\"msg-content\"><div class=\"msg-text\"><div class=\"dir-ltr\">
<strong>Title: $topic[1]</strong><br/>";
$category = mysql_fetch_array(mysql_query("SELECT name FROM ibwfrr_arcid WHERE id='".$topic[3]."'"));
echo"<strong>Category: $category[0]</strong><br/>";
	   /// pm extra ///
	  $pmtext = htmlspecialchars($topic[5]);
	  $pmdet = substr($pmtext,0,25);
       $pmex = "$pmdet .......";
echo"Texts: $pmex <br/>";
$comment = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_arpost WHERE tid='".$topic[0]."'"));
echo"<strong>$comment[0] comments/$topic[4] views</strong></div></div>
</td></tr><tr><td colspan=\"2\" class=\"meta-and-actions\"><span class=\"metadata\">
<a href=\"archive.php?action=viewarcpost&amp;postid=$topic[0]\">Read full post</a></span>
<span class=\"msg-actions\"></span></td></tr></table></div>";
}



echo "";

/*
echo"
<center><a href=\"archive.php?action=recentposts\">More&#187;</a></center>";*/
echo "</small></p>";

echo "<p align=\"center\"><small>";
if($page>1){$ppage = $page-1;
echo "<a href=\"index.php?action=viewfrm&amp;page=$ppage&amp;fid=$fid&amp;view=$view\">&#171;PREV</a> ";
}if($page<$num_pages){$npage = $page+1;
echo "<a href=\"index.php?action=viewfrm&amp;page=$npage&amp;fid=$fid&amp;view=$view\">Next&#187;</a>";
}

if($num_pages>1){
$rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
$rets .= "<anchor>[GO]";
$rets .= "<go href=\"index.php\" method=\"get\">";
$rets .= "<postfield name=\"action\" value=\"$action\"/>";
$rets .= "<postfield name=\"fid\" value=\"$fid\"/>";
$rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
$rets .= "<postfield name=\"view\" value=\"$view\"/>";
$rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
$rets .= "</go></anchor>";
echo $rets;
}

echo"
</div>
<div id=\"footer\"><div style=\"margin:0;padding:0;display:inline\"></div>
<table class=\"global-actions\"><tr><td><a href=\"index.php?action=main\">Home</a></td>
<td><a href=\"#top\">Top</a></td><td><a href=\"index.php?action=logout\">Log Out</a></td></tr></table></div>
</p></body></html>";
    echo "</html>";
}
else if($action=="allpposts")
{
echo "<body class=\"images nojs users-page users-show-page\">
<div id=\"container\"><div id=\"brand_bar\">
<table id=\"top\"><tr><td class=\"left\">
<a href=\"index.php?action=main\" class=\"brandmark\">
<img alt=\"AW\" src=\"frendz.png\" width=\"44\" /></a></td><td class=\"right\">
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"lists.php?action=buds\">
<img alt=\"Friends\" src=\"top_buds.png\" width=\"36\" /></a>
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"inbox.php?action=main\">
<img alt=\"Inbox\" src=\"top_msg.png\" width=\"36\" /></a>
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"index.php?action=chat\"><img alt=\"Chat\" src=\"top_pop.png\" width=\"40\" /></a>
</td></tr></table></div>";

$who = $_GET['who'];
$arcid = $_GET['arcid'];
addonline(getuid_sid($sid),"Viewing Forum","index.php?action=viewfrm&amp;fid=$fid");

$finfo = mysql_fetch_array(mysql_query("SELECT name from ibwfrr_arcid WHERE id='".$arcid."'"));
$fnm = htmlspecialchars($finfo[0]);

echo"<div class=\"disco\"><div class=\"disco-header\" align=\"left\">
<a href=\"index.php?action=main\">Home</a>&#187;<a href=\"archive.php?action=main\">Archive</a>&#187;All Pending Posts
</div></div>";
echo"<div id=\"main_content\">";
    echo "<p><small>";
	if(!ismod(getuid_sid($sid)))
  {
      echo "<br/><center><big><font color=\"green\">You are not a staff in</font> <font color=\"red\"><b>SBD Staff Panel</b></font></big></center><br/>";
      echo "</div>
<div id=\"footer\"><div style=\"margin:0;padding:0;display:inline\"></div>
<table class=\"global-actions\"><tr><td><a href=\"index.php?action=main\">Home</a></td>
<td><a href=\"#top\">Top</a></td><td><a href=\"index.php?action=logout\">Log Out</a></td></tr></table></div>
</p></body></html>";
	  exit();
	  }
if($page=="" || $page<=0)$page=1;
if($page==1)
{
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_artpc WHERE app='0'"));
$num_items = $noi[0]; //changable
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
if($page>$num_pages)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;
if($limit_start<0)$limit_start=0;
$topics = mysql_query("SELECT id, name, authorid, arcid, views, text, pollid FROM ibwfrr_artpc WHERE app='0' ORDER BY lastpost DESC, name, id LIMIT $limit_start, $items_per_page");
}
while($topic = mysql_fetch_array($topics))
{
$nop = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_arpost WHERE tid='".$topic[0]."'"));
$tnm = htmlspecialchars($topic[1]);

echo"<div class=\"timeline\"><table class=\"msg\">
<tr class=\"msg-header\"><td class=\"avatar\" rowspan=\"3\">";
$avlink = getavatar($topic[2]);
if($avlink=="")
{echo "<img src=\"images/nopic.jpg\" width=\"25\" height=\"25\" alt=\"*\"/>";}else{
echo "<img src=\"$avlink\" width=\"25\" height=\"25\" alt=\"*\"/>";}
echo"</td>
<td class=\"user-info\">
<a href=\"index.php?action=viewuser&amp;who=$topic[2]\">";
$name = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$topic[2]."'"));
echo"<span class=\"username\"><b>$name[0]</b></span></a>
</td></tr><tr class=\"msg-container\"><td colspan=\"2\" class=\"msg-content\"><div class=\"msg-text\"><div class=\"dir-ltr\">
<strong>Title: $topic[1]</strong><br/>";
$category = mysql_fetch_array(mysql_query("SELECT name FROM ibwfrr_arcid WHERE id='".$topic[3]."'"));
echo"<strong>Category: $category[0]</strong><br/>";
	   /// pm extra ///
	  $pmtext = htmlspecialchars($topic[5]);
	  $pmdet = substr($pmtext,0,25);
       $pmex = "$pmdet .......";
echo"Texts: $pmex <br/>";
$comment = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_arpost WHERE tid='".$topic[0]."'"));
echo"<strong>$comment[0] comments/$topic[4] views</strong></div></div>
</td></tr><tr><td colspan=\"2\" class=\"meta-and-actions\"><span class=\"metadata\">
<a href=\"archive.php?action=viewarcpost&amp;postid=$topic[0]\">Read full post</a></span>
<span class=\"msg-actions\"></span></td></tr></table></div>";
}



echo "";

/*
echo"
<center><a href=\"archive.php?action=recentposts\">More&#187;</a></center>";*/
echo "</small></p>";

echo "<p align=\"center\"><small>";
if($page>1){$ppage = $page-1;
echo "<a href=\"index.php?action=viewfrm&amp;page=$ppage&amp;fid=$fid&amp;view=$view\">&#171;PREV</a> ";
}if($page<$num_pages){$npage = $page+1;
echo "<a href=\"index.php?action=viewfrm&amp;page=$npage&amp;fid=$fid&amp;view=$view\">Next&#187;</a>";
}

if($num_pages>1){
$rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
$rets .= "<anchor>[GO]";
$rets .= "<go href=\"index.php\" method=\"get\">";
$rets .= "<postfield name=\"action\" value=\"$action\"/>";
$rets .= "<postfield name=\"fid\" value=\"$fid\"/>";
$rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
$rets .= "<postfield name=\"view\" value=\"$view\"/>";
$rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
$rets .= "</go></anchor>";
echo $rets;
}

echo"
</div>
<div id=\"footer\"><div style=\"margin:0;padding:0;display:inline\"></div>
<table class=\"global-actions\"><tr><td><a href=\"index.php?action=main\">Home</a></td>
<td><a href=\"#top\">Top</a></td><td><a href=\"index.php?action=logout\">Log Out</a></td></tr></table></div>
</p></body></html>";
    echo "</html>";
}else if($action=="mypposts")
{
echo "<body class=\"images nojs users-page users-show-page\">
<div id=\"container\"><div id=\"brand_bar\">
<table id=\"top\"><tr><td class=\"left\">
<a href=\"index.php?action=main\" class=\"brandmark\">
<img alt=\"AW\" src=\"frendz.png\" width=\"44\" /></a></td><td class=\"right\">
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"lists.php?action=buds\">
<img alt=\"Friends\" src=\"top_buds.png\" width=\"36\" /></a>
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"inbox.php?action=main\">
<img alt=\"Inbox\" src=\"top_msg.png\" width=\"36\" /></a>
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"index.php?action=chat\"><img alt=\"Chat\" src=\"top_pop.png\" width=\"40\" /></a>
</td></tr></table></div>";

$who = $_GET['who'];
$arcid = $_GET['arcid'];
addonline(getuid_sid($sid),"Viewing Forum","index.php?action=viewfrm&amp;fid=$fid");

$finfo = mysql_fetch_array(mysql_query("SELECT name from ibwfrr_arcid WHERE id='".$arcid."'"));
$fnm = htmlspecialchars($finfo[0]);

echo"<div class=\"disco\"><div class=\"disco-header\" align=\"left\">
<a href=\"index.php?action=main\">Home</a>&#187;<a href=\"archive.php?action=main\">Archive</a>&#187;My Pending Posts
</div></div>";
echo"<div id=\"main_content\">";
    echo "<p><small>";
if($page=="" || $page<=0)$page=1;
if($page==1)
{
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_artpc WHERE app='0' AND authorid='".$uid."'"));
$num_items = $noi[0]; //changable
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
if($page>$num_pages)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;
if($limit_start<0)$limit_start=0;
$topics = mysql_query("SELECT id, name, authorid, arcid, views, text, pollid FROM ibwfrr_artpc WHERE app='0' AND authorid='".$uid."' ORDER BY lastpost DESC, name, id LIMIT $limit_start, $items_per_page");
}
while($topic = mysql_fetch_array($topics))
{
$nop = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_arpost WHERE tid='".$topic[0]."'"));
$tnm = htmlspecialchars($topic[1]);

echo"<div class=\"timeline\"><table class=\"msg\">
<tr class=\"msg-header\"><td class=\"avatar\" rowspan=\"3\">";
$avlink = getavatar($topic[2]);
if($avlink=="")
{echo "<img src=\"images/nopic.jpg\" width=\"25\" height=\"25\" alt=\"*\"/>";}else{
echo "<img src=\"$avlink\" width=\"25\" height=\"25\" alt=\"*\"/>";}
echo"</td>
<td class=\"user-info\">
<a href=\"index.php?action=viewuser&amp;who=$topic[2]\">";
$name = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$topic[2]."'"));
echo"<span class=\"username\"><b>$name[0]</b></span></a>
</td></tr><tr class=\"msg-container\"><td colspan=\"2\" class=\"msg-content\"><div class=\"msg-text\"><div class=\"dir-ltr\">
<strong>Title: $topic[1]</strong><br/>";
$category = mysql_fetch_array(mysql_query("SELECT name FROM ibwfrr_arcid WHERE id='".$topic[3]."'"));
echo"<strong>Category: $category[0]</strong><br/>";
	   /// pm extra ///
	  $pmtext = htmlspecialchars($topic[5]);
	  $pmdet = substr($pmtext,0,25);
       $pmex = "$pmdet .......";
echo"Texts: $pmex <br/>";
$comment = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_arpost WHERE tid='".$topic[0]."'"));
echo"<strong>$comment[0] comments/$topic[4] views</strong></div></div>
</td></tr><tr><td colspan=\"2\" class=\"meta-and-actions\"><span class=\"metadata\">
<a href=\"archive.php?action=viewarcpost&amp;postid=$topic[0]\">Read full post</a></span>
<span class=\"msg-actions\"></span></td></tr></table></div>";
}



echo "";

/*
echo"
<center><a href=\"archive.php?action=recentposts\">More&#187;</a></center>";*/
echo "</small></p>";

echo "<p align=\"center\"><small>";
if($page>1){$ppage = $page-1;
echo "<a href=\"index.php?action=viewfrm&amp;page=$ppage&amp;fid=$fid&amp;view=$view\">&#171;PREV</a> ";
}if($page<$num_pages){$npage = $page+1;
echo "<a href=\"index.php?action=viewfrm&amp;page=$npage&amp;fid=$fid&amp;view=$view\">Next&#187;</a>";
}

if($num_pages>1){
$rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
$rets .= "<anchor>[GO]";
$rets .= "<go href=\"index.php\" method=\"get\">";
$rets .= "<postfield name=\"action\" value=\"$action\"/>";
$rets .= "<postfield name=\"fid\" value=\"$fid\"/>";
$rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
$rets .= "<postfield name=\"view\" value=\"$view\"/>";
$rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
$rets .= "</go></anchor>";
echo $rets;
}

echo"
</div>
<div id=\"footer\"><div style=\"margin:0;padding:0;display:inline\"></div>
<table class=\"global-actions\"><tr><td><a href=\"index.php?action=main\">Home</a></td>
<td><a href=\"#top\">Top</a></td><td><a href=\"index.php?action=logout\">Log Out</a></td></tr></table></div>
</p></body></html>";
    echo "</html>";
}else if($action=="userposts")
{
echo "<body class=\"images nojs users-page users-show-page\">
<div id=\"container\"><div id=\"brand_bar\">
<table id=\"top\"><tr><td class=\"left\">
<a href=\"index.php?action=main\" class=\"brandmark\">
<img alt=\"AW\" src=\"frendz.png\" width=\"44\" /></a></td><td class=\"right\">
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"lists.php?action=buds\">
<img alt=\"Friends\" src=\"top_buds.png\" width=\"36\" /></a>
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"inbox.php?action=main\">
<img alt=\"Inbox\" src=\"top_msg.png\" width=\"36\" /></a>
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"index.php?action=chat\"><img alt=\"Chat\" src=\"top_pop.png\" width=\"40\" /></a>
</td></tr></table></div>";

$who = $_GET['who'];
$arcid = $_GET['arcid'];
addonline(getuid_sid($sid),"Viewing Forum","index.php?action=viewfrm&amp;fid=$fid");
$name = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$who."'"));
$finfo = mysql_fetch_array(mysql_query("SELECT name from ibwfrr_arcid WHERE id='".$arcid."'"));
$fnm = htmlspecialchars($finfo[0]);

echo"<div class=\"disco\"><div class=\"disco-header\" align=\"left\">
<a href=\"index.php?action=main\">Home</a>&#187;<a href=\"archive.php?action=main\">Archive</a>&#187;$name[0]'s Posts
</div></div>";
echo"<div id=\"main_content\">";
    echo "<p><small>";
if($page=="" || $page<=0)$page=1;
if($page==1)
{
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_artpc WHERE app='1' AND authorid='".$who."'"));
$num_items = $noi[0]; //changable
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
if($page>$num_pages)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;
if($limit_start<0)$limit_start=0;
$topics = mysql_query("SELECT id, name, authorid, arcid, views, text, pollid FROM ibwfrr_artpc WHERE app='1' AND authorid='".$who."' ORDER BY lastpost DESC, name, id LIMIT $limit_start, $items_per_page");
}
while($topic = mysql_fetch_array($topics))
{
$nop = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_arpost WHERE tid='".$topic[0]."'"));
$tnm = htmlspecialchars($topic[1]);

echo"<div class=\"timeline\"><table class=\"msg\">
<tr class=\"msg-header\"><td class=\"avatar\" rowspan=\"3\">";
$avlink = getavatar($topic[2]);
if($avlink=="")
{echo "<img src=\"images/nopic.jpg\" width=\"25\" height=\"25\" alt=\"*\"/>";}else{
echo "<img src=\"$avlink\" width=\"25\" height=\"25\" alt=\"*\"/>";}
echo"</td>
<td class=\"user-info\">
<a href=\"index.php?action=viewuser&amp;who=$topic[2]\">";
$name = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$topic[2]."'"));
echo"<span class=\"username\"><b>$name[0]</b></span></a>
</td></tr><tr class=\"msg-container\"><td colspan=\"2\" class=\"msg-content\"><div class=\"msg-text\"><div class=\"dir-ltr\">
<strong>Title: $topic[1]</strong><br/>";
$category = mysql_fetch_array(mysql_query("SELECT name FROM ibwfrr_arcid WHERE id='".$topic[3]."'"));
echo"<strong>Category: $category[0]</strong><br/>";
	   /// pm extra ///
	  $pmtext = htmlspecialchars($topic[5]);
	  $pmdet = substr($pmtext,0,25);
       $pmex = "$pmdet .......";
echo"Texts: $pmex <br/>";
$comment = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_arpost WHERE tid='".$topic[0]."'"));
echo"<strong>$comment[0] comments/$topic[4] views</strong></div></div>
</td></tr><tr><td colspan=\"2\" class=\"meta-and-actions\"><span class=\"metadata\">
<a href=\"archive.php?action=viewarcpost&amp;postid=$topic[0]\">Read full post</a></span>
<span class=\"msg-actions\"></span></td></tr></table></div>";
}



echo "";

/*
echo"
<center><a href=\"archive.php?action=recentposts\">More&#187;</a></center>";*/
echo "</small></p>";

echo "<p align=\"center\"><small>";
if($page>1){$ppage = $page-1;
echo "<a href=\"index.php?action=viewfrm&amp;page=$ppage&amp;fid=$fid&amp;view=$view\">&#171;PREV</a> ";
}if($page<$num_pages){$npage = $page+1;
echo "<a href=\"index.php?action=viewfrm&amp;page=$npage&amp;fid=$fid&amp;view=$view\">Next&#187;</a>";
}

if($num_pages>1){
$rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
$rets .= "<anchor>[GO]";
$rets .= "<go href=\"index.php\" method=\"get\">";
$rets .= "<postfield name=\"action\" value=\"$action\"/>";
$rets .= "<postfield name=\"fid\" value=\"$fid\"/>";
$rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
$rets .= "<postfield name=\"view\" value=\"$view\"/>";
$rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
$rets .= "</go></anchor>";
echo $rets;
}

echo"
</div>
<div id=\"footer\"><div style=\"margin:0;padding:0;display:inline\"></div>
<table class=\"global-actions\"><tr><td><a href=\"index.php?action=main\">Home</a></td>
<td><a href=\"#top\">Top</a></td><td><a href=\"index.php?action=logout\">Log Out</a></td></tr></table></div>
</p></body></html>";
    echo "</html>";
}else if($action=="myaposts")
{
echo "<body class=\"images nojs users-page users-show-page\">
<div id=\"container\"><div id=\"brand_bar\">
<table id=\"top\"><tr><td class=\"left\">
<a href=\"index.php?action=main\" class=\"brandmark\">
<img alt=\"AW\" src=\"frendz.png\" width=\"44\" /></a></td><td class=\"right\">
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"lists.php?action=buds\">
<img alt=\"Friends\" src=\"top_buds.png\" width=\"36\" /></a>
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"inbox.php?action=main\">
<img alt=\"Inbox\" src=\"top_msg.png\" width=\"36\" /></a>
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"index.php?action=chat\"><img alt=\"Chat\" src=\"top_pop.png\" width=\"40\" /></a>
</td></tr></table></div>";

$who = $_GET['who'];
$arcid = $_GET['arcid'];
addonline(getuid_sid($sid),"Viewing Forum","index.php?action=viewfrm&amp;fid=$fid");

$finfo = mysql_fetch_array(mysql_query("SELECT name from ibwfrr_arcid WHERE id='".$arcid."'"));
$fnm = htmlspecialchars($finfo[0]);

echo"<div class=\"disco\"><div class=\"disco-header\" align=\"left\">
<a href=\"index.php?action=main\">Home</a>&#187;<a href=\"archive.php?action=main\">Archive</a>&#187;My Authorized Posts
</div></div>";
echo"<div id=\"main_content\">";
    echo "<p><small>";
if($page=="" || $page<=0)$page=1;
if($page==1)
{
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_artpc WHERE app='1' AND authorid='".$uid."'"));
$num_items = $noi[0]; //changable
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
if($page>$num_pages)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;
if($limit_start<0)$limit_start=0;
$topics = mysql_query("SELECT id, name, authorid, arcid, views, text, pollid FROM ibwfrr_artpc WHERE app='1' AND authorid='".$uid."' ORDER BY lastpost DESC, name, id LIMIT $limit_start, $items_per_page");
}
while($topic = mysql_fetch_array($topics))
{
$nop = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_arpost WHERE tid='".$topic[0]."'"));
$tnm = htmlspecialchars($topic[1]);

echo"<div class=\"timeline\"><table class=\"msg\">
<tr class=\"msg-header\"><td class=\"avatar\" rowspan=\"3\">";
$avlink = getavatar($topic[2]);
if($avlink=="")
{echo "<img src=\"images/nopic.jpg\" width=\"25\" height=\"25\" alt=\"*\"/>";}else{
echo "<img src=\"$avlink\" width=\"25\" height=\"25\" alt=\"*\"/>";}
echo"</td>
<td class=\"user-info\">
<a href=\"index.php?action=viewuser&amp;who=$topic[2]\">";
$name = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$topic[2]."'"));
echo"<span class=\"username\"><b>$name[0]</b></span></a>
</td></tr><tr class=\"msg-container\"><td colspan=\"2\" class=\"msg-content\"><div class=\"msg-text\"><div class=\"dir-ltr\">
<strong>Title: $topic[1]</strong><br/>";
$category = mysql_fetch_array(mysql_query("SELECT name FROM ibwfrr_arcid WHERE id='".$topic[3]."'"));
echo"<strong>Category: $category[0]</strong><br/>";
	   /// pm extra ///
	  $pmtext = htmlspecialchars($topic[5]);
	  $pmdet = substr($pmtext,0,25);
       $pmex = "$pmdet .......";
echo"Texts: $pmex <br/>";

$comment = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_arpost WHERE tid='".$topic[0]."'"));
echo"<strong>$comment[0] comments/$topic[4] views</strong></div></div>
</td></tr><tr><td colspan=\"2\" class=\"meta-and-actions\"><span class=\"metadata\">
<a href=\"archive.php?action=viewarcpost&amp;postid=$topic[0]\">Read full post</a></span>
<span class=\"msg-actions\"></span></td></tr></table></div>";
}



echo "";

/*
echo"
<center><a href=\"archive.php?action=recentposts\">More&#187;</a></center>";*/
echo "</small></p>";

echo "<p align=\"center\"><small>";
if($page>1){$ppage = $page-1;
echo "<a href=\"index.php?action=viewfrm&amp;page=$ppage&amp;fid=$fid&amp;view=$view\">&#171;PREV</a> ";
}if($page<$num_pages){$npage = $page+1;
echo "<a href=\"index.php?action=viewfrm&amp;page=$npage&amp;fid=$fid&amp;view=$view\">Next&#187;</a>";
}

if($num_pages>1){
$rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
$rets .= "<anchor>[GO]";
$rets .= "<go href=\"index.php\" method=\"get\">";
$rets .= "<postfield name=\"action\" value=\"$action\"/>";
$rets .= "<postfield name=\"fid\" value=\"$fid\"/>";
$rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
$rets .= "<postfield name=\"view\" value=\"$view\"/>";
$rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
$rets .= "</go></anchor>";
echo $rets;
}

echo"
</div>
<div id=\"footer\"><div style=\"margin:0;padding:0;display:inline\"></div>
<table class=\"global-actions\"><tr><td><a href=\"index.php?action=main\">Home</a></td>
<td><a href=\"#top\">Top</a></td><td><a href=\"index.php?action=logout\">Log Out</a></td></tr></table></div>
</p></body></html>";
    echo "</html>";
}
else if($action=="viewarcpost")
{
echo "<body class=\"images nojs users-page users-show-page\">
<div id=\"container\"><div id=\"brand_bar\">
<table id=\"top\"><tr><td class=\"left\">
<a href=\"index.php?action=main\" class=\"brandmark\">
<img alt=\"AW\" src=\"frendz.png\" width=\"44\" /></a></td><td class=\"right\">
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"lists.php?action=buds\">
<img alt=\"Friends\" src=\"top_buds.png\" width=\"36\" /></a>
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"inbox.php?action=main\">
<img alt=\"Inbox\" src=\"top_msg.png\" width=\"36\" /></a>
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"index.php?action=chat\"><img alt=\"Chat\" src=\"top_pop.png\" width=\"40\" /></a>
</td></tr></table></div>";

$who = $_GET['who'];
$postid = isnum((int)$_GET['postid']);
addonline(getuid_sid($sid),"Viewing Forum","index.php?action=viewfrm&amp;fid=$fid");

$id = mysql_fetch_array(mysql_query("SELECT arcid from ibwfrr_artpc WHERE id='".$postid."'"));
$finfo = mysql_fetch_array(mysql_query("SELECT name from ibwfrr_arcid WHERE id='".$id[0]."'"));
$fnm = htmlspecialchars($finfo[0]);
$fi1 = mysql_fetch_array(mysql_query("SELECT name from ibwfrr_artpc WHERE id='".$postid."'"));
  $fi = parsepm($fi1[0], $sid);
echo"<div class=\"disco\"><div class=\"disco-header\" align=\"left\">
<a href=\"index.php?action=main\">Home</a>&#187;<a href=\"archive.php?action=main\">Archive</a>
&#187;<a href=\"archive.php?action=authorizedposts&amp;arcid=$id[0]\">$fnm</a>&#187;$fi1[0]
</div></div>";

$topic = mysql_fetch_array(mysql_query("SELECT id, name, authorid, arcid, views, text, pollid, crdate, appby FROM ibwfrr_artpc WHERE id='".$postid."'"));
  $arc = parsepm($topic[1], $sid); 
 // $arcpost = parsepm($topic[5], $sid);
  
 $fshout = htmlspecialchars($topic[5]);
$fshout = getsmilies($fshout);
$fshout = parsemsg($topic[5],$sid);
$fshout = getbbcode($fshout,$sid);
$arcpost = $fshout; 
  
  
 $vws = $topic[4]+1;
      mysql_query("UPDATE ibwfrr_artpc SET views='".$vws."' WHERE  id='".$postid."'");
echo"<div id=\"main_content\">";
    echo "<p><small>";
echo"<div class=\"titles\">$fi</div>";
if(ismod($uid)){
echo "<center><a href=\"archive.php?action=deleteposts&amp;postid=$postid\">
<strong>Delete</strong></a>,";
 $postban = mysql_fetch_array(mysql_query("SELECT app FROM ibwfrr_artpc WHERE id='".$postid."'"));
  if($postban[0] == 1){
echo"<a href=\"archive.php?action=dapp&amp;postid=$postid\">
<strong>Disauthorized</strong></a></center>";
}else{
echo"<a href=\"archive.php?action=app&amp;postid=$postid\">
<strong>Authorized</strong></a></center>";
}
	  }else{
	  echo"";
	  }
	  //////////////////////
echo "<div class=\"msg-detail\">
<div class=\"main-msg-container\"><table class=\"main-msg\"><tr><td class=\"avatar\" rowspan=\"1\">";
$avlink = getavatar($topic[2]);
if($avlink=="")
{echo "<img src=\"images/nopic.jpg\" width=\"25\" height=\"25\" alt=\"*\"/>";}else{
echo "<img src=\"$avlink\" width=\"25\" height=\"25\" alt=\"*\"/>";}
$name = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$topic[2]."'"));

echo"</td><td class=\"user-info\">
<a href=\"index.php?action=viewuser&amp;who=$topic[2]\">
<span class=\"username\">$name[0]</span></a></td></tr><tr>
<td class=\"msg-content\" colspan=\"3\"><div class=\"msg-text\">
<div class=\"dir-ltr\"><span style=\"color: blue;\">$arc</span>
<br /><br />$arcpost</div></div>";
echo"<div class=\"metadata\">Category: $fnm<br/>";
$topic11 = mysql_fetch_array(mysql_query("SELECT crdate FROM ibwfrr_artpc WHERE id='".$postid."'"));
    $dtot = date("l, d F Y -h:i:s a",$topic11[0]);
	$auth = getnick_uid($topic[8]);
echo"Posted on: ".$dtot."<br/>Authorized by: <b>$auth</b></div></td>
</tr></div></div><td class=\"optional-section\" colspan=\"3\"><div class=\"msg-stats\"><div class=\"stat\">";
$comment = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_arpost WHERE tid='".$topic[0]."'"));
echo"<span class=\"nb\"><span class=\"statnum\">$comment[0] </span>
<span class=\"statlabel\">Comments</span><span class=\"statnum\">$topic[4] </span><span class=\"statlabel\">Views</span></span></div></div></td></tr></table>
<ul class=\"topics-list\"><li class=\"topic\"></li></ul></div></div>
<div class=\"messages\"><div class=\"msgsheet\">";

echo"<form action=\"archive.php?action=submitcomment\" class=\"msgform\" method=\"post\">
<table class=\"msgtable\"><div class=\"titles\">Comment</div>
<tr><td><div class=\"msg_box\">
<textarea class=\"msgbox\" name=\"commentxt\" maxlength=\"500000\"/></textarea>
<input type=\"hidden\" name=\"postid\" value=\"$topic[0]\"/>
<input type=\"hidden\" name=\"arcid\" value=\"$topic[3]\"/></div></td></tr>";

echo"<tr><td class=\"msg-btn-container\">
<span class=\"w-button-common w-button-default\"><input name=\"commit\" type=\"submit\" value=\"Submit\" />
</span></td></tr></table></form></div></div><div id=\"main_content\"><p><small>";

////////////////////
if($page=="" || $page<=0)$page=1;
if($page==1)
{
$postid = isnum((int)$_GET['postid']);
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_arpost WHERE tid='".$postid."'"));
$num_items = $noi[0]; //changable
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
if($page>$num_pages)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;
if($limit_start<0)$limit_start=0;
$topics2 = mysql_query("SELECT id, text, uid, dtpost FROM ibwfrr_arpost WHERE tid='".$postid."' ORDER BY dtpost DESC, text, id LIMIT $limit_start, $items_per_page");
}
while($topic2 = mysql_fetch_array($topics2))
{

echo"<div class=\"timeline replies\"><div class=\"msg-gallery\">
<table class=\"main-msg\"><tr class=\"msg-header\"><td class=\"avatar\" rowspan=\"3\">";
$avlink = getavatar($topic2[2]);
if($avlink=="")
{echo "<img src=\"images/nopic.jpg\" width=\"25\" height=\"25\" alt=\"*\"/>";}else{
echo "<img src=\"$avlink\" width=\"25\" height=\"25\" alt=\"*\"/>";}
$h = getnick_uid($topic2[2]);
echo"</td><td class=\"user-info\">
<a href=\"index.php?action=viewuser&amp;who=$topic2[2]\"><span class=\"username\">$h</span>
</a></td></tr><tr class=\"msg-container\"><td colspan=\"2\" class=\"msg-content\"><div class=\"msg-text\"><div class=\"dir-ltr\">";
 // $pmtext = parsepm($topic2[1], $sid);
  
$fshout = htmlspecialchars($topic2[1]);
$fshout = getsmilies($fshout);
$fshout = parsemsg($topic2[1],$sid);
$fshout = getbbcode($fshout,$sid);
$pmtext = $fshout; 
  
  
  
  
      $dtot = date("l, d F Y -h:i:s a",$topic2[3]);
echo"".$pmtext."
<div class=\"metadata\">".$dtot." <a href=\"index.php?action=viewuser&amp;who=$topic2[2]\">
</a><b></b></div></div></div></div></td></tr><tr><td colspan=\"2\" class=\"meta-and-actions\"><div align=\"right\"><span class=\"msg-actions\"></span></td>
</tr></table></div></div>";
///////////////////////////////////////
}

echo "</small></p>";

echo "<p align=\"center\"><small>";
if($page>1){$ppage = $page-1;
echo "<a href=\"archive.php?action=viewarcpost&amp;page=$ppage&amp;postid=$postid\">&#171;PREV</a> ";
}if($page<$num_pages){$npage = $page+1;
echo "<a href=\"archive.php?action=viewarcpost&amp;page=$npage&amp;postid=$postid\">Next&#187;</a>";
}
 echo "<br/>$page/$num_pages<br/>";
if($num_pages>1){

$rets = "<form action=\"archive.php\" method=\"get\">";
        $rets .= "<input name=\"page\" style=\"-wap-input-format: '*N'\" size=\"2\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
		$rets .= "<input type=\"hidden\" name=\"fid\" value=\"$fid\"/>";
		//$rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
		$rets .= "<input type=\"hidden\" name=\"postid\" value=\"$postid\"/>";
		$rets .= "<input type=\"hidden\" name=\"page\" value=\"$pg\"/>";
        $rets .= "<input type=\"submit\" value=\"Go To Page\"/>";
        $rets .= "</form>";



/*
$rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
$rets .= "<anchor>[GO]";
$rets .= "<go href=\"index.php\" method=\"get\">";
$rets .= "<postfield name=\"action\" value=\"$action\"/>";
$rets .= "<postfield name=\"fid\" value=\"$fid\"/>";
$rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
$rets .= "<postfield name=\"view\" value=\"$view\"/>";
$rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
$rets .= "</go></anchor>";*/
echo $rets;
}



echo"</div></div><div id=\"footer\"><div style=\"margin:0;padding:0;display:inline\"></div>
<table class=\"global-actions\"><tr><td><a href=\"index.php?action=main\">Home</a></td>
<td><a href=\"#top\">Top</a></td><td><a href=\"index.php?action=logout\">Log Out</a></td></tr></table></div>
</p></body></html>";
    echo "</html>";
}else if($action=="submitpost")
{
  $amount = mysql_fetch_array(mysql_query("SELECT balance FROM dcroxx_me_users WHERE id='".getuid_sid($sid)."'"));
  if($amount[0] < 5){
    $pstyle = gettheme($sid);
      echo xhtmlhead("Messages Service",$pstyle);
      echo "<p align=\"center\"><small>";
      echo "[x]<br/>Insufficient Balance<br/>";
            echo "You need atleast <b>5 BDT</b> for unlock archive submit service<br/>
            Make shouts and friendship with others and stay 1hour for earn <b>5 BDT</b>";
            echo "</small></p>";
                echo"<p align=\"center\"><small>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a><br/><br/>";
  echo "</small></p>";
    echo "</card>";
    exit();
  }

echo "<body class=\"images nojs users-page users-show-page\">
<div id=\"container\"><div id=\"brand_bar\">
<table id=\"top\"><tr><td class=\"left\">
<a href=\"index.php?action=main\" class=\"brandmark\">
<img alt=\"AW\" src=\"frendz.png\" width=\"44\" /></a></td><td class=\"right\">
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"lists.php?action=buds\">
<img alt=\"Friends\" src=\"top_buds.png\" width=\"36\" /></a>
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"inbox.php?action=main\">
<img alt=\"Inbox\" src=\"top_msg.png\" width=\"36\" /></a>
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"index.php?action=chat\"><img alt=\"Chat\" src=\"top_pop.png\" width=\"40\" /></a>
</td></tr></table></div>";

$who = $_GET['who'];
$postid = isnum((int)$_GET['postid']);
addonline(getuid_sid($sid),"Viewing Forum","index.php?action=viewfrm&amp;fid=$fid");

$id = mysql_fetch_array(mysql_query("SELECT arcid from ibwfrr_artpc WHERE id='".$postid."'"));
$finfo = mysql_fetch_array(mysql_query("SELECT name from ibwfrr_arcid WHERE id='".$id[0]."'"));
$fnm = htmlspecialchars($finfo[0]);
$fi = mysql_fetch_array(mysql_query("SELECT name from ibwfrr_artpc WHERE id='".$postid."'"));
echo"<div class=\"disco\"><div class=\"disco-header\" align=\"left\">
<a href=\"index.php?action=main\">Home</a>&#187;<a href=\"archive.php?action=main\">Archive</a>&#187;Submit Post
</div></div>";

echo"<div id=\"main_content\">";
    echo "<div class=\"x15\">Your post will be visible after completeing review and authorization by staff team.<br/>
You will get 3 plusses for each authorized posts.<br/>Your posts should be informative and remember to choose right category before submitting otherwise
 it will not be authorized.<br/>Adult jokes/posts are not allowed.<br/>You can use 
 <a href=\"archive.php?action=bbcodes\">these BBCodes</a> to decorate your posts.</div>
<div class=\"msgsheet has-footer\"><div class=\"msgbox-container\">";


echo"<form action=\"archive.php?action=processpost\" method=\"post\"><table class=\"msgtable\"><tr><td colspan=\"3\">
<b>Category:</b><br/><select name=\"arc\">";

$fcats = mysql_query("SELECT id, name FROM ibwfrr_arcid ORDER BY position, id");
while($fcat=mysql_fetch_array($fcats))
{
$nop = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_artpc WHERE arcid='".$fcat[0]."'"));
echo "<option value=\"$fcat[0]\">$fcat[1]</option>";
}
echo"</select><br/><b>Title</b><br/>
<div class=\"msg_box\">
<input class=\"titlebox\" type=\"text\" name=\"title\" value=\"\" maxlength=\"500\"/></div>
<br/><b>Message</b><br/>
<div class=\"msg_box\">
<textarea class=\"msgbox\" name=\"content\" rows=\"7\" cols=\"10\" maxlength=\"500000\"/></textarea>

<postfield name=\"arc\" type=\"hidden\" value=\"$(arc)\"/>
<postfield name=\"title\" type=\"hidden\" value=\"$(title)\"/>
<postfield name=\"content\" type=\"hidden\" value=\"$(content)\"/>

</div></td></tr><tr><td class=\"msg-btn-container\">
<span class=\"w-button-common submit w-button-default\">

<input name=\"commit\" type=\"submit\" value=\"Submit\"/>
</span></td></tr></table></form></div>";





echo"</div></div><div id=\"footer\"><div style=\"margin:0;padding:0;display:inline\"></div>
<table class=\"global-actions\"><tr><td><a href=\"index.php?action=main\">Home</a></td>
<td><a href=\"#top\">Top</a></td><td><a href=\"index.php?action=logout\">Log Out</a></td></tr></table></div>
</p></body></html>";
    echo "</html>";
}else if($action=="app")
{
echo "<body class=\"images nojs users-page users-show-page\">
<div id=\"container\"><div id=\"brand_bar\">
<table id=\"top\"><tr><td class=\"left\">
<a href=\"index.php?action=main\" class=\"brandmark\">
<img alt=\"AW\" src=\"frendz.png\" width=\"44\" /></a></td><td class=\"right\">
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"lists.php?action=buds\">
<img alt=\"Friends\" src=\"top_buds.png\" width=\"36\" /></a>
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"inbox.php?action=main\">
<img alt=\"Inbox\" src=\"top_msg.png\" width=\"36\" /></a>
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"index.php?action=chat\"><img alt=\"Chat\" src=\"top_pop.png\" width=\"40\" /></a>
</td></tr></table></div>";

$who = $_GET['who'];
$postid = isnum((int)$_GET["postid"]);
addonline(getuid_sid($sid),"Viewing Forum","index.php?action=viewfrm&amp;fid=$fid");

$id = mysql_fetch_array(mysql_query("SELECT arcid, authorid from ibwfrr_artpc WHERE id='".$postid."'"));
$finfo = mysql_fetch_array(mysql_query("SELECT name, authorid, appby from ibwfrr_artpc WHERE id='".$postid."'"));
$fnm = htmlspecialchars($finfo[0]);
$fi = mysql_fetch_array(mysql_query("SELECT name from ibwfrr_artpc WHERE id='".$postid."'"));
echo"<div class=\"disco\"><div class=\"disco-header\" align=\"left\">
<a href=\"index.php?action=main\">Home</a>&#187;<a href=\"archive.php?action=main\">Archive</a>&#187;Authorized Post
</div></div>";

echo"<div id=\"main_content\"><div class=\"x15\">";
$uid =getuid_sid($sid);

$res = mysql_query("UPDATE ibwfrr_artpc SET appby='".$uid."', app='1' WHERE id='".$postid."'");
if($res)
{
$hehe=mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$id[0]."'"));
$totl = $hehe[0]+3;
//$tot = $hehe[1]+1;
mysql_query("UPDATE ibwfrr_users SET plusses='".$totl."' WHERE id='".$id[0]."'");
echo "<img src=\"images/ok.gif\" alt=\"o\"/>Post <b>$fnm</b> authorized successfully!<br/>";
/*mysql_query("INSERT INTO dcroxx_me_private SET byuid = '".$uid."', touid = '".$finfo[1]."', text = '[b]NOTIFICATION:[/b]
[br/]Your thread [archive=".$postid."]$fnm"."[/archive] approved! and 3 Plusses added to your account[br/]
[small]P.S. This is an automated PM for all staffs[/small]', timesent = '".time()."'");*/
$tnm = htmlspecialchars($title);
$ibwf = time()+6*60*60;
$user = getnick_uid($finfo[1]);
mysql_query("insert into ibwfrr_events (event,time) values ('<b>$user</b> has created <b>$fnm</b>','$ibwf')");


$nick = getnick_sid($sid);
$note = "Your thread [archive=".$postid."]$fnm"."[/archive] has been approved! and 3 Plusses added to your account";
notify($note,$uid,$finfo[1]);


/////////Follower Notify
/*$user = getnick_uid($id[1]);
$sql1 = mysql_query("SELECT uid FROM ibwfrr_follow WHERE followid=".$id[1]."");
while ($id1 = @mysql_fetch_array($sql1))
{
	$nick = getnick_sid($sid);
@mysql_query("INSERT INTO ibwfrr_notifications SET byuid = '".$uid."', touid = '".$id1[0]."', text = 'Follower Notify:[br/][b]$user"."[/b] 
Create [b]$fnm"."[/b] in Post Archive', timesent = '".time()."', unread = '1', starred = '0'");
}*/
/////////////////////

}else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>Can't authorized at this moment<br/>";
}
 
echo"</div><div class=\"msgsheet has-footer\"></div></div><div id=\"footer\"><div style=\"margin:0;padding:0;display:inline\"></div>
<table class=\"global-actions\"><tr><td><a href=\"index.php?action=main\">Home</a></td>
<td><a href=\"#top\">Top</a></td><td><a href=\"index.php?action=logout\">Log Out</a></td></tr></table></div>
</p></body></html>";
    echo "</html>";
}else if($action=="deleteposts")
{
echo "<body class=\"images nojs users-page users-show-page\">
<div id=\"container\"><div id=\"brand_bar\">
<table id=\"top\"><tr><td class=\"left\">
<a href=\"index.php?action=main\" class=\"brandmark\">
<img alt=\"AW\" src=\"frendz.png\" width=\"44\" /></a></td><td class=\"right\">
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"lists.php?action=buds\">
<img alt=\"Friends\" src=\"top_buds.png\" width=\"36\" /></a>
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"inbox.php?action=main\">
<img alt=\"Inbox\" src=\"top_msg.png\" width=\"36\" /></a>
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"index.php?action=chat\"><img alt=\"Chat\" src=\"top_pop.png\" width=\"40\" /></a>
</td></tr></table></div>";

$who = $_GET['who'];
$postid = isnum((int)$_GET["postid"]);
addonline(getuid_sid($sid),"Viewing Forum","index.php?action=viewfrm&amp;fid=$fid");

$id = mysql_fetch_array(mysql_query("SELECT arcid from ibwfrr_artpc WHERE id='".$postid."'"));
$finfo = mysql_fetch_array(mysql_query("SELECT name, authorid from ibwfrr_artpc WHERE id='".$postid."'"));
$fnm = htmlspecialchars($finfo[0]);
$fi = mysql_fetch_array(mysql_query("SELECT name from ibwfrr_artpc WHERE id='".$postid."'"));
echo"<div class=\"disco\"><div class=\"disco-header\" align=\"left\">
<a href=\"index.php?action=main\">Home</a>&#187;<a href=\"archive.php?action=main\">Archive</a>&#187;Delete Post
</div></div>";

echo"<div id=\"main_content\"><div class=\"x15\">";
$uid =getuid_sid($sid);
$f = mysql_fetch_array(mysql_query("SELECT name, authorid from ibwfrr_artpc WHERE id='".$postid."'"));
//$res = mysql_query("UPDATE ibwfrr_artpc SET del='1' WHERE id='".$postid."'");;
$res = mysql_query("DELETE FROM ibwfrr_artpc WHERE id='".$postid."'");
if($res)
{
echo "<img src=\"images/ok.gif\" alt=\"o\"/>Post <b>$fnm</b> deleted successfully!<br/>";
/* mysql_query("INSERT INTO dcroxx_me_private SET text='
 We are sorry but your post <b>$fnm</b> is declined and deleted., byuid='".$uid."', touid='".$finfo[1]."', timesent='".$tm."'");*/

$nick = getnick_sid($sid);
$note = "We are sorry but your post <b>$fnm</b> is declined and deleted.";
notify($note,$uid,$finfo[1]); 
 
 }else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>Can't delete at this moment<br/>";
}
 
echo"</div><div class=\"msgsheet has-footer\"></div></div><div id=\"footer\"><div style=\"margin:0;padding:0;display:inline\"></div>
<table class=\"global-actions\"><tr><td><a href=\"index.php?action=main\">Home</a></td>
<td><a href=\"#top\">Top</a></td><td><a href=\"index.php?action=logout\">Log Out</a></td></tr></table></div>
</p></body></html>";
    echo "</html>";
}else if($action=="processpost")
{
echo "<body class=\"images nojs users-page users-show-page\">
<div id=\"container\"><div id=\"brand_bar\">
<table id=\"top\"><tr><td class=\"left\">
<a href=\"index.php?action=main\" class=\"brandmark\">
<img alt=\"AW\" src=\"frendz.png\" width=\"44\" /></a></td><td class=\"right\">
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"lists.php?action=buds\">
<img alt=\"Friends\" src=\"top_buds.png\" width=\"36\" /></a>
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"inbox.php?action=main\">
<img alt=\"Inbox\" src=\"top_msg.png\" width=\"36\" /></a>
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"index.php?action=chat\"><img alt=\"Chat\" src=\"top_pop.png\" width=\"40\" /></a>
</td></tr></table></div>";

$uid =getuid_sid($sid);
/*$arc = mysql_real_escape_string($_POST['arc']);
$title = mysql_real_escape_string($_POST['title']);
$content = mysql_real_escape_string($_POST['content']);*/
$arc = $_POST["arc"];
$title = $_POST["title"];
$content = $_POST["content"];
addonline(getuid_sid($sid),"Viewing Forum","index.php?action=viewfrm&amp;fid=$fid");

$id = mysql_fetch_array(mysql_query("SELECT arcid from ibwfrr_artpc WHERE id='".$postid."'"));
$finfo = mysql_fetch_array(mysql_query("SELECT name from ibwfrr_arcid WHERE id='".$id[0]."'"));
$fnm = htmlspecialchars($finfo[0]);
$fi = mysql_fetch_array(mysql_query("SELECT name from ibwfrr_artpc WHERE id='".$postid."'"));
echo"<div class=\"disco\"><div class=\"disco-header\" align=\"left\">
<a href=\"index.php?action=main\">Home</a>&#187;<a href=\"archive.php?action=main\">Archive</a>&#187;Submit Post
</div></div>";

	  
echo"<div id=\"main_content\"><div class=\"toast flash\">";

//////////////////////////////////////////
 if(strlen($content)<200)
 {
      echo "<img src=\"images/notok.gif\" alt=\"X\"/>Message should contain at least 200 characters<br/>
	  <img src=\"images/notok.gif\" alt=\"X\"/>Your post couldnt be processed.<br/>";
echo "</div></div><div id=\"footer\">
<div style=\"margin:0;padding:0;display:inline\"></div>
<table class=\"global-actions\"><tr><td><a href=\"index.php?action=main\">Home</a>
</td><td><a href=\"#top\">Top</a></td><td>
<a href=\"index.php?action=logout\">Log Out</a></td></tr></table></div></p></body></html>";
      exit();
}
  $crdate = time();
$texst = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_artpc WHERE name LIKE '".$title."' AND arcid='".$arc."'"));
if($texst[0]==0)
{$res = false;
/////////////////////////
$ltopic = mysql_fetch_array(mysql_query("SELECT crdate FROM ibwfrr_artpc WHERE authorid='".$uid."' ORDER BY crdate DESC LIMIT 1"));
global $topic_af;
$antiflood = time()-$ltopic[0];
if($antiflood>$topic_af)
{
/////////////////////
if((trim($title)!="")||(trim($content)!=""))
{
if(!isblocked($title,$uid)&&!isblocked($content,$uid))
{

$res = mysql_query("INSERT INTO ibwfrr_artpc SET name='".$title."', arcid='".$arc."', authorid='".$uid."', text='".$content."', crdate='".$crdate."', lastpost='".$crdate."', app='0'");
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>";
echo "Your post couldnt be processed.";
$user = getnick_sid($sid);
$w3btime = time();
$user = getnick_uid($uid);
echo "</div></div><div id=\"footer\">
<div style=\"margin:0;padding:0;display:inline\"></div>
<table class=\"global-actions\"><tr><td><a href=\"index.php?action=main\">Home</a>
</td><td><a href=\"#top\">Top</a></td><td>
<a href=\"index.php?action=logout\">Log Out</a></td></tr></table></div></p></body></html>";
exit();
}
}
if($res)
{
/*$usts = mysql_fetch_array(mysql_query("SELECT posts, plusses FROM ibwfrr_users WHERE id='".$uid."'"));
$ups = $usts[0]+1;
$upl = $usts[1]+1;
mysql_query("UPDATE ibwfrr_users SET posts='".$ups."', plusses='".$upl."' WHERE id='".$uid."'");*/
$tnm = htmlspecialchars($title);
$ibwf = time()+6*60*60;
$user = getnick_uid($uid);
$who = getnick_uid($who);
$ust = mysql_fetch_array(mysql_query("SELECT id, name FROM ibwfrr_artpc WHERE name='".$title."'"));
$tname = htmlspecialchars($ust[1]);


echo "<img src=\"images/ok.gif\" alt=\"O\"/>Post <b>$tnm</b> submitted successfully and it's being reviewed by the staff team. Please wait until one of the moderators authorize it.";

/////////Follower Notify
/*$sql1 = mysql_query("SELECT uid FROM ibwfrr_follow WHERE followid=".$uid."");
while ($id1 = @mysql_fetch_array($sql1))
{
	$nick = getnick_sid($sid);
@mysql_query("INSERT INTO ibwfrr_notifications SET byuid = '".$uid."', touid = '".$id1[0]."', text = 'Follower Notify:[br/][b]$user"."[/b] 
Create [b]$tnm"."[/b] in Post Archive', timesent = '".time()."', unread = '1', starred = '0'");
}*/
/////////////////////
$tid = mysql_fetch_array(mysql_query("SELECT id FROM ibwfrr_artpc WHERE name='".$title."' AND arcid='".$arc."'"));
$sql = mysql_query("SELECT id, name FROM dcroxx_me_users WHERE perm>'0'");
while ($id = @mysql_fetch_array($sql))
{
	$nick = getnick_sid($sid);
@mysql_query("INSERT INTO ibwf_notifications SET byuid = '3', touid = '".$id[0]."', text = 'A new thread posted in [archivestaff=".$ust[0]."]Post Archive[/archivestaff] n need your approval for publish.[br/]', timesent = '".time()."'");
}

}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Your post couldnt be processed.";
}
}else{
$af = $topic_af -$antiflood;
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Antiflood Control: $af";
}
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Already have a post with this Title";
}
  
  //////////////////////////////////////
echo"</div></div><div id=\"footer\">
<div style=\"margin:0;padding:0;display:inline\"></div>
<table class=\"global-actions\"><tr><td><a href=\"index.php?action=main\">Home</a>
</td><td><a href=\"#top\">Top</a></td><td>
<a href=\"index.php?action=logout\">Log Out</a></td></tr></table></div></p></body></html>";
}
else if($action=="submitcomment")
{
echo "<body class=\"images nojs users-page users-show-page\">
<div id=\"container\"><div id=\"brand_bar\">
<table id=\"top\"><tr><td class=\"left\">
<a href=\"index.php?action=main\" class=\"brandmark\">
<img alt=\"AW\" src=\"frendz.png\" width=\"44\" /></a></td><td class=\"right\">
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"lists.php?action=buds\">
<img alt=\"Friends\" src=\"top_buds.png\" width=\"36\" /></a>
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"inbox.php?action=main\">
<img alt=\"Inbox\" src=\"top_msg.png\" width=\"36\" /></a>
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"index.php?action=chat\"><img alt=\"Chat\" src=\"top_pop.png\" width=\"40\" /></a>
</td></tr></table></div>";

$uid =getuid_sid($sid);
/*$arcid = mysql_real_escape_string($_POST["arcid"]);
$postid = mysql_real_escape_string($_POST["postid"]);
//$content = mysql_real_escape_string($_GET['content']);
$commentxt = mysql_real_escape_string($_POST["commentxt"]);*/
$arcid = $_POST["arcid"];
$postid = $_POST["postid"];
//$content = mysql_real_escape_string($_GET['content']);
$commentxt = $_POST["commentxt"];

addonline(getuid_sid($sid),"Viewing Forum","index.php?action=viewfrm&amp;fid=$fid");
echo"<div class=\"disco\"><div class=\"disco-header\" align=\"left\">
<a href=\"index.php?action=main\">Home</a>&#187;<a href=\"archive.php?action=main\">Archive</a>&#187;Submit Comment
</div></div>";
echo"<div id=\"main_content\"><div class=\"toast flash\">";

////////////
$pex = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_arpost WHERE text LIKE '".$commentxt."' AND tid='".$postid."'"));
if($pex[0]==0)
{
/////////////
  $crdate = time();
if(trim($commentxt)==""){
echo "<img src=\"images/notok.gif\" alt=\"X\"/>";
echo "Comment can't be blank";
$user = getnick_sid($sid);
$w3btime = time();
$user = getnick_uid($uid);
echo "</div></div><div id=\"footer\">
<div style=\"margin:0;padding:0;display:inline\"></div>
<table class=\"global-actions\"><tr><td><a href=\"index.php?action=main\">Home</a>
</td><td><a href=\"#top\">Top</a></td><td>
<a href=\"index.php?action=logout\">Log Out</a></td></tr></table></div></p></body></html>";
exit();
/*if(!isblocked($commentxt,$uid)){
$res = mysql_query("INSERT INTO ibwfrr_arpost SET text='".$commentxt."', tid='".$postid."', uid='".$uid."', dtpost='".$crdate."'");
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>";
echo "Your post couldnt be processed.";
$user = getnick_sid($sid);
$w3btime = time();
$user = getnick_uid($uid);
echo "</div></div><div id=\"footer\">
<div style=\"margin:0;padding:0;display:inline\"></div>
<table class=\"global-actions\"><tr><td><a href=\"index.php?action=main\">Home</a>
</td><td><a href=\"#top\">Top</a></td><td>
<a href=\"index.php?action=logout\">Log Out</a></td></tr></table></div></p></body></html>";
exit();
}*/
}
$res = mysql_query("INSERT INTO ibwfrr_arpost SET text='".$commentxt."', tid='".$postid."', uid='".$uid."', dtpost='".$crdate."'");

if($res){
$tnm = htmlspecialchars($title);
$ibwf = time()+6*60*60;
$user = getnick_uid($uid);
$who = getnick_uid($who);
$ust = mysql_fetch_array(mysql_query("SELECT id, name, authorid FROM ibwfrr_artpc WHERE id='".$postid."'"));
$tname = htmlspecialchars($ust[1]);

$nick = getnick_uid($uid);
/*mysql_query("INSERT INTO dcroxx_me_private SET text='
$nick just comment on your post [archive=$postid]$tname"."[/archive][br/]', byuid='".$uid."', touid='".$ust[2]."', timesent='".time()."'");
*/
$txt = htmlspecialchars(substr(parsepm($shtx[0]), 0, 20));
$note = "$nick just comment on your post [archive=$postid]$tname"."[/archive]";
notify($note,$uid,$ust[2]); 


echo "<img src=\"images/ok.gif\" alt=\"O\"/>Your comment posted!";
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Your post couldnt be processed.";
}
//////////////////
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>
This post already included this type of comment.";
}

  //////////////////////////////////////
echo"</div></div><div id=\"footer\">
<div style=\"margin:0;padding:0;display:inline\"></div>
<table class=\"global-actions\"><tr><td><a href=\"index.php?action=main\">Home</a>
</td><td><a href=\"#top\">Top</a></td><td>
<a href=\"index.php?action=logout\">Log Out</a></td></tr></table></div></p></body></html>";
}else if($action=="bbcodes")
{
echo "<body class=\"images nojs users-page users-show-page\">
<div id=\"container\"><div id=\"brand_bar\">
<table id=\"top\"><tr><td class=\"left\">
<a href=\"index.php?action=main\" class=\"brandmark\">
<img alt=\"AW\" src=\"frendz.png\" width=\"44\" /></a></td><td class=\"right\">
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"lists.php?action=buds\">
<img alt=\"Friends\" src=\"top_buds.png\" width=\"36\" /></a>
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"inbox.php?action=main\">
<img alt=\"Inbox\" src=\"top_msg.png\" width=\"36\" /></a>
<img alt=\"|\" class=\"divider\" height=\"44\" src=\"brandbar_divider.gif\"/>
<a href=\"index.php?action=chat\"><img alt=\"Chat\" src=\"top_pop.png\" width=\"40\" /></a>
</td></tr></table></div>";

$who = $_GET['who'];
$postid = isnum((int)$_GET['postid']);
addonline(getuid_sid($sid),"Viewing Forum","index.php?action=viewfrm&amp;fid=$fid");

$id = mysql_fetch_array(mysql_query("SELECT arcid from ibwfrr_artpc WHERE id='".$postid."'"));
$finfo = mysql_fetch_array(mysql_query("SELECT name from ibwfrr_arcid WHERE id='".$id[0]."'"));
$fnm = htmlspecialchars($finfo[0]);
$fi = mysql_fetch_array(mysql_query("SELECT name from ibwfrr_artpc WHERE id='".$postid."'"));
echo"<div class=\"disco\"><div class=\"disco-header\" align=\"left\">
<a href=\"index.php?action=main\">Home</a>&#187;<a href=\"archive.php?action=main\">Archive</a>&#187;BBCodes List
</div></div>";

$topic = mysql_fetch_array(mysql_query("SELECT id, name, authorid, arcid, views, text, pollid, crdate, appby FROM ibwfrr_artpc WHERE arcid='".$postid."'"));
 $vws = $topic[4]+1;
      mysql_query("UPDATE ibwfrr_artpc SET views='".$vws."' WHERE  id='".$postid."'");
echo"<div id=\"main_content\">";
    echo "<div class=\"titles\">BBCodes List</div>
<div class=\"msgsheet has-footer\"><div class=\"msgbox-container\">";


echo"<br/>Use ENTER button of your phone/PC to insert line breaks.<br/><br/>
[b]TEXT[/b]: <b>TEXT</b><br/>
[i]TEXT[/i]: <i>TEXT</i><br/>
[u]TEXT[/u]: <u>TEXT</u><br/>
[big]TEXT[/big]: <big>TEXT</big><br/>
[small]TEXT[/small]: <small>TEXT</small><br/>

[center]TEXT[/center]:<center>Center Alignment</center><br/>
[red]TEXT[/red]: <font color=\"red\">TEXT</font><br/>
[darkred]TEXT[/darkred]: <font color=\"darkred\">TEXT</font><br/>
[orange]TEXT[/orange]: <font color=\"orange\">TEXT</font><br/>
[brown]TEXT[/brown]: <font color=\"brown\">TEXT</font><br/>
[yellow]TEXT[/yellow]: <font color=\"yellow\">TEXT</font><br/>
[green]TEXT[/green]: <font color=\"green\">TEXT</font><br/>
[blue]TEXT[/blue]: <font color=\"blue\">TEXT</font><br/>
[olive]TEXT[/olive]: <font color=\"olive\">TEXT</font><br/>
[cyan]TEXT[/cyan]: <font color=\"cyan\">TEXT</font><br/>
[darkblue]TEXT[/darkblue]: <font color=\"darkblue\">TEXT</font><br/>
[indigo]TEXT[/indigo]: <font color=\"indigo\">TEXT</font><br/>
[violet]TEXT[/violet]: <font color=\"violet\">TEXT</font><br/>
	</div>";


echo"</div></div><div id=\"footer\"><div style=\"margin:0;padding:0;display:inline\"></div>
<table class=\"global-actions\"><tr><td><a href=\"index.php?action=main\">Home</a></td>
<td><a href=\"#top\">Top</a></td><td><a href=\"index.php?action=logout\">Log Out</a></td></tr></table></div>
</p></body></html>";
    echo "</html>";
}
///////////
/////////////////////error//////////////////////////

else
{
  echo "<card id=\"main\" title=\"SocialBD.NeT\">";
  echo "<p align=\"center\"><small>";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
    echo "</html>";
}
 ?>
 </html>