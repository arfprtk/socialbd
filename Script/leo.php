<?php
header("Content-type: text/vnd.wap.wml");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");		        // expires in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");     // Last modified, right now
header("Cache-Control: no-cache, must-revalidate");	        // Prevent caching, HTTP/1.1
header("Pragma: no-cache");
header("Content-type: text/html; charset=UTF-8");
header("Pragma: no-cache");
echo "<?xml version=\"1.0\"?>";
echo "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\" \"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\">";
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../themes/tufan.css"/>
<meta name="google-site-verification" content=""/>
<meta name="msvalidate.01" content=""/>
<meta name="author" content="Prottay Chowdhury Tufan - facebook.com/FoortiBD"/>
<meta name="title" content="Its always your dreamy chat haven!"/>
<meta name="descriptions" content="TufanBD is one of the most popular Online community site in Bangladesh"/>
<meta name="messgeses" content="TufanBD is fully copyrighted by Prottay Chowdhury Tufan"/>
<meta name="keywords" content="TufanBD, TufanBD.NeT, Tufan, Tufan420, online community, community, online community site, community site in bd, chating site, most popular community site, chat, poll, forum, literature, blog, conferance, buy community site"/>
<meta property="fb:admins" content="https://facebook.com/FoortiBD"/>
<meta property="og:image" content="http://tufanbd.net/logo.png"/>
<meta property="og:title" content="TufanBD Community"/>
<meta property="og:type" content="chat"/>
<link rel="author" href="https://facebook.com/FoortiBD"/>
<meta name="Content-Type" content="text/html" charset="utf-8"/>
<meta name="robots" content="follow"/>
<title>Leo</title>
</head>
    <body>
<head>
<meta forua="true" http-equiv="Cache-Control" content="max-age=0"/>
<meta forua="true" http-equiv="Cache-Control" content="must-revalidate"/>
<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> 
</head>
<?php
include("config.php");
include("core.php");
connectdb(); fuckbrowser(); check_injection();
$action=mysql_real_escape_string($_GET["action"]);
$sid = mysql_real_escape_string($_GET["sid"]);
$page = mysql_real_escape_string($_GET["page"]);
$uid = mysql_real_escape_string(getuid_sid($sid));

if ($action=="")
{
echo"<div class=\"header\" align=\"center\"><small>";
$logo = mysql_fetch_array(mysql_query("SELECT logo, annc FROM ibwfrr_users WHERE id='".$uid."'"));
// Logo Enable/Disable
if($logo[0]=="1"){
echo "<img src=\"../images/logo.png\" alt=\"logo\" /><br/>";
}else{
echo "Logo Disabled<br/>";}
echo"Its always your dreamy chat haven!<br/>";
date_default_timezone_set('UTC');
$gerNew_Time = time() + (6* 60 * 60);
$gertime=date("h:i:s a - l, jS F Y",$gerNew_Time);
echo "<b>$gertime</b><br/>";
echo"</small></div>";
echo "<p align=\"left\"><small>";
echo "The people of this sign are courageous, tall in height and have powerful physique and broad chest.
 They possess impressive and commanding personality. They are born with leadership qualities and have magnetic power of attraction.<br/><br/>

They have reddish complexion. They have strong bones, broad forehead, beautiful eyes and big nose.
 They are ambitious and have dominating nature. They seek such occupations like military, police services or administrative services.<br/><br/>

They are proud, pious and clean hearted. They get fewer results for their deeds but are never disappointed.
 They love travels of hills and are adventurous. They like fast driving and fast moving vehicles.
 They achieve rise in destiny very late sometimes above 30 yrs of age. They have small families.
 Their pitch of voice is high. They are ambitious, autocratic, independent, strong-willed, suspicious, violent, ill tempered and jealous.
 They are strong and rough towards their subordinates.
";
echo "</small></p>";

	echo "<div class=\"anc\" align=\"left\"><small>";
echo "<a href=\"index.php?action=main&amp;sid=$sid\"><img src=\"../images/home.gif\" alt=\"*\"/>Home</a>";
echo "</small></div>";

echo"<div class=\"header\" align=\"center\"><small>
 Copyrights By: <b><font color=\"white\">Prottay Chowdhury Tufan</font></b><br/>
 ".rainbow("Founder & CEO of IT Development Center")."</small></div>";
 
echo "</div>";
echo "</body>";
}
//////////////Characteristic
else if ($action=="main"){
echo"<div class=\"header\" align=\"center\"><small>";
$logo = mysql_fetch_array(mysql_query("SELECT logo, annc FROM ibwfrr_users WHERE id='".$uid."'"));
// Logo Enable/Disable
if($logo[0]=="1"){
echo "<img src=\"../images/logo.png\" alt=\"logo\" /><br/>";
}else{
echo "Logo Disabled<br/>";}
echo"Its always your dreamy chat haven!<br/>";
date_default_timezone_set('UTC');
$gerNew_Time = time() + (6* 60 * 60);
$gertime=date("h:i:s a - l, jS F Y",$gerNew_Time);
echo "<b>$gertime</b><br/>";
echo"</small></div>";

echo "<p align=\"left\"><small>";
date_default_timezone_set('UTC');
$gerNew_Time = time() + (6* 60 * 60);
$gertime=date("M d, Y",$gerNew_Time);

echo"<u>Leo Horoscope for $gertime</u><br/>
 As food owes its flavour to salt-some unhappiness is essential only than you realize the value of happiness.
 You will make good money today- but the rise in expenses will make it difficult for you to save.
 Good time to get involved into activities that include youngsters. Interference of others will cause frictions.
 Despite the interference of outsiders, your better half will support you in all possible ways.
 Your competitive nature will enable you to win any contest you enter.<br/>";
echo "</small></p>";
	echo "<div class=\"anc\" align=\"left\"><small>";
echo "<a href=\"index.php?action=main&amp;sid=$sid\"><img src=\"../images/home.gif\" alt=\"*\"/>Home</a>";
echo "</small></div>";

echo"<div class=\"header\" align=\"center\"><small>
 Copyrights By: <b><font color=\"white\">Prottay Chowdhury Tufan</font></b><br/>
 ".rainbow("Founder & CEO of IT Development Center")."</small></div>";
 
echo "</div>";
echo "</body>";
}
else{
    addonline(getuid_sid($sid),"Characteristic","");
    echo "<card id=\"main\" title=\"Characteristic\">";
  echo "<p align=\"center\"><small>";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
?>

</html>
