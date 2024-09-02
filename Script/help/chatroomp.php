<?php
header("Content-type: text/vnd.wap.wml");
echo "<?xml version=\"1.0\"?>";
echo "<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\"
\"http://www.wapforum.org/DTD/wml_1.1.xml\">";
echo "<!-- dj.dance chat raversrule@gmail.com -->\n";
$sid = $_GET["sid"];
echo "<wml>\n";
echo "<card title=\"Chatroom Private\">\n";
echo "<p align=\"left\">";
echo "<small>";
echo "<b>Chatroom Private</b><br/><br/>";
echo "Looking for some privacy ? want to chat to your partner without being disturbed?<br/><br/>Click on Chatroom on the main page, then select users rooms.. then simply create a password protected chatroom, give the password to the on you want it to share, and start chatting<br/><br/>no one can enter your private room without a password, and never the less can any of the staff members<br/><br/>enjoy!<br/>";
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