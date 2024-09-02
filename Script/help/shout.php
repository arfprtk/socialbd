<?php
header("Content-type: text/vnd.wap.wml");
echo "<?xml version=\"1.0\"?>";
echo "<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\"
\"http://www.wapforum.org/DTD/wml_1.1.xml\">";
echo "<!-- dj.dance chat raversrule@gmail.com -->\n";
$sid = $_GET["sid"];
echo "<wml>\n";
echo "<card title=\"ShoutBox\">\n";
echo "<p align=\"left\">";
echo "<small>";
echo "<b>ShoutBox</b><br/><br/>";
echo "A new way of communicating with users on arawap, the 1st of its kind to be launched on wap, by arawap!<br/><br/>its a simple little chat feature that lets you leave messages on the site easily and fast<br/><br/>to use the Shoutbox you need atleast 75 plusses, to find out how to get more plusses, read the Plusses/Points page in the Help Menu<br/><br/>Note that inproper shouts will be deleted immediately<br/>";
echo "</small>";
echo "</p>";
echo "<p align=\"center\">";
echo "<small>";
echo "<a href=\"../help.php?sid=$sid\">Help Menu</a><br/>";
echo "<a href=\"../index.php?action=main&amp;sid=$sid\"><img src=\"/images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
echo "</small>";
echo "</p>";
echo "</card>\n";
echo "</wml>\n";
?>