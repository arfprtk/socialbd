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
<title>Aries</title>
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
echo "The persons born under Aries sign have a bit dark complexioned face, eyes somewhat brown, dwarf or medium height, sturdy and strong body, 
long neck and they talk cleverly.<br/><br/>

The persons of this sign as a rule are solitary by nature; they have smiling faces and are less spoken. They are brisk walkers.
 They have thin teeth in the lower jaw, upper jaw may sometimes have long teeth protruding out of the mouth. Anger reflects from their faces. 
 They have ample travels and frequent transfers from place to place in life. Service or business they acquire has touring feature. 
 Usually they may have bleeding teeth. They possess limited intelligence. They prefer to work under directions and guidance from others. 
 Their eyes acquire red or pale colour. They have scars on forehead or face. They are temperamental in nature and are prone to fevers and blood diseases. 
 They may have some skin diseases or are prone to them. They have large eyes and rough hair.<br/><br/>

They are usually short tempered and impatient in nature. They are ambitious, courageous and vigilant for self-respect. 
They shape their own destiny by dint of struggle and hard work. They are straight forward, generous and lovers of freedom. 
They are practical at work and work for welfare in many areas of the social fabric.<br/>

They may have weak knees and are allergic to suffocation of closed chambers. Many of them are water phobic. 
They like to stick to the profession or job they do. They may sometimes be acknowledged as friend offenders in 
the society because they don't open up with their likes and dislikes. They usually have fewer children. They are gluttonous.

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

echo"<u>Aries Horoscope for $gertime</u><br/>
 You will have abundance of energy- but work pressure seems to get you irritated. 
 Do not indulge in speculation based on humours Devote your spare time in selfless service. 
 It will give happiness and tremendous joy to you and your family. Work put in the past brings 
 in results and rewards today. Successful day for those in the creative fields as they receive 
 long awaited fame and recognition. Take care of your action and words as authority figure will 
 be less understanding if you do something deceitful.
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
