<?php
header("Content-type: image/jpeg");
$cid = $_GET["cid"];
$msg = $_GET["msg"];
include("config.php");
include("core.php");
connectdb();
$cinfo = mysql_fetch_array(mysql_query("SELECT * FROM dcroxx_me_cards WHERE id='".$cid."'"));
$bgpic = imagecreatefromjpeg("pmcards/$cid.jpg");
if($cid=="1"){
$textcolor = imagecolorallocate($bgpic,0,0,0xFFFFFF);
}
if($cid=="2"){
$textcolor = imagecolorallocate($bgpic,0,0,0xFFFFFF);
}
if($cid=="3"){
$textcolor = imagecolorallocate($bgpic,0,0,0xFFFFFF);
}
if($cid=="4"){
$textcolor = imagecolorallocate($bgpic,0,0,0xFFFFFF);
}
if($cid=="5"){
$textcolor = imagecolorallocate($bgpic,0,0,0xFFFFFF);
}
if($cid=="6"){
$textcolor = imagecolorallocate($bgpic,0,0,0xFFFFFF);
}
if($cid=="7"){
$textcolor = imagecolorallocate($bgpic,0,0,0xFFFFFF);
}
if($cid=="8"){
$textcolor = imagecolorallocate($bgpic,0,0,0x0033CC);
}
imagestring($bgpic,$cinfo[1],$cinfo[2],$cinfo[3],"$msg",$textcolor);
$avl = $uinfo[3];
imagejpeg($bgpic,"",100);
imagedestroy($bgpic);
?>


