<?php
     session_name("PHPSESSID");
session_start();
include("config.php"); 
include("core.php"); 
include("xhtmlfunctions.php");
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
//8152
?>
<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> 
<?php

connectdb();
$action=$_GET["action"];
$id=$_GET["id"];
$sid = $_GET["sid"];
$rid=$_GET["rid"];
$rpw=$_GET["rpw"];
$uid = getuid_sid($sid);
  
 $uexist = isuser($uid);

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
    
	
	
		$validated = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE id='".$uid."'  AND validated='0'"));
    if(($validated[0]>0)&&(validation()))
    {
	$pstyle = gettheme($sid);
      echo xhtmlheadchat("$stitle",$pstyle);
      echo "<img src=\"images/vala.gif\" alt=\"x\"/><br/>";
    echo "<img src=\"../images/notok.gif\" alt=\"X\"/><br/><b>Ur Account is Not Validated Yet</b><br/>Our online Staff members r validating U now. Plz be patient try again this option in few Minutes..Untill then Explore and Enjoy other features in $stitle.<br/>thank you!<br/><br/>";
	 echo "<a href=\"index.php?action=main&amp;sid=$sid\">Home</a>";
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
    $isroom = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_rooms WHERE id='".$rid."'"));
    if($isroom[0]==0)
    {
      $pstyle = gettheme($sid);
      echo xhtmlheadchat("$stitle",$pstyle);
      echo "<p align=\"center\">";
      echo "This room doesn't exist anymore<br/>";
      echo ":P see in another room<br/><br/>";
      echo "<a href=\"index.php?action=chat&amp;sid=$sid\">Chatrooms</a>";
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
      echo "<a href=\"index.php?action=chat&amp;sid=$sid\">Chatrooms</a>";
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
      echo "<a href=\"index.php?action=chat&amp;sid=$sid\">Chatrooms</a>";
      echo "</p>";
      echo xhtmlfoot();
      exit();
    }
    addtochat($uid, $rid);
        //This Chat Script is by  Far'oun
        //raed_mfs@yahoo.tk
        //want to see main menu...
        $timeto = 300;
            $timenw = (time() - $timeadjust);
            $timeout = $timenw-$timeto;
            $deleted = mysql_query("DELETE FROM dcroxx_me_chat WHERE timesent<".$timeout."");
            
        if ($action=="")
                         {
          
        $pstyle = gettheme($sid);
        echo xhtmlheadchat1("$stitle",$pstyle,$rid,$sid);
        
         //start of main card
         
        //echo "<timer value=\"200\"/><p align=\"center\">";
        addonline($uid,"Chatrooms","");
        echo "<small>
        <a href=\"chat.php?action=say&amp;sid=$sid&amp;rid=$rid&amp;rpw=$rpw\">Options</a> / ";
        $time = date('dmHis');
        //echo "<a href=\"chat.php?time=$time&amp;sid=$sid&amp;rid=$rid&amp;rpw=$rpw\">Refresh</a>";

        $unreadinbox=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE unread='1' AND touid='".$uid."'"));
        $pmtotl=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE touid='".$uid."'"));
        $unrd="(".$unreadinbox[0]."/".$pmtotl[0].")";
        if ($unreadinbox[0]>0)
        {
        echo "<br/><a href=\"inbox.php?action=main&amp;sid=$sid\">Inbox$unrd</a>";
      }
      echo "</small></p>";
        $message=$_POST["message"];
        $who = $_POST["who"];
        $rinfo = mysql_fetch_array(mysql_query("SELECT censord, freaky FROM dcroxx_me_rooms WHERE id='".$rid."'"));
        if (trim($message) != "")
        {
          $nosm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_chat WHERE msgtext='".$message."'"));
          if($nosm[0]==0){
            
            $chatok = mysql_query("INSERT INTO dcroxx_me_chat SET  chatter='".$uid."', who='".$who."', timesent='".(time() - $timeadjust)."', msgtext='".$message."', rid='".$rid."';");
            $lstmsg = mysql_query("UPDATE dcroxx_me_rooms SET lastmsg='".(time() - $timeadjust)."' WHERE id='".$rid."'");
            
            $hehe=mysql_fetch_array(mysql_query("SELECT chmsgs FROM dcroxx_me_users WHERE id='".$uid."'"));
            $totl = $hehe[0]+1;
            $msgst= mysql_query("UPDATE dcroxx_me_users SET chmsgs='".$totl."' WHERE id='".$uid."'");
            if($rinfo[1]==2)
            {
              //oh damn i gotta post this message to ravebabe :(
              //will it succeed?
              $botid = "c6f6b1059e3602f7";
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
    	
    	$chatok = mysql_query("INSERT INTO dcroxx_me_chat SET  chatter='8152', who='', timesent='".(time() - $timeadjust)."', msgtext='".$reply." @".getnick_uid($uid)."', rid='".$rid."';");
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
               
                
                if($counter<10)
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
                    echo "<b>Chat system:&#187;<i>*oi! $chnick, no spamming*</i></b><br/>";
                  }
				  else if(isenta($text))
                  {
                    $chnick = getnick_uid($chat[0]);
                    echo "<b>Chat system:&#187;<i>*$chnick, enterd*</i></b><br/>";
                  }
                  else if($nos>2){
                    $chnick = getnick_uid($chat[0]);
                    echo "<b>Chat system:&#187;<i>*hey! $chnick, you can only use 2 smilies per msg*</i></b><br/>";
                  }else{
                    $sres = substr($chat[3],0,3);
                    
                    if($sres == "/nik")
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
                         $tosay = str_replace("fuck","*this word rhymes with duck*",$tosay);
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
                  echo "<a href=\"chat.php?action=say2&amp;sid=$sid&amp;who=$chat[0]&amp;rid=$rid&amp;rpw=$rpw\">$optlink</a>&#187; ";
                  echo $tosay."<br/>";
                  }
                }
               
                  $counter++;
                }
                }
            }
            echo "</small>";
            echo "</p>";
        
      
        
      echo xhtmlfoot();
}
/////////////////////////////////////////////////////SAY
        else if ($action=="say")                   {
        $pstyle = gettheme($sid);
      echo xhtmlheadchat("$stitle",$pstyle);
        
        addonline($uid,"Writing Chat Message","");
       
 			echo "<p align=\"center\">";
         $message=$_POST["message"];
        $who = $_POST["who"];
       
            
            $chatok = mysql_query("INSERT INTO dcroxx_me_chat SET  chatter='".$uid."', who='".$who."', timesent='".(time() - $timeadjust)."', msgtext='".$message."', rid='".$rid."';");
            $lstmsg = mysql_query("UPDATE dcroxx_me_rooms SET lastmsg='".(time() - $timeadjust)."' WHERE id='".$rid."'");
            
            $hehe=mysql_fetch_array(mysql_query("SELECT chmsgs FROM dcroxx_me_users WHERE id='".$uid."'"));
            $totl = $hehe[0]+1;
            $msgst= mysql_query("UPDATE dcroxx_me_users SET chmsgs='".$totl."' WHERE id='".$uid."'");
			
            echo "<form action=\"chat.php?action=say&amp;sid=$sid&amp;rid=$rid&amp;rpw=$rpw\" method=\"post\">";
            echo "Message:<input name=\"message\" type=\"text\" value=\"\" maxlength=\"255\"/><br/>";
            echo "<input type=\"submit\" value=\"Say\"/>";
            echo "</form>";
            

            
            echo "<small><a href=\"lists.php?action=chmood&amp;sid=$sid&amp;page=1\">&#187;Chat mood</a></small><br/>";
            echo "<small><a href=\"chat.php?action=inside&amp;sid=$sid&amp;rid=$rid&amp;rpw=$rpw\">&#187;Who's Inside</a></small><br/>";
            echo "<small><a href=\"chat.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw\">&#171;Chatroom</a></small></p>";
        //end
        
        echo "<p align=\"center\"><a href=\"index.php?action=chat&amp;sid=$sid\"><img src=\"images/chat.gif\" alt=\"*\"/>Chatrooms</a><br/>";
        echo "<a href=\"index.php?action=main&amp;sid=$sid\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a></p>";

      echo xhtmlfoot();
                                               }
        ////////////////////////////////////////////
    /////////////////////////////////////////////////////SAY2
        else if ($action=="say2") 
                          {
        $pstyle = gettheme($sid);
        echo xhtmlheadchat("$stitle",$pstyle);
        echo "<p align=\"center\">";
		$who=$_GET["who"];
        $unick = getnick_uid($who);
        
        echo "<b>Private to $unick</b>";
        echo "</p>";
        
        addonline($uid,"Writing chat message","");
        
            echo "<form action=\"chat.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw\" method=\"post\">";
            echo "<p>Message:<input name=\"message\" type=\"text\" value=\" \" maxlength=\"255\"/><br/>";
            echo "<input type=\"submit\" value=\"Say\"/>";
            echo "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
            echo "</form>";
            
            echo "<br/>";
            echo "<small><a href=\"index.php?action=viewuser&amp;sid=$sid&amp;who=$who\">&#187;View $unick's Profile</a></small><br/>";
            echo "<small><a href=\"chat.php?action=expose&amp;sid=$sid&amp;who=$who&amp;rid=$rid&amp;rpw=$rpw\">&#187;Expose $unick</a></small><br/>";
            
            echo "<small><a href=\"chat.php?action=inside&amp;sid=$sid&amp;rid=$rid&amp;rpw=$rpw\">&#187;Who's Inside</a></small><br/>";
            echo "<small><a href=\"chat.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw\">&#171;Chatroom</a></small></p>";
        //end
        
        echo "<p align=\"center\"><a href=\"index.php?action=chat&amp;sid=$sid\"><img src=\"images/chat.gif\" alt=\"*\"/>Chatrooms</a><br/>";
        echo "<a href=\"index.php?action=main&amp;sid=$sid\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a></p>";

      echo xhtmlfoot();
                                               }
        ////////////////////////////////////////////
        //////////////////////////////inside//////////
             //////////////////////////////inside//////////
      else if ($action=="inside")           {
          
      addonline($uid,"Viewing Chat UserList","");
echo "<head>";
      echo "<title>Chat UserList</title>";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
      echo "</head>";
	   echo " <frameset rows=\"*,150\" frameborder=\"no\" border=\"0\" framespacing=\"5\">";
   echo " <frame src=\"chat.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw\" name=\"mainFrame\" id=\"mainFrame\" title=\"mainFrame\" />";
   echo " <frame src=\"chat.php?action=say&amp;sid=$sid&amp;rid=$rid&amp;rpw=$rpw\" name=\"bottomFrame\" scrolling=\"No\" noresize=\"noresize\" id=\"bottomFrame\" title=\"bottomFrame\" />";
  echo " </frameset>";
      echo "<noframes>";
	     echo "<body>";
     
        echo "</body>";
		   echo "</noframes>";

                                           }
        else if ($action=="expose")           {

        addonline($uid,"Chat inside list","");
        echo "<card id=\"main\" title=\"Inside list\">";
        echo "<p align=\"center\"><br/>";
        mysql_query("UPDATE dcroxx_me_chat SET exposed='1' WHERE chatter='".$who."' AND who='".$uid."'");
        $unick = getnick_uid($who);
        echo "$unick messages to you are exposed to mods";
        echo "<br/><br/>";
        echo "<a href=\"chat.php?sid=$sid&amp;rid=$rid&amp;rpw=$rpw\">&#171;Chatroom</a><br/>";
        echo "<br/><a href=\"index.php?action=chat&amp;sid=$sid\"><img src=\"images/chat.gif\" alt=\"*\"/>Chatrooms</a><br/>";
        echo "<a href=\"index.php?action=main&amp;sid=$sid\"><img src=\"images/home.gif\" alt=\"*\"/>Home</a></p>";

      echo xhtmlfoot();
                                           }
        
        
?>