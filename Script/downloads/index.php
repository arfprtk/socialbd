<?php


include("../xhtmlfunctions.php");
header("Content-type: text/html; charset=ISO-8859-1");
echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
?>
<?php
include("../config.php");
include("../core.php");
connectdb();
$action = $_GET["action"];
$sid = $_GET["sid"];
    if(islogged($sid)==false)
    {
      $pstyle = gettheme($sid);
      echo xhtmlhead("Arawap",$pstyle);
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"../index.php\">Login</a>";
      echo "</p>";
     echo xhtmlfoot();
      exit();
    }
$uid = getuid_sid($sid);
if(isbanned($uid))
    {
     $pstyle = gettheme($sid);
      echo xhtmlhead("Arawap",$pstyle);
      echo "<p align=\"center\">";
      echo "<img src=\"../images/notok.gif\" alt=\"x\"/><br/>";
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
  addonline(getuid_sid($sid),"Free Downloads","downloads/index.php?action=main");
  $pstyle = gettheme($sid);
      echo xhtmlhead("Free Downloads xhtml",$pstyle);
  echo "<p align=\"center\">";
  
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
   //echo "<img src=\"../images/ayu.gif\" alt=\"\"/>";
  
 

        $unreadinbox=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE unread='1' AND touid='".$uid."'"));
        $pmtotl=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE touid='".$uid."'"));
        $unrd="(".$unreadinbox[0].")";
        if ($unreadinbox[0]>0)
        {
        echo "<a href=\"../inbox.php?action=main&amp;sid=$sid\">U hv $unrd NEW msg</a><br/>";
      }
	 

 echo "<h5 align=\"center\"><blink>ArAwAp FREE downloads!</blink></h5>";
 
   echo "<div class=\"mblock2\">";
    echo "<center>";
 echo "<a href=\"../../downloads/xindex.php?action=music&amp;sid=$sid\">|::::! Music roOM !::::|</a><br/>";
 echo "<a href=\"../../downloads/xindex.php?action=wall&amp;sid=$sid\">|::::! WallpaperZ !::::|</a><br/>";
 echo "<a href=\"../../downloads/xindex.php?action=ani&amp;sid=$sid\">|::::! AnimationZ !::::|</a><br/>";
 echo "<a href=\"../../downloads/xindex.php?action=games&amp;sid=$sid\">|::::! Game[.]BoX !::::|</a><br/>";
 echo "<a href=\"../../downloads/xindex.php?action=app&amp;sid=$sid\">|:::! ApplicationZ !:::|</a><br/>";
 echo "<a href=\"../../downloads/xindex.php?action=vid&amp;sid=$sid\">|::::! Video roOM !::::|</a><br/>";
 echo "<a href=\"../../downloads/xindex.php?action=the&amp;sid=$sid\">|::::::! ThemeS !::::::|</a><br/>";
// echo "<a href=\"xindex.php?action=main&amp;sid=$sid\">|::::! Music roOM !::::|</a><br/>";
 echo "<a href=\"../../downloads/xindex.php?action=18&amp;sid=$sid\">|:::! Xxx +18 xxX !:::|</a><br/>";
 
 
 echo "|:::! W@P Scripts !:::|";
  echo "</center><br/><br/>";
 echo "</div>";
 echo "<div class=\"mblock2\">";
  echo "Ur requests, Errors &#187;<br/>";
  echo "</div>";
 echo"</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"../index.php?action=main&amp;sid=$sid\"><img src=\"../images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "<br/><h5 align=\"center\"><MARQUEE WIDTH=100% BEHAVIOR=ALTERNATE>-&copy; AraWap.Net-</MARQUEE></h5>";
	
  echo "</p>";
   echo xhtmlfoot();
}else


if($action=="music")
{
  addonline(getuid_sid($sid),"Free Downloads","downloads/index.php?action=main");
  $pstyle = gettheme($sid);
      echo xhtmlhead("Free Downloads",$pstyle);
  echo "<p align=\"left\">";
  
  
  
  echo "<b><u>Free Music!!</u></b><br/><br/>";
   echo "<u>English Music!!</u><br/>";
  echo "<a href=\"xdwn.php?action=emidi&amp;sid=$sid\">Midi tones</a><br/>";
echo "<a href=\"../downloads/emidi/funy/xindex.php?action=main&amp;sid=$sid\">Funny music Clips</a><br/>";
 
  echo "<a href=\"emp3/amr/xindex.php?action=main&amp;sid=$sid\">Amr Songs</a><br/>";
   echo "<a href=\"xdwn.php?action=emp3&amp;sid=$sid\">Mp3 Songs</a><br/><br/>";
 
  echo "<u>Sinhala Music!!</u><br/>";
	echo "<a href=\"xdwn.php?action=smidi&amp;sid=$sid\">Midi tones</a><br/>";
  echo "<a href=\"../downloads/smidi/funy/xindex.php?action=main&amp;sid=$sid\">Funny music Clips</a><br/>";
   echo "<a href=\"smp3/amr/xindex.php?action=main&amp;sid=$sid\">Amr Songs</a><br/>";
  echo "<a href=\"xdwn.php?action=smp3&amp;sid=$sid\">Mp3 Songs</a><br/>";
  
  
  echo "<u>Hindi, and other music comming soon!</u><br/>";
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"xindex.php?action=main&amp;sid=$sid\">back to Downloads</a><br/>";
  echo "<a href=\"../xhtml/index.php?action=main&amp;sid=$sid\"><img src=\"../images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
   echo xhtmlfoot();
}
else


if($action=="wall")
{
  addonline(getuid_sid($sid),"Free Downloads","downloads/index.php?action=main");
  $pstyle = gettheme($sid);
      echo xhtmlhead("Free Downloads",$pstyle);
  echo "<p align=\"center\">";
  
  
  
  echo "<b><u>Free Wallpapers!</u></b><br/><br/>";
  
  echo "Select ur Display Size<br/>";
echo "<a href=\"ani/ol/xindex.php?action=main&amp;sid=$sid\">Nokia Oparetor Logos</a><br/>";
	echo "<a href=\"wall/s30/xindex.php?action=main&amp;sid=$sid\">96 x 65 picS</a><br/>";
	echo "<a href=\"wall/s40/xindex.php?action=main&amp;sid=$sid\">128 x 128 picS</a><br/>";
		echo "<a href=\"wall/mot/xindex.php?action=main&amp;sid=$sid\">132 x 176 picS</a><br/>";
	echo "<a href=\"wall/s60/xindex.php?action=main&amp;sid=$sid\">174 x 144 picS</a><br/>";
		echo "<a href=\"wall/s90/xindex.php?action=main&amp;sid=$sid\">240 x 320 picS</a><br/>";


	echo "<a href=\"xdwn.php?action=wcam&amp;sid=$sid\">Live Web cam Photos</a><br/>";
	echo "<a href=\"xdwn.php?action=slpic&amp;sid=$sid\">Sri Lankan Photos</a><br/>";
	

  	echo "More photos comming soon!<br/>";
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"../xhtml/index.php?action=main&amp;sid=$sid\"><img src=\"../images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
   echo xhtmlfoot();
}

else


if($action=="ani")
{
  addonline(getuid_sid($sid),"Free Downloads","downloads/index.php?action=main");
  $pstyle = gettheme($sid);
      echo xhtmlhead("Free Downloads",$pstyle);
  echo "<p align=\"center\">";
  
  
  
  echo "<b><u>Free animationz</u></b><br/>";
  echo "<a href=\"ani/ani/xindex.php?action=main&amp;sid=$sid\">Animals</a><br/>";
  echo "<a href=\"ani/flags/xindex.php?action=main&amp;sid=$sid\">Flags</a><br/>";
  echo "<a href=\"ani/greetings/xindex.php?action=main&amp;sid=$sid\">Greetings</a><br/>";
  echo "<a href=\"ani/love/xindex.php?action=main&amp;sid=$sid\">Love-1</a><br/>";
  echo "<a href=\"ani/s40/xindex.php?action=main&amp;sid=$sid\">Love-2</a><br/>";
  echo "<a href=\"ani/ppl/xindex.php?action=main&amp;sid=$sid\">People</a><br/>";
  echo "<a href=\"ani/other/xindex.php?action=main&amp;sid=$sid\">Other</a><br/>";
 
    echo "<a href=\"ani/s60/xindex.php?action=main&amp;sid=$sid\">More 176x220 Animations</a><br/>";
	
	
  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"xindex.php?action=main&amp;sid=$sid\">back to Downloads</a><br/>";
  echo "<a href=\"../xhtml/index.php?action=main&amp;sid=$sid\"><img src=\"../images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
   echo xhtmlfoot();
}

else


if($action=="games")
{
  addonline(getuid_sid($sid),"Free Downloads","downloads/index.php?action=main");
  $pstyle = gettheme($sid);
      echo xhtmlhead("Free Downloads",$pstyle);
  echo "<p align=\"left\">";
  
  
  
  echo "<b><u>Free Games</u></b><br/><br/>";
  
  

   echo "<a href=\"games/s40/xindex.php?action=main&amp;sid=$sid\">s40 .jar Games</a><br/>";
    echo "<a href=\"games/s60g/xindex.php?action=main&amp;sid=$sid\">s60 Best Symbian Games</a><br/>";
    echo "<a href=\"games/ea/xindex.php?action=main&amp;sid=$sid\">Newst EA Games (miX)</a><br/>";
	 
	
	
  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"xindex.php?action=main&amp;sid=$sid\">back to Downloads</a><br/>";
  echo "<a href=\"../xhtml/index.php?action=main&amp;sid=$sid\"><img src=\"../images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
   echo xhtmlfoot();
}


else


if($action=="app")
{
  addonline(getuid_sid($sid),"Free Downloads","downloads/index.php?action=main");
 $pstyle = gettheme($sid);
      echo xhtmlhead("Free Downloads",$pstyle);
  echo "<p align=\"center\">";
  
  
  
  echo "<b><u>Free mobile Applications</u></b><br/><br/>";
   echo "<a href=\"app/S40/xindex.php?action=main&amp;sid=$sid\">40 Series Applications</a><br/>";
   echo "<a href=\"xindex.php?action=s60app&amp;sid=$sid\">s60 Symbian Applications</a><br/>";
   echo "<a href=\"app/s90/xindex.php?action=main&amp;sid=$sid\">90 Series Applications</a><br/>";
    echo "<a href=\"xindex.php?action=main&amp;sid=$sid\">.Jar Applications</a><br/>";
	echo "(Most mobiles support For .Jar Applicatioz)<br/>";
	
	
	
  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"xindex.php?action=main&amp;sid=$sid\">back to Downloads</a><br/>";
  echo "<a href=\"../xhtml/index.php?action=main&amp;sid=$sid\"><img src=\"../images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
   echo xhtmlfoot();
}


else


if($action=="vid")
{
  addonline(getuid_sid($sid),"Free Downloads","downloads/index.php?action=main");
 $pstyle = gettheme($sid);
      echo xhtmlhead("Free Downloads",$pstyle);
  echo "<p align=\"center\">";
  
  
  
  echo "<b><u></u>Free 3gp Videos</b><br/><br/>";
  
  
  echo "<u>English Videos!!</u><br/>";
  echo "<a href=\"evid/songs/xindex.php?action=main&amp;sid=$sid\">Songs</a><br/>";
   echo "<a href=\"evid/funy/xindex.php?action=main&amp;sid=$sid\">Funny Clips</a><br/><br/>";
   echo "<u>Sinhala Videos!!</u><br/>";
    echo "<a href=\"svid/songs/xindex.php?action=main&amp;sid=$sid\">Songs</a><br/>";
	 echo "<a href=\"svid/songs/xindex.php?action=main&amp;sid=$sid\">Funny Clips</a><br/>";
  
	
	  echo "Other Videos Comming Soon..<br/>";
  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"xindex.php?action=main&amp;sid=$sid\">back to Downloads</a><br/>";
  echo "<a href=\"../xhtml/index.php?action=main&amp;sid=$sid\"><img src=\"../images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
   echo xhtmlfoot();
}

else


if($action=="the")
{
  addonline(getuid_sid($sid),"Free Downloads","downloads/index.php?action=main");
 $pstyle = gettheme($sid);
      echo xhtmlhead("Free Downloads",$pstyle);
  echo "<p align=\"center\">";
  
  
  
  echo "<b><u>Free Themes</u></b><br/>";
  
   echo "<a href=\"themes/s40/xindex.php?action=main&amp;sid=$sid\"> NOKIA s40 themes</a><br/>";
	 echo "<a href=\"themes/c1/xindex.php?action=main&amp;sid=$sid\"> NOKIA s60 themes set-1</a><br/>";
	  echo "<a href=\"themes/c2/xindex.php?action=main&amp;sid=$sid\"> NOKIA s60 themes set-2</a><br/>";
	   echo "<a href=\"themes/n73/xindex.php?action=main&amp;sid=$sid\">n73, n80, n95 Themes</a><br/>";
	   
	 echo "<a href=\"themes/sethemes/xindex.php?action=main&amp;sid=$sid\">S. EricsoN ThemeS</a><br/>";
  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"xindex.php?action=main&amp;sid=$sid\">back to Downloads</a><br/>";
  echo "<a href=\"../xhtml/index.php?action=main&amp;sid=$sid\"><img src=\"../images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
   echo xhtmlfoot();
}


else


if($action=="18")
{
  addonline(getuid_sid($sid),"Free Downloads","downloads/index.php?action=main");
 $pstyle = gettheme($sid);
      echo xhtmlhead("Free Downloads",$pstyle);
  echo "<p align=\"center\">";
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  
  
  echo "<b><u></u></b><br/>";
  
  $nopl = mysql_fetch_array(mysql_query("SELECT sex, birthday, location FROM dcroxx_me_users WHERE id='".$who."'"));
  $uage = getage($nopl[1]);
	  echo "Ur age is <b><u>$uage</u></b><br/>and ur Birthday is $nopl[1] <br/>";
	if($uage>=18){


 
 
  echo "If these details r not correct DONT Click continue!<br/>";
  
   echo "(Service cost- 20 arawap credits)<br/>";

   echo "<a href=\"xindex.php?action=18c&amp;sid=$sid\">Ok, I want to continue</a><br/>";
	 echo "<a href=\"xindex.php?action=main&amp;sid=$sid\">No,Dont want to continue</a><br/>";
  

  }else{
         echo "<img src=\"../images/notok.gif\" alt=\"x\"/>U r too small to Enter this section. lol.<br/>";
       }
  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "This Section Files Brought U by Tharindudar<br/>";
  echo "<a href=\"xindex.php?action=main&amp;sid=$sid\">Back to Downloads</a><br/>";
  echo "<a href=\"../xhtml/index.php?action=main&amp;sid=$sid\"><img src=\"../images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
   echo xhtmlfoot();
}




else

if($action=="18c")
{
  addonline(getuid_sid($sid),"Free Downloads","downloads/index.php?action=main");
  $pstyle = gettheme($sid);
      echo xhtmlhead("Free Downloads",$pstyle);
  echo "<p align=\"center\">";
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  
  
  echo "<b><u></u></b><br/>";
  
  $nopl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));

	if($nopl[0]>=18){

echo "<u>English Sex</u><br/>";
echo "<a href=\"x/envid/xindex.php?action=main&amp;sid=$sid\">3gp Videos</a><br/>";
echo "<a href=\"x/enpic/xindex.php?action=main&amp;sid=$sid\">Photos</a><br/><br/><br/>";
echo "<u>Sri lanka Sex</u><br/>";

echo "<a href=\"x/slvid/xindex.php?action=main&amp;sid=$sid\">3gp Videos</a><br/>";
echo "<a href=\"x/slpic/xindex.php?action=main&amp;sid=$sid\">Photos</a>";
	
	
  mysql_query("UPDATE dcroxx_me_users SET plusses=plusses-20 WHERE id='".$who."'");
    echo "<br/><br/>-------<br/>20 credits were subtracted from you<br/>";
    $nopl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
    echo "You now have: $nopl[0] credits";
	

	$nicck = getnick_sid($sid);

 
	$brws = explode(" ",$HTTP_USER_AGENT);
	$ubr = $brws[0];
	$fp = fopen("x.txt","a+");
	fwrite ($fp,$nicck);
	fclose($fp);
	
 

  }else{
   $nick = getnick_sid($sid);
  $who = getuid_nick($nick);

          $nopl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
    echo "U shoud hv 20 Credits to enter this section<br/>
 Now you have: $nopl[0] credits";
	
	 echo "<br/>plz Read <a href=\"../xhtml/index.php?action=viewtpc&amp;sid=$sid&amp;tid=2040\"> How to Earn Much Credits??</a><br/>";
       }
  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"xindex.php?action=main&amp;sid=$sid\">Back to Downloads</a><br/>";
  echo "<a href=\"../xhtml/index.php?action=main&amp;sid=$sid\"><img src=\"../images/home.gif\" alt=\"*\"/>";
    echo "Home</a>";
	 echo "<br/>This Section Files Brought U by Tharindudar";
  echo "</p>";
   echo xhtmlfoot();
}


else


if($action=="s60app")
{
  addonline(getuid_sid($sid),"Free Downloads","downloads/index.php?action=main");
 $pstyle = gettheme($sid);
      echo xhtmlhead("Free Downloads",$pstyle);
  echo "<p align=\"left\">";

  
  
  echo "<b><u>Best s60 Apps Collection!</u></b><br/>";
  echo "<a href=\"../downloads/app/hot/xindex.php?action=main&amp;sid=$sid\">&#187; Hot and New!</a><br/>";
  echo "<a href=\"../downloads/app/ant/xindex.php?action=main&amp;sid=$sid\">&#187; AntiVirus</a><br/>"; 
  echo "<a href=\"../downloads/app/aupl/xindex.php?action=main&amp;sid=$sid\">&#187; Audio Players</a><br/>";
  echo "<a href=\"../downloads/app/vidpl/xindex.php?action=main&amp;sid=$sid\">&#187; Vidio Players</a><br/>";
  echo "<a href=\"../downloads/app/cam/xindex.php?action=main&amp;sid=$sid\">&#187; Camera Tools</a><br/>";
  echo "<a href=\"../downloads/app/sys/xindex.php?action=main&amp;sid=$sid\">&#187; System Tools</a><br/>";
  echo "<a href=\"../downloads/app/cal/xindex.php?action=main&amp;sid=$sid\">&#187; Call Managers</a><br/>";
  echo "<a href=\"../downloads/app/dwnm/xindex.php?action=main&amp;sid=$sid\">&#187; Download Managers</a><br/>";
  echo "<a href=\"../downloads/app/filem/xindex.php?action=main&amp;sid=$sid\">&#187; File Managers</a><br/>";
  
  echo "<a href=\"../downloads/app/callr/xindex.php?action=main&amp;sid=$sid\">&#187; Call Records</a><br/>";
  echo "<a href=\"../downloads/app/web/xindex.php?action=main&amp;sid=$sid\">&#187; Web Browsers</a><br/>";
  echo "<a href=\"../downloads/app/use/xindex.php?action=main&amp;sid=$sid\">&#187; Useful Apps</a><br/>";
  
  
  

  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"../xhtml/index.php?action=main&amp;sid=$sid\"><img src=\"../images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
   echo xhtmlfoot();
}








else
if($action=="get")
{
  addonline(getuid_sid($sid),"Free Downloads","downloads/index.php?action=main");
 $pstyle = gettheme($sid);
      echo xhtmlhead("Free Downloads",$pstyle);
  echo "<p align=\"center\">";
  
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  
  echo "<b><u>Withdraw Credits</u></b><br/>";
  echo "U can Get Back Ur Credits From AW Bank now.<br/>";
$credits = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
$arabank = mysql_fetch_array(mysql_query("SELECT arabank FROM dcroxx_me_users WHERE id='".$who."'"));
 
  echo "U have <b>$credits[0]</b> Credits in Pocket!<br/>";
    echo "U have <b>$arabank[0]</b> Credits in Bank!<br/>";
  echo "</p>";
  echo "<p>";  
  
    
   
  
    echo " <b>Type here the Amount U gonna Withdraw</b>  <br/>";
echo "<input name=\"tfgp\" format=\"*N\" maxlength=\"5\"/>";
  echo "<br/><anchor>withdraw now";


  
 echo "<go href=\"downloads/index-func.php?action=get&amp;sid=$sid&amp;who=$who\"
method=\"post\">";
 echo "<postfield name=\"ptg\" value=\"$(tfgp)\"/>";
 echo "</go></anchor>";
  
  
	
	
  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"../xhtml/index.php?action=main&amp;sid=$sid\"><img src=\"../images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
   echo xhtmlfoot();
}else

if($action=="dep")
{
  addonline(getuid_sid($sid),"Free Downloads","downloads/index.php?action=main");
  echo "<card id=\"main\" title=\"Free Downloads\">";
  echo "<p align=\"center\">";
  
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  
  echo "<b><u>Deposit Credits!</u></b><br/>";
  echo "
  
   *if u dont have much credits to deposit contact an online staff member and ask how to earn much credits.<br/>
  *U can deposit any amount of credits.<br/>
 *we add u 5% intersts in everyday.<br/>
 *U can withdraw ur Credits+interest in any time.<br/>

  
  <br/>";

  echo "<a href=\"downloads/index.php?action=dep1&amp;sid=$sid\">OK, I want to Deposit My credits Now</a>";
  
  echo "</p>";
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
  echo "<a href=\"../xhtml/index.php?action=main&amp;sid=$sid\"><img src=\"../images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
   echo xhtmlfoot();
}else


if($action=="mis")
{
  addonline(getuid_sid($sid),"Arawap Shop","downloads/index.php?action=main");
  echo "<card id=\"main\" title=\"Arawap Shop\">";
  echo "<p align=\"center\">";
  
  $nick = getnick_sid($sid);
  $who = getuid_nick($nick);
  
  echo "<b><u>Our Aim</u></b><br/>";
  echo " Hello $nick we r proud to say dat u r in da <i>1st wap-bank 
 in the world </i>, U can get an interests for ur hardly earned credits.Our target is to make wealthy ppl in da wap as wel as in real life,
 so be the best Transactor in our bank..Now other noobs may Copy us, but we Promise u, We do more than them! Maximum fUn from arawap! 
 <br/><b> Good Luck!! </b><br/>
 
 <i>-arawap team-</i><br/>";

  echo "</p>";
  
  ////// UNTILL HERE >> 
  echo "<p align=\"center\">";
   echo "<a href=\"downloads/index.php?action=main&amp;sid=$sid\">Back to Bank</a><br/>";
  echo "<a href=\"../xhtml/index.php?action=main&amp;sid=$sid\"><img src=\"../images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
   echo xhtmlfoot();
}

else
{
  addonline(getuid_sid($sid),"Lost","");
  $pstyle = gettheme($sid);
      echo xhtmlhead("Free Downloads",$pstyle);
  echo "<p align=\"center\">";
  echo "I don't know how did you get into here, but there's nothing to show<br/><br/>";
  echo "<a href=\"../xhtml/index.php?action=main&amp;sid=$sid\"><img src=\"../images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
  echo "</p>";
   echo xhtmlfoot();
}

?></wml>