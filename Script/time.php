<?php
date_default_timezone_set('UTC');
$TimeZone="+6"; 
$gerNew_Time = time() + (6* 60 * 60);
$Hour=date("H",$gerNew_Time);


/*if ($Hour <= 4) { echo 'Good Evening'; }
else */
     if ($Hour <= 11) { echo 'Good Morning'; }
else if ($Hour <= 12) { echo 'Good Noon'; }
else if ($Hour <= 15) { echo 'Good Afternoon'; }
else if ($Hour <= 18) { echo 'Good Evening'; }
else if ($Hour <= 23) { echo 'Good Night'; }
else if ($Hour <= 00) { echo 'You Night Owl'; }

echo "";
?>




