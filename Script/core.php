<?php
ini_set('arg_separator.output','&amp;');
ini_set("display_errors", "0"); 
include("config.php");
//include("gmprc.php");
//session_start();
/*if(!get_magic_quotes_gpc())
{
$_GET = array_map('trim', $_GET);
$_POST = array_map('trim', $_POST);
$_COOKIE = array_map('trim', $_COOKIE);

$_GET = array_map('addslashes', $_GET);
$_POST = array_map('addslashes', $_POST);
$_COOKIE = array_map('addslashes', $_COOKIE);
}*/
function badquery($str) { 
        $search=array("\\","\0","\n","\r","\x1a","'",'"'); 
                $replace=array("\\\\","\\0","\\n","\\r","\Z","\'",'\"'); 
                return str_replace($search,$replace,$str); 
    } 
if (!get_magic_quotes_gpc()) {
foreach ($_GET as $key => $value) {$_GET[$key] = addslashes(badquery(strip_tags(htmlspecialchars($value)))); }
foreach ($_POST as $key => $value) {$_POST[$key] = addslashes(badquery(strip_tags(htmlspecialchars($value)))); }
foreach ($_REQUEST as $key => $value) {$_REQUEST[$key] = addslashes(badquery(strip_tags(htmlspecialchars($value)))); }
foreach ($_SERVER as $key => $value) {$_SERVER[$key] = addslashes(badquery(strip_tags(htmlspecialchars($value)))); }
foreach ($_COOKIE as $key => $value) {$_COOKIE[$key] = addslashes(badquery(strip_tags(htmlspecialchars($value)))); }
}

///Pic Size
function format_size($size, $round = 2) {
$sizes = array('Byts', ' kb', ' mb', ' gb',' TB');
$total = count($sizes)-1;
for ($i=0; $size > 1024 && $i < $total; $i++) $size /= 1024;
return round($size,$round).$sizes[$i];
}
////NUMBER FILTER
function isnum($string) 
{
 $string = preg_replace(array('/[^0-9]/'),array('', '', ''),$string);
 $string = mysql_real_escape_string(htmlspecialchars($string)); 
return $string;
 }
 
 function Filter_Q($string) 
{
 $badWords = "(union)|(insert)|(drop)|(http)|(iframe)|(script)|(--)|(>)|(<)|(')|(^)|(#)|(%)|(php)|(rp)|(madarchod)|(chod)|(fuck)|(mastercredit)|(bdremix)|(khanki)|(benchod)|(www)|(plusbd)|(magi)|(gand)|(lund)|(boobs)|(bhosdi)|(lauda)|(baap)|(bhosda)|(rockerwap)|(n3t)|(spicecult)|(perm)|(cyberpowereragon)|(perm='4')|(perm=4)|(plusess)|(,)"; 
 $string = eregi_replace($badWords, "", $string);
 $string = preg_replace(array('/[^a-zA-Z0-9\ \-\_\/\*\(\)\[\]\?\.\,\:\&\@\=\+]/'),array('', '', ''),$string);
 $string = mysql_real_escape_string(htmlspecialchars($string)); 

return $string;
 }
 function hridoysqlsecurityclean($str) { 
        $str = @trim($str);
        $str = badquery($str);
        $str = htmlspecialchars($str); 
        $str = strip_tags($str); 
        $str = stripslashes($str); 
        $str = stripslashes($str); 
        $str = addslashes($str); 
    return mysql_real_escape_string($str); 
    }
 function browser_agent($_mob_browser){$_mob_browser=hridoysqlsecurityclean($_mob_browser);
  if(preg_match('/(google|bot)/i',strtolower($_mob_browser))){
 $position = strpos(strtolower($_mob_browser),"bot");
 $_mob_browser = substr($_mob_browser, $position-30, $position+2);
 $_browser = explode (" ", $_mob_browser);
 $_browser = array_reverse($_browser); 
 }else if (isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])) {
 $_mob_browser = $_SERVER['HTTP_X_OPERAMINI_PHONE_UA'];
 $_position=strpos(strtolower($_mob_browser),"nokia");$position=strpos(strtolower($_mob_browser),"android");
 if($_position){$_mob_browser = substr($_mob_browser, $_position,25);}
 else{if($position){$_mob_browser = substr($_mob_browser, $position,25);$_browser = explode ('-', $_mob_browser);return hridoysqlsecurityclean($_browser[0]);}}
 $_browser = explode (' ', $_mob_browser);
 }else if (isset($_SERVER['HTTP_X_BOLT_PHONE_UA'])) {
 $_mob_browser = $_SERVER['HTTP_X_BOLT_PHONE_UA'];
 $_position=strpos(strtolower($_mob_browser),"nokia");$position=strpos(strtolower($_mob_browser),"android");
 if($_position){$_mob_browser = substr($_mob_browser, $_position,25);}
 else{if($position)$_mob_browser = substr($_mob_browser, $position,25);$_browser = explode ('-', $_mob_browser);return hridoysqlsecurityclean($_browser[0]);}
 $_browser = explode (' ', $_mob_browser); }else if (isset($_SERVER['HTTP_X_MOBILE_UA'])) {
 $_mob_browser = $_SERVER['HTTP_X_MOBILE_UA'];
 $_position=strpos(strtolower($_mob_browser),"nokia");$position=strpos(strtolower($_mob_browser),"android");
 if($_position){$_mob_browser = substr($_mob_browser, $_position,25);}
 else{if($position){$_mob_browser = substr($_mob_browser, $position,25);$_browser = explode ('-', $_mob_browser);return hridoysqlsecurityclean($_browser[0]);}}
 $_browser = explode (' ', $_mob_browser); }else if(isset($_SERVER['HTTP_X_devICE_USER_AGENT'])) {
 $_mob_browser = $_SERVER['HTTP_X_devICE_USER_AGENT'];
 $_position=strpos(strtolower($_mob_browser),"nokia");$position=strpos(strtolower($_mob_browser),"android");
 if($_position){$_mob_browser = substr($_mob_browser, $_position,25);}
 else{if($position){$_mob_browser = substr($_mob_browser, $position,25);$_browser = explode ('-', $_mob_browser);return hridoysqlsecurityclean($_browser[0]);}}
 $_browser = explode (' ', $_mob_browser);}else{$_position=strpos(strtolower($_mob_browser),"nokia");$position=strpos(strtolower($_mob_browser),"android");
 if($_position){$_mob_browser = substr($_mob_browser, $_position,25);}
 else{if($position){$_mob_browser = substr($_mob_browser, $position,25);$_browser = explode ('-', $_mob_browser);return hridoysqlsecurityclean($_browser[0]);}}
 
 $_browser = explode (' ', $_mob_browser);
 }
   
            return hridoysqlsecurityclean($_browser[0]);            
}


function getoribrowser($_mob_browser){
if(preg_match('/(google|bot)/i',strtolower($_mob_browser))){
$position = strpos(strtolower($_mob_browser),"bot");
$_mob_browser = substr($_mob_browser, $position-30, $position+2);
$_browser = explode (" ", $_mob_browser);
$_browser = array_reverse($_browser); 
}else if (isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])) {
$_mob_browser = $_SERVER['HTTP_X_OPERAMINI_PHONE_UA'];
$_position=strpos(strtolower($_mob_browser),"nokia");
if($_position)$_mob_browser = substr($_mob_browser, $_position,25);
$_browser = explode ("/", $_mob_browser);
}else {
$_position=strpos(strtolower($_mob_browser),"nokia");
if($_position)$_mob_browser = substr($_mob_browser, $_position,25);
$_browser = explode ("/", $_mob_browser);
}
return $_browser[0];
}

function getbrowser(){
if (isset($_SERVER)){
$browserA = explode("(",$_SERVER["HTTP_USER_AGENT"]); 
$browserB = explode(")",$browserA[1]);
$browser = $browserA[0]."(".$browserB[0]." ".$browserB[1].")";
}else{
$browserA = explode("(",getenv("HTTP_USER_AGENT")); 
$browserB = explode(")",$browserA[1]);
$browser = $browserA[0]."(".$browserB[0]." ".$browserB[1].")";
}

return $browser; 

}
function connectdb()
{
    global $dbname, $dbuser, $dbhost, $dbpass;
    $conms = @mysql_connect($dbhost,$dbuser,$dbpass); //connect mysql
    if(!$conms) return false;
    $condb = @mysql_select_db($dbname);
    if(!$condb) return false;
    return true;
}
/////register form
function getnewgml($uid)
{
  /*
    global $onver;
    if($onver)
    {
        $doit = false;
        $gmi = mysql_fetch_array(mysql_query("SELECT gmailun, gmailpw, gmailchk, gmaillch, timezone FROM dcroxx_me_xinfo WHERE uid='".$uid."'"));
        $cancheck = $gmi[2]*60;
        $cancheck += $gmi[3];
        if((time() + $timeadjust) >=$cancheck)
        {
          $doit = true;
        }
        if(trim($gmi[0])!="" && trim($gmi[1])!="")
        {
          $doit = true;
        }
        if ($doit)
        {
          if($cancheck+60>(time() + $timeadjust) )
          {
           $ttime = (time() + $timeadjust);
            mysql_query("UPDATE dcroxx_me_xinfo SET gmaillch='".$ttime."' WHERE uid='".$uid."'");
          }
            return getnewm($gmi[0],$gmi[1],$gmi[4]);

        }
        return 0;

    }else{
      return 0;
    }
  */
}
function findcard($tcode)
{
    $st =strpos($tcode,"[card=");
    if ($st === false)
    {
      return $tcode;
    }else
    {
      $ed =strpos($tcode,"[/card]");
      if($ed=== false)
      {
        return $tcode;
      }
    }
    $texth = substr($tcode,0,$st);
    $textf = substr($tcode,$ed+7);
    $msg = substr($tcode,$st+10,$ed-$st-10);
    $cid = substr($tcode,$st+6,3);
    $words = explode(' ',$msg);
    $msg = implode('+',$words);
  return "$texth<br/><img src=\"pmcard.php?cid=$cid&amp;msg=$msg\" alt=\"$cid\"/><br/>$textf";
}

function notification($uid){
    $nopm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_notifications WHERE touid='".$uid."' AND unread='1'"));
    return $nopm[0];

}
function notification2($uid){
    $nopm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM ibwf_notifications WHERE touid='".$uid."'"));
    return $nopm[0];

}
function notify($msg,$uid,$who)
{
mysql_query("INSERT INTO ibwf_notifications SET text='".$msg."', byuid='".$uid."', touid='".$who."', unread='1', timesent='".time()."'");
}

//////////////////////////is disabled?
function isdisabled($uid){
$not = mysql_fetch_array(mysql_query("SELECT 2x_disabl_acc FROM dcroxx_me_users WHERE id='".$uid."'"));
if($not[0]=='1'){
return true;
}else{
return false;
}}
///////////////////////////////////////////is pmban?
function ispmbaned($uid)
{
$not = mysql_fetch_array(mysql_query("SELECT xpmban2x FROM dcroxx_me_users WHERE id='".$uid."'"));
if($not[0]=='1')
{
return true;
}else{
return false;
}
}
///////////////////////////////////////////is postban?
function ispostbaned($uid)
{
$not = mysql_fetch_array(mysql_query("SELECT postban FROM dcroxx_me_users WHERE id='".$uid."'"));
if($not[0]=='1')
{
return true;
}else{
return false;
}
}
///////////////////////////////////////////is shoutban?
function isshoutbaned($uid)
{
$not = mysql_fetch_array(mysql_query("SELECT shoutban FROM dcroxx_me_users WHERE id='".$uid."'"));
if($not[0]=='1')
{
return true;
}else{
return false;
}
}
///////////////////////////////////////////is chatban?
function ischatbaned($uid)
{
$not = mysql_fetch_array(mysql_query("SELECT chatban FROM dcroxx_me_users WHERE id='".$uid."'"));
if($not[0]=='1')
{
return true;
}else{
return false;
}
}


function addtogc($uid){
$timeto = 180;
$timenw = time();
$timeout = $timenw - $timeto;
$bago = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_gconline WHERE uid='".$uid."'"));
if($bago[0]==0){
mysql_query("INSERT INTO dcroxx_me_gconline SET lton='".time()."', uid='".$uid."'");
}else{
mysql_query("UPDATE dcroxx_me_gconline SET lton='".time()."' WHERE uid='".$uid."'");
}
}


function saveuinfo($sid)
{

    $headers = apache_request_headers();
    $alli = "";
    foreach ($headers as $header => $value)
    {
        $alli .= "$header: $value <br />\n";
    }
    $alli .= "IP: ".$_SERVER['REMOTE_ADDR']."<br/>";
    $alli .= "REFERRER: ".$_SERVER['HTTP_REFERER']."<br/>";
    $alli .= "REMOTE HOST: ".getenv('REMOTE_HOST')."<br/>";
    $alli .= "PROX: ".$_SERVER['HTTP_X_FORWARDED_FOR']."<br/>";
    $alli .= "HOST: ".getenv('HTTP_X_FORWARDED_HOST')."<br/>";
    $alli .= "SERV: ".getenv('HTTP_X_FORWARDED_SERVER')."<br/>";
    if(trim($sid)!="")
    {
        $uid = getuid_sid($sid);
        $fname = "tmp/".getnick_uid($uid).".rwi";
        $out = fopen($fname,"w");
        fwrite($out,$alli);
        fclose($out);
    }

    //return 0;
}
function registerform($ef)
{
  $ue = $errl = $pe = $ce = "";
  switch($ef)
  {
    case 1:
        $errl = "<img src=\"images/point.gif\" alt=\"!\"/> Please type your  Nick (Space or bad nick not allow)";
        $ue = "<img src=\"images/point.gif\" alt=\"!\"/>";
        break;
  case 2:
  $errl = "<img src=\"images/point.gif\" alt=\"!\"/> Please type your password";
    $pe = "<img src=\"images/point.gif\" alt=\"!\"/>";
     break;
 /*case 3:
    $errl = "<img src=\"images/point.gif\" alt=\"!\"/> Please type your password again";
        $ce = "<img src=\"images/point.gif\" alt=\"!\"/>";
        break;*/
    case 4:
        $errl = "<img src=\"images/point.gif\" alt=\"!\"/> User Nick is invalid";
        $ue = "<img src=\"images/point.gif\" alt=\"!\"/>";
        break;
    case 5:
        $errl = "<img src=\"images/point.gif\" alt=\"!\"/> Password is invalid";
        $pe = "<img src=\"images/point.gif\" alt=\"!\"/>";
        break;
    /*case 6:
        $errl = "<img src=\"images/point.gif\" alt=\"!\"/> Passwords doesn't match";
        $ce = "<img src=\"images/point.gif\" alt=\"!\"/>";
        break;*/
    case 7:
        $errl = "<img src=\"images/point.gif\" alt=\"!\"/> Ur Nick must be 4 characters or more";
        $ue = "<img src=\"images/point.gif\" alt=\"!\"/>";
        break;
    case 8:
        $errl = "<img src=\"images/point.gif\" alt=\"!\"/> Password must be 4 characters or more";
        $pe = "<img src=\"images/point.gif\" alt=\"!\"/>";
        break;
    case 9:
    $errl = "<img src=\"images/point.gif\" alt=\"!\"/> your Nick already in use, choose a different one";
        $ue = "<img src=\"images/point.gif\" alt=\"!\"/>";
        break;
    case 10:
        $errl = "<img src=\"images/point.gif\" alt=\"!\"/> Unknown mysql error try registering later";

        break;
    case 11:
     $errl = "<img src=\"images/point.gif\" alt=\"!\"/> User Nick must start with a letter from a-z";
        $ue = "<img src=\"images/point.gif\" alt=\"!\"/>";
        break;
    case 12:
     $errl = "<img src=\"images/point.gif\" alt=\"!\"/> User Nick is reserved for admins of the site";
        $ue = "<img src=\"images/point.gif\" alt=\"!\"/>";
        break;
    case 13:
        $errl = "<img src=\"images/point.gif\" alt=\"!\"/> Please choose an appropriate nickname";
  $ue = "<img src=\"images/point.gif\" alt=\"!\"/>";
           break;
   case 14:
        $errl = "<img src=\"images/point.gif\" alt=\"!\"/> U must enter an email address";
        $ue = "<img src=\"images/point.gif\" alt=\"!\"/>";
	     break;
    case 15:
        $errl = "<img src=\"images/point.gif\" alt=\"!\"/> Incorrect Verification Code";
        $ue = "<img src=\"images/point.gif\" alt=\"!\"/>";
        break;
  }

$rform = "<small>$errl</small><br/>";
  $rform .= "<form action=\"register.php\" method=\"post\">";
  $rform .= "<small>Username:</small> <br/><input name=\"uid\" maxlength=\"15\" format=\"*x\" maxlength=\"30\"/><br/>";
  $rform .= "<small>Password:</small> <br/><input type=\"password\" name=\"pwd\" format=\"*x\" maxlength=\"30\" AUTOCOMPLETE=\"off\"/><br/>";
  //$rform .= "<small>Password Again:</small> <br/><input type=\"password\" name=\"cpw\" format=\"*x\" maxlength=\"30\"/><br/>";
  $rform .= "<small>Birthday (YYYY-MM-DD)</small>: <br/><input name=\"bdyy\" format=\"*N\" size=\"4\" maxlength=\"4\"/>-<input name=\"bdym\" format=\"*N\" size=\"2\" maxlength=\"2\"/>-<input name=\"bdyd\" format=\"*N\" size=\"2\" maxlength=\"2\"/><br/>";
  $rform .= "<small>Sex/Gender:</small><br/>";
  $rform .= "<select name=\"usx\" value=\"M\">";
  $rform .= "<option value=\"M\">Male/Boy</option>";
  $rform .= "<option value=\"F\">Female/Girl</option>";
  $rform .= "</select><br/>";
  $rform .= "<small>Location[Country-Area]:</small> <br/><input name=\"ulc\"  maxlength=\"100\" placeHolder=\"Ex: BD-Dhaka\"/><br/>";
  $rform .= "<small>Email Address:</small> <br/><input name=\"email\" maxlength=\"50\"/><br/>";
    $rform .= "<small>Site Language:</small><br/>";
 $rform .= "<select name=\"lang\" value=\"1\">";
  $rform .= "<option value=\"1\">English (Default)</option>";
  $rform .= "<option value=\"7\">Bangla</option>";
//  $rform .= "<option value=\"2\">Sinhala</option>";
 // $rform .= "<option value=\"3\">Afrikaans</option>";
 //   $rform .= "<option value=\"4\">Indonesian</option>";
    $rform .= "<option value=\"5\">Arabic</option>";

    $rform .= "</select><br/>";
  $rform .= "<small>Enter Code</small><br/>\n";
  $rform .= "<img src=\"captcha.php\" alt=\"Code\"><br/>\n";
  $rform .= "<input type=\"text\" name=\"captcha\" /><br>\n";
    $r = $_GET["r"];
  if($r>0){
  $rform .= "<input type=\"hidden\" name=\"reff\" value=\"$r\"/>";
}
  $rform .= "<input type='hidden' name=\"act\" value=\"$code\"/>";
  $rform .= "<input type='hidden' name=\"cod\" value=\"$cod\"/>";
  $rform .= "<input type=\"submit\" value=\"Register\" class=\"hmenu hmenubottom\"/>";
  $rform .= "</form>";
  return $rform;
  return $rform;
}
///////////////////////////////////////////is shielded?

function gohere($uid)
{
  $not = mysql_fetch_array(mysql_query("SELECT pid FROM dcroxx_me_users WHERE id='".$uid."'"));
  if($not[0]=='1')
  {
    return true;
  }else{
    return false;
  }
}
/////////////////////////////////////////////////paper
function echo_scores2($uid,$poy,$pchoice,$cchoice,$wld)
{
$nopl = mysql_fetch_array(mysql_query("SELECT byuid FROM dcroxx_me_jnp WHERE id='".$poy."'"));
	$unick = getnick_uid($nopl[0]);
if ($wld == "won")
         {

        	$text = "You give $pchoice to $unick who give you $cchoice you WON!";

         }

        if ($wld == "lost")
          {

           	$text = "You give $pchoice to $unick who give you $cchoice you LOSE!";

         }

        if ($wld == "drew")
          {

           	$text = "You give $pchoice to $unick who give you $cchoice you DRAW!";

                 }

        echo "$text<br/>";

        return true;
}
//////////////////////Function add user to online list :P

function addlast($uid,$place)
{
 $res = mysql_query("UPDATE dcroxx_me_users SET place='".$place."' WHERE id='".$uid."'");
  $res = mysql_query("INSERT INTO dcroxx_me_users SET id='".$uid."', place='".$place."'");
  if(!$res)
  {
    //most probably userid already in the online list
    //so just update the place and time
    $res = mysql_query("UPDATE dcroxx_me_users SET place='".$place."' WHERE id='".$uid."'");
}
}
//////////////////////////////////////////// Search Id
function generate_srid($svar1,$svar2="", $svar3="", $svar4="", $svar5="")
{

  $res = mysql_fetch_array(mysql_query("SELECT id FROM dcroxx_me_search WHERE svar1 like '".$svar1."' AND svar2 like '".$svar2."' AND svar3 like '".$svar3."' AND svar4 like '".$svar4."' AND svar5 like '".$svar5."'"));
  if($res[0]>0)
  {
    return $res[0];
  }
  $ttime = (time() + $timeadjust);
  mysql_query("INSERT INTO dcroxx_me_search SET svar1='".$svar1."', svar2='".$svar2."', svar3='".$svar3."', svar4='".$svar4."', svar5='".$svar5."', stime='".$ttime."'");
  $res = mysql_fetch_array(mysql_query("SELECT id FROM dcroxx_me_search WHERE svar1 like '".$svar1."' AND svar2 like '".$svar2."' AND svar3 like '".$svar3."' AND svar4 like '".$svar4."' AND svar5 like '".$svar5."'"));
  return $res[0];
}

function candelvl($uid, $item)
{
  $candoit = mysql_fetch_array(mysql_query("SELECT  uid FROM dcroxx_me_vault WHERE id='".$item."'"));
  if($uid==$candoit[0]||ismod($uid))
  {
    return true;
  }
  return false;
}

/////////////////////////////////// GET RATE

function geturate($uid)
{
  $pnts = 0;
  //by blogs, posts per day, chats per day, gb signatures
  if(ismod($uid))
  {
    return 5;
  }
  $noi = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_blogs WHERE bowner='".$uid."'"));
  if($noi[0]>=5)
  {
    $pnts = 5;
  }else{
    $pnts = $noi[0];
  }
  $noi = mysql_fetch_array(mysql_query("SELECT regdate, plusses, chmsgs FROM dcroxx_me_users WHERE id='".$uid."'"));
  $rwage = ceil(((time() + $timeadjust)- $noi[0])/(24*60*60) );
  $ppd = ceil($noi[1]/$rwage);
  if($ppd>=20)
  {
    $pnts+=5;
  }else{
    $pnts += floor($ppd/4);
  }
  $cpd = ceil($noi[2]/$rwage);
  if($cpd>=100)
  {
    $pnts+=5;
  }else{
    $pnts += floor($cpd/20);
  }
  return floor($pnts/3);



}
///////////////////////////////////function isuser

function isuser($uid)
{
  $cus = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE id='".$uid."'"));
  if($cus[0]>0)
  {
    return true;
  }
  return false;
}
////////////////////////////////////////////Spam filter

function isenta($text)
{
  $sfil[0] = "enttt";

  $text = str_replace(" ", "", $text);
  $text = strtolower($text);
  for($i=0;$i<count($sfil);$i++)
  {

    $nosf = substr_count($text,$sfil[$i]);
    if($nosf>0)
    {
      return true;
    }
  }

  return false;
}
////////////////////////////////////////////Can access forum

function canaccess($uid, $fid)
{
  $fex = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_forums WHERE id='".$fid."'"));
  if($fex[0]==0)
  {
    return false;
  }
  $persc = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_acc WHERE fid='".$fid."'"));
  if($persc[0]==0)
  {
    $clid = mysql_fetch_array(mysql_query("SELECT clubid FROM dcroxx_me_forums WHERE id='".$fid."'"));
    if($clid[0]==0)
    {
      return true;
    }else{
      if(ismod($uid))
      {
        return true;
      }else{
        $ismm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_clubmembers WHERE uid='".$uid."' AND clid='".$clid[0]."'"));
        if($ismm[0]>0)
        {
          return true;
        }else{
          return false;
        }
      }
    }

  }else{
    $gid = mysql_fetch_array(mysql_query("SELECT gid FROM dcroxx_me_acc WHERE fid='".$fid."'"));
    $gid = $gid[0];
    $ginfo = mysql_fetch_array(mysql_query("SELECT autoass, mage, userst, posts, plusses FROM dcroxx_me_groups WHERE id='".$gid."'"));
    if($ginfo[0]=="1")
    {
      $uperms = mysql_fetch_array(mysql_query("SELECT birthday, perm, posts, plusses FROM dcroxx_me_users WHERE id='".$uid."'"));

      if($ginfo[2]==4)
      {

        if(isowner($uid))
        {
            return true;
        }else{
          return false;
        }
      }
      if($ginfo[2]==3)
      {

        if(isheadadmin($uid))
        {
            return true;
        }else{
          return false;
        }
      }
      if($ginfo[2]==2)
      {

        if(isadmin($uid))
        {
            return true;
        }else{
          return false;
        }
      }

      if($ginfo[2]==1)
      {

        if(ismod($uid))
        {
            return true;
        }else{
          return false;
        }
      }
      if($uperms[1]>$ginfo[2])
      {
        return true;
      }
      $acc = true;
      if(getage($uperms[0])< $ginfo[1])
      {
        $acc =  false;
      }
      if($uperms[2]<$ginfo[3])
      {
        $acc =  false;
      }
      if($uperms[3]<$ginfo[4])
      {
        $acc =  false;
      }

    }
  }
  return $acc;
}

///////////////////////////////
function getsimbol($uid)
 {
 $info= mysql_fetch_array(mysql_query("SELECT perm, plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
  if(isbanned($uid))
  {
    return "(x)";
  }
  if($info[0]=='4')
  {
   return "&#169;";
  }else  if($info[0]=='3')
 {
    return "&#185;";
  }else if($info[0]=='2')
  {
    return "&#178;";
  }else if($info[0]=='1')
  {
    return "&#179;";
  }else{
     if($info[1]<10)
   {
     return ".";
    }else if($info[1]<50)
    {
       return "+";
    }else if($info[1]<125)
    {
       return "*";
    }else if($info[1]<500)
    {
       return "&#170;";
    }else if($info[1]<4000)
    {
        return "&#177;";
    }else if($info[1]<6000)
    {
        return "&#167;";
    }else if($info[1]<10000)
    {
        return ":D";
    }else
   {
        return "&#164;";
    }
  }
}
function unhtmlspecialchars2( $string )
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
}

function getuage_sid($sid)
{
  $uid = getuid_sid($sid);
  $uage = mysql_fetch_array(mysql_query("SELECT birthday FROM dcroxx_me_users WHERE id='".$uid."'"));
  return getage($uage[0]);
}

function canenter($rid, $sid)
{
    $rperm = mysql_fetch_array(mysql_query("SELECT mage, perms, chposts, clubid FROM dcroxx_me_rooms WHERE id='".$rid."'"));
    $uperm = mysql_fetch_array(mysql_query("SELECT birthday, chmsgs FROM dcroxx_me_users WHERE id='".getuid_sid($sid)."'"));
    if($rperm[3]!=0)
    {
      if(ismod(getuid_sid($sid)))
      {
        return true;
      }else{
        $ismm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_clubmembers WHERE uid='".getuid_sid($sid)."' AND clid='".$rperm[3]."'"));
        if($ismm[0]>0)
        {
          return true;
        }else{
          return false;
        }
      }
   }
    if($rperm[1]==1)
    {
      return ismod(getuid_sid($sid));
    }
    if($rperm[1]==2)
    {
      return isadmin(getuid_sid($sid));
    }
     if($rperm[1]==3)
    {
      return isheadadmin(getuid_sid($sid));
    }
    if($rperm[1]==4)
    {
      return isowner(getuid_sid($sid));
    }

    if(getuage_sid($sid)<$rperm[0])
    {
      return false;
    }
    if($uperm[1]<$rperm[2])
    {
      return false;
    }
    return true;
}
///////////////////clear data


function cleardata()
{
 mysql_query("DELETE FROM ibwfrr_disable_shout WHERE timeto<'".time()."'");
 
 mysql_query("UPDATE dcroxx_me_users SET xpmban2x='0', xpmban2xtimeup='0' WHERE xpmban2xtimeup<'".time()."'");
 mysql_query("UPDATE dcroxx_me_users SET postban='0', postbantimeup='0' WHERE postbantimeup<'".time()."'");
 mysql_query("UPDATE dcroxx_me_users SET shoutban='0', shoutbantimeup='0' WHERE shoutbantimeup<'".time()."'");
 mysql_query("UPDATE dcroxx_me_users SET chatban='0', chatbantimeup='0' WHERE chatbantimeup<'".time()."'");
 

 $timeto = 180;

$timenw = time();

$timeout = $timenw - $timeto;

$exec = mysql_query("DELETE FROM dcroxx_me_gconline WHERE lton<'".$timeout."'");

 $timeto = 30*24*60*60;
  $timenw = time();
  $timeout = $timenw - $timeto;
  $exec = mysql_query("DELETE FROM dcroxx_me_ses WHERE expiretm<'".$timeout."'");
  $timeto = 500;
  $timenw = time();
  $timeout = $timenw - $timeto;
  $exec = mysql_query("DELETE FROM dcroxx_me_quizrooms WHERE displaytime<'".$timeout."'");
  $timeto = 120;
  $timenw = time();
  $timeout = $timenw - $timeto;
  $exec = mysql_query("DELETE FROM dcroxx_me_chonline WHERE lton<'".$timeout."'");
  $timeto = 420;
  $timenw = time();
  $timeout = $timenw - $timeto;
  $exec = mysql_query("DELETE FROM dcroxx_me_chat WHERE timesent<'".$timeout."'");
  $timeto = 60*60;
  $timenw = time();
  $timeout = $timenw - $timeto;
  $exec = mysql_query("DELETE FROM dcroxx_me_search WHERE stime<'".$timeout."'");
  ///delete expired rooms
  $start2 = mktime(0, 0); // midnight today
  $gettime = mysql_fetch_array(mysql_query("SELECT MAX(value) FROM dcroxx_me_settings WHERE name='reset'"));
  $timenw = time() + (14 * 3600);
 $timeto = mktime(0, 0); // midnight today
  $timeto -= 24*60*60;
    $start = $gettime[0]+57600;
if($start<$timenw)
    {

mysql_query("UPDATE dcroxx_me_settings SET value='$timenw' WHERE name='reset'");
$sql = "SELECT id FROM dcroxx_me_users";
        $ppl = mysql_query($sql);
        while($mem = mysql_fetch_array($ppl))
        {
 $timenw = time() + (14 * 3600);
        mysql_query("UPDATE dcroxx_me_users SET onlinetime='$timenw' WHERE id='".$mem[0]."'");
        mysql_query("UPDATE dcroxx_me_users SET onlinedone='0' WHERE id='".$mem[0]."'");
        mysql_query("UPDATE dcroxx_me_users SET resetime='$timenw' WHERE id='".$mem[0]."'");
}
}else{
 }
  $timeto = 5*60;
  $timenw = time();
  $timeout = $timenw - $timeto;
  $rooms = mysql_query("SELECT id FROM dcroxx_me_rooms WHERE static='0' AND lastmsg<'".$timeout."'");
  while ($room=mysql_fetch_array($rooms))
  {
    $ppl = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_chonline WHERE rid='".$room[0]."'"));
    if($ppl[0]==0)
    {
        $exec = mysql_query("DELETE FROM dcroxx_me_rooms WHERE id='".$room[0]."'");
    }
  }
  $lbpm = mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE name='lastbpm'"));
  $td = date("Y-m-d");
  //echo $lbpm[0];

  if ($td!=$lbpm[0])
  {
	//echo "boo";
	$sql = "SELECT id, name, birthday  FROM dcroxx_me_users where month(`birthday`) = month(curdate()) and dayofmonth(`birthday`) = dayofmonth(curdate())";
	$ppl = mysql_query($sql);
	while($mem = mysql_fetch_array($ppl))
	{
		$msg = "[card=008]to you $mem[1]"."[/card] pinoyaztig team wish you a day full of joy and happiness and many happy returns[br/]*fireworks*[br/][small][i]p.s: this is an automated pm[/i][/small]";
		autopm($msg, $mem[0]);
	}
	mysql_query("UPDATE dcroxx_me_settings SET value='".$td."' WHERE name='lastbpm'");
  }

}

///////////////////////////////////////get file ext.

function getext($strfnm)
{
  $str = trim($strfnm);
  if (strlen($str)<4){
    return $str;
  }
  for($i=strlen($str);$i>0;$i--)
  {
    $ext .= substr($str,$i,1);
    if(strlen($ext)==3)
    {
      $ext = strrev($ext);
      return $ext;
    }
  }
}

///////////////////////////////////////get extension icon

function getextimg($ext)
{
    $ext = strtolower($ext);
    switch ($ext)
    {
      case "jpg":
      case "gif":
      case "png":
      case "bmp":
        return "<img src=\"images/image.gif\" alt=\"*\"/>";
        break;
      case "zip":
      case "rar":
        return "<img src=\"images/pack.gif\" alt=\"*\"/>";
        break;
      case "jad":
      case "jar":
        return "<img src=\"images/game.gif\" alt=\"*\"/>";
        break;
      case "amr":
      case "wav":
      case "mp3":
        return "<img src=\"images/music.gif\" alt=\"*\"/>";
        break;
      case "mpg":
      case "3gp":
        return "<img src=\"images/video.gif\" alt=\"*\"/>";
        break;
      default:
        return "<img src=\"images/other.gif\" alt=\"*\"/>";
        break;
    }
}


//////////////////////////////////////RESIZE IMAGE
function imageResize($width, $height, $target) {

//takes the larger size of the width and height and applies the
//formula accordingly...this is so this script will work
//dynamically with any size image


$percentage = ($target / $width);


//gets the new value and applies the percentage, then rounds the value
$width = round($width * $percentage);
$height = round($height * $percentage);

//returns the new sizes in html image tag format...this is so you
//can plug this function inside an image tag and just get the

return "width=\"$width\" height=\"$height\"";

}
   function candelgal($uid, $item)
{
  $candoit = mysql_fetch_array(mysql_query("SELECT  uid FROM dcroxx_me_gallery3 WHERE id='".$item."'"));
  if($uid==$candoit[0]||ismod($uid))
  {
    return true;
  }
  return false;
}
///////////////////////////////////////Add to chat

function addtochat($uid, $rid)
{
  $timeto = 220;
  $timenw = (time() + $timeadjust);
  $timeout = $timenw - $timeto;
  $exec = mysql_query("DELETE FROM dcroxx_me_chonline WHERE lton<'".$timeout."'");
  $ttime = (time() + $timeadjust);
  $res = mysql_query("INSERT INTO dcroxx_me_chonline SET lton='".$ttime."', uid='".$uid."', rid='".$rid."'");
  if(!$res)
  {
    $ttime = (time() + $timeadjust);
    mysql_query("UPDATE dcroxx_me_chonline SET lton='".$ttime."', rid='".$rid."' WHERE uid='".$uid."'");
  }
}
////////////////////////////////////////////is mod

function ismod($uid)
{
  $perm = mysql_fetch_array(mysql_query("SELECT perm FROM dcroxx_me_users WHERE id='".$uid."'"));

  if($perm[0]>0)
  {
    return true;
  }
}

///////////////////////////if registration is allowed

function cancre()
{
   $getreg = mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE name='cc'"));
   if($getreg[0]=='1')
   {
     return true;
   }else
   {
     return false;
   }
}
////////////////////////////////////////////is mod

function ismod2($uid)
{
  $perm = mysql_fetch_array(mysql_query("SELECT perm FROM dcroxx_me_users WHERE id='".$uid."'"));

  if($perm[0]==1)
  {
    return true;
  }
}

////////////////////////////////////////////is mod

function candelgb($uid,$mid)
{
  $minfo = mysql_fetch_array(mysql_query("SELECT gbowner, gbsigner FROM dcroxx_me_gbook WHERE id='".$mid."'"));
  if($minfo[0]==$uid)
  {
    return true;
  }
  if($minfo[1]==$uid)
  {
    return true;
  }
  return false;
}

////////////////////////////////////////////Spam filter

function isspam($text)
{
  $sfil[0] = "www.";
  $sfil[1] = "http:";
 $sfil[2] = ".php";
  $text = str_replace(" ", "", $text);
  $text = strtolower($text);
  for($i=0;$i<count($sfil);$i++)
  {

    $nosf = substr_count($text,$sfil[$i]);
    if($nosf>0)
    {
      return true;
    }
  }

  return false;
}



    //////////////////////////////////////////functia contor profil
function mypro($uid, $tid)
{
  if($uid==$tid)
  {
    return true;
  }
}    /////////////////////// auto pm
function pmautomat($msg, $who)
{
    mysql_query("INSERT INTO dcroxx_me_notificare SET text='".$msg."', byuid='1', touid='".$who."', unread='1', timesent='".time()."'");

}
    function gettime()

{

	$part_time = explode(' ', microtime(7));
	$real_time = $part_time[1].substr($part_time[0], 1);
      return $real_time;
}   /////////////////////notificari necitite

function notificarenecitita($uid)
{
    $nopm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_notificare WHERE touid='".$uid."' AND unread='1'"));
    return $nopm[0];
}
//////////////////////////////////////////verbals(add more yours)
function uverbs($no)
{
		if($no==0)
			$utext = "Slapped<br/> and fell down...";
		else if($no==1)
			$utext = "Punched with kili Kili Shot...";
		else if($no==2)
			$utext = "swing and Kicked....";
		else if($no==3)
			$utext = "Jumped and swing the weapon....";
		else if($no==4)
			$utext = "Feel Something Wrong. <br/> howled and jumped....";
		else
			$utext = "Punched hard. <br/> howled....";
	return $utext;
}


function check_rpg($sid)
{
	$uid = getuid_sid($sid);
	$set="0";
	$checks = mysql_fetch_array(mysql_query("SELECT code FROM dcroxx_me_rpg WHERE uid='".$uid."'"));
	$check = $checks[0];
	if($check!="")
	$set = "1";
	if($set!="1")
	{
		$checks = mysql_fetch_array(mysql_query("SELECT code FROM dcroxx_me_rpg WHERE who='".$uid."'"));
		$check = $checks[0];
	}
	if($check!="0")
	{
		if($set=="1")
			$counts = mysql_query("SELECT who FROM dcroxx_me_rpg WHERE code='".$check."'");
		else
			$counts = mysql_query("SELECT uid FROM dcroxx_me_rpg WHERE code='".$check."'");
	}
	if(mysql_num_rows($counts)!= "0")
	{
		$count = mysql_fetch_array($counts);
		echo "<br/>";
		echo getshoutbox($sid);
		echo "<br/><br/>";
		$bet = mysql_fetch_array(mysql_query("SELECT bet FROM dcroxx_me_rpg WHERE code='".$check."'"));
		$bets = $bet[0];
		echo "Battle between ".getnick_uid($uid)." and ".getnick_uid($count[0])." with $bets Credits";

		echo "<br/><a href=\"wz.php?action=erpg&amp;who=$count[0]&amp;set=$uid&amp;code=$check\">I Accept the Challenge!</a><br/>";
		echo "<a href=\"wz.php?action=reject&amp;who=$count[0]&amp;set=$uid&amp;code=$check\">I Reject the Challenge</a><br/>";
	}
}

///////////////////////////////////get page from go

function getpage_go($go,$tid)
{
  if(trim($go)=="")return 1;
  if($go=="last")return getnumpages($tid);
  $counter=1;

  $posts = mysql_query("SELECT id FROM dcroxx_me_posts WHERE tid='".$tid."'");
  while($post=mysql_fetch_array($posts))
  {
    $counter++;
    $postid = $post[0];
    if($postid==$go)
    {
        $tore = ceil($counter/5);
        return $tore;
    }
  }
  return 1;
}

////////////////////////////get number of topic pages

function getnumpages($tid)
{
  $nops = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_posts WHERE tid='".$tid."'"));
  $nops = $nops[0]+1; //where did the 1 come from? the topic text, duh!
  $nopg = ceil($nops/5); //5 is the posts to show in each page
  return $nopg;
}


////////////////////////////////////////////can delete a blog?

function candelbl($uid,$bid)
{
  $minfo = mysql_fetch_array(mysql_query("SELECT bowner FROM dcroxx_me_blogs WHERE id='".$bid."'"));
  if(ismod($uid))
  {
    return true;
  }
  if($minfo[0]==$uid)
  {
    return true;
  }

  return false;
}

//////////////////////////////////////////////////RAVEBABE
function PostToHost($host, $path, $data_to_send)
{

				$result = "";
        $fp = fsockopen($host,80,$errno, $errstr, 30);
        if( $fp)
        {
            fputs($fp, "POST $path HTTP/1.0\n");
        fputs($fp, "Host: $host\n");
        fputs($fp, "Content-type: application/x-www-form-urlencoded\n");
        fputs($fp, "Content-length: " . strlen($data_to_send) . "\n");
        fputs($fp, "Connection: close\n\n");
        fputs($fp, $data_to_send);

        while(!feof($fp)) {
					$result .=  fgets($fp, 128);
        }
        fclose($fp);

        return $result;
        }


}
/////////////////////////Get user plusses

function getplusses($uid)
{
    $plus = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
    return $plus[0];
}
/////////////////////////Can uid sign who's guestbook?

function cansigngb($uid, $who)
{
  if(arebuds($uid, $who))
  {
    return true;
  }
  if($uid==$who)
  {
    return false; //imagine if someone signed his own gbook o.O
  }
  if(getplusses($uid)>=75)
  {
    return true;
  }
  return false;
}

/////////////////////////Can uid rate who's photo?

function canratephoto($uid, $who)
{
  if($uid==$who)
  {
    return false; //imagine if someone signed his own gbook o.O
  }else
  return true;
}
/////////////////////////////////////////////Are buds?

function arebuds($uid, $tid)
{
    $res = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_buddies WHERE ((uid='".$uid."' AND tid='".$tid."') OR (uid='".$tid."' AND tid='".$uid."')) AND agreed='1'"));
    if($res[0]>0)
    {
      return true;
    }
    return false;
}

//////////////////////////////////function get n. of buds

function getnbuds($uid)
{
  $notb = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_buddies WHERE (uid='".$uid."' OR tid='".$uid."') AND agreed='1'"));
  return $notb[0];
}

/////////////////////////////get no. of requists

function getnreqs($uid)
{
  $notb = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_buddies WHERE  tid='".$uid."' AND agreed='0'"));
  return $notb[0];
}


/////////////////////////////get no. of online buds

function getonbuds($uid)
{
  $counter =0;
    $buds = mysql_query("SELECT uid, tid FROM dcroxx_me_buddies WHERE (uid='".$uid."' OR tid='".$uid."') AND agreed='1'");
    while($bud=mysql_fetch_array($buds))
    {
      if($bud[0]==$uid)
      {
        $tid = $bud[1];
      }else{
        $tid = $bud[0];
      }
      if(isonline($tid))
      {
        $counter++;
      }
    }
    return $counter;
}
/////////////////////////////////////////////Function shoutbox
/*
function getshoutbox($sid)
{
  $lshout = mysql_fetch_array(mysql_query("SELECT shout, shouter, id  FROM dcroxx_me_shouts ORDER BY shtime DESC LIMIT 1"));
  $shnick = getnick_uid($lshout[1]);
  $shbox .= "<i><a href=\"index.php?action=viewuser&amp;who=$lshout[1]\">".$shnick."</a></i>: ";
  $shboxtxt = parsepm($lshout[0], $sid);
  $shbox .= str_replace("/reader",getnick_uid(getuid_sid($sid)), $shboxtxt);
  $shbox .= "<br/>";
  $shbox .= "<center>";
  $shbox .= "<small><a href=\"index.php?action=shout\">Shout</small></a> | ";
  $shbox .= "<small><a href=\"lists.php?action=shouts\">History</small></a>";
  if (ismod(getuid_sid($sid)))
  {
    $shbox .= " | <small><a href=\"mprocpl.php?action=delsh&amp;shid=$lshout[2]\">Delete</small></a>";
  }
  $shbox .= "</center>";
  return $shbox;
}
*/
/////////////////////////////////user link
function ulink($uid,$sid)
{
  $col = mysql_fetch_array(mysql_query("SELECT id,name,perm FROM dcroxx_me_users WHERE id='".$uid."'"));
  if($col[2]=='2')
  {
    $admn .= "<a href=\"index.php?action=viewuser&amp;who=$col[0]\" class=\"admn\">$col[1]</a>";
   return $admn;
}else if($col[2]=='1')
    {
        $modr .= "<a href=\"index.php?action=viewuser&amp;who=$col[0]\" class=\"modr\">$col[1]</a>"; 
        return $modr;
    }else{
$user .= "<a href=\"index.php?action=viewuser&amp;who=$col[0]\">$col[1]</a>";
  return $user;
}
}
////////////////////////////////////////////////////////////
function getshoutbox($sid)
{
$shbox = "<center><small>";
$lshout = mysql_query("SELECT shout, shouter, id, l_id, act_cat, act_id, img_id FROM dcroxx_me_shouts ORDER BY shtime DESC LIMIT 1");
while ($shots = mysql_fetch_array($lshout))
{
$shnick = getnick_uid($shots[1]);

  $avlink = getavatar($shots[1]);
  if ($avlink==""){
  $bulb= "<img src=\"images/nopic.jpg\" width=\"25\" height=\"30\" alt=\"Profile\"/></a>";
  }else{
  $bulb= "<img src=\"phpthumb.php?image=$avlink&h=30&w=25\" alt=\"Profile\"/></a>";
  }

/*if(isonline($shots[1]))
{
    $bulb="<img src=\"images/onl.gif\" alt=\"On\"/>";
}
else{
    $bulb="<img src=\"images/ofl.gif\" alt=\"Off\"/>";
}    */

$s = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_mention WHERE shid='".$shots[2]."'"));
$lst = mysql_fetch_array(mysql_query("SELECT tag_id FROM dcroxx_me_mention WHERE shid='".$shots[2]."'"));
$lnck = getnick_uid($lst[0]);
$ck = getnick_uid($lst[0]);
$cos = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_mention WHERE shid='".$shots[2]."'"));
$pip = $cos[0]-1;
if($cos[0]==1){ 
$lk = " <font color=\"#4c5157\">with</font> <a href=\"$ck\">$lnck</a>"; 
}else if($cos[0]>1) {
$lk = " <font color=\"#4c5157\">with</font> <a href=\"$ck\">$lnck</a> <font color=\"#4c5157\">and</font> <a href=\"tag_mention.php?action=tag_peoples&shid=$shots[2]\">$pip others</a>";
}else if ($cos[0]==0){
$lk = "";
}
//Start Activity & Feelings
if ($shots[5]=="" || $shots[5]=="0"){
$activity = "";
}else{
if ($shots[4]=="0"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$shots[5]."'"));
$activity = "<img src=\"$i[2]\"> <font color=\"#9397a0\">$i[0]</font>";
}else if ($shots[4]=="1"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$shots[5]."'"));
$activity = "<img src=\"$i[2]\"> feeling <font color=\"#9397a0\">$i[0]</font>";
}else if ($shots[4]=="2"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$shots[5]."'"));
$activity = "<img src=\"$i[2]\"> watching <font color=\"#9397a0\">$i[0]</font>";
}else if ($shots[4]=="3"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$shots[5]."'"));
$activity = "<img src=\"$i[2]\"> reading <font color=\"#9397a0\">$i[0]</font>";
}else if ($shots[4]=="4"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$shots[5]."'"));
$activity = "<img src=\"$i[2]\"> listening <font color=\"#899bc4\">$i[0]</font>";
}else if ($shots[4]=="5"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$shots[5]."'"));
$activity = "<img src=\"$i[2]\"> drinking <font color=\"#9397a0\">$i[0]</font>";
}else if ($shots[4]=="6"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$shots[5]."'"));
$activity = "<img src=\"$i[2]\"> eating <font color=\"#9397a0\">$i[0]</font>";
}else if ($shots[4]=="7"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$shots[5]."'"));
$activity = "<img src=\"$i[2]\"> playing <font color=\"#9397a0\">$i[0]</font>";
}else if ($shots[4]=="8"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$shots[5]."'"));
$activity = "<img src=\"$i[2]\"> travelling to <font color=\"#9397a0\">$i[0]</font>";
}else if ($shots[4]=="9"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$shots[5]."'"));
$activity = "<img src=\"$i[2]\"> looking for <font color=\"#9397a0\">$i[0]</font>";
}else if ($shots[4]=="10"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$shots[5]."'"));
$activity = "<img src=\"$i[2]\"> exercising <font color=\"#9397a0\">$i[0]</font>";
}else if ($shots[4]=="11"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$shots[5]."'"));
$activity = "<img src=\"$i[2]\"> attending <font color=\"#9397a0\">$i[0]</font>";
}else if ($shots[4]=="12"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$shots[5]."'"));
$activity = "<img src=\"$i[2]\"> supporting <font color=\"#9397a0\">$i[0]</font>";
}else if ($shots[4]=="13"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$shots[5]."'"));
$activity = "<img src=\"$i[2]\"> celebrating <font color=\"#9397a0\">$i[0]</font>";
}else if ($shots[4]=="14"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$shots[5]."'"));
$activity = "<img src=\"$i[2]\"> meeting <font color=\"#9397a0\">$i[0]</font>";
}else if ($shots[4]=="15"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$shots[5]."'"));
$activity = "<img src=\"$i[2]\"> getting <font color=\"#9397a0\">$i[0]</font>";
}else if ($shots[4]=="16"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$shots[5]."'"));
$activity = "<img src=\"$i[2]\"> making <font color=\"#9397a0\">$i[0]</font>";
}else if ($shots[4]=="17"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$shots[5]."'"));
$activity = "<img src=\"$i[2]\"> thinking about <font color=\"#9397a0\">$i[0]</font>";
}else if ($shots[4]=="18"){
$i = mysql_fetch_array(mysql_query("SELECT title, details, img FROM dcroxx_me_s_activity WHERE id='".$shots[5]."'"));
$activity = "<img src=\"$i[2]\"> remembering <font color=\"#9397a0\">$i[0]</font>";
}
}

if ($shots[3]=="" || $shots[3]=="0"){
$location = "";
}else{
$l_name = mysql_fetch_array(mysql_query("SELECT title, img FROM dcroxx_me_s_location WHERE id='".$shots[3]."'"));
$location = "<img src=\"$l_name[1]\"> at <font color=\"#07a851\">$l_name[0]</font><br/>";
}

$shbox .= "$bulb <i><a href=\"index.php?action=viewuser&who=$shots[1]\">".$shnick."</a></i> $activity $location $lk<br/> ";


$fshout = htmlspecialchars($shots[0]);

$fshout = getsmilies($fshout);
$fshout = findimage($fshout);
$shout = parsemsg($lshout[0],$sid);
$user = ulink($lshout[1],$sid);
$fshout = getbbcode($fshout, $sid);
$shbox .= $fshout;
//if (ismod(getuid_sid($sid))){
//$shbox .= ", <a href=\"modproc.php?action=delsh&shid=$shots[2]\">delete</a>";
//}
$shbox .= "<br/>";
if ($shots[6]==""){
$shbox .= "";
}else{
$shbox .= "<img src=\"$shots[6]\" alt=\"\"><br/>";
}


$shcomm = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) comm FROM dcroxx_me_shcomments WHERE shoutid='".$shots[2]."'"));
$shout = $shcomm['comm'];
$counts = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_like WHERE shoutid='".$shots[2]."'"));
$counts1 = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_dislike WHERE shoutid='".$shots[2]."'"));
if($counts[0]>0){ $lyk = "-<a href=\"like.php?action=main&amp;shid=$shots[2]\">$counts[0]</a>"; }else{ $lyk = ""; }
if($counts1[0]>0){ $dislyk = "-<a href=\"dislike.php?action=main&amp;shid=$shots[2]\">$counts1[0]</a>"; }else{ $dislyk = ""; }
$shbox .= "<a href=\"lists.php?action=shouts\">history</a>, ";
$shbox .= "<a href=\"shcomments.php?shid=$shots[2]\">comments</a>, ";

$i = mysql_fetch_array(mysql_query("SELECT shouter FROM dcroxx_me_shouts WHERE id='".$shots[2]."'"));
if (ismod(getuid_sid($sid)) || $i[0]==$uid){
$shbox .= "<a href=\"tag_mention.php?shid=$shots[2]\">tag</a>, ";
}
$shbox .= "<a href=\"genproc.php?action=like&amp;shid=$shots[2]\">like</a>$lyk, ";
$shbox .= "<a href=\"genproc.php?action=dislike&amp;shid=$shots[2]\">dislike</a>$dislyk";
}
//$shbox .= "<a href=\"lists.php?action=shouts\">&#187;post shout</a>";

$shbox .= "</center></small>";
return $shbox;
}
/////////////////////////////////////////////////////////
function getshouts($sid){
$uid=getuid_sid($sid);
if(!isshoutblocked($uid)){
    echo getshoutbox($sid);
}

}
/////////////////////////////////////////get vip

function getvipstatus($uid)
{
  $info= mysql_fetch_array(mysql_query("SELECT vip FROM dcroxx_me_users WHERE id='".$uid."'"));
  if(isbanned($uid))
  {
    return "Vip!<img src=\"images/banovan.gif\" alt=\"*\"/>";
  }
  if($info[0]=='0')
  {
    return "No Vip Status";
  }
  if($info[0]=='1')
      return "<img src=\"images/vip.jpg\" alt=\"*Vip clan*\"/>";
  }
/////////////////////////NOVAC

function getnovac($uid)
{
    $novac = mysql_fetch_array(mysql_query("SELECT novac FROM dcroxx_me_users WHERE id='".$uid."'"));
    return $novac[0];
}
/////////////////////////////////////////////get tid frm post id

function gettid_pid($pid)
{
  $tid = mysql_fetch_array(mysql_query("SELECT tid FROM dcroxx_me_posts WHERE id='".$pid."'"));
  return $tid[0];
}
////////////////////////////////////////////is vip

function isvip($uid)
{
  $vip = mysql_fetch_array(mysql_query("SELECT specialid>'0' FROM dcroxx_me_users WHERE id='".$uid."'"));
  
  if($vip[0]>0)
  {
    return true;
  }
}
///////////////////////////////////////////is trashed?

function istrashed($uid)
{
 $ttime = (time() + $timeadjust);
  $del = mysql_query("DELETE FROM dcroxx_me_metpenaltiespl WHERE timeto<'".$ttime."'");
  $not = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_metpenaltiespl WHERE uid='".$uid."' AND penalty='0'"));
  if($not[0]>0)
  {
    return true;
  }else{
    return false;
  }
}      function getextfile($ext)
{
    $ext = strtolower($ext);
    switch ($ext)
    {
      case "jpg":
      case "jpeg":
      case "jpe":
      return "image/jpeg";
        break;
      case "gif":
      return "image/x-generic";
        break;
       case "png":
      return "image/png";
        break;
       case "bmp":
        return "image/bmp";
        break;
      case "zip":
      return "application/zip";
        break;
      case "sis":
        return "application/vnd.symbian.install";
        break;
     case "rar":
        return "package/x-generic";
        break;
      case "amr":
     return "audio/amr";
        break;
     case "mpga":
      case "mp3":
      case "mp2":
        return "audio/mpeg";
        break;
      case "wav":
        return "audio/x-wav";
        break;
      case "mpg":
      case "mpeg":
      case "mpe":
      return "video/mpeg";
        break;
       case "3gp":
       case "3gpp":
        return "video/3gpp";
        break;
        case "jar":
        return "application/java-archive";
        break;
     case "jad":
        return "text/vnd.sun.j2me.app-descriptor";
        break;
        default:
        return "other";
        break;
    }
}
   /////////////////////notificare

function getpmcount1($uid,$view="all")
{
  if($view=="all"){
    $nopm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_notificare WHERE touid='".$uid."'"));
    }else if($view =="snt")
    {
        $nopm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_notificare WHERE byuid='".$uid."'"));
    }else if($view =="str")
    {
        $nopm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_notificare WHERE touid='".$uid."' AND starred='1'"));
    }else if($view =="urd")
    {
        $nopm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_notificare WHERE touid='".$uid."' AND unread='1'"));
    }
    return $nopm[0];
}

///////////////////////////////////////////is shielded?

function isshield($uid)
{
  $not = mysql_fetch_array(mysql_query("SELECT shield FROM dcroxx_me_users WHERE id='".$uid."'"));
  if($not[0]=='1')
  {
    return true;
  }else{
    return false;
  }
}

///////////////////////////////////////////Get IP

function getip_uid($uid)
{
  $not = mysql_fetch_array(mysql_query("SELECT ipadd FROM dcroxx_me_users WHERE id='".$uid."'"));
  return $not[0];

}

///////////////////////////////////////////Get Browser

function getbr_uid($uid)
{
  $not = mysql_fetch_array(mysql_query("SELECT browserm FROM dcroxx_me_users WHERE id='".$uid."'"));
  return $not[0];

}

///////////////////////////////////////////is trashed?

function isbanned($uid)
{
$ttime = time();
  $del = mysql_query("DELETE FROM dcroxx_me_metpenaltiespl WHERE timeto<'".$ttime."'");
  $not = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_metpenaltiespl WHERE uid='".$uid."' AND (penalty='1' OR penalty='2')"));

  if($not[0]>0)
  {
    return true;
  }else{
    return false;
  }
}


/////////////////////////////////////////////get tid frm post id

function gettname($tid)
{
  $tid = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_topics WHERE id='".$tid."'"));
  return $tid[0];
}

/////////////////////////////////////////////get tid frm post id

function getfid_tid($tid)
{
  $fid = mysql_fetch_array(mysql_query("SELECT fid FROM dcroxx_me_topics WHERE id='".$tid."'"));
  return $fid[0];
}

/////////////////////////////////////////////is ip banned

function isipbanned($uid)
{

  $pinf = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_metpenaltiespl WHERE penalty='2' AND ipadd='".$ipa."' AND browserm='".$brm."'"));
  if($pinf[0]>0)
  {
  return true;
}
return false;
}

////////////////get number of pinned topics in forum

function getpinned($fid)
{
  $nop = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_topics WHERE fid='".$fid."' AND pinned ='1'"));
  return $nop[0];
}
  /////////////////////////////////////////// Search Id
function iscowner($uid, $rid)
{
  $candoit = mysql_fetch_array(mysql_query("SELECT owner FROM dcroxx_me_rooms WHERE id='".$rid."'"));
  if($uid==$candoit[0]||ismod($uid))
  {
    return true;
  }
  return false;
}

///////////////////////////////////////////is shielded?

function locked($uid, $rid)
{
  $not = mysql_fetch_array(mysql_query("SELECT locked FROM dcroxx_me_rooms WHERE id='".$rid."'"));
  if($not[0]=='1')
  { return true;
  }else{
    return false;
  }
}
///////////////////////////////////////////is shielded?

function lockedcon($uid, $rid)
{
  $not = mysql_fetch_array(mysql_query("SELECT locked FROM dcroxx_me_rooms WHERE id='".$rid."'"));
  if($not[0]=='2')
  { return true;
  }else{
    return false;
  }
}   ///////////////////////////////////function isuser

function inside($uid, $rid)
{
   $ins = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_chonline WHERE uid='".$uid."' AND rid='".$rid."'"));
        if($ins[0]>0)
        {
          return true;
        }else{
          return false;
}
}
///////////////////////////////////function isuser

function inside2($uid, $rid)
{
   $ins = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_chat WHERE chatter='".$uid."' AND rid='".$rid."'"));
        if($ins[0]>0)
        {
          return true;
        }else{
          return false;
}
}
///////////////////////////////////////////is shielded?

function kick($uid,$rid)
{
  $not = mysql_fetch_array(mysql_query("SELECT kick FROM dcroxx_me_kick WHERE uid='".$uid."' AND rid='".$rid."'"));
  if($not[0]=='1')
  {
    return true;
  }else{
    return false;
  }
}
/////////////////////////////////////////////can bud?

function budres($uid, $tid)
{
  //3 = can't bud
  //2 = already buds
  //1 = request pended
  //0 = can bud
  if($uid==$tid)
  {
    return 3;
  }

  if (arebuds($uid, $tid))
  {
    return 2;
  }
  $req = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_buddies WHERE ((uid='".$uid."' AND tid='".$tid."') OR (uid='".$tid."' AND tid='".$uid."')) AND agreed='0'"));
  if($req[0]>0)
  {
    return 1;
  }
  $notb = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_buddies WHERE (uid='".$tid."' OR tid='".$tid."') AND agreed='1'"));
  global $max_buds;
  if($notb[0]>=$max_buds)
  {

    return 3;
  }
  $notb = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_buddies WHERE (uid='".$uid."' OR tid='".$uid."') AND agreed='1'"));
  global $max_buds;
  if($notb[0]>=$max_buds)
  {

    return 3;
  }
  return 0;
}
function getalert($sid){

    if (alertstat($sid)==1){

    $userid = getuid_sid($sid);

        $count = mysql_fetch_array(mysql_query("SELECT COUNT(id) FROM dcroxx_me_private WHERE touid = $userid AND unread='1'"));

        if($count[0]>0){

    $lastmsg_id = mysql_fetch_array(mysql_query("SELECT MIN(id) FROM dcroxx_me_private WHERE touid = $userid AND unread='1'"));

        $pminfo = mysql_fetch_array(mysql_query("SELECT text, timesent, byuid, reported FROM dcroxx_me_private WHERE id = $lastmsg_id[0]"));

    if(isonline($pminfo[2])){

$iml = "<img src=\"images/onl.gif\" alt=\"On\"/>";

}else{

$iml = "<img src=\"images/ofl.gif\" alt=\"Off\"/>";

}

$msgtxt = "Popup Pm";

$msgtxt .= "<small><b>From</b>: $iml<a href=\"index.php?action=viewuser&amp;who=$pminfo[2]\">".getnick_uid($pminfo[2])."</a><br/>";

$tmstamp = $pminfo[1] + addhours();

$tmdt = date("d/m/Y h:i:s A", $tmstamp);

$diff1=time()-$pminfo[1];

$msgtxt .= "<b>Sent</b>: $tmdt<br/>".gettimemsg($diff1)."<br/>";

$pmtext = parsepm($pminfo[0], $sid);

if(isspam($pmtext)){

if(($pminfo[3]=="0") && ($pminfo[2]!=1)){

mysql_query("UPDATE dcroxx_me_private SET reported='1' WHERE id='".$pmid."'");

}

}

$msgtxt .= "<b>Message</b>:<br/>".$pmtext;

$msgtxt .= "<u><br/>Reply:</u>:<br/>";

$msgtxt .= "<form action=\"inbxproc.php?action=sendpm&amp;who=$pminfo[2]\" method=\"post\"><textarea id=\"inputText\" name=\"pmtext\"></textarea><br/>";

$msgtxt .= "<input id=\"inputButton\" type=\"submit\" value=\"Send\"/>";

$msgtxt .= "</form>";

$msgtxt .= "<br/><a href=\"inbox.php?action=main\">Go to Inbox</a><br/></small></div></div>";

mysql_query("UPDATE dcroxx_me_private SET unread='0' WHERE id = $lastmsg_id[0]");

echo $msgtxt;

return;

}

else {

    return "";

}

}

else {

    return "";

}

}
////////////////////////////////////////////Session expiry time

function getsxtm()
{
   $getdata = mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE name='sesexp'"));
   return $getdata[0];
}

////////////////////////////////////////////Get bud msg

function getbudmsg($uid)
{
   $getdata = mysql_fetch_array(mysql_query("SELECT budmsg FROM dcroxx_me_users WHERE id='".$uid."'"));
   return $getdata[0];
}

////////////////////////////////////////////Get forum name

function getfname($fid)
{
  $fname = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_forums WHERE id='".$fid."'"));
  return $fname[0];
}
////////////////////////////////////////////PM antiflood time

function getpmaf()
{
   $getdata = mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE name='pmaf'"));
   return $getdata[0];
}
   //////////////////////Function add user to online list :P

function addplace($uid,$plc)
{
 $res = mysql_query("UPDATE dcroxx_me_users SET saan='".$plc."' WHERE id='".$uid."'");
  $res = mysql_query("INSERT INTO dcroxx_me_users SET id='".$uid."', saan='".$plc."'");
  if(!$res)
  {
    //most probably userid already in the online list
    //so just update the place and time
    $res = mysql_query("UPDATE dcroxx_me_users SET saan='".$plc."' WHERE id='".$uid."'");
}
}
////////////////////////////////////////////PM antiflood time

function getfview()
{
   $getdata = mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE name='fview'"));
   return $getdata[0];
}

////////////////////////////////////////////get forum message

function getfmsg()
{
   $getdata = mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE name='4ummsg'"));
   return $getdata[0];
}
////////////////////////////////////////////get forum message

function getfmsg3()
{
   $getdata = mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE name='4ummsg3'"));
   return $getdata[0];
}
////////////////////////////////////////////get Login Page message

function getfmsg2()
{
   $getdata = mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE name='4ummsg2'"));
   return $getdata[0];
}
//////////////////////////////////////////////is online

function isonline($uid)
{
  $uon = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_online WHERE userid='".$uid."'"));
  if($uon[0]>0)
  {
    return true;
  }else
  {
    return false;
  }
}
///////////////////////////if registration is allowed

function canreg()
{
   $getreg = mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE name='reg'"));
   if($getreg[0]=='1')
   {
     return true;
   }else
   {
     return false;
   }
}
    /////////////////////////////////////////////popups on
 function popupson($who)
 {
   $res = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE id='".$who."' AND popmsg='1'"));
     if($res[0]>0)
     {
       return true;
     }
     return false;
 }
    /////////////////////////////////////////////////paper
function echo_scores($pscore,$cscore,$pchoice,$cchoice,$wld)
{

	if ($wld == "won")
         {

        	$text = "You chose $pchoice. Kindaters chose $cchoice. You won.";

         }

        if ($wld == "lost")
          {

           	$text = "You chose $pchoice. Kindaters chose $cchoice. You lost.";

         }

        if ($wld == "drew")
          {

           	$text = "You chose $pchoice. So did Kindaters. You draw.";

                 }

        echo "You: $pscore<br/>";
	echo "Kindaters: $cscore<br/>";
        echo "$text<br/>";
	 echo $game;
        return true;
}

function getppp($uid){

    $ppp = mysql_fetch_array(mysql_query("SELECT ppp FROM dcroxx_me_users WHERE id = $uid"));

    return $ppp[0];

}
function alertstat($sid){

    $userid=getuid_sid($sid);

    if(!$userid){

        return 0;

    }

$alerstat = mysql_fetch_array(mysql_query("SELECT alert FROM dcroxx_me_users WHERE id = $userid"));

return $alerstat[0];

}
function getmmscount($uid,$view="all"){

if($view=="all"){

$nopm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM mms WHERE touid='".$uid."'"));

}else if($view =="snt"){

$nopm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM mms WHERE byuid='".$uid."'"));

}else if($view =="str"){

$nopm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM mms WHERE touid='".$uid."' AND starred='1'"));

}else if($view =="urd"){

$nopm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM mms WHERE touid='".$uid."' AND unread='1'"));

}

return $nopm[0];

}
function getunreadmms($uid){

$nopm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM mms WHERE touid='".$uid."' AND unread='1'"));

return $nopm[0];

}
///////////////////////////////////////////Get Forum ID

function getfid($topicid)
{
  $fid = mysql_fetch_array(mysql_query("SELECT fid FROM dcroxx_me_topics WHERE id='".$topicid."'"));
  return $fid[0];
}
////////////////////////////////////////////Parse PM
////anti spam
function parsepm($text, $sid="")
{
  $text = htmlspecialchars($text);
  $sml = mysql_fetch_array(mysql_query("SELECT hvia FROM dcroxx_me_users WHERE id='".getuid_sid($sid)."'"));
  if ($sml[0]=="1")
  {
  $text = getsmilies($text);
  }
  $text = getbbcode($text, $sid, 1);
  $text = findcard($text);
  $text = findimage($text);
  return $text;
}


////////////////////////////////////////////Parse other msgs

function parsemsg($text,$sid="")
{
  $text = htmlspecialchars($text);
  $sml = mysql_fetch_array(mysql_query("SELECT hvia FROM dcroxx_me_users WHERE id='".getuid_sid($sid)."'"));
  if ($sml[0]=="1")
  {
  $text = getsmilies($text);
  }
  $text = getbbcode($text, $sid);
  $text = findcard($text);
  $text = findimage($text);
  return $text;
}

function findimage($tcode){
$st =strpos($tcode,"[image=");
if ($st === false)
{
return $tcode;
}

$texth = substr($tcode,0,$st);
$textf = substr($tcode,$st+18);
//$msg = substr($tcode,$st+10,$ed-$st-10);
$cid = substr($tcode,$st+7,10);
//$words = explode(' ',$msg);
//$msg = implode('+',$words);
$plc = mysql_fetch_array(mysql_query("SELECT imageurl FROM dcroxx_me_images WHERE code='".$cid."'"));
return "$texth<br/><img src=\"$plc[0]\" alt=\"*\"/><br/>$textf";
}
///////////////////////////////////////////Is site blocked

function isblocked($str,$sender){
if(ismod($sender)){return false;}
$str = str_replace(" ","",$str);
$str = strtolower($str);
$res = mysql_query("SELECT site FROM dcroxx_me_blockedsite");
while ($row = mysql_fetch_array($res)){
$sites[] = $row[0];
}
for($i=0;$i<count($sites);$i++){
$nosf = substr_count($str,$sites[$i]);
if($nosf>0){
return true;
}}
return false;
}

///////////////////////////////////////////Is pm starred

function isstarred($pmid)
{
  $strd = mysql_fetch_array(mysql_query("SELECT starred FROM dcroxx_me_private WHERE id='".$pmid."'"));
  if($strd[0]=="1")
  {
    return true;
  }else{
    return false;
  }
}
////////////////////////////////////////////IS LOGGED?

function islogged($sid)
{
  //delete old sessions first


  $deloldses = mysql_query("DELETE FROM dcroxx_me_ses WHERE expiretm<'".time()."'");
  //does sessions exist?
  $sesx = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_ses WHERE id='".$sid."'"));

  if($sesx[0]>0)
  {
    if(!isuser(getuid_sid($sid)))
{
  return false;
}
    //yip it's logged in
    //first extend its session expirement time
   // $xtm = ((time() + $timeadjust) + (60*getsxtm())) ;
	$xtm = time() + (1*24*60*60*getsxtm());
    $extxtm = mysql_query("UPDATE dcroxx_me_ses SET expiretm='".$xtm."' WHERE id='".$sid."'");
    return true;
  }else{
    //nope its session must be expired or something
    return false;
  }
}

////////////////////////Get user nick from session id

function getnick_sid($sid)
{
  $uid = mysql_fetch_array(mysql_query("SELECT uid FROM dcroxx_me_ses WHERE id='".$sid."'"));
  $uid = $uid[0];
  return getnick_uid($uid);
}

////////////////////////Get user id from session id

function getuid_sid($sid)
{
  $uid = mysql_fetch_array(mysql_query("SELECT uid FROM dcroxx_me_ses WHERE id='".$sid."'"));
  $uid = $uid[0];
  return $uid;
}
/////////////////////////////////////////getdrzava

function getdrzava($uid)
{
  $drzava = mysql_fetch_array(mysql_query("SELECT drzava FROM dcroxx_me_users WHERE id='".$uid."'"));
  return $drzava[0];
}

/////////////////////Get total number of pms

function getpmcount($uid,$view="all")
{
  if($view=="all"){
    $nopm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE touid='".$uid."'"));
    }else if($view =="snt")
    {
        $nopm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE byuid='".$uid."'"));
    }else if($view =="str")
    {
        $nopm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE touid='".$uid."' AND starred='1'"));
    }else if($view =="urd")
    {
        $nopm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE touid='".$uid."' AND unread='1'"));
    }
    return $nopm[0];
}

function deleteClub($clid)
{
    $fid = mysql_fetch_array(mysql_query("SELECT id FROM dcroxx_me_forums WHERE clubid='".$clid."'"));
    $fid = $fid[0];
    $topics = mysql_query("SELECT id FROM dcroxx_me_topics WHERE fid=".$fid."");
    while($topic = mysql_fetch_array($topics))
    {
      mysql_query("DELETE FROM dcroxx_me_posts WHERE tid='".$topic[0]."'");
    }
    mysql_query("DELETE FROM dcroxx_me_topics WHERE fid='".$fid."'");
    mysql_query("DELETE FROM dcroxx_me_forums WHERE id='".$fid."'");
    mysql_query("DELETE FROM dcroxx_me_rooms WHERE clubid='".$clid."'");
    mysql_query("DELETE FROM dcroxx_me_clubmembers WHERE clid='".$clid."'");
    mysql_query("DELETE FROM dcroxx_me_announcements WHERE clid='".$clid."'");
    mysql_query("DELETE FROM dcroxx_me_clubs WHERE id=".$clid."");
    return true;
}

function deleteMClubs($uid)
{
  $uclubs = mysql_query("SELECT id FROM dcroxx_me_clubs WHERE owner='".$uid."'");
  while($uclub=mysql_fetch_array($uclubs))
  {
    deleteClub($uclub[0]);
  }
}
function ip()
{
if($_SERVER["REMOTE_ADDR"]){$ip=$_SERVER["REMOTE_ADDR"];}
else{$ip=$_SERVER["HTTP_X_FORWARDED_FOR"];}
if(strpos($ip,",")){
$exp_ip=explode(",",$ip);
$ip=$exp_ip[0];
}
return $ip;
}

function ipinrange($ip, $range1, $range2)
{
$ip=ip2long($ip);
$range1=ip2long($range1);
$range2=ip2long($range2);
return (($ip >= $range1) && ($ip <= $range2));
}

/*function network($ip)
{
$result=mysql_query("SELECT * FROM network ORDER BY subone, subtwo");
while($ranges=mysql_fetch_array($result)){
if(ipinrange($ip, $ranges[1], $ranges[2])){
if(is_file("flags/".$ranges["flag"])){
$flag="<img src=\"flags/$ranges[5]\" alt=\"$ranges[5]\"/> ";
$flag2="<img src=\"flags/".$ranges["flag"]."\" alt=\"".$ranges["flag"]."\"/><br/>";
}
return $flag.$ranges["isp"]."<br/>Country:".$ranges["country"];
}
}
}*/
function network($ip)
{
$result=mysql_query("SELECT * FROM network ORDER BY subone, subtwo");
while($ranges=mysql_fetch_array($result)){
if(ipinrange($ip, $ranges[1], $ranges[2])){
if(is_file("flags/".$ranges["flag"])){
//$flag="<img src=\"../flags/$ranges[5]\" alt=\"$ranges[5]\"/> ";
$flag2="<img src=\"flags/".$ranges["flag"]."\" alt=\"".$ranges["flag"]."\"/><br/>";
}
return "IP Country: <b>".$ranges["country"]."</b><br/>";
}
}
}

function network_flag($ip)
{
$result=mysql_query("SELECT * FROM network ORDER BY subone, subtwo");
while($ranges=mysql_fetch_array($result)){
if(ipinrange($ip, $ranges[1], $ranges[2])){
if(is_file("flags/".$ranges["flag"])){
//$flag="<img src=\"../flags/$ranges[5]\" alt=\"$ranges[5]\"/> ";
$flag2="<img src=\"flags/".$ranges["flag"]."\" alt=\"".$ranges["flag"]."\"/><br/>";
}
return "Flag: ".$flag2;
}
}
}


function preexp($uid){
if(ispu($uid)){
	$vip = mysql_fetch_array(mysql_query("SELECT specialid, ptime FROM dcroxx_me_users WHERE id='".$uid."'"));
	$time = time();
	if($vip[1]<$time)
	{
		$res = mysql_query("UPDATE dcroxx_me_users SET specialid='0' WHERE id='".$uid."'");
		if($res)
		{
			$msg = "[b]NOTIFICATION:[/b][br/]Your premium user subscribtion has been expired! [br/][small][i]p.s: this is an automated pm[/i][/small]";
			$msg = mysql_escape_string($msg);
			autopm($msg, $uid);
		}
	}
	}
}
////////////////////// Function lotto subscriber
function islotto($uid){
$vip = mysql_fetch_array(mysql_query("SELECT lotto FROM dcroxx_me_users WHERE id='".$uid."'"));
if($vip[0]=='1'){
return true;
}
}
/////////lotto expire
function lottoexp($uid){
if(islotto($uid)){
	$vip = mysql_fetch_array(mysql_query("SELECT lotto, lottotime FROM dcroxx_me_users WHERE id='".$uid."'"));
	$time = time();
	if($vip[1]<$time)
	{
		$res = mysql_query("UPDATE dcroxx_me_users SET lotto='0' WHERE id='".$uid."'");
		if($res)
		{
			$msg = "[b]NOTIFICATION:[/b][br/]Your golden lotto subscribtion has been expired![br/][small][i]p.s: this is an automated pm[/i][/small]";
			$msg = mysql_escape_string($msg);
			autopm($msg, $uid);
		}
	}
	}
}

/*//////////////////////Function add user to online list :P
function addonline($uid,$place,$plclink)
{
  /////delete inactive users
  $tm = (time() + $timeadjust) ;
  $timeout = $tm - 420; //time out = 5 minutes
  $deloff = mysql_query("DELETE FROM dcroxx_me_online WHERE actvtime <'".$timeout."'");

  ///now try to add user to online list and add total time online


  $lastactive = mysql_fetch_array(mysql_query("SELECT lastact FROM dcroxx_me_users WHERE id='".$uid."'"));
  $tolsla = (time() + $timeadjust) - $lastactive[0];
  $totaltimeonline = mysql_fetch_array(mysql_query("SELECT tottimeonl FROM dcroxx_me_users WHERE id='".$uid."'"));
  $totaltimeonline = $totaltimeonline[0] + $tolsla;
  $res = mysql_query("UPDATE dcroxx_me_users SET tottimeonl='".$totaltimeonline."' WHERE id='".$uid."'");

   $ttime = (time() + $timeadjust);
  $res = mysql_query("UPDATE dcroxx_me_users SET lastact='".$ttime."' WHERE id='".$uid."'");
 $res = mysql_query("UPDATE dcroxx_me_users SET
lastact='".time()."' WHERE id='".$uid."'");
 $res = mysql_query("UPDATE dcroxx_me_users SET
lastseen='".$place."' WHERE id='".$uid."'");
 $res = mysql_query("UPDATE dcroxx_me_users SET
lastdet='".$plclink."' WHERE id='".$uid."'");

$res = mysql_query("INSERT INTO dcroxx_me_online SET userid='".$uid."', actvtime='".$ttime."', place='".$place."', placedet='".$plclink."'");
  if(!$res)
  {
    //most probably userid already in the online list
    //so just update the place and time
    $res = mysql_query("UPDATE dcroxx_me_online SET actvtime='".$ttime."', place='".$place."', placedet='".$plclink."' WHERE userid='".$uid."'");


  }
  $maxmem=mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE id='2'"));

            $result = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_online"));

          if($result[0]>=$maxmem[0])
          {
            $tnow = date("D d M Y - H:i", (time() + $timeadjust));
            mysql_query("UPDATE dcroxx_me_settings set name='".$tnow."', value='".$result[0]."' WHERE id='2'");
          }
          $maxtoday = mysql_fetch_array(mysql_query("SELECT ppl FROM dcroxx_me_mpot WHERE ddt='".date("d m y")."'"));
          if($maxtoday[0]==0||$maxtoday=="")
          {
            mysql_query("INSERT INTO dcroxx_me_mpot SET ddt='".date("d m y")."', ppl='1', dtm='".date("H:i:s")."'");
            $maxtoday[0]=1;
          }
          if($result[0]>=$maxtoday[0])
          {
            mysql_query("UPDATE dcroxx_me_mpot SET ppl='".$result[0]."', dtm='".date("H:i:s")."' WHERE ddt='".date("d m y")."'");
          }
}
     */
     /////////////////////Function add user to online list :P

function addonline($uid,$place,$plclink)
{

$brws = $_SERVER['HTTP_USER_AGENT'];
$ubr = addslashes(strip_tags($brws));
$brws2 = browser_agent($_SERVER['HTTP_USER_AGENT']);
$ubr2 = addslashes(strip_tags($brws2));
mysql_query("UPDATE dcroxx_me_users SET browserdet='".$ubr."', omphone='".$ubr2."' WHERE id='".$uid."'");

  $tm = time();
  $timeout = $tm - 300; //time out = 5 minutes
if (ismod(getuid_sid($sid))){
  $tm = time();
  $timeout = $tm - 300; //time out = 5 minutes
$deloff = mysql_query("DELETE FROM dcroxx_me_online WHERE actvtime <'".$timeout."'");
}else{
  $tm1 = time();
  $timeout1 = $tm1 - 3600; //time out = 60 minutes
$deloff = mysql_query("DELETE FROM dcroxx_me_online WHERE actvtime <'".$timeout1."'");
}

cleardata(); casinoone(); preexp($uid); lottoexp($uid);

  ///now try to add user to online list
 $lastactive2 = mysql_fetch_array(mysql_query("SELECT resetime FROM dcroxx_me_users WHERE id='".$uid."'"));
$tolsla2 = time() - $lastactive2[0];
$totaltimeonline2 = mysql_fetch_array(mysql_query("SELECT onlinetime FROM dcroxx_me_users WHERE id='".$uid."'"));
$totaltimeonline2 = $totaltimeonline2[0] + $tolsla2;
$onlinetime = mysql_fetch_array(mysql_query("SELECT onlinetime FROM dcroxx_me_users WHERE id='".$uid."'"));
$num = $onlinetime[0]/86400;
$hours = intval($num);
if(!onlinetime($uid))
    {
if($hours==5)
    {
$kano ="100";

$msg = "".getnick_uid(getuid_sid($sid))."Congratulation! You are lucky, because even if you did not reach 5 hours. You've got 100plusses n 100bp."."[br/][small]Note: This is an automated PM[/small]";
                        autopm($msg, $uid);

$res = mysql_query("UPDATE dcroxx_me_users SET plusses=plusses+'$kano' WHERE id='".$uid."'");
$res = mysql_query("UPDATE dcroxx_me_users SET onlinedone='1' WHERE id='".$uid."'");
$res = mysql_query("UPDATE dcroxx_me_users SET battlep=battlep+'$kano' WHERE id='".$uid."'");
}
}



$lttime = mysql_fetch_array(mysql_query("SELECT lastact, plustime FROM dcroxx_me_users WHERE id='".$uid."'")); 
$limit = time() - $lttime[0]; 
if($limit<180){
$newtime = $lttime[1] + $limit; 
if($newtime>1800){
    if(ispu($uid)){
        mysql_query("UPDATE dcroxx_me_users SET plustime='0', totaltime=totaltime+$limit, plusses=plusses+9, balance=balance+1.00 WHERE id='".$uid."'"); 
        $current = mysql_fetch_array(mysql_query("SELECT plusses, balance FROM dcroxx_me_users WHERE id='".$uid."'"));
	//$res = mysql_query("INSERT INTO ibwf_notifications SET text='Congratulations you have been awarded with 9 plusses for staying online for 30 minutes straight and you currently have ".$current[0]." plusses.', byuid='3', touid='".$uid."', unread='1', timesent='".time()."'");
        //$res = mysql_query("INSERT INTO dcroxx_me_private SET text='[b]NOTIFICATION[br/]:Plusses Booster:[/b][br/]You are have been Online for 30 minutes. You have recieved 15 Plusses [br/][br/][small][i]p.s: This is an automated PM[/i][/small]', byuid='3', touid='".$uid."', timesent='".time()."'"); 
$res = mysql_query("INSERT INTO dcroxx_me_events SET event='
Congratulations! [user=$uid][b]".getnick_uid($uid)."[/b][/user] have been awarded with 3 plusses for staying online for 
30 minutes straight and currently have ".$current[0]." plusses and ".$current[1]." Taka ', uid='".$uid."', time='".time()."'");  
		$note = "Congratulations! [user=$uid][b]".getnick_uid($uid)."[/b][/user] have been awarded with 9 plusses and 1.00 taka for staying online for 30 minutes straight and currently have ".$current[0]." plusses and ".$current[1]." taka.";
notify($note,$uid,$uid);
 }else{
        mysql_query("UPDATE dcroxx_me_users SET plustime='0', totaltime=totaltime+$limit, plusses=plusses+3, balance=balance+0.50 WHERE id='".$uid."'"); 
       $current = mysql_fetch_array(mysql_query("SELECT plusses, balance FROM dcroxx_me_users WHERE id='".$uid."'"));
/*$res = mysql_query("INSERT INTO ibwf_notifications SET text='
Congratulations you have been awarded with 3 plusses for staying online for 30 minutes straight and you currently have ".$current[0]." plusses.
', byuid='3', touid='".$uid."', unread='1', timesent='".time()."'");*/
       
$res = mysql_query("INSERT INTO dcroxx_me_events SET event='
Congratulations! [user=$uid][b]".getnick_uid($uid)."[/b][/user] have been awarded with 3 plusses for staying online for 
30 minutes straight and currently have ".$current[0]." plusses and ".$current[1]." Taka', uid='".$uid."', time='".time()."'");  

$note = "Congratulations! [user=$uid][b]".getnick_uid($uid)."[/b][/user] have been awarded with 3 plusses and 0.50 taka for staying online for 30 minutes straight and currently have ".$current[0]." plusses and ".$current[1]." taka ";
notify($note,$uid,$uid);	   
       // $res = mysql_query("INSERT INTO dcroxx_me_private SET text='[b]NOTIFICATION:[/b][br/]You are have been Online for 30 minutes. You have recieved 5 Plusses [br/][br/][small][i]p.s: This is an automated PM[/i][/small]', byuid='3', touid='".$uid."', timesent='".time()."'"); 
    }
}else{ 
mysql_query("UPDATE dcroxx_me_users SET  totaltime=totaltime+$limit, plustime='".$newtime."' WHERE id='".$uid."'"); 
} 
} 

///////// 25,50,75 Plusses for 50,75,100 Shouts
$shts = mysql_fetch_array(mysql_query("SELECT shouts, shouts_50, shouts_75, shouts_100 from dcroxx_me_users WHERE id='".$uid."'"));
if ($shts[1]>49){
$cow = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
$cow = $cow[0]+75;
mysql_query("UPDATE dcroxx_me_users SET plusses='".$cow."', shouts_50='0'  WHERE id='".$uid."'");
$note = "Congratulations! you have successfully reached 50 shouts and gain 75 plusses";
notify($note,$uid,$uid);	 
}else if ($shts[2]>74){
$cow = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
$cow = $cow[0]+25;
mysql_query("UPDATE dcroxx_me_users SET plusses='".$cow."', shouts_75='0'  WHERE id='".$uid."'");
$note = "Congratulations! you have successfully reached 75 shouts and gain 75+25=100 plusses";
notify($note,$uid,$uid);	 
}else if ($shts[3]>99){
$cow = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
$cow = $cow[0]+50;
mysql_query("UPDATE dcroxx_me_users SET plusses='".$cow."', shouts_100='0'  WHERE id='".$uid."'");
$note = "Congratulations! you have successfully reached 100 shouts and gain 75+25+50=150 plusses";
notify($note,$uid,$uid);	 
}

///////// 1 RP for 25 Chat Posts
$chatsrp = mysql_fetch_array(mysql_query("SELECT chmsgs, chmsgs2 from dcroxx_me_users WHERE id='".$uid."'"));
if ($chatsrp[1]>24){
$cowrp = mysql_fetch_array(mysql_query("SELECT rp FROM dcroxx_me_users WHERE id='".$uid."'"));
$cowrp2 = $cowrp[0]+1;
mysql_query("UPDATE dcroxx_me_users SET rp='".$cowrp2."', chmsgs2='0'  WHERE id='".$uid."'");
$note = "Congratulations! you have successfully reached 25 chat posts and gain [b]1 RP[/b]";
notify($note,$uid,$uid);	 
}else{}





$noi = mysql_fetch_array(mysql_query("SELECT count(*) FROM dcroxx_me_country WHERE country='".getisp2(getip())."'"));
        if($noi[0]==0){
            mysql_query("INSERT INTO dcroxx_me_country SET country='".getisp2(getip())."', lastupdate='".time()."'");
        }else{
            mysql_query("UPDATE dcroxx_me_country SET lastupdate='".time()."' WHERE country='".getisp2(getip())."'");
        }
		
 $ttime = time();
$res = mysql_query("UPDATE dcroxx_me_users SET resetime='".$ttime."' WHERE id='".$uid."'");
 $res = mysql_query("UPDATE dcroxx_me_users SET lastact='".time()."' WHERE id='".$uid."'");
  $res = mysql_query("INSERT INTO dcroxx_me_online SET userid='".$uid."', actvtime='".$tm."', place='".$place."', placedet='".$plclink."', country='".getisp2(getip())."'");
  if(!$res)
  {
    //most probably userid already in the online list
    //so just update the place and time
    $res = mysql_query("UPDATE dcroxx_me_online SET actvtime='".$tm."', place='".$place."', placedet='".$plclink."', country='".getisp2(getip())."' WHERE userid='".$uid."'");

mysql_query("UPDATE dcroxx_me_users SET lastact='".time()."' WHERE id='3'");
mysql_query("INSERT INTO dcroxx_me_online SET userid='3', place='".$place."', actvtime='".$tm."'");

  }
  $maxmem=mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE id='2'"));

            $result = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_online"));

          if($result[0]>=$maxmem[0])
          {
            $tnow = date("D d M Y - H:i");
            mysql_query("UPDATE dcroxx_me_settings set name='".$tnow."', value='".$result[0]."' WHERE id='2'");
          }
          $maxtoday = mysql_fetch_array(mysql_query("SELECT ppl FROM dcroxx_me_mpot WHERE ddt='".date("d m y")."'"));
          if($maxtoday[0]==0||$maxtoday=="")
          {
            mysql_query("INSERT INTO dcroxx_me_mpot SET ddt='".date("d m y")."', ppl='1', dtm='".date("H:i:s")."'");
            $maxtoday[0]=1;
          }
          if($result[0]>=$maxtoday[0])
          {
            mysql_query("UPDATE dcroxx_me_mpot SET ppl='".$result[0]."', dtm='".date("H:i:s")."' WHERE ddt='".date("d m y")."'");
          }
}

/////////////////////Get members online

function getnumonline()
{
    $nouo = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_online "));
    return $nouo[0];
}

//////////////////////////////////////is ignored

function isignored($tid, $uid){
$ign = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_ignore WHERE target='".$tid."' AND name='".$uid."'"));
if($ign[0]>0){
if(ismod($uid)){
return true;
}
return true;
}
return false;
}

///////////////////////////////////////////GET IP

//////////////////////////////////////////GET IP
function getip(){
if (isset($_SERVER)){
if(isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
if(strpos($ip,",")){
$exp_ip = explode(",",$ip);
$ip = $exp_ip[0];
}
}else if(isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
$ip = getenv('HTTP_CLIENT_IP');
}else{
$ip = getenv('REMOTE_ADDR');
}
}else{
if(getenv('HTTP_X_FORWARDED_FOR')){
$ip = getenv('HTTP_X_FORWARDED_FOR');
if(strpos($ip,",")){
$exp_ip=explode(",",$ip);
$ip = $exp_ip[0];
}
}else if(getenv('HTTP_CLIENT_IP')){
$ip = getenv('HTTP_CLIENT_IP');
}else {
$ip = getenv('REMOTE_ADDR');
}
}
return $ip; 
}
/*function getip(){
		$rem = @$_SERVER["REMOTE_ADDR"];
		$ff = @$_SERVER["HTTP_X_FORWARDED_FOR"];
		$ci = @$_SERVER["HTTP_CLIENT_IP"];
		if(preg_match('/^(?:192\.168|172\.16|10\.|127\.)/', $rem)){ 
			if($ff){ return $ff; }
			if($ci){ return $ci; }
			return $rem;
		} else {
			if($rem){ return $rem; }
			if($ff){ return $ff; }
			if($ci){ return $ci; }
			return $ip;
		}
	}*/
/*	function getip()
{
  $proxy_headers = array(
                          'CLIENT_IP', 
                          'FORWARDED', 
                          'FORWARDED_FOR', 
                          'FORWARDED_FOR_IP', 
                          'HTTP_CLIENT_IP', 
                          'HTTP_FORWARDED', 
                          'HTTP_FORWARDED_FOR', 
                          'HTTP_FORWARDED_FOR_IP', 
                          'HTTP_PC_REMOTE_ADDR', 
                          'HTTP_PROXY_CONNECTION',
                          'HTTP_VIA', 
                          'HTTP_X_FORWARDED', 
                          'HTTP_X_FORWARDED_FOR', 
                          'HTTP_X_FORWARDED_FOR_IP', 
                          'HTTP_X_IMFORWARDS', 
                          'HTTP_XROXY_CONNECTION', 
                          'VIA', 
                          'X_FORWARDED', 
                          'X_FORWARDED_FOR'
                         );
     $ip = false;
     if(!empty($_SERVER['HTTP_CLIENT_IP']))
     {
          $ip = $_SERVER['HTTP_CLIENT_IP'];
     }
     if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
     {
          $ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
          if($ip)
          {
               array_unshift($ips, $ip);
               $ip = false;
          }
          for($i = 0; $i < count($ips); $i++)
          {
               if(!preg_match("/^([1-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])(\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])){3}$/", $ips[$i], $proxy_header_temp))
               {
                    if(version_compare(phpversion(), "5.0.0", ">="))
                    {
                         if(ip2long($ips[$i]) != false)
                         {
                              $ip = $ips[$i];
                              break;
                         }
                    }
                    else
                    {
                         if(ip2long($ips[$i]) != - 1)
                         {
                              $ip = $ips[$i];
                              break;
                         }
                    }
               }
          }
     }
     return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
} */
//////////////////////GET USER NICK FROM USERID

function getfile($id)
{
  $unick = mysql_fetch_array(mysql_query("SELECT id FROM dcroxx_me_vault WHERE id='".$id."'"));
  return $unick[0];
}
//////////////////////////////////////////ignore result

function ignoreres($uid, $tid)
{
  //0 user can't ignore the target
  //1 yes can ignore
  //2 already ignored
  if($uid==$tid)
  {
    return 0;
  }
  if(ismod($tid))
  {
    //you cant ignore staff members
    return 0;
  }
  if(arebuds($tid, $uid))
  {
    //why the hell would anyone ignore his bud? o.O
    return 0;
  }
  if(isignored($tid, $uid))
  {
    return 2; // the target is already ignored by the user
  }
  return 1;
}

///////////////////////////////////////////Function getage

function getage($strdate)
{
    $dob = explode("-",$strdate);
    if(count($dob)!=3)
    {
      return 0;
    }
    $y = $dob[0];
    $m = $dob[1];
    $d = $dob[2];
    if(strlen($y)!=4)
    {
      return 0;
    }
    if(strlen($m)!=2)
    {
      return 0;
    }
    if(strlen($d)!=2)
    {
      return 0;
    }
  $y += 0;
  $m += 0;
  $d += 0;
  if($y==0) return 0;
  $rage = date("Y") - $y;
  if(date("m")<$m)
  {
    $rage-=1;

  }else{
    if((date("m")==$m)&&(date("d")<$d))
    {
      $rage-=1;
    }
  }
  return $rage;
}

/////////////////////////////////////////getavatar

function getavatar($uid)
{
  $av = mysql_fetch_array(mysql_query("SELECT avatar FROM dcroxx_me_users WHERE id='".$uid."'"));
  return $av[0];
}
/////////////////////////////////////////getmusic

function getmusic($uid)
{
  $music = mysql_fetch_array(mysql_query("SELECT music FROM dcroxx_me_users WHERE id='".$uid."'"));
  return $music[0];
}
/////////////////////////////////////////Can see details?

function cansee($uid, $tid)
{
  if($uid==$tid)
  {
    return true;
  }
  if(ismod($uid))
  {
    return true;
  }
  return false;
}

//////////////////////////gettimemsg
/*
function gettimemsg($sec)
{
  $ds = floor($sec/60/60/24);
  if($ds > 0)
  {
    return "$ds days";
  }
  $hs = floor($sec/60/60);
  if($hs > 0)
  {
    return "$hs hours";
  }
  $ms = floor($sec/60);
  if($ms > 0)
  {
    return "$ms minutes";
  }
  return "$sec Seconds";
}*/


function gettimemsg($sec)

{



$years=0;

$months=0;

$weeks=0;

$days=0;

$mins=0;

$hours=0;

if ($sec>59)

{

$secs=$sec%60;

$mins=$sec/60;

$mins=(integer)$mins;

}



if ($mins>59)

{

$hours=$mins/60;

$hours=(integer)$hours;

$mins=$mins%60;

}



if ($hours>23)

{

$days=$hours/24;

$days=(integer)$days;

$hours=$hours%24;

}



if ($days>6)

{

$weeks=$days/7;

$weeks=(integer)$weeks;

$days=$days%7;

}



if ($weeks>3)

{

$months=$weeks/4;

$months=(integer)$months;

$weeks=$weeks%4;

}



if ($months>11)

{

$years=$months/12;

$years=(integer)$years;

$months=$months%12;

}



if($years>0)

{

if($years==1){$yearmsg="year";}else{$yearmsg="years";}

if($months==1){$monthsmsg="month";}else{$monthsmsg="months";}

if($days==1){$daysmsg="day";}else{$daysmsg="days";}

if($hours==1){$hoursmsg="hour";}else{$hoursmsg="hours";}

if($mins==1){$minsmsg="minute";}else{$minsmsg="minutes";}

if($secs==1){$secsmsg="second";}else{$secsmsg="seconds";}



if($months!=0){$monthscheck="$months $monthsmsg ";}else{$monthscheck="";}

if(($days!=0)&&($months==0)){$dayscheck="$days $daysmsg ";}else{$dayscheck="";}

if(($hours!=0)&&($months==0)&&($days==0)){$hourscheck="$hours $hoursmsg ";}else{$hourscheck="";}

if(($mins!=0)&&($months==0)&&($days==0)&&($hours==0)){$minscheck="$mins $minsmsg ";}else{$minscheck="";}

if(($secs!=0)&&($months==0)&&($days==0)&&($hours==0)&&($mins==0)){$secscheck="$secs $secsmsg";}else{$secscheck="";}



return "$years $yearmsg $monthscheck$dayscheck$hourscheck$minscheck$secscheck";

}



if(($years<1)&&($months>0))

{

if($months==1){$monthsmsg="month";}else{$monthsmsg="months";}

if($days==1){$daysmsg="day";}else{$daysmsg="days";}

if($hours==1){$hoursmsg="hour";}else{$hoursmsg="hours";}

if($mins==1){$minsmsg="minute";}else{$minsmsg="minutes";}

if($secs==1){$secsmsg="second";}else{$secsmsg="seconds";}



if($days!=0){$dayscheck="$days $daysmsg ";}else{$dayscheck="";}

if(($hours!=0)&&($days==0)){$hourscheck="$hours $hoursmsg ";}else{$hourscheck="";}

if(($mins!=0)&&($days==0)&&($hours==0)){$minscheck="$mins $minsmsg ";}else{$minscheck="";}

if(($secs!=0)&&($days==0)&&($hours==0)&&($mins==0)){$secscheck="$secs $secsmsg";}else{$secscheck="";}



return "$months $monthsmsg $dayscheck$hourscheck$minscheck$secscheck";

}



if(($months<1)&&($weeks>0))

{

if($weeks==1){$weeksmsg="week";}else{$weeksmsg="weeks";}

if($days==1){$daysmsg="day";}else{$daysmsg="days";}

if($hours==1){$hoursmsg="hour";}else{$hoursmsg="hours";}

if($mins==1){$minsmsg="minute";}else{$minsmsg="minutes";}

if($secs==1){$secsmsg="second";}else{$secsmsg="seconds";}



if($days!=0){$dayscheck="$days $daysmsg ";}else{$dayscheck="";}

if(($hours!=0)&&($days==0)){$hourscheck="$hours $hoursmsg ";}else{$hourscheck="";}

if(($mins!=0)&&($days==0)&&($hours==0)){$minscheck="$mins $minsmsg ";}else{$minscheck="";}

if(($secs!=0)&&($days==0)&&($hours==0)&&($mins==0)){$secscheck="$secs $secsmsg";}else{$secscheck="";}



return "$weeks $weeksmsg $dayscheck$hourscheck$minscheck$secscheck";

}



if(($weeks<1)&&($days>0))

{

if($days==1){$daysmsg="day";}else{$daysmsg="days";}

if($hours==1){$hoursmsg="hour";}else{$hoursmsg="hours";}

if($mins==1){$minsmsg="minute";}else{$minsmsg="minutes";}

if($secs==1){$secsmsg="second";}else{$secsmsg="seconds";}



if($hours!=0){$hourscheck="$hours $hoursmsg ";}else{$hourscheck="";}

if(($mins!=0)&&($hours==0)){$minscheck="$mins $minsmsg ";}else{$minscheck="";}

if(($secs!=0)&&($hours==0)&&($mins==0)){$secscheck="$secs $secsmsg";}else{$secscheck="";}



return "$days $daysmsg $hourscheck$minscheck$secscheck";

}



if(($days<1)&&($hours>0))

{

if($hours==1){$hoursmsg="hour";}else{$hoursmsg="hours";}

if($mins==1){$minsmsg="minute";}else{$minsmsg="minutes";}

if($secs==1){$secsmsg="second";}else{$secsmsg="seconds";}



if($mins!=0){$minscheck="$mins $minsmsg ";}else{$minscheck="";}

if(($secs!=0)&&($mins==0)){$secscheck="$secs $secsmsg";}else{$secscheck="";}



return "$hours $hoursmsg $minscheck$secscheck";

}



if(($hours<1)&&($mins>0))

{

if($mins==1){$minsmsg="minute";}else{$minsmsg="minutes";}

if(($secs==1)&&($mins==0)){$secsmsg="second";}else{$secsmsg="seconds";}



if($secs!=0){$secscheck="$secs $secsmsg";}else{$secscheck="";}



return "$mins $minsmsg $secscheck";

}



if(($mins<1)&&($sec>0))

{

if($sec==1){$secsmsg="second";}else{$secsmsg="seconds";}



if($sec!=0){$secscheck="$sec $secsmsg";}else{$secscheck="";}



return "$secscheck";

}else{

return "Online!";

}

}
/////////////////////Get Page Jumber
function getjumper($action, $sid,$pgurl)
{
  $rets = "<form action=\"index.php\" method=\"get\">";
      $rets .= "Jump to page<input name=\"page\" format=\"*N\" size=\"3\"/>";
        $rets .= "<input type=\"submit\" value=\"GO\"/>";
        $rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
        $rets .= "<input type=\"hidden\" name=\"sid\" value=\"$sid\"/>";
        $rets .= "</form>";

        echo $rets;
}
/////////////////////Get unread number of pms

function getunreadpm($uid)
{
    $nopm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE touid='".$uid."' AND unread='1'"));
    return $nopm[0];
}

//////////////////////GET USER NICK FROM USERID

function getnick_uid($uid)
{
  $unick = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$uid."'"));
return "$unick[0]";
}



///////////////////////////////////////////////Get the smilies

function getsmilies($text)
{
  $sql = "SELECT * FROM dcroxx_me_smilies";
  $smilies = mysql_query($sql);
  while($smilie=mysql_fetch_array($smilies))
  {
    $scode = $smilie[1];
    $spath = $smilie[2];
    $text = str_replace($scode,"<img src=\"$spath\" alt=\"$scode\"/>",$text);
  }
  return $text;
}

////////////////////////////////////////////check nicks

function checknick($aim)
{
  $chk =0;
$aim = strtolower($aim);
  $nicks = mysql_query("SELECT id, name, nicklvl FROM dcroxx_me_nicks");

while($nick=mysql_fetch_array($nicks))
{
    if($aim==$nick[1])
    {
      $chk = $nick[2];
    }else if(substr($aim,0,strlen($nick[1]))==$nick[1])
    {
      $chk = $nick[2];
    }else{
    $found = strpos($aim, $nick[1]);
    if($found!=0)
    {
        $chk = $nick[2];
    }
    }
}
return $chk;
}

function emailexist($email){
$checkmail = mysql_fetch_array(mysql_query("SELECT COUNT(*) from dcroxx_me_users where email='".$email."'"));
if($checkmail[0]>0){
return true;
}else{
return false;
}}
function phoneexist($email){
$checknumber = mysql_fetch_array(mysql_query("SELECT COUNT(*) from dcroxx_me_users where phone='".$email."'"));
if($checknumber[0]>0){
return true;
}else{
return false;
}}


function autopm($msg, $who)
{
    $ttime = time();
    mysql_query("INSERT INTO dcroxx_me_private SET text='".$msg."', byuid='3', touid='".$who."', unread='1', timesent='".$ttime."'");

}

function autogbsign($msg, $who){
    $ttime = time();
    mysql_query("INSERT INTO dcroxx_me_gbook SET gbowner='".$who."', gbsigner='2', dtime='".time()."', gbmsg='".$msg."'");
}
   //////////////////////////////////////////////////////////
function candelmd($uid,$bid)
  {
    $minfo = mysql_fetch_array(mysql_query("SELECT bowner FROM lirmeditatii WHERE id='".$bid."'"));
    if(ismod($uid))
    {
      return true;
    }
    if($minfo[0]==$uid)
    {
      return true;
    }
    return false;
  }
////////////////////////////////////////////////////Register

function register($name,$pass,$usex,$bday,$uloc,$lang,$email,$ubr,$reffer)
{
  $execms = mysql_query("SELECT * FROM dcroxx_me_users WHERE name='".$name."';");

  if (mysql_num_rows($execms)>0){
    return 1;
  }else{
    $pass = md5($pass);
	$validation = mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE name='vldtn'"));
if($validation[0]==1)
{
$validated=0;
}else{
$validated=1;
}
    $reg = mysql_query("INSERT INTO dcroxx_me_users SET name='".$name."', pass='".$pass."', birthday='".$bday."', sex='".$usex."', location='".$uloc."', regdate='".time()."',validated='".$validated."', lang='".$lang."', email='".$email."', ipadd='".getip()."', browserm='".$ubr."'");

    if ($reg)
    {
	    $uid = getuid_nick($name);
	 if($reffer=="")
      {
      }else{
      	mysql_query("INSERT INTO dcroxx_me_invite SET invite='".$uid."', invitedby='".$reffer."', regdate='".time()."'");
        $msg = "You reffered the user [b][user=$uid]$name"."[/user][/b]. The Admin will review it soon and give your bonus ASAP. Thank you.[br/][small][i]p.s: this is an automated pm[/i][/small]";
        autopm($msg, $reffer);
      }
	
      $uid = mysql_fetch_array(mysql_query("SELECT id FROM dcroxx_me_users WHERE name='".$name."'"));
    /*  $msg = "Hello /reader =). Greetings from all $sitename[0] staff, we are happy to have you here, welcome to our big happy family!, 
	  If You Have any questions or comments about the site feel free to message me or any of the other staff members online or call +8801822751576.
	   ENJOY! (excited)[br/][small][i]p.s: this is an automated pm[/i][/small]";*/
$msg = "Hello /reader,[br/][br/]-wc- [red]to our small happy family![/red][br/][br/][teal]If you have any questions or comments about the site feel free 
to message any of the staff member from the online list.[/teal][center][topic=1][b][blue]-next- Please check out the instructions for any kind of help 
specially written for New Guest.[/blue][/b][/topic][/center][br/]You can gain points by posting in forums,literatures,blogs,polls,contests which will 
unlock other parts of this great site!-flower-[br/][small][i]p.s: this is an automated sign from SocialBD![/i][/small]";

      $msg = mysql_escape_string($msg);
      autopm($msg, $uid[0]);
	  $msg1 = "[img=image.gif/1-072.jpg][br/]Welcome to our small community. Hope you will enjoy with us all time.[br/]
	  [small][i]p.s: this is an automated sign from [b]SocialBD Team[/b]![/i][/small]";

	  $msg1 = mysql_escape_string($msg1);
	  autogbsign($msg1, $uid[0]);
      return 0;
    }else{
      return 2;

    }
  }

}

function validation()
{
$getval = mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE name='vldtn'"));
if($getval[0]=='1')
{
return true;
}else
{
return false;
}
}



function casino(){
date_default_timezone_set('UTC');
$gerNew_Time = time() + (6 * 60 * 60);
$gertime=date("l",$gerNew_Time);
	$epp = mysql_fetch_array(mysql_query("SELECT id, oprtr, time FROM dcroxx_me_casinodb WHERE status='1' ORDER BY time DESC LIMIT 0,1"));
if($gertime==Friday){
		$epp = mysql_fetch_array(mysql_query("SELECT id, oprtr, time FROM dcroxx_me_casinodb WHERE status='1' ORDER BY time DESC LIMIT 0,1"));
$lpt = mysql_fetch_array(mysql_query("SELECT id, uid, oprtr, time, bet FROM dcroxx_me_casinotkn WHERE oprtr='".$epp[0]."' ORDER BY RAND() LIMIT 1"));
$cdno = mysql_fetch_array(mysql_query("SELECT id, oprtr, no FROM dcroxx_me_cardno WHERE oprtr='gp' ORDER BY RAND() LIMIT 1"));

  $magicbox = rand(1, 3);
    if ($magicbox=="1"){
    	$opl = mysql_fetch_array(mysql_query("SELECT plusses FROM dcroxx_me_users WHERE id='".$lpt[1]."'"));
    	$pval = $lpt[4]*2;
    	$npl = $opl[0] + $pval;
    	mysql_query("UPDATE dcroxx_me_users SET plusses='".$npl."' WHERE id='".$uid."'");
mysql_query("INSERT INTO dcroxx_me_private SET text='Congratulation[br/]You have win Casino Royal and [b]".$pval."[/b] Plusses has been added to your account[br/][small]p.s: that is an automated pm[/small]', byuid='3', touid='".$lpt[1]."', timesent='".time()."'");
    	$nam = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$lpt[1]."'"));
    	mysql_query("INSERT INTO dcroxx_me_shouts SET shout='".$nam[0]." has got [b]".$pval."[/b] Plusses as a winner of [b]Casino Royale - $epp[1][/b]', shouter='3', shtime='".time()."'");
           mysql_query("UPDATE dcroxx_me_casinodb SET status='0' WHERE id='".$epp[1]."'");
           mysql_query("UPDATE dcroxx_me_casino SET status='0', uid='".$lpt[1]."', gtime='".time()."' WHERE id='".$epp[1]."'");
    }else if($magicbox=="2"){
    	$opl = mysql_fetch_array(mysql_query("SELECT rp FROM dcroxx_me_users WHERE id='".$lpt[1]."'"));
    	$pval = $lpt[4]*2;
    	$npl = $opl[0] + $pval;
    	mysql_query("UPDATE dcroxx_me_users SET rp='".$npl."' WHERE id='".$uid."'");
mysql_query("INSERT INTO dcroxx_me_private SET text='Congratulation[br/]You have win Casino Royal and [b]".$pval."[/b] Reputation Points has been added to your account[br/][small]p.s: that is an automated pm[/small]', byuid='3', touid='".$lpt[1]."', timesent='".time()."'");
    	$nam = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$lpt[1]."'"));
    	mysql_query("INSERT INTO dcroxx_me_shouts SET shout='".$nam[0]." has got [b]".$pval."[/b] RP as a winner of [b]Casino Royale - $epp[1][/b]', shouter='3', shtime='".time()."'");
           mysql_query("UPDATE dcroxx_me_casinodb SET status='0' WHERE id='".$epp[1]."'");
		              mysql_query("UPDATE dcroxx_me_casino SET status='0', uid='".$lpt[1]."', gtime='".time()."' WHERE id='".$epp[1]."'");
    }else if($magicbox=="3"){
    	
  $opl = mysql_fetch_array(mysql_query("SELECT golden_coin FROM dcroxx_me_users WHERE id='".$lpt[1]."'"));
    	$pval = $lpt[4]*2;
    	$npl = $opl[0] + $pval;
    	mysql_query("UPDATE dcroxx_me_users SET golden_coin='".$npl."' WHERE id='".$uid."'");
mysql_query("INSERT INTO dcroxx_me_private SET text='Congratulation[br/]You have win Casino Royal and [b]".$pval."[/b] Golden Coin has been added to your account[br/][small]p.s: that is an automated pm[/small]', byuid='3', touid='".$lpt[1]."', timesent='".time()."'");
    	$nam = mysql_fetch_array(mysql_query("SELECT name FROM dcroxx_me_users WHERE id='".$lpt[1]."'"));
    	mysql_query("INSERT INTO dcroxx_me_shouts SET shout='".$nam[0]." has got [b]".$pval."[/b] GC as a winner of [b]Casino Royale - $epp[1][/b]', shouter='3', shtime='".time()."'");
     mysql_query("UPDATE dcroxx_me_casinodb SET status='0' WHERE id='".$epp[1]."'");
	            mysql_query("UPDATE dcroxx_me_casino SET status='0', uid='".$lpt[1]."', gtime='".time()."' WHERE id='".$epp[1]."'");
   }

        mysql_query("DELETE FROM dcroxx_me_casinodb WHERE status='0'");
$nm = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_casino WHERE ORDER BY time DESC LIMIT 0,1"));
  mysql_query("INSERT INTO dcroxx_me_casino SET oprtr='$nm[0]', time='".time()."', status='1'");
  mysql_query("INSERT INTO dcroxx_me_casinodb SET oprtr='', time='".time()."', status='1'");
      $nam = getnick_uid($lpt[1]);
      $num = substr($cdno[2],0,4);

}

}
function casinoone(){
	$epp = mysql_fetch_array(mysql_query("SELECT id, oprtr, time FROM dcroxx_me_casinodb WHERE status='1' ORDER BY time DESC LIMIT 0,1"));
	$tokens = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_casinotkn WHERE oprtr='".$epp[0]."'"));
	if($tokens[0]>"1"){
		casino();
	}else{
		date_default_timezone_set('UTC');
		$gerNew_Time = time() + (6 * 60 * 60);
		$gertime=date("l",$gerNew_Time);
			$epp = mysql_fetch_array(mysql_query("SELECT id, oprtr, time FROM dcroxx_me_casinodb WHERE status='1' ORDER BY time DESC LIMIT 0,1"));
if($gertime==Friday){
	$ess = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_casinodb WHERE status='0'"));
	if($ess[0]==0){	
	}else{
	$epp = mysql_fetch_array(mysql_query("SELECT id, oprtr, time FROM dcroxx_me_casinodb WHERE status='0' ORDER BY time DESC LIMIT 0,1"));
	mysql_query("INSERT INTO dcroxx_me_shouts SET shout='[b]Casino Royale - $epp[1][/b] is deleted for insufficient bets', shouter='3', shtime='".time()."'");
	mysql_query("DELETE FROM dcroxx_me_casinodb WHERE status='0'");
	}
	}}}

   /////////////////blocat la trivia
function isoprit($str,$sender)
{
  $str = str_replace(" ","",$str);
  $str = strtolower($str);
    $res = mysql_query("SELECT browser FROM dcroxx_me_pc");
while ($row = mysql_fetch_array($res))
{
   $sites[] = $row[0];
}
  for($i=0;$i<count($sites);$i++)
  {
        $nosf = substr_count($str,$sites[$i]);
    if($nosf>0)
    {
      return false;
    }
  }
  return true;
}
/////////////////////// GET dcroxx_me_users user id from nickname

function getuid_nick($nick)
{
  $uid = mysql_fetch_array(mysql_query("SELECT id FROM dcroxx_me_users WHERE name='".$nick."'"));
  return $uid[0];
}
function isheadadmin($uid)
{
  $admn = mysql_fetch_array(mysql_query("SELECT perm FROM dcroxx_me_users WHERE id='".$uid."'"));
  if($admn[0]>=3)
  {
    return true;
  }else{
    return false;
  }
}

function isheadadmin2($uid)
{
  $admn = mysql_fetch_array(mysql_query("SELECT perm FROM dcroxx_me_users WHERE id='".$uid."'"));
  if($admn[0]==3)
  {
    return true;
  }else{
    return false;
  }
}
/////////////////////////////////////////Is owner?

function isowner($uid)
{
  $own = mysql_fetch_array(mysql_query("SELECT perm FROM dcroxx_me_users WHERE id='".$uid."'"));
  if($own[0]>=4)
  {
    return true;
  }else{
    return false;
  }
}
/////////////////////////////////////////Is admin?

function isadmin($uid)
{
  $admn = mysql_fetch_array(mysql_query("SELECT perm FROM dcroxx_me_users WHERE id='".$uid."'"));
  if($admn[0]>=2)
  {
    return true;
  }else{
    return false;
  }
}

function isadmin2($uid)
{
  $admn = mysql_fetch_array(mysql_query("SELECT perm FROM dcroxx_me_users WHERE id='".$uid."'"));
  if($admn[0]==2)
  {
    return true;
  }else{
    return false;
  }
}

///////////////////////////////////parse bbcode

function getbbcode($text, $sid="", $filtered)
{
$bro=("$REMOTE_ADDR");
    $usr = explode("/",$_SERVER['HTTP_USER_AGENT']);
    $phone = ("$usr[0]");
$text = str_replace("[phone]","$phone",$text);
        $unreadinbox=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE unread='1' AND touid='".$uid."'"));
        $pmtotl=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_private WHERE touid='".$uid."'"));
        $unrd="[".$unreadinbox[0]."l".$pmtotl[0]."]";
        $text = preg_replace("/\[inbox]/is","<a href=\"inbox.php?action=main\">Inbox $unrd</a>",$text);
  $text = preg_replace("/\[updatepro]/is","<a href=\"index.php?action=uset\">Update Profie</a>",$text);
$text = preg_replace("/\[images\=((.*?)(.php|php4|php5|xhtml|html))\]/i","Im trying To Hack", $text);
$text = str_replace("[nick]","".getnick_uid(getuid_sid($sid))."",$text); 
  $text = preg_replace("/\[b\](.*?)\[\/b\]/i","<b>\\1</b>", $text);
  
//$text = preg_replace(array('/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))/', '/(^|[^a-z0-9_])@([a-z0-9_]+)/i', '/(^|[^a-z0-9_])#([a-z0-9_]+)/i'), array('<a href="$1">$1</a>', '$1<a href="/$2">$2</a>', '$1<a href="/$2">#$2</a>'), $text);
//$text = preg_replace(array('/(^|[^a-z0-9_])@([a-z0-9_]+)/i', '/(^|[^a-z0-9_])#([a-z0-9_]+)/i'), array('$1<a href="/$2">$2</a>', '$1<a href="/$2">#$2</a>'), $text);
$text = preg_replace(array('/(^|[^a-z0-9_])@([a-z0-9_]+)@/i', '/(^|[^a-z0-9_])#([a-z0-9_]+)/i'), array('$1<a href="/$2">$2</a>', '$1<a href="/$2">#$2</a>'), $text);

/*
if(substr($value, 0, 20) == "https://youtube.com/" || substr($value, 0, 24) == "https://www.youtube.com/" || substr($value, 0, 16) == "www.youtube.com/" || substr($value, 0, 12) == "youtube.com/" || substr($value, 0, 19) == "http://youtube.com/" || substr($value, 0, 23) == "http://www.youtube.com/" || substr($value, 0, 16) == "http://youtu.be/") {

} elseif(substr($value, 0, 17) == "http://vimeo.com/" || substr($value, 0, 21) == "http://www.vimeo.com/" || substr($value, 0, 18) == "https://vimeo.com/" || substr($value, 0, 22) == "https://www.vimeo.com/" || substr($value, 0, 14) == "www.vimeo.com/" || substr($value, 0, 10) == "vimeo.com/") {
$value = 'vm:'.(int)substr(parse_url($value, PHP_URL_PATH), 1);
}
<iframe width='490' height='340' src='http://www.youtube.com/embed/$ytcode' frameboder='0' allowfullscreen></iframe>
<iframe width="100%" height="315" src="http://player.vimeo.com/video/'.str_replace('vm:', '', $value).'" frameborder="0" allowfullscreen></iframe>
<img src="https://maps.googleapis.com/maps/api/staticmap?center='.$value.'&zoom=13&size=700x150&maptype=roadmap&markers=color:red%7C'.$value.'&sensor=false&scale=2&visual_refresh=true" />
				<div class="message-divider"></div>';*/
				
$text = preg_replace("/\[youtube\=(.*?)\](.*?)\[\/youtube\]/is","<br/>$2<br/>
	<iframe width=\"400\" height=\"300\" src=\"https://www.youtube.com/embed/$1\" frameboder=\"0\" allowfullscreen></iframe>", $text);
	
$text = preg_replace("/\[vimeo\=(.*?)\](.*?)\[\/vimeo\]/is","<br/>$2<br/>
	<iframe width=\"400\" height=\"300\" src=\"https://player.vimeo.com/video/$1\" frameborder=\"0\" allowfullscreen></iframe>", $text);
	
$text = preg_replace("/\[map\=(.*?)\](.*?)\[\/map\]/is","<br/>$2<br/>
   <img src=\"https://maps.googleapis.com/maps/api/staticmap?center=$1&zoom=9&size=320x150&maptype=roadmap&markers=color:green%7C$1&sensor=false&scale=1&visual_refresh=true\" />", $text);
	



	
$text = preg_replace("/\[mp3\=(.*?)\](.*?)\[\/mp3\]/is","<br/>$2<br/>
	<object type=\"application/x-shockwave-flash\" data=\"music/player.swf\" id=\"audioplayer1\" height=\"20\" width=\"250\">
	<param name=\"movie\" value=\"music/player.swf\">
	<param name=\"FlashVars\" value=\"playerID=1&amp;autostart=no&amp;soundFile=$1\">
	<param name=\"quality\" value=\"high\">
	<param name=\"menu\" value=\"false\">
	<param name=\"wmode\" value=\"transparent\">
	</object>", $text);
$text = preg_replace("/\\n/", "<br />", $text);
$text = str_replace("\\r\\n","<br/>",$text);
//$text = preg_replace("/\\r\\n/", "<br />", $text);
  $text = preg_replace("/\[i\](.*?)\[\/i\]/i","<i>\\1</i>", $text);
  $text = preg_replace("/\[u\](.*?)\[\/u\]/i","<u>\\1</u>", $text);
  $text = preg_replace("/\[big\](.*?)\[\/big\]/i","<big>\\1</big>", $text);
  $text = preg_replace("/\[small\](.*?)\[\/small\]/i","<small>\\1</small>", $text);
  //$text = preg_replace("/\[img\=(.*?)\]/is","<img src=\"$1\">",$text);
  
$text = preg_replace("/\[post\=(.*?)\](.*?)\[\/post\]/is","<a class=\"plain\" href=\"archive.php?action=viewarcpost&amp;postid=$1\">$2</a>",$text);
$text = preg_replace("/\[ticket\=(.*?)\](.*?)\[\/ticket\]/is","<a class=\"plain\" href=\"helpdesk.php?action=viewmyticket&amp;tid=$1\">$2</a>",$text);
$text = preg_replace("/\[user\=(.*?)\](.*?)\[\/user\]/is","<a class=\"plain\" href=\"index.php?action=viewuser&amp;who=$1\">$2</a>",$text);
$text = preg_replace("/\[archive\=(.*?)\](.*?)\[\/archive\]/is","<a class=\"plain\" href=\"archive.php?action=viewarcpost&amp;postid=$1\">$2</a>",$text);
$text = preg_replace("/\[archivestaff\=(.*?)\](.*?)\[\/archivestaff\]/is","<a class=\"plain\" href=\"archive.php?action=viewarcpost&amp;postid=$1\">$2</a>",$text);
 $text = preg_replace("/\[image_preview\=((.*?)(.jpg|jpeg|png|gif|bmp))\]/i","<img src=\"\\1\" alt=\"Loading...\"/>", $text);
  
$text=preg_replace("/\[blink\](.*?)\[\/blink\]/i","<blink>\\1</blink>", $text);
  $text=preg_replace("/\[run\](.*?)\[\/run\]/i","<marquee direction=\"left\">\\1</marquee>", $text);
$text=preg_replace("/\[run2\](.*?)\[\/run2\]/i","<marquee direction=\"right\">\\1</marquee>", $text);
$text = preg_replace("/\[img\=(.*?)\]/is","<img src=\"phpthumb.php?image=$1\">",$text);
$text=preg_replace("/\[midi\=(.*?)\]/i","<bgsound src=\"\\1\"/>", $text);
  $text = preg_replace("/\[url\=(.*?)\](.*?)\[\/url\]/is","<a href=\"$1\">$2</a>",$text);
$text=preg_replace("/\[quote\](.*?)\[\/quote\]/i","<div class=\"quote\">\\1</div>", $text);
  $text = preg_replace("/\[clr\=(.*?)\](.*?)\[\/clr\]/is","<font color=\"$1\">$2</font>",$text);
  $text = preg_replace("/\[rep]/is","<a href=\"repicons.php?sid=$sid\">Reputation Icons</a>",$text);
$text = preg_replace("/\[music]/is","<a href=\"lists.php?action=music\">Profile Music</a>",$text);
$text = preg_replace("/\[pmoods]/is","<a href=\"lists.php?action=pmoods\">Profile Moods</a>",$text);
$text = preg_replace("/\[avatar]/is","<a href=\"lists.php?action=upavat\">Upload Avatar</a>",$text);
$text = preg_replace("/\[addtheme]/is","<a href=\"index.php?action=sitethms\">Profile Theme</a>",$text);
$text = preg_replace("/\[user\=(.*?)\](.*?)\[\/user\]/is","<a href=\"index.php?action=viewuser&amp;who=$1\">$2</a>",$text);
$text = preg_replace("/\[marquee\](.*?)\[\/marquee\]/i","<marquee>\\1</marquee>", $text);
$text = preg_replace("/\[marqueer\](.*?)\[\/marqueer\]/i","<marquee direction=\"right\">\\1</marquee>", $text);
$text = preg_replace("/\[blink\](.*?)\[\/blink\]/i","<blink>\\1</blink>", $text);
$text = preg_replace("/\[strike\](.*?)\[\/strike\]/i","<strike>\\1</strike>", $text);
$text=preg_replace("/\[blink\](.*?)\[\/blink\]/i","<blink>\\1</blink>", $text);
$text=preg_replace("/\[del\](.*?)\[\/del\]/i","<del>\\1</del>", $text);
$text=preg_replace("/\[center\](.*?)\[\/center\]/i","<p align=\"center\">\\1</p>", $text);
$text=preg_replace("/\[left\](.*?)\[\/left\]/i","<p align=\"left\">\\1</p>", $text);
$text=preg_replace("/\[right\](.*?)\[\/right\]/i","<p align=\"right\">\\1</p>", $text);
$text = preg_replace("/\[number_format\=(.*?)\](.*?)\[\/number_format\]/is","<a href=\"wtai://wp/mc;$1\">$2</a>",$text);
  $text = preg_replace("/\[topic\=(.*?)\](.*?)\[\/topic\]/is","<a href=\"index.php?action=viewtpc&amp;tid=$1\">$2</a>",$text);
  $text = preg_replace("/\[forum\=(.*?)\](.*?)\[\/forum\]/is","<a href=\"index.php?action=viewfrm&amp;tid=$1\">$2</a>",$text);
  $text = preg_replace("/\[club\=(.*?)\](.*?)\[\/club\]/is","<a href=\"index.php?action=gocl&amp;clid=$1\">$2</a>",$text);
  $text = preg_replace("/\[blog\=(.*?)\](.*?)\[\/blog\]/is","<a href=\"index.php?action=viewblog&amp;bid=$1\">$2</a>",$text);
  $text = preg_replace("/\[aFardin\=(.*?)\](.*?)\[\/aFardin\]/is","<a href=\"$1\">$2</a>",$text);
  //$text = ereg_replace("http://[A-Za-z0-9./=?-_]+","<a href=\"\\0\">\\0</a>", $text);
 $text = preg_replace( "#\(scr:red\)(.+?)\(/scr\)#is", "<marquee loop=\"800\" bgcolor=\"#FF0000\" direction=\"right\">\\1</marquee>", $text );
 
 $text=preg_replace("/\[red\](.*?)\[\/red\]/i","<font color=\"red\">\\1</font>", $text);
$text=preg_replace("/\[lime\](.*?)\[\/lime\]/i","<font color=\"lime\">\\1</font>", $text);
$text=preg_replace("/\[green\](.*?)\[\/green\]/i","<font color=\"green\">\\1</font>", $text);
$text=preg_replace("/\[yellow\](.*?)\[\/yellow\]/i","<font color=\"yellow\">\\1</font>", $text);
$text=preg_replace("/\[white\](.*?)\[\/white\]/i","<font color=\"white\">\\1</font>", $text);
$text=preg_replace("/\[blue\](.*?)\[\/blue\]/i","<font color=\"blue\">\\1</font>", $text);
$text=preg_replace("/\[grey\](.*?)\[\/grey\]/i","<font color=\"grey\">\\1</font>", $text);
$text=preg_replace("/\[silver\](.*?)\[\/silver\]/i","<font color=\"silver\">\\1</font>", $text);
$text=preg_replace("/\[navy\](.*?)\[\/navy\]/i","<font color=\"navy\">\\1</font>", $text);
$text=preg_replace("/\[darkgreen\](.*?)\[\/darkgreen\]/i","<font color=\"darkgreen\">\\1</font>", $text);
$text=preg_replace("/\[aqua\](.*?)\[\/aqua\]/i","<font color=\"aqua\">\\1</font>", $text);
$text=preg_replace("/\[aquamarine\](.*?)\[\/aquamarine\]/i","<font color=\"aquamarine\">\\1</font>", $text);
$text=preg_replace("/\[maroon\](.*?)\[\/maroon\]/i","<font color=\"maroon\">\\1</font>", $text);
$text=preg_replace("/\[purple\](.*?)\[\/purple\]/i","<font color=\"purple\">\\1</font>", $text);
$text=preg_replace("/\[skyblue\](.*?)\[\/skyblue\]/i","<font color=\"skyblue\">\\1</font>", $text);
$text=preg_replace("/\[darkseagreen\](.*?)\[\/darkseagreen\]/i","<font color=\"darkseagreen\">\\1</font>", $text);
$text=preg_replace("/\[yellowgreen\](.*?)\[\/yellowgreen\]/i","<font color=\"yellowgreen\">\\1</font>", $text);
$text=preg_replace("/\[sienna\](.*?)\[\/sienna\]/i","<font color=\"sienna\">\\1</font>", $text);
$text=preg_replace("/\[greenyellow\](.*?)\[\/greenyellow\]/i","<font color=\"greenyellow\">\\1</font>", $text);
$text=preg_replace("/\[powderblue\](.*?)\[\/powderblue\]/i","<font color=\"powderblue\">\\1</font>", $text);
$text=preg_replace("/\[tan\](.*?)\[\/tan\]/i","<font color=\"tan\">\\1</font>", $text);
$text=preg_replace("/\[thistle\](.*?)\[\/thistle\]/i","<font color=\"thistle\">\\1</font>", $text);
$text=preg_replace("/\[orchid\](.*?)\[\/orchid\]/i","<font color=\"orchid\">\\1</font>", $text);
$text=preg_replace("/\[goldenrod\](.*?)\[\/goldenrod\]/i","<font color=\"goldenrod\">\\1</font>", $text);
$text=preg_replace("/\[crimson\](.*?)\[\/crimson\]/i","<font color=\"crimson\">\\1</font>", $text);
$text=preg_replace("/\[plum\](.*?)\[\/plum\]/i","<font color=\"plum\">\\1</font>", $text);
$text=preg_replace("/\[lightcyan\](.*?)\[\/lightcyan\]/i","<font color=\"lightcyan\">\\1</font>", $text);
$text=preg_replace("/\[violet\](.*?)\[\/violet\]/i","<font color=\"violet\">\\1</font>", $text);
$text=preg_replace("/\[khaki\](.*?)\[\/khaki\]/i","<font color=\"khaki\">\\1</font>", $text);
$text=preg_replace("/\[magenta\](.*?)\[\/magenta\]/i","<font color=\"magenta\">\\1</font>", $text);
$text=preg_replace("/\[hotpink\](.*?)\[\/hotpink\]/i","<font color=\"hotpink\">\\1</font>", $text);
$text=preg_replace("/\[orange\](.*?)\[\/orange\]/i","<font color=\"orange\">\\1</font>", $text);

  if(substr_count($text,"[br/]")<=1000){
    $text = str_replace("[br/]","<br/>",$text);

  }

//$text = preg_replace("/\\n/", "<br />", $text);
		// Define smiles
		$smiles = array(
			':)'	=> '1 (10).png',
			':D'	=> '1 (2).png',
			':('	=> '1 (9).png',
			':P'	=> '1 (11).png',
			':O)'	=> '1.png',
			':3)'	=> '1 (5).png',
			'o.O'	=> '1 (3).png',
			';)'	=> '1 (27).png',
			':O'	=> '1 (24).png',
			'-_-'	=> '1 (22).png',
			':-O'	=> '1 (1).png',
			':*'	=> '1 (16).png',
			':_:'	=> '1 (15).png',
			'8-)'	=> '1 (12).png',
			'8|'	=> '1 (23).png',
			'(^^^)'	=> '1 (21).png',
			':_('	=> '1 (13).png',
			':v'	=> '1 (17).png',
			'/:'	=> '1 (26).png',
			':3'	=> '1 (4).png',
			':poop:'	=> '1 (18).png',
			':smoke:'	=> 'cigarette.png',
			':ring:'	=> 'ring.png',
			':-('	=> '1 (8).png',
		);
		
		if($smiles) {
			foreach($smiles as $smile => $img) {
				$text = str_replace($smile, '<img src="emoticons/'.$img.'"/>', $text);
			}
		} 
  
  
  
  
  return $text;
}

function ispu($uid){
$vip = mysql_fetch_array(mysql_query("SELECT specialid FROM dcroxx_me_users WHERE id='".$uid."'"));
if($vip[0]>0){
return true;
}}
//////////////////////////////////////////////////MISC FUNCTIONS
function spacesin($word)
{
  $pos = strpos($word," ");
  if($pos === false)
  {
    return false;
  }else
  {
    return true;
  }
}

/////////////////////////////////Number of registered members
function regmemcount()
{
  $rmc = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users"));
  return $rmc[0];
}
///////
/////// Invited member count
function invitedmemcount()

{

  $rmc = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_invite"));

  return $rmc[0];

}

function isloggedtools($uid){
//delete old sessions first
$deloldses = mysql_query("DELETE FROM dcroxx_me_toolses WHERE expiretm<'".time()."'");
//does sessions exist?
  $pass0 = mysql_fetch_array(mysql_query("SELECT tools_pass FROM dcroxx_me_users WHERE id='".$uid."'"));
$sesx = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_toolses WHERE uid='".$uid."' AND pass='".$pass0[0]."'"));
if($sesx[0]>0){
//yip it's logged in
//first extend its session expirement time
/*  $pass0 = mysql_fetch_array(mysql_query("SELECT tools_pass FROM dcroxx_me_users WHERE id='".$uid."'"));
$xtm = time() + (60*getsxtm());
$extxtm = mysql_query("UPDATE dcroxx_me_toolses SET expiretm='".$xtm."' WHERE uid='".$uid."' AND pass='".$pass0[0]."'");*/
return true;
}else{
//nope its session must be expired or something
return false;
}
}



///////////////////////////function counter

function addvisitor()
{
  $cc = mysql_fetch_array(mysql_query("SELECT value FROM dcroxx_me_settings WHERE name='Counter'"));
  $cc = $cc[0]+1;
  $res = mysql_query("UPDATE dcroxx_me_settings SET value='".$cc."' WHERE name='Counter'");
}

function scharin($word)
{
  $chars = "abcdefghijklmnopqrstuvwxyz0123456789-_";
  for($i=0;$i<strlen($word);$i++)
  {
    $ch = substr($word,$i,1);
  $nol = substr_count($chars,$ch);
  if($nol==0)
  {
    return true;
  }
  }
  return false;
}

function isdigitf($word)
{
  $chars = "abcdefghijklmnopqrstuvwxyz";
    $ch = substr($word,0,1);
  $sres = ereg("[0-9]",$ch);

    $ch = substr($word,0,1);
  $nol = substr_count($chars,$ch);
  if($nol==0)
  {
    return true;
  }


  return false;

}
function boxstart($title){

	echo "

	<div class=\"boxed\">

      <div class=\"boxedTitle\">

        <h1 align=\"center\" class=\"boxedTitleText c1\"><strong>$title</strong>

	</h1>

      </div>

      <div class=\"boxedContent c1\">";

}

function boxend(){

	echo "</div></div>";

	}
function getpmood($uid)
{
  $pmood = mysql_fetch_array(mysql_query("SELECT pmood FROM dcroxx_me_users WHERE id='".$uid."'"));
  return $pmood[0];
}
/////////////////////////////////////////////Get Mood
function getsetmood($uid)
{
   $getdata = mysql_fetch_array(mysql_query("SELECT setmood FROM dcroxx_me_users WHERE id='".$uid."'"));
   return $getdata[0];
   $text = getsmilies($text);
}
function ischecker($uid)
{
  $admn = mysql_fetch_array(mysql_query("SELECT perm FROM dcroxx_me_users WHERE id='".$uid."'"));
  if($admn[0]=='2')
  {
    return true;
  }else{
    return false;
  }
}
////////////////////////////get number of topic pages

function getnumpages2($artid)
{
  $nops = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_artpost WHERE artid='".$artid."'"));
  $nops = $nops[0]+1; //where did the 1 come from? the topic text, duh!
  $nopg = ceil($nops/5); //5 is the posts to show in each page
  return $nopg;
}
///////////////////////////////////get page from go

function getpage_go2($go,$artid)
{
  if(trim($go)=="")return 1;
  if($go=="last")return getnumpages2($artid);
  $counter=1;

  $posts = mysql_query("SELECT id FROM dcroxx_me_artpost WHERE artid='".$artid."'");
  while($post=mysql_fetch_array($posts))
  {
    $counter++;
    $postid = $post[0];
    if($postid==$go)
    {
        $tore = ceil($counter/5);
        return $tore;
    }
  }
  return 1;
}
function canaddart($uid,$id)
{
  $minfo = mysql_fetch_array(mysql_query("SELECT authorid FROM dcroxx_me_readart WHERE id='".$id."'"));
  if($minfo[0]==$uid||ismod($uid))
  {
    return true;
  }
  if($minfo[1]==$uid||ismod($uid))
  {
    return true;
  }
  return false;
}

function chall($byuid, $touid)
{
    $res = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_jnp WHERE ((byuid='".$byuid."' AND touid='".$touid."') OR (byuid='".$touid."' AND touid='".$byuid."'))"));
    if($res[0]>0)
    {
      return true;
    }
    return false;
}
////////////////////////////////////////////function pop up msg

function popup($sid)

{

 $uid = getuid_sid($sid);

          $unreadpopup=mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_popups WHERE unread='1' AND touid='".$uid."'"));





        if ($unreadpopup[0]>0)

        {



          $pminfo = mysql_fetch_array(mysql_query("SELECT id, text, byuid, timesent, touid, reported FROM dcroxx_me_popups WHERE unread='1' AND touid='".$uid."'"));

          $pmfrm = getnick_uid($pminfo[2]);

          $ncl = mysql_query("UPDATE dcroxx_me_popups SET unread='0' WHERE id='".$pminfo[0]."'");

          $popmsgbox .= "<center><strong>POP-UP Message From $pmfrm</strong>";

          $popmsgbox .= "<br/>";

          $tmstamp = $pminfo[3];

         $tmdt = date("d m Y - H:i:s", $tmstamp);

          $popmsgbox .= "Sent At: $tmdt<br/>";

          $pmtext = parsepm($pminfo[1], $sid);

          $pmtext = str_replace("/llfaqs","<a href=\"lists.php?action=faqs\">$sitename F.A.Qs</a>", $pmtext);

          $pmtext = str_replace("/reader",getnick_uid($pminfo[4]), $pmtext);

          $pmid=$pminfo[0];

          $popmsgbox .= "Message: $pmtext";

          $popmsgbox .= "<br/>Send Reply to $pmfrm<br/></center>";

         $popmsgbox .= "<form action=\"inbxproc.php?action=sendpopup&amp;who=$pminfo[2]&amp;pmid=$pminfo[0]\" method=\"post\">";

         $popmsgbox .= "<center><input name=\"pmtext\" maxlength=\"500\"/><br/>";

         $popmsgbox .= "<input type=\"Submit\" name=\"submit\" Value=\"Send\"></center></form>";

          // $res = mysql_query("INSERT INTO dcroxx_me_online SET userid='".$uid."', actvtime='".$tm."', place='".$place."', placedet='".$plclink."'");

           $location = mysql_fetch_array(mysql_query("SELECT placedet FROM dcroxx_me_online WHERE userid='".$uid."'"));

           $popmsgbox .= "<center><a href=\"$location[0]\">Skip Msg</a><br/>";

           $popmsgbox .= "<a href=\"inbxproc.php?action=rptpop&amp;pmid=$pminfo[0]\">Report</a></center>";


               }

           return $popmsgbox;

}
/////////////////////////mms hours
function addhours(){

        return 15*60*60;

 }
///////////////////////////////////////////is shielded?

function spinned($uid)
{
  $not = mysql_fetch_array(mysql_query("SELECT spinned FROM dcroxx_me_users WHERE id='".$uid."'"));
  if($not[0]=='1')
  { return true;
  }else{
    return false;
  }
}
function pending($uid)
{
    $res = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_rpgame WHERE uid='".$uid."'"));
    if($res[0]>0)
    {
      return true;
    }
    return false;
}
/////////////////////Get pops

function isrpg($uid)
{
    $nopop = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_rpg WHERE touid='".$uid."' AND accept='1'"));
   return $nopop[0];
}
//////////////////////GET USER NICK FROM USERID

function ingame($uid)
{
  $unick = mysql_fetch_array(mysql_query("SELECT uid FROM dcroxx_me_rpgame WHERE uid='".$uid."'"));
  return $unick[0];
}

/////////////////////Get pops

function ishit($uid)
{
    $nopop = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE id='".$uid."' AND hit='0'"));
   return $nopop[0];
}
/////////////////////Get pops

function isrpg2($uid)
{
    $nopop = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_rpg WHERE byuid='".$uid."' AND accept='2'"));
   return $nopop[0];
}
/////////////////////Get pops

function notactive($uid)
{
    $nopop = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_users WHERE id='".$uid."' AND activate='1'"));
   return $nopop[0];
}
/////////////////////////Get user plusses

function health($uid)
{
    $plus = mysql_fetch_array(mysql_query("SELECT health FROM dcroxx_me_users WHERE id='".$uid."'"));
    return $plus[0];
}
///////////////////////////////////////////is shielded?

function turn($uid)
{
  $not = mysql_fetch_array(mysql_query("SELECT hit FROM dcroxx_me_users WHERE id='".$uid."'"));
  if($not[0]=='1')
  { return true;
  }else{
    return false;
  }
}
///////////////////////////////////////////is shielded?

function noact($uid)
{
  $not = mysql_fetch_array(mysql_query("SELECT hit FROM dcroxx_me_users WHERE id='".$uid."'"));
  if($not[0]=='3')
  { return true;
  }else{
    return false;
  }
}
function have()
{
    $nopop = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM dcroxx_me_quiz"));
   return $nopop[0];
}
function correct($answer,$id)
{
  $uid = mysql_fetch_array(mysql_query("SELECT id FROM dcroxx_me_quizrooms WHERE answer='".$answer."' AND id='".$id."'"));
  return $uid[0];
}
/////////////////////// GET dcroxx_me_users user id from nickname

function getuid_hint($secure)
{
  $uid = mysql_fetch_array(mysql_query("SELECT uid FROM dcroxx_me_bank WHERE hint='".$secure."'"));
  return $uid[0];
}
     ///////////////////////////////////////////is shielded?

function onlinetime($uid)
{
  $not = mysql_fetch_array(mysql_query("SELECT onlinedone FROM dcroxx_me_users WHERE id='".$uid."'"));
  if($not[0]=='1')
  { return true;
  }else{
    return false;
  }
}
///////////////////////////////////////////is shielded?

function bank($uid)
{
  $not = mysql_fetch_array(mysql_query("SELECT done FROM dcroxx_me_bank WHERE uid='".$uid."'"));
  if($not[0]=='1')
  {
    return true;
  }else{
    return false;
  }
}
function getbrip($sid){

$uid=getuid_sid($sid);

$HTTP_USER_AGENT = getenv("HTTP_USER_AGENT");

$REMOTE_ADDR = $_SERVER["REMOTE_ADDR"];

if($REMOTE_ADDR == "207.210.86.252"){

$REMOTE_ADDR = getenv("HTTP_X_FORWARDED_FOR");

}

mysql_query("UPDATE dcroxx_me_users SET ua='".$HTTP_USER_AGENT."', ip='".$REMOTE_ADDR."' WHERE id='$uid'");

}
function isdigitf3($word)
{
  $chars = "1234567890";
    $ch = substr($word,0,1);
  $sres = ereg("[0-9]",$ch);

    $ch = substr($word,0,1);
  $nol = substr_count($chars,$ch);
  if($nol==0)
  {
    return true;
  }


  return false;

}
function shad0w($uid, $who)
{

$pm = mysql_fetch_array(mysql_query("SELECT viewpro FROM dcroxx_me_users WHERE id='".$who."'"));
if($pm[0]=='2')
{
if (ismod($uid))
{
return true;
}else{

return false;
}
return false;
}else if($pm[0]=='1')
{
if($uid==$who||arebuds($uid,$who)||ismod($uid))
{
return true;
}else{
return false;
}
}else if($pm[0]=='0')
{
return true;
}
}
function shad0w2($uid, $who)
{

$pm = mysql_fetch_array(mysql_query("SELECT viewinbox FROM dcroxx_me_users WHERE id='".$who."'"));
if($pm[0]=='2')
{
if (ismod($uid))
{
return true;
}else{

return false;
}
return false;
}else if($pm[0]=='1')
{
if($uid==$who||arebuds($uid,$who)||ismod($uid))
{
return true;
}else{
return false;
}
}else if($pm[0]=='0')
{
return true;
}
}
function shad0w3($uid, $who)
{

$pm = mysql_fetch_array(mysql_query("SELECT viewgallery FROM dcroxx_me_users WHERE id='".$who."'"));
if($pm[0]=='2')
{
if (ismod($uid))
{
return true;
}else{

return false;
}
return false;
}else if($pm[0]=='1')
{
if($uid==$who||arebuds($uid,$who)||ismod($uid))
{
return true;
}else{
return false;
}
}else if($pm[0]=='0')
{
return true;
}
}

function strClean($text){
$tex = strip_tags($text);
$tex = stripslashes(stripslashes($tex));
return $tex;

}
/////////////////////////////////////////get status

function getratestatus($uid)
{
$rate=mysql_fetch_array(mysql_query("SELECT rate FROM dcroxx_me_users WHERE id='".$uid."'"));
if($rate[0]<0){$rstatus="Rate Me";}
else if($rate[0]<25){$status="Rate Me";}
else if($rate[0]<50){$status="Rate Me";}
else if($rate[0]<75){$status="Rate Me";}
else if($rate[0]<250){$status="Someone Likes Me";}
else if($rate[0]<500){$status="Yeah Am Liked";}
else if($rate[0]<750){$status="Looking Good";}
else if($rate[0]<1000){$status="Looking Good";}
else if($rate[0]<1500){$status="Cutie";}
else if($rate[0]<4000){$status="lovely";}
else if($rate[0]<5000){$status="Fab ";}
else if($rate[0]<7000){$status="Hot";}
else if($rate[0]<8000){$status="WOW";}
else if($rate[0]<9000){$status="Perfection ";}
else if($rate[0]<15000){$status="Flawless";}
else if($rate[0]<1000000){$status="One In A Million";}
return $status;
}
function addtotrivia($uid)
{
  $timeto = 150;
  $timenw = time();
  $timeout = $timenw - $timeto;
  $exec = mysql_query("DELETE FROM dcroxx_me_onlinetrivia WHERE lton<'".$timeout."'");
  $res = mysql_query("INSERT INTO dcroxx_me_onlinetrivia SET lton='".time()."', uid='".$uid."'");
  if(!$res)
  {
    mysql_query("UPDATE dcroxx_me_onlinetrivia SET lton='".time()."' WHERE uid='".$uid."'");
  }
}
/////////////////////////////////////////get status

function getstatus2($uid)
{
  $info = mysql_fetch_array(mysql_query("SELECT perm, plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
  $shopssid = mysql_fetch_array(mysql_query("SELECT shopssid FROM dcroxx_me_users WHERE id='".$uid."'"));
  if(isbanned($uid))
  {
         return "<img src=\"staff/banned.gif\" alt=\"image\"/>";
		        break;
  }

  if($shopssid[0]=='7')
  {
    return "Ferrari Enzo!";
  }else
  if($shopssid[0]=='8')
  {
    return "Porsche Carrera!";
  }else
  if($shopssid[0]=='9')
  {
    return "Bugatti!";
  }else
  if($shopssid[0]=='10')
  {
    return "McLaren F1!";
  }else
  if($shopssid[0]=='11')
  {
    return "Jaguar XJ220!";
  }else
  if($shopssid[0]=='12')
  {
    return "Lamborghini Murcielago!";
  }else
  if($shopssid[0]=='13')
  {
    return "McLaren Mercedes SLR!";
  }else

 if($info[0]=='4')
  {
        return "<img src=\"images/owner.gif\" alt=\"image\"/>";
        break;
  }else
   if($info[0]=='3')
  {
        return "<img src=\"images/hadmin.gif\" alt=\"image\"/>";
        break;
  }else
  if($info[0]=='2')
  {
        return "<img src=\"images/admin.gif\" alt=\"image\"/>";
        break;
  }else if($info[0]=='1')
  {
        return "<img src=\"images/mod.gif\" alt=\"image\"/>";
        break;
  }else if($info[0]=='5')
  {
        return "<img src=\"images/owner.gif\" alt=\"image\"/>";
        break;
  }else{
    if($info[1]<10)
    {
        return "<img src=\"images/newbie.gif\" alt=\"image\"/>";
        break;
    }else if($info[1]<25)
    {
        return "<img src=\"images/member.gif\" alt=\"image\"/>";
        break;
    }else if($info[1]<50)
    {
        return "<img src=\"images/sparkle.gif\" alt=\"image\"/>";
        break;
    }else if($info[1]<75)
    {
        return "<img src=\"images/sparkle.gif\" alt=\"image\"/>";
        break;
    }else if($info[1]<250)
    {
        return "<img src=\"images/sparkle.gif\" alt=\"image\"/>";
        break;
    }else if($info[1]<500)
    {
        return "<img src=\"images/sparkle.gif\" alt=\"image\"/>";
        break;
    }else if($info[1]<750)
    {
        return "<img src=\"images/icon.gif\" alt=\"image\"/>";
        break;
    }else if($info[1]<1000)
    {
        return "<img src=\"images/icon.gif\" alt=\"image\"/>";
		       break;
    }else if($info[1]<1500)
    {
        return "<img src=\"images/icon.gif\" alt=\"image\"/>";
		       break;
    }else if($info[1]<2000)
    {
        return "<img src=\"images/icon.gif\" alt=\"image\"/>";
		       break;
    }else if($info[1]<2500)
    {
         return "<img src=\"images/explosion.gif\" alt=\"image\"/>";
		        break;
    }else if($info[1]<3000)
    {
         return "<img src=\"images/explosion.gif\" alt=\"image\"/>";
		        break;
    }else if($info[1]<4000)
    {
         return "<img src=\"images/explosion.gif\" alt=\"image\"/>";
		        break;
    }else if($info[1]<5000)
    {
         return "<img src=\"images/explosion.gif\" alt=\"image\"/>";
		        break;
    }else if($info[1]<10000)
    {
         return "<img src=\"images/rock.gif\" alt=\"image\"/>";
		        break;
    }else
    {
         return "<img src=\"images/rock.gif\" alt=\"image\"/>";
		        break;
    }
  }
}
/////////////////////////////////////////get status

function getstatus($uid)
{
  $info = mysql_fetch_array(mysql_query("SELECT perm, plusses FROM dcroxx_me_users WHERE id='".$uid."'"));
  $shopssid = mysql_fetch_array(mysql_query("SELECT shopssid FROM dcroxx_me_users WHERE id='".$uid."'"));
  if(isbanned($uid))
  {
    return "Banned!";
  }

  if($shopssid[0]=='4')
  {
    return "Ferrari Enzo!";
  }else
  if($shopssid[0]=='5')
  {
    return "Porsche Carrera!";
  }else
  if($shopssid[0]=='6')
  {
    return "Bugatti!";
  }else
  if($shopssid[0]=='7')
  {
    return "McLaren F1!";
  }else
  if($shopssid[0]=='8')
  {
    return "Jaguar XJ220!";
  }else
  if($shopssid[0]=='9')
  {
    return "Lamborghini Murcielago!";
  }else
  if($shopssid[0]=='10')
  {
    return "McLaren Mercedes SLR!";
  }else


if($info[0]=='6')
  {
    return "Staff Controller!!!";
	}else if($info[0]=='5')
  {
    return "Programmer n Security Chief!!!";
	}else if($info[0]=='4')
  {
    return "Administrator!!!";
	}else if($info[0]=='3')
  {
    return "Head Administrator!!";

  }else if($info[0]=='2')
  {
    return "Senior Moderator!";
  }else if($info[0]=='1')
  {
    return "Moderator!";
  }else{
   
if($info[1]<10)

{

return "Newbie";

}else if($info[1]<15)

{

return "Member";

}else if($info[1]<50)

{

return "Advanced Member";

}else if($info[1]<75)

{

return "Super Member";

}else if($info[1]<250)

{

return "Valued Member";

}else if($info[1]<500)

{

return "FinixBD VIP";

}else if($info[1]<750)

{

return "Extreme Member";

}else if($info[1]<1000)

{

return "Forum Guru";

}else if($info[1]<1500)

{

return "Hardcore Porter";

}else if($info[1]<2000)

{

return "Forum Master";

}else if($info[1]<2500)

{

return "The Demon Poster";

}else if($info[1]<3000)

{

return "Forum Freak";

}else if($info[1]<4000)
{
	return "I Post Too Much lol";
}else if($info[1]<5000)
{
	return "24/7 Porter";
}else if($info[1]<10000)
{
	return "Geek";
}else if($info[1]>10000)
{
	return "Ultimate Member!!";
}else

{

return "New Member";

}
  }
}
//////////////////////////////////////////////////////////////////////////////////// user rating
function getrating($uid)
{
$info=mysql_fetch_array(mysql_query("SELECT * FROM dcroxx_me_users WHERE id='".$uid."'"));
$posts = $info["posts"];
$plusses = $info["plusses"];
$gplus = $gplus["gplus"];
 $shouts = $shouts["shouts"];
$tot = $posts+$plusses+$gplus+$shouts;
if($tot<50){return "<img src=\"../images/half-star.gif\" width=105 height=15 alt=\"\"/>";}
if($tot<100){return "<img src=\"../images/1-star.gif\" width=105 height=15 alt=\"\"/>";}
if($tot<500){return "<img src=\"../images/1half-star.gif\" width=105 height=15 alt=\"\"/>";}
if($tot<1000){return "<img src=\"../images/2-star.gif\" width=105 height=15 alt=\"\"/>";}
if($tot<5000){return "<img src=\"../images/2-star.gif\" width=105 height=15 alt=\"\"/>";}
if($tot<10000){return "<img src=\"../images/2half-star.gif\" width=105 height=15 alt=\"\"/>";}
if($tot<50000){return "<img src=\"../images/2half-star.gif\" width=105 height=15 alt=\"\"/>";}
if($tot<100000){return "<img src=\"../images/3-star.gif\" width=105 height=15 alt=\"\"/>";}
if($tot<500000){return "<img src=\"../images/3half-star.gif\" width=105 height=15 alt=\"\"/>";}
if($tot<800000){return "<img src=\"../images/4-star.gif\" width=105 height=15 alt=\"\"/>";}
if($tot<1000000){return "<img src=\"../images/4half-star.gif\" width=105 height=15 alt=\"\"/>";}
if($tot>=1500000){return "<img src=\"../images/5-star.gif\" width=105 height=15 alt=\"\"/>";}
}
////// RATING ///////
function rating($uid)
{
$info = mysql_fetch_array(mysql_query("SELECT plusses, gplus, shouts, chmsgs FROM dcroxx_me_users WHERE id='".$uid."'"));
$pl = $info[0];
$gp = $info[1];
$sh = $info[2];
$ch = $info[3];
$infototal = ($pl + $gp + $sh + $ch);
if($infototal<10)
{
return "<img src=\"images/empty.gif\" alt=\"\"/>";
}
else if($infototal<350)
{
return "<img src=\"images/half.gif\" alt=\"\"/>";
}
else if($infototal<1000)
{
return "<img src=\"images/one.gif\" alt=\"\"/>";
}
else if($infototal<2500)
{
return "<img src=\"images/onehalf.gif\" alt=\"\"/>";
}
else if($infototal<6500)
{
return "<img src=\"images/two.gif\" alt=\"\"/>";
}
else if($infototal<15000)
{
return "<img src=\"images/twohalf.gif\" alt=\"\"/>";
}
else if($infototal<37000)
{
return "<img src=\"images/three.gif\" alt=\"\"/>";
}
else if($infototal<85000)
{
return "<img src=\"images/threehalf.gif\" alt=\"\"/>";
}
else if($infototal<190000)
{
return "<img src=\"images/four.gif\" alt=\"\"/>";
}
else if($infototal<420000)
{
return "<img src=\"images/fourhalf.gif\" alt=\"\"/>";
}
else if($infototal<900000)
{
return "<img src=\"images/five.gif\" alt=\"\"/>";
}
else if($infototal<1700000)
{
return "<img src=\"images/fivehalf.gif\" alt=\"\"/>";
}
else if($infototal<3300000)
{
return "<img src=\"images/six.gif\" alt=\"\"/>";
}
else if($infototal<7000000)
{
return "<img src=\"images/sixhalf.gif\" alt=\"\"/>";
}
else
{
return "<img src=\"images/seven.gif\" alt=\"\"/>";
}
}
/*function getstarsign($strdate){

$dob = explode("-",$strdate);

if(count($dob)!=3){

return "Unavailable";

}

$m = $dob[1];

$d = $dob[2];

if(($m==3)&&($d>20)){

   // return "<img src=\"images/aries.gif\" alt=\"\"/>Aries - the Ram";
    return "Aries - the Ram";

}

else

if(($m==4)&&($d<21)){

   // return "<img src=\"images/aries.gif\" alt=\"\"/>Aries - the Ram";
    return "Aries - the Ram";

}

else

if(($m==4)&&($d>20)){

    //return "<img src=\"images/taurus.gif\" alt=\"\"/>Taurus - the Bull";
    return "Taurus - the Bull";

}

else

if(($m==5)&&($d<22)){

    //return "<img src=\"images/taurus.gif\" alt=\"\"/>Taurus - the Bull";
    return "Taurus - the Bull";

}

else

if(($m==5)&&($d>21)){

   // return "<img src=\"images/gemini.gif\" alt=\"\"/>Gemini - the Twins";
    return "Gemini - The Twins";

}

else

if(($m==6)&&($d<22)){

    //return "<img src=\"images/gemini.gif\" alt=\"\"/>Gemini - the Twins";
    return "Gemini - The Twins";

}

else

if(($m==6)&&($d>21)){

   // return "<img src=\"images/cancer.gif\" alt=\"\"/>Cancer - the Crab";
    return "Cancer - The Crab";

}

else

if(($m==7)&&($d<23)){

   // return "<img src=\"images/cancer.gif\" alt=\"\"/>Cancer - the Crab";
    return "Cancer - The Crab";

}

else

if(($m==7)&&($d>22)){

    //return "<img src=\"images/leo.gif\" alt=\"\"/>Leo - the Lion";
    return "Leo - The Lion";

}

else

if(($m==8)&&($d<24)){

    //return "<img src=\"images/leo.gif\" alt=\"\"/>Leo - the Lion";
    return "Leo - The Lion";

}

else

if(($m==8)&&($d>23)){

    //return "<img src=\"images/virgo.gif\" alt=\"\"/>Virgo - the Virgin";
    return "Virgo - The Virgin";

}

else

if(($m==9)&&($d<23)){

    //return "<img src=\"images/virgo.gif\" alt=\"\"/>Virgo - the Virgin";
    return "Virgo - The Virgin";

}

else

if(($m==9)&&($d>22)){

    //return "<img src=\"images/libra.gif\" alt=\"\"/>Libra - the Scales";
    return "Libra - The Scales";

}

else

if(($m==10)&&($d<24)){

   // return "<img src=\"images/libra.gif\" alt=\"\"/>Libra - the Scales";
    return "Libra - The Scales";

}

else

if(($m==10)&&($d>23)){

   // return "<img src=\"images/scorpio.gif\" alt=\"\"/>Scorpio - the Scorpion";
    return "Scorpio - The Scorpion";

}

else

if(($m==11)&&($d<23)){

   // return "<img src=\"images/scorpio.gif\" alt=\"\"/>Scorpio - the Scorpion";
    return "Scorpio - The Scorpion";

}

else

if(($m==11)&&($d>22)){

    //return "<img src=\"images/sagittarius.gif\" alt=\"\"/>Sagittarius - the Archer";
    return "Sagittarius - The Archer";

}

else

if(($m==12)&&($d<24)){

    //return "<img src=\"images/sagittarius.gif\" alt=\"\"/>Sagittarius - the Archer";
    return "Sagittarius - The Archer";

}

else

if(($m==12)&&($d>23)){

    //return "<img src=\"images/capricorn.gif\" alt=\"\"/>Capricorn - the Goat";
    return "Capricorn - The Goat";

}

else

if(($m==1)&&($d<21)){

  //  return "<img src=\"images/capricorn.gif\" alt=\"\"/>Capricorn - the Goat";
    return "Capricorn - The Goat";

}

else

if(($m==1)&&($d>20)){

    //return "<img src=\"images/aquarius.gif\" alt=\"\"/>Aquarius - the Waterman";
    return "Aquarius - The Waterman";

}

else

if(($m==2)&&($d<19)){

    //return "<img src=\"images/aquarius.gif\" alt=\"\"/>Aquarius - the Waterman";
    return "Aquarius - The Waterman";

}

else

if(($m==2)&&($d>18)){

  //  return "<img src=\"images/pisces.gif\" alt=\"\"/>Pisces - the Fishes";
    return "Pisces - The Fishes";

}

else

if(($m==3)&&($d<21)){

    //return "<img src=\"images/pisces.gif\" alt=\"\"/>Pisces - the Fishes";
    return "Pisces - The Fishes";

}

}*/


function getstarsign($strdate){
$dob = explode("-",$strdate);
if(count($dob)!=3){
return "Unavailable";
}
$m = $dob[1];
$d = $dob[2];

//list($year,$month,$day)=explode("-",$date);
if(($m=="01" && $d>20)||($m=="02" && $d<19)){
return "<a href=\"aquarius.php?action=main\">Aquarius</a>";
}else if(($m=="02" && $d>18)||($m=="03" && $d<21)){
return "<a href=\"pisces.php?action=main\">Pisces</a>";
}else if(($m=="03" && $d>20)||($m=="04" && $d<20)){
return "<a href=\"aries.php?action=main\">Aries</a>";
}else if(($m=="04" && $d>19)||($m=="05" && $d<21)){
return "<a href=\"taurus.php?action=main\">Taurus</a>";
}else if(($m=="05" && $d>20)||($m=="06" && $d<22)){
return "<a href=\"gemini.php?action=main\">Gemini</a>";
}else if(($m=="06" && $d>21)||($m=="07" && $d<23)){
return "<a href=\"cancer.php?action=main\">Cancer</a>";
}else if(($m=="07" && $d>22)||($m=="08" && $d<23)){
return "<a href=\"leo.php?action=main\">Leo</a>";
}else if(($m=="08" && $d>22)||($m=="09" && $d<23)){
return "<a href=\"virgo.php?action=main\">Virgo</a>";
}else if(($m=="09" && $d>22)||($m=="10" && $d<24)){
return "<a href=\"libra.php?action=main\">Libra</a>";
}else if(($m=="10" && $d>23)||($m=="11" && $d<23)){
return "<a href=\"scorpio.php?action=main\">Scorpio</a>";
}else if(($m=="11" && $d>22)||($m=="12" && $d<22)){
return "<a href=\"sagittarius.php?action=main\">Sagittarius</a>";
}else if(($m=="12" && $d>21)||($m=="01" && $d<21)){
return "<a href=\"capricorn.php?action=main\">Capricorn</a>";
}else {
return "Not Set";
}
}

function getstarsign2($strdate){
//list($year,$month,$day)=explode("-",$date);
$dob = explode("-",$strdate);
if(count($dob)!=3){
return "Unavailable";
}
$m = $dob[1];
$d = $dob[2];
if(($m=="01" && $day>20)||($m=="02" && $day<19)){
return "<a href=\"aquarius.php?action=&amp;sid=$sid\">Characteristics</a>";
}else if(($m=="02" && $d>18)||($m=="03" && $d<21)){
return "<a href=\"pisces.php?action=&amp;sid=$sid\">Characteristics</a>";
}else if(($m=="03" && $d>20)||($m=="04" && $d<20)){
return "<a href=\"aries.php?action=&amp;sid=$sid\">Characteristics</a>";
}else if(($m=="04" && $d>19)||($m=="05" && $d<21)){
return "<a href=\"taurus.php?action=&amp;sid=$sid\">Characteristics</a>";
}else if(($m=="05" && $d>20)||($m=="06" && $d<22)){
return "<a href=\"gemini.php?action=&amp;sid=$sid\">Characteristics</a>";
}else if(($m=="06" && $d>21)||($m=="07" && $d<23)){
return "<a href=\"cancer.php?action=&amp;sid=$sid\">Characteristics</a>";
}else if(($m=="07" && $d>22)||($m=="08" && $d<23)){
return "<a href=\"leo.php?action=&amp;sid=$sid\">Characteristics</a>";
}else if(($m=="08" && $d>22)||($m=="09" && $d<23)){
return "<a href=\"virgo.php?action=&amp;sid=$sid\">Characteristics</a>";
}else if(($m=="09" && $d>22)||($m=="10" && $d<24)){
return "<a href=\"libra.php?action=&amp;sid=$sid\">Characteristics</a>";
}else if(($m=="10" && $d>23)||($m=="11" && $d<23)){
return "<a href=\"scorpio.php?action=&amp;sid=$sid\">Characteristics</a>";
}else if(($m=="11" && $d>22)||($m=="12" && $d<22)){
return "<a href=\"sagittarius.php?action=&amp;sid=$sid\">Characteristics</a>";
}else if(($m=="12" && $d>21)||($m=="01" && $d<21)){
return "<a href=\"capricorn.php?action=&amp;sid=$sid\">Characteristics</a>";
}else {
return "Not Set";
}
}


//////////////////OS By Tufan420
function OS($user_agent){
$exp = explode(" ", $user_agent);
$oses = array (
'Windows 3.11' => 'Win16',
'Windows 95' => '(Windows 95)|(Win95)|(Windows_95)',
'Windows 98' => '(Windows 98)|(Win98)',
'Windows 2000' => '(Windows NT 5.0)|(Windows 2000)',
'Windows XP' => '(Windows NT 5.1)|(Windows XP)',
'Windows Vista' => '(Windows NT 6.0)|(Windows Vista)',
'Windows 7' => '(Windows NT 6.1)|(Windows 7)',
'Windows 2003' => '(Windows NT 5.2)',
'Windows NT 4.0' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
'Windows ME' => 'Windows ME',
'Open BSD'=>'OpenBSD',
'Sun OS'=>'SunOS',
'Linux'=>'(Linux)|(X11)',
'Macintosh'=>'(Mac_PowerPC)|(Macintosh)',
'QNX'=>'QNX',
'BeOS'=>'BeOS',
'OS/2'=>'OS/2',
'Palm OS'=>'Palm OS',
'Search Bot'=>'(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)',
'SonyE'=>'J2ME-MIDP',
'Android'=>'android',
'Symbian'=>'(Series 60)|(Symbian)',
'SymbianOS 6.1'=>'SymbianOS/6.1',
'SymbianOS 7.0'=>'SymbianOS/7.0',
'SymbianOS 8.0'=>'SymbianOS/8.0',
'SymbianOS 9.1'=>'SymbianOS/9.1',
'SymbianOS 9.2'=>'SymbianOS/9.2',
'SymbianOS 9.4'=>'SymbianOS/9.4',
'Mac OS (iPhone)'=>'iPhone',
'Windows CE' => 'Windows CE',
'J2ME-Opera Mini'=>'(Opera Mini)|(Java)|(J2ME)',
);

foreach($oses as $os=>$pattern){
if (eregi($pattern,$user_agent))
return $os;
}
return 'Unknown OS';
}

function getisp($ip)
{
$result=mysql_query("SELECT * FROM network ORDER BY subone, subtwo");
while($ranges=mysql_fetch_array($result)){
if(ipinrange($ip, $ranges[1], $ranges[2])){

return "Network: <b>".$ranges["isp"]."</b><br/>";
}
}	
}

function getisp2($ip)
{
$result=mysql_query("SELECT * FROM network ORDER BY subone, subtwo");
while($ranges=mysql_fetch_array($result)){
if(ipinrange($ip, $ranges[1], $ranges[2])){

return $ranges["country"];
}
}	
}
?>