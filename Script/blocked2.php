<head>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="favicon.ico" type="image/gif" />
<link rel="StyleSheet" type="text/css" href="style/default.css" />
<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> 
</head>
<?php
function browser_agent($_mob_browser){$_mob_browser=$_mob_browser;
  if(preg_match('/(google|bot)/i',strtolower($_mob_browser))){
 $position = strpos(strtolower($_mob_browser),"bot");
 $_mob_browser = substr($_mob_browser, $position-30, $position+2);
 $_browser = explode (" ", $_mob_browser);
 $_browser = array_reverse($_browser); 
 }else if (isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])) {
 $_mob_browser = $_SERVER['HTTP_X_OPERAMINI_PHONE_UA'];
 $_position=strpos(strtolower($_mob_browser),"nokia");$position=strpos(strtolower($_mob_browser),"android");
 if($_position){$_mob_browser = substr($_mob_browser, $_position,25);}
 else{if($position){$_mob_browser = substr($_mob_browser, $position,25);$_browser = explode ('-', $_mob_browser);return $_browser[0];}}
 $_browser = explode (' ', $_mob_browser);
 }else if (isset($_SERVER['HTTP_X_BOLT_PHONE_UA'])) {
 $_mob_browser = $_SERVER['HTTP_X_BOLT_PHONE_UA'];
 $_position=strpos(strtolower($_mob_browser),"nokia");$position=strpos(strtolower($_mob_browser),"android");
 if($_position){$_mob_browser = substr($_mob_browser, $_position,25);}
 else{if($position)$_mob_browser = substr($_mob_browser, $position,25);$_browser = explode ('-', $_mob_browser);return $_browser[0];}
 $_browser = explode (' ', $_mob_browser); }else if (isset($_SERVER['HTTP_X_MOBILE_UA'])) {
 $_mob_browser = $_SERVER['HTTP_X_MOBILE_UA'];
 $_position=strpos(strtolower($_mob_browser),"nokia");$position=strpos(strtolower($_mob_browser),"android");
 if($_position){$_mob_browser = substr($_mob_browser, $_position,25);}
 else{if($position){$_mob_browser = substr($_mob_browser, $position,25);$_browser = explode ('-', $_mob_browser);return $_browser[0];}}
 $_browser = explode (' ', $_mob_browser); }else if(isset($_SERVER['HTTP_X_devICE_USER_AGENT'])) {
 $_mob_browser = $_SERVER['HTTP_X_devICE_USER_AGENT'];
 $_position=strpos(strtolower($_mob_browser),"nokia");$position=strpos(strtolower($_mob_browser),"android");
 if($_position){$_mob_browser = substr($_mob_browser, $_position,25);}
 else{if($position){$_mob_browser = substr($_mob_browser, $position,25);$_browser = explode ('-', $_mob_browser);return $_browser[0];}}
 $_browser = explode (' ', $_mob_browser);}else{$_position=strpos(strtolower($_mob_browser),"nokia");$position=strpos(strtolower($_mob_browser),"android");
 if($_position){$_mob_browser = substr($_mob_browser, $_position,25);}
 else{if($position){$_mob_browser = substr($_mob_browser, $position,25);$_browser = explode ('-', $_mob_browser);return $_browser[0];}}
 
 $_browser = explode (' ', $_mob_browser);
 }
   
            return $_browser[0];            
}
$brws2 = browser_agent($_SERVER['HTTP_USER_AGENT']);
$text = addslashes(strip_tags($brws2));
      echo "<title>SocialBD.NeT</title>";
	  echo"<center>";
      echo "<img src=\"chapel/1.gif\" alt=\"x\"/><br/>";
      echo "Sorry, currently we are not allow <b>$text</b> device<br/>";
      echo "Don't be panic, we will allow this device soon.<br/>";
      echo "If you have any query, <a href=\"contact/index.php\">Contact US</a>";

?>