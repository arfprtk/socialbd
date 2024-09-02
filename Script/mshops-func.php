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
$who = $_GET["who"];

$itemid = $_GET["itemid"];
    if(islogged($sid)==false)
    {
     $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
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
      echo xhtmlhead("$stitle shop",$pstyle);
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

if($action=="buy")
{
  addonline(getuid_sid($sid),"$stitle Shop","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
  echo "<p align=\"center\">";
  
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  $credits = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
  $items = mysql_fetch_array(mysql_query("SELECT itemname, itmeprice, itemshopid, avail FROM dcroxx_me_shop WHERE itemid='".$itemid."'"));
  

  echo "<b><u>$items[0]</u></b><br/>";

  echo "</p>";
  echo "<p>";  
  
  if($items[3]>0){
  
  if($items[1]>$credits[0]){
  echo "You don't have enough credits to buy this itme.<br/>";
  }else{
  
  $reg = mysql_query("INSERT INTO dcroxx_me_shop_Inventory SET uid='".$who."', itemid='".$itemid."', time='".time()."'");  
  
  $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
  $ugpl = $ugpl[0] - $items[1];
  mysql_query("UPDATE dcroxx_me_users SET plusses='".$ugpl."' WHERE id='".$who."'");
  
  $totitems = mysql_fetch_array(mysql_query("SELECT avail FROM dcroxx_me_shop WHERE itemid='".$itemid."'"));
  $totitems = $totitems[0] - 1;
  mysql_query("UPDATE dcroxx_me_shop SET avail='".$totitems."' WHERE itemid='".$itemid."'");
  
  echo "Congrats, you have just bought the $items[0]<br/>";

  }
  }else{
  echo "Out Of Stock, We Restock every Month";
  }
  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
   echo "<a href=\"mshop.php?action=main\">Back to Shop</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
  exit();
    }
//////////////////////////////////
else

if($action=="buy2")
{
  addonline(getuid_sid($sid),"$stitle Shop","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
  echo "<p align=\"center\">";
  $ownid[0]=1;

    $whoid=$_GET["who"];
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  $credits = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
  
  

  echo "<b><u>Advertise My Club!</u></b><br/>";

  echo "</p>";
  echo "<p>";  
  
 
  
  if(2500>$credits[0]){
  echo "You don't have enough credits to buy this itme.<br/>";
  }else{
  
 
  
  $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
  $ugpl = $ugpl[0] - 2500;
  mysql_query("UPDATE dcroxx_me_users SET plusses='".$ugpl."' WHERE id='".$who."'");
  
$message = "  $nick has Paid $stitle Shop to Advertise his Club, Please Action This request as soon as possible.[br/][small][i]p.s: this is an automated pm[/i][/small]";
	autopm($message, $ownid[0]);
  
  echo "U Have Successfully Purchased to Advertise Ur Club in $stitle Main page, Ur Club Will be advertised For 12 Hours in Main page soon!<br/>
  <u>Plz Note:</u> If u have more than 1 club, Plz PM <b>$stitle</b>, Which Club U wanna Advertise..<br/>";

  }
  

  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
   echo "<a href=\"mshop.php?action=main\">Back to Shop</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
  exit();
    }
//////////////////////////////////
else

if($action=="buy3")
{
  addonline(getuid_sid($sid),"$stitle Shop","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
  echo "<p align=\"center\">";
  $ownid[0]=1;

    $whoid=$_GET["who"];
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  $credits = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
  
  

  echo "<b><u>Personal Smilie!</u></b><br/>";

  echo "</p>";
  echo "<p>";  
  
 
  
  if(5000>$credits[0]){
  echo "You don't have enough credits to buy this itme.<br/>";
  }else{
  
 
  
  $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
  $ugpl = $ugpl[0] - 5000;
  mysql_query("UPDATE dcroxx_me_users SET plusses='".$ugpl."' WHERE id='".$who."'");
  
/*$message = "  $nick has visited $stitle shop and Ordered a Personal Smilie, Please Action This request as soon as possible.[br/][small][i]p.s: this is an automated pm[/i][/small]";
	autopm($message, $ownid[0]);*/
	
  $tm = time();
$pms = mysql_query("SELECT id, name FROM dcroxx_me_users WHERE perm>'0'"); 
while($pm=mysql_fetch_array($pms)){
$message = "  [user=$who]$nick"."[/user] has visited $stitle shop and Ordered a Personal Smilie, Please Action This request as soon as possible.[br/][small][i]p.s: this is an automated pm[/i][/small]";
mysql_query("INSERT INTO dcroxx_me_private SET text='Smilies Notify:[br/]".$message."[br/]', byuid='3', touid='".$pm[0]."', timesent='".time()."'");
}
  
  echo "Thank You For Choosing To Purchase Your Personal Smilie. Your Credits Have Been Debited and your request sent to the staff for processing.<br/>";

  }
  

  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
   echo "<a href=\"mshop.php?action=main\">Back to Shop</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
  exit();
    }
//////////////////////////////////
else

if($action=="buy4")
{
  addonline(getuid_sid($sid),"$stitle Shop","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
  echo "<p align=\"center\">";
  $ownid[0]=1;

    $whoid=$_GET["who"];
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  $credits = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
  
  

  echo "<b><u>Change My Nick!</u></b><br/>";

  echo "</p>";
  echo "<p>";  
  
 
  
  if(2000>$credits[0]){
  echo "You don't have enough credits to buy this itme.<br/>";
  }else{
  
 
  
  $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
  $ugpl = $ugpl[0] - 2000;
  mysql_query("UPDATE dcroxx_me_users SET plusses='".$ugpl."' WHERE id='".$who."'");
  
/*$message = "  $nick has Paid $stitle Shop to change his Nick, Please Action This request as soon as possible.[br/][small][i]p.s: this is an automated pm[/i][/small]";
	autopm($message, $ownid[0]);*/
  
  $tm = time();
$pms = mysql_query("SELECT id, name FROM dcroxx_me_users WHERE perm>'0'"); 
while($pm=mysql_fetch_array($pms)){
$message = "  [user=$who]$nick"."[/user] has Paid $stitle Shop to change his Nick, Please Action This request as soon as possible.[br/][small][i]p.s: this is an automated pm[/i][/small]";
mysql_query("INSERT INTO dcroxx_me_private SET text='Nick Notify:[br/]".$message."[br/]', byuid='3', touid='".$pm[0]."', timesent='".time()."'");
}
  
  echo "U Have Successfully  purchased to change ur nick<br/>
  Plz PM <b>Owners</b>that like wat, ur nick Should be changed <br/>";

  }
  

  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
   echo "<a href=\"mshop.php?action=main\">Back to Shop</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
  exit();
    }
//////////////////////////////////
else

if($action=="gprs")
{
  addonline(getuid_sid($sid),"$stitle Shop","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
  echo "<p align=\"center\">";
  $ownid[0]=1;

    $whoid=$_GET["who"];
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  $credits = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
  
  

  echo "<b><u>Free Gprs On Mobitel!</u></b><br/>";

  echo "</p>";
  echo "<p>";  
  
 
  
  if(9000>$credits[0]){
  echo "You don't have enough credits to buy this itme.<br/>";
  }else{
  
 
  
  $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
  $ugpl = $ugpl[0] - 9000;
  mysql_query("UPDATE dcroxx_me_users SET plusses='".$ugpl."' WHERE id='".$who."'");
  
/*$message = "  $nick has Paid $stitle Shop to get free gprs trick, Please Action This request as soon as possible.[br/]
[small][i]p.s: this is an automated pm[/i][/small]";
	autopm($message, $ownid[0]);*/
  
$tm = time();
$pms = mysql_query("SELECT id, name FROM dcroxx_me_users WHERE perm>'0'"); 
while($pm=mysql_fetch_array($pms)){
$message = "  [user=$who]$nick"."[/user] has Paid $stitle Shop to get free gprs trick, Please Action This request as soon as possible.[br/][small][i]p.s: this is an automated pm[/i][/small]";
mysql_query("INSERT INTO dcroxx_me_private SET text='GPRS Notify:[br/]".$message."[br/]', byuid='3', touid='".$pm[0]."', timesent='".time()."'");
}
  
  echo "U Have Successfully  purchased free gprs trick!<br/>now
  Plz PM <b>Owners</b><br/>";

  }
  

  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
   echo "<a href=\"mshop.php?action=main\">Back to Shop</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
  exit();
    }
//////////////////////////////////
/*else

if($action=="buy5")
{
  addonline(getuid_sid($sid),"$stitle Shop","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
  echo "<p align=\"center\">";
  $ownid[0]=1;

    $whoid=$_GET["who"];
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  $credits = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
  
  

  echo "<b><u>VIP Membership!</u></b><br/>";

  echo "</p>";
  echo "<p>";  
  
 
  
  if(8000>$credits[0]){
  echo "You don't have enough credits to buy this itme.<br/>";
  }else{
  
 
  
  $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
  $ugpl = $ugpl[0] - 8000;
  mysql_query("UPDATE dcroxx_me_users SET plusses='".$ugpl."' WHERE id='".$who."'");
  
/*$message = "  [user=$who]$nick[/user] has Paid $stitle Shop to be a VIP FOR one month, Please Action This request as soon as possible.[br/]
[small][i]p.s: this is an automated pm[/i][/small]";
	autopm($message, $ownid[0]);*/
  
/*$tm = time();
$pms = mysql_query("SELECT id, name FROM dcroxx_me_users WHERE perm>'0'"); 
while($pm=mysql_fetch_array($pms)){
$message = "  [user=$who]$nick"."[/user] has Paid $stitle Shop to be a VIP FOR one month, Please Action This request as soon as possible.[br/][small][i]p.s: this is an automated pm[/i][/small]";
mysql_query("INSERT INTO dcroxx_me_private SET text='VIP Notify:[br/]".$message."[br/]', byuid='3', touid='".$pm[0]."', timesent='".time()."'");
}
  
  
  echo "Thank You For Choosing To Purchase a VIP Membership For one month!<br/>
";

  }
  

  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
   echo "<a href=\"mshop.php?action=main\">Back to Shop</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
  exit();
    }*/
//////////////////////////////////
else

if($action=="buy6")
{
  addonline(getuid_sid($sid),"$stitle Shop","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
  echo "<p align=\"center\">";
  $ownid[0]=1;

    $whoid=$_GET["who"];
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  $credits = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
  
  

  echo "<b><u>Secrets!</u></b><br/>";

  echo "</p>";
  echo "<p>";  
  
 
  
  if(3500>$credits[0]){
  echo "You don't have enough credits to buy this itme.<br/>";
  }else{
  
 
  
  $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
  $ugpl = $ugpl[0] - 3500;
  mysql_query("UPDATE dcroxx_me_users SET plusses='".$ugpl."' WHERE id='".$who."'");
  
$message = "  $nick has bought $stitle secrets[br/][small][i]p.s: this is an automated pm[/i][/small]";
	autopm($message, $ownid[0]);
  
  echo "Thank You For Choosing To Purchase $stitle secrets!<br/><br/>
  *put /aw in da chat to hide ur nick link.(in WML version)<br/>
  *put /reader in a pm text to show receivers nick in dat pm. first send a pm to urself with this code to understand it.(this trick very useful to club owners wen they pm all members in club<br/>
  * put /faq to link FAQ<br/>
[ ur nick is recorded to our database So we will let u know as soon as we add new tricks in $stitle. u dont wanna pay for it further. Plz keep these tricks as a secret and if any1 ask how u did it.plz ask him to go $stitle shop and purches da tricks. thanx!
  ";

  }
  

  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
   echo "<a href=\"mshop.php?action=main\">Back to Shop</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
  exit();
    }
//////////////////////////////////
if($action=="flash")
{
  addonline(getuid_sid($sid),"$stitle Shop","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
  echo "<p align=\"center\">";
  $ownid[0]=1;

    $whoid=$_GET["who"];
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  $credits = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
  $items = mysql_fetch_array(mysql_query("SELECT itemname, itmeprice, itemshopid, avail FROM dcroxx_me_shop WHERE itemid='".$itemid."'"));
  
  echo "<b><u>Buy Some flash games for pc</u></b><br/>";

  echo "</p>";
  echo "<p>";  
  
 
  
 if(4000>$credits[0]){
  echo "You don't have enough credits to buy this itme.<br/>";
  }else{
  
  
 
  
   mysql_query("UPDATE dcroxx_me_users SET flash='1' WHERE id='".$who."'");
  
  $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
  $ugpl = $ugpl[0] - 4000;
  mysql_query("UPDATE dcroxx_me_users SET plusses='".$ugpl."' WHERE id='".$who."'");
  
  echo "Congrats, you have just enable flash games<br/>";

  }
  

  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
   echo "<a href=\"mshop.php?action=main\">Back to Shop</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
  exit();
    }
//////////////////////////////////
if($action=="nicknamechange")
{
  addonline(getuid_sid($sid),"$stitle Shop","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
  echo "<p align=\"center\">";
  $ownid[0]=1;

    $whoid=$_GET["who"];
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  $credits = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
  $items = mysql_fetch_array(mysql_query("SELECT itemname, itmeprice, itemshopid, avail FROM dcroxx_me_shop WHERE itemid='".$itemid."'"));
  
  echo "<b><u>Change Ur Nickname</u></b><br/>";

  echo "</p>";
  echo "<p>";  
  
 
  
 if(2500>$credits[0]){
  echo "You don't have enough credits to buy this itme.<br/>";
  }else{
  
  
 
  
   mysql_query("UPDATE dcroxx_me_users SET nicknamechange='1' WHERE id='".$who."'");
  
  $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
  $ugpl = $ugpl[0] - 2500;
  mysql_query("UPDATE dcroxx_me_users SET plusses='".$ugpl."' WHERE id='".$who."'");
  
  echo "Congrats, you have just enable Nick name changer<br/>";

  }
  

  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
   echo "<a href=\"mshop.php?action=main\">Back to Shop</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
  exit();
    }
//////////////////////////////////
if($action=="radio")
{
  addonline(getuid_sid($sid),"$stitle Shop","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
  echo "<p align=\"center\">";
  $ownid[0]=1;

    $whoid=$_GET["who"];
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  $credits = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
  $items = mysql_fetch_array(mysql_query("SELECT itemname, itmeprice, itemshopid, avail FROM dcroxx_me_shop WHERE itemid='".$itemid."'"));
  
  echo "<b><u>Online Radio</u></b><br/>";

  echo "</p>";
  echo "<p>";  
  
 
  
 if(1000>$credits[0]){
  echo "You don't have enough credits to buy this itme.<br/>";
  }else{
  
  
 
  
   mysql_query("UPDATE dcroxx_me_users SET radio2='1' WHERE id='".$who."'");
  
  $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
  $ugpl = $ugpl[0] - 1000;
  mysql_query("UPDATE dcroxx_me_users SET plusses='".$ugpl."' WHERE id='".$who."'");
  
  echo "Congrats, you have just enable Online Radio<br/>";

  }
  

  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
   echo "<a href=\"mshop.php?action=main\">Back to Shop</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
  exit();
    }
//////////////////////////////////
if($action=="privacy")
{
  addonline(getuid_sid($sid),"$stitle Shop","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
  echo "<p align=\"center\">";
  $ownid[0]=1;

    $whoid=$_GET["who"];
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  $credits = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
  $items = mysql_fetch_array(mysql_query("SELECT itemname, itmeprice, itemshopid, avail FROM dcroxx_me_shop WHERE itemid='".$itemid."'"));
  
  echo "<b><u>Enable Options for Privacy</u></b><br/>";

  echo "</p>";
  echo "<p>";  
  
 
  
 if(1000>$credits[0]){
  echo "You don't have enough credits to buy this itme.<br/>";
  }else{
  
  
 
  
   mysql_query("UPDATE dcroxx_me_users SET privacy='1' WHERE id='".$who."'");
  
  $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
  $ugpl = $ugpl[0] - 1000;
  mysql_query("UPDATE dcroxx_me_users SET plusses='".$ugpl."' WHERE id='".$who."'");
  
  echo "Congrats, you have just enable site privacy options<br/>";

  }
  

  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
   echo "<a href=\"mshop.php?action=main\">Back to Shop</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
  exit();
    }
//////////////////////////////////
else
if($action=="useitem2")
{
  addonline(getuid_sid($sid),"$stitle Shop","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
  echo "<p align=\"center\">";
  
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);

  $items = mysql_fetch_array(mysql_query("SELECT itemname, itmeprice, itemshopid FROM dcroxx_me_shop WHERE itemid='".$itemid."'"));  
  $numberitems = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_shop_Inventory WHERE uid='".$who."' and itemid='".$itemid."'"));  
  
  if($numberitems[0]>0)
  {  
 
  
  echo "<b><u>Use $items[0]</u></b><br/>";
  
  echo "<a href=\"mshops-func.php?action=sendtom&amp;itemid=$itemid\">Send to Member</a><br/>";
  echo "Use Yourself";

  }else{
  echo "<b><u>You don't have this item in your Inventory.<br/>If you want to use it, go and buy it.</u></b><br/>";
  }
  
  echo "</p>";
  
  echo "<p>"; 
  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
  exit();
    }
//////////////////////////////////
else

if($action=="useitem3")
{
  addonline(getuid_sid($sid),"$stitle Shop","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
  echo "<p align=\"center\">";
  
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  $credits = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
  $items = mysql_fetch_array(mysql_query("SELECT itemname, itmeprice, itemshopid FROM dcroxx_me_shop WHERE itemid='".$itemid."'"));
  
  $numberitems = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_shop_Inventory WHERE uid='".$who."' and itemid='".$itemid."'"));
  
  if($numberitems[0]>0)
  {  
  
  echo "<b><u>Use $items[0]</u></b><br/>";
  
  echo "<a href=\"mshops-func.php?action=changest&amp;itemid=$itemid\">Change Status</a>";

  }else{
  echo "<b><u>You don't have this item in your Inventory.<br/>If you want to use it, go and buy it.</u></b><br/>";
  }
  
  echo "</p>";
  
  echo "<p>"; 
  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
  exit();
    }
//////////////////////////////////
else

if($action=="changest")
{
  addonline(getuid_sid($sid),"$stitle Shop","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
  echo "<p align=\"center\">";
  
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);

  $items = mysql_fetch_array(mysql_query("SELECT itemname, itmeprice, itemshopid FROM dcroxx_me_shop WHERE itemid='".$itemid."'"));  
  $numberitems = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_shop_Inventory WHERE uid='".$who."' and itemid='".$itemid."'"));  
  
  if($numberitems[0]>0)
  {    
  
  $res = mysql_query("UPDATE dcroxx_me_users SET shopssid='".$itemid."' WHERE id='".$who."'");
  if($res){
  echo "Your new Status is $items[0]";
  $itemidd = mysql_fetch_array(mysql_query("SELECT itemid FROM dcroxx_me_shop WHERE itemname='".$items[0]."'"));
  $delitem = mysql_query("DELETE FROM dcroxx_me_shop_Inventory WHERE uid='".$who."' and itemid='".$itemidd[0]."'");
  }else{
  echo "<b><u>Oops, you can't use this status.</u></b><br/>";
  }
  }else{
  echo "<b><u>Oops, you can't use this status.</u></b><br/>";
  }
  
  
  echo "</p>";
  
  echo "<p>"; 
  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
  exit();
    }
//////////////////////////////////else

if($action=="sendtom")
{
  addonline(getuid_sid($sid),"$stitle Shop","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
  echo "<p align=\"center\">";
  
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);


  $items = mysql_fetch_array(mysql_query("SELECT itemname, itmeprice, itemshopid FROM dcroxx_me_shop WHERE itemid='".$itemid."'"));  
  $numberitems = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_shop_Inventory WHERE uid='".$who."' and itemid='".$itemid."'"));  
  
  if($numberitems[0]>0)
  {    
    
  echo "Send <i>$items[0]</i> to:<br/>";
  echo "<form action=\"mshops-func.php?action=sendto\" method=\"post\">";
  echo "User: <input name=\"who\" format=\"*x\" maxlength=\"15\"/><br/>";
  echo "Message: <input name=\"pmtext\" maxlength=\"500\"/><br/>";
    echo "<input type=\"hidden\" name=\"pmitem\" value=\"$items[0]\"/>";
echo "<input type=\"submit\" value=\"SEND\"/>";
echo "</form>";


  
  }else{
  echo "<b><u>Oops, you can't send this item.</u></b><br/>";
  }
  
  
  echo "</p>";
  
  echo "<p>"; 
  
  echo "</p>";
  ////// UNTILL HERE >> 
 echo "<p align=\"center\">";
 echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
 echo "Home</a>";
 echo "</p>";
  echo xhtmlfoot();
  exit();
    }
//////////////////////////////////
else if($action=="sendto")
{
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
echo "<p align=\"center\">";


  $pmtou = $_POST["pmtou"];
 $pmtext = $_POST["pmtext"];
 $pmitme = $_POST["pmitem"];
 

$nick = getnick_sid($sid);

$who = $_POST["who"];
  $who = getuid_nick($who);
  
 

  if($who==0)
  {
  echo "<img src=\"images/notok.gif\" alt=\"x\"/>User Does Not Exist<br/>";
  }else{
 $whonick = getnick_uid($who);
$byuid = getuid_sid($sid);
 $tm = time() ;
 $lastpm = mysql_fetch_array(mysql_query("SELECT MAX(timesent) FROM dcroxx_me_private WHERE byuid='".$byuid."'"));
  $pmfl = $lastpm[0]+getpmaf();
  if($pmfl<$tm)
  {
  if(!isblocked($pmtext,$byuid))
  {
  if((!isignored($byuid, $who))&&(!istrashed($byuid)))
 {

 $pmitemtext = "[i]**$nick has sent  you a gift -[b] $pmitme [/b]check it in [u]$stitle-shop > My inventory[/u] smile.[/i]**[br/][br/]$pmtext";
 $res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$pmitemtext."', byuid='".$byuid."', touid='".$who."', timesent='".$tm."'");
  }else{
    $res = true;
  }
  if($res)
  {
    echo "<img src=\"images/ok.gif\" alt=\"O\"/>";
    echo "Item was sent successfully to $whonick<br/><br/>";
    echo parsepm($pmitemtext, $sid);
    $itemidd = mysql_fetch_array(mysql_query("SELECT itemid FROM dcroxx_me_shop WHERE itemname='".$pmitme."'"));
    $delitem = mysql_query("DELETE FROM dcroxx_me_shop_Inventory WHERE uid='".$byuid."' and itemid='".$itemidd[0]."'");
    $reg = mysql_query("INSERT INTO dcroxx_me_shop_Inventory SET uid='".$who."', itemid='".$itemidd[0]."', time='".time()."'");  

  }else{
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>";
    echo "Can't Send Item to $whonick<br/><br/>";
  }
  }
  }

    }
   echo "<br/><a href=\"mshop.php?action=main\">Back to ShoP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
 exit();
    }
//////////////////////////////////
else
{
  addonline(getuid_sid($sid),"Lost in Shop","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
  echo "<p align=\"center\">";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo xhtmlfoot();
  exit();
    }

?>
