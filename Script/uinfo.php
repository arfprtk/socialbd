<?php
    session_name("PHPSESSID");
session_start();
include("xhtmlfunctions.php");
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";

?>

<html>


<?php
include("config.php");
include("core.php");
$bcon = connectdb();
if (!$bcon)
{
    echo "<card id=\"main\" title=\"$stitle (ERROR!)\">";
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
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$page = $_GET["page"];
$who = $_GET["who"];

$uid = getuid_sid($sid);

    if((islogged($sid)==false)||($uid==0))
    {
        echo "<card id=\"main\" title=\"$stitle\">";
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
        echo "<card id=\"main\" title=\"$stitle\">";
      echo "<p align=\"center\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
      echo "You are <b>Banned</b><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT timeto FROM dcroxx_me_metpenaltiespl WHERE uid='".$uid."' AND penalty='1'"));
      $remain = $banto[0]- (time() - $timeadjust);
      $rmsg = gettimemsg($remain);
      echo "Time to finish your penalty: $rmsg<br/><br/>";
      //echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
      echo "</card>";
      echo "</wml>";
      exit();
    }
if($action=="")
{
  addonline($uid,"Viewing User Profile","");
   $pstyle = gettheme($sid);
      echo xhtmlhead("User Info",$pstyle);
 // echo "<card id=\"main\" title=\"$stitle\">";
  echo "<p align=\"center\"><small>";
  $whonick = getnick_uid($who);
 // echo "<a href=\"index.php?action=viewuser&amp;who=$who\">$whonick's Basic Profile</a>";
  echo "<b>Activity Of ".getnick_uid($who)."</b><br/>";
  //echo "<p align=\"center\">";
echo "<a href=\"index.php?action=viewuser&amp;who=$who\">Basic</a> | 
<a href=\"index.php?action=prostats&amp;who=$who\">Advanced</a> | ";
echo "Activity | ";
echo "<a href=\"uinfo.php?action=look&amp;who=$who\">Info</a><br/><br/>";
  echo "</small></p>";
  echo "<p><small>";
  $regd = mysql_fetch_array(mysql_query("SELECT regdate FROM dcroxx_me_users WHERE id='".$who."'"));
  $sage = (time() - $timeadjust)-$regd[0];
  $rwage = ceil($sage/(24*60*60));
  
$pstn = mysql_fetch_array(mysql_query("SELECT posts FROM dcroxx_me_users WHERE id='".$who."'"));
$ppd = $pstn[0]/$rwage;
echo "Posts Per Day: <b>$ppd</b><br/>";

$nopl = mysql_fetch_array(mysql_query("SELECT shouts FROM dcroxx_me_users WHERE id='".$who."'"));
$spd = $nopl[0]/$rwage;
echo "Shouts Per Day: <b>$spd</b><br/>";
  
$chpn = mysql_fetch_array(mysql_query("SELECT chmsgs FROM dcroxx_me_users WHERE id='".$who."'"));
$cpd = $chpn[0]/$rwage;
echo "Chat Posts Per Day: <b>$cpd</b><br/>";  

$sql= mysql_fetch_array(mysql_query("SELECT totaltime FROM dcroxx_me_users WHERE id='".$who."'"));;
$rwage2 = gettimemsg($sql[0]/$rwage);
echo "Online Time Per Day: <b>$rwage2 </b><br/>";

/*
  echo "&#187;$stitle age: <b>$rwage days</b><br/>";
  echo "&#187;$stitle rating(0-5): <b>".geturate($who)."</b><br/>";


  $gbsg = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_gbook WHERE gbsigner='".$who."'"));
  echo "&#187;Have signed: <b>$gbsg[0] Guestbooks</b><br/>";
  $brts = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_brate WHERE uid='".$who."'"));
  echo "&#187;Have rated: <b>$brts[0] Blogs</b><br/>";
  $pvts = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_presults WHERE uid='".$who."'"));
  echo "&#187;Have voted in <b>$pvts[0] Polls</b><br/>";
  $strd = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE touid='".$who."' AND starred='1'"));
  echo "&#187;Starred PMs: <b>$strd[0]</b><br/><br/>";
  echo "<a href=\"uinfo.php?action=fsts&amp;who=$who\">&#187;Posts In forums</a><br/>";
  echo "<a href=\"uinfo.php?action=cinf&amp;who=$who\">&#187;Contact Info</a><br/>";
  echo "<a href=\"uinfo.php?action=look&amp;who=$who\">&#187;Looking</a><br/>";
  echo "<a href=\"uinfo.php?action=pers&amp;who=$who\">&#187;Personality</a><br/>";
  echo "<a href=\"uinfo.php?action=rwidc&amp;who=$who\">&#187;$stitle ID Card</a><br/>";*/
  echo "</small></p>";
  echo "<p align=\"left\"><small>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</small></p>";
  echo "</card>";
    exit();
    }
//////////////////////////////////

else if($action=="rwidc")
{
    addonline(getuid_sid($sid),"$stitle ID","");
    echo "<card id=\"main\" title=\"$stitle ID\">";
    echo "<p align=\"center\">";
    echo "<b>M! ID card</b><br/>";
    echo "<img src=\"rwidc.php?id=$who\" alt=\"rw id\"/><br/><br/>";
    echo "The source for this ID card is http://$stitle.tk/rwidc.php?id=$who<br/><br/>";
    echo "To look at your card Go to CPanel&gt; $stitle ID Card.";
    
    echo "</p>";
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";
    echo "</card>";
    exit();
    }
//////////////////////////////////

else if($action=="fsts")
{
    addonline($uid,"Viewing User Profile","");
    $whonick = getnick_uid($who);
    echo "<card id=\"main\" title=\"$stitle\">";
    echo "<p><small>";
    echo "<a href=\"index.php?action=main\">Home</a>&gt;";

    echo "<a href=\"index.php?action=viewuser&amp;who=$who\">$whonick</a><br/>";
    echo "&gt;<a href=\"uinfo.php?sid=$sid&amp;who=$who\">Extended Info</a>&gt;Posts in forums<br/><br/>";
    $pst = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_posts WHERE uid='".$who."'"));
    $frms = mysql_query("SELECT id, name FROM dcroxx_me_forums WHERE clubid='0' ORDER BY name");
    while ($frm=mysql_fetch_array($frms))
    {
      $nops = mysql_fetch_array(mysql_query("SELECT COUNT(*) as nops, a.uid FROM dcroxx_me_posts a INNER JOIN dcroxx_me_topics b ON a.tid = b.id WHERE a.uid='".$who."' AND b.fid='".$frm[0]."' GROUP BY a.uid "));
      $prc = ceil(($nops[0]/$pst[0])*100);
      echo htmlspecialchars($frm[1]).": <b>$nops[0] ($prc%)</b><br/>";
    }
    echo "<br/><a href=\"index.php?action=main\">Home</a>&gt;";
    
    echo "<a href=\"index.php?action=viewuser&amp;who=$who\">$whonick</a><br/>";
    echo "&gt;<a href=\"uinfo.php?sid=$sid&amp;who=$who\">Extended Info</a>&gt;Posts in forums";
    echo "</small></p>";
    echo "</card>";
    exit();
    }
//////////////////////////////////

else if($action=="cinf")
{
    addonline($uid,"Viewing User Profile","");
    $whonick = getnick_uid($who);
    echo "<card id=\"main\" title=\"$stitle\">";
    echo "<p><small>";
    echo "<a href=\"index.php?action=main\">Home</a>&gt;";

    echo "<a href=\"index.php?action=viewuser&amp;who=$who\">$whonick</a><br/>";
    echo "&gt;<a href=\"uinfo.php?sid=$sid&amp;who=$who\">Extended Info</a>&gt;Contact Info<br/><br/>";
    //duh
    $inf1 = mysql_fetch_array(mysql_query("SELECT country, city, street, phoneno, realname, budsonly, sitedscr FROM dcroxx_me_xinfo WHERE uid='".$who."'"));
    
    $inf2 = mysql_fetch_array(mysql_query("SELECT site, email FROM dcroxx_me_users WHERE id='".$who."'"));
    if($inf1[5]=='1')
    {
    if(($uid==$who)||(arebuds($uid, $who)))
    {
        $rln = $inf1[4];
        $str = $inf1[2];
        $phn = $inf1[3];
    }else{
        $rln = "Can't view";
        $str = "Can't view";
        $phn = "Can't view";
    }
    }else{
      $rln = $inf1[4];
      $str = $inf1[2];
      $phn = $inf1[3];
    }
    echo "Real Name: $rln<br/>";
    echo "Country: $inf1[0]<br/>";
    echo "City: $inf1[1]<br/>";
    echo "Street: $str<br/>";
    echo "Site: <a href=\"$inf2[0]\">$inf2[0]</a><br/>";
    echo "Site description: $inf1[6]<br/>";
    echo "Phone No.: $phn<br/>";
    echo "E-Mail: $inf2[1]<br/>";
    //tuh
    echo "<br/><a href=\"index.php?action=main\">Home</a>&gt;";

    echo "<a href=\"index.php?action=viewuser&amp;who=$who\">$whonick</a><br/>";
    echo "&gt;<a href=\"uinfo.php?sid=$sid&amp;who=$who\">Extended Info</a>&gt;Contact Info";
    echo "</small></p>";
    echo "</card>";
    exit();
    }
//////////////////////////////////

else if($action=="look")
{
    addonline($uid,"Viewing User Profile","");
	   $pstyle = gettheme($sid);
      echo xhtmlhead("User Info",$pstyle);
    $whonick = getnick_uid($who);
   // echo "<card id=\"main\" title=\"$stitle\">";
echo "<p align=\"center\"><small>";
echo "<b>Personal info Of ".getnick_uid($who)."</b><br/>";
echo "<a href=\"index.php?action=viewuser&amp;who=$who\">Basic</a> | 
<a href=\"index.php?action=prostats&amp;who=$who\">Advanced</a> | ";
echo "<a href=\"uinfo.php?who=$who\">Activity</a> | ";
echo "Info<br/><br/>";
echo "</small></p>";

echo "<p><small>";
    //duh
    $inf1 = mysql_fetch_array(mysql_query("SELECT sexpre, height, weight, racerel, hairtype, eyescolor FROM dcroxx_me_xinfo WHERE uid='".$who."'"));
    $inf2 = mysql_fetch_array(mysql_query("SELECT sex FROM dcroxx_me_users WHERE id='".$who."'"));
    if($inf1[0]=="M" && $inf2[0]=="F")
    {
      $sxp = "Straight";
    }else if($inf1[0]=="F" && $inf2[0]=="M")
    {
      $sxp = "Straight";
    }else if($inf1[0]=="M" && $inf2[0]=="M"){
      $sxp = "Gay";
    }else if($inf1[0]=="F" && $inf2[0]=="F"){
      $sxp = "Lesbian";
    }else if($inf1[0]=="B"){
      $sxp = "Bisexual";
    }else{
      $sxp = "inapplicable";
    }
    if($inf2[0]=="M")
    {
      $usx = "Male";
    }else if($inf2[0]=="F")
    {
      $usx = "Female";
    }else{
      $usx = "Shemale";
    }
    echo "Sex: <b>$usx</b><br/>";
    echo "Orientation: <b>$sxp</b><br/>";
    echo "Height: <b>$inf1[1]</b><br/>";
    echo "Weight: <b>$inf1[2]</b><br/>";
    echo "Ethnic origin: <b>$inf1[3]</b><br/>";
    echo "Hair: <b>$inf1[4]</b><br/>";
    echo "Eyes: <b>$inf1[5]</b><br/>--------------------<br/>";
  //////////////////////////////////////////////  //tuh
    $inf1 = mysql_fetch_array(mysql_query("SELECT country, city, street, phoneno, realname, budsonly, sitedscr FROM dcroxx_me_xinfo WHERE uid='".$who."'"));
    
    $inf2 = mysql_fetch_array(mysql_query("SELECT site, email FROM dcroxx_me_users WHERE id='".$who."'"));
    if($inf1[5]=='1')
    {
    if(($uid==$who)||(arebuds($uid, $who)))
    {
        $rln = $inf1[4];
        $str = $inf1[2];
        $phn = $inf1[3];
    }else{
        $rln = "Can't view";
        $str = "Can't view";
        $phn = "Can't view";
    }
    }else{
      $rln = $inf1[4];
      $str = $inf1[2];
      $phn = $inf1[3];
    }
    echo "Real Name: <b>$rln</b><br/>";
    echo "Country: <b>$inf1[0]</b><br/>";
    echo "City: <b>$inf1[1]</b><br/>";
    echo "Street: <b>$str</b><br/>";
   // echo "Site: <b><a href=\"$inf2[0]\">$inf2[0]</a></b><br/>";
   // echo "Site description: <b>$inf1[6]</b><br/>";
    echo "Phone No.: <b>$phn</b><br/>";
    echo "E-Mail: <b>$inf2[1]</b><br/>--------------------<br/>";	
	
    $inf1 = mysql_fetch_array(mysql_query("SELECT likes, deslikes, habitsb, habitsg, favsport, favmusic, moretext FROM dcroxx_me_xinfo WHERE uid='".$who."'"));
    echo "Likes:<b> ".parsemsg($inf1[0])."</b><br/>";
    echo "Dislikes:<b> ".parsemsg($inf1[1])."</b><br/>";
    echo "Bad Habits:<b> ".parsemsg($inf1[2])."</b><br/>";
    echo "Good Habits:<b> ".parsemsg($inf1[3])."</b><br/>";
    echo "Sport:<b> ".parsemsg($inf1[4])."</b><br/>";
    echo "Music:<b> ".parsemsg($inf1[5])."</b><br/>";
    echo "More text:<b> ".parsemsg($inf1[6])."</b><br/>";	
    echo "</small></p>";

	echo "<p align=\"center\"><small>";
	echo "<img src=\"images/home.gif\" alt=\"*\"><a href=\"index.php?action=main\">Home</a>";
    echo "</small></p>";
    echo "</card>";
    exit();
    }
//////////////////////////////////

else if($action=="pers")
{
    addonline($uid,"Viewing User Profile","");
    $whonick = getnick_uid($who);
    echo "<card id=\"main\" title=\"$stitle\">";
    echo "<p><small>";
    echo "<a href=\"index.php?action=main\">Home</a>&gt;";

    echo "<a href=\"index.php?action=viewuser&amp;who=$who\">$whonick</a><br/>";
    echo "&gt;<a href=\"uinfo.php?sid=$sid&amp;who=$who\">Extended Info</a>&gt;Personality<br/><br/>";
    //duh
    $inf1 = mysql_fetch_array(mysql_query("SELECT likes, deslikes, habitsb, habitsg, favsport, favmusic, moretext FROM dcroxx_me_xinfo WHERE uid='".$who."'"));
    echo "<b>Likes:</b> ".parsemsg($inf1[0])."<br/>";
    echo "<b>Dislikes:</b> ".parsemsg($inf1[1])."<br/>";
    echo "<b>Bad Habits:</b> ".parsemsg($inf1[2])."<br/>";
    echo "<b>Good Habits:</b> ".parsemsg($inf1[3])."<br/>";
    echo "<b>Sport:</b> ".parsemsg($inf1[4])."<br/>";
    echo "<b>Music:</b> ".parsemsg($inf1[5])."<br/>";
    echo "<b>More text:</b> ".parsemsg($inf1[6])."<br/>";
    //tuh
    echo "<br/><a href=\"index.php?action=main\">Home</a>&gt;";

    echo "<a href=\"index.php?action=viewuser&amp;who=$who\">$whonick</a><br/>";
    echo "&gt;<a href=\"uinfo.php?sid=$sid&amp;who=$who\">Extended Info</a>&gt;Personality";
    echo "</small></p>";
    echo "</card>";
    exit();
    }
//////////////////////////////////

else{
  echo "<card id=\"main\" title=\"$stitle\">";
  echo "<p align=\"center\">";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p></card>";
    exit();
    }

?></html>
