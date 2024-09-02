<?php
    session_name("PHPSESSID");
session_start();

/*
Uploader
by Methos

   /\             / -------
     /     \   _   /    ----------
    / /     \[.. ]/    ---------
   ////// ' \/ `   ------
  ////  // :    : ------
 // /   /  /`    '----
//          //..\\
       ==UU==UU==
             '//||\\`
Edited By-opticalpigion
*/




echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";
?>

<?php
include("config.php");
include("core.php");
include("class.upload.php");
$bcon = connectdb();
if (!$bcon)
{
    echo "<p align=\"left\">";
    echo "<img src=\"images/exit.gif\" alt=\"*\"/><br/>"; 
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/white_medium.css\">";


    echo "ERROR! cannot connect to database<br/><br/>";
    echo "This error happens usually when backing up the database, please be patient, The site will be up any minute<br/><br/>";
    echo "<b>THANK YOU VERY MUCH</b><br/><br/>";
      echo "</p>";
    
}

$sid = $_SESSION['sid'];
$descript = $_POST["descript"];
$user= $_POST["user"];

error_reporting(E_ALL); 

$userinfo = mysql_fetch_array(mysql_query("SELECT name, sex FROM dcroxx_me_users WHERE id='".$user."'"));
$membername = $userinfo[0];

if ($_POST['action'] == 'image')
{
      addonline(getuid_sid($sid),"Uploading Photo","");
         echo "<p align=\"left\">";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../themes/white_medium.css\">";

    // ---------- IMAGE UPLOAD ----------
    
    // we create an instance of the class, giving as argument the PHP object 
    // corresponding to the file field from the form
    // All the uploads are accessible from the PHP object $_FILES
    $handle = new Upload($_FILES['my_field']);

    // then we check if the file has been uploaded properly
    // in its *temporary* location in the server (often, it is /tmp)
    if ($handle->uploaded) {
        
        // yes, the file is on the server
        // below are some example settings which can be used if the uploaded file is an image.
        $handle->image_resize            = true;
        $handle->image_ratio_y           = true;
        $handle->image_x                 = 128;

        // now, we start the upload 'process'. That is, to copy the uploaded file
        // from its temporary location to the wanted location
        // It could be something like $handle->Process('/home/www/');
        $handle->Process('usergallery/');
        
        // we check if everything went OK
        if ($handle->processed) {
            // everything was fine !

            echo '  File uploaded with success<br/>';
             echo '  <img src="usergallery/' . $handle->file_dst_name . '" /><br/>';
             $info = getimagesize($handle->file_dst_pathname);
            $imageurl = "usergallery/$handle->file_dst_name";
            $reg = mysql_query("INSERT INTO dcroxx_me_usergallery SET uid='".$user."', imageurl='".$imageurl."', sex='".$userinfo[1]."', time='".time()."', descript='".$descript."'");

        } else {
            // one error occured

            echo '  File not uploaded to the wanted location<br/>';
            echo '  Error: ' . $handle->error . '<br/>';

        }

        // we delete the temporary files
        $handle-> Clean();

    } else {
        // if we're here, the upload file failed for some reasons
        // i.e. the server didn't receive the file

        echo '  File not uploaded on the server<br/>';
        echo '  Error: ' . $handle->error . '';
    }

    echo "</p>";     
  
  echo "<p><small>";
  echo "<a href=\"index.php?action=main\">Home</a>";
  echo " &#62; ";
  echo "<a href=\"gallery.php?action=main\">Photo Gallery</a><br/>";
  echo " &#62; ";
  echo "Uploading Photo<br/>";
  echo "</small></p>";  
  

}
?>
