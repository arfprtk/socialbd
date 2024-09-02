<?php


$text = $_SERVER['HTTP_USER_AGENT'];
$mobile = "blocked2.php";
$var[0] = 't9space.com';
$var[1] = 'cooltunnel.com';
$var[2] = 'anonymouse.org';
$var[3] = 'rexbd';
$var[4] = 'http://www.verkata.com';
$var[4] = 'Mozilla/5.0 (Linux; Android 5.1.1; SM-G531H Build/LMY48B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.98 Mobile Safari/537.36';

$result = count($var);
for ($i=0;$i<$result;$i++){
$ausg = stristr($text, $var[$i]);
if(strlen($ausg)>0){
header("location: $mobile");
echo "<meta http-equiv=\"refresh\" content=\"0; URL= blocked2.php\"/>";
//echo '<br/>Browsing Restricted!!!<br/>';
break;
exit();
}}
?>
