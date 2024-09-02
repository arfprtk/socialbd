<?php
session_name("PHPSESSID");
session_start();

//include("xhtmlfunctions.php");
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> 
<link rel=\"StyleSheet\" type=\"text/css\" href=\"SocialBD.css\" />";

?>

<?php
include("config.php");
include("core.php");
connectdb();

$action = $_GET["action"];
$sid = $_SESSION['sid'];
$page = $_GET["page"];

$uid = getuid_sid($sid);

if($action != "")
{
if(islogged($sid)==false)
{
      $pstyle = gettheme1("1");
      echo xhtmlhead("",$pstyle);
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
  echo xhtmlfoot();
      exit();
    }
}
if(isbanned($uid))
    {
      $pstyle = gettheme($sid);
      echo xhtmlhead("",$pstyle);
      echo "<p align=\"center\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
      echo "You are <b>Banned</b><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT timeto FROM dcroxx_me_metpenaltiespl WHERE uid='".$uid."' AND penalty='1'"));
	  $banres = mysql_fetch_array(mysql_query("SELECT lastpnreas FROM dcroxx_me_users WHERE id='".$uid."'"));

      $remain = $banto[0]- (time() - $timeadjust) ;
      $rmsg = gettimemsg($remain);
      echo "Time to finish your penalty: $rmsg<br/><br/>";
	  echo "Ban Reason: $banres[0]";
      //echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
  echo xhtmlfoot();
      exit();
    }

if($action=="main")
{
  echo"<title>Notifications</title>";   
	 // $pstyle = gettheme($sid);
      //echo xhtmlhead("Notification",$pstyle);
    //addvisitor();
  addonline(getuid_sid($sid),"Notifications","notification.php?action=$action");

include("header.php");

echo "<div class=\"penanda\" align=\"left\">";
$notify2 = notification2(getuid_sid($sid));
if($notify2>0)
{
  echo "<center><a href=\"notification.php?action=clearall\"><img src=\"7Ov1U5Yvw-2.png\"><br/>[Clear All Notifications]</a></center><br/>";  
}
//----------------> ADVERTISEMENT IS HERE
/*echo "</small></p>";
echo "<p align=\"left\"><small>";*/
$newnot = notification(getuid_sid($sid));
if($newnot>0)
   {
    //echo "<b>You have $newnot new notifications:</b><br/>";
    $notify2 = notification2(getuid_sid($sid));
   if($notify2<1)
   {
echo "<b>Currently no notifications are available for you!</b>";
   }
   else
   {
    //--------------------------> NOTIFICATIONS BY W3B_JOCKY
if($page=="" || $page<=0) {$page=1;}
$count = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) page FROM ibwf_notifications WHERE touid='".$uid."' AND unread='1'"));

$num_items = $count['page']; //changable
$event_per_page= 10;
$num_pages = ceil($num_items/$event_per_page);
if(($page>$num_pages)&&$page!=1) {$page= $num_pages;}
$limit_start = ($page-1)*$event_per_page;


$results = mysql_query("SELECT * FROM ibwf_notifications WHERE touid='".$uid."' AND unread='1' ORDER BY unread DESC, id DESC LIMIT $limit_start, $event_per_page");
while($row =mysql_fetch_assoc($results))
{
$notid = $row['id'];
$who = $row['byuid'];
$whonick = getnick_uid($who);
//if ($row['unread'] == '1')
//{
    mysql_query("UPDATE ibwf_notifications SET unread='0' WHERE id='".$notid."'");
    $nottxt = $row['text'];
    $nottext = parsepm($nottxt, $sid);
   // echo "&#187; $nottext";
//}
 /*else
 {
    $nottxt = $row['text'];
    $nottext = parsepm($nottxt, $sid);
    echo "&#187; $nottext";
 }*/
 $tmstamp = $row['timesent'];
$tremain = time()-$tmstamp;
$tmdt = gettimemsg($tremain)." ago"; ////////////////////this is the time thing
//echo " ($tmdt)<br/><br/>";

$notinfo = mysql_fetch_array(mysql_query("SELECT text, timesent, touid FROM  ibwf_notifications WHERE id='".$notid."'"));
$tmstamp = $notinfo[1];
$tremain = time()-$tmstamp;
$tmdt = gettimemsg($tremain)." ago";
$dtot = date("M d",$notinfo[1]);
$dtot1 = date("h:ia",$notinfo[1]);
$nottext = parsepm($notinfo[0],$sid);
echo "<b>$nottext</b> · ";
echo "<small><font color=\"#c0c0c0\">$dtot at $dtot1</font></small>";
echo "<hr/>";




}
echo "<p align=\"left\">";
//echo getnormalad($sid);
if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"notification.php?action=$action&amp;page=$ppage\">See Older Notifications</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"notification.php?action=$action&amp;page=$npage\">See Newer Notifications</a>";
    }
   /* echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to Page: <input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"notification.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }*/
   // echo getnormalad($sid);
    echo "</p>";
   }
   }
   else
   {
    echo "<b>All Notifications:</b><br/>";
    $notify2 = notification2(getuid_sid($sid));
   if($notify2<1)
   {
echo "<b>Currently no notifications are available for you!</b>";
   }
   else
   {
    //--------------------------> NOTIFICATIONS BY W3B_JOCKY
if($page=="" || $page<=0) {$page=1;}
$count = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) page FROM ibwf_notifications WHERE touid='".$uid."'"));

$num_items = $count['page']; //changable
$event_per_page= 10;
$num_pages = ceil($num_items/$event_per_page);
if(($page>$num_pages)&&$page!=1) {$page= $num_pages;}
$limit_start = ($page-1)*$event_per_page;


$results = mysql_query("SELECT * FROM ibwf_notifications WHERE touid='".$uid."' ORDER BY unread DESC, id DESC LIMIT $limit_start, $event_per_page");
while($row =mysql_fetch_assoc($results))
{
$notid = $row['id'];
$who = $row['byuid'];
$whonick = getnick_uid($who);
/*if ($row['unread'] == '1')
{
    mysql_query("UPDATE ibwf_notifications SET unread='0' WHERE id='".$notid."'");
    $nottxt = $row['text'];
    $nottext = parsepm($nottxt, $sid);
    echo "&#187; <b>$nottext</b>";
}
*/
// else
// {
    $nottxt = $row['text'];
    $nottext = parsepm($nottxt, $sid);
  //  echo "&#187; $nottext";
// }
 $tmstamp = $row['timesent'];
$tremain = time()-$tmstamp;
$tmdt = gettimemsg($tremain)." ago"; ////////////////////this is the time thing
//echo " ($tmdt)<br/><br/>";
$notinfo = mysql_fetch_array(mysql_query("SELECT text, timesent, touid FROM  ibwf_notifications WHERE id='".$notid."'"));
$tmstamp = $notinfo[1];
$tremain = time()-$tmstamp;
$tmdt = gettimemsg($tremain)." ago";
$dtot = date("M d",$notinfo[1]);
$dtot1 = date("h:ia",$notinfo[1]);
$nottext = parsepm($notinfo[0],$sid);
echo "$nottext · ";
echo "<small><font color=\"#c0c0c0\">$dtot at $dtot1</font></small>";
echo "<hr/>";



}
echo "<p align=\"left\">";
//echo getnormalad($sid);
if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"notification.php?action=$action&amp;page=$ppage\">See Older Notifications</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"notification.php?action=$action&amp;page=$npage\">See Newer Notifications</a>";
    }
 /*   echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to Page: <input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"notification.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }*/
  //  echo getnormalad($sid);
    echo "</p>";
   }
   }
/*echo "</small></p>";
echo "<p align=\"center\"><small>";*/
}
else if($action=="clearall")
{
  addonline(getuid_sid($sid),"Notifications","notification.php?action=main");
  //////////////wap
include("header.php");
/*echo "<card id=\"main\" title=\"Notifications\">";
echo "<p align=\"center\"><small>";*/
//echo getnormalad($sid);
$res= mysql_query("DELETE FROM ibwf_notifications WHERE touid='".$uid."'");
if($res)
{
    echo "<img src=\"images/ok.gif\" />Notifications cleared<br/>";
}else{
    echo "<img src=\"imsges/ok.gif\" />Database error<br/>";
}
echo "<a href=\"notification.php?action=main\">&#171;Notifications</a><br/>";
}
//echo getnormalad($sid);
/*echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a><br/>";*/

include("footer.php");
//echo "</small></p>";
echo "</card>";
?>
</html>

