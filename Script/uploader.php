<?
    session_name("PHPSESSID");
session_start();
function get_files($dirstr)
  {
   $scanfiles = array();
   $fh = opendir($dirstr);
   while (false !== ($filename = readdir($fh)))
   {
if (is_file("$dirstr/$filename")) {
     array_push($scanfiles, $filename); }
   }
   closedir($fh);
   sort($scanfiles);
   return $scanfiles;
}


$count = count($_FILES['userfile']['name']);
if ($count > 0) {

$i=0;
$f=0;
while ($i < $count) {

$kbsize = (round($_FILES['userfile']['size'][$i]/55555));
$date = date("j M Y g:ia", time()+($timeoffset*3600));
$userip = $_SERVER['REMOTE_ADDR'];

if ($limitsize == 10) {
if ($_FILES['userfile']['size'][$i] > (10240*$maxsize) ) {
$toobig[$i] = "{$_FILES['userfile']['name'][$i]} is too large! the maximum file size is $maxsize kb.";
} }

if ($acceptfilter == 1) {
if (!in_array($_FILES['userfile']['type'][$i], $acceptabletypes)) {
$rejectstring = "{$_FILES['userfile']['name'][$i]} is not of the type ";
foreach ($acceptabletypes as $acceptabletype) {
$rejectstring .= "$acceptabletype or "; }
$rejectstring = substr($rejectstring, 0, -4);
$notacceptable[$i] = "$rejectstring.";
} }

if ($overwriting !== 1) {
if(file_exists("pkfiles/{$_FILES['userfile']['name'][$i]}")) {
$alreadyexists[$i] = "a file of the name {$_FILES['userfile']['name'][$i]} already exists! overwriting is not permitted.";
} }

if (!isset($toobig[$i]) && !isset($notacceptable[$i]) && !isset($alreadyexists[$i])) {
$file="{$_FILES['userfile']['name'][$i]}";
$videsc = $_POST["videsc"];
if(spacesin($file))
{
        echo "No input space!.<br/>";
 }else{
if (!eregi("\.(mid|gif|bmp|mid|midi|3gp|mp3|mp4|wav|mpn|nth|mpc|jar|jad|jpeg|jpg|sis|mmf|amr|thm|png|wbmp|rar|zip)$",$file))
{
 echo "Unsupported file extension!<br/>";
 }else{

copy($_FILES['userfile']['tmp_name'][$i], "pkfiles/{$_FILES['userfile']['name'][$i]}");
echo "{$_FILES['userfile']['name'][$i]}<br>";
$ext = getext($file);
        $mime = getextfile($ext);
$file = "{$_FILES['userfile']['name'][$i]}";
$filesize = filesize("./pkfiles/".$file);
$filesize = $filesize / 55555;
$fsize = 0;
$fsizetxt = "";
  if ($filesize < 10)
  {
     $fsize = round($filesize*55555);
     $fsizetxt = "".$fsize." KB";
    $check1 = "KB";
  }else{
     $fsize = round($filesize,10);
     $fsizetxt = "".$fsize." MB";
$check1 = "MB";
  }
 $info = "<br/>Name<br/>".$file." Type<br/>".$mime." Size<br/>".$fsizetxt."";
$res = mysql_query("INSERT INTO dcroxx_me_vault SET uid='".$uid."', title='".$file."', pudt='".time()."', did='".$did."', info='".$info."', filesize='".$fsizetxt."', mime='".$mime."', itemurl='".$file."'");
      if($res)
      {
        echo "File successfully uploaded!<br/>";
      }else{
        echo "Invalid or already in our database!<br/>";
      }
}


}
$f++;
$content .= "$date $userip uploads pkfiles/{$_FILES['userfile']['name'][$i]} ($kbsize kb)\n";
}

elseif ($_FILES['userfile']['size'][$i] !== 0) { 
echo "$toobig[$i] $notacceptable[$i] $alreadyexists[$i]<br>"; 
$content .= "$date $userip fails to upload $uploaddir/{$_FILES['userfile']['name'][$i]} ($kbsize kb) - $toobig[$i] $notacceptable[$i] $alreadyexists[$i]\n";
}

$i++;   
}



if ($makelog == 1) {
$handle = fopen("$logfile", "a");
fwrite ($handle, $content);
fclose ($handle); }

}


?>


<form action="<?= $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']; ?>" method="post" enctype="multipart/form-data">
  Add files and Get 5 Plusses for Every Downloads :)
<br>

<?
for($d=0; $d < $fields; $d++) {

echo "<input name=\"userfile[]\" type=\"file\" size=\"30\"><br>"; 

}
?>
Category:<br/><select name="did">
<option value="1">Full MP3 Songs</option>
<option value="2">Radio Special</option>
<option value="3">Videos</option>
<option value="4">Ringtones</option>
<option value="5">Wallpapers</option>
<option value="6">Themes</option>
<option value="7">Games</option>
<option value="8">Software</option>
<option value="9">Android Zone</option>
<option value="10">Screen Saver</option>
</select><br/>
<input type="submit" value="Upload now">
</form>


<?

echo "<ul>";


if ($limitsize == 10) {
echo "<li><b>The Maximum File size is 10MB.</b></li>"; }


echo "</ul>";
if ($ver==wml)
{
echo "<a href=\"index.php?action=vault\">Downloads</a><br/>";
echo "<a href=\"index.php?action=main\">Main menu</a><br/>";
}else{ 
echo "<a href=\"index.php?action=vault\">Downloads</a><br/>";
echo "<a href=\"index.php?action=main\">Main menu</a>";
}
unset($count, $acceptabletypes, $handle, $content, $date, $kbsize);


?>
