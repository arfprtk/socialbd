<?php
define ('USER_NOT_FOUND',0);
define ('MIME_TYPE','application/xhtml+xml');



function gettheme($sid){
$uid=getuid_sid($sid);
if(!$uid){
$uid=1;
}
$blah=mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM themes WHERE uid=$uid"));
if($blah[0]>0){
$thm = mysql_fetch_array(mysql_query("SELECT * FROM themes WHERE uid='".$uid."' AND applied=1"));
}
else $thm = mysql_fetch_array(mysql_query("SELECT * FROM themes WHERE uid=1 AND applied=1"));
$blah = "<style type=\"text/css\">
* {
	margin: 0;
	padding: 0;
}
.boxed {
margin: 10px auto;
    max-width: 10000px;
	margin-bottom: 10px;
	border: 1px solid #000000;
}
.boxedTitle {
	margin: 1px auto;
    	max-width: 10000px;
	padding: 0 0 0 2px;
	background: ".$thm[2]." url(images/".$thm[3].") repeat-x;
}
.boxedTitleText {
	font-size: 11px;
	color: ".$thm[4].";
}
.boxedContent {
margin: 1px auto;
    max-width: 10000px;
	padding: 2px 2px 2px 2px;
	background: ".$thm[5].";
}
.logo {
margin: 1px auto;
    max-width: 10000px;
	padding: 2px 2px 2px 2px;
	background: ".$thm[10]." url(images/".$thm[12].") repeat-x;
}
.footer {
	margin: 1px auto;
    max-width: 10000px;
	padding: 5px;
	background: url(images/".$thm[19].") repeat-x;
}
h1 {
	color: #000000;
}
a:visited {
	color: ".$thm[7].";
}
h5 {
	margin: 1px auto;
    max-width: 10000px;
	padding: 0 0 0 2px;
	background: ".$thm[8]." url(images/".$thm[9].") repeat-x;
	color: ".$thm[4].";
}
body {
margin: 1px auto;
    max-width: 10000px;
background: ".$thm[10]." ;
font: normal small Arial, Helvetica, sans-serif, Verdana;
color: ".$thm[11].";
text align: left;
}
#inputText {
	background-color: ".$thm[13].";
	color: ".$thm[14].";
	border: 1px solid ".$thm[15].";
}
#inputButton {
	background-color: ".$thm[16].";
	color: ".$thm[17].";
	border: 1px solid ".$thm[18].";
}
</style>
";
return $blah;

}

function getlogo($uid){

	if(!$uid){

		$uid=1;

	}

	$name=mysql_fetch_array(mysql_query("SELECT name FROM themes WHERE uid=$uid AND applied=1"));

	switch($name[0]){

		case "Vista" :

                $logo = "<img src=\"images/logo.gif\" alt=\"chat\" />";

                break;

		case "Red" :

                $logo = "<img src=\"images/logo.gif\" alt=\"chat\" />";

                break;

		case "XP" :

                $logo = "<img src=\"images/logo.gif\" alt=\"chat\" />";

                break;

		case "Royal Black" :

                $logo = "<img src=\"images/logo.gif\" alt=\"chat\" />";

                break;

case "Black Widow" :

                $logo = "<img src=\"images/logo.gif\" alt=\"chat\" />";

                break;



		case "Green Pink" :

                $logo = "<img src=\"images/logo.gif\" alt=\"chat\" />";

                break;

		case "Yellow" :

                $logo = "<img src=\"images/logo.gif\" alt=\"chat\" />";

                break;

		case "Aero" :

                $logo = "<img src=\"images/logo.gif\" alt=\"chat\" />";

                break;

		case "Matrix" :

                $logo = "<img src=\"images/logo.gif\" alt=\"chat\" />";

                break;

		case "Opera - WML" :

                $logo = "<img src=\"images/logo.gif\" alt=\"chat\" />";

                break;

		default : 

                $logo = "<img src=\"images/logo.gif\" alt=\"chat\" />";

                break;

		

	}

	return $logo;

}

function gettheme2($sid){

$uid=getuid_sid($sid);

if(!$uid){

$uid=1;

}

$blah=mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM themes WHERE uid=$uid"));

if($blah[0]>0){

$thm = mysql_fetch_array(mysql_query("SELECT * FROM themes WHERE uid='".$uid."' AND applied=1"));

}

else $thm = mysql_fetch_array(mysql_query("SELECT * FROM themes WHERE uid='".$uid."' AND applied=1"));

$blah = "<style type=\"text/css\">

* {

	margin: 0;

	padding: 0;

}

.boxed {

margin: 1px auto;

    max-width: 10000px;

	

	margin-bottom: 1px; 

	border: 1px solid #000000;



}

.boxedTitle {

	margin: 1px auto;

    	max-width: 10000px;

	padding: 0 0 0 2px;

	background: ".$thm[2]." url(../images/".$thm[3].") repeat-x;

}

.boxedTitleText {

	font-size: 11px;

	color: ".$thm[4].";

}

.boxedContent {

margin: 1px auto;

    max-width: 10000px;

	padding: 2px 2px 2px 2px;

	background: ".$thm[5].";

}

.logo {

margin: 1px auto;

    max-width: 10000px;

	padding: 2px 2px 2px 2px;

	background: ".$thm[10]." url(../images/".$thm[12].") repeat-x;

}

.footer {

	margin: 1px auto;

    max-width: 10000px;

	padding: 5px;

	background: url(../images/".$thm[19].") repeat-x;

}

h1 {

	color: #000000;

}

a:visited {

	color: ".$thm[7].";

}

a:link {

	color: ".$thm[6].";

}

h5 {

	margin: 1px auto;

    max-width: 10000px;

	padding: 0 0 0 2px;

	background: ".$thm[8]." url(../images/".$thm[9].") repeat-x;

	color: ".$thm[4].";

}

body { 

margin: 1px auto;

    max-width: 10000px;

background: ".$thm[10]." ;

font: normal small Arial, Helvetica, sans-serif, Verdana;

color: ".$thm[11].";

}

#inputText {

	background-color: ".$thm[13].";

	color: ".$thm[14].";

	border: 1px solid ".$thm[15].";

}

#inputButton {

	background-color: ".$thm[16].";

	color: ".$thm[17].";

	border: 1px solid ".$thm[18].";

}

</style>

";

return $blah;

}

function getlogo2($uid){

	if(!$uid){

		$uid=1;

	}

	$name=mysql_fetch_array(mysql_query("SELECT name FROM themes WHERE uid=$uid AND applied=1"));

	switch($name[0]){

		case "Vista" :

                $logo = "<img src=\"../images/logo.gif\" alt=\"chat\" />";

                break;

		case "Red" :

                $logo = "<img src=\"../images/logo.gif\" alt=\"chat\" />";

                break;

		case "XP" :

                $logo = "<img src=\"../images/logo.gif\" alt=\"chat\" />";

                break;

		case "Royal Black" :

                $logo = "<img src=\"../images/logo.gif\" alt=\"chat\" />";

                break;

		case "Green Pink" :

                $logo = "<img src=\"../images/logo.gif\" alt=\"chat\" />";

                break;

		case "Yellow" :

                $logo = "<img src=\"../images/logo.gif\" alt=\"chat\" />";

                break;

		case "Aero" :

                $logo = "<img src=\"../images/logo.gif\" alt=\"chat\" />";

                break;

		case "Matrix" :

                $logo = "<img src=\"../images/logo.gif\" alt=\"chat\" />";

                break;

		case "Opera - WML" :

                $logo = "<img src=\"../images/logo.gif\" alt=\"chat\" />";

                break;

		default : 

                $logo = "<img src=\"../images/logo.gif\" alt=\"chat\" />";

                break;

		

	}

	return $logo;

}

function gettheme3($sid){

$uid=getuid_sid($sid);

if(!$uid){

$uid=1;

}

$blah=mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM themes WHERE uid=$uid"));

if($blah[0]>0){

$thm = mysql_fetch_array(mysql_query("SELECT * FROM themes WHERE uid='".$uid."' AND applied=1"));

}

else $thm = mysql_fetch_array(mysql_query("SELECT * FROM themes WHERE uid='".$uid."' AND applied=1"));

$blah = "<style type=\"text/css\">

* {

	margin: 0;

	padding: 0;

}

.boxed {

margin: 1px auto;

    max-width: 10000px;

	

	margin-bottom: 1px; 

	border: 1px solid #000000;



}

.boxedTitle {

	margin: 1px auto;

    	max-width: 10000px;

	padding: 0 0 0 2px;

	background: ".$thm[2]." url(../images/".$thm[3].") repeat-x;

}

.boxedTitleText {

	font-size: 11px;

	color: ".$thm[4].";

}

.boxedContent {

margin: 1px auto;

    max-width: 10000px;

	padding: 2px 2px 2px 2px;



	background: ".$thm[5].";

}

.logo {

margin: 1px auto;

    max-width: 10000px;

	padding: 2px 2px 2px 2px;

	background: ".$thm[10]." url(../images/".$thm[12].") repeat-x;

}

.footer {

	margin: 1px auto;

    max-width: 10000px;



	padding: 5px;

	background: url(../images/".$thm[19].") repeat-x;

}

h1 {

	color: #000000;

}

a:visited {

	color: ".$thm[7].";

}

a:link {

	color: ".$thm[6]."; 

}

h5 {

	margin: 3px auto;

    max-width: 500px;

	padding: 0 0 0 2px;

	background: ".$thm[8]." url(../images/".$thm[9].") repeat-x;

	color: ".$thm[4].";

}

body { 

margin: 1px auto;

    max-width: 10000px;

background: ".$thm[10]." ;

font: normal small Arial, Helvetica, sans-serif, Verdana;

color: ".$thm[11].";

}

#inputText {

	background-color: ".$thm[13].";

	color: ".$thm[14].";

	border: 1px solid ".$thm[15].";

}

#inputButton {

	background-color: ".$thm[16].";

	color: ".$thm[17].";

	border: 1px solid ".$thm[18].";

}

</style>

";

return $blah;

}

function getlogo3($uid){

	if(!$uid){

		$uid=1;

	}

	$name=mysql_fetch_array(mysql_query("SELECT name FROM themes WHERE uid=$uid AND applied=1"));

	switch($name[0]){

		case "Vista" :

                $logo = "<img src=\"../images/logo.gif\" alt=\"chat\" />";

                break;

		case "Red" :

                $logo = "<img src=\"../images/logo.gif\" alt=\"chat\" />";

                break;

		case "XP" :

                $logo = "<img src=\"../images/logo.gif\" alt=\"chat\" />";

                break;

		case "Royal Black" :

                $logo = "<img src=\"../images/logo.gif\" alt=\"chat\" />";

                break;

		case "Green Pink" :

                $logo = "<img src=\"../images/logo.gif\" alt=\"chat\" />";

                break;

		case "Yellow" :

                $logo = "<img src=\"../images/logo.gif\" alt=\"chat\" />";

                break;

		case "Aero" :

                $logo = "<img src=\"../images/logo.gif\" alt=\"chat\" />";

                break;

		case "Matrix" :

                $logo = "<img src=\"../images/logo.gif\" alt=\"chat\" />";

                break;

		case "Opera - WML" :

                $logo = "<img src=\"../images/logo.gif\" alt=\"chat\" />";

                break;

		default : 

                $logo = "<img src=\"../images/logo.gif\" alt=\"chat\" />";

                break;

		

	}

	return $logo;

}


function geticonsetid($sid)
{
    $uid = getuid_sid($sid);
	$thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
	$iconsetid = mysql_fetch_array(mysql_query("SELECT iconset FROM dcroxx_me_mainthemes WHERE id='".$thid[0]."'"));
	return $iconsetid[0];
}

function xhtmlhead($page_title, $page_style="")
{
	$ret = "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
	$ret .= "\n<head>\n<title>$page_title</title>\n";
	$ret .= "<meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\" />";
	$ret .= "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />";
    $ret .= "<meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>";
	$ret .= "\n".$page_style;
	$ret .= "\n</head>\n<body>";
	return $ret;
}
function xhtmlheadchat1($page_title, $page_style="",$rid,$sid)
{
	$ret = "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
	$ret .= "\n<head>\n<title>$page_title</title>\n";
	$ret .= "<meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\" />";
	$ret .= "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />";
    $ret .= "<meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>";
    $ret .= "<meta http-equiv=\"refresh\" content=\"20; URL=chat.php?sid=$sid&amp;rid=$rid\"/>";
	$ret .= "\n".$page_style;
	$ret .= "\n</head>\n<body>";
	return $ret;
}
function xhtmlheadchat($page_title, $page_style="")
{
	$ret = "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
	$ret .= "\n<head>\n<title>$page_title</title>\n";
	$ret .= "<meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\" />";
	$ret .= "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />";
    $ret .= "<meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>";
	$ret .= "\n".$page_style;
	$ret .= "\n</head>\n<body>";
	return $ret;
}
function xhtmlfoot()
{
	$ret = "\n</body>\n</html>";
	return $ret;
}
function gettheme1($thid)
{
	if($thid[0]==""||$thid[0]==0)$thid[0]=1;
	$thinfo = mysql_fetch_array(mysql_query("SELECT bgc, txc, lnk, hdc, hbg FROM dcroxx_me_mainthemes WHERE id='".$thid[0]."'"));
	$ret = "<style type=\"text/css\">\n";
	$ret .= "body {background-color:#$thinfo[0]; color:#$thinfo[1]}\n";
	$ret .= "h3 {background-color:#$thinfo[4]; color:#$thinfo[3]}\n";
	$ret .= "a:link {color:#$thinfo[2]}\n";
	$ret .= "a:visited {color:#$thinfo[2]}\n";
               	$ret .= ".boxed {width: 100%; margin-bottom: 3px; border: 1px solid #$thinfo[1]}\n";
	$ret .= ".boxedTitle {height: 18px; padding: 0 0 0 2px; background: #$thinfo[1] url(images/box2.jpg) repeat-x;}\n";
	$ret .= ".boxedTitleText {font-size: 11px; color: #$thinfo[2]}\n";
	$ret .= ".boxedContent {padding: 2px 2px 2px 2px; background: #$thinfo[3]}\n";

	$ret .= "</style>";
	return $ret;
}


?>