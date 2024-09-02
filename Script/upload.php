<?php
session_name("PHPSESSID");
session_start();
include("xhtmlfunctions.php");
header("Content-type: text/html; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><meta content = \"width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" name = \"viewport\" /> ";

?>

<?php
include('class.upload.php');
include("config.php");
include("core.php");

$bcon = connectdb();

$sid = $_SESSION['sid'];
$uid = getuid_sid($sid);

set_time_limit(0);

if(islogged($sid)==false)
{
      $pstyle = gettheme1("1");
      echo xhtmlhead("$stitle",$pstyle);
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

/////////////////////////////////Members List
  error_reporting(E_ALL);
  // we first include the upload class, as we will need it here to deal with the uploaded file
  $userinfo = mysql_fetch_array(mysql_query("SELECT name, sex FROM dcroxx_me_users WHERE id='".$uid."'"));
  $membername = $userinfo[0];
  // we have three forms on the test page, so we redirect accordingly
  if ($_POST['action'] == 'image') {
        $pstyle = gettheme($sid);
        echo xhtmlhead("",$pstyle);
        echo "<p align=\"center\">";
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
          $handle->image_x                 = 350;
         /* $handle->image_x                 = 189;
          $handle->image_y                 = 150;*/
       $handle->image_bevel = 10;
          $handle->image_bevel_color1 = '#FFFFFF';
$handle->image_bevel_color1 = '#000000';
$handle->image_watermark = 'images/watermark.png';
$handle->image_watermark_x = 5;
$handle->image_watermark_position = 'BR';
            // now, we start the upload 'process'. That is, to copy the uploaded file
          // from its temporary location to the wanted location
          // It could be something like $handle->Process('/home/www/');
          $handle->Process('usergallery/');
          // we check if everything went OK
         if ($handle->processed) {
              // everything was fine !
                echo '  file uploaded with success<br/>';
              echo '  <img src="usergallery/' . $handle->file_dst_name . '" /><br/>';
              $info = getimagesize($handle->file_dst_pathname);
              echo '  link to the file just uploaded: <a href="usergallery/' . $handle->file_dst_name . '">' . $handle->file_dst_name . '</a><br/>';
              $imageurl = "usergallery/$handle->file_dst_name";
              $reg = mysql_query("INSERT INTO dcroxx_me_usergallery SET uid='".$uid."', imageurl='".$imageurl."', sex='".$userinfo[1]."', time='".(time() - $timeadjust)."'");
            } else {
              // one error occured
              echo '  file not uploaded to the wanted location<br/>';
              echo '  Error: ' . $handle->error . '<br/>';
           }
          // we delete the temporary files
          $handle-> Clean();
       } else {
          // if we're here, the upload file failed for some reasons
          // i.e. the server didn't receive the file
            echo '  file not uploaded on the server<br/>';
          echo '  Error: ' . $handle->error . '';
      }
      echo "</p>";
  ////// UNTILL HERE >> 
    echo "<p align=\"center\">";
   echo "<br/><br/><a href=\"gallery2.php?action=main\">&#171;Back to Gallery</a><br/>";
    echo "<a href=\"index.php?action=main\"><img src=\"images/home.gif\" alt=\"*\"/>";
echo "Home</a>";
  echo "</p>";


echo xhtmlfoot();
    exit();
    }

?>
