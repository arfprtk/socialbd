<?php
header("Content-type: text/vnd.wap.wml");
echo "<?xml version=\"1.0\"?>";
echo "<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\"
\"http://www.wapforum.org/DTD/wml_1.1.xml\">";
echo "<!-- dj.dance chat raversrule@gmail.com -->\n";
$sid = $_GET["sid"];
echo "<wml>\n";
echo "<card title=\"Smilies\">\n";
echo "<p align=\"left\">";
echo "<small>";
echo "<b>Smilies</b><br/><br/>";
echo " Wanna make your chat and forum posts more animated? Then why not make use of Smilies! you don't know how?! Well, nevermind.you ain't at the Help Menu 4 nuthing<br/><br/> Just click on cpanel,scroll down to smilies,click on it.U will now see the smilies with codes on the left hand side of them.Learn off the codes<br/><br/>To add the smilies to your posts or pm's,just write out the code and .....VOILA!<br/><br/>Please do not misuse the smilies,only 2 smilies are allowed per post, you can make use of more smilies in ur private mesages.Smilies do not come out in Shoutbox and in Guestbooks<br/><br/>One last thing, posting just a smilie in forums without writing anything constitutes fraud at arawap. You will b warned and penalized. If u do not take heed to the warnings,u WILL be banned!<br/>";

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