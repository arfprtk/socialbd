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

if($action=="main")
{
  addonline(getuid_sid($sid),"Win Recharge Cards","token.php?action=$action");
        $pstyle = gettheme($sid);
      echo xhtmlhead("Win Recharge Cards",$pstyle);
echo "<card id=\"main\" title=\"Win Recharge Cards\">";
   echo "<p align=\"center\"><small>";
   $epp = mysql_fetch_array(mysql_query("SELECT id, oprtr, time FROM dcroxx_me_rechrgcrd ORDER BY time DESC LIMIT 0,1"));
   echo "Game <b>#$epp[0]</b><br/>Play For <b>$epp[1]</b> Recharge Card<br/><br/></small></p>";
   echo "<p align=\"left\"><small>";
echo "<b>Game Rules</b><br/><br/>
(*) This game can be played every Friday, Sunday, Tuesday and Thursday.<br/>
(*) You can buy tokens using your golden coins.<br/>
(*) <b>1.75</b> BDT = <b>1</b> Token.<br/>
(*) You are allowed to buy 1 token per game.<br/>
(*) Winners will be selected randomly by a bot.<br/>
(*) Winners will get their recharge card's # instantly by an automated PM from <b>Admin Panel</b>.<br/>
(*) Current game: Game <b>#$epp[0]</b> is for <b>$epp[1]</b> Recharge Card. Play next games if you would like to win other operator's cards.<br/>
(*) Time of draw: Every Friday, Sunday, Tuesday and Thursday <b>11:59:59 p.m.</b> BST (Bangladesh Standard Time).<br/><br/>";

echo "<a href=\"token.php?action=buy\">Click here to buy your token</a><br/>(The cost is 3 golden coins)<br/><br/>";
echo "<b>The List Of Sold Tokens:</b><br/>";
$sql = "SELECT id, uid, oprtr, time FROM dcroxx_me_token";
$items = mysql_query($sql);
echo mysql_error();
if(mysql_num_rows($items)>0)
{
while ($item = mysql_fetch_array($items))
{
$nick = getnick_uid($item[1]);
echo "Token ID: <b>$item[3]</b> By: <b>$nick</b><br/>";
}
}
   echo "</small></p><p align=\"center\"><small>";
echo "<a href=\"token.php?action=list\">Winners List</a>";
  echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  ?>
  <center><script type="text/javascript">
var ad_idzone = "2164913",
	 ad_width = "300",
	 ad_height = "50";
</script>
<script type="text/javascript" src="https://ads.exdynsrv.com/ads.js"></script>
<noscript><a href="http://main.exdynsrv.com/img-click.php?idzone=2164913" target="_blank">
<img src="https://syndication.exdynsrv.com/ads-iframe-display.php?idzone=2164913&output=img&type=300x50" width="300" height="50"></a></noscript>
</center>
<?
  echo "</small></p>";
    echo "</card>";
}
else if($action=="buy")
{
  addonline(getuid_sid($sid),"Win Recharge Cards","");
          $pstyle = gettheme($sid);
      echo xhtmlhead("Win Recharge Cards",$pstyle);
echo "<card id=\"main\" title=\"Win Recharge Cards\">";
   echo "<p align=\"center\"><small>";

    $epp = mysql_fetch_array(mysql_query("SELECT balance FROM dcroxx_me_users WHERE id='".$uid."'"));

    if($epp[0]<2)
    {
    echo "<img src=\"images/notok.gif\" alt=\"X\"/> You dont have enough balance<br/><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
    echo "</small></p>";
    echo "</card>";
    echo "</wml>";
    exit();
    }
    $epp1 = mysql_fetch_array(mysql_query("SELECT id, oprtr, time FROM dcroxx_me_rechrgcrd ORDER BY time DESC LIMIT 0,1"));
    $res = mysql_query("INSERT INTO dcroxx_me_token SET uid='".$uid."', oprtr='".$epp1[1]."', time='".time()."'");

    if($res)
    {
mysql_query("UPDATE dcroxx_me_users SET balance=$epp[0]-1.75 WHERE id='".$uid."'");
echo "<img src=\"images/ok.gif\" alt=\"O\"/> Token Buy Successfully";
mysql_query("INSERT INTO dcroxx_me_withdraw_report SET uid='".getuid_sid($sid)."', amount='1.75', wtime='".time()."', reason='Buy a Token for Win Recharge Card Game <b>$epp1[1]</b>'");
    }else{
      echo "<img src=\"images/notok.gif\" alt=\"X\"/> Request not complate. Please try again";
    }
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  ?>
  <center><script type="text/javascript">
var ad_idzone = "2164913",
	 ad_width = "300",
	 ad_height = "50";
</script>
<script type="text/javascript" src="https://ads.exdynsrv.com/ads.js"></script>
<noscript><a href="http://main.exdynsrv.com/img-click.php?idzone=2164913" target="_blank">
<img src="https://syndication.exdynsrv.com/ads-iframe-display.php?idzone=2164913&output=img&type=300x50" width="300" height="50"></a></noscript>
</center>
<?
  echo "</small></p>";
    echo "</card>";
}
else if($action=="temprr")
{
        $pstyle = gettheme($sid);
      echo xhtmlhead("Win Recharge Cards",$pstyle);
    echo "<card id=\"main\" title=\"Erros\">";
    echo "<p align=\"center\"><small>";
    $brws = $_SERVER['HTTP_USER_AGENT'];
    $res = mysql_query("UPDATE dcroxx_me_users SET browserm='".$brws."' WHERE id='".getuid_sid($sid)."'");
          echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</small></p>";
    echo "</card>";
}
else if($action=="list")
{
        $pstyle = gettheme($sid);
      echo xhtmlhead("Win Recharge Cards",$pstyle);
    echo "<card id=\"main\" title=\"Recharge Card Winners List\">";
    $uid = getuid_sid($sid);

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_rechrgcrd WHERE uid!='0'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 20;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    $sql = "SELECT id, oprtr, uid, gtime, cno FROM dcroxx_me_rechrgcrd WHERE uid!='0' ORDER BY gtime DESC LIMIT $limit_start, $items_per_page";

    echo "<p align=\"center\"><small><b>Recharge Card Winners List</b></small></p><br/><p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $num = substr($item[4],0,4);
        $unick = getnick_uid($item[2]);
        $ulnk = "Game#$item[0] ($item[1]) - Winner - <a href=\"index.php?action=viewuser&amp;who=$item[2]\">$unick</a> - Card#$num xxxxxxxx";
      echo "$ulnk<br/><br/>";
      

    }
    }
    echo "</small></p>";
    echo "<p align=\"center\"><small>";
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
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"lists.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"who\" value=\"$who\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</small></p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\"><small>";
  echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  ?>
  <center><script type="text/javascript">
var ad_idzone = "2164913",
	 ad_width = "300",
	 ad_height = "50";
</script>
<script type="text/javascript" src="https://ads.exdynsrv.com/ads.js"></script>
<noscript><a href="http://main.exdynsrv.com/img-click.php?idzone=2164913" target="_blank">
<img src="https://syndication.exdynsrv.com/ads-iframe-display.php?idzone=2164913&output=img&type=300x50" width="300" height="50"></a></noscript>
</center>
<?
  echo "</small></p>";
    echo "</card>";
}else{

  addonline(getuid_sid($sid),"ERROR","");
          $pstyle = gettheme($sid);
      echo xhtmlhead("Win Recharge Cards",$pstyle);
echo "<card id=\"main\" title=\"ERROR\">";
   echo "<p align=\"center\"><small>";

echo "Nothing Here";

  echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</small></p>";
    echo "</card>";
}

?>
</html>