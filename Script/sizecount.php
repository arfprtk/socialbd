<?php
/// Set Content type
header("Content-type: image/png");
/*
$bgpic = imagecreatefromjpeg("images/rwidc.jpg");
$textcolor = imagecolorallocate($bgpic,0x00,0,0x00);
$infcolor = imagecolorallocate($bgpic,0,0,0);
*/


/// Create the image
//$im = imagecreatefrompng('1.png');   
$im = imagecreate(115, 27);
//// Create some colors
$white = imagecolorallocate($im, 255, 255, 255);
$red = imagecolorallocate($im, 255, 0, 0);
$black = imagecolorallocate($im, 0,0,0);

//0x00,0x55,0x00
/// the text draw
$size = $_GET['size'];
$text = "  Size: $size";
///// Replace path by your own font ttf
$font = 'Gabriola.ttf';
///// Add some shadow
//imagettftext($im, 18, 0, 11, 25, $red, $font, $text);
//// Add the text
imagettftext($im, 15, 0, 9, 20, $black, $font, $text);
imagepng($im);
imagedestroy($im);
?>