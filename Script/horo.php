<?php
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\"\"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\">";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
echo "<head>";
?>
<title>Daily Horoscope</title>
<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> 
<style type="text/css">
body{
font-weight : normal;
font-size : small;
padding: 4px;
font-family : Verdana, arial;
background-color : #ffffff;
color : #000000;
margin : 1px 1px 1px 1px;
}
a:active, a:visited, a:link {color:#2C75B1}
a:hover {color : #000000;}
a.white:active, a.white:link, a.white:visited {color:#ffffff}
a.red, a.red:visited  {color:#ff0000}
div { padding: 4px; margin: 0px 0px 0px 0px;}
div.header { padding: 3px; background-color: #CCCCCC;; border-bottom: 1px solid #000000; border-top: 1px solid #000000 }
div.upban { text-align:center; padding: 2px; background-color: #EFF3F6; border-bottom: 1px dotted #AFCDDC; border-top: 1px dotted #AFCDDC; }
div.info { text-align:center; padding: 2px; color:red; }
div.logo { text-align:center; background-color:#8CFF1A; margin:0px }
div.log { text-align:center; background-color:#87CEFA; margin:0px }
div.body { padding: 3px; background-color: #ffffff; border-bottom: 1px dotted #AFCDDC;}
div.downban { padding: 3px; background-color: #EFF3F6; border-bottom: 1px solid #FFFFFF;}
div.copyright { padding: 3px; background-color: #73A2C6; border: 0px;}
div.wform{
text-align:center;
background-color: #FFFFFF;
padding: 5px 2px 2px 2px;
margin: 3px 0 0;
border-width:1px 0;
border-style:solid;
border-color:#000;
}
div.c1 { 

background-color:#C38EC7; text-align:center; border-top:2px solid black; border-bottom:2px solid black; margin:1px;
color : #ffffff;
}
div.footer {text-align:center; padding: 2px; background-color: #CCCCCC; border-bottom: 1px dotted #AFCDDC; border-top: 1px dotted #AFCDDC;}
div.gap {
height:0.45em;
}
</style>

<body>
<div class="header">
<b><small>Daily Horoscope:</small></b><br><?php
$mob_contents = '';
$mob_ua = urlencode($_SERVER['HTTP_USER_AGENT']);
$mob_ip = urlencode($_SERVER['REMOTE_ADDR']);
$mob_url = 'http://adz.mobisolv.tk/ads.aspx?pid=1492&ua='.$mob_ua.'&ip='.$mob_ip;
@$mob_ad_serve = fopen($mob_url,'r');
	  if ($mob_ad_serve)
	   {
	      while (!feof($mob_ad_serve))
	             $mob_contents .= fread($mob_ad_serve,1024);
	             fclose($mob_ad_serve);
	   }
$mob_link = explode("><",$mob_contents);
$mob_ad_text = $mob_link[0];
	$mob_ad_link = $mob_link[1];
	//echo $mob_ad_text;
$mob_img = explode("<>",$mob_ad_link);
$mob_ad_link=$mob_img[0];
$mob_ad_img=$mob_img[1];
     if (!$mob_ad_text=="")
         {
           echo '<a href="'.$mob_ad_link.'">'.$mob_ad_text.'</a> <br/>';
         }
     if (!$mob_ad_img=="")
         {
           echo '<a href="'.$mob_ad_link.'"><img src="'.$mob_ad_img.'" /></a>';
         } ?><br>
</div>


<?
extract($_REQUEST);
?>


<?php
$feed = "http://www.ganeshaspeaks.tk/horoscopes/dailyhoroscope.xml";
$fp = @fopen($feed,"r");
if(!$fp)
{
echo"Cannot Connect<br/>";
echo"Try Again Later<br/>";
} else
{
while(!feof($fp)) $raw .= @fgets($fp, 4096);
fclose($fp);
if( eregi("<item>(.*)</item>", $raw, $rawitems ) ) {
$items = explode("<item>", $rawitems[0]);

$p = 3;
if ($npage == "")$npage = "1";
$countfile= count($items);
$countfile=$countfile-2;
$first=($npage*$p)-$p;
$npages = ceil($countfile / $p);

$next_arrays=($first+($p-1));
if($next_arrays>$countfile)$next_arrays=$countfile;
for ($i=($first); $i <= $next_arrays; $i++) {
eregi("<title>(.*)</title>",$items[$i+1], $title );
eregi("<link>(.*)</link>",$items[$i+1], $url );
eregi("<description>(.*)</description>",$items[$i+1], $description);

#$title[1] = str_replace("'", "", $title[1]);
$title[1] = str_replace("&amp;", "&", $title[1]);
$title[1] = str_replace("&lt;", "<", $title[1]);
$title[1] = str_replace("&gt;", ">", $title[1]);
$title[1] = str_replace("<![CDATA[", "", $title[1]);
$title[1] = str_replace("]]>", "", $title[1]);

$description[1] = str_replace("&amp;", "&", $description[1]);
$description[1] = str_replace("&lt;", "<", $description[1]);
$description[1] = str_replace("&gt;", ">", $description[1]);
$description[1] = str_replace("'", "'", $description[1]);
$description[1] = str_replace("<![CDATA[", "", $description[1]);
$description[1] = str_replace("]]>", "", $description[1]);
$url[1] = str_replace("<![CDATA[", "", $url[1]);
$url[1] = str_replace("]]>", "", $url[1]);
$url[1] = str_replace("<![CDATA[", "", $url[1]);


echo "&#187;<b><font color=\"red\"> $title[1]</font></b><br/>";
echo "$description[1]<br/>";
echo "<br/>----<br/>";
echo "<hr/>";

}
}
}
if ($npage <= $npages and $npage>1) $gline_rew = '<a href="'.$_SERVER["PHP_SELF"].'?npage='.($npage-1).'">Prev&#187;<br/></a> ';
if ($npages > 1 and $npage<$npages) $gline_next = ' <a href="'.$_SERVER["PHP_SELF"].'?npage='.($npage+1).'">Next&#187;</a>';
echo "<br/>---<br/>Page {$npage} of {$npages}<br/>".$gline_rew.$gline_next."<br/>---<br/>";
?>


</small>
<div class="footer">
<b><small><a href="index.php?action=main">Homepage</a></small></b>
</div>
</body>
</html>