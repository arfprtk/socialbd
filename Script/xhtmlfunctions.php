<?php
define ('USER_NOT_FOUND',0);
define ('MIME_TYPE','application/xhtml+xml');

function isbrw($uid)
{
 $user = mysql_fetch_array(mysql_query("SELECT browserm FROM dcroxx_me_users WHERE id='".$uid."'"));
  
 if($user[0]=="Opera/9.23"||$user[0]=="Opera/9.21"||$user[0]=="Opera/9.20"||$user[0]=="Opera/9.25"||$user[0]=="Opera/9.24"||$user[0]=="Opera/9.50"||$user[0]=="Opera/9.10"||$user[0]=="Mozilla/4.0"||$user[0]=="Mozilla/4.08"||$user[0]=="Mozilla/5.0")
  {
    return true;
  }
  return false;
}

function gettheme($sid)
{ 
    $uid = getuid_sid($sid);
	if(isbrw($uid))
  {
    include ("snow.php");
	
    }

	$thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
	if($thid[0]==""||$thid[0]==0)$thid[0]=1;
	$thinfo = mysql_fetch_array(mysql_query("SELECT bgc, txc, lnk, hdc, hbg, boxbg FROM dcroxx_me_mainthemes WHERE id='".$thid[0]."'"));
	$ret = "<style type=\"text/css\">\n";

$ret .= "body {max-width:auto; margin: 12px auto;border: 0px dotted red;   background-color:#$thinfo[0]; 
font-family : Verdana, Arial, Helvetica, sans-serif;
	font-style:normal;
	font-size: medium;
color:#$thinfo[1]}\n"; 
	$ret .= "h5 {background-color:#$thinfo[4]; color:#$thinfo[3]; font-size: 12px;}\n";
	$ret .= "a:link {color:#$thinfo[2]}\n";
	$ret .= "a:visited {color:#$thinfo[2]}\n";
      $ret .= "a:hover {color:#$thinfo[2]; font-weight:bold; text-transform:uppercase; font-size: 18px;}\n";
       $ret .= " div.doquote{background-color:#ccffff;font-style:normal;color:#666666;text-align:left;border:1px solid #dfe7ad;padding:2px}\n";
	    $ret .= "h6 {background-color:#$thinfo[4]; color:#$thinfo[3]; font-size: 15px;}\n";
	$ret .= "a:link {color:#$thinfo[2]}\n";
	$ret .= "a:visited {color:#$thinfo[2]}\n";
      $ret .= "a:hover {color:#$thinfo[2]; font-weight:bold; text-transform:uppercase; font-size: 10px;}\n";
       $ret .= " div.doquote{background-color:#ccffff;font-style:normal;color:#666666;text-align:left;border:1px solid #dfe7ad;padding:2px}\n";
	   $ret .= "h7 {background-color:#$thinfo[4]; color:#$thinfo[3]; font-size: 18px;}\n";
	$ret .= "a:link {color:#$thinfo[2]}\n";
	$ret .= "a:visited {color:#$thinfo[2]}\n";
      $ret .= "a:hover {color:#$thinfo[2]; font-weight:bold; text-transform:uppercase; font-size: 18px;}\n";
       $ret .= " div.doquote{background-color:#ccffff;font-style:normal;color:#666666;text-align:center;border:1px solid #dfe7ad;padding:2px}\n";


	$ret .= "img {border: 0;}\n";
	$ret .= "div.mblock1 {background-color: #$thinfo[3]; border: 0px; line: #9400D3; text-align: left;}\n";
	$ret .= "div.mblock0 {background-color: #$thinfo[3]; border: 0px; line: #9400D3; text-align: left;}\n";
    $ret .= "div.mblock3 {background-color: #$thinfo[3]; border: 10px; line: #9400D3; text-align:center;}\n";
	$ret .= "div.mblock3 {background-color: #$thinfo[3]; border: 0px squre #9400D3; text-align:center;}\n";
	$ret .= "</style>";
	return $ret;
	
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
    $ret .= "<meta http-equiv=\"refresh\" content=\"50; URL=chat.php?sid=$sid&amp;rid=$rid\"/>";
	$ret .= "\n".$page_style;
	$ret .= "\n</head>\n<body>";
	return $ret;
}
function xhtmlheadchat2($page_title, $page_style="",$rid,$sid)
{
	$ret = "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
	$ret .= "\n<head>\n<title>$page_title</title>\n";
	$ret .= "<meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\" />";
	$ret .= "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />";
    $ret .= "<meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>";
    $ret .= "<meta http-equiv=\"refresh\" content=\"0; URL=chat.php?sid=$sid&amp;rid=$rid\"/>";
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
	
	$ret .= "body {max-width:auto; margin: 12px auto;border: 0px dotted red; background-color:#ffffff; 

font-family : Verdana, Arial, Helvetica, sans-serif;
	font-size: medium;
	font-style:normal;
color:#$thinfo[1]}\n";
	$ret .= "h5 {background-color:#$thinfo[4]; color:#$thinfo[3]; font-size: 16px;}\n";
	$ret .= "a:link {color:#$thinfo[2]}\n";
	$ret .= "a:visited {color:#$thinfo[2]}\n";
	 $ret .= "a:hover {color:#$thinfo[2]; font-weight:bold; text-decoration:none; text-transform:uppercase; font-size: 10px;}\n";
	 $ret .= "h6 {background-color:#$thinfo[4]; color:#$thinfo[3]; font-size: 15px;}\n";
	$ret .= "a:link {color:#$thinfo[2]}\n";
	$ret .= "a:visited {color:#$thinfo[2]}\n";
      $ret .= "a:hover {color:#$thinfo[2]; font-weight:bold; text-decoration:none; text-transform:uppercase; font-size: 18px;}\n";
       $ret .= " div.doquote{background-color:#ccffff;font-style:normal;color:#666666;text-align:left;border:1px solid #dfe7ad;padding:2px}\n";
	   $ret .= "h5 {background-color:#000000; color:#$thinfo[3]; font-size: 12px;}\n";
	$ret .= "a:link {color:#$thinfo[2]}\n";
	$ret .= "a:visited {color:#$thinfo[2]}\n";
      $ret .= "a:hover {color:#$thinfo[2]; font-weight:bold; text-decoration:none; text-transform:uppercase; font-size: 18px;}\n";
       $ret .= " div.doquote{background-color:#ccffff;font-style:normal;color:#666666;text-align:center;border:1px solid #dfe7ad;padding:2px}\n";
    $ret .= "</style>";
	return $ret;
}
?>