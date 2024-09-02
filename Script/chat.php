<?
session_name("PHPSESSID");
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<meta http-equiv=\"Cache-Control\" content=\"no-cache\"/>
<meta name=\"description\" content=\":)\">
<meta name=\"keywords\" content=\"free, community, forums, chat, wap, communicate\"></head>
<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> 
<?php

include("config.php");
include("core.php");
include("xhtmlfunctions.php");

connectdb();          


$action=$_GET["action"];
$id=$_GET["id"];
$sid = $_SESSION['sid'];
$rid=$_GET["rid"];
$rpw=$_GET["rpw"];
$chat=$_GET["chat"];
$who=$_GET["who"];
$unick=$_GET["unick"];
$uid = getuid_sid($sid);
 $spin=$_GET["spin"];
  $idn=$_GET["idn"];
$cancel=$_GET["cancel"];
 $uexist = isuser($uid);
$time = date('dmHis');
if((islogged($sid)==false)||!$uexist)
    {
      $pstyle = gettheme($sid);
      echo xhtmlheadchat("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
  echo xhtmlfoot();
      exit();
    }




if(isbanned($uid))
    {
      $pstyle = gettheme($sid);
      echo xhtmlheadchat("$stitle",$pstyle);
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
		if(ischatbaned($uid)){
      $pstyle = gettheme($sid);
      echo xhtmlheadchat("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
      echo "You are Chat Banned By <b>Staff Team</b><br/>";
	  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"x\"/>Home</a>";
      echo "</p>";
  echo xhtmlfoot();
      exit();
    }
    $isroom = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_rooms WHERE id='".$rid."'"));
    if($isroom[0]==0)
    {
      $pstyle = gettheme($sid);
      echo xhtmlheadchat("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "This room doesn't exist anymore<br/>";
      echo ":P see in another room<br/><br/>";
      echo "<a href=\"index.php?action=chat\">Chatrooms</a>";
      echo "</p>";
      echo xhtmlfoot();
      exit();
    }
    $passworded = mysql_fetch_array(mysql_query("SELECT pass FROM dcroxx_me_rooms WHERE id='".$rid."'"));
    if($passworded[0]!="")
    {
      if($rpw!=$passworded[0])
      {
      $pstyle = gettheme($sid);
      echo xhtmlheadchat("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "You can't enter this room<br/>";
      echo ":P stay away<br/><br/>";
      echo "<a href=\"index.php?action=chat\">Chatrooms</a>";
      echo "</p>";
      echo xhtmlfoot();
      exit();
      }
    }
    if(!canenter($rid,$sid))
    {
      $pstyle = gettheme($sid);
      echo xhtmlheadchat("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "You can't enter this room<br/>";
      echo ":P stay away<br/><br/>";
      echo "<a href=\"index.php?action=chat\">Chatrooms</a>";
      echo "</p>";
      echo xhtmlfoot();
      exit();
    }
  if(!inside($uid, $rid))
    {
 if(!iscowner($uid, $rid))
    {
if(locked($uid, $rid))
    {
      echo "<p align=\"center\">";
      echo "This room is locked!<br/>";
      echo ":P Stay outside<br/><br/>";
      echo "<a href=\"index.php?action=chat&amp;type=send&amp;browse?start\">Chatrooms</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    }
}
}
 if(kick($uid, $rid))
    {

      echo "<p align=\"center\">";
      echo "You have been kicked from this room hekhek!<br/>";
      echo ":P Stay outside<br/><br/>";
      echo "<a href=\"index.php?action=chat&amp;type=send&amp;browse?start\">Chatrooms</a>";
      echo "</p>";
      echo "</body>";
      echo "</html>";
      exit();
    } 
	


    addtochat($uid, $rid);
        //This Chat Script is by Ra'ed Far'oun
        //raed_mfs@yahoo.tk
        //want to see main menu...
        $timeto = 300;
            $timenw = time();
            $timeout = $timenw-$timeto;
            $deleted = mysql_query("DELETE FROM dcroxx_me_chat WHERE timesent<".$timeout."");

        if ($action=="")
                         {

                     $pstyle = gettheme($sid);
        echo xhtmlheadchat1("$stitle Chat",$pstyle,$rid,$sid);

         //start of main card
       //  echo "<meta http-equiv=\"refresh\" content=\"20; URL= chat.php?action=$action&amp;rid=$rid\"/>";
        echo "<timer value=\"200\"/><p align=\"left\">";
          addonline($uid,"Chatrooms","");
       addplace($uid,"chat.php?rid=$rid&amp;rpw=$rpw","");
  echo "<small>
        <a href=\"chat.php?action=say&amp;rid=$rid&amp;rpw=$rpw\">Write</a><br/>";
        echo "<a href=\"chat.php?time=";
        echo date('dmHis');
        echo "&amp;rid=$rid&amp;rpw=$rpw";
        echo "\">Refresh</a><br/>";
		//<input id=\"inputText\" name=\"message\" type=\"text\" value=\"\" maxlength=\"2550\"/><br/>
echo "Message:<form action=\"chat.php?rid=$rid&amp;rpw=$rpw\" method=\"post\">
<textarea id=\"inputText\" name=\"message\" type=\"text\" value=\"\" style=\"height:30px;width: 270px;\" ></textarea><br/>";
echo "<input id=\"inputButton\" type=\"submit\" value=\"Send\"/>";
echo "</form>";
	 if(iscowner($uid, $rid))
             {
     if(!locked($uid, $rid))
    {

      echo "<small><a href=\"genproc.php?action=lock&amp;rid=$rid&amp;browse?start\">Lock</a></small><br/>";
    }else{
        echo "<small><a href=\"genproc.php?action=unlock&amp;rid=$rid&amp;browse?start\">Unlock</a></small><br/>";
    }
}
if(have())
    {
if($rid==804)
        {

$range_result = mysql_query( " SELECT MAX(`id`) AS max_id , MIN(`id`) AS min_id FROM `dcroxx_me_quiz` ");
$range_row = mysql_fetch_object( $range_result );
$random = mt_rand( $range_row->min_id , $range_row->max_id );
$result = mysql_query( " SELECT question, answer, id FROM `dcroxx_me_quiz` WHERE `id` >= $random LIMIT 0,1 ");
while($rpgds=mysql_fetch_array($result))
  {

 $winner =$rpgds[0];
$winner2 =$rpgds[1];
}

 $tm = time();
 $time = mysql_fetch_array(mysql_query("SELECT MAX(displaytime) FROM dcroxx_me_quizrooms ORDER by id LIMIT 1"));
  $pmfl = $time[0]+60;
  if($pmfl<$tm)
  {
   mysql_query("INSERT INTO dcroxx_me_chat SET  chatter='3', who='', timesent='".time()."', msgtext='Nobody got the correct answer. Next question.', rid='".$rid."';");
mysql_query("INSERT INTO dcroxx_me_quizrooms SET  displaytime='".time()."', question='".$winner."', answer='".$winner2."';");

 }else{
$quiz = mysql_query("SELECT question, answer, id FROM dcroxx_me_quizrooms ORDER BY id DESC LIMIT 1");
 while($rpgds=mysql_fetch_array($quiz))
  {
 $question =$rpgds[0];
$question2 =$rpgds[1];
$question3 =$rpgds[2];
}

echo "<br/><a href=\"index.php?action=viewuser&amp;who=3\">ChatGirl</a>: <font color=\"red\">$question</font>";
$rema = $pmfl - $tm;
if ($rema==60)
{
$kano ="100";

}else if ($rema==59)
{

$kano ="100";
}else if ($rema==58)
{

$kano ="90";
}else if ($rema==57)
{

$kano ="90";
}else if ($rema==56)
{

$kano ="80";
}else if ($rema==55)
{

$kano ="80";
}else if ($rema==54)
{

$kano ="80";
}else if ($rema==53)
{

$kano ="70";
}else if ($rema==52)
{

$kano ="70";
}else if ($rema==51)
{

$kano ="60";
}else if ($rema==50)
{

$kano ="50";
}else if ($rema==49)
{

$kano ="40";
}else if ($rema==48)
{

$kano ="40";
}else if ($rema==47)
{

$kano ="40";
}else if ($rema==46)
{

$kano ="40";
}else if ($rema==45)
{

$kano ="38";
}else if ($rema==44)
{

$kano ="38";
}else if ($rema==43)
{

$kano ="38";
}else if ($rema==42)
{

$kano ="38";
}else if ($rema==41)
{

$kano ="35";
}else if ($rema==40)
{

$kano ="35";
}else if ($rema==39)
{

$kano ="35";
}else if ($rema==38)
{

$kano ="35";
}else if ($rema==37)
{

$kano ="35";
}else if ($rema==36)
{

$kano ="35";
}else if ($rema==35)
{

$kano ="35";
}else if ($rema==34)
{

$kano ="35";
}else if ($rema==33)
{

$kano ="35";
}else if ($rema==32)
{

$kano ="35";
}else if ($rema==31)
{

$kano ="33";
}else if ($rema==30)
{

$kano ="33";
}else if ($rema==29)
{

$kano ="33";
}else if ($rema==28)
{

$kano ="33";
}else if ($rema==27)
{

$kano ="33";
}else if ($rema==26)
{

$kano ="33";
}else if ($rema==25)
{
$kano ="33";
}else if ($rema==24)
{

$kano ="30";
}else if ($rema==23)
{

$kano ="30";
}else if ($rema==22)
{

$kano ="30";
}else if ($rema==21)
{

$kano ="26";
}else if ($rema==20)
{

$kano ="26";
}else if ($rema==19)
{

$kano ="26";
}else if ($rema==18)
{

$kano ="26";
}else if ($rema==17)
{

$kano ="25";
}else if ($rema==16)
{

$kano ="25";
}else if ($rema==15)
{

$kano ="25";
}else if ($rema==14)
{

$kano ="20";
}else if ($rema==13)
{

$kano ="20";
}else if ($rema==12)
{

$kano ="20";
}else if ($rema==11)
{

$kano ="20";
}else if ($rema==10)
{

$kano ="18";
}else if ($rema==9)
{

$kano ="17";
}else if ($rema==8)
{

$kano ="17";
}else if ($rema==7)
{

$kano ="16";
}else if ($rema==6)
{

$kano ="15";
}else if ($rema==5)
{

$kano ="13";
}else if ($rema==4)
{

$kano ="10";
}else if ($rema==3)
{

$kano ="6";
}else if ($rema==2)
{

$kano ="5";
}else if ($rema==1)
{

$kano ="4";
}else if ($rema==0)
{

$kano ="0";
}
echo " <small>(Time left to answer: <b><font color=\"red\">$rema</font></b> seconds. Reward: <b><font color=\"red\">$kano</font></b> Plusses)</small>";
}
}
}
    if($rid==182)
        {

echo "<a href=\"chat.php?action=reset&amp;rid=182\">CLEAR DATA</a><br/>";
}
if($rid==454)
        {

$tries2 = mysql_fetch_array(mysql_query("SELECT cards FROM dcroxx_me_spincard"));
$mama2= $tries2[0];
if($mama2>0)
 {
if($spin==1)
        {

  $tm = time();
  $lastpm = mysql_fetch_array(mysql_query("SELECT MAX(spintime) FROM dcroxx_me_users WHERE id='".$uid."'"));
  $pmfl = $lastpm[0]+15;
  if($pmfl<$tm)
  {

     }else{

$rema = $pmfl - $tm;
echo "<a href=\"index.php?action=viewuser&amp;who=3\">ChatGirl</a>: you can spin cards again after <b>$rema</b> seconds.<br/>";
}
if(!spinned($uid))
    {
$rpgd = mysql_query("SELECT id, no FROM dcroxx_me_getcards ORDER by RAND() LIMIT 1");
 while($rpgds=mysql_fetch_array($rpgd))
  {

$cards =$rpgds[1];
}
 if(getplusses(getuid_sid($sid))<10)
    {
        echo "You need 10 plusses in order to spin the wheel!";
    }else{
 mysql_query("UPDATE dcroxx_me_users SET cards=cards+'$cards' WHERE id='".$uid."'");
 mysql_query("UPDATE dcroxx_me_spincard SET cards=cards-'$cards'");
 mysql_query("UPDATE dcroxx_me_users SET plusses=plusses-'1' WHERE id='".$uid."'");
 mysql_query("UPDATE dcroxx_me_users SET spintime='".time()."' WHERE id='".$uid."'");
 mysql_query("UPDATE dcroxx_me_users SET spinned='1' WHERE id='".$uid."'");
$mycards = mysql_fetch_array(mysql_query("SELECT cards FROM dcroxx_me_users WHERE id='".$uid."'"));
echo "<br/><a href=\"index.php?action=viewuser&amp;who=3\">ChatGirl</a>: you got $cards card(s) for that spin wait after 20 sec to spin cards again. You have $mycards[0] total of cards.<br/>";
  }

}
}else{

  $tm = time();
  $lastpm = mysql_fetch_array(mysql_query("SELECT MAX(spintime) FROM dcroxx_me_users WHERE id='".$uid."'"));
  $pmfl = $lastpm[0]+20;
  if($pmfl<$tm)
  {
mysql_query("UPDATE dcroxx_me_users SET spinned='0' WHERE id='".$uid."'");
$cinfo = mysql_fetch_array(mysql_query("SELECT cards from dcroxx_me_spincard"));
echo "<br/><a href=\"index.php?action=viewuser&amp;who=3\">ChatGirl</a>: There are $cinfo[0] remaining cards. 
Click <a href=\"chat.php?spin=1&amp;rid=$rid\">spin the wheel</a> spin cards to get some cards. Each spin will cost 1 plusses, 
if you got the highest number of cards after the remaining cards goes to zero, you will get the 1000 plusses prize more info for game info.<br/>";
     }else{

$rema = $pmfl - $tm;
echo "<br/><a href=\"index.php?action=viewuser&amp;who=3\">ChatGirl</a>: you can spin cards again after <b>$rema</b> seconds.<br/>";
}
}
}else{
$rpgd = mysql_query("SELECT id, cards FROM dcroxx_me_users ORDER by cards DESC LIMIT 1");
 while($rpgds=mysql_fetch_array($rpgd))
  {
 $winner =$rpgds[0];
$winner2 =$rpgds[1];
}
 $unick2 = getnick_uid($winner);
mysql_query("UPDATE dcroxx_me_spincard SET cards='500'");
mysql_query("INSERT INTO dcroxx_me_chat SET  chatter='3', timesent='".time()."', msgtext='$unick2 got $winner2 cards, and the 1000 plusses prize', perm='".$perm[0]."', rid='".$rid."';");
mysql_query("UPDATE dcroxx_me_users SET plusses=plusses+'1000' WHERE id='".$winner."'");
mysql_query("UPDATE dcroxx_me_users SET cards='0'");
mysql_query("UPDATE dcroxx_me_users SET spintime='0'");
}
}
      if($cancel==1)
        {
mysql_query("UPDATE dcroxx_me_private SET unread='0' WHERE id='".$idn."'");
}

 $unreadinbox=mysql_fetch_array(mysql_query("SELECT byuid, text, id FROM dcroxx_me_private WHERE unread='1' AND touid='".$uid."'"));
        $pmtotl=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE touid='".$uid."'"));
        $unrd="(".$unreadinbox[0]."/".$pmtotl[0].")";
        if ($unreadinbox[0]>0)
        {
$text = parsepm($unreadinbox[1], $sid);
$by = getnick_uid($unreadinbox[0]);
echo "<b>$by: </b>$text<br/>";
  echo "REPLY:<br/>";
 echo "<form action=\"inbxproc.php?action=sendpm&amp;who=$unreadinbox[0]&amp;rid=$rid\" method=\"post\">";
  echo "<input name=\"pmtext\" maxlength=\"500\"/><br/>";
  echo "<input type=\"submit\" value=\"Send\"/>";
  echo "</form>";
echo "<br/><a href=\"chat.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw&amp;cancel=1&amp;idn=$unreadinbox[2]&amp;time=$time\">Cancel</a>";
   }

   if($rid==182)
        {
     $uid = getuid_sid($sid);

$nopop = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_jnp WHERE touid='".$uid."' AND reply='1'"));
if($nopop[0]>0)
{
 $ncl = mysql_fetch_array(mysql_query("SELECT id, bet, byuid, touid FROM dcroxx_me_jnp WHERE touid='".$uid."' ORDER BY id DESC LIMIT 1"));
$by = getnick_uid($ncl[2]);
echo "Jack en Poy challenge from $by BET: $ncl[1]<br/>";
 echo "<form action=\"chat.php?action=jnp&amp;rid=$rid&amp;time=$time\" method=\"post\">";
    echo "JNP Challenge: <select name=\"kamay\">";
 echo "<option value=\"0\">Decline</option>";
 echo "<option value=\"1\">Paper</option>";
  echo "<option value=\"2\">Scissors</option>";
  echo "<option value=\"3\">Rock</option>";
  echo "</select>";
echo "<input type=\"hidden\" name=\"who\" value=\"$ncl[2]\"/>";
echo "<input type=\"hidden\" name=\"poy\" value=\"$ncl[0]\"/>";
echo "<input type=\"submit\" value=\"Send\"/>";
echo "</form>";
}
}
        $unreadinbox=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE unread='1' AND touid='".$uid."'"));
        $pmtotl=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE touid='".$uid."'"));
        $unrd="(".$unreadinbox[0]."/".$pmtotl[0].")";
        if ($unreadinbox[0]>0)
        {
        echo "<br/><a href=\"inbox.php?action=main\">Inbox$unrd</a>";
      }
      echo "</small></p>";
       $message=$_POST["message"];
        $who = $_POST["who"];
        $rinfo = mysql_fetch_array(mysql_query("SELECT censord, freaky FROM dcroxx_me_rooms WHERE id='".$rid."'"));
        if (trim($message) != "")
        {
          $nosm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_chat WHERE msgtext='".$message."'"));
          if($nosm[0]==0){



			$validated = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE id='".$uid."'  AND validated='0'"));
    if(($validated[0]>0)&&(validation()))
    {
echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
	echo "ur chat msg wont dispaly here,coz <b><a href=\"pmo.php?action=val\">U r not validated yet!</a></b>";

		  }else{
            $chatok = mysql_query("INSERT INTO dcroxx_me_chat SET  chatter='".$uid."', who='".$who."', timesent='".(time() - $timeadjust)."', msgtext='".$message."', rid='".$rid."';");
            $lstmsg = mysql_query("UPDATE dcroxx_me_rooms SET lastmsg='".(time() - $timeadjust)."' WHERE id='".$rid."'");

            $hehe=mysql_fetch_array(mysql_query("SELECT chmsgs FROM dcroxx_me_users WHERE id='".$uid."'"));
            $totl = $hehe[0]+1;
            $msgst= mysql_query("UPDATE dcroxx_me_users SET chmsgs='".$totl."' WHERE id='".$uid."'");


	if(!cancre())
{
$hehee=mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
            $totll = $hehee[0]+1;
            $msgst= mysql_query("UPDATE dcroxx_me_users SET plusses='".$totll."' WHERE id='".$uid."'");
}



			}


if($rid==804)
    {
$tid = correct($message,$question3);
  if($tid==0)
    {
 $by = getnick_uid($uid);
 mysql_query("INSERT INTO dcroxx_me_chat SET  chatter='3', timesent='".time()."', msgtext='$by sorry your answer is incorrect.Please try again', rid='".$rid."'");
  mysql_query("UPDATE dcroxx_me_users SET plusses=plusses-'3' WHERE id='".$uid."'");
    }else{
$range_result = mysql_query( " SELECT MAX(`id`) AS max_id , MIN(`id`) AS min_id FROM `dcroxx_me_quiz` ");
$range_row = mysql_fetch_object( $range_result );
$random = mt_rand( $range_row->min_id , $range_row->max_id );
$result = mysql_query( " SELECT question, answer, id FROM `dcroxx_me_quiz` WHERE `id` >= $random LIMIT 0,1 ");
while($rpgds=mysql_fetch_array($result))
  {

 $winner =$rpgds[0];
$winner2 =$rpgds[1];
}
 mysql_query("DELETE FROM dcroxx_me_quiz WHERE id='".$question3."'");
mysql_query("INSERT INTO dcroxx_me_quizrooms SET  displaytime='".time()."', question='".$winner."', answer='".$winner2."';");

 $by = getnick_uid($uid);
 mysql_query("INSERT INTO dcroxx_me_chat SET  chatter='3', who='".$who."', timesent='".time()."', msgtext='$by you are correct. $message  you got $kano plusses. Next question', rid='".$rid."'");
 mysql_query("UPDATE dcroxx_me_users SET plusses=plusses+'$kano' WHERE id='".$uid."'");
 mysql_query("UPDATE dcroxx_me_users SET gplus=gplus+'$kano' WHERE id='".$uid."'");
 mysql_query("DELETE FROM dcroxx_me_quizrooms WHERE id='".$question3."'");

}
 }
  $chatok = mysql_query("INSERT INTO dcroxx_me_chat SET  chatter='".$uid."', who='".$who."', timesent='".time()."', msgtext='".$message."', perm='".$perm[0]."', rid='".$rid."';");
            $lstmsg = mysql_query("UPDATE dcroxx_me_rooms SET lastmsg='".time()."' WHERE id='".$rid."'");

            $hehe=mysql_fetch_array(mysql_query("SELECT chmsgs FROM dcroxx_me_users WHERE id='".$uid."'"));
            $totl = $hehe[0]+1;
            $msgst= mysql_query("UPDATE dcroxx_me_users SET chmsgs='".$totl."' WHERE id='".$uid."'");
          if($rid!==454)
        {
if($rid!==182)
        {
            $hehe2=mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
            $totl2 = $hehe2[0]+1;
            $msgst2= mysql_query("UPDATE dcroxx_me_users SET plusses='".$totl2."' WHERE id='".$uid."'");
}
}
/*
if($rinfo[1]==2)
            {
              //oh damn i gotta post this message to ravebabe :(
              //will it succeed?
              $botid = "f71659fb4e369b0f";
              $hostname = "www.pandorabots.tk";
              $hostpath = "/pandora/talk-xml";
              $sendData = "botid=".$botid."&input=".urlencode($message)."&custid=".$custid;

              $result = PostToHost($hostname, $hostpath, $sendData);

              $pos = strpos($result, "custid=\"");
              $pos = strpos($result, "<that>");
    	if ($pos === false) {
    		$reply = "";
    	} else {
    		$pos += 6;
    		$endpos = strpos($result, "</that>", $pos);
    		$reply = unhtmlspecialchars2(substr($result, $pos, $endpos - $pos));
    		$reply = mysql_escape_string($reply);
    	}

    	$chatok = mysql_query("INSERT INTO dcroxx_me_chat SET  chatter='14', who='', timesent='".time()."', msgtext='".$reply." @".getnick_uid($uid)."', rid='".$rid."';");
            }
          }
          $message = "";
            }

            echo "<p>";
            echo "<small>";
            $chats = mysql_query("SELECT chatter, who, timesent, msgtext, exposed FROM dcroxx_me_chat WHERE rid='".$rid."' ORDER BY timesent DESC, id DESC");
            $counter=0;

            while($chat = mysql_fetch_array($chats))
            {
                $canc = true;


                if($counter<20)
                {
                  if(istrashed($chat[0])){
                        if($uid!=$chat[0])
                        {
                          $canc = false;
                        }
                  }
                //////good
                if(isignored($chat[0],$uid)){
                  $canc = false;
                }
                //////////good
                if($chat[0]!=$uid)
                {
                  if($chat[1]!=0)
                  {
                    if($chat[1]!=$uid)
                    {
                      $canc = false;
                    }
                  }
                }
if($chat[5]==3)
         {
        $chat[5] = "&#185;";

   }else if($chat[5]==2)
      {
      $chat[5] = "&#178;";
      }else if($chat[5]==1)
      {
        $chat[5] = "&#179;";
      }else if($chat[5]==0)
      {
        $chat[5] = "";
     }
                if($chat[4]=='1' && ismod($uid))
                {
                  $canc = true;
                }
                if($canc)
                {
                   $cmid = mysql_fetch_array(mysql_query("SELECT  chmood FROM dcroxx_me_users WHERE id='".$chat[0]."'"));

                   $iml = "";
                if(($cmid[0]!=0))
                {
                  $mlnk = mysql_fetch_array(mysql_query("SELECT img, text FROM dcroxx_me_moods WHERE id='".$cmid[0]."'"));
                  $iml = "<img src=\"$mlnk[0]\" alt=\"$mlnk[1]\"/>";

                }
                  $chnick = getnick_uid($chat[0]);
                    $optlink = $iml.$chnick;
                  if(($chat[1]!=0)&&($chat[0]==$uid))
                  {
                    ///out
                    $iml = "<img src=\"moods/out.gif\" alt=\"!\"/>";
                    $chnick = getnick_uid($chat[1]);
                    $optlink = $iml."PM to ".$chnick;
                  }
                  if($chat[1]==$uid)
                  {
                    ///out
                    $iml = "<img src=\"moods/in.gif\" alt=\"!\"/>";
                    $chnick = getnick_uid($chat[0]);
                    $optlink = $iml."PM by ".$chnick;
                  }
                    if($chat[4]=='1')
                  {
                    ///out
                    $iml = "<img src=\"moods/point.gif\" alt=\"!\"/>";
                    $chnick = getnick_uid($chat[0]);
                    $tonick = getnick_uid($chat[1]);
                    $optlink = "$iml by ".$chnick." to ".$tonick;
                  }

                  $ds= date("H.i.s", $chat[2]);
                  $text = parsepm($chat[3], $sid);
                  $nos = substr_count($text,"<img src=");
                  if(isspam($text))
                  {
echo "<br/>";
$chnick = getnick_uid($chat[0]);
                    echo "<b>Chat system:&#187;<i>*i love you! $chnick, wap.tk*</i></b><br/>";
                  }
                  else if($nos>2){
 echo "<br/>";
$chnick = getnick_uid($chat[0]);
                    echo "<b>Chat system:&#187;<i>*hey are u ok? $chnick, you can only use 2 smilies per msg*</i></b><br/>";
                  }else{
                    $sres = substr($chat[3],0,3);

                    if($sres == "/me")
                    {
                        $chco = strlen($chat[3]);
                        $goto = $chco - 3;
                        $rest = substr($chat[3],3,$goto);
                        $tosay = parsepm($rest, $sid);

                        echo "<b><i>*$chnick $tosay*</i></b><br/>";
                    }else{

                      $tosay = parsepm($chat[3], $sid);

                      if($rinfo[0]==1)
                      {
                         $tosay = str_replace("****","*this word rhymes with duck*",$tosay);
                         $tosay = str_replace("****","*dont swear*",$tosay);
                         $tosay = str_replace("dick","*ooo! you dirty person*",$tosay);
                         $tosay = str_replace("pussy","*angel flaps*",$tosay);
                         $tosay = str_replace("cock","*daddy stick*",$tosay);
                         $tosay = str_replace("can i be a mod","*im sniffing staffs ass*",$tosay);
						 $tosay = str_replace("can i be admin","*im a big ass kisser*",$tosay);

						 $tosay = str_replace("ginger","*the cute arsonist*",$tosay);
						 $tosay = str_replace("neon","*the cute but evil princess*",$tosay);
						 $tosay = str_replace("kaas","*the cheese boy*",$tosay);
						 $tosay = str_replace("slut","*s+m freak*",$tosay);
						 $tosay = str_replace("kahla","*lyrical lizard*",$tosay);


					   }

                      if($rinfo[1]==1)
                      {
                          $tosay = htmlspecialchars($chat[3]);
                          $tosay = strrev($tosay);
                        }
                   echo "<br/><a href=\"chat.php?action=say2&amp;who=$chat[0]&amp;rid=$rid&amp;rpw=$rpw\">$optlink$chat[5]</a>:$tosay";
                  }
                }

                  $counter++;
                }
                }
            }
            echo "</small>";
            echo "</p>";

        echo "<p align=\"left\">";
echo "<a href=\"chat.php?action=say&amp;rid=$rid&amp;rpw=$rpw\">Write</a><br/>";
        echo "<a href=\"chat.php?time=";
        echo date('dmHis');
        echo "&amp;rid=$rid&amp;rpw=$rpw";
        echo "\">Refresh</a>";
	if(ismod($uid))
  {
echo "<a href=\"lists.php?action=kicklist&amp;rid=$rid\">----Kick List</a>";
}
        $chatters=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_chonline where rid='".$rid."'"));
        echo "<br/><a href=\"chat.php?action=inside&amp;rid=$rid&amp;rpw=$rpw\">Who's Inside($chatters[0])</a><br/>";
        echo "<a href=\"index.php?action=chat\"> Chatrooms</a><br/>";
        echo "<a href=\"index.php?action=main\">Main Menu</a><br/>";


        echo "</body>";
}
*/
 if($rinfo[1]==2)
            {
              //oh damn i gotta post this message to ravebabe :(
              //will it succeed?
              $botid = "f2fa743c8e36fa8f";
              $hostname = "www.pandorabots.tk";
              $hostpath = "/pandora/talk-xml";
              $sendData = "botid=".$botid."&input=".urlencode($message)."&custid=".$custid;

              $result = PostToHost($hostname, $hostpath, $sendData);

              $pos = strpos($result, "custid=\"");
              $pos = strpos($result, "<that>");
    	if ($pos === false) {
    		$reply = "";
    	} else {
    		$pos += 6;
    		$endpos = strpos($result, "</that>", $pos);
    		$reply = unhtmlspecialchars2(substr($result, $pos, $endpos - $pos));
    		$reply = mysql_escape_string($reply);
    	}

    	$chatok = mysql_query("INSERT INTO dcroxx_me_chat SET  chatter='9', who='', timesent='".(time() - $timeadjust)."', msgtext='".$reply." @".getnick_uid($uid)."', rid='".$rid."';");
            }
          }
          $message = "";
            }

            echo "<p>";
            echo "<small>";
            $chats = mysql_query("SELECT chatter, who, timesent, msgtext, exposed FROM dcroxx_me_chat WHERE rid='".$rid."' ORDER BY timesent DESC, id DESC");
            $counter=0;

            while($chat = mysql_fetch_array($chats))
            {
                $canc = true;


                if($counter<15)
                {
                  if(istrashed($chat[0])){
                        if($uid!=$chat[0])
                        {
                          $canc = false;
                        }
                  }
                //////good
                if(isignored($chat[0],$uid)){
                  $canc = false;
                }
                //////////good
                if($chat[0]!=$uid)
                {
                  if($chat[1]!=0)
                  {
                    if($chat[1]!=$uid)
                    {
                      $canc = false;
                    }
                  }
                }
                if($chat[4]=='1' && ismod($uid))
                {
                  $canc = true;
                }
                if($canc)
                {
                   $cmid = mysql_fetch_array(mysql_query("SELECT  chmood FROM dcroxx_me_users WHERE id='".$chat[0]."'"));

                   $iml = "";
                if(($cmid[0]!=0))
                {
                  $mlnk = mysql_fetch_array(mysql_query("SELECT img, text FROM dcroxx_me_moods WHERE id='".$cmid[0]."'"));
                  $iml = "<img src=\"$mlnk[0]\" alt=\"$mlnk[1]\"/>";

                }
                  $chnick = getnick_uid($chat[0]);
                    $optlink = $iml.$chnick;
                  if(($chat[1]!=0)&&($chat[0]==$uid))
                  {
                    ///out
                    $iml = "<img src=\"moods/out.gif\" alt=\"!\"/>";
                    $chnick = getnick_uid($chat[1]);
                    $optlink = $iml."PM to ".$chnick;
                  }
                  if($chat[1]==$uid)
                  {
                    ///out
                    $iml = "<img src=\"moods/in.gif\" alt=\"!\"/>";
                    $chnick = getnick_uid($chat[0]);
                    $optlink = $iml."PM by ".$chnick;
                  }
                    if($chat[4]=='1')
                  {
                    ///out
                    $iml = "<img src=\"moods/point.gif\" alt=\"!\"/>";
                    $chnick = getnick_uid($chat[0]);
                    $tonick = getnick_uid($chat[1]);
                    $optlink = "$iml by ".$chnick." to ".$tonick;
                  }

                  $ds= date("H.i.s", $chat[2]);
                  $text = parsepm($chat[3], $sid);
                  $nos = substr_count($text,"<img src=");
                  if(isspam($text))
                  {
                    $chnick = getnick_uid($chat[0]);
                    echo "<a href=\"index.php?action=viewuser&amp;who=3\">ChatGirl</a>: <b><i>oi! $chnick,no spamming</i></b><br/>";
                  }
				  else if(isenta($text))
                  {
                    $chnick = getnick_uid($chat[0]);
                    echo "<font color=\"red\"><b><i>*$chnick enterd*</font></i></b></font><br/>";
                  }
                  else if($nos>2){
                    $chnick = getnick_uid($chat[0]);
                    echo "<a href=\"index.php?action=viewuser&amp;who=3\">ChatGirl</a>: <b><i>hey! $chnick,you can only use 2 smilies per msg</i></b><br/>";
                  }else{
                    $sres = substr($chat[3],0,3);

                    if($sres == "/aw")
                    {
                        $chco = strlen($chat[3]);
                        $goto = $chco - 3;
                        $rest = substr($chat[3],3,$goto);
                        $tosay = parsepm($rest, $sid);

                        echo "<b><i>*$chnick $tosay*</i></b><br/>";
                    }else{

                      $tosay = parsepm($chat[3], $sid);

                      if($rinfo[0]==1)
                      {

                         $tosay = str_replace("shit","*dont swear*",$tosay);
                         $tosay = str_replace("dick","*ooo! you dirty person*",$tosay);
                         $tosay = str_replace("pussy","*angel flaps*",$tosay);
                         $tosay = str_replace("cock","*daddy stick*",$tosay);
                         $tosay = str_replace("can i be a mod","*im sniffing staffs ass*",$tosay);
						 $tosay = str_replace("can i be admin","*im a big ass kisser*",$tosay);

						 $tosay = str_replace("ginger","*the cute arsonist*",$tosay);
						 $tosay = str_replace("neon","*the cute but evil princess*",$tosay);
						 $tosay = str_replace("kaas","*the cheese boy*",$tosay);
						 $tosay = str_replace("slut","*s+m freak*",$tosay);
						 $tosay = str_replace("kahla","*lyrical lizard*",$tosay);




					   }

                      if($rinfo[1]==1)
                      {
                          $tosay = htmlspecialchars($chat[3]);
                          $tosay = strrev($tosay);
                        }
$avlink = getavatar($chat[0]);
if ($avlink==""){
$avl ="<img src=\"images/nopic.jpg\" alt=\"avatar\" height=\"20\" width=\"20\"/>";
}else{
$avl ="<img src=\"$avlink\" alt=\"avatar\" height=\"20\" width=\"20\"/>";
}
                  echo "$avl<a href=\"chat.php?action=say2&amp;who=$chat[0]&amp;rid=$rid&amp;rpw=$rpw\">$optlink</a>: ";
                  echo $tosay."<br/>";
                  }
                }

                  $counter++;
                }
                }
            }
            echo "</small>";
            echo "</p>";

                   echo "<p align=\"left\"><small>";
				   
				echo"<b>Online Chatter:</b><br/>";   
$inside=mysql_query("SELECT DISTINCT * FROM dcroxx_me_chonline WHERE rid='".$rid."' and uid IS NOT NULL");
while($ins=mysql_fetch_array($inside)){
$who = $ins[1];
$noi = mysql_fetch_array(mysql_query("SELECT lastact FROM dcroxx_me_users WHERE id='".$who."'"));
$var1 = date("His",$noi[0]);
$var2 = time();
$var21 = date("His",$var2);
$var3 = $var21 - $var1;
$var4 = date("s",$var3);
$remain = time() - $noi[0];
$idle = gettimemsg($remain);
$idle2 = "- idle:";
$unick = getnick_uid($ins[1]);
$avlink = getavatar($ins[1]);
if ($avlink==""){
$avl ="<img src=\"images/nopic.jpg\" alt=\"avatar\" height=\"25\" width=\"25\"/>";
}else{
$avl ="<img src=\"$avlink\" alt=\"avatar\" height=\"25\" width=\"25\"/>";
}
//$userl = "$avl<a href=\"chat.php?action=say2&amp;who=$ins[1]&amp;rid=$rid&amp;rpw=$rpw\">$unick</a> $idle2 $idle<br/>";
$userl = "$avl<a href=\"chat.php?action=say2&amp;who=$ins[1]&amp;rid=$rid&amp;rpw=$rpw\">$unick</a>";
 echo "$userl,";
}			   
				   
       // $chatters=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_chonline where rid='".$rid."'"));
        //echo "<br/><a href=\"chat.php?action=inside&amp;rid=$rid&amp;rpw=$rpw\">Who's Inside($chatters[0])</a><br/>";
        echo "<br/><br/>";
        echo "<img src=\"images/uploader.gif\" alt=\"*\"><a href=\"index.php?action=chat\">Chatrooms</a><br/>";
        echo "<img src=\"images/home.gif\" alt=\"*\"><a href=\"index.php?action=main\">Home</a></small></p>";

}
/////////////////////////////////////////////////////SAY
        else if ($action=="options")                   {
  $pstyle = gettheme($sid);
    echo xhtmlhead("Chat",$pstyle);
        addonline($uid,"Chatroom Options","");

            echo "<form action=\"chat.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw\" method=\"post\">";
            echo "<p>Message:<input name=\"message\" type=\"text\" value=\"\" maxlength=\"255\"/><br/>";
            echo "<input type=\"submit\" value=\"Say\"/>";
            echo "</form><br/>";
            echo "<small><a href=\"lists.php?action=chmood&amp;page=1\">&#187;Chat mood</a></small><br/>";
            echo "<small><a href=\"chat.php?action=smilies&amp;rid=$rid&amp;rpw=$rpw\">&#187;Smilies</a></small><br/>";
            echo "<small><a href=\"chat.php?action=inside&amp;rid=$rid&amp;rpw=$rpw\">&#187;Who's Inside</a></small><br/>";
            echo "<small><a href=\"chat.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw\">&#171;Chatroom</a></small></p>";
        //end

        echo "<p align=\"center\"><a href=\"index.php?action=chat\"><img src=\"../images/chat.gif\" alt=\"*\"/>Chatrooms</a><br/>";
        echo "<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"*\"/>Home</a></p>";

        echo "</body>";
                                               }
               else if ($action=="say")                   {


        addonline($uid,"Writing Chat Message","");

            echo "<form action=\"chat.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw\" method=\"post\">";
            echo "<p>Message:<input name=\"message\" type=\"text\" value=\"\" maxlength=\"255\"/><br/>";
            echo "<input type=\"submit\" value=\"Say\"/>";
            echo "</form><br/>";
            //echo "<small><a href=\"lists.php?action=chmood&amp;page=1\">&#187;Chat mood</a></small><br/>";
            //echo "<small><a href=\"chat.php?action=inside&amp;rid=$rid&amp;rpw=$rpw\">&#187;Who's Inside</a></small><br/>";
            echo "<small><a href=\"chat.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw\">&#171;Back to room</a></small></p>";
        //end

        echo "<p align=\"center\"><a href=\"index.php?action=chat\"><img src=\"../images/chat.gif\" alt=\"*\"/>Chatrooms</a><br/>";
        echo "<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"*\"/>Home</a></p>";

        echo "</body>";
                                               }
     ////////////////////////////////////////////
    /////////////////////////////////////////////////////SAY2
        else if ($action=="say2")                   {
        echo "<p align=\"center\">";
        $unick = getnick_uid($who);
        echo "<b>Private to $unick</b>";
        echo "</p>";
        echo "<p align=\"left\">";
        addonline($uid,"Writing chat message","");
         if($rid==182)
        {
 echo "<form action=\"chat.php?action=jnpc&amp;rid=$rid&amp;time=$time\" method=\"post\">";
    echo "JNP Challenge: <select name=\"kamay\">";
  echo "<option value=\"1\">Paper</option>";
  echo "<option value=\"2\">Scissors</option>";
  echo "<option value=\"3\">Rock</option>";
  echo "</select>";
    echo "<br/>BET: <input name=\"bet\" maxlength=\"4\" size=\"3\" format=\"*N\"/><br/>";
echo "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
echo "<input type=\"submit\" value=\"Send\"/>";
echo "</form>";
}
            echo "<form action=\"chat.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw\" method=\"post\">";
            echo "Message:<input name=\"message\" type=\"text\" value=\" \" maxlength=\"255\"/><br/>";
            echo "<input type=\"submit\" value=\"Say\"/>";
            echo "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
            echo "</form>";
            echo "<small><a href=\"index.php?action=viewuser&amp;who=$who\">&#187;View $unick's Profile</a></small><br/>";
            echo "<small><a href=\"chat.php?action=expose&amp;who=$who&amp;rid=$rid&amp;rpw=$rpw\">&#187;Expose $unick</a></small><br/>";
                    if(iscowner($uid, $rid))
             {
     if(!kick($who, $rid))
    {

      echo "<a href=\"genproc.php?action=kick&amp;who=$who&amp;rid=$rid\">&#187;Kick</a><br/>";
    }else{
        echo "<a href=\"genproc.php?action=unkick&amp;who=$who&amp;rid=$rid\">&#187;Unkick</a><br/>";
    }
}

            echo "<small><a href=\"chat.php?action=inside&amp;rid=$rid&amp;rpw=$rpw\">&#187;Who's Inside</a></small><br/>";
            echo "<small><a href=\"chat.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw\">&#171;Back to room</a></small></p>";
        //end

        echo "<p align=\"center\"><a href=\"index.php?action=chat\"><img src=\"../images/chat.gif\" alt=\"*\"/>Chatrooms</a><br/>";
        echo "<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"*\"/>Home</a></p>";

        echo "</body>";
                                               }
        ////////////////////////////////////////////
        //////////////////////////////inside//////////
        else if ($action=="inside")           {
  $pstyle = gettheme($sid);
    echo xhtmlhead("Chat",$pstyle);
          addonline($uid,"Chat inside list","");
              echo "<p align=\"left\"><br/>";
        $inside=mysql_query("SELECT DISTINCT * FROM dcroxx_me_chonline WHERE rid='".$rid."' and uid IS NOT NULL");

        while($ins=mysql_fetch_array($inside))
        {

         $who = $ins[1];
$noi = mysql_fetch_array(mysql_query("SELECT lastact FROM dcroxx_me_users WHERE id='".$who."'"));
$var1 = date("His",$noi[0]);
$var2 = time();
$var21 = date("His",$var2);
$var3 = $var21 - $var1;
$var4 = date("s",$var3);
$remain = time() - $noi[0];
$idle = gettimemsg($remain);
$idle2 = "- idle:";



          $unick = getnick_uid($ins[1]);
          $userl = "<small><a href=\"chat.php?action=say2&amp;who=$ins[1]&amp;rid=$rid&amp;rpw=$rpw\">$unick</a> $idle2 $idle<br/></small>";
   
  echo "$userl";
        }
        echo "<br/><br/>";
        echo "<a href=\"chat.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw\">&#171;Back to room</a><br/>";
        echo "<br/><a href=\"index.php?action=chat\"><img src=\"../images/chat.gif\" alt=\"*\"/>Chatrooms</a><br/>";
        echo "<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"*\"/>Home</a></p>";

        echo "</body>";
                                           }
        else if ($action=="expose")           {

          addonline($uid,"Chat inside list","");
        echo "<card id=\"main\" title=\"Inside list\">";
        echo "<p align=\"center\"><br/>";
        mysql_query("UPDATE dcroxx_me_chat SET exposed='1' WHERE chatter='".$who."' AND who='".$uid."'");
        $unick = getnick_uid($who);
        echo "$unick messages to you have been exposed to staff";
        echo "<br/><br/>";
        echo "<a href=\"chat.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw\">&#171;Back to room</a><br/>";
        echo "<br/><a href=\"index.php?action=chat\"><img src=\"../images/chat.gif\" alt=\"*\"/>Chatrooms</a><br/>";
        echo "<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"*\"/>Home</a></p>";

        echo "</body>";
                                           }
        //////////////////////////////////Smilies :)

else if($action=="smilies")
{
    addonline(getuid_sid($sid),"Viewing The Smilies List","");
  $pstyle = gettheme($sid);
    echo xhtmlhead("Chat",$pstyle);
    echo "<small><a href=\"chat.php?action=options&amp;rid=$rid&amp;rpw=$rpw\">Options</a>, ";
    echo "<a href=\"chat.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw\">Chatroom</a><br/></small>";
    //////ALL LISTS SCRIPT <<

    if($page=="" || $page<=0)$page=1;
    $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_smilies"));
    $num_items = $noi[0]; //changable
    $items_per_page= 5;
    $num_pages = ceil($num_items/$items_per_page);
    if(($page>$num_pages)&&$page!=1)$page= $num_pages;
    $limit_start = ($page-1)*$items_per_page;

    //changable sql

        $sql = "SELECT id, scode, imgsrc FROM dcroxx_me_smilies ORDER BY id DESC LIMIT $limit_start, $items_per_page";


    echo "<p>";
    $items = mysql_query($sql);

    echo mysql_error();
    if(mysql_num_rows($items)>0)
    {
    while ($item = mysql_fetch_array($items))
   {
		if(isadmin(getuid_sid($sid)))
		{
			$delsl = "<a href=\"admproc.php?action=delsm&amp;smid=$item[0]\">[x]</a>";
		}else{
			$delsl = "";
		}
        echo "$item[1] &#187; ";
        echo "<img src=\"$item[2]\" alt=\"$item[1]\"/> $delsl<br/>";
    }
    }
    echo "</p>";
    echo "<p align=\"center\">";
    if($page>1)
    {
      $ppage = $page-1;
      echo "<a href=\"lists.php?action=smilies&amp;page=$ppage&amp;rid=$rid&amp;rpw=$rpw\">&#171;PREV</a> ";
    }
    if($page<$num_pages)
    {
      $npage = $page+1;
      echo "<a href=\"chat.php?action=smilies&amp;page=$npage&amp;rid=$rid&amp;rpw=$rpw\">Next&#187;</a>";
    }
    echo "<br/>$page/$num_pages<br/>";
    if($num_pages>2)
    {
      $rets = "Jump to page<input name=\"pg\" format=\"*N\" size=\"3\"/>";
        $rets .= "<anchor>[GO]";
        $rets .= "<go href=\"chat.php\" method=\"get\">";
        $rets .= "<postfield name=\"action\" value=\"$action\"/>";
        $rets .= "<postfield name=\"sid\" value=\"$sid\"/>";
        $rets .= "<postfield name=\"rid\" value=\"$rid\"/>";
        $rets .= "<postfield name=\"page\" value=\"$(pg)\"/>";
        $rets .= "</go></anchor>";

        echo $rets;
    }
    echo "</p>";
  ////// UNTILL HERE >>
    echo "<p align=\"center\">";
    echo "<a href=\"index.php?action=main\"><img src=\"../images/home.gif\" alt=\"*\"/>Home</a>";
    echo "</p>";
    echo "</body>";
}

    else if ($action=="jnpc")
  {
 $who = $_POST["who"];
          $bet =$_POST["bet"];
    $kamay =$_POST["kamay"];
$tnick = getnick_uid($who);
  echo "<p align=\"center\">";
  //$uid = getuid_sid($sid);

 if($uid==$who)
			{
     echo "Dont be so stupid to challenge your self!<br/>";
 }else{
if($bet<=19)
{
   echo "We accept above 20 bet to make a challenge!<br/>";
 }else{
if(chall($uid,$who))
    {
  echo "You have a pending challenge<br/>";
 }else{
 $gpsf = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
  $gpst = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
  if($gpsf[0]>=$bet)
{
 if($gpst[0]>=$bet)
{
    $res = mysql_query("INSERT INTO dcroxx_me_jnp SET touid='".$who."', byuid='".$uid."', hand='".$kamay."', reply='1', bet='".$bet."', actime='".time()."'");
  if($res)
        {

            echo "Jack en poy challenge with $bet Sent to $tnick<br/>";
        }else{
          echo "Database error<br/>";
        }
      }else{
          echo "Either you Or the recipient has insufficient plusses to complete this request!<br/>";
        }
        }else{
          echo "Either you Or the recipient has insufficient plusses to complete this request!<br/>";
        }

}
}
}
 echo "<a href=\"chat.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw&amp;type=send&amp;time=$time\">back to room</a><br/>";
  echo "</p>";
  echo "</body>";
}
  else if ($action=="jnp")
  {
 $who = $_POST["who"];

    $kamay =$_POST["kamay"];
$poy =$_POST["poy"];


  echo "<p align=\"center\">";
  //$uid = getuid_sid($sid);

 if($uid==$who)
			{
     echo "Dont be so stupid to challenge your self!<br/>";
 }else{
 $gpsf = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
  $gpst = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
 $number = mysql_fetch_array(mysql_query("SELECT hand, bet FROM dcroxx_me_jnp WHERE id='".$poy."'"));
$number2 = $number[0];
$bet2 = $number[1];
$plus = $number[1];
if($gpsf[0]>=$bet2)
{
 if($gpst[0]>=$bet2)
{
$unick = getnick_uid($uid);

if ($kamay=="1")
{
$pchoice = "Paper";
if ($number2 =="1")
{
                        $cchoice = "Paper";

                        echo_scores2($uid,$poy,$pchoice,$cchoice,drew);
                        $msg = "Challenge draw with $unick!"."";
			autopm($msg, $who);
  mysql_query("DELETE FROM dcroxx_me_jnp WHERE id='".$poy."'");


                    }
else if ($number2 =="2")
{

			$cchoice = "Scissors";
                      echo_scores2($uid,$poy,$pchoice,$cchoice,lost);
               mysql_query("UPDATE dcroxx_me_users SET plusses=plusses-'$number[1]' WHERE id='".$uid."'");
                mysql_query("UPDATE dcroxx_me_users SET plusses=plusses+'$plus' WHERE id='".$who."'");
          echo "$number[1] plusses has been deducted to your account";
                $msg = "You defeated $unick in your jack en poy challenge and you got $plus plusses."."";
			autopm($msg, $who);
                      mysql_query("DELETE FROM dcroxx_me_jnp WHERE id='".$poy."'");
 }
else if ($number2 =="3")
{

			$cchoice = "Rock";
                     echo_scores2($uid,$poy,$pchoice,$cchoice,won);
                   mysql_query("UPDATE dcroxx_me_users SET plusses=plusses-'$number[1]' WHERE id='".$who."'");
                mysql_query("UPDATE dcroxx_me_users SET plusses=plusses+'$plus' WHERE id='".$uid."'");
          echo "You won $plus plusses added to your account!";
                $msg = "You defeated by $unick $number[1] plusses has been deducted!"."";
			autopm($msg, $who);
                  mysql_query("DELETE FROM dcroxx_me_jnp WHERE id='".$poy."'");
                  }
else if ($number2 =="")
{

          echo "Not in game!";

                  }
}
if ($kamay=="2")
{
	$pchoice = "Scissors";
if ($number2 =="1")
{

			$cchoice = "Paper";
                    echo_scores2($uid,$poy,$pchoice,$cchoice,won);

                     mysql_query("UPDATE dcroxx_me_users SET plusses=plusses-'$number[1]' WHERE id='".$who."'");
                mysql_query("UPDATE dcroxx_me_users SET plusses=plusses+'$plus' WHERE id='".$uid."'");
          echo "You won $plus plusses added to your account!";
                $msg = "You defeated by $unick $number[1] plusses has been deducted!"."";
			autopm($msg, $who);
                  mysql_query("DELETE FROM dcroxx_me_jnp WHERE id='".$poy."'");
                    }
else if ($number2 =="2")
 {
                        $cchoice = "Scissors";
                     echo_scores2($uid,$poy,$pchoice,$cchoice,drew);
	           $msg = "Challenge draw with $unick!"."";
			autopm($msg, $who);
                    mysql_query("DELETE FROM dcroxx_me_jnp WHERE id='".$poy."'");

                    }
else if ($number2 =="3")
{

			$cchoice = "Rock";
                      echo_scores2($uid,$poy,$pchoice,$cchoice,lost);
                   mysql_query("UPDATE dcroxx_me_users SET plusses=plusses-'$number[1]' WHERE id='".$uid."'");
                mysql_query("UPDATE dcroxx_me_users SET plusses=plusses+'$plus' WHERE id='".$who."'");

                $msg = "You defeated $unick in your jack en poy challenge and you got $plus plusses."."";
			autopm($msg, $who);

             mysql_query("DELETE FROM dcroxx_me_jnp WHERE id='".$poy."'");
             }
else if ($number2 =="")
{

          echo "Not in game!";

                  }
}
if ($kamay=="3")
{
	$pchoice = "Rock";
if ($number2 =="1")
{

			$cchoice = "Paper";
                        echo_scores2($uid,$poy,$pchoice,$cchoice,lost);
		    mysql_query("UPDATE dcroxx_me_users SET plusses=plusses-'$number[1]' WHERE id='".$uid."'");
                mysql_query("UPDATE dcroxx_me_users SET plusses=plusses+'$plus' WHERE id='".$who."'");

                $msg = "You defeated $unick in your jack en poy challenge and you got $plus plusses."."";
			autopm($msg, $who);
                 mysql_query("DELETE FROM dcroxx_me_jnp WHERE id='".$poy."'");
                 }
else if ($number2 =="2")
{

			$cchoice = "Scissors";
                         echo_scores2($uid,$poy,$pchoice,$cchoice,won);

                    mysql_query("UPDATE dcroxx_me_users SET plusses=plusses-'$number[1]' WHERE id='".$who."'");
                mysql_query("UPDATE dcroxx_me_users SET plusses=plusses+'$plus' WHERE id='".$uid."'");
          echo "You won $plus plusses added to your account!";
                $msg = "You defeated by $unick $number[1] plusses has been deducted!"."";
			autopm($msg, $who);
                     mysql_query("DELETE FROM dcroxx_me_jnp WHERE id='".$poy."'");
                    }
else if ($number2 =="3") {
                        $cchoice = "Rock";
                        echo_scores2($uid,$poy,$pchoice,$cchoice,drew);
                     mysql_query("DELETE FROM dcroxx_me_jnp WHERE id='".$poy."'");
                 $msg = "Challenge draw with $unick!"."";
			autopm($msg, $who);
                          }
else if ($number2 =="")
{

          echo "Not in game!";

                  }
}
if ($kamay == 0) {
  if($kamay==0)
            {
              $msg = "declined";
            }else{
                $msg = "";
            }
echo "Challenge declined!<br/>";

              $msg = "".getnick_uid(getuid_sid($sid))." has $msg to your jack en poy challenge!"."";
			autopm($msg, $who);
mysql_query("DELETE FROM dcroxx_me_jnp WHERE touid='".$uid."' AND byuid='".$who."'");

    }
      }else{
          echo "Either you Or the recipient has insufficient plusses to complete this request!<br/>";

              $msg = "Either you Or the recipient has insufficient plusses to complete this request!"."";
			autopm($msg, $who);
mysql_query("DELETE FROM dcroxx_me_jnp WHERE id='".$poy."'");
        }
        }else{
          echo "Either you Or the recipient has insufficient plusses to complete this request!<br/>";
        }
   }
echo "<br/><a href=\"chat.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw&amp;type=send&amp;time=$time\">back to room</a><br/>";
  echo "</p>";
  echo "</body>";
exit();
}

/////////////////////////////////////////////
   else if ($action=="reset")
{



        echo "<p align=\"center\">DATA Reset Successfully";
        mysql_query("DELETE FROM dcroxx_me_jnp WHERE byuid='".$uid."'");
      echo "<br/><a href=\"chat.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw&amp;type=send&amp;time=$time\">back to room</a><br/>";
        echo "</p></body>";
             exit();
}

/////////////////////////////////////////////
if($action=="sendpm")
{
$pmtext = $_POST["pmtext"];
  echo "<p align=\"center\">";
  $whonick = getnick_uid($who);
  $byuid = getuid_sid($sid);
   if(($pmtext==""))
        {
     echo "Dont leave them empty!";
       }else{
$tm = time();
  $lastpm = mysql_fetch_array(mysql_query("SELECT MAX(timesent) FROM dcroxx_me_private WHERE byuid='".$byuid."'"));
  $pmfl = $lastpm[0]+getpmaf();
  if($byuid==1)$pmfl=0;
  if($pmfl<$tm)
  {
    if(!isblocked($pmtext,$byuid))
    {
    if((!isignored($byuid, $who))&&(!istrashed($byuid)))
    {
  $res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$pmtext."', byuid='".$byuid."', touid='".$who."', timesent='".$tm."'");
  }else{
    $res = true;
  }
  if($res)
  {

mysql_query("UPDATE dcroxx_me_private SET unread='0' WHERE id='".$idn."'");
    echo "PM was sent successfully to $whonick<br/><br/>";
    echo parsepm($pmtext, $sid);

  }else{
    echo "Can't Send PM to $whonick<br/><br/>";
  }
  }else{
    $bantime = time() + (7*24*60*60);

    echo "Can't Send PM to $whonick<br/><br/>";
    echo "You just sent a link to one of the crapiest sites on earth<br/> The members of these sites spam here a lot, so go to that site and stay there if you don't like it here<br/> as a result of your stupid action:<br/>1. you have lost your sheild<br/>2. you have lost all your plusses<br/>3. You are BANNED!";
    mysql_query("INSERT INTO dcroxx_me_penalties SET uid='".$byuid."', penalty='1', exid='1', timeto='".$bantime."', pnreas='Banned: Automatic Ban for spamming for a crap site'");
    mysql_query("UPDATE dcroxx_me_users SET plusses='0', shield='0' WHERE id='".$byuid."'");
    mysql_query("INSERT INTO dcroxx_me_private SET text='".$pmtext."', byuid='".$byuid."', touid='2', timesent='".$tm."'");
  }
  }else{
    $rema = $pmfl - $tm;
    echo "<img src=\"images/notok.gif\" alt=\"X\"/>";
    echo "Flood control: $rema Seconds<br/><br/>";
  }
}
  echo "<br/><a href=\"chat.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw&amp;type=send&amp;time=$time\">back to room</a><br/>";
$plc = mysql_fetch_array(mysql_query("SELECT saan FROM dcroxx_me_users WHERE id='".$uid."'"));

  echo "<a href=\"index.php?action=main\">";
echo "Home</a>";
  echo "</p>";
    echo "</body>";
exit();
}
?>
</html>
