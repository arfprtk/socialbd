<?php
session_name("PHPSESSID");
session_start();
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
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

<meta property="place:location:latitude" content="3.1185996"/>
<meta property="place:location:longitude" content="101.5713278"/>
<meta property="business:contact_data:street_address" content="28,Jalan PJU 1a/8,Toman Perindustriyan Jaya,Kualalampur"/>
<meta property="business:contact_data:locality" content="Selangor"/>
<meta property="business:contact_data:postal_code" content="47301"/>
<meta property="business:contact_data:country_name" content="Malaysia"/>
<meta property="business:contact_data:email" content="fardin.ahsan@gmail.com"/>
<meta property="business:contact_data:phone_number" content="+60166912379"/>
<meta property="business:contact_data:website" content="http://socialbd.net"/>
<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> 
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
if(!ismod(getuid_sid($sid)))
{
  echo "<head>";
      echo "<title>$sitename</title>";
      //echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/white_medium.css\">";
      echo "</head>";
      echo "<body>";
  echo "<p align=\"center\"><small>";
  echo "<b>permission Denied!</b><br/>";
  echo "<br/>Only staff can use this page...<br/>";
  echo "<a href=\"index.php\">Home</a>";
  echo "</small></p>";
  echo "</body>";
  echo "</html>";
  exit();
}
$res = mysql_query("UPDATE ibwfrr_users SET browserm='".$ubr."', ipadd='".$uip."' WHERE id='".$uid."'");

if($action=="")
{
  //addvisitor();
  addonline(getuid_sid($sid),"OwnerCP","");
        $pstyle = gettheme($sid);
      echo xhtmlhead("Add Smilies",$pstyle);
      echo "<body>";

echo "<small>Maximum Size: <b>50 KB</b></small><br/><br/>";
echo "<form method=\"post\" enctype=\"multipart/form-data\" action=\"?action=upload\">
<small>Choose File: (32x32 is better size)</small><br/>
<INPUT TYPE=\"file\" NAME=\"file\" SIZE=\"20\"><br/>
<small>Code:</small><br/><INPUT TYPE=\"text\" NAME=\"codex\" SIZE=\"20\"><br/>
<INPUT TYPE=\"submit\" NAME=\"submit\" VALUE=\"ADD\">
</FORM>";
}
else if($action=="upload")
{
  addvisitor();
  addonline(getuid_sid($sid),"OwnerCP","");
          $pstyle = gettheme($sid);
      echo xhtmlhead("Add Smilies",$pstyle);

      echo "<body>";
	  
$uid = $_GET['who'];
if(isset($_FILES['file'])) { 
$file = $_FILES['file'];
$file = str_replace(' ','_',$file);
$nf = $file['name'];
$dotpos = strrpos($nf,'.');
$ft = substr($nf,$dotpos); 
// Detect Harmful extension and transform them into text format
if ($ft ==".php") { $ft =".txt";}
if ($ft ==".asp") { $ft =".txt";}
if ($ft ==".js") { $ft =".txt";}
if ($ft ==".so") { $ft =".txt";}
if ($ft ==".pl") { $ft =".txt";}
if ($ft ==".cgi") { $ft =".txt";}
if ($ft ==".shtml") { $ft =".txt";}
if ($ft ==".html") { $ft =".txt";}
if ($ft ==".phtml") { $ft =".txt";}
if ($ft ==".htm") { $ft =".txt";}
if ($ft ==".xml") { $ft =".txt";}
if ($ft ==".wml") { $ft =".txt";}
if ($ft ==".exe") { $ft =".txt";}
if ($ft ==".ini") { $ft =".txt";}
if ($ft ==".htaccess") { $ft =".txt";}
////// Determine File Types
$hf .= $ft;
if (!eregi("\.(gif|png)$",$nf)){
echo "<small>Only <b>.PNG</b> and <b>.GIF</b> file supported</small><br/>";} else {
$file = $file['tmp_name'];
if(copy($file,"smilies/$nf"))
{
$savat = "smilies/$nf";
$res = mysql_query("INSERT INTO dcroxx_me_smilies SET scode='".$_POST["codex"]."', imgsrc='".$savat."', byuid='".getuid_sid($sid)."'");
if($res){
echo "<img src=\"images/ok.gif\" alt=\"O\"/><small>Smilies Uploaded Successful</small><br/>";
} else {
echo "<img src=\"images/notok.gif\" alt=\"X\"/><small>Error Uploading!</small><br/>";}}}
}}

echo"<br/>";
echo"<small><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";

echo "</small></p>";
echo "</body>";
echo "</html>";
?>
