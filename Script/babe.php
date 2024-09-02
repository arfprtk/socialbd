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

include("config.php"); //load config
include("core.php"); //load main functions
connectdb();

        
        //clearnc();
$action=$_GET["action"];
$id=$_GET["id"];
$sid = $_SESSION['sid'];
$botid = "c6f6b1059e3602f7";
$input = $_POST["input"];
$custid=$_POST["custid"];
$hostname = "www.pandorabots.tk";
$hostpath = "/pandora/talk-xml";
if(islogged($sid)==false)
    {
      $pstyle = gettheme($sid);
      echo xhtmlhead("$stitle",$pstyle);
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


 $pstyle = gettheme($sid);
    echo xhtmlhead("$stitle Babe",$pstyle);                 //start of main card
        echo "<p align=\"center\">";
        echo "<br/>";
        
        
        addonline(getuid_sid($sid),"Chatting to $stitle Babe","");
    if ($input!="")
    {

        $sendData = "botid=".$botid."&input=".urlencode($input)."&custid=".$custid;
    	// Send the request to Pandorabot
    	$result = PostToHost($hostname, $hostpath, $sendData);
    	//TODO: Process the returned XML as an XML document instead of a big string.
    	// Use string manipulations to pull out the 'custid' and 'that' values.
    	$pos = strpos($result, "custid=\"");

    	// Extract the custid
    	if ($pos === false) {
    		$custid = "";
    	} else {
    		$pos += 8;
    		$endpos = strpos($result, "\"", $pos);
    		$custid = substr($result, $pos, $endpos - $pos);
    	}
    	// Extrat <that> - this is the reply from the Pandorabot
    	$pos = strpos($result, "<that>");
    	if ($pos === false) {
    		$reply = "";
    	} else {
    		$pos += 6;
    		$endpos = strpos($result, "</that>", $pos);
    		$reply = unhtmlspecialchars(substr($result, $pos, $endpos - $pos));
    	}

        //echo htmlspecialchars( $reply);
        $hers = $reply;
        $hers = parsemsg($hers);
             $input=htmlspecialchars($input);
             $nick = getnick_uid($uid);
             echo "<br/><b>$nick: </b>$input<br/>";
             echo "<b>$stitle Babe: </b>$hers<br/>";
		echo "<form action=\"babe.php?sid=$sid\" method=\"post\">";
        echo "<br/><input type=\"text\" name=\"input\" maxlength=\"120\" value=\"$input\"/>";
echo "<input type=\"submit\" value=\"Say\"/>";
        	echo "</form>";
		echo "<br/>";
    }else{
      echo "Hello, now you can chat with our chatbot<br/> her name is $stitleBabe, have fun<br/>";
echo "<form action=\"babe.php?sid=$sid\" method=\"post\">";
      echo "<input type=\"text\" name=\"input\" maxlength=\"120\" value=\"$input\"/>";
		echo "<input type=\"submit\" value=\"Say\"/>";
        	echo "</form>";
		echo "<br/>";
    }
    
    echo "<br/><br/><a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a><br/>";
echo "</p>";
  echo xhtmlfoot();
function unhtmlspecialchars( $string )
{
  $string = str_replace ( '&amp;', '&', $string );
  $string = str_replace ( '&#039;', '\'', $string );
  $string = str_replace ( '&quot;', '"', $string );
  $string = str_replace ( '&lt;', '<', $string );
  $string = str_replace ( '&gt;', '>', $string );
  $string = str_replace ( '&uuml;', '?', $string );
  $string = str_replace ( '&Uuml;', '?', $string );
  $string = str_replace ( '&auml;', '?', $string );
  $string = str_replace ( '&Auml;', '?', $string );
  $string = str_replace ( '&ouml;', '?', $string );
  $string = str_replace ( '&Ouml;', '?', $string );
  return $string;
exit();
}

?>
