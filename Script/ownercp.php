<?php
   session_name("PHPSESSID");
session_start();

//session_start();
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\"\"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\">";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";

echo "<head><title>SocialBD</title>";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/style.css\" />";
echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
<meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
<meta name=\"description\" content=\"Chatheaven :)\">
<meta name=\"keywords\" content=\"free, community, forums, chat, wap, communicate\">
<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> </head>";
echo "<body>";
include("config.php");
include("core.php");
include("xhtmlfunctions.php");
connectdb();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$apwd = $_GET["apwd"];
$page = $_GET["page"];
$who = $_GET["who"];
$pmid = $_GET["pmid"];
$whonick = getnick_uid($who);
$byuid = getuid_sid($sid);
$uid = getuid_sid($sid);
$sitename = mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE name='sitename'"));
$sitename = $sitename[0];
$ubrw = explode(" ",$HTTP_USER_AGENT);
$ubrw = $ubrw[0];
$ipad = getip();
if(!isowner(getuid_sid($sid)))
  {
    $pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "You are not an owner<br/>";
      echo "<br/>";
      echo "<a href=\"index.php\">Home</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
if(islogged($sid)==false)
    {$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
	
if(!isloggedtools($uid)){
$pstyle = gettheme($sid);
echo xhtmlhead("Administrator Tools",$pstyle);
	  echo "<card id=\"main\" title=\"Owner Panel\">";
  echo "<p align=\"center\"><small>";
	$nick = getnick_sid($sid);
echo" <center>Sorry <b>$nick</b>, you are not logged in to your site panel.<br/>
Please login in first for use your tools/power<br/><br/>
Tools Pass:<br/>
<form action=\"ownercplogs.php?action=main\" method=\"get\">
<input type=\"password\" name=\"apwd\" format=\"*x\" maxlength=\"35\"/><br/>";
//echo "<postfield name=\"apwd\" value=\"$(apwd)\"/>";
echo "<input type=\"hidden\" name=\"action\" value=\"main\"/>";
echo"<input type=\"submit\" name=\"Submit\" value=\"Login Now\"/><br/>
</form></center>";
  
      echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
    echo "</small></p>";
  echo "</card>";
  echo "</html>";
  exit();
}	
$res = mysql_query("UPDATE dcroxx_me_users SET pid='0' WHERE id='".getuid_sid($sid)."'");
    addonline(getuid_sid($sid),"owner CP","");
if($action=="general")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
    $xtm = getsxtm();
    $paf = getpmaf();
    $fvw = getfview();
    $fmsg = htmlspecialchars(getfmsg());
  $fmsg3 = htmlspecialchars(getfmsg3());
  $fmsg2 = htmlspecialchars(getfmsg2());
    if(canreg())
    {
      $arv = "e";
    }else{
      $arv= "d";
    }
echo "<form action=\"ownerproc.php?action=general\" method=\"post\"><center>";
echo "Session Period: <br/><input name=\"sesp\" format=\"*N\" maxlength=\"3\" size=\"3\ value=\"$xtm\" style=\"height:25px;width: 300px;\"/><br/>";
echo "PM Anti Flood: <br/><input name=\"pmaf\" format=\"*N\" maxlength=\"3\" size=\"3\" value=\"$paf\" style=\"height:25px;width: 300px;\"/><br/>";
  
echo "Main Page Message: <br/><textarea id=\"inputText\" name=\"fmsg\" style=\"height:70px;width: 300px;\" >$fmsg</textarea><br/>";
echo "Login Page Message: <br/><textarea id=\"inputText\" name=\"fmsg2\" style=\"height:70px;width: 300px;\" >$fmsg2</textarea><br/>";
echo "Forum Page Message: <br/><textarea id=\"inputText\" name=\"fmsg3\" style=\"height:70px;width: 300px;\" >$fmsg3</textarea><br/>";

echo "Registration: <br/>";
echo "<select name=\"areg\" value=\"$arv\" style=\"height:25px;width: 300px;\">";
echo "<option value=\"e\">Enabled</option>";
echo "<option value=\"d\">Disabled</option>";
echo "</select><br/>";
echo "View (Style):<br/>";
echo "<select name=\"fvw\" value=\"$fvw\" style=\"height:25px;width: 300px;\">";
  //$vname[0]="Drop Menu";
$vname[0]="Horizontal Links";
$vname[1]="Nothing";
for($i=0;$i<count($vname);$i++){
echo "<option value=\"$i\">$vname[$i]</option>";
}
echo "</select><br/><br/>";
echo "<input type=\"submit\" value=\"SUBMIT\" style=\"height:25px;width: 300px;\"/>";
echo "</center></form>";

  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=ownercp\">Owner cPanel</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p></body>";
    exit();
    }
//////////////////////////////////
else if($action=="addperm")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Add Perm");
    echo "<p align=\"center\">";
    echo "<b>Add permission</b>";
    $forums = mysql_query("SELECT id, name FROM dcroxx_me_forums ORDER BY position, id, name");
    echo "<form action=\"ownerproc.php?action=addperm\" method=\"post\">";
    echo "<br/><br/>Forum: <select name=\"fid\">";
 while ($forum=mysql_fetch_array($forums))
    {
        echo "<option value=\"$forum[0]\">$forum[1]</option>";
    }
    echo "</select>";
    $forums = mysql_query("SELECT id, name FROM dcroxx_me_groups ORDER BY  name, id");
    echo "<br/>UGroups: <select name=\"gid\">";
    while ($forum=mysql_fetch_array($forums))
    {
        echo "<option value=\"$forum[0]\">$forum[1]</option>";
    }
    echo "</select>";
echo "<input type=\"submit\" value=\"Submit\"/>";
echo "</form>";

    echo "<br/><br/><a href=\"index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "owner CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
    exit();
    }
//////////////////////////////////////////////////////////Manage Mods

else if($action=="manmods")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Mods");
    echo "<p align=\"center\">";
    echo "NOTE: Some features will be added later to this page<br/><br/>";
    $mods = mysql_query("SELECT id, name FROM dcroxx_me_users WHERE perm='1'");
    echo "Mod: <select name=\"mid\">";
    while($mod=mysql_fetch_array($mods))
    {
      echo "<option value=\"$mod[0]\">$mod[1]</option>";
    }
    echo "</select><br/>";
    /*
    $forums = mysql_query("SELECT id, name FROM dcroxx_me_forums");
    echo "Forum: <select name=\"fid\">";
    while($forum=mysql_fetch_array($forums))
    {
      echo "<option value=\"$forum[0]\">$forum[1]</option>";
    }
    echo "</select><br/>";
    echo "<anchor>Add";
    echo "<go href=\"ownerproc.php?action=addfmod\" method=\"post\">";
    echo "<postfield name=\"mid\" value=\"$(mid)\"/>";
    echo "<postfield name=\"fid\" value=\"$(fid)\"/>";
    echo "</go>";
    echo "</anchor>";
    */
    echo "<anchor>Add All Forums";
    echo "<go href=\"ownerproc.php?action=addfmod\" method=\"post\">";
    echo "<postfield name=\"mid\" value=\"$(mid)\"/>";
    echo "<postfield name=\"fid\" value=\"*\"/>";
    echo "</go>";
    echo "<br/></anchor>";
    echo "<anchor>Delete All Forums";
    echo "<go href=\"ownerproc.php?action=delfmod\" method=\"post\">";
    echo "<postfield name=\"mid\" value=\"$(mid)\"/>";
    echo "<postfield name=\"fid\" value=\"*\"/>";
    echo "</go>";
    echo "</anchor>";
    //echo "<br/><br/>";
    echo "<br/><br/><a href=\"index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "owner CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
    exit();
    }
//////////////////////////////////
else if($action=="fcats")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Catagories");
    echo "<p>";
    echo "<a href=\"ownercp.php?action=addcat\">&#187;Add Category</a><br/>";
    echo "<a href=\"ownercp.php?action=edtcat\">&#187;Edit Category</a><br/>";
    echo "<a href=\"ownercp.php?action=delcat\">&#187;Delete Category</a><br/>";
    echo "</p>";
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "owner CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
    exit();
    }
//////////////////////////////////

else if($action=="club")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Clubs");
	$clid = $_GET["clid"];
    echo "<p>";
    echo "<a href=\"ownercp.php?action=gccp&amp;clid=$clid\">&#187;Give Credit Plusses</a><br/>";
    echo "<a href=\"ownerproc.php?action=delclub&amp;clid=$clid\">&#187;Delete Club</a><br/>";
    echo "</p>";
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "owner CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
    exit();
    }
//////////////////////////////////
else if($action=="manrss")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Rss");
    echo "<p>";
    echo "<a href=\"ownercp.php?action=addrss\">&#187;Add Source</a><br/>";
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_rss"));
    if($noi[0]>0)
    {echo "<form action=\"ownercp.php?action=edtrss\" method=\"post\">";
        echo "<br/><select name=\"rssid\">";
        while($rs=mysql_fetch_array($rss))
        {
            echo "<option value=\"$rs[1]\">$rs[0]</option>";
        }
      echo "</select><br/>";
echo "<input type=\"submit\" value=\"Edit\"/>";
echo "<form action=\"ownerproc.php?action=delrss\" method=\"post\">";
echo "<br/><select name=\"rssid\">";
while($rs1=mysql_fetch_array($rss1))
        {
            echo "<option value=\"$rs1[1]\">$rs1[0]</option>";
        }
      echo "</select><br/>";
echo "<input type=\"submit\" value=\"Delete\"/>";
echo "<br/>";
echo "</form>";
    }
    echo "</p>";
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "owner CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
    exit();
    }
//////////////////////////////////
else if($action=="chrooms")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Chatrooms");
    echo "<p>";
    echo "<a href=\"ownercp.php?action=addchr\">&#187;Add Room</a><br/>";
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_rooms"));
    if($noi[0]>0)
    {
        $rss = mysql_query("SELECT name, id FROM dcroxx_me_rooms");
        echo "<form action=\"ownerproc.php?action=delchr\" method=\"post\">";
        echo "<br/><select name=\"chrid\">";
        while($rs=mysql_fetch_array($rss))
        {
           $rs0 = htmlspecialchars("$rs[0]");
          $rs1 = htmlspecialchars("$rs[1]");
          echo "<option value=\"$rs1\">$rs0</option>";
        }
      echo "</select><br/>";
echo "<input type=\"submit\" value=\"Delete\"/>";
echo "</form>";

    }
    echo "</p>";
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "owner CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
    exit();
    }
//////////////////////////////////
else if($action=="forums")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
    boxstart("Forums");
    echo "<p>";
    echo "<a href=\"ownercp.php?action=addfrm\">&#187;Add Forum</a><br/>";
    echo "<a href=\"ownercp.php?action=edtfrm\">&#187;Edit Forum</a><br/>";
    echo "<a href=\"ownercp.php?action=delfrm\">&#187;Delete Forum</a><br/>";
    echo "</p>";
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "owner CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
    exit();
    }
//////////////////////////////////
else if($action=="clrdta")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Clear Data");

    echo "<p>";
    echo "<a href=\"ownerproc.php?action=delpms\">&#187;Deleted PMs</a><br/>";
    echo "<a href=\"ownerproc.php?action=clrmlog\">&#187;Clear ModLog</a><br/>";
    echo "<a href=\"ownerproc.php?action=delsht\">&#187;Delete Old Shouts</a><br/>";
    echo "</p>";
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "owner CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
    exit();
    }
//////////////////////////////////
else if($action=="ugroups")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Groups");

    echo "<p>";
    echo "<a href=\"ownercp.php?action=addgrp\">&#187;Add User Group</a><br/>";
    //echo "<a href=\"ownercp.php?action=edtgrp\">&#187;Edit User group</a><br/>";
    echo "<a href=\"ownercp.php?action=delgrp\">&#187;Delete User group</a><br/>";
    echo "</p>";
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "owner CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
    exit();
    }
//////////////////////////////////
else if($action=="addcat")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Catagories");
     echo "<p align=\"center\">";
    echo "<form action=\"ownerproc.php?action=addcat\" method=\"post\">";
    echo "Name:<input name=\"fcname\" maxlength=\"30\"/><br/>";
    echo "Position:<input name=\"fcpos\" format=\"*N\" size=\"3\"  maxlength=\"3\"/><br/>";
echo "<input type=\"submit\" value=\"Add\"/>";
    echo "</form>";
    echo "<br/><br/><a href=\"ownercp.php?action=fcats\">";
  echo "Forum Categories</a><br/>";
    echo "<a href=\"index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "owner CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
    exit();
    }

//////////////////////////////////
else if($action=="addfrm")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
  addonline(getuid_sid($sid),"Owner cp - xHTML:v3","");
                 $id=$_GET["id"];
      echo "<head>\n";
	  echo "<title>Rccwap</title>\n";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/methosprf.css\" />";
	  	  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";
	  echo "</head>";
      echo "<body>";
echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" height=\"12\" width=\"159\">";
echo "<tr>";
echo "<td id=\"body\" width=\"159\">";
echo "</td>";
echo "</tr>";
echo "</table>";

 echo "<table border=\"0\" width=\"99%\" cellspacing=\"0\" cellpadding=\"0\" class=\"boxed\" align=\"center\">";
echo "<tr>";
echo "<td class=\"boxedTitle\" height=\"20\">";
echo "<h1 align=\"center\" class=\"boxedTitleText\">add forum</h1></td>";
echo "</tr>";
echo "<tr>";
echo "<td class=\"boxedContent\">";


    echo "<p align=\"center\">";
	echo "<form action=\"ownerproc.php?action=addfrm\" method=\"post\">\n";
    echo "<b>Add Forum</b><br/><br/>";
    echo "Name:<input name=\"frname\" maxlength=\"30\"/><br/>";
    echo "Position:<input name=\"frpos\" format=\"*N\" size=\"3\"  maxlength=\"3\"/><br/>";
    $fcats = mysql_query("SELECT id, name FROM dcroxx_me_fcats ORDER BY position, id, name");
    echo "Category: <select name=\"fcid\">";
    while ($fcat=mysql_fetch_array($fcats))
    {
        echo "<option value=\"$fcat[0]\">$fcat[1]</option>";
    }
    echo "</select><br/>";
	echo "<input type=\"submit\" value=\"Add\" />\n";
	echo "</form>\n";
				echo "</tr>";
			echo "</table>";
		echo "</div>";
		echo "</div>";

  echo "</div>";
echo "<tr>";
					echo "<td class=\"IL-R\"><small>";
  echo "<p><small>";
  echo "<a href=\"index.php?action=main\">Home</a>";
  echo " &#62; ";
  echo "admin cp";
  echo "</small></p>";

  echo xhtmlfoot();
    exit();
    }
//////////////////////////////////
else if($action=="gccp")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Plusses");
    echo "<p align=\"center\">";
    echo "<b>Add club plusses</b><br/><br/>";
	$clid = $_GET["clid"];
    echo "<form action=\"ownerproc.php?action=gccp&amp;clid=$clid\" method=\"post\">";
    echo "Plusses:<input name=\"plss\" maxlength=\"3\" size=\"3\" format=\"*N\"/><br/>";
echo "<input type=\"submit\" value=\"Give\"/>";
echo "</form>";
    echo "<br/><br/><a href=\"index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "owner CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
    exit();
    }
//////////////////////////////////
else if($action=="addusml")
{
   $pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
    boxstart("Smilies");
    echo "<p align=\"center\">";
    echo "<b>Add Smilies</b><br/><br/>";
    echo "<p align=\"center\">";
    echo "<b>Add User Smilies</b><br/><br/>";
    echo "<form action=\"ownrproc.php?action=addusml\" method=\"post\">";
    echo "Code:<input name=\"smlcde\" maxlength=\"30\"/><br/>";
    echo "Image Source:<input name=\"smlsrc\" value=\"../usersmilies/\" maxlength=\"200\"/><br/>";
    echo "<input type=\"Submit\" Name=\"Submit\" Value=\"Add\"></form>";
  echo "<b>9 </b><a accesskey=\"9\" href=\"ownercp.php?action=ownercp\"><img src=\"../images/admn.gif\" alt=\"\"/>Owner Tools</a><br/>";
  echo "<b>0 </b><a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
     echo "</p>";
    echo "</body>";
boxend();
    exit();
    }
//////////////////////////////////

    
else if($action=="addsml")
{
    echo "<head>";
    echo "<title>Owner Tools</title>";
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
    echo "</head>";
    echo "<body>";
    echo "<p align=\"center\">";
    echo "<b>Add Smilies</b><br/><br/>";
    echo "<form action=\"ownerproc.php?action=addsml\" method=\"post\">";
    echo "Code:<input name=\"smlcde\" maxlength=\"30\"/><br/>";
    echo "Image Source:<input name=\"smlsrc\" value=\"../smilies/\" maxlength=\"200\"/><br/>";
    echo "<input type=\"Submit\" Name=\"Submit\" Value=\"Add\"></form>";
echo"<br/>";
echo "<br/><br/><a href=\"smilies/index.php?action=smilies\">Smilies</a><br/>";
echo "<a href=\"smilies/index.php?action=upload&amp;script=xhtml&amp;prevscript=$script\">Upload</a><br/>";
  echo "<b>9 </b><a accesskey=\"9\" href=\"index.php?action=ownercp\"><img src=\"../images/admn.gif\" alt=\"\"/>Owner Tools</a><br/>";
  echo "<b>0 </b><a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p>";
    echo "</body>";
    exit();
    }

//////////////////////////////////
else if($action=="addavt")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Avatar");
    echo "<p align=\"center\">";
    echo "<b>Add Smilies</b><br/><br/>";
    echo "<form action=\"ownerproc.php?action=addavt\" method=\"post\">";
    echo "Source:<input name=\"avtsrc\" maxlength=\"30\"/><br/>";
    echo "<input type=\"submit\" value=\"Add\"/>";
    echo "</form>";
    echo "<br/><br/><a href=\"index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "owner CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
    exit();
    }
//////////////////////////////////

else if($action=="addrss")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Rss");
    echo "<p align=\"center\">";
    echo "<b>Add RSS</b><br/><br/>";
    echo "<form action=\"ownerproc.php?action=addrss\" method=\"post\">";
    echo "Name:<input name=\"rssnm\" maxlength=\"50\"/><br/>";
    echo "Source:<input name=\"rsslnk\" maxlength=\"255\"/><br/>";
    echo "Image:<input name=\"rssimg\" maxlength=\"255\"/><br/>";
    echo "Description:<input name=\"rssdsc\"  maxlength=\"255\"/><br/>";
    $forums = mysql_query("SELECT id, name FROM dcroxx_me_forums ORDER BY position, id, name");
    echo "Forum: <select name=\"fid\">";
    echo "<option value=\"0\">NO FORUM</option>";
    while ($forum=mysql_fetch_array($forums))
    {
        echo "<option value=\"$forum[0]\">$forum[1]</option>";
    }
    echo "</select><br/>";
echo "<input type=\"submit\" value=\"Add\"/>";
echo "</form>";

    echo "<br/><br/><a href=\"ownercp.php?action=manrss\">";
  echo "<img src=\"images/rss.gif\" alt=\"rss\"/>Manage RSS</a><br/>";
    echo "<a href=\"index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "owner CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
    exit();
    }
//////////////////////////////////

else if($action=="addchr")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Chat Room");
    echo "<p align=\"center\">";
    echo "<b>Add Room</b><br/><br/>";
    echo "<form action=\"ownerproc.php?action=addchr\" method=\"post\">";
    echo "Name:<input name=\"chrnm\" maxlength=\"30\"/><br/>";
    echo "Minimum Age:<input name=\"chrage\" format=\"*N\" maxlength=\"3\" size=\"3\"/><br/>";
    echo "Minimum Chat Posts:<input name=\"chrpst\" format=\"*N\" maxlength=\"4\" size=\"4\"/><br/>";
    echo "Permission:<select name=\"chrprm\">";
    echo "<option value=\"0\">Normal</option>";
    echo "<option value=\"1\">Moderators</option>";
    echo "<option value=\"2\">admin</option>";
echo "<option value=\"3\">head admin</option>";
    echo "<option value=\"4\">Owners</option>";
    echo "</select><br/>";
echo "VIP: <select name=\"specialid\" value=\"$specialid[0]\">";
    echo "<option value=\"0\">Normal</option>";
    echo "<option value=\"1\">Millionaire</option>";
    echo "<option value=\"2\">Quiz Masters</option>";
    echo "<option value=\"8\">Prince</option>";
    echo "<option value=\"9\">Princess</option>";
    echo "</select><br/>";
    echo "Censored:<select name=\"chrcns\">";
    echo "<option value=\"1\">Yes</option>";
    echo "<option value=\"0\">No</option>";
    echo "</select><br/>";
    echo "Fun:<select name=\"chrfun\">";
    echo "<option value=\"0\">No</option>";
    echo "<option value=\"1\">esreveR</option>";
    echo "<option value=\"2\">Fun Babe</option>";
    echo "</select><br/>";
echo "<input type=\"submit\" value=\"Add\"/>";
    echo "<form>";
    echo "<br/><br/><a href=\"ownercp.php?action=chrooms\">";
  echo "<img src=\"images/chat.gif\" alt=\"chat\"/>Chatrooms</a><br/>";
    echo "<a href=\"index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "owner CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
    exit();
    }
//////////////////////////////////

else if($action=="edtrss")
{$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
  boxstart("Rss");
  $rssid = $_POST["rssid"];
  $rsinfo = mysql_fetch_array(mysql_query("SELECT title, link, imgsrc, fid, dscr FROM dcroxx_me_rss WHERE id='".$rssid."'"));
    echo "<form action=\"ownerproc.php?action=edtrss\" method=\"post\">";
    echo "Name:<input name=\"rssnm\" maxlength=\"50\" value=\"$rsinfo[0]\"/><br/>";
    echo "Source:<input name=\"rsslnk\" maxlength=\"255\" value=\"$rsinfo[1]\"/><br/>";
    echo "Image:<input name=\"rssimg\" maxlength=\"255\" value=\"$rsinfo[2]\"/><br/>";
    echo "Description:<input name=\"rssdsc\"  maxlength=\"255\" value=\"$rsinfo[4]\"/><br/>";
    $forums = mysql_query("SELECT id, name FROM dcroxx_me_forums ORDER BY position, id, name");
    echo "Forum: <select name=\"fid\" value=\"$rsinfo[3]\">";
    echo "<option value=\"0\">NO FORUM</option>";
    while ($forum=mysql_fetch_array($forums))
    {
        echo "<option value=\"$forum[0]\">$forum[1]</option>";
    }
    echo "</select><br/>";
echo "<input type=\"submit\" value=\"Edit\"/>";
echo "<input type=\"hidden\" name=\"fid\" value=\"$fid\"/>";
echo "<input type=\"hidden\" name=\"rssid\" value=\"$rssid\"/>";
echo "</form>";
    echo "<br/><br/><a href=\"ownercp.php?action=manrss\">";
  echo "<img src=\"images/rss.gif\" alt=\"rss\"/>Manage RSS</a><br/>";
    echo "<a href=\"index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "owner CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
    exit();
    }
//////////////////////////////////
else if($action=="addgrp")
{boxstart("Goup");
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
    echo "<p align=\"center\">";
    echo "<b>Add Group</b><br/><br/>";
    echo "<form action=\"ownerproc.php?action=addgrp\" method=\"post\">";
    echo "Name:<input name=\"ugname\" maxlength=\"30\"/><br/>";
    echo "Auto Assign:<select name=\"ugaa\">";
    echo "<option value=\"1\">Yes</option>";
    echo "<option value=\"0\">No</option>";
    echo "</select><br/>";
    echo "<br/><small><b>For Auto Assign Only</b></small><br/>";
    echo "Allow:<select name=\"allus\">";
    echo "<option value=\"0\">Normal Users</option>";
    echo "<option value=\"1\">Mods</option>";
    echo "<option value=\"2\">admin</option>";
echo "<option value=\"3\">head admin</option>";
    echo "<option value=\"4\">Owners</option>";
    echo "</select><br/>";
    echo "Min. Age:";
    echo "<input name=\"mage\" format=\"*N\" maxlength=\"3\" size=\"3\"/>";
    echo "<br/>Min. Posts:";
    echo "<input name=\"mpst\" format=\"*N\" maxlength=\"3\" size=\"3\"/>";
    echo "<br/>Min. Plusses:";
    echo "<input name=\"mpls\" format=\"*N\" maxlength=\"3\" size=\"3\"/><br/>";
echo "<input type=\"submit\" value=\"Add\"/>";
echo "</form>";
    echo "<br/><br/><a href=\"ownercp.php?action=ugroups\">";
  echo "UGroups</a><br/>";
    echo "<a href=\"index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "owner CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
    exit();
    }
//////////////////////////////////

else if($action=="edtfrm")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Forum");
    echo "<p align=\"center\">";
    echo "<b>Edit Forum</b><br/><br/>";
    $forums = mysql_query("SELECT id,name FROM dcroxx_me_forums ORDER BY position, id, name");
    echo "<form action=\"ownerproc.php?action=edtfrm\" method=\"post\">";
    echo "Forum: <select name=\"fid\">";
    while($forum=mysql_fetch_array($forums))
    {
      echo "<option value=\"$forum[0]\">$forum[1]</option>";
    }
    echo "</select>";
    echo "<br/>Name:<input name=\"frname\" maxlength=\"30\"/><br/>";
    echo "Position:<input name=\"frpos\" format=\"*N\" size=\"3\"  maxlength=\"3\"/><br/>";
    $fcats = mysql_query("SELECT id, name FROM dcroxx_me_fcats ORDER BY position, id, name");
    echo "Category: <select name=\"fcid\">";
    while ($fcat=mysql_fetch_array($fcats))
    {
        echo "<option value=\"$fcat[0]\">$fcat[1]</option>";
    }
    echo "</select><br/>";
echo "<input type=\"submit\" value=\"Edit\"/>";
echo "</form>";
    echo "<br/><br/><a href=\"ownercp.php?action=forums\">";
  echo "Forums</a><br/>";
    echo "<a href=\"index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "owner CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
    exit();
    }
//////////////////////////////////
else if($action=="delfrm")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Forum");
    echo "<p align=\"center\">";
    echo "<b>Delete Forum</b><br/><br/>";
    $forums = mysql_query("SELECT id,name FROM dcroxx_me_forums ORDER BY position, id, name");
   echo "<form action=\"ownerproc.php?action=delfrm\" method=\"post\">";
    echo "Forum: <select name=\"fid\">";
    while($forum=mysql_fetch_array($forums))
    {
      $forum0 = htmlspecialchars("$forum[0]");
      $forum1 = htmlspecialchars("$forum[1]");
         echo "<option value=\"$forum0\">$forum1</option>";
    }
    echo "</select><br/>";
echo "<input type=\"submit\" value=\"Delete\"/>";
    echo "</form>";

    echo "<br/><br/><a href=\"ownercp.php?action=forums\">";
  echo "Forums</a><br/>";
    echo "<a href=\"index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "owner CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
    exit();
    }
//////////////////////////////////
else if($action=="delgrp")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Group");
    echo "<p align=\"center\">";
    echo "<b>Delete UGroup</b><br/><br/>";
    $forums = mysql_query("SELECT id,name FROM dcroxx_me_groups ORDER BY name, id");
    echo "<form action=\"ownerproc.php?action=delgrp\" method=\"post\">";
    echo "UGroup: <select name=\"ugid\">";
    while($forum=mysql_fetch_array($forums))
    {
      echo "<option value=\"$forum[0]\">$forum[1]</option>";
    }
    echo "</select><br/>";
echo "<input type=\"submit\" value=\"Delete\"/>";
echo "</form>";
    echo "<br/><br/><a href=\"ownercp.php?action=forums\">";
  echo "Forums</a><br/>";
    echo "<a href=\"index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "owner CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
    exit();
    }
//////////////////////////////////
else if($action=="edtcat")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Catagories");
    echo "<p align=\"center\">";
    echo "<b>Edit Category</b><br/><br/>";
    $fcats = mysql_query("SELECT id, name FROM dcroxx_me_fcats ORDER BY position, id, name");
    echo "<form action=\"ownerproc.php?action=edtcat\" method=\"post\">";
    echo "Edit: <select name=\"fcid\">";
    while ($fcat=mysql_fetch_array($fcats))
    {
        echo "<option value=\"$fcat[0]\">$fcat[1]</option>";
    }
    echo "</select><br/>";
    echo "Name:<input name=\"fcname\" maxlength=\"30\"/><br/>";
    echo "Position:<input name=\"fcpos\" format=\"*N\" size=\"3\"  maxlength=\"3\"/><br/>";
echo "<input type=\"submit\" value=\"Edit\"/>";
echo "</form>";
    echo "<br/><br/><a href=\"ownercp.php?action=fcats\">";
  echo "Forum Categories</a><br/>";
    echo "<a href=\"index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "owner CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
}else if($action=="delcat")
{boxstart("Catagories");
    echo "<p align=\"center\">";
    echo "<b>Delete Category</b><br/><br/>";
    $fcats = mysql_query("SELECT id, name FROM dcroxx_me_fcats ORDER BY position, id, name");
    echo "<form action=\"ownerproc.php?action=delcat\" method=\"post\"/>";
    echo "Delete: <select name=\"fcid\">";

    while ($fcat=mysql_fetch_array($fcats))
    {
        echo "<option value=\"$fcat[0]\">$fcat[1]</option>";
    }
    echo "</select><br/>";
echo "<input type=\"submit\" value=\"Delete\"/>";
    echo "</form>";

    echo "<br/><br/><a href=\"ownercp.php?action=fcats\">";
  echo "Forum Categories</a><br/>";
    echo "<a href=\"index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "owner CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
    exit();
    }
//////////////////////////////////user info

else if($action=="chuinfo")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Change User Info");
    echo "<p align=\"center\">";
    echo "Type user nickname<br/><br/>";
   echo "<form action=\"ownercp.php?action=acui\" method=\"post\">";
    echo "User: <input name=\"unick\" format=\"*x\" maxlength=\"15\"/><br/>";
echo "<input type=\"submit\" value=\"find\"/>";
echo "</form>";
    echo "<br/><br/><a href=\"index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "owner CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
    exit();
    }
//////////////////////////////////user info

else if($action=="delinfo")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Change User Info");
    echo "<p align=\"center\">";
    echo "Delete User Info<br/><br/>";
 echo "<a href=\"ownerproc.php?action=delshout&amp;who=$who\">Delete Shout Of This User</a><br/>";
 echo "<a href=\"ownerproc.php?action=delbuddies&amp;who=$who\">Delete Buddies Of This User</a><br/>";
 echo "<a href=\"ownerproc.php?action=delgb&amp;who=$who\">Delete GB Of This User</a><br/>";
 echo "<a href=\"ownerproc.php?action=delignore&amp;who=$who\">Delete Ignore Of This User</a><br/>";
 echo "<a href=\"ownerproc.php?action=delmangr&amp;who=$who\">Delete Mangr Of This User</a><br/>";
 echo "<a href=\"ownerproc.php?action=delmodr&amp;who=$who\">Delete Modrl Of This User</a><br/>";
 echo "<a href=\"ownerproc.php?action=delpenalties&amp;who=$who\">Delete Penalties Of This User</a><br/>";
echo "<a href=\"ownerproc.php?action=delposts&amp;who=$who\">Delete Posts Of This User</a><br/>";
 echo "<a href=\"ownerproc.php?action=delpopups&amp;who=$who\">Delete Popups Of This User</a><br/>";
 echo "<a href=\"ownerproc.php?action=deltopics&amp;who=$who\">Delete Topics Of This User</a><br/>";
 echo "<a href=\"ownerproc.php?action=delgames&amp;who=$who\">Delete Games Of This User</a><br/>";
 echo "<a href=\"ownerproc.php?action=delpresults&amp;who=$who\">Delete presults Of This User</a><br/>";
 echo "<a href=\"ownerproc.php?action=delvault&amp;who=$who\">Delete vault Of This User</a><br/>"; 
echo "<a href=\"ownerproc.php?action=delchat&amp;who=$who\">Delete chat Of This User</a><br/>";
 echo "<a href=\"ownerproc.php?action=delchat2&amp;who=$who\">Delete chat Of This User</a><br/>";
 echo "<a href=\"ownerproc.php?action=delxinfo&amp;who=$who\">Delete xinfo Of This User</a><br/>";
 echo "<a href=\"ownerproc.php?action=delses&amp;who=$who\">Delete ses Of This User</a><br/>";
 echo "<a href=\"ownerproc.php?action=delonline&amp;who=$who\">Delete online Of This User</a><br/>";
 echo "<a href=\"ownerproc.php?action=delchonline&amp;who=$who\">Delete chonline Of This User</a><br/>";
 echo "<a href=\"ownerproc.php?action=delblog&amp;who=$who\">Delete Blogs Of This User</a><br/>";
echo "<a href=\"ownerproc.php?action=delblogs&amp;who=$who\">Delete blogs Of This User</a><br/>";
  echo "<a href=\"ownerproc.php?action=delxp&amp;who=$tid\">&#187;Delete $unick's posts</a><br/>";


 echo "<a href=\"ownerproc.php?action=REMOVEPNREASON&amp;who=$who\">Remove Last penalty Reason</a><br/>";
    echo "<br/><br/><a href=\"index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "owner CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
    exit();
    }
///////////////////////////////////////////////////////Change User info

else if($action=="acui")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("Change User Info");
    echo "<p align=\"center\">";
    $unick = $_POST["unick"];
    $tid = getuid_nick($unick);
    if($tid==0)
    {
      echo "<img src=\"images/notok.gif\" alt=\"x\"/>User Does Not exist<br/>";
    }else{
      echo "</p>";
      echo "<p>";
      echo "<a href=\"ownercp.php?action=chubi&amp;who=$tid\">&#187;$unick's Profile</a><br/>";
      $judg = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_judges WHERE uid='".$tid."'"));
      if($judg[0]>0)
      {
      echo "<a href=\"ownerproc.php?action=deljdg&amp;who=$tid\">&#187;Remove $unick From Judges List</a><br/>";
      }else{
        echo "<a href=\"ownerproc.php?action=addjdg&amp;who=$tid\">&#187;Make $unick judge</a><br/>";
      }
echo "<a href=\"ownercp.php?action=delinfo&amp;who=$tid\">&#187;Delete user Info</a><br/>";
      //echo "<a href=\"ownercp.php?action=addtog&amp;who=$tid\">&#187;Add  $unick to a group</a><br/>";
      //echo "<a href=\"ownercp.php?action=umset&amp;who=$tid\">&#187;$unick's Mod. Settings</a><br/>";
	      echo "<a href=\"ownerproc.php?action=delu&amp;who=$tid\">&#187;Delete $unick</a><br/>";
echo "<a href=\"lists.php?action=readmsgs&amp;who=$tid\">&#187;Read Send Messages</a><br/>";


 echo "<a href=\"ownerproc.php?action=dodajvip&amp;who=$tid\">&#187;Add $unick Vip Status</a><br/>";
           echo "<a href=\"ownerproc.php?action=skinivip&amp;who=$tid\">&#187;Remove $unick Vip Status</a><br/>";
   
      echo "</p>";
 echo "<br/><br/>";
	echo "<form action=\"ownerproc.php?action=upwd&amp;who=$who\" method=\"post\">\n";
    echo "Password: <input name=\"npwd\" maxlength=\"15\"/><br/>";
	echo "<input type=\"submit\" value=\"Change\" />\n";
	echo "</form>\n";
      echo "<p align=\"center\">";
    }
    echo "<a href=\"ownercp.php?action=chuinfo\">";
  echo "Users Info</a><br/>";
    echo "<a href=\"index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "owner CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
    exit();
    }
///////////////////////////////////////////////////////////////

else if($action=="chubi")
{
$pstyle = gettheme($sid);
    echo xhtmlhead("$stitle",$pstyle);
boxstart("User Details");

    $who = $_GET["who"];
    $unick = getnick_uid($who);
    echo "<onevent type=\"onenterforward\">";
    $avat = getavatar($who);
    $email = mysql_fetch_array(mysql_query("SELECT email FROM dcroxx_me_users WHERE id='".$who."'"));
    $site = mysql_fetch_array(mysql_query("SELECT site FROM dcroxx_me_users WHERE id='".$who."'"));
    $bdy = mysql_fetch_array(mysql_query("SELECT birthday FROM dcroxx_me_users WHERE id='".$who."'"));
    $uloc = mysql_fetch_array(mysql_query("SELECT location FROM dcroxx_me_users WHERE id='".$who."'"));
    $usig = mysql_fetch_array(mysql_query("SELECT signature FROM dcroxx_me_users WHERE id='".$who."'"));
    $sx = mysql_fetch_array(mysql_query("SELECT sex FROM dcroxx_me_users WHERE id='".$who."'"));
    $perm = mysql_fetch_array(mysql_query("SELECT perm FROM dcroxx_me_users WHERE id='".$who."'"));
     $specialid = mysql_fetch_array(mysql_query("SELECT specialid FROM dcroxx_me_users WHERE id='".$who."'"));

 echo "<refresh>
        <setvar name=\"unick\" value=\"$unick\"/>
        <setvar name=\"savat\" value=\"$avat\"/>
        <setvar name=\"semail\" value=\"$email[0]\"/>
        <setvar name=\"usite\" value=\"$site[0]\"/>
        <setvar name=\"ubday\" value=\"$bdy[0]\"/>
        <setvar name=\"uloc\" value=\"$uloc[0]\"/>
        <setvar name=\"usig\" value=\"$usig[0]\"/>
        <setvar name=\"sx\" value=\"$sx[0]\"/>
        <setvar name=\"perm\" value=\"$perm[0]\"/>
        <setvar name=\"npwd\" value=\"\"/>
   ";

    echo "<form action=\"ownerproc.php?action=uprof&amp;who=$who\" method=\"post\">";
    echo "Nickname: <input name=\"unick\" maxlength=\"15\" value=\"$unick\"/><br/>";
    echo "Avatar: <input name=\"savat\" maxlength=\"100\" value=\"$avat\"/><br/>";
    echo "E-Mail: <input name=\"semail\" maxlength=\"100\" value=\"$email[0]\"/><br/>";
    echo "Site: <input name=\"usite\" maxlength=\"100\" value=\"$site[0]\"/><br/>";
    echo "Birthday<small>(YYYY-MM-DD)</small>: <input name=\"ubday\" maxlength=\"50\" value=\"$bdy[0]\"/><br/>";
    echo "Location: <input name=\"uloc\" maxlength=\"50\" value=\"$uloc[0]\"/><br/>";
    echo "Signature: <input name=\"usig\" maxlength=\"100\" value=\"$usig[0]\"/><br/>";
    echo "Sex: <select name=\"usex\" value=\"$sx[0]\">";
    echo "<option value=\"M\">Male</option>";
    echo "<option value=\"F\">Female</option>";
    echo "</select><br/>";

 
    echo "Privileges: <select name=\"perm\" value=\"$perm[0]\">";
    echo "<option value=\"0\">Normal</option>";
       echo "<option value=\"1\">Moderator</option>";
  echo "<option value=\"2\">Admin</option>";
echo "<option value=\"3\">Head Admin</option>";
echo "<option value=\"4\">Owner</option>";
if ($uid==1){
echo "<option value=\"6\">Staff Controller</option>";
echo "<option value=\"5\">Programmer n Security Executive</option>";
}else{}
  echo "</select><br/>";

    echo "VIP: <select name=\"specialid\" value=\"$specialid[0]\">";
     echo "<option value=\"0\">Normal</option>";
    echo "<option value=\"1\">Millionaire</option>";
    echo "<option value=\"2\">Quiz Masters</option>";
    echo "<option value=\"8\">Prince</option>";
    echo "<option value=\"9\">Princess</option>";
    echo "<option value=\"10\">Upcoming Star</option>";
    echo "<option value=\"11\">Super Star</option>";
    echo "<option value=\"12\">Reaper</option>";
    echo "<option value=\"13\">Director</option>";
    echo "<option value=\"14\">Spy</option>";
    echo "<option value=\"15\">Killer!</option>";
    echo "<option value=\"16\">Assassin!</option>";
    echo "<option value=\"17\">Partner</option>";
    echo "</select><br/>";
	echo "<input type=\"submit\" value=\"Update\" />\n";
	echo "</form>\n";

 echo "<br/><br/>";
	echo "<form action=\"ownerproc.php?action=upwd&amp;who=$who\" method=\"post\">\n";
    echo "Password: <input name=\"npwd\" maxlength=\"15\"/><br/>";
	echo "<input type=\"submit\" value=\"Change\" />\n";
	echo "</form>\n";
    echo "</p>";
    echo "<p align=\"center\">";
    echo "<a href=\"ownercp.php?action=chuinfo\">";
  echo "Users Info</a><br/>";
    echo "<a href=\"index.php?action=ownercp\"><img src=\"images/admn.gif\" alt=\"*\"/>";
  echo "owner CP</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
    echo "</body>";
    exit();
    }
//////////////////////////////////
else{
   echo "<p align=\"center\">";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></body>";
    exit();
    }

?>
</html>
