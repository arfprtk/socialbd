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
$bcon = connectdb();
if (!$bcon)
{
  $pstyle = gettheme($sid);
      echo xhtmlhead("Personal gallery",$pstyle);
    echo "<p align=\"center\">";
    echo "<img src=\"images/exit.gif\" alt=\"*\"/><br/>";
    echo "ERROR! cannot connect to database<br/><br/>";
    echo "This error happens usually when backing up the database, please be patient, The site will be up any minute<br/><br/>";
    echo "you can temperoray be in this site <a href=\"http://SocialBD.NeT/xhtml/chat\">$site_name</a> while $site_name is offline<br/>";
    echo "<b>THANK YOU VERY MUCH</b>";
    echo "</p>";
        echo xhtmlfoot();
    exit();
}
$brws = explode(" ",$_SERVER[HTTP_USER_AGENT] );
$ubr = $brws[0];
$uip = getip();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$page = $_GET["page"];
$who = $_GET["who"];


$uid = getuid_sid($sid);

cleardata();

if(isipbanned($uip,$ubr))
    {
      if(!isshield(getuid_sid($sid)))
      {
    $pstyle = gettheme($sid);
      echo xhtmlhead("Personal gallery",$pstyle);
      echo "<p align=\"center\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
      echo "This IP address is blocked<br/>";
      echo "<br/>";
      echo "How ever we grant a shield against IP-Ban for our great users, you can try to see if you are shielded by trying to log-in, if you kept coming to this page that means you are not shielded, so come back when the ip-ban period is over<br/><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT  timeto FROM dcroxx_me_penalties WHERE  penalty='2' AND ipadd='".$uip."' AND browserm='".$ubr."' LIMIT 1 "));
      //echo mysql_error();
      $remain =  $banto[0] - time();
      $rmsg = gettimemsg($remain);
      echo " IP: $rmsg<br/><br/>";
      
      echo "</p>";
      echo "<p>";
  echo "UserID: <input name=\"loguid\" format=\"*x\" maxlength=\"30\"/><br/>";
  echo "Password: <input type=\"password\" name=\"logpwd\"  maxlength=\"30\"/><br/>";
  echo "<anchor>LOGIN<go href=\"login.php\" method=\"get\">";
  echo "<postfield name=\"loguid\" value=\"$(loguid)\"/>";
  echo "<postfield name=\"logpwd\" value=\"$(logpwd)\"/>";
  echo "</go></anchor>";
  echo "</p>";
     echo xhtmlfoot();
      exit();
      }
   }
if(($action != "") && ($action!="terms"))
{
    $uid = getuid_sid($sid);
    if((islogged($sid)==false)||($uid==0))
    {
  $pstyle = gettheme($sid);
      echo xhtmlhead("Personal gallery",$pstyle);
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a><br/><br/>";
      echo "</p>";
         echo xhtmlfoot();
      exit();
    }
    
    
    
}
//echo isbanned($uid);
if(isbanned($uid))
    {
       $pstyle = gettheme($sid);
      echo xhtmlhead("Personal gallery",$pstyle);
      echo "<p align=\"center\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
      echo "You are <b>Banned</b><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT timeto FROM dcroxx_me_penalties WHERE uid='".$uid."' AND penalty='1'"));
	  $banres = mysql_fetch_array(mysql_query("SELECT lastpnreas FROM dcroxx_me_users WHERE id='".$uid."'"));
	  
      $remain = $banto[0]- time();
      $rmsg = gettimemsg($remain);
      echo "Time to finish your penalty: $rmsg<br/><br/>";
	  echo "Ban Reason: $banres[0]";
      //echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
      echo xhtmlfoot();
      exit();
    }

///////////////////////////////GOLDLINEHOST//////////BY GLH WEB CREATION/////////
?>
<?php
//////////////////////////////////gallery List

if($action=="gallery")
{
    $who = $_GET["who"];
    addonline(getuid_sid($sid),"Viewing Gallery","");
   $pstyle = gettheme($sid);
      echo xhtmlhead("Personal gallery",$pstyle);
	  echo "<p align=\"center\"><small>";
  	$uid = getuid_sid($sid);



    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    if($who!="")
    {
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM gallery WHERE uid='".$who."'"));
    }else{
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM gallery"));
    }
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    if($who!="")
    {
        $sql = "SELECT id, uid, file FROM gallery WHERE uid='".$who."' ORDER BY id DESC LIMIT $limit_start, $items_per_page";
        }else{
$sql = "SELECT id, uid, file FROM gallery  ORDER BY id DESC LIMIT $limit_start, $items_per_page";
        }


    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
      $user = getnick_uid($item[1]);
	  $ext = getext($item[2]);
        $ime = getextimg($ext);
        $lnk = "<small><img src=\"gallery.php?id=$item[0]\" alt=\"$user\"/><br/><a href=\"gallery/$item[2]\">$user</a></small>";
        
      if(candelvl($uid, $item[0]))
      {
        $delnk = "<a href=\"admproc.php?action=delpic&amp;vid=$item[0]\">[x]</a>";
      }else{
        $delnk = "";
      }
      if($who!="")
      {
        $byusr="";
      }else{
        $unick = getnick_uid($item[3]);
        $ulnk = "<a href=\"index.php?action=viewuser&amp;who=$item[1]\">$unick</a>";
        $byusr = "- By $ulnk";
      }
      echo "$lnk $delnk<br/>";
      

    }
    }
    echo "</small></p>";
    echo "<p align=\"center\"><small>";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"pics.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"pics.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
  
    echo "</small></p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\"><small>";
  
if($who!="")
{
echo "<a href=\"index.php?action=viewuser&amp;who=$who\">";
$whonick = getnick_uid($who);
echo "$whonick's Profile</a><br/>";
$uid =getuid_sid($sid);
echo "<a href=\"galhelp1.php?action=main&amp;who=$uid\">&#187;Add photos to My personal Album</a><br/>";
}else{
echo "<a href=\"gallery1.php?action=main\">";
echo "..] Old gallerY [..</a><br/>";

echo "<a href=\"galhelp.php?action=main\">";
echo "Cant upload pics??</a><br/>";
}
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</small></p>";
    echo xhtmlfoot();
    exit();
    }


?>





