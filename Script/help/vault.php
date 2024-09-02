<?php
header("Content-type: text/vnd.wap.wml");
echo "<?xml version=\"1.0\"?>";
echo "<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\"
\"http://www.wapforum.org/DTD/wml_1.1.xml\">";
echo "<!-- dj.dance chat raversrule@gmail.com -->\n";
$sid = $_GET["sid"];
echo "<wml>\n";
echo "<card title=\"Vault\">\n";
echo "<p align=\"left\">";
echo "<small>";
echo "<b>Vault</b><br/><br/>";
echo "The vault is located in your CPanel, its an easy way to share your already uploaded files, with the users of arawap. <br/><br/>Simply go to CPanel, then select vault, and then add item. Enter a name for the file you are adding, then below it enter the adress (url) of the file you want to add, like this, http://mysite.com/myfile.mp3<br/><br/>Everything that is added in the vault will appear in your profile, aswell as in the Downloads link of the forum index. Added files that dont work or that leads to a dead link will be deleted without notice<br/>";
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