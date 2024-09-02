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
$sitename = mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE name='sitename'"));
$sitename = $sitename[0];

if(!ismod(getuid_sid($sid)))
{
  echo "<card id=\"main\" title=\"$sitename\">";
  echo "<p align=\"center\"><small>";
  echo "<b>permission Denied!</b><br/>";
  echo "<br/>Only mod/admin can use this page...<br/>";
  echo "<a href=\"index.php\">Home</a>";
  echo "</small></p>";
  echo "</card>";
  echo "</wml>";
  exit();
}

if(islogged($sid)==false)
{
  echo "<card id=\"main\" title=\"$sitename\">";
  echo "<p align=\"center\"><small>";
  echo "You are not logged in<br/>";
  echo "Or Your session has been expired<br/><br/>";
  echo "<a href=\"index.php\">Login</a>";
  echo "</small></p>";
  echo "</card>";
  echo "</wml>";
  exit();
}

addonline(getuid_sid($sid),"Prime Minister/Minister Tools","");

//////////////////////////Prime Minister/Minister Tools//////////////////////////

if($action=="admincp")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  echo "<b>Prime Minister/Minister Tools</b>";
  echo "</small></p>";
  echo "<p><small>";
  
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_disable_shout"));
if($noi[0]==1){
$shdis = mysql_fetch_array(mysql_query("SELECT uid, pnreas FROM ibwfrr_disable_shout"));
$shdisnick = getnick_uid($shdis[0]);
echo "Shoutbox is disabled by <b>$shdisnick</b> for $shdis[1]<br/>
<a href=\"md.php?action=enablesht\">&#187;Enable ShoutBoX</a><br/>";
}else{
echo "Shoutbox is enabled (DEAFULT)<br/>
<a href=\"md.php?action=disablesht\">&#187;Disable ShoutBoX</a><br/>";
}

echo"<br/>";

$vldtn = mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE name='vldtn'"));
if($vldtn[0]==0){
echo "Validation is disabled (DEAFULT)<br/>
<a href=\"md.php?action=en_val\">&#187;Enable Validation</a><br/>";
}else{
echo "Validation is enabled by <b>Staff Team</b><br/>
<a href=\"md.php?action=dis_val\">&#187;Disable Validation</a><br/>";
}

echo"<br/>";

$reg = mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE name='reg'"));
if($reg[0]==0){
echo "Registration is disabled by <b>Staff Team</b><br/>
<a href=\"md.php?action=en_reg\">&#187;Enable Registration</a><br/>";
}else{
echo "Registration is enabled (DEAFULT)<br/>
<a href=\"md.php?action=dis_reg\">&#187;Disable Registration</a><br/>";
}

echo"<br/>";



if(isadmin(getuid_sid($sid))){
echo "<a href=\"admincp.php?action=ugroups\">&#187;User Groups</a><br/>";
echo "<a href=\"admincp.php?action=addperm\">&#187;Add Permissions</a><br/>";
echo "<a href=\"admincp.php?action=manrss\">&#187;Manage RSS Sources</a><br/>";
}
echo "<a href=\"add_smilies.php\">&#187;Add Smilies</a><br/>";
echo "<a href=\"admincp.php?action=chrooms\">&#187;Chat Rooms</a><br/><br/>";
  
  $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_penalties WHERE penalty='1' OR penalty='2'"));
  echo "<a href=\"lists.php?action=banned\">&#187;Banned Lists($noi[0])</a><br/>";
  $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_penalties WHERE penalty='0'"));
  echo "<a href=\"lists.php?action=trashed\">&#187;Trashed Lists($noi[0])</a><br/>";
  if(isadmin(getuid_sid($sid))){
  $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_penalties WHERE penalty='2'"));
  echo "<a href=\"lists.php?action=ipban\">&#187;Banned IPs Lists($noi[0])</a><br/>";
  }

  $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE validated='0'"));
  echo "<a href=\"md.php?action=validatelist\">&#187;Validation List($noi[0])</a><br/>";
    $noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_users WHERE 2x_disabl_acc='1'"));
  echo "<a href=\"md.php?action=disablelist\">&#187;Disable Accounts($noi[0])</a><br/>";


  
  
  
  echo "</small></p>";
  echo "<p align=\"center\"><small>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}

else if($action=="disablesht")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
  $who = isnum((int)$_GET['who']);
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"ModCP\">"; 
  echo "<p align=\"left\"><small>";
  
  
 echo" <center>
Disable Shout:<br/><br/>
<form action=\"admproc2.php?action=disablesht\" method=\"post\">";
  echo "Reason: <input name=\"pres\" maxlength=\"100\" size=\"30\"/><br/>";
  echo "Minutes: <input name=\"pmn\" format=\"*N\" maxlength=\"2\"/><br/>";
  echo "Seconds: <input name=\"psc\" format=\"*N\" maxlength=\"2\"/><br/>";
//echo"<input type=\"password\" name=\"apwd\" format=\"*x\" maxlength=\"35\"/><br/>";
echo "<input type=\"hidden\" name=\"action\" value=\"main\"/>";
echo"<input type=\"submit\" name=\"Submit\" value=\"Disable\"/><br/>
</form></center>"; 
  
  /*echo"Disable Shout:<br/><br/>";
  echo "Reason: <input name=\"pres\" maxlength=\"100\" size=\"30\"/><br/>";
  echo "Minutes: <input name=\"pmn\" format=\"*N\" maxlength=\"2\"/><br/>";
  echo "Seconds: <input name=\"psc\" format=\"*N\" maxlength=\"2\"/><br/>";
  echo "<anchor>Disable";
  echo "<go href=\"admproc2.php?action=disablesht\" method=\"post\">";
  echo "<postfield name=\"pres\" value=\"$(pres)\"/>";
  echo "<postfield name=\"pmn\" value=\"$(pmn)\"/>";
  echo "<postfield name=\"psc\" value=\"$(psc)\"/>";
  echo "<postfield name=\"who\" value=\"$who\"/>";
  echo "</go></anchor><br/>";*/
 
  echo"</small></p><p align=\"center\"><small>";
  echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Admin Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////mod a user//////////////////////////

else if($action=="user")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
  $who = $_GET["who"];
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  $unick = getnick_uid($who);
  echo "<b>Moderating $unick</b>";
  echo "</small></p>";
  echo "<p align=\"left\"><small>";
 // if(!isbanned($who) || !ispmbaned($who) || !ispostbaned($who) || !isshoutbaned($who) || !ischatbaned($who)){
  echo "<a href=\"md.php?action=penalties&amp;who=$who\">&#187;Penalties</a><br/>";
 // }else{
  
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
  
  //}
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
/*if(!isshield($who)){
echo "<a href=\"ownrproc2.php?action=shld&amp;who=$who\">&#187;Shield</a><br/>";
}else{
echo "<a href=\"ownrproc2.php?action=ushld&amp;who=$who\">&#187;Unshield</a><br/>";
}*/
 

  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
////////////////////////////
else if($action=="addsml")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
    echo "<card id=\"main\" title=\"Admin Tools\">";
    echo "<p align=\"center\"><small>";
    echo "<b>Add Smilies</b><br/><br/>";
    echo "Code:<input name=\"smlcde\" maxlength=\"30\" size=\"31\"/><br/>";
    echo "Image Source:<input name=\"smlsrc\" maxlength=\"200\"/><br/>";
    echo "<anchor>Add";
    echo "<go href=\"admproc2.php?action=addsml\" method=\"post\">";
    echo "<postfield name=\"smlcde\" value=\"$(smlcde)\"/>";
    echo "<postfield name=\"smlsrc\" value=\"$(smlsrc)\"/>";
    echo "</go></anchor>";
    echo "<br/><br/><a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Admin Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
    echo "</card>";
}
///////////////Validation List

else if($action=="validatelist")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
    addonline(getuid_sid($sid),"Admin Tools","");
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
      echo "<a href=\"admincp2.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"admincp2.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"admincp2.php\" method=\"get\">";
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


else if($action=="disablelist")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
    addonline(getuid_sid($sid),"Admin Tools","");
    echo "<card id=\"main\" title=\"Disable List\">";
    //////ALL LISTS SCRIPT <<
    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE 2x_disabl_acc='1'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql
    
        $sql = "SELECT id, name FROM dcroxx_me_users WHERE 2x_disabl_acc='1' ORDER BY name  LIMIT $limit_start, $items_per_page";
    

    echo "<p><small>";
    $items = mysql_query($sql);

    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {

    $nopl = mysql_fetch_array(mysql_query("SELECT 2x_disable_reas, 2x_disable_uid FROM dcroxx_me_users WHERE id='".$item[0]."'"));
    //$uage = getage($nopl[1]);
  /*  if($nopl[0]=='M')
    {$usex = "Male";}else
    if($nopl[0]=='F'){$usex = "Female";}
    else{$usex = "Argh! No Profile!";}
    $nopl[2] = htmlspecialchars($nopl[2]);*/
  $uick = getnick_uid($nopl[1]);
    $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a> ($nopl[0]) By <a href=\"index.php?action=viewuser&amp;who=$nopl[1]\">$uick</a>";
    echo "$lnk<br/>";
    }
    }
    echo "</small></p>";
    echo "<p align=\"center\"><small>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"admincp2.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"admincp2.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"admincp2.php\" method=\"get\">";
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
echo xhtmlhead("Admin Tools",$pstyle);
  $who = $_GET["who"];
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\">";
  $unick = getnick_uid($who);
  
    echo "Trashing $unick<br/>";
  echo" <center>
<form method=\"post\" action=\"admproc2.php?action=trash\">";
echo"Reason: <textarea name=\"pres\" style=\"height:30px;width: 270px;\" ></textarea><br/>";
    echo "Days: <input name=\"pds\" format=\"*N\" maxlength=\"4\"/><br/>";
    echo "Hours: <input name=\"phr\" format=\"*N\" maxlength=\"4\"/><br/>";
    echo "Minutes: <input name=\"pmn\" format=\"*N\" maxlength=\"2\"/><br/>";
    echo "Seconds: <input name=\"psc\" format=\"*N\" maxlength=\"2\"/><br/>";
	    echo "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
echo"<input type=\"submit\" name=\"Submit\" value=\"PUNISH\"/><br/>
</form>";

  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</center></card>";
}
//////////////////////////ban user//////////////////////////

else if($action=="ban")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
  $who = $_GET["who"];
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\">";
 /* if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!<br/>";
  }else{*/
  $unick = getnick_uid($who);
  echo "Banning $unick<br/>";

  echo" <center>
<form method=\"post\" action=\"admproc2.php?action=ban\">";
echo"Reason: <textarea name=\"pres\" style=\"height:30px;width: 270px;\" ></textarea><br/>";
    echo "Days: <input name=\"pds\" format=\"*N\" maxlength=\"4\"/><br/>";
    echo "Hours: <input name=\"phr\" format=\"*N\" maxlength=\"4\"/><br/>";
    echo "Minutes: <input name=\"pmn\" format=\"*N\" maxlength=\"2\"/><br/>";
    echo "Seconds: <input name=\"psc\" format=\"*N\" maxlength=\"2\"/><br/>";
	    echo "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
echo"<input type=\"submit\" name=\"Submit\" value=\"PUNISH\"/><br/>
</form>";

 // }
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</center></card>";
}
//////////////////////////plusses//////////////////////////

else if($action=="plsopt")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
  $who = $_GET["who"];
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  if(!ismod(getuid_sid($sid)))
  {
  echo "permission Denied!<br/>";
  }else{
  $unick = getnick_uid($who);
  echo "Add/Substract $unick's Plusses";
  echo "</small></p>";

echo" <center><form method=\"post\" action=\"modproc2.php?action=pls\">";
$pen[0]="Substract";
$pen[1]="Add";
echo "Action: <select name=\"pid\">";
for($i=0;$i<count($pen);$i++){
echo "<option value=\"$i\">$pen[$i]</option>";
}
echo "</select><br/>";
echo"Reason: <textarea name=\"pres\" style=\"height:30px;width: 270px;\" ></textarea><br/>";
echo "Plusses: <input name=\"pval\" format=\"*N\" maxlength=\"3\"/><br/>";
echo "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
echo "<postfield name=\"pid\" value=\"$(pid)\"/>";
echo"<input type=\"submit\" name=\"Submit\" value=\"UPDATE\"/><br/>
</form></center>";

}
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p></card>";
}

else if($action=="bdt")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
  $who = $_GET["who"];
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  if(!ismod(getuid_sid($sid)))
  {
  echo "permission Denied!<br/>";
  }else{
  $unick = getnick_uid($who);
  echo "Add/Substract $unick's Money";
  echo "</small></p>";

echo" <center><form method=\"post\" action=\"modproc2.php?action=bdt\">";
$pen[0]="Add Amount";
$pen[1]="Subtract Amount";
echo "Action:<br/> <select name=\"pid\">";
for($i=0;$i<count($pen);$i++){
echo "<option value=\"$i\">$pen[$i]</option>";
}
echo "</select><br/>";
echo"Reason:<br/> <textarea name=\"pres\" style=\"height:30px;width: 270px;\" ></textarea><br/>";
echo "Amount:<br/> <input name=\"pval\" format=\"*N\" maxlength=\"3\"/><br/>";
echo "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
echo "<postfield name=\"pid\" value=\"$(pid)\"/>";
echo"<input type=\"submit\" name=\"Submit\" value=\"UPDATE\"/><br/>
</form></center>";

}
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p></card>";
}

else if($action=="bdt_with")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
  $who = $_GET["who"];
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  if(!ismod(getuid_sid($sid)))
  {
  echo "permission Denied!<br/>";
  }else{
  $unick = getnick_uid($who);
  echo "Add/Substract $unick's Money Withdraw";
  echo "</small></p>";

echo" <center><form method=\"post\" action=\"modproc2.php?action=bdt_with\">";
$pen[0]="Add Amount Withdraw";
$pen[1]="Subtract Amount Withdraw";
echo "Action:<br/> <select name=\"pid\">";
for($i=0;$i<count($pen);$i++){
echo "<option value=\"$i\">$pen[$i]</option>";
}
echo "</select><br/>";
echo"Reason:<br/> <textarea name=\"pres\" style=\"height:30px;width: 270px;\" ></textarea><br/>";
echo "Amount Withdraw:<br/> <input name=\"pval\" format=\"*N\" maxlength=\"3\"/><br/>";
echo "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
echo "<postfield name=\"pid\" value=\"$(pid)\"/>";
echo"<input type=\"submit\" name=\"Submit\" value=\"UPDATE\"/><br/>
</form></center>";

}
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p></card>";
}

else if($action=="rpopt")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
  $who = $_GET["who"];
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  if(!isheadadmin(getuid_sid($sid)) && !isowner(getuid_sid($sid)))
  {
  echo "permission Denied!<br/>";
  }else{
  $unick = getnick_uid($who);
  echo "Add $unick's RP";
  echo "</small></p>";
  echo "<p><small>";
  echo "Quiz name: <input name=\"pres\" maxlength=\"100\"/><br/>";
  echo "Position: <input name=\"pid\" maxlength=\"100\"/><br/>";
  echo "RP: <input name=\"pval\" format=\"*N\" maxlength=\"3\"/><br/>";
  echo "<anchor>Update";
  echo "<go href=\"modproc2.php?action=rp\" method=\"post\">";
  echo "<postfield name=\"who\" value=\"$who\"/>";
  echo "<postfield name=\"pres\" value=\"$(pres)\"/>";
  echo "<postfield name=\"pval\" value=\"$(pval)\"/>";
  echo "<postfield name=\"pid\" value=\"$(pid)\"/>";
  echo "</go></anchor>";
  }
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
//////////////////////////plusses//////////////////////////

else if($action=="waropt")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
  $who = $_GET["who"];
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!<br/>";
  }else{
  $unick = getnick_uid($who);
  echo "give warning $unick";
  echo "</small></p>";
 

  echo" <center>
<form method=\"post\" action=\"modproc2.php?action=war\">";
echo"Reason: <textarea name=\"pres\" style=\"height:30px;width: 270px;\" ></textarea><br/>";
    echo "Give Percent: <input name=\"pval\" format=\"*N\" maxlength=\"4\"/><br/>";
	    echo "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
echo"<input type=\"submit\" name=\"Submit\" value=\"PUNISH\"/><br/>
</form>";

  }
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</center></card>";
}
//////////////////////////add permissions//////////////////////////

else if($action=="addpRmxX")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  /*if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!<br/>";
  }else{*/
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
  echo "<br/><anchor>Submit
  <go href=\"admproc2.php?action=addpRmxX\" method=\"post\">
  <postfield name=\"fid\" value=\"$(fid)\"/>
  <postfield name=\"gid\" value=\"$(gid)\"/>
  </go></anchor><br/>";
 // }
  echo "<br/><a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}
else if($action=="addlink")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
    echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
    echo "<p align=\"center\"><small>";
    echo "Please Enter The Address Of the Site To Add<br/>";
    echo "<b>url</b><br/>";
    echo "<input name=\"url\"/><br/>";
    echo "<b>sitetitle</b><br/>";
    echo "<input name=\"title\"/><br/>";
    echo "<br/><anchor>Add Link";
    echo "<go href=\"admproc2.php?action=addlink\" method=\"post\">";
    echo "<postfield name=\"url\" value=\"$(url)\"/>";
    echo "<postfield name=\"title\" value=\"$(title)\"/>";
    echo "</go>";
    echo "</anchor>";
    echo "</small></p>";
    echo "<p align=\"center\"><small>";
  echo "<a href=\"linksites.php?sid=$sid\">Links</a><br/>";
  echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
    echo "</card>";
}
//////////////////////////forum categories//////////////////////////

else if($action=="fcats")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p><small>";
  if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{
  echo "<a href=\"admincp2.php?action=addcat\">&#187;Add Category</a><br/>";
  echo "<a href=\"admincp2.php?action=edtcat\">&#187;Edit Category</a><br/>";
  echo "<a href=\"admincp2.php?action=delcat\">&#187;Delete Category</a><br/>";
  }
  echo "</small></p>";
  echo "<p align=\"center\"><small>";
  echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}
//////////////////////////club tools//////////////////////////

else if($action=="club")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
  $clid = $_GET["clid"];
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p><small>";
  if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{
  echo "<a href=\"admincp2.php?action=gccp&amp;clid=$clid\">&#187;Give Credit Plusses</a><br/>";
  echo "<a href=\"admproc2.php?action=delclub&amp;clid=$clid\">&#187;Delete Club</a><br/>";
  }
  echo "</small></p>";
  echo "<p align=\"center\"><small>";
  echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}
//////////////////////////chatrooms//////////////////////////

else if($action=="chrooms")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p><small>";
 /* if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{*/
  echo "<a href=\"admincp2.php?action=addchr\">&#187;Add Room</a><br/>";
  $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_rooms"));
  if($noi[0]>0)
  {
  $rss = mysql_query("SELECT name, id FROM dcroxx_me_rooms");
  echo "<br/><select name=\"chrid\">";
  while($rs=mysql_fetch_array($rss))
  {
  echo "<option value=\"$rs[1]\">$rs[0]</option>";
  }
  echo "</select><br/>";
  echo "<anchor>Delete Room";
  echo "<go href=\"admproc2.php?action=delchr\" method=\"post\">";
  echo "<postfield name=\"chrid\" value=\"$(chrid)\"/>";
  echo "</go></anchor><br/>";
  }
  //}
  echo "</small></p>";
  echo "<p align=\"center\"><small>";
  echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}
//////////////////////////forums//////////////////////////

else if($action=="forums")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p><small>";
  if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{
  echo "<a href=\"admincp2.php?action=addfrm\">&#187;Add Forum</a><br/>";
  echo "<a href=\"admincp2.php?action=edtfrm\">&#187;Edit Forum</a><br/>";
  echo "<a href=\"admincp2.php?action=delfrm\">&#187;Delete Forum</a><br/>";
  }
  echo "</small></p>";
  echo "<p align=\"center\"><small>";
  echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}
//////////////////////////user groups//////////////////////////

else if($action=="ugroups")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p><small>";
 /* if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{*/
  echo "<a href=\"admincp2.php?action=addgrp\">&#187;Add User Group</a><br/>";
  //echo "<a href=\"admincp2.php?action=edtgrp\">&#187;Edit User group</a><br/>";
  echo "<a href=\"admincp2.php?action=delgrp\">&#187;Delete User group</a><br/>";
 // }
  echo "</small></p>";
  echo "<p align=\"center\"><small>";
  echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}
//////////////////////////add category//////////////////////////

else if($action=="addcat")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{
  echo "<b>Add Category</b><br/><br/>";
  echo "Name:<input name=\"fcname\" maxlength=\"30\"/><br/>";
  echo "Position:<input name=\"fcpos\" format=\"*N\" size=\"3\"  maxlength=\"3\"/><br/>";
  echo "<anchor>Add";
  echo "<go href=\"admproc2.php?action=addcat\" method=\"post\">";
  echo "<postfield name=\"fcname\" value=\"$(fcname)\"/>";
  echo "<postfield name=\"fcpos\" value=\"$(fcpos)\"/>";
  echo "</go></anchor>";
  }
  echo "<br/><br/><a href=\"admincp2.php?action=fcats\">Forum Categories</a><br/>";
  echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}
//////////////////////////add forum//////////////////////////

else if($action=="addfrm")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{
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
  echo "<anchor>Add";
  echo "<go href=\"admproc2.php?action=addfrm\" method=\"post\">";
  echo "<postfield name=\"frname\" value=\"$(frname)\"/>";
  echo "<postfield name=\"frpos\" value=\"$(frpos)\"/>";
  echo "<postfield name=\"fcid\" value=\"$(fcid)\"/>";
  echo "</go></anchor>";
  }
  echo "<br/><br/><a href=\"admincp2.php?action=forums\">Forums</a><br/>";
  echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}
//////////////////////////give club plusses//////////////////////////

else if($action=="gccp")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!<br/>";
  }else{
  echo "<b>Add club plusses</b><br/><br/>";
  $clid = $_GET["clid"];
  echo "Plusses:<input name=\"plss\" maxlength=\"3\" size=\"3\" format=\"*N\"/><br/>";
  echo "<anchor>Add";
  echo "<go href=\"admproc2.php?action=gccp&amp;clid=$clid\" method=\"post\">";
  echo "<postfield name=\"plss\" value=\"$(plss)\"/>";
  echo "</go></anchor><br/>";
  }
  echo "<br/><a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}
//////////////////////////add chatroom//////////////////////////

else if($action=="addchr")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  /*if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{*/
  echo "<b>Add Room</b><br/><br/>";
  echo "Name:<input name=\"chrnm\" maxlength=\"30\"/><br/>";
  echo "Min Age:<input name=\"chrage\" format=\"*N\" maxlength=\"3\" size=\"3\"/><br/>";
  echo "Max Age:<input name=\"maxage\" format=\"*N\" maxlength=\"3\" size=\"3\"/><br/>";
  echo "Minimum Chat Posts:<input name=\"chrpst\" format=\"*N\" maxlength=\"4\" size=\"4\"/><br/>";
  echo "permission:<select name=\"chrprm\">";
  echo "<option value=\"0\">Member(s)</option>";
  echo "<option value=\"1\">Mod(s)</option>";
  echo "<option value=\"2\">Admin(s)</option>";
  echo "<option value=\"3\">Head Admin(s)</option>";
  echo "<option value=\"4\">Owner(s)</option>";
  echo "</select><br/>";
  echo "Censored:<select name=\"chrcns\">";
  echo "<option value=\"1\">Yes</option>";
  echo "<option value=\"0\">No</option>";
  echo "</select><br/>";
  echo "Fun:<select name=\"chrfun\">";
  echo "<option value=\"0\">No</option>";
  echo "<option value=\"1\">esreveR</option>";
  echo "<option value=\"2\">ravebabe</option>";
  echo "</select><br/>";
  echo "<anchor>Add";
  echo "<go href=\"admproc2.php?action=addchr\" method=\"post\">";
  echo "<postfield name=\"chrnm\" value=\"$(chrnm)\"/>";
  echo "<postfield name=\"chrage\" value=\"$(chrage)\"/>";
  echo "<postfield name=\"maxage\" value=\"$(maxage)\"/>";
  echo "<postfield name=\"chrpst\" value=\"$(chrpst)\"/>";
  echo "<postfield name=\"chrprm\" value=\"$(chrprm)\"/>";
  echo "<postfield name=\"chrcns\" value=\"$(chrcns)\"/>";
  echo "<postfield name=\"chrfun\" value=\"$(chrfun)\"/>";
  echo "</go></anchor>";
 // }
  echo "<br/><br/><a href=\"admincp2.php?action=chrooms\"><img src=\"images/chat.gif\" alt=\"\"/>Chatrooms</a><br/>";
  echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}
//////////////////////////add group//////////////////////////

else if($action=="addgrp")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  /*if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{*/
  echo "<b>Add Group</b><br/><br/>";
  echo "Name:<input name=\"ugname\" maxlength=\"30\"/><br/>";
  echo "Auto Assign:<select name=\"ugaa\">";
  echo "<option value=\"1\">Yes</option>";
  echo "<option value=\"0\">No</option>";
  echo "</select><br/>";
  echo "<br/><b>For Auto Assign Only</b><br/>";
  echo "Allow:<select name=\"allus\">";
  echo "<option value=\"0\">Member(s)</option>";
  echo "<option value=\"1\">Mod(s)</option>";
  echo "<option value=\"2\">Admin(s)</option>";
  echo "<option value=\"3\">Head Admins(s)</option>";
  echo "<option value=\"4\">Owner(s)</option>";
  echo "</select><br/>";
  echo "Min Age:";
  echo "<input name=\"mage\" format=\"*N\" maxlength=\"3\" size=\"3\"/>";
  echo "<br/>Max Age:";
  echo "<input name=\"maxage\" format=\"*N\" maxlength=\"3\" size=\"3\"/>";
  echo "<br/>Min. Posts:";
  echo "<input name=\"mpst\" format=\"*N\" maxlength=\"3\" size=\"3\"/>";
  echo "<br/>Min. Plusses:";
  echo "<input name=\"mpls\" format=\"*N\" maxlength=\"3\" size=\"3\"/><br/>";
  echo "<anchor>Add";
  echo "<go href=\"admproc2.php?action=addgrp\" method=\"post\">";
  echo "<postfield name=\"ugname\" value=\"$(ugname)\"/>";
  echo "<postfield name=\"ugaa\" value=\"$(ugaa)\"/>";
  echo "<postfield name=\"allus\" value=\"$(allus)\"/>";
  echo "<postfield name=\"mage\" value=\"$(mage)\"/>";
  echo "<postfield name=\"maxage\" value=\"$(maxage)\"/>";
  echo "<postfield name=\"mpst\" value=\"$(mpst)\"/>";
  echo "<postfield name=\"mpls\" value=\"$(mpls)\"/>";
  echo "</go></anchor>";
 // }
  echo "<br/><br/><a href=\"admincp2.php?action=ugroups\">UGroups</a><br/>";
  echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}
//////////////////////////edit forum//////////////////////////

else if($action=="edtfrm")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{
  echo "<b>Edit Forum</b><br/><br/>";
  $forums = mysql_query("SELECT id,name FROM dcroxx_me_forums ORDER BY position, id, name");
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
  echo "<anchor>Edit";
  echo "<go href=\"admproc2.php?action=edtfrm\" method=\"post\">";
  echo "<postfield name=\"fid\" value=\"$(fid)\"/>";
  echo "<postfield name=\"frname\" value=\"$(frname)\"/>";
  echo "<postfield name=\"frpos\" value=\"$(frpos)\"/>";
  echo "<postfield name=\"fcid\" value=\"$(fcid)\"/>";
  echo "</go></anchor>";
  }
  echo "<br/><br/><a href=\"admincp2.php?action=forums\">Forums</a><br/>";
  echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}
//////////////////////////delete forum//////////////////////////

else if($action=="delfrm")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{
  echo "<b>Delete Forum</b><br/><br/>";
  $forums = mysql_query("SELECT id,name FROM dcroxx_me_forums ORDER BY position, id, name");
  echo "Forum: <select name=\"fid\">";
  while($forum=mysql_fetch_array($forums))
  {
  echo "<option value=\"$forum[0]\">$forum[1]</option>";
  }
  echo "</select><br/>";
  echo "<anchor>Delete";
  echo "<go href=\"admproc2.php?action=delfrm\" method=\"post\">";
  echo "<postfield name=\"fid\" value=\"$(fid)\"/>";
  echo "</go></anchor>";
  }
  echo "<br/><br/><a href=\"admincp2.php?action=forums\">Forums</a><br/>";
  echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}
//////////////////////////delete group//////////////////////////

else if($action=="delgrp")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  /*if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{*/
  echo "<b>Delete UGroup</b><br/><br/>";
  $forums = mysql_query("SELECT id,name FROM dcroxx_me_groups ORDER BY name, id");
  echo "UGroup: <select name=\"ugid\">";
  while($forum=mysql_fetch_array($forums))
  {
  echo "<option value=\"$forum[0]\">$forum[1]</option>";
  }
  echo "</select><br/>";
  echo "<anchor>Delete";
  echo "<go href=\"admproc2.php?action=delgrp\" method=\"post\">";
  echo "<postfield name=\"ugid\" value=\"$(ugid)\"/>";
  echo "</go></anchor>";
  //}
  echo "<br/><br/><a href=\"admincp2.php?action=forums\">Forums</a><br/>";
  echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}
//////////////////////////edit category//////////////////////////

else if($action=="edtcat")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{
  echo "<b>Edit Category</b><br/><br/>";
  $fcats = mysql_query("SELECT id, name FROM dcroxx_me_fcats ORDER BY position, id, name");
  echo "Edit: <select name=\"fcid\">";
  while ($fcat=mysql_fetch_array($fcats))
  {
  echo "<option value=\"$fcat[0]\">$fcat[1]</option>";
  }
  echo "</select><br/>";
  echo "Name:<input name=\"fcname\" maxlength=\"30\"/><br/>";
  echo "Position:<input name=\"fcpos\" format=\"*N\" size=\"3\"  maxlength=\"3\"/><br/>";
  echo "<anchor>Edit";
  echo "<go href=\"admproc2.php?action=edtcat\" method=\"post\">";
  echo "<postfield name=\"fcid\" value=\"$(fcid)\"/>";
  echo "<postfield name=\"fcname\" value=\"$(fcname)\"/>";
  echo "<postfield name=\"fcpos\" value=\"$(fcpos)\"/>";
  echo "</go></anchor>";
  }
  echo "<br/><br/><a href=\"admincp2.php?action=fcats\">Forum Categories</a><br/>";
  echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}
//////////////////////////delete category//////////////////////////

else if($action=="delcat")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Admin Tools",$pstyle);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  if(!isadmin(getuid_sid($sid)))
  {
  echo "permission Denied!";
  }else{
  echo "<b>Delete Category</b><br/><br/>";
  $fcats = mysql_query("SELECT id, name FROM dcroxx_me_fcats ORDER BY position, id, name");
  echo "Delete: <select name=\"fcid\">";
  while ($fcat=mysql_fetch_array($fcats))
  {
  echo "<option value=\"$fcat[0]\">$fcat[1]</option>";
  }
  echo "</select><br/>";
  echo "<anchor>Delete";
  echo "<go href=\"admproc2.php?action=delcat\" method=\"post\">";
  echo "<postfield name=\"fcid\" value=\"$(fcid)\"/>";
  echo "</go></anchor>";
  }
  echo "<br/><br/><a href=\"admincp2.php?action=fcats\">Forum Categories</a><br/>";
  echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}
//////////////////////////error//////////////////////////

else
{
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
?>
</html>