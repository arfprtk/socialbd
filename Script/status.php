<?php
session_name("PHPSESSID");
session_start();
include("xhtmlfunctions.php");
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";

include("config.php"); 
include("core.php"); 
connectdb();
$sid = $_SESSION['sid'];
$noob = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE plusses<10"));
$snoob = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE plusses>=10 AND plusses<25"));
$tyro = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE plusses>=25 AND plusses<50"));
$member = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE plusses>=50 AND plusses<75"));
$amem = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE plusses>=75 AND plusses<250"));
$vital = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE plusses>=250 AND plusses<500"));
$vein = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE plusses>=500 AND plusses<750"));
$guru = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE plusses>=750 AND plusses<1000"));
$vip = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE plusses>=1000 AND plusses<1500"));
$fan = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE plusses>=1500 AND plusses<2000"));
$pio = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE plusses>=2000 AND plusses<2500"));
$vate = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE plusses>=2500 AND plusses<3000"));
$tre = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE plusses>=3000 AND plusses<4000"));
$master = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE plusses>=4000 AND plusses<5000"));
$icon = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE plusses>=5000 AND plusses<10000"));
$mor = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE plusses>=10000"));

$pstyle = gettheme1($sid);
      echo xhtmlhead("$stitle Status",$pstyle);
echo "<p align=\"left\">";
echo "<small>";
echo "<b>Required Credits</b><br/><br/>";
echo "0-9 &#187; <b>N00b</b>($noob[0] Members)<br/>";
echo "10-24 &#187; <b>SpaRkl3</b>($snoob[0] Members)<br/>";
echo "25-49 &#187; <b>flaR3</b>($tyro[0] Members)<br/>";
echo "50-74 &#187; <b>flaM3</b>($member[0] Members)<br/>";
echo "75-249 &#187; <b>buRst</b>($amem[0] Members)<br/>";
echo "250-499 &#187; <b>ViTa1</b>($vital[0] Members)<br/>";
echo "500-749 &#187; <b>$stitle unplugged</b>($vein[0] Members)<br/>";
echo "750-999 &#187; <b>GuRu</b>($guru[0] Members)<br/>";
echo "1000-1499 &#187; <b>V.I.P</b>($vip[0] Members)<br/>";
echo "1500-1999 &#187; <b>FaNatic</b>($fan[0] Members)<br/>";
echo "2000-2499 &#187; <b>$stitle KNight</b>($pio[0] Members)<br/>";
echo "2500-2999 &#187; <b>VeteRaN</b>($vate[0] Members)<br/>";
echo "3000-3999 &#187; <b>$stitle eXpelleR</b>($tre[0] Members)<br/>";
echo "4000-4999 &#187; <b>MasteR</b>($master[0] Members)<br/>";
echo "5000-9999 &#187; <b>ic0N</b>($icon[0] Members)<br/>";
echo "10000+ &#187; <b>$stitle Unstopable</b>($mor[0] Members)<br/>";


echo "<br/></small>";
echo "</p>";
echo "<p align=\"center\">";
echo "<small>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
echo "</small>";
echo "</p>";
  echo xhtmlfoot();
exit();
?>
