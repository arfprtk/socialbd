<?
session_name("PHPSESSID");
session_start();
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"

"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> 
<?php

include("config.php");

include("core.php");
include("xhtmlfunctions.php");

//session_start();

$bcon = connectdb();
if (!$bcon)
{
      echo "<head>\n";
	  echo "<title>SpiderWap</title>\n";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/style.css\" />";
	  	  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";

	  echo "</head>";
      echo "<body>";

	echo "<div class=\"ahblock2\">";

	echo "</div>";

    echo "<p align=\"center\">";
    echo "<img src=\"images/exit.gif\" alt=\"*\"/><br/>";
    echo "ERROR! cannot connect to database<br/><br/>";
    echo "This error happens usually when backing up the database, please be patient, The site will be up any minute<br/><br/>";
    echo "Soon, we will offer services that doesn't depend on MySQL databse to let you enjoy our site, while the database is not connected<br/>";
    echo "<b>THANK YOU VERY MUCH</b>";
    echo "</p>";
	echo "<div class=\"ahblock2\">";

	echo "</div>";
    echo "</body>";
    echo "</html>";
    exit();
}
//protect against sql injections and remove $ sign
if( !get_magic_quotes_gpc() )
{
    if( is_array($_GET) )
    {
        while( list($k, $v) = each($_GET) )
        {
            if( is_array($_GET[$k]) )
            {
                while( list($k2, $v2) = each($_GET[$k]) )
                {
                    $_GET[$k][$k2] = addslashes($v2);
                }
                @reset($_GET[$k]);
            }
            else
            {
                $_GET[$k] = addslashes($v);
            }
        }
        @reset($_GET);
    }

    if( is_array($_POST) )
    {
        while( list($k, $v) = each($_POST) )
        {
            if( is_array($_POST[$k]) )
            {
                while( list($k2, $v2) = each($_POST[$k]) )
                {
                    $_POST[$k][$k2] = addslashes($v2);
                }
                @reset($_POST[$k]);
            }
            else
            {
                $_POST[$k] = addslashes($v);
            }
        }
        @reset($_POST);
    }
}
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$uid = getuid_sid($sid);
$theme = mysql_fetch_array(mysql_query("SELECT theme FROM dcroxx_me_users WHERE id='".$uid."'"));

if((islogged($sid)==false)||($uid==0))
{
      echo "<head>\n";
	  echo "<title>SpiderWap</title>\n";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/style.css\" />";
	  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";

	  echo "</head>";
      echo "<body>";

	echo "<div class=\"ahblock2\">";

	echo "</div>";

      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
	echo "<div class=\"ahblock2\">";

	echo "</div>";

      echo "</body>";
      echo "</html>";
      exit();
}
if(isbanned($uid))
    {
	      echo "<head>\n";
	  echo "<title>SpiderWap</title>\n";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/style.css\" />";
	  	  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";

	  echo "</head>";
      echo "<body>";

	echo "<div class=\"ahblock2\">";

	echo "</div>";

      echo "<p align=\"center\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
      echo "You are <b>Banned</b><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT timeto FROM dcroxx_me_penalties WHERE uid='".$uid."' AND penalty='1'"));
      $remain = $banto[0]- time();
      $rmsg = gettimemsg($remain);
      echo "Time to finish your penalty: $rmsg<br/><br/>";
      //echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
	echo "<div class=\"ahblock2\">";

	echo "</div>";
    echo "</body>";
    echo "</html>";
      exit();
    }
if($action=="guessgm")
{     
		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
	  echo "<head>\n";
	  echo "<title>SocialBD</title>\n";
      //echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
	  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";

	  echo "</head>";
      echo "<body>";

    addonline(getuid_sid($sid),"Playing G.T.N.","");
	echo "<div class=\"ahblock2\">";

	echo "</div>";

  echo "<p align=\"center\">";
  $gid = $_POST["gid"];
  $un = $_POST["un"];

  if($gid=="")
  {
        mysql_query("DELETE FROM dcroxx_me_games WHERE uid='".$uid."'");
        mt_srand((double)microtime()*1000000);
        $rn = mt_rand(1,100);
        mysql_query("INSERT INTO dcroxx_me_games SET uid='".$uid."', gvar1='8', gvar2='".$rn."'");
        $tries = 8;
        $gameid = mysql_fetch_array(mysql_query("SELECT id FROM dcroxx_me_games WHERE uid='".$uid."'"));
        $gid=$gameid[0];
  }else{
    $ginfo = mysql_fetch_array(mysql_query("SELECT gvar1,gvar2 FROM dcroxx_me_games WHERE id='".$gid."' AND uid='".$uid."'"));
    $tries = $ginfo[0]-1;
    mysql_query("UPDATE dcroxx_me_games SET gvar1='".$tries."' WHERE id='".$gid."'");
    $rn = $ginfo[1];
  }
  if ($tries>0)
                {
                $gmsg = "<small>Just try to guess the number before you have no more tries, the number is between 1-100</small><br/><br/>";
                echo $gmsg;
                $tries = $tries-1;
                $gpl = $tries*3;
                echo "Tries:$tries, Plusses:$gpl<br/><br/>";
                      if ($un==$rn){
                        $gpl = $gpl+3;
                        $ugpl = mysql_fetch_array(mysql_query("SELECT gplus FROM dcroxx_me_users WHERE id='".$uid."'"));
                        $ugpl = $gpl + $ugpl[0];
                        mysql_query("UPDATE dcroxx_me_users SET gplus='".$ugpl."' WHERE id='".$uid."'");
                        echo "<small>Congrats! the number was $rn, $gpl Plusses has been added to your Game Plusses, <a href=\"games.php?action=guessgm\">New Game</a></small><br/><br/>";
                      }else{
                        if($un <$rn)
                        {
                          echo "Try bigger number than $un !<br/><br/>";
                        }else{
                            echo "Try smaller number than $un !<br/><br/>";
                        }
		echo " TRY";
		echo "<form action=\"games.php?action=guessgm\" method=\"post\">";
		echo "Your Guess: <input type=\"text\" name=\"un\" style=\"-wap-input-format: '*N'\" size=\"3\" value=\"$un\"/>";
		echo "<input type=\"hidden\" name=\"gid\" value=\"$gid\"/>";
		echo "<input type=\"Submit\" name=\"try\" value=\"TRY\"></form><br/>";
                      }


                }else{
                    $gmsg = "<small>GAME OVER, <a href=\"games.php?action=guessgm\">New Game</a></small><br/><br/>";
                    echo $gmsg;
                }
  echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
	echo "<div class=\"ahblock2\">";

	echo "</div>";

  echo "</p></body></html>";
  exit();
}

//////////////////////////////////Mix A Buddy

if($action=="jukebox")
{       echo "<head>\n";
	  echo "<title>SpiderWap</title>\n";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
		  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";

	  echo "</head>";
      echo "<body>";

    addonline(getuid_sid($sid),"JukeboX","");
    $view = $_GET["view"];
    if($view=="")$view="date";

    echo "<p align=\"center\">";
    echo "<embed style=\"width:435px; visibility:visible; height:270px;\" allowScriptAccess=\"never\" src=\"http://www.musicplaylist.us/mc/mp3player-othersite.swf?config=http://www.musicplaylist.us/mc/config/config_purple_shuffle.xml&mywidth=435&myheight=270&playlist_url=http://www.musicplaylist.us/loadplaylist.php?playlist=26996731\" menu=\"false\" quality=\"low\" width=\"435\" height=\"270\" name=\"mp3player\" wmode=\"transparent\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.tk/go/getflashplayer\" border=\"0\"/><br/>><a href=http://www.musicplaylist.us><img src=http://www.musicplaylist.us/mc/images/create_purple.jpg border=0></a><a href=http://www.musicplaylist.us/standalone/26996731 target=_blank><img src=http://www.musicplaylist.us/mc/images/launch_purple.jpg border=0></a><a href=http://www.musicplaylist.us/download/26996731><img src=http://www.musicplaylist.us/mc/images/get_purple.jpg border=0></a> </div>";
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
   echo "<br/><br/><a href=\"index.php?action=funm\">&#171;Back to Fun Menu</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";

   echo "</body>";
   echo "</html>";
   exit();
}else

//////////////////////////////////Mix A Buddy

if($action=="mixabud")
{       
		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
	  echo "<head>\n";
	  echo "<title>SocialBD</title>\n";
     // echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
		  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";

	  echo "</head>";
      echo "<body>";

    addonline(getuid_sid($sid),"Mix A Buddy","");
    $view = $_GET["view"];
    if($view=="")$view="date";

    echo "<p align=\"center\">";
    echo "<img src=\"images/group.gif\" alt=\"*\"/><br/>";
    echo "Here You Go Mate, This Could Be Your New Buddy/Friend! Give Him/Her A Try, Or If You Dont Think This Buddy Is Right For You, Then Feel Free To Try Again -ENJOY-!<br/>";
echo "<a href=\"games.php?action=mixabud\">Try Again!</a>";
    echo "</p>";
    //////ALL LISTS SCRIPT <<

    //changable sql
    $sql = "SELECT id, name, regdate FROM dcroxx_me_users ORDER BY RAND() LIMIT 1";
    echo "<p align=\"center\">";
    $items = mysql_query($sql);

    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $jdt = date("d-m-y", $item[2]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a>

joined: $jdt";
      echo "$lnk<br/>";
      echo "If You Like The Above User/Buddy, Check His/Her Profile And See If He/She Could Become Your New Buddy/Friend!<br/>";
    }
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
   echo "<br/><br/><a href=\"index.php?action=funm\">&#171;Back to Fun Menu</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";

   echo "</body>";
   echo "</html>";
   exit();
}else

//////////////////////////////////Mix A Buddy Guy

if($action=="mixabudguy")
{       echo "<head>\n";
	  echo "<title>SpiderWap</title>\n";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
	  	  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";

	  echo "</head>";
      echo "<body>";

    addonline(getuid_sid($sid),"Mix A Buddy Guy","");
    $view = $_GET["view"];
    if($view=="")$view="date";
    echo "<p align=\"center\">";
    echo "<img src=\"images/group.gif\" alt=\"*\"/><br/>";
    echo "Here You Go Mate, This Could Be Your New Buddy/Friend! Give Him A Try, Or If You Dont Think This Buddy Is Right For You, Then Feel Free To Try Again -ENJOY-!<br/>";
echo "<a href=\"games.php?action=mixabudguy\">Try Again!</a>";
    echo "</p>";
    //////ALL LISTS SCRIPT <<

    //changable sql
    $sql = "SELECT id, name, regdate FROM dcroxx_me_users WHERE sex='M' ORDER BY

RAND() LIMIT 1";

    echo "<p>";
    $items = mysql_query($sql);

    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $jdt = date("d-m-y", $item[2]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a>

joined: $jdt";
      echo "$lnk<br/>";
      echo "If You Like The Above User/Buddy, Check His Profile And See If He Could Become Your New Buddy/Friend!<br/>";
    }
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
   echo "<br/><br/><a href=\"index.php?action=funm\">&#171;Back to Fun Menu</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";

   echo "</body>";
   echo "</html>";
   exit();

}

//////////////
 // //////////

else if($action == "8ball")
{      echo "<head>\n";
	  echo "<title>SpiderWap</title>\n";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
	  	  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";

	  echo "</head>";
      echo "<body>";

     addonline(getuid_sid($sid), "ASKING 8BALL", "");


     echo "<p align=\"center\">";
     $gid = $_POST["gid"];
     $un = $_POST["un"];

     if($gid == "")
    {

        echo "<img src=\"8ball.jpeg\" alt=\"8Ball\"/><br/>";
        echo "<b><u>Magic 8Ball</u></b><br/>";
        echo "<b><i>Question:</i></b><br/>
        <input type=\"hidden\" name=\"text\" value=\"\"/>";
        echo "<br/>
        <form action=\"games.php?action=8ball\" method=\"post\">";
        echo "<input name=\"text\" value=\"question\"/>";
        echo "<br/>";
        echo "<input type=\"submit\" value=\"Ask\"/>";
        echo "</form>";
        }

         $xfile = @file("text.txt");
        $random_num = rand (0, count($xfile)-1);
        $udata = explode("::", $xfile[$random_num]);

        echo "<b><u>The Answer Is</u></b><br/>";
        echo "<b><i>$udata[1]</i></b><br/>";

        echo "<br/><br/><a href=\"index.php?action=funm\">&#171;Back to Fun Menu</a><br/>";
        echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
        echo "Home</a>";
        echo "</body>";
        echo "</html>";
		exit();
    }


/////////////////////////////////

else if($action == "scramble")
{      echo "<head>\n";
	  echo "<title>SpiderWap</title>\n";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
	  	  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";

	  echo "</head>";
      echo "<body>";

    addonline(getuid_sid($sid),"playing word scramble","");
  echo "<p align=\"center\">";
$answer = $_POST["answer"];
if (empty($_POST["answer"]))  {

srand((float) microtime() * 10000000);
$input = array(
"dictionary",
"recognize",
"example",
"entertainment",
"experiment",
"appreciation",
"information",
"pronunciation",
"language",
"government",
"psychic",
"blueberry",
"selection",
"automatic",
"strawberry",
"bakery",
"shopping",
"eggplant",
"chicken",
"organic ",
"angel",
"season",
"market",
"information",
"complete",
"sunset",
"unique",
"customer"
);
$rand_keys = array_rand($input, 2);
$word = $input[$rand_keys[0]];
$Sword = str_shuffle($word);
echo "<p align=\"center\">$Sword</p>
      <p align=\"center\">In the
      text box below type the correct word that is scrambled above.</p>
      <form method=\"POST\" action=\"games.php?action=scramble\">
        <center><input type=\"text\" name=\"answer\" size=\"20\">
<input type=\"hidden\" name=\"correct\" value=\"$word\">
<input type=\"submit\" value=\"GO!\" name=\"B1\"></center>
      </form>
      <p align=\"center\">
      <a href=\"index.php?action=funm\">&#171;Back to Fun Menu</a><br/>
<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a></p>
</body>";
}
else {
$answer = strtolower($answer);
if($answer == $correct){
$result = "Correct! <b>$answer</b>";
$uid = getuid_sid($sid);
$ugpl = mysql_fetch_array(mysql_query("SELECT gplus FROM dcroxx_me_users WHERE id='".$uid."'"));
$ugpl = "25" + $ugpl[0];
mysql_query("UPDATE dcroxx_me_users SET gplus='".$ugpl."' WHERE id='".$uid."'");

echo "<p align=\"center\">$result<br/>You Have Had 25 game Plusses Added For Winning.
</p>
      <p align=\"center\"><a href=\"games.php?action=scramble\">Try Another Word?</a><br/>
<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a></p>
</body>";
echo "</html>";
exit();
}


else {
      echo "<head>\n";
	  echo "<title>SpiderWap</title>\n";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
	  	  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";

	  echo "</head>";
      echo "<body>";

$result = "Sorry! The Correct Answer Was <b>$correct</b>.";
$uid = getuid_sid($sid);
$ugpl = mysql_fetch_array(mysql_query("SELECT gplus FROM dcroxx_me_users WHERE id='".$uid."'"));
$ugpl = $ugpl[0] - "25";
mysql_query("UPDATE dcroxx_me_users SET gplus='".$ugpl."' WHERE id='".$uid."'");

echo "<p align=\"center\">$result<br/>You Have Had 25 game Plusses Deducted For Losing.
</p>
<p align=\"center\"><a href=\"games.php?action=scramble\">Try Another Word?</a><br/>
<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a></p>
</body>";
echo "</html>";
exit();
}
}
}
////////////////////////////////////////


////////

else

//////////////////////////////////Mix A Buddy Girl

if($action=="mixabudgirl")
{       echo "<head>\n";
	  echo "<title>SpiderWap</title>\n";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
		  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";

	  echo "</head>";
      echo "<body>";

    addonline(getuid_sid($sid),"Mix A Buddy Girl","");
    $view = $_GET["view"];
    if($view=="")$view="date";
    echo "<p align=\"center\">";
    echo "<img src=\"images/group.gif\" alt=\"*\"/><br/>";
    echo "Here You Go Mate, This Could Be Your New Buddy/Friend! Give Her A Try, Or If You Dont Think This Buddy Is Right For You, Then Feel Free To Try Again -ENJOY-!<br/>";
echo "<a href=\"games.php?action=mixabudgirl\">Try Again!</a>";
    echo "</p>";
    //////ALL LISTS SCRIPT <<

    //changable sql
    $sql = "SELECT id, name, regdate FROM dcroxx_me_users WHERE sex='F' ORDER BY RAND() LIMIT 1";

    echo "<p>";
    $items = mysql_query($sql);

    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $jdt = date("d-m-y", $item[2]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[0]\">$item[1]</a>

joined: $jdt";
      echo "$lnk<br/>";
      echo "If You Like The Above User/Buddy, Check Her Profile And See If She Could Become Your New Buddy/Friend!<br/>";
    }
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
   echo "<br/><br/><a href=\"index.php?action=funm\">&#171;Back to Fun Menu</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
   echo "</body>";
   echo "</html>";
   exit();

}else

/////////////////////////////////////////////////CASINO/////////////////////////////////////////
if($action=="casinoi")
{         echo "<head>\n";
	  echo "<title>SpiderWap</title>\n";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
	 	  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";

	  echo "</head>";
      echo "<body>";

    addonline(getuid_sid($sid),"Playing Casino","");
    $view = $_GET["view"];
    if($view=="")$view="date";

    echo "<p align=\"center\">";
    echo "<img src=\"images/roll.gif\" alt=\"*\"/><br/>";
    echo "Play our slots game to win some great prizes! Very fun game!";
    echo "</p>";
    //////ALL LISTS SCRIPT <<

        echo "<p align=\"center\">";
    echo "<a href=\"games.php?action=casino\">&#187;Start spinning Slots</a><br/>";
    echo "</p>";
      ////// UNTILL HERE >>
    echo "<p align=\"center\">";
   echo "<br/><br/><a href=\"index.php?action=funm\">&#171;Back to Fun Menu</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";

  echo "</body>";
  echo "</html>";
exit();
}
/////////////////////////////////////////////////END OF CASINO/////////////////////////////////////////
else if($action=="casino")
{      echo "<head>\n";
	  echo "<title>SpiderWap</title>\n";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
		  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";

	  echo "</head>";
      echo "<body>";

    addonline(getuid_sid($sid),"Playing Casino","");
    $view = $_GET["view"];
    if($view=="")$view="date";
    echo "<p align=\"center\">";

    //////ALL LISTS SCRIPT <<

$num1 = rand(1, 9);
$num2 = rand(1, 9);
$num3 = rand(1, 9);
echo "<img src=\"images/casino.gif\" alt=\"*\"/><br/>";
echo "<b><u>These Are Your Cards:</u></b><br/>";
echo "<b>[$num1][$num2][$num3]</b><br/>";
$messege = "<b>Sorry, you lose!</b>";
if ($num1 == 7 and $num2 == 7 and $num3 == 7) {
  $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
  $gpl = rand(10, 30);
  $ugpl = $gpl + $ugpl[0];
  mysql_query("UPDATE dcroxx_me_users SET plusses='".$ugpl."' WHERE id='".$uid."'");
  $messege = "*You Have Just Won $gpl Credits";
}
if ($num1 == 1 and $num2 == 1 and $num3 == 1) {
  $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
  $gpl = rand(10, 30);
  $ugpl = $gpl + $ugpl[0];
  mysql_query("UPDATE dcroxx_me_users SET plusses='".$ugpl."' WHERE id='".$uid."'");
  $messege = "*You Have Just Won $gpl Credits";
}
if ($num1 == 3 and $num3 == 3) {
  $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
  $gpl = rand(1, 10);
  $ugpl = $gpl + $ugpl[0];
  mysql_query("UPDATE dcroxx_me_users SET plusses='".$ugpl."' WHERE id='".$uid."'");
  $messege = "*You Have Just Won $gpl Credits";
}
if ($num2 == 5 and $num1 == 5) {
  $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
  $gpl = rand(1, 10);
  $ugpl = $gpl + $ugpl[0];
  mysql_query("UPDATE dcroxx_me_users SET plusses='".$ugpl."' WHERE id='".$uid."'");
  $messege = "*You Have Just Won $gpl Credits";
}
if ($num1 == 6 and $num3 == 5) {
  $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
  $gpl = rand(1, 5);
  $ugpl = $ugpl[0] - $gpl;
  mysql_query("UPDATE dcroxx_me_users SET plusses='".$ugpl."' WHERE id='".$uid."'");
  $messege = "*You Have Just Lost $gpl Credits";
}
if ($num2 == 9 and $num1 == 5) {
  $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
  $gpl = rand(1, 5);
  $ugpl = $ugpl[0] - $gpl;
  mysql_query("UPDATE dcroxx_me_users SET plusses='".$ugpl."' WHERE id='".$uid."'");
  $messege = "*You Have Just Lost $gpl Credits";
}

echo "$messege";

echo "<br/><b><a href=\"games.php?action=casino\">Spin The Wheel!</a></b>";
   echo "<br/><br/><a href=\"index.php?action=funm\">&#171;Back to Fun Menu</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
    echo "Home</a>";
  echo "</p>";
  echo "</body>";
  exit();
}
/////////////////////////////////////////////////END OF CASINO/////////////////////////////////////////

//////////////////////////////////LOTTO////////////BY QUIKSILVER 2006 quiksilver@ranterswap.tk////////

else if($action=="lottoi")
{    
		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
	  echo "<head>\n";
	  echo "<title>SocialBD</title>\n";
     // echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
		  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";

	  echo "</head>";
      echo "<body>";

    addonline(getuid_sid($sid),"Playing lotto","");

    echo "<p align=\"center\">";
    echo "<b>SBD Lotto Draw</b><br/>Wanna become a SiD millionaire? Really? Really,really? Then this game should keep you busy and entertained for HOURS! Win the lotto and be known as a millionaire here!<br/>";

    echo "</p>";
    //////ALL LISTS SCRIPT <<
 echo "<p align=\"center\">";

 echo "<br/><a href=\"games.php?action=lotto\">";
 echo "QuickPick</a><br/>";
 echo "Quickpick Price: 2 Credits<br/><br/>";
  echo "<a href=\"games.php?action=lottop\">";
 echo "Millionaires rewards</a><br/>";
   echo "</p>";


  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<br/><br/><a href=\"index.php?action=funm\">&#171;Back to Fun Menu</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
    echo "Home</a>";
  echo "</p>";
  echo "</body>";
  exit();
}

//////////////////////////////////LOTTO////////////BY QUIKSILVER 2006 quiksilver@ranterswap.tk////////

else if($action=="lotto")
{
		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
      echo "<head>\n";
	  echo "<title>SocialBD</title>\n";
    //  echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
	 	  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";

	  echo "</head>";
      echo "<body>";

    addonline(getuid_sid($sid),"Playing lotto","");

    echo "<p align=\"center\">";

    echo "<b> Lotto Draw</b><br/>Heres the lucky draw =D<br/>";

    echo "</p>";
    //////ALL LISTS SCRIPT <<
echo "<p align=\"center\">";
 if(getplusses(getuid_sid($sid))<10)
    {
        echo "You should have at least 10 Credits to play this game!";
    }else{
echo "<u>These are the winning lotto numbers</u><br/>";
 echo "<b>(2)(9)(18)(30)(38)(42)</b><br/>";
   echo "<u>These are your numbers</u><br/>";
$xfile = @file("lotto.txt");
$random_num = rand (0,count($xfile)-1);
$udata = explode("::",$xfile[$random_num]);
echo $udata[1];
}
  $ugpl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
  $ugpl = $ugpl[0] - 2;
  mysql_query("UPDATE dcroxx_me_users SET plusses='".$ugpl."' WHERE id='".$uid."'");
echo "<br/><a href=\"games.php?action=lotto\">";
echo "another quickpick</a><br/>";
   echo "</p>";

  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<br/><a href=\"index.php?action=funm\">&#171;Back to Fun Menu</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
    echo "Home</a>";
  echo "</p>";
   echo "</body>";
  echo "</html>";
  exit();

}

//////////////////////////////////LOTTO////////////BY QUIKSILVER 2006 quiksilver@ranterswap.tk////////

else if($action=="lottow")
{    
		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);  echo "<head>\n";
	  echo "<title>SocialBD</title>\n";
    //  echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
	 	  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";

	  echo "</head>";
      echo "<body>";

    addonline(getuid_sid($sid),"Playing lotto","");

    echo "<p align=\"center\">";
    echo "<b> Lotto Draw</b><br/>This is the secret code that you must inbox SiD in order to become a SiD millionaire!<br/>";

    echo "</p>";
    //////ALL LISTS SCRIPT <<
echo "<p align=\"center\">";
 if(getplusses(getuid_sid($sid))<10)
    {
        echo "You should have at least 10 credits to play this game!";
    }else{
  $xfile = @file("lottowin.txt");
  echo $udata[1];
   }

  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<br/><br/><a href=\"index.php?action=funm\">&#171;Back to Fun Menu</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
    echo "Home</a>";
  echo "</p>";
   echo "</body>";
  echo "</html>";
  exit();
}

//////////////////////////////////LOTTO////////////BY QUIKSILVER 2006 quiksilver@ranterswap.tk////////

else if($action=="lottop")
{
		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
      echo "<head>\n";
	  echo "<title>SocialBD</title>\n";
   //   echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
		  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";

	  echo "</head>";
      echo "<body>";

    addonline(getuid_sid($sid),"Playing lotto","");

    echo "<p align=\"center\">";
      echo "<b>Lotto Draw</b><br/>Millionares get:<br/>";

    echo "</p>";
    //////ALL LISTS SCRIPT <<


   echo "*300 plusses<br/>";
   echo "*their status changes to SiD millionaire<br/>";
    echo "*your name will be up in site stats as one of the lotto winners<br/>";
    echo "*you will also be added to out V.I.P list<br/>";



  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=funm\"><img src=\"images/roll.gif\" alt=\"*\"/>";
echo "</a>Fun Menu<br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo "</body>";
  echo "</html>";
 exit();

}else
//////////////////////////////////LOTTO////////////BY QUIKSILVER 2006 quiksilver@ranterswap.tk////////
/////////////////////////////////////////////////FC/////////////////////////////////////////
if($action=="fci")
{      echo "<head>\n";
	  echo "<title>SpiderWap</title>\n";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
	  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";

	  echo "</head>";
      echo "<body>";

    addonline(getuid_sid($sid),"Playing Fortune Cookie","");
    $view = $_GET["view"];
    if($view=="")$view="date";

    echo "<p align=\"center\">";
    echo "<img src=\"images/roll.gif\" alt=\"*\"/><br/>";
    echo "Hmmm... So  you have come to let the cookie tell you your fortune?! Well good luck young (or old,lol) SiD wapper!!!!";
    echo "</p>";
    //////ALL LISTS SCRIPT <<

        echo "<p align=\"center\">";
    echo "<a href=\"games.php?action=fc\">&#187;Read Fortune Cookie</a><br/>";
    echo "</p>";
      ////// UNTILL HERE >>
    echo "<p align=\"center\">";
   echo "<br/><br/><a href=\"index.php?action=funm\">&#171;Back to Fun Menu</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
   echo "</body>";
  echo "</html>";
  exit();

}else
/////////////////////////////////////////////////FC/////////////////////////////////////////
if($action=="fc")
{      echo "<head>\n";
	  echo "<title>SpiderWap</title>\n";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
	  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";

	  echo "</head>";
      echo "<body>";

    addonline(getuid_sid($sid),"Playing Fortune Cookie","");
    $view = $_GET["view"];
    if($view=="")$view="date";

    echo "<p align=\"center\">";
    echo "<b>The fortune cookie tells you:</b>";
    echo "</p>";
 //////ALL LISTS SCRIPT <<
echo "<p align=\"center\">";
$xfile = @file("fortune.txt");
$random_num = rand (0,count($xfile)-1);
$udata = explode("::",$xfile[$random_num]);
echo $udata[1];
 echo "<br/><a href=\"games.php?action=fc\">Another Cookie</a>";
   echo "</p>";


  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
   echo "<br/><br/><a href=\"index.php?action=funm\">&#171;Back to Fun Menu</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";

   echo "</body>";
   echo "</html>";
   exit();
}

///////////////
if($action == "startlove")
{     
		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
	  echo "<head>\n";
	  echo "<title>SocialBD</title>\n";
      //echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
	  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";

	  echo "</head>";
      echo "<body>";

     addonline(getuid_sid($sid), "Love Calc", "");
     $view = $_GET["view"];
     if($view == "")$view = "date";
     echo "<p align=\"center\">";
     echo "<img src=\"smilies/heart.gif\" alt=\"*\"/><br/>";
     echo "Your Name:<br/>";
     echo "<input name=\"name\" maxlength=\"12\"/><br/>";
     echo "partner's Name:<br/>";
     echo "<input name=\"partner\" maxlength=\"12\"/><br/>";
     echo "<a href=\"?action=results\">Calculate Your Love!</a><br/>";
     echo "</p>";
    echo "<p align=\"center\">";
     echo "<br/><br/><a href=\"index.php?action=funm\">&#171;Back to Fun Menu</a><br/>";
     echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
    echo "Home</a>";
     echo "</p>";
     echo "</body>";
     echo "</html>";
	 exit();
    }
elseif($action == "results")
{      
		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle); 
	  echo "<head>\n";
	  echo "<title>SocialBD</title>\n";
      //echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
	  	  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";

	  echo "</head>";
      echo "<body>";

     addonline(getuid_sid($sid), "Love Calc Results", "");
     $view = $_GET["view"];
     if($view == "")$view = "date";
     echo "<p align=\"center\">";
     $lovecalc = rand (40, 100);
     $jeez = "48";
     $wow = "67";
     echo "You Love Your Partner <b>$lovecalc %</b><br/>";
    if($lovecalc < $jeez) echo "<b>Jeez Do Better Than That!</b>";
     elseif($lovecalc > $wow) echo "<b>WOW Thats Cool Keep It Up!</b>";
     else echo "<b>Obviously I Dont Know What To Say!</b>";
     echo "</p>";
     // //// UNTILL HERE >>
    echo "<p align=\"center\">";
     echo "<br/><br/><a href=\"index.php?action=funm\">&#171;Back to Fun Menu</a><br/>";
     echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
    echo "Home</a>";
     echo "</p>";
     echo "</body>";
     echo "</html>";
	 exit();
    }
////////////////////////////////////////

else if($action == "hangman")
{      echo "<head>\n";
	  echo "<title>SpiderWap</title>\n";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
	  	  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";

	  echo "</head>";
      echo "<body>";

  addonline(getuid_sid($sid),"Playing Hangman","");
  if ($cat==""){
  echo "<p align=\"center\">
  <img src=\"images/hang_6.gif\" alt=\"Hangman\"/><br/>
  Select a category:<br/>";
  echo "<a href=\"$PHP_SELF?action=hangman&amp;cat=anmls\">Animals</a><br/>";
  echo "<a href=\"$PHP_SELF?action=hangman&amp;cat=clrs\">Colours</a><br/>";
  echo "<a href=\"$PHP_SELF?action=hangman&amp;cat=comp\">Computers</a><br/>";
  echo "<a href=\"$PHP_SELF?action=hangman&amp;cat=frt\">Fruit</a><br/>";
  echo "<a href=\"$PHP_SELF?action=hangman&amp;cat=big\">Big Words</a><br/>";
  echo "<a href=\"$PHP_SELF?action=hangman&amp;cat=lotr\">Lord Of The Rings</a><br/>";
  echo "<a href=\"$PHP_SELF?action=hangman&amp;cat=mths\">Months</a><br/>";
  echo "<a href=\"$PHP_SELF?action=hangman&amp;cat=web\">Web / Wap coding</a><br/>";

  echo "<br/><a href=\"index.php?action=main\">Back</a><br/>";

  echo "</p></body></html>";
  exit();
  }
if ($cat==anmls){
$category="ANIMALS";
$list = "ANIMALS
BABOON
BEAR
BULL
CAMEL
CAT
COW
CROW
DOG
DONKEY
DUCKBILL PLATYPUS
EAGLE
ELEPHANT
FISH
FOX
GIRAFFE
GOAT
GOLDFISH
HAWK
HEDGEHOG
HORSE
KANGAROO
KITTEN
MOLE
MONKEY
MOUSE
MULE
OWL
PARROT
PIG
PINK ELEPHANT
POLAR BEAR
PORCUPINE
POSSUM
PUPPY
RABBIT
RACCOON
RAT
ROBIN
SEAL
SHARK
SKUNK
SQUIRREL
STOAT
WALRUS
WEASEL
WHALE
ZEBRA";}



if ($cat==clrs){
$category="COLOURS";
$list = "BLACK
BLUE
BROWN
BUBBLEGUM PINK
COLORS
CYAN
FUCHSIA
GOLD
GREEN
GREY
INDIGO
LAVENDER
LIME GREEN
MAROON
OLIVE
ORANGE
PERIWINKLE
PINK
PURPLE
RED
ROYAL BLUE
SCARLET
TEAL
TURQUOISE
VIOLET
WHITE
YELLOW"; }


if ($cat==comp){
$category="COMPUTERS";
$list = "ACCESS
ANTI-VIRUS SOFTWARE
BASIC
CD-ROM DRIVE
CHAT
COMPUTER
CPU
DATABASE
DOS
EMAIL
EXCEL
FIREWALL
FLOPPY DRIVE
FORUMS
FRONTPAGE
GAMES
HACKER
HARD DRIVE
HTML
ICQ
INTERNET
JUNK MAIL
KEYBOARD
LINUX
LOTUS
MICROSOFT
MONITOR
MOTHER BOARD
MOUSEPAD
OPERATING SYSTEM
PARALLEL PORT
PHP
PRINTER
PUBLISHING
RAM
SERIAL PORT
SOLITARE
SPEAKERS
TECHNOLOGY
UNIX
URL
VIRUS
VISUAL BASIC
WINDOWS
WORD
WORD PROCESSING
WORLD WIDE WEB
ZIP"; }


if ($cat==frt){
$category="FRUIT";
$list = "APPLE
BANANA
BLACKBERRY
BLUEBERRY
FRUIT
GRAPE
GRAPEFRUIT
KIWI
MANGO
ORANGE
PEACH
PEAR
RASBERRY
STRAWBERRY
TANGERINE
TOMATO
UGLY FRUIT"; }



if ($cat==big){
$category="BIG WORDS";
$list = "AUSTRALOPITHECINE
DEOXYRIBONUCLEIC ACID
LARGE WORDS
MITOCHONDRIA"; }

if ($cat==lotr){
$category="LORD OF THE RINGS";
$list = "AGORNATH
ARAGORN
ARWEN
BAG END
BALIN
BALROG
BARROW DOWNS
BARROW WRIGHT
BEREN
BILBO BAGGINS
BLACK RIDERS
BOROMIR
BREE
BUCKLAND
CELEBORN
DEAD MARSHES
DWARVES
EDORAS
ELENDIL
ELFSTONE
ELROND
ELVES
ENTS
EOWYN
FANGORN FOREST
FARAMIR
FRODO BAGGINS
GALADRIEL
GANDALF
GILGALAD
GLAMDRING
GLORFINDEL
GOLDBERRY
GOLLUM
GONDOR
HALDIR
HELMS DEEP
HOBBITON
HOBBITS
ISENGARD
ISILDUR
LEGOLAS
LEMBAS BREAD
LONELY MOUNTAIN
LONELY MOUNTIAN
LORD OF THE RINGS
LOTHLORIEN
LUTHIEN
MELKOR
MEN
MERRY
MIDDLE EARTH
MINAS MORGUL
MINAS TIRITH
MIRKWOOD
MITHRANDIR
MITHRIL
MORDOR
MORIA
MT. DOOM
MY PRECIOUSSS
NAZGUL
NUMENOR
OLD FOREST
OLD MAN WILLOW
ORCS
ORTHANC
PIPE WEED
PIPPIN
PLAINTIR
RANGERS
RINGWRAITHS
RIVENDELL
ROHAN
SAMWISE GAMGEE
SARUMAN
SAURON
SHADOWFAX
SHAGRAT
SHELOB
SHIRE
SILMARILLIAN
SMAUG
SMEAGOL
STEWARD OF GONDOR
STING
STRIDER
THE FELLOWSHIP OF THE RING
THE RETURN OF THE KING
THE RING
THE TWO TOWERS
THEODIN
TOM BOMBADIL
TREEBEARD
TROLLS
UNDYING LANDS
URUK-HAI
VALINOR
WARG RIDERS
WEATHERTOP
WIZARDS
WORMTONGUE";}


if ($cat==mths){
$category="MONTHS";
$list = "APRIL
AUGUST
DECEMBER
FEBRUARY
JANUARY
JULY
JUNE
MARCH
MAY
MONTHS
NOVEMBER
OCTOBER
SEPTEMBER"; }

if ($cat==web){
$category="WEB / WAP CODING";
$list = "JAVA BEANS
PHP SCRIPTS
SOURCE CODE
JAVASCRIPT GAMES
SSI IS SERVER SIDE INCLUDES
BILL GATES
COOKIES
HTTP AUTHENTICATION
ERROR HANDLING
MANIPULATING IMAGES
FILE UPLOADS
DATABASE / CONNECTION
APACHE SERVER
ZIP FILE
TAR COMPRESSION
FUNCTIONS
ENCRYPTION
MYSQL DATABASE
INITIALIZATION
FAQ - FREQUENTLY ASKED QUESTIONS
DEBUGGING
VERIFICATION
HTML VALIDATION
CASCADING STYLE SHEETS";}

# below ($alpha) is the alphabet letters to guess from.
#   you can add international (non-English) letters, in any order, such as in:
#   $alpha = "????????????????????????????ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$alpha = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

# below ($additional_letters) are extra characters given in words; '?' does not work
#   these characters are automatically filled in if in the word/phrase to guess
$additional_letters = " -.,;!?%& 0123456789/";

#========= do not edit below here ======================================================

$sid = $_GET["sid"];
$uid = getuid_sid($sid);
$len_alpha = strlen($alpha);

if(isset($_GET["n"])) $n=$_GET["n"];
if(isset($_GET["letters"])) $letters=$_GET["letters"];
if(!isset($letters)) $letters="";

if(isset($PHP_SELF)) $self=$PHP_SELF;
else $self=$_SERVER["PHP_SELF"];

$links="";
$max=6;
# error_reporting(0);
$list = strtoupper($list);
$words = explode("\n",$list);
srand ((double)microtime()*1000000);
$all_letters=$letters.$additional_letters;
$wrong = 0;

echo "<p align=\"center\">";
if (!isset($n)) { $n = rand(1,count($words)) - 1; }
$word_line="";
$word = trim($words[$n]);
$done = 1;
for ($x=0; $x < strlen($word); $x++)
{
  if (strstr($all_letters, $word[$x]))
  {
    if ($word[$x]==" ") $word_line.=" / "; else $word_line.=$word[$x];
  }
  else { $word_line.="_ "; $done = 0; }
}

if (!$done)
{

  for ($c=0; $c<$len_alpha; $c++)
  {
    if (strstr($letters, $alpha[$c]))
    {
      if (strstr($words[$n], $alpha[$c])) {$links .= "<b>$alpha[$c]</b> "; }
      else { $links .= " $alpha[$c] "; $wrong++; }
    }
    else
    { $links .= " <a href=\"$self?action=hangman&amp;cat=$cat&amp;letters=$alpha[$c]$letters&amp;n=$n\">$alpha[$c]</a> "; }
  }
  $nwrong=$wrong; if ($nwrong>6) $nwrong=6;
  echo "<br/><img src=\"../images/hang_$nwrong.gif\" alt=\"Wrong: $wrong out of $max\"/><br/>";

  if ($wrong >= $max)
  {
    $n++;
    if ($n>(count($words)-1)) $n=0;
    echo "<br/><br/>$word_line";
    echo "<br/><br/><big>SORRY, YOU ARE HANGED!!!</big><br/><br/>";
    if (strstr($word, " ")) $term="answer"; else $term="word";
    echo "The $term was \"<b>$word</b>\"<br/><br/>";
    $sqlfetch=mysql_query("SELECT gplus FROM dcroxx_me_users WHERE id='".$uid."'");
    $sqlfet=mysql_fetch_array($sqlfetch);
    $gplusnew=$sqlfet[0] - "25";
    $sql="UPDATE dcroxx_me_users SET gplus='".$gplusnew."' WHERE id='".$uid."'";
    $res=mysql_query($sql);
    echo "You Have Had 25 game Plusses Deducted For Losing.<br/>";
    echo "<a href=\"$self?action=hangman&amp;cat=$cat&amp;n=$n\">Play again</a><br/>";
  echo "<a href=\"$self?action=hangman\">Change category</a>";
  }else{
    echo " Wrong Guesses Left: <b>".($max-$wrong)."</b><br/><br/>";
    echo "$word_line";
    echo "<br/><br/>Choose a letter:<br/>";
    echo "$links";
  }
}else{
  $n++;    # get next word
  if ($n>(count($words)-1)) $n=0;
  echo "<br/><br/>\n$word_line";
  echo "<br/><br/><b>Congratulations!!! You win!!!</b><br/><br/><br/>";
      $sqlfetch=mysql_query("SELECT gplus FROM dcroxx_me_users WHERE id='".$uid."'");
    $sqlfet=mysql_fetch_array($sqlfetch);
    $gplusnew=$sqlfet[0] + "25";
    $sql="UPDATE dcroxx_me_users SET gplus='".$gplusnew."' WHERE id='".$uid."'";
    $res=mysql_query($sql);
    echo "You Have Had 25 game Plusses Added For Winning.<br/>";
  echo "<a href=\"$self?action=hangman&amp;cat=$cat&amp;n=$n\">Play again</a><br/>";
  echo "<a href=\"$self?action=hangman\">Change category</a>";
}
  echo "<br/><br/><a href=\"index.php?action=main\">Back</a>";
  echo "<br/><a href=\"index.php?action=funm\">&#171;Back to Fun Menu</a><br/>";
  echo "</p></body></html>";
}


function getchars($text)
{
	$text = strtolower($text);
	$abc = "abcdefghijklmnopqrstuvwxyz";
	$rts = "";
	for ($i=0; $i<strlen($text); $i++)
	{
		$onc = substr($text,$i, 1);
		$pos = strpos($abc,$onc);
		if($pos===false)
		{
			//meh
		}else{
			$pos = strpos($rts, $onc);
			if($pos===false)
			{
				$rts .= $onc;
			}
		}
	}
	return $rts;
}
?>