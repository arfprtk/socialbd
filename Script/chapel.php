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


/**
* @author:HONKYTONKMAN(Adriano)
* @re-coded from lavalair/wapdesire (i don't know how many versions..)
* @version wap2.0/xhtml
*/





include("config.php");
include("core.php");
include("xhtmlfunctions.php");
connectdb();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$page = $_GET["page"];
$who = $_GET["who"];
$uid = getuid_sid($sid);
if($action != "")
{
    if(islogged($sid)==false)
    {
      echo "<head>";
      echo "<title>Error!!!</title>";
      echo "<body bgcolor=\"#00BFFF\" link=\"#0000CC\" vlink=\"#0000CC\" alink=\"#0000CC\">";

      echo "</head>";
      
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
if(isbanned($uid))
    {
      echo "<head>";
      echo "<title>Error!!!</title>";
echo "<body bgcolor=\"#00BFFF\" link=\"#0000CC\" vlink=\"#0000CC\" alink=\"#0000CC\">";

      echo "</head>";
      
      echo "<p align=\"center\">";
      echo "<img src=\"../images/notok.gif\" alt=\"\"/><br/>";
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



//////////////ok let's start



connectdb();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$page = $_GET["page"];
$who = $_GET["who"];
$uid = getuid_sid($sid);
if($action != "")
{
    if(islogged($sid)==false)
    {
      echo "<head>";
      echo "<title></title>";
      echo "<body bgcolor=\"#00BFFF\" link=\"#0000CC\" vlink=\"#0000CC\" alink=\"#0000CC\">";

      echo "</head>";
      
      echo "<p align=\"center\">";
      echo "<br/>";
      echo "<br/>";
      echo "<a href=\"index.php\">Login</a>";


      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
}
if(isbanned($uid))
    {
      echo "<head>";
      echo "<title>Error!!!</title>";
      echo "<body bgcolor=\"#00BFFF\" link=\"#0000CC\" vlink=\"#0000CC\" alink=\"#0000CC\">";

      echo "</head>";
      
      echo "<p align=\"center\">";
      echo "<img src=\"../images/notok.gif\" alt=\"\"/><br/>";
      echo "<b>BANNING</b><br/><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT timeto, pnreas, exid FROM dcroxx_me_penalties WHERE uid='".$uid."' AND penalty='1' OR uid='".$uid."' AND penalty='2'"));
	$banres = mysql_fetch_array(mysql_query("SELECT lastpnreas FROM dcroxx_me_users WHERE id='".$uid."'"));
      $remain = $banto[0]- time();
      $rmsg = gettimemsg($remain);
      echo "<b>Time left: </b>$rmsg<br/>";
      $nick = getnick_uid($banto[2]);
	echo "<b>BY: </b>$nick<br/>";
	echo "<b>REASON: </b>$banto[1]";
      


      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
//////////////every thing good

if($action=="chapel")
{
     $pstyle = gettheme($sid);
      echo xhtmlhead("Chapel",$pstyle);
addonline(getuid_sid($sid),"chapel","");
echo "<head>";
      echo "<title></title>";
       
//echo "<body bgcolor=\"#00BFFF\" link=\"#0000CC\" vlink=\"#0000CC\" alink=\"#0000CC\">";

      echo "</head>";
      

echo "<center>";
echo "<u><b>CHAPEL</b></u><br/>";


echo "<br/><a href=\"chapel.php?action=vad\"><b>[CHAPEL]</b></a><br/>";


$couple = mysql_fetch_array(mysql_query("SELECT who, partner, req FROM couple WHERE partner='".$uid."'"));
if($couple[2]=='1')
{
$unick = getnick_uid($couple[1]);
$nick = getnick_uid($couple[0]);
$nopl = mysql_fetch_array(mysql_query("SELECT sex FROM dcroxx_me_users WHERE id='".$couple[0]."'"));
if($nopl[0]=='M')
{
$usex = "M";
}else if($nopl[0]=='F'){
$usex = "F";
}else{
$usex = "Partner";
}

echo "<b>COUPLE  $unick and $nick</b><br/><br/>";



echo "<a href=\"chapel.php?action=reqacc&amp;who=$couple[0]\"><b>YESS</b> ,i do</a><br/>";
echo "<a href=\"chapel.php?action=reqref&amp;who=$couple[1]\">NOoo, i'm not crazy</a><br/><br/>";

}else{

echo "<br/>put the nickname of the user in the field below..a inbox will alert about it<br/>";
echo "he/she could say yes or not..<br/><br/>";

$nick = getnick_sid($sid);

$whonick = getnick_uid($who);
echo "<form action=\"chapel.php?action=getreq\" method=\"post\">";
echo "NICK:<br/><input name=\"usr\" maxlength=\"25\"/><br/>";

echo "<input type=\"submit\" name=\"submit\" value=\"send\"></form><br/><br/>";
}
$rukiya = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM couple WHERE (who='".$uid."' OR partner='".$uid."') AND accept='1'"));
if ($rukiya[0]=="1")
{
echo "<br/><a href=\"chapel.php?action=div\">[DIVORCE!]</a><br/>";
}






  echo "<b></b><div><a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a></div><br/>";

echo "</center>";
echo "</body>";
exit();
}

/////////////////////////////////////////////
else if($action=="getreq")
{
     $pstyle = gettheme($sid);
      echo xhtmlhead("Chapel",$pstyle);
addonline(getuid_sid($sid),"chapel","");
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
echo "<p align=\"center\">";
$usr = $_POST["usr"];
$usr = mysql_real_escape_string($usr);
$usr = getuid_nick($usr);
$we = mysql_fetch_array(mysql_query("SELECT who, partner, accept, req FROM couple WHERE who='".$uid."'"));
if($we[2]=='1')
{


echo "<title></title>";
//echo "<body bgcolor=\"#00BFFF\" link=\"#0000CC\" vlink=\"#0000CC\" alink=\"#0000CC\">";



$wer = getnick_uid($we[1]);

echo "<br/><img src=\"../chapel/2.gif\" alt=\"\"/><br/>";
echo "ERROR, you're married with  $wer!<br/><br/>";
  echo "<b></b><div><a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a></div><br/>";




echo "</p>";
echo "</body>";
echo "</html>";
exit();
}

$me = mysql_fetch_array(mysql_query("SELECT who, partner, accept, req FROM couple WHERE partner='".$uid."'"));
if($me[2]=='1')
{
echo "<title></title>";
//echo "<body bgcolor=\"#00BFFF\" link=\"#0000CC\" vlink=\"#0000CC\" alink=\"#0000CC\">";




$sya = getnick_uid($me[0]);

echo "<br/><img src=\"../chapel/2.gif\" alt=\"\"/><br/>";
echo "ERROR, you're already married with $sya!<br/><br/>";
   echo "<a href=\"chapel.php?action=chapel\">back</a><br/><br/>";

  echo "<b></b><div><a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a></div><br/>";



echo "</p>";
echo "</body>";
echo "</html>";
exit();
}
$sex1 = mysql_fetch_array(mysql_query("SELECT sex FROM dcroxx_me_users WHERE id='".$uid."'"));
$sex2 = mysql_fetch_array(mysql_query("SELECT sex FROM dcroxx_me_users WHERE id='".$usr."'"));
if($usr==0)
{

echo "<title></title>";
//echo "<body bgcolor=\"#00BFFF\" link=\"#0000CC\" vlink=\"#0000CC\" alink=\"#0000CC\">";



echo "<br/><img src=\"../chapel/2.gif\" alt=\"\"/><br/>";

echo "nickname don't found..<br/>";
echo "try it again..<br/>";




}else if($usr==$uid)
{

echo "<title></title>";
//echo "<body bgcolor=\"#00BFFF\" link=\"#0000CC\" vlink=\"#0000CC\" alink=\"#0000CC\">";

echo "<br/><img src=\"../chapel/2.gif\" alt=\"\"/><br/>";

echo "what are you doing? do you wanna marry yourself? ehm..<br/>";




}

elseif($sex1[0]!=$sex2[0])

{

$whonick = getnick_uid($usr);
$couple = mysql_fetch_array(mysql_query("SELECT who, partner, accept, req FROM couple WHERE partner='".$usr."'"));
if($couple[2]=='1')
{
echo "<title></title>";
//echo "<body bgcolor=\"#00BFFF\" link=\"#0000CC\" vlink=\"#0000CC\" alink=\"#0000CC\">";


$sya = getnick_uid($couple[0]);

      echo "<br/><img src=\"../chapel/2.gif\" alt=\"\"/><br/>";


echo "$whonick is married with $sya. SORRY..!<br/><br/>";

echo "<br/><a href=\"chapel.php?action=chapel\">back</a><br/>";

//////////here the codes to close ELSE FUNCTION and prevent the bug that send to a already married user a request!


echo "</body>";
echo "</html>";
exit();

///////////////bug killed!
}

$byuid = getuid_sid($sid);
$tm = time();
if((!isignored($byuid, $who))&&(!istrashed($byuid)))
{
$unick = getnick_uid($uid);
$pmtext = " AUTOMATIC MESSAGE: $unick wanna marry you, goes to home ,on CHAPEL , and say yes or not";
$res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$pmtext."', byuid='".$byuid."', touid='".$usr."', timesent='".$tm."'");
}else{
$res = true;
}
if($res)
{

echo "<title></title>";
//echo "<body bgcolor=\"#00BFFF\" link=\"#0000CC\" vlink=\"#0000CC\" alink=\"#0000CC\">";

echo "<u><b>CHAPEL</b></u>";

echo "<br/><img src=\"../chapel/1.gif\" alt=\"\"/><br/>";


echo "request send to  $whonick<br/>";
echo "wait now..<br/><br/>";

mysql_query("INSERT INTO couple SET req='1', partner='".$usr."', who='".$uid."', time='".time()."'");
}else{

echo "<title></title>";
echo "<body bgcolor=\"#00BFFF\" link=\"#0000CC\" vlink=\"#0000CC\" alink=\"#0000CC\">";


echo "ERROR<br/><br/>";
}
}
else
{


echo "<title></title>";
//echo "<body bgcolor=\"#00BFFF\" link=\"#0000CC\" vlink=\"#0000CC\" alink=\"#0000CC\">";



    //  echo "<br/><img src=\"../chapel/2.gif\" alt=\"\"/><br/>";
echo "ERROR you're trying to marry<br/>";

echo "someone with your same sex..!!!..<br/>";


}
echo "<br/><a href=\"chapel.php?action=chapel\">back</a><br/>";

  echo "<b></b><div><a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a></div><br/>";




echo "</p>";
echo "</body>";
exit();
}

/////////////////////////////////////////////
else if($action=="reqacc")
{
     $pstyle = gettheme($sid);
      echo xhtmlhead("Chapel",$pstyle);
$who = $_GET["who"];
addonline(getuid_sid($sid),"chapel","");
echo "<title></title>";

//echo "<body bgcolor=\"#00BFFF\" link=\"#0000CC\" vlink=\"#0000CC\" alink=\"#0000CC\">";

echo "<p align=\"center\">";
echo "<b>CHAPEL</b><br/><br/>";
$byuid = getuid_sid($sid);
$nick = getnick_uid($uid);

   // echo "<img src=\"../chapel/1.gif\" alt=\"\"/><br/>";


echo "Congratulations! $nick ..has said YES!<br/><br/>";
$msg = "Congratulations!  $nick has said YES!";
mysql_query("INSERT INTO dcroxx_me_private SET text='".$msg."', byuid='".$byuid."', touid='".$who."', unread='1', timesent='".time()."'");
mysql_query("UPDATE couple SET accept='1', req='2', joined='".time()."' WHERE partner='".$uid."' AND who='".$who."'");

$nick = getnick_uid($who);
$byuid = getuid_sid($sid);
$unick = getnick_uid($byuid);
$fmsg = "$nick and I just get married!";
mysql_query("UPDATE dcroxx_me_users SET shouts='".$fmsg."' WHERE id='".$byuid."'");



  echo "<b></b><div><a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a></div><br/>";



echo "</p>";
echo "</body>";
exit();
}

//////////////////////////////////about

else if($action=="vad")
{
     $pstyle = gettheme($sid);
      echo xhtmlhead("Chapel",$pstyle);
    addonline(getuid_sid($sid),"chapel","");
    echo "<head>";
    echo "<title></title>";
   // echo "<body bgcolor=\"#00BFFF\" link=\"#0000CC\" vlink=\"#0000CC\" alink=\"#0000CC\">";

    echo "</head>";
    echo "<body>";
    echo "<p align=\"center\">";

//echo "<img src=\"../chapel/1.gif\" alt=\"\"/><br/>";
    echo "<b>about chapel..</b><br/>";
echo "</div><br/>";

 echo "[1]- Please Note: This Marriage IS NOT Legally Binding.<br/>";

 echo "[2]- it's only for fun,inside this community.and you can change your partner anytime you want.<br/>";
   
  echo "[3]- when you create a marriage , name of your partner will show on your profile.<br/>";






    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";


   echo "<a href=\"chapel.php?action=chapel\">back</a><br/><br/>";
   echo "<b></b><div><a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a></div><br/>";



  echo "</p>";
    echo "</body>";
exit();
}

/////////////////////////////////////////////


else if($action=="reqref")
{
     $pstyle = gettheme($sid);
      echo xhtmlhead("Chapel",$pstyle);
$who = $_GET["who"];
addonline(getuid_sid($sid),"chapel","");
echo "<title></title>";

//echo "<body bgcolor=\"#00BFFF\" link=\"#0000CC\" vlink=\"#0000CC\" alink=\"#0000CC\">";

echo "<p align=\"center\">";
echo "<b>CHAPEL</b><br/><br/>";
echo "<img src=\"../chapel/2.gif\" alt=\"\"/><br/>";

$nick = getnick_uid($who);
echo "SOB..will say your negative answer.<br/><br/>";
$byuid = getuid_sid($sid);
$couple = mysql_fetch_array(mysql_query("SELECT who, partner FROM couple WHERE partner='".$uid."'"));
$msg = "Sorry, $nick HAS SAID NO :( ";
mysql_query("INSERT INTO dcroxx_me_private SET text='".$msg."', byuid='".$byuid."', touid='".$couple[0]."', unread='1', timesent='".time()."'");
$res = mysql_query("DELETE FROM couple WHERE partner='".$uid."' AND who='".$couple[0]."'");

  echo "<b></b><div><a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a></div><br/>";


echo "</p>";
echo "</body>";
}else if($action=="div")
{
     $pstyle = gettheme($sid);
      echo xhtmlhead("Chapel",$pstyle);

addonline(getuid_sid($sid),"chapel","");
echo "<title></title>";

//echo "<body bgcolor=\"#00BFFF\" link=\"#0000CC\" vlink=\"#0000CC\" alink=\"#0000CC\">";

echo "<br/><img src=\"../chapel/2.gif\" alt=\"\"/><br/>";


echo "<p align=\"center\">";
$me = mysql_fetch_array(mysql_query("SELECT who, partner, accept, req FROM couple WHERE who ='".$uid."'"));
$me = mysql_fetch_array(mysql_query("SELECT who,partner FROM couple WHERE who='".$uid."' OR partner='".$uid."'"));
$you = mysql_fetch_array(mysql_query("SELECT who, partner, accept, req FROM couple WHERE partner ='".$uid."'"));
$nick = getnick_uid($me[0]);
$unick = getnick_uid($me[1]);

if($uid==$me[0])
{
echo "do you wanna divorce $unick ?";
}

if($uid==$me[1])
{
echo "do you wanna divorce $nick ?";
}

$wed = mysql_fetch_array(mysql_query("SELECT partner FROM couple WHERE who='".$uid."'"));
if (!$wed)
{
$wed = mysql_fetch_array(mysql_query("SELECT who FROM couple WHERE partner='".$uid."'"));
}
$who = $wed[0];

echo "<form action=\"chapel.php?action=sep\" method=\"post\">";
echo "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
echo "<input type=\"submit\" name=\"submit\" value=\"YES\"></form><br/><br/>";
echo "<a href=\"chapel.php?action=chapel\">No</a><br/><br/>";
  echo "<b></b><div><a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a></div><br/>";


echo "</p>";
echo "</body>";
exit();
}

/////////////////////////////////////////////
else if($action=="sep")
{
     $pstyle = gettheme($sid);
      echo xhtmlhead("Chapel",$pstyle);
addonline(getuid_sid($sid),"chapel","");
echo "<title></title>";

//echo "<body bgcolor=\"#00BFFF\" link=\"#0000CC\" vlink=\"#0000CC\" alink=\"#0000CC\">";
echo "<br/><img src=\"../chapel/2.gif\" alt=\"\"/><br/>";

echo "<p align=\"center\">";
$who = $_POST["who"];
$uid = getuid_sid($sid);
$res = mysql_query("DELETE FROM couple WHERE who='".$uid."' OR partner='".$uid."'");
$res = mysql_query("DELETE FROM couple WHERE who='".$who."' OR partner='".$who."'");
if($res)
{
$nick = getnick_uid($who);
$nic = getnick_uid($uid);
$msg = "-sorry.. $nic has divorced from you..";
mysql_query("INSERT INTO dcroxx_me_private SET text='".$msg."', byuid='".$uid."', touid='".$who."', unread='1', timesent='".time()."'");
echo "DIVORCED from  $nick !<br/><br/>";
}else{
echo "ERROR<br/><br/>";

}
  echo "<b></b><div><a accesskey=\"0\" href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"\"/>Home</a></div><br/>";


echo "</p>";
echo "</body>";
exit();
}

///////////////////////////////Error/////////////////////////////
else{
addonline(getuid_sid($sid),"lost in chapel","");
  echo "<head>";
    echo "<title></title>";
    		
echo "<body bgcolor=\"#00BFFF\" link=\"#0000CC\" vlink=\"#0000CC\" alink=\"#0000CC\">";


    echo "</head>";
  
  echo "<p align=\"center\">";
  echo "ERROR..<br/><br/>";
  echo "<a href=\"index.php?action=main\">back</a>";
echo "</p>";
  echo "</body>";
  echo "</html>";
exit();
}

?>

</html>
