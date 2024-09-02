<?php
header("Content-type: text/vnd.wap.wml");
echo "<?xml version=\"1.0\"?>";
echo "<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\"
\"http://www.wapforum.org/DTD/wml_1.1.xml\">";
echo "<!-- dj.dance chat raversrule@gmail.com -->\n";
$sid = $_GET["sid"];
echo "<wml>\n";
echo "<card title=\"Report Abusement\">\n";
echo "<p align=\"left\">";
echo "<small>";
echo "<b>Report Abusement</b><br/><br/>";
echo "the report topic/post and chat message system is a feature on arawap to help stop spamming, user harassment and other abuse criteria to report anything in this site there are 3 ways of doing this<br/><br/>1. when you receive a pm with lets say abusive language, click on the drop down box named action and select report and press go this will be then reported to mods to be dealt with<br/><br/>2. when viewing a topic there are little stars at the end of every reply click on the very 1st post to report a topic<br/><br/><br/>and just click any of the star at the end of the post you need to report<br/><br/>3. when in the chatroom and you receive a abusive pm for example off somebody sweears at you, simply click on that pm as if you were going to reply and then there will be  a option called expose user, use that to expose the user to the admin/mods in that room<br/><br/>finally please note that spamming links are automatically reported and you might possibly be banned depending on the type of link you are sending to other users<br/>";

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