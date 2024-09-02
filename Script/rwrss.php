<?php
session_name("PHPSESSID");
session_start();

/*
 wap forum
by  araa
*/
//» &#187;
//« &#171;
header("Content-type: text/vnd.wap.wml");
header("Cache-Control: no-store, no-cache, must-revalidate");
echo("<?xml version=\"1.0\"?>");
echo "<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\"". " \"http://www.wapforum.org/DTD/wml_1.1.xml\">
<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";
?>

<wml>
<?php
include("config.php");
include("core.php");
include("lastRSS.php");
$bcon = connectdb();
if (!$bcon)
{
    echo "<card id=\"main\" title=\" (ERROR!)\">";
    echo "<p align=\"center\">";
    echo "<img src=\"images/exit.gif\" alt=\"*\"/><br/>";
    echo "ERROR! cannot connect to database<br/><br/>";
    echo "This error happens usually when backing up the database, please be patient, The site will be up any minute<br/><br/>";
    echo "Soon, we will offer services that doesn't depend on MySQL databse to let you enjoy our site, while the database is not connected<br/>";
    echo "<b>THANK YOU VERY MUCH</b>";
    echo "</p>";
    echo "</card>";
    echo "</wml>";
    exit();
}
$brws = explode(" ",$HTTP_USER_AGENT);
$ubr = $brws[0];
$uip = getip();
$rssid = $_GET["rssid"];
$sid = $_SESSION['sid'];
$page = $_GET["page"];
$fid = $_GET["fid"];
$action = $_GET["action"];
$uid = getuid_sid($sid);
$hvia = $HTTP_VIA;
cleardata();
if(isipbanned($uip,$ubr))
    {
      if(!isshield(getuid_sid($sid)))
      {
        echo "<card id=\"main\" title=\"\">";
      echo "<p align=\"center\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
      echo "This IP address is blocked<br/>";
      echo "<br/>";
      echo "How ever we grant a shield against IP-Ban for our great users, you can try to see if you are shielded by trying to log-in, if you kept coming to this page that means you are not shielded, so come back when the ip-ban period is over<br/><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT  timeto FROM dcroxx_me_metpenaltiespl WHERE  penalty='2' AND ipadd='".$uip."' AND browserm='".$ubr."' LIMIT 1 "));
      //echo mysql_error();
      $remain =  $banto[0] - (time() - $timeadjust);
      $rmsg = gettimemsg($remain);
      echo "Time to unblock the IP: $rmsg<br/><br/>";

      echo "</p>";
      echo "<p>";
  echo "UserID: <input name=\"loguid\" format=\"*x\" maxlength=\"30\"/><br/>";
  echo "Password: <input type=\"password\" name=\"logpwd\"  maxlength=\"30\"/><br/>";
  echo "<anchor>LOGIN<go href=\"login.php\" method=\"get\">";
  echo "<postfield name=\"loguid\" value=\"$(loguid)\"/>";
  echo "<postfield name=\"logpwd\" value=\"$(logpwd)\"/>";
  echo "</go></anchor>";
  echo "</p>";
      echo "</card>";
      echo "</wml>";
      exit();
      }
    }
if($action=="showfrss")
{
    addonline(getuid_sid($sid),"RSS aggregator","");
    echo "<card id=\"main\" title=\"RW RSS\">";
    
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_rss WHERE fid='".$fid."'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, title, dscr, imgsrc, pubdate FROM dcroxx_me_rss WHERE fid='".$fid."' ORDER BY id LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      if(trim($item[3]!=""))
      {
        $img = "<img src=\"$item[3]\" alt=\"*\"/>";
      }else{
        $img="";
      }
        $lnk = "$img<a href=\"rwrss.php?action=readrss&amp;rssid=$item[0]&amp;fid=$fid\">".htmlspecialchars($item[1])."</a><br/>";
        $feedsc = htmlspecialchars($item[2]);
        echo $lnk;
        echo $feedsc;
        echo "<br/>Publish Date: $item[4]<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"rwrss.php?action=$action&amp;page=$ppage&amp;fid=$fid\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"rwrss.php?action=$action&amp;page=$npage&amp;fid=$fid\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"rwrss.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"fid\" value=\"$fid\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
  echo "<p align=\"center\">";
  echo "<a href=\"index.php?action=viewfrm&amp;fid=$fid\">";
echo htmlspecialchars(getfname($fid))."</a><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}
else if($action=="readrss")
{
    addonline(getuid_sid($sid),"RSS Reader","");
    echo "<card id=\"main\" title=\"RW RSS\">";
    echo "<p align=\"center\">";
    $rssinfo = mysql_fetch_array(mysql_query("SELECT lupdate, link FROM dcroxx_me_rss WHERE id='".$rssid."'"));
    $updt = (time() - $timeadjust) - 3600;
    if($rssinfo[0]<$updt)
    {
        ///code to refresh info
        $rss = new lastRSS;
        $rss->cache_dir = './rsscache';
        $rss->cache_time = 3600;
        $rss->date_format = 'd m y - H:i';
        $rss->stripHTML = true;
        $rssurl = $rssinfo[1];
        if ($rs = $rss->get($rssurl))
        {
          $title = $rs["title"];
          $pgurl = $rs["link"];
          $srcd = $rs["description"];
          $pubdate = $rs["lastBuildDate"];
          
            mysql_query("UPDATE dcroxx_me_rss SET lupdate='".(time() - $timeadjust)."', title='".$title."', pgurl='".$pgurl."', srcd='".$srcd."', pubdate='".$pubdate."' WHERE id='".$rssid."'");
            mysql_query("DELETE FROM dcroxx_me_rssdata WHERE rssid='".$rssid."'");
            $rssitems = $rs["items"];
            for($i=0;$i<count($rssitems);$i++)
            {
              $rssitem = $rssitems[$i];
              mysql_query("INSERT INTO dcroxx_me_rssdata SET rssid='".$rssid."', title='".mysql_real_escape_string($rssitem["title"])."', link='".$rssitem["link"]."', text='".mysql_real_escape_string($rssitem["description"])."', pubdate='".$rssitem["pubDate"]."'");
            }
        }
        else {
            $errt = "Error: It's not possible to get the service...";
            mysql_query("INSERT INTO dcroxx_me_rssdata SET rssid='".$rssid."', title='ERROR!', link='', text='".mysql_real_escape_string($errt)."', pubdate='".(time() - $timeadjust)."'");
        }
    }
    $rssinfo = mysql_fetch_array(mysql_query("SELECT pgurl, title, srcd, imgsrc FROM dcroxx_me_rss WHERE id='".$rssid."'"));
    echo "<img src=\"$rssinfo[3]\" alt=\"*\"/><br/>";
    echo "<b>$rssinfo[1]</b><br/><small>";
    echo $rssinfo[2];
    echo "</small></p>";
    
    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_rssdata WHERE rssid='".$rssid."'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, title,  text, pubdate FROM dcroxx_me_rssdata WHERE rssid='".$rssid."' ORDER BY id LIMIT $limit_start, $items_per_page";


    echo "<p><small>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
        $lnk = "<img src=\"images/star.gif\" alt=\"*\"/><b>".$item[1]."</b><br/>";
        $feedsc = $item[2];
        echo $lnk;
        echo $feedsc;
        echo "<br/>Publish Date: $item[3]<br/><img src=\"images/line.jpg\" alt=\"*\"/><br/>";
    }
    }
    echo "</small></p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"rwrss.php?action=$action&amp;page=$ppage&amp;rssid=$rssid&amp;fid=$fid\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"rwrss.php?action=$action&amp;page=$npage&amp;rssid=$rssid&amp;fid=$fid\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"rwrss.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"rssid\" value=\"$rssid\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"fid\" value=\"$fid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
    echo "<p align=\"center\">";
    
    if($fid!=""||$fid>0)
    {
    $fname = htmlspecialchars(getfname($fid));
    echo "<a href=\"rwrss.php?action=showfrss&amp;fid=$fid\"><img src=\"images/rss.gif\" alt=\"rss\"/>$fname Extras</a><br/>";
    echo "<a href=\"index.php?action=viewfrm&amp;fid=$fid\">";
    echo $fname."</a><br/>";
    }

    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}
else{
addonline(getuid_sid($sid),"Lost in RSS aggregator","");
    echo "<card id=\"main\" title=\"RW RSS\">";
  echo "<p align=\"center\">";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
}
?></wml>
