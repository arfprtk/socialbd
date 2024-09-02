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
//////////////// <------------- Originally Created By Tufan420 ---------------->
if($action=="")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Golden Lotto",$pstyle);
   addonline(getuid_sid($sid),"Golden Lotto","goldenlotto.php?action=main");
   echo "<card id=\"main\" title=\"Golden Lotto\">";
   echo "<p align=\"left\"><small>";
   echo "<u>Golden Lotto Service</u><br/><br/>";
   echo "<b>List of the features that you may win after subscribing to this service.</b><br/><br/>";
   echo "(*) Common features for all subscribers: Plusses Booster and 5 Random Gifts from ChatGirl<br/>";
   echo "(*) Plusses booster will boost your bonus plusses that you are getting staying online for 30 min(s)<br/>";
   echo "(*) At this moment you are getting 3 bonus plusses per 30 min(s) but plusses booster will offers you 9 plusses per 30 min(s)!<br/>";
   echo "(*) The most exciting part of the Golden Lotto is the magic box! You may win <b>7 days VIP membership</b> or <b>5 reputation points</b> or <b>250 plusses</b> by opening the magic box!<br/>";
   echo "(*) If you are already subscribed to one of our VIP packages, 7 days will be added to your account as bonus if the magic box comes with a 7 days VIP membership for you.<br/>";
   echo "(*) How to subscribe to Golden Lotto Serviece? Just choose any of our packages below......<br/>";
   echo "</small></p>";
   echo "<p align=\"center\"><small>";
   echo "Select Package<br/>";
   echo "<br/><b>Package 1</b><br/>";
   echo "15 Golden Coins = 7 Days Subscription</small><br/>";
   
echo "<center>
<form method=\"post\" action=\"goldenlotto.php?action=upgrade\">
<select name=\"pkg\" value=\"30\">
<option value=\"7\">Package 1</option>
</select><br/>
<input type=\"submit\" name=\"Submit\" value=\"Subscribe\"/><br/>
</form></center>";


    echo "<center><small><br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
    echo "Home</a>";
    echo "</small></center>";
    echo "</card>";
   
}
////////////////upgrade
else if($action=="upgrade")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Golden Lotto",$pstyle);
	addonline(getuid_sid($sid),"Subscribe To Diamond Offer","");

	echo "<card id=\"main\" title=\"Diamond Offer\">";
   echo "<p align=\"center\"><small>";
   if(islotto($uid))
   {
   	echo "[x]<br/>You have already subscribed to this serviece. Please try after expiration.";
   }
   else
   {
   
       $pkg = $_POST["pkg"];
       if($pkg=='7')
    {
    }else{
    	    echo "<img src=\"images/notok.gif\" alt=\"X\"/>Unknown Packege<br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
    echo "</small></p>";
    echo "</card>";
    echo "</wml>";
    exit();
    }
    $epp = mysql_fetch_array(mysql_query("SELECT golden_coin FROM dcroxx_me_users WHERE id='".$uid."'"));
    if(($epp[0]<15) || ($pkg==7 && $epp[0]<15))
    {
    echo "You need at least 15 Golden Points to subscribe.<br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
    echo "</small></p>";
    echo "</card>";
    echo "</wml>";
    exit();
    }
    $timeto = $pkg*24*60*60;
    $vtime = $timeto + time();
        if($pkg=='7')
    {
      $mins = $epp[0] - 15;
    }
    $res = mysql_query("UPDATE dcroxx_me_users SET lottotime='".$vtime."' WHERE id='".$uid."'");
        if($res)
    {
    	//mysql_query("INSERT INTO ibwfrr_private SET text='Congratulation!![br/]And thanks for subscribing to Diamond Offer. You have also got 5 Golden Points From Me as common gift of this serviece.[br/]Stay with us...[br/][small]p.s: that is an automated pm[/small]', byuid='50', touid='".$uid."', timesent='".time()."'");
      
    	//////////////// Golden Coin For Lotto Subscribers

      
    	
    mysql_query("UPDATE dcroxx_me_users SET lotto='1' WHERE id='".$uid."'");
    //mysql_query("UPDATE dcroxx_me_users SET golden_coin='".$mins."', usedgcs=usedgcs+15 WHERE id='".$uid."'");
    mysql_query("UPDATE dcroxx_me_users SET golden_coin='".$mins."' WHERE id='".$uid."'");
      echo "<b>Congratulations!! You have successfully subscribed to Golden Lotto.</b><br/>";
	$pf = mysql_fetch_array(mysql_query("SELECT golden_coin FROM dcroxx_me_users WHERE id='".$uid."'"));
	if($pf[0]>0)
	{
	    $ptf = mysql_fetch_array(mysql_query("SELECT gcexpire FROM dcroxx_me_users WHERE id='".$uid."'"));
	    $timibwf = 60*24*60*60;
	    $vtime = $timibwf + $ptf[0];
	    mysql_query("UPDATE dcroxx_me_users SET gcexpire='".$vtime."' WHERE id='".$uid."'");
	}
          	$opl = mysql_fetch_array(mysql_query("SELECT golden_coin FROM dcroxx_me_users WHERE id='".$uid."'"));
    	//$pval = 5;
    	//$npl = $opl[0] + $pval;
    	//mysql_query("UPDATE ibwfrr_users SET goldencoin='".$npl."' WHERE id='".$uid."'");
    	//echo "<b>Congratulations!!</b><br/>";
    	//echo "You have won 5 Golden Points...<br/>";
    	//$nam = mysql_fetch_array(mysql_query("SELECT name FROM ibwfrr_users WHERE id='".$uid."'"));
    	//$nam = getnick_uid($lpt[0]);
     echo "<br/><b>You have got the below features from the Golden Lotto Magic Box:</b><br/><br/>";
    $magicbox = rand(1, 3);
    if ($magicbox=="1")
    {
    	$opl = mysql_fetch_array(mysql_query("SELECT rp FROM dcroxx_me_users WHERE id='".$uid."'"));
    	$pval = 5;
    	$npl = $opl[0] + $pval;
    	mysql_query("UPDATE dcroxx_me_users SET rp='".$npl."' WHERE id='".$uid."'");
    	echo "<b>Congratulations!!</b><br/>";
    	echo "You have won 5 Reputation Points from the magic box. Thanks for using this serviece.<br/>";
    	$nam = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$uid."'"));
    	//$nam = getnick_uid($lpt[0]);
    	mysql_query("INSERT INTO dcroxx_me_shouts SET shout='".$nam[0]." has got [b]5 RPs[/b] from the [b]Golden Lotto Magic Box[/b]', shouter='3', shtime='".time()."'");
      
    }
    else if($magicbox=="2")
    {
    	$opl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
    	$pval = 250;
    	$npl = $opl[0] + $pval;
    	mysql_query("UPDATE dcroxx_me_users SET plusses='".$npl."', lastplreas='Golden Lotto winner' WHERE id='".$uid."'");
    	echo "<b>Congratulations!!</b><br/>";
    	echo "You have won 250 Plusses from the magic box. Thanks for using this serviece.<br/>";
    	$nam = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$uid."'"));
    	//$nam = getnick_uid($lpt[0]);
    	mysql_query("INSERT INTO dcroxx_me_shouts SET shout='".$nam[0]." has got [b]250 Plusses[/b] from the [b]Golden Lotto Magic Box[/b]', shouter='3', shtime='".time()."'");

    }
    else if($magicbox=="3")
    {
    	if(ispu($uid))
    	{
    		$opl = mysql_fetch_array(mysql_query("SELECT ptime FROM dcroxx_me_users WHERE id='".$uid."'"));
    $pval = 7*24*60*60;
    $npl = $opl[0] + $pval;
    $vtime = $npl + time();
    	mysql_query("UPDATE dcroxx_me_users SET ptime='".$npl."' WHERE id='".$uid."'");
    	}
    	else
    	{
    		mysql_query("UPDATE dcroxx_me_users SET specialid='17' WHERE id='".$uid."'");
    		$timeto = $pkg*24*60*60;
    		$vtime = $timeto + time();
    		mysql_query("UPDATE dcroxx_me_users SET ptime='".$vtime."' WHERE id='".$uid."'");
    	}
    	echo "<b>Congratulations!!</b><br/>";
    	echo "You have won 7 days VIP Membership from the magic box. Thanks for using this serviece.<br/>";
    	$nam = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$uid."'"));
    	//$nam = getnick_uid($lpt[0]);
    	mysql_query("INSERT INTO dcroxx_me_shouts SET shout='".$nam[0]." has got [b]7 Days VIP Membership[/b] from the [b]Golden Lotto Magic Box[/b] :-)', shouter='3', shtime='".time()."'");

    }
      //echo "<br/><br/><a href=\"goldenlotto.php?action=magicbox\">&#187;Open Magic Box&#171;</a><br/>";
    }

    else{
      echo "<img src=\"images/notok.gif\" alt=\"X\"/> Subscription not completed. Please try again";
    }
}
    
  echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "";
  echo "</small></p>";
    echo "</card>";
}

else{

  addonline(getuid_sid($sid),"Lost","");
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