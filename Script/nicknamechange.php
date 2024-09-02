<?php
session_name("PHPSESSID");
session_start();

/*
DENVER WHO VIEWED ME 2007
*/
//>> &#187;
//<< &#171;
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";
?>

<html>
<?php
include("config.php");
include("core.php");
include("xhtmlfunctions.php");
connectdb();

$action = $_GET["action"];
$sid = $_SESSION['sid'];
$page = $_GET["page"];
$who = $_GET["who"];
$fid = $_GET["fid"];
$pid = $_GET["pid"];
$id = $_GET["id"];
 $uid = getuid_sid($sid);
if($action != "")
{
    if(islogged($sid)==false)
    {
      echo "<card id=\"main\" title=\"pinoyaztig.net\">";
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or<br/>Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
      echo "</card>";
      echo "</wml>";
      exit();
    }
}
if(isbanned($uid))
    {
        echo "<card id=\"main\" title=\"pinoyaztig.net\">";
      echo "<p align=\"center\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
      echo "You are <b>Banned</b><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT timeto FROM ibwf_penalties WHERE uid='".$uid."' AND penalty='1'"));
      $remain = $banto[0]- time();
      $rmsg = gettimemsg($remain);
      echo "Time to finish your penalty: $rmsg<br/><br/>";
      //echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
      echo "</card>";
      echo "</wml>";
      exit();
    }
 
 ////put this in index
/////////////////////////////////////////////change nick alone
else if($action=="schimbanick")
{
		$pstyle = gettheme($sid);
      echo xhtmlhead("Nick Change",$pstyle);
    $uid = getuid_sid($sid);
    addonline(getuid_sid($sid),"Cumpara nick","");
    echo "<card id=\"main\" title=\"$stilte\">";
    echo "<p align=\"center\"><small>";
    echo "Welcome! Oprtiune This lets you buy a nick! As will be shorter the more expensive! Maximum: 4-14 characters!<br/>";

   echo "<onevent type=\"onenterforward\">";
    $nume = mysql_fetch_array(mysql_query("SELECT name FROM ibwf_users WHERE id='".$uid."'"));
  echo "<refresh>
        <setvar name=\"nick\" value=\"$nume[0]\"/>";
  echo "</refresh></onevent>";
  
  
  echo "<form action=\"nicknamechange.php?action=verificanick\" method=\"post\"><center>";
echo "Nick:<br/><input name=\"nick\" maxlength=\"14\"/><br/>";
 echo "<input type=\"submit\" value=\"VERIFY\"/>";
           echo "</form>";
  
  /*
  echo "Nick<br/><input name=\"nick\" maxlength=\"14\" size=\"14\"/><br/>";
  echo "<anchor>Verify";
    echo "<go href=\"nicknamechange.php?action=verificanick\" method=\"post\">";
    echo "<postfield name=\"nick\" value=\"$(nick)\"/>";
    echo "</go></anchor>";*/

  echo "<br/><br/><a href=\"index.php?action=main\">";
echo "home</a>";
  echo "</small></p></card>";
    exit();
    }
///////////////////////////////////////////////////////////verifica
else if($action=="verificanick")
{
		$pstyle = gettheme($sid);
      echo xhtmlhead("Nick Change",$pstyle);
    addonline(getuid_sid($sid),"search  nick","");
    $nick = $_POST["nick"];
    $uid = getuid_sid($sid);
   echo "<card id=\"main\" title=\"$stitle\">";
  echo "<p align=\"center\"><small>";
  
  
if($nick=""){
echo "Please type 4 characters long nick name<br/>";
echo "<br/><br/><a href=\"nicknamechange.php?action=schimbanick\">Back</a><br/>";  
echo "<a href=\"index.php?action=main\">";
echo "Home</a>";
echo "</small></p></card>";
exit();
}
  
  $nickprezent = mysql_fetch_array(mysql_query("SELECT name FROM ibwf_users WHERE id='".$uid."'"));
  $dacaexista = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_users WHERE name='".$nick."'"));
  if($nickprezent[0]!=$nick)
  {
      if($dacaexista[0]>0)
      {
        echo "Else already has the nick in use!<br/>";
      }else{
  $catelit = strlen($nick);
  if($catelit < 4){
  echo "Nick should not contain less than 4 characters!<br/>";
  echo "<br/><br/><a href=\"nicknamechange.php?action=schimbanick\">Back</a><br/>";
  }else if($catelit == 4){
  echo "    You choose a nickname 4 characters, so will cost <b>10000</b> plusses!<br/>";

   echo "nick is <b>$nick</b><br/>";
  if(getplusses(getuid_sid($sid))<10000)
    {
    $cate = 10000 - getplusses(getuid_sid($sid));
    echo "You need $cate plusses<br/>";
    }else
{
    echo "<anchor>enter";
    echo "<go href=\"nicknamechange.php?action=setezanick\" method=\"post\">";
    echo "<postfield name=\"nick\" value=\"$nick\"/>";
    echo "<postfield name=\"bani\" value=\"10000\"/>";
    echo "</go></anchor>";
    }
  echo "<br/><br/><a href=\"nicknamechange.php?action=schimbanick\">Back</a><br/>";
  }else if($catelit == 5){
  echo "Nick should not contain less than 5 characters <b>7000</b> plusses!";
  echo "nick is <b>$nick</b><br/>";
  if(getplusses(getuid_sid($sid))<7000)
    {
    $cate = 7000 - getplusses(getuid_sid($sid));
    echo "You need $cate plusses<br/>";
    }else
{
 echo "<anchor>enter";
    echo "<go href=\"nicknamechange.php?action=setezanick\" method=\"post\">";
    echo "<postfield name=\"nick\" value=\"$nick\"/>";
    echo "<postfield name=\"bani\" value=\"7000\"/>";
    echo "</go></anchor>";
    }
   echo "<br/><br/><a href=\"nicknamechange.php?action=schimbanick\">Back</a><br/>";
  }else if($catelit == 6){
  echo "You chose a nick for 6 characters, so will cost <b>4000</b> plusuri!";
    echo "The name chosen is <b>$nick</b><br/>";
  if(getplusses(getuid_sid($sid))<4000)
    {
    $cate = 4000 - getplusses(getuid_sid($sid));
    echo "You need $cate plusuri<br/>";
    }else{
  echo "<anchor>Apply";
    echo "<go href=\"nicknamechange.php?action=setezanick\" method=\"post\">";
    echo "<postfield name=\"nick\" value=\"$nick\"/>";
    echo "<postfield name=\"bani\" value=\"4000\"/>";
    echo "</go></anchor>";
    }
   echo "<br/><br/><a href=\"nicknamechange.php?action=schimbanick\">Back</a><br/>";
  }else if($catelit > 6){
  echo "Ai ales of a nick $catelit character, deci te va costa <b>2000</b> plusses!";

  echo "The name chosen is <b>$nick</b><br/>";
  if(getplusses(getuid_sid($sid))<2000)
    {
    $cate = 2000 - getplusses(getuid_sid($sid));
    echo "You need $cate plusses<br/>";
    }else{
  echo "<anchor>Apply";
    echo "<go href=\"nicknamechange.php?action=setezanick\" method=\"post\">";
    echo "<postfield name=\"nick\" value=\"$nick\"/>";
    echo "<postfield name=\"bani\" value=\"2000\"/>";
    echo "</go></anchor>";
    }

  echo "<br/><br/><a href=\"nicknamechange.php?action=schimbanick\">Back</a><br/>";
  }
  }}else{
  echo "This nickname already use!!<br/>";
  }
  echo "<a href=\"index.php?action=main\">";
echo "Home</a>";
  echo "</small></p></card>";
    exit();
    }
//////////////////////////////////////////////////////////////////seteaza
else if($action=="setezanick")
{
		$pstyle = gettheme($sid);
      echo xhtmlhead("Nick Change",$pstyle);
    addonline(getuid_sid($sid),"Set nick bought!","");
    $nick = $_POST["nick"];
    $bani = $_POST["bani"];
    echo "<card id=\"main\" title=\"$stitle\">";
  echo "<p align=\"center\"><small>";
  $idmeu = getuid_sid($sid);

  $nickprezent = mysql_fetch_array(mysql_query("SELECT name FROM ibwf_users WHERE id='".$uid."'"));
  $dacaexista = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_users WHERE name='".$nick."'"));
  if($nickprezent[0]!=$nick)
  {
      if($dacaexista[0]>0)
      {
        echo "    Else already has the nick in use!<br/>";
      }else{

  $plsmele = mysql_fetch_array(mysql_query("SELECT plusses FROM ibwf_users WHERE id='".$uid."'"));
  $ramas = $plsmele[0]-$bani;
  if($plsmele[0] <$bani){
  echo "You have enough plusess to buy this nick!<br/>";
  }else{
  $res = mysql_query("UPDATE ibwf_users SET name='".$nick."', plusses='".$ramas."', lastplreas='A cumparat nick: $nick' WHERE id='".$idmeu."'");
  if($res)
  {
    echo "<b>$nick</b> succes!<br/>";
    echo "<b>$bani</b> extracted from your account!<br/>";
  }else{
    echo "Error in dBase!<br/>";
    }
    }
    }}else{
  echo "This nickname already use!!<br/>";
  }

  echo "<br/><a href=\"index.php?action=main\">";
echo "Home</a>";
echo "</small></p></card>";
    exit();
    }

?>

</html>
