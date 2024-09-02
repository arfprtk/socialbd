<?php
     session_name("PHPSESSID");
session_start();
include("xhtmlfunctions.php");
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
?>

<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> 
<?php
include("config.php");
include("core.php");
connectdb();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$who = $_GET["who"];

$itemid = $_GET["itemid"];
    if(islogged($sid)==false)
    {
     $pstyle = gettheme($sid);
      echo xhtmlhead(" shop",$pstyle);
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
      echo xhtmlhead(" shop",$pstyle);
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
  addonline(getuid_sid($sid),"Here are some Flash Games","");
$pstyle = gettheme($sid);
      echo xhtmlhead("Flash Games",$pstyle);
  echo "<p align=\"center\">";
  


  echo "<p align=\"center\"><small>";
 echo "<b>FLASH GAMES</small></p>";


if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM alien_war_swf_games"));
    $num_items = $noi[0];
    $items_per_page= 10;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    $sql = "SELECT game_ID, game_SwfFile, game_Name, game_Thumb, game_Width, game_Height, game_Desc FROM alien_war_swf_games ORDER BY game_ID ASC LIMIT $limit_start, $items_per_page";

$items = mysql_query($sql);  if(mysql_num_rows($items)>0){
 while ($item = mysql_fetch_array($items)){

 
 
 echo "<small><img class=\"pphoto\" src=\"games/images/$item[3]\" alt=\"$item[2]\" height=\"50\" width=\"50\"/>
<b><a href=\"javascript:void(0);\" onClick=\"window.open('games/play.php?id=$item[0]&who=$uid&timesent=".time()."','play_game','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=1,left=380,top=120');return false;\">$item[2]</a></b><br/>
<small>$item[6]</small></small><br/><hr/>";
 
/*<a href="javascript:void(0);" onClick="window.open('games/play.php?id=$item[0]','play_game','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=1,width=$item[4],height=$item[5],left=380,top=120');return false;">
<img src="games/images/<?php echo ($i['game_Thumb']);?>" width="70" height="60" alt="<?php echo htmlspecialchars($i['game_Desc']);?>" title="<?php echo htmlspecialchars($i['game_Desc']);?>">
		</a>*/
 
 
 
 

 }}

if($page<$num_pages){
$npage = $page+1;
echo "<div class=\"divin\" align=\"center\"><a href=\"shouts.php?action=shouts&page=$npage\">See More Stories</a></div>";
}

  echo "</p>";
    echo xhtmlfoot();
exit();
}

?>
