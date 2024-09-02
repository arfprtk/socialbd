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
$sitename = mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE name='sitename'"));
$sitename = $sitename[1];
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

echo "<FORM align=\"center\" ACTION=\"bgupload.php?action=upload\" METHOD=\"POST\" ENCTYPE=\"multipart/form-data\">";
?>
<b>Select Mid File :</b><br/>
<input align="center" type="file" name="superdat"><br/>
<input align="center" type="hidden" name="upload" value="upload"/>
<INPUT align="center" TYPE=SUBMIT NAME="submit" VALUE="Upload"><br/><br/></small><br/>Upload your Own Music File This Will be use as your Own Profile Music.<br/>
<?php
?>
</FORM>
<?php

echo "<br/><br/><center><a href=\"index.php?action=main\">Main menu</a></center>";
?>
</body>
</html>