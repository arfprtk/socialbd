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
	
    date_default_timezone_set('UTC');
    $New_Time = time() + (6 * 60 * 60);
    $Hour = date("G",$New_Time);
   // if(18>$Hour || 22<$Hour)
   if(14>$Hour || 22<$Hour) //2-11PM
    {
	      $pstyle = gettheme($sid);
      echo xhtmlhead("Golden Coin",$pstyle);
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"center\"><small>";
	?>
	<!-- G&R_320x50 -->
<script id="GNR35743">
    (function (i,g,b,d,c) {
        i[g]=i[g]||function(){(i[g].q=i[g].q||[]).push(arguments)};
        var s=d.createElement(b);s.async=true;s.src=c;
        var x=d.getElementsByTagName(b)[0];
        x.parentNode.insertBefore(s, x);
    })(window,'gandrad','script',document,'//content.green-red.com/lib/display.js');
    gandrad({siteid:11444,slot:35743});
</script>
<!-- End of G&R_320x50 -->
<?
    echo "You can play this game everyday from 2 p.m to 11 p.m BST (Bangladesh Standard Time) Please try again after 2 p.m.<br/><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
    echo "</small></p>";
    echo "</card>";
    echo "</wml>";
    exit();
    }

if($action=="main")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Golden Coin",$pstyle);
  addonline(getuid_sid($sid),"Golden Coin","goldencoin.php?action=$action");
echo "<card id=\"main\" title=\"Golden Coin\">";
   echo "<p align=\"center\">";
?>
   <!-- G&R_320x50 -->
<script id="GNR35743">
    (function (i,g,b,d,c) {
        i[g]=i[g]||function(){(i[g].q=i[g].q||[]).push(arguments)};
        var s=d.createElement(b);s.async=true;s.src=c;
        var x=d.getElementsByTagName(b)[0];
        x.parentNode.insertBefore(s, x);
    })(window,'gandrad','script',document,'//content.green-red.com/lib/display.js');
    gandrad({siteid:11444,slot:35743});
</script>
<!-- End of G&R_320x50 -->
<?
addtogc($uid);
date_default_timezone_set('UTC');
$BD_Time = time() + (6* 60 * 60);
$newtime = date("h:i:s a",$BD_Time);
$lstall = mysql_fetch_array(mysql_query("SELECT id, uid, coin, createtime, catchtime FROM ibwfrr_goldencoin ORDER BY catchtime DESC LIMIT 1"));
$lstcoin = mysql_fetch_array(mysql_query("SELECT id, createtime FROM ibwfrr_goldencoin WHERE uid='' ORDER BY createtime DESC LIMIT 1"));
$unick = getnick_uid($uid);
$whonick = getnick_uid($lstall[1]);

echo "<b>Golden Coin Game</b><br/><br/>Golden Coin are being thrown here with a rendom interval of time. 
All you need to do is, refresh this page until a link to grab your coin appears than hits the link. Remember, 
you need to be fast to grab the coin otherwise it will be transferred to someone else's pocket!<br/>";

if(time()<$lstcoin[1])
{
echo "<br/>Sorry there's no coin at the moment<br/>";
$tkn = rand(20000, 90000);
echo "<a href=\"goldencoin.php?action=main&amp;token=$tkn\">Search for coin</a> [$newtime]<br/>";

$item = mysql_fetch_array(mysql_query("SELECT id, specialid FROM dcroxx_me_users WHERE id='".$uid."'"));
//if ($item[1]>0){
if (ispu($uid)){
$idle2 = gettimemsg($lstcoin[1] - time());
echo "<br/>Next coin will be thrown after: <b>$idle2</b><br/>";
}
}else{
	$tkn = rand(20000, 90000);
echo "<br/>Here is a coin.... <a href=\"goldencoin.php?action=grab&amp;coinid=$lstcoin[0]&amp;token=$tkn\">Grab it!</a><br/>";
}

$idle = gettimemsg(time() - $lstall[4]);
echo "<br/>Last Coin Gainer: <b>$whonick</b> ($idle ago)";

  echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "";
  echo "</p>";
    echo "</card>";
}
else if($action=="grab")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Golden Coin",$pstyle);
  addonline(getuid_sid($sid),"Grabing Golden Coin","goldencoin.php?action=main");
  date_default_timezone_set('UTC');
    $New_Time = time() + (6 * 60 * 60);
    $Hour = date("G",$New_Time);
    //if(18>$Hour || 22<$Hour)
    if(14>$Hour || 22<$Hour) //2-11PM
    {
    echo "<card id=\"main\" title=\"$sitename\">";
    echo "<p align=\"center\"><small>";
    echo "You can play this game everyday from 2 p.m to 11 p.m BST (Bangladesh Standard Time) Please try again after 2 p.m.<br/><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
    echo "</small></p>";
    echo "</card>";
    echo "</wml>";
    exit();
    } 
echo "<card id=\"main\" title=\"Grab Coin\">";
   echo "<p align=\"center\"><small>";
$unick = getnick_uid($uid);
$coinid = $_GET["coinid"];
$rndm = rand(300, 480);
$showtime = time() + $rndm;
$gcoin = mysql_fetch_array(mysql_query("SELECT uid, coin, createtime, catchtime FROM ibwfrr_goldencoin WHERE id='".$coinid."'"));
$nout = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_goldencoin WHERE id='".$coinid."'"));

    if(time()<$gcoin[2])
    {
    mysql_query("INSERT INTO dcroxx_me_shouts SET shout='I kicked out [b]".getnick_uid(getuid_sid($sid))."[/b] for trying to cheat in [b]Golden Coin[/b] -evil-', shouter='3', shtime='".time()."'");
    $res = mysql_query("DELETE FROM dcroxx_me_ses WHERE uid='".getuid_sid($sid)."'");
    echo "Don't try to cheat in Golden Coin again. ChatGirl is here. May be you are kicked out and you may need to login again<br/><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
    echo "</small></p>";
    echo "</card>";
    echo "</wml>";
    exit();
    }
$bst = time() + 6*60*60;
$today = gmstrftime("%d.%m.%Y",$bst);
$isallowed = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_goldencoin WHERE uid='".$uid."' AND date='".$today."'"));
if($isallowed[0]>4)
{
    echo "Sorry you have already grabbed 5 Golden Coins today! Try again tomorrow!";
}
else{
if($gcoin[0]<1 && $coinid!=0 && $nout[0]!=0)
{
$prof = mysql_fetch_array(mysql_query("SELECT golden_coin FROM dcroxx_me_users WHERE id='".$uid."'"));
$vws = $prof[0]+1; mysql_query("UPDATE dcroxx_me_users SET golden_coin='".$vws."'WHERE  id='".$uid."'");
$pf = mysql_fetch_array(mysql_query("SELECT golden_coin FROM dcroxx_me_users WHERE id='".$uid."'"));

    $timibwf = 30*24*60*60;
    $vtime = $timibwf + time();
    mysql_query("UPDATE dcroxx_me_users SET gcexpire='".$vtime."' WHERE id='".$uid."'");

$bst = time() + 6*60*60;
$today = gmstrftime("%d.%m.%Y",$bst);
    mysql_query("UPDATE ibwfrr_goldencoin SET uid='".$uid."', catchtime='".time()."', coin='1', date='".$today."' WHERE id='".$coinid."'");
        echo "You have grabbed the coin!<br/><a href=\"goldencoin.php?action=main\">Play Again!</a>";
    mysql_query("INSERT INTO ibwfrr_goldencoin SET createtime='".$showtime."'");
    //mysql_query("INSERT INTO ibwfrr_shouts SET shout='".$unick." just grabbed a G-coin-lden C-coin-in', shouter='3', shtime='".time()."'");
}else{
        echo "The coin is already grabbed by you or someone else!<br/><a href=\"goldencoin.php?action=main\">Try for next one</a>";
}}

  echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "";
  echo "</small></p>";
    echo "</card>";
}
else if($action=="temprr")
{
    echo "<card id=\"main\" title=\"Erros\">";
    echo "<p align=\"center\"><small>";
    //$brws = $_SERVER['HTTP_USER_AGENT'];
    //$res = mysql_query("UPDATE ibwfrr_users SET browserm='".$brws."' WHERE id='".getuid_sid($sid)."'");
          echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</small></p>";
    echo "</card>";
}else{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Golden Coin",$pstyle);
  addonline(getuid_sid($sid),"ERROR","");
echo "<card id=\"main\" title=\"ERROR\">";
   echo "<p align=\"center\"><small>";

echo "Nothing Here";

  echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "";
  echo "</small></p>";
    echo "</card>";
}

?>
</html>