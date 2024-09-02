<?php
session_name("PHPSESSID");
session_start();


header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\"\"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\">";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";

  include("config.php");
include("core.php");
include("xhtmlfunctions.php");
$bcon = connectdb();

$res = mysql_query("UPDATE dcroxx_me_users SET lastact='".time()."' WHERE id='250'");
if (!$bcon)
{



    echo "<head><title>$site_name</title>";
    echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/style.css\" />";
    echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
<meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
<meta name=\"description\" content=\"Riderz wap dating portal and community containg chat, forums, blogs and much more\" />
<meta name=\"keywords\" content=\"chat, forums, wap, dating, games, blogs, polls, quiz, lavalair, news, rap, goth\" /></head>";
echo"<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";
 echo "<body>";

    echo "<img src=\"images/exit.gif\" alt=\"*\"/><br/>";
    include("ad.php");
    echo "ERROR! cannot connect to database<br/><br/>";
    echo "This error happens usually when backing up the database, please be patient, The site will be up any minute<br/><br/>";
    echo "you can temperoray be in this site <a href=\"http://chatheaven.wen.ru\">$site_name</a> while $site_name is offline<br/>";
    echo "<b>THANK YOU VERY MUCH</b>";
    echo "</p>";

    echo "</body></html>";
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
$theme = mysql_fetch_array(mysql_query("SELECT theme FROM dcroxx_me_users WHERE id='".$uid."'"));
 $popuppm = mysql_fetch_array(mysql_query("SELECT popuppm FROM dcroxx_me_users WHERE id='".$uid."'"));
$uid = getuid_sid($sid);

cleardata();
if(isipbanned($uip,$ubr))
    {
      if(!isshield(getuid_sid($sid)))
      {


      echo "<head><title>$site_name</title>";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/style.css\" />";
      echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
      <meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
      <meta name=\"description\" content=\"Riderz wap dating portal and community containg chat, forums, blogs and much more\" />
      <meta name=\"keywords\" content=\"chat, forums, wap, dating, games, blogs, polls, quiz, lavalair, news, rap, goth\" /></head>";

     echo "<body>";

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
  echo "<form align=\"left\" action=\"login.php\" method=\"post\" ENCTYPE=\"multipart/form-data\">";

  echo "UserID: <input name=\"loguid\" format=\"*x\" maxlength=\"30\"/><br/>";
  echo "Password: <input type=\"password\" name=\"logpwd\"  maxlength=\"30\"/><br/>";
  echo "<postfield name=\"loguid\" value=\"$(loguid)\"/>";
  echo "<postfield name=\"logpwd\" value=\"$(logpwd)\"/>";
  echo "<input type=\"submit\" value=\"Login!\"/><br/>";
  echo "</form>";
  echo "</p>";

  echo "</body></html>";

      exit();
      }
   }
if(($action != "") && ($action!="terms"))
{
    $uid = getuid_sid($sid);
    if((islogged($sid)==false)||($uid==0))
    {

      echo "<head><title>$site_name</title>";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/style.css\" />";
      echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
      <meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
      <meta name=\"description\" content=\"Riderz wap dating portal and community containg chat, forums, blogs and much more\" />
      <meta name=\"keywords\" content=\"chat, forums, wap, dating, games, blogs, polls, quiz, lavalair, news, rap, goth\" /></head>";


echo "<body>";

      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a><br/><br/>";
      echo "</p>";

      echo "</body></html>";
      exit();
    }



}
//echo isbanned($uid);
if(isbanned($uid))
    {

      echo "<head><title>$site_name</title>";
      echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/style.css\" />";
      echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
      <meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
      <meta name=\"description\" content=\"Riderz wap dating portal and community containg chat, forums, blogs and much more\" />
      <meta name=\"keywords\" content=\"chat, forums, wap, dating, games, blogs, polls, quiz, lavalair, news, rap, goth\" /></head>";

echo "<body>";

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

     echo "</body></html>";
       exit();
    }

$res = mysql_query("UPDATE dcroxx_me_users SET browserm='".$brw."', ipadd='".$uip."' WHERE id='".getuid_sid($sid)."'");
addonline(getuid_sid($sid),"XHTML - Viewing Dating System","dating.php?action=main");
////////////////////////////////////////MAIN PAGE
if($action=="main")
{
		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
$result=mysql_query("select * from dcroxx_me_dating where cat='m4f'");
$mf = mysql_num_rows($result);

$result=mysql_query("select * from dcroxx_me_dating where cat='f4m'");
$fm = mysql_num_rows($result);

$result=mysql_query("select * from dcroxx_me_dating where cat='m4m'");
$mm = mysql_num_rows($result);

$result=mysql_query("select * from dcroxx_me_dating where cat='f4f'");
$ff = mysql_num_rows($result);

echo "<body>";
    if(stristr($HTTP_USER_AGENT,"Windows NT"))
{


 }else{
 }

    echo "<head><title>SocialBD</title>";
    //  echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
      echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
      <meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
      <meta name=\"description\" content=\"Riderz wap dating portal and community containg chat, forums, blogs and much more\" />
      <meta name=\"keywords\" content=\"chat, forums, wap, dating, games, blogs, polls, quiz, lavalair, news, rap, goth\" /></head>";
      echo "<body>";
echo "<p>";
echo "<img src=\"images/dating.gif\" alt=\"\"/><u><b>SocialBD-Dating</b></u><img src=\"images/dating.gif\" alt=\"\"/></p>";

echo "<p><img src=\"images/dating.gif\" alt=\"\"/><a title=\"Enter\" href=\"dating.php?action=datingview&amp;cat=m4f\">Guys for Girls</a>($mf)<br/>";

echo "<img src=\"images/dating.gif\" alt=\"\"/><a title=\"Enter\" href=\"dating.php?action=datingview&amp;cat=f4m\">Girls for Guys</a>($fm)<br/>";

echo "<img src=\"images/dating.gif\" alt=\"\"/><a title=\"Enter\" href=\"dating.php?action=datingview&amp;cat=m4m\">Guys for Guys</a>($mm)<br/>";

echo "<img src=\"images/dating.gif\" alt=\"\"/><a title=\"Enter\" href=\"dating.php?action=datingview&amp;cat=f4f\">Girls for Girls</a>($ff)<br/>";

echo "<br/><a title=\"Enter\" href=\"dating.php?action=add\">Add My Card</a>";
echo "<br/><a title=\"Enter\" href=\"index.php?action=main\">Home</a>";

echo "</p>";
              if(stristr($HTTP_USER_AGENT,"Windows NT"))
{

 }else{

 }
     echo "</body></html>";
}

else if($action=="datingview")
{
		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
	echo "<body>";
if(stristr($HTTP_USER_AGENT,"Windows NT"))
{

 }else{
 }
        echo "<head><title>SocailBD</title>";
     // echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
      echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
      <meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
      <meta name=\"description\" content=\"Riderz wap dating portal and community containg chat, forums, blogs and much more\" />
      <meta name=\"keywords\" content=\"chat, forums, wap, dating, games, blogs, polls, quiz, lavalair, news, rap, goth\" /></head>";
      echo "<body>";
 $cat=$_GET["cat"];
 $page=$_GET["page"];
 if($page=="")
	{
		$page=1;
	}
$max_results = 7;
$from = (($page * $max_results) - $max_results);
echo "<p>";
$total_results = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_dating WHERE cat='$cat'"));
if($total_results[0]<1)
{
	echo "No Profiles To Show Yet<br/>";
}else{
$total_pages = ceil($total_results[0] / $max_results);
echo "$page Of $total_pages<br/><br/>";

$sql = mysql_query("SELECT * FROM dcroxx_me_dating WHERE cat='$cat'  ORDER BY id desc LIMIT $from, $max_results");
while($row = mysql_fetch_array($sql)){
$name = $row['uid'];
$key = $row['id'];
$sqlthing = mysql_fetch_array(mysql_query("SELECT * FROM dcroxx_me_users WHERE id='$name'"));
$age=getage($sqlthing["birthday"]);
$uname=$sqlthing["name"];
echo "<a href=\"dating.php?action=card&amp;cat=$cat&amp;key=$key\">~$uname(Age: $age)~</a><br/>" ;


}

if($page < $total_pages){
    $next = ($page + 1);
    echo "<a href=\"dating.php?action=datingview&amp;page=$next&amp;cat=$cat\"><small>Next</small></a><br />";
}
if($page > 1){
    $prev = ($page - 1);
    echo "<a href=\"dating.php?action=datingview&amp;page=$prev&amp;cat=$cat\"><small>Prev</small></a><br/>";
}
$i = 1; $i <= $total_pages; $i++ ;
}
echo "<br/><a href=\"dating.php?action=main\">Dating Index</a>";
echo "</p>";
              if(stristr($HTTP_USER_AGENT,"Windows NT"))
{

 }else{

 }
echo "</body>";
}

else if($action=="card")
{
		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
$key=$_GET["key"];
$cat=$_GET["cat"];
$sql = mysql_fetch_array(mysql_query("SELECT * FROM dcroxx_me_dating WHERE id='$key'"));
$usid=$sql["uid"];
$who=$usid;
$name=getnick_uid($usid);
$about=$sql["aboutme"];
$looking=$sql["lookingfor"];
echo "<body>";
if(stristr($HTTP_USER_AGENT,"Windows NT"))
{

 }else{
 }
        echo "<head><title>SocialBD</title>";
    //  echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
      echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
      <meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
      <meta name=\"description\" content=\"Riderz wap dating portal and community containg chat, forums, blogs and much more\" />
      <meta name=\"keywords\" content=\"chat, forums, wap, dating, games, blogs, polls, quiz, lavalair, news, rap, goth\" /></head>";
      echo "<body>";
 echo "<p>";
echo "<b>*Username*</b><br/> <a href=\"index.php?action=viewuser&amp;who=$usid\">$name</a><br/><br/>";
echo "<b>*About*</b><br/> $about<br/><br/>";
echo "<b>*Looking For*</b><br/> $looking<br/>";

echo "<br/>";
echo "<a href=\"inbox.php?action=sendpm&amp;who=$usid\">[Send $name A PM]</a><br/><br/>";

 $uid = getuid_sid($sid);
  if(budres($uid, $who)==0)
  {
    echo "<a href=\"genproc.php?action=bud&amp;who=$who&amp;todo=add\">Add to buddy list</a><br/>";
  }else if(budres($uid, $who)==1)
  {
    echo "Queued Buddy Requests<br/>";
  }else if(budres($uid, $who)==2)
  {
    echo "<a href=\"genproc.php?action=bud&amp;who=$who&amp;todo=del\">Remove From buddy list</a><br/>";
  }
  $ires = ignoreres($uid, $who);
  if(es==2)
  {
    echo "<a href=\"genproc.php?action=ign&amp;who=$who&amp;todo=del\">Remove From Ignore list</a><br/>";
  }else if($ires==1)
  {
    echo "<a href=\"genproc.php?action=ign&amp;who=$who&amp;todo=add\">Add to Ignore list</a><br/>";
  }


echo "<a href=\"dating.php?action=datingview&amp;cat=$cat\">Back</a>";

echo "<br/><a href=\"dating.php?action=main\">Dating Index</a>";
echo "</p>";
              if(stristr($HTTP_USER_AGENT,"Windows NT"))
{

 }else{
}
 echo "</body>";
}

else if($action=="add")
{
		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
	echo "<body>";
	if(stristr($HTTP_USER_AGENT,"Windows NT"))
{

 }else{
 }        echo "<head><title>SocialBD</title>";
    //  echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
      echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
      <meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
      <meta name=\"description\" content=\"Riderz wap dating portal and community containg chat, forums, blogs and much more\" />
      <meta name=\"keywords\" content=\"chat, forums, wap, dating, games, blogs, polls, quiz, lavalair, news, rap, goth\" /></head>";
      echo "<body>";

 echo "<p>";
 echo "Here you can Place your own add in our dating system, simply enter the details below to add you card</p>";
echo "<form action=\"dating.php?action=add2\" method=\"post\">";
echo "<p>";
echo "About Me:<br/>";
echo "<small>hobbies intrests etc</small><br/>";
echo "<input name=\"aboutme\"/><br/>";
echo "Looking For:<br/>";
echo "<input name=\"lookingfor\"/><br/>";
echo "Your Gender:";
echo "<br/><select name=\"first\">";
echo "<option value=\"select\">select</option>";
echo "<option value=\"m\">M</option>";
echo "<option value=\"f\">F</option>";
echo "</select>";
echo "<br/>Gender wanted:";
echo "<br/><select name=\"second\">";
echo "<option value=\"select\">select</option>";
echo "<option value=\"m\">M</option>";
echo "<option value=\"f\">F</option>";
echo "</select>";
$ui=getuid_sid($sid);
echo "<input type=\"hidden\" name=\"ui\" value=\"$ui\"/>";
echo "<br/><input name=\"submit\" value=\"[Add My Card]\" type=\"submit\"/></p></form><p>";
echo "<a href=\"index.php?action=main\">Home</a></p>";

if(stristr($HTTP_USER_AGENT,"Windows NT"))
{

 }else{

 }
echo "</body>";
}

else if($action=="add2")
{
		 $pstyle = gettheme($sid);
      echo xhtmlhead("SocialBD",$pstyle);
		echo "<body>";
	if(stristr($HTTP_USER_AGENT,"Windows NT"))
{

 }else{
 }
      echo "<head><title>SocialBD</title>";
      //echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"style/$theme[0]\" />";
      echo "<meta http-equiv=\"Cache-Control\" content=\"must-revalidate\" />
      <meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
      <meta name=\"description\" content=\"Riderz wap dating portal and community containg chat, forums, blogs and much more\" />
      <meta name=\"keywords\" content=\"chat, forums, wap, dating, games, blogs, polls, quiz, lavalair, news, rap, goth\" /></head>";
      echo "<body>";
 echo "<p>";
$about=$_POST["aboutme"];
$looking=$_POST["lookingfor"];
$cat1=$_POST["first"];
$cat2=$_POST["second"];
$cat=$cat1."4".$cat2;
$ui=$_POST["ui"];
$result=mysql_query("select * from dcroxx_me_dating where uid='$ui' and cat='$cat'");
$number_of_rows = mysql_num_rows($result);
if ($number_of_rows>0){
$problems="1";
echo "You already have a card in this category! =p<br/>";
echo "<br/><a href=\"dating.php?action=main\">Dating Index</a><br/>";}
if ($problems==""){
echo "<img src=\"images/dating.gif\" alt=\"\"/>$sitename-Dating<img src=\"images/dating.gif\" alt=\"\"/><br/>";
$sql = "INSERT INTO dcroxx_me_dating (uid, cat, aboutme, lookingfor) VALUES ('$ui','$cat','$about','$looking')";
$result = mysql_query($sql);
echo "Cupids arrow has been fired, but were will it land?";
echo "<br/><a href=\"dating.php?action=main\">Dating Index</a><br/>";
}

echo "<a href=\"index.php?action=main\">Home</a></p>";

if(stristr($HTTP_USER_AGENT,"Windows NT"))
{

 }else{

 }
echo "</body>";
}

echo "</html>";
?>
