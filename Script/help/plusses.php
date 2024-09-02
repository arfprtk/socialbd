<?php
header("Content-type: text/vnd.wap.wml");
echo "<?xml version=\"1.0\"?>";
echo "<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\"
\"http://www.wapforum.org/DTD/wml_1.1.xml\">";
echo "<!-- dj.dance chat raversrule@gmail.com -->\n";
$sid = $_GET["sid"];
echo "<wml>\n";
echo "<card title=\"Plusses/Points\">\n";
echo "<p align=\"left\">";
echo "<small>";
echo "<b>Plusses/Points</b><br/><br/>";
echo "here are the ways you can get or recieve Credits on arawap<br/><br/>by posting in the forums the more posts you get will unlock hidden forums and also the clubs feature here when you have enough pluses<br/><br/>you can get games Credits by playing guess the number and other games coming soon and also other users can give you game Credits this will unlock more games when thay are added<br/><br/>also you can get battle points by winning rap battles in battle board forum these will be added by the battle board judges<br/><br/>and also mods and admin can add Credits for reasons like bringing members to arawap and also deduct Credits for free posting being an example<br/>";
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