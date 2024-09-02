<?php
session_name("PHPSESSID");
session_start();

include("xhtmlfunctions.php");
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> 
<link href=\"SocialBD.css\" media=\"screen, handheld\" rel=\"stylesheet\" type=\"text/css\" />";

?>

<?php
include("config.php");
include("core.php");
connectdb();

$action = $_GET["action"];
$sid = $_SESSION['sid'];
$page = $_GET["page"];
$who = $_GET["who"];
$pmid = $_GET["pmid"];
$pmtext = $_POST["pmtext"];
$whonick = getnick_uid($who);
$byuid = getuid_sid($sid);
$sitename = mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE name='sitename'"));
$sitename = $sitename[0];
$ubrw = explode(" ",$HTTP_USER_AGENT);
$ubrw = $ubrw[0];
$ipad = getip();
$uid = getuid_sid($sid);

if($action != "")
{
if(islogged($sid)==false)
{
      $pstyle = gettheme1("1");
      echo xhtmlhead("",$pstyle);
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
  echo xhtmlfoot();
      exit();
    }
}
if(isbanned($uid))
    {
      $pstyle = gettheme($sid);
      echo xhtmlhead("",$pstyle);
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

    $amount = mysql_fetch_array(mysql_query("SELECT balance FROM dcroxx_me_users WHERE id='".getuid_sid($sid)."'"));
  if($amount[0] < 1){
    $pstyle = gettheme($sid);
      echo xhtmlhead("Messages Service",$pstyle);
      echo "<p align=\"center\"><small>";
      echo "[x]<br/>Insufficient Balance<br/>";
            echo "You need atleast <b>1 BDT</b> for unlock message service<br/>
            Make shouts and friendship with others and stay 1hour for earn <b>1 BDT</b>";
            echo "</small></p>";
                echo"<p align=\"center\"><small>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a><br/><br/>";
  echo "</small></p>";
    echo "</card>";
    exit();
  }

if($action==""){
addonline(getuid_sid($sid),"Viewing Conversations","inbox.php?action=main");
$who = $_GET["who"];
$wnick = getnick_uid($who);
echo "<head>";
$pms = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE (byuid='".$uid."' AND touid='".$who."') OR (byuid='".$who."' AND touid='".$uid."') ORDER BY timesent"));

if ($pms[0]>0){echo "<title>$wnick</title>";}else{echo "<title>New Message</title>";}

echo "</head>";
echo "<body>";
include("header.php");

?>
<!-- G&R_320x50 -->
<script id="GNR35743">
    (function (i,g,b,d,c) {
        i[g]=i[g]||function(){(i[g].q=i[g].q||[]).push(arguments)};
        var s=d.createElement(b);s.async=true;s.src=c;
        var x=d.getElementsByTagName(b)[0];
        x.parentNode.insertBefore(s, x);
    })(window,'gandrad','script',document,'//content.green-red.com/lib/display.js');
    gandrad({siteid:11444,slot:35743});
</script>
<!-- End of G&R_320x50 -->
<!-- G&R_250x250 -->
<script id="GNR36434">
    (function (i,g,b,d,c) {
        i[g]=i[g]||function(){(i[g].q=i[g].q||[]).push(arguments)};
        var s=d.createElement(b);s.async=true;s.src=c;
        var x=d.getElementsByTagName(b)[0];
        x.parentNode.insertBefore(s, x);
    })(window,'gandrad','script',document,'//content.green-red.com/lib/display.js');
    gandrad({siteid:11444,slot:36434});
</script>
<!-- End of G&R_250x250 -->
<?
$uid = getuid_sid($sid);
$unick = getnick_uid($uid);


  if($page=="" || $page<=0)$page=1;
    $pms = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE (byuid='".$uid."' AND touid='".$who."') OR (byuid='".$who."' AND touid='".$uid."') ORDER BY timesent"));

 $num_items = $pms[0];
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if($page>$num_pages)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    if($num_items>0){
echo "<div class=\"penanda\" align=\"left\">";


if(getuid_sid($sid)!=$who){
if(budres($who,getuid_sid($sid))==0){
$regx = "";
}else if(budres($who,getuid_sid($sid))==1){
$regx = "";
}else if(budres($who,getuid_sid($sid))==2){
if(isonline($pm[0])){
$regx = "<img src=\"DbsprgIuYE0.gif\"> <font color=\"#9397a0\">active now</font>";
}else{
$noi = mysql_fetch_array(mysql_query("SELECT lastact FROM dcroxx_me_users WHERE id='".$who."'"));
$remain = time() - $noi[0];
$idle = gettimemsg($remain);
$regx = "$idle";
}
}}else{
	$noi = mysql_fetch_array(mysql_query("SELECT lastact FROM dcroxx_me_users WHERE id='".$who."'"));
$remain = time() - $noi[0];
$idle = gettimemsg($remain);
$regx = "$idle ago";}

$ex = substr(md5(time()),0,25);
$e0x = substr(md5(time()),0,35);
echo "<strong>$wnick</strong> $regx<br/><div class=\"tab2\"><a href=\"\">Refresh</a></div> 
<a href=\"?head_code=$ex&who=$who&down_code=$e0x\">More Options</a><hr/>";

$imgid = $_GET["imgid"];
$ex = substr(md5(time()),0,25);
$e0x = substr(md5(time()),0,35);  
/*echo"<form action=\"?action=sent_inbox&head_code=$ex&who=$who&down_code=$e0x\" method=\"post\">";
if ($imgid==""){
echo "<textarea id=\"inputText\" name=\"pmtext\" style=\"height:50px;width: 270px;\" ></textarea>";
}else{
echo "<textarea id=\"inputText\" name=\"pmtext\" style=\"height:50px;width: 270px;\" >[image_preview=$imgid]</textarea>";
}
echo "<input id=\"inputButton\" type=\"submit\" name=\"shout\" value=\"Send\" class=\"hmenu hmenubottom\"/></form><hr/>";
*/
if($page>1){$ppage = $page-1;
echo "<a href=\"?head_code=$ex&who=$who&down_code=$e0x&page=$ppage\">See Older Messages</a><hr/> ";
}
     $pms = mysql_query("SELECT byuid, text, timesent, id, touid FROM dcroxx_me_private WHERE ((byuid=$uid AND touid=$who) OR (byuid=$who AND touid=$uid)) ORDER BY timesent ASC LIMIT $limit_start, $items_per_page");


while($pm=mysql_fetch_array($pms)){
	    $sql = "SELECT name FROM dcroxx_me_users WHERE id=$pm[0]";
	    $sql2 = mysql_query($sql);
	    $item = mysql_fetch_array($sql2);{
$sex = mysql_fetch_array(mysql_query("SELECT sex FROM dcroxx_me_users WHERE name='$item[0]'"));
if($sex[0]=="M"){$icon = "<img src=\"avatars/male.gif\" alt=\"M\"/>";}
if($sex[0]=="F"){$icon = "<img src=\"avatars/female.gif\" alt=\"F\"/>";}
if($sex[0]==""){$icon = "";}
$avlink = getavatar($pm[0]);
if($avlink==""){$avt =  "$icon";}else{
$avt = "<img src=\"$avlink\" alt=\"$avlink\" type=\"icon\" width=\"18\" hieght=\"23\"/>";}
	    $sql3 = "SELECT name FROM dcroxx_me_users WHERE id=$pm[0]";
	    $sql33 = mysql_query($sql3);
	    $item3 = mysql_fetch_array($sql33);{
$sex = mysql_fetch_array(mysql_query("SELECT sex FROM dcroxx_me_users WHERE name='$item3[0]'"));
if($sex[0]=="M"){$nicks = "<font color=\"blue\"><b>".getnick_uid($pm[0])."</b></font>";}
if($sex[0]=="F"){$nicks = "<font color=\"deeppink\"><b>".getnick_uid($pm[0])."</b></font>";}
if($sex[0]==""){$nicks = "";}
	   if((ismod($pm[0])) || (ispu($pm[0]))){
      $ds = "<img src=\"verified_user.png\">";
      }else{$ds = "";}	
$bylnk = "<a href=\"index.php?action=viewuser&who=$pm[0]\">$nicks</a>$ds<br/>";
}
}

echo $bylnk;
echo parsepm($pm[1], $sid);  
if ($pm[4]==$uid){
mysql_query("UPDATE dcroxx_me_private SET unread='0', seen='1' WHERE id='".$pm[3]."'");
}else{}

$nopl = mysql_fetch_array(mysql_query("SELECT osmafia FROM dcroxx_me_users WHERE id='".$who."'"));
if($nopl[0]=="Windows 3.11" || $nopl[0]=="Windows 95" || $nopl[0]=="Windows 98" || $nopl[0]=="Windows 2000" || $nopl[0]=="Windows XP" || $nopl[0]=="Windows Vista" || $nopl[0]=="Windows 7" || $nopl[0]=="Windows 8" || $nopl[0]=="Windows 2003" || $nopl[0]=="Windows NT 4.0" || $nopl[0]=="Windows ME"){
	$device = "· <font color=\"#9397a0\">Sent from Desktop</font>";
}else{
	$device = "· <font color=\"#9397a0\">Sent from Mobile</font>";	
}

$pl = mysql_fetch_array(mysql_query("SELECT seen FROM dcroxx_me_private WHERE id='".$pm[3]."'"));
if($pl[0]==1){
	$ce = " · <font color=\"#9397a0\">Seen</font>";
}else{
	$ce = "";	
}

if ($pm[0]!=$uid){
$remain = time() - $pm[2];
$idle = gettimemsg($remain);
echo"<br/><small><font color=\"#9397a0\">$idle ago</font> $device</small><br/><hr/>";
}else{
$remain = time() - $pm[2];
$idle = gettimemsg($remain);
echo"<br/><small><font color=\"#9397a0\">$idle ago</font> $ce </small><br/><hr/>";
}     }

if($page<$num_pages){$npage = $page+1;
echo "<a href=\"?head_code=$ex&who=$who&down_code=$e0x&page=$npage\">See Newer Messages</a><hr/>";
}


$imgid = $_GET["imgid"];
$ex = substr(md5(time()),0,25);
$e0x = substr(md5(time()),0,35);  
echo"<form action=\"?action=sent_inbox&head_code=$ex&who=$who&down_code=$e0x\" method=\"post\">";
if ($imgid==""){
echo "<textarea id=\"inputText\" name=\"pmtext\" style=\"height:50px;width: 270px;\" ></textarea>";
}else{
echo "<textarea id=\"inputText\" name=\"pmtext\" style=\"height:50px;width: 270px;\" >[image_preview=$imgid]</textarea>";
}
echo "<input id=\"inputButton\" type=\"submit\" name=\"shout\" value=\"Send\" class=\"hmenu hmenubottom\"/></form><hr/>";
echo"<div class=\"mblock1\">
<b>Simple Emotions:</b><br/>
:)	<img src=\"emoticons/1 (10).png\" height=\"16\" width=\"16\" />
:D	<img src=\"emoticons/1 (2).png\" height=\"16\" width=\"16\" />
:(	<img src=\"emoticons/1 (9).png\" height=\"16\" width=\"16\" />
:-(	<img src=\"emoticons/1 (8).png\" height=\"16\" width=\"16\" />
:P	<img src=\"emoticons/1 (11).png\" height=\"16\" width=\"16\" />
:O)	<img src=\"emoticons/1.png\" height=\"16\" width=\"16\" />
:3)	<img src=\"emoticons/1 (5).png\" height=\"16\" width=\"16\" />
o.O	<img src=\"emoticons/1 (3).png\" height=\"16\" width=\"16\" />
;)	<img src=\"emoticons/1 (27).png\" height=\"16\" width=\"16\" />
:O	<img src=\"emoticons/1 (24).png\" height=\"16\" width=\"16\" />
-_-	<img src=\"emoticons/1 (22).png\" height=\"16\" width=\"16\" />
:-O	<img src=\"emoticons/1 (1).png\" height=\"16\" width=\"16\" />
:*	<img src=\"emoticons/1 (16).png\" height=\"16\" width=\"16\" /> <br/>
:_:	<img src=\"emoticons/1 (15).png\" height=\"16\" width=\"16\" />
8-)	<img src=\"emoticons/1 (12).png\" height=\"16\" width=\"16\" />
8|	<img src=\"emoticons/1 (23).png\" height=\"16\" width=\"16\" />
(^^^) <img src=\"emoticons/1 (21).png\" height=\"16\" width=\"16\" />
:_(	<img src=\"emoticons/1 (13).png\" height=\"16\" width=\"16\" />
:v	<img src=\"emoticons/1 (17).png\" height=\"16\" width=\"16\" />
/:	<img src=\"emoticons/1 (26).png\" height=\"16\" width=\"16\" />
:3	<img src=\"emoticons/1 (4).png\" height=\"16\" width=\"16\" />
:poop: <img src=\"emoticons/1 (18).png\" height=\"16\" width=\"16\" />
:smoke: <img src=\"emoticons/cigarette.png\" height=\"16\" width=\"16\" />
:ring: <img src=\"emoticons/ring.png\" height=\"16\" width=\"16\" />
</div><br/><hr/>";

echo"
<a href=\"?action=like&head_code=$ex&who=$who&down_code=$e0x\">Like</a> ·
<a href=\"lists.php?action=smilies&head_code=$ex&down_code=$e0x\">Smilies</a> ·
<a href=\"lists.php?action=bbcode&head_code=$ex&down_code=$e0x\">BBCodes</a> ·

<a href=\"?action=stickers&head_code=$ex&who=$who&down_code=$e0x&stickers_folder=meep\">Send Stickers</a> ·
<a href=\"?action=add_photo&head_code=$ex&who=$who&down_code=$e0x\">Add Photos</a> ·
<a href=\"?head_code=$ex&who=$who&down_code=$e0x\">Refresh</a><hr/><br/>";
?>
<!-- G&R_320x50 -->
<script id="GNR35743">
    (function (i,g,b,d,c) {
        i[g]=i[g]||function(){(i[g].q=i[g].q||[]).push(arguments)};
        var s=d.createElement(b);s.async=true;s.src=c;
        var x=d.getElementsByTagName(b)[0];
        x.parentNode.insertBefore(s, x);
    })(window,'gandrad','script',document,'//content.green-red.com/lib/display.js');
    gandrad({siteid:11444,slot:35743});
</script>
<!-- End of G&R_320x50 -->
<!-- G&R_250x250 -->
<script id="GNR36434">
    (function (i,g,b,d,c) {
        i[g]=i[g]||function(){(i[g].q=i[g].q||[]).push(arguments)};
        var s=d.createElement(b);s.async=true;s.src=c;
        var x=d.getElementsByTagName(b)[0];
        x.parentNode.insertBefore(s, x);
    })(window,'gandrad','script',document,'//content.green-red.com/lib/display.js');
    gandrad({siteid:11444,slot:36434});
</script>
<!-- End of G&R_250x250 -->
<?
echo"<font color=\"#9397a0\">CHAT OPTIONS</font><br/>";
echo"<a href=\"\">Mark Unread</a><br/>";
echo"<a href=\"\">Delete</a><br/>";
echo"<a href=\"\">Delete Selected</a><br/>";
echo"<a href=\"\">Archive</a><br/>";
echo"<a href=\"\">Block Messages</a><br/>";
echo"<a href=\"\">Report Spam or Abuse</a><br/>";
echo "</div>";
}else{
echo"<div class=\"div\"><strong>New Message</strong></div><hr/>";
echo "<div class=\"penanda\" align=\"left\">";
if(isignored($uid, $who)){
	echo"You can't send message to <strong>$wnick</strong>";
}else{
echo "To:<br/> <div class=\"tab2\"><a href=\"index.php?action=main\">$wnick <small>x</small></a></div>
<br/> <a href=\"add_recipients.php\">Add Recipients</a><hr/>";
$imgid = $_GET["imgid"];

	  $ex = substr(md5(time()),0,25);
	  $e0x = substr(md5(time()),0,35);
	  
	  
echo"<form action=\"?action=sent_inbox&head_code=$ex&who=$who&down_code=$e0x\" method=\"post\">";
if ($imgid==""){
echo "<textarea id=\"inputText\" name=\"pmtext\" style=\"height:50px;width: 270px;\" ></textarea>";
}else{
echo "<textarea id=\"inputText\" name=\"pmtext\" style=\"height:50px;width: 270px;\" >[image_preview=$imgid]</textarea>";
}
echo "<input id=\"inputButton\" type=\"submit\" name=\"shout\" value=\"Send\" class=\"hmenu hmenubottom\"/></form><hr/>";
	  





	  $ex = substr(md5(time()),0,25);
	  $e0x = substr(md5(time()),0,35);

echo "<br/>Send photos instead:<hr/><form enctype=\"multipart/form-data\" action=\"?action=upload&head_code=$ex&who=$who&down_code=$e0x\" method=\"post\">";
  echo "<input type=\"file\" name=\"attach\" class=\"penanda\"/><br/>";
  echo"<input type=\"hidden\" name=\"head_code\" value=\"$ex\">";
  echo"<input type=\"hidden\" name=\"who\" value=\"$who\">";
  echo"<input type=\"hidden\" name=\"down_code\" value=\"$e0x\">";
echo"<input id=\"inputButton\" type=\"submit\" name=\"submit\" value=\"Send Photos\" class=\"div\"/>
        </form><br/>";
}		
		
		echo "</div>";
}

include("footer.php");
echo "</body>";
}
else if($action=="upload"){
include("header.php");

if(ispmbaned($uid)){
$ex = substr(md5(time()),0,25);
$e0x = substr(md5(time()),0,35);  
echo"You are temporary blocked for sending Message by <b>Staff Team</b><br/>
Please contact with <a href=\"index.php?action=viewuser&who=2\">Fardin420</a><br/>";
//echo "<meta http-equiv=\"refresh\" content=\"1; URL= ?head_code=$ex&who=$who&down_code=$e0x&page=$num_pages\"/>";
echo"<img src=\"images/home.gif\" alt=\"\"><a href=\"index.php?action=main\">Home</a>";
include("footer.php");
exit();
}
$shid = $_POST['shid'];
$cmnt_id = $_POST['cmnt_id'];
echo "<div class=\"penanda\" align=\"left\">";
$size = $_FILES['attach']['size']/1024;
$origname = $_FILES['attach']['name'];
$des = $_POST["des"];
$res = false;
$ext = explode(".", strrev($origname));
switch(strtolower($ext[0])){
case "gpj":
$res = true;
break;
case "gepj":
$res = true;
break;
case "gnp":
$res = true;
break;
}

$tm = time();
$uploaddir = "attachments";
if($size>1024){
echo "File Is Larger Than 1MB!";
}else{
/*    $name = getuid_sid($sid);
    $uploadfile = $name.".".$ext;
    $uppath=$uploaddir."/".$uploadfile;
    move_uploaded_file($_FILES['attach']['tmp_name'], $uppath);
    $filewa=$uppath;
    list($width, $height, $type, $attr) = getimagesize($filewa);
    $newname=$uploaddir."/".$origname."";
    $newheight = ($height*640)/$width;
    $newimg=imagecreatetruecolor(640, $newheight);
    $largeimg=imagecreatefromjpeg($filewa);
    imagecopyresampled($newimg, $largeimg, 0, 0, 0, 0, 640, $newheight, $width, $height);
    imagejpeg($newimg, $newname);
    imagedestroy($newimg);
    imagedestroy($largeimg);
    $file1=$origname."";
    unlink($filewa);*/
		$image_path = "watermark.png";
$font_path = "GILSANUB.TTF";
$font_size = 30;       // in pixcels
//$water_mark_text_1 = "9";
$water_mark_text_2 = "SocialBD";

function watermark_image($oldimage_name, $new_image_name){
    global $image_path;
    list($owidth,$oheight) = getimagesize($oldimage_name);
    //$width = $height = 300;    
    $width = $owidth;    
    $height = $oheight;    
    $im = imagecreatetruecolor($width, $height);
    $img_src = imagecreatefromjpeg($oldimage_name);
    imagecopyresampled($im, $img_src, 0, 0, 0, 0, $width, $height, $owidth, $oheight);
    $watermark = imagecreatefrompng($image_path);
    list($w_width, $w_height) = getimagesize($image_path);        
    $pos_x = $width - $w_width; 
    $pos_y = $height - $w_height;
    imagecopy($im, $watermark, $pos_x, $pos_y, 0, 0, $w_width, $w_height);
    imagejpeg($im, $new_image_name, 100);
    imagedestroy($im);
    unlink($oldimage_name);
    return true;
}


function watermark_text($oldimage_name, $new_image_name){
    global $font_path, $font_size, $water_mark_text_1, $water_mark_text_2;
    list($owidth,$oheight) = getimagesize($oldimage_name);
  //  $width = $height = 300;    
    $width = $owidth;    
    $height = $oheight;    
    $image = imagecreatetruecolor($width, $height);
    $image_src = imagecreatefromjpeg($oldimage_name);
    imagecopyresampled($image, $image_src, 0, 0, 0, 0, $width, $height, $owidth, $oheight);
   // $black = imagecolorallocate($image, 0, 0, 0);
    $blue = imagecolorallocate($image, 79, 166, 185);
   // imagettftext($image, $font_size, 0, 30, 190, $black, $font_path, $water_mark_text_1);
    imagettftext($image, $font_size, 0, 68, 190, $blue, $font_path, $water_mark_text_2);
    imagejpeg($image, $new_image_name, 100);
    imagedestroy($image);
    unlink($oldimage_name);
    return true;
}
$demo_image= "";
if(isset($_POST['submit']) and $_POST['submit'] == "Send Photos"){
    $path = "attachments/";
    $valid_formats = array("jpg",  "bmp","jpeg");
	$name = $_FILES['attach']['name'];
	if(strlen($name)){
   list($txt, $ext) = explode(".", $name);
   if(in_array($ext,$valid_formats)&& $_FILES['attach']['size'] <= 256*1024){
    $upload_status = move_uploaded_file($_FILES['attach']['tmp_name'], $path.$_FILES['attach']['name']);
    if($upload_status){
        $new_name = $path.time().".jpg";
        if(watermark_image($path.$_FILES['attach']['name'], $new_name))
                $demo_image = $new_name;
			
			
   // $res1 = mysql_query("INSERT INTO dcroxx_me_gallery SET uid='$name', sex='$s[0]', itemurl='attach/$file1', des='$des'");	
$pmtext = "[url=$demo_image][image_preview=$demo_image][/url]";

$iu = mysql_fetch_array(mysql_query("SELECT id FROM alien_war_rooms WHERE (byuid='".$uid."' AND touid='".$who."') OR (byuid='".$who."' AND touid='".$uid."')"));
$res1 = mysql_query("INSERT INTO dcroxx_me_private SET text='".$pmtext."', byuid='".$uid."', touid='".$who."', timesent='".time()."', folderid='".$iu[0]."'");
if($res1){
echo "<br/> <img src=\"avatars/ok.gif\" alt=\"0\">Message sent successfully.<br/><br/>";
$head_code = $_POST["head_code"];
$down_code = $_POST["down_code"];
$who = $_GET["who"];
 //header("Location: chat.php?head_code=$head_code&who=$who&down_code=$down_code");

$pms = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE (byuid='".getuid_sid($sid)."' AND touid='".$who."') OR (byuid='".$who."' AND touid='".getuid_sid($sid)."') ORDER BY timesent"));
$num_items = $pms[0];
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
$ex = substr(md5(time()),0,25);
$e0x = substr(md5(time()),0,35);  
echo "<meta http-equiv=\"refresh\" content=\"1; URL= ?head_code=$head_code&who=$who&down_code=$down_code&page=$num_pages\"/>";
 
 
 
 
 
$isu = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM alien_war_rooms WHERE (byuid='".$uid."' AND touid='".$who."') OR (byuid='".$who."' AND touid='".$uid."')"));
if($isu[0]>0){
mysql_query("UPDATE alien_war_rooms SET timesent='".time()."' WHERE (byuid='".$uid."' AND touid='".$who."') OR (byuid='".$who."' AND touid='".$uid."')");
}else{mysql_query("INSERT INTO alien_war_rooms SET byuid='".$uid."', touid='".$who."', timesent='".time()."'");}

}else{
echo "<br/><img src=\"avatars/notok.gif\" alt=\"X\">File couldn't be processed !!!<br/>
 <a href=\"tufan420\">Contact With Admin</a><br/><br/>";
echo "</div>";
}}}}}}
include("footer.php");
echo "</body>";
}

else if($action=="sent_inbox"){
	
	
$pmtext = $_POST["pmtext"];

if(strlen($pmtext)<2){
    echo "<head>";
    echo "<title>Message</title>";
    echo "</head>";
    echo "<body>";
include("header.php");
    echo "<div class=\"penanda\">";
      echo "<center><img src=\"dwarf.gif\" alt=\"\"><br/><strong>Hey stupid, don't try to cheat. Type some word first</strong><br/><br/></center>";   
echo "</div>";
include("footer.php");
echo "</body>";
      exit();
}
    echo "<head>";
    echo "<title>Sending Message</title>";
   echo "</head>";
    echo "<body>";
include("header.php");
    echo "<div class=\"penanda\" align=\"left\">";
  $whonick = getnick_uid($who);
  $byuid = getuid_sid($sid);
  $uid = getuid_sid($sid);
  $who = $_GET["who"];

if(ispmbaned($uid)){
$ex = substr(md5(time()),0,25);
$e0x = substr(md5(time()),0,35);  
echo"You are temporary blocked for sending Message by <b>Staff Team</b><br/>
Please contact with <a href=\"index.php?action=viewuser&who=2\">Fardin420</a><br/>";
//echo "<meta http-equiv=\"refresh\" content=\"1; URL= ?head_code=$ex&who=$who&down_code=$e0x&page=$num_pages\"/>";
include("footer.php");
exit();
}
  
if(isignored($uid, $who)){
$head_code = substr(md5(time()),0,25);
$down_code = substr(md5(time()),0,35);
$who = $_GET["who"];
 $pms = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE (byuid='".getuid_sid($sid)."' AND touid='".$who."') OR (byuid='".$who."' AND touid='".getuid_sid($sid)."') ORDER BY timesent"));
$num_items = $pms[0];
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
$ex = substr(md5(time()),0,25);
$e0x = substr(md5(time()),0,35);  
echo"You are ignored by the user";
echo "<meta http-equiv=\"refresh\" content=\"1; URL= ?head_code=$ex&who=$who&down_code=$e0x&page=$num_pages\"/>";
 
exit();
}

$u = $_GET["pid"];

$iu = mysql_fetch_array(mysql_query("SELECT id FROM alien_war_rooms WHERE (byuid='".$uid."' AND touid='".$who."') OR (byuid='".$who."' AND touid='".$uid."')"));


  $res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$pmtext."', byuid='".$uid."', touid='".$who."', timesent='".time()."', folderid='".$iu[0]."'");
//  $res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$pmtext."', byuid='".$uid."', touid='".$who."', timesent='".time()."'");
  if($res){
$who = $_GET["who"];
//header("Location: chat.php?head_code=$head_code&who=$who&down_code=$down_code");
echo"Message sent Successfully";
$pms = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE (byuid='".getuid_sid($sid)."' AND touid='".$who."') OR (byuid='".$who."' AND touid='".getuid_sid($sid)."') ORDER BY timesent"));
$num_items = $pms[0];
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
$ex = substr(md5(time()),0,25);
$e0x = substr(md5(time()),0,35);  
echo "<meta http-equiv=\"refresh\" content=\"1; URL= ?head_code=$ex&who=$who&down_code=$e0x&page=$num_pages\"/>";
 


$isu = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM alien_war_rooms WHERE (byuid='".$uid."' AND touid='".$who."') OR (byuid='".$who."' AND touid='".$uid."')"));
if($isu[0]>0){
mysql_query("UPDATE alien_war_rooms SET timesent='".time()."' WHERE (byuid='".$uid."' AND touid='".$who."') OR (byuid='".$who."' AND touid='".$uid."')");
}else{mysql_query("INSERT INTO alien_war_rooms SET byuid='".$uid."', touid='".$who."', timesent='".time()."'");}

}else{
    echo "There must be something wrong. Contact with developers";
}
//}else{echo "<img src=\"images/notok.gif\" alt=\"x\"/>Only Friends can send pm $unick<br/><a href=\"friendsproc.php?action=add&who=$who\">Add Friend</a><br/>";}
echo "</div>";
include("footer.php");
echo "</body>";
 }  
 
 else if($action=="like"){
	 
echo "<head>";
echo "<title>Sending Message</title>";
echo "</head>";
echo "<body>";
include("header.php");
echo "<div class=\"penanda\" align=\"left\">";
if(ispmbaned($uid)){
$ex = substr(md5(time()),0,25);
$e0x = substr(md5(time()),0,35);  
echo"You are temporary blocked for sending Message by <b>Staff Team</b><br/>
Please contact with <a href=\"index.php?action=viewuser&who=2\">Fardin420</a><br/>";
//echo "<meta http-equiv=\"refresh\" content=\"1; URL= ?head_code=$ex&who=$who&down_code=$e0x&page=$num_pages\"/>";
include("footer.php");
exit();
}
$whonick = getnick_uid($who);
$byuid = getuid_sid($sid);
$uid = getuid_sid($sid);
$pmtext = "[image_preview=like_msg_icon.png]";

if(isignored($uid, $who)){
$head_code = substr(md5(time()),0,25);
$down_code = substr(md5(time()),0,35);
$who = $_GET["who"];
//header("Location: chat.php?head_code=$head_code&who=$who&down_code=$down_code");
echo"You are ignored by the users";
$pms = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE (byuid='".getuid_sid($sid)."' AND touid='".$who."') OR (byuid='".$who."' AND touid='".getuid_sid($sid)."') ORDER BY timesent"));
$num_items = $pms[0];
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
$ex = substr(md5(time()),0,25);
$e0x = substr(md5(time()),0,35);  
echo "<meta http-equiv=\"refresh\" content=\"1; URL= ?head_code=$ex&who=$who&down_code=$e0x&page=$num_pages\"/>";
 
exit();
}


$iu = mysql_fetch_array(mysql_query("SELECT id FROM alien_war_rooms WHERE (byuid='".$uid."' AND touid='".$who."') OR (byuid='".$who."' AND touid='".$uid."')"));

$res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$pmtext."', byuid='".$uid."', touid='".$who."', timesent='".time()."', folderid='".$iu[0]."'");
if($res){
$head_code = substr(md5(time()),0,25);
$down_code = substr(md5(time()),0,35);
$who = $_GET["who"];
//header("Location: chat.php?head_code=$head_code&who=$who&down_code=$down_code");
echo"Message sent Successfully";
$pms = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE (byuid='".getuid_sid($sid)."' AND touid='".$who."') OR (byuid='".$who."' AND touid='".getuid_sid($sid)."') ORDER BY timesent"));
$num_items = $pms[0];
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
$ex = substr(md5(time()),0,25);
$e0x = substr(md5(time()),0,35);  
echo "<meta http-equiv=\"refresh\" content=\"1; URL= ?head_code=$ex&who=$who&down_code=$e0x&page=$num_pages\"/>";
 
$isu = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM alien_war_rooms WHERE (byuid='".$uid."' AND touid='".$who."') OR (byuid='".$who."' AND touid='".$uid."')"));
if($isu[0]>0){
mysql_query("UPDATE alien_war_rooms SET timesent='".time()."' WHERE (byuid='".$uid."' AND touid='".$who."') OR (byuid='".$who."' AND touid='".$uid."')");
}else{mysql_query("INSERT INTO alien_war_rooms SET byuid='".$uid."', touid='".$who."', timesent='".time()."'");}

}else{
echo "There must be something wrong. Contact with developers";
}

echo "</div>";
include("footer.php");
echo "</body>";
}  

else if($action=="stickers"){
	 
echo "<head>";
echo "<title>Send a Stickers</title>";
echo "</head>";
echo "<body>";
include("header.php");
if(ispmbaned($uid)){
$ex = substr(md5(time()),0,25);
$e0x = substr(md5(time()),0,35);  
echo"You are temporary blocked for sending Message by <b>Staff Team</b><br/>
Please contact with <a href=\"index.php?action=viewuser&who=2\">Fardin420</a><br/>";
//echo "<meta http-equiv=\"refresh\" content=\"1; URL= ?head_code=$ex&who=$who&down_code=$e0x&page=$num_pages\"/>";
include("footer.php");
exit();
}
if(isignored($uid, $who)){
$head_code = substr(md5(time()),0,25);
$down_code = substr(md5(time()),0,35);
$who = $_GET["who"];
//header("Location: chat.php?head_code=$head_code&who=$who&down_code=$down_code");
echo"You are ignored by the user";
$pms = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE (byuid='".getuid_sid($sid)."' AND touid='".$who."') OR (byuid='".$who."' AND touid='".getuid_sid($sid)."') ORDER BY timesent"));
$num_items = $pms[0];
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
$ex = substr(md5(time()),0,25);
$e0x = substr(md5(time()),0,35);  
echo "<meta http-equiv=\"refresh\" content=\"1; URL= ?head_code=$ex&who=$who&down_code=$e0x&page=$num_pages\"/>";
 
exit();
}
  echo"<div class=\"hmenu hmenubottom\">";
echo"<a href=\"index.php\"><img class=\"pphoto\" src=\"icon.ico\" alt=\"FBD\"/>Send a Stickers</a>
<a href=\"index.php\" class='right_box'>Cancel</a>";
echo"</div>";
echo "<div class=\"penanda\" align=\"left\">";

echo"<b>$whonick</b><br/>Send a Sticker:<br/><br/>";
$stickers_folder = $_GET["stickers_folder"];
$whonick = getnick_uid($who);
$byuid = getuid_sid($sid);
$uid = getuid_sid($sid);
$pmtext = "[image_preview=like_msg_icon.png]";
$head_code = substr(md5(time()),0,25);
$down_code = substr(md5(time()),0,35);

if ($stickers_folder=="meep"){
echo "<form action=\"?action=sent_stickers&head_code=$head_code&who=$who&down_code=$down_code\" method=\"post\">";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/1.png\"/> <img src=\"stickers/$stickers_folder/1.png\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/2.png\"/> <img src=\"stickers/$stickers_folder/2.png\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/3.png\"/> <img src=\"stickers/$stickers_folder/3.png\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/4.png\"/> <img src=\"stickers/$stickers_folder/4.png\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/5.png\"/> <img src=\"stickers/$stickers_folder/5.png\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/6.png\"/> <img src=\"stickers/$stickers_folder/6.png\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/7.png\"/> <img src=\"stickers/$stickers_folder/7.png\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/8.png\"/> <img src=\"stickers/$stickers_folder/8.png\"> ";
echo "<input type=\"Submit\" name=\"send\" Value=\"Send\" class=\"div\"></form>";

$more = "<b>$stickers_folder</b> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Biscuit in Love\">Biscuit in Love</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=drinks\">Drinks</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Fat Rabbit Farm\">Fat Rabbit Farm</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=gifts\">Gifts</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Gumball\">Gumball</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Hacker Boy\">Hacker Boy</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Mango\">Mango</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Momo\">Momo</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Text Talk\">Text Talk</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=The Expendables 3\">The Expendables 3</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=adult\">adult</a><br/>";

}else if ($stickers_folder=="drinks"){
echo "<form action=\"?action=sent_stickers&head_code=$head_code&who=$who&down_code=$down_code\" method=\"post\">";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/1.png\"/> <img src=\"stickers/$stickers_folder/1.png\" hieght=\"53\" width=\"49\">";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/2.png\"/> <img src=\"stickers/$stickers_folder/2.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/3.png\"/> <img src=\"stickers/$stickers_folder/3.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/4.png\"/> <img src=\"stickers/$stickers_folder/4.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/5.png\"/> <img src=\"stickers/$stickers_folder/5.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/6.png\"/> <img src=\"stickers/$stickers_folder/6.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/7.png\"/> <img src=\"stickers/$stickers_folder/7.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/8.png\"/> <img src=\"stickers/$stickers_folder/8.png\" hieght=\"53\" width=\"49\"><br/> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/9.png\"/> <img src=\"stickers/$stickers_folder/9.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/10.png\"/> <img src=\"stickers/$stickers_folder/10.png\" hieght=\"53\" width=\"49\"> ";
echo "<br/><input type=\"Submit\" name=\"send\" Value=\"Send\" class=\"div\"></form>";

$more = "<b>$stickers_folder</b> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Biscuit in Love\">Biscuit in Love</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Fat Rabbit Farm\">Fat Rabbit Farm</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=gifts\">Gifts</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Gumball\">Gumball</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Hacker Boy\">Hacker Boy</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Mango\">Mango</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=meep\">Meep</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Momo\">Momo</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Text Talk\">Text Talk</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=The Expendables 3\">The Expendables 3</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=adult\">adult</a><br/>";

}else if ($stickers_folder=="adult"){
echo "<form action=\"?action=sent_stickers&head_code=$head_code&who=$who&down_code=$down_code\" method=\"post\">";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/1.png\"/> <img src=\"stickers/$stickers_folder/1.png\" hieght=\"53\" width=\"49\">";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/2.png\"/> <img src=\"stickers/$stickers_folder/2.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/3.png\"/> <img src=\"stickers/$stickers_folder/3.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/4.png\"/> <img src=\"stickers/$stickers_folder/4.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/5.png\"/> <img src=\"stickers/$stickers_folder/5.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/6.png\"/> <img src=\"stickers/$stickers_folder/6.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/7.png\"/> <img src=\"stickers/$stickers_folder/7.png\" hieght=\"53\" width=\"49\"> ";
echo "<br/><input type=\"Submit\" name=\"send\" Value=\"Send\" class=\"div\"></form>";

$more = "<b>$stickers_folder</b> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Biscuit in Love\">Biscuit in Love</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=drinks\">Drinks</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Fat Rabbit Farm\">Fat Rabbit Farm</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=gifts\">Gifts</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Gumball\">Gumball</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Hacker Boy\">Hacker Boy</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Mango\">Mango</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=meep\">Meep</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Momo\">Momo</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Text Talk\">Text Talk</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=The Expendables 3\">The Expendables 3</a><br/>";

}else if ($stickers_folder=="gifts"){
echo "<form action=\"?action=sent_stickers&head_code=$head_code&who=$who&down_code=$down_code\" method=\"post\">";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/1.png\"/> <img src=\"stickers/$stickers_folder/1.png\" hieght=\"53\" width=\"49\">";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/2.png\"/> <img src=\"stickers/$stickers_folder/2.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/3.png\"/> <img src=\"stickers/$stickers_folder/3.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/4.png\"/> <img src=\"stickers/$stickers_folder/4.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/5.png\"/> <img src=\"stickers/$stickers_folder/5.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/6.png\"/> <img src=\"stickers/$stickers_folder/6.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/7.png\"/> <img src=\"stickers/$stickers_folder/7.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/8.png\"/> <img src=\"stickers/$stickers_folder/8.png\" hieght=\"53\" width=\"49\"><br/>";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/9.png\"/> <img src=\"stickers/$stickers_folder/9.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/10.png\"/> <img src=\"stickers/$stickers_folder/10.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/11.png\"/> <img src=\"stickers/$stickers_folder/11.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/12.png\"/> <img src=\"stickers/$stickers_folder/12.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/13.png\"/> <img src=\"stickers/$stickers_folder/13.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/14.png\"/> <img src=\"stickers/$stickers_folder/14.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/15.png\"/> <img src=\"stickers/$stickers_folder/15.png\" hieght=\"53\" width=\"49\">";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/16.png\"/> <img src=\"stickers/$stickers_folder/16.png\" hieght=\"53\" width=\"49\"> <br/>";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/17.png\"/> <img src=\"stickers/$stickers_folder/17.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/18.png\"/> <img src=\"stickers/$stickers_folder/18.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/19.png\"/> <img src=\"stickers/$stickers_folder/19.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/20.png\"/> <img src=\"stickers/$stickers_folder/20.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/21.png\"/> <img src=\"stickers/$stickers_folder/21.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/22.png\"/> <img src=\"stickers/$stickers_folder/22.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/23.png\"/> <img src=\"stickers/$stickers_folder/23.png\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/24.png\"/> <img src=\"stickers/$stickers_folder/24.png\" hieght=\"53\" width=\"49\"><br/> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/25.png\"/> <img src=\"stickers/$stickers_folder/25.png\" hieght=\"53\" width=\"49\"> ";
echo "<br/><input type=\"Submit\" name=\"send\" Value=\"Send\" class=\"div\"></form>";

$more = "<b>$stickers_folder</b> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Biscuit in Love\">Biscuit in Love</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=drinks\">Drinks</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Fat Rabbit Farm\">Fat Rabbit Farm</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Gumball\">Gumball</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Hacker Boy\">Hacker Boy</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Mango\">Mango</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=meep\">Meep</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Momo\">Momo</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Text Talk\">Text Talk</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=The Expendables 3\">The Expendables 3</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=adult\">adult</a><br/>";


}else if ($stickers_folder=="Biscuit in Love"){
echo "<form action=\"?action=sent_stickers&head_code=$head_code&who=$who&down_code=$down_code\" method=\"post\">";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/1.jpeg\"/> <img src=\"stickers/$stickers_folder/1.jpeg\" hieght=\"53\" width=\"49\">";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/2.jpeg\"/> <img src=\"stickers/$stickers_folder/2.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/3.jpeg\"/> <img src=\"stickers/$stickers_folder/3.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/4.jpeg\"/> <img src=\"stickers/$stickers_folder/4.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/5.jpeg\"/> <img src=\"stickers/$stickers_folder/5.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/6.jpeg\"/> <img src=\"stickers/$stickers_folder/6.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/7.jpeg\"/> <img src=\"stickers/$stickers_folder/7.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/8.jpeg\"/> <img src=\"stickers/$stickers_folder/8.jpeg\" hieght=\"53\" width=\"49\"><br/>";
echo "<br/><input type=\"Submit\" name=\"send\" Value=\"Send\" class=\"div\"></form>";

$more = "<b>$stickers_folder</b> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=drinks\">Drinks</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Fat Rabbit Farm\">Fat Rabbit Farm</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=gifts\">Gifts</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Gumball\">Gumball</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Hacker Boy\">Hacker Boy</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Mango\">Mango</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=meep\">Meep</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Momo\">Momo</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Text Talk\">Text Talk</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=The Expendables 3\">The Expendables 3</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=adult\">adult</a><br/>";


}else if ($stickers_folder=="Fat Rabbit Farm"){
echo "<form action=\"?action=sent_stickers&head_code=$head_code&who=$who&down_code=$down_code\" method=\"post\">";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/1.jpeg\"/> <img src=\"stickers/$stickers_folder/1.jpeg\" hieght=\"53\" width=\"49\">";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/2.jpeg\"/> <img src=\"stickers/$stickers_folder/2.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/3.jpeg\"/> <img src=\"stickers/$stickers_folder/3.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/4.jpeg\"/> <img src=\"stickers/$stickers_folder/4.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/5.jpeg\"/> <img src=\"stickers/$stickers_folder/5.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/6.jpeg\"/> <img src=\"stickers/$stickers_folder/6.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/7.jpeg\"/> <img src=\"stickers/$stickers_folder/7.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/8.jpeg\"/> <img src=\"stickers/$stickers_folder/8.jpeg\" hieght=\"53\" width=\"49\"><br/>";
echo "<br/><input type=\"Submit\" name=\"send\" Value=\"Send\" class=\"div\"></form>";

$more = "<b>$stickers_folder</b> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Biscuit in Love\">Biscuit in Love</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=drinks\">Drinks</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=gifts\">Gifts</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Gumball\">Gumball</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Hacker Boy\">Hacker Boy</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Mango\">Mango</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=meep\">Meep</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Momo\">Momo</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Text Talk\">Text Talk</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=The Expendables 3\">The Expendables 3</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=adult\">adult</a><br/>";


}else if ($stickers_folder=="Gumball"){
echo "<form action=\"?action=sent_stickers&head_code=$head_code&who=$who&down_code=$down_code\" method=\"post\">";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/1.jpeg\"/> <img src=\"stickers/$stickers_folder/1.jpeg\" hieght=\"53\" width=\"49\">";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/2.jpeg\"/> <img src=\"stickers/$stickers_folder/2.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/3.jpeg\"/> <img src=\"stickers/$stickers_folder/3.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/4.jpeg\"/> <img src=\"stickers/$stickers_folder/4.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/5.jpeg\"/> <img src=\"stickers/$stickers_folder/5.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/6.jpeg\"/> <img src=\"stickers/$stickers_folder/6.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/7.jpeg\"/> <img src=\"stickers/$stickers_folder/7.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/8.jpeg\"/> <img src=\"stickers/$stickers_folder/8.jpeg\" hieght=\"53\" width=\"49\"><br/>";
echo "<br/><input type=\"Submit\" name=\"send\" Value=\"Send\" class=\"div\"></form>";

$more = "<b>$stickers_folder</b> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Biscuit in Love\">Biscuit in Love</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=drinks\">Drinks</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Fat Rabbit Farm\">Fat Rabbit Farm</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=gifts\">Gifts</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Hacker Boy\">Hacker Boy</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Mango\">Mango</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=meep\">Meep</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Momo\">Momo</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Text Talk\">Text Talk</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=The Expendables 3\">The Expendables 3</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=adult\">adult</a><br/>";


}else if ($stickers_folder=="Hacker Boy"){
echo "<form action=\"?action=sent_stickers&head_code=$head_code&who=$who&down_code=$down_code\" method=\"post\">";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/1.jpeg\"/> <img src=\"stickers/$stickers_folder/1.jpeg\" hieght=\"53\" width=\"49\">";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/2.jpeg\"/> <img src=\"stickers/$stickers_folder/2.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/3.jpeg\"/> <img src=\"stickers/$stickers_folder/3.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/4.jpeg\"/> <img src=\"stickers/$stickers_folder/4.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/5.jpeg\"/> <img src=\"stickers/$stickers_folder/5.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/6.jpeg\"/> <img src=\"stickers/$stickers_folder/6.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/7.jpeg\"/> <img src=\"stickers/$stickers_folder/7.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/8.jpeg\"/> <img src=\"stickers/$stickers_folder/8.jpeg\" hieght=\"53\" width=\"49\"><br/>";
echo "<br/><input type=\"Submit\" name=\"send\" Value=\"Send\" class=\"div\"></form>";

$more = "<b>$stickers_folder</b> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Biscuit in Love\">Biscuit in Love</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=drinks\">Drinks</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Fat Rabbit Farm\">Fat Rabbit Farm</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=gifts\">Gifts</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Gumball\">Gumball</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Mango\">Mango</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=meep\">Meep</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Momo\">Momo</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Text Talk\">Text Talk</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=The Expendables 3\">The Expendables 3</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=adult\">adult</a><br/>";


}else if ($stickers_folder=="Mango"){
echo "<form action=\"?action=sent_stickers&head_code=$head_code&who=$who&down_code=$down_code\" method=\"post\">";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/1.jpeg\"/> <img src=\"stickers/$stickers_folder/1.jpeg\" hieght=\"53\" width=\"49\">";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/2.jpeg\"/> <img src=\"stickers/$stickers_folder/2.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/3.jpeg\"/> <img src=\"stickers/$stickers_folder/3.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/4.jpeg\"/> <img src=\"stickers/$stickers_folder/4.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/5.jpeg\"/> <img src=\"stickers/$stickers_folder/5.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/6.jpeg\"/> <img src=\"stickers/$stickers_folder/6.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/7.jpeg\"/> <img src=\"stickers/$stickers_folder/7.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/8.jpeg\"/> <img src=\"stickers/$stickers_folder/8.jpeg\" hieght=\"53\" width=\"49\"><br/>";
echo "<br/><input type=\"Submit\" name=\"send\" Value=\"Send\" class=\"div\"></form>";

$more = "<b>$stickers_folder</b> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Biscuit in Love\">Biscuit in Love</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=drinks\">Drinks</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Fat Rabbit Farm\">Fat Rabbit Farm</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=gifts\">Gifts</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Gumball\">Gumball</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Hacker Boy\">Hacker Boy</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=meep\">Meep</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Momo\">Momo</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Text Talk\">Text Talk</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=The Expendables 3\">The Expendables 3</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=adult\">adult</a><br/>";


}else if ($stickers_folder=="Momo"){
echo "<form action=\"?action=sent_stickers&head_code=$head_code&who=$who&down_code=$down_code\" method=\"post\">";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/1.jpeg\"/> <img src=\"stickers/$stickers_folder/1.jpeg\" hieght=\"53\" width=\"49\">";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/2.jpeg\"/> <img src=\"stickers/$stickers_folder/2.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/3.jpeg\"/> <img src=\"stickers/$stickers_folder/3.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/4.jpeg\"/> <img src=\"stickers/$stickers_folder/4.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/5.jpeg\"/> <img src=\"stickers/$stickers_folder/5.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/6.jpeg\"/> <img src=\"stickers/$stickers_folder/6.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/7.jpeg\"/> <img src=\"stickers/$stickers_folder/7.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/8.jpeg\"/> <img src=\"stickers/$stickers_folder/8.jpeg\" hieght=\"53\" width=\"49\"><br/>";
echo "<br/><input type=\"Submit\" name=\"send\" Value=\"Send\" class=\"div\"></form>";

$more = "<b>$stickers_folder</b> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Biscuit in Love\">Biscuit in Love</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=drinks\">Drinks</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Fat Rabbit Farm\">Fat Rabbit Farm</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=gifts\">Gifts</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Gumball\">Gumball</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Hacker Boy\">Hacker Boy</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Mango\">Mango</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=meep\">Meep</a> ·  
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Text Talk\">Text Talk</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=The Expendables 3\">The Expendables 3</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=adult\">adult</a><br/>";


}else if ($stickers_folder=="Text Talk"){
echo "<form action=\"?action=sent_stickers&head_code=$head_code&who=$who&down_code=$down_code\" method=\"post\">";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/1.jpeg\"/> <img src=\"stickers/$stickers_folder/1.jpeg\" hieght=\"53\" width=\"49\">";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/2.jpeg\"/> <img src=\"stickers/$stickers_folder/2.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/3.jpeg\"/> <img src=\"stickers/$stickers_folder/3.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/4.jpeg\"/> <img src=\"stickers/$stickers_folder/4.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/5.jpeg\"/> <img src=\"stickers/$stickers_folder/5.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/6.jpeg\"/> <img src=\"stickers/$stickers_folder/6.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/7.jpeg\"/> <img src=\"stickers/$stickers_folder/7.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/8.jpeg\"/> <img src=\"stickers/$stickers_folder/8.jpeg\" hieght=\"53\" width=\"49\"><br/>";
echo "<br/><input type=\"Submit\" name=\"send\" Value=\"Send\" class=\"div\"></form>";

$more = "<b>$stickers_folder</b> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Biscuit in Love\">Biscuit in Love</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=drinks\">Drinks</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Fat Rabbit Farm\">Fat Rabbit Farm</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=gifts\">Gifts</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Gumball\">Gumball</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Hacker Boy\">Hacker Boy</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Mango\">Mango</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=meep\">Meep</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Momo\">Momo</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=The Expendables 3\">The Expendables 3</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=adult\">adult</a><br/>";


}else if ($stickers_folder=="The Expendables 3"){
echo "<form action=\"?action=sent_stickers&head_code=$head_code&who=$who&down_code=$down_code\" method=\"post\">";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/1.jpeg\"/> <img src=\"stickers/$stickers_folder/1.jpeg\" hieght=\"53\" width=\"49\">";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/2.jpeg\"/> <img src=\"stickers/$stickers_folder/2.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/3.jpeg\"/> <img src=\"stickers/$stickers_folder/3.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/4.jpeg\"/> <img src=\"stickers/$stickers_folder/4.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/5.jpeg\"/> <img src=\"stickers/$stickers_folder/5.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/6.jpeg\"/> <img src=\"stickers/$stickers_folder/6.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/7.jpeg\"/> <img src=\"stickers/$stickers_folder/7.jpeg\" hieght=\"53\" width=\"49\"> ";
echo"<input type=\"radio\" name=\"sticker\" value=\"stickers/$stickers_folder/8.jpeg\"/> <img src=\"stickers/$stickers_folder/8.jpeg\" hieght=\"53\" width=\"49\"><br/>";
echo "<br/><input type=\"Submit\" name=\"send\" Value=\"Send\" class=\"div\"></form>";

$more = "<b>$stickers_folder</b> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Biscuit in Love\">Biscuit in Love</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=drinks\">Drinks</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Fat Rabbit Farm\">Fat Rabbit Farm</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=gifts\">Gifts</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Gumball\">Gumball</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Hacker Boy\">Hacker Boy</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Mango\">Mango</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=meep\">Meep</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Momo\">Momo</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=Text Talk\">Text Talk</a> · 
<a href=\"?action=stickers&head_code=$head_code&who=$who&down_code=$down_code&stickers_folder=adult\">adult</a><br/>";


}

echo"<br/><b><font color=\"#9397a0\">More Sticker Packs:</font></b> 
$more
<a href=\"stickers.php\">Sticker Store</a><hr/>
<a href=\"?head_code=$head_code&who=$who&down_code=$down_code\">Back To Thread</a><br/>
";


echo "</div>";
include("footer.php");
echo "</body>";
}  

else if($action=="sent_stickers"){
	 
echo "<head>";
echo "<title>Send a Stickers</title>";
echo "</head>";
echo "<body>";
if(ispmbaned($uid)){
$ex = substr(md5(time()),0,25);
$e0x = substr(md5(time()),0,35);  
echo"You are temporary blocked for sending Message by <b>SocailBD Team</b><br/>
Please contact with <a href=\"index.php?action=viewuser&who=2\">Fardin420</a><br/>";
//echo "<meta http-equiv=\"refresh\" content=\"1; URL= ?head_code=$ex&who=$who&down_code=$e0x&page=$num_pages\"/>";
echo"<img src=\"images/home.gif\" alt=\"\"><a href=\"index.php?action=main\">Home</a>";
include("footer.php");
exit();
}
if(isignored($uid, $who)){
$head_code = substr(md5(time()),0,25);
$down_code = substr(md5(time()),0,35);
$who = $_GET["who"];
//header("Location: chat.php?head_code=$head_code&who=$who&down_code=$down_code");
echo"You are ignored";
$pms = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE (byuid='".getuid_sid($sid)."' AND touid='".$who."') OR (byuid='".$who."' AND touid='".getuid_sid($sid)."') ORDER BY timesent"));
$num_items = $pms[0];
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
$ex = substr(md5(time()),0,25);
$e0x = substr(md5(time()),0,35);  
echo "<meta http-equiv=\"refresh\" content=\"1; URL= ?head_code=$ex&who=$who&down_code=$e0x&page=$num_pages\"/>";
 
exit();
}
 $who = $_GET["who"];
$sticker = $_POST["sticker"];
$whonick = getnick_uid($who);
$byuid = getuid_sid($sid);
$uid = getuid_sid($sid);
$pmtext = "[image_preview=$sticker]";


$iu = mysql_fetch_array(mysql_query("SELECT id FROM alien_war_rooms WHERE (byuid='".$uid."' AND touid='".$who."') OR (byuid='".$who."' AND touid='".$uid."')"));
$res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$pmtext."', byuid='".$uid."', touid='".$who."', timesent='".time()."', folderid='".$iu[0]."'");
if($res){
$head_code = substr(md5(time()),0,25);
$down_code = substr(md5(time()),0,35);
$who = $_GET["who"];
//header("Location: chat.php?head_code=$head_code&who=$who&down_code=$down_code");
echo"Message sent Successfully";
$pms = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE (byuid='".getuid_sid($sid)."' AND touid='".$who."') OR (byuid='".$who."' AND touid='".getuid_sid($sid)."') ORDER BY timesent"));
$num_items = $pms[0];
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
$ex = substr(md5(time()),0,25);
$e0x = substr(md5(time()),0,35);  
echo "<meta http-equiv=\"refresh\" content=\"1; URL= ?head_code=$ex&who=$who&down_code=$e0x&page=$num_pages\"/>";
 

$isu = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM alien_war_rooms WHERE (byuid='".$uid."' AND touid='".$who."') OR (byuid='".$who."' AND touid='".$uid."')"));
if($isu[0]>0){
mysql_query("UPDATE alien_war_rooms SET timesent='".time()."' WHERE (byuid='".$uid."' AND touid='".$who."') OR (byuid='".$who."' AND touid='".$uid."')");
}else{mysql_query("INSERT INTO alien_war_rooms SET byuid='".$uid."', touid='".$who."', timesent='".time()."'");}

}else{
echo "There must be something wrong. Contact with developers";
}

echo "</div>";
include("footer.php");
echo "</body>";
}

else if($action=="add_photo"){
	 if(ispmbaned($uid)){
$ex = substr(md5(time()),0,25);
$e0x = substr(md5(time()),0,35);  
echo"You are temporary blocked for sending Message by <b>SocailBD Team</b><br/>
Please contact with <a href=\"index.php?action=viewuser&who=2\">Fardin420</a><br/>";
//echo "<meta http-equiv=\"refresh\" content=\"1; URL= ?head_code=$ex&who=$who&down_code=$e0x&page=$num_pages\"/>";
echo"<img src=\"images/home.gif\" alt=\"\"><a href=\"index.php?action=main\">Home</a>";
include("footer.php");
exit();
}
echo "<head>";
echo "<title>Add Photos</title>";
echo "</head>";
echo "<body>";
include("header.php");
echo"<div class=\"penanda\">";
if(isignored($uid, $who)){
$head_code = substr(md5(time()),0,25);
$down_code = substr(md5(time()),0,35);
$who = $_GET["who"];
//header("Location: chat.php?head_code=$head_code&who=$who&down_code=$down_code");
echo"You are ignored by the user";
$pms = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE (byuid='".getuid_sid($sid)."' AND touid='".$who."') OR (byuid='".$who."' AND touid='".getuid_sid($sid)."') ORDER BY timesent"));
$num_items = $pms[0];
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
$ex = substr(md5(time()),0,25);
$e0x = substr(md5(time()),0,35);  
echo "<meta http-equiv=\"refresh\" content=\"1; URL= ?head_code=$ex&who=$who&down_code=$e0x&page=$num_pages\"/>";
 
exit();
}
 $who = $_GET["who"];
$sticker = $_POST["sticker"];
$whonick = getnick_uid($who);
$byuid = getuid_sid($sid);
$uid = getuid_sid($sid);
$pmtext = "[image_preview=$sticker]";

$head_code = substr(md5(time()),0,25);
$down_code = substr(md5(time()),0,35);
echo "<b>$whonick</b><br/>Send Photos<hr/><br/>
<form enctype=\"multipart/form-data\" action=\"?action=upload&head_code=$head_code&who=$who&down_code=$down_code\" method=\"post\">";
  echo "<input type=\"file\" name=\"attach\" class=\"penanda\"/><br/>";
  echo"<input type=\"hidden\" name=\"head_code\" value=\"$head_code\">";
  echo"<input type=\"hidden\" name=\"who\" value=\"$who\">";
  echo"<input type=\"hidden\" name=\"down_code\" value=\"$down_code\">";
echo"<input id=\"inputButton\" type=\"submit\" name=\"submit\" value=\"Send Photos\" class=\"div\"/>
        </form><br/>";

echo "</div>";
include("footer.php");
echo "</body>";
}  
?>
</html>