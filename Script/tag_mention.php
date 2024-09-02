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
////////////////////////////////// Uploader By IT Development Center :)
if($action=="")
{
          $pstyle = gettheme($sid);
      echo xhtmlhead("Tag Friends",$pstyle);
	addonline(getuid_sid($sid),"Attact a Photo","attach.php?action=$action");
	    echo "<head>";
    echo "<title>Tag Friends</title>";
    echo "</head>";
    echo "<body>";


echo"<br/>";
$shid = $_GET["shid"];

if($shid==""){
echo"<center><small><img src=\"dwarf.gif\" alt=\"\"><br/><strong>Hey stupid, select a post first and try to tag then</strong><br/><br/></small></center>";
}else{
echo"<form method=\"get\" action=\"tag_mention.php\">
<input name=\"stext\" placeholder=\"Search\" autocomplete=\"off\" autocorrect=\"off\" spellcheck=\"false\" type=\"text\" size=\"40px;\"/>
<input type=\"hidden\" name=\"shid\" value=\"$shid\"/>
<input value=\"Search\" type=\"submit\"  class=\"hmenu hmenubottom\"/>
</form>";
echo"<br/><div class=\"likebox\"><small><font color=\"#9397a0\">SUGGESTIONS</font></small></div><br/>";
////////May be it's Complete
$stext = $_GET["stext"];
$sin = $_GET["sin"];
$sor = $_GET["sor"];
$shid = $_GET["shid"];

echo "<form action=\"tag_mention_proc.php?shid=$shid\" method=\"post\">";
if(trim($stext)==""){
if($page=="" || $page<=0)$page=1;
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users"));
$num_items = $noi[0]; //changable
$items_per_page= 20;
$num_pages = ceil($num_items/$items_per_page);
if(($page>$num_pages)&&$page!=1)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;
$sql = "SELECT id, name FROM dcroxx_me_users ORDER BY lastact DESC LIMIT $limit_start, $items_per_page";
$items = mysql_query($sql);
echo mysql_error();
if(mysql_num_rows($items)>0){
while ($item = mysql_fetch_array($items)){
	
$sex = mysql_fetch_array(mysql_query("SELECT sex FROM dcroxx_me_users WHERE id='".$item[0]."'"));
if($sex[0]=="M"){$nicks = "<font color=\"blue\">$item[1]</font>";}
if($sex[0]=="F"){$nicks = "<font color=\"deeppink\">$item[1]</font>";}
if($sex[0]==""){$nicks = "";}

//echo "<input type=\"checkbox\" name=\"check_list[]\" value=\"$item[0]\"/><strong>$nicks</strong><br/><br/><hr/>";
echo "<input type=\"checkbox\" name=\"check_list[]\" value=\"$item[0]\"/> <small><a href=\"\">$nicks</a></small><br/>";




}}}else{
if($page=="" || $page<1)$page=1;
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE name LIKE '%".$stext."%'"));
$num_items = $noi[0];
$items_per_page = 20;
$num_pages = ceil($num_items/$items_per_page);
if(($page>$num_pages)&&$page!=1)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;
$sql = "SELECT id, name FROM dcroxx_me_users WHERE name LIKE '%".$stext."%' ORDER BY lastact LIMIT $limit_start, $items_per_page";
$items = mysql_query($sql);
while($item=mysql_fetch_array($items)){
	
$sex = mysql_fetch_array(mysql_query("SELECT sex FROM dcroxx_me_users WHERE id='".$item[0]."'"));
if($sex[0]=="M"){$nicks = "<font color=\"blue\">$item[1]</font>";}
if($sex[0]=="F"){$nicks = "<font color=\"deeppink\">$item[1]</font>";}
if($sex[0]==""){$nicks = "";}	


echo"<input type=\"checkbox\" name=\"check_list[]\" value=\"$item[0]\"><small>$nicks</small><br/>";
}}
if($page<$num_pages){
$npage = $page+1;
echo "<br/><div class=\"mblock1\"><center><small><b><a href=\"?page=$npage&shid=$shid\"><font color=\"red\">Show More</font></a></b></small></center></div>";
}

  echo "<input type=\"Submit\" name=\"done\" Value=\"Done\">";
  echo"</form>";
  
} 
  
  echo"<center><small>";
echo"<img src=\"images/home.gif\" alt=\"\"><a href=\"index.php\">Home</a>";
echo"</small></center>";
echo "</body>";
exit();
}
else if($action=="tag_peoples")
{
          $pstyle = gettheme($sid);
      echo xhtmlhead("Tag Friends",$pstyle);
    addonline(getuid_sid($sid),"Attact a Photo","attach.php?action=$action");
	    echo "<head>";
    echo "<title>Tag Peoples</title>";
    echo "</head>";
    echo "<body>";


echo"<div class=\"penanda\"><small>";
$shid = $_GET["shid"];


if($page=="" || $page<=0)$page=1;
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_mention WHERE shid='".$shid."'"));
$num_items = $noi[0]; //changable
$items_per_page= 20;
$num_pages = ceil($num_items/$items_per_page);
if(($page>$num_pages)&&$page!=1)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;
$sql = "SELECT id, tag_id, tag_user FROM dcroxx_me_mention WHERE shid='".$shid."' ORDER BY time DESC LIMIT $limit_start, $items_per_page";
$items = mysql_query($sql);
echo mysql_error();
if(mysql_num_rows($items)>0){
while ($item = mysql_fetch_array($items)){
	
$sex = mysql_fetch_array(mysql_query("SELECT sex FROM dcroxx_me_users WHERE id='".$item[1]."'"));
if($sex[0]=="M"){$nicks = "<font color=\"blue\"><b>$item[2]</b></font>";}
if($sex[0]=="F"){$nicks = "<font color=\"deeppink\"><b>$item[2]</b></font>";}
if($sex[0]==""){$nicks = "";}	

$sex = mysql_fetch_array(mysql_query("SELECT sex FROM dcroxx_me_users WHERE id='".$item[1]."'"));
if($sex[0]=="M"){$usersex = "<img src=\"images/male.gif\" alt=\"M\"/>";}
if($sex[0]=="F"){$usersex = "<img src=\"images/female.gif\" alt=\"F\"/>";}
if($sex[0]==""){$usersex = "";}

$avlink = getavatar($item[1]);
if($avlink=="" || !file_exists($avlink)){
$avt =  "$usersex";}else{
$avt = "<img src=\"$avlink\" alt=\"$avlink\" type=\"icon\" width=\"35\" hieght=\"40\"/>";}
$ick = getnick_uid($item[1]);
echo"$avt <a href=\"$ick\">$nicks</a><br/>";
	
}}

if($page<$num_pages){
$npage = $page+1;
echo "<center><strong><a href=\"?page=$npage&shid=$shid\">Show More</a></strong></center>";
}
  echo"</small><center><small>";
echo"<img src=\"images/home.gif\" alt=\"\"><a href=\"index.php\">Home</a>";
echo"</small></center>";
echo "</body>";
exit();
}

?>
</html>