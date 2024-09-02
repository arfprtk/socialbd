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



if($action=="main")

{

    echo "<card id=\"main\" title=\"Mod CP\">";

    echo "<p align=\"center\"><small>";

    echo "<b>Reports</b>";

    echo "</small></p>";

     echo "<p><small>";

    $nrpm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE reported='1'"));

    echo "<a href=\"modcp2.php?action=rpm\">&#187;Inbox Messages($nrpm[0])</a><br/>";
    $nrpm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_chat WHERE reported='1'"));

    echo "<a href=\"modcp2.php?action=rcmsg\">&#187;Chat Messages($nrpm[0])</a><br/>";
    
    $nrpm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_popups WHERE reported='1'"));

    echo "<a href=\"modcp2.php?action=rpop\">&#187;Popup Messages($nrpm[0])</a><br/>";

    $nrps = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_posts WHERE reported='1'"));

    echo "<a href=\"modcp2.php?action=rps\">&#187;Posts($nrps[0])</a><br/>";

    $nrtp = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_topics WHERE reported='1'"));

    echo "<a href=\"modcp2.php?action=rtp\">&#187;Topics($nrtp[0])</a>";

    echo "</small></p>";

     echo "<p align=\"center\"><small>";

    echo "<b>Logs</b>";

    echo "</small></p>";

    

     echo "<p><small>";

$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_mlog"));

    if($noi[0]>0){

    $nola = mysql_query("SELECT DISTINCT (action)  FROM dcroxx_me_mlog ORDER BY actdt DESC");



      while($act=mysql_fetch_array($nola))

      {

        $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_mlog WHERE action='".$act[0]."'"));

        echo "<a href=\"modcp2.php?action=log&amp;view=$act[0]\">$act[0]($noi[0])</a><br/>";

      }



    }

    echo "</small></p>";

  echo "<p align=\"center\"><small>";

  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}



/////////////////////////////////Reported PMs



else if($action=="rpm")

{

  $page = safe_query($_GET["page"]);

    echo "<card id=\"main\" title=\"Mod CP\">";

    echo "<p align=\"center\"><small>";

    echo "<b>Reported Inboxes</b>";

    echo "</small></p>";

    echo "<p><small>";

    echo "";

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

       if (ismod(getuid_sid($sid)))

       {

       echo "<a href=\"modproc2.php?action=hpm&amp;pid=$item[0]\">Handle</a><br/><br/>";

       }

       else

       {

       echo "<b>Handle</b><br/><br/>";

       }

    }

    echo "";

    echo "</small></p>";

    echo "<p align=\"center\"><small>";

    if($page>1)

    {

      $ppage = $page-1;

      echo "<a href=\"modcp2.php?action=$action&amp;page=$ppage\">&#171;PREV</a> ";

    }

    if($page<$num_pages)

    {

      $npage = $page+1;

      echo "<a href=\"modcp2.php?action=$action&amp;page=$npage\">Next&#187;</a>";

    }

    echo "<br/>$page/$num_pages<br/>";

    if($num_pages>2)

    {

      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";

        $rets .= "<anchor>[GO]";

        $rets .= "<go href=\"modcp2.php\" method=\"get\">";

        $rets .= "<postfield name=\"action\" value=\"$action\"/>";

        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";

        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";

        

        $rets .= "</go></anchor>";



        echo $rets;

    }

    echo "<br/><br/>";

    echo "<a href=\"modcp2.php?action=main\">Reports/Logs</a><br/>";

  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}



/////////////////////////////////Reported Popups



else if($action=="rpop")

{

  $page = safe_query($_GET["page"]);

    echo "<card id=\"main\" title=\"Mod CP\">";

    echo "<p align=\"center\"><small>";

    echo "<b>Reported Popups</b>";

    echo "</small></p>";

    echo "<p><small>";

    echo "";

    if($page=="" || $page<=0)$page=1;

    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_popups WHERE reported ='1'"));

    $num_items = $noi[0]; //changable

    $items_per_page= 5;

    $num_pages = ceil($num_items/$items_per_page);

    if($page>$num_pages)$page= $num_pages;

    $limit_start = ($page-1)*$items_per_page;

    $sql = "SELECT id, text, byuid, touid, timesent FROM dcroxx_me_popups WHERE reported='1' ORDER BY timesent DESC LIMIT $limit_start, $items_per_page";

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

       if (ismod(getuid_sid($sid)))

       {

       echo "<a href=\"modproc2.php?action=hpop&amp;pid=$item[0]\">Handle</a><br/><br/>";

       }

       else

       {

       echo "<b>Handle</b><br/><br/>";

       }

    }

    echo "";

    echo "</small></p>";

    echo "<p align=\"center\"><small>";

    if($page>1)

    {

      $ppage = $page-1;

      echo "<a href=\"modcp2.php?action=$action&amp;page=$ppage\">&#171;PREV</a> ";

    }

    if($page<$num_pages)

    {

      $npage = $page+1;

      echo "<a href=\"modcp2.php?action=$action&amp;page=$npage\">Next&#187;</a>";

    }

    echo "<br/>$page/$num_pages<br/>";

    if($num_pages>2)

    {

      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";

        $rets .= "<anchor>[GO]";

        $rets .= "<go href=\"modcp2.php\" method=\"get\">";

        $rets .= "<postfield name=\"action\" value=\"$action\"/>";

        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";

        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";

        

        $rets .= "</go></anchor>";



        echo $rets;

    }

    echo "<br/><br/>";

    echo "<a href=\"modcp2.php?action=main\">Reports/Logs</a><br/>";

  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}



/////////////////////////////////Reported Posts



else if($action=="rps")

{

  $page = safe_query($_GET["page"]);

    echo "<card id=\"main\" title=\"Mod CP\">";

    echo "<p align=\"center\"><small>";

    echo "<b>Reported Posts</b>";

    echo "</small></p>";

    echo "<p><small>";

    echo "";

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

      $tname = mysql_fetch_array(mysql_query("SELECT text, name FROM dcroxx_me_topics WHERE id='".$item[2]."'"));

      $tname = htmlspecialchars($tname[1]);

      $dtop = date("d m y - H:i:s", $item[4]);

      $text = parsemsg($item[1]);

      $flk = "<a href=\"index.php?action=viewuser&amp;who=$item[3]\">$poster</a>";

      $tlk = "<a href=\"index.php?action=viewtpc&amp;tid=$item[2]\">$tname</a>";

      echo "Poster: $flk<br/>In: $tlk<br/>Time: $dtop<br/>";

       echo $text;

       echo "<br/>";

       if (ismod(getuid_sid($sid)))

       {

       echo "<a href=\"modproc2.php?action=hps&amp;pid=$item[0]\">Handle</a><br/><br/>";

       }

       else

       {

       echo "<b>Handle</b><br/><br/>";

       }

    }

    echo "";

    echo "</small></p>";

    echo "<p align=\"center\"><small>";

    if($page>1)

    {

      $ppage = $page-1;

      echo "<a href=\"modcp2.php?action=$action&amp;page=$ppage\">&#171;PREV</a> ";

    }

    if($page<$num_pages)

    {

      $npage = $page+1;

      echo "<a href=\"modcp2.php?action=$action&amp;page=$npage\">Next&#187;</a>";

    }

    echo "<br/>$page/$num_pages<br/>";

    if($num_pages>2)

    {

      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";

        $rets .= "<anchor>[GO]";

        $rets .= "<go href=\"modcp2.php\" method=\"get\">";

        $rets .= "<postfield name=\"action\" value=\"$action\"/>";

        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";

        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";



        $rets .= "</go></anchor>";



        echo $rets;

    }

    echo "<br/><br/>";

    echo "<a href=\"modcp2.php?action=main\">Reports/Logs</a><br/>";

  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}


else if($action=="adqw")
{
  $who = $_GET["who"];
  echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\"><small>";
  $unick = getnick_uid($who);
  echo "<b>Create New Quiz</b><br/>";
  echo "</small></p>";
  echo "<p align=\"left\"><small>";
	 
  echo "Quiz Owner USER ID: <input name=\"qid\" format=\"*N\" maxlength=\"100\" value=\"0\"/><br/>";
  echo "Reputation Point: <input name=\"qrp\" format=\"*N\" maxlength=\"3\" value=\"0\"/><br/>";
  echo "Plusses: <input name=\"qpls\" format=\"*N\" maxlength=\"3\" value=\"0\"/><br/>";
  echo "Winners USER ID: <input name=\"qwid\" format=\"*N\" maxlength=\"100\" value=\"0\"/><br/>";
  echo "Quiz/Contest Name: <input name=\"qnm\" maxlength=\"100\"/> (exp: Guess The Number 20)<br/>";
  echo "Position: <input name=\"qp\" maxlength=\"10\"/> (1st, 2nd, 3rd)<br/>";
  
  echo "<anchor>Submit For Admin Validation";
  echo "<go href=\"modproc2.php?action=quizw\" method=\"post\">";
  echo "<postfield name=\"qid\" value=\"$(qid)\"/>";
  echo "<postfield name=\"qrp\" value=\"$(qrp)\"/>";
  echo "<postfield name=\"qpls\" value=\"$(qpls)\"/>";
  echo "<postfield name=\"qwid\" value=\"$(qwid)\"/>";
  echo "<postfield name=\"qnm\" value=\"$(qnm)\"/>";
  echo "<postfield name=\"qp\" value=\"$(qp)\"/>";
  echo "<postfield name=\"who\" value=\"$who\"/>";
  echo "</go></anchor><br/>";

  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}



/////////////////////////////////Reported Posts



else if($action=="log")

{

  $page = safe_query($_GET["page"]);

  $view = $_GET["view"];

    echo "<card id=\"main\" title=\"Mod CP\">";

    echo "<p align=\"center\"><small>";

    echo "<b>$view</b>";

    echo "</small></p>";

    echo "<p><small>";

    echo "";

    if($page=="" || $page<=0)$page=1;

    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_mlog WHERE  action='".$view."'"));

    $num_items = $noi[0]; //changable

    $items_per_page= 5;

    $num_pages = ceil($num_items/$items_per_page);

    if($page>$num_pages)$page= $num_pages;

    $limit_start = ($page-1)*$items_per_page;

    $sql = "SELECT  actdt, details FROM dcroxx_me_mlog WHERE action='".$view."' ORDER BY actdt DESC LIMIT $limit_start, $items_per_page";

    $items = mysql_query($sql);

    while ($item=mysql_fetch_array($items))

    {

      echo "Time: ".date("d m y-H:i:s", $item[0])."<br/>";

      echo $item[1];

      echo "<br/>";

       

    }

    echo "";

    echo "</small></p>";

    echo "<p align=\"center\"><small>";

    if($page>1)

    {

      $ppage = $page-1;

      echo "<a href=\"modcp2.php?action=$action&amp;page=$ppage&amp;view=$view\">&#171;PREV</a> ";

    }

    if($page<$num_pages)

    {

      $npage = $page+1;

      echo "<a href=\"modcp2.php?action=$action&amp;page=$npage&amp;view=$view\">Next&#187;</a>";

    }

    echo "<br/>$page/$num_pages<br/>";

    if($num_pages>2)

    {

      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";

        $rets .= "<anchor>[GO]";

        $rets .= "<go href=\"modcp2.php\" method=\"get\">";

        $rets .= "<postfield name=\"action\" value=\"$action\"/>";

        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";

        $rets .= "<postfield name=\"view\" value=\"$view\"/>";

        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";



        $rets .= "</go></anchor>";



        echo $rets;

    }

    echo "<br/><br/>";

    echo "<a href=\"modcp2.php?action=main\">Reports/Logs</a><br/>";

  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}



/////////////////////////////////Reported Topics



else if($action=="rtp")

{

  $page = safe_query($_GET["page"]);

    echo "<card id=\"main\" title=\"Mod CP\">";

    echo "<p align=\"center\"><small>";

    echo "<b>Reported Topics</b>";

    echo "</small></p>";

    echo "<p><small>";

    echo "";

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

       if (ismod(getuid_sid($sid)))

       {

       echo "<a href=\"modproc2.php?action=htp&amp;tid=$item[0]\">Handle</a><br/><br/>";

       }

       else

       {

       echo "<b>Handle</b><br/><br/>";

       }

    }

    echo "";

    echo "</small></p>";

    echo "<p align=\"center\"><small>";

    if($page>1)

    {

      $ppage = $page-1;

      echo "<a href=\"modcp2.php?action=$action&amp;page=$ppage\">&#171;PREV</a> ";

    }

    if($page<$num_pages)

    {

      $npage = $page+1;

      echo "<a href=\"modcp2.php?action=$action&amp;page=$npage\">Next&#187;</a>";

    }

    echo "<br/>$page/$num_pages<br/>";

    if($num_pages>2)

    {

      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";

        $rets .= "<anchor>[GO]";

        $rets .= "<go href=\"modcp2.php\" method=\"get\">";

        $rets .= "<postfield name=\"action\" value=\"$action\"/>";

        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";

        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";



        $rets .= "</go></anchor>";



        echo $rets;

    }

    echo "<br/><br/>";

    echo "<a href=\"modcp2.php?action=main\">Reports/Logs</a><br/>";

  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}

/*else if($action=="quiz")

{

  $tid = $_GET["tid"];

    echo "<card id=\"main\" title=\"Mod CP\">";

    echo "<p><small>Quiz Description<br/>";

echo "<input name=\"des\" value=\"$des\" maxlength=\"255\"/> ";

echo "<br/><anchor>Submit";

echo "<go href=\"modproc2.php?action=quiz&amp;tid=$tid\" method=\"post\">";

echo "<postfield name=\"des\" value=\"$(des)\"/>";

echo "</go>";



echo "</anchor><br/>";

  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}*/
///////////////Quiz RPs
else if($action=="quizrp")
{
    $who = $_GET["who"];
    echo "<card id=\"main\" title=\"Mod CP\">";
    echo "<p align=\"center\">";
    $unick = getnick_uid($who);
    echo "Update $unick's Reputation Points";
    echo "</p>";
    echo "<p>";
    echo "Quiz Name: <input name=\"quizname\" maxlength=\"100\"/><br/>";
    //echo "Position: <input name=\"pres\" maxlength=\"100\"/><br/>";
    echo "Position: <select name=\"pos\" value=\"Host\">";
    echo "<option value=\"Host\">Host</option>";
    echo "<option value=\"Gift\">Gift</option>";
    echo "<option value=\"1st\">1st</option>";
    echo "<option value=\"2nd\">2nd</option>";
    echo "<option value=\"3rd\">3rd</option>";
    echo "<option value=\"4th\">4th</option>";
    echo "<option value=\"5th\">5th</option>";
    echo "<option value=\"6th\">6th</option>";
    echo "<option value=\"7th\">7th</option>";
    echo "<option value=\"8th\">8th</option>";
    echo "<option value=\"9th\">9th</option>";
    echo "<option value=\"10th\">10th</option>";
    echo "</select><br/>";
    echo "RPs: <input name=\"pval\" format=\"*N\" maxlength=\"3\"/><br/>";
    echo "<anchor>Update";
    echo "<go href=\"modproc2.php?action=quizrp\" method=\"post\">";
    echo "<postfield name=\"who\" value=\"$who\"/>";
    echo "<postfield name=\"quizname\" value=\"$(quizname)\"/>";
    echo "<postfield name=\"pos\" value=\"$(pos)\"/>";
    echo "<postfield name=\"pval\" value=\"$(pval)\"/>";
    echo "</go></anchor>";
    echo "</p>";

     echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}

else if($action=="adq")
{
  $who = $_GET["who"];
  echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\"><small>";
  $unick = getnick_uid($who);
  echo "<b>Create New Quiz</b><br/>";
  echo "</small></p>";
  echo "<p align=\"left\"><small>";
	 
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
  echo "<go href=\"modproc2.php?action=quiz\" method=\"post\">";
  echo "<postfield name=\"qtitle\" value=\"$(qtitle)\"/>";
  echo "<postfield name=\"qby\" value=\"$(qby)\"/>";
  echo "<postfield name=\"qdes\" value=\"$(qdes)\"/>";
  echo "<postfield name=\"qstatus\" value=\"$(qstatus)\"/>";
  echo "<postfield name=\"qtid\" value=\"$(qtid)\"/>";
  //echo "<postfield name=\"who\" value=\"$ui\"/>";
  echo "</go></anchor><br/>";

  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
else if($action=="editquiz")
{
  $who = $_GET["who"];
  $id = safe_query($_GET["id"]);
  echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\"><small>";
  $unick = getnick_uid($who);
  echo "<b>Edit a Quiz</b><br/>";
  echo "</small></p>";
  echo "<p align=\"left\"><small>";
  $tpc = mysql_fetch_array(mysql_query("SELECT id, qtitle, qby, qdes, qstatus, qtid,  who, time FROM dcroxx_me_topics WHERE id='".$id."'"));
  
  echo "Quiz Title: <input name=\"qtitle\" maxlength=\"100\" value=\"$tpc[1]\"/> (example: Biddar Jahaj 10)<br/>";
  echo "By: <input name=\"qby\" maxlength=\"100\" value=\"$tpc[2]\"/> (Your Name)<br/>";
  echo "Short Description: <input name=\"qdes\" maxlength=\"255\" value=\"$tpc[3]\"/> (Question type/prize/time)<br/>";
  echo "Status:";
    echo "<select name=\"qstatus\">";
    echo "<option value=\"o\">Open</option>";
    echo "<option value=\"c\">Close</option>";
    echo "</select><br/>";

 // echo "Topic ID: <input name=\"qtid\" format=\"*N\" maxlength=\"100\" value=\"$tpc[5]\"/> (Your quiz topic ID)<br/>";

  echo "<anchor>Update Quiz";
  echo "<go href=\"modproc2.php?action=editquiz&amp;id=$id\" method=\"post\">";
  echo "<postfield name=\"qtitle\" value=\"$(qtitle)\"/>";
  echo "<postfield name=\"qby\" value=\"$(qby)\"/>";
  echo "<postfield name=\"qdes\" value=\"$(qdes)\"/>";
  echo "<postfield name=\"qstatus\" value=\"$(qstatus)\"/>";
 // echo "<postfield name=\"qtid\" value=\"$(qtid)\"/>";
  //echo "<postfield name=\"who\" value=\"$ui\"/>";
  echo "</go></anchor><br/>";

  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}

else if($action=="advquiz")
{
$tid = isnum((int)$_GET["tid"]);
echo "<card id=\"main\" title=\"Mod CP\">";
echo "<p align=\"center\"><small>";
echo "<b>Short Description:</b><br/>(if you need and BBCODEs not allowed)<br/><input name=\"des\" maxlength=\"100\"/><br/><br/>";

echo"Advertise auto delete schedule:<br/>";
  echo "Days: <input name=\"pds\" format=\"*N\" maxlength=\"4\"/><br/>";
  echo "Hours: <input name=\"phr\" format=\"*N\" maxlength=\"4\"/><br/>";
  echo "Minutes: <input name=\"pmn\" format=\"*N\" maxlength=\"2\"/><br/>";
  echo "Seconds: <input name=\"psc\" format=\"*N\" maxlength=\"2\"/><br/>";


echo "<anchor>Post AD";
echo "<go href=\"modproc2.php?action=quizadv\" method=\"post\">";
echo "<postfield name=\"tid\" value=\"$tid\"/>";
echo "<postfield name=\"des\" value=\"$(des)\"/>";

 echo "<postfield name=\"pds\" value=\"$(pds)\"/>";
  echo "<postfield name=\"phr\" value=\"$(phr)\"/>";
  echo "<postfield name=\"pmn\" value=\"$(pmn)\"/>";
  echo "<postfield name=\"psc\" value=\"$(psc)\"/>";
echo "</go></anchor>";
echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p></card>";
}

else if($action=="rcmsg")

{

  $page = safe_query($_GET["page"]);

    echo "<card id=\"main\" title=\"Mod CP\">";

    echo "<p align=\"center\"><small>";

    echo "<b>Reported Chat Messages</b>";

    echo "</small></p>";

    echo "<p><small>";

    echo "";

    if($page=="" || $page<=0)$page=1;

    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_chat WHERE reported='1'"));

    $num_items = $noi[0]; //changable

    $items_per_page= 5;

    $num_pages = ceil($num_items/$items_per_page);

    if($page>$num_pages)$page= $num_pages;

    $limit_start = ($page-1)*$items_per_page;

    $sql = "SELECT id, msgtext, chatter, reportedby, timesent FROM dcroxx_me_chat WHERE reported='1' ORDER BY timesent DESC LIMIT $limit_start, $items_per_page";

    $items = mysql_query($sql);

    while ($item=mysql_fetch_array($items))

    {

      $fromnk = getnick_uid($item[2]);

      $tonick = getnick_uid($item[3]);

      $dtop = date("d m y - H:i:s", $item[4]);

      $text = parsepm($item[1]);

      $flk = "<a href=\"index.php?action=viewuser&amp;who=$item[2]\">$fromnk</a>";

      $tlk = "<a href=\"index.php?action=viewuser&amp;who=$item[3]\">$tonick</a>";

      echo "Message By: $flk Reported By: $tlk<br/>Time: $dtop<br/>";

       echo $text;

       echo "<br/>";

       if (ismod(getuid_sid($sid)))

       {

       echo "<a href=\"modproc2.php?action=hchmsg&amp;pid=$item[0]\">Handle</a><br/><br/>";

       }

       else

       {

       echo "<b>Handle</b><br/><br/>";

       }

    }

    echo "";

    echo "</small></p>";

    echo "<p align=\"center\"><small>";

    if($page>1)

    {

      $ppage = $page-1;

      echo "<a href=\"modcp2.php?action=$action&amp;page=$ppage\">&#171;PREV</a> ";

    }

    if($page<$num_pages)

    {

      $npage = $page+1;

      echo "<a href=\"modcp2.php?action=$action&amp;page=$npage\">Next&#187;</a>";

    }

    echo "<br/>$page/$num_pages<br/>";

    if($num_pages>2)

    {

      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";

        $rets .= "<anchor>[GO]";

        $rets .= "<go href=\"modcp2.php\" method=\"get\">";

        $rets .= "<postfield name=\"action\" value=\"$action\"/>";

        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";

        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";

        

        $rets .= "</go></anchor>";



        echo $rets;

    }

    echo "<br/><br/>";

    echo "<a href=\"modcp2.php?action=main\">Reports/Logs</a><br/>";

  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}
else{

    echo "<card id=\"main\" title=\"Mod CP\">";

  echo "<p align=\"center\"><small>";

  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";

  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}

?>

</wml>

