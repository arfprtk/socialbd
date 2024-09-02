<?php
    session_name("PHPSESSID");
session_start();


header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\"\"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\">";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";

?>
<meta content = "width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name = "viewport" /> 
<?php
include("config.php");
include("core.php");
include("xhtmlfunctions.php");
   echo "<head>";
echo "<title>Articles</title>";
   //echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/$theme[0]\">";
   echo "</head>";

   echo "<body>";
$bcon = connectdb();
if (!$bcon)
{
    echo "<p align=\"center\">";
      echo "sorry probably our database cant hold the system of our server.<br/>";
      echo "Please come back later<br/><br/>";
      echo "</p>";
    exit();
}
$action = $_GET["action"];
$sid = $_SESSION['sid'];
$artid = $_GET["artid"];
$page = $_GET["page"];
$uid = getuid_sid($sid);
if($action != "")
{
    if(islogged($sid)==false)
    {

 echo "<p align=\"center\">";
      echo "You are not logged in<br/>";
      echo "Or Your session has been expired<br/><br/>";
      echo "<a href=\"index.php\">Login</a>";
      echo "</p>";
      exit();

    }
}
if(isbanned($uid))
    {

      echo "<p align=\"center\">";
     echo "<img src=\"images/exit2.gif\" alt=\"*\"/><br/>";
      echo "You are <b>Banned</b><br/>";
      $banto = mysql_fetch_array(mysql_query("SELECT timeto FROM dcroxx_me_penalties WHERE uid='".$uid."' AND penalty='1'"));
      $remain = $banto[0]- time();
      $rmsg = gettimemsg($remain);
      echo "Time to finish your penalty: $rmsg<br/><br/>";
      //echo "<a href=\"index.php\">Login</a>";
      echo "</p>";

      exit();
    }
  
if($action == "")
{
     $pstyle = gettheme($sid);
      echo xhtmlhead("Hangman",$pstyle);
     addonline(getuid_sid($sid), "Playing Hangman", "");

	    echo "<head>";
    echo "<title>Playing Hangman</title>";
    echo "</head>";
    echo "<body>";
echo "<small><b>Playing Hangman</b><br/><br/>";

   
   
$cat=$_GET["cat"];
if ($cat==""){

echo "<b>Select a category:</b><br/>";
echo "<a href=\"$PHP_SELF?cat=anmls\">Animals</a><br/>";
echo "<a href=\"$PHP_SELF?cat=clrs\">Colours</a><br/>";
echo "<a href=\"$PHP_SELF?cat=comp\">Computers</a><br/>";
echo "<a href=\"$PHP_SELF?cat=frt\">Fruit</a><br/>";
echo "<a href=\"$PHP_SELF?cat=big\">Big Words</a><br/>";
echo "<a href=\"$PHP_SELF?cat=lotr\">Lord Of The Rings</a><br/>";
echo "<a href=\"$PHP_SELF?cat=mths\">Months</a><br/>";
echo "<a href=\"$PHP_SELF?cat=web\">Web / Wap coding</a><br/>";

echo "<br/><img src=\"images/home.gif\" alt=\"\"><a href=\"index.php?action=main\">Home</a>";
echo "</small>";
echo "</body>";

exit();
}
if ($cat=="anmls"){
$category="ANIMALS";
$list = "ANIMALS
BABOON
BEAR
BULL
CAMEL
CAT
COW
CROW
DOG
DONKEY
DUCKBILL PLATYPUS
EAGLE
ELEPHANT
FISH
FOX
GIRAFFE
GOAT
GOLDFISH
HAWK
HEDGEHOG
HORSE
KANGAROO
KITTEN
MOLE
MONKEY
MOUSE
MULE
OWL
PARROT
PIG
PINK ELEPHANT
POLAR BEAR
PORCUPINE
POSSUM
PUPPY
RABBIT
RACCOON
RAT
ROBIN
SEAL
SHARK
SKUNK
SQUIRREL
STOAT
WALRUS
WEASEL
WHALE
ZEBRA";}



if ($cat=="clrs"){
$category="COLOURS";
$list = "BLACK
BLUE
BROWN
BUBBLEGUM PINK
COLORS
CYAN
FUCHSIA
GOLD
GREEN
GREY
INDIGO
LAVENDER
LIME GREEN
MAROON
OLIVE
ORANGE
PERIWINKLE
PINK
PURPLE
RED
ROYAL BLUE
SCARLET
TEAL
TURQUOISE
VIOLET
WHITE
YELLOW"; }


if ($cat=="comp"){
$category="COMPUTERS";
$list = "ACCESS
ANTI-VIRUS SOFTWARE
BASIC
CD-ROM DRIVE
CHAT
COMPUTER
CPU
DATABASE
DOS
EMAIL
EXCEL
FIREWALL
FLOPPY DRIVE
FORUMS
FRONTPAGE
GAMES
HACKER
HARD DRIVE
HTML
ICQ
INTERNET
JUNK MAIL
KEYBOARD
LINUX
LOTUS
MICROSOFT
MONITOR
MOTHER BOARD
MOUSEPAD
OPERATING SYSTEM
PARALLEL PORT
PHP
PRINTER
PUBLISHING
RAM
SERIAL PORT
SOLITARE
SPEAKERS
TECHNOLOGY
UNIX
URL
VIRUS
VISUAL BASIC
WINDOWS
WORD
WORD PROCESSING
WORLD WIDE WEB
ZIP"; }


if ($cat=="frt"){
$category="FRUIT";
$list = "APPLE
BANANA
BLACKBERRY
BLUEBERRY
FRUIT
GRAPE
GUAVA
GRAPEFRUIT
KIWI
MANGO
ORANGE
PEACH
PEAR
RASBERRY
STRAWBERRY
TANGERINE
TOMATO
UGLY FRUIT"; }



if ($cat=="big"){
$category="BIG WORDS";
$list = "AUSTRALOPITHECINE
DEOXYRIBONUCLEIC ACID
LARGE WORDS
MITOCHONDRIA"; }

if ($cat=="lotr"){
$category="LORD OF THE RINGS";
$list = "AGORNATH
ARAGORN
ARWEN
BAG END
BALIN
BALROG
BARROW DOWNS
BARROW WRIGHT
BEREN
BILBO BAGGINS
BLACK RIDERS
BOROMIR
BREE
BUCKLAND
CELEBORN
DEAD MARSHES
DWARVES
EDORAS
ELENDIL
ELFSTONE
ELROND
ELVES
ENTS
EOWYN
FANGORN FOREST
FARAMIR
FRODO BAGGINS
GALADRIEL
GANDALF
GILGALAD
GLAMDRING
GLORFINDEL
GOLDBERRY
GOLLUM
GONDOR
HALDIR
HELMS DEEP
HOBBITON
HOBBITS
ISENGARD
ISILDUR
LEGOLAS
LEMBAS BREAD
LONELY MOUNTAIN
LONELY MOUNTIAN
LORD OF THE RINGS
LOTHLORIEN
LUTHIEN
MELKOR
MEN
MERRY
MIDDLE EARTH
MINAS MORGUL
MINAS TIRITH
MIRKWOOD
MITHRANDIR
MITHRIL
MORDOR
MORIA
MT. DOOM
MY PRECIOUSSS
NAZGUL
NUMENOR
OLD FOREST
OLD MAN WILLOW
ORCS
ORTHANC
PIPE WEED
PIPPIN
PLAINTIR
RANGERS
RINGWRAITHS
RIVENDELL
ROHAN
SAMWISE GAMGEE
SARUMAN
SAURON
SHADOWFAX
SHAGRAT
SHELOB
SHIRE
SILMARILLIAN
SMAUG
SMEAGOL
STEWARD OF GONDOR
STING
STRIDER
THE FELLOWSHIP OF THE RING
THE RETURN OF THE KING
THE RING
THE TWO TOWERS
THEODIN
TOM BOMBADIL
TREEBEARD
TROLLS
UNDYING LANDS
URUK-HAI
VALINOR
WARG RIDERS
WEATHERTOP
WIZARDS
WORMTONGUE";}


if ($cat=="mths"){
$category="MONTHS";
$list = "APRIL
AUGUST
DECEMBER
FEBRUARY
JANUARY
JULY
JUNE
MARCH
MAY
MONTHS
NOVEMBER
OCTOBER
SEPTEMBER"; }

if ($cat=="web"){
$category="WEB / WAP CODING";
$list = "JAVA BEANS
PHP SCRIPTS
SOURCE CODE
JAVASCRIPT GAMES
SSI IS SERVER SIDE INCLUDES
BILL GATES
COOKIES
HTTP AUTHENTICATION
ERROR HANDLING
MANIPULATING IMAGES
FILE UPLOADS
DATABASE / CONNECTION
APACHE SERVER
ZIP FILE
TAR COMPRESSION
FUNCTIONS
ENCRYPTION
MYSQL DATABASE
INITIALIZATION
FAQ - FREQUENTLY ASKED QUESTIONS
DEBUGGING
VERIFICATION
HTML VALIDATION
CASCADING STYLE SHEETS";}

# below ($alpha) is the alphabet letters to guess from.
# you can add international (non-English) letters, in any order, such as in:
# $alpha = "????????????????????????????ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$alpha = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

# below ($additional_letters) are extra characters given in words; '?' does not work
# these characters are automatically filled in if in the word/phrase to guess
$additional_letters = " -.,;!?%& 0123456789/";

#========= do not edit below here ======================================================
$uid = getuid_sid($sid);
$len_alpha = strlen($alpha);

if(isset($_GET["n"])) $n=$_GET["n"];
if(isset($_GET["letters"])) $letters=$_GET["letters"];
if(!isset($letters)) $letters="";

if(isset($PHP_SELF)) $self=$PHP_SELF;
else $self="hangman.php";

$links="";
$max=6;
# error_reporting(0);
$list = strtoupper($list);
$words = explode("\n",$list);
srand ((double)microtime()*1000000);
$all_letters=$letters.$additional_letters;
$wrong = 0;
	
echo "<p align=\"center\">";
if (!isset($n)) { $n = rand(1,count($words)) - 1; }
$word_line="";
$word = trim($words[$n]);
$done = 1;
for ($x=0; $x < strlen($word); $x++)
{
if (strstr($all_letters, $word[$x]))
{
if ($word[$x]==" ") $word_line.=" / "; else $word_line.=$word[$x];
}
else { $word_line.="_ "; $done = 0; }
}

if (!$done)
{

for ($c=0; $c<$len_alpha; $c++)
{
if (strstr($letters, $alpha[$c]))
{
if (strstr($words[$n], $alpha[$c])) {$links .= "<b>$alpha[$c]</b> "; }
else { $links .= " $alpha[$c] "; $wrong++; }
}
else
{ $links .= " <a href=\"$self?cat=$cat&amp;letters=$alpha[$c]$letters&amp;n=$n\">$alpha[$c]</a> "; }
}
echo"<img src=\"hangman_$wrong.gif\" alt=\"*\"/>";
$nwrong=$wrong; if ($nwrong>6) $nwrong=6;
echo "<br/>Wrong: $wrong out of $max!<br/>";

if ($wrong >= $max){
$n++;
if ($n>(count($words)-1)) $n=0;

echo "<br/><br/>$word_line";
echo "<br/><br/><big>SORRY, YOU ARE HANGED!!!</big><br/><br/>";
if (strstr($word, " ")) $term="answer"; else $term="word";
echo "The $term was \"<b>$word</b>\"<br/><br/>";
$sqlfetch=mysql_query("SELECT plusses FROM alien_war_users WHERE id='".$uid."'");
$sqlfet=mysql_fetch_array($sqlfetch);
$plussesnew=$sqlfet[0] - "10";
$sql="UPDATE alien_war_users SET plusses='".$plussesnew."' WHERE id='".$uid."'";
$res=mysql_query($sql);
echo "You have lost 10 Credits!!<br/>";
echo "<a href=\"$self?cat=$cat&amp;n=$n\">Play again</a><br/>";
echo "<a href=\"$self?\">Change category</a>";
}
else{
echo " Wrong Guesses Left: <b>".($max-$wrong)."</b><br/><br/>";
echo "$word_line";
echo "<br/><br/>Choose a letter:<br/>";
echo "$links";
}
}else{
$n++; # get next word
if ($n>(count($words)-1)) $n=0;
echo "<b><font color=\"#006400\">$word_line</font></b>";
echo "<br/><br/><b>Congratulations!!! You win!!!</b><br/>";
$sqlfetch=mysql_query("SELECT plusses FROM alien_war_users WHERE id='".$uid."'");
$sqlfet=mysql_fetch_array($sqlfetch);
$plussesnew=$sqlfet[0] + "25";
$sql="UPDATE alien_war_users SET plusses='".$plussesnew."' WHERE id='".$uid."'";
$res=mysql_query($sql);
echo "You have won 25 Credits for winning!<br/>";
echo "<a href=\"$self?cat=$cat&amp;n=$n\">Play again</a><br/>";
echo "<a href=\"$self?\">Change category</a>";
}
   
echo "<br/><img src=\"images/home.gif\" alt=\"\"><a href=\"index.php?action=main\">Home</a>";
echo "</small>";
echo "</body>";
    }


?>
</html>