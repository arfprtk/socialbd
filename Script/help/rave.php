<?php
header("Content-type: text/vnd.wap.wml");
echo "<?xml version=\"1.0\"?>";
echo "<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\"
\"http://www.wapforum.org/DTD/wml_1.1.xml\">";
echo "<!-- dj.dance chat raversrule@gmail.com -->\n";
$sid = $_GET["sid"];
echo "<wml>\n";
echo "<card title=\"ravebabe\">\n";
echo "<p align=\"left\">";
echo "<small>";
echo "<b>ravebabe</b><br/><br/>";
echo "arawap Bot ? who and what is she you ask ?<br/><br/>arawap Bot is our very own BOT, or computer as you can call it, very intelligent, has a nice personality, and very smart..<br/><br/>if you feel bored or just have nothing to do, just click on Fun Menu on the main page, then select arawap Bot and start chatting.. :)<br/><br/>Note: She does not cyber hahaha<br/>";
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