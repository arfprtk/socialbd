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

if(!ismod(getuid_sid($sid)))

{

  echo "<card id=\"main\" title=\"$sitename\">";

  echo "<p align=\"center\"><small>";

  echo "<b>Permission Denied!</b><br/>";

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

addonline(getuid_sid($sid),"Secret Zone","");

if($action=="penalties"){
$pstyle = gettheme($sid);
echo xhtmlhead("Secret Zone",$pstyle);
  $who = $_GET["who"];
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<center>";
  if(!ismod(getuid_sid($sid))){
  echo "Permission Denied!<br/>";
  }else{
  $unick = getnick_uid($who);
  echo "Moderating Penalties Of $unick";
  echo "<br/><br/>";

echo" <form method=\"post\" action=\"?action=penalties_ok\">";
  if(isheadadmin(getuid_sid($sid)) || isowner(getuid_sid($sid))){
$pen[0]="General Banned (Can't do anything)";
$pen[1]="PM Banned (Can't sent messages)";
$pen[2]="Post Banned (Can't post anywhere)";
$pen[3]="Shout Banned (Can't shout only)";
$pen[4]="Chat Banned (Can't chat only)";
$pen[5]="IP Banned (Can't enter our site)";
}else{
$pen[0]="General Banned (Can't do anything)";
$pen[1]="PM Banned (Can't sent messages)";
$pen[2]="Post Banned (Can't post anywhere)";
$pen[3]="Shout Banned (Can't shout only)";
$pen[4]="Chat Banned (Can't chat only)";
}

echo "Penalty: <br/><select name=\"pid\" style=\"height:30px;width: 270px;\">";
for($i=0;$i<count($pen);$i++){
echo "<option value=\"$i\">$pen[$i]</option>";
}
echo "</select><br/>";
echo"Reason: <br/><textarea name=\"pres\" style=\"height:30px;width: 270px;\" ></textarea><br/>";
echo "Days: <br/><input name=\"pds\" format=\"*N\" maxlength=\"4\" style=\"height:20px;width: 270px;\"/><br/>";
echo "Hours: <br/><input name=\"phr\" format=\"*N\" maxlength=\"4\" style=\"height:20px;width: 270px;\"/><br/>";
echo "Minutes: <br/><input name=\"pmn\" format=\"*N\" maxlength=\"2\" style=\"height:20px;width: 270px;\"/><br/>";
echo "Seconds: <br/><input name=\"psc\" format=\"*N\" maxlength=\"2\" style=\"height:20px;width: 270px;\"/><br/>";
echo "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
echo "<postfield name=\"pid\" value=\"$(pid)\"/>";
echo"<br/><input type=\"submit\" name=\"Submit\" value=\"PUNISH\" style=\"height:40px;width: 276px;\"/><br/>
</form>";

}
echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</center></card>";
}

else if($action=="penalties_ok"){
    $pstyle = gettheme($sid);
    echo xhtmlhead("Admin Tools",$pstyle);
  $pid = $_POST["pid"];
  $who = $_POST["who"];
  $pres = $_POST["pres"];
  $pds = $_POST["pds"];
  $phr = $_POST["phr"];
  $pmn = $_POST["pmn"];
  $psc = $_POST["psc"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  $uid = getuid_sid($sid);
  $pRmxX = mysql_fetch_array(mysql_query("SELECT pRmxX FROM dcroxx_me_users WHERE id='".$uid."'"));
  $trgtpRmxX = mysql_fetch_array(mysql_query("SELECT pRmxX FROM dcroxx_me_users WHERE name='".$user."'"));
  if($trgtpRmxX>$pRmxX){ 
  echo "<b><img src=\"images/notok.gif\" alt=\"x\"/><br/>Error!!!<br/>permission Denied...</b><br/>";
  echo "<br/>U Cannot Ban $user<br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  exit;
  }else{
  echo "<br/>";
 /* $pex = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_penalties WHERE pnreas LIKE '".mysql_escape_string($pres)."'"));
if($pex[0]==0){*/
  if(trim($pres)==""){
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>You must Specify a reson for punishing the user";
  }else{
  $timeto = $pds*24*60*60;
  $timeto += $phr*60*60;
  $timeto += $pmn*60;
  $timeto += $psc;
  $ptime = $timeto + time();
  
  
if ($pid==0){
///////////General Banned///////////////
$res = mysql_query("INSERT INTO dcroxx_me_metpenaltiespl SET uid='".$who."', penalty='1', exid='".getuid_sid($sid)."', timeto='".$ptime."', pnreas='".mysql_escape_string($pres)."'");
 if($res){
  $pmsg[1]="Banned";
  mysql_query("UPDATE dcroxx_me_users SET lastpnreas='".$pmsg[1].": ".mysql_escape_string($pres)."' WHERE id='".$who."'");
  mysql_query("INSERT INTO dcroxx_me_mlog SET action='Penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> Banned the user <b>".$user."</b> for ".mysql_escape_string($pres)." (".gettimemsg($timeto).")', actdt='".time()."'");
mysql_query("INSERT INTO dcroxx_me_private SET text='You are now Banned by [b]Staff Team[/b][br/][small]p.s: this is an automated pm[/small]', byuid='3', touid='".$who."', timesent='".time()."'");
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>$user penalties successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error penalties $user";
  }
///////////General Banned///////////////
}else if ($pid==1){
///////////PM Banned///////////////
$res = mysql_query("UPDATE dcroxx_me_users SET xpmban2x='1', xpmban2xtimeup='".$ptime."' WHERE id='".$who."'");
 if($res){
  $pmsg[1]="PM Banned";
  mysql_query("UPDATE dcroxx_me_users SET lastpnreas='".$pmsg[1].": ".mysql_escape_string($pres)."' WHERE id='".$who."'");
  mysql_query("INSERT INTO dcroxx_me_mlog SET action='Penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> PM Banned the user <b>".$user."</b> for ".mysql_escape_string($pres)." (".gettimemsg($timeto).")', actdt='".time()."'");
mysql_query("INSERT INTO dcroxx_me_private SET text='You are now PM Banned by [b]Staff Team[/b][br/][small]p.s: this is an automated pm[/small]', byuid='3', touid='".$who."', timesent='".time()."'");

  echo "<img src=\"images/ok.gif\" alt=\"O\"/>$user penalties successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error penalties $user";
  }
///////////PM Banned///////////////
}else if ($pid==2){
///////////Post Banned///////////////
$res = mysql_query("UPDATE dcroxx_me_users SET postban='1', postbantimeup='".$ptime."' WHERE id='".$who."'");
 if($res){
  $pmsg[1]="Post Banned";
  mysql_query("UPDATE dcroxx_me_users SET lastpnreas='".$pmsg[1].": ".mysql_escape_string($pres)."' WHERE id='".$who."'");
  mysql_query("INSERT INTO dcroxx_me_mlog SET action='Penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> Post Banned the user <b>".$user."</b> for ".mysql_escape_string($pres)." (".gettimemsg($timeto).")', actdt='".time()."'");
mysql_query("INSERT INTO dcroxx_me_private SET text='You are now Post Banned by [b]Staff Team[/b][br/][small]p.s: this is an automated pm[/small]', byuid='3', touid='".$who."', timesent='".time()."'");

  echo "<img src=\"images/ok.gif\" alt=\"O\"/>$user penalties successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error penalties $user";
  }
///////////Post Banned///////////////
}else if ($pid==3){
///////////Shout Banned///////////////
$res = mysql_query("UPDATE dcroxx_me_users SET shoutban='1', shoutbantimeup='".$ptime."' WHERE id='".$who."'");
 if($res){
  $pmsg[1]="Shout Banned";
  mysql_query("UPDATE dcroxx_me_users SET lastpnreas='".$pmsg[1].": ".mysql_escape_string($pres)."' WHERE id='".$who."'");
  mysql_query("INSERT INTO dcroxx_me_mlog SET action='Penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> Shout Banned the user <b>".$user."</b> for ".mysql_escape_string($pres)." (".gettimemsg($timeto).")', actdt='".time()."'");
mysql_query("INSERT INTO dcroxx_me_private SET text='You are now Shout Banned by [b]Staff Team[/b][br/][small]p.s: this is an automated pm[/small]', byuid='3', touid='".$who."', timesent='".time()."'");

  echo "<img src=\"images/ok.gif\" alt=\"O\"/>$user penalties successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error penalties $user";
  }
///////////Shout Banned///////////////
}else if ($pid==4){
///////////Chat Banned///////////////
$res = mysql_query("UPDATE dcroxx_me_users SET chatban='1', chatbantimeup='".$ptime."' WHERE id='".$who."'");
 if($res){
  $pmsg[1]="Chat Banned";
  mysql_query("UPDATE dcroxx_me_users SET lastpnreas='".$pmsg[1].": ".mysql_escape_string($pres)."' WHERE id='".$who."'");
  mysql_query("INSERT INTO dcroxx_me_mlog SET action='Penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> Chat Banned the user <b>".$user."</b> for ".mysql_escape_string($pres)." (".gettimemsg($timeto).")', actdt='".time()."'");
mysql_query("INSERT INTO dcroxx_me_private SET text='You are now Chat Banned by [b]Staff Team[/b][br/][small]p.s: this is an automated pm[/small]', byuid='3', touid='".$who."', timesent='".time()."'");

  echo "<img src=\"images/ok.gif\" alt=\"O\"/>$user penalties successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error penalties $user";
  }
///////////Chat Banned///////////////
}else if ($pid==5){
///////////IP Banned///////////////
$uipbrw = mysql_fetch_array(mysql_query("SELECT ipadd, browserdet FROM dcroxx_me_users WHERE id='".$who."'"));
$res = mysql_query("INSERT INTO dcroxx_me_metpenaltiespl SET uid='".$who."', penalty='2', exid='".getuid_sid($sid)."', timeto='".$ptime."', pnreas='".mysql_escape_string($pres)."', ipadd='".$uipbrw[0]."' AND browserm='".$uipbrw[1]."'");
 if($res){
  $pmsg[1]="IP Banned";
  mysql_query("UPDATE dcroxx_me_users SET lastpnreas='".$pmsg[1].": ".mysql_escape_string($pres)."' WHERE id='".$who."'");
  mysql_query("INSERT INTO dcroxx_me_mlog SET action='Penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> IP Banned the user <b>".$user."</b> for ".mysql_escape_string($pres)." (".gettimemsg($timeto).")', actdt='".time()."'");
mysql_query("INSERT INTO dcroxx_me_private SET text='You are now IP Banned by [b]Staff Team[/b][br/][small]p.s: this is an automated pm[/small]', byuid='3', touid='".$who."', timesent='".time()."'");

  echo "<img src=\"images/ok.gif\" alt=\"O\"/>$user penalties successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error penalties $user";
  }
///////////IP Banned///////////////
}

 }
 /* }else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>There is another account which is already banned with this reason";
}*/
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"admincp2.php?action=admncp\"><img src=\"images/admn.gif\" alt=\"\"/>Prime Minister/Minister Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  }
  echo "</card>";
}


else if($action=="penalties_with"){
    $pstyle = gettheme($sid);
    echo xhtmlhead("Secret Zone",$pstyle);
  $who = $_GET["who"];
  $cat = $_GET["cat"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"Admin Tools\">";
  echo "<p align=\"center\"><small>";
  
if ($cat==unban){
$res = mysql_query("DELETE FROM dcroxx_me_metpenaltiespl WHERE penalty='1' AND uid='".$who."'");
if($res){
$unick = getnick_uid($who);
mysql_query("INSERT INTO dcroxx_me_mlog SET action='Penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> Un-Banned the user <b>".$unick."</b>', actdt='".time()."'");
mysql_query("INSERT INTO dcroxx_me_private SET text='You are now Un-banned by [b]Staff Team[/b][br/][small]p.s: this is an automated pm[/small]', byuid='3', touid='".$who."', timesent='".time()."'");
echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick Unbanned";
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
}
}else if ($cat==pmunban){
$res = mysql_query("UPDATE dcroxx_me_users SET xpmban2x='0', xpmban2xtimeup='0' WHERE id='".$who."'");
if($res){
$unick = getnick_uid($who);
mysql_query("INSERT INTO dcroxx_me_mlog SET action='Penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> PM Un-Banned the user <b>".$unick."</b>', actdt='".time()."'");
mysql_query("INSERT INTO dcroxx_me_private SET text='You are now PM Un-banned by [b]Staff Team[/b][br/][small]p.s: this is an automated pm[/small]', byuid='3', touid='".$who."', timesent='".time()."'");
echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick Unbanned";
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
}
}else if ($cat==postunban){
$res = mysql_query("UPDATE dcroxx_me_users SET postban='0', postbantimeup='0' WHERE id='".$who."'");
if($res){
$unick = getnick_uid($who);
mysql_query("INSERT INTO dcroxx_me_mlog SET action='Penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> Post Un-Banned the user <b>".$unick."</b>', actdt='".time()."'");
mysql_query("INSERT INTO dcroxx_me_private SET text='You are now Post Un-banned by [b]Staff Team[/b][br/][small]p.s: this is an automated pm[/small]', byuid='3', touid='".$who."', timesent='".time()."'");
echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick Unbanned";
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
}
}else if ($cat==shoutunban){
$res = mysql_query("UPDATE dcroxx_me_users SET shoutban='0', shoutbantimeup='0' WHERE id='".$who."'");
if($res){
$unick = getnick_uid($who);
mysql_query("INSERT INTO dcroxx_me_mlog SET action='Penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> Shout Un-Banned the user <b>".$unick."</b>', actdt='".time()."'");
mysql_query("INSERT INTO dcroxx_me_private SET text='You are now Shout Un-banned by [b]Staff Team[/b][br/][small]p.s: this is an automated pm[/small]', byuid='3', touid='".$who."', timesent='".time()."'");
echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick Unbanned";
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
}
}else if ($cat==chatunban){
$res = mysql_query("UPDATE dcroxx_me_users SET chatban='0', chatbantimeup='0' WHERE id='".$who."'");
if($res){
$unick = getnick_uid($who);
mysql_query("INSERT INTO dcroxx_me_mlog SET action='Penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> Chat Un-Banned the user <b>".$unick."</b>', actdt='".time()."'");
mysql_query("INSERT INTO dcroxx_me_private SET text='You are now Chat Un-banned by [b]Staff Team[/b][br/][small]p.s: this is an automated pm[/small]', byuid='3', touid='".$who."', timesent='".time()."'");
echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick Unbanned";
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
}
}else if ($cat==ipnipnip){
$res = mysql_query("DELETE FROM dcroxx_me_metpenaltiespl WHERE penalty='2' AND uid='".$who."'");
if($res){
$unick = getnick_uid($who);
mysql_query("INSERT INTO dcroxx_me_mlog SET action='Penalties', details='<b>".getnick_uid(getuid_sid($sid))."</b> IP Un-Banned the user <b>".$unick."</b>', actdt='".time()."'");
mysql_query("INSERT INTO dcroxx_me_private SET text='Your IP is now un-banned by [b]Staff Team[/b][br/][small]p.s: this is an automated pm[/small]', byuid='3', touid='".$who."', timesent='".time()."'");

echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick Unbanned";
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
}
}
  
  
  
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"admincp2.php?action=admincp\"><img src=\"images/admn.gif\" alt=\"\"/>Admin Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
/////////////////////////////////////////////////
else if($action=="plsopt"){
$pstyle = gettheme($sid);
echo xhtmlhead("Secret Zone",$pstyle);
  $who = $_GET["who"];
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<center>";
  if(!ismod(getuid_sid($sid))){
  echo "Permission Denied!<br/>";
  }else{
  $unick = getnick_uid($who);
  echo "Add/Substract $unick's Plusses";
  echo "<br/><br/>";

echo" <form method=\"post\" action=\"?action=pls\">";
$pen[0]="Decrease Plusses (-)";
$pen[1]="Increase Plusses (+)";
echo "Action: <br/><select name=\"pid\" style=\"height:30px;width: 270px;\">";
for($i=0;$i<count($pen);$i++){
echo "<option value=\"$i\">$pen[$i]</option>";
}
echo "</select><br/>";
echo"Reason: <br/><textarea name=\"pres\" style=\"height:30px;width: 270px;\" ></textarea><br/>";
echo "Plusses: <br/><input name=\"pval\" format=\"*N\" maxlength=\"4\" style=\"height:25px;width: 270px;\"/><br/>";
echo "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
echo "<postfield name=\"pid\" value=\"$(pid)\"/>";
echo"<input type=\"submit\" name=\"Submit\" value=\"UPDATE\" style=\"height:30px;width: 276px;\"/><br/>
</form>";

}
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</center></card>";
}


else if($action=="pls"){
    $pstyle = gettheme($sid);
    echo xhtmlhead("Secret Zone",$pstyle);
$pid = $_POST["pid"];
$who = $_POST["who"];
$pres = $_POST["pres"];
$pval = $_POST["pval"];

echo "<card id=\"main\" title=\"Admin Tools\">";
echo "<p align=\"center\"><small>";
if(!ismod(getuid_sid($sid))){echo "Permission Denied!";}else{
$unick = getnick_uid($who);
$opl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
if($pid=='0'){$npl = $opl[0] - $pval;}else{$npl = $opl[0] + $pval;}
if($npl<0){$npl=0;}
if(trim($pres)==""){
echo "<img src=\"images/notok.gif\" alt=\"X\"/>You must Specify a reson for updating $unick's Plusses";
}else{
$res = mysql_query("UPDATE dcroxx_me_users SET lastplreas='".mysql_escape_string($pres)."', plusses='".$npl."' WHERE id='".$who."'");
if($res){
mysql_query("INSERT INTO dcroxx_me_mlog SET action='Plusses', details='<b>".getnick_uid(getuid_sid($sid))."</b> Updated <b>".$unick."</b> plusses from ".$opl[0]." to $npl', actdt='".time()."'");
$tm = time()+6*60*60;
$uid = getuid_sid($sid);
$nick = getnick_uid($uid);
$user = getnick_sid($sid);
mysql_query("INSERT INTO ibwf_plusseslogs SET res='".mysql_escape_string($pres)."', byuid='".$uid."', touid='".$who."', beforeplusses='".$opl[0]."', atmplusses='".$npl."', time='".$tm."'");
mysql_query("INSERT INTO dcroxx_me_private SET text='[b]NOTIFICATION:[/b][br/]I have updated your plusses from ".$opl[0]." to ".$npl."[br/][small]p.s: this is an automated pm[/small]', byuid='".getuid_sid($sid)."', touid='".$who."', timesent='".time()."'");
echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick's Plusses Updated From $opl[0] to $npl";
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
}}}
  echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}

else if($action=="rppr"){
$pstyle = gettheme($sid);
echo xhtmlhead("Secret Zone",$pstyle);
  $who = $_GET["who"];
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<center>";
  if(!ismod(getuid_sid($sid))){
  echo "Permission Denied!<br/>";
  }else{
  $unick = getnick_uid($who);
  echo "Add/Substract $unick's Reputation Points";
  echo "<br/><br/>";

echo" <form method=\"post\" action=\"?action=rpprok\">";
$pen[0]="Decrease Reputation Points (-)";
$pen[1]="Increase Reputation Points (+)";
echo "Action: <br/><select name=\"pid\" style=\"height:30px;width: 270px;\">";
for($i=0;$i<count($pen);$i++){
echo "<option value=\"$i\">$pen[$i]</option>";
}
echo "</select><br/>";
echo"Reason: <br/><textarea name=\"pres\" style=\"height:30px;width: 270px;\" ></textarea><br/>";
echo "Reputation Points: <br/><input name=\"pval\" format=\"*N\" maxlength=\"4\" style=\"height:25px;width: 270px;\"/><br/>";
echo "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
echo "<postfield name=\"pid\" value=\"$(pid)\"/>";
echo"<input type=\"submit\" name=\"Submit\" value=\"UPDATE\" style=\"height:30px;width: 276px;\"/><br/>
</form>";

}
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</center></card>";
}


else if($action=="rpprok"){
    $pstyle = gettheme($sid);
    echo xhtmlhead("Secret Zone",$pstyle);
$pid = $_POST["pid"];
$who = $_POST["who"];
$pres = $_POST["pres"];
$pval = $_POST["pval"];

echo "<card id=\"main\" title=\"Admin Tools\">";
echo "<p align=\"center\"><small>";
if(!ismod(getuid_sid($sid))){echo "Permission Denied!";}else{
$unick = getnick_uid($who);
$opl = mysql_fetch_array(mysql_query("SELECT rp FROM dcroxx_me_users WHERE id='".$who."'"));
if($pid=='0'){$npl = $opl[0] - $pval;}else{$npl = $opl[0] + $pval;}
if($npl<0){$npl=0;}
if(trim($pres)==""){
echo "<img src=\"images/notok.gif\" alt=\"X\"/>You must Specify a reson for updating $unick's Reputation Points";
}else{
$res = mysql_query("UPDATE dcroxx_me_users SET lastplreas='".mysql_escape_string($pres)."', rp='".$npl."' WHERE id='".$who."'");
if($res){
mysql_query("INSERT INTO dcroxx_me_mlog SET action='Reputation', details='<b>".getnick_uid(getuid_sid($sid))."</b> updated <b>".$unick."</b> RP from ".$opl[0]." to $npl', actdt='".time()."'");
$tm = time()+6*60*60;
$uid = getuid_sid($sid);
$nick = getnick_uid($uid);
$user = getnick_sid($sid);
mysql_query("INSERT INTO dcroxx_me_private SET text='[b]NOTIFICATION:[/b][br/]I have updated your RP from ".$opl[0]." to ".$npl."[br/][small]p.s: this is an automated pm[/small]', byuid='".getuid_sid($sid)."', touid='".$who."', timesent='".time()."'");
echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick's Reputation Points updated From $opl[0] to $npl";
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
}}}
  echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
else if($action=="kick")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Secret Zone",$pstyle);
  $who = $_GET["who"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  $uid = getuid_sid($sid);
  $pRmxX = mysql_fetch_array(mysql_query("SELECT pRmxX FROM dcroxx_me_users WHERE id='".$uid."'"));
  $trgtpRmxX = mysql_fetch_array(mysql_query("SELECT pRmxX FROM dcroxx_me_users WHERE name='".$user."'"));
  if($trgtpRmxX>$pRmxX){ 
  echo "<b><img src=\"images/notok.gif\" alt=\"x\"/><br/>Error!!!<br/>permission Denied...</b><br/>";
  echo "<br/>U Cannot Boot $user<br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  }else{
  echo "<br/>";
  $res = mysql_query("DELETE FROM dcroxx_me_ses WHERE uid='".$who."'");
  if($res)
  {
  mysql_query("INSERT INTO dcroxx_me_mlog SET action='Kick', details='<b>".getnick_uid(getuid_sid($sid))."</b> kicked <b>$user</b>', actdt='".time()."'");
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>$user kicked successfully";
  mysql_query("DELETE FROM dcroxx_me_online WHERE userid='".$who."'");
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error kicking $user";
  }
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  }
  echo "</card>";
}

////////////////account disable
else if($action=="disableac")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Secret Zone",$pstyle);
  $who = $_GET['who'];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"ModCP\">"; 
  echo "<p align=\"center\">";
  if(isdisabled($who)){
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>This account is already disabled";
  }else{
  echo "Disable <b>$user</b>'s Account<br/>";

 echo"<center>
<form action=\"?action=disableacc&amp;who=$who\" method=\"post\">
Disable Reasons:<br/>
<textarea id=\"inputText\" name=\"shtxt\" style=\"height:50px;width: 270px;\" ></textarea><br/>";
echo "<input id=\"inputButton\" type=\"submit\" value=\"Disable\" style=\"height:30px;width: 276px;\" /></form></center><br/>";

  }
  echo"</p><p align=\"center\"><small>";
  echo "<a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
else if($action=="disableacc")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Secret Zone",$pstyle);
  $who = isnum((int)$_GET['who']);
  $shtxt = $_POST['shtxt'];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"ModCP\">"; 
  echo "<p align=\"center\">";
  if(isdisabled($who)){
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>This account is already disabled";
  }else{
	  $pex = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE 2x_disable_reas LIKE '".$shtxt."'"));
if($pex[0]==0)
{
/////////////
  $res = mysql_query("UPDATE dcroxx_me_users SET 2x_disabl_acc='1', 2x_disable_reas='".$shtxt."', 2x_disable_uid='".$uid."', name='disabled_".$who."', origin_nick='".$user."' WHERE id='".$who."'");
  if($res)
  {
    $res = mysql_query("DELETE FROM dcroxx_me_ses WHERE uid='".$who."'");
    mysql_query("INSERT INTO dcroxx_me_private SET text='[b]NOTIFICATION:[/b][br/]Your account is disabled by [b]Staff Team[/b][br/][small]p.s: this is an automated pm[/small]', byuid='3', touid='".$who."', timesent='".time()."'");
 mysql_query("INSERT INTO dcroxx_me_mlog SET action='Disable_Account', details='<b>".getnick_uid(getuid_sid($sid))."</b> disabled the account of <b>".$user."</b>', actdt='".time()."'");
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Disabled Successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
  }
  }else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>a previous disable reason is match with you disable reason. So, please change the disable reason for this account.";
}
  }
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p></card>";
}
/////////////////account enable
else if($action=="enableacc")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Secret Zone",$pstyle);
  $who = isnum((int)$_GET['who']);
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"ModCP\">"; 
  echo "<p align=\"center\">";
  if(!isdisabled($who)){
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>This account is not disabled for enabling";
  }else{
  $pex = mysql_fetch_array(mysql_query("SELECT origin_nick FROM dcroxx_me_users WHERE id='".$who."'"));
  if ($pex[0]==""){$naaam = "userid_$who";}else{$naaam = $pex[0];}
  $res = mysql_query("UPDATE dcroxx_me_users SET 2x_disabl_acc='0', name='".$naaam."', origin_nick='' WHERE id='".$who."'");
  if($res)
  {
    mysql_query("INSERT INTO dcroxx_me_private SET text='[b]NOTIFICATION:[/b][br/]Your account is enabled by [b]Staff Team[/b][br/][small]p.s: this is an automated pm[/small]', byuid='3', touid='".$who."', timesent='".time()."'");
 mysql_query("INSERT INTO dcroxx_me_mlog SET action='Enable_Account', details='<b>".getnick_uid(getuid_sid($sid))."</b> enabled the account of <b>".$user."</b>', actdt='".time()."'");
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Enabled Successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
  }
  }
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p></card>";
}

else if($action=="disablelist")
{
    addonline(getuid_sid($sid),"Admin Tools","");
	    $pstyle = gettheme($sid);
    echo xhtmlhead("Disabled Accounts",$pstyle);
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
    
        $sql = "SELECT id, origin_nick FROM dcroxx_me_users WHERE 2x_disabl_acc='1' ORDER BY name  LIMIT $limit_start, $items_per_page";
    

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
	if ($item[1]==""){
	$dis_nick = "disabled";
	}else{
	$dis_nick = "$item[1]";
	}
  $uick = getnick_uid($nopl[1]);
    $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$dis_nick</a> ($nopl[0])<br/>
	Disabled by: <a href=\"index.php?action=viewuser&amp;who=$nopl[1]\">$uick</a>";
    echo "$lnk<br/><br/>";
    }
    }
    echo "</small></p>";
    echo "<p align=\"center\"><small>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"admincp.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"admincp.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"admincp.php\" method=\"get\">";
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

else if($action=="validatelist")
{
$pstyle = gettheme($sid);
echo xhtmlhead("Secret Zone",$pstyle);
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

    $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1] ($uage/$usex/$nopl[2])</a>";
    echo "$lnk<br/>";
    }
    }
    echo "</small></p>";
    echo "<p align=\"center\"><small>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"md.php?action=validatelist&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"md.php?action=validatelist&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"md.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"validatelist\"/>";
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
else if($action=="active_id")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Secret Zone",$pstyle);
  $who = $_GET["who"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"Admin Tools\">";
  echo "<p align=\"center\"><small>";
  $res = mysql_query("Update dcroxx_me_users SET validated='1' WHERE id='".$who."'");
  if($res)
  {
  mysql_query("INSERT INTO dcroxx_me_private SET text='[b]NOTIFICATION:[/b][br/]Congratulations![br/]Your account is activated by [b]Staff Team[/b].[br/] You can enjoy our full features from now...[br/][small]p.s: this is an automated pm[/small]', byuid='3', touid='".$who."', timesent='".time()."'");
  mysql_query("INSERT INTO dcroxx_me_mlog SET action='Validation', details='<b>".getnick_uid(getuid_sid($sid))."</b> validate <b>$user</b> account', actdt='".time()."'");
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>$user activated successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error activating $user";
  }
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}

else if($action=="disablesht")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Secret Zone",$pstyle);
  $who = $_GET['who'];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"ModCP\">"; 
  echo "<p align=\"center\">";
  echo"<b>Disable Shout</b><br/>";
  echo "<center><form action=\"md.php?action=disableshtOK\" method=\"post\">";
  echo "Reason: <br/><textarea name=\"pres\" style=\"height:50px;width: 270px;\" ></textarea><br/>";
  echo "Minutes: <br/><input name=\"pmn\" format=\"*N\" maxlength=\"2\" style=\"height:30px;width: 270px;\"/><br/>";
  echo "Seconds: <br/><input name=\"psc\" format=\"*N\" maxlength=\"2\" style=\"height:30px;width: 270px;\"/><br/>";
  echo "<postfield name=\"pres\" value=\"$(pres)\"/>";
  echo "<postfield name=\"pmn\" value=\"$(pmn)\"/>";
  echo "<postfield name=\"psc\" value=\"$(psc)\"/>";
  echo "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
  echo "<br/><input type=\"Submit\" Name=\"Submit\" Value=\"DISABLE\" style=\"height:30px;width: 276px;\"></form></center>";
   
  echo"</p><p align=\"center\"><small>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}


else if($action=="disableshtOK")
{
  $who = $_POST["who"];
  $pres = $_POST["pres"];
  $pmn = $_POST["pmn"];
  $psc = $_POST["psc"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";

  $uid = getuid_sid($sid);
  echo "<br/>";
  if(trim($pres)==""){
  echo "<img src=\"../icons/notok.gif\" alt=\"X\"/>You must Specify a reason for disable shout";
  }else{
  $timeto += $pmn*60;
  $timeto += $psc;
  $ptime = $timeto + time();
  $res = mysql_query("INSERT INTO ibwfrr_disable_shout SET uid='".$uid."', timeto='".$ptime."', pnreas='".mysql_escape_string($pres)."'");
  if($res)
  {
  mysql_query("INSERT INTO dcroxx_me_mlog SET action='ShoutBoX', details='<b>".getnick_uid(getuid_sid($sid))."</b> disabled shoutbox for ".mysql_escape_string($pres)." (".gettimemsg($timeto).")', actdt='".time()."'");
  echo "<img src=\"../icons/ok.gif\" alt=\"O\"/>Shoutbox disable successfully";
  }else{
  echo "<img src=\"../icons/notok.gif\" alt=\"X\"/>Error disable shoutbox";
  }
  }

  echo "<br/><br/><a href=\"index.php?action=admincp\"><img src=\"../icons/admn.gif\" alt=\"\"/>Admin Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"../icons/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";

  echo "</card>";
}

else if($action=="enablesht")
{
  $who = $_POST["who"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\"><small>";
  $uid = getuid_sid($sid);
  $res = mysql_query("DELETE FROM ibwfrr_disable_shout");
  if($res)
  {
  mysql_query("INSERT INTO dcroxx_me_mlog SET action='ShoutBoX', details='<b>".getnick_uid(getuid_sid($sid))."</b> enable shoutbox', actdt='".time()."'");
  echo "<img src=\"../icons/ok.gif\" alt=\"O\"/>Shoutbox enable successfully";
  }else{
  echo "<img src=\"../icons/notok.gif\" alt=\"X\"/>Error enable shoutbox";
  }

  echo "<br/><br/><a href=\"index.php?action=admincp\"><img src=\"../icons/admn.gif\" alt=\"\"/>Admin Tools</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"../icons/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}
//////////////delete pms
else if($action=="delprivate"){
$pstyle = gettheme($sid);
echo xhtmlhead("Secret Zone",$pstyle);
  $who = $_GET["who"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"President Tools\">";
  echo "<p align=\"center\"><small>";
  $uid = getuid_sid($sid);
  $pRmxX = mysql_fetch_array(mysql_query("SELECT pRmxX FROM dcroxx_me_users WHERE id='".$uid."'"));
  $trgtpRmxX = mysql_fetch_array(mysql_query("SELECT pRmxX FROM dcroxx_me_users WHERE name='".$user."'"));

  if($trgtpRmxX>$pRmxX){ 
  echo "<b><img src=\"images/notok.gif\" alt=\"x\"/><br/>Error!!!<br/>Permission Denied...</b><br/>";
  echo "<br/>U Cannot Delete $user<br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  }else{

  echo "<br/>";
  $res = mysql_query("DELETE FROM dcroxx_me_private WHERE byuid='".$who."' AND unread='0' OR unread='1'");
  if($res){
 mysql_query("INSERT INTO dcroxx_me_mlog SET action='PMs', details='<b>".getnick_uid(getuid_sid($sid))."</b> deleted all sent PMs of <b>$user</b>', actdt='".time()."'");

  echo "<img src=\"images/ok.gif\" alt=\"O\"/>User PMs deleted";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error deleting";
  }
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  }
  echo "</small></p></card>";
}

else if($action=="en_val"){
$pstyle = gettheme($sid);
echo xhtmlhead("Secret Zone",$pstyle);
  echo "<card id=\"main\" title=\"President Tools\">";
  echo "<p align=\"center\"><small>";
  $uid = getuid_sid($sid);
  $res = mysql_query("UPDATE dcroxx_me_settings SET value='1' WHERE name='vldtn'");
  if($res){
 mysql_query("INSERT INTO dcroxx_me_mlog SET action='Validation', details='<b>".getnick_uid(getuid_sid($sid))."</b> enable user validation', actdt='".time()."'");
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Validation Enabled";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error enabling";
  }
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
else if($action=="dis_val"){
$pstyle = gettheme($sid);
echo xhtmlhead("Secret Zone",$pstyle);
  echo "<card id=\"main\" title=\"President Tools\">";
  echo "<p align=\"center\"><small>";
  $uid = getuid_sid($sid);
  $res = mysql_query("UPDATE dcroxx_me_settings SET value='0' WHERE name='vldtn'");
  if($res){
 mysql_query("INSERT INTO dcroxx_me_mlog SET action='Validation', details='<b>".getnick_uid(getuid_sid($sid))."</b> disable user validation', actdt='".time()."'");
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Validation Disabled";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error disabling";
  }
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}

else if($action=="en_reg"){
$pstyle = gettheme($sid);
echo xhtmlhead("Secret Zone",$pstyle);
  echo "<card id=\"main\" title=\"President Tools\">";
  echo "<p align=\"center\"><small>";
  $uid = getuid_sid($sid);
  $res = mysql_query("UPDATE dcroxx_me_settings SET value='1' WHERE name='reg'");
  if($res){
 mysql_query("INSERT INTO dcroxx_me_mlog SET action='Registration', details='<b>".getnick_uid(getuid_sid($sid))."</b> enable user registration', actdt='".time()."'");
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Registration Enabled";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error enabling";
  }
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
else if($action=="dis_reg"){
$pstyle = gettheme($sid);
echo xhtmlhead("Secret Zone",$pstyle);
  echo "<card id=\"main\" title=\"President Tools\">";
  echo "<p align=\"center\"><small>";
  $uid = getuid_sid($sid);
  $res = mysql_query("UPDATE dcroxx_me_settings SET value='0' WHERE name='reg'");
  if($res){
 mysql_query("INSERT INTO dcroxx_me_mlog SET action='Registration', details='<b>".getnick_uid(getuid_sid($sid))."</b> disable user registration', actdt='".time()."'");
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>Registration Disabled";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error disabling";
  }
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}


else if($action=="waropt0"){
$pstyle = gettheme($sid);
echo xhtmlhead("Secret Zone",$pstyle);
  $who = $_GET["who"];
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\">";
  if(!ismod(getuid_sid($sid)))
  {
  echo "Permission Denied!<br/>";
  }else{
  $unick = getnick_uid($who);
  echo "Increase Warning Of $unick";
  echo "</p>";
 

  echo" <center>
<form method=\"post\" action=\"?action=war0\">";
echo"Reason: <br/><textarea name=\"pres\" style=\"height:50px;width: 270px;\" ></textarea><br/>";
echo "Give Percent: (Only Numeric)<br/><input name=\"pval\" format=\"*N\" maxlength=\"4\" style=\"height:25px;width: 270px;\"/><br/>";
	    echo "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
echo"<input type=\"submit\" name=\"Submit\" value=\"WARN NOW\" style=\"height:30px;width: 276px;\"/><br/>
</form>";

  }
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</center></card>";
}
else if($action=="waropt1"){
$pstyle = gettheme($sid);
echo xhtmlhead("Secret Zone",$pstyle);
  $who = $_GET["who"];
  echo "<card id=\"main\" title=\"Prime Minister/Minister Tools\">";
  echo "<p align=\"center\">";
  if(!ismod(getuid_sid($sid)))
  {
  echo "Permission Denied!<br/>";
  }else{
  $unick = getnick_uid($who);
  echo "Decrease Warning Of $unick";
  echo "</p>";
 

  echo" <center>
<form method=\"post\" action=\"?action=war1\">";
echo"Reason: <br/><textarea name=\"pres\" style=\"height:50px;width: 270px;\" ></textarea><br/>";
echo "Give Percent: (Only Numeric)<br/><input name=\"pval\" format=\"*N\" maxlength=\"4\" style=\"height:25px;width: 270px;\"/><br/>";
	    echo "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
echo"<input type=\"submit\" name=\"Submit\" value=\"COOL NOW\" style=\"height:30px;width: 276px;\"/><br/>
</form>";

  }
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</center></card>";
}

else if($action=="war0"){
    $pstyle = gettheme($sid);
    echo xhtmlhead("Secret Zone",$pstyle);
    $who = $_POST["who"];
    $pres = $_POST["pres"];
    $pval = $_POST["pval"];
    echo "<card id=\"main\" title=\"Admin Tools\">";
  echo "<p align=\"center\"><small>";
  if(!ismod(getuid_sid($sid))){
  echo "Permission Denied!";
  }else{
$unick = getnick_uid($who);
$opl = mysql_fetch_array(mysql_query("SELECT warning FROM dcroxx_me_users WHERE id='".$who."'"));
    $npl = $opl[0] + $pval;
if($npl<0){
  $npl=0;
}
if(trim($pres)==""){
echo "<img src=\"images/notok.gif\" alt=\"X\"/>You must Specify a reason for warning to $unick";
}else{
$res = mysql_query("UPDATE dcroxx_me_users SET warning='".$npl."' WHERE id='".$who."'");
if($res){
mysql_query("INSERT INTO ibwf_warlog SET uid='".$uid."', toid='".$who."', res='".$pres."', time='".time()."'");
echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick's warning level Updated From $opl[0] to $npl";
mysql_query("INSERT INTO dcroxx_me_mlog SET action='Warning', details='<b>".getnick_uid(getuid_sid($sid))."</b> increase <b>".$unick."</b> warning from ".$opl[0]." to $npl', actdt='".time()."'");
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
}}}
echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p></card>";
}
else if($action=="war1"){
    $pstyle = gettheme($sid);
    echo xhtmlhead("Secret Zone",$pstyle);
    $who = $_POST["who"];
    $pres = $_POST["pres"];
    $pval = $_POST["pval"];
    echo "<card id=\"main\" title=\"Admin Tools\">";
  echo "<p align=\"center\"><small>";
  if(!ismod(getuid_sid($sid))){
  echo "Permission Denied!";
  }else{
$unick = getnick_uid($who);
$opl = mysql_fetch_array(mysql_query("SELECT warning FROM dcroxx_me_users WHERE id='".$who."'"));
    $npl = $opl[0] - $pval;
if($npl<0){
  $npl=0;
}
if(trim($pres)==""){
echo "<img src=\"images/notok.gif\" alt=\"X\"/>You must Specify a reason for warning to $unick";
}else{
$res = mysql_query("UPDATE dcroxx_me_users SET warning='".$npl."' WHERE id='".$who."'");
if($res){
mysql_query("INSERT INTO ibwf_warlog SET uid='".$uid."', toid='".$who."', res='".$pres."', time='".time()."'");
echo "<img src=\"images/ok.gif\" alt=\"O\"/>$unick's warning level Updated From $opl[0] to $npl";
mysql_query("INSERT INTO dcroxx_me_mlog SET action='Warning', details='<b>".getnick_uid(getuid_sid($sid))."</b> decrease <b>".$unick."</b> warning from ".$opl[0]." to $npl', actdt='".time()."'");
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
}}}
echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p></card>";
}

else if($action=="srb"){
    $pstyle = gettheme($sid);
    echo xhtmlhead("Secret Zone",$pstyle);
    $who = $_GET["who"];
    echo "<card id=\"main\" title=\"Admin Tools\">";
  echo "<p align=\"center\"><small>";
  if(!ismod(getuid_sid($sid))){
  echo "Permission Denied!";
  }else{
$unick = getnick_uid($who);
$mynick = getnick_uid(getuid_sid($sid));
//$res = mysql_query("UPDATE dcroxx_me_users SET warning='".$npl."' WHERE id='".$who."'");
$res = mysql_query("INSERT INTO dcroxx_me_private SET text='[b]$mynick"."[/b] requested to you for approve [b]$unick"."[/b] [aFardin=md.php?action=srbok&who=$who]SPAM REPORT BONUS"."[/aFardin][br/][small]p.s: this is an automated pm[/small]', byuid='3', touid='1', timesent='".time()."'");

if($res){
echo "<img src=\"images/ok.gif\" alt=\"O\"/>A request has been sent to site Admin. He will approve this request soon till then, wait for his response.";
mysql_query("INSERT INTO dcroxx_me_mlog SET action='Report_Bonus', details='<b>".getnick_uid(getuid_sid($sid))."</b> requested for approve Spam Report Bonus to <b>".$unick."</b> ', actdt='".time()."'");
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error";
}}
echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
echo "</small></p></card>";
}

else if($action=="srbok")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Secret Zone",$pstyle);
  $who = $_GET["who"];
  $user = getnick_uid($who);
  echo "<card id=\"main\" title=\"Admin Tools\">";
  echo "<p align=\"center\"><small>";
  $opl = mysql_fetch_array(mysql_query("SELECT balance, ref_amount FROM dcroxx_me_users WHERE id='".$who."'"));
  $npl = $opl[0] + 0.50;
  $npl0 = $opl[1] + 0.50;
 // $res = mysql_query("Update dcroxx_me_users SET validated='1' WHERE id='".$who."'");
  $res = mysql_query("UPDATE dcroxx_me_users SET lastplreas='BDT: 0.50 for Spam Report Bonus', balance='".$npl."', ref_amount='".$npl0."' WHERE id='".$who."'");
  if($res){
  mysql_query("INSERT INTO dcroxx_me_private SET text='Congratulations![br/]You have awarded [b]0.50 BDT[/b] by [b]Staff Team[/b] for reported about a spam.[br/][small]p.s: this is an automated pm[/small]', byuid='3', touid='".$who."', timesent='".time()."'");
  mysql_query("INSERT INTO dcroxx_me_mlog SET action='Report_Bonus', details='<b>".getnick_uid(getuid_sid($sid))."</b> approve the request for Spam Report Bonus of <b>$user</b>', actdt='".time()."'");
  echo "<img src=\"images/ok.gif\" alt=\"O\"/>$user rewarded successfully";
  }else{
  echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error rewarding $user";
  }
  echo "<br/><br/><a href=\"index.php?action=viewuser&amp;who=$who\">$user's Profile</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}

else if($action=="scan_brw")
{
    addonline(getuid_sid($sid),"Scan Multi IDs","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Secret Zone",$pstyle);
    //////ALL LISTS SCRIPT <<
    $who = $_GET["who"];
    $whoinfo = mysql_fetch_array(mysql_query("SELECT browserdet FROM dcroxx_me_users WHERE id='".$who."'"));
    if(ismod(getuid_sid($sid))){
    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE browserdet='".$whoinfo[0]."'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, name FROM dcroxx_me_users WHERE browserdet='".$whoinfo[0]."' ORDER BY lastact  LIMIT $limit_start, $items_per_page";


    echo "<p>";
	echo"<b>Multi ID Scan Reports:</b><br/>
	Current Browser: <b>$whoinfo[0]</b><br/>
	<a href=\"index.php?action=viewuser&amp;who=$item[0]\">Block This Browser</a><br/><br/>
	Before blocking a browser please see how many peoples will be blocked.<br/><br/>";
	echo"<b>Members Using Same Browsers:</b><br/>";
    $items = mysql_query($sql);

    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {

      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
        $rets .= "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
    }else{
      echo "<p align=\"center\">";
      echo "You can't view this list";
      echo "</p>";
    }
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
 exit();
    }

	
else if($action=="brw_log")
{
    addonline(getuid_sid($sid),"Scan Multi IDs","");
    $pstyle = gettheme($sid);
      echo xhtmlhead("Secret Zone",$pstyle);
    //////ALL LISTS SCRIPT <<
    $who = $_GET["who"];
    $whoinfo = mysql_fetch_array(mysql_query("SELECT ua FROM ua WHERE uid='".$who."'"));
    if(ismod(getuid_sid($sid))){
    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ua WHERE uid='".$who."'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, ua FROM ua WHERE uid='".$who."' ORDER BY time LIMIT $limit_start, $items_per_page";


    echo "<p>";
	echo"<b>Default Browsers:</b><br/>";
    $items = mysql_query($sql);
    if(mysql_num_rows($items)>0){
    while ($item = mysql_fetch_array($items)){
      $lnk = "$item[1]";
      echo "$lnk<br/>";
    }}
    echo "</p>";
	
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lists.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
        $rets .= "<form action=\"lists.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/><br/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
        $rets .= "</form>";

        echo $rets;
    }
    echo "</p>";
    }else{
      echo "<p align=\"center\">";
      echo "You can't view this list";
      echo "</p>";
    }
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    echo "<a href=\"index.php?action=main\"><img src=\"images/themes/$themeimageset[0]/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
 exit();
    }


//////////////////////////////////////////////////
else{
    $pstyle = gettheme($sid);
    echo xhtmlhead("Secret Zone",$pstyle);
    echo "<card id=\"main\" title=\"Mod CP\">";

  echo "<p align=\"center\"><small>";

  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";

  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";

  echo "</small></p></card>";

}

?>

</html>