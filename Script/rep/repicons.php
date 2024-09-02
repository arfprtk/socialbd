<?php
/*
IrisBlaze wap forum
by Ra'ed Shabana
*/
//>> &#187;
//<< &#171;
header("Content-type: text/vnd.wap.wml");
header("Cache-Control: no-store, no-cache, must-revalidate");
echo("<?xml version=\"1.0\"  encoding=\"UTF-8\"?>");
echo "<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\"". " \"http://www.wapforum.org/DTD/wml_1.1.xml\">";
?>

<wml>
<?php
include("config.php");
include("core.php");
connectdb();
$iurl = $_GET["iurl"];
$sid = $_GET["sid"];
$page = $_GET["page"];


    if(islogged($sid)==false)
    {
      echo "<card id=\"main\" title=\"$sitename\">";
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
      echo "</card>";
      echo "</wml>";
      exit();
    }

if(isbanned($uid))
    {
        echo "<card id=\"main\" title=\"$sitename\">";
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
if(trim($iurl)=="")
{
addonline(getuid_sid($sid),"Reputation Icons","");

    echo "<card id=\"main\" title=\"Rep. Icons\">";
    //////ALL LISTS SCRIPT <<
    $noi=mysql_fetch_array(mysql_query("SELECT COUNT(url) FROM ibwf_ricon"));
    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql
        $sql = "SELECT url FROM ibwf_ricon LIMIT $limit_start, $items_per_page";
//$moderatorz=mysql_query("SELECT tlphone, COUNT(*) as notl FROM users GROUP BY tlphone ORDER BY notl DESC LIMIT  ".$pagest.",5");
    
    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {

    while ($item = mysql_fetch_array($items))
    {
      $lnk = "<a href=\"repicons.php?sid=$sid&amp;iurl=$item[0]\"><img src=\"$item[0]\" alt=\"RI\"/></a>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"repicons.php?page=$ppage&amp;sid=$sid\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"repicons.php?page=$npage&amp;sid=$sid\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"repicons.php\" method=\"get\">";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";

        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=cpanel&amp;sid=$sid\">";
echo "Help Menu</a><br/>";
    echo "<a href=\"index.php?action=main&amp;sid=$sid\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo "</card>";
}else
{
	addonline(getuid_sid($sid),"Reputation Icons","");

    echo "<card id=\"main\" title=\"Rep. Icons\">";
	
	echo "<p align=\"center\">";
	$res = mysql_query("UPDATE ibwf_users SET ficon='".$iurl."' WHERE id='".getuid_sid($sid)."' LIMIT 1  ");
	if($res)
	{
		echo "<img src=\"images/ok.gif\" alt=\"+\" />Reputation icon updated successfully";
	}else
	{
		echo "<img src=\"images/notok.gif\" alt=\"X\" />Database Error";
	}
	echo "</p>";
	echo "<p align=\"center\">";
	echo "<a href=\"repicons.php?sid=$sid\">";
echo "Reputation Icons</a><br/>";
    echo "<a href=\"index.php?action=cpanel&amp;sid=$sid\">";
echo "Help Menu</a><br/>";
    echo "<a href=\"index.php?action=main&amp;sid=$sid\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo "</card>";
}
?>

</wml>