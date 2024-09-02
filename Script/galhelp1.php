<?php
   session_name("PHPSESSID");
session_start();
/*
|======================================================|
| http://SocialBD.NeT / http://SocialBD.NeT            |
|======================================================|
*/

include("xhtmlfunctions.php");
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
?>
<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> 
<?php
include("config.php");
include("core.php");
$bcon = connectdb();
if (!$bcon)
{
  $pstyle = gettheme($sid);
      echo xhtmlhead("Personal gallery",$pstyle);
    echo "<p align=\"center\">";
    echo "<img src=\"images/exit.gif\" alt=\"*\"/><br/>";
    echo "ERROR! cannot connect to database<br/><br/>";
    echo "This error happens usually when backing up the database, please be patient, The site will be up any minute<br/><br/>";
    echo "you can temperoray be in this site <a href=\"http://SocialBD.NeT/xhtml/chat\">$site_name</a> while $site_name is offline<br/>";
    echo "<b>THANK YOU VERY MUCH</b>";
    echo "</p>";
        echo xhtmlfoot();
    exit();
}
$brws = explode(" ",$_SERVER[HTTP_USER_AGENT] );
$ubr = $brws[0];
$uip = getip();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$page = $_GET["page"];
$who = $_GET["who"];


$uid = getuid_sid($sid);

cleardata();

if(isipbanned($uip,$ubr))
    {
      if(!isshield(getuid_sid($sid)))
      {
    $pstyle = gettheme($sid);
      echo xhtmlhead("Personal gallery",$pstyle);
      echo "<p align=\"center\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
      echo "This IP address is blocked<br/>";
      echo "<br/>";
      echo "How ever we grant a shield against IP-Ban for our great users, you can try to see if you are shielded by trying to log-in, if you kept coming to this page that means you are not shielded, so come back when the ip-ban period is over<br/><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT  timeto FROM dcroxx_me_penalties WHERE  penalty='2' AND ipadd='".$uip."' AND browserm='".$ubr."' LIMIT 1 "));
      //echo mysql_error();
      $remain =  $banto[0] - time();
      $rmsg = gettimemsg($remain);
      echo " IP: $rmsg<br/><br/>";
      
      echo "</p>";
      echo "<p>";
  echo "UserID: <input name=\"loguid\" format=\"*x\" maxlength=\"30\"/><br/>";
  echo "Password: <input type=\"password\" name=\"logpwd\"  maxlength=\"30\"/><br/>";
  echo "<anchor>LOGIN<go href=\"login.php\" method=\"get\">";
  echo "<postfield name=\"loguid\" value=\"$(loguid)\"/>";
  echo "<postfield name=\"logpwd\" value=\"$(logpwd)\"/>";
  echo "</go></anchor>";
  echo "</p>";
     echo xhtmlfoot();
      exit();
      }
   }
if(($action != "") && ($action!="terms"))
{
    $uid = getuid_sid($sid);
    if((islogged($sid)==false)||($uid==0))
    {
  $pstyle = gettheme($sid);
      echo xhtmlhead("Personal gallery",$pstyle);
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a><br/><br/>";
      echo "</p>";
         echo xhtmlfoot();
      exit();
    }
    
    
    
}
//echo isbanned($uid);
if(isbanned($uid))
    {
       $pstyle = gettheme($sid);
      echo xhtmlhead("Personal gallery",$pstyle);
      echo "<p align=\"center\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
      echo "You are <b>Banned</b><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT timeto FROM dcroxx_me_penalties WHERE uid='".$uid."' AND penalty='1'"));
	  $banres = mysql_fetch_array(mysql_query("SELECT lastpnreas FROM dcroxx_me_users WHERE id='".$uid."'"));
	  
      $remain = $banto[0]- time();
      $rmsg = gettimemsg($remain);
      echo "Time to finish your penalty: $rmsg<br/><br/>";
	  echo "Ban Reason: $banres[0]";
      //echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
      echo xhtmlfoot();
      exit();
    }

///////////////////////////////GOLDLINEHOST//////////BY GLH WEB CREATION/////////
?>
<?php
//////////////////////////////////gallery List

if($action=="main")

 addonline(getuid_sid($sid),"personal Gallery","");
   $pstyle = gettheme($sid);
      echo xhtmlhead("Personal gallery",$pstyle);
	  echo "<p><small>";
	  echo "
+ Rename the photo before uploading.<br/>
+ U can upload only ur own photos,ur family, friends photos here!<br/>
+ Dont upload other photos like animals, graphic, cartoons, actors etc..<br/>

+ If u cant see browsing file options, that means ur mobile doesnt support uploading photos<br/>
+ After u upload a photo if u won't get a msg <b> file has been successfully uploaded </b>
that means ur photo hasnt been added to gallery. So in a time like that , try to upload same photo 3 or 4 times till it gets uploaded sussesfully..<br/>
+ Try to upload photo size below 50kb in jpeg(jpg) format<br/>
+ uploading photos take a few time. unlill then plz wait<br/>

+ if u break these tearms, it will be cozes to delete ur account.<br/>
+ if have any Questions pm to <b>FardIn420</b>
<br/>----------<br/>";
echo "<a href=\"uploada.php?action=uploader&amp;who=$who\">OK, I AGREE</a><br/>";
echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</small></p>";
    echo xhtmlfoot();

?>
