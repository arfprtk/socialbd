<?php
     session_name("PHPSESSID");
session_start();
/*

script by wapple.890m.tk
edited by khan1
emailtokhan1@gmail.tk
myspace.tk/emailtokhan1
thanks to all coders that help other coders (smiles)
especially 2wap.org

*/


$version = "version: v1.0";
$adven = "adventure";
?>
<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> 
<?php
// header('Content-type: application/vnd.wap.xhtml+xml');
echo "<?xml version=\"1.0\"?>";
echo "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\" \"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\">";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
include("config.php");
include("core.php");
include("xhtmlfunctions.php");

$bcon = connectdb();

if (!$bcon)
{
     echo "<head>";
     echo "<title>$sitename</title>";
     echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
     echo "<head>";
     echo "<body>";
     echo "<p align=\"center\">";
     echo "<img src=\"../images/notok.gif\" alt=\"!\"/><br/>";
     echo "<b><strong>Error! Cannot Connect To Database...</strong></b><br/><br/>";
     echo "This error happens usually when backing up the database, please be patient...";
     echo "</p>";
     echo "</body>";
     echo "</html>";
     exit();
    }

$action = $_GET["action"];
$sid = $_SESSION['sid'];
$sitename = mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE name='sitename'"));
$sitename = $sitename[0];
$uid = getuid_sid($sid);
$theme = mysql_fetch_array(mysql_query("SELECT theme FROM dcroxx_me_users WHERE id='" . $uid . "'"));

if((islogged($sid) == false) || ($uid == 0))
    {
     echo "<head>";
     echo "<title>Error!!!</title>";
     echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
     echo "</head>";
     echo "<body>";
     echo "<p align=\"center\">";
     echo "You are not logged in<br/>";
     echo "Or Your session has been expired<br/><br/>";
     echo "<a href=\"index.php\">Login</a>";
     echo "</p>";
     echo "</body>";
     echo "</html>";
     exit();
    }
if(isbanned($uid))
    {
     echo "<head>";
     echo "<title>Error!!!</title>";
     echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
     echo "</head>";
     echo "<body>";
     echo "<p align=\"center\">";
     echo "<img src=\"../images/notok.gif\" alt=\"x\"/><br/>";
     echo "<b>You are Banned</b><br/><br/>";
     $banto = mysql_fetch_array(mysql_query("SELECT timeto, pnreas, exid FROM dcroxx_me_penalties WHERE uid='" . $uid . "' AND penalty='1' OR uid='" . $uid . "' AND penalty='2'"));
     $banres = mysql_fetch_array(mysql_query("SELECT lastpnreas FROM dcroxx_me_users WHERE id='" . $uid . "'"));
     $remain = $banto[0] - time();
     $rmsg = gettimemsg($remain);
     echo "<b>Time Left: </b>$rmsg<br/>";
     $nick = getnick_uid($banto[2]);
     echo "<b>By: </b>$nick<br/>";
     echo "<b>Reason: </b>$banto[1]";
     // echo "<a href=\"index.php\">Login</a>";
    echo "</p>";
     echo "</body>";
     echo "</html>";
     exit();
     }
if($action == "padventure")
{
     addonline(getuid_sid($sid), "playing Adventure", "");
$pstyle = gettheme($sid);
    echo xhtmlhead("Adven",$pstyle);
     $view = $_GET["view"];
     if($view == "")$view = "date";
    
    
     echo "<head>";
     echo "<title>ChatBeta Adventure</title>";
     echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
     echo "</head>";
     echo "<body>";
    
     echo "<p align=\"center\">";
     echo "<img src=\"images/roll.gif\" alt=\"*\"/><br/>";
     echo "<small>How great... Wanna play  Adventure? good luck and enjoy killing!</small>";
     echo "</p>";
     // ////ALL LISTS SCRIPT <<
    echo "<p align=\"center\">";
     echo "<a href=\"adven.php?action=go\">&#187;Go</a><br/>";
     echo "</p>";
     // //// UNTILL HERE >>
    echo "<p align=\"center\">";
     echo "<a href=\"index.php?action=funm\"><img src=\"images/roll.gif\" alt=\"*\"/>";
    echo "Fun/Games</a><br/>";
     echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
    echo "Home</a>";
     echo "</p>";
    
     echo "<br/>";
     echo "</body>";
     echo "</html>";
exit();
}

/////////////////////////////////////////////
else if($action == "go")
{
     addonline(getuid_sid($sid), "playing Adventure", "");
$pstyle = gettheme($sid);
    echo xhtmlhead("Adven",$pstyle);
     $view = $_GET["view"];
     if($view == "")$view = "date";
    
    
     echo "<head>";
     echo "<title> Adventure</title>";
     echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
     echo "</head>";
     echo "<body>";
    
    
     echo "<p align=\"center\">";
     echo "<big><b>ChatBeta Adventure</b></big><br/>";
     echo "<b><small>Mania!</small></b>";
     echo "</p>";
    
    
     if(getplusses(getuid_sid($sid)) < 100)
        {
         echo "You need at least 100 plusses to play adventure!";
         }
    
    // ////ALL LISTS SCRIPT <<
    echo "<p align=\"center\">";
    echo "<small><u>Choose Hero:</u></small><br/>";
    echo "<a href=\"adven.php?action=a\">King </a><br/>";
    echo "<a href=\"adven.php?action=b\">King Rohan</a><br/>";
    echo "<a href=\"adven.php?action=c\">King Xyve</a><br/>";
    // echo "<a href=\"adven.php?action=d\">King Richard</a>, <a href=\"adven.php?action=e\">King Lothor</a>
    echo "</p>";
    
    
     // //// UNTILL HERE >>
    echo "<p align=\"center\">";
     echo "<a href=\"index.php?action=funm\">Fun N Games</a><br/>";
     echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
    echo "Home</a>";
     echo "</p>";
     echo "<br/>";
    
     echo "</body>";
     echo "</html>";
   exit();
}

/////////////////////////////////////////////
if($action == "a")
{
     addonline(getuid_sid($sid), "Adventuring King ", "");
$pstyle = gettheme($sid);
    echo xhtmlhead("Adven",$pstyle);
     echo "<head>";
     echo "<title>Adventure</title>";
     echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
     echo "</head>";
     echo "<body>";
     echo "<p align=\"center\">";
    
     // ////ALL LISTS SCRIPT <<
    $num1 = rand(1, 5);
    
     $uid = mysql_fetch_array(mysql_query("SELECT uid FROM dcroxx_me_ses WHERE id='" . $sid . "'"));
     $uid = $uid[0];
    $usrid = $uid;
     echo "<b><u>$adven $version</u></b><br/>";
     echo "<b>King  $adven</b><br/>";
     echo "<small><u>You are armored with 3 sword and magical powers, try to kill your enemy!</u></small>";
     echo "<p align=\"center\">";
     echo "<a href=\"adven.php?action=a\">Sword Attack</a><br/>";
     echo "<a href=\"adven.php?action=a\">Kick</a><br/>";
     echo "<a href=\"adven.php?action=a\">Magic</a><br/>";
     echo "</p>";
     $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='" . $uid . "'"));
     $ugpl = $ugpl[0];
     echo "<p align=\"center\">";
     echo "Golden Plusses: <b>$ugpl</b><br/>";
     $power = rand(50, 100);
     echo "Power: <b>$power</b> <br/>";
     $damage = rand(0, 100);
     $evil = Monster;
     $gold = rand(30, 100);
    
    if ($num1 == 1){
         $num = rand(1, 3);
         echo "You hit $evil with damage $damage. You've Won $gold Gold!";
         $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='" . $uid . "'"));
         $ugpl = $ugpl[0];
         $ugpl2 = $ugpl + "$gold";
         mysql_query("UPDATE dcroxx_me_users SET plusses='" . $ugpl2 . "' WHERE id='" . $uid . "'");
        
        
        echo "<br/>";
        }
    if ($num1 == 2){
         $num = rand(1, 3);
         echo "You hit $evil with damage $damage,but he return 2 kick for you with damage $gold. You've been attacked and Lost $gold gold!";
         $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='" . $uid . "'"));
         $ugpl = $ugpl[0];
         $ugpl2 = $ugpl - "$gold";
         mysql_query("UPDATE dcroxx_me_users SET plusses='" . $ugpl2 . "' WHERE id='" . $uid . "'");
        
        
        echo "<br/>";
        }
    if ($num1 == 3){
         $num = rand(1, 3);
         echo "You hit $evil damaging him $damage %. Then $evil return magic attack to you, damaging you $damage %. You draw! Minus 10 plusses for that attack";
         $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='" . $uid . "'"));
         $ugpl = $ugpl[0];
         $ugpl2 = $ugpl - "10";
         mysql_query("UPDATE dcroxx_me_users SET plusses='" . $ugpl2 . "' WHERE id='" . $uid . "'");
        
        
        echo "<br/>";
        }
    if ($num1 == 4){
         $num = rand(1, 3);
         echo "You hit $evil with a damage of $damage %. Then $evil return a scratch attack to you $gold %. You draw! Minus $gold plusses for that attack";
         $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='" . $uid . "'"));
         $ugpl = $ugpl[0];
         $ugpl2 = $ugpl - "$gold";
         mysql_query("UPDATE dcroxx_me_users SET plusses='" . $ugpl2 . "' WHERE id='" . $uid . "'");
        
        echo "<br/>";
        }
    if ($num1 == 5){
         $num = rand(1, 3);
         echo "You hit $evil damaging him 0%. Miss... Miss! Miss! Minus 10 plusses for that attack";
         $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='" . $uid . "'"));
         $ugpl = $ugpl[0];
         $ugpl2 = $ugpl - "10";
         mysql_query("UPDATE dcroxx_me_users SET plusses='" . $ugpl2 . "' WHERE id='" . $uid . "'");
        echo "</p>";
        echo "<br/>";
        }
    echo "<small><a href=\"index.php?action=funm\">Fun N Games</a></small>";
    echo "<br/>----------<br/>";
     echo "<a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
     echo "</p>";
    
    
     echo "</body>";
     echo "</html>";
  exit();
}

/////////////////////////////////////////////
if($action == "b")
{
     addonline(getuid_sid($sid), "ADVENTURING Hero Rohan", "");
$pstyle = gettheme($sid);
    echo xhtmlhead("Adven",$pstyle);
     echo "<head>";
     echo "<title>Adventure</title>";
     echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
     echo "</head>";
     echo "<body>";
     echo "<p align=\"center\">";
    
     // ////ALL LISTS SCRIPT <<
    $num2 = rand(1, 9);
    
     $uid = mysql_fetch_array(mysql_query("SELECT uid FROM dcroxx_me_ses WHERE id='" . $sid . "'"));
     $uid = $uid[0];
    $usrid = $uid;
     echo "<b><u>$adven $version</u></b><br/>";
     echo "<b>King Rohan $adven</b><br/>";
     echo "<small><u>You are armored with Special Axe and magical powers, try to let your enemy with low lifepower!</u></small><br/>";
     echo "<p align=\"center\">";
     echo "<a href=\"adven.php?action=b\">Sword Attack</a><br/>";
     echo "<a href=\"adven.php?action=b\">Kick</a><br/>";
     echo "<a href=\"adven.php?action=b\">Magic</a><br/>";
     echo "</p>";
     $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='" . $uid . "'"));
     $ugpl = $ugpl[0];
     echo "<p align=\"center\">";
     echo "Golden Plusses: <b>$ugpl</b><br/>";
     $power = rand(50, 100);
     echo "Power: <b>$power</b><br/>";
     $damage = rand(0, 100);
     $evil2 = Darklord;
     $gold = rand(30, 100);
     $magic = rand(60, 93);
     $level = 2;
     $level2 = 3;
     $low = 1;
    if ($num2 == 1){
         $num = rand(1, 3);
         echo "You hit $evil2 with damage $damage. You've Won $gold Gold!";
         $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='" . $uid . "'"));
         $ugpl = $ugpl[0];
         $ugpl2 = $ugpl + "$gold";
         mysql_query("UPDATE dcroxx_me_users SET plusses='" . $ugpl2 . "' WHERE id='" . $uid . "'");
        
        echo "<br/>";
        }
    if ($num2 == 2){
         $num = rand(1, 3);
         echo "You hit $evil2 with damage $damage,but he return 2 body and $low high kick for you with damage $gold. You've been attacked and Lost $gold gold!";
         $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='" . $uid . "'"));
         $ugpl = $ugpl[0];
         $ugpl2 = $ugpl - "$gold";
         mysql_query("UPDATE dcroxx_me_users SET plusses='" . $ugpl2 . "' WHERE id='" . $uid . "'");
        
        echo "<br/>";
        }
    if ($num2 == 3){
         $num = rand(1, 3);
         echo "You cast magic $magic % with a hit to $evil2 damaging him $damage %. Then $evil2 return magic attack to you, damaging you $damage %. You draw! Minus 10 plusses for that attack";
         $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='" . $uid . "'"));
         $ugpl = $ugpl[0];
         $ugpl2 = $ugpl - "10";
         mysql_query("UPDATE dcroxx_me_users SET plusses='" . $ugpl2 . "' WHERE id='" . $uid . "'");
        
        echo "<br/>";
        }
    if ($num2 == 4){
         $num = rand(1, 3);
         echo "You hit $evil2 with a damage of $damage %. Then $evil2 return <b>dark spell attack</b> to you $gold %. You draw! Minus $gold plusses for that attack";
         $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='" . $uid . "'"));
         $ugpl = $ugpl[0];
         $ugpl2 = $ugpl - "$gold";
         mysql_query("UPDATE dcroxx_me_users SET plusses='" . $ugpl2 . "' WHERE id='" . $uid . "'");
        
        echo "<br/>";
        }
    if ($num2 == 5){
         $num = rand(1, 3);
         echo "You hit $evil2 damaging him 0%. Miss... Miss! Miss! Minus 10 plusses for that attack";
         $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='" . $uid . "'"));
         $ugpl = $ugpl[0];
         $ugpl2 = $ugpl - "10";
         mysql_query("UPDATE dcroxx_me_users SET plusses='" . $ugpl2 . "' WHERE id='" . $uid . "'");
        
        echo "<br/>";
        }
    if ($num2 == 6){
         $num = rand(1, 3);
         echo "You hit $evil2 damaging him  100%. level up $level2. You are a GODLIKE! Plus 90 plusses for that attack";
         $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='" . $uid . "'"));
         $ugpl = $ugpl[0];
         $ugpl2 = $ugpl + "90";
         mysql_query("UPDATE dcroxx_me_users SET plusses='" . $ugpl2 . "' WHERE id='" . $uid . "'");
        
        echo "<br/>";
        }
    if ($num2 == 7){
         $num = rand(1, 3);
         echo "You hit $evil2 damaging him 40%. Level up to $level You win 50 plusses for that attack";
         $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='" . $uid . "'"));
         $ugpl = $ugpl[0];
         $ugpl2 = $ugpl + "50";
         mysql_query("UPDATE dcroxx_me_users SET plusses='" . $ugpl2 . "' WHERE id='" . $uid . "'");
        
        echo "<br/>";
        }
    if ($num2 == 8){
         $num = rand(1, 3);
         echo "You did not hit $evil2 . He jump faster than your attack! <b>Miss... Miss! Miss!</b> Minus 10 plusses for that attack";
         $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='" . $uid . "'"));
         $ugpl = $ugpl[0];
         $ugpl2 = $ugpl - "10";
         mysql_query("UPDATE dcroxx_me_users SET plusses='" . $ugpl2 . "' WHERE id='" . $uid . "'");
        
        echo "<br/>";
        }
    if ($num2 == 9){
         $num = rand(1, 3);
         echo "You hit $evil2 $damage % damage, but he hit you 99 % damage. Minus 99 plusses for that attack";
         $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='" . $uid . "'"));
         $ugpl = $ugpl[0];
         $ugpl2 = $ugpl - "99";
         mysql_query("UPDATE dcroxx_me_users SET plusses='" . $ugpl2 . "' WHERE id='" . $uid . "'");
        
        echo "<br/>";
        }
    echo "<small><a href=\"index.php?action=funm\">Fun N Games</a></small>";
    echo "<br/>----------<br/>";
     echo "<a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
     echo "</p>";
     echo "</body>";
     echo "</html>";
   exit();
}

/////////////////////////////////////////////
if($action == "c")
{
     addonline(getuid_sid($sid), "ADVENTURING Hero Rohan", "");
$pstyle = gettheme($sid);
    echo xhtmlhead("Adven",$pstyle);
     echo "<head>";
     echo "<title>Adventure $version</title>";
     echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
     echo "</head>";
     echo "<body>";
     echo "<p align=\"center\">";
    
     // ////ALL LISTS SCRIPT <<
    $num2 = rand(1, 9);
    
     $uid = mysql_fetch_array(mysql_query("SELECT uid FROM dcroxx_me_ses WHERE id='" . $sid . "'"));
     $uid = $uid[0];
    $usrid = $uid;
     echo "<b><u>$adven $version</u></b><br/>";
     echo "<b>King Xyve $adven</b><br/>";
     echo "<small><u>You are armored with Two bladed Samorai and Fire powers, try to let your enemy with low life stat!</u></small><br/>";
    
     echo "<p align=\"center\">";
     echo "<a href=\"adven.php?action=c\">Sword Attack</a><br/>";
     echo "<a href=\"adven.php?action=c\">Kick</a><br/>";
     echo "<a href=\"adven.php?action=c\">Magic</a><br/>";
    
     echo "</p>";
     $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='" . $uid . "'"));
     $ugpl = $ugpl[0];
     echo "<p align=\"center\">";
     echo "Golden Plusses: <b>$ugpl</b><br/>";
     $power = rand(50, 100);
     echo "Power: <b>$power</b><br/>";
     $damage = rand(0, 100);
     $evil3 = HeadDragon;
     $gold = rand(30, 100);
     $magic = rand(60, 93);
     $level = 2;
     $level2 = 3;
     $low = 1;
    if ($num2 == 1){
         $num = rand(1, 3);
         echo "You hit $evil3 with damage $damage. You've Won $gold Gold!";
         $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='" . $uid . "'"));
         $ugpl = $ugpl[0];
         $ugpl2 = $ugpl + "$gold";
         mysql_query("UPDATE dcroxx_me_users SET plusses='" . $ugpl2 . "' WHERE id='" . $uid . "'");
        
        echo "<br/>";
        }
    if ($num2 == 2){
         $num = rand(1, 3);
         echo "You hit $evil3 with damage $damage,but he return 2 kick for you with damage $magic . You've been attacked and Lost $gold gold!";
         $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='" . $uid . "'"));
         $ugpl = $ugpl[0];
         $ugpl2 = $ugpl - "$gold";
         mysql_query("UPDATE dcroxx_me_users SET plusses='" . $ugpl2 . "' WHERE id='" . $uid . "'");
        
        echo "<br/>";
        }
    if ($num2 == 3){
         $num = rand(1, 3);
         echo "You cast magic $magic % with a hit to $evil3 damaging him $damage %. Then $evi3 return magic attack to you, damaging you $damage %. You draw! Minus 10 plusses for that attack";
         $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='" . $uid . "'"));
         $ugpl = $ugpl[0];
         $ugpl2 = $ugpl - "10";
         mysql_query("UPDATE dcroxx_me_users SET plusses='" . $ugpl2 . "' WHERE id='" . $uid . "'");
        
        echo "<br/>";
        }
    if ($num2 == 4){
         $num = rand(1, 3);
         echo "You hit $evil3 with a damage of $damage %. Then $evil2 return <b>hold spell attack</b> to you $gold %. You draw! Minus $gold plusses for that attack";
         $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='" . $uid . "'"));
         $ugpl = $ugpl[0];
         $ugpl2 = $ugpl - "$gold";
         mysql_query("UPDATE dcroxx_me_users SET plusses='" . $ugpl2 . "' WHERE id='" . $uid . "'");
        
        echo "<br/>";
        }
    if ($num2 == 5){
         $num = rand(1, 3);
         echo "You hit $evil3 damaging him 0%. Miss... Miss! Miss! Minus 10 plusses for that attack";
         $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='" . $uid . "'"));
         $ugpl = $ugpl[0];
         $ugpl2 = $ugpl - "10";
         mysql_query("UPDATE dcroxx_me_users SET plusses='" . $ugpl2 . "' WHERE id='" . $uid . "'");
        
        echo "<br/>";
        }
    if ($num2 == 6){
         $num = rand(1, 3);
         echo "You hit $evil3 damaging him  100%. You are a GODLIKE! Plus 98 plusses for that attack";
         $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='" . $uid . "'"));
         $ugpl = $ugpl[0];
         $ugpl2 = $ugpl + "90";
         mysql_query("UPDATE dcroxx_me_users SET plusses='" . $ugpl2 . "' WHERE id='" . $uid . "'");
        
        echo "<br/>";
        }
    if ($num2 == 7){
         $num = rand(1, 3);
         echo "You hit $evil3 damaging him 70%. Level up to $level2 You win 50 plusses for that attack";
         $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='" . $uid . "'"));
         $ugpl = $ugpl[0];
         $ugpl2 = $ugpl + "50";
         mysql_query("UPDATE dcroxx_me_users SET plusses='" . $ugpl2 . "' WHERE id='" . $uid . "'");
        
        echo "<br/>";
        }
    if ($num2 == 8){
         $num = rand(1, 3);
         echo "You did not hit $evil3 . He ran faster than your attack! <b>Miss... Miss! Miss!</b> Minus 10 plusses for that attack";
         $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='" . $uid . "'"));
         $ugpl = $ugpl[0];
         $ugpl2 = $ugpl - "10";
         mysql_query("UPDATE dcroxx_me_users SET plusses='" . $ugpl2 . "' WHERE id='" . $uid . "'");
        
        echo "<br/>";
        }
    if ($num2 == 9){
         $num = rand(1, 3);
         echo "You hit $evil3 $damage % damage, but he hit you 100 % damage. Minus 100 plusses for that attack";
         $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='" . $uid . "'"));
         $ugpl = $ugpl[0];
         $ugpl2 = $ugpl - "99";
         mysql_query("UPDATE dcroxx_me_users SET plusses='" . $ugpl2 . "' WHERE id='" . $uid . "'");
        
        echo "<br/>";
        }
    echo "<small><a href=\"index.php?action=funm\">Fun N Games</a></small>";
    echo "<br/>----------<br/>";
     echo "<a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
     echo "</p>";
     echo "</body>";
     echo "</html>";
    
 exit();
}

?>
</html>
