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

if((islogged($sid)==false)||($uid==0))
    {
        echo "<card id=\"main\" title=\"$sitename\">";
      echo "<p align=\"center\"><small>";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.html\">Login</a>";
      echo "</small></p>";
      echo "</card>";
      echo "</wml>";
      exit();

}

if($action=="")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Casino",$pstyle);
  addonline(getuid_sid($sid),"Upgrade To Premium","casino.html?action=$action");
echo "<title>Casino</title>";

   echo "<p align=\"left\"><small>";
   
$epp = mysql_fetch_array(mysql_query("SELECT rp FROM dcroxx_me_users WHERE id='".$uid."'"));
  
  echo "<b>You have <big>{$epp[0]}</big> Reputation Points.</b><br/>";
echo "
<div class=\"update\" align=\"left\"><b>What is Casino Royale: </b><big>[Bet Limit: 25 RP - 50 RP]</big></div>
<div class=\"update\" align=\"left\"><img src=\"casino.png\" height=\"18\" width=\"20\" alt=\"\"/> You can bet on this play by spending reputation point from your account.</div>
<div class=\"update\" align=\"left\"><img src=\"casino.png\" height=\"18\" width=\"20\" alt=\"\"/> If you win, your bet amount will be doubled and stored to your account randomly (Reputation Points/Plusses/Golden Coins).</div>
<div class=\"update\" align=\"left\"><img src=\"casino.png\" height=\"18\" width=\"20\" alt=\"\"/> The bet is played once per week, you can bet any day over the week before the draw (Friday),
the draw will occur automatically every Friday 8 PM.</div>
<div class=\"update\" align=\"left\"><img src=\"casino.png\" height=\"18\" width=\"20\" alt=\"\"/> The result will be published here and you will also receive notifications as well.</div>
<div class=\"update\" align=\"left\"><img src=\"casino.png\" height=\"18\" width=\"20\" alt=\"\"/> You can bet once per week and your winning chance is 50-50.</div>
<div class=\"update\" align=\"left\"><img src=\"casino.png\" height=\"18\" width=\"20\" alt=\"\"/> If you lose the bet, you might not get refunded to your account.</div>";



   $epp = mysql_fetch_array(mysql_query("SELECT id, oprtr, time FROM dcroxx_me_casino ORDER BY time DESC LIMIT 0,1"));
      $ep = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_casinotkn WHERE oprtr='".$epp[1]."'"));
	  $e = $ep[0]-1;
   echo "<b>Current Casino Game:</b> #$epp[0]<br/>
<big>
<i>Draw Held On: Every <b>Friday</b> at <b>8:00 PM</b></i><br/>
Winners: 1<br/>
Partial Looser: $e<br/>
Total Players: $ep[0]<br/><br/>
</big>
";

$p = mysql_fetch_array(mysql_query("SELECT uid FROM dcroxx_me_casinotkn WHERE oprtr='".$epp[0]."'"));
if ($p[0]!==$uid){
echo"<b>&#187; <a href=\"casino.php?action=bet&amp;time=".time()."&amp;game={$epp[0]}\">Bet 25 RP</a> / <a href=\"casino.php?action=bet1&amp;time=".time()."&amp;game={$epp[0]}\">Bet 50 RP</a></b> (Bet Now!)<br/>";
}else{}
echo"<b>&#187; <a href=\"casino.php?action=week&amp;id=$epp[0]\">Current Casino Week #$epp[0] History</a></b><br/><br/>";

echo"<b>Previous Casino Weeks:</b><br/>";
//echo"#9 #8 #7 #6 #5 #4 #3 #2 #1";
 if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*)  FROM dcroxx_me_casino"));
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    $sql = "SELECT id FROM dcroxx_me_casino ORDER BY id DESC LIMIT $limit_start, $items_per_page";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0){
    while ($item = mysql_fetch_array($items)) {
$unick = getnick_uid($item[0]);
$lnk = "<a href=\"casino.php?action=week&amp;id=$item[0]\">#$item[0]</a>";
 echo "$lnk ";
/*echo"<b>Previous Casino Weeks:</b><br/>
#9 #8 #7 #6 #5 #4 #3 #2 #1";*/
    }}
	echo"<br/><br/>*<a href=\"index.php?action=viewuser&who=2\">Contact Fardin420 for further details</a><br/>";
echo"</small></p>";
echo "<div class=\"anc\" align=\"left\"><small>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
echo "</small></div>";

echo "</body>";
}
else if($action=="bet")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Casino",$pstyle);
  addonline(getuid_sid($sid),"Casino Game","");
  //$rp=mysql_real_escape_string($_GET["rp"]);
  $game=$_GET["game"];
  //////////////wap
 
   echo "<p align=\"left\"><small>";

	$ep = mysql_fetch_array(mysql_query("SELECT oprtr FROM dcroxx_me_casino ORDER BY time DESC LIMIT 0,1"));
	if($ep[0]!==$game){
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>Sorry, this game is already expired!<br/></small></p>";

  echo "<div class=\"anc\" align=\"left\"><small>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
echo "</small></div>";

echo "</body>";
    exit();
    }
	
$buy = mysql_fetch_array(mysql_query("SELECT id, bet FROM dcroxx_me_casinotkn WHERE uid='".getuid_sid($sid)."' AND oprtr='".$game."'"));
    if($buy[0]>0){
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>Sorry, you have already bet 25 reputation points on this game<br/>";

  echo "<div class=\"anc\" align=\"left\"><small>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
echo "</small></div>";

echo "</body>";
    exit();
    }
    $epp = mysql_fetch_array(mysql_query("SELECT rp FROM dcroxx_me_users WHERE id='".$uid."'"));

    if($epp[0]<25){
    echo "<img src=\"images/notok.gif\" alt=\"X\"/> You dont have enough Reputation Points<br/><br/>";

  echo "<div class=\"anc\" align=\"left\"><small>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
echo "</small></div>";


echo "</body>";
    exit();
    }
    $epp1 = mysql_fetch_array(mysql_query("SELECT id, oprtr, time FROM dcroxx_me_casino ORDER BY time DESC LIMIT 0,1"));
    $res = mysql_query("INSERT INTO dcroxx_me_casinotkn SET uid='".$uid."', oprtr='".$epp1[0]."', time='".time()."', bet='25'");

    if($res)
    {
    mysql_query("UPDATE dcroxx_me_users SET rp=$epp[0]-25 WHERE id='".$uid."'");
      echo "<img src=\"images/ok.gif\" alt=\"O\"/>Successfully bet <b>25</b> Reputation Points";

    }else{
      echo "<img src=\"images/notok.gif\" alt=\"X\"/> Request not complate. Please try again";
    }
  echo "<br/>";
  echo "<div class=\"anc\" align=\"left\"><small>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
echo "</small></div>";


echo "</body>";
}else if($action=="bet1")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Casino",$pstyle);
  addonline(getuid_sid($sid),"Casino Game","");
  //$rp=mysql_real_escape_string($_GET["rp"]);
  $game=$_GET["game"];
 
   echo "<p align=\"left\"><small>";

	$ep = mysql_fetch_array(mysql_query("SELECT oprtr FROM dcroxx_me_casino ORDER BY time DESC LIMIT 0,1"));
	if($ep[0]!==$game){
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>Sorry, this game is already expired!<br/>";

  echo "<div class=\"anc\" align=\"left\"><small>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
echo "</small></div>";

echo "</body>";
    exit();
    }
	
$buy = mysql_fetch_array(mysql_query("SELECT id, bet FROM dcroxx_me_casinotkn WHERE uid='".getuid_sid($sid)."' AND oprtr='".$game."'"));
    if($buy[0]>0){
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>Sorry, you have already bet 50 reputation points on this game<br/>";

  echo "<div class=\"anc\" align=\"left\"><small>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
echo "</small></div>";

echo "</body>";
    exit();
    }
    $epp = mysql_fetch_array(mysql_query("SELECT rp FROM dcroxx_me_users WHERE id='".$uid."'"));

    if($epp[0]<50){
    echo "<img src=\"images/notok.gif\" alt=\"X\"/> You dont have enough Reputation Points<br/><br/>";

  echo "<div class=\"anc\" align=\"left\"><small>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
echo "</small></div>";


echo "</body>";
    exit();
    }
    $epp1 = mysql_fetch_array(mysql_query("SELECT id, oprtr, time FROM dcroxx_me_casino ORDER BY time DESC LIMIT 0,1"));
    $res = mysql_query("INSERT INTO dcroxx_me_casinotkn SET uid='".$uid."', oprtr='".$epp1[0]."', time='".time()."', bet='50'");

    if($res)
    {
    mysql_query("UPDATE dcroxx_me_users SET rp=$epp[0]-50 WHERE id='".$uid."'");
      echo "<img src=\"images/ok.gif\" alt=\"O\"/>Successfully bet <b>50</b> Reputation Points";

    }else{
      echo "<img src=\"images/notok.gif\" alt=\"X\"/> Request not complate. Please try again";
    }
  echo "<br/>";
  echo "<div class=\"anc\" align=\"left\"><small>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
echo "</small></div>";

echo "</body>";
}else if($action=="week")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Casino",$pstyle);
  addonline(getuid_sid($sid),"Casino Game","");
  //$rp=mysql_real_escape_string($_GET["rp"]);
  $id=$_GET["id"];
 
   echo "<p align=\"left\"><small>";

echo"<b>Casino Royale History: #$id</b><br/>";


$p = mysql_fetch_array(mysql_query("SELECT COUNT(*)  FROM dcroxx_me_casinotkn WHERE oprtr='".$id."'"));
if ($p[0]==0){
	echo"There are no betters yet on this game.";
}else{


 if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*)  FROM dcroxx_me_casinotkn WHERE oprtr='".$id."'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    $sql = "SELECT uid, bet, time FROM dcroxx_me_casinotkn WHERE oprtr='".$id."' ORDER BY time DESC LIMIT $limit_start, $items_per_page";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0){
    while ($item = mysql_fetch_array($items)) {
		
$i = mysql_fetch_array(mysql_query("SELECT uid FROM dcroxx_me_casino WHERE oprtr='".$id."'"));
if ($i[0]==0){
	$tui = "";
}else{
if ($i[0]==$item[0]){
	$tui = "<small><font color=\"red\">(Winner)</font></small>";
}else{
	$tui = "";
}}
	
$unick = getnick_uid($item[0]);
// $dtot = date("d-m-y - H:i:s",$item[2]);
 $dtot = date("H:ia l jS M y",$item[2]);
$lnk = "<a href=\"index.php?action=viewuser&who=$item[0]\">$unick</a> $tui: bet <b>$item[1] RP</b> On <b>$dtot</b>";
 echo "$lnk<br/>";

}}}
	
	
  echo "</small>";
  echo "<div class=\"anc\" align=\"left\"><small>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
echo "</small></div>";

echo "</body>";
}
else{

  addonline(getuid_sid($sid),"ERROR","");
echo "<card id=\"main\" title=\"ERROR\">";
   echo "<p align=\"center\"><small>";

echo "Nothing Here";

  echo "<br/><br/><a href=\"main.html\"><img src=\"../images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "";
  echo "</small></p>";
    echo "</card>";
}

?>
</html>