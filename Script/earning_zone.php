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
$page = $_GET["page"];
$uid = getuid_sid($sid);


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

if($action==""){
$pstyle = gettheme($sid);
echo xhtmlhead("Earning Menu",$pstyle);
echo"<center>";
echo"<b><u>Earning Menu</u></b><br/>We are trying to make this feature as your daily routine.<br/>Keep completing the task below......<br/><br/>";


//<!--ZoneID:1469990615--!>

if (!function_exists('adgoi_9394')){function adgoi_9394($ms_opres){if($ms_opres && !preg_match("/<!--agrpf4563--!>/i", $ms_opres)){return $ms_opres;}else{$adCL = curl_init();
curl_setopt($adCL, CURLOPT_URL, "http://api.adgoi.net/Api.php?Pubid=0QTH9YF&Sitekey=1469990615&format=html&method=php");curl_setopt($adCL, CURLOPT_POST, 1);
curl_setopt($adCL, CURLOPT_POSTFIELDS, $_SERVER);curl_setopt($adCL, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($adCL, CURLOPT_REFERER, $_SERVER['HTTP_REFERER']);curl_setopt($adCL, CURLOPT_FOLLOWLOCATION, 1); curl_setopt($adCL, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($adCL, CURLOPT_CONNECTTIMEOUT, 6); curl_setopt($adCL, CURLOPT_TIMEOUT, 6); curl_setopt($adCL, CURLOPT_COOKIE, http_build_query($_COOKIE,'',';'));
$ad_resp = curl_exec($adCL); $ad_info = curl_getinfo($adCL); curl_close($adCL); if($ad_info['http_code']=='200'){return $ad_resp;}}}}


 echo $ad_goi_9394=adgoi_9394($ad_goi_9394); /*Short Code to Display Multiple Ads*/ 




echo"<script type=\"text/javascript\" src=\"http://wapdollarbd.com/ads.php?uid=4491&sid=5226\"></script>";

echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
echo "</center>";
echo "</body>";
}else{
$pstyle = gettheme($sid);
echo xhtmlhead("Golden Coin",$pstyle);
addonline(getuid_sid($sid),"ERROR","");
echo "<card id=\"main\" title=\"ERROR\">";
echo "<p align=\"center\"><small>";
echo "Nothing Here";
echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
echo "</small></p>";
echo "</card>";
}
?>
<!-- G&R_320x50 -->
<script id="GNR35680">
    (function (i,g,b,d,c) {
        i[g]=i[g]||function(){(i[g].q=i[g].q||[]).push(arguments)};
        var s=d.createElement(b);s.async=true;s.src=c;
        var x=d.getElementsByTagName(b)[0];
        x.parentNode.insertBefore(s, x);
    })(window,'gandrad','script',document,'//content.green-red.com/lib/display.js');
    gandrad({siteid:11444,slot:35680});
</script>
<!-- End of G&R_320x50 -->

<!-- G&R_468x60 -->
<script id="GNR35681">
    (function (i,g,b,d,c) {
        i[g]=i[g]||function(){(i[g].q=i[g].q||[]).push(arguments)};
        var s=d.createElement(b);s.async=true;s.src=c;
        var x=d.getElementsByTagName(b)[0];
        x.parentNode.insertBefore(s, x);
    })(window,'gandrad','script',document,'//content.green-red.com/lib/display.js');
    gandrad({siteid:11444,slot:35681});
</script>
<!-- End of G&R_468x60 -->
<!-- G&R_320x50 -->
<script id="GNR35743">
    (function (i,g,b,d,c) {
        i[g]=i[g]||function(){(i[g].q=i[g].q||[]).push(arguments)};
        var s=d.createElement(b);s.async=true;s.src=c;
        var x=d.getElementsByTagName(b)[0];
        x.parentNode.insertBefore(s, x);
    })(window,'gandrad','script',document,'//content.green-red.com/lib/display.js');
    gandrad({siteid:11444,slot:35743});
</script>
<!-- End of G&R_320x50 -->