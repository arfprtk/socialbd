<?php
header('Content-Type: image/png');
$im = imagecreatetruecolor(150, 26);
$white = 0x00FF00;
$grey = imagecolorallocate($im, 128, 128, 128);
$black = imagecolorallocate($im, 0, 0, 0);
imagefilledrectangle($im, 0, 0, 399, 29, $white);
$level = $_GET['level'].'%';
$font = 'comic.TTF';
imagettftext($im, 19, 0, 56, 23, $grey, $font, $level);
imagettftext($im, 19, 0, 55, 24, $black, $font, $level);
imagepng($im);
imagedestroy($im);
?>