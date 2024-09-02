<?php
session_name("PHPSESSID");
session_start();
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
?>
<meta name="description" content="LDS Christian Social Community on Mobile" />
<meta name="keywords" content="lds, mormon, wapsite, christian, social community" />
<link rel="shortcut icon" href="/images/favicon.ico" />
<link rel="icon" href="/images/favicon.gif" type="image/gif" />
<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> 
<?php
include("config.php");

include("core.php");
include("xhtmlfunctions.php");
connectdb();
//protect against sql injections and remove $ sign
if( !get_magic_quotes_gpc() )
{
    if( is_array($_GET) )
    {
        while( list($k, $v) = each($_GET) )
        {
            if( is_array($_GET[$k]) )
            {
                while( list($k2, $v2) = each($_GET[$k]) )
                {
                    $_GET[$k][$k2] = addslashes($v2);
                }
                @reset($_GET[$k]);
            }
            else
            {
                $_GET[$k] = addslashes($v);
            }
        }
        @reset($_GET);
    }

    if( is_array($_POST) )
    {
        while( list($k, $v) = each($_POST) )
        {
            if( is_array($_POST[$k]) )
            {
                while( list($k2, $v2) = each($_POST[$k]) )
                {
                    $_POST[$k][$k2] = addslashes($v2);
                }
                @reset($_POST[$k]);
            }
            else
            {
                $_POST[$k] = addslashes($v);
            }
        }
        @reset($_POST);
    }
}
$iurl = $_GET["iurl"];
$sid = $_SESSION['sid'];
$page = $_GET["page"];
$uid = getuid_sid($sid);
$theme = mysql_fetch_array(mysql_query("SELECT theme FROM dcroxx_me_users WHERE id='".$uid."'"));


    if(islogged($sid)==false)
    {
      echo "<head>\n";
	  echo "<title></title>\n";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/style.css\" />";
	  	  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";

	  echo "</head>";
      echo "<body>";

	echo "<div class=\"ahblock2\">";

	echo "</div>";

      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
	echo "<div class=\"ahblock2\">";

	echo "</div>";

      echo "</body>";
      echo "</html>";
      exit();
    }

if(isbanned($uid))
    {
      echo "<head>\n";
	  echo "<title></title>\n";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/style.css\" />";
	  	  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";

	  echo "</head>";
      echo "<body>";

	echo "<div class=\"ahblock2\">";

	echo "</div>";

      echo "<p align=\"center\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
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
if(trim($iurl)=="")
{
      echo "<head>\n";
	  echo "<title></title>\n";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
	  	  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";

	  echo "</head>";
      echo "<body>";

addonline(getuid_sid($sid),"Reputation Icons","");
	echo "<div class=\"ahblock2\">";




    //////ALL LISTS SCRIPT <<
    $noi=mysql_fetch_array(mysql_query("SELECT COUNT(url) FROM dcroxx_me_ricon"));
    if($page=="" || $page<=0)$page=1;
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql
        $sql = "SELECT url FROM dcroxx_me_ricon LIMIT $limit_start, $items_per_page";
//$moderatorz=mysql_query("SELECT tlphone, COUNT(*) as notl FROM users GROUP BY tlphone ORDER BY notl DESC LIMIT  ".$pagest.",5");
    
    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {

    while ($item = mysql_fetch_array($items))
    {
      $lnk = "<a href=\"repicons.php?&amp;iurl=$item[0]\"><img src=\"$item[0]\" alt=\"RI\"/></a>";
      echo "$lnk<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"repicons.php?page=$ppage\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"repicons.php?page=$npage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)

    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=cpanel\">";
echo "CPanel</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  	echo "</div>";
	echo "<div class=\"ahblock2\">";

	echo "</div>";

    echo "</body>";
	echo "</html>";
	exit();
}else
{
	addonline(getuid_sid($sid),"Reputation Icons","");
      echo "<head>\n";
	  echo "<title></title>\n";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
	  	  echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";

	  echo "</head>";
      echo "<body>";

	echo "<div class=\"ahblock2\">";

	echo "</div>";
	
	echo "<p align=\"center\">";
	$res = mysql_query("UPDATE dcroxx_me_users SET ficon='".$iurl."' WHERE id='".getuid_sid($sid)."' LIMIT 1  ");
	if($res)
	{
		echo "<img src=\"images/ok.gif\" alt=\"+\" />Reputation icon updated successfully";
	}else
	{
		echo "<img src=\"images/notok.gif\" alt=\"X\" />Database Error";
	}
	echo "</p>";
	echo "<p align=\"center\">";
	echo "<a href=\"repicons.php?\">";
echo "Reputation Icons</a><br/>";
    echo "<a href=\"index.php?action=cpanel\">";
echo "CPanel</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
	echo "<div class=\"ahblock2\">";

	echo "</div>";


    echo "</body>";
	echo "</html>";
	exit();
}
?>