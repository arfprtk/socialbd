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
$who = $_GET["who"];
$whonick = getnick_uid($who);
$sitename = mysql_fetch_array(mysql_query("SELECT value FROM ibwfrr_settings WHERE name='sitename'"));
$sitename = $sitename[0];



if($action != ""){
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

addonline(getuid_sid($sid),"Advance Shout","special_shout.php");
if($action=="")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Advance Shout",$pstyle);
$l_id = $_GET["l_id"];
$act_cat = $_GET["act_cat"];
$act_id = $_GET["act_id"];
$img_id = $_GET["img_id"];

$ex = substr(md5(time()),0,25);
$e0x = substr(md5(time()),0,35);  
$e00x = substr(md5(time()),0,45);  
echo"<small><b>TIPS:</b><br/>
<font color=\"red\">
At first - <br/>
(*) Add Location or<br/>
(*) Add Feelings/Activity or<br/>
(*) Add Photos<br/>
Then write down your message for shout!!!</font><br/><br/>";
     $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwfrr_disable_shout"));
  if($noi[0]==1){
	  echo"<center><br/>Shoutbox disable by <b>Staff Team</b><br/><br/></center>";
  }else{
echo" <br/>ShoutBox Message:</small><br/>
<form method=\"post\" action=\"?action=shout_proc_advance\">
<textarea name=\"shtxt\" style=\"height:60px;width: 270px;\" ></textarea><br/>
<small><b>";
echo"
<b><a style=\"font-family: Comic CMS Scan;font-style:normal;\">Simple Emotions</a> : <a href=\"lists.php?action=smilies\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Smilies</a> : <a href=\"lists.php?action=bbcode\" style=\"font-family: Comic CMS Scan;font-style:normal;\">BBCodes</a></b><br/>
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
:*	<img src=\"emoticons/1 (16).png\" height=\"16\" width=\"16\" /> 
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
<br/><br/>
";
if ($l_id==""){
echo"<img src=\"emotions/gqS520QVYNv.png\" alt=\"Add Location\"/> <a href=\"?action=location&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Add Location</a><br/>";
}else{
$l_name = mysql_fetch_array(mysql_query("SELECT title FROM dcroxx_me_s_location WHERE id='".$l_id."'"));
echo"<img src=\"emotions/CUcWG_lmHJ9.png\" alt=\"Add Location\"/> <a href=\"?action=location&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">$l_name[0]</a><br/>";
}

if ($act_cat=="0"){
$i = mysql_fetch_array(mysql_query("SELECT title, details FROM dcroxx_me_s_activity WHERE act_cat='0' AND id='".$act_id."'"));
$asdf = "<img src=\"emotions/01TjtkIxVPt.png\"> <a href=\"?action=activity&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">$i[0]</a>";
}else if ($act_cat=="1"){
$i = mysql_fetch_array(mysql_query("SELECT title, details FROM dcroxx_me_s_activity WHERE act_cat='1' AND id='".$act_id."'"));
$asdf = "<img src=\"emotions/01TjtkIxVPt.png\"> <a href=\"?action=activity&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Feeling $i[0]</a>";
}else if ($act_cat=="2"){
$i = mysql_fetch_array(mysql_query("SELECT title, details FROM dcroxx_me_s_activity WHERE act_cat='2' AND id='".$act_id."'"));
$asdf = "<img src=\"emotions/H-xqTJfPmTL.png\"> <a href=\"?action=activity&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Watching $i[0]</a>";
}else if ($act_cat=="3"){
$i = mysql_fetch_array(mysql_query("SELECT title, details FROM dcroxx_me_s_activity WHERE act_cat='3' AND id='".$act_id."'"));
$asdf = "<img src=\"emotions/m4LtK_PmtP2.png\"> <a href=\"?action=activity&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Reading $i[0]</a>";
}else if ($act_cat=="4"){
$i = mysql_fetch_array(mysql_query("SELECT title, details FROM dcroxx_me_s_activity WHERE act_cat='4' AND id='".$act_id."'"));
$asdf = "<img src=\"emotions/s6A1uyjNu18.png\"> <a href=\"?action=activity&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Listening To $i[0]</a>";
}else if ($act_cat=="5"){
$i = mysql_fetch_array(mysql_query("SELECT title, details FROM dcroxx_me_s_activity WHERE act_cat='5' AND id='".$act_id."'"));
$asdf = "<img src=\"emotions/zFR1EyqbEhr.png\"> <a href=\"?action=activity&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Drinking $i[0]</a>";
}else if ($act_cat=="6"){
$i = mysql_fetch_array(mysql_query("SELECT title, details FROM dcroxx_me_s_activity WHERE act_cat='6' AND id='".$act_id."'"));
$asdf = "<img src=\"emotions/LDWD2fqgedV.png\"> <a href=\"?action=activity&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Eating $i[0]</a>";
}else if ($act_cat=="7"){
$i = mysql_fetch_array(mysql_query("SELECT title, details FROM dcroxx_me_s_activity WHERE act_cat='7' AND id='".$act_id."'"));
$asdf = "<img src=\"emotions/PWXl1uOBmiV.png\"> <a href=\"?action=activity&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Playing $i[0]</a>";
}else if ($act_cat=="8"){
$i = mysql_fetch_array(mysql_query("SELECT title, details FROM dcroxx_me_s_activity WHERE act_cat='8' AND id='".$act_id."'"));
$asdf = "<img src=\"emotions/_Gr8Yagnmzs.png\"> <a href=\"?action=activity&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Travelling To $i[0]</a>";
}else if ($act_cat=="9"){
$i = mysql_fetch_array(mysql_query("SELECT title, details FROM dcroxx_me_s_activity WHERE act_cat='9' AND id='".$act_id."'"));
$asdf = "<img src=\"emotions/ElGwiB8-Nv-.png\"> <a href=\"?action=activity&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Looking For $i[0]</a>";
}else if ($act_cat=="10"){
$i = mysql_fetch_array(mysql_query("SELECT title, details FROM dcroxx_me_s_activity WHERE act_cat='10' AND id='".$act_id."'"));
$asdf = "<img src=\"emotions/6njE4ZpfaGe.png\"> <a href=\"?action=activity&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Exercising $i[0]</a>";
}else if ($act_cat=="11"){
$i = mysql_fetch_array(mysql_query("SELECT title, details FROM dcroxx_me_s_activity WHERE act_cat='11' AND id='".$act_id."'"));
$asdf = "<img src=\"emotions/0bpKgMSKCH7.png\"> <a href=\"?action=activity&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Attending $i[0]</a>";
}else if ($act_cat=="12"){
$i = mysql_fetch_array(mysql_query("SELECT title, details FROM dcroxx_me_s_activity WHERE act_cat='12' AND id='".$act_id."'"));
$asdf = "<img src=\"emotions/l0bR-N4pFr0.png\"> <a href=\"?action=activity&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Supporting $i[0]</a>";
}else if ($act_cat=="13"){
$i = mysql_fetch_array(mysql_query("SELECT title, details FROM dcroxx_me_s_activity WHERE act_cat='13' AND id='".$act_id."'"));
$asdf = "<img src=\"emotions/Y0XYQTSGpjm.png\"> <a href=\"?action=activity&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Celebrating $i[0]</a>";
}else if ($act_cat=="14"){
$i = mysql_fetch_array(mysql_query("SELECT title, details FROM dcroxx_me_s_activity WHERE act_cat='14' AND id='".$act_id."'"));
$asdf = "<img src=\"emotions/BjLdaEqXEtx.png\"> <a href=\"?action=activity&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Meeting $i[0]</a>";
}else if ($act_cat=="15"){
$i = mysql_fetch_array(mysql_query("SELECT title, details FROM dcroxx_me_s_activity WHERE act_cat='15' AND id='".$act_id."'"));
$asdf = "<img src=\"emotions/7mp6__C07cx.png\"> <a href=\"?action=activity&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Getting $i[0]</a>";
}else if ($act_cat=="16"){
$i = mysql_fetch_array(mysql_query("SELECT title, details FROM dcroxx_me_s_activity WHERE act_cat='16' AND id='".$act_id."'"));
$asdf = "<img src=\"emotions/LTyVawR3QTl.png\"> <a href=\"?action=activity&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Making $i[0]</a>";
}else if ($act_cat=="17"){
$i = mysql_fetch_array(mysql_query("SELECT title, details FROM dcroxx_me_s_activity WHERE act_cat='17' AND id='".$act_id."'"));
$asdf = "<img src=\"emotions/xgYYkUVvZDW.png\"> <a href=\"?action=activity&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Thinking About $i[0]</a>";
}else if ($act_cat=="18"){
$i = mysql_fetch_array(mysql_query("SELECT title, details FROM dcroxx_me_s_activity WHERE act_cat='18' AND id='".$act_id."'"));
$asdf = "<img src=\"emotions/nH18MO0PvHr.png\"> <a href=\"?action=activity&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Remembering $i[0]</a>";
}



if ($act_cat==""){
echo"<img src=\"emotions/s_JBnFooj2Z.png\" alt=\"Add Feeling or Activity\"/> <a href=\"?action=activity&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Add Feeling or Activity</a><br/>";
}else{
echo"$asdf<br/>";
}

if ($img_id==""){
echo"<img src=\"emotions/KIY954HBjri.png\" alt=\"Add Photos\"/> <a href=\"?action=photo&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Add Photos</a><br/>";
}else{
echo"<img src=\"emotions/KIY954HBjri.png\" alt=\"Add Photos\"/> <img src=\"$img_id\" alt=\"Add Photos\" height=\"28\" width=\"30\"><br/>";
}

$ex = substr(md5(time()),0,25);
$e0x = substr(md5(time()),0,35);  
$e00x = substr(md5(time()),0,45);  
$act_cat = $_GET["act_cat"];
$act_id = $_GET["act_id"];
$img_id = $_GET["img_id"];
echo"</b></small>
<br/><input type=\"submit\" name=\"Submit\" style=\"height:30px;width: 270px;\" value=\"Add Shout\"/><br/>
<input type=\"hidden\" name=\"l_id\" value=\"$l_id\"/>
<input type=\"hidden\" name=\"timeX\" value=\"$ex\"/>
<input type=\"hidden\" name=\"act_cat\" value=\"$act_cat\"/>
<input type=\"hidden\" name=\"timeY\" value=\"$e0x\"/>
<input type=\"hidden\" name=\"act_id\" value=\"$act_id\"/>
<input type=\"hidden\" name=\"timeZ\" value=\"$e00x\"/>
<input type=\"hidden\" name=\"img_id\" value=\"$img_id\"/>
</form>";

}
  echo "<p align=\"center\"><small>";
  echo "<br/><a href=\"index.php?action=main\" style=\"font-family: Comic CMS Scan;font-style:normal;\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}

else if($action=="photo")
{
      $pstyle = gettheme($sid);
      echo xhtmlhead("Advance Shout",$pstyle);
    addonline(getuid_sid($sid),"Attact a Photo","attach.php?action=$action");
	    echo "<head>";
    echo "<title>Add Photos</title>";
    echo "</head>";
    echo "<body>";
$ex = substr(md5(time()),0,25);
$e0x = substr(md5(time()),0,35);  
$e00x = substr(md5(time()),0,45);  
$act_cat = $_GET["act_cat"];
$act_id = $_GET["act_id"];
$img_id = $_GET["img_id"];
$l_id = $_GET["l_id"];


echo"<div class=\"penanda\">";
 // echo "Shoutbox Message:<br/><input name=\"shtxt\" maxlength=\"250\"/><br/>";

echo "<form enctype=\"multipart/form-data\" action=\"?action=upload&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" method=\"post\">";
  echo "<small><b>Add Photos</b></small><br/><br/><input type=\"file\" name=\"attach\" class=\"penanda\"/><br/><br/>";
echo"<input id=\"inputButton\" type=\"submit\" name=\"submit\" value=\"POST AND PREVIEW\" class=\"div\"/>
<input type=\"hidden\" name=\"l_id\" value=\"$l_id\"/>
<input type=\"hidden\" name=\"timeX\" value=\"$ex\"/>
<input type=\"hidden\" name=\"act_cat\" value=\"$act_cat\"/>
<input type=\"hidden\" name=\"timeY\" value=\"$e0x\"/>
<input type=\"hidden\" name=\"act_id\" value=\"$act_id\"/>
<input type=\"hidden\" name=\"timeZ\" value=\"$e00x\"/>
<input type=\"hidden\" name=\"img_id\" value=\"$img_id\"/>
        </form></div><br/>";
  echo "<p align=\"center\"><small>";
  echo "<br/><a href=\"index.php?action=main\" style=\"font-family: Comic CMS Scan;font-style:normal;\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
echo "</body>";
}
else if($action=="upload"){
      $pstyle = gettheme($sid);
      echo xhtmlhead("Advance Shout",$pstyle);
$ex = substr(md5(time()),0,25);
$e0x = substr(md5(time()),0,35);  
$e00x = substr(md5(time()),0,45);  
$act_cat = $_GET["act_cat"];
$act_id = $_GET["act_id"];
$img_id = $_GET["img_id"];
$l_id = $_GET["l_id"];

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
$uploaddir = "attach";
if($size>1024){
echo "File Is Larger Than 1MB!";
}
else if ($res==false){
echo "<br/>File type not supported ! Please attach only a JPG/JPEG format image.<br/>";
}else{
$name = getuid_sid($sid);
$image_path = "logo.png";
$font_path = "GILSANUB.TTF";
$font_size = 30;       // in pixcels
//$water_mark_text_1 = "9";
$water_mark_text_2 = "SocialBD";

function watermark_image($oldimage_name, $new_image_name){
    global $image_path;
    list($owidth,$oheight) = getimagesize($oldimage_name);
    //$width = $height = 300;    
    $width = 250;    
    $height = 250;  
	/*$width = $owidth;    
    $height = $oheight;    */
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
    $width = 250;    
    $height = 250; 
	/*$width = $owidth;    
    $height = $oheight;   */ 
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
if(isset($_POST['submit']) and $_POST['submit'] == "POST AND PREVIEW"){
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

}

 //header("Location: s_more.php?imgid=attach/$file1");
 $rty ="$demo_image";
 //echo $rty;
 echo"Photo uploaded successfully!<br/>
 Please wait for some moments";
 echo "<meta http-equiv=\"refresh\" content=\"1; URL= ?&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$rty\"/>";
 //&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id
// header("Location: s_more.php?imgid=$rty");


}
}}}}

else if($action=="location"){
      $pstyle = gettheme($sid);
      echo xhtmlhead("Add Location",$pstyle);
$ex = substr(md5(time()),0,25);
$e0x = substr(md5(time()),0,35);  
$e00x = substr(md5(time()),0,45);  
$act_cat = $_GET["act_cat"];
$act_id = $_GET["act_id"];
$img_id = $_GET["img_id"];

echo"<form method=\"get\" action=\"special_shout.php?action=location\">
<input name=\"stext\" style=\"height:20px;width: 270px;\" placeholder=\"Search Location\" autocomplete=\"off\" autocorrect=\"off\" spellcheck=\"false\" type=\"text\"/>
<input value=\"Search\" type=\"submit\" style=\"height:29px;\"/>
<input type=\"hidden\" name=\"action\" value=\"location\"/>
<input type=\"hidden\" name=\"timeX\" value=\"$ex\"/>
<input type=\"hidden\" name=\"act_cat\" value=\"$act_cat\"/>
<input type=\"hidden\" name=\"timeY\" value=\"$e0x\"/>
<input type=\"hidden\" name=\"act_id\" value=\"$act_id\"/>
<input type=\"hidden\" name=\"timeZ\" value=\"$e00x\"/>
</form>";
echo"<b><font color=\"#9397a0\">NEARBY</font></b><br/><br/>";
////////May be it's Complete

$stext = $_GET["stext"];
$sin = $_GET["sin"];
$sor = $_GET["sor"];
if(trim($stext)==""){
if($page=="" || $page<=0)$page=1;
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_s_location"));
$num_items = $noi[0]; //changable
$items_per_page= 20;
$num_pages = ceil($num_items/$items_per_page);
if(($page>$num_pages)&&$page!=1)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;
$sql = "SELECT title, img, details, id FROM dcroxx_me_s_location ORDER BY title DESC LIMIT $limit_start, $items_per_page";
$items = mysql_query($sql);
echo mysql_error();
if(mysql_num_rows($items)>0){
while ($item = mysql_fetch_array($items)){
if ($item[2]==""){$det = "";}else{$det = " <small>($item[2])</small>";}
echo "<img src=\"$item[1]\" alt=\"\"/> <a href=\"?l_id=$item[3]&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">$item[0]</a>$det<br/>";
}}
}else{
if($page=="" || $page<1)$page=1;
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_s_location WHERE title LIKE '%".$stext."%'"));
$num_items = $noi[0];
$items_per_page = 20;
$num_pages = ceil($num_items/$items_per_page);
if(($page>$num_pages)&&$page!=1)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;
$sql = "SELECT title, img, details, id FROM dcroxx_me_s_location WHERE title LIKE '%".$stext."%' ORDER BY title LIMIT $limit_start, $items_per_page";
$items = mysql_query($sql);
while($item=mysql_fetch_array($items)){
if ($item[2]==""){$det = "";}else{$det = " <small>($item[2])</small>";}
echo "<img src=\"$item[1]\" alt=\"\"/> <a href=\"?l_id=$item[3]&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">$item[0]</a>$det<br/>";
}
$ni = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_s_location WHERE title LIKE '%".$stext."%'"));
if ($ni[0]==0){
mysql_query("INSERT INTO dcroxx_me_s_location SET title='".$stext."', img='emotions/gqS520QVYNv.png', details=''");
$oi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_s_location"));
$o = $oi[0];
echo "<img src=\"$item[1]\" alt=\"\"/> <a href=\"?l_id=$o&amp;timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">$stext</a><br/>";
}else{}
}

////////May be it's Complete
echo "</div>";


  echo "<p align=\"center\"><small>";
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}else if($action=="activity"){
      $pstyle = gettheme($sid);
      echo xhtmlhead("What are you doing?",$pstyle);
$l_id = $_GET["l_id"];
$act_cat = $_GET["act_cat"];
$act_id = $_GET["act_id"];
$img_id = $_GET["img_id"];

$ex = substr(md5(time()),0,25);
$e0x = substr(md5(time()),0,35);  
$e00x = substr(md5(time()),0,45);  
//echo"&amp;timeX=$ex&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x";

	  
echo"<img src=\"emotions/01TjtkIxVPt.png\"> <a href=\"?action=activity_details&act_cat=1&amp;timeX=$ex&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Feeling</a><br/>";
echo"<img src=\"emotions/H-xqTJfPmTL.png\"> <a href=\"?action=activity_details&act_cat=2&amp;timeX=$ex&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Watching</a><br/>";
echo"<img src=\"emotions/m4LtK_PmtP2.png\"> <a href=\"?action=activity_details&act_cat=3&amp;timeX=$ex&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Reading</a><br/>";
echo"<img src=\"emotions/s6A1uyjNu18.png\"> <a href=\"?action=activity_details&act_cat=4&amp;timeX=$ex&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Listening To</a><br/>";
echo"<img src=\"emotions/zFR1EyqbEhr.png\"> <a href=\"?action=activity_details&act_cat=5&amp;timeX=$ex&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Drinking</a><br/>";
echo"<img src=\"emotions/LDWD2fqgedV.png\"> <a href=\"?action=activity_details&act_cat=6&amp;timeX=$ex&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Eating</a><br/>";
echo"<img src=\"emotions/PWXl1uOBmiV.png\"> <a href=\"?action=activity_details&act_cat=7&amp;timeX=$ex&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Playing</a><br/>";
echo"<img src=\"emotions/_Gr8Yagnmzs.png\"> <a href=\"?action=activity_details&act_cat=8&amp;timeX=$ex&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Travelling To</a><br/>";
echo"<img src=\"emotions/ElGwiB8-Nv-.png\"> <a href=\"?action=activity_details&act_cat=9&amp;timeX=$ex&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Looking For</a><br/>";
echo"<img src=\"emotions/6njE4ZpfaGe.png\"> <a href=\"?action=activity_details&act_cat=10&amp;timeX=$ex&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Exercising</a><br/>";
echo"<img src=\"emotions/0bpKgMSKCH7.png\"> <a href=\"?action=activity_details&act_cat=11&amp;timeX=$ex&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Attending</a><br/>";
echo"<img src=\"emotions/l0bR-N4pFr0.png\"> <a href=\"?action=activity_details&act_cat=12&amp;timeX=$ex&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Supporting</a><br/>";
echo"<img src=\"emotions/Y0XYQTSGpjm.png\"> <a href=\"?action=activity_details&act_cat=13&amp;timeX=$ex&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Celebrating</a><br/>";
echo"<img src=\"emotions/BjLdaEqXEtx.png\"> <a href=\"?action=activity_details&act_cat=14&amp;timeX=$ex&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Meeting</a><br/>";
echo"<img src=\"emotions/7mp6__C07cx.png\"> <a href=\"?action=activity_details&act_cat=15&amp;timeX=$ex&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Getting</a><br/>";
echo"<img src=\"emotions/LTyVawR3QTl.png\"> <a href=\"?action=activity_details&act_cat=16&amp;timeX=$ex&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Making</a><br/>";
echo"<img src=\"emotions/xgYYkUVvZDW.png\"> <a href=\"?action=activity_details&act_cat=17&amp;timeX=$ex&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Thinking About</a><br/>";
echo"<img src=\"emotions/nH18MO0PvHr.png\"> <a href=\"?action=activity_details&act_cat=18&amp;timeX=$ex&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">Remembering</a><br/>";
echo"<img src=\"emotions/01TjtkIxVPt.png\"> <a href=\"?action=activity_details&act_cat=0&amp;timeX=$ex&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">More...</a><br/>";


  echo "<p align=\"center\"><small>";
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}
else if($action=="activity_details"){
//$act_cat = $_GET["act_cat"];
$l_id = $_GET["l_id"];
$act_cat = $_GET["act_cat"];
$act_id = $_GET["act_id"];
$img_id = $_GET["img_id"];

$ex = substr(md5(time()),0,25);
$e0x = substr(md5(time()),0,35);  
$e00x = substr(md5(time()),0,45);  
//echo"&amp;timeX=$ex&amp;timeY=$e0x&amp;act_id=$act_id&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x";

$pstyle = gettheme($sid);
if ($act_cat=="" || $act_cat=="0"){
$asdf = "More";
}else if ($act_cat=="1"){
$asdf = "How are you feeling?";
}else if ($act_cat=="2"){
$asdf = "What are you watching?";
}else if ($act_cat=="3"){
$asdf = "What are you reading?";
}else if ($act_cat=="4"){
$asdf = "What are you listening?";
}else if ($act_cat=="5"){
$asdf = "What are you drinking?";
}else if ($act_cat=="6"){
$asdf = "What are you eating?";
}else if ($act_cat=="7"){
$asdf = "What are you playing?";
}else if ($act_cat=="8"){
$asdf = "Where are you travelling to?";
}else if ($act_cat=="9"){
$asdf = "What are you looking for?";
}else if ($act_cat=="10"){
$asdf = "What are you exercising?";
}else if ($act_cat=="11"){
$asdf = "What are you attending?";
}else if ($act_cat=="12"){
$asdf = "What are you supporting?";
}else if ($act_cat=="13"){
$asdf = "What are you celebrating?";
}else if ($act_cat=="14"){
$asdf = "What are you meeting?";
}else if ($act_cat=="15"){
$asdf = "What are you getting?";
}else if ($act_cat=="16"){
$asdf = "What are you making?";
}else if ($act_cat=="17"){
$asdf = "What are you thinking?";
}else if ($act_cat=="18"){
$asdf = "What are you remembering?";
}
      echo xhtmlhead("$asdf",$pstyle);
echo"<form method=\"get\" action=\"special_shout.php?action=activity_details\">
<input name=\"stext\" style=\"height:20px;width: 270px;\" placeholder=\"Search\" autocomplete=\"off\" autocorrect=\"off\" spellcheck=\"false\" type=\"text\"/>
<input value=\"Search\" type=\"submit\" style=\"height:29px;\"/>
<input type=\"hidden\" name=\"action\" value=\"activity_details\"/>
<input type=\"hidden\" name=\"act_cat\" value=\"$act_cat\"/>
<input type=\"hidden\" name=\"timeX\" value=\"$ex\"/>
<input type=\"hidden\" name=\"l_id\" value=\"$l_id\"/>
<input type=\"hidden\" name=\"timeY\" value=\"$e0x\"/>
<input type=\"hidden\" name=\"act_id\" value=\"$act_id\"/>
<input type=\"hidden\" name=\"timeZ\" value=\"$e00x\"/>
<input type=\"hidden\" name=\"img_id\" value=\"$img_id\"/>
</form>";
//echo"<b><font color=\"#9397a0\">NEARBY</font></b><br/><br/>";
echo"<br/><br/>";
////////May be it's Complete
$stext = $_GET["stext"];
$sin = $_GET["sin"];
$sor = $_GET["sor"];
if(trim($stext)==""){
if($page=="" || $page<=0)$page=1;
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_s_activity WHERE act_cat='".$act_cat."'"));
$num_items = $noi[0]; //changable
$items_per_page= 20;
$num_pages = ceil($num_items/$items_per_page);
if(($page>$num_pages)&&$page!=1)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;
$sql = "SELECT title, img, details, id, act_cat FROM dcroxx_me_s_activity WHERE act_cat='".$act_cat."' ORDER BY title DESC LIMIT $limit_start, $items_per_page";
$items = mysql_query($sql);
echo mysql_error();
if(mysql_num_rows($items)>0){
while ($item = mysql_fetch_array($items)){
//timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$$item[3]&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x
echo "<img src=\"$item[1]\" alt=\"\"/> <a href=\"?timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$item[3]&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">$item[0]</a><br/>";
}}
}else{
$l_id = $_GET["l_id"];
if($page=="" || $page<1)$page=1;
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_s_activity WHERE act_cat='".$act_cat."' AND title LIKE '%".$stext."%'"));
$num_items = $noi[0];
$items_per_page = 20;
$num_pages = ceil($num_items/$items_per_page);
if(($page>$num_pages)&&$page!=1)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;
$sql = "SELECT title, img, details, id FROM dcroxx_me_s_activity WHERE act_cat='".$act_cat."' AND title LIKE '%".$stext."%' ORDER BY title LIMIT $limit_start, $items_per_page";
$items = mysql_query($sql);
while($item=mysql_fetch_array($items)){
echo "<img src=\"$item[1]\" alt=\"\"/> <a href=\"?timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$item[3]&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">$item[0]</a><br/>";
}
$ni = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_s_activity WHERE act_cat='".$act_cat."' AND title LIKE '%".$stext."%'"));
if ($ni[0]==0){

if ($act_cat=="" || $act_cat=="0"){
mysql_query("INSERT INTO dcroxx_me_s_activity SET title='".$stext."', img='emotions/01TjtkIxVPt.png', details='', act_cat='".$act_cat."'");
}else if ($act_cat=="1"){
mysql_query("INSERT INTO dcroxx_me_s_activity SET title='".$stext."', img='emotions/01TjtkIxVPt.png', details='', act_cat='".$act_cat."'");
}else if ($act_cat=="2"){
mysql_query("INSERT INTO dcroxx_me_s_activity SET title='".$stext."', img='emotions/H-xqTJfPmTL.png', details='', act_cat='".$act_cat."'");
}else if ($act_cat=="3"){
mysql_query("INSERT INTO dcroxx_me_s_activity SET title='".$stext."', img='emotions/m4LtK_PmtP2.png', details='', act_cat='".$act_cat."'");
}else if ($act_cat=="4"){
mysql_query("INSERT INTO dcroxx_me_s_activity SET title='".$stext."', img='emotions/s6A1uyjNu18.png', details='', act_cat='".$act_cat."'");
}else if ($act_cat=="5"){
mysql_query("INSERT INTO dcroxx_me_s_activity SET title='".$stext."', img='emotions/zFR1EyqbEhr.png', details='', act_cat='".$act_cat."'");
}else if ($act_cat=="6"){
mysql_query("INSERT INTO dcroxx_me_s_activity SET title='".$stext."', img='emotions/LDWD2fqgedV.png', details='', act_cat='".$act_cat."'");
}else if ($act_cat=="7"){
mysql_query("INSERT INTO dcroxx_me_s_activity SET title='".$stext."', img='emotions/PWXl1uOBmiV.png', details='', act_cat='".$act_cat."'");
}else if ($act_cat=="8"){
mysql_query("INSERT INTO dcroxx_me_s_activity SET title='".$stext."', img='emotions/_Gr8Yagnmzs.png', details='', act_cat='".$act_cat."'");
}else if ($act_cat=="9"){
mysql_query("INSERT INTO dcroxx_me_s_activity SET title='".$stext."', img='emotions/ElGwiB8-Nv-.png', details='', act_cat='".$act_cat."'");
}else if ($act_cat=="10"){
mysql_query("INSERT INTO dcroxx_me_s_activity SET title='".$stext."', img='emotions/6njE4ZpfaGe.png', details='', act_cat='".$act_cat."'");
}else if ($act_cat=="11"){
mysql_query("INSERT INTO dcroxx_me_s_activity SET title='".$stext."', img='emotions/0bpKgMSKCH7.png', details='', act_cat='".$act_cat."'");
}else if ($act_cat=="12"){
mysql_query("INSERT INTO dcroxx_me_s_activity SET title='".$stext."', img='emotions/l0bR-N4pFr0.png', details='', act_cat='".$act_cat."'");
}else if ($act_cat=="13"){
mysql_query("INSERT INTO dcroxx_me_s_activity SET title='".$stext."', img='emotions/Y0XYQTSGpjm.png', details='', act_cat='".$act_cat."'");
}else if ($act_cat=="14"){
mysql_query("INSERT INTO dcroxx_me_s_activity SET title='".$stext."', img='emotions/BjLdaEqXEtx.png', details='', act_cat='".$act_cat."'");
}else if ($act_cat=="15"){
mysql_query("INSERT INTO dcroxx_me_s_activity SET title='".$stext."', img='emotions/7mp6__C07cx.png', details='', act_cat='".$act_cat."'");
}else if ($act_cat=="16"){
mysql_query("INSERT INTO dcroxx_me_s_activity SET title='".$stext."', img='emotions/LTyVawR3QTl.png', details='', act_cat='".$act_cat."'");
}else if ($act_cat=="17"){
mysql_query("INSERT INTO dcroxx_me_s_activity SET title='".$stext."', img='emotions/xgYYkUVvZDW.png', details='', act_cat='".$act_cat."'");
}else if ($act_cat=="18"){
mysql_query("INSERT INTO dcroxx_me_s_activity SET title='".$stext."', img='emotions/nH18MO0PvHr.png', details='', act_cat='".$act_cat."'");
}

//mysql_query("INSERT INTO dcroxx_me_s_activity SET title='".$stext."', img='', details='".$stext."', act_cat='".$act_cat."'");
$oi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_s_activity WHERE act_cat='".$act_cat."'"));
$o = $oi[0];
echo "<img src=\"$item[1]\" alt=\"\"/> <a href=\"?timeX=$ex&amp;act_cat=$act_cat&amp;timeY=$e0x&amp;act_id=$o&amp;timeZ=$e00x&amp;l_id=$l_id&amp;timeZ=$e00x&amp;img_id=$img_id\" style=\"font-family: Comic CMS Scan;font-style:normal;\">$stext</a><br/>";
}
}

////////May be it's Complete
echo "</div>";


  echo "<p align=\"center\"><small>";
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
}

else if($action=="shout_proc_advance"){

  $shtxt = $_POST["shtxt"];
  $l_id = $_POST["l_id"];
$act_cat = $_POST["act_cat"];
$act_id = $_POST["act_id"];
$img_id = $_POST["img_id"];
    addonline(getuid_sid($sid),"Shouting","");

$pstyle = gettheme($sid);
      echo xhtmlhead("Shout",$pstyle);
    echo "<p align=\"center\">";
	
	if(strlen($shtxt)<5){
    echo "Shout is blank or short. Your shouts must contain at least 5 characters.<br/>";
  echo "<p align=\"center\"><small>";
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
    exit();
}

$q=mysql_fetch_assoc(mysql_query("SELECT shtime, shouter FROM dcroxx_me_shouts WHERE shouter='".$uid."'  ORDER BY id DESC LIMIT 1"));
$st=$q['shtime'];
$now=time();
$dif=$now - $st;
$wait= 10 - $dif;
if($dif<'25'){
echo "<img src=\"images/notok.gif\" alt=\"X\"/>A shout has been added recently.<br/>So you have to wait $wait seconds to add your shout!<br/>";
  echo "<p align=\"center\"><small>";
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
exit();
}
  /*  if(getplusses(getuid_sid($sid))<75)
    {
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>You should have at least 75 plusses to shout!";
    }else{*/
$shtxt = $shtxt;
//$uid = getuid_sid($sid);
$shtm = time();

$res = mysql_query("INSERT INTO dcroxx_me_shouts SET shout='".$shtxt."', shouter='".$uid."', shtime='".$shtm."', l_id='".$l_id."', act_cat='".$act_cat."', act_id='".$act_id."', img_id='".$img_id."'");
if($res){
$shts = mysql_fetch_array(mysql_query("SELECT shouts, shouts_50, shouts_75, shouts_100 from dcroxx_me_users WHERE id='".$uid."'"));
$shts1 = $shts[0]+1;
$hts = $shts[1]+1;
$shs = $shts[2]+1;
$sts = $shts[3]+1;
mysql_query("UPDATE dcroxx_me_users SET shouts='".$shts1."', shouts_50='".$hts."', shouts_75='".$shs."', shouts_100='".$sts."' WHERE id='".$uid."'");


//$cow = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
//$cow = $cow[0]+3;
//mysql_query("UPDATE dcroxx_me_users SET plusses='".$cow."' WHERE id='".$uid."'");
//  echo "3 plusses added to you account";
echo "<b>TIPS:</b> Makes more shout and get more plusses. :)<br/>";
$shid = mysql_fetch_array(mysql_query("SELECT id FROM dcroxx_me_shouts WHERE shouter='".$uid."' ORDER BY shtime DESC LIMIT 0, 1"));
    echo "<img src=\"images/ok.gif\" alt=\"O\"/>Shout has added successfully to public front page<br/>
	<a href=\"tag_mention.php?shid=$shid[0]\">Wanna Mention?</a><br/><br/>";
    }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Database Error<br/><br/>";
    }
           // }
  echo "<p align=\"center\"><small>";
  echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p>";
  echo "</card>";
   exit();
    }
/////////////////////error//////////////////////////

else
{
  echo "<card id=\"main\" title=\"Advance Shout\">";
  echo "<p align=\"center\"><small>";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
  echo "</small></p></card>";
}
?>
</html>