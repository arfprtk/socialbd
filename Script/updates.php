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
$ubr=$_SERVER['HTTP_USER_AGENT'];
$uip = getip();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$who = $_GET["who"];
$uid=getuid_sid($sid);
    if(islogged($sid)==false)
    {
      $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle Bank",$pstyle);
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
     echo xhtmlfoot();
      exit();
    }
	$uid = getuid_sid($sid);
if(isbanned($uid))
    {
     $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle Bank",$pstyle);
      echo "<p align=\"center\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
      echo "You are <b>Banned</b><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT timeto FROM dcroxx_me_metpenaltiespl WHERE uid='".$uid."' AND penalty='1'"));
      $remain = $banto[0]- (time()  );
      $rmsg = gettimemsg($remain);
      echo "Time to finish your penalty: $rmsg<br/><br/>";
      //echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
    echo xhtmlfoot();
      exit();
    }


if($action==""){
addonline($uid,"Site Updates","");
//$pstyle = gettheme1($sid);
//echo xhtmlhead("Site Updates",$pstyle);
echo"<title>Site Updates</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"SocialBD.css\">";

$view = $_GET["view"];
if($view=="")$view="date";
echo "<div class=\"header\" align=\"center\">";
echo "<b>Site Updates</b>";
echo "</div>";
echo "<div class=\"penanda\" align=\"left\">";
if($page=="" || $page<=0)$page=1;
if($who==""){
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_events"));
}
$num_items = $noi[0]; //changable
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
if(($page>$num_pages)&&$page!=1)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;
    
$sql = "SELECT id, event, uid, time FROM dcroxx_me_events ORDER BY time DESC LIMIT $limit_start, $items_per_page";
$items = mysql_query($sql);
echo mysql_error();
if(mysql_num_rows($items)>0){
while ($event = mysql_fetch_array( $items)){
echo "<div class=\"shout\" align=\"left\">";
echo "".parsepm($event[event]).""; 
echo "";

echo "<br/><div class=\"likebox\" align=\"left\"><small>";
  $vb = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM alien_war_like WHERE uid='".$uid."' AND shoutid='".$item[0]."'"));
  if($vb[0]==0){
 echo "$lyk <a href=\"shoutproc.php?action=like&shid=$item[0]\">Like</a> ";
  }else{
 echo "$lyk <a href=\"shoutproc.php?action=unlike&shid=$item[0]\">Unlike</a> ";
  }
echo "<a href=\"shcomments.php?shid=$item[0]\">$sht Comments</a> ";
echo "<a href=\"share.php?shid=$item[0]\">Share</a> ";
echo "<a href=\"shout.php?shid=$item[0]\">More</a> ";
//echo"$shx $dlsh";
echo"$shx";
echo"$sx";

echo '</small></div>';
echo "</div>";

}}

echo"</div>";
    echo "<div class=\"div\" align=\"center\">";

   if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"updates.php?action=events&amp;page=$ppage&amp;view=$view\">See Newer Updates</a> ";
    }
   
      if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"updates.php?action=events&amp;page=$npage&amp;view=$view\">See Older Updates</a>";
    
      }
    /*echo "<br/>Page: $page Of $num_pages<br/>";
    if($num_pages>2){
		$rets = "<form action=\"updates.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" style=\"-wap-input-format: '*N'\" size=\"2\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"submit\" value=\"[GO]\"/>";
        $rets .= "</form>";
        echo $rets;
    }*/

    echo "</div>";
	
echo "<div class=\"footer\" align=\"center\">";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
echo "</div>";
exit();
}
else if($action=="recentactivities"){
addonline($uid,"Site Updates","");
//$pstyle = gettheme1($sid);
//echo xhtmlhead("Site Updates",$pstyle);
echo"<title>Recent Activities</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"SocialBD.css\">";

$view = $_GET["view"];
if($view=="")$view="date";
echo "<div class=\"header\" align=\"center\">";
echo "<b>Recent Activities</b>";
echo "</div>";
echo "<div class=\"penanda\" align=\"left\">";
if($page=="" || $page<=0)$page=1;
if($who==""){
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_events WHERE uid='".$who."'"));
}
$num_items = $noi[0]; //changable
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
if(($page>$num_pages)&&$page!=1)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;
    
$sql = "SELECT id, event, uid, time FROM dcroxx_me_events WHERE uid='".$who."' ORDER BY time DESC LIMIT $limit_start, $items_per_page";
$items = mysql_query($sql);
echo mysql_error();
if(mysql_num_rows($items)>0){
while ($event = mysql_fetch_array( $items)){
echo "<div class=\"shout\" align=\"left\">";
echo "".parsepm($event[event]).""; 
echo "";

echo "<br/><div class=\"likebox\" align=\"left\"><small>";
  $vb = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM alien_war_like WHERE uid='".$uid."' AND shoutid='".$item[0]."'"));
  if($vb[0]==0){
 echo "$lyk <a href=\"shoutproc.php?action=like&shid=$item[0]\">Like</a> ";
  }else{
 echo "$lyk <a href=\"shoutproc.php?action=unlike&shid=$item[0]\">Unlike</a> ";
  }
echo "<a href=\"shcomments.php?shid=$item[0]\">$sht Comments</a> ";
echo "<a href=\"share.php?shid=$item[0]\">Share</a> ";
echo "<a href=\"shout.php?shid=$item[0]\">More</a> ";
//echo"$shx $dlsh";
echo"$shx";
echo"$sx";

echo '</small></div>';
echo "</div>";

}}

echo"</div>";
    echo "<div class=\"div\" align=\"center\">";

   if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"updates.php?action=events&amp;page=$ppage&amp;view=$view\">See Newer Updates</a> ";
    }
   
      if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"updates.php?action=events&amp;page=$npage&amp;view=$view\">See Older Updates</a>";
    
      }
    /*echo "<br/>Page: $page Of $num_pages<br/>";
    if($num_pages>2){
		$rets = "<form action=\"updates.php\" method=\"get\">";
        $rets .= "Jump to page<input name=\"page\" style=\"-wap-input-format: '*N'\" size=\"2\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"submit\" value=\"[GO]\"/>";
        $rets .= "</form>";
        echo $rets;
    }*/

    echo "</div>";
	
echo "<div class=\"footer\" align=\"center\">";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
echo "</div>";
exit();
}

?>


</html>
