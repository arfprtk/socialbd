<?php
session_name("PHPSESSID");
session_start();
include("config.php");
include("core.php");
include("xhtmlfunctions.php");
//session_start();
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\"\"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\"><meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";

echo "<head><title>$site_name</title>";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"html/style/style.css\" />";
echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
<meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
<meta name=\"description\" content=\"Chatheaven :)\"> 
<meta name=\"keywords\" content=\"free, community, forums, chat, wap, communicate\"></head>";
echo "<body>";


$bcon = connectdb();
if (!$bcon)
{
    echo "<img src=\"images/exit.gif\" alt=\"*\"/><br/>";
    echo "ERROR! cannot connect to database<br/><br/>";
    echo "This error happens usually when backing up the database, please be patient, The site will be up any minute<br/><br/>";
    echo "you can temperoray be in this site <a href=\"http://chatheaven.wen.ru\">$site_name</a> while $site_name is offline<br/>";
    echo "<b>THANK YOU VERY MUCH</b>";
    echo "</p>";
    echo "</html>";
    echo "</body>";
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
      echo "<p align=\"center\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
      echo "This IP address is blocked<br/>";
      echo "<br/>";
      echo "How ever we grant a shield against IP-Ban for our great users, you can try to see if you are shielded by trying to log-in, if you kept coming to this page that means you are not shielded, so come back when the ip-ban period is over<br/><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT timeto FROM dcroxx_me_penalties WHERE penalty='2' AND ipadd='".$uip."' AND browserm='".$ubr."' LIMIT 1 "));
      //echo mysql_error();
      $remain =  $banto[0] - time();
      $rmsg = gettimemsg($remain);
      echo " IP: $rmsg<br/><br/>";
      
      echo "</p>";
      echo "<p>";
  echo "<form align=\"left\" action=\"login.php\" method=\"post\" ENCTYPE=\"multipart/form-data\">";

  echo "UserID: <input name=\"loguid\" format=\"*x\" maxlength=\"30\"/><br/>";
  echo "Password: <input type=\"password\" name=\"logpwd\"  maxlength=\"30\"/><br/>";
  echo "<postfield name=\"loguid\" value=\"$(loguid)\"/>";
  echo "<postfield name=\"logpwd\" value=\"$(logpwd)\"/>";
  echo "<input type=\"submit\" value=\"Login!\"/><br/>";
  echo "</form>";
  echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
      }
   }
if(($action != "") && ($action!="terms"))
{
    $uid = getuid_sid($sid);
    if((islogged($sid)==false)||($uid==0))
    {
      
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a><br/><br/>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
    
    
    
}
//echo isbanned($uid);
if(isbanned($uid))
    {
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
      echo "</body>";
      echo "</html>";
      exit();
    }

///////////////////////////////GOLDLINEHOST//////////BY GLH WEB CREATION/////////

if($action=="uploader")
{
addvisitor();
addonline(getuid_sid($sid),"User Pic Uploader","");
   $pstyle = gettheme1($sid);
      echo xhtmlhead("Personal gallery",$pstyle);
$nick = getnick_sid($sid);
$uid = getuid_sid($sid);
echo "<center><b><small>Welcome $nick</small></b></center><br/>";
//get file name
if ($upload="upload"&&$file_name){
if (!eregi("\.(jpeg|jpg)$",$file_name)){
print "<small><b>Unsuported File extention!!!</b></small>";
}else{
$file_name = preg_replace(
             '/[^a-zA-Z0-9\.\$\%\'\`\-\@\{\}\~\!\#\(\)\&\_\^]/'
             ,'',str_replace(array(' ','%20'),array('_','_'),$file_name));
if(strlen($file_name)>53){ print "<b>File Name to long!!!</b>";
}else{
if (empty($file)) {
print "<small><b>No input file specified!!!</b></small>";
}else{
if (file_exists($file_name))
			{
			echo "<small>Pic already exists</small>";
			echo "<br /><small><a href=\"uploada.php\">Upload xhtml</a><br /></small>";
                  echo "<br /><small><img src=\"images/home.gif\" alt=\"*\"><a href=\"index.php\">Home</a><br /></small>";
                  print "</p></body></html>";
			exit();
			}

$pics = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM gallery where uid='".$uid."'"));
$cpic = $pics[0]+1;
$rev = strrev ($file_name);
$exp = explode (".", $rev);
$true = strrev ($exp[0]);
$trueext = strtolower ($true);
$picn = "$nick$cpic.$trueext";
copy("$file", "gallery/$file_name") or
die("Couldn't copy file.");
$adds = mysql_query("INSERT INTO gallery SET uid='".$uid."',file='$file_name'");
    if ($adds) {

          echo "<small>added pic $file_name</small><br/>";

         } else {

              echo "<small>Please try again</small><br/>";
           }


echo "<small>file has been successfully uploaded</small>";
}
}
}
}
?>
<?php
echo "<form align=\"left\" action=\"uploada.php?action=uploader&amp;who=$who\" method=\"post\" ENCTYPE=\"multipart/form-data\">
<small>Select File: </small><br/><input type=\"file\" name=\"file\" size=\"30\"/><br/>
<input type=\"submit\" value=\"Upload\"/><br/><br/>
<small><a href=\"galhelp1.php?action=main\">READ HERE FIRST!!!</a><br /></small>
<small><a href=\"pics.php?action=gallery&amp;who=$who\">View My Album</a><br /></small>
<small><img src=\"images/home.gif\" alt=\"*\"><a href=\"index.php?action=main\">Home</a><br /></small>";
}
echo "</form>
</body>
</html>";
?>
