<?php

//A
$today = time();

//B
$event = mktime(0,0,0,12,25,date("Y"));

//C
$apart = $event - $today;

//D
if ($apart >= -86400)
{
  $myevent = $event;
}

//E
else
{
  $myevent = mktime(0,0,0,12,25,date("Y")+1);
}

//F
$countdown = round(($myevent - $today)/86400);

//G
if ($countdown > 1)
{
  echo "$countdown days until Christmas";
}

//H
elseif (($myevent-$today) <= 0 && ($myevent-$today) >= -86400)
{
  echo "Today is Christmas!";
}

//I
else
{
  echo "$countdown day until Christmas";
}

?>