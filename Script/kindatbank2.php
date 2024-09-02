<?php

    session_name("PHPSESSID");
session_start();

header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\"\"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\">";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";

	echo "<head>";

	echo "<title></title>";
	echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/style.css\" />
	<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";
	echo "</head>";
include("core.php");
include("config.php");
	echo "<body>";
$bcon = connectdb();
if (!$bcon)
{
    echo "<card id=\"main\" title=\"DATABASE Error!\">";
    echo "<p align=\"center\">";
    echo "Site is busy<br/><br/>";
    echo "Our database is busy. Please try again later!<br/><br/>";
    echo "</p>";
    echo "</body>";
    echo "</html>";
    exit();
}
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$pass = $_GET["pass"];
$uid = getuid_sid($sid);
if($action != "")
{
    if(islogged($sid)==false)
    {
         echo "<card id=\"main\" title=\"\">";
      echo "<p align=\"left\">";
   
      echo "Your session has been expired<br/>";
 echo "<a href=\"index.php\">Login</a>";
  echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
  
    }
}
if(isbanned($uid))
    {
        echo "<card id=\"main\" title=\"\">";
      echo "<p align=\"center\">";
     echo "<img src=\"images/exit2.gif\" alt=\"*\"/><br/>";
      echo "You are <b>Banned</b><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT timeto FROM dcroxx_me_penalties WHERE uid='".$uid."' AND penalty='1'"));
      $remain = $banto[0]- time();
      $rmsg = gettimemsg($remain);
      echo "Time to finish your penalty: $rmsg<br/><br/>";
      //echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
 $passworded = mysql_fetch_array(mysql_query("SELECT pass FROM dcroxx_me_bank WHERE uid='".$uid."'"));
    if($passworded[0]!="")
    {
      if($pass!=$passworded[0])
      {
        echo "<card id=\"main\" title=\"\">";
      echo "<p align=\"center\">";
      echo "System could not process incorrect password!<br/>";
      echo "<a href=\"index.php?action=main&amp;type=send\">";
echo "Main menu</a>";
       echo "<br/>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
      }
    }
if($action=="")
{
  addonline(getuid_sid($sid),"","");
  echo "<card id=\"main\" title=\"\">";
    echo "<p align=\"center\">";
$noi = mysql_fetch_array(mysql_query("SELECT plusses, plusses2 FROM dcroxx_me_bank WHERE uid='".$uid."'"));
$jdt = date("D,d,M,y-h:i:s a");
echo "Total Deposited plusses:<b>$noi[0]</b><br/>";  
echo "Latest withdraw Plusses:<b>$noi[1]</b><br/>";
echo "</p>";
echo "<p align=\"left\">";
echo "<a href=\"kindatbank2.php?action=with&amp;uid=$uid&amp;pass=$pass\">Withdraw</a><br/>";
echo "<a href=\"kindatbank2.php?action=dep&amp;uid=$uid&amp;pass=$pass\">Deposit</a><br/>";
echo "</p><p align=\"center\">"; 
echo "<a href=\"index.php?action=main&amp;type=send\">";
echo "Main menu</a>";
  echo "</p>";
    echo "</body>";
   exit();
    }
////////////////////////////////////////////////////
else if($action=="reg")
{
    addonline(getuid_sid($sid),"Creating Bank Account","index.php?action=main");
    echo "<card id=\"main\" title=\"Creating Bank Account\">";
    echo "<p align=\"center\">";
  echo "<input format=\"*x\" name=\"rpw\" maxlength=\"10\"/><br/>";
              echo "<anchor>SEND <go href=\"kindatbank.php?action=reg2&amp;type=send\" method=\"post\">";
             
              echo "<postfield name=\"rpw\" value=\"$(rpw)\"/>";
              echo "</go></anchor><br/>";
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
   
    echo "<a href=\"index.php?action=main&amp;type=send\">";
echo "Main menu</a>";
  echo "</p>";
    echo "</body>";
   exit();
    }
/////////////////////////////////////////////////////Give Plusses

else if($action=="dep")
{
  addonline(getuid_sid($sid),"Deposit","index.php?action=main");
    echo "<card id=\"main\" title=\"\">";
  echo "<p align=\"center\">";

echo "<form action=\"kindatbank2.php?action=dep2&amp;uid=$uid&amp;pass=$pass\" method=\"post\">";
 echo "Amount to deposit:<input name=\"ptg\" format=\"*N\" maxlength=\"10\"/><br/>";
echo "<input type=\"submit\" value=\"GO\"/>";  
echo "</form>";
  echo "<br/><br/><a href=\"index.php?action=main&amp;type=send\">";
echo "Main menu</a>";
  echo "</p>";
  echo "</body>";
   exit();
    }
/////////////////////////////////////////////////////Give Plusses

else if($action=="with")
{
  addonline(getuid_sid($sid),"Deposit","index.php?action=main");
    echo "<card id=\"main\" title=\"\">";
  echo "<p align=\"center\">";
 
echo "<form action=\"kindatbank2.php?action=with2&amp;uid=$uid&amp;pass=$pass\" method=\"post\">";
 echo "Amount to withdraw:<input name=\"ptg\" format=\"*N\" maxlength=\"10\"/><br/>";
echo "<input type=\"submit\" value=\"GO\"/>";  
echo "</form>";
  echo "<br/><br/><a href=\"index.php?action=main&amp;type=send\">";
echo "Main menu</a>";
  echo "</p>";
  echo "</body>";
   exit();
    }
/////////////////////////////////////////////////////Give Plusses
else if($action=="dep2")
{
    addonline(getuid_sid($sid),"Depositing","index.php?action=main");
    $who = $_GET["who"];
    $ptg = trim($_POST["ptg"]);
    echo "<card id=\"main\" title=\"\">";
  echo "<p align=\"center\">";
  //$uid = getuid_sid($sid);
  if(isdigitf3($ptg))
{
        echo "<card id=\"main\" title=\"\">";
      echo "<p align=\"center\">";
        echo "Write the correct amount amount!<br/>";
  echo "<a href=\"index.php?action=main&amp;type=send&amp;browse?start\">";
  echo "Main menu</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
$uid = getuid_sid($sid);
if(($ptg==""))
        {
          echo "Dont leave them blank!";
        }else{
if($ptg<=99)
{
   echo "100 minimum deposit<br/>";
 }else{
if($ptg>=1001)
{
   echo "1000 maximum deposit!<br/>";
 }else{

$unick = getnick_uid($who);
  $psf = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
  $npl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_bank WHERE uid='".$uid."'"));
  if($psf[0]>=$ptg){
    $psf = $psf[0]-$ptg;
    $npl1 = $npl[0]+$ptg;
   $npl2 = $npl1/100;
   $npl3 = $npl2+$npl1+50;
    $res = mysql_query("UPDATE dcroxx_me_bank SET plusses='".$npl3."' WHERE uid='".$uid."'");
    if($res)
            {
            if($tdo==1)
            {
              $msg = "sent";
            }else{
                $msg = "sent";
            }
         mysql_query("INSERT INTO dcroxx_me_banktime SET uid='".$uid."', actime='".time()."'");
         $res = mysql_query("UPDATE dcroxx_me_users SET plusses='".$psf."' WHERE id='".$uid."'");
           echo "Done! Thank you for banking<br/>";
            $msg = "".getnick_uid(getuid_sid($sid))."thank you for banking"."[br/][small]Note: Please don't share this account to anyone![/small]";
			autopm($msg, $uid);
        }else{
          echo "Database Error!<br/>";
        }
      }else{
         $nopl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".getuid_sid($sid)."'"));
       echo "Your dont have enough plusses to deposit!<br/>";
        }
      }
}
}

echo "<br/>";
  echo "<a href=\"kindatbank2.php?action=&amp;uid=$uid&amp;pass=$pass\">Bank main</a><br/>";
     echo "<a href=\"index.php?action=main&amp;type=send\">";
echo "Main menu</a>";
echo "</p>";
  echo "</body>";
   exit();
    }
//////////////////////////////////////////////////////Give Plusses
else if($action=="with2")
{
    addonline(getuid_sid($sid),"Withdrawing","index.php?action=main");
    $who = $_GET["who"];
    $ptg = trim($_POST["ptg"]);
    echo "<card id=\"main\" title=\"\">";
  echo "<p align=\"center\">";
  //$uid = getuid_sid($sid);
  if(isdigitf3($ptg))
{
        echo "<card id=\"main\" title=\"\">";
      echo "<p align=\"center\">";
        echo "Write the correct amount amount!<br/>";
  echo "<a href=\"index.php?action=main&amp;type=send&amp;browse?start\">";
  echo "Main menu</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
if(($ptg==""))
        {
          echo "Dont leave them blank!";
        }else{
if($ptg<=99)
{
   echo "100 minimum withdraw<br/>";
 }else{
if($ptg>=1001)
{
   echo "1000 maximum withdraw!<br/>";
 }else{
             $actime = mysql_fetch_array(mysql_query("SELECT actime FROM dcroxx_me_banktime WHERE uid='".$uid."' ORDER BY actime DESC LIMIT 1"));
		$timeout = $actime[0] + (60*60);
		if(time()<$timeout)
		{
                $actime2 = $actime[0];
                $remain = time() - $actime2;
           
$days = floor($remain / (60 * 60 * 24));
$remainder = $remain % (60 * 60 * 24);
$hours = floor($remainder / (60 * 60));
$remainder = $remainder % (60 * 60);
$minutes = floor($remainder / 60);
$seconds = $remainder % 60;	
echo "You can withdraw after 1 hour. Your time starts now: <br/>$hours:$minutes:$seconds<br/><br/>";
		}else{
$unick = getnick_uid($who);
  $psf = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_bank WHERE uid='".$uid."'"));
  $npl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
  if($psf[0]>=$ptg){
    $psf = $psf[0]-$ptg;
    $npl = $npl[0]+$ptg;
    $res = mysql_query("UPDATE dcroxx_me_users SET plusses='".$npl."' WHERE id='".$uid."'");
    if($res)
            {
            if($tdo==1)
            {
              $msg = "sent";
            }else{
                $msg = "sent";
            }
          
    $res = mysql_query("UPDATE dcroxx_me_bank SET plusses='".$psf."', plusses2='".$ptg."' WHERE uid='".$uid."'");
           echo "Your bank is now updated<br/>Thank you for banking<br/>";
           $msg = "".getnick_uid(getuid_sid($sid))."thank you for banking"."[br/][small]Note: Please don't share this account to anyone![/small]";
			autopm($msg, $uid);
        }else{
          echo "Database Error!<br/>";
        }
      }else{
         $nopl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_bank WHERE uid='".getuid_sid($sid)."'"));
        echo "Your bank account is dont have enough plusses to withdraw!<br/>";
        }
      }
}
}
}
echo "<br/>";
  echo "<a href=\"kindatbank2.php?action=&amp;uid=$uid&amp;pass=$pass\">Bank main</a><br/>";
     echo "<a href=\"index.php?action=main&amp;type=send\">";
echo "Main menu</a>";
echo "</p>";
  echo "</body>";
   exit();
    }


?>

</html>
