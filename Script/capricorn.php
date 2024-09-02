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
<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> 
<title>Capricorn</title>
</head>
    <body>
<head>
<meta forua="true" http-equiv="Cache-Control" content="max-age=0"/>
<meta forua="true" http-equiv="Cache-Control" content="must-revalidate"/>
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
echo "The people under this sign are thin in body, long-necked and have thin teeth. 
They have hard hair on their scalp. They have strong bones. Sharpened chin is usually noticeable. 
They are stable and serious in nature. They set high standards for themselves. Sometimes their private and social lives are different. 
They are critical in nature and even do not spare themselves in criticism.<br/><br/>

They are slow workers but work confidently only. They are usually seen having large families. 
They are usually not sensitive about means but aim at the end only.<br/><br/>

They are introverts and are reserved in nature. They are highly ambitious and try utmost to acquire higher status in life. 
Their will power is strong. They are disappointed when they fail to achieve the goal they aspire set goal in their life. 
The seers and sages are also found under this sign. They may have to face rivalry and strong enmity in life. They are showy sometimes. 
Rise in destiny is marked at 32-33 years of age. They develop ailments associated with allergies, hypertension and weak-back.

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

echo"<u>Capricorn Horoscope for $gertime</u><br/>
 Motivate yourself to be more optimistic. It increases confidence and flexibility but at the same time prepare it to 
 leave negative emotions like fear hatred jealousy revenge. You will be in the mood to travel and spend money- 
 but you will be sorry if you do. Your problems will be serious- but people around you will not notice the pain 
 you are going through-Probably they feel it is none of their business. Try to control your speech as your harsh 
 words can mar the peace and perturb the smooth pace of the ties with your sweetheart. Health of your spouse may keep you worried. 
 Your ability to act swiftly to problems will bring you recognition.
<br/>";

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
