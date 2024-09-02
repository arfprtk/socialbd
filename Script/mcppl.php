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
    }
    addonline(getuid_sid($sid),"Mod CP","");
if($action=="main")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Tools",$pstyle);
    echo "<card id=\"main\" title=\"Mod CP\">";
    echo "<p align=\"center\">";
    echo "<b>Reports</b>";
    echo "</p>";
     echo "<p>";
	 
	 echo "<b><a href=\"mcppl.php?action=tops&amp;who=$who\">Top Staff Members in $stitle!</a></b><br/>";
	 echo "<a href=\"mprocpl.php?action=mbrl\">Search by Ip!</a><br/>";
	  echo "<a href=\"mprocpl.php?action=4n\">Search by browser!</a><br/>";
	 	 $no = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE validated='0' "));

echo "<a href=\"mcppl.php?action=validatelist&amp;who=$who\">waiting to Validate!!($no[0]) </a><br/>";
    $nrpm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE reported='1'"));
    echo "<a href=\"mcppl.php?action=rpm\">&#187;Pr. Messages($nrpm[0])</a><br/>";
    $nrps = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_posts WHERE reported='1'"));
    echo "<a href=\"mcppl.php?action=rps\">&#187;Posts($nrps[0])</a><br/>";
    $nrtp = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_topics WHERE reported='1'"));
    echo "<a href=\"mcppl.php?action=rtp\">&#187;Topics($nrtp[0])</a>";
    echo "</p>";
     echo "<p align=\"center\">";
    echo "<b>Logs</b>";
    echo "</p>";
    
     echo "<p>";
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_mlog"));
    if($noi[0]>0){
    $nola = mysql_query("SELECT DISTINCT (action)  FROM dcroxx_me_mlog ORDER BY actdt DESC");

      while($act=mysql_fetch_array($nola))
      {
        $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_mlog WHERE action='".$act[0]."'"));
        echo "<a href=\"mcppl.php?action=log&amp;view=$act[0]\">$act[0]($noi[0])</a><br/>";
      }

    }
    echo "</p>";
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}


/////////////////////////////////top staff

else if($action=="tops")
{$pstyle = gettheme($sid);
echo xhtmlhead("Tools",$pstyle);
    addonline(getuid_sid($sid),"Top Staff Members","");
    echo "<card id=\"main\" title=\"Top staff\">";
    echo "<p align=\"center\">";
    echo "<b>Top Staff members</b><br/>";
	echo "Here U can see Top Staff Members and their Staff points<br/> Dont be the last one in the list! lol";
    echo "</p>";
    //////ALL LISTS SCRIPT <<
    
        if($page=="" || $page<=0)$page=1;
    $num_items = regmemcount(); //changable
    $items_per_page= 11;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, name, battlep FROM dcroxx_me_users  ORDER BY battlep DESC LIMIT $limit_start, $items_per_page";

    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a> <small>Staff Points: $item[2]</small>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";

  ////// UNTILL HERE >>
    echo "<p align=\"center\">";

    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo "</card>";
}


/////////////////////////////////Reported PMs

else if($action=="rpm")
{$pstyle = gettheme($sid);
echo xhtmlhead("Tools",$pstyle);
  $page = $_GET["page"];
    echo "<card id=\"main\" title=\"Mod CP\">";
    echo "<p align=\"center\">";
    echo "<b>Reported PMs</b>";
    echo "</p>";
    echo "<p>";
    echo "<small>";
    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE reported ='1'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if($page>$num_pages)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    $sql = "SELECT id, text, byuid, touid, timesent FROM dcroxx_me_private WHERE reported='1' ORDER BY timesent DESC LIMIT $limit_start, $items_per_page";
    $items = mysql_query($sql);
    while ($item=mysql_fetch_array($items))
    {
      $fromnk = getnick_uid($item[2]);
      $tonick = getnick_uid($item[3]);
      $dtop = date("d m y - H:i:s", $item[4]);
      $text = parsepm($item[1]);
      $flk = "<a href=\"index.php?action=viewuser&amp;who=$item[2]\">$fromnk</a>";
      $tlk = "<a href=\"index.php?action=viewuser&amp;who=$item[3]\">$tonick</a>";
      echo "From: $flk To: $tlk<br/>Time: $dtop<br/>";
       echo $text;
       echo "<br/>";
       echo "<a href=\"mprocpl.php?action=hpm&amp;pid=$item[0]\">Handle</a><br/><br/>";
    }
    echo "</small>";
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"mcppl.php?action=$action&amp;page=$ppage\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"mcppl.php?action=$action&amp;page=$npage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"mcppl.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "<br/><br/>";
    echo "<a href=\"mcppl.php?action=main\">";
echo "Mod R/L</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}
else if($action=="validatelist")
{$pstyle = gettheme($sid);
echo xhtmlhead("Tools",$pstyle);
addonline(getuid_sid($sid),"Staff Tools","");
echo "<card id=\"main\" title=\"Validate List\">";
echo "<p align=\"left\">";
echo "Dont be delay!! 1st <u>check user's Online time, Ip and details</u> ,then Validate him/her.<br/> After validate,plz send a Pm asking If she/he needs any help from u.<br/>** If u get any suspectable user,<br/>*if users ip begin with 124.43. or 58.<br/>*if users browser mozilla, opera, nokia6630 or fake browser<b> Dont't Validate him/her!</b><br/>, <u>*Delete </u> option works only for Admins.<br/>";

//////ALL LISTS SCRIPT <<
if($page=="" || $page<=0)$page=1;
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE validated='0'"));
$num_items = $noi[0]; //changable
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
if(($page>$num_pages)&&$page!=1)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;

//changable sql

$sql = "SELECT id, name FROM dcroxx_me_users WHERE validated='0' ORDER BY tottimeonl DESC LIMIT $limit_start, $items_per_page";


$items = mysql_query($sql);

if(mysql_num_rows($items)>0)
{
while ($item = mysql_fetch_array($items))
{

$nopl = mysql_fetch_array(mysql_query("SELECT sex, birthday, location, tottimeonl FROM dcroxx_me_users WHERE id='".$item[0]."'"));
$uage = getage($nopl[1]);
if($nopl[0]=='M')
{$usex = "Male";}else
if($nopl[0]=='F'){$usex = "Female";}
else{$usex = "DONT VALIDATE THIS User!!";}
$nopl[2] = htmlspecialchars($nopl[2]);

$lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]($uage/$usex/$nopl[2])</a>";

echo "$lnk ";
$num = $nopl[3]/86400;
$days = intval($num);
$num2 = ($num - $days)*24;
$hours = intval($num2);
$num3 = ($num2 - $hours)*60;
$mins = intval($num3);
$num4 = ($num3 - $mins)*60;
$secs = intval($num4);

echo " ";
if(($days==0) and ($hours==0) and ($mins==0)){
  echo "$secs s<br/>";
}else
if(($days==0) and ($hours==0)){
  echo "$mins m, ";
  echo "$secs s<br/>";
}else
if(($days==0)){
  echo "$hours h, ";
  echo "$mins m, ";
  echo "$secs s<br/>";
}else{
  echo "$days days, ";
  echo "$hours hours, ";
  echo "$mins mins, ";
  echo "$secs seconds<br/>";
}
}
}
echo "</p>";
echo "<p align=\"center\">";
if($page>1)
{
$ppage = $page-1;
echo "<a href=\"mcppl.php?action=$action&amp;page=$ppage&amp;who=$who\">«Prev</a> ";
}
if($page<$num_pages)
{
$npage = $page+1;
echo "<a href=\"mcppl.php?action=$action&amp;page=$npage&amp;who=$who\">Next»</a>";
}
echo "<br/>$page/$num_pages<br/>";
if($num_pages>2)
{
$rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
$rets .= "<anchor>[GO]";
$rets .= "<go href=\"mcppl.php\" method=\"get\">";
$rets .= "<postfield name=\"action\" value=\"$action\"/>";
$rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
$rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
$rets .= "</go></anchor>";

echo $rets;
}
echo "</p>";
echo "<p align=\"center\">";
echo "<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
echo "</p>";
echo "</card>";
}
/////////////////////////////////Reported Posts

else if($action=="rps")
{$pstyle = gettheme($sid);
echo xhtmlhead("Tools",$pstyle);
  $page = $_GET["page"];
    echo "<card id=\"main\" title=\"Mod CP\">";
    echo "<p align=\"center\">";
    echo "<b>Reported Posts</b>";
    echo "</p>";
    echo "<p>";
    echo "<small>";
    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_posts WHERE reported ='1'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if($page>$num_pages)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    $sql = "SELECT id, text, tid, uid, dtpost FROM dcroxx_me_posts WHERE reported='1' ORDER BY dtpost DESC LIMIT $limit_start, $items_per_page";
    $items = mysql_query($sql);
    while ($item=mysql_fetch_array($items))
    {
      $poster = getnick_uid($item[3]);
      $tname = htmlspecialchars(gettname($item[3]));
      $dtop = date("d m y - H:i:s", $item[4]);
      $text = parsemsg($item[1]);
      $flk = "<a href=\"index.php?action=viewuser&amp;who=$item[3]\">$poster</a>";
      $tlk = "<a href=\"index.php?action=viewtpc&amp;tid=$item[2]\">$tname</a>";
      echo "Poster: $flk<br/>In: $tlk<br/>Time: $dtop<br/>";
       echo $text;
       echo "<br/>";
       echo "<a href=\"mprocpl.php?action=hps&amp;pid=$item[0]\">Handle</a><br/><br/>";
    }
    echo "</small>";
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"mcppl.php?action=$action&amp;page=$ppage\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"mcppl.php?action=$action&amp;page=$npage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"mcppl.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";

        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "<br/><br/>";
    echo "<a href=\"mcppl.php?action=main\">";
echo "Mod R/L</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}

else if($action=="adq")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Add Quiz/Contest",$pstyle);
  $who = $_GET["who"];
  echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"left\"><small>";
  $unick = getnick_uid($who);
  echo "<b>Create New Quiz</b><br/>";
  echo "</small></p>";
  
  
echo"<form method=\"post\" action=\"mprocpl.php?action=quiz\">";
  
echo "<small>Quiz Title:</small> <input name=\"qtitle\" maxlength=\"100\"/> <small>(example: Biddar Jahaj 10)</small><br/>";
echo "<small>By: </small><input name=\"qby\" maxlength=\"100\"/><small> (Your Name)</small><br/>";
echo "<small>Short Description: </small><input name=\"qdes\" maxlength=\"255\"/><small> (Question type/prize/time)</small><br/>";
echo "<small>Status:</small>";
echo "<select name=\"qstatus\" value=\"1\">";
echo "<option value=\"o\">Open</option>";
echo "<option value=\"c\">Close</option>";
echo "</select><br/>";
echo "<small>Topic ID: </small><input name=\"qtid\" format=\"*N\" maxlength=\"100\"/> <small>(Your quiz topic ID)</small><br/>";

 /* echo "<anchor>Create Quiz";
  echo "<go href=\"modproc.php?action=quiz&amp;sid=$sid\" method=\"post\">";
  echo "<postfield name=\"qtitle\" value=\"$(qtitle)\"/>";
  echo "<postfield name=\"qby\" value=\"$(qby)\"/>";
  echo "<postfield name=\"qdes\" value=\"$(qdes)\"/>";
  echo "<postfield name=\"qstatus\" value=\"$(qstatus)\"/>";
  echo "<postfield name=\"qtid\" value=\"$(qtid)\"/>"; */
  
echo"<input type=\"submit\" name=\"Submit\" value=\"Create Quiz\"/><br/></form>";
  
  
 /* echo "<p align=\"left\"><small>";
  echo "Quiz Title: <input name=\"qtitle\" maxlength=\"100\"/> (example: Biddar Jahaj 10)<br/>";
  echo "By: <input name=\"qby\" maxlength=\"100\"/> (Your Name)<br/>";
  echo "Short Description: <input name=\"qdes\" maxlength=\"255\"/> (Question type/prize/time)<br/>";
  echo "Status:";
    echo "<select name=\"qstatus\" value=\"1\">";
    echo "<option value=\"o\">Open</option>";
    echo "<option value=\"c\">Close</option>";
    echo "</select><br/>";
  echo "Topic ID: <input name=\"qtid\" format=\"*N\" maxlength=\"100\"/> (Your quiz topic ID)<br/>";

  echo "<anchor>Create Quiz";
  echo "<go href=\"modproc.php?action=quiz&amp;sid=$sid\" method=\"post\">";
  echo "<postfield name=\"qtitle\" value=\"$(qtitle)\"/>";
  echo "<postfield name=\"qby\" value=\"$(qby)\"/>";
  echo "<postfield name=\"qdes\" value=\"$(qdes)\"/>";
  echo "<postfield name=\"qstatus\" value=\"$(qstatus)\"/>";
  echo "<postfield name=\"qtid\" value=\"$(qtid)\"/>";
  //echo "<postfield name=\"who\" value=\"$ui\"/>";
  echo "</go></anchor><br/>";*/

  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
else if($action=="editquiz")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Edit Quiz/Contest",$pstyle);
  $who = $_GET["who"];
  $id = $_GET["id"];
  echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"left\"><small>";
  $unick = getnick_uid($who);
  echo "<b>Edit a Quiz</b><br/>";
  echo "</small></p>";
  //echo "<p align=\"left\"><small>";
  $tpc = mysql_fetch_array(mysql_query("SELECT id, qtitle, qby, qdes, qstatus, qtid,  who, time FROM ibwfrr_topics WHERE id='".$id."'"));
  
 echo"<form method=\"post\" action=\"mprocpl.php?action=editquiz&amp;id=$id\">"; 
  
  echo "<small>Quiz Title: </small><input name=\"qtitle\" maxlength=\"100\" value=\"$tpc[1]\"/> <small>(example: Biddar Jahaj 10)</small><br/>";
  echo "<small>By: </small><input name=\"qby\" maxlength=\"100\" value=\"$tpc[2]\"/> <small>(Your Name)</small><br/>";
  echo "<small>Short Description: </small><input name=\"qdes\" maxlength=\"255\" value=\"$tpc[3]\"/> <small>(Question type/prize/time)</small><br/>";
  echo "<small>Status:</small>";
    echo "<select name=\"qstatus\">";
    echo "<option value=\"o\">Open</option>";
    echo "<option value=\"c\">Close</option>";
    echo "</select><br/>";
echo"<input type=\"submit\" name=\"Submit\" value=\"Update Quiz\"/><br/></form>";
 // echo "Topic ID: <input name=\"qtid\" format=\"*N\" maxlength=\"100\" value=\"$tpc[5]\"/> (Your quiz topic ID)<br/>";

 /* echo "<anchor>Update Quiz";
  echo "<go href=\"modproc.php?action=editquiz&amp;sid=$sid&amp;id=$id\" method=\"post\">";
  echo "<postfield name=\"qtitle\" value=\"$(qtitle)\"/>";
  echo "<postfield name=\"qby\" value=\"$(qby)\"/>";
  echo "<postfield name=\"qdes\" value=\"$(qdes)\"/>";
  echo "<postfield name=\"qstatus\" value=\"$(qstatus)\"/>";
 // echo "<postfield name=\"qtid\" value=\"$(qtid)\"/>";
  //echo "<postfield name=\"who\" value=\"$ui\"/>";
  echo "</go></anchor><br/>";*/

  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}

else if($action=="adqw")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Quiz/Contest",$pstyle);
  $who = $_GET["who"];
  echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\"><small>";
  $unick = getnick_uid($who);
  echo "<b>Create New Quiz</b><br/>";
  echo "</small></p>";
 echo"<form method=\"post\" action=\"mprocpl.php?action=quizw\">"; 	 
  echo "<small>Quiz Owner USER ID:</small> <input name=\"qid\" format=\"*N\" maxlength=\"100\" value=\"0\"/><br/>";
  echo "<small>Reputation Point:</small> <input name=\"qrp\" format=\"*N\" maxlength=\"3\" value=\"0\"/><br/>";
  echo "<small>Plusses:</small> <input name=\"qpls\" format=\"*N\" maxlength=\"3\" value=\"0\"/><br/>";
  echo "<small>Winners USER ID:</small> <input name=\"qwid\" format=\"*N\" maxlength=\"100\" value=\"0\"/><br/>";
  echo "<small>Quiz/Contest Name:</small> <input name=\"qnm\" maxlength=\"100\"/> <small>(exp: Guess The Number 20)</small><br/>";
  echo "<small>Position:</small> <input name=\"qp\" maxlength=\"10\"/> <small>(1st, 2nd, 3rd)</small><br/>";
  echo"<input type=\"submit\" name=\"Submit\" value=\"Submit For Admin Validation\"/><br/></form>";
  /*echo "<anchor>Submit For Admin Validation";
  echo "<go href=\"modproc.php?action=quizw&amp;sid=$sid\" method=\"post\">";
  echo "<postfield name=\"qid\" value=\"$(qid)\"/>";
  echo "<postfield name=\"qrp\" value=\"$(qrp)\"/>";
  echo "<postfield name=\"qpls\" value=\"$(qpls)\"/>";
  echo "<postfield name=\"qwid\" value=\"$(qwid)\"/>";
  echo "<postfield name=\"qnm\" value=\"$(qnm)\"/>";
  echo "<postfield name=\"qp\" value=\"$(qp)\"/>";
  echo "<postfield name=\"who\" value=\"$who\"/>";
  echo "</go></anchor><br/>";*/

  echo "<br/><a href=\"index.php?action=main&amp;sid=$sid\"><img src=\"../icons/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}


/////////////////////////////////Reported Posts

else if($action=="log")
{$pstyle = gettheme($sid);
echo xhtmlhead("Tools",$pstyle);
  $page = $_GET["page"];
  $view = $_GET["view"];
    echo "<card id=\"main\" title=\"Mod CP\">";
    echo "<p align=\"center\">";
    echo "<b>$view</b>";
    echo "</p>";
    echo "<p>";
    echo "<small>";
    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_mlog WHERE  action='".$view."'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if($page>$num_pages)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    $sql = "SELECT  actdt, details FROM dcroxx_me_mlog WHERE action='".$view."' ORDER BY actdt DESC LIMIT $limit_start, $items_per_page";
    $items = mysql_query($sql);
    while ($item=mysql_fetch_array($items))
    {
 echo $item[1];
 echo "<br/>";
 echo "".date("h:i:sa @ jS M Y (l)", $item[0])."<br/>--------------<br/>";
       
    }
    echo "</small>";
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"mcppl.php?action=$action&amp;page=$ppage&amp;view=$view\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"mcppl.php?action=$action&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"mcppl.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"view\" value=\"$view\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";

        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "<br/><br/>";
    echo "<a href=\"mcppl.php?action=main\">";
echo "Mod R/L</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}

/////////////////////////////////Reported Topics

else if($action=="rtp")
{$pstyle = gettheme($sid);
echo xhtmlhead("Tools",$pstyle);
  $page = $_GET["page"];
    echo "<card id=\"main\" title=\"Mod CP\">";
    echo "<p align=\"center\">";
    echo "<b>Reported Topics</b>";
    echo "</p>";
    echo "<p>";
    echo "<small>";
    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_topics WHERE reported ='1'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if($page>$num_pages)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    $sql = "SELECT id, name, text, authorid, crdate FROM dcroxx_me_topics WHERE reported='1' ORDER BY crdate DESC LIMIT $limit_start, $items_per_page";
    $items = mysql_query($sql);
    while ($item=mysql_fetch_array($items))
    {
      $poster = getnick_uid($item[3]);
      $tname = htmlspecialchars($item[1]);
      $dtop = date("d m y - H:i:s", $item[4]);
      $text = parsemsg($item[2]);
      $flk = "<a href=\"index.php?action=viewuser&amp;who=$item[3]\">$poster</a>";
      $tlk = "<a href=\"index.php?action=viewtpc&amp;tid=$item[0]\">$tname</a>";
      echo "Poster: $flk<br/>In: $tlk<br/>Time: $dtop<br/>";
       echo $text;
       echo "<br/>";
       echo "<a href=\"mprocpl.php?action=htp&amp;tid=$item[0]\">Handle</a><br/><br/>";
    }
    echo "</small>";
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"mcppl.php?action=$action&amp;page=$ppage\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"mcppl.php?action=$action&amp;page=$npage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"mcppl.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";

        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "<br/><br/>";
    echo "<a href=\"mcppl.php?action=main\">";
echo "Mod R/L</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}

///////////////////////////////////////////////Mod a user

else if($action=="user")
{$pstyle = gettheme($sid);
echo xhtmlhead("Tools",$pstyle);
    $who = $_GET["who"];
    echo "<card id=\"main\" title=\"Mod CP\">";
    echo "<p align=\"center\">";
    $unick = getnick_uid($who);
    echo "<b>Moderating $unick</b>";
    echo "</p>";
    echo "<p>";
    echo "<a href=\"mcppl.php?action=penopt&amp;who=$who\">&#187;Penalties</a><br/>";
    echo "<a href=\"mcppl.php?action=plsopt&amp;who=$who\">&#187;Credits</a><br/><br/>";
	echo "<a href=\"mcppl.php?action=cdsopt&amp;who=$who\">&#187;Bank Credits</a><br/><br/>";
    if(istrashed($who))
    {
      echo "<a href=\"mprocpl.php?action=untr&amp;who=$who\">&#187;Untrash</a><br/>";
    }
    if(isbanned($who))
    {
      echo "<a href=\"mprocpl.php?action=unbanonley&amp;who=$who\">&#187;Unban</a><br/>";
    }
    if(!isshield($who))
    {
      echo "<a href=\"mprocpl.php?action=shld&amp;who=$who\">&#187;Shield</a><br/>";
    }else{
        echo "<a href=\"mprocpl.php?action=ushld&amp;who=$who\">&#187;Unshield</a><br/>";
    }
    echo "</p>";
    echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}

//////////////////////////////////////Penalties Options

else if($action=="penopt")
{$pstyle = gettheme($sid);
echo xhtmlhead("Tools",$pstyle);
    $who = $_GET["who"];
    echo "<card id=\"main\" title=\"Mod CP\">";
    echo "<p align=\"center\">";
    $unick = getnick_uid($who);
    echo "What do you want to do with $unick";
	echo "<br/>Dont Ip ban a user Without admins Permison.";
    echo "</p>";
    echo "<p>";
    $pen[0]="Trash";
    $pen[1]="Ban";
    $pen[2]="Ban Ip";
 
echo" <center>
<form method=\"post\" action=\"mprocpl.php?action=pun1\">";
 echo "Penalty: <select name=\"pid\">";
    for($i=0;$i<count($pen);$i++)
    {
      echo "<option value=\"$i\">$pen[$i]</option>";
    }
    echo "</select><br/>";

echo"Reason: <textarea name=\"pres\" style=\"height:30px;width: 270px;\" ></textarea><br/>";
    echo "Days: <input name=\"pds\" format=\"*N\" maxlength=\"4\"/><br/>";
    echo "Hours: <input name=\"phr\" format=\"*N\" maxlength=\"4\"/><br/>";
    echo "Minutes: <input name=\"pmn\" format=\"*N\" maxlength=\"2\"/><br/>";
    echo "Seconds: <input name=\"psc\" format=\"*N\" maxlength=\"2\"/><br/>";
	    echo "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
		    echo "<postfield name=\"pid\" value=\"$(pid)\"/>";
echo"<input type=\"submit\" name=\"Submit\" value=\"PUNISH\"/><br/>
</form></center>";





   /* echo "Reason: <input name=\"pres\" maxlength=\"100\"/><br/>";

    echo "<anchor>PUNISH";
    echo "<go href=\"mprocpl.php?action=pun1\" method=\"post\">";
    echo "<postfield name=\"who\" value=\"$who\"/>";
    echo "<postfield name=\"pid\" value=\"$(pid)\"/>";
    echo "<postfield name=\"pres\" value=\"$(pres)\"/>";
    echo "<postfield name=\"pds\" value=\"$(pds)\"/>";
    echo "<postfield name=\"phr\" value=\"$(phr)\"/>";
    echo "<postfield name=\"pmn\" value=\"$(pmn)\"/>";
    echo "<postfield name=\"psc\" value=\"$(psc)\"/>";
    echo "</go></anchor>";
    echo "</p>";*/
    
     echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}

//////////////////////////////////////Penalties Options

else if($action=="plsopt")
{$pstyle = gettheme($sid);
echo xhtmlhead("Tools",$pstyle);
    $who = $_GET["who"];
    echo "<card id=\"main\" title=\"Mod CP\">";
    echo "<p align=\"center\">";
    $unick = getnick_uid($who);
    echo "Add/Substract $unick's Credits";
    echo "</p>";
    echo "<p>";
    $pen[0]="Substract";
    $pen[1]="Add";
    
    echo "Action: <select name=\"pid\">";
    for($i=0;$i<count($pen);$i++)
    {
      echo "<option value=\"$i\">$pen[$i]</option>";
    }
    echo "</select><br/>";
    echo "Reason: <input name=\"pres\" maxlength=\"100\"/><br/>";
    echo "Plusses: <input name=\"pval\" format=\"*N\" maxlength=\"3\"/><br/>";
    echo "<anchor>Update";
    echo "<go href=\"mprocpl.php?action=pls\" method=\"post\">";
    echo "<postfield name=\"who\" value=\"$who\"/>";
    echo "<postfield name=\"pres\" value=\"$(pres)\"/>";
    echo "<postfield name=\"pval\" value=\"$(pval)\"/>";
    echo "<postfield name=\"pid\" value=\"$(pid)\"/>";
    echo "</go></anchor>";
    echo "</p>";

     echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}

else if($action=="cdsopt")
{$pstyle = gettheme($sid);
echo xhtmlhead("Tools",$pstyle);
    $who = $_GET["who"];
    echo "<card id=\"main\" title=\"Mod CP\">";
    echo "<p align=\"center\">";
    $unick = getnick_uid($who);
    echo "Add/Substract $unick's bank Credits";
    echo "</p>";
    echo "<p>";
    $pen[0]="Substract";
    $pen[1]="Add";
    
    echo "Action: <select name=\"pid\">";
    for($i=0;$i<count($pen);$i++)
    {
      echo "<option value=\"$i\">$pen[$i]</option>";
    }
    echo "</select><br/>";
    echo "Reason: <input name=\"pres\" maxlength=\"100\"/><br/>";
    echo "Plusses: <input name=\"pval\" format=\"*N\" maxlength=\"6\"/><br/>";
    echo "<anchor>Update";
    echo "<go href=\"mprocpl.php?action=bnk\" method=\"post\">";
    echo "<postfield name=\"who\" value=\"$who\"/>";
    echo "<postfield name=\"pres\" value=\"$(pres)\"/>";
    echo "<postfield name=\"pval\" value=\"$(pval)\"/>";
    echo "<postfield name=\"pid\" value=\"$(pid)\"/>";
    echo "</go></anchor>";
    echo "</p>";

     echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}




else{
    echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\">";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}
?></html>
