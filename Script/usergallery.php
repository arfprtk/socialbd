<?php
    session_name("PHPSESSID");
session_start();
//>> &#187;
//<< &#171;
include("config.php");
include("core.php");
include("xhtmlfunctions.php");
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";
?>

<?php

$action = $_GET["action"];
$sid = $_SESSION['sid'];
$whoimage = $_GET["whoimage"];
$bcon = connectdb();
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
  addonline(getuid_sid($sid),"User Gallery","");
  $pstyle = gettheme($sid);
  echo xhtmlhead("User Gallery",$pstyle);
  echo "<p align=\"center\"><small>";
  echo "<i><b><u>The Gallery of the Members from </u></b></i><br/>";
  echo "<br/>";
  echo "</small></p>";
  echo "<p><small>";
  $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usergallery WHERE sex='F'"));
  echo "<a href=\"usergallery.php?action=females\"><img src=\"images/female.gif\" alt=\"*\"/>Females</a>($noi[0])<br/>";
  $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usergallery WHERE sex='M'"));
  echo "<a href=\"usergallery.php?action=males\"><img src=\"images/male.gif\" alt=\"*\"/>Males</a>($noi[0])<br/><br/>";
  echo "<a href=\"usergallery.php?action=upload\">Add Your Photo</a><br/><br/>";
  echo "</small></p>";
    echo "</p>"; 
  ////// UNTILL HERE >> 
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
}else
if($action=="males")
{
  addonline(getuid_sid($sid),"Male Gallery","");
  $pstyle = gettheme($sid);
  echo xhtmlhead("Male Gallery",$pstyle);
  echo "<p align=\"center\"><small>";
  echo "<i><b><u>Male Users From $stitle</u></b></i>";
  echo "<br/><br/>";
  echo "</small></p>";
   //////ALL LISTS SCRIPT <<
   $uid1 = getuid_sid($sid); 

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usergallery WHERE sex='M'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

    $sql = "SELECT uid, id, imageurl FROM dcroxx_me_usergallery WHERE sex='M' ORDER BY id DESC LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
	
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
		$sql = "SELECT rating FROM dcroxx_me_usergallery_rating WHERE imageid='".$item[1]."'";		
		$imginfo = mysql_query($sql);
		
		echo mysql_error();
        if(mysql_num_rows($imginfo)>0)
        {
           while ($imginfos = mysql_fetch_array($imginfo)){ 
              $ratingtotal = $ratingtotal + $imginfos[0];}
        }
		

		if($totalcomments<1){$totalcomments=0;}         
		$norm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usergallery_rating WHERE imageid='".$item[1]."'"));
		if ($norm[0]>0){
		$rating = ceil($ratingtotal/$norm[0]);
		}else{$rating=0;}
		
		$rated = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usergallery_rating WHERE byuid='".$uid1."' and imageid ='".$item[1]."'"));
		$totalcomments = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usergallery_rating WHERE imageid ='".$item[1]."' and commentsyn ='Y'"));
		$userinfo = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$item[0]."'"));
		
        echo "<a href=\"index.php?action=viewuser&amp;who=$item[0]\"><b><i><u>$userinfo[0]</u></i></b></a><small>";
        if(canratephoto($uid1, $item[0]) and ($rated[0]==0))
    	{
         echo "<br/><a href=\"usergallery.php?action=rate&amp;whoimage=$item[1]\">Rate This Photo</a>";
        }
        if(($uid1=="1") or ($uid1==$item[0]))
    	{
         echo " / <a href=\"usergallery.php?action=del&amp;whoimage=$item[1]\">Delete</a>";
        }
        if($uid1==$item[0])
    	{
         echo "<br/><a href=\"genproc.php?action=upavg&amp;avsrc=$item[2]\">Use As Avatar</a>";
        }
        echo "</small><br/><img src=\"$item[2]\" alt=\"$userinfo[0]\"/><br/>";
        echo "<small>Rating: $rating/10 (<a href=\"usergallery.php?action=votes&amp;whoimage=$item[1]\">$norm[0]</a> Votes)<br/><a href=\"usergallery.php?action=comments&amp;whoimage=$item[1]\">Comments</a>($totalcomments[0])";
        echo "</small><br/><br/>";
        $ratingtotal = 0;
        
    }
    }
    
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"usergallery.php?action=males&amp;page=$ppage\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"usergallery.php?action=males&amp;page=$npage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
  $rets = "<form action=\"usergallery.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "</form>";

        echo $rets;
}
    echo "</p>"; 
  ////// UNTILL HERE >> 
    echo "<p align=\"center\">";
   echo "<br/><br/><a href=\"usergallery.php?action=main\">&#171;Back to Gallery</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
}else
if($action=="females")
{
  addonline(getuid_sid($sid),"Female Gallery","");
  $pstyle = gettheme($sid);
  echo xhtmlhead("Female Gallery",$pstyle);
  echo "<p align=\"center\"><small>";
  echo "<i><b><u>Female Users From $stitle</u></b></i>";
  echo "<br/><br/>";
  echo "</small></p>";
   //////ALL LISTS SCRIPT <<
   $uid1 = getuid_sid($sid); 

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usergallery WHERE sex='F'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

    $sql = "SELECT uid, id, imageurl FROM dcroxx_me_usergallery WHERE sex='F' ORDER BY id DESC LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
	
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
		$sql = "SELECT rating FROM dcroxx_me_usergallery_rating WHERE imageid='".$item[1]."'";		
		$imginfo = mysql_query($sql);
		
		echo mysql_error();
        if(mysql_num_rows($imginfo)>0)
        {
           while ($imginfos = mysql_fetch_array($imginfo)){ 
              $ratingtotal = $ratingtotal + $imginfos[0];}
        }
		

		if($totalcomments<1){$totalcomments=0;}         
		$norm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usergallery_rating WHERE imageid='".$item[1]."'"));
		if ($norm[0]>0){
		$rating = ceil($ratingtotal/$norm[0]);
		}else{$rating=0;}
		
		$rated = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usergallery_rating WHERE byuid='".$uid1."' and imageid ='".$item[1]."'"));
		$totalcomments = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usergallery_rating WHERE imageid ='".$item[1]."' and commentsyn ='Y'"));
		$userinfo = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$item[0]."'"));
		
        echo "<a href=\"index.php?action=viewuser&amp;who=$item[0]\"><b><i><u>$userinfo[0]</u></i></b></a><small>";
        if(canratephoto($uid1, $item[0]) and ($rated[0]==0))
    	{
         echo "<br/><a href=\"usergallery.php?action=rate&amp;whoimage=$item[1]\">Rate This Photo</a>";
        }
        if(($uid1=="1") or ($uid1==$item[0]))
    	{
         echo " / <a href=\"usergallery.php?action=del&amp;whoimage=$item[1]\">Del</a>";
        }
        if($uid1==$item[0])
    	{
         echo "<br/><a href=\"genproc.php?action=upavg&amp;avsrc=$item[2]\">Use As Avatar</a>";
        }
        echo "</small><br/><img src=\"$item[2]\" alt=\"$userinfo[0]\"/><br/>";
        echo "<small>Rating: $rating/10 (<a href=\"usergallery.php?action=votes&amp;whoimage=$item[1]\">$norm[0]</a> Votes)<br/><a href=\"usergallery.php?action=comments&amp;whoimage=$item[1]\">Comments</a>($totalcomments[0])";
        echo "</small><br/><br/>";
        $ratingtotal = 0;
        
    }
    }
    
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"usergallery.php?action=females&amp;page=$ppage\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"usergallery.php?action=females&amp;page=$npage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
   if($num_pages>2)
   {
  $rets = "<form action=\"usergallery.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "</form>";

        echo $rets;
}
    echo "</p>"; 
  ////// UNTILL HERE >> 
    echo "<p align=\"center\">";
   echo "<br/><br/><a href=\"usergallery.php?action=main\">&#171;Back to Gallery</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
}else
if($action=="rate")
{
$validated = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE id='".$uid."'  AND validated='0'"));
    if(($validated[0]>0)&&(validation()))
    {
	
    $pstyle = gettheme($sid);
  echo xhtmlhead("try again",$pstyle);
      echo "<p align=\"center\">";
	   $nickk = getnick_sid($sid);
  $whoo = getuid_nick($nickk);
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
	   echo "<b>Ur Account is Not Validated Yet</b><br/>";
	  $totaltimeonline = mysql_fetch_array(mysql_query("SELECT tottimeonl FROM dcroxx_me_users WHERE id='".$whoo."'"));  
$num = $totaltimeonline[0]/86400;
$days = intval($num);
$num2 = ($num - $days)*24;
$hours = intval($num2);
$num3 = ($num2 - $hours)*60;
$mins = intval($num3);
$num4 = ($num3 - $mins)*60;
$secs = intval($num4);

echo "<b>Your online time:</b> ";
if(($days==0) and ($hours==0) and ($mins==0)){
  echo "$secs seconds<br/>";
}else
if(($days==0) and ($hours==0)){
  echo "$mins mins, ";
  echo "$secs seconds<br/>";
}else
if(($days==0)){
  echo "$hours hours, ";
  echo "$mins mins, ";
  echo "$secs seconds<br/>";
}else{
  echo "$days days, ";
  echo "$hours hours, ";
  echo "$mins mins, ";
  echo "$secs seconds<br/>";
}
    echo "<br/>You have to Spend at least<u> 20 mins online</u> to get validated ur account. Plz be patient try again this option after 20 Minutes online here..Untill then Explorer and Enjoy other features in .<br/>thank you!<br/><br/>";
	
	echo "<a href=\"index.php?action=formmenu\">Back To Forums</a><br/>";
	echo "<a href=\"downloads/xindex.php?action=main\">Back To Downloads</a><br/>";
	 echo "<a href=\"index.php?action=main\">Back To Home</a><br/><br/>";
	
	 echo "</p>";
   echo xhtmlfoot();
      exit();


    }
  addonline(getuid_sid($sid),"User Gallery","");
  $pstyle = gettheme($sid);
  echo xhtmlhead("Rate - User Gallery",$pstyle);
  echo "<p align=\"center\"><small>";
  echo "Rate this members Photo: 1=Low, 10=High<br/>You can also leave a comment for this photo!<br/>";
  echo "<br/>";
  echo "</small></p>";
  echo "<p>";
    echo "<form action=\"usergallery.php?action=rateuser&amp;whoimage=$whoimage\" method=\"post\">";
    echo "<small>Rate:</small> <select name=\"rate\" value=\"$rate[0]\">";
    echo "<option value=\"1\">1</option>";
    echo "<option value=\"2\">2</option>";
    echo "<option value=\"3\">3</option>";
    echo "<option value=\"4\">4</option>";
    echo "<option value=\"5\">5</option>";
    echo "<option value=\"6\">6</option>";
    echo "<option value=\"7\">7</option>";
    echo "<option value=\"8\">8</option>";
    echo "<option value=\"9\">9</option>";
    echo "<option value=\"10\">10</option>";
    echo "</select><br/>";
    
  echo "<small>Comments:</small> <input name=\"comment\" format=\"*M\" maxlength=\"200\"/><br/>";
  echo "<input type=\"submit\" value=\"Rate\"/>";
  echo "</form>"; 
  
    echo "</p>"; 
  ////// UNTILL HERE >> 
    echo "<p align=\"center\">";
   echo "<br/><br/><a href=\"usergallery.php?action=main\">&#171;Back to Gallery</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
}else
if($action=="comments")
{
  addonline(getuid_sid($sid),"User Gallery","");
  $pstyle = gettheme($sid);
  echo xhtmlhead("User Gallery",$pstyle);
  echo "<p align=\"center\"><small>";
  echo "<br/>";
  echo "</small></p>";
      //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usergallery_rating WHERE imageid='".$whoimage."' and commentsyn ='Y'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    
    $uidinfo = mysql_fetch_array(mysql_query("SELECT uid FROM dcroxx_me_usergallery WHERE id='".$whoimage."'"));
    $uid = getuid_sid($sid);

    
    $sql = "SELECT rating, comments, byuid, time, commentsreply, id  FROM dcroxx_me_usergallery_rating WHERE imageid ='".$whoimage."' and commentsyn ='Y' ORDER BY time DESC LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
        
    if(isonline($item[2]))
  {
    $iml = "<img src=\"images/onl.gif\" alt=\"+\"/>";
    
  }else{
    $iml = "<img src=\"images/ofl.gif\" alt=\"-\"/>";
  }
    if(strlen($item[1])>1){
         
      $snick = getnick_uid($item[2]);
      $lnk = "<small><a href=\"index.php?action=viewuser&amp;who=$item[2]\">$iml$snick:</a> <b>$item[0]/10</b></small>";
	  if(ismod($uid))
  {
	   echo "  <a href=\"usergallery.php?action=delc&amp;whoimage=$item[5]\">[x]</a>";
	   }
	  echo "$lnk<br/><small>";
      $bs = date("d/m/y",$item[3]);
      $text = parsepm($item[1], $sid);
      if(($uid==$uidinfo[0]) and (strlen($item[4])<1))
      {
        $replylink = "<a href=\"usergallery.php?action=commentreply&amp;id=$item[5]\">Reply to Comment</a><br/><i>$bs</i>";
      }else{
        $replylink = " <i>$bs</i>";
      }
      echo "$text";
      if(strlen($item[4])>1)
      {
      $text1 = parsepm($item[4], $sid);
      echo "<br><b><i>Reply:</i> $text1</b>";
      }
      echo "<br/>$replylink<br/><br/>";
      echo "</small>";
    }
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"usergallery.php?action=$action&amp;page=$ppage&amp;whoimage=$whoimage\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"usergallery.php?action=$action&amp;page=$npage&amp;whoimage=$whoimage\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
   if($num_pages>2)
   {
  $rets = "<form action=\"usergallery.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "</form>";

        echo $rets;
}
    echo "</p>"; 
  ////// UNTILL HERE >> 
    echo "<p align=\"center\">";
   echo "<br/><br/><a href=\"usergallery.php?action=main\">&#171;Back to Gallery</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
}else
if($action=="commentreply")
{
  addonline(getuid_sid($sid),"User Gallery","");
  $pstyle = gettheme($sid);
  echo xhtmlhead("User Gallery",$pstyle);
  $id = $_GET["id"];
  echo "<p align=\"center\"><small>";
  echo "Reply to a Comment<br/>";
  echo "<br/>";
  echo "</small></p>";
  echo "<p>";
    echo "<form action=\"usergallery.php?action=commentreplyaction&amp;id=$id\" method=\"post\">";
  echo "<small>Reply:</small> <input name=\"reply\" format=\"*M\" maxlength=\"200\"/><br/>";
  echo "<input type=\"submit\" value=\"Reply\"/>";
  echo "</form>"; 
  
    echo "</p>"; 
  ////// UNTILL HERE >> 
    echo "<p align=\"center\">";
   echo "<br/><br/><a href=\"usergallery.php?action=main\">&#171;Back to Gallery</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
}else
if($action=="votes")
{
  addonline(getuid_sid($sid),"User Gallery","");
  $pstyle = gettheme($sid);
  echo xhtmlhead("User Gallery",$pstyle);
  echo "<p align=\"center\"><small>";
  echo "<br/>";
  echo "</small></p>";
      //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_usergallery_rating WHERE imageid='".$whoimage."'"));
    $num_items = $noi[0]; //changable
    $items_per_page= 20;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;
    
    $imageratinginfo = "SELECT rating, byuid  FROM dcroxx_me_usergallery_rating WHERE imageid='".$item[1]."'";

    
        $sql = "SELECT rating, byuid, time  FROM dcroxx_me_usergallery_rating WHERE imageid ='".$whoimage."' ORDER BY time DESC LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);
    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
    {
        
          if(isonline($item[1]))
  {
    $iml = "<img src=\"images/onl.gif\" alt=\"+\"/>";
    
  }else{
    $iml = "<img src=\"images/ofl.gif\" alt=\"-\"/>";
  }
    
    $snick = getnick_uid($item[1]);
      $lnk = "<a href=\"index.php?action=viewuser&amp;who=$item[1]\">$iml$snick:</a> <b>$item[0]/10</b>";
      echo "$lnk<br/>";
    
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"usergallery.php?action=$action&amp;page=$ppage&amp;who=$who\">&#171;Prev</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"usergallery.php?action=$action&amp;page=$npage&amp;who=$who\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
   if($num_pages>2)
 {
  $rets = "<form action=\"usergallery.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "</form>";

        echo $rets;
}
    echo "</p>"; 
  ////// UNTILL HERE >> 
    echo "<p align=\"center\">";
   echo "<br/><br/><a href=\"usergallery.php?action=main\">&#171;Back to Gallery</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
}else


if($action=="rateuser")
{
   addonline(getuid_sid($sid),"Rate a User","");
   $rate = $_POST["rate"];
   $comment = $_POST["comment"];
   $pstyle = gettheme($sid);
  echo xhtmlhead("User Gallery",$pstyle);
   echo "<p align=\"center\">";
   $uid = getuid_sid($sid);
   if((strlen($comment))>1){   
   $res= mysql_query("INSERT INTO dcroxx_me_usergallery_rating SET imageid='".$whoimage."', rating='".$rate."', comments='".$comment."', byuid='".$uid."', time='".(time() - $timeadjust)."', commentsyn='Y'");
   }else
   if((strlen($comment))<2){   
   $res= mysql_query("INSERT INTO dcroxx_me_usergallery_rating SET imageid='".$whoimage."', rating='".$rate."', comments='".$comment."', byuid='".$uid."', time='".(time() - $timeadjust)."', commentsyn='N'");
   }

   if(($res) and ((strlen($comment))>1)){
   
     echo "<img src=\"images/ok.gif\" alt=\"o\"/>Rated Successfully<br/>";
     echo "<img src=\"images/ok.gif\" alt=\"o\"/>Comments added Successfully<br/>";
   }else
   if(($res) and ((strlen($comment))<2)){
   
     echo "<img src=\"images/ok.gif\" alt=\"o\"/>Rated Successfully<br/>";
     echo "<img src=\"images/notok.gif\" alt=\"x\"/>No Comments were added<br/>";
   }
   else{
     echo "<img src=\"images/notok.gif\" alt=\"x\"/>Rated unsuccessfully<br/>";
     echo "<img src=\"images/notok.gif\" alt=\"x\"/>No Comments were added<br/>";
   }
    echo "</p>"; 
  ////// UNTILL HERE >> 
    echo "<p align=\"center\">";
   echo "<br/><br/><a href=\"usergallery.php?action=main\">&#171;Back to Gallery</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
}else


if($action=="commentreplyaction")
{
   addonline(getuid_sid($sid),"Reply To Comment","");
   $id = $_GET["id"];
   $reply = $_POST["reply"];
   $pstyle = gettheme($sid);
  echo xhtmlhead("User Gallery",$pstyle);
   echo "<p align=\"center\">";
   $uid = getuid_sid($sid);
   $res = mysql_query("UPDATE dcroxx_me_usergallery_rating SET commentsreply='".$reply."' WHERE id='".$id."'");


   if($res){
   
     echo "<img src=\"images/ok.gif\" alt=\"o\"/>Replyed Successfully<br/>";
   }
   else{
     echo "<img src=\"images/notok.gif\" alt=\"x\"/>Replyed unsuccessfully<br/>";
   }
    echo "</p>"; 
  ////// UNTILL HERE >> 
    echo "<p align=\"center\">";
   echo "<br/><br/><a href=\"usergallery.php?action=main\">&#171;Back to Gallery</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
}else


if($action=="upload")
{
   addonline(getuid_sid($sid),"Uploading a Photo","");
   $rate = $_POST["rate"];
   $comment = $_POST["comment"];
   $pstyle = gettheme($sid);
  echo xhtmlhead("Uploading",$pstyle);
  set_time_limit(0);
   echo "<p><small>";
   echo "You can now upload your photo direct from your phone. If this doesn't work, MMS or E-Mail me the photo to <b>admin@.tk</b><br/>Note: You must rename your photo to your username if you MMS or E-Mail it.<br/>";
   
 
            echo "<br/>Pick a Photo to upload, and press 'upload'<br/>";
            echo " <form name=\"form2\" enctype=\"multipart/form-data\" method=\"post\" action=\"upload.php?action=upload\" />";
            echo "<input type=\"file\" size=\"32\" name=\"my_field\" value=\"\" />";
            echo "<input type=\"hidden\" name=\"action\" value=\"image\" /><br/>";
            echo "<input type=\"submit\" name=\"Submit\" value=\"upload\" />";
            echo "</form>";
   
    echo "</small></p>"; 
  ////// UNTILL HERE >> 
    echo "<p align=\"center\">";
   echo "<br/><br/><a href=\"usergallery.php?action=main\">&#171;Back to Gallery</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
}
//////////// Delete users posts
else if($action=="del")
{

    $pstyle = gettheme($sid);
  echo xhtmlhead("User Gallery",$pstyle);
      echo "<p align=\"center\">";

        echo "<br/>";
    $uid1 = getuid_sid($sid); 
        echo "<br/>";
		$tname=gettname($tid);
  $tinfo= mysql_fetch_array(mysql_query("SELECT uid FROM dcroxx_me_usergallery WHERE id='".$whoimage."'"));
if(($uid1=="1") or $tinfo[0]==getuid_sid($sid))

{
    $res = mysql_query("DELETE FROM dcroxx_me_usergallery WHERE id='".$whoimage."'");
    $res = mysql_query("DELETE FROM dcroxx_me_usergallery_rating WHERE imageid='".$whoimage."'");
      

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>Photo and all the Comments have been deleted";
      }}else{
        
		echo "<img src=\"images/notok.gif\" alt=\"X\"/>Wata shame! Dont be an Ass hole to Delete others photo!! Fuck u off from  b4  kick u out!";
			$wintext = "".getnick_uid($uid)." Tried to delete others photo";
	$res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$wintext."', byuid='".$uid."', touid='1', timesent='".time()."'");
      }


   echo "<br/><br/><a href=\"usergallery.php?action=main\">&#171;Back to Gallery</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
}
else if($action=="delc")
{

    $pstyle = gettheme($sid);
  echo xhtmlhead("User Gallery",$pstyle);
      echo "<p align=\"center\">";

        echo "<br/>";
    $res = mysql_query("DELETE FROM dcroxx_me_usergallery_rating WHERE id='".$whoimage."'");
  
      

        if($res)
      {
        echo "<img src=\"images/ok.gif\" alt=\"O\"/>the Comment has been deleted";
      }else{
        echo "<img src=\"images/notok.gif\" alt=\"X\"/>Error deleting Photo";
      }

   echo "<br/><br/><a href=\"usergallery.php?action=main\">&#171;Back to Gallery</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
}

else

{
  addonline(getuid_sid($sid),"Lost in Gallery","");
  $pstyle = gettheme($sid);
  echo xhtmlhead("Gallery",$pstyle);
  echo "<p align=\"center\">";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
  echo xhtmlfoot();
}

?>
