<?php

/*
|======================================================|
| Arawap Wap Forum                                     |
| http://Arawap.net / http://Arawap.net          |
| Arawapwap@gmail.com								   |
|======================================================|
*/

include("xhtmlfunctions.php");
header("Content-type: text/html; charset=ISO-8859-1");
echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
?>
<?php
include("config.php");
include("core.php");
connectdb();
$action = $_GET["action"];
$sid = $_GET["sid"];
    if(islogged($sid)==false)
    {
      $pstyle = gettheme($sid);
      echo xhtmlhead("Arawap Bank",$pstyle);
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
      echo xhtmlhead("Arawap Bank",$pstyle);
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
    
if($action=="main")
{
  addonline(getuid_sid($sid),"Arawap Bank","awbank.php?action=main");
 $pstyle = gettheme($sid);
      echo xhtmlhead("Arawap Bank",$pstyle);
  echo "<p align=\"center\">";
  
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
   echo "<img src=\"images/ayu.gif\" alt=\"\"/><br/>";
  echo "<b><u>AubOwan $nick!!</u></b><br/>";
  echo "<br/>";

 echo "<i>Welcome to 1st w@p Bank in da w0rld! </i><br/>";
  echo "Deposit Ur Credits in aRa bank and get <b>5% interest Daily!!</b><br/>";
$credits = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
$arabank = mysql_fetch_array(mysql_query("SELECT arabank FROM dcroxx_me_users WHERE id='".$who."'"));
 
  echo "U have <b>$credits[0]</b> Credits in Pocket!<br/>";
    echo "U have <b>$arabank[0]</b> Credits in Bank!<br/><br/>"; 
	
   echo "<a href=\"awbank.php?action=dep&amp;sid=$sid\">&#187; Deposit Credits</a><br/>";
   echo "<a href=\"awbank.php?action=get&amp;sid=$sid\">&#187; Withdraw Credits</a><br/>";
   echo "&#187; Bank LoanS<br/>";
   echo "<a href=\"awbank.php?action=mis&amp;sid=$sid\">&#187; Our Aim</a><br/>";
 echo"</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main&amp;sid=$sid\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "<br/><br/>100% coded by: ";
	echo"<a href=\"index.php?action=viewuser&amp;who=1&amp;sid=$sid\">aRaa</a><br/>";
	 echo"(c) Arawap.net";
  echo "</p>";
 echo xhtmlfoot();
}else


if($action=="dep1")
{
  addonline(getuid_sid($sid),"Arawap Bank","awbank.php?action=main");
 $pstyle = gettheme($sid);
      echo xhtmlhead("Arawap Bank",$pstyle);
  echo "<p align=\"center\">";
  
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  
  echo "<b><u>Deposit Credits!</u></b><br/>";
  echo "Here You are about to Deposit Your Hardly Earned Credits in aRa bank!<br/>";
$credits = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
$arabank = mysql_fetch_array(mysql_query("SELECT arabank FROM dcroxx_me_users WHERE id='".$who."'"));
 
  echo "U have <b>$credits[0]</b> Credits in Pocket!<br/>";
    echo "U have <b>$arabank[0]</b> Credits in Bank!<br/>";
  echo "</p>";
  echo "<p>";  
  
    
  
    echo " <b>Type here the Amount U gonna deposit</b>  <br/>";

echo "<form action=\"awbank-func.php?action=dep&amp;sid=$sid&amp;who=$who\" method=\"post\">";
echo "<input name=\"ptg\" format=\"*N\" maxlength=\"5\"/>";
echo "<input type=\"submit\" value=\"Deposit now!\"/>";
echo "</form>";
  
	
	
  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main&amp;sid=$sid\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
 echo xhtmlfoot();
}else
if($action=="get")
{
  addonline(getuid_sid($sid),"Arawap Bank","awbank.php?action=main");
$pstyle = gettheme($sid);
      echo xhtmlhead("Arawap Bank",$pstyle);
  echo "<p align=\"center\">";
  
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  
  echo "<b><u>Withdraw Credits</u></b><br/>";
  echo "U can Get Back Ur Credits From AW Bank now.<br/>";
$credits = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
$arabank = mysql_fetch_array(mysql_query("SELECT arabank FROM dcroxx_me_users WHERE id='".$who."'"));
 
  echo "U have <b>$credits[0]</b> Credits in Pocket!<br/>";
    echo "U have <b>$arabank[0]</b> Credits in Bank!<br/>";
  echo "</p>";
  echo "<p>";  
  
    
   
  
    echo " <b>Type here the Amount U gonna Withdraw</b>  <br/>";
	echo "<form action=\"awbank-func.php?action=get&amp;sid=$sid&amp;who=$who\" method=\"post\">";
echo "<input name=\"ptg\" format=\"*N\" maxlength=\"5\"/>";
echo "<input type=\"submit\" value=\"withdraw now\"/>";
echo "</form>";
  
  
	
	
  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main&amp;sid=$sid\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
 echo xhtmlfoot();
}else

if($action=="dep")
{
  addonline(getuid_sid($sid),"Arawap Bank","awbank.php?action=main");
 $pstyle = gettheme($sid);
      echo xhtmlhead("Arawap Bank",$pstyle);
  echo "<p align=\"center\">";
  
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  
  echo "<b><u>Deposit Credits!</u></b><br/>";
  echo "
  
   *if u dont have much credits to deposit contact an online staff member and ask how to earn much credits.<br/>
  *U can deposit any amount of credits.<br/>
 *we add u 5% intersts in everyday.<br/>
 *U can withdraw ur Credits+interest in any time.<br/>

  
  <br/>";

  echo "<a href=\"awbank.php?action=dep1&amp;sid=$sid\">OK, I want to Deposit My credits Now</a>";
  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main&amp;sid=$sid\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
 echo xhtmlfoot();
}else


if($action=="mis")
{
  addonline(getuid_sid($sid),"Arawap Shop","awbank.php?action=main");
  $pstyle = gettheme($sid);
      echo xhtmlhead("Arawap Bank",$pstyle);
  echo "<p align=\"center\">";
  
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  
  echo "<b><u>Arawap Extras</u></b><br/>";
  echo " Hello $nick we r proud to say dat u r in da <i>1st and only wap-bank 
 in the world </i>, U can get an interests for ur hardly earned credits.Our target is to make wealthy ppl in da wap as wel as in real life,
 so be the best Transactor in our bank..  Maximum fUn from arawap! 
 <br/><b> Good Luck!! </b><br/>
 
 <i>-arawap team-</i><br/>";

  echo "</p>";
  
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
   echo "<a href=\"awbank.php?action=main&amp;sid=$sid\">Back to Bank</a><br/>";
  echo "<a href=\"index.php?action=main&amp;sid=$sid\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
 echo xhtmlfoot();
}

else
{
  addonline(getuid_sid($sid),"Lost in Shop","");
 $pstyle = gettheme($sid);
      echo xhtmlhead("Arawap Bank",$pstyle);
  echo "<p align=\"center\">";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php?action=main&amp;sid=$sid\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
   echo xhtmlfoot();
}

?>