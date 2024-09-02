<?php
session_name("PHPSESSID");
session_start();
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";
?>
<meta name="title" content="SocialBD.NeT - Always Something Different"/>
<meta name="description" content="SocialBD.NeT Means Always Something Different For The Generation And Lots Of Fun"/>
<meta name="keywords" content="Chat, Online, Community, Flirt, Dating, Love, Friendship, Adda, Social Network"/>
<meta name="robots" content="index, follow"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="language" content="English"/>
<meta name="revisit-after" content="7 days"/>
<meta name="author" content="Prottay Chowdhury Tufan"/>
<meta name='yandex-verification' content='4e0ffed7e0c2d1fb' />
<meta name="alexaVerifyID" content="QnQ37VUcD_KHSW-7pmRlHHG6myA"/> 

<meta property="og:type" content="profile"/>
<meta property="profile:first_name" content="Prottay Chowdhury"/>
<meta property="profile:last_name" content="Tufan"/>
<meta property="profile:username" content="FoortiBD"/>
<meta property="og:title" content="SocialBD.NeT"/>
<meta property="og:description" content="SocialBD.NeT Means Always Something Different For The Generation And Lots Of Fun"/>
<meta property="og:image" content="http://socialbd.net/logo250x250.png"/>
<meta property="og:url" content="http://socialbd.net"/>
<meta property="og:site_name" content="SocialBD.NeT"/>
<meta property="og:see_also" content="http://SocialBD.NeT"/>
<meta property="fb:admins" content="FoortiBD"/>


<meta name="twitter:card" content="summary"/>
<meta name="twitter:site" content="SocialBD"/>
<meta name="twitter:title" content="SocialBD.NeT">
<meta name="twitter:description" content="SocialBD.NeT Means Always Something Different For The Generation And Lots Of Fun"/>
<meta name="twitter:creator" content="Prottay Chowdhury Tufan"/>
<meta name="twitter:image:src" content="http://socialbd.net/logo250x250.png"/>
<meta name="twitter:domain" content="socialbd.com"/>

<meta itemprop="name" content="SocialBD.NeT"/>
<meta itemprop="description" content="SocialBD.NeT Means Always Something Different For The Generation And Lots Of Fun"/>
<meta itemprop="image" content="http://socialbd.net/logo250x250.png"/>

<meta property="place:location:latitude" content="3.1185996"/>
<meta property="place:location:longitude" content="101.5713278"/>
<meta property="business:contact_data:street_address" content="28,Jalan PJU 1a/8,Toman Perindustriyan Jaya,Kualalampur"/>
<meta property="business:contact_data:locality" content="Selangor"/>
<meta property="business:contact_data:postal_code" content="47301"/>
<meta property="business:contact_data:country_name" content="Malaysia"/>
<meta property="business:contact_data:email" content="fardin.ahsan@gmail.com"/>
<meta property="business:contact_data:phone_number" content="+60166912379"/>
<meta property="business:contact_data:website" content="http://socialbd.net"/>

<link rel="shortcut icon" href="/images/favicon.ico" />
<link rel="icon" href="/images/favicon.gif" type="image/gif" />
<link rel="StyleSheet" type="text/css" href="style/default.css" />
</head>

<?php
include("config.php");
include("core.php");
include("xhtmlfunctions.php");

$bcon = connectdb();
$uid = getuid_sid($sid);

if (!$bcon)
{
    $pstyle = gettheme1("1");
    echo xhtmlhead("$stitle (ERROR!)",$pstyle);
    echo "<p align=\"center\">";
    echo "<img src=\"images/exit.gif\" alt=\"*\"/><br/>";
    echo "ERROR! cannot connect to database<br/><br/>";
    echo "This error happens usually when backing up the database, please be patient, The site will be up any minute<br/><br/>";
    echo "<b>THANK YOU VERY MUCH</b>";
    echo "</p>";
  echo xhtmlfoot();
      exit();
}
$brws = explode("/",$_SERVER['HTTP_USER_AGENT']);
$ubr = $brws[0];
$uip = getip();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$page = $_GET["page"];
$who = $_GET["who"];

cleardata();
if(isipbanned($uip,$ubr))
    {
      if(!isshield(getuid_sid($sid)))
      {
      $pstyle = gettheme1("1");
      echo xhtmlhead("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
      echo "This IP address is blocked<br/>";
      echo "<br/>";
      echo "How ever we grant a shield against IP-Ban for our great users, you can try to see if you are shielded by trying to log-in, if you kept coming to this page that means you are not shielded, so come back when the ip-ban period is over<br/><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT  timeto FROM dcroxx_me_metpenaltiespl WHERE  penalty='2' AND ipadd='".$uip."' AND browserm='".$ubr."' LIMIT 1 "));
      //echo mysql_error();
      $remain =  $banto[0] - (time() - $timeadjust) ;
      $rmsg = gettimemsg($remain);
      echo "Time to unblock the IP: $rmsg<br/><br/>";

      echo "</p>";
      echo "<p>";
	  
  echo "<form action=\"login.php\" method=\"get\">";
  echo "Username:<br/> <input name=\"loguid\" format=\"*x\" size=\"8\" maxlength=\"30\"/><br/>";
  echo "Password:<br/> <input type=\"password\" name=\"logpwd\" size=\"8\" maxlength=\"30\"/><br/>";
echo "<input type=\"submit\" value=\"Login\"/>";
echo "</form>";
  echo "</p>";
  echo xhtmlfoot();
      exit();
      }
    }
	
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
	
if($action==""){  
$who = $_GET["who"];
$un = mysql_fetch_array(mysql_query("SELECT id FROM dcroxx_me_users WHERE name='".$who."'"));
$whoid = $un[0];
$showshout = mysql_fetch_array(mysql_query("SELECT showshout FROM dcroxx_me_users WHERE id='".$uid."'"));
$whoidnick = getnick_uid($whoid);
addonline(getuid_sid($sid),"xHTML-Viewing Profile of $whoidnick","index.php?action=viewuser&amp;who=$whoid");
  $pstyle = gettheme($sid);
    echo xhtmlhead($whoidnick." Profile",$pstyle);
	
   $theme1 = mysql_fetch_array(mysql_query("SELECT theme FROM dcroxx_me_users WHERE id='".$whoid."'"));
       echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/default.css\" />";
          echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />\n";
      echo "<meta http-equiv=\"Cache-Control\" content=\"no-cache\" />\n";
      echo "<meta http-equiv=\"Pragma\" content=\"no-cache\" />\n";
	  

  echo "<p align=\"center\">";
  echo "<h2>$whoidnick's Profile</h2><br/>";
  if($whoid==""||$whoid==0)
  {
    $mnick = $_POST["mnick"];
    $whoid = getuid_nick($mnick);
  }

  echo"<center>";

  $whoidnick = getnick_uid($whoid);
  if($whoidnick!=""){

  
/*echo "<center><b>".getstatus2($whoid)."</b><br/>";
echo "<div class=\"mblock1\">";*/
  if (shad0w($uid,$whoid)) {

if(isonline($whoid)){
echo "$whoidnick is online<br/>";
}else{
echo "$whoidnick is offline<br/>";
}
$plc = mysql_fetch_array(mysql_query("SELECT place FROM dcroxx_me_online WHERE userid='".$whoid."'"));
$ln5 = "Where:";
$go = mysql_fetch_array(mysql_query("SELECT placedet FROM dcroxx_me_online WHERE userid='".$whoid."'"));

    $lnk2 = "<br/><a href=\"$go[0]\">Go There!</a>";
    $uact = $plc[0];
  
echo "<br/><b>$ln5 $uact</b><br/>";
$noi = mysql_fetch_array(mysql_query("SELECT lastact FROM dcroxx_me_users WHERE id='".$whoid."'"));
$var1 = date("his",$noi[0]);
$var2 = time();
$var21 = date("his",$var2);
$var3 = $var21 - $var1;
$var4 = date("s",$var3);
echo "Idle For: ";
$remain = time() - $noi[0];
$idle = gettimemsg($remain);
echo "$idle<br/>";


$sql = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM lastview WHERE whonick='".$whoidnick."'"));
if ($sql[0]>10){
$sql = mysql_fetch_array(mysql_query("SELECT MAX(id) FROM lastview WHERE whonick='".$whoidnick."'"));
$sql = $sql[0]-9;
mysql_query("DELETE FROM lastview WHERE whonick='".$whoidnick."' AND id <'".$sql."'");
}

$lv=getnick_sid($sid);
$a = getuid_nick($whoidnick);
if($a!=$uid){
mysql_query("INSERT INTO lastview SET lastview='".$lv."', whonick='".$whoidnick."', ltime='".time()."'");
}

$sql= mysql_fetch_array(mysql_query("SELECT lastview,ltime FROM lastview WHERE whonick='".$whoidnick."'ORDER BY ltime DESC LIMIT 1"));
$a = getuid_nick($sql[0]);
$link = "<a href=\"index.php?action=viewuser&amp;who=$a\"></a>$sql[0]";
echo "Last Viewed By: <b>$link</b><br/><br/>";




$avlink = getavatar($whoid);
if ($avlink==""){
echo "<img src=\"images/nopic.jpg\" alt=\"avatar\"/><br/>";
$size = format_size(filesize($avlink));
echo "<img src=\"sizecount.php?size=$size\" alt=\"0\" /><br/>";
}else{
echo "<img src=\"$avlink\" alt=\"avatar\" width=\"150\" height=\"189\"/><br/>";
$size = format_size(filesize($avlink));
echo "<img src=\"sizecount.php?size=$size\" alt=\"0\" /><br/>";
}


echo"<br/>";
echo "<div class=\"mblock1\">";

  echo "<p>";
  echo "<small>";


  echo "Member's ID: <b>$whoid</b><br/>";
  echo "Username: <b>$whoidnick</b><br/>";
$nopl = mysql_fetch_array(mysql_query("SELECT mood, birthday, location FROM dcroxx_me_users WHERE id='".$whoid."'"));
    if($nopl[0]=='s')
  {
    $mood = "Im Sweet";
  }
  else if($nopl[0]=='x')
  {
    $mood = "Im Sexy";
  }
  else if($nopl[0]==';;;;a')
  {
    $mood = "Im Angry";
  }

  else if($nopl[0]=='h')
  {
    $mood = "Im Happy";
  }
  else if($nopl[0]=='u')
  {
    $mood = "Im Sad";
  }
  else if($nopl[0]=='f')
  {
    $mood = "Looking For a Friend";
  }
  else if($nopl[0]=='l')
  {
    $mood = "Looking For a Lover";
  }
  else if($nopl[0]=='0')
  {
    $mood = "Leave me Alone";
  }
  else if($nopl[0]=='b')
  {
    $mood = "Im Busy";
  }
  else if($nopl[0]=='e')
  {
    $mood = "Enjoying $stitle";
  }


  else
  {
    $mood = "Enjoying $stitle";
  }

   echo "Status: <b>".getstatus($whoid)."</b><br/>";
  $nopl = mysql_fetch_array(mysql_query("SELECT sex, birthday, location FROM dcroxx_me_users WHERE id='".$whoid."'"));
  $uage = getage($nopl[1]);
  if($nopl[0]=='M')
  {
    $usex = "Male";
  }else if($nopl[0]=='F'){
    $usex = "Female";
  }else{
    $usex = "Shemale";
  }
  $nopl[2] = htmlspecialchars($nopl[2]);
  echo "Age: <b>$uage</b><br/>"; 
  echo "Gender: <b>$usex</b><br/>"; 

		$ip = mysql_fetch_array(mysql_query("SELECT ipadd FROM dcroxx_me_users WHERE id='".$whoid."'"));
$shonetwork = network($ip[0]);
if($shonetwork==""){
  echo "IP Country: <b>Unknown</b><br/>
              Flag: <img src=\"flags/UNK.gif\" alt=\"UN\" /><br/>";
}else{
  echo "$shonetwork";  
}
    echo "Online Mood: <b>$mood</b><br/>";
 
echo "Star Sign: <b>".getstarsign($nopl[1])."</b>";

echo"<br/>";

  $nopl = mysql_fetch_array(mysql_query("SELECT chmsgs FROM dcroxx_me_users WHERE id='".$whoid."'"));
  $tm24 = time() - (24*60*60);
$aut = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_chat WHERE timesent>'".$tm24."' AND chatter='".$whoid."'"));
  echo "Chat Posts: <b>$aut[0], ($nopl[0])</b><br/>";
  
    $nopl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$whoid."'"));
  $nop = mysql_fetch_array(mysql_query("SELECT arabank FROM dcroxx_me_users WHERE id='".$whoid."'"));
  echo "Plusses: <b>$nopl[0]</b><br/>";

  $nop = mysql_fetch_array(mysql_query("SELECT rp,userp FROM dcroxx_me_users WHERE id='".$whoid."'"));
  echo "Reputation Points: <b>$nop[0]</b><br/>";
  echo "Used Reputation Points: <b>$nop[1]</b><br/>";
    $no = mysql_fetch_array(mysql_query("SELECT topm FROM dcroxx_me_users WHERE id='".$whoid."'"));
  echo "Top Member: <b>$no[0]</b> Times<br/>";
  $n = mysql_fetch_array(mysql_query("SELECT golden_coin FROM dcroxx_me_users WHERE id='".$whoid."'"));
  echo "Golden Coins: <b>$n[0]</b><br/>";
  
  $noin = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE touid='".$whoid."'"));
$nout = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE byuid='".$whoid."'"));
echo "PMs IN: <b>$noin[0]</b> - OUT: <b>$nout[0]</b><br/>";

   $unpm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE touid='".$whoid."' AND unread>0"));
  $unread = mysql_fetch_array(mysql_query("SELECT COUNT(DISTINCT unread) FROM dcroxx_me_private WHERE byuid='".$uid."' AND touid='".$whoid."'"));
  if($unpm[0]==0)
  {
  echo "Unread PM's: <b>0</b><br/>";
  }else{
  echo "Unread PM's: <b>$unpm[0]</b>, <b>$unread[0]</b> from u<br/>";
  }
    $nx = mysql_fetch_array(mysql_query("SELECT apoints FROM dcroxx_me_users WHERE id='".$whoid."'"));
  echo "Activity Points: <b>$nx[0]</b><br/>";
  
$love = mysql_fetch_array(mysql_query("SELECT love FROM dcroxx_me_users WHERE id='".$whoid."'"));
  echo "Love Points: <b>$love[0]</b><br/>";
  $mybuds = getnbuds($whoid);
    echo "Total Friends: <b>$mybuds</b><br/>";
	
   echo "Profile Viewed: <b>$prof[0]</b><br/>";	
	
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_invite WHERE invite='".$whoid."'"));
if($noi[0]>0){
    $noi = mysql_fetch_array(mysql_query("SELECT invitedby FROM dcroxx_me_invite WHERE invite='".$whoid."'"));
    echo "Invited By: <b>".getnick_uid($noi[0])."</b><br/>";
}else{
   echo "Invited By: <b>None</b><br/>"; 
}
$noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_invite WHERE invitedby='".$whoid."'"));
echo "Invited Members: <b>$noi[0]</b><br/>";


  $nopl = mysql_fetch_array(mysql_query("SELECT browserm, os_brw FROM dcroxx_me_users WHERE id='".$whoid."'"));
  echo "Browser: <b>$nopl[0]</b><br/>";
  echo "OS: <b>".OS($nopl[1])."</b><br/>";
$ip = mysql_fetch_array(mysql_query("SELECT ipadd FROM dcroxx_me_users WHERE id='".$whoid."'"));
$isp = getisp($ip[0]);
if($isp==""){
    $ispshow = "Network: Unknown<br/>";
}else{
    $ispshow = $isp;
}
echo $ispshow;
echo "Profile Page: <b>http://SocialBD.NeT/".strtolower($whoidnick)."</b><br/>";

   echo "</div>";
   
  echo "</small>";
  echo "</p>";
   echo "<p align=\"left\"><small>";

 /////////////Users Photo


}else{
echo "
<img src=\"pass.gif\" alt=\"*\"/><br/>
<b>Profile Protection <font color=\"red\">ON</font></b><br/>
None can view this profile without our <b>SocialBD Team</b> and <b>$whoidnick</b>'s friends.<br/>";
}
 
 
 
   }else{
     echo "
	 <img src=\"images/notok.gif\" alt=\"X\"/><br/> 
	 <b>Member dos not exist</b><br/>
	 Check the spelling you've enter<br/>";
   }
 $thid = mysql_fetch_array(mysql_query("SELECT themeid FROM dcroxx_me_users WHERE id='".$uid."'"));
    $themeimageset = mysql_fetch_array(mysql_query("SELECT themedir FROM dcroxx_me_iconset WHERE id='".$thid[0]."'"));
    $unick = getnick_uid($whoid);
          echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</small></p>";
    echo xhtmlfoot();
exit();
}
?>