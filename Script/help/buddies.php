<?php
header("Content-type: text/vnd.wap.wml");
echo "<?xml version=\"1.0\"?>";
echo "<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\"
\"http://www.wapforum.org/DTD/wml_1.1.xml\">";
echo "<!-- dj.dance chat raversrule@gmail.com -->\n";
$sid = $_GET["sid"];
echo "<wml>\n";
echo "<card title=\"BuddyLIst\">\n";
echo "<p align=\"left\">";
echo "<small>";
echo "<b>Buddylist</b><br/><br/>";
echo " got no friends huh? if you wish to add someone to your budylist head into any members profile and click on the add to buddylist button<br/><br/> once a request is sent the would be buddy has the choice to accept or decline your request also you can remove a buddy by repeating the above but this time a remove from buddy option will appear<br/><br/> please note that you can only have a maximum of 45 buddys and and the add to buddy request wont show up if that user allready has 35 buddies<br/>";

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