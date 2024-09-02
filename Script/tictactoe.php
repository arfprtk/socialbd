<?php
session_name("PHPSESSID");
session_start();
include("xhtmlfunctions.php");
include("config.php");
include("core.php");  connectdb();
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\"\"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\"><meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
echo '<head>';
echo "<link rel=\"StyleSheet\" type=\"text/css\" href=\"SocialBD.css\" /><link rel=\"shortcut icon\" href=\"favicon.ico\"/>";
echo "<meta name=\"title\" content=\"SocialBD.NeT\">
<meta name=\"descriptions\" content=\"free, community, forums, chat, wap, community, download\">
<meta name=\"messgeses\" content=\"MSG From IT Development Center: Don't Try To Hack OR else :P\">
<meta name=\"keywords\" content=\"Site Desined By IT Development Center :) :)\">
<meta name=\"Content-Type\" content=\"text/html\" charset=\"utf-8\"/>
<meta name=\"robots\" content=\"index,all,follow\"/></head>";
echo "<body>";
$ubr=$_SERVER['HTTP_USER_AGENT'];
$uip = getip();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$who = $_GET["who"];
$uid=getuid_sid($sid);
////////////////Ip Banned By IT Development Center :)	
   if(islogged($sid)==false)
    {
      $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle Bank",$pstyle);
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
      echo xhtmlhead("$stitle Bank",$pstyle);
      echo "<p align=\"center\">";
      echo "<img src=\"images/notok.gif\" alt=\"x\"/><br/>";
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

  
////////////////////////Start
if ($action==""){
addonline($uid,"Tic Tac Toe","");
	    echo "<head>";
    echo "<title>Tic Tac Toe</title>";
    echo "</head>";
    echo "<body>";
echo "<div class=\"div\" align=\"center\">";
echo "<b>Tic Tac Toe</b></div>";
  echo "<div class=\"penanda\">";
  
echo "<a href=\"ttt.php\">Tic Tac Toe (With Computer)</a><hr/>";
echo "<a href=\"tictactoe.php?action=new\">Tic Tac Toe (With Human)</a><hr/>";
echo"<a href=\"tictactoe.php?action=tutorial\">Tic Tac Toe Tutorial</a><hr/>";
echo "<a href=\"tictactoe.php?action=running\">Watch a Running TTT Game</a><hr/>";

}
else if ($action=="invite"){
	
		    echo "<head>";
    echo "<title>Tic Tac Toe</title>";
    echo "</head>";
    echo "<body>";
include("header.php");
echo "<div class=\"div\" align=\"center\">";
echo "<b>Tic Tac Toe</b></div>";
  echo "<div class=\"penanda\">";
	        $whonick=$_POST["whonick"];
		$who = $_GET["who"];
		if(!$who){
			$who=getuid_nick($whonick);
		}
		$tm=time();
addonline($uid,"Inviting ".getnick_uid($who)." for Tic Tac Toe","");
if (isonline($who)){
$tsid=mysql_fetch_array(mysql_query("SELECT id FROM dcroxx_me_ses WHERE uid=$who AND expiretm>$tm"));
mysql_query("INSERT INTO tictactoe SET player1=$uid, player2=$who, turn=2, lturntime=$tm, accepted=0");
$gameid=mysql_fetch_array(mysql_query("SELECT id FROM tictactoe WHERE lturntime=$tm"));
$msg="[url=index.php?action=viewuser&sid=$tsid[0]&who=$uid]".getnick_uid($uid)."[/url] has invited you for a Tic Tac Toe game. Please 
	[url=tictactoe.php?action=accept&gameid=$gameid[0]&sid=$tsid[0]]click here[/url] to accept this invite or ignore this message
	 to reject the invite. This invite will auto expire in 5 minutes.";
	// autopm($msg,$who);
 mysql_query("INSERT INTO dcroxx_me_private SET text='[url=".getnick_uid($uid)."]".getnick_uid($uid)."[/url] has invited you for a Tic Tac Toe game. Please [url=tictactoe.php?action=accept&gameid=$gameid[0]]click here[/url] to accept this invite or ignore this message to reject the invite. This invite will auto expire in 5 minutes.', byuid='3', touid='".$who."', timesent='".time()."'");

	 
	 $flag=1;}else{$flag=0;}
if($flag){
echo "<br/>Your invitation for tic tac toe has been sent successfully to ".getnick_uid($who).". Please wait till s/he accepts your invite. 
You will be notified when your invitation is accepted. Your invite will expire in 5 minutes.<br/>";
}
else{
	echo "<br/>It seems that ".getnick_uid($who)." is offline so the invite couldn't be sent. Try with an online user.<br/>";
}

}

else if ($action=="accept"){
	echo "<head>";
    echo "<title>Tic Tac Toe</title>";
    echo "</head>";
    echo "<body>";
echo "<div class=\"div\" align=\"center\">";echo "<b>Tic Tac Toe</b></div>";
  echo "<div class=\"penanda\">";
	$gameid=$_GET["gameid"];
	$quer=mysql_query("UPDATE tictactoe SET accepted=1 WHERE id=$gameid");
	$quer=mysql_query("INSERT INTO ttt SET gameid=$gameid");
	$sql=mysql_fetch_array(mysql_query("SELECT * FROM tictactoe WHERE id=$gameid"));
	addonline($uid,"Accepting ".$sql[1]."'s Tic Tac Toe invitation","");
	$tsid=mysql_fetch_array(mysql_query("SELECT id FROM dcroxx_me_ses WHERE uid='".$sql[1]."'"));
//$msg="Your invitation for Tic Tac Toe to ".getnick_uid($sql[2])." was accepted. [url=tictactoe.php?action=game&sid=$tsid[0]&gameid=$gameid]click here[/url] to play.";
	// autopm($msg,$sql[1]);	
 mysql_query("INSERT INTO dcroxx_me_private SET text='Your invitation for Tic Tac Toe to ".getnick_uid($sql[2])." was accepted. [url=tictactoe.php?action=game&gameid=$gameid]click here[/url] to play.', byuid='3', touid='".$sql[1]."', timesent='".time()."'");

echo "<br/>You have accepted the invitation successfully. <a href=\"tictactoe.php?action=game&amp;gameid=$gameid\">Click here</a> to proceed and play.<br/>";

}

//////////////////////////new game
else if ($action=="new"){
addonline($uid,"2 Player TTT menu","");
	    echo "<head>";
    echo "<title>Tic Tac Toe</title>";
    echo "</head>";
    echo "<body>";
echo "<div class=\"div\" align=\"center\">";echo "<b>Tic Tac Toe</b></div>";
  echo "<div class=\"penanda\">";
   
echo "Enter the name of user with whom you want to play TicTacToe. The invite will be sent only if the user is online within past 5 minutes.<br/>
Or, you may also open a user's profile by clicking his/her name in online list and click <b>Invite for TicTacToe</b> under actions.<br/><br/>
<form action=\"tictactoe.php?action=invite\" method=\"post\">
Enter Username To Invite:<br/><input id=\"inputText\" type=\"text\" name=\"whonick\" maxlength=\"30\"/><br/>
<input id=\"inputButton\" type=\"submit\" name=\"submit\" value=\"Invite To Play\" class=\"div\"/>
</form>";
}
//////////////////////////new game
else if ($action=="tutorial"){
addonline($uid,"2 player TTT tutorial","");
	    echo "<head>";
    echo "<title>Tic Tac Toe</title>";
    echo "</head>";
    echo "<body>";
echo "<div class=\"div\" align=\"center\">";echo "<b>Tic Tac Toe</b></div>";
  echo "<div class=\"penanda\">";
   
echo "
SocialBD presents Biplayer TicTacToe in which you can play that rather familiar old school nostalgic <i>zero-katto</i> game to recall 
those boring history periods where everyone fought to sit on the last bench!!! Jokes apart, lets see how to play the online version of 
this game.<br/><br/>You can play this game with any SocialBD user whose <b>Last Active</b> time is not more than 5 minutes in the <b>Online List</b>.<br/><br/>
Step1 - In <b>Online List</b> click the name of user with whom you wanna play the game, to open his/her profile.<br/>
Step2 - Scroll down and click <b>Invite for TicTacToe</b> link, which is located just under the <b>Send Message</b> box.<br/>
Step3 - Now that user will immediately receive a text message from <b>SocialBD</b>. The message contains a link, clicking which will make him/her 
accept your invite. If that user isn't interested in the game right then, s/he can ignore the message and invitation will expire after 5 minutes automatically.<br/>
Step4 - If that user has accepted your invite, the you'll immediately receive a text message from <b>SocialBD</b> with a link to the game. Click the link to join the game.<br/>
Step5 - The 1st turn will be of the user whom you invited and will have a zero(0), you'll have a cross(X).<br/>
Step6 - Click the <b>Refresh</b> link to see whether the opponent has moved or not. If s/he hasn't moved, refresh again after 5-10 seconds to check the status. You can also use your phone/PC browser's refresh button to check the status.<br/>
Step7 - As soon as your opponent has moved, its your turn which will be indicated just above the game board. Click the box in which you want to make the move and click the <b>Move</b> button just below the board.<br/>
Step8 - Meanwhile your opponent can click <b>Refresh</b> after 5-10 seconds interval to check whether you've moved or not.<br/>
Step9 - The game may end in a draw or may end with someone's win. In either case both the players will be notified. The winner is created with 
100 game points and 25 game points are deducted from the looser's. 10 points will be added to both user's profiles if the game is drawn.<br/>
<b>Note</b> - 1.<i>If the player whose current turn it is, doesn't move for 5 minutes, the game is automatically expired.</i><br/>
2.<i>If while a running game, you navigate any other part of site, like shoutbox or inbox then use your browser's back button to return back to the game.</i>
";
}

//////////////////////////running games
else if ($action=="running"){
addonline($uid,"Running TTT Games list","");
	    echo "<head>";
    echo "<title>Tic Tac Toe</title>";
    echo "</head>";
    echo "<body>";
echo "<div class=\"div\" align=\"center\">";echo "<b>Tic Tac Toe</b></div>";
  echo "<div class=\"penanda\">";
$query=mysql_query("SELECT id, player1, player2 FROM tictactoe WHERE 1=1");
if(mysql_num_rows($query)==0){
	echo "No games are currently in progress. Please try again later.";
}
else{
	echo "Following games are currently in progress. Click one to watch:<br/><br/>";
while($data=mysql_fetch_array($query)){
	echo "<a href=\"tictactoe.php?action=watch&amp;gameid=$data[0]\">".getnick_uid($data[1])." VS. ".getnick_uid($data[2])."</a><hr/>";

}
}
}
//////////////////////////stats
else if ($action=="stats"){
	$who=$_GET["who"];
	$list=$_GET["list"];
	$whonick=getnick_uid($who);
addonline($uid,"TTT Stats for $whonick","");
	    echo "<head>";
    echo "<title>Tic Tac Toe</title>";
    echo "</head>";
    echo "<body>";
echo "<div class=\"div\" align=\"center\">";echo "<b>Tic Tac Toe</b></div>";
  echo "<div class=\"penanda\">";
echo "<center>The following stats are of games played after 13/09/2008. Details of games played before this date aren't available.</center><br/>";
if($list=="win"){
$query=mysql_query("SELECT player2 FROM tttstats WHERE player1=$who AND result=1");
if(mysql_num_rows($query)==0){
	echo "<center>$whonick hasn't defeated anyone in a TTT game.</center>";
}
else{
echo "Following players have been defeated by $whonick in biplayer TTT games:<br/>";
while($data=mysql_fetch_array($query)){
	echo "<a href=\"".getnick_uid($data[0])."\">".getnick_uid($data[0])."</a><br/>";
}
}
}
else if($list=="lost"){
$query=mysql_query("SELECT player1 FROM tttstats WHERE player2=$who AND result=1");
if(mysql_num_rows($query)==0){
	echo "<center>$whonick hasn't lost to anyone in any TTT game.</center>";
}
else{
echo "Following players have defeated $whonick in biplayer TTT games:<br/>";
while($data=mysql_fetch_array($query)){
	echo "<a href=\"".getnick_uid($data[0])."\">".getnick_uid($data[0])."</a><br/>";
}
}
}
else if($list=="drawn"){
$query=mysql_query("SELECT player1 FROM tttstats WHERE player2=$who AND result=0");
$query1=mysql_query("SELECT player2 FROM tttstats WHERE player1=$who AND result=0");

if((mysql_num_rows($query)==0) && (mysql_num_rows($query1)==0)){
	echo "<center>$whonick hasn't played any TTT game that ended in a draw.</center>";
}
else{
echo "Following players have played drawn TTT games with $whonick:<br/>";
while($data=mysql_fetch_array($query)){
	echo "<a href=\"".getnick_uid($data[0])."\">".getnick_uid($data[0])."</a><br/>";
}
while($data=mysql_fetch_array($query1)){
	echo "<a href=\"".getnick_uid($data[0])."\">".getnick_uid($data[0])."</a><br/>";
}
}
}
else{
	echo "
	TTT stats for $whonick:<br/>
	&#187;<a href=\"tictactoe.php?action=stats&amp;who=$who&amp;list=win\">Won Games</a><br/>
	&#187;<a href=\"tictactoe.php?action=stats&amp;who=$who&amp;list=lost\">Lost Games</a><br/>
	&#187;<a href=\"tictactoe.php?action=stats&amp;who=$who&amp;list=drawn\">Drawn Games</a>";
}	
}

/////////////////////////////////////Watch the game//////////////////////////////
else if ($action=="watch"){
	    echo "<head>";
    echo "<title>Tic Tac Toe</title>";
    echo "</head>";
    echo "<body>";
echo "<div class=\"div\" align=\"center\">";echo "<b>Tic Tac Toe</b></div>";
  echo "<div class=\"penanda\">";

	$gameid=$_GET["gameid"];
	$players=mysql_fetch_array(mysql_query("SELECT player1, player2 FROM tictactoe WHERE id=$gameid"));
	if(!$players){
		echo "This game has expired due to 5 minutes of inactivity of the player whose turn it was.";

		exit();
	}
		addonline($uid,"Watching TTT game between ".getnick_uid($players[1])." and ".getnick_uid($players[0]),"");

	$move=$_POST["move"];
	$mover1=$_POST["mover1"];


	$sql=mysql_fetch_array(mysql_query("SELECT * FROM tictactoe WHERE id=$gameid"));
	///////////////////////////////check win//////////////////////////////////////
	$winner=0;
	//horizontal
	if($sql[6]==$sql[7] AND $sql[7]==$sql[8]){
		$winner=$sql[6];
	}
	else if($sql[9]==$sql[10] AND $sql[10]==$sql[11]){
		$winner=$sql[9];
	}
	else if($sql[12]==$sql[13] AND $sql[13]==$sql[14]){
		$winner=$sql[12];
	}
	//vertical
	else if($sql[6]==$sql[9] AND $sql[9]==$sql[12]){
	        $winner=$sql[6];
	}
	else if($sql[7]==$sql[10] AND $sql[10]==$sql[13]){
	        $winner=$sql[7];
	}
	else if($sql[8]==$sql[11] AND $sql[11]==$sql[14]){
	        $winner=$sql[8];
	}
        //diagonal	
	else if($sql[6]==$sql[10] AND $sql[10]==$sql[14]){
	        $winner=$sql[6];
	}
	else if($sql[8]==$sql[10] AND $sql[10]==$sql[12]){
	        $winner=$sql[8];
	}
	else if(($sql[6]>0) AND ($sql[7]>0) AND ($sql[8]>0) AND ($sql[9]>0) AND ($sql[10]>0) AND ($sql[11]>0) AND ($sql[12]>0) AND ($sql[13]>0) AND ($sql[14]>0)){
		echo "This game ended in a draw. 10 game points were added to the profiles of both the players.";

		exit();

	}
	///////////////////////////////////
	if ($winner){
		if($winner==1){
			$looser=2;
		}
		else if($winner==2){
			$looser=1;
		}
		$blah="player".$winner;
		$quer1=mysql_fetch_array(mysql_query("SELECT $blah FROM tictactoe WHERE id = $gameid"));
	        $winnick=getnick_uid($quer1[0]);
		$blah="player".$looser;
         	$quer2=mysql_fetch_array(mysql_query("SELECT $blah FROM tictactoe WHERE id = $gameid"));
	        $loosenick=getnick_uid($quer2[0]);
		echo "This game has been won by $winnick ! Congratulations! 100 game points will be added to $winnick's profile.<br/>";
		echo "Sorry $loosenick, you've lost this game. 25 game points will be deducted from your profile.";

		exit();
	}
	// X image 
$x = "<img src=\"x.png\" alt=\"X\"/>";

// O image
$o = "<img src=\"o.png\" alt=\"0\"/>";
		$pls1="<b>".getnick_uid($players[0])."</b>:". $x;
		$pls2="<b>".getnick_uid($players[1])."</b>:". $o;
		$quer=mysql_fetch_array(mysql_query("SELECT turn FROM tictactoe WHERE id = $gameid"));
		$player="player".$quer[0];
		$quer1=mysql_fetch_array(mysql_query("SELECT $player FROM tictactoe WHERE id = $gameid"));
		echo "<b><u>".getnick_uid($quer1[0])."'s turn</u></b><br/>";
		echo $pls1."<br/>".$pls2;
		echo "<br/><a href=\"tictactoe.php?action=watch&amp;gameid=$gameid\">Refresh</a><br/><br/>";
	//Draw the board
echo "
<table border=\"1\" cellpadding=\"2\" cellspacing=\"3\">
<tr>
<td width=\"20\" height=\"20\">";
if($sql[6]==1){
	echo $x;
}
else if($sql[6]==2){
	echo $o;
}


echo "</td>";
echo "<td width=\"20\" height=\"20\">";
if($sql[7]==1){ 	echo $x;
}
else if($sql[7]==2){
	echo $o;
}
echo "</td>";
echo "<td width=\"20\" height=\"20\">";
if($sql[8]==1){
	echo $x;
}
else if($sql[8]==2){
	echo $o;
}
echo "</td></tr>";
echo "<tr><td width=\"20\" height=\"20\">";
if($sql[9]==1){
	echo $x;
}
else if($sql[9]==2){
	echo $o;
}
echo "</td>";
echo "<td width=\"20\" height=\"20\">";
if($sql[10]==1){
	echo $x;
}
else if($sql[10]==2){
	echo $o;
}

echo "</td>";
echo "<td width=\"20\" height=\"20\">";
if($sql[11]==1){
	echo $x;
}
else if($sql[11]==2){
	echo $o;
}
echo "</td></tr>";
echo "<tr><td width=\"20\" height=\"20\">";
if($sql[12]==1){
	echo $x;
}
else if($sql[12]==2){
	echo $o;
}
echo "</td>";
echo "<td width=\"20\" height=\"20\">";
if($sql[13]==1){
	echo $x;
}
else if($sql[13]==2){
	echo $o;
}
echo "</td>";
echo "<td width=\"20\" height=\"20\">";
if($sql[14]==1){
	echo $x;
}
else if($sql[14]==2){
	echo $o;
}
echo "</td></tr></table>";


}
/////////////////////////////////////Play the game//////////////////////////////
else if ($action=="game"){
	    echo "<head>";
    echo "<title>Tic Tac Toe</title>";
    echo "</head>";
    echo "<body>";
echo "<div class=\"div\" align=\"center\">";echo "<b>Tic Tac Toe</b></div>";
  echo "<div class=\"penanda\">";
	$gameid=$_GET["gameid"];
	$players=mysql_fetch_array(mysql_query("SELECT player1, player2 FROM tictactoe WHERE id=$gameid"));
	if(!$players){
		echo "This game has expired due to 5 minutes of inactivity of the player whose turn it was.";

		exit();
	}
	if($uid==$players[0]){
		addonline($uid,"Playing Tic Tac Toe with ".getnick_uid($players[1]),"");
	}
	else if($uid==$players[1]){
		addonline($uid,"Playing Tic Tac Toe with ".getnick_uid($players[0]),"");
	}

	$move=$_POST["move"];
	$mover1=$_POST["mover1"];
	$sql=mysql_fetch_array(mysql_query("SELECT turn FROM tictactoe WHERE id=$gameid"));
	$mover=$sql[0];
	$field="square".$move;

	if($move>0){
		$blah=mysql_fetch_array(mysql_query("SELECT $field FROM tictactoe WHERE id=$gameid"));
	if($mover1==$mover){
		if($blah[0]==0){
	if($mover==1){
		$mover2=2;
	}
	else $mover2=1;
		$time=time();
		mysql_query("UPDATE tictactoe SET $field=$mover, turn=$mover2, lturntime=$time WHERE id=$gameid");
		}
		else{
		echo "That box is already occupied!!! Go <a href=\"tictactoe.php?action=game&amp;gameid=$gameid\">back</a> and choose another one!";

		exit();
		}
	}
	else {
		echo "Its not your turn!!! Go <a href=\"tictactoe.php?action=game&amp;gameid=$gameid\">back</a> and wait for your turn while refreshing the page!";

		exit();
	}
	}

	$sql=mysql_fetch_array(mysql_query("SELECT * FROM tictactoe WHERE id=$gameid"));
	///////////////////////////////check win//////////////////////////////////////
	$winner=0;
	//horizontal
	if($sql[6]==$sql[7] AND $sql[7]==$sql[8]){
		$winner=$sql[6];
	}
	else if($sql[9]==$sql[10] AND $sql[10]==$sql[11]){
		$winner=$sql[9];
	}
	else if($sql[12]==$sql[13] AND $sql[13]==$sql[14]){
		$winner=$sql[12];
	}
	//vertical
	else if($sql[6]==$sql[9] AND $sql[9]==$sql[12]){
	        $winner=$sql[6];
	}
	else if($sql[7]==$sql[10] AND $sql[10]==$sql[13]){
	        $winner=$sql[7];
	}
	else if($sql[8]==$sql[11] AND $sql[11]==$sql[14]){
	        $winner=$sql[8];
	}
        //diagonal	
	else if($sql[6]==$sql[10] AND $sql[10]==$sql[14]){
	        $winner=$sql[6];
	}
	else if($sql[8]==$sql[10] AND $sql[10]==$sql[12]){
	        $winner=$sql[8];
	}
	else if(($sql[6]>0) AND ($sql[7]>0) AND ($sql[8]>0) AND ($sql[9]>0) AND ($sql[10]>0) AND ($sql[11]>0) AND ($sql[12]>0) AND ($sql[13]>0) AND ($sql[14]>0)){
		echo "This game ended in a draw. 10 game points were added to the profiles of both of you.";
				if($uid==$sql[1]){
		$blah=mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$sql[1]."'"));
		$plusses=$blah[0]+10;
		$blah=mysql_query("UPDATE dcroxx_me_users SET plusses='$plusses' WHERE id='".$sql[1]."'");
		$blah=mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$sql[2]."'"));
		$plusses=$blah[0]+10;
		$blah=mysql_query("UPDATE dcroxx_me_users SET plusses='$plusses' WHERE id='".$sql[2]."'");
		$stat=mysql_query("INSERT INTO tttstats SET player1='".$sql[1]."', player2='".$sql[2]."', result=0, time='".time()."'");
				}

		exit();

	}
	///////////////////////////////////
	if ($winner){
		if($winner==1){
			$looser=2;
		}
		else if($winner==2){
			$looser=1;
		}
		$blah="player".$winner;
		$quer1=mysql_fetch_array(mysql_query("SELECT $blah FROM tictactoe WHERE id = $gameid"));
	        $winnick=getnick_uid($quer1[0]);
		$blah="player".$looser;
         	$quer2=mysql_fetch_array(mysql_query("SELECT $blah FROM tictactoe WHERE id = $gameid"));
	        $loosenick=getnick_uid($quer2[0]);
		echo "This game has been won by $winnick ! Congratulations! 100 game points will be added to $winnick's profile.<br/>";
		echo "Sorry $loosenick, you've lost this game. 25 game points will be deducted from your profile.";
         
		//add subtract points
		if($uid==$quer1[0]){
		$blah=mysql_fetch_array(mysql_query("SELECT plusses, tttw FROM dcroxx_me_users WHERE id='".$quer1[0]."'"));
		$plusses=$blah[0]+100;
		$ttw=$blah[1]+1;
		$blah=mysql_query("UPDATE dcroxx_me_users SET plusses='$plusses', tttw=$ttw WHERE id='".$quer1[0]."'");
		$blah=mysql_fetch_array(mysql_query("SELECT plusses, tttl FROM dcroxx_me_users WHERE id='".$quer2[0]."'"));
		$plusses=$blah[0]-25;
		$ttl=$blah[1]+1;
		$blah=mysql_query("UPDATE dcroxx_me_users SET plusses='$plusses', tttl=$ttl WHERE id='".$quer2[0]."'");
		$stat=mysql_query("INSERT INTO tttstats SET player1='".$quer1[0]."', player2='".$quer2[0]."', result=1, time='".time()."'");
		}

		exit();
	}
	// X image 
$x = "<img src=\"x.png\" alt=\"X\"/>";

// O image
$o = "<img src=\"o.png\" alt=\"0\"/>";
		$pls1="<b>".getnick_uid($players[0])."</b>:". $x;
		$pls2="<b>".getnick_uid($players[1])."</b>:". $o;
		$quer=mysql_fetch_array(mysql_query("SELECT turn FROM tictactoe WHERE id = $gameid"));
		$player="player".$quer[0];
		$quer1=mysql_fetch_array(mysql_query("SELECT $player FROM tictactoe WHERE id = $gameid"));
		echo "<b><u>".getnick_uid($quer1[0])."'s turn</u></b><br/>";
		echo $pls1."<br/>".$pls2;
		echo "<br/><a href=\"tictactoe.php?action=game&amp;gameid=$gameid\">Refresh</a><br/><br/>";
	//Draw the board
echo "
<form action=\"tictactoe.php?action=game&amp;gameid=$gameid\" method=\"post\">
<table border=\"1\" cellpadding=\"2\" cellspacing=\"3\">
<tr>
<td width=\"35\" height=\"20\">";
if($sql[6]==1){
	echo $x;
}
else if($sql[6]==2){
	echo $o;
}

else {
	echo "<input type=\"radio\" name=\"move\" value=\"1\" />";
}
echo "</td>";
echo "<td width=\"35\" height=\"20\">";
if($sql[7]==1){
	echo $x;
}
else if($sql[7]==2){
	echo $o;
}
else {
	echo "<input type=\"radio\" name=\"move\" value=\"2\" />";
}echo "</td>";
echo "<td width=\"35\" height=\"20\">";
if($sql[8]==1){
	echo $x;
}
else if($sql[8]==2){
	echo $o;
}
else {
	echo "<input type=\"radio\" name=\"move\" value=\"3\" />";
}echo "</td></tr>";
echo "<tr><td width=\"35\" height=\"20\">";
if($sql[9]==1){
	echo $x;
}
else if($sql[9]==2){
	echo $o;
}
else {
	echo "<input type=\"radio\" name=\"move\" value=\"4\" />";
}echo "</td>";
echo "<td width=\"35\" height=\"20\">";
if($sql[10]==1){
	echo $x;
}
else if($sql[10]==2){
	echo $o;
}
else {
	echo "<input type=\"radio\" name=\"move\" value=\"5\" />";
}echo "</td>";
echo "<td width=\"35\" height=\"20\">";
if($sql[11]==1){
	echo $x;
}
else if($sql[11]==2){
	echo $o;
}
else {
	echo "<input type=\"radio\" name=\"move\" value=\"6\" />";
}echo "</td></tr>";
echo "<tr><td width=\"35\" height=\"20\">";
if($sql[12]==1){
	echo $x;
}
else if($sql[12]==2){
	echo $o;
}
else {
	echo "<input type=\"radio\" name=\"move\" value=\"7\" />";
}echo "</td>";
echo "<td width=\"35\" height=\"20\">";
if($sql[13]==1){
	echo $x;
}
else if($sql[13]==2){
	echo $o;
}
else {
	echo "<input type=\"radio\" name=\"move\" value=\"8\" />";
}echo "</td>";
echo "<td width=\"35\" height=\"20\">";
if($sql[14]==1){
	echo $x;
}
else if($sql[14]==2){
	echo $o;
}
else {
	echo "<input type=\"radio\" name=\"move\" value=\"9\" />";
}echo "</td></tr></table>";
if($sql[1]==$uid){
	$mover1=1;
}
else{
	$mover1=2;
}
	echo "<input type=\"hidden\" name=\"mover1\" value=\"$mover1\"/><input type=\"submit\" name=\"submit\" value=\"Move\" />";
echo "</form>";

}
echo "</div>";
  echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
  echo "Home</a>";
echo "</body>";
?>
</font></body></html>