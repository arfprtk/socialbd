<?php
session_name("PHPSESSID");
session_start();

header("Cache-Control: no-cache, must-revalidate");	        // Prevent caching, HTTP/1.1
header("Pragma: no-cache");
echo "<?xml version=\"1.0\"?>";
include("config.php");
include("core.php");
include("xhtmlfunctions.php");
echo "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\" \"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\">";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
  echo "<head><title>SocialBD</title>";
   // echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/style.css\" />";
    echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
<meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
<meta name=\"description\" content=\" wap dating portal and community containg chat, forums, blogs and much more\" />
<meta name=\"keywords\" content=\"chat, forums, wap, dating, games, blogs, polls, quiz, lavalair, news, rap, goth\" />
<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> </head>";

 echo "<body>";
  $bcon = connectdb();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$uid = getuid_sid($sid);
$sitename = mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE name='sitename'"));
$sitename = $sitename[0];

$time = time();
$time = time();
if (!$bcon)
{
   echo "<head><title>$site_name</title>";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/style.css\" />";
      echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
      <meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
      <meta name=\"description\" content=\"Riderz wap dating portal and community containg chat, forums, blogs and much more\" />
      <meta name=\"keywords\" content=\"chat, forums, wap, dating, games, blogs, polls, quiz, lavalair, news, rap, goth\" /></head>";

     echo "<body>";


    echo "<p align=\"center\">";
    echo "<img src=\"../images/notok.gif\" alt=\"!\"/><br/>";
    echo "<b><strong>Error! Cannot Connect To Database...</strong></b><br/><br/>";
    echo "This error happens usually when backing up the database, please be patient...";
    echo "</p>";
    echo "</body>";
    echo "</html>";
    exit();
}
$theme = mysql_fetch_array(mysql_query("SELECT theme FROM dcroxx_me_users WHERE id='".$uid."'"));
if($action=="addlyrics")
{
	/////////////////////////forum.wapfuns.tk/////////remove it only if you are stupid/////////////
	addonline(getuid_sid($sid),"Adding new Lyrics","index.php?action=online");
		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
 echo "<head><title>SocialBD</title>";
      //echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/style.css\" />";
      echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
      <meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
      <meta name=\"description\" content=\" wap dating portal and community containg chat, forums, blogs and much more\" />
      <meta name=\"keywords\" content=\"chat, forums, wap, dating, games, blogs, polls, quiz, lavalair, news, rap, goth\" /></head>";

     echo "<body>";

    echo "<p align=\"center\">";
	echo "<form action=\"lyric.php?action=publyrics\" method=\"post\">";
    echo "Title:<br/><input name=\"title\" maxlength=\"50\"/><br/>";
    echo "Artist:<br/><input name=\"tart\" maxlength=\"50\"/><br/>";
    echo "Lyrics:<br/><textarea name=\"tlyric\" maxlength=\"3500\"></textarea><br/>";
    echo "<input type=\"submit\" value=\"Publish\"/>";
    echo "</form><br/>";
    ///////////////////////forum.wapfuns.tk/////////remove it only if you are stupid///////////////
     echo "<a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"\"/>Home</a>";
    echo "</p>";
    echo "</body>";
}

if($action=="publyrics")
{   
		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
	  echo "<head><title>SocialBD</title>";
     // echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
      echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
      <meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
      <meta name=\"description\" content=\"Riderz wap dating portal and community containg chat, forums, blogs and much more\" />
      <meta name=\"keywords\" content=\"chat, forums, wap, dating, games, blogs, polls, quiz, lavalair, news, rap, goth\" /></head>";

echo "<body>";

  $title = $_POST["title"];
  $tart = $_POST["tart"];
  $tlyric = $_POST["tlyric"];
  if(istrashed(getuid_sid($sid)))
  {
	  //////////////////////forum.wapfuns.tk//////////remove it only if you are stupid/////////////////
      echo "<head>";
      echo "<title>$sitename</title>";
      echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
      echo "</head>";
      echo "<body>";
      echo "<p align=\"center\">";
      echo "<img src=\"../images/notok.gif\" alt=\"X\"/><br/>Unknown error cannot publish lyrics!<br/>please try again later...<br/><br/>";
      echo "<b>0 </b><a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
  }
  addonline(getuid_sid($sid),"Pulished New Lyrics","");
      echo "<head>";
      /////////////////////////forum.wapfuns.tk//////////remove it only if you are stupid/////////////
      echo "<title>SocialBD</title>";
    //  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
      echo "</head>";
      echo "<body>";
      echo "<p align=\"center\"><small>";

{
  if((trim($title)!="")||(trim($tart)!="")||(trim($tlyric)!=""))
      {
    if(!isblocked($title,$uid)&&!isblocked($tart,$uid))
    {
    $res = mysql_query("INSERT INTO dcroxx_me_lyrics SET artist='".$tart."', title='".$title."', lyrics='".$tlyric."'");
    }else{
    $bantime = $time + (30*24*60*60);
    echo "<img src=\"../images/notok.gif\" alt=\"X\"/>";
    echo "Can't Post Lyrics<br/><br/>";
    echo "You just tried publishing a lyrics with a link to one of the crapiest sites on earth<br/> The members of these sites spam here a lot, so go to that site and stay there if you don't like it here<br/> as a result of your stupid action:<br/>1. you have lost your sheild<br/>2. you have lost all your plusses<br/>3. You are BANNED!";
    $user = getnick_sid($sid);
    mysql_query("INSERT INTO dcroxx_me_mlog SET action='autoban', details='<b>wapfuns</b> auto banned $user for spamming in lyrics', actdt='".$time."'");
    mysql_query("INSERT INTO dcroxx_me_penalties SET uid='".$uid."', penalty='1', exid='2', timeto='".$bantime."', pnreas='Banned: Automatic Ban for spamming for a crap site'");
    mysql_query("UPDATE dcroxx_me_users SET plusses='0', shield='0' WHERE id='".$uid."'");
    echo "</body>";
    echo "</html>";
    exit();
    }
     }
       if($res)
      {
        $usts = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
        $upl = $usts[0]+100;
        mysql_query("UPDATE dcroxx_me_users SET posts='".$ups."', plusses='".$upl."' WHERE id='".$uid."'");
        $tnm = htmlspecialchars($title);
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Lyrics <b>$tnm</b> Created Successfully";
        $tid = mysql_fetch_array(mysql_query("SELECT id FROM dcroxx_me_lyrics WHERE title='".$title."'"));
        echo "<br/><br/><a href=\"lyric.php?action=lyrics&amp;tid=$tid[0]\">";
        echo "View Lyrics</a><br/>";
      }else{
       echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error Creating New Thread";
      }
      }
      echo "<a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
      echo "</small></p>";
      echo "</body>";
}
else if($action=="lyrics")
{
      //  echo "<head><title>$site_name</title>";
    //  echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
      echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
      <meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
      <meta name=\"description\" content=\"Riderz wap dating portal and community containg chat, forums, blogs and much more\" />
      <meta name=\"keywords\" content=\"chat, forums, wap, dating, games, blogs, polls, quiz, lavalair, news, rap, goth\" /></head>";

echo "<body>";

  addonline(getuid_sid($sid),"Lyrics","");
  		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
  echo "<p><small>";
  $tid = $_GET['tid'];
  $tinfo = mysql_fetch_array(mysql_query("SELECT artist, title, lyrics FROM dcroxx_me_lyrics WHERE id='".$tid."' LIMIT 1"));
  echo "Artist: <b>".htmlspecialchars($tinfo[0])."</b><br/>";
  echo "Title: <b>".htmlspecialchars($tinfo[1])."</b><br/><br/>";
  $lyrics =  $tinfo[2];
  $lyrics = htmlspecialchars($lyrics);
  $lyrics = nl2br($lyrics);
  echo "".$lyrics."";
  echo "</small></p>
  <p align=\"center\"><small>
  <a href=\"lyric.php?action=refr\">Back to lyrics</a><br/>
  <a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</small></p>";
  echo "</body>";

  }
else if($action=="refr")
{
        echo "<head><title>SocialBD</title>";
    //  echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
      echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
      <meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
      <meta name=\"description\" content=\" wap dating portal and community containg chat, forums, blogs and much more\" />
      <meta name=\"keywords\" content=\"chat, forums, wap, dating, games, blogs, polls, quiz, lavalair, news, rap, goth\" /></head>";

echo "<body>";
    addonline(getuid_sid($sid),"Viewing Lyrics","");
	 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
	  
    echo "<p><small>";
    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM dcroxx_me_lyrics"));
    $num_items = $noi[0]; //changable
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if($page>$num_pages)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    $titles = mysql_query("SELECT id, artist, title FROM dcroxx_me_lyrics ORDER BY artist, title LIMIT $limit_start, $items_per_page");
        while($title = mysql_fetch_array($titles)){
echo '<a href="lyric.php?action=lyrics&amp;tid='.$title[0].'">'.htmlspecialchars($title[1]).' - '.htmlspecialchars($title[2]).'</a><br/>';
        }
   echo "</small></p><p align=\"center\"><small>";
   if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lyric.php?action=refr&amp;page=$ppage\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"lyric.php?action=refr&amp;page=$npage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
        $rets = "<form action=\"lyric.php\" method=\"get\">";
        $rets .= "<input name=\"page\" style=\"-wap-input-format: '*N'\" size=\"3\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "<input type=\"submit\" value=\"Go To Page\"/>";
        $rets .= "</form>";

        echo $rets;
    }
  echo "<a href=\"lyric.php?action=addlyrics\">Publish New Lyrics</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</small></p>";
  echo "</body>";
}
?>
</html>