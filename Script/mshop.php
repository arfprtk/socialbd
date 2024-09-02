<?php
    session_name("PHPSESSID");
session_start();

include("xhtmlfunctions.php");
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";
?>

<?php
include("config.php");
include("core.php");
connectdb();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
    if(islogged($sid)==false)
    {
   $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
     echo xhtmlfoot();
      exit();
    }
$uid = getuid_sid($sid);
if(isbanned($uid))
    {
      $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
      echo "You are <b>Banned</b><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT timeto FROM dcroxx_me_metpenaltiespl WHERE uid='".$uid."' AND penalty='1'"));
      $remain = $banto[0]- (time()  );
      $rmsg = gettimemsg($remain);
      echo "Time to finish your penalty: $rmsg<br/><br/>";
      //echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
      echo xhtmlfoot();
      exit();
    }

if($action=="main")
{
  addonline(getuid_sid($sid),"$stitle Shop","");
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
  echo "<p align=\"center\">";
  
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  
  echo "<b><u>Hello $nick</u></b><br/>";
  echo "<i><b><u>Welcome to the $stitle-Shop</u></b></i><br/>";

  echo "</p>";
  echo "<p><small>";  
 
  echo "<a href=\"mshop.php?action=shops\">View Shops</a><br/>";
  echo "<a href=\"mshop.php?action=wallet\">My Wallet</a><br/>";
  echo "<a href=\"mshop.php?action=inventory\">My Inventory</a><br/><br/>";
      echo "</small></p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
 echo xhtmlfoot();
  exit();
    }
//////////////////////////////////

else
if($action=="shops")
{
  addonline(getuid_sid($sid),"$stitle Shop","");
 $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle Shop",$pstyle);
  echo "<p align=\"center\">";
  
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  
  echo "<i><b><u><small>Shops:</small></u></b></i><br/>";

  echo "</p>";
  echo "<p>";  
  
  echo "<a href=\"mshops.php?action=shop5\">Useful Items and Features![NEW]</a><br/>";
  echo "<a href=\"mshops.php?action=shop2\">Gifts and Gadgets</a><br/>";
  echo "<a href=\"mshops.php?action=shop3\">Moto Trader</a><br/>";
  echo "<a href=\"mshops.php?action=shop4\">Extra</a><br/>";
 echo "<a href=\"mshops.php?action=shop6\">Pc Users</a><br/>";
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
 echo xhtmlfoot();
  exit();
    }
//////////////////////////////////
else
if($action=="wallet")
{
  addonline(getuid_sid($sid),"$stitle Shop","");
  $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle wallet",$pstyle);
  echo "<p align=\"center\">";
  
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  
  echo "<i><b><u><small>My Wallet:</small></u></b></i><br/>";

  echo "</p>";
  echo "<p>";  
  
  $credits = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
 
  echo "Current Balance: <b>$credits[0]</b><br/><br/>";
  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
   echo "<a href=\"mshop.php?action=main\">Back to Shop</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
echo xhtmlfoot();
  exit();
    }
//////////////////////////////////

else
if($action=="inventory")
{
  addonline(getuid_sid($sid),"$stitle Shop","");
  $pstyle = gettheme($sid);
      echo xhtmlhead("inventory",$pstyle);
  echo "<p align=\"center\">";
  
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  
  echo "<i><b><u><small>Inventory:</small></u></b></i><br/>";

  echo "</p>";
  echo "<p>";
  
     $sql = "SELECT itemid FROM dcroxx_me_shop_Inventory WHERE uid='".$who."'";

    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
    $shopitem = mysql_fetch_array(mysql_query("SELECT itemid, itemname, itemshopid FROM dcroxx_me_shop WHERE itemid='".$item[0]."'"));
        
    echo "$shopitem[1]<br/>";
    if($shopitem[2]=='1'){
    echo " <small><a href=\"mshops-func.php?action=useitem1&amp;itemid=$shopitem[0]\">Use Item</a></small><br/><br/>";
    }
    else
    if($shopitem[2]=='2'){
    echo " <small><a href=\"mshops-func.php?action=useitem2&amp;itemid=$shopitem[0]\">Use Item</a></small><br/><br/>";
    }
    else
    if($shopitem[2]=='3'){
    echo " <small><a href=\"mshops-func.php?action=useitem3&amp;itemid=$shopitem[0]\">Use Status</a></small><br/><br/>";
    }
    else
    if($shopitem[2]=='4'){
    echo " <small><a href=\"mshops-func.php?action=useitem4&amp;itemid=$shopitem[0]\">Use Item</a></small><br/><br/>";
    }
   
  }
 }
    
    
    echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"mshop.php?action=main\">Back to Shop</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
  exit();
    }
//////////////////////////////////

else
{
  addonline(getuid_sid($sid),"Lost in Shop","");
  $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle shop",$pstyle);
  echo "<p align=\"center\">";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
  exit();
    }


?>
