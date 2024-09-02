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
if($action=="")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("VIP Upgrade",$pstyle);
  addonline(getuid_sid($sid),"Upgrade To VIP","?action=$action");
  

echo "<card id=\"main\" title=\"Upgrade To VIP\">";
   echo "<p align=\"left\"><small>";

   echo "<u>VIP Upgrade</u><br/><br/>";
      echo "<b>List of the features that you may win after subscribing to this service.</b><br/><br/>";
echo "
(*) Common features for all subscribers: Plusses Booster and 3 Random Gifts from ChatGirl<br/>
(*) Plusses booster will boost your bonus plusses that you are getting staying online for 30 min(s)<br/>
(*) At this moment you are getting 3 bonus plusses per 30 min(s) but plusses booster will offers you 9 plusses per 30 min(s)!<br/>
(*) <font color=\"red\">At this moment you are getting 0.50 BDT per 30 min(s) but amount booster will offers you 1.00 BDT per 30 min(s)!</font><br/>
(*) VIP account holders can edit their own posts and rename their own topics<br/>
(*) VIP account holders can send pm to locked inboxes, change their name (admin approval needed) and use special BBCODES<br/>
(*) VIP account holders can access VIP Gallery and Download, can able to send Broadcast Messages (admin approval needed)<br/>
(*) The most exciting part of the VIP Pack is the magic box! You may win <b>7 days extra VIP membership</b> or <b>5 reputation points</b> or <b>250 plusses</b> by opening the magic box!<br/>
(*) If you are already subscribed to one of our VIP packages, 7 days will be added to your account as bonus if the magic box comes with a 7 days VIP membership for you.<br/>
(*) How to upgrade to VIP Packages? Just choose any of our packages below......<br/>
</small></p>";

  $epp = mysql_fetch_array(mysql_query("SELECT balance FROM dcroxx_me_users WHERE id='".$uid."'"));
   echo "<center><small>";
  echo "You currently have <b>$epp[0] Taka</b> on Account Balance<br/>
  <a href=\"balance_reload.php\" title=\"Balance Reload\">Not enough amount? Reload now</a><br/><br/>
Select a VIP Pack
<br/>";
/*<br/>
75 Taka = 1 month VIP membership<br/>
200 Taka = 3 months VIP membership<br/>
350 Taka = 6 months VIP membership<br/>";*/

echo "</small>";

echo"
<form method=\"post\" action=\"?action=upgrade\"/>
<select name=\"pkg\" value=\"30\" style=\"height:30px;width: 170px;\"/>
<option value=\"30\">1 Month VIP for 75 BDT</option>
<option value=\"90\">3 Months VIP for 200 BDT</option>
<option value=\"180\">6 Months VIP for 350 BDT</option>
</select> 

<select name=\"pkgn\" value=\"1\" style=\"height:30px;width: 170px;\"/>
<option value=\"1\">Millionaire!</option>
<option value=\"8\">Prince!</option>
<option value=\"9\">Princess!</option>
<option value=\"10\">Upcoming Star!</option>
<option value=\"11\">Super Star!</option>
<option value=\"12\">Reaper!</option>
<option value=\"13\">Director!</option>
<option value=\"15\">Killer!</option>
<option value=\"16\">Assassin!</option>
<option value=\"17\">Partner!</option>
</select><br/><br/>

<input type=\"submit\" name=\"Submit\" value=\"UPGRADE\" style=\"height:30px;width: 170px;\"/><br/>
</form></center>";

echo"<small><center><br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a></small></center>";
    echo "</card>";
}
else if($action=="upgrade")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("VIP Upgrade",$pstyle);
  addonline(getuid_sid($sid),"Upgrade To VIP","");

if(ispu(getuid_sid($sid)))
{
echo "<card id=\"viewforum\" title=\"Validation\">";
echo "<p align=\"center\">";
echo "<img src=\"images/notok.gif\" alt=\"X\"/><br/>
    <small>You are already a VIP user. Try after expiration.<br/><b>Thank You</b></small><br/><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/><small>Home</small></a>";
echo "</p></card>";
echo "</html>";
exit();
}
echo "<card id=\"main\" title=\"Upgrade To VIP\">";
   echo "<p align=\"center\"><small>";
    $pkg = $_POST["pkg"];
    $pkgn = $_POST["pkgn"];

    if($pkg=='30'){
    }else if($pkg=='90'){
    }else if($pkg=='180'){
    }else{
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>Unknown Packege<br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
    echo "</small></p>";
    echo "</card>";
    echo "</wml>";
    exit();
    }

	if($pkgn=='1'){
    }else if($pkgnn=='8'){
    }else if($pkgn=='9'){
    }else if($pkgn=='10'){
    }else if($pkgn=='11'){
    }else if($pkgn=='12'){
    }else if($pkgn=='13'){
    }else if($pkgn=='14'){
    }else if($pkgn=='15'){
    }else if($pkgn=='16'){
    }else if($pkgn=='17'){
    }else{
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>Unknown Status/Rank<br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
    echo "</small></p>";
    echo "</card>";
    echo "</wml>";
    exit();
    }

    $epp = mysql_fetch_array(mysql_query("SELECT balance FROM dcroxx_me_users WHERE id='".$uid."'"));

    if(($epp[0]<75) || ($pkg==30 && $epp[0]<75) || ($pkg==90 && $epp[0]<200) || ($pkg==180 && $epp[0]<350))
    {
    echo "<img src=\"images/notok.gif\" alt=\"X\"/> You don't have enough Money for this package<br/><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
    echo "</small></p>";
    echo "</card>";
    echo "</wml>";
    exit();
    }

    $timeto = $pkg*24*60*60;
    $vtime = $timeto + time();

    if($pkg=='30')
    {
      $mins = $epp[0] - 75;
      $pls = 75;
    }else if($pkg=='90'){
      $mins = $epp[0] - 200;
      $pls = 200;
    }else if($pkg=='180'){
      $mins = $epp[0] - 350;
      $pls = 350;
    }

    $res = mysql_query("UPDATE dcroxx_me_users SET ptime='".$vtime."' WHERE id='".$uid."'");

    if($res)
    {
    mysql_query("UPDATE dcroxx_me_users SET specialid='".$_POST["pkgn"]."' WHERE id='".$uid."'");
    mysql_query("UPDATE dcroxx_me_users SET balance='".$mins."', withdraw_balance=withdraw_balance+$pls, lastplreas='BDT: Buy a VIP Pack' WHERE id='".$uid."'");
    mysql_query("INSERT INTO dcroxx_me_withdraw_report SET uid='".getuid_sid($sid)."', amount='".$pls."', wtime='".time()."', reason='Buy a VIP Package'");
      echo "<img src=\"images/ok.gif\" alt=\"O\"/> Upgraded Successfully to VIP";
    }else{
      echo "<img src=\"images/notok.gif\" alt=\"X\"/> Upgrading not complete. Please try again";
	  
	  
	     echo "<br/><br/><img src=\"animation_celebration_icon32x32.png\" alt=\"X\"/><br/>";
    $magicbox = rand(1, 3);
    if ($magicbox=="1")
    {
    	$opl = mysql_fetch_array(mysql_query("SELECT rp FROM dcroxx_me_users WHERE id='".$uid."'"));
    	$pval = 5;
    	$npl = $opl[0] + $pval;
    	mysql_query("UPDATE dcroxx_me_users SET rp='".$npl."' WHERE id='".$uid."'");
    	echo "<b>Congratulations!!</b><br/>";
    	echo "You have won 5 Reputation Points from the magic box. Thanks for using this service.<br/>";
    	$nam = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$uid."'"));
    	//$nam = getnick_uid($lpt[0]);
    	mysql_query("INSERT INTO dcroxx_me_shouts SET shout='".$nam[0]." has got [b]5 RPs[/b] from the [b]VIP Magic Box[/b]', shouter='3', shtime='".time()."'");
      
    }
    else if($magicbox=="2")
    {
    	$opl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
    	$pval = 250;
    	$npl = $opl[0] + $pval;
    	mysql_query("UPDATE dcroxx_me_users SET plusses='".$npl."', lastplreas='Golden Lotto winner' WHERE id='".$uid."'");
    	echo "<b>Congratulations!!</b><br/>";
    	echo "You have won 250 Plusses from the magic box. Thanks for using this service.<br/>";
    	$nam = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$uid."'"));
    	//$nam = getnick_uid($lpt[0]);
    	mysql_query("INSERT INTO dcroxx_me_shouts SET shout='".$nam[0]." has got [b]250 Plusses[/b] from the [b]VIP Magic Box[/b]', shouter='3', shtime='".time()."'");

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
    	//	mysql_query("UPDATE dcroxx_me_users SET specialid='17' WHERE id='".$uid."'");
    		$timeto = $pkg*24*60*60;
    		$vtime = $timeto + time();
    		mysql_query("UPDATE dcroxx_me_users SET ptime='".$vtime."' WHERE id='".$uid."'");
    	}
    	echo "<b>Congratulations!!</b><br/>";
    	echo "You have won 7 days extra VIP Membership from the magic box. Thanks for using this service.<br/>";
    	$nam = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$uid."'"));
    	//$nam = getnick_uid($lpt[0]);
    	mysql_query("INSERT INTO dcroxx_me_shouts SET shout='".$nam[0]." has got [b]7 Days extra VIP Membership[/b] from the [b]VIP Magic Box[/b] :-)', shouter='3', shtime='".time()."'");

    }  
	  
	  
    }

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
}
/*else if($action=="cp"){
addonline(getuid_sid($sid),"VIP CP","");
echo "<card id=\"main\" title=\"VIP CP\">";
echo "<p align=\"center\">";
if(!ispu(getuid_sid($sid))){
echo "[X]<br/>Permission Denied";
echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "";
  echo "</p>";
    echo "</card></wml>";
    exit();
}
echo "-:VIP CP:-";
echo "</p><p>";
echo "#<a href=\"attach.php?action=attach\">Attach A Photo</a><br/>";
echo "#<a href=\"index.php?action=displayname\">Change Display Name</a><br/>";
echo "#<a href=\"?action=profileads\">Profile Advertisement</a>";
echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "";
  echo "</p>";
    echo "</card>";
}

else if($action=="profileads"){
addonline(getuid_sid($sid),"VIP CP","");
echo "<card id=\"main\" title=\"VIP CP\">";
echo "<p align=\"center\">";
if(!ispu(getuid_sid($sid))){
echo "[X]<br/>Permission Denied";
echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "";
  echo "</p>";
    echo "</card></wml>";
    exit();
}
echo "</p><p><small>";

	echo "(*) You will be charged 100 plusses per hour!!<br/>";
	echo "(*) Ads will be visible on main page for your selected hours<br/>";
	echo "(*) You can use 20 letter as a ad title (Special Characters not allowed, must small lettter)</small><br/><br/>";
	
	echo "<onevent type=\"onenterforward\">";
echo "<refresh><setvar name=\"msgtxt\" value=\"\"/>
<setvar name=\"btitle\" value=\"\"/>";
echo "</refresh></onevent>";

echo "<small>Advertisement Title:</small><br/>
<small><small>(Input some text as your profile intro. Example: <b>Heart Of SocialBD</b>)</small></small><br/>
<input name=\"btitle\" maxlength=\"20\" value=\"Heart Of SocialBD\"/><br/>";
echo "<small>Hours to be ads visibility:</small><br/>
<small><small>(Just scroll up number which you want to visible your ads. Example: <b>1</b>)</small></small><br/>
<small><small>(<b>Note:</b> per number count as per hour)</small></small><br/>
<input type=\"number\" name=\"msgtxt\" maxlength=\"2\" value=\"1\"/><br/>";
echo "<anchor>Publish Ads";
echo "
<go href=\"?action=nickads\" method=\"post\">
<postfield name=\"btitle\" value=\"$(btitle)\"/>
<postfield name=\"msgtxt\" value=\"$(msgtxt)\"/>
</go>";echo "</anchor>";
   // echo "</p>";
	
echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "<small>Home</small></a>";
  echo "";
  echo "</p>";
    echo "</card>";
}



else if($action=="nickads")
{
	$btitle = $_POST["btitle"];
$msgtxt = $_POST["msgtxt"];
$qut = $_POST["qut"];
if(!ispu(getuid_sid($sid))){
	echo "<card id=\"main\" title=\"$sitename\">";
echo "<p align=\"center\"><small>";
echo "[X]<br/>Permission Denied";
echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "";
  echo "</p>";
    echo "</card></wml>";
    exit();
}
$points = $msgtxt*100;
if(!getplusses(getuid_sid($sid))>$points)
{
echo "<card id=\"main\" title=\"$sitename\">";
echo "<p align=\"center\"><small>";
echo "Sorry, you do not have sufficient balance for advertise your profile <b>$msgtxt hours</b><br/><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
echo "</small></p>";
echo "</card>";
echo "</wml>";
exit();
}

if(isblocked($btitle,$uid)&&isblocked($msgtxt,$uid)){
echo "<card id=\"main\" title=\"$sitename\">";
echo "<p align=\"center\"><small>";
echo "Sorry, something went wrong. Maybe you inputed texts or numbers are on our blocked list<br/><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
echo "</small></p>";
echo "</card>";
echo "</wml>";
exit();
}

    $uid = safe_query(getuid_sid($sid));
addonline(getuid_sid($sid),"Publish Nick Ads","");
echo "<card id=\"main\" title=\"$sitename\">";
echo "<p align=\"center\"><small>";
$crdate = time();
$uid = safe_query(getuid_sid($sid));
$res = false;

$gpsf = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_nickads WHERE userid='".$uid."'"));
if($gpsf[0]==0){
//////
$adtime = time() + $msgtxt*60*60;
if((trim($msgtxt)!="")&&(trim($btitle)!=""))
{
$res = mysql_query("INSERT INTO ibwfrr_nickads SET userid='".$uid."', title='".$btitle."', crdate='".$crdate."', adtime='".$adtime."'");
}
/////
if($res)
{
$hehe=mysql_fetch_array(mysql_query("SELECT plusses FROM ibwfrr_users WHERE id='".$uid."'"));
$points = $msgtxt*100;
$tot = $hehe[0]-$points;
$msgst= mysql_query("UPDATE ibwfrr_users SET plusses='".$tot."' WHERE id='".$uid."'");
echo "<img src=\"images/ok.gif\" alt=\"O\"/>Your profile advertisement added to our database successfully<br/>
<b>$points points</b> subtract from your account as profile advertisement charge for <b>$msgtxt hour/s</b><br/>";
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error publishing profile advertisement <br/>";
}
}else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>You have already publish your profile advertisement<br/>";
}

echo "<br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
echo "</small></p>";
echo "</card>";

}
*/
else{

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