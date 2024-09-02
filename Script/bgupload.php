<?php
session_name("PHPSESSID");
session_start();
include("core.php");
include("config.php");
connectdb();
$uip = getip();
$action = $_GET["action"];
$sid = $_GET["sid"];
$page = $_GET["page"];
$who = $_GET["who"];
$uid = getuid_sid($sid);
$sid = $_SESSION['sid'];
$site = $_GET["site"];
$theme = mysql_fetch_array(mysql_query("SELECT theme FROM dcroxx_me_users WHERE id='".$uid."'"));
if(islogged($sid)==false)
{
echo "<head>";
echo "<title>Error!!!</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/1.css\">";
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
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html"/>
<meta http-equiv="Cache-Control" content="no-cache" forua="true"/>
<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> ';
echo "<title>Mid Uploader</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/1.css\">";
echo "</head>";
echo "<body bgcolor=\"#FFFFFF\" text=\"#000000\" link=\"#0000FF\" vlink=\"#800080\">";

if ($upload="upload"&&$superdat_name){

if (!eregi("\.(mid|mid|mid|mid)$",$superdat_name)){
print "<b>Unsupported File Extention!=)</b>";
}else{
$superdat_name = preg_replace(
'/[^a-zA-Z0-9\.\$\%\'\`\-\@\{\}\~\!\#\(\)\&\_\^]/'
,'',str_replace(array(' ','%20',"'"),array('_','_', ""),$superdat_name));
if(strlen($superdat_name)>53){ print "<b>File Name Is Too Long!</b>";
}else{
if (empty($superdat)) {
print "<b>No input file specified!!!</b>";
}else{
copy("$superdat", "files/$uid.mid") or
die("Couldn't copy file.");

$date=(date("D, j F Y"));
$sid = $_GET["sid"];
$fsize=round($superdat_size/1024,1);
$text = "&&$superdat_name&&$fsize KB&&$date&&$REMOTE_ADDR&&";
$fz = "$fsize KB";
$uid = getuid_sid($sid);
$sid = $_GET["sid"];
if("$text"!="$check[1]"){
$mysql=mysql_query("INSERT INTO dcroxx_me_users SET bgs='".$uid."' WHERE id='".$uid."'");
echo mysql_error();
}
echo "mid has successfully been uploaded and updated to your profile.<br/> To Fully Update This BG Please Clear Your Browser Cache</b><br/>";
}
}
}
}
?>

</body>
</html>