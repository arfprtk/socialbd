<?php
  session_name("PHPSESSID");
session_start();

include("xhtmlfunctions.php");
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
?>
<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> 
<?php
include("config.php");
include("core.php");
connectdb();
$ubr=$_SERVER['HTTP_USER_AGENT'];
$uip = getip();
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$who = $_GET["who"];
$set = $_GET["set"];
$code= $_GET["code"];
$uid=getuid_sid($sid);
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


	addonline(getuid_sid($sid),"AW War Zone","wz.php?action=$main");

//check gateway
	$checking = mysql_fetch_array(mysql_query("SELECT uid, who FROM dcroxx_me_rpg WHERE code='".$code."'"));
	$nexts = mysql_fetch_array(mysql_query("SELECT next FROM dcroxx_me_rpg WHERE code='".$code."'"));
	$next = $nexts[0];
	if($code!="")
	{
		$out = mysql_num_rows(mysql_query("SELECT * FROM dcroxx_me_rpg WHERE code='".$code."'"));
		if($out=="0")
		{
		$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle WarZone",$pstyle);
			echo "<p align=\"centre\">";
			echo "<br/><br/> This game has already finished :). Try Building another<br/><br/>";
			echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
			echo "</p>";
			  echo xhtmlfoot();
			exit();
		}
	}
	$altm = time()-(5*60*60);
	$res = mysql_query("DELETE FROM dcroxx_me_rpg WHERE timesent<'".$altm."'");
	
	
if($action=="main")
    {
          
       addonline($uid,"Listining to music","");
echo "<head>";
      echo "<title>Chat UserList</title>";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
      echo "</head>";
	   echo "<noframes>";
	   echo "<small><a href=\"lists.php?action=chmood&amp;page=1\">&#187;Chat mfghhfng</a></small><br/>";
	   echo "</noframes>";
	   echo " <frameset rows=\"90%,10%\" frameborder=\"no\" border=\"0\" framespacing=\"0\">";
   echo " <frame src=\"index.php?action=main\" name=\"mainFrame\" id=\"mainFrame\" title=\"mainFrame\" />";
   $uid =getuid_sid($sid);
   echo " <frame src=\"music.php?action=viewuser&amp;who=$uid\" name=\"bottomFrame\" scrolling=\"No\" noresize=\"noresize\" id=\"bottomFrame\" title=\"bottomFrame\" />";
  echo " </frameset>";
      echo "<noframes>";
	     echo "<body>";
       echo "<small><a href=\"lists.php?action=chmood&amp;page=1\">&#187;Chat mfghhfng</a></small><br/>";
	  echo "fdgfdgdfgfdb";
        echo "</body>";
		   echo "</noframes>";
exit();
}

/////////////////////////////////////////////
else if($action=="help")
{
	$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle WarZone",$pstyle);
	echo "<p align=\"centre\">";
	$whonick = getnick_uid($who);
	echo "RULES<br/>";
	echo "<small>";
	echo "* $whonick must Accept Ur Challenge to play the game<br/> * U can Hit $whonick once per time.. then U hv to be Await a few seconds Until $whonick's action <br/>* If u Click <u>Hospital </u>, Ur health gets Increased..<br/>* If u Click <u>Hit</u>, Ur Oppenent Health gets Down<br/>* Both Players Should be online in the War zone<br/><br/>" ;
	echo "</small>";
	
	echo "<a href=\"wz.php?action=main&amp;who=$who\">Back to Game</a><br/>";
	
	echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
	echo "</p>";
		  echo xhtmlfoot();
exit();
}

/////////////////////////////////////////////

else if($action=="war")

{

   addonline(getuid_sid($sid),"WAP -WarZone","wz.php?action=$action");

$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle WarZone",$pstyle);

               echo "<p align=\"center\">";

               echo "<u><b>$stitle WarZone!</b></u>";

               echo "</p>";

               echo "<p align=\"center\">";
echo "<img src=\"smilies/wz1.jpg\"
alt=\"*\"/>";
 echo "<br/><br/>Now U can Battle With an AW User!<br/> This battle is between <b>Death and Life!!</b> If u Win U will Have Double Credits dat u Bet..<br/> U can Challenge any <b> ONLINE </b> User. <br/><i>plz note: There is no use Challenging an <u>Offline user</u></i>";

     echo "<br/><br/>Type Here Ur Opponent UserName:<br/>";

                                               echo "<form action=\"wz.php?action=unik\" method=\"post\">";
                                               echo "<input name=\"marusr\"
maxlength=\"25\"/><br/>";

                                               

                                             echo "<input type=\"submit\" value=\"Im Ready..\"/>";  
echo "</form>";

                                               echo "</go></anchor>";
											   echo "<br/><a href=\"wz.php?action=help&amp;who=$who\">Help</a><br/>";
											   echo "<br/><br/><i>-plz dont copy us-</i> ";
  echo "<br/> coded by: ";
	echo"<a href=\"index.php?action=viewuser&amp;who=1\">$stitle</a><br/>";
	 echo"(c) $stitle";
											   	echo "<br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
	echo "</p>";
		  echo xhtmlfoot();
exit();
}

/////////////////////////////////////////////


else if($action=="unik")

{

   addonline(getuid_sid($sid),"WAP -WarZone","wz.php?action=$action");

  $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle WarZone",$pstyle);

               echo "<p align=\"center\">";

               echo "<u><b>$stitle WarZone!</b></u>";

               echo "</p>";

               echo "<p align=\"center\">";
echo "<img src=\"smilies/wz1.jpg\"
alt=\"*\"/>";
             

               echo "</p>";

               $marusr = $_POST["marusr"];

               $who = getuid_nick($marusr);

               $whonick = getnick_uid($who);

               if($who=="")

               {

               echo "<p align=\"center\">";

               echo "Sorry this user does not exist, Please Try Again";

   echo "<br/><br/><a href=\"index.php?action=main\"><img
src=\"images/home.gif\" alt=\"*\"/>";

               echo "Home</a>";

               echo "</p>";

               // DO NOT REMOVE THE LINE BELOW - $stitle

   echo "<p align=\"center\">";
			   
		
		 echo "</p>";



                echo xhtmlfoot();;

               echo "</wml>";

               exit;

               }



 

               echo "<p align=\"left\">";


      echo "U r Going to Battle With $whonick!<br/>";
   
   
   	echo "<br/>-RULES-<br/>";
	echo "<small>";
	echo "1. if you do not play within 5mins, the game will terminate and the one who wont respond will lose.<br/>";
	echo "2. Whoever loses should not abuse the system for his incapability.<br/>";
	echo "3. This game has been made with certain terms and conditions and one should not violet them<br/>";
	echo "4. Lastly enjoy the game to the fullest.<br/>";
	echo "5. If there is any system failure and one loses his/her Credits, the site doesnt gives u any insurance without the finishing the complete game.<br/>";
	echo "6. Pressing the <u>Ok. I Agree</u> button means you ACCEPT ALL THE RULES AND CONDITIONS OF THE GAME.<br/>";
		echo "7. U both (U and ur opponent) Must Hv Enough Credits to Bet!<br/>";
	echo "8. IF you DONOT ACCEPT ALL THE RULES AND CONDITIONS OF THE GAME, please dont proceed.<br/>";
	echo "</small>";
		echo "<a href=\"wz.php?action=main&amp;who=$who\">Ok, I Agree</a><br/>";
	echo "<a href=\"index.php?action=main\">No, I Dont</a><br/>";

		 
		 echo "</p>";



   echo xhtmlfoot();
exit();
}

/////////////////////////////////////////////
else if($action=="terms")
{
	$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle WarZone",$pstyle);
	echo "<p align=\"centre\">";
	
	echo "RULES<br/>";
	echo "<small>";
	echo "1. if you do not play within 5mins, the game will terminate and the one who wont respond will lose.<br/>";
	echo "2. Whoever loses should not abuse the system for his incapability.<br/>";
	echo "3. This game has been made with certain terms and conditions and one should not violet them<br/>";
	echo "4. Lastly enjoy the game to the fullest.<br/>";
	echo "5. If there is any system failure and one loses his/her Credits, the site doesnt gives u any insurance without the finishing the complete game.<br/>";
	echo "6. Pressing the <u>Ok. I Agree</u> button means you ACCEPT ALL THE RULES AND CONDITIONS OF THE GAME.<br/>";
		echo "7. U both (U and ur opponent) Must Hv Enough Credits to Bet!<br/>";
	echo "8. IF you DONOT ACCEPT ALL THE RULES AND CONDITIONS OF THE GAME, please dont proceed.<br/>";
	echo "</small>";
	
	echo "<a href=\"wz.php?action=main&amp;who=$who\">Ok, I Agree</a><br/>";
	echo "<a href=\"index.php?action=main\">No, I Dont</a><br/>";
	echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
	echo "</p>";
		  echo xhtmlfoot();
exit();
}

/////////////////////////////////////////////
else if($action=="wz")
{
$who = $_GET["who"];
$bet = $_GET["bet"];
if($bet=='0')
{
          $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle WarZone",$pstyle);
            echo "<p align=\"center\">";
            echo "You should place your bet to challenge lol.. ";
            echo "<br/>-----<br/><a href=\"wz.php?action=war\">Back to Warzone</a><br/>";
            echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
       echo "</p>";
  echo xhtmlfoot();
            exit();

}
$sql = mysql_fetch_array(mysql_query("SELECT id FROM dcroxx_me_users WHERE id='".$who."'"));     
      if(!isonline($sql[0]))
    {
            $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle WarZone",$pstyle);
            echo "<p align=\"center\">";
            echo "You cannot challenge the opponent. The Opponent is Offline.. ";
             echo "<br/>-----<br/><a href=\"wz.php?action=war\">Back to Warzone</a><br/>";
            echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
           echo "</p>";
  echo xhtmlfoot();
            exit();

    }
	$bet = $_POST["bet"];
	$recb=mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
	
if($recb[0]< $bet)
{

	  $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle WarZone",$pstyle);
            echo "<p align=\"center\">";
		echo "Sorry Oppenent dont Hv sufficent Credits to bet this amount.Check his Credits and again Bet<br/>";
		echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
	
        echo "</p>";
  echo xhtmlfoot();
            exit();

    }
$check = mysql_fetch_array(mysql_query("SELECT code FROM dcroxx_me_rpg WHERE who='".$who."'"));
$info = mysql_fetch_array(mysql_query("SELECT who FROM dcroxx_me_rpg WHERE code='".$check[0]."'"));
if($info[0]==$who)
{
            $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle WarZone",$pstyle);
            echo "<p align=\"center\">";
            echo "Can't challenge the opponent at the moment. opponent is in a battle now.<br/>";
            echo "<br/>-----<br/><a href=\"wz.php?action=war\">Back to Warzone</a><br/>";
            echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
            echo "</p>";
   
  echo xhtmlfoot();
            exit();

}

if($who==$uid)
            {
            $who = $_GET["who"];
           $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle WarZone",$pstyle);
            echo "<p align=\"center\">";
            echo "Don't be dumb to challenge yourself! lol..<br/>";
             echo "<br/>-----<br/><a href=\"wz.php?action=war\">Back to Warzone</a><br/>";
            echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
            echo "</p>";
       
  echo xhtmlfoot();
            exit();

}
	$bet = $_POST["bet"];
	if($bet=="")
	$bet = 5;
$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle WarZone",$pstyle);
	echo "<p align=\"centre\">";
	$recb=mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
	
	if(($recb[0] - $bet) < 0)
	
	{
		echo "Sorry you dont Hv sufficent Credits to bet this amount.Check ur Credits again and Bet<br/>";
		echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
		echo "</p>";
		  echo xhtmlfoot();

		exit();
	}
	do{
		$code = rand(1,150000);
		$check = mysql_num_rows(mysql_query("SELECT * FROM dcroxx_me_rpg WHERE code='".$code."'"));
	}while($check!=0);
	
	$res = mysql_query("INSERT INTO dcroxx_me_rpg SET uid='".$uid."', rhealth='100', who='".$who."', ahealth='100', bet='".$bet."', next='".$uid."', code='".$code."', timesent='".time()."'");
	echo "<a href=\"wz.php?action=erpg&amp;who=$who&amp;set=$uid&amp;code=$code\">Lets start</a><br/>";
	echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
echo "</p>";
  echo xhtmlfoot();
	
exit();
}

/////////////////////////////////////////////

else if($action=="reject")
{
	
	$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle WarZone",$pstyle);
	echo "<p align=\"centre\">";
	$res = mysql_query("DELETE FROM dcroxx_me_rpg WHERE code='".$code."'");
	echo "<br/>You have successfully Rejected the game :)<br/>";
	$wintext = "".getnick_uid($uid)." Rejected the battle.. [br/][i] p.s. This is an automatic pm for the WarZone[/i]";
	$res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$wintext."', byuid='".$uid."', touid='".$who."', timesent='".time()."'");
	$res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$wintext."', byuid='".$who."', touid='".$uid."', timesent='".time()."'");
	
	echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
echo "</p>";
  echo xhtmlfoot();
exit();
}

/////////////////////////////////////////////
else if($action=="erpg")
{
	$repair = $_GET["repair"];
	   $whonick = getnick_uid($who);
	
   addonline(getuid_sid($sid),"Fighting With $whonick","wz.php?action=war");
	$pstyle = gettheme($sid);
      echo xhtmlhead("$stitle WarZone",$pstyle);
	
	
    echo "<p align=\"center\">";
	echo "<br/>";
	echo getshoutbox($sid);
	echo "<br/>";
	echo "</p>";
	echo "<p align=\"centre\">";
	echo "<br/>";
	if($repair=="0")
	{
		if($next==$checking[1])
		{	
			
			$rech=mysql_fetch_array(mysql_query("SELECT rhealth FROM dcroxx_me_rpg WHERE code='".$code."'"));
			$atth=mysql_fetch_array(mysql_query("SELECT ahealth FROM dcroxx_me_rpg WHERE code='".$code."'"));
			$mx = $rech[0]/2;
			$rep = rand(1,$mx);
			$atth = $atth[0] + $rep;
			$res = mysql_query("UPDATE dcroxx_me_rpg SET ahealth='".$atth."', next='".$set."', timesent='".time()."' WHERE code='".$code."'");
			echo "<br/>you got $rep  Health points<br/>";
			$rech = $rech[0];
			echo "".getnick_uid($checking[0])."'s Health: $rech<br/> ".getnick_uid($checking[1])."'s Health: $atth<br/>";
		}
		else
		{
			$rech=mysql_fetch_array(mysql_query("SELECT rhealth FROM dcroxx_me_rpg WHERE code='".$code."'"));
			$atth=mysql_fetch_array(mysql_query("SELECT ahealth FROM dcroxx_me_rpg WHERE code='".$code."'"));
			$mx = $atth[0]/2;
			$rep = rand(1,$mx);
			$rech = $rech[0] + $rep;
			$res = mysql_query("UPDATE dcroxx_me_rpg SET rhealth='".$rech."', next='".$set."', timesent='".time()."' WHERE code='".$code."'");
			echo "<br/>you got $rep Health points<br/>";
			$atth = $atth[0];
			echo "".getnick_uid($checking[0])."'s Health: $rech<br/> ".getnick_uid($checking[1])."'s Health: $atth<br/>";
		}
	}
	else if($repair=="1"){
	
		if($next==$checking[1])
		{
			$rech=mysql_fetch_array(mysql_query("SELECT rhealth FROM dcroxx_me_rpg WHERE code='".$code."'"));
			$atth=mysql_fetch_array(mysql_query("SELECT ahealth FROM dcroxx_me_rpg WHERE code='".$code."'"));
			$mx = $atth[0]/2;
			$dam = rand(1,$mx);
			$no = rand(0,17);
			$utext = uverbs($no);
			echo "<br/> You $utext With $dam points<br/>";
			$rech = $rech[0] - $dam;
			$atth = $atth[0];
			if($rech<0)
			{
				//wining condition
				echo "</p>";
				echo "<p align=\"centre\">";
				$recb = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
				$attb = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
				$bets = mysql_fetch_array(mysql_query("SELECT bet FROM dcroxx_me_rpg WHERE code='".$code."'"));
				$bet = $bets[0];
				$newplusses = $attb[0] - $bet;
				$res = mysql_query("UPDATE dcroxx_me_users SET plusses='".$newplusses."' WHERE id='".$who."'");
				$newplusses = $recb[0] + $bet;
				$res = mysql_query("UPDATE dcroxx_me_users SET plusses='".$newplusses."' WHERE id='".$uid."'");
				$res = mysql_query("DELETE FROM dcroxx_me_rpg WHERE code='".$code."'");
				echo "".getnick_uid($who)." is Lost and  ".getnick_uid($uid)." Won with $bet Credits!";
				$wintext = "".getnick_uid($who)." is Lost and ".getnick_uid($uid)." Won with $bet Credits! [br/][i] p.s. Note: This is an automatic pm from WarZone[/i]";
				$res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$wintext."', byuid='".$uid."', touid='".$who."', timesent='".time()."'");
				$res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$wintext."', byuid='".$who."', touid='".$uid."', timesent='".time()."'");
				echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
				echo "</p>";
				  echo xhtmlfoot();
				exit();
			}
			if($rech<0)
			$rech=0;
			$res = mysql_query("UPDATE dcroxx_me_rpg SET rhealth='".$rech."', next='".$set."', timesent='".time()."' WHERE code='".$code."'");
			echo "".getnick_uid($checking[0])."'s Health: $rech<br/> ".getnick_uid($checking[1])."'s Health: $atth<br/>";
			//$set = "0";
		}
		else
		{
			$rech=mysql_fetch_array(mysql_query("SELECT rhealth FROM dcroxx_me_rpg WHERE code='".$code."'"));
			$atth=mysql_fetch_array(mysql_query("SELECT ahealth FROM dcroxx_me_rpg WHERE code='".$code."'"));
			$mx = $rech[0]/2;
			$dam = rand(1,$mx);
			$no = rand(0,17);
			$utext = uverbs($no);
			echo "<br/> You $utext With $dam points<br/>";
			$atth = $atth[0] - $dam;
			$rech = $rech[0];
			if($atth<0)
			{
				//wining condition
				echo "</p>";
				echo "<p align=\"centre\">";
				$recb = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
				$attb = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$who."'"));
				$bets = mysql_fetch_array(mysql_query("SELECT bet FROM dcroxx_me_rpg WHERE code='".$code."'"));
				$bet = $bets[0];
				$newplusses = $attb[0] - $bet;
				$res = mysql_query("UPDATE dcroxx_me_users SET plusses='".$newplusses."' WHERE id='".$who."'");
				$newplusses = $recb[0] + $bet;
				$res = mysql_query("UPDATE dcroxx_me_users SET plusses='".$newplusses."' WHERE id='".$uid."'");
				$res = mysql_query("DELETE FROM dcroxx_me_rpg WHERE code='".$code."'");
			echo "".getnick_uid($uid)." Won with $bet Credits and".getnick_uid($who)." is Lost";
				$wintext = "".getnick_uid($uid)." Won with $bet Credits and ".getnick_uid($who)." is Lost![br/][i] p.s. note: This is an automatic pm for the Battle you had just now[/i]";
				$res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$wintext."', byuid='".$uid."', touid='".$who."', timesent='".time()."'");
				$res = mysql_query("INSERT INTO dcroxx_me_private SET text='".$wintext."', byuid='".$who."', touid='".$uid."', timesent='".time()."'");
				echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a>";
				echo "</p>";
				  echo xhtmlfoot();
				exit();
			}
			if($rech<0)
			$rech=0;
			$res = mysql_query("UPDATE dcroxx_me_rpg SET ahealth='".$atth."', next='".$set."',timesent='".time()."' WHERE code='".$code."'");
			echo "".getnick_uid($checking[0])."'s Health: $rech<br/> ".getnick_uid($checking[1])."' Health: $atth<br/>";
		}
	}
	else{
	
	$noi = mysql_fetch_array(mysql_query("SELECT lastact FROM dcroxx_me_users WHERE id='".$checking[0]."'"));
  $var1 = date("His",$noi[0]);$var2 = time();$var21 = date("His",$var2);$var3 = $var21 - $var1;$var4 = date("s",$var3);
  echo "<u>Idle</u><br/>";
  echo "<a
href=\"index.php?action=viewuser&amp;who=$checking[0]\">".getnick_uid($checking[0])."</a>";

	
  echo " : ";$remain = time() - $noi[0];$idle = gettimemsg($remain);echo "$idle<br/>"; 
	  $noi = mysql_fetch_array(mysql_query("SELECT lastact FROM dcroxx_me_users WHERE id='".$checking[1]."'"));
  $var1 = date("His",$noi[0]);$var2 = time();$var21 = date("His",$var2);$var3 = $var21 - $var1;$var4 = date("s",$var3);
  echo "<a
href=\"index.php?action=viewuser&amp;who=$checking[1]\">".getnick_uid($checking[1])."</a>";

	
  echo " : ";$remain = time() - $noi[0];$idle = gettimemsg($remain);echo "$idle<br/><br/>";
  
		$rech=mysql_fetch_array(mysql_query("SELECT rhealth FROM dcroxx_me_rpg WHERE code='".$code."'"));
		$atth=mysql_fetch_array(mysql_query("SELECT ahealth FROM dcroxx_me_rpg WHERE code='".$code."'"));
		echo "".getnick_uid($checking[0])."'s Health: $rech[0]<br/> ".getnick_uid($checking[1])."'s Health: $atth[0]<br/>";
	}
	$nexts = mysql_fetch_array(mysql_query("SELECT next FROM dcroxx_me_rpg WHERE code='".$code."'"));
	$next = $nexts[0];
	if($next==$uid)
	{
		if($next==$checking[0])
			$set=$checking[1];
		else
			$set=$checking[0];
		echo "<a href=\"wz.php?action=erpg&amp;who=$who&amp;set=$set&amp;repair=1&amp;code=$code\">HIT</a><br/>";
		echo "<a href=\"wz.php?action=erpg&amp;who=$who&amp;set=$set&amp;repair=0&amp;code=$code\">HOSPITAL</a><br/>";
	}
	else
	{
		echo "<a href=\"wz.php?action=erpg&amp;time=";
		echo date('dmHis');
		echo "&amp;who=$who&amp;code=$code\">ReFRESH</a>";
			echo "<br/>Now opponent's Turn, Be Await n Refresh..";
				echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
				echo "Home</a>";
		
	}
	
	echo "</p>";
	  echo xhtmlfoot();
exit();
}

?>


</html>
