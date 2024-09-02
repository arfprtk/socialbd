<?php
   session_name("PHPSESSID");
session_start();
//include("chkisdn.inc.php");
?>
<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> 
<body>
<?php
include("config.php");
include("core.php");
include("xhtmlfunctions.php");
$bcon = connectdb();
$uid = getuid_sid($sid);
$lang = mysql_fetch_array(mysql_query("SELECT lang FROM dcroxx_me_users WHERE id='".$uid."'"));
include("language.php");
if (!$bcon)
{
        echo "<p align=\"center\">";
    echo "<img src=\"images/exit.gif\" alt=\"*\"/><br/>";
    echo "ERROR! cannot connect to database<br/><br/>";
    echo "This error happens usually when backing up the database, please be patient, The site will be up any minute<br/><br/>";
    echo "<b>THANK YOU VERY MUCH</b>";
    echo "</p>";
echo "</font></body>";
echo "</html>";
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
      boxstart("Error!");

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
        boxend();
      exit();
      }
    }
if(($action != "") && ($action!="terms"))
{
    $uid = getuid_sid($sid);
    if((islogged($sid)==false)||($uid==0))
    {
    boxstart("Error!");

      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
boxend();
echo "</font></body></html>";
      exit();
    }



}
//echo isbanned($uid);
if(isbanned($uid))
    {
      $pstyle = gettheme($sid);

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
$res = mysql_query("UPDATE dcroxx_me_users SET browserm='".$ubr."', ipadd='".$uip."' WHERE id='".getuid_sid($sid)."'");
if(!isowner(getuid_sid($sid)))
  {

      echo "<p align=\"center\">";
      echo "You are not an owner<br/>";
      echo "<br/>";
      echo "<a href=\"index.php\">Home</a>";
      echo "</p>";
      exit();
    }
////////////////////////////////////////////////////
   if($action=="main")
{
    addonline(getuid_sid($sid),"pm2all - xHTML","");
$pstyle = gettheme($sid);
    echo xhtmlhead("Pm 2 all",$pstyle);
 echo "<p align=\"center\">";
echo "<small><a href=\"index.php?action=pmallmem\">Pm to club members</a> </small>";


echo" <center><small><b>Broadcast PM:</b></small><br/>
<form  action=\"pm2all.php?action=global\" method=\"post\">
<textarea name=\"pmtou\" style=\"height:30px;width: 270px;\" ></textarea><br/>
<select name=\"who\">
<option value=\"online\">All Online Users</option>
<option value=\"staff\">All Staffs</option>
<option value=\"owners\">All Owners</option>
<option value=\"admin\">All Admins</option>
<option value=\"mods\">All Moderators</option>
<option value=\"headadmin\">All Head Admin</option>
<option value=\"all\">All Members</option>
</select><br/>

<input type=\"submit\" name=\"Submit\" value=\"SEND\"/><br/>
</form></center>";

/*    echo "<form action=\"pm2all.php?action=global\" method=\"post\">";
  echo "PM:<input name=\"pmtou\" maxlength=\"250\"/><br/>";
  echo "TO:<select name=\"who\">";
  echo "<option value=\"online\">Online users</option>";
  echo "<option value=\"staff\">staff</option>";
 echo "<option value=\"owners\">owners</option>";
 echo "<option value=\"admin\">admin</option>";
 echo "<option value=\"mods\">mods</option>";
 echo "<option value=\"headadmin\">headadmin</option>";
  echo "<option value=\"all\">all members</option>";
  echo "</select><br/>";
  echo "<input type=\"submit\" value=\"Update\"/>";
  echo "</form>";*/
  
        /////////main menu footer
echo "<div class=\"footer\"><center><small>";
	     echo "<img src=\"images/home.gif\" alt=\"\"><a href=\"index.php?action=main\">Home</a> <br/>";
		
           echo "</small></center></div>";


    exit();
    }
/////////////////////////////////////////////////////////////
  else if($action=="global")
{
 addonline(getuid_sid($sid),"pm2all - xHTML","");
$pstyle = gettheme($sid);
    echo xhtmlhead("Pm 2 All",$pstyle);
 echo "<p align=\"center\">";
$who = $_POST["who"];
$pmtou = $_POST["pmtou"];
$byuid = getuid_sid($sid);

$tm = time();
if($who=="all"){
$lastpm = mysql_fetch_array(mysql_query("SELECT MAX(timesent) FROM dcroxx_me_private WHERE byuid='".$byuid."'"));
echo "All users has been send a pm<br/>";
$pms = mysql_query("SELECT id, name FROM dcroxx_me_users WHERE lastact>'".$tm24."'");
$tm = time();
while($pm=mysql_fetch_array($pms))
{
mysql_query("INSERT INTO dcroxx_me_private SET text='[b]Broadcast Message:[/b][br/]".$pmtou."[br/][small]This message was sent to all the members[/small]', byuid='".$byuid."', touid='".$pm[0]."', timesent='".$tm."'");
}
}else if($who=="staff"){
$lastpm = mysql_fetch_array(mysql_query("SELECT MAX(timesent) FROM dcroxx_me_private WHERE byuid='".$byuid."'"));
echo "All users has been send a pm<br/>";
$pms = mysql_query("SELECT id, name FROM dcroxx_me_users WHERE perm>'0'"); 
$tm = time();
while($pm=mysql_fetch_array($pms))
{
mysql_query("INSERT INTO dcroxx_me_private SET text='[b]Broadcast Message:[/b][br/]".$pmtou."[br/][small]This message was sent to all staff[/small]', byuid='".$byuid."', touid='".$pm[0]."', timesent='".$tm."'");
}
}

else if($who=="mods"){
$lastpm = mysql_fetch_array(mysql_query("SELECT MAX(timesent) FROM dcroxx_me_private WHERE byuid='".$byuid."'"));
echo "All users has been send a pm<br/>";
$pms = mysql_query("SELECT id, name FROM dcroxx_me_users WHERE perm='1'");
$tm = time();
while($pm=mysql_fetch_array($pms))
{
mysql_query("INSERT INTO dcroxx_me_private SET text='[b]Broadcast Message:[/b][br/]".$pmtou."[br/][small]This message was sent to all Mods[/small]', byuid='".$byuid."', touid='".$pm[0]."', timesent='".$tm."'");
}
}
else if($who=="owners"){
$lastpm = mysql_fetch_array(mysql_query("SELECT MAX(timesent) FROM dcroxx_me_private WHERE byuid='".$byuid."'"));
echo "All users has been send a pm<br/>";
$pms = mysql_query("SELECT id, name FROM dcroxx_me_users WHERE perm='4'"); 
$tm = time();
while($pm=mysql_fetch_array($pms))
{
mysql_query("INSERT INTO dcroxx_me_private SET text='[b]Broadcast Message:[/b][br/]".$pmtou."[br/][small]This message was sent to all owners[/small]', byuid='".$byuid."', touid='".$pm[0]."', timesent='".$tm."'");
}
}
else if($who=="admin"){
$lastpm = mysql_fetch_array(mysql_query("SELECT MAX(timesent) FROM dcroxx_me_private WHERE byuid='".$byuid."'"));
echo "All users has been send a pm<br/>";
$pms = mysql_query("SELECT id, name FROM dcroxx_me_users WHERE perm='2'");
$tm = time();
while($pm=mysql_fetch_array($pms))
{
mysql_query("INSERT INTO dcroxx_me_private SET text='[b]Broadcast Message:[/b][br/]".$pmtou."[br/][small]This message was sent to all admin[/small]', byuid='".$byuid."', touid='".$pm[0]."', timesent='".$tm."'");
}
}
else if($who=="headadmin"){
$lastpm = mysql_fetch_array(mysql_query("SELECT MAX(timesent) FROM dcroxx_me_private WHERE byuid='".$byuid."'"));
echo "All users has been send a pm<br/>";
$pms = mysql_query("SELECT id, name FROM dcroxx_me_users WHERE perm='3'");
$tm = time();
while($pm=mysql_fetch_array($pms))
{
mysql_query("INSERT INTO dcroxx_me_private SET text='[b]Broadcast Message:[/b][br/]".$pmtou."[br/][small]This message was sent to all head admin[/small]', byuid='".$byuid."', touid='".$pm[0]."', timesent='".$tm."'");
}
}
else if($who=="online"){
  $lastpm = mysql_fetch_array(mysql_query("SELECT MAX(timesent) FROM dcroxx_me_private WHERE byuid='".$byuid."'"));
echo "<p align=\"center\">";
  echo "All online users where sent this pm<br/>";
  $pms = mysql_query("SELECT userid FROM dcroxx_me_online");
  $tm = time();
  while($pm=mysql_fetch_array($pms))
  {
  mysql_query("INSERT INTO dcroxx_me_private SET text='[b]Broadcast Message:[/b][br/]".$pmtou."[br/][small][i]This message was sent to online users at this moment in time[/i][/small]', byuid='".$byuid."', touid='".$pm[0]."', timesent='".$tm."'");
  }
}
         /////////main menu footer
echo "<div class=\"footer\"><center><small>";
	     echo "<img src=\"images/home.gif\" alt=\"\"><a href=\"index.php?action=main\">Home</a> <br/>";
		
           echo "</small></center></div>";

    exit();
    }
//////////////////////////////////
?>
