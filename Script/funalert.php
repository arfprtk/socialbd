<?php
    session_name("PHPSESSID");
session_start();
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
//header('Content-type: application/vnd.wap.xhtml+xml'); 
echo "<?xml version=\"1.0\"?>";
echo "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\" \"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\">";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> 
<?php
include("config.php");
include("core.php");
$bcon = connectdb();
$sitename = mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE name='sitename'"));
$sitename = $sitename[0];

if (!$bcon)
{
    echo "<head>";
    echo "<title>Error!!!</title>";
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/white_medium.css\">";
    echo "</head>";
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
$brws = explode("/",$HTTP_USER_AGENT);
$ubr = $brws[0];
$uip = getip();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$page = $_GET["page"];
$who = $_GET["who"];
$uid = getuid_sid($sid);

$sqlthing = mysql_query("SELECT * FROM dcroxx_me_users WHERE id='$uid'");
   $name=(mysql_result($sqlthing,0,"name"));
cleardata();

if(($action != "") && ($action!="terms"))
{
    $uid = getuid_sid($sid);
    if((islogged($sid)==false)||($uid==0))
    {
      echo "<head>";
      echo "<title>Error!!!</title>";
      echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/white_medium.css\">";
      echo "</head>";
      echo "<body>";
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    } 
}
//echo isbanned($uid);
if(isbanned($uid))
    {
      echo "<head>";
      echo "<title>Error!!!</title>";
      echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
      echo "</head>";
      echo "<body>";
      echo "<p align=\"center\">";
      echo "<img src=\"../images/notok.gif\" alt=\"x\"/><br/>";
      echo "<b>You are Banned</b><br/><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT timeto, pnreas, exid FROM dcroxx_me_penalties WHERE uid='".$uid."' AND penalty='1' OR uid='".$uid."' AND penalty='2'"));
	$banres = mysql_fetch_array(mysql_query("SELECT lastpnreas FROM dcroxx_me_users WHERE id='".$uid."'"));
      $remain = $banto[0]- time();
      $rmsg = gettimemsg($remain);
      echo "<b>Time Left: </b>$rmsg<br/>";
      $nick = getnick_uid($banto[2]);
	echo "<b>By: </b>$nick<br/>";
	echo "<b>Reason: </b>$banto[1]";
      //echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
$res = mysql_query("UPDATE dcroxx_me_users SET browserm='".$brws4."', ipadd='".$uip."' WHERE id='".getuid_sid($sid)."'");

////////////////////////////////////////MAIN PAGE


if($action=="main")
{
  addvisitor();
  $mmsg = htmlspecialchars(getsetmood(getuid_sid($sid)));
  addonline(getuid_sid($sid),"Fun Alerts ($mmsg)","");
  //saveuinfo($sid);


  echo "<head>";
  echo "<title>Fun Alerts</title>";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
  echo "<body>";
  echo "<p align=\"center\">";
  echo "$sitename Fun Alerts,<br/>";
  echo "</p>";
  echo "<p align=\"center\">";
  echo "Please Select Your alert below:</p>";
  echo "<p align=\"center\">";

  echo "<a href=\"funalert.php?action=bitch\">Bitch Alert</a><br/>";
  echo "<a href=\"funalert.php?action=crush\">Crush Alert</a><br/>";
  echo "<a href=\"funalert.php?action=easter\">Easter Alert</a><br/>";
  echo "<a href=\"funalert.php?action=fart\">Fart Alert</a><br/>";
  echo "<a href=\"funalert.php?action=freak\">Freak Alert</a><br/>";
  echo "<a href=\"funalert.php?action=fuck\">Fuck Alert</a><br/>";
  echo "<a href=\"funalert.php?action=hug\">Hug Alert</a><br/>";
  echo "<a href=\"funalert.php?action=idiot\">Idiot Alert</a><br/>";
  echo "<a href=\"funalert.php?action=love\">Love Alert</a><br/>";
  echo "<a href=\"funalert.php?action=valentine\">Valentine Alert</a><br/>";
  echo "<a href=\"funalert.php?action=weirdo\">Weirdo Alert</a><br/>";
  echo "<a href=\"funalert.php?action=whip\">Whip Alert</a><br/>";
  echo "<a href=\"funalert.php?action=xmas\">Xmas Alert</a><br/>";



  echo "<br/><a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p>";
  echo "</body>";
   exit();
    }


if($action=="bitch")
{
  addvisitor();
  $mmsg = htmlspecialchars(getsetmood(getuid_sid($sid)));
  addonline(getuid_sid($sid),"Fun Alerts ($mmsg)","");
  //saveuinfo($sid);


  echo "<head>";
  echo "<title>Fun Alerts</title>";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
  echo "<body>";
  echo "<p align=\"center\">";
  echo "$sitename Fun Alerts,<br/>";
  echo "</p>";




    echo "<p align=\"center\">";
    $whonick = getnick_uid($who);
    echo "<b>Send Bitch Alert to who ?</b>";
    echo "<form action=\"inbxproc.php?action=sendfun\" method=\"post\">";
    echo "User: <input name=\"who\" format=\"*x\" maxlength=\"15\"/><br/>";
    echo "<input name=\"pmtext\" TYPE=\"hidden\" VALUE=\"BITCH ALERT - I think ur a fucking total BITCH and to get a grip comprendy BITCH\"/><br/>";
    echo "<center><input type=\"Submit\" Name=\"Submit\" Value=\"Send\"></center></form>";
    echo "</p>";    


  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p>";
  echo "</body>";
   exit();
    }


else if($action=="crush")
{
  addvisitor();
   $mmsg = htmlspecialchars(getsetmood(getuid_sid($sid)));
  addonline(getuid_sid($sid),"Fun Alerts ($mmsg)","");
  //saveuinfo($sid);


  echo "<head>";
  echo "<title>Fun Alerts</title>";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
  echo "<body>";
  echo "<p align=\"center\">";
  echo "$sitename Fun Alerts,<br/>";
  echo "</p>";




    echo "<p align=\"center\">";
    $whonick = getnick_uid($who);
    echo "<b>Send Crush Alert to who ?</b>";
    echo "<form action=\"inbxproc.php?action=sendfun\" method=\"post\">";
    echo "User: <input name=\"who\" format=\"*x\" maxlength=\"15\"/><br/>";
    echo "<input name=\"pmtext\" TYPE=\"hidden\" VALUE=\"CRUSH ALERT - I just wanna say i have a lil crush on ya and cant stop thinking about u :) (inlove)\"/><br/>";
    echo "<center><input type=\"Submit\" Name=\"Submit\" Value=\"Send\"></center></form>";
    echo "</p>";    


  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p>";
  echo "</body>";
   exit();
    }

else if($action=="easter")
{
  addvisitor();
   $mmsg = htmlspecialchars(getsetmood(getuid_sid($sid)));
  addonline(getuid_sid($sid),"Fun Alerts ($mmsg)","");
  //saveuinfo($sid);


  echo "<head>";
  echo "<title>Fun Alerts</title>";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
  echo "<body>";
  echo "<p align=\"center\">";
  echo "$sitename Fun Alerts,<br/>";
  echo "</p>";




    echo "<p align=\"center\">";
    $whonick = getnick_uid($who);
    echo "<b>Send Easter Alert to who ?</b>";
    echo "<form action=\"inbxproc.php?action=sendfun\" method=\"post\">";
    echo "User: <input name=\"who\" format=\"*x\" maxlength=\"15\"/><br/>";
    echo "<input name=\"pmtext\" TYPE=\"hidden\" VALUE=\"EASTER ALERT - I'd just like to wish you a very happy easter and tell you not to eat too much chocolate and wers mine (wink) (egg)\"/><br/>";
    echo "<center><input type=\"Submit\" Name=\"Submit\" Value=\"Send\"></center></form>";
    echo "</p>";    


  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p>";
  echo "</body>";
   exit();
    }

else if($action=="fart")
{
  addvisitor();
   $mmsg = htmlspecialchars(getsetmood(getuid_sid($sid)));
  addonline(getuid_sid($sid),"Fun Alerts ($mmsg)","");
  //saveuinfo($sid);


  echo "<head>";
  echo "<title>Fun Alerts</title>";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
  echo "<body>";
  echo "<p align=\"center\">";
  echo "$sitename Fun Alerts,<br/>";
  echo "</p>";




    echo "<p align=\"center\">";
    $whonick = getnick_uid($who);
    echo "<b>Send Fart Alert to who ?</b>";
    echo "<form action=\"inbxproc.php?action=sendfun\" method=\"post\">";
    echo "User: <input name=\"who\" format=\"*x\" maxlength=\"15\"/><br/>";
    echo "<input name=\"pmtext\" TYPE=\"hidden\" VALUE=\"FART ALERT - I'm just let one rip in ur face.Wat a stinking rotter i am.lol\"/><br/>";
    echo "<center><input type=\"Submit\" Name=\"Submit\" Value=\"Send\"></center></form>";
    echo "</p>";    


  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p>";
  echo "</body>";
   exit();
    }

else if($action=="freak")
{
  addvisitor();
   $mmsg = htmlspecialchars(getsetmood(getuid_sid($sid)));
  addonline(getuid_sid($sid),"Fun Alerts ($mmsg)","");
  //saveuinfo($sid);


  echo "<head>";
  echo "<title>Fun Alerts</title>";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
  echo "<body>";
  echo "<p align=\"center\">";
  echo "$sitename Fun Alerts,<br/>";
  echo "</p>";




    echo "<p align=\"center\">";
    $whonick = getnick_uid($who);
    echo "<b>Send Freak Alert to who ?</b>";
    echo "<form action=\"inbxproc.php?action=sendfun\" method=\"post\">";
    echo "User: <input name=\"who\" format=\"*x\" maxlength=\"15\"/><br/>";
    echo "<input name=\"pmtext\" TYPE=\"hidden\" VALUE=\"FREAK ALERT - I think ur a whacko freak and ur losing it. (freak)\"/><br/>";
    echo "<center><input type=\"Submit\" Name=\"Submit\" Value=\"Send\"></center></form>";
    echo "</p>";    


  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p>";
  echo "</body>";
   exit();
    }

else if($action=="fuck")
{
  addvisitor();
   $mmsg = htmlspecialchars(getsetmood(getuid_sid($sid)));
  addonline(getuid_sid($sid),"Fun Alerts ($mmsg)","");
  //saveuinfo($sid);


  echo "<head>";
  echo "<title>Fun Alerts</title>";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
  echo "<body>";
  echo "<p align=\"center\">";
  echo "$sitename Fun Alerts,<br/>";
  echo "</p>";




    echo "<p align=\"center\">";
    $whonick = getnick_uid($who);
    echo "<b>Send Fuck Alert to who ?</b>";
    echo "<form action=\"inbxproc.php?action=sendfun\" method=\"post\">";
    echo "User: <input name=\"who\" format=\"*x\" maxlength=\"15\"/><br/>";
    echo "<input name=\"pmtext\" TYPE=\"hidden\" VALUE=\"FUCK ALERT - I just want to get strip u naked caress ur sensual body before pinning u down scratching u hard and fucking u gud mmmm (fuck1)\"/><br/>";
    echo "<center><input type=\"Submit\" Name=\"Submit\" Value=\"Send\"></center></form>";
    echo "</p>";    


  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p>";
  echo "</body>";
   exit();
    }

else if($action=="hug")
{
  addvisitor();
   $mmsg = htmlspecialchars(getsetmood(getuid_sid($sid)));
  addonline(getuid_sid($sid),"Fun Alerts ($mmsg)","");
  //saveuinfo($sid);


  echo "<head>";
  echo "<title>Fun Alerts</title>";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
  echo "<body>";
  echo "<p align=\"center\">";
  echo "$sitename Fun Alerts,<br/>";
  echo "</p>";




    echo "<p align=\"center\">";
    $whonick = getnick_uid($who);
    echo "<b>Send Hug Alert to who ?</b>";
    echo "<form action=\"inbxproc.php?action=sendfun\" method=\"post\">";
    echo "User: <input name=\"who\" format=\"*x\" maxlength=\"15\"/><br/>";
    echo "<input name=\"pmtext\" TYPE=\"hidden\" VALUE=\"HUG ALERT - I'm just giving u a friendly hug because i really care about u :) (hug)\"/><br/>";
    echo "<center><input type=\"Submit\" Name=\"Submit\" Value=\"Send\"></center></form>";
    echo "</p>";    


  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p>";
  echo "</body>";
   exit();
    }

else if($action=="idiot")
{
  addvisitor();
   $mmsg = htmlspecialchars(getsetmood(getuid_sid($sid)));
  addonline(getuid_sid($sid),"Fun Alerts ($mmsg)","");
  //saveuinfo($sid);


  echo "<head>";
  echo "<title>Fun Alerts</title>";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
  echo "<body>";
  echo "<p align=\"center\">";
  echo "$sitename Fun Alerts,<br/>";
  echo "</p>";




    echo "<p align=\"center\">";
    $whonick = getnick_uid($who);
    echo "<b>Send Idiot Alert to who ?</b>";
    echo "<form action=\"inbxproc.php?action=sendfun\" method=\"post\">";
    echo "User: <input name=\"who\" format=\"*x\" maxlength=\"15\"/><br/>";
    echo "<input name=\"pmtext\" TYPE=\"hidden\" VALUE=\"IDIOT ALERT - I think ur an IDIOT so stop annoying me (idiot)\"/><br/>";
    echo "<center><input type=\"Submit\" Name=\"Submit\" Value=\"Send\"></center></form>";
    echo "</p>";    


  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p>";
  echo "</body>";
   exit();
    }

else if($action=="love")
{
  addvisitor();
   $mmsg = htmlspecialchars(getsetmood(getuid_sid($sid)));
  addonline(getuid_sid($sid),"Fun Alerts ($mmsg)","");
  //saveuinfo($sid);


  echo "<head>";
  echo "<title>Fun Alerts</title>";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
  echo "<body>";
  echo "<p align=\"center\">";
  echo "$sitename Fun Alerts,<br/>";
  echo "</p>";




    echo "<p align=\"center\">";
    $whonick = getnick_uid($who);
    echo "<b>Send Love Alert to who ?</b>";
    echo "<form action=\"inbxproc.php?action=sendfun\" method=\"post\">";
    echo "User: <input name=\"who\" format=\"*x\" maxlength=\"15\"/><br/>";
    echo "<input name=\"pmtext\" TYPE=\"hidden\" VALUE=\"LOVE ALERT - (2hearts) I want u to know how much i love u (heartbeat) and that u r my dream lover and want to be part of ur life.Make my day with 4 lil words I LOVE U TO.(2hearts)\"/><br/>";
    echo "<center><input type=\"Submit\" Name=\"Submit\" Value=\"Send\"></center></form>";
    echo "</p>";    


  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p>";
  echo "</body>";
   exit();
    }

else if($action=="valentine")
{
  addvisitor();
   $mmsg = htmlspecialchars(getsetmood(getuid_sid($sid)));
  addonline(getuid_sid($sid),"Fun Alerts ($mmsg)","");
  //saveuinfo($sid);


  echo "<head>";
  echo "<title>Fun Alerts</title>";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
  echo "<body>";
  echo "<p align=\"center\">";
  echo "$sitename Fun Alerts,<br/>";
  echo "</p>";




    echo "<p align=\"center\">";
    $whonick = getnick_uid($who);
    echo "<b>Send Valentine Alert to who ?</b>";
    echo "<form action=\"inbxproc.php?action=sendfun\" method=\"post\">";
    echo "User: <input name=\"who\" format=\"*x\" maxlength=\"15\"/><br/>";
    echo "<input name=\"pmtext\" TYPE=\"hidden\" VALUE=\"VALENTINE ALERT - Today is a very special day so i have sent this alert just to say Darling be forever mine i love u sexy Be my Valentine  x x x (rose)\"/><br/>";
    echo "<center><input type=\"Submit\" Name=\"Submit\" Value=\"Send\"></center></form>";
    echo "</p>";    


  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p>";
  echo "</body>";
   exit();
    }

else if($action=="weirdo")
{
  addvisitor();
   $mmsg = htmlspecialchars(getsetmood(getuid_sid($sid)));
  addonline(getuid_sid($sid),"Fun Alerts ($mmsg)","");
  //saveuinfo($sid);


  echo "<head>";
  echo "<title>Fun Alerts</title>";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
  echo "<body>";
  echo "<p align=\"center\">";
  echo "$sitename Fun Alerts,<br/>";
  echo "</p>";




    echo "<p align=\"center\">";
    $whonick = getnick_uid($who);
    echo "<b>Send Weirdo Alert to who ?</b>";
    echo "<form action=\"inbxproc.php?action=sendfun\" method=\"post\">";
    echo "User: <input name=\"who\" format=\"*x\" maxlength=\"15\"/><br/>";
    echo "<input name=\"pmtext\" TYPE=\"hidden\" VALUE=\"WEIRDO ALERT - I think youre a weirdo...(hahaha) you probably are too (weirdo)\"/><br/>";
    echo "<center><input type=\"Submit\" Name=\"Submit\" Value=\"Send\"></center></form>";
    echo "</p>";    


  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p>";
  echo "</body>";
   exit();
    }

else if($action=="whip")
{
  addvisitor();
   $mmsg = htmlspecialchars(getsetmood(getuid_sid($sid)));
  addonline(getuid_sid($sid),"Fun Alerts ($mmsg)","");
  //saveuinfo($sid);


  echo "<head>";
  echo "<title>Fun Alerts</title>";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
  echo "<body>";
  echo "<p align=\"center\">";
  echo "$sitename Fun Alerts,<br/>";
  echo "</p>";




    echo "<p align=\"center\">";
    $whonick = getnick_uid($who);
    echo "<b>Send Whip Alert to who ?</b>";
    echo "<form action=\"inbxproc.php?action=sendfun\" method=\"post\">";
    echo "User: <input name=\"who\" format=\"*x\" maxlength=\"15\"/><br/>";
    echo "<input name=\"pmtext\" TYPE=\"hidden\" VALUE=\"WHIP ALERT - I wanna give u a Hell of a gud whipping.Now be a gud Bitch and obey me. (whip3)\"/><br/>";
    echo "<center><input type=\"Submit\" Name=\"Submit\" Value=\"Send\"></center></form>";
    echo "</p>";    


  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p>";
  echo "</body>";
   exit();
    }

else if($action=="xmas")
{
  addvisitor();
   $mmsg = htmlspecialchars(getsetmood(getuid_sid($sid)));
  addonline(getuid_sid($sid),"Fun Alerts ($mmsg)","");
  //saveuinfo($sid);


  echo "<head>";
  echo "<title>Fun Alerts</title>";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
  echo "</head>";
  echo "<body>";
  echo "<p align=\"center\">";
  echo "$sitename Fun Alerts,<br/>";
  echo "</p>";




    echo "<p align=\"center\">";
    $whonick = getnick_uid($who);
    echo "<b>Send Xmas Alert to who ?</b>";
    echo "<form action=\"inbxproc.php?action=sendfun\" method=\"post\">";
    echo "User: <input name=\"who\" format=\"*x\" maxlength=\"15\"/><br/>";
    echo "<input name=\"pmtext\" TYPE=\"hidden\" VALUE=\"XMAS ALERT - I want to wish u a happy crimbo and hopes satanclaus is gud to u.Have a great day of fun.(xmas)\"/><br/>";
    echo "<center><input type=\"Submit\" Name=\"Submit\" Value=\"Send\"></center></form>";
    echo "</p>";    


  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a>";
  echo "</p>";
  echo "</body>";
   exit();
    }


?>
</html>
