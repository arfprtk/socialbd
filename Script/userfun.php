<?php
     session_name("PHPSESSID");
session_start();
header("Content-type: text/html");
header("Cache-Control: no-store, no-cache, must-revalidate");
echo("<?xml version=\"1.0\"?>");
include("xhtmlfunctions.php");
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";
?>
<html>
<?php
include("config.php");
include("core.php");
connectdb();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$who = $_GET["who"];
if(islogged($sid)==false)
{
    echo "<card id=\"main\" title=\"$stitle\">";
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
      echo "</card>";
      echo "</wml>";
      exit();
}
$uid = getuid_sid($sid);
if(isbanned($uid))
    {
        echo "<card id=\"main\" title=\"$stitle\">";
      echo "<p align=\"center\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
      echo "You are <b>Banned</b><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT timeto FROM dcroxx_me_metpenaltiespl WHERE uid='".$uid."' AND penalty='1'"));
      $remain = $banto[0]- (time() - $timeadjust) ;
      $rmsg = gettimemsg($remain);
      echo "Time to finish your penalty: $rmsg<br/><br/>";
      //echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
      echo "</card>";
      echo "</wml>";
      exit();
    }

else if($action=="profile")
{
        $pstyle = gettheme($sid);
        echo xhtmlhead("User Fun",$pstyle);
  $whonick = getnick_uid($who);
  addonline(getuid_sid($sid),"Having fun with another member :P","");
  $gender = mysql_fetch_array(mysql_query("SELECT sex FROM dcroxx_me_users WHERE id='".$who."'"));  
  echo "<card id=\"main\" title=\"$whonick's Fun Zone\">";
  echo "<p>";
  
  echo "<b>Smooch's:</b><br/>";
  $smooch = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usfun WHERE byuid='".$who."' AND funtype='1'"));
  echo "Have Smooched: <b><a href=\"userfun.php?action=smoochwho&amp;who=$who\">".$smooch[0]."</a></b> Times<br/>";
  $smooched = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usfun WHERE touid='".$who."' AND funtype='1'"));
  echo "Have been Smooched: <b><a href=\"userfun.php?action=smoochby&amp;who=$who\">".$smooched[0]."</a></b> Times<br/>";
  if ($gender[0]=='M')
    {
      echo "Poor <i><b>$whonick</b></i>, a fat old lady have smooched him untill he almost choked! yes you can smooch <i><b>$whonick</b></i> but don't kill him<br/>";
    }
  else {
      echo "Poor <i><b>$whonick</b></i>, a fat old lady have smooched her untill she almost choked! yes you can smooch <i><b>$whonick</b></i> but don't kill her<br/>";
       }
  echo "<a href=\"userfun.php?action=smooch&amp;who=$who\">Smooch!</a><br/><br/>";
  
  echo "<b>Kicks:</b><br/>";
  $kick = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usfun WHERE byuid='".$who."' AND funtype='2'"));
  echo "Have Kicked: <b><a href=\"userfun.php?action=kickwho&amp;who=$who\">".$kick[0]."</a></b> Times<br/>";
  $kicked = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usfun WHERE touid='".$who."' AND funtype='2'"));
  echo "Have been Kicked: <b><a href=\"userfun.php?action=kickby&amp;who=$who\">".$kicked[0]."</a></b> Times<br/>";
  echo "And yes <i><b>$whonick</b></i> have been kicked on the shin untill it's smashed, I think it'll be funny to kick <i><b>$whonick</b></i> on the chin hehe<br/>";
  echo "<a href=\"userfun.php?action=kick&amp;who=$who\">Kick!</a><br/><br/>";
  
    echo "<b>Pokes:</b><br/>";
  $poke = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usfun WHERE byuid='".$who."' AND funtype='3'"));
  echo "Have Poked: <b><a href=\"userfun.php?action=pokewho&amp;who=$who\">".$poke[0]."</a></b> Times<br/>";
  $poked = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usfun WHERE touid='".$who."' AND funtype='3'"));
  echo "Have been Poked: <b><a href=\"userfun.php?action=pokeby&amp;who=$who\">".$poked[0]."</a></b> Times<br/>";
  if ($gender[0]=='F')
      {
        echo "The last thing that <i><b>$whonick</b></i> needs now is another poke, she have a hole in her tummy because of the last poke, and no the other side of the hole is not in her back, some of us are obsessed with butts you know<br/>";
    }
  else {
      echo "The last thing that <i><b>$whonick</b></i> needs now is another poke, he have a hole in his tummy because of the last poke, and no the other side of the hole is not in his back, some of us are obsessed with butts you know<br/>";
       }        
  echo "<a href=\"userfun.php?action=poke&amp;who=$who\">Poke!</a><br/><br/>";
  
    echo "<img src=\"smilies/cuddle.gif\" alt=\"hug\"/><b>Hugs:</b><br/>";
  $hug = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usfun WHERE byuid='".$who."' AND funtype='4'"));
  echo "Have Hugged: <b><a href=\"userfun.php?action=hugwho&amp;who=$who\">".$hug[0]."</a></b> Times<br/>";
  $huged = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usfun WHERE touid='".$who."' AND funtype='4'"));
  echo "Have been Hugged: <b><a href=\"userfun.php?action=hugby&amp;who=$who\">".$huged[0]."</a></b> Times<br/>";
  if ($gender[0]=='F')
      {
        echo "Poor <i><b>$whonick</b></i>, remember that fat lady who choked her? well.. she hugged her untill she broke her ribs, she surely needs a hug from you now<br/>";
      }
  else {
      echo "Poor <i><b>$whonick</b></i>, remember that fat lady who choked him? well.. she hugged him untill he broke his ribs, he surely needs a hug from you now<br/>";
       }  
  echo "<a href=\"userfun.php?action=hug&amp;who=$who\">Hug!</a><br/><br/>";
    
  echo "</p>";
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=viewuser&amp;who=$who\">View $whonick's Profile</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  echo "</card>";
    exit();
    }
//////////////////////////////////


if($action=="smooch")
{ 
        $pstyle = gettheme($sid);
        echo xhtmlhead("User Fun",$pstyle);
  $whonick = getnick_uid($who);
  addonline(getuid_sid($sid),"Having fun with another member :P","");
  echo "<card id=\"main\" title=\"$whonick's Fun Zone\">";
  echo "<p align=\"center\">";  
  $credits = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
  if ($uid==$who){
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>You can't Smooch yourself<br/>";
  }else
  if ($credits[0]>4){
  $res = mysql_query("INSERT INTO dcroxx_me_usfun SET byuid='".$uid."', touid='".$who."', funtype='1'");
  echo "<img src=\"images/ok.gif\" alt=\"+\"/> You have just Smooched $whonick, where did you do that, I'm not gonna tell <img src=\"smilies/spiteful.gif\" alt=\"haba\"/><br/>";
  echo "5 Credits were subtracted from you, and you can't perform any other action on $whonick for the next 10 days<br/>";
  $ucred = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
  $ucred = $ucred[0] - 5;
  mysql_query("UPDATE dcroxx_me_users SET plusses='".$ucred."' WHERE id='".$uid."'");
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>You should have at least 5 Credits to perform an action on other members<br/>";
  }
  echo "<br/><a href=\"index.php?action=viewuser&amp;who=$who\">View $whonick's Profile</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  echo "</card>";
    exit();
    }
//////////////////////////////////
if($action=="hug")
{ 
        $pstyle = gettheme($sid);
        echo xhtmlhead("User Fun",$pstyle);
  $whonick = getnick_uid($who);
  addonline(getuid_sid($sid),"Having fun with another member :P","");
  echo "<card id=\"main\" title=\"$whonick's Fun Zone\">";
  echo "<p align=\"center\">";  
  $credits = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
    if ($uid==$who){
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>You can't Hug yourself<br/>";
  }else
  if ($credits[0]>4){
  $res = mysql_query("INSERT INTO dcroxx_me_usfun SET byuid='".$uid."', touid='".$who."', funtype='4'");
  echo "<img src=\"images/ok.gif\" alt=\"+\"/> You have just Huged $whonick, where did you do that, I'm not gonna tell <img src=\"smilies/spiteful.gif\" alt=\"haba\"/><br/>";
  echo "5 Credits were subtracted from you, and you can't perform any other action on $whonick for the next 10 days<br/>";
    $ucred = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
  $ucred = $ucred[0] - 5;
  mysql_query("UPDATE dcroxx_me_users SET plusses='".$ucred."' WHERE id='".$uid."'");
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>You should have at least 5 Credits to perform an action on other members<br/>";
  }
  echo "<br/><a href=\"index.php?action=viewuser&amp;who=$who\">View $whonick's Profile</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  echo "</card>";
    exit();
    }
//////////////////////////////////
if($action=="kick")
{ 
        $pstyle = gettheme($sid);
        echo xhtmlhead("User Fun",$pstyle);
  $whonick = getnick_uid($who);
  addonline(getuid_sid($sid),"Having fun with another member :P","");
  echo "<card id=\"main\" title=\"$whonick's Fun Zone\">";
  echo "<p align=\"center\">";  
  $credits = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
    if ($uid==$who){
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Why do you want to Kick Yourself?<br/>";
  }else
  if ($credits[0]>4){
  $res = mysql_query("INSERT INTO dcroxx_me_usfun SET byuid='".$uid."', touid='".$who."', funtype='2'");
  echo "<img src=\"images/ok.gif\" alt=\"+\"/> You have just Kicked $whonick, where did you do that, I'm not gonna tell <img src=\"smilies/spiteful.gif\" alt=\"haba\"/><br/>";
  echo "5 Credits were subtracted from you, and you can't perform any other action on $whonick for the next 10 days<br/>";
    $ucred = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
  $ucred = $ucred[0] - 5;
  mysql_query("UPDATE dcroxx_me_users SET plusses='".$ucred."' WHERE id='".$uid."'");
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>You should have at least 5 Credits to perform an action on other members<br/>";
  }
  echo "<br/><a href=\"index.php?action=viewuser&amp;who=$who\">View $whonick's Profile</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  echo "</card>";
    exit();
    }
//////////////////////////////////

if($action=="poke")
{ 
        $pstyle = gettheme($sid);
        echo xhtmlhead("User Fun",$pstyle);
  $whonick = getnick_uid($who);
  addonline(getuid_sid($sid),"Having fun with another member :P","");
  echo "<card id=\"main\" title=\"$whonick's Fun Zone\">";
  echo "<p align=\"center\">";  
  $credits = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
    if ($uid==$who){
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Why do you want to Poke Yourself?<br/>";
  }else
  if ($credits[0]>4){
  $res = mysql_query("INSERT INTO dcroxx_me_usfun SET byuid='".$uid."', touid='".$who."', funtype='3'");
  echo "<img src=\"images/ok.gif\" alt=\"+\"/> You have just Poked $whonick, where did you do that, I'm not gonna tell <img src=\"smilies/spiteful.gif\" alt=\"haba\"/><br/>";
  echo "5 Credits were subtracted from you, and you can't perform any other action on $whonick for the next 10 days<br/>";
    $ucred = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
  $ucred = $ucred[0] - 5;
  mysql_query("UPDATE dcroxx_me_users SET plusses='".$ucred."' WHERE id='".$uid."'");
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>You should have at least 5 Credits to perform an action on other members<br/>";
  }
  echo "<br/><a href=\"index.php?action=viewuser&amp;who=$who\">View $whonick's Profile</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  echo "</card>";
    exit();
    }
//////////////////////////////////
if($action=="smoochwho")
{ 
        $pstyle = gettheme($sid);
        echo xhtmlhead("User Fun",$pstyle);
  $whonick = getnick_uid($who);
  addonline(getuid_sid($sid),"Having fun with another member :P","");
  echo "<card id=\"main\" title=\"$whonick's Fun Zone\">";
  echo "<p><small>";
  echo "Members smooched by <a href=\"index.php?action=viewuser&amp;who=$who\">$whonick</a><br/>";
  echo "</small></p>";
  
      //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_usfun WHERE byuid='".$who."' AND funtype='1'"));
    
    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT touid FROM dcroxx_me_usfun WHERE byuid='".$who."' AND funtype='1' LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $nick = getnick_uid($item[0]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$nick</a>";
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
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"lists.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
  echo "<p align=\"center\">";
  echo "<br/><a href=\"index.php?action=viewuser&amp;who=$who\">View $whonick's Profile</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  echo "</card>";
    exit();
    }
//////////////////////////////////
if($action=="smoochby")
{ 
        $pstyle = gettheme($sid);
        echo xhtmlhead("User Fun",$pstyle);
  $whonick = getnick_uid($who);
  addonline(getuid_sid($sid),"Having fun with another member :P","");
  echo "<card id=\"main\" title=\"$whonick's Fun Zone\">";
  echo "<p><small>";
  echo "Members who smooched <a href=\"index.php?action=viewuser&amp;who=$who\">$whonick</a><br/>";
  echo "</small></p>";
  
      //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_usfun WHERE touid='".$who."' AND funtype='1'"));
    
    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT byuid FROM dcroxx_me_usfun WHERE touid='".$who."' AND funtype='1' LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $nick = getnick_uid($item[0]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$nick</a>";
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
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"lists.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
    echo "<p align=\"center\">";
  echo "<br/><a href=\"index.php?action=viewuser&amp;who=$who\">View $whonick's Profile</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  echo "</card>";
    exit();
    }
//////////////////////////////////

if($action=="kickwho")
{ 
        $pstyle = gettheme($sid);
        echo xhtmlhead("User Fun",$pstyle);
  $whonick = getnick_uid($who);
  addonline(getuid_sid($sid),"Having fun with another member :P","");
  echo "<card id=\"main\" title=\"$whonick's Fun Zone\">";
  echo "<p><small>";
  echo "Members kicked by <a href=\"index.php?action=viewuser&amp;who=$who\">$whonick</a><br/>";
  echo "</small></p>";
  
      //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_usfun WHERE byuid='".$who."' AND funtype='2'"));
    
    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT touid FROM dcroxx_me_usfun WHERE byuid='".$who."' AND funtype='2' LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $nick = getnick_uid($item[0]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$nick</a>";
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
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"lists.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
    echo "<p align=\"center\">";
  echo "<br/><a href=\"index.php?action=viewuser&amp;who=$who\">View $whonick's Profile</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  echo "</card>";
    exit();
    }
//////////////////////////////////
if($action=="kickby")
{ 
        $pstyle = gettheme($sid);
        echo xhtmlhead("User Fun",$pstyle);
  $whonick = getnick_uid($who);
  addonline(getuid_sid($sid),"Having fun with another member :P","");
  echo "<card id=\"main\" title=\"$whonick's Fun Zone\">";
  echo "<p><small>";
  echo "Members who kicked <a href=\"index.php?action=viewuser&amp;who=$who\">$whonick</a><br/>";
  echo "</small></p>";
  
      //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_usfun WHERE touid='".$who."' AND funtype='2'"));
    
    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT byuid FROM dcroxx_me_usfun WHERE touid='".$who."' AND funtype='2' LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $nick = getnick_uid($item[0]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$nick</a>";
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
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"lists.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
    echo "<p align=\"center\">";
  echo "<br/><a href=\"index.php?action=viewuser&amp;who=$who\">View $whonick's Profile</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  echo "</card>";
    exit();
    }
//////////////////////////////////
if($action=="pokewho")
{ 
        $pstyle = gettheme($sid);
        echo xhtmlhead("User Fun",$pstyle);
  $whonick = getnick_uid($who);
  addonline(getuid_sid($sid),"Having fun with another member :P","");
  echo "<card id=\"main\" title=\"$whonick's Fun Zone\">";
  echo "<p><small>";
  echo "Members poked by <a href=\"index.php?action=viewuser&amp;who=$who\">$whonick</a><br/>";
  echo "</small></p>";
  
      //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_usfun WHERE byuid='".$who."' AND funtype='3'"));
    
    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT touid FROM dcroxx_me_usfun WHERE byuid='".$who."' AND funtype='3' LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $nick = getnick_uid($item[0]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$nick</a>";
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
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"lists.php\" method=\"get\">;";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
    echo "<p align=\"center\">";
  echo "<br/><a href=\"index.php?action=viewuser&amp;who=$who\">View $whonick's Profile</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  echo "</card>";
    exit();
    }
//////////////////////////////////
if($action=="pokeby")
{ 
        $pstyle = gettheme($sid);
        echo xhtmlhead("User Fun",$pstyle);
  $whonick = getnick_uid($who);
  addonline(getuid_sid($sid),"Having fun with another member :P","");
  echo "<card id=\"main\" title=\"$whonick's Fun Zone\">";
  echo "<p><small>";
  echo "Members who poked <a href=\"index.php?action=viewuser&amp;who=$who\">$whonick</a><br/>";
  echo "</small></p>";
  
      //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_usfun WHERE touid='".$who."' AND funtype='3'"));
    
    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT byuid FROM dcroxx_me_usfun WHERE touid='".$who."' AND funtype='3' LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $nick = getnick_uid($item[0]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$nick</a>";
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
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"lists.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
    echo "<p align=\"center\">";
  echo "<br/><a href=\"index.php?action=viewuser&amp;who=$who\">View $whonick's Profile</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  echo "</card>";
    exit();
    }
//////////////////////////////////
if($action=="hugwho")
{ 
        $pstyle = gettheme($sid);
        echo xhtmlhead("User Fun",$pstyle);
  $whonick = getnick_uid($who);
  addonline(getuid_sid($sid),"Having fun with another member :P","");
  echo "<card id=\"main\" title=\"$whonick's Fun Zone\">";
  echo "<p><small>";
  echo "Members huged by <a href=\"index.php?action=viewuser&amp;who=$who\">$whonick</a><br/>";
  echo "</small></p>";
  
      //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_usfun WHERE byuid='".$who."' AND funtype='4'"));
    
    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT touid FROM dcroxx_me_usfun WHERE byuid='".$who."' AND funtype='4' LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $nick = getnick_uid($item[0]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$nick</a>";
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
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"lists.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
    echo "<p align=\"center\">";
  echo "<br/><a href=\"index.php?action=viewuser&amp;who=$who\">View $whonick's Profile</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  echo "</card>";
   exit();
    }
//////////////////////////////////
if($action=="hugby")
{ 
        $pstyle = gettheme($sid);
        echo xhtmlhead("User Fun",$pstyle);
  $whonick = getnick_uid($who);
  addonline(getuid_sid($sid),"Having fun with another member :P","");
  echo "<card id=\"main\" title=\"$whonick's Fun Zone\">";
  echo "<p><small>";
  echo "Members who huged <a href=\"index.php?action=viewuser&amp;who=$who\">$whonick</a><br/>";
  echo "</small></p>";
  
      //////ALL LISTS SCRIPT <<
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_usfun WHERE touid='".$who."' AND funtype='4'"));
    
    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT byuid FROM dcroxx_me_usfun WHERE touid='".$who."' AND funtype='4' LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $nick = getnick_uid($item[0]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$nick</a>";
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
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"lists.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
    echo "<p align=\"center\">";
  echo "<br/><a href=\"index.php?action=viewuser&amp;who=$who\">View $whonick's Profile</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  echo "</card>";
    exit();
    }
//////////////////////////////////
if($action=="convert")
{ 
        $pstyle = gettheme($sid);
        echo xhtmlhead("User Fun",$pstyle);
  $whonick = getnick_uid($who);
  addonline(getuid_sid($sid),"Having fun with another member :P","");
  echo "<card id=\"main\" title=\"$whonick's Fun Zone\">";
  echo "<p><small>";
  echo "Members who huged <a href=\"index.php?action=viewuser&amp;who=$who\">$whonick</a><br/>";
  echo "</small></p>";
  
    //changable sql

        $sql = "SELECT id, gplus, plusses FROM dcroxx_me_users";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $nick = getnick_uid($item[0]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$nick</a>";
      echo "$lnk<br/>";
      $plusses = $item[2];
      $gameplusses = $item[1];
      $totalplusses = $plusses + $gameplusses;
      mysql_query("UPDATE dcroxx_me_users SET plusses='".$totalplusses."' WHERE id='".$item[0]."'");
      
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
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"lists.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
    echo "<p align=\"center\">";
  echo "<br/><a href=\"index.php?action=viewuser&amp;who=$who\">View $whonick's Profile</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  echo "</card>";
    exit();
    }


?></html>
