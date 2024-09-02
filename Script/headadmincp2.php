<?php
session_name("PHPSESSID");
session_start();

include("xhtmlfunctions.php");
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";

?>

<?php
include("config.php");
include("core.php");
connectdb();

$action = $_GET["action"];
$sid = $_SESSION['sid'];
$page = $_GET["page"];

$uid = getuid_sid($sid);

if(!isheadadmin(getuid_sid($sid)))
{
echo "<card id=\"main\" title=\"Error!!!\">";
echo "<p align=\"center\"><small>";
echo "<b>permission Denied!</b><br/>";
echo "<br/>Only head admin can use this page...<br/>";
echo "<a href=\"index.php\">Home</a>";
echo "</small></p>";
echo "</card>";
echo "</wml>";
exit();
}

if(islogged($sid)==false)
{
echo "<card id=\"main\" title=\"Error!!!\">";
echo "<p align=\"center\"><small>";
echo "You are not logged in<br/>";
echo "Or Your session has been expired<br/><br/>";
echo "<a href=\"index.php\">Login</a>";
echo "</small></p>";
echo "</card>";
echo "</wml>";
exit();
}

addonline(getuid_sid($sid),"Vice President Tools","");

//////////////////////////Vice President Tools//////////////////////////

/////////////////////////////////Vice President Tools
if($action=="headadmincp")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
addonline(getuid_sid($sid),"Vice President Tools","");
echo "<card id=\"main\" title=\"Head Admin Tools\">";
echo "<p align=\"center\"><small>";
echo "<b>Head Admin Tools</b>";
echo "</small></p>";
echo "<p><small>";
if(isheadadmin(getuid_sid($sid)))
{
$noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_penalties WHERE penalty='1' OR penalty='2'"));
echo "<a href=\"lists.php?action=banned\">Banned($noi[0])</a><br/>";
$noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_penalties WHERE penalty='0'"));
echo "<a href=\"lists.php?action=trashed\">Trashed($noi[0])</a><br/>";
$noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_penalties WHERE penalty='2'"));
echo "<a href=\"lists.php?action=ipban\">Banned IPs($noi[0])</a><br/>";
$noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE validated='0'"));
echo "<a href=\"headadmincp2.php?action=validatelist\">Validate List($noi[0])</a><br/>";


  $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_disable_shout"));
if($noi[0]==1){
echo "<a href=\"md.php?action=enablesht\">Enable Shout</a><br/>";
}else{
echo "<a href=\"md.php?action=disablesht\">Disable Shout</a><br/>";
}

//echo "<a href=\"web/soulznet_logs/soulznet_web_login.txt\">User Logins</a><br/>";
//echo "<a href=\"headadmincp2.php?action=general\">&#187;General Settings</a><br/>";
/*echo "<a href=\"admincp2.php?action=fcats\">&#187;Forum Categories</a><br/>";
echo "<a href=\"admincp2.php?action=forums\">&#187;Forums</a><br/>";
//echo "<a href=\"admincp2.php?action=ugroups\">&#187;User groups</a><br/>";
//echo "<a href=\"headadmincp2.php?action=manmods\">&#187;Manage Moderators</a><br/>";
//echo "<a href=\"headadmincp2.php?action=addpRmxX\">&#187;Add permissions</a><br/>";
//echo "<a href=\"headadmincp2.php?action=chuinfo\">&#187;Change user info</a><br/>";
//echo "<a href=\"headadmincp2.php?action=manrss\">&#187;Manage RSS Sources</a><br/>";
//echo "<a href=\"../users/themes.php?sid=$sid\">&#187;Add P.W.S. Theme</a><br/>";
echo "<a href=\"add_smilies.php\">&#187;Add Smilies</a><br/>";
//echo "<a href=\"headadmincp2.php?action=addavt\">&#187;Add Avatar</a><br/>";
//echo "<a href=\"headadmincp2.php?action=blocksites\">&#187;Edit Blocked Sites</a><br/>";
echo "<a href=\"admincp2.php?action=chrooms\">&#187;Chatrooms</a><br/>";
//echo "<a href=\"headadmincp2.php?action=clrdta\">&#187;Clear Data</a><br/>";
*/
echo"<br/>";
    echo "<a href=\"headadmincp.php?action=general\">&#187;General Settings</a><br/>";
    echo "<a href=\"headadmincp.php?action=fcats\">&#187;Forum Categories</a><br/>";
    echo "<a href=\"headadmincp.php?action=forums\">&#187;Forums</a><br/>";
            echo "<a href=\"headadmincp.php?action=ugroups\">&#187;User groups</a><br/>";
    echo "<a href=\"headadmincp.php?action=addperm\">&#187;Add permissions</a><br/>";
    //echo "<a href=\"headadmincp.php?action=chuinfo\">&#187;Change user info</a><br/>";
    echo "<a href=\"headadmincp.php?action=manrss\">&#187;Manage RSS Sources</a><br/>";
      //  echo "<a href=\"users/themes.php?sid=$sid\">&#187;Add Theme</a><br/>";
    echo "<a href=\"add_smilies.php\">&#187;Add Smilies</a><br/>";
    echo "<a href=\"headadmincp.php?action=addavt\">&#187;Add Avatar</a><br/>";
    echo "<a href=\"headadmincp.php?action=chrooms\">&#187;Chatrooms</a><br/>";
      echo "<a href=\"headadmincp.php?action=clrdta\">&#187;Clear Data</a><br/>";




echo "<br/>";
}else{
echo "You are not S.admin";
}
echo "</small></p>";
echo "<p align=\"center\"><small>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p>";
echo "</card>";
}

else if($action=="general")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
echo "<card id=\"main\" title=\"Vice President Tools\">";
$xtm = getsxtm();
$paf = getpmaf();
$fvw = getfview();
$fmsg = htmlspecialchars(getfmsg());
$sitename = mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE name='sitename'"));
$sitename = $sitename[0];
if(canreg())
{
$arv = "e";
}else{
$arv= "d";
}
if(validation())
{
$vldtn = "e";
}else{
$vldtn= "d";
}
echo "<onevent type=\"onenterforward\">";
echo "<refresh>
<setvar name=\"sitename\" value=\"$sitename\"/>
<setvar name=\"sesp\" value=\"$xtm\"/>
<setvar name=\"pmaf\" value=\"$paf\"/>
<setvar name=\"fmsg\" value=\"$fmsg\"/>
<setvar name=\"areg\" value=\"$arv\"/>
<setvar name=\"fvw\" value=\"$fvw\"/>
<setvar name=\"vldtn\" value=\"$vldtn\"/>
";
echo "</refresh></onevent>";
echo "<p align=\"center\"><small>";
echo "<b>General Settings</b><br/>";
echo "</small></p>";
echo "<p><small>";
echo "Site Name:";
echo "<input name=\"sitename\" maxlength=\"255\"/>";
echo "<br/>Session Period: ";
echo "<input name=\"sesp\" format=\"*N\" maxlength=\"3\" size=\"3\"/>";
echo "<br/>PM Antiflood<input name=\"pmaf\" format=\"*N\" maxlength=\"3\" size=\"3\"/>";
echo "<br/>Forum Message: ";
echo "<input name=\"fmsg\"  maxlength=\"255\" />";
echo "<br/>Registration: ";
echo "<select name=\"areg\" value=\"$arv\">";
echo "<option value=\"e\">Enabled</option>";
echo "<option value=\"d\">Disabled</option>";
echo "</select><br/>";
echo "View:";
echo "<select name=\"fvw\" value=\"$fvw\">";
$vname[0]="Forums Page";
$vname[1]="Forums";
$vname[2]="Categories";
$vname[3]="Drop List";
for($i=0;$i<count($vname);$i++)
{
echo "<option value=\"$i\">$vname[$i]</option>";
}

echo "</select>";
echo "<br/>Validation: <select name=\"vldtn\" value=\"$vldtn\">";
echo "<option value=\"e\">Enabled</option>";
echo "<option value=\"d\">Disabled</option>";
echo "</select><br/>";
echo "
<br/><anchor>Submit
<go href=\"headadminproc2.php?action=general\" method=\"post\">
<postfield name=\"sitename\" value=\"$(sitename)\"/>
<postfield name=\"sesp\" value=\"$(sesp)\"/>
<postfield name=\"fmsg\" value=\"$(fmsg)\"/>
<postfield name=\"areg\" value=\"$(areg)\"/>
<postfield name=\"pmaf\" value=\"$(pmaf)\"/>
<postfield name=\"fvw\" value=\"$(fvw)\"/>
<postfield name=\"vldtn\" value=\"$(vldtn)\"/>
</go></anchor>
";
echo "</small></p>";
echo "<p align=\"center\"><small>";
echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p></card>";
}
//////////////////////////mod a user//////////////////////////

else if($action=="user")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
$who = $_GET["who"];
echo "<card id=\"main\" title=\"Vice President Tools\">";
echo "<p align=\"center\"><small>";
$unick = getnick_uid($who);
  $unck = $who;
echo "<b>Moderating $unick</b>";
echo "</small></p>";
echo "<p align=\"left\"><small>";

 echo "<a href=\"md.php?action=penalties&amp;who=$who\">&#187;Penalties</a><br/>";
  if(isbanned($who)){
  echo "<a href=\"md.php?action=penalties_with&amp;who=$who&amp;cat=unban\">&#187;Penalties Remove</a> [General Un-Banned]<br/>";
  }else{}
  if(ispmbaned($who)){
  echo "<a href=\"md.php?action=penalties_with&amp;who=$who&amp;cat=pmunban\">&#187;Penalties Remove</a> [PM Un-Banned]<br/>";
  }else{}
  if(ispostbaned($who)){
  echo "<a href=\"md.php?action=penalties_with&amp;who=$who&amp;cat=postunban\">&#187;Penalties Remove</a> [Post Un-Banned]<br/>";
  }else{}
  if(isshoutbaned($who)){
  echo "<a href=\"md.php?action=penalties_with&amp;who=$who&amp;cat=shoutunban\">&#187;Penalties Remove</a> [Shout Un-Banned]<br/>";
  }else{}
  if(ischatbaned($who)){
  echo "<a href=\"md.php?action=penalties_with&amp;who=$who&amp;cat=chatunban\">&#187;Penalties Remove</a> [Chat Un-Banned]<br/>";
  }else{}


  echo "<a href=\"md.php?action=plsopt&amp;who=$who\">&#187;Plusses</a><br/>";
$noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE validated='0' AND id='".$who."'"));
if($noi[0]==1){
echo "<a href=\"md.php?action=active_id&amp;who=$who\">&#187;Active This ID</a><br/>";
}
  echo "<a href=\"md.php?action=kick&amp;who=$who\">&#187;Kick</a> [Remove From Online List]<br/>";
  echo "<a href=\"md.php?action=delprivate&amp;who=$who\">&#187;Delete Sent PMs</a> [If Spammer]<br/>";
  echo "<a href=\"md.php?action=waropt0&amp;who=$who\">&#187;Increase Warning Level</a><br/>";
  echo "<a href=\"md.php?action=waropt1&amp;who=$who\">&#187;Decrease Warning Level</a><br/>";
  echo "<a href=\"md.php?action=rppr&amp;who=$who\">&#187;Add Reputation Points</a><br/><br/>";
  
  echo "<a href=\"md.php?action=srb&amp;who=$who\">&#187;Add Bonus Balance for Spam Report</a><br/><br/>";

if(!isdisabled($who)){
echo "<a href=\"md.php?action=disableac&amp;who=$who\">&#187;Disable Account</a><br/>";
}else{
echo "<a href=\"md.php?action=enableacc&amp;who=$who\">&#187;Enable Account</a><br/>";
}

if(!istrashed($who)){
echo "<a href=\"headadmincp2.php?action=trash&amp;who=$who\">&#187;Trash This ID</a><br/>";
}else{
echo "<a href=\"headadminproc2.php?action=untr&amp;who=$who\">&#187;Un-trash This ID</a><br/>";
}

if(!isshield($who)){
echo "<a href=\"headadminproc2.php?action=shld&amp;who=$who\">&#187;Shield This ID</a><br/>";
}else{
echo "<a href=\"headadminproc2.php?action=ushld&amp;who=$who\">&#187;Un-shield This ID</a><br/>";
}

echo" <a href=\"headadmincp2.php?action=acui&unick=$unck\">&#187;Edit This ID</a>";


echo "<br/><center><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a></center>";
echo "</small></p></card>";
}
//////////////////////////////////Validation List

else if($action=="validatelist")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
addonline(getuid_sid($sid),"Vice President Tools","");
echo "<card id=\"main\" title=\"Validate List\">";
//////ALL LISTS SCRIPT <<
if($page=="" || $page<=0)$page=1;
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE validated='0'"));
$num_items = $noi[0]; //changable
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
if(($page>$num_pages)&&$page!=1)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;

//changable sql

$sql = "SELECT id, name FROM dcroxx_me_users WHERE validated='0' ORDER BY name  LIMIT $limit_start, $items_per_page";


echo "<p><small>";
$items = mysql_query($sql);

if(mysql_num_rows($items)>0)
{
while ($item = mysql_fetch_array($items))
{

$nopl = mysql_fetch_array(mysql_query("SELECT sex, birthday, location FROM dcroxx_me_users WHERE id='".$item[0]."'"));
$uage = getage($nopl[1]);
if($nopl[0]=='M')
{$usex = "Male";}else
if($nopl[0]=='F'){$usex = "Female";}
else{$usex = "Argh! No Profile!";}
$nopl[2] = htmlspecialchars($nopl[2]);

$lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]($uage/$usex/$nopl[2])</a>";
echo "$lnk<br/>";
}
}
echo "</small></p>";
echo "<p align=\"center\"><small>";
if($page>1)
{
$ppage = $page-1;
echo "<a href=\"headadmincp2.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
}
if($page<$num_pages)
{
$npage = $page+1;
echo "<a href=\"headadmincp2.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
}
echo "<br/>$page/$num_pages<br/>";
if($num_pages>2)
{
$rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
$rets .= "<anchor>[GO]";
$rets .= "<go href=\"headadmincp2.php\" method=\"get\">";
$rets .= "<postfield name=\"action\" value=\"$action\"/>";
$rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
$rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
$rets .= "</go></anchor>";

echo $rets;
}
echo "</small></p>";
echo "<p align=\"center\"><small>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p>";
echo "</card>";
}

//////////////////////////trash user//////////////////////////

else if($action=="trash")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
$who = $_GET["who"];
echo "<card id=\"main\" title=\"Vice President Tools\">";
echo "<p align=\"center\"><small>";
$unick = getnick_uid($who);
echo "Trashing $unick<br/>";
  echo" <center>
<form method=\"post\" action=\"headadminproc2.php?action=trash\">";
echo"Reason: <textarea name=\"pres\" style=\"height:30px;width: 270px;\" ></textarea><br/>";
    echo "Days: <input name=\"pds\" format=\"*N\" maxlength=\"4\"/><br/>";
    echo "Hours: <input name=\"phr\" format=\"*N\" maxlength=\"4\"/><br/>";
    echo "Minutes: <input name=\"pmn\" format=\"*N\" maxlength=\"2\"/><br/>";
    echo "Seconds: <input name=\"psc\" format=\"*N\" maxlength=\"2\"/><br/>";
	    echo "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
echo"<input type=\"submit\" name=\"Submit\" value=\"PUNISH\"/><br/>
</form>";

echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p></card>";
}
//////////////////////////ban user//////////////////////////

else if($action=="ban")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
$who = $_GET["who"];
echo "<card id=\"main\" title=\"Vice President Tools\">";
echo "<p align=\"center\"><small>";
$unick = getnick_uid($who);
echo "Banning $unick<br/>";


 echo" <center>
<form method=\"post\" action=\"headadminproc2.php?action=ban\">";
echo"Reason: <textarea name=\"pres\" style=\"height:30px;width: 270px;\" ></textarea><br/>";
    echo "Days: <input name=\"pds\" format=\"*N\" maxlength=\"4\"/><br/>";
    echo "Hours: <input name=\"phr\" format=\"*N\" maxlength=\"4\"/><br/>";
    echo "Minutes: <input name=\"pmn\" format=\"*N\" maxlength=\"2\"/><br/>";
    echo "Seconds: <input name=\"psc\" format=\"*N\" maxlength=\"2\"/><br/>";
	    echo "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
echo"<input type=\"submit\" name=\"Submit\" value=\"PUNISH\"/><br/>
</form>";


echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p></card>";
}
//////////////////////////ipban user//////////////////////////

else if($action=="ipban")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
$who = $_GET["who"];
echo "<card id=\"main\" title=\"Vice President Tools\">";
echo "<p align=\"center\"><small>";
$unick = getnick_uid($who);
echo "ip-banning $unick<br/>";

 echo" <center>
<form method=\"post\" action=\"headadminproc2.php?action=ipban\">";
echo"Reason: <textarea name=\"pres\" style=\"height:30px;width: 270px;\" ></textarea><br/>";
    echo "Days: <input name=\"pds\" format=\"*N\" maxlength=\"4\"/><br/>";
    echo "Hours: <input name=\"phr\" format=\"*N\" maxlength=\"4\"/><br/>";
    echo "Minutes: <input name=\"pmn\" format=\"*N\" maxlength=\"2\"/><br/>";
    echo "Seconds: <input name=\"psc\" format=\"*N\" maxlength=\"2\"/><br/>";
	    echo "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
echo"<input type=\"submit\" name=\"Submit\" value=\"PUNISH\"/><br/>
</form>";

echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p></card>";
}
//////////////////////////add permissions//////////////////////////

else if($action=="addpRmxX")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
echo "<card id=\"main\" title=\"Vice President Tools\">";
echo "<p align=\"center\"><small>";
echo "<b>Add permission</b>";
$forums = mysql_query("SELECT id, name FROM dcroxx_me_forums ORDER BY position, id, name");
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
echo "        <br/><anchor>Submit
<go href=\"headadminproc2.php?action=addpRmxX\" method=\"post\">
<postfield name=\"fid\" value=\"$(fid)\"/>
<postfield name=\"gid\" value=\"$(gid)\"/>
</go></anchor>";
echo "<br/><br/><a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p>";
echo "</card>";
}
//////////////////////////////////////Manage Mods

else if($action=="manmods")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
echo "<card id=\"main\" title=\"Vice President Tools\">";
echo "<p align=\"center\"><small>";
echo "NOTE: Some features will be added later to this page<br/><br/>";
$mods = mysql_query("SELECT id, name FROM dcroxx_me_users WHERE pRmxX='1'");
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
echo "<go href=\"headadminproc2.php?action=addfmod\" method=\"post\">";
echo "<postfield name=\"mid\" value=\"$(mid)\"/>";
echo "<postfield name=\"fid\" value=\"$(fid)\"/>";
echo "</go>";
echo "</anchor>";
*/
echo "<anchor>Add All Forums";
echo "<go href=\"headadminproc2.php?action=addfmod\" method=\"post\">";
echo "<postfield name=\"mid\" value=\"$(mid)\"/>";
echo "<postfield name=\"fid\" value=\"*\"/>";
echo "</go>";
echo "<br/></anchor>";
echo "<anchor>Delete All Forums";
echo "<go href=\"headadminproc2.php?action=delfmod\" method=\"post\">";
echo "<postfield name=\"mid\" value=\"$(mid)\"/>";
echo "<postfield name=\"fid\" value=\"*\"/>";
echo "</go>";
echo "</anchor>";
//echo "<br/><br/>";
echo "<br/><br/><a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p>";
echo "</card>";
}

else if($action=="blocksites")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
echo "<card id=\"main\" title=\"Vice President Tools\">";
echo "<p><small>";
echo "<a href=\"headadmincp2.php?action=addsite\">&#187;Add Site</a><br/>";
echo "<a href=\"headadmincp2.php?action=viewsite\">&#187;View Sites</a><br/>";
//echo "<a href=\"headadmincp2.php?action=delsite\">&#187;Delete Site</a><br/>";
echo "</small></p>";
echo "<p align=\"center\"><small>";
echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p>";
echo "</card>";
}
else if($action=="addsite")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
echo "<card id=\"main\" title=\"Vice President Tools\">";
echo "<p><small>";
echo "Please Enter The Address Of the Site To Block<br/>";
echo "<input name=\"site\"/>";
echo "<br/><anchor>Add Site";
echo "<go href=\"headadminproc2.php?action=addsite\" method=\"post\">";
echo "<postfield name=\"site\" value=\"$(site)\"/>";
echo "</go>";
echo "</anchor>";
echo "</small></p>";
echo "<p align=\"center\"><small>";
echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p>";
echo "</card>";
}
else if($action=="viewsite")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
echo "<card id=\"main\" title=\"Vice President Tools\">";
echo "<p><small>";
echo "Currently Blocked Sites Are Listed Below";
echo "</small></p><p><small>";
$res = mysql_query("SELECT * FROM dcroxx_me_blockedsite");
while ($row = mysql_fetch_array($res))
{
echo $row[1];
echo " <a href=\"headadminproc2.php?action=delsite&amp;id=$row[0]\">[X]</a>";
echo "<br/>";
}
echo "</small></p>";
echo "<p align=\"center\"><small>";
echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p>";
echo "</card>";
}
else if($action=="delsite")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
echo "<card id=\"main\" title=\"Vice President Tools\">";
echo "<p><small>";
echo "<a href=\"headadmincp2.php?action=addsite\">&#187;Add Site</a><br/>";
echo "<a href=\"headadmincp2.php?action=viewsite\">&#187;View Sites</a><br/>";
echo "<a href=\"headadmincp2.php?action=delsite\">&#187;Delete Site</a><br/>";
echo "</small></p>";
echo "<p align=\"center\"><small>";
echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p>";
echo "</card>";
}
else if($action=="manrss")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
echo "<card id=\"main\" title=\"RSS Sources\">";
echo "<p><small>";
echo "<a href=\"headadmincp2.php?action=addrss\">&#187;Add Source</a><br/>";
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_rss"));
if($noi[0]>0)
{
$rss = mysql_query("SELECT title, id FROM dcroxx_me_rss");
echo "<br/><select name=\"rssid\">";
while($rs=mysql_fetch_array($rss))
{
echo "<option value=\"$rs[1]\">$rs[0]</option>";
}
echo "</select><br/>";
echo "<anchor>Edit Source";
echo "<go href=\"headadmincp2.php?action=edtrss\" method=\"post\">";
echo "<postfield name=\"rssid\" value=\"$(rssid)\"/>";
echo "</go></anchor><br/>";
echo "<anchor>Delete Source";
echo "<go href=\"headadminproc2.php?action=delrss\" method=\"post\">";
echo "<postfield name=\"rssid\" value=\"$(rssid)\"/>";
echo "</go></anchor><br/>";
}
echo "</small></p>";
echo "<p align=\"center\"><small>";
echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p>";
echo "</card>";
}
else if($action=="clrdta")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
echo "<card id=\"main\" title=\"Vice President Tools\">";
echo "<p><small>";
echo "<a href=\"headadminproc2.php?action=delpms\">&#187;Delete Inboxes</a><br/>";
echo "<a href=\"headadminproc2.php?action=delpops\">&#187;Delete Popups</a><br/>";
echo "<a href=\"headadminproc2.php?action=clrmlog\">&#187;Clear ModLog</a><br/>";
echo "<a href=\"headadminproc2.php?action=delsht\">&#187;Delete Old Shouts</a><br/>";
echo "</small></p>";
echo "<p align=\"center\"><small>";
echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p>";
echo "</card>";
}
else if($action=="addsml")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
echo "<card id=\"main\" title=\"Vice President Tools\">";
echo "<p align=\"center\"><small>";
echo "<b>Add Smilies</b><br/><br/>";
echo "Code:<input name=\"smlcde\" maxlength=\"30\"/><br/>";
echo "Image Source:<input name=\"smlsrc\" maxlength=\"200\"/><br/>";
echo "<anchor>Add";
echo "<go href=\"headadminproc2.php?action=addsml\" method=\"post\">";
echo "<postfield name=\"smlcde\" value=\"$(smlcde)\"/>";
echo "<postfield name=\"smlsrc\" value=\"$(smlsrc)\"/>";
echo "</go></anchor>";
echo "<br/><br/><a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p>";
echo "</card>";
}
else if($action=="addgal")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
echo "<card id=\"main\" title=\"Vice President Tools\">";
echo "<p align=\"center\"><small>";
echo "<b>Add Gallery Pic</b><br/><br/>";
echo "Code:<input name=\"galcde\" maxlength=\"30\"/><br/>";
echo "Image Source:<input name=\"galsrc\" maxlength=\"200\"/><br/>";
echo "<anchor>Add";
echo "<go href=\"headadminproc2.php?action=addgal\" method=\"post\">";
echo "<postfield name=\"galcde\" value=\"$(galcde)\"/>";
echo "<postfield name=\"galsrc\" value=\"$(galsrc)\"/>";
echo "</go></anchor>";
echo "<br/><br/><a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
echo "<a href=\"index.php?action=home\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p>";
echo "</card>";
}
else if($action=="addavt")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
echo "<card id=\"main\" title=\"Vice President Tools\">";
echo "<p align=\"center\"><small>";
echo "<b>Add Smilies</b><br/><br/>";
echo "Source:<input name=\"avtsrc\" maxlength=\"30\"/><br/>";
echo "<anchor>Add";
echo "<go href=\"headadminproc2.php?action=addavt\" method=\"post\">";
echo "<postfield name=\"avtsrc\" value=\"$(avtsrc)\"/>";
echo "</go></anchor>";
echo "<br/><br/><a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"*\"/>Vice President Tools</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p>";
echo "</card>";
}

else if($action=="addrss")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
echo "<card id=\"main\" title=\"Vice President Tools\">";
echo "<p align=\"center\"><small>";
echo "<b>Add RSS</b><br/><br/>";
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
echo "<anchor>Add";
echo "<go href=\"headadminproc2.php?action=addrss\" method=\"post\">";

echo "<postfield name=\"rssnm\" value=\"$(rssnm)\"/>";
echo "<postfield name=\"rsslnk\" value=\"$(rsslnk)\"/>";
echo "<postfield name=\"rssimg\" value=\"$(rssimg)\"/>";
echo "<postfield name=\"rssdsc\" value=\"$(rssdsc)\"/>";
echo "<postfield name=\"fid\" value=\"$(fid)\"/>";

echo "</go></anchor>";
echo "<br/><br/><a href=\"headadmincp2.php?action=manrss\"><img src=\"images/rss.gif\" alt=\"rss\"/>Manage RSS</a><br/>";
echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p>";
echo "</card>";
}
else if($action=="edtrss")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);

$rssid = $_POST["rssid"];
$rsinfo = mysql_fetch_array(mysql_query("SELECT title, link, imgsrc, fid, dscr FROM dcroxx_me_rss WHERE id='".$rssid."'"));
echo "<card id=\"main\" title=\"Vice President Tools\">";
echo "<onevent type=\"onenterforward\">";
echo "<refresh>
<setvar name=\"rssnm\" value=\"$rsinfo[0]\"/>
<setvar name=\"rsslnk\" value=\"$rsinfo[1]\"/>
<setvar name=\"rssimg\" value=\"$rsinfo[2]\"/>
<setvar name=\"fid\" value=\"$rsinfo[3]\"/>
<setvar name=\"rssdsc\" value=\"$rsinfo[4]\"/>
<setvar name=\"rssdsc\" value=\"$rsinfo[4]\"/>
<setvar name=\"rssid\" value=\"$rssid\"/>
";
echo "</refresh></onevent>";
echo "<p align=\"center\"><small>";

echo "<b>Edit RSS</b><br/><br/>";
echo "Name:<input name=\"rssnm\" maxlength=\"50\"/><br/>";
echo "Source:<input name=\"rsslnk\" maxlength=\"255\"/><br/>";
echo "Image:<input name=\"rssimg\" maxlength=\"255\"/><br/>";
echo "Description:<input name=\"rssdsc\"  maxlength=\"255\"/><br/>";
$forums = mysql_query("SELECT id, name FROM dcroxx_me_forums ORDER BY position, id, name");
echo "Forum: <select name=\"fid\" value=\"$rsinfo[3]\">";
echo "<option value=\"0\">NO FORUM</option>";
while ($forum=mysql_fetch_array($forums))
{
echo "<option value=\"$forum[0]\">$forum[1]</option>";
}
echo "</select><br/>";
echo "<anchor>Edit";
echo "<go href=\"headadminproc2.php?action=edtrss\" method=\"post\">";

echo "<postfield name=\"rssnm\" value=\"$(rssnm)\"/>";
echo "<postfield name=\"rsslnk\" value=\"$(rsslnk)\"/>";
echo "<postfield name=\"rssimg\" value=\"$(rssimg)\"/>";
echo "<postfield name=\"rssdsc\" value=\"$(rssdsc)\"/>";
echo "<postfield name=\"fid\" value=\"$(fid)\"/>";
echo "<postfield name=\"rssid\" value=\"$(rssid)\"/>";
echo "</go></anchor>";
echo "<br/><br/><a href=\"headadmincp2.php?action=manrss\"><img src=\"images/rss.gif\" alt=\"\"/>Manage RSS</a><br/>";
echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p>";
echo "</card>";
}
/////////////////////////////////user info

else if($action=="chuinfo")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
echo "<card id=\"main\" title=\"Vice President Tools\">";
echo "<p align=\"center\"><small>";
echo "Type user nickname<br/><br/>";
echo "User: <input name=\"unick\" format=\"*x\" maxlength=\"15\"/><br/>";
echo "<anchor>[FIND]";
echo "<go href=\"headadmincp2.php?action=acui\" method=\"post\">";
echo "<postfield name=\"unick\" value=\"$(unick)\"/>";
echo "</go></anchor>";
echo "<br/><br/><a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p>";
echo "</card>";
}

else if($action=="acui")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
echo "<card id=\"main\" title=\"Vice President Tools\">";


    $unick = $_GET["unick"];
    $unick2 = getnick_uid($unick);
   // $tid = getuid_nick($unick);
    $tid = $unick;
if($tid==0)
{
echo "<p align=\"center\"><small>";
echo "<img src=\"images/notok.gif\" alt=\"x\"/>User Does Not exist<br/>";
echo "</small></p>";
}else{
$trgtpRmxX = mysql_fetch_array(mysql_query("SELECT pRmxX FROM dcroxx_me_users WHERE id='".$tid."'"));
$uidpRmxX = mysql_fetch_array(mysql_query("SELECT pRmxX FROM dcroxx_me_users WHERE id='".$uid."'"));
if($trgtpRmxX>$uidpRmxX){
echo "<p align=\"center\"><small>";
echo "<b><img src=\"images/notok.gif\" alt=\"x\"/><br/>Error!!!<br/>permission Denied...</b><br/>";
echo "U Cannot Edit $unick2<br/><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p>";
}else{
echo "<p><small>";
echo "<a href=\"headadmincp2.php?action=chubi&amp;who=$tid\">&#187;$unick2's Profile</a><br/>";
$judg = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_judges WHERE uid='".$tid."'"));
if($judg[0]>0)
{
echo "<a href=\"headadminproc2.php?action=deljdg&amp;who=$tid\">&#187;Remove $unick2 From Judges List</a><br/>";
}else{
echo "<a href=\"headadminproc2.php?action=addjdg&amp;who=$tid\">&#187;Make $unick2 judge</a><br/>";
}
echo "<a href=\"headadmincp2.php?action=addtog&amp;who=$tid\">&#187;Add  $unick2 to a group</a><br/>";
echo "<a href=\"headadmincp2.php?action=umset&amp;who=$tid\">&#187;$unick2's Mod. Settings</a><br/>";
echo "<a href=\"headadminproc2.php?action=delxp&amp;who=$tid\">&#187;Delete $unick2's posts</a><br/>";
echo "<a href=\"headadminproc2.php?action=delu&amp;who=$tid\">&#187;Delete $unick2</a><br/>";

echo "</small></p>";
echo "<p align=\"center\"><small>";
echo "<a href=\"headadmincp2.php?action=chuinfo\">Users Info</a><br/>";
echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p>";
}
}
echo "</card>";
}

////////////////////////////////////////////

else if($action=="chubi")
{
$pstyle = gettheme($sid);
echo xhtmlhead("HeadAdmin Tools",$pstyle);
echo "<card id=\"main\" title=\"Vice President Tools\">";
$who = $_GET["who"];
if(isowner($who)){
    echo "<small>Permission Denied!<br/><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
    echo "</small></card>";
    echo "</wml>";
    exit();
}
$unick = getnick_uid($who);
echo "<onevent type=\"onenterforward\">";
$avat = getavatar($who);
$email = mysql_fetch_array(mysql_query("SELECT email FROM dcroxx_me_users WHERE id='".$who."'"));
$bdy = mysql_fetch_array(mysql_query("SELECT birthday FROM dcroxx_me_users WHERE id='".$who."'"));
$uloc = mysql_fetch_array(mysql_query("SELECT location FROM dcroxx_me_users WHERE id='".$who."'"));
$usig = mysql_fetch_array(mysql_query("SELECT signature FROM dcroxx_me_users WHERE id='".$who."'"));
$sx = mysql_fetch_array(mysql_query("SELECT sex FROM dcroxx_me_users WHERE id='".$who."'"));
$pRmxX = mysql_fetch_array(mysql_query("SELECT perm FROM dcroxx_me_users WHERE id='".$who."'"));
$uidpRmxX = mysql_fetch_array(mysql_query("SELECT perm FROM dcroxx_me_users WHERE id='".$uid."'"));
     $specialid = mysql_fetch_array(mysql_query("SELECT specialid FROM dcroxx_me_users WHERE id='".$who."'"));
echo "<refresh>
<setvar name=\"unick\" value=\"$unick\"/>
<setvar name=\"savat\" value=\"$avat\"/>
<setvar name=\"semail\" value=\"$email[0]\"/>
<setvar name=\"ubday\" value=\"$bdy[0]\"/>
<setvar name=\"uloc\" value=\"$uloc[0]\"/>
<setvar name=\"usig\" value=\"$usig[0]\"/>
<setvar name=\"sx\" value=\"$sx[0]\"/>
<setvar name=\"pRmxX\" value=\"$pRmxX[0]\"/>
<setvar name=\"specialid\" value=\"$specialid[0]\"/>
<setvar name=\"npwd\" value=\"\"/>
";
echo "</refresh></onevent>";
if($pRmxX>$uidpRmxX){
echo "<p align=\"center\"><small>";
echo "<b><img src=\"images/notok.gif\" alt=\"x\"/><br/>Error!!!<br/>permission Denied...</b><br/>";
echo "U Cannot Edit $unick<br/><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p>";
}else{


    echo "<form action=\"headadminproc2.php?action=uprof&amp;who=$who\" method=\"post\">";
    echo "Nickname: <input name=\"unick\" maxlength=\"15\" value=\"$unick\"/><br/>";
    echo "Avatar: <input name=\"savat\" maxlength=\"100\" value=\"$avat\"/><br/>";
    echo "E-Mail: <input name=\"semail\" maxlength=\"100\" value=\"$email[0]\"/><br/>";
    echo "Birthday<small>(YYYY-MM-DD)</small>: <input name=\"ubday\" maxlength=\"50\" value=\"$bdy[0]\"/><br/>";
    echo "Location: <input name=\"uloc\" maxlength=\"50\" value=\"$uloc[0]\"/><br/>";
    echo "Info: <input name=\"usig\" maxlength=\"100\" value=\"$usig[0]\"/><br/>";
    echo "Sex: <select name=\"usex\" value=\"$sx[0]\">";
    echo "<option value=\"M\">Male</option>";
    echo "<option value=\"F\">Female</option>";
    echo "</select><br/>";

 
    echo "Privileges: <select name=\"pRmxX\" value=\"$pRmxX[0]\">";
    echo "<option value=\"0\">Normal</option>";
       echo "<option value=\"1\">Moderator</option>";
  echo "<option value=\"2\">Admin</option>";
  echo "</select><br/>";

    echo "VIP: <select name=\"specialid\" value=\"$specialid[0]\">";
     echo "<option value=\"0\">Normal</option>";
    echo "<option value=\"1\">Millionaire</option>";
    echo "<option value=\"2\">Quiz Masters</option>";
    echo "<option value=\"8\">Prince</option>";
    echo "<option value=\"9\">Princess</option>";
    echo "<option value=\"10\">Upcomeing Star</option>";
    echo "<option value=\"11\">Super Star</option>";
    echo "<option value=\"12\">Reaper</option>";
    echo "<option value=\"13\">Director</option>";
    echo "<option value=\"14\">Spy</option>";
    echo "<option value=\"15\">Killer!</option>";
    echo "<option value=\"16\">Assassin!</option>";
    echo "<option value=\"17\">Partner</option>";
    echo "</select><br/>";
	echo "<input type=\"submit\" value=\"Update\" />";
	echo "</form>";
	
	 echo "<br/><br/>";
	echo "<form action=\"headadminproc2.php?action=upwd&amp;who=$who\" method=\"post\">\n";
    echo "Password: <input name=\"npwd\" maxlength=\"15\"/><br/>";
	echo "<input type=\"submit\" value=\"Change\" />";
	echo "</form>";
/*
echo "Nickname: <input name=\"unick\" maxlength=\"15\"/><br/>";
echo "Profile Pic: <input name=\"savat\" maxlength=\"100\"/><br/>";
echo "E-Mail: <input name=\"semail\" maxlength=\"100\"/><br/>";
echo "Birthday(YYYY-MM-DD): <input name=\"ubday\" maxlength=\"50\"/><br/>";
echo "Location: <input name=\"uloc\" maxlength=\"50\"/><br/>";
echo "Info: <input name=\"usig\" maxlength=\"100\"/><br/>";
echo "Sex: <select name=\"usex\" value=\"$sx[0]\">";
echo "<option value=\"M\">Male</option>";
echo "<option value=\"F\">Female</option>";
echo "</select><br/>";
echo "Privileges: <select name=\"pRmxX\" value=\"$pRmxX[0]\">";
echo "<option value=\"0\">Normal</option>";
echo "<option value=\"1\">Moderator</option>";
echo "<option value=\"2\">Admin</option>";
echo "</select><br/>";
echo "<anchor>Update";
echo "<go href=\"headadminproc2.php?action=uprof&amp;who=$who\" method=\"post\">";
echo "<postfield name=\"unick\" value=\"$(unick)\"/>";
echo "<postfield name=\"savat\" value=\"$(savat)\"/>";
echo "<postfield name=\"semail\" value=\"$(semail)\"/>";
echo "<postfield name=\"ubday\" value=\"$(ubday)\"/>";
echo "<postfield name=\"uloc\" value=\"$(uloc)\"/>";
echo "<postfield name=\"usig\" value=\"$(usig)\"/>";
echo "<postfield name=\"usex\" value=\"$(usex)\"/>";
echo "<postfield name=\"pRmxX\" value=\"$(pRmxX)\"/>";
echo "</go></anchor>";
echo "<br/><br/>";
echo "Password: <input name=\"npwd\" format=\"*x\" maxlength=\"15\"/><br/>";
echo "<anchor>Change";
echo "<go href=\"headadminproc2.php?action=upwd&amp;who=$who\" method=\"post\">";
echo "<postfield name=\"npwd\" value=\"$(npwd)\"/>";

echo "</go></anchor>";*/
//echo "</small></p>";
echo "<p align=\"center\"><small>";
echo "<a href=\"headadmincp2.php?action=chuinfo\">Users Info</a><br/>";
echo "<a href=\"headadmincp2.php?action=headadmincp\"><img src=\"images/admn.gif\" alt=\"\"/>Vice President Tools</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p>";
}
echo "</card>";
}
else{
echo "<card id=\"main\" title=\"Vice President Tools\">";
echo "<p align=\"center\"><small>";
echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p></card>";
}

?>
</html>
