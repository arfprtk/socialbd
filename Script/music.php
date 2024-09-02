<?php
      session_name("PHPSESSID");
session_start();

header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";
?>
<wml>
<?php
include("config.php");
include("core.php");
connectdb();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
if(!ismod(getuid_sid($sid)))
  {
    echo "<card id=\"main\" title=\"$stitle\">";
      echo "<p align=\"center\">";
      echo "You are not a mod<br/>";
      echo "<br/>";
      echo "<a href=\"index.php\">Home</a>";
      echo "</p>";
      echo "</card>";
      exit();
    }
if(islogged($sid)==false)
    {
        echo "<card id=\"main\" title=\"$stitle\">";
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
      echo "</card>";
    }///////////////////////////////GOLDLINEHOST//////////BY GLH WEB CREATION/////////
	if(!isowner(getuid_sid($sid)))
  {

      echo "<p align=\"center\">";
      echo "You are not an owner<br/>";
      echo "<br/>";
      echo "<a href=\"index.php\">Home</a>";
      echo "</p>";
      exit();
    }
    addonline(getuid_sid($sid),"Mod CP","");
if($action=="addmus")
{
echo "<card id=\"main\" title=\"Music panel\">";
echo "<p align=\"center\">";
echo "<b>Add Music</b><br/><br/>";
echo "<b>Music Title</b><br/>";
echo "<input name=\"title\"/><br/>";

echo "Link Music:<input name=\"musiclink\" maxlength=\"200\"/><br/>";
echo "<anchor>ADD";
echo "<go href=\"music.php?action=addmus2\" method=\"post\">";
echo "<postfield name=\"musiclink\" value=\"$(musiclink)\"/>";
echo "<postfield name=\"title\" value=\"$(title)\"/>";
echo "</go></anchor>";
echo "<br/><br/><a href=\"Index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
echo "Owner panel</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "HAPPY</a>";
echo "</p>";
echo "</card>";
}

else if($action=="addmus2")
{
$title = $_POST["title"];

$musiclink = $_POST["musiclink"];
echo "<card id=\"main\" title=\"HAPPY Forum\">";
echo "<p align=\"center\">";
echo "<br/>";
$res = mysql_query("INSERT INTO dcroxx_me_music SET title='".$title."', musiclink='".$musiclink."'");

if($res)
{
echo "<img src=\"images/ok.gif\" alt=\"O\"/>Music Added!";
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error adding music!";
}

echo "<br/><br/><a href=\"music.php?action=addmus#\">";
echo "Add more Music</a><br/>";
echo "<a href=\"index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
echo "Owner panel</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "HAPPY</a>";

echo "</p></card>";
}
else{
    echo "<card id=\"main\" title=\"Mod CP\">";
  echo "<p align=\"center\">";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}
?></html>