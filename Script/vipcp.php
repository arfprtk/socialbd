<?php
session_name("PHPSESSID");
session_start();

header("Content-type: text/html");
header("Cache-Control: no-store, no-cache, must-revalidate");
echo("<?xml version=\"1.0\"?>");
include("xhtmlfunctions.php");
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
?>
<html>
<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> 
<?php
include("config.php");
include("core.php");
connectdb();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
if(!isvip(getuid_sid($sid)))
  {
    echo "<card id=\"main\" title=\"Forum\">";
      echo "<p align=\"center\">";
      echo "VI NISTE VIP CHLAN!<br/>";
      echo "<br/>";
      echo "<a href=\"index.php\">FORUM</a>";
      echo "</p>";
      echo "</card>";
      echo "</wml>";
      exit();
    }
if(islogged($sid)==false)
    {
        echo "<card id=\"main\" title=\"Forum\">";
      echo "<p align=\"center\">";
      echo "Niste Ulogovani!<br/>";
      echo "Ili je vas pristupni period istekao!<br/><br/>";
      echo "<a href=\"index.php\">Uloguj se!</a>";
      echo "</p>";
      echo "</card>";
      echo "</wml>";
      exit();
    }
    addonline(getuid_sid($sid),"VIP Panel","");
if($action=="55")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("V.I.P CP!",$pstyle);
    echo "<card id=\"main\" title=\"Vip Panel\">";
    echo "<p align=\"center\">";
    addonline(getuid_sid($sid),"Vip Panel","");
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=vipcp\"><img src=\"images/vip.gif\" alt=\"*\"/>";
  echo "Vip Panel</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p></card>";
}
/*else if($action=="poruka")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("V.I.P CP!",$pstyle);
    echo "<card id=\"main\" title=\"Vip Panel\">";
    echo "<p align=\"center\">";
    addonline(getuid_sid($sid),"Vip Panel","");
    $xtm = getsxtm();
    $paf = getpmaf();
    $fvw = getfview();
    $fmsg = parsepm(getfmsg($text));
  echo "<onevent type=\"onenterforward\">";
  echo "<refresh>
        <setvar name=\"fmsg\" value=\"$fmsg\"/>
   ";
  echo "</refresh></onevent>";
  echo "</p>";
  echo "<p align=\"center\">";
  echo "<b>Forum Poruka</b><br/>";
  echo "Forum messages are not used as a chat! This option has only admin and VIP chlanovi if it is abused will be abolished?<br/>";
  echo "</p>";
  echo "<p>";
  
echo "<form method=\"post\" action=\"vipproc.php?action=poruka\">";
echo "Forum Message:<br/> <input name=\"fmsg\" maxlength=\"255\"/><br/>";
echo "<input type=\"submit\" name=\"Submit\" value=\"CONFIRM\"/><br/>";
echo "</form>";
  
 /* echo "<br/>Forum Message: ";
  echo "<input name=\"fmsg\"  maxlength=\"255\"/>";
 
  echo "<br/><anchor>CONFIRM!
        <go href=\"vipproc.php?action=poruka\" method=\"post\">
        <postfield name=\"fmsg\" value=\"$(fmsg)\"/>
        </go></anchor> ";*/
		
 /* echo "<br/><small>*Any misuse of these options will be severely punished!*</small><br/>";
  echo "</p>";
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=vipcp\"><img src=\"images/vip.gif\" alt=\"*\"/>";
  echo "Vip Panel</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p></card>";
}*/
//////////////////////////////////////////promeni nick

else if($action=="nick")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("V.I.P CP!",$pstyle);
  $pid = $_GET["pid"];
  $page = $_GET["page"];
  $fid = $_GET["fid"];
    addonline(getuid_sid($sid),"<b>Change Nick</b>","");
    echo "<card id=\"main\" title=\"Change NIck\">";
 
    echo "<p align=\"center\">";
  echo "<b>are u tired of ur old nick well change it here</b>";
  echo "</p>";
  echo "<p>";
  $trnick = getnick_uid($uid);
  if(isvip(getuid_sid($sid)))
  {
    $trnick = getnick_uid($uid);
  echo "<form method=\"post\" action=\"vipproc.php?action=nick\">";
echo "Nick:<br/> <input name=\"unick\" value=\"$trnick\" maxlength=\"10\"/><br/>";
echo "<input type=\"submit\" name=\"Submit\" value=\"Edit\"/><br/>";
echo "</form>";
  
  
  
  /*  echo "<br/>Nick: ";  
    echo "<input name=\"unick\" value=\"$unick\" maxlength=\"30\"/> ";
    echo "<br/><anchor>Edit";
    echo "<go href=\"vipproc.php?action=nick\" method=\"post\">";
    echo "<postfield name=\"unick\" value=\"$(unick)\"/>";
    echo "</go>";*/
    
    echo "</anchor>";
  echo "<br/><small>*Any misuse of these options will be severely punished!*</small><br/>";
echo "<br/><small><b>*If you accidentally happen to any reason (out your network, run out of credit, etc.) stay with anyone new, next door to Morabito happy with this new to anyone and your old password!*</b></small><br/>";
  }
  echo "</p>";
echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=vipcp\"><img src=\"images/vip.gif\" alt=\"*\"/>";
  echo "Vip Panel</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo "</card>";
}
//////////////////////////////
else if($action=="pp2vip"){
    $pstyle = gettheme($sid);
    echo xhtmlhead("V.I.P CP!",$pstyle);
	addonline(getuid_sid($sid),"<b>Pm to all vip</b>","");
        echo "<card id=\"main\" title=\"Pm to all vip\">";
	echo "<p align=\"center\">";
	
	
echo "<form method=\"post\" action=\"vipproc.php?action=pp2vip\">";
echo "<b>Send pm to vip members</b><br/> <input name=\"pmtext\" maxlength=\"500\"/><br/>";
echo "<input type=\"submit\" name=\"Submit\" value=\"Message\"/><br/>";
echo "</form>";
	
	
	
/*	echo "<b>Send pm to vip members</b><br/><br/>";
	echo "<input name=\"pmtext\" maxlength=\"500\"/><br/>";
	echo "<small><anchor>Message<go href=\"vipproc.php?action=pp2vip\" method=\"post\">";
	echo "<postfield name=\"pmtext\" value=\"$(pmtext)\"/>";
	echo "</go></anchor></small>";*/
  echo "<br/><small>*Any misuse of these options will be severely punished!*</small><br/>";
  echo "<br/><a href=\"index.php?action=vipcp\"><img src=\"images/vip.gif\" alt=\"*\"/>";
  echo "Vip Panel</a><br/>";
  echo "</p>";
  echo "<p align=\"center\">";	
	echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
	echo "</p>";
	echo "</card>";
}
else if($action=="svi")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("V.I.P CP!",$pstyle);
  addonline(getuid_sid($sid),"<b>PP sent to all members</b>","");
  echo "<card id=\"main\" title=\"PP sent to all members\">";
  echo "<p align=\"center\">";
  
  echo "<form method=\"post\" action=\"vipproc.php?action=ppzasvi&amp;who=\">";
echo "<b>PP sent to all members!</b><br/> <input name=\"poruka\" maxlength=\"500\"/><br/>";
echo "<input type=\"submit\" name=\"Submit\" value=\"Message\"/><br/>";
echo "</form>";

/*	echo "PP sent to all members!<br/><br/>";
  echo "<input name=\"poruka\" maxlength=\"500\"/><br/>";
  echo "<anchor>Message<go href=\"vipproc.php?action=ppzasvi&amp;who=\" method=\"post\">";
  echo "<postfield name=\"poruka\" value=\"$(poruka)\"/>";
  echo "</go></anchor><br/><br/>";*/
  
  echo "<br/><a href=\"index.php?action=vipcp\">VIP CP</a><br/>";
  echo "</p>";
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo "</card>";
}
else if($action=="zenea")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("V.I.P CP!",$pstyle);
  addonline(getuid_sid($sid),"<b>PP sent to all female members</b>","");
  echo "<card id=\"main\" title=\"PP sent to all female members\">";
  echo "<p align=\"center\">";
  
    echo "<form method=\"post\" action=\"vipproc.php?action=ppzenea&amp;who=\">";
echo "<b>PP sent to all female members!</b><br/> <input name=\"poruka\" maxlength=\"500\"/><br/>";
echo "<input type=\"submit\" name=\"Submit\" value=\"Message\"/><br/>";
echo "</form>";

/*	echo "PP sent to all female members!<br/><br/>";
  echo "<input name=\"poruka\" maxlength=\"500\"/><br/>";
  echo "<anchor>Message<go href=\"vipproc.php?action=ppzenea&amp;who=\" method=\"post\">";
  echo "<postfield name=\"poruka\" value=\"$(poruka)\"/>";
  echo "</go></anchor><br/><br/>";
  */
  echo "<a href=\"index.php?action=vipcp\">VIP CP</a><br/>";
  echo "</p>";
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo "</card>";
}
else if($action=="musa")
{
    $pstyle = gettheme($sid);
    echo xhtmlhead("V.I.P CP!",$pstyle);
  addonline(getuid_sid($sid),"<b>PP sends all the male members</b>","");
  echo "<card id=\"main\" title=\"PP sends all the male members\">";
  echo "<p align=\"center\">";
  
  
      echo "<form method=\"post\" action=\"vipproc.php?action=ppmusa&amp;who=\">";
echo "<b>PP sends all the male members!</b><br/> <input name=\"poruka\" maxlength=\"500\"/><br/>";
echo "<input type=\"submit\" name=\"Submit\" value=\"Message\"/><br/>";
echo "</form>";

/*	echo "PP sends all the male members!<br/><br/>";
  echo "<input name=\"poruka\" maxlength=\"500\"/><br/>";
  echo "<anchor>Message<go href=\"vipproc.php?action=ppmusa&amp;who=\" method=\"post\">";
  echo "<postfield name=\"poruka\" value=\"$(poruka)\"/>";
  echo "</go></anchor><br/><br/>";*/
  echo "<a href=\"index.php?action=vipcp\">vipCP</a><br/>";
  echo "</p>";
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo "</card>";
}


else{
   echo "<card id=\"main\" title=\"Vip Panel\">";
  echo "<p align=\"center\">";
  echo "Lost in Vip Panel!<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}



?>
</html>