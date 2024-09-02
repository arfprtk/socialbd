<?php
define ('USER_NOT_FOUND',0);
define ('MIME_TYPE','application/xhtml+xml');
function printError($mime, $err, $opt="")
{
	switch ($err)
	{
		case USER_NOT_FOUND:
		if($mime == MIME_TYPE)
		{
			echo xhtmlhead("retrivewap", geterrps());
			echo "<h3>ERROR!</h3>\n";
			echo "<p align=\"center\">retrivewap<br />The Member <b>$opt</b> Doesn't Exist<br />\n";
			echo "Please make sure you typed the name of the member correctly</p>\n";
			echo xhtmlfoot();
		}else{
			echo wmlhead("retrivewap");
			echo "<b>ERROR!</b>";
			echo "<p align=\"center\">retrivewap<br /><br />The Member <b>$opt</b> Doesn't Exist<br />\n";
			echo "Please make sure you typed the name of the member correctly</p>\n";
			echo wmlfoot();
		}
			break;
	}
}
function wmlhead($page_title)
{
	$ret = "<wml>\n<card id=\"main\" title=\"$page_title\">\n";
	return $ret;
}
function wmlfoot()
{
	$ret = "<p align=\"center\">\n<small>";
	$ret .= "<br/>Be a part of the best wap community<br />";
	$ret .= "Click <a href=\"../features.php\">here</a> to know what features and services you're gonna get by becoming a member<br/><br/>";
	$ret .= "<a href=\"http://retrivewap.co.za\">retrivewap</a>";
	$ret .= "</small></p>";
	$ret .= "\n</card>\n</wml>";
	return $ret;
}
function xhtmlhead($page_title, $page_style="")
{
	$ret = "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
	$ret .= "\n<head>\n<title>$page_title</title>\n";
	$ret .= "<meta http-equiv=\"content-type\" content=\"text/html; charset=iso-8859-1\" />";
	$ret .= "\n".$page_style;
	$ret .= "\n</head>\n<body>";
	return $ret;
}
function xhtmlfoot()
{	
	$ret = "<p align=\"center\">\n<font size=\"2\">";
	$ret .= "Be a part of the best wap community<br />";
	$ret .= "Click <a href=\"../features.php\">here</a> to know what features and services you're gonna get by becoming a member<br/><br/>";
	$ret .= "<a href=\"http://retrivewap.co.za\">retrivewap</a>";
	$ret .= "</font></p>";
	$ret .= "\n</body>\n</html>";
	return $ret;
}
function parseppmsg($text)
{
  $text = htmlspecialchars($text);
  $text = getsmiliespp($text);
  $text = getbbcodepp($text);
  //$text = findcard($text);
  return $text;
}
function getbbcodepp($text)
{
  $text=preg_replace("/\[b\](.*?)\[\/b\]/i","<b>\\1</b>", $text);
  $text=preg_replace("/\[i\](.*?)\[\/i\]/i","<i>\\1</i>", $text);
  $text=preg_replace("/\[u\](.*?)\[\/u\]/i","<u>\\1</u>", $text);
  $text=preg_replace("/\[big\](.*?)\[\/big\]/i","<big>\\1</big>", $text);
  $text=preg_replace("/\[small\](.*?)\[\/small\]/i","<small>\\1</small>", $text);
  if(substr_count($text,"[br/]")<=3){
    $text = str_replace("[br/]","<br/>",$text);
  }
  //$text = preg_replace("/\[url\=(.*?)\](.*?)\[\/url\]/is","<a href=\"$1\">$2</a>",$text);
  //$text = preg_replace("/\[topic\=(.*?)\](.*?)\[\/topic\]/is","<a href=\"index.php?action=viewtpc&amp;tid=$1&amp;sid=$sid\">$2</a>",$text);
  //$text = preg_replace("/\[club\=(.*?)\](.*?)\[\/club\]/is","<a href=\"index.php?action=gocl&amp;clid=$1&amp;sid=$sid\">$2</a>",$text);
  //$text = preg_replace("/\[blog\=(.*?)\](.*?)\[\/blog\]/is","<a href=\"index.php?action=viewblog&amp;bid=$1&amp;sid=$sid\">$2</a>",$text);
  //$text = ereg_replace("http://[A-Za-z0-9./=?-_]+","<a href=\"\\0\">\\0</a>", $text);
  $text = str_replace("2wap","2crapwap",$text);
  return $text;
}
function getsmiliespp($text)
{
  $sql = "SELECT * FROM ibwf_smilies";
  $smilies = mysql_query($sql);
  while($smilie=mysql_fetch_array($smilies))
  {
    $scode = $smilie[1];
    $spath = $smilie[2];
    $text = str_replace($scode,"<img src=\"../$spath\" alt=\"$scode\"/>",$text);
  }
  return $text;
}
function gettheme($uid)
{
	$thid = mysql_fetch_array(mysql_query("SELECT thid FROM ibwf_mypage WHERE uid='".$uid."'"));
	if($thid[0]==""||$thid[0]==0)$thid[0]=1;
	$thinfo = mysql_fetch_array(mysql_query("SELECT bgc, txc, lnk, hdc, hbg FROM ibwf_themes WHERE id='".$thid[0]."'"));
	$ret = "<style type=\"text/css\">\n";
	$ret .= "body {background-color:#$thinfo[0]; color:#$thinfo[1]}\n";
	$ret .= "h3 {background-color:#$thinfo[4]; color:#$thinfo[3]}\n";
	$ret .= "a:link {color:#$thinfo[2]}\n";
	$ret .= "a:visited {color:#$thinfo[2]}\n";
	$ret .= "</style>";
	return $ret;
}
function geterrps()
{
	$ret = "<style type=\"text/css\">\n";
	
	$ret .= "body {background-color:#FF0000; color:#FFFFFF}\n";
	$ret .= "h3 {background-color:#FFFF00; color:#000000}\n";
	$ret .= "a:link {color:#555555}\n";
	$ret .= "a:visited {color:#555555}\n";
	/*
	$ret .= "body {background-color:#CCDDFF; color:#000055}\n";
	$ret .= "h3 {background-color:#FFFFCC; color:#005500}\n";
	$ret .= "a:link {color:#FF0000}\n";
	$ret .= "a:visited {color:#FF0000}\n";
	*/
	$ret .= "</style>";
	return $ret;
}
?>