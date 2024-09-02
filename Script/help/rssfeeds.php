<?php
header("Content-type: text/vnd.wap.wml");
echo "<?xml version=\"1.0\"?>";
echo "<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\"
\"http://www.wapforum.org/DTD/wml_1.1.xml\">";
echo "<!-- dj.dance chat raversrule@gmail.com -->\n";
$sid = $_GET["sid"];
echo "<wml>\n";
echo "<card title=\"RSS Feeds\">\n";
echo "<p align=\"left\">";
echo "<small>";
echo "<b>RSS Feeds</b><br/><br/>";
echo "RSS Feeds is the fastest and best way to get up to date news, no matter what the category or subject<br/><br/>Lucky for you, arawap has its own RSS Service. To get to the RSS Feeds simply select your board, for instance Tech. Boards, then Pick a Forum, for instance Wap/Web<br/><br/>Then on the top of the page you will notice a text named Wap/Web Extras, thats where the RSS Feed of the category or subject is located<br/><br/>Click on it and enjoy!<br/>";
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