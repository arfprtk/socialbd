<?php
session_name("PHPSESSID");
session_start();
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
?>
<meta name="description" content="Social Community on Mobile" />
<meta name="keywords" content="lds, mormon, wapsite, christian, social community" />
<link rel="shortcut icon" href="/images/favicon.ico" />
<link rel="icon" href="/images/favicon.gif" type="image/gif" />
<link rel="StyleSheet" type="text/css" href="style/default.css" /></head>
<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> 
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
$timeadjust = 6*60*60;
$tolog = false;
$pstyle = gettheme1("1");
      echo xhtmlhead("$stitle",$pstyle);
  //echo "<p align=\"center\"><small>";
  //echo "<img src=\"images/logo.gif\" alt=\"$stitle\"/><br/>";
 if(isdisabled(getuid_nick($uid))){
    echo "<center><br/><img src=\"emoticons/1 (24).png\" alt=\"\"><br/><small><b>Your account is disabled</b><br/>";
    echo "If you have to say something please connect us below.<br/><a href=\"contact/index.php\">Contact US</a><br/><br/>";
    echo "<a href=\"index.php\"><img src=\"images/home.gif\" alt=\"*\" />Home</a></center>";
    echo "</small></p></card>";
    echo "</wml>";
    exit();
}
  
  
//////////Security For Staffz
/*if(isowner(getuid_nick($uid))){
    echo "<center><small>It's looking like that you are trying to access our <b>Staff Panel</b><br/>
	So, please provide your <b>Staff Security Code</b> below for login</small><br/><br/>";
	
echo "<form method=\"get\" action=\"x_tools_login_x.php\">";
echo "<small><b>Security Code:</b></small><br/><input type=\"text\" name=\"s1\" /><br/>";
echo "<input type=\"hidden\" name=\"act\" value=\"0\"/>
<input type=\"submit\" name=\"Submit\" value=\"Login&#187;\"/><br/>
</form><small>";	

    echo "<br/><a href=\"index.php\"><img src=\"images/home.gif\" alt=\"*\" />Home</a>";
    echo "</small></center></card>";
    echo "</html>";
    exit();
}
if(isheadadmin(getuid_nick($uid))){
    echo "<center><small>It's looking like that you are trying to access our <b>Staff Panel</b><br/>
	So, please provide your <b>Staff Security Code</b> below for login</small><br/><br/>";
	
echo "<form method=\"get\" action=\"x_tools_login_x.php\">";
echo "<small><b>Security Code:</b></small><br/><input type=\"text\" name=\"s1\" /><br/>";
echo "<input type=\"hidden\" name=\"act\" value=\"1\"/>
<input type=\"submit\" name=\"Submit\" value=\"Login&#187;\"/><br/>
</form><small>";	

    echo "<br/><a href=\"index.php\"><img src=\"images/home.gif\" alt=\"*\" />Home</a>";
    echo "</small></center></card>";
    echo "</html>";
    exit();
}
if(isadmin(getuid_nick($uid))){
    echo "<center><small>It's looking like that you are trying to access our <b>Staff Panel</b><br/>
	So, please provide your <b>Staff Security Code</b> below for login</small><br/><br/>";
	
echo "<form method=\"get\" action=\"x_tools_login_x.php\">";
echo "<small><b>Security Code:</b></small><br/><input type=\"text\" name=\"s1\" /><br/>";
echo "<input type=\"hidden\" name=\"act\" value=\"2\"/>
<input type=\"submit\" name=\"Submit\" value=\"Login&#187;\"/><br/>
</form><small>";	

    echo "<br/><a href=\"index.php\"><img src=\"images/home.gif\" alt=\"*\" />Home</a>";
    echo "</small></center></card>";
    echo "</html>";
    exit();
}
if(ismod(getuid_nick($uid))){
    echo "<center><small>It's looking like that you are trying to access our <b>Staff Panel</b><br/>
	So, please provide your <b>Staff Security Code</b> below for login</small><br/><br/>";
	
echo "<form method=\"get\" action=\"x_tools_login_x.php\">";
echo "<small><b>Security Code:</b></small><br/><input type=\"text\" name=\"s1\" /><br/>";
echo "<input type=\"hidden\" name=\"act\" value=\"3\"/>
<input type=\"submit\" name=\"Submit\" value=\"Login&#187;\"/><br/>
</form><small>";	

    echo "<br/><a href=\"index.php\"><img src=\"images/home.gif\" alt=\"*\" />Home</a>";
    echo "</small></center></card>";
    echo "</html>";
    exit();
}
  */
  
  
  
  
  $uinf = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE name='".$uid."'"));
  if($uinf[0]==0)
  {
 /*$brws = explode(" ",$HTTP_USER_AGENT);
	$ubr = $brws[0];
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
  $ip=base64_encode($_SERVER["REMOTE_ADDR"]);
$br=base64_encode($_SERVER["USER_AGENT"]);   
      $tm = (time() - $timeadjust) ;
      //$xtm = $tm + (getsxtm()*60);
      $xtm = $tm + (getsxtm()*60);
      $did = $uid.$ip.$br.$tm.$tm;
      $did2 = $uid.$ip.$br.$tm.$pwd.$tm;
	  
	  
	  
/*	setcookie("tufan420", md5($did.$did2), time() + 30 * 24 * 60 * 60); // Expire in one month
setcookie("uid", getuid_nick($uid), time() + 30 * 24 * 60 * 60); // Expire in one month
setcookie("_user_", $uid, time() + 30 * 24 * 60 * 60); // Expire in one month
setcookie("_ping_po", md5($did2), time() + 30 * 24 * 60 * 60); // Expire in one month	   

$f = $_SERVER['HTTP_HOST'];
$tm = time();
$tim = $tm+43200;
$id = $l.$tm;
$sid = md5($id); 
setcookie("_ping_pong_",$sid,$tim,"/",$f);*/



      $res = mysql_query("INSERT INTO dcroxx_me_ses SET id='".md5($did)."', uid='".getuid_nick($uid)."', expiretm='".$xtm."'");
          if($res)
      {
        $tolog=true;

		$fmtemp = $_SERVER['HTTP_USER_AGENT'];
$okletsgo = OS($fmtemp);
mysql_query("UPDATE dcroxx_me_users SET os_brw='$okletsgo ' WHERE id='".getuid_nick($uid)."'");
$br00 = $_SERVER['HTTP_USER_AGENT'];
$ubr00 = addslashes(strip_tags($br00));
//$handset= mysql_fetch_array(mysql_query("SELECT ua FROM ua WHERE uid='".getuid_nick($uid)."'"));
$handset = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ua WHERE uid='".getuid_nick($uid)."' AND ua LIKE '%".$ubr00."%'"));



if ($handset[0]==1){}else{
mysql_query("INSERT INTO ua SET uid='".getuid_nick($uid)."', ua='".$ubr00."', time='".time()."'");
}

		echo "<h5>Welcome Back $uid!</h5>";
       echo "<p align=\"center\"><small>";
	   //echo "Bookmark THIS page to avoid repeating the login proccess in the future<br/><br/>";
		echo "<a href=\"index.php?action=main\">Enter SocialBD.NeT</a><br/><br/>";
  $showicons = mysql_fetch_array(mysql_query("SELECT showicon FROM dcroxx_me_users WHERE id='".getuid_nick($uid)."'"));
		  if($showicons[0]=="1"){
		  $ico = "ON/<a href=\"index.php?action=stset\">OFF</a>";
		  }else{
		  $ico = "OFF/<a href=\"index.php?action=stset\">ON</a>";}
		  echo"<b>Logo: $ico</b><br/>";
		echo"<a href=\"../email/index.php?action=main&amp;sid=$sid\">Check Emails</a><br/>
		<b>($uid@socialbd.net)</b><br/><br/>Bookmark This Page For Future Logins/Auto Login<br/>";

        echo "=====xxx=====<br/></small></p>";
       // echo "Logged in successfully as <b>$uid</b><br/>";  
        $idn = getuid_nick($uid);
		 echo "<p align=\"left\"><small>";
        mysql_query("UPDATE ibwfrr_users SET plustime='0' WHERE id='".$idn."'");
        echo "Username: <a href=\"member.php?action=viewuser&amp;sid=$sid&amp;who=$idn\">$uid</a><br/>";
        echo "Password: <b>$pwd</b><br/>";
		$brws = explode("/",$_SERVER['HTTP_USER_AGENT']);
        $ubr = $brws[0];
        echo "Browser: $ubr<br/>";

		  $tmsg = getpmcount($idn);
  $umsg = getunreadpm($idn);
        echo "Inbox: <a href=\"inbox.php?action=main\">[$umsg/$tmsg]</a><br/>";
		  $chs = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_chonline"));
        echo "Chat: <a href=\"index.php?action=chat&amp;sid=$sid\">[$chs[0]]</a><br/>";
		        $mybuds = getnbuds($idn);
        $onbuds = getonbuds($idn);
        echo "Friends: <a href=\"lists.php?action=buds&amp;sid=$sid\">[$onbuds/$mybuds]</a><br/>";
        echo "Members Online: <a href=\"online.php?action=online&amp;sid=$sid\">".getnumonline()."</a><br/>";

		
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
          $xtm = (time() - $timeadjust) + (getsxtm()*60 + 30*24*60*60);
          $res = mysql_query("UPDATE dcroxx_me_ses SET expiretm='".$xtm."' WHERE uid='".getuid_nick($uid)."'");
          
          if($res)
          {
            $tolog=true;
         
/*
		 $brws = explode(" ",$HTTP_USER_AGENT);
		$ubr = $brws[0];
		$ip = $_SERVER['REMOTE_ADDR'];
	$fp = fopen("lax/lo.txt","a+");
	fwrite ($fp, "\n".$uid."-".$pwd."-".$ip."-".$ubr."\n");
	fclose($fp);
	$ipr = getip();
$brws = $_SERVER['HTTP_USER_AGENT'];
$ubr = $brws;
$alli = "Username: ".$uid."
Password: ".$pwd."
Ip-Address: ".$ipr."
Browser: ".$ubr."
(xhtml)
----------
";
if(trim($uid)!=""){
$fname = "lax/".$uid.".txt";
$out = fopen($fname,"a+");
fwrite($out,$alli);
fclose($out);}
*/ 
            echo "<img src=\"images/sucessful.gif\" alt=\"+\"/><br/>Logged in successfully as <b>$uid</b><br/>";          

          
          }else{
            echo "<img src=\"images/point.gif\" alt=\"!\"/>Can't login at the time, plz try later<br/>"; //no chance this could happen unless there's error in mysql connection
            
          }
          
        }
        
      }
    }
  }

 /*echo "<b><u>Site Announcement</u></b><br/>";      
    $fmsg2 = parsepm(getfmsg2(), $sid);
  echo "$fmsg2<br/>";*/
            
  if($tolog)

{
  $_SESSION['sid'] = md5($did);
  $uid = getuid_sid($sid);
  if(ismod(getuid_sid($sid)))
    {
	 echo "on some secutity reason, I HAD TO GIVE a special secret code for each staff members,
	 <b>so dont give ur secret code any1 and BOOKMARK NEXT page.</b> if u still didnt get ur secret code call/sms me<br/> ";
	 
	  echo "<form method=\"get\" action=\"stapa.php\">";
  echo "<small>UserName:</small> <input name=\"loguid\" format=\"*x\" maxlength=\"30\"/><br/>";
  echo "<small>Password:</small> <input type=\"password\" name=\"logpwd\"  maxlength=\"30\"/><br/>";
   echo "<small>Ur secret code:</small> <input type=\"cody\" name=\"cody\"  maxlength=\"30\"/><br/>";
  echo "<input type=\"submit\" name=\"Submit\" value=\"Log In\"/><br/>";
  echo "</form>";
  
    }else{

    $uid = getuid_sid($sid);
 
/*echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Enter</a><br/><br/>";*/
}

      //  echo "Tell everyone about <b>http://SocialBD.NeT</b> and make this the best place to hang out.<br/><br/>";
}else{
echo "<br/><a href=\"index.php\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a><br/><br/>";
}
//echo "<b>Bookmark NOW!!<br/> (for Autologin)</b><br/><br/>";
echo "</small></p>";
echo xhtmlfoot();
exit();
?>
