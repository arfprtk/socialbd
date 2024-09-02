<?php
session_name("PHPSESSID");
session_start();
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
echo "<?xml version=\"1.0\"?>";
echo "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\" \"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\">";
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> 
<?php
include("config.php");
include("core.php");
include("xhtmlfunctions.php");
connectdb(); 
$action = mysql_real_escape_string($_GET["action"]);
$sid = mysql_real_escape_string($_SESSION["sid"]);
$page = mysql_real_escape_string($_GET["page"]);
$uid = getuid_sid($sid);

if($action != "")
{
    if(islogged($sid)==false)
    {
      echo "<head>";
      echo "<title>Error!!!</title>";
      echo "</head>";
      echo "<body>";
      echo "<p align=\"center\"><small>";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</small></p>";
     
      echo "</body></html>";
      exit();
    }
}
if(isbanned($uid))
    {
      echo "<head>";
      echo "<title>Error!!!</title>";
      echo "</head>";
      echo "<body>";
      echo "<p align=\"center\"><small>";
      echo "<img src=\"../images/notok.gif\" alt=\"x\"/><br/>";
      echo "<b>You are Banned</b><br/><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT timeto, pnreas, exid FROM ibwfrr_penalties WHERE uid='".$uid."' AND penalty='1' OR uid='".$uid."' AND penalty='2'"));
        $banres = mysql_fetch_array(mysql_query("SELECT lastpnreas FROM ibwfrr_users WHERE id='".$uid."'"));
      $remain = $banto[0]- time();
      $rmsg = gettimemsg($remain);
      echo "<b>Time Left: </b>$rmsg<br/>";
      $nick = getnick_uid($banto[2]);
      echo "<b>By: </b>$nick<br/>";
      echo "<b>Reason: </b>$banto[1]";
      echo "</small></p>";
      echo "</body>";
      echo "</html>";
      exit();
    }

////////////////////////////////// Upload Section

if($action=="attach"){
    addonline(getuid_sid($sid),"Ghost mood","");
	    $pstyle = gettheme1("5");
    echo xhtmlhead("Attachment",$pstyle);


echo "<h5><center>Attachment</center></h5>";
  //  if(ismod(getuid_sid($sid))||ispu(getuid_sid($sid))){
   // if(ismod(getuid_sid($sid))){
    $time = time();
//////ALL LISTS SCRIPT <<
	//echo"<div class=\"header\" align=\"center\"><span class=\"a\"><big>Finix</big></span><span class=\"b\"><big>BD.Com</big></span></div>";
    //    echo "<p align=\"left\">";
	    echo "<small>";
        echo "
Image(JPG/JPEG image only):<br/>
Size limit: <b>512 KB</b><br/>
        Image will be resized to fit its width to 128 pixels.</small>
        <form enctype=\"multipart/form-data\" action=\"attach.php?action=upavat\" method=\"post\">
        <input type=\"file\" name=\"attach\"/><br/>
        <input type=\"hidden\" name=\"code\" value=\"".$time."\"/>
        <input id=\"inputButton\" type=\"submit\" name=\"submit\" value=\"Send\"/>
        </form><br/>";
/*}else{
echo "Only staffs and premium users can use this option<br/>";
}*/
  ////// UNTILL HERE >>
  
echo"<small><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a></small>";

    echo "</body>";
}

////////////////Upload avatar////////////////////////

else if($action=="upavat")
{
addonline(getuid_sid($sid),"Ghost mood","");
 	    $pstyle = gettheme1("5");
    echo xhtmlhead("Attachment",$pstyle);
echo "<h5><center>Attachment</center></h5>";
$code = $_POST['code'];
$size = $_FILES['attach']['size']/1024;
$origname = $_FILES['attach']['name'];
$res = false;
$ext = explode(".", strrev($origname));
switch(strtolower($ext[0])){
        case "gpj":
    $res = true;
    break;
    case "gepj":
    $res = true;
    break;
}

$tm = time();
$uploaddir = "attachments";
if($size>512){
echo "<small>File is larger than 512KB</small>";
}
else if ($res!=true){
echo "<small>File type not supported ! Please attach only a JPG/JPEG format image.</small><br/>";
}
else
{
$uploadfile = $name.".".$ext;
$uppath=$uploaddir."/".$uploadfile;
if(copy($_FILES['attach']['tmp_name'], $uppath)){
    $filewa = $uppath;
    list($width, $height, $type, $attr) = getimagesize($filewa);
    $newname=$uploaddir."/".$code."_att_tufan420.jpg";
    $newheight = ($height*180)/$width;
    $newimg=imagecreatetruecolor(140, $newheight);
    $largeimg=imagecreatefromjpeg($filewa);
    imagecopyresampled($newimg, $largeimg, 0, 0, 0, 0, 140, $newheight, $width, $height);
    imagejpeg($newimg, $newname);
    imagedestroy($newimg);
    imagedestroy($largeimg);
    $file1 = $uploaddir."/".$code."_att_tufan420.jpg";
    unlink($filewa);
  $res1 = mysql_query("INSERT INTO ibwfrr_images SET byuid='".getuid_sid($sid)."', imageurl='".$file1."', code='".$code."', time='".time()."'");  
}
}
if($res1)
{
    echo "<small>$origname <br/> Was Successfully Uploaded</small><br/><br/>";
    echo "<img src=\"$file1\" alt=\"$origname\" /><br/>";
    echo "<br/><small>Copy and past anywhere the code for attaching this image:</small><br/>";
    echo "<input name=\"code\" value=\"[image=$code]\" /><br/><br/>";
  
echo"<small><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a></small>";

}

else {

    echo "<small>File couldn't be processed !!!<br/> Contact With Admin </small><br/><br/>";
  
echo"<small><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a></small>";

}
}
?>
</html>
