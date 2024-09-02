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
<title>Sagittarius</title>
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
echo "The people under this sign are men of principle, following their religion. They are the nucleus of their families, earning for all.<br/><br/>

They have great potentials, happy and lucky attitude towards life. 
They are enterprising, logical, leaders, have healthy attitude towards life. 
They gain popularity through their actions and intelligence. They are optimistic, 
truthful and generous. They are loyal, independent, modest, and virtuous. They attain their goals in life. 
They are usually born in rich families and do not acquire riches by their efforts.<br/><br/>

They have long faces and necks and other parts of body attractive but conspicuous. They are soft-spoken and quite popular. 
They stick to their friendship. They are courageous but tolerant. They lose their hair of their head early. They work without thinking of fruits. 
Even if they are traders they are honest. They are quick to anger; are more idealistic and dominating. They attain rise of destiny at the age of 22-23 years.



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

echo"<u>Sagittarius Horoscope for $gertime</u><br/>
  Cheer up as good time ahead and you will have additional energy. 
  Speculation will be hazardous- therefore all investments should be 
  made with extreme care. Arguments at home will lead to unpleasantness 
  with family members. Little manipulations and negotiations will bring 
  unexpected gains. Despite of all the troubles in your life, your partner 
  will stand by you in any case. Secret enemies will be eager to spread rumors about you.

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
