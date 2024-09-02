<?
session_name("PHPSESSID");
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<head>
<meta forua="true" http-equiv="Cache-Control" content="max-age=0"/>
<meta forua="true" http-equiv="Cache-Control" content="must-revalidate"/>
</head>
<meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
<meta name=\"description\" content=\":)\">
<meta name=\"keywords\" content=\"free, community, forums, chat, wap, communicate\"></head>
<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> 
<?php

include("config.php");
include("core.php");
include("xhtmlfunctions.php");

connectdb();  
$action=$_GET["action"];
$id=$_GET["id"];
$sid = $_SESSION['sid'];
$rid=$_GET["rid"];
$rpw=$_GET["rpw"];
$page=$_GET["page"];
$chat=$_GET["chat"];
$who=$_GET["who"];
$unick=$_GET["unick"];
$uid = getuid_sid($sid);
 $spin=$_GET["spin"];
  $idn=$_GET["idn"];
$cancel=$_GET["cancel"];
 $uexist = isuser($uid);
$time = date('dmHis');
if((islogged($sid)==false)||!$uexist)
    {
      $pstyle = gettheme($sid);
      echo xhtmlheadchat("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
  echo xhtmlfoot();
      exit();
    }




if(isbanned($uid))
    {
      $pstyle = gettheme($sid);
      echo xhtmlheadchat("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
      echo "You are <b>Banned</b><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT timeto FROM dcroxx_me_metpenaltiespl WHERE uid='".$uid."' AND penalty='1'"));
	  $banres = mysql_fetch_array(mysql_query("SELECT lastpnreas FROM dcroxx_me_users WHERE id='".$uid."'"));

      $remain = $banto[0]- (time() - $timeadjust) ;
      $rmsg = gettimemsg($remain);
      echo "Time to finish your penalty: $rmsg<br/><br/>";
	  echo "Ban Reason: $banres[0]";
      //echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
  echo xhtmlfoot();
      exit();
    }
	
	if(ischatbaned($uid)){
      $pstyle = gettheme($sid);
      echo xhtmlheadchat("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
      echo "You are Chat Banned By <b>Staff Team</b><br/>";
	  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"x\"/>Home</a>";
      echo "</p>";
  echo xhtmlfoot();
      exit();
    }
    $isroom = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_rooms WHERE id='".$rid."'"));
    if($isroom[0]==0)
    {
      $pstyle = gettheme($sid);
      echo xhtmlheadchat("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "This room doesn't exist anymore<br/>";
      echo ":P see in another room<br/><br/>";
      echo "<a href=\"index.php?action=chat\">Chatrooms</a>";
      echo "</p>";
      echo xhtmlfoot();
      exit();
    }
    $passworded = mysql_fetch_array(mysql_query("SELECT pass FROM dcroxx_me_rooms WHERE id='".$rid."'"));
    if($passworded[0]!="")
    {
      if($rpw!=$passworded[0])
      {
      $pstyle = gettheme($sid);
      echo xhtmlheadchat("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "You can't enter this room<br/>";
      echo ":P stay away<br/><br/>";
      echo "<a href=\"index.php?action=chat\">Chatrooms</a>";
      echo "</p>";
      echo xhtmlfoot();
      exit();
      }
    }
    if(!canenter($rid,$sid))
    {
      $pstyle = gettheme($sid);
      echo xhtmlheadchat("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "You can't enter this room<br/>";
      echo ":P stay away<br/><br/>";
      echo "<a href=\"index.php?action=chat\">Chatrooms</a>";
      echo "</p>";
      echo xhtmlfoot();
      exit();
    }
  if(!inside($uid, $rid))
    {
 if(!iscowner($uid, $rid))
    {
if(locked($uid, $rid))
    {
      echo "<p align=\"center\">";
      echo "This room is locked!<br/>";
      echo ":P Stay outside<br/><br/>";
      echo "<a href=\"index.php?action=chat&amp;type=send&amp;browse?start\">Chatrooms</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
}
}
 if(kick($uid, $rid))
    {

      echo "<p align=\"center\">";
      echo "You have been kicked from this room hekhek!<br/>";
      echo ":P Stay outside<br/><br/>";
      echo "<a href=\"index.php?action=chat&amp;type=send&amp;browse?start\">Chatrooms</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
	
    if ($rid==182||$rid==454||$rid==804){	
	      $pstyle = gettheme($sid);
      echo xhtmlheadchat("Room ID:$rid",$pstyle);
      echo "<p align=\"center\">";
      echo "You cant enter this room from here.<br/>";
      echo "<a href=\"chat_.php?rid=$rid\">Please click here for enter</a><br/><br/>";
      echo "<a href=\"index.php?action=chat&amp;type=send&amp;browse?start\">Chatrooms</a><br/>";
      echo "<a href=\"index.php?action=main\">Home</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
	
cleardata();
addtochat($uid, $rid);
//This Chat Script is by Tufan420
//hridoy636@gmail.com
//want to see main menu...
$timeto = 900;
$timenw = time();
$timeout = $timenw-$timeto;
//$deleted = mysql_query("DELETE FROM dcroxx_me_chat WHERE timesent<".$timeout."");

if ($action=="")
{

echo "<card id=\"chat\" title=\"$sitename\" ontimer=\"chat_room.php?time=";
echo date('dmHis');
echo "&amp;rid=$rid&amp;rpw=$rpw";

echo "\">";

//start of main card

echo "<p align=\"left\"><small>";
$rooms = mysql_fetch_array(mysql_query("SELECT id, name FROM dcroxx_me_rooms WHERE id='".$rid."'"));
$rname = $rooms[1];
addonline($uid,"Chating in <b>$rname</b>","");
      $pstyle = gettheme($sid);
      echo xhtmlheadchat("$rname",$pstyle);
echo "
";
$lnk2 = date('dmHis');
$lnk3 = "<a href=\"chat_room.php?time=$lnk2&amp;rid=$rid&amp;rpw=$rpw\">refresh</a>";

echo"<a href=\"chat_room.php?action=options&amp;rid=$rid&amp;rpw=$rpw\">Options</a> <br/>
 <a href=\"chat_room.php?time=$lnk2&amp;rid=$rid&amp;rpw=$rpw\">Refresh</a><br/>";

$unreadinbox=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE unread='1' AND touid='".$uid."'"));
$pmtotl=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE touid='".$uid."'"));
$unrd="(".$unreadinbox[0]."/".$pmtotl[0].")";
if ($unreadinbox[0]>0)
{
echo "<a href=\"inbox.php?action=main\">PMs $unrd</a><br/>";
}
echo "</small>";
/*echo "Message:</small><input name=\"message\" type=\"text\" value=\"\" maxlength=\"200\"/><br/>";
echo "<anchor>Say";
echo "<go href=\"chat_room.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw\" method=\"post\">";
echo "<postfield name=\"message\" value=\"$(message)\"/>";
echo "</go></anchor> <b>|</b> <anchor><refresh><setvar name=\"message\" value=\"\"/></refresh>Clear Text</anchor><small></small></p>";
*/
echo "<form action=\"chat_room.php?rid=$rid&amp;rpw=$rpw\" method=\"post\">
<small>Message:</small><br/>
<textarea id=\"inputText\" name=\"message\" type=\"text\" value=\"\" style=\"height:30px;width: 270px;\" ></textarea><br/>";
echo "<input id=\"inputButton\" type=\"submit\" value=\"Send\"/>";
echo "</form>";



$message=mysql_real_escape_string($_POST["message"]);
$who = mysql_real_escape_string($_POST["who"]);
$rinfo = mysql_fetch_array(mysql_query("SELECT censord, freaky FROM dcroxx_me_rooms WHERE id='".$rid."'"));
if (trim($message) != "")
{
$nosm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_chat WHERE msgtext='".$message."'"));
if($nosm[0]==0){

$chatok = mysql_query("INSERT INTO dcroxx_me_chat SET  chatter='".$uid."', who='".$who."', timesent='".time()."', msgtext='".$message."', rid='".$rid."';");
$lstmsg = mysql_query("UPDATE dcroxx_me_rooms SET lastmsg='".time()."' WHERE id='".$rid."'");

$hehe=mysql_fetch_array(mysql_query("SELECT chmsgs, chmsgs2 FROM dcroxx_me_users WHERE id='".$uid."'"));
$totl = $hehe[0]+1;
$tot = $hehe[1]+1;
$msgst= mysql_query("UPDATE dcroxx_me_users SET chmsgs='".$totl."', chmsgs2='".$tot."' WHERE id='".$uid."'");
if($rinfo[1]==2)
{
//oh damn i gotta post this message to ravebabe :(
//will it succeed?
$botid = "adc8c4b82e36a644";
$hostname = "www.pandorabots.com";
$hostpath = "/pandora/talk-xml";
$sendData = "botid=".$botid."&input=".urlencode($message)."&custid=".$custid;

$result = PostToHost($hostname, $hostpath, $sendData);

$pos = strpos($result, "custid=\"");
$pos = strpos($result, "<that>");
if ($pos === false) {
$reply = "";
} else {
$pos += 6;
$endpos = strpos($result, "</that>", $pos);
$reply = unhtmlspecialchars2(substr($result, $pos, $endpos - $pos));
$reply = mysql_escape_string($reply);
}

$chatok = mysql_query("INSERT INTO dcroxx_me_chat SET  chatter='3', who='', timesent='".time()."', msgtext='".$reply." @".getnick_uid($uid)."', rid='".$rid."';");
}
}
$message = "";
}

echo "<p><small>";
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_chat WHERE rid='".$rid."'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

    $sql = "SELECT chatter, who, timesent, msgtext, exposed, id FROM dcroxx_me_chat WHERE rid='".$rid."' ORDER BY timesent DESC LIMIT $limit_start, $items_per_page";

    //echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
        /////////////////formation is here
        $canc = true;


if($counter<12)
{
if(istrashed($item[0])){
if($uid!=$item[0])
{
$canc = false;
}
}
//////good
if(isignored($item[0],$uid)){
$canc = false;
}
//////////good
if($item[0]!=$uid)
{
if($item[1]!=0)
{
if($item[1]!=$uid)
{
$canc = false;
}
}
}
if($item[4]=='1' && ismod($uid))
{
$canc = true;
}
if($canc)
{
$cmid = mysql_fetch_array(mysql_query("SELECT chmood FROM dcroxx_me_users WHERE id='".$item[0]."'"));

$iml = "";
if(($cmid[0]!=0))
{
$mlnk = mysql_fetch_array(mysql_query("SELECT img, text FROM dcroxx_me_moods WHERE id='".$cmid[0]."'"));
//$iml = "<img src=\"$mlnk[0]\" alt=\"$mlnk[1]\"/>";
$iml = "";
}
$chnick = getnick_uid($item[0]);
$optlink = $iml.$chnick;
if(($item[1]!=0)&&($item[0]==$uid))
{
///out
//$iml = "<img src=\"../moods/out.gif\" alt=\"!\"/>";
$iml = "";
$chnick = getnick_uid($item[1]);
$optlink = $iml."PM to ".$chnick;
}
if($item[1]==$uid)
{
///out
//$iml = "<img src=\"../moods/in.gif\" alt=\"!\"/>";
$iml = "";
$chnick = getnick_uid($item[0]);
$optlink = $iml."PM by ".$chnick;
}
if($item[4]=='1')
{
///out
//$iml = "<img src=\"../moods/point.gif\" alt=\"!\"/>";
$iml = "";
$chnick = getnick_uid($item[0]);
$tonick = getnick_uid($item[1]);
$optlink = "$iml by ".$chnick." to ".$tonick;
}

$ds= date("H.i.s", $item[2]);
$text = parsepm($item[3], $sid);
$nos = substr_count($text,"<img src=");
if(isspam($text))
{
$chnick = getnick_uid($item[0]);
echo "<b>ChatGirl:</b><br/>Darling  $chnick, Akhane spam Kora Jaby Na<br/>";
}
else if($nos>2){
$chnick = getnick_uid($item[0]);
echo "<b>ChatGirl:</b><br/>oh Darling $chnick, you can only use 2 smilies per msg<br/>";
}else{
$sres = substr($item[3],0,3);

if($sres == "/asdhi")
{
$chco = strlen($item[3]);
$goto = $chco - 3;
$rest = substr($item[3],3,$goto);
$tosay = parsepm($rest, $sid);

echo "<b><i>*$chnick $tosay*</i></b><br/>";
}else{

$tosay = parsepm($item[3], $sid);

if($rinfo[0]==1)
{
$tosay = str_replace("l0tir","ERROR!",$tosay);
$tosay = str_replace("kanki","ERROR!",$tosay);
$tosay = str_replace("l0ti","ERROR!",$tosay);
$tosay = str_replace("cudi","ERROR!",$tosay);
$tosay = str_replace("madarcod","ERROR!",$tosay);
$tosay = str_replace("khanki","ERROR!",$tosay);
$tosay = str_replace("com","ERROR!",$tosay);

$tosay = str_replace("loti","ERROR!",$tosay);
$tosay = str_replace("lotir","ERROR!",$tosay);
$tosay = str_replace("codo","ERROR!",$tosay);
$tosay = str_replace("chodamu","ERROR!",$tosay);
$tosay = str_replace("chodbo","ERROR!",$tosay);

$tosay = str_replace("magi","ERROR!",$tosay);
$tosay = str_replace("bainchod","ERROR!",$tosay);
$tosay = str_replace("banchud","ERROR!",$tosay);
$tosay = str_replace("fuck","ERROR!",$tosay);
$tosay = str_replace("sex","ERROR!",$tosay);

}

if($rinfo[1]==1)
{
$tosay = htmlspecialchars($item[3]);
$tosay = strrev($tosay);
}
$avlink = getavatar($chat[0]);
if ($avlink==""){
$avl ="<img src=\"images/nopic.jpg\" alt=\"avatar\" height=\"20\" width=\"20\"/>";
}else{
$avl ="<img src=\"$avlink\" alt=\"avatar\" height=\"20\" width=\"20\"/>";
}
echo "$avl<a href=\"chat_room.php?action=say2&amp;who=$item[0]&amp;rid=$rid&amp;rpw=$rpw&amp;msgid=$item[5]\">$optlink</a>: ";
if($item[6]==0){
$rpt = "";    
}else{
$rpt = " <b>[Reported]</b>";
}
$ger = $item[2] + (6* 60 * 60);
$dss= date("h:i:s a", $ger);
$browse = mysql_fetch_array(mysql_query("SELECT browserm FROM dcroxx_me_users WHERE id='".$item[0]."'"));
$d0 = "(Chat On: <b>$dss</b> Via <b>$browse[0]</b>)";
echo $tosay."$rpt<br/>";

 if(ismod(getuid_sid($sid))){
echo"<small>$d0</small> <a href=\"chat_room.php?action=delchatmsg&amp;who=$item[0]&amp;rid=$rid&amp;rpw=$rpw&amp;msgid=$item[5]\">(x)</a><br/>";
 }else{}
 echo"<br/>";
}
}

$counter++;
}
}
    }
    }

    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"chat_room.php?page=$ppage&amp;rid=$rid\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"chat_room.php?page=$npage&amp;rid=$rid\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"chat_room.php\" method=\"get\">";
        $rets .= "<postfield name=\"rid\" value=\"$rid\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    

echo "";
echo "</small></p>";

echo "<p align=\"left\"><small>";
//$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_chonline WHERE rid='".$rid."'"));
//echo "Users Chatting: <a href=\"chat_room.php?action=inside&amp;rid=$rid&amp;rpw=$rpw\">$noi[0]</a>";

echo"<b>Online Chatter:</b><br/>";   
$inside=mysql_query("SELECT DISTINCT * FROM dcroxx_me_chonline WHERE rid='".$rid."' and uid IS NOT NULL");
while($ins=mysql_fetch_array($inside)){
$who = $ins[1];
$noi = mysql_fetch_array(mysql_query("SELECT lastact FROM dcroxx_me_users WHERE id='".$who."'"));
$var1 = date("His",$noi[0]);
$var2 = time();
$var21 = date("His",$var2);
$var3 = $var21 - $var1;
$var4 = date("s",$var3);
$remain = time() - $noi[0];
$idle = gettimemsg($remain);
$idle2 = "- idle:";
$unick = getnick_uid($ins[1]);
$avlink = getavatar($ins[1]);
if ($avlink==""){
$avl ="<img src=\"images/nopic.jpg\" alt=\"avatar\" height=\"25\" width=\"25\"/>";
}else{
$avl ="<img src=\"$avlink\" alt=\"avatar\" height=\"25\" width=\"25\"/>";
}
//$userl = "$avl<a href=\"chat.php?action=say2&amp;who=$ins[1]&amp;rid=$rid&amp;rpw=$rpw\">$unick</a> $idle2 $idle<br/>";
$userl = "$avl<a href=\"chat.php?action=say2&amp;who=$ins[1]&amp;rid=$rid&amp;rpw=$rpw\">$unick</a>";
 echo "$userl,";
}			

echo"</small></p>";
echo "<p align=\"left\"><small>";
$onu = getnumonline();
echo "<a href=\"index.php?action=chat\"><img src=\"images/chat.gif\"/>Chatrooms</a><br/>
<a href=\"index.php?action=main\"><img src=\"images/home.gif\"/>Home</a><br/>";
echo "</small></p>";

echo "</card>";
}
/////////////////////////////////////////////////////CHAT OPTIONS

else if ($action=="options")
{
echo "<card id=\"say\" title=\"$sitename\">";
addonline($uid,"Chat Options","");
echo "<p align=\"center\"><small>";
echo "<b>Chat Options</b>";
echo "</small></p>";
echo "<p><small>";
echo "&#187;<a href=\"lists.php?action=chmood&amp;page=1\">Chat Mood</a><br/>";
echo "&#187;<a href=\"lists.php?action=smilies\">Smilies List</a><br/>";
echo "&#187;<a href=\"chat_room.php?action=inside&amp;rid=$rid&amp;rpw=$rpw\">Who's Inside</a><br/>";
$judg = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_judges WHERE uid='".getuid_sid($sid)."'"));

if(ismod(getuid_sid($sid))||$judg[0]>0)

{

echo "<a href=\"chat_room.php?action=clrtxt&amp;rid=$rid\">&#187;Clear Msgs</a><br/>";
}
$rooms = mysql_fetch_array(mysql_query("SELECT id, name FROM dcroxx_me_rooms WHERE id='".$rid."'"));
$rname = $rooms[1];
echo "&#171;<a href=\"chat_room.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw\">Back To $rname</a><br/>";

echo "</small></p>";
echo "<p align=\"center\"><small>";
$onu = getnumonline();
echo "<a href=\"index.php?action=main\">Home</a><br/>";
echo "</small></p>";
echo "</card>";
}
/////////////////////////////////////////////////////SAY
else if ($action=="say")                   {
echo "<card id=\"say\" title=\"$sitename\">";

addonline($uid,"Writing Chat Message","");

echo "<p><small>Message:<input name=\"message\" type=\"text\" value=\"\" maxlength=\"200\"/><br/>";
echo "<anchor>&#171;Say";
echo "<go href=\"chat_room.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw\" method=\"post\">";
echo "<postfield name=\"message\" value=\"$(message)\"/>";
echo "</go></anchor><br/>";
echo "<a href=\"lists.php?action=chmood&amp;page=1\">&#187;Chat mood</a><br/>";
echo "<a href=\"chat_room.php?action=inside&amp;rid=$rid&amp;rpw=$rpw\">&#187;Who's Online</a><br/>";
echo "<a href=\"chat_room.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw\">&#171;Chatroom</a></small></p>";
//end

echo "<p align=\"center\"><small><a href=\"index.php?action=chat\"><img src=\"images/chat.gif\" alt=\"*\"/>Chatrooms</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a></small></p>";

echo "</card>";
}

else if ($action=="delchatmsg")                   {
echo "<card id=\"say\" title=\"$sitename\">";

addonline($uid,"Deleting Chat Message","");
$msgid = mysql_real_escape_string($_GET["msgid"]);
echo "<p align=\"center\"><small>";
if(ismod(getuid_sid($sid))){
$res = mysql_query("DELETE FROM dcroxx_me_chat WHERE id='".$msgid."'");
if($res){
echo "<img src=\"images/ok.gif\" alt=\"o\"/>Chat message delete from our database<br/>";
}else{
echo "<img src=\"images/notok.gif\" alt=\"x\"/>Database Error!<br/>";
}
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Sorry, only staff can take this action<br/>";
}
echo "</small></p>";
//end

echo "<p align=\"center\"><small><a href=\"index.php?action=chat\"><img src=\"images/chat.gif\" alt=\"*\"/>Chatrooms</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a></small></p>";

echo "</card>";
}
////////////////////////////////////////////
/////////////////////////////////////////////////////SAY2
else if ($action=="say2")                   {
echo "<card id=\"say\" title=\"$sitename\">";
echo "<p align=\"center\"><small>";
$who = isnum((int)$_GET["who"]);
$unick = getnick_uid($who);
echo "<b>Private to $unick</b>";
echo "</small></p>";
addonline($uid,"Writing chat message","");
echo "<p><small>Message:<input name=\"message\" type=\"text\" value=\" \" maxlength=\"200\"/><br/>";
echo "<anchor>&#171;Private";
echo "<go href=\"chat_room.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw\" method=\"post\">";
echo "<postfield name=\"message\" value=\"$(message)\"/>";
echo "<postfield name=\"who\" value=\"$who\"/>";
echo "</go></anchor><br/>";
echo "<a href=\"member.php?action=viewuser&amp;who=$who\">&#187;View $unick's Profile</a><br/>";
echo "<a href=\"chat_room.php?action=expose&amp;who=$who&amp;rid=$rid&amp;rpw=$rpw\">&#187;Expose $unick</a><br/>";
echo "<a href=\"chat_room.php?action=report&amp;msgid=".isnum((int)$_GET["msgid"])."&amp;rid=$rid\">&#187;Report Message</a><br/>";

echo "<a href=\"chat_room.php?action=inside&amp;rid=$rid&amp;rpw=$rpw\">&#187;Who's Online</a><br/>";
echo "<a href=\"chat_room.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw\">&#171;Chatroom</a></small></p>";
//end

echo "<p align=\"center\"><small><a href=\"index.php?action=chat\"><img src=\"images/chat.gif\" alt=\"*\"/>Chatrooms</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a></small></p>";

echo "</card>";
}
////////////////////////////////////////////
//////////////////////////////inside//////////
else if ($action=="inside")           {

addonline($uid,"Chat inside list","");
echo "<card id=\"main\" title=\"Inside list\">";
echo "<p align=\"left\"><small>Users Chatting:<br/>";
$inside=mysql_query("SELECT DISTINCT * FROM dcroxx_me_chonline WHERE rid='".$rid."' and uid IS NOT NULL");

while($ins=mysql_fetch_array($inside))
{
$noi = mysql_fetch_array(mysql_query("SELECT lastact FROM dcroxx_me_users WHERE id='".$ins[1]."'"));
$var1 = date("His",$noi[0]);
$var2 = time();
$var21 = date("His",$var2);
$var3 = $var21 - $var1;
$var4 = date("s",$var3);
$remain = time() - $noi[0];
$idle = gettimemsg($remain);

$unick = getnick_uid($ins[1]);
$userl = "<a href=\"chat_room.php?action=say2&amp;who=$ins[1]&amp;rid=$rid&amp;rpw=$rpw\">$unick</a> - Idle: <b>$idle</b><br/>";
echo "$userl";
}
echo "<br/><br/>";
echo "<a href=\"chat_room.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw\">&#171;Chatroom</a><br/>";
echo "<br/><a href=\"index.php?action=chat\"><img src=\"images/chat.gif\" alt=\"*\"/>Chatrooms</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a></small></p>";

echo "</card>";
}
else if ($action=="expose")           {

addonline($uid,"Chat inside list","");
echo "<card id=\"main\" title=\"Inside list\">";
echo "<p align=\"center\"><small><br/>";
mysql_query("UPDATE dcroxx_me_chat SET exposed='1' WHERE chatter='".$who."' AND who='".$uid."'");
$unick = getnick_uid($who);
echo "$unick messages to you have been exposed to staff";
echo "<br/><br/>";
echo "<a href=\"chat_room.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw\">&#171;Chatroom</a><br/>";
echo "<br/><a href=\"index.php?action=chat\"><img src=\"images/chat.gif\" alt=\"*\"/>Chatrooms</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a></small></p>";

echo "</card>";
}

//////////////////////////chat clear//////////////////////////


else if($action=="clrtxt")

{

echo "<card id=\"main\" title=\"Clear Chat \">";

echo "<p align=\"center\"><small>";
if(!ismod(getuid_sid($sid))){
    echo "<b>Permission Denied By Tufan420</b><br/>";
    echo "<br/><a href=\"index.php?action=chat\"><img src=\"images/chat.gif\" alt=\"*\"/>Chatrooms</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
    echo "</small></p></card></wml>";
    exit();
}
echo "<br/>";

$rooms = mysql_fetch_array(mysql_query("SELECT id, name FROM dcroxx_me_rooms WHERE id='".$rid."'"));

$res = mysql_query("DELETE FROM dcroxx_me_chat");

echo mysql_error();

if($res)

{

echo "Text Cleared Successfully";

}else{

echo "Database Error!";

}

echo "<br/><a href=\"index.php?action=chat\"><img src=\"images/chat.gif\" alt=\"*\"/>Chatrooms</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";

echo "</small></p></card>";
}
else if($action=="report")
{
$msgid = isnum((int)$_GET["msgid"]);
addonline($uid,"Reported Chat MSG","");
echo "<card id=\"main\" title=\"$sitename\">";
echo "<p align=\"center\"><small>";
$rooms = mysql_fetch_array(mysql_query("SELECT reported FROM dcroxx_me_chat WHERE id='".$msgid."'"));
if($rooms[0]==0){
$str = mysql_query("UPDATE dcroxx_me_chat SET reported='1', reportedby='".getuid_sid($sid)."' WHERE id='".$msgid."' ");
if($str)
{
echo "<img src=\"images/ok.gif\" alt=\"O\"/>Message reported to mods successfully<br/>";
}else{
echo "<img src=\"images/notok.gif\" alt=\"X\"/>Can't report Message at this moment<br/>";
}   
}else{
    echo "<b>This message is already reported</b><br/>";
}

echo "<br/><a href=\"index.php?action=chat\"><img src=\"images/chat.gif\" alt=\"*\"/>Chatrooms</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
echo "</small></p></card>";
}
?>

</wml>
