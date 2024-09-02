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
    if(islogged($sid)==false)
    {
    $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
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
            echo "</p>";
  echo xhtmlfoot();
      exit();
    }
    
if($action=="shop1")
{
  addonline(getuid_sid($sid),"$stitle Shop","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
  echo "<p align=\"center\">";
  
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  
  echo "<b><u>Moodies</u></b><br/>";
  echo "<small>Buy yourself a new Mood and new Smilies.</small><br/>";

  echo "</p>";
  
  echo "Moods<br/>";
  echo "Smilies<br/>";  
  
  echo "<p><small>";  
  
  
  echo "</small></p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
      echo "</p>";
  echo xhtmlfoot();
  exit();
    }
//////////////////////////////////else

if($action=="shop2")
{
  addonline(getuid_sid($sid),"$stitle Shop","");
 $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
  echo "<p align=\"center\">";
  
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  
  echo "<b><u>Gifts and Gadgets</u></b><br/>";
  echo "Spoil yourself, or someone else.<br/>Send a gift to best friends and make them surprise!.<br/>";

 $credits = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
 
  echo "U have <b>$credits[0]</b> Credits!<br/>";

  echo "</p>";
  echo "<p>";  
  
    $sql = "SELECT itemid, itemname, itmeprice, itemshopid, avail FROM dcroxx_me_shop WHERE itemshopid='2'";

    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
        
    echo "$item[1]<br/>";
    echo " <small>Price: <b>$item[2]Credits</b></small><br/>";
    echo " Availible: <b>$item[4]</b><br/>";
    echo " <a href=\"mshops-func.php?action=buy&amp;itemid=$item[0]\">Buy Item</a><br/><br/>";
       
    }
    }

        
  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
      echo "</p>";
  echo xhtmlfoot();
  exit();
    }
//////////////////////////////////else


if($action=="shop5")
{
  addonline(getuid_sid($sid),"$stitle Shop","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
  echo "<p align=\"center\">";
  
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  
  echo "<b><u>Gifts and Gadgets</u></b><br/>";
  echo "Here You Can Spend Your Hard Earned Credits To Get Special Features On Our Site<br/>";
$credits = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
 
  echo "U have <b>$credits[0]</b> Credits!<br/>";
  echo "</p>";
  echo "<p>";  
  
    
  /*  echo "<b>Advertise ur Club</b><br/>";
    echo " <b>Price: </b>2500 Credits<br/>";
    echo " <b>Description:</b> U can advertise Ur club in Top of da $stitle main page for 12 hours and get MUCH HITZ to ur Club! <br/>";
    echo " <a href=\"mshops-func.php?action=buy2\">Buy Now!</a><br/><br/>";
  
   echo "<b>Free Gprs on Mobitel!</b><br/>";
    echo " <b>Price: </b>9000 Credits<br/>";
    echo " <b>Description:</b> With this trick U can use  Free Gprs in mobitel network!! <br/>";
    echo " <a href=\"mshops-func.php?action=gprs\">Buy Now!</a><br/><br/>";*/
	
	
   echo "<b>Personal Smilie</b><br/>";
    echo " <b>Price: </b>5000 Credits<br/>";
    echo " <b>Description:</b> U can purchase an own Persional smilie from here. <br/>";
    echo " <a href=\"mshops-func.php?action=buy3\">Buy Now!</a><br/><br/>";
	
	 echo "<b>Change Ur Nick!</b><br/>";
    echo " <b>Price: </b>2000 Credits<br/>";
    echo " <b>Description:</b> Wanna change Ur nick as u want ? ok buy this feature.<br/>";
    echo " <a href=\"mshops-func.php?action=buy4\">Buy Now!</a><br/><br/>";
	
/*	 echo "<b>VIP Membership!</b><br/>";
    echo " <b>Price: </b>8000 Credits<br/>";
    echo " <b>Description:</b> Just get the VIP membership and Be a $stitle Prince / princess for a month!<br/>";
    echo " <a href=\"mshops-func.php?action=buy5\">Buy Now!</a><br/><br/>";
	
	 echo "<b>AW TOP Secrets!</b><br/>";
    echo " <b>Price: </b>2500 Credits<br/>";
    echo " <b>Description:</b>Codes for Hiding ur Nick link in da chat, 
	useful codes for club owners, etc.. Just get these codes and Surprise ur friends! <br/>";
    echo " <a href=\"mshops-func.php?action=buy6\">Buy Now!</a><br/><br/>";*/
	
	
  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
       echo "</p>";
  echo xhtmlfoot();
  exit();
    }
//////////////////////////////////else

if($action=="shop3")
{
  addonline(getuid_sid($sid),"$stitle Shop","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
  echo "<p align=\"center\">";
  
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  
  echo "<b><u>Moto Trader</u></b><br/>";
  echo "<small>Wanne be known as the fastes chatter around?<br/>Well then buy yourself a new Sport Car Status.</small><br/>";

  echo "</p>";
  echo "<p>";  
  
    $sql = "SELECT itemid, itemname, itmeprice, itemshopid, avail FROM dcroxx_me_shop WHERE itemshopid='3'";

    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
        
    echo "$item[1]<br/>";
    echo " <small>Price: <b>$item[2]Credits</b></small><br/>";
    echo " <small>Availible: <b>$item[4]</b></small><br/>";
    echo " <small><a href=\"mshops-func.php?action=buy&amp;itemid=$item[0]\">Buy Status</a></small><br/><br/>";
       
    }
    }
  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
       echo "</p>";
  echo xhtmlfoot();
  exit();
    }
//////////////////////////////////else
if($action=="shop4")
{
  addonline(getuid_sid($sid),"$stitle Shop","");
 $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
  echo "<p align=\"center\">";
  
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  
  echo "<b><u>Extras</u></b><br/>";
  echo "<small>Buy new Feauters for the $stitle Chat/Forum</small><br/>";

  echo "</p>";
  echo "<p><small>";  
   echo "Nickname changer<br/>";
  echo " <small>Price: <b>2500Credits</b></small><br/>";
  echo " <small>Availible: <b>Unlimeted</b></small><br/>";
  echo " <small><a href=\"mshops-func.php?action=nicknamechange\"><b>Buy Item</b></a></small><br/><br/>";
 
   echo "Enable Site Privacy<br/>";
  echo " <small>Price: <b>1000Credits</b></small><br/>";
  echo " <small>Availible: <b>Unlimeted</b></small><br/>";
  echo " <small><a href=\"mshops-func.php?action=privacy\"><b>Buy Item</b></a></small><br/><br/>";
 
  echo "</small></p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
      echo "</p>";
  echo xhtmlfoot();
  exit();
    }
//////////////////////////////////else
if($action=="shop6")
{
  addonline(getuid_sid($sid),"$stitle Shop","");
 $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
  echo "<p align=\"center\">";
  
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  
  echo "<b><u>Extras</u></b><br/>";
  echo "<small>Buy new Feauters for the $stitle Chat/Forum</small><br/>";

  echo "</p>";
  echo "<p><small>";  
   echo "Flash Games<br/>";
  echo " <small>Price: <b>4000Credits</b></small><br/>";
  echo " <small>Availible: <b>Unlimeted</b></small><br/>";
  echo "<small><a href=\"mshops-func.php?action=flash\"><b>Buy Item </b></a></small><br/><br/>";
   echo "Online Radio<br/>";
  echo " <small>Price: <b>1000Credits</b></small><br/>";
  echo " <small>Availible: <b>Unlimeted</b></small><br/>";
  echo "<small><a href=\"mshops-func.php?action=radio\"><b>Buy Item </b></a></small><br/><br/>";
 
  echo "</small></p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
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
        echo "</p>";
  echo xhtmlfoot();
  exit();
    }


?>
