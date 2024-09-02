<?php
    session_name("PHPSESSID");
session_start();



header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\"\"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\">";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";

	echo "<head>";

	echo "<title>SocialBD</title>";
	//echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/style.css\" />";
	echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />

<meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
<meta name=\"description\" content=\" :)\"> 
<meta name=\"keywords\" content=\"free, community, forums, chat, wap, communicate\">
<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> </head>";


	echo "<body>";
include("core.php");
include("config.php");
include("xhtmlfunctions.php");
connectdb();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$page = $_GET["page"];
$site="SocialBD RPG";
$time = date('dmHis');
$uid = getuid_sid($sid);
if((islogged($sid)==false)||($uid==0))
    {
       echo "<title>Kindat RPG</title>";
      echo "You are not logged in<br/>";
      echo "Or<br/>Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }

if($action=="pend")
{
  addonline(getuid_sid($sid)," RPG","");
  		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
     if(pending($uid))
    {
   echo "<title> RPG</title>";
      echo "<p align=\"center\">";
  $info = mysql_fetch_array(mysql_query("SELECT uid, who FROM dcroxx_me_rpgame WHERE uid='".$uid."'"));
$tnick = getnick_uid($info[1]);

echo "You have a pending game with $tnick<br/>";
 echo "<a href=\"kindatrpg.php?action=cancel&amp;who=$info[1]\">Cancel this Game</a><br/>----<br/>";
      echo "<a href=\"kindatrpg.php?action=main\">";
echo "Kindat RPG</a><br/>---<br/>";
 echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
}
 echo "<title> RPG</title>";
echo "<p align=\"center\">";
echo "You Don't Have a Pending Game!<br/>";
  echo "<a href=\"kindatrpg.php?action=main\">";
echo " RPG</a><br/>------<br/>";
 echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
 echo "</p>";
    echo "</body>";
   exit();
    }
////////////////////////////////////////////////////
else if($action=="cancel")
{
  addonline(getuid_sid($sid)," RPG","");
 		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
echo "<title> RPG</title>";
echo "<p align=\"center\">";
$info = mysql_fetch_array(mysql_query("SELECT uid, who FROM dcroxx_me_rpgame WHERE uid='".$uid."'"));
$tnick = getnick_uid($info[1]);
$tries2 = mysql_fetch_array(mysql_query("SELECT health FROM dcroxx_me_users WHERE id='".$uid."'"));
$mama3= $tries2[0];
if($mama3>49)
 {
echo "Cancelling this game means that you loose!<br/>";
echo "<a href=\"kindatrpg.php?action=cannow\">continue</a><br/>";

}else{

echo "You have Succesfully Cancelled the Game!<br/>";
$msg = "".getnick_uid(getuid_sid($sid))." cancelled the game!"."";
			autopm($msg, $info[1]);
  mysql_query("UPDATE dcroxx_me_users SET hit='1' WHERE id='".$info[1]."'");
mysql_query("DELETE FROM dcroxx_me_rpg WHERE byuid='".$uid."'");
 mysql_query("DELETE FROM dcroxx_me_rpgame WHERE uid='".$uid."'");
 mysql_query("DELETE FROM dcroxx_me_rpgame WHERE uid='".$info[1]."'");
 mysql_query("UPDATE dcroxx_me_users SET hit='1' WHERE id='".$uid."'");
 mysql_query("UPDATE dcroxx_me_users SET lastdamage='0' WHERE id='".$uid."'");
 mysql_query("UPDATE dcroxx_me_users SET givedamage='0' WHERE id='".$uid."'");
}

 echo "<a href=\"kindatrpg.php?action=main\">";
echo " RPG</a><br/>------<br/>";
 echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
 echo "</p>";
    echo "</body>";
   exit();
    }
////////////////////////////////////////////////////
else if($action=="cannow")
{
  addonline(getuid_sid($sid),"Kindat RPG","");
		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);

 echo "<title> RPG</title>";
echo "<p align=\"center\">";
$info = mysql_fetch_array(mysql_query("SELECT uid, who, bet FROM dcroxx_me_rpgame WHERE uid='".$uid."'"));
$tnick = getnick_uid($info[1]);
echo "You have Succesfully Cancelled the Game!<br/>";
$msg = "".getnick_uid(getuid_sid($sid))." cancelled the game!"."";
			autopm($msg, $info[1]);
mysql_query("UPDATE dcroxx_me_users SET plusses=plusses-'$info[2]' WHERE id='".$uid."'");
mysql_query("UPDATE dcroxx_me_users SET plusses=plusses+'$info[2]' WHERE id='".$info[1]."'");
mysql_query("UPDATE dcroxx_me_users SET loss=loss+'1' WHERE id='".$uid."'");
mysql_query("UPDATE dcroxx_me_users SET wins=wins+'1' WHERE id='".$info[1]."'");
 mysql_query("UPDATE dcroxx_me_users SET hit='1' WHERE id='".$info[1]."'");
mysql_query("DELETE FROM dcroxx_me_rpg WHERE byuid='".$uid."'");
 mysql_query("DELETE FROM dcroxx_me_rpgame WHERE uid='".$uid."'");
 mysql_query("DELETE FROM dcroxx_me_rpgame WHERE uid='".$info[1]."'");
 mysql_query("UPDATE dcroxx_me_users SET hit='1' WHERE id='".$uid."'");

 echo "<a href=\"kindatrpg.php?action=main\">";
echo " RPG</a><br/>------<br/>";
 echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
 echo "</p>";
    echo "</body>";
   exit();
    }
////////////////////////////////////////////////////
else if($action=="main")
{

  addonline(getuid_sid($sid),"Kindat RPG","");
  		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
  if(notactive($uid))
{
       echo "<title> RPG</title>";
      echo "<p align=\"center\"><small>";
       echo "User RPG account is not activated.<br/>---<br/>";
     echo "<a href=\"kindatrpg.php?action=activate\">Activate</a><br/>---<br/>";
       echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
echo "</small></p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
    echo "<title> RPG</title>";
echo "<p align=\"center\"><small>";
 $tnick = getnick_uid($uid);
  echo "Good Luck $tnick!<br/>---<br/>";
echo "<a href=\"kindatrpg.php?\">Battle Field</a><br/>";
echo "<a href=\"kindatrpg.php?action=clinic\">Clinic</a><br/>";
echo "<a href=\"kindatrpg.php?action=pend\">Pending Game</a><br/>";
echo "<a href=\"kindatrpg.php?action=bank\">Conversion</a><br/>";
echo "<a href=\"kindatrpg.php?action=player\">RPG Player</a><br/>";
echo "<a href=\"index.php?action=rpg&amp;who=$uid\">RPG Stats</a><br/>----<br/>";
 echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
  echo "</small></p>";
    echo "</body>";
   exit();
    }
////////////////////////////////////////////////////
else if($action=="activate")
{
  addonline(getuid_sid($sid)," RPG","");
  		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
 echo "<title> RPG</title>";
echo "<p align=\"center\">";
  if(notactive($uid))
{
echo "Activated successfully you can now start playing :)!";
mysql_query("UPDATE dcroxx_me_users SET activate='2' WHERE id='".$uid."'");
 }else{
echo "You already activated your account!";
}      
  echo "<br/>---<br/><a href=\"kindatrpg.php?action=main\">";
echo " RPG</a><br/>------<br/>";
 echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
 echo "</p>";
    echo "</body>";
   exit();
    }
////////////////////////////////////////////////////
else if($action=="clinic")
{

  
  addonline(getuid_sid($sid)," RPG","");
  		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
   echo "<title> Clinic</title>";
echo "<p align=\"center\">";
 $tnick = getnick_uid($uid);
  echo "Here You can Buy health which cost 2GP(game plusses) per HEALTH<br/>";
 echo "You can earn Game plusses by playing GTN under Fun Menu :)<br/>";
 $info = mysql_fetch_array(mysql_query("SELECT gplus, health FROM dcroxx_me_users WHERE id='".$uid."'"));
if ($info[1]==0)  
{
$kano ="200";
$healthko ="100";
}else if ($info[1]==99)  
{

$kano ="2";
$healthko ="1";
}else if ($info[1]==98)  
{

$kano ="4";
$healthko ="2";
}else if ($info[1]==97)  
{

$kano ="6";
$healthko ="3";
}else if ($info[1]==96)  
{

$kano ="8";
$healthko ="4";
}else if ($info[1]==95)  
{

$kano ="10";
$healthko ="5";
}else if ($info[1]==94)  
{

$kano ="12";
$healthko ="6";
}else if ($info[1]==93)  
{

$kano ="14";
$healthko ="7";
}else if ($info[1]==92)  
{

$kano ="16";
$healthko ="8";
}else if ($info[1]==90)  
{

$kano ="20";
$healthko ="10";
}else if ($info[1]==89)  
{

$kano ="22";
$healthko ="11";
}else if ($info[1]==88)  
{

$kano ="24";
$healthko ="12";
}else if ($info[1]==87)  
{

$kano ="26";
$healthko ="13";
}else if ($info[1]==86)  
{

$kano ="28";
$healthko ="14";
}else if ($info[1]==85)  
{

$kano ="30";
$healthko ="15";
}else if ($info[1]==84)  
{

$kano ="32";
$healthko ="16";
}else if ($info[1]==83)  
{

$kano ="34";
$healthko ="17";
}else if ($info[1]==82)  
{

$kano ="36";
$healthko ="18";
}else if ($info[1]==80)  
{

$kano ="40";
$healthko ="20";
}else if ($info[1]==79)  
{

$kano ="42";
$healthko ="21";
}else if ($info[1]==78)  
{

$kano ="44";
$healthko ="22";
}else if ($info[1]==77)  
{

$kano ="46";
$healthko ="23";
}else if ($info[1]==76)  
{

$kano ="48";
$healthko ="24";
}else if ($info[1]==75)  
{

$kano ="50";
$healthko ="25";
}else if ($info[1]==74)  
{

$kano ="52";
$healthko ="26";
}else if ($info[1]==73)  
{

$kano ="54";
$healthko ="27";
}else if ($info[1]==72)  
{

$kano ="56";
$healthko ="28";
}else if ($info[1]==70)  
{

$kano ="60";
$healthko ="30";
}else if ($info[1]==69)  
{

$kano ="62";
$healthko ="31";
}else if ($info[1]==68)  
{

$kano ="64";
$healthko ="32";
}else if ($info[1]==67)  
{

$kano ="66";
$healthko ="33";
}else if ($info[1]==66)  
{

$kano ="68";
$healthko ="34";
}else if ($info[1]==65)  
{

$kano ="70";
$healthko ="35";
}else if ($info[1]==64)  
{

$kano ="72";
$healthko ="36";
}else if ($info[1]==63)  
{

$kano ="74";
$healthko ="37";
}else if ($info[1]==62)  
{

$kano ="76";
$healthko ="38";
}else if ($info[1]==60)  
{

$kano ="80";
$healthko ="40";
}else if ($info[1]==59)  
{

$kano ="82";
$healthko ="41";
}else if ($info[1]==58)  
{

$kano ="84";
$healthko ="42";
}else if ($info[1]==57)  
{

$kano ="86";
$healthko ="43";
}else if ($info[1]==56)  
{

$kano ="88";
$healthko ="44";
}else if ($info[1]==55)  
{

$kano ="90";
$healthko ="45";
}else if ($info[1]==54)  
{

$kano ="92";
$healthko ="46";
}else if ($info[1]==53)  
{

$kano ="94";
$healthko ="47";
}else if ($info[1]==52)  
{

$kano ="96";
$healthko ="48";
}else if ($info[1]==50)  
{

$kano ="100";
$healthko ="50";
}else if ($info[1]==49)  
{

$kano ="102";
$healthko ="51";
}else if ($info[1]==48)  
{

$kano ="104";
$healthko ="52";
}else if ($info[1]==47)  
{

$kano ="106";
$healthko ="53";
}else if ($info[1]==46)  
{

$kano ="108";
$healthko ="54";
}else if ($info[1]==45)  
{

$kano ="110";
$healthko ="55";
}else if ($info[1]==44)  
{

$kano ="112";
$healthko ="56";
}else if ($info[1]==43)  
{

$kano ="114";
$healthko ="57";
}else if ($info[1]==42)  
{

$kano ="116";
$healthko ="58";
}else if ($info[1]==40)  
{

$kano ="120";
$healthko ="60";
}else if ($info[1]==39)  
{

$kano ="122";
$healthko ="61";
}else if ($info[1]==38)  
{

$kano ="124";
$healthko ="62";
}else if ($info[1]==37)  
{

$kano ="126";
$healthko ="63";
}else if ($info[1]==36)  
{

$kano ="128";
$healthko ="64";
}else if ($info[1]==35)  
{

$kano ="130";
$healthko ="65";
}else if ($info[1]==34)  
{

$kano ="132";
$healthko ="66";
}else if ($info[1]==33)  
{

$kano ="134";
$healthko ="67";
}else if ($info[1]==32)  
{

$kano ="136";
$healthko ="68";
}else if ($info[1]==30)  
{

$kano ="140";
$healthko ="70";
}else if ($info[1]==29)  
{

$kano ="142";
$healthko ="71";
}else if ($info[1]==28)  
{

$kano ="144";
$healthko ="72";
}else if ($info[1]==27)  
{

$kano ="146";
$healthko ="73";
}else if ($info[1]==26)  
{

$kano ="148";
$healthko ="73";
}else if ($info[1]==25)  
{

$kano ="150";
$healthko ="75";
}else if ($info[1]==24)  
{

$kano ="152";
$healthko ="76";
}else if ($info[1]==23)  
{

$kano ="154";
$healthko ="77";
}else if ($info[1]==22)  
{

$kano ="156";
$healthko ="78";
}else if ($info[1]==20)  
{

$kano ="160";
$healthko ="80";
}else if ($info[1]==19)  
{

$kano ="162";
$healthko ="81";
}else if ($info[1]==18)  
{

$kano ="164";
$healthko ="82";
}else if ($info[1]==17)  
{

$kano ="166";
$healthko ="83";
}else if ($info[1]==16)  
{

$kano ="168";
$healthko ="84";
}else if ($info[1]==15)  
{

$kano ="170";
$healthko ="85";
}else if ($info[1]==14)  
{

$kano ="172";
$healthko ="86";
}else if ($info[1]==13)  
{

$kano ="174";
$healthko ="87";
}else if ($info[1]==12)  
{

$kano ="176";
$healthko ="88";
}else if ($info[1]==10)  
{

$kano ="180";
$healthko ="90";
}else if ($info[1]==11)  
{

$kano ="198";
$healthko ="99";
}else if ($info[1]==21)  
{

$kano ="158";
$healthko ="79";
}else if ($info[1]==31)  
{

$kano ="138";
$healthko ="69";
}else if ($info[1]==41)  
{

$kano ="118";
$healthko ="59";
}else if ($info[1]==51)  
{

$kano ="98";
$healthko ="49";
}else if ($info[1]==61)  
{

$kano ="78";
$healthko ="39";
}else if ($info[1]==71)  
{

$kano ="58";
$healthko ="29";
}else if ($info[1]==81)  
{

$kano ="38";
$healthko ="19";
}else if ($info[1]==91)  
{

$kano ="18";
$healthko ="9";
}else if ($info[1]==100)  
{

$kano ="0";
$healthko ="0";
}else if ($info[1]==1)  
{

$kano ="198";
$healthko ="99";
}else if ($info[1]==2)  
{

$kano ="196";
$healthko ="98";
}else if ($info[1]==3)  
{

$kano ="194";
$healthko ="97";
}else if ($info[1]==4)  
{

$kano ="192";
$healthko ="96";
}else if ($info[1]==5)  
{

$kano ="190";
$healthko ="95";
}else if ($info[1]==6)  
{

$kano ="188";
$healthko ="94";
}else if ($info[1]==7)  
{

$kano ="186";
$healthko ="93";
}else if ($info[1]==8)  
{

$kano ="184";
$healthko ="92";
}else if ($info[1]==9)  
{

$kano ="182";
$healthko ="91";
}

echo "You Need $healthko of health which costs $kano GP<br/>";
echo "Bugdet: $info[0]GP<br/>";
echo "<a href=\"kindatrpg.php?action=clinic2\">Buy</a>|";
echo "<a href=\"kindatrpg.php?action=main\">Cancel</a><br/>-----<br/>";

echo "<a href=\"index.php?action=rpg&amp;who=$uid\"> RPG Stats</a><br/>----<br/>";
 echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
  echo "</p>";
    echo "</body>";
   exit();
    }
////////////////////////////////////////////////////
else if($action=="clinic2")
{

  addonline(getuid_sid($sid)," RPG","");
  		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
   if(notactive($uid))
{
       echo "<title> RPG</title>";
      echo "<p align=\"center\">";
        echo "User RPG account is not activated.<br/>";
 echo "----<br/><a href=\"kindatrpg.php?action=main\">";
echo "Kindat RPG</a><br/>------<br/>";
 echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
 if(pending($uid))
    {
   echo "<title> RPG</title>";
      echo "<p align=\"center\">";
      echo "You have a pending game!<br/>";
      echo "<a href=\"kindatrpg.php?action=main\">";
echo " RPG</a><br/>------<br/>";
 echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
}
  echo "<title> CLINIC RPG</title>";
echo "<p align=\"center\">";
$info = mysql_fetch_array(mysql_query("SELECT gplus, health FROM dcroxx_me_users WHERE id='".$uid."'"));
if ($info[1]==0)  
{
$kano ="200";
$healthko ="100";
}else if ($info[1]==99)  
{

$kano ="2";
$healthko ="1";
}else if ($info[1]==98)  
{

$kano ="4";
$healthko ="2";
}else if ($info[1]==97)  
{

$kano ="6";
$healthko ="3";
}else if ($info[1]==96)  
{

$kano ="8";
$healthko ="4";
}else if ($info[1]==95)  
{

$kano ="10";
$healthko ="5";
}else if ($info[1]==94)  
{

$kano ="12";
$healthko ="6";
}else if ($info[1]==93)  
{

$kano ="14";
$healthko ="7";
}else if ($info[1]==92)  
{

$kano ="16";
$healthko ="8";
}else if ($info[1]==90)  
{

$kano ="20";
$healthko ="10";
}else if ($info[1]==89)  
{

$kano ="22";
$healthko ="11";
}else if ($info[1]==88)  
{

$kano ="24";
$healthko ="12";
}else if ($info[1]==87)  
{

$kano ="26";
$healthko ="13";
}else if ($info[1]==86)  
{

$kano ="28";
$healthko ="14";
}else if ($info[1]==85)  
{

$kano ="30";
$healthko ="15";
}else if ($info[1]==84)  
{

$kano ="32";
$healthko ="16";
}else if ($info[1]==83)  
{

$kano ="34";
$healthko ="17";
}else if ($info[1]==82)  
{

$kano ="36";
$healthko ="18";
}else if ($info[1]==80)  
{

$kano ="40";
$healthko ="20";
}else if ($info[1]==79)  
{

$kano ="42";
$healthko ="21";
}else if ($info[1]==78)  
{

$kano ="44";
$healthko ="22";
}else if ($info[1]==77)  
{

$kano ="46";
$healthko ="23";
}else if ($info[1]==76)  
{

$kano ="48";
$healthko ="24";
}else if ($info[1]==75)  
{

$kano ="50";
$healthko ="25";
}else if ($info[1]==74)  
{

$kano ="52";
$healthko ="26";
}else if ($info[1]==73)  
{

$kano ="54";
$healthko ="27";
}else if ($info[1]==72)  
{

$kano ="56";
$healthko ="28";
}else if ($info[1]==70)  
{

$kano ="60";
$healthko ="30";
}else if ($info[1]==69)  
{

$kano ="62";
$healthko ="31";
}else if ($info[1]==68)  
{

$kano ="64";
$healthko ="32";
}else if ($info[1]==67)  
{

$kano ="66";
$healthko ="33";
}else if ($info[1]==66)  
{

$kano ="68";
$healthko ="34";
}else if ($info[1]==65)  
{

$kano ="70";
$healthko ="35";
}else if ($info[1]==64)  
{

$kano ="72";
$healthko ="36";
}else if ($info[1]==63)  
{

$kano ="74";
$healthko ="37";
}else if ($info[1]==62)  
{

$kano ="76";
$healthko ="38";
}else if ($info[1]==60)  
{

$kano ="80";
$healthko ="40";
}else if ($info[1]==59)  
{

$kano ="82";
$healthko ="41";
}else if ($info[1]==58)  
{

$kano ="84";
$healthko ="42";
}else if ($info[1]==57)  
{

$kano ="86";
$healthko ="43";
}else if ($info[1]==56)  
{

$kano ="88";
$healthko ="44";
}else if ($info[1]==55)  
{

$kano ="90";
$healthko ="45";
}else if ($info[1]==54)  
{

$kano ="92";
$healthko ="46";
}else if ($info[1]==53)  
{

$kano ="94";
$healthko ="47";
}else if ($info[1]==52)  
{

$kano ="96";
$healthko ="48";
}else if ($info[1]==50)  
{

$kano ="100";
$healthko ="50";
}else if ($info[1]==49)  
{

$kano ="102";
$healthko ="51";
}else if ($info[1]==48)  
{

$kano ="104";
$healthko ="52";
}else if ($info[1]==47)  
{

$kano ="106";
$healthko ="53";
}else if ($info[1]==46)  
{

$kano ="108";
$healthko ="54";
}else if ($info[1]==45)  
{

$kano ="110";
$healthko ="55";
}else if ($info[1]==44)  
{

$kano ="112";
$healthko ="56";
}else if ($info[1]==43)  
{

$kano ="114";
$healthko ="57";
}else if ($info[1]==42)  
{

$kano ="116";
$healthko ="58";
}else if ($info[1]==40)  
{

$kano ="120";
$healthko ="60";
}else if ($info[1]==39)  
{

$kano ="122";
$healthko ="61";
}else if ($info[1]==38)  
{

$kano ="124";
$healthko ="62";
}else if ($info[1]==37)  
{

$kano ="126";
$healthko ="63";
}else if ($info[1]==36)  
{

$kano ="128";
$healthko ="64";
}else if ($info[1]==35)  
{

$kano ="130";
$healthko ="65";
}else if ($info[1]==34)  
{

$kano ="132";
$healthko ="66";
}else if ($info[1]==33)  
{

$kano ="134";
$healthko ="67";
}else if ($info[1]==32)  
{

$kano ="136";
$healthko ="68";
}else if ($info[1]==30)  
{

$kano ="140";
$healthko ="70";
}else if ($info[1]==29)  
{

$kano ="142";
$healthko ="71";
}else if ($info[1]==28)  
{

$kano ="144";
$healthko ="72";
}else if ($info[1]==27)  
{

$kano ="146";
$healthko ="73";
}else if ($info[1]==26)  
{

$kano ="148";
$healthko ="73";
}else if ($info[1]==25)  
{

$kano ="150";
$healthko ="75";
}else if ($info[1]==24)  
{

$kano ="152";
$healthko ="76";
}else if ($info[1]==23)  
{

$kano ="154";
$healthko ="77";
}else if ($info[1]==22)  
{

$kano ="156";
$healthko ="78";
}else if ($info[1]==20)  
{

$kano ="160";
$healthko ="80";
}else if ($info[1]==19)  
{

$kano ="162";
$healthko ="81";
}else if ($info[1]==18)  
{

$kano ="164";
$healthko ="82";
}else if ($info[1]==17)  
{

$kano ="166";
$healthko ="83";
}else if ($info[1]==16)  
{

$kano ="168";
$healthko ="84";
}else if ($info[1]==15)  
{

$kano ="170";
$healthko ="85";
}else if ($info[1]==14)  
{

$kano ="172";
$healthko ="86";
}else if ($info[1]==13)  
{

$kano ="174";
$healthko ="87";
}else if ($info[1]==12)  
{

$kano ="176";
$healthko ="88";
}else if ($info[1]==10)  
{

$kano ="180";
$healthko ="90";
}else if ($info[1]==11)  
{

$kano ="198";
$healthko ="99";
}else if ($info[1]==21)  
{

$kano ="158";
$healthko ="79";
}else if ($info[1]==31)  
{

$kano ="138";
$healthko ="69";
}else if ($info[1]==41)  
{

$kano ="118";
$healthko ="59";
}else if ($info[1]==51)  
{

$kano ="98";
$healthko ="49";
}else if ($info[1]==61)  
{

$kano ="78";
$healthko ="39";
}else if ($info[1]==71)  
{

$kano ="58";
$healthko ="29";
}else if ($info[1]==81)  
{

$kano ="38";
$healthko ="19";
}else if ($info[1]==91)  
{

$kano ="18";
$healthko ="9";
}else if ($info[1]==100)  
{

$kano ="0";
$healthko ="0";
}else if ($info[1]==1)  
{

$kano ="198";
$healthko ="99";
}else if ($info[1]==2)  
{

$kano ="196";
$healthko ="98";
}else if ($info[1]==3)  
{

$kano ="194";
$healthko ="97";
}else if ($info[1]==4)  
{

$kano ="192";
$healthko ="96";
}else if ($info[1]==5)  
{

$kano ="190";
$healthko ="95";
}else if ($info[1]==6)  
{

$kano ="188";
$healthko ="94";
}else if ($info[1]==7)  
{

$kano ="186";
$healthko ="93";
}else if ($info[1]==8)  
{

$kano ="184";
$healthko ="92";
}else if ($info[1]==9)  
{

$kano ="182";
$healthko ="91";
}
$gpst = mysql_fetch_array(mysql_query("SELECT gplus FROM dcroxx_me_users WHERE id='".$uid."'"));
if($gpst[0]>=$kano)
{
 
 mysql_query("UPDATE dcroxx_me_users SET gplus=gplus-'$kano' WHERE id='".$uid."'");
 mysql_query("UPDATE dcroxx_me_users SET health=health+'$healthko' WHERE id='".$uid."'");
echo "Congratulations you can Now Play pinoyRPG again :)<br/>";
}else{
echo "Insufficient Game Plusses<br/>";
}
echo "<a href=\"index.php?action=rpg&amp;who=$uid\">Kindat RPG Stats</a><br/>----<br/>";
 echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
  echo "</p>";
    echo "</body>";
   exit();
    }
////////////////////////////////////////////////////
else if($action=="bank")
{

  
  addonline(getuid_sid($sid)," RPG Bank","");
  		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
    echo "<title> Bank</title>";
echo "<p align=\"center\">";
 $tnick = getnick_uid($uid);
 echo "You can Convert your Plusses to GamePlusses and also BattlePoints to GamePlusses here :)<br/>";
echo "Exchange rate:<br/>";
echo "1plusses=10GP and 1B=5GP<br/>";
echo "<form action=\"kindatrpg.php?action=conv\" method=\"post\">";
     echo "<input name=\"hmany\" maxlength=\"4\" format=\"*N\"/><br/>";
  echo "Convertion Type:<br/><select name=\"cur\">";
 echo "<option value=\"1\">Plusses-GP</option>";
  echo "<option value=\"2\">BP-GP</option>";

  echo "</select>";
echo "<br/><input type=\"submit\" value=\"Submit\"/>";    
echo "</form>";
echo "<br/><a href=\"index.php?action=rpg&amp;who=$uid\">Kindat RPG Stats</a><br/>----<br/>";
 echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
  echo "</p>";
    echo "</body>";
   exit();
    }
////////////////////////////////////////////////////
else if($action=="conv")
{
$cur =$_POST["cur"];
$hmany =$_POST["hmany"];

  
  addonline(getuid_sid($sid)," RPG Bank","");		
  $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
   if(notactive($uid))
{
       echo "<title> RPG</title>";
      echo "<p align=\"center\">";
        echo "User RPG account is not activated.<br/>";
   echo "----<br/><a href=\"kindatrpg.php?action=main\">";
echo " RPG</a><br/>------<br/>";
 echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
 echo "<title> Bank</title>";
echo "<p align=\"center\">";
$gpst = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
$gpsf = mysql_fetch_array(mysql_query("SELECT battlep FROM dcroxx_me_users WHERE id='".$uid."'"));
if ($cur == 1) {
if($gpst[0]>=$hmany)
{
echo "Converted Succesfully :)<br/>";
$convert = $hmany*10;
 mysql_query("UPDATE dcroxx_me_users SET plusses=plusses-'$hmany' WHERE id='".$uid."'");
mysql_query("UPDATE dcroxx_me_users SET gplus=gplus+'$convert' WHERE id='".$uid."'");
}else{
          echo "Insufficient plusses!<br/>";
        }
}
if ($cur == 2) {
if($gpsf[0]>=$hmany)
{
echo "Converted Succesfully :B<br/>";
$convert2 = $hmany*5;
mysql_query("UPDATE dcroxx_me_users SET battlep=battlep-'$hmany' WHERE id='".$uid."'");
mysql_query("UPDATE dcroxx_me_users SET gplus=gplus+'$convert2' WHERE id='".$uid."'");
}else{
          echo "Insufficient Battle Points!<br/>";
        }
}
echo "<a href=\"index.php?action=rpg&amp;who=$uid\"> RPG Stats</a><br/>----<br/>";
 echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
  echo "</p>";
    echo "</body>";
   exit();
    }
////////////////////////////////////////////////////
else if($action=="chal")
{
   $who = $_GET["who"];
 
     $unick = getnick_uid($who);
  addonline(getuid_sid($sid)," RPG","");
  		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
    echo "<title> RPG</title>";
echo "<p align=\"left\">";
$unick = getnick_uid($who);

 
	echo "<form action=\"kindatrpg.php?action=chalnow\" method=\"post\">";
   echo "Plusses BET<br/><input name=\"share\" maxlength=\"4\" format=\"*N\"/><br/>";
echo "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
echo "<input type=\"submit\" value=\"Submit\"/>";    
echo "</form>";
 echo "<br/>----<br/><a href=\"kindatrpg.php?action=main\">";
echo "Kindat RPG</a><br/>------<br/>";

 echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
  echo "</p>";
    echo "</body>";
   exit();
    }
////////////////////////////////////////////////////
else if($action=="chalnow")
{
   $who = $_POST["who"];
$share = $_POST["share"];
     $tnick = getnick_uid($who);
  addonline(getuid_sid($sid),"Kindat RPG","");
  		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
  if(notactive($who))
{
       echo "<title>Kindat RPG</title>";
      echo "<p align=\"center\">";
        echo "User RPG account is not activated.<br/>";
  echo "----<br/><a href=\"kindatrpg.php?action=main\">";
echo "Kindat RPG</a><br/>------<br/>";
 echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
 if(notactive($uid))
{
       echo "<title>Kindat RPG</title>";
      echo "<p align=\"center\">";
        echo "User RPG account is not activated.<br/>";
   echo "----<br/><a href=\"kindatrpg.php?action=main\">";
echo "Kindat RPG</a><br/>------<br/>";
 echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
 if(pending($who))
    {
   echo "<title>Kindat RPG</title>";
      echo "<p align=\"center\">";
      echo "Player has a pending game!<br/>";
     echo "<a href=\"kindatrpg.php?action=main\">";
echo "Kindat RPG</a><br/>------<br/>";
 echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
}
 if(pending($uid))
    {
   echo "<title>Kindat RPG</title>";
      echo "<p align=\"center\">";
      echo "You have a pending game!<br/>";
      echo "<a href=\"kindatrpg.php?action=main\">";
echo "Kindat RPG</a><br/>------<br/>";
 echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
}
   echo "<title>Kindat RPG</title>";
echo "<p align=\"center\">";
if($uid==$who)
			{
echo "Are You Crazy and trying to Challenge YourSelf.?<br/>";
  }else{
if($share<=0)
{
   echo "0 BET is not allowed!<br/>";
 }else{

 $gpsf = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
  $gpst = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
 
 $health = mysql_fetch_array(mysql_query("SELECT health FROM dcroxx_me_users WHERE id='".$uid."'"));
  $health2 = mysql_fetch_array(mysql_query("SELECT health FROM dcroxx_me_users WHERE id='".$who."'"));
 if($gpsf[0]>=$share)
{
 if($gpst[0]>=$share)
{
if($health[0]>=100)
{
if($health2[0]>=100)
{

    $res = mysql_query("INSERT INTO dcroxx_me_rpg SET touid='".$who."', byuid='".$uid."', accept='1', bet='".$share."', actime='".time()."'");
  if($res)
        {
       mysql_query("UPDATE dcroxx_me_users SET hit='3' WHERE id='".$who."'");
       mysql_query("INSERT INTO dcroxx_me_rpgame SET uid='".$uid."', who='".$who."', bet='".$share."', owner='".$uid."'");
       mysql_query("INSERT INTO dcroxx_me_rpgame SET uid='".$who."', who='".$uid."', bet='".$share."', owner='".$uid."'");
      echo "A challenge for pinoyRPG has been sent!.<br/>Wait till the recipient accept your Challenge<br/>";
        }else{
          echo "Error!!<br/>";
        }
      }else{
          echo "Insufficient Health either you or the recipient!<br/>";
        }
        }else{
          echo "Insufficient Health either you or the recipient!<br/>";
        }    
  }else{
          echo "Insufficient Plusses either you or the recipient!<br/>";
        } 
 }else{
          echo "Insufficient Plusses either you or the recipient!<br/>";
        } 
}
}
echo "<a href=\"kindatrpg.php?action=main\">";
echo "Kindat RPG</a><br/>---<br/>";

 echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
  echo "</p>";
    echo "</body>";
}
else if($action=="acc")
{
$who = $_GET["who"];
     $unick = getnick_uid($who);
  addonline(getuid_sid($sid),"Kindat RPG","");
  		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
  if(!ingame($uid))
    {
       echo "<title>Kindat RPG</title>";
     echo "<p align=\"center\">";
 echo "Access Denied You are not in game!<br/>";

     echo "<a href=\"kindatrpg.php?action=main\">";
echo "Kindat RPG</a><br/>------<br/>";
 echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
  echo "<title>Kindat RPG</title>";
echo "<p align=\"center\">";
$info = mysql_fetch_array(mysql_query("SELECT uid, who FROM dcroxx_me_rpgame WHERE uid='".$uid."'"));
$accept = $_GET["accept"];

$uid = getuid_sid($sid);
$ncl = mysql_fetch_array(mysql_query("SELECT id, bet, byuid, touid FROM dcroxx_me_rpg WHERE touid='".$uid."' ORDER BY id DESC LIMIT 1"));

mysql_query("UPDATE dcroxx_me_rpg SET accept='2' WHERE touid='".$uid."'");
echo "You have accepted the Challenge<br/>";
echo "<a href=\"kindatrpg.php?action=sfight\">";
echo "Go to Battle Field</a><br/>- - -<br/>";
echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
  echo "</p>";
    echo "</body>";
   exit();
    }
////////////////////////////////////////////////////
else if($action=="decline")
{
$who = $_GET["who"];

     $unick = getnick_uid($who);
  addonline(getuid_sid($sid),"Kindat RPG","");
  		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
if(!ingame($uid))
    {
       echo "<title>Kindat RPG</title>";
     echo "<p align=\"center\">";
 echo "Access Denied You are not in game!<br/>";

     echo "<a href=\"kindatrpg.php?action=main\">";
echo "Kindat RPG</a><br/>------<br/>";
 echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
echo "<title>Kindat RPG</title>";
echo "<p align=\"center\">";
$info = mysql_fetch_array(mysql_query("SELECT uid, who FROM dcroxx_me_rpgame WHERE uid='".$uid."'"));
$tnick = getnick_uid($info[1]);

mysql_query("DELETE FROM dcroxx_me_rpg WHERE touid='".$uid."' AND byuid='".$info[1]."'");
mysql_query("DELETE FROM dcroxx_me_rpg WHERE byuid='".$who."'");
mysql_query("DELETE FROM dcroxx_me_rpgame WHERE uid='".$uid."'");
 mysql_query("DELETE FROM dcroxx_me_rpgame WHERE uid='".$who."'");
 mysql_query("UPDATE dcroxx_me_users SET hit='1' WHERE id='".$uid."'");
  mysql_query("UPDATE dcroxx_me_users SET hit='1' WHERE id='".$who."'");
echo "You have successfully declined the challenge!<br/>";
 $gpsf = mysql_fetch_array(mysql_query("SELECT byuid, touid FROM dcroxx_me_users WHERE id='".$uid."'"));
              $msg = "".getnick_uid(getuid_sid($sid))." declined to your rpg challenge!"."";
			autopm($msg, $who);
echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
  echo "</p>";
    echo "</body>";
   exit();
    }
///////////////////////////////////////////////////////Top Chatters

else if($action=="player")
{
    addonline(getuid_sid($sid),"Top rpg Gamer","");
			 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
    echo "<title>TOP  RPG</title>";
    
echo "<p align=\"center\">";
    echo "<b>TOP  PLAYER</b></p>";

    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
   $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE activate='2' AND wins>='1'"));
    
 $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, name, wins, loss FROM dcroxx_me_users WHERE activate='2' ORDER BY wins DESC LIMIT $limit_start, $items_per_page";

echo "<p align=\"center\">";


    $items = mysql_query($sql);
    echo mysql_error();
     if(mysql_num_rows($items)>0)
    {  
while ($item = mysql_fetch_array($items))
   
{
 
   $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a><br/> Wins: $item[2] Losses: $item[3]<br/>---";
  echo "$lnk<br/>";
    }
    }
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"kindatrpg.php?action=player&amp;page=$ppage&amp;view=$view\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"kindatrpg.php?action=player&amp;page=$npage&amp;view=$view\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
        $rets = "<form action=\"kindatrpg.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";

        $rets .= "</form>";
        

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
  echo "</p>";
    echo "</body>";
   exit();
    }
////////////////////////////////////////////////////
else{
$hit = $_GET["hit"];
$who = $_GET["who"];
$rpg = $_GET["rpg"];
$ncl = mysql_fetch_array(mysql_query("SELECT id, bet, byuid, touid FROM dcroxx_me_rpg WHERE touid='".$uid."' ORDER BY id DESC LIMIT 1"));
 $ncl2 = mysql_fetch_array(mysql_query("SELECT id, bet, byuid, touid FROM dcroxx_me_rpg WHERE byuid='".$uid."' ORDER BY id DESC LIMIT 1"));
 $unick2 = getnick_uid($ncl2[3]);
$unick = getnick_uid($ncl[2]);
addonline(getuid_sid($sid),"Challenge with $unick$unick2 with BET $ncl[1]$ncl2[1]","");
		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
if(!ingame($uid))
    {
       echo "<title>Kindat RPG</title>";
     echo "<p align=\"center\">";
 echo "Access Denied You are not in game!<br/>";
mysql_query("UPDATE dcroxx_me_users SET hit='1' WHERE id='".$uid."'");
   mysql_query("UPDATE dcroxx_me_users SET lastdamage='0' WHERE id='".$uid."'");
 mysql_query("UPDATE dcroxx_me_users SET givedamage='0' WHERE id='".$uid."'");
   echo "<a href=\"kindatrpg.php?action=main\">";
echo "Kindat RPG</a><br/>----<br/>";
 echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
   echo "<title>Kindat RPG</title>";
   echo "<p align=\"center\">";
$info = mysql_fetch_array(mysql_query("SELECT uid, who FROM dcroxx_me_rpgame WHERE uid='".$uid."'"));
  $unick = getnick_uid($info[1]);
echo getshoutbox($sid);
echo "<br/>";
$info = mysql_fetch_array(mysql_query("SELECT health FROM dcroxx_me_users WHERE id='".$uid."'"));
if($rpg==game)
    {
mysql_query("UPDATE dcroxx_me_rpg SET accept='0' WHERE byuid='".$uid."'");
}
 if(!turn($uid))
    {
$rpgd = mysql_query("SELECT id, name FROM dcroxx_me_attacks ORDER by RAND() LIMIT 1");

  while($rpgds=mysql_fetch_array($rpgd))
  {
$attack =$rpgds[1];
}
}
 if(!turn($uid))
    {
$rpgd = mysql_query("SELECT id, damage FROM dcroxx_me_damage ORDER by RAND() LIMIT 1");
 while($rpgds=mysql_fetch_array($rpgd))
  {
 
$hwdamage =$rpgds[1];
}
}
$info = mysql_fetch_array(mysql_query("SELECT uid, who, bet FROM dcroxx_me_rpgame WHERE uid='".$uid."'"));
if(!turn($uid))
    {
 if($hit=="1")
    {
 mysql_query("UPDATE dcroxx_me_users SET hit='1' WHERE id='".$uid."'");
  mysql_query("UPDATE dcroxx_me_users SET hit='0' WHERE id='".$info[1]."'");
 mysql_query("UPDATE dcroxx_me_users SET health=health-'$hwdamage' WHERE id='".$info[1]."'");
mysql_query("UPDATE dcroxx_me_users SET lastattack='".$attack."' WHERE id='".$uid."'");
mysql_query("UPDATE dcroxx_me_users SET damages='$hwdamage' WHERE id='".$uid."'");

mysql_query("UPDATE dcroxx_me_users SET giveattack='".$attack."' WHERE id='".$info[1]."'");
mysql_query("UPDATE dcroxx_me_users SET givedamage='$hwdamage' WHERE id='".$info[1]."'");
 mysql_query("UPDATE dcroxx_me_users SET lastdamage='0' WHERE id='".$uid."'");
}
}
 $damages = mysql_fetch_array(mysql_query("SELECT damages FROM dcroxx_me_users WHERE id='".$uid."'"));
  $attacks = mysql_fetch_array(mysql_query("SELECT lastattack FROM dcroxx_me_users WHERE id='".$uid."'"));
 $givedamages = mysql_fetch_array(mysql_query("SELECT givedamage FROM dcroxx_me_users WHERE id='".$uid."'"));
  $giveattacks = mysql_fetch_array(mysql_query("SELECT giveattack FROM dcroxx_me_users WHERE id='".$uid."'"));
if(!noact($uid))
    {
$tries = mysql_fetch_array(mysql_query("SELECT health FROM dcroxx_me_users WHERE id='".$uid."'"));
$mama= $tries[0];
if($mama>0)
 {
$tries2 = mysql_fetch_array(mysql_query("SELECT health FROM dcroxx_me_users WHERE id='".$info[1]."'"));
$mama2= $tries2[0];
if($mama2>0)
 {

if(!turn($uid))
    {
echo "You received a $giveattacks[0] attack from $unick!<br/>";
 echo "Damage: $givedamages[0]<br/>";
}else{
   echo "You gave $unick a $attacks[0] attack!<br/>"; 
echo "Damage: $damages[0]<br/>"; 
}
$unick3 = getnick_uid($uid);
 $health = mysql_fetch_array(mysql_query("SELECT health FROM dcroxx_me_users WHERE id='".$uid."'"));
  $health2 = mysql_fetch_array(mysql_query("SELECT health FROM dcroxx_me_users WHERE id='".$info[1]."'"));
 
 echo "<b>HEALTH LEFT</b><br/>"; 
  echo "<a href=\"index.php?action=viewuser&amp;who=$info[1]\">$unick</a>: $health2[0]<br/>";
echo "$unick3: $health[0]<br/>";


  if(!turn($uid))
    {
      echo "<a href=\"kindatrpg.php?&amp;hit=1&amp;t=$time\">HIT!</a><br/>";
    echo "<a href=\"kindatrpg.php?action=cancel\">Cancel</a><br/>---<br/>";

    }else{
        echo "<a href=\"kindatrpg.php?&amp;t=$time\">refresh</a><br/>---<br/>";
    }
$whos = $info[1];


}else{
 echo "You killed $unick and you've got $info[2] plusses!<br/>";

      mysql_query("UPDATE dcroxx_me_users SET health='100' WHERE id='".$uid."'");
mysql_query("UPDATE dcroxx_me_users SET wins=wins+'1' WHERE id='".$uid."'");
mysql_query("DELETE FROM dcroxx_me_rpgame WHERE uid='".$uid."'");
mysql_query("UPDATE dcroxx_me_users SET hit='1' WHERE id='".$uid."'");
mysql_query("DELETE FROM dcroxx_me_rpg WHERE byuid='".$uid."'");
mysql_query("UPDATE dcroxx_me_rpg SET accept='0' WHERE byuid='".$uid."'");
mysql_query("UPDATE dcroxx_me_users SET health='0' WHERE id='".$info[1]."'");
 mysql_query("UPDATE dcroxx_me_users SET lastdamage='0' WHERE id='".$uid."'");
 mysql_query("UPDATE dcroxx_me_users SET givedamage='0' WHERE id='".$uid."'");
}
}else{
 echo "You have killed by $unick!<br/>";
mysql_query("UPDATE dcroxx_me_users SET health='0' WHERE id='".$uid."'");
$info = mysql_fetch_array(mysql_query("SELECT uid, who, bet FROM dcroxx_me_rpgame WHERE uid='".$uid."'"));
mysql_query("UPDATE dcroxx_me_users SET plusses=plusses-'$info[2]' WHERE id='".$uid."'");
mysql_query("UPDATE dcroxx_me_users SET plusses=plusses+'$info[2]' WHERE id='".$info[1]."'");
mysql_query("UPDATE dcroxx_me_users SET hit='1' WHERE id='".$uid."'");
mysql_query("UPDATE dcroxx_me_users SET loss=loss+'1' WHERE id='".$uid."'");
mysql_query("DELETE FROM dcroxx_me_rpgame WHERE uid='".$uid."'");
mysql_query("DELETE FROM dcroxx_me_rpgame WHERE uid='".$uid."'"); 
mysql_query("DELETE FROM dcroxx_me_rpg WHERE byuid='".$uid."' AND id='".$ncl2[0]."'");
mysql_query("UPDATE dcroxx_me_rpg SET accept='0' WHERE touid='".$uid."'");
 mysql_query("UPDATE dcroxx_me_users SET lastdamage='0' WHERE id='".$uid."'");
 mysql_query("UPDATE dcroxx_me_users SET givedamage='0' WHERE id='".$uid."'");
}

   }else{
 echo "You gave $unick a $attacks[0] attack!<br/>"; 
echo "Damage: 0<br/>"; 
$unick3 = getnick_uid($uid);
 $health = mysql_fetch_array(mysql_query("SELECT health FROM dcroxx_me_users WHERE id='".$uid."'"));
  $health2 = mysql_fetch_array(mysql_query("SELECT health FROM dcroxx_me_users WHERE id='".$info[1]."'"));
 
 echo "<b>HEALTH LEFT</b><br/>"; 
  echo "<a href=\"index.php?action=viewuser&amp;who=$info[1]\">$unick</a>: $health2[0]<br/>";
echo "$unick3: $health[0]<br/>";

 echo "<a href=\"kindatrpg.php?&amp;t=$time\">refresh</a><br/>---<br/>";
}
 echo "<a href=\"index.php?action=main\">";
echo "Exit RPG</a><br/>---<br/>";
echo "<a href=\"kindatrpg.php?action=main\">";
echo "Kindat RPG</a><br/>---<br/>";
 echo "<a href=\"index.php?action=main\">";
echo "Main menu</a>";
  echo "</p>";
    echo "</body>";

   exit();
    }

?>

</html>
