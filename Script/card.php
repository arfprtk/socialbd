<?php
date_default_timezone_set('UTC');
$gerNew_Time = time() + (6* 60 * 60);
$gertime=date("l",$gerNew_Time);
$epp = mysql_fetch_array(mysql_query("SELECT id, oprtr, time, status FROM dcroxx_me_rechrgcrd ORDER BY time DESC LIMIT 0,1"));
if($gertime==Wednesday && $epp[3]==1)
{
$lpt = mysql_fetch_array(mysql_query("SELECT id, uid, oprtr, time FROM dcroxx_me_token ORDER BY RAND() LIMIT 1"));
$cdno = mysql_fetch_array(mysql_query("SELECT id, oprtr, no FROM dcroxx_me_cardno WHERE oprtr='ar' ORDER BY RAND() LIMIT 1"));
      mysql_query("INSERT INTO dcroxx_me_private SET text='Congratulation[br/]You have win Airtel Recharge Card[br/] To get your card number contact with [b]Admin Panel[/b][br/][small]p.s: that is an automated pm[/small]', byuid='3', touid='".$lpt[1]."', timesent='".time()."'");
      mysql_query("INSERT INTO dcroxx_me_rechrgcrd SET oprtr='GrameenPhone', time='".time()."', status='2'");
      $nam = getnick_uid($lpt[1]);
      $num = substr($cdno[2],0,4);
      mysql_query("INSERT INTO dcroxx_me_shouts SET shout='Congratulation. ".$nam." just win Airtel Recharge Card[br/][b]Card No: xxxxxxxxxxx [/b]', shouter='3', shtime='".time()."'");
      mysql_query("UPDATE dcroxx_me_rechrgcrd SET uid='".$lpt[1]."', cno='".$cdno[2]."', gtime='".time()."' WHERE id='".$epp[0]."'");
      mysql_query("DELETE FROM dcroxx_me_token");
      mysql_query("DELETE FROM dcroxx_me_cardno WHERE id='".$cdno[0]."'");
}else if($gertime==Friday && $epp[3]==2)
{
$lpt = mysql_fetch_array(mysql_query("SELECT id, uid, oprtr, time FROM dcroxx_me_token ORDER BY RAND() LIMIT 1"));
$cdno = mysql_fetch_array(mysql_query("SELECT id, oprtr, no FROM dcroxx_me_cardno WHERE oprtr='gp' ORDER BY RAND() LIMIT 1"));
      mysql_query("INSERT INTO dcroxx_me_private SET text='Congratulation[br/]You have win GrameenPhone Recharge Card[br/]To get your card number contact with [b]Admin Panel[/b][br/][small]p.s: that is an automated pm[/small]', byuid='3', touid='".$lpt[1]."', timesent='".time()."'");
      mysql_query("INSERT INTO dcroxx_me_rechrgcrd SET oprtr='Robi', time='".time()."', status='3'");
      $nam = getnick_uid($lpt[1]);
      $num = substr($cdno[2],0,4);
      mysql_query("INSERT INTO dcroxx_me_shouts SET shout='Congratulation. ".$nam." just win GrameenPhone Recharge Card[br/][b]Card No: xxxxxxxxxxx [/b]', shouter='3', shtime='".time()."'");
      mysql_query("UPDATE dcroxx_me_rechrgcrd SET uid='".$lpt[1]."', cno='".$cdno[2]."', gtime='".time()."' WHERE id='".$epp[0]."'");
      mysql_query("DELETE FROM dcroxx_me_token");
      mysql_query("DELETE FROM dcroxx_me_cardno WHERE id='".$cdno[0]."'");
}else if($gertime==Saturday && $epp[3]==3)
{
$lpt = mysql_fetch_array(mysql_query("SELECT id, uid, oprtr, time FROM dcroxx_me_token ORDER BY RAND() LIMIT 1"));
$cdno = mysql_fetch_array(mysql_query("SELECT id, oprtr, no FROM dcroxx_me_cardno WHERE oprtr='rb' ORDER BY RAND() LIMIT 1"));
      mysql_query("INSERT INTO dcroxx_me_private SET text='Congratulation[br/]You have win Robi Recharge Card[br/]To get your card number contact with [b]Admin Panel[/b][br/][small]p.s: that is an automated pm[/small]', byuid='3', touid='".$lpt[1]."', timesent='".time()."'");
      mysql_query("INSERT INTO dcroxx_me_rechrgcrd SET oprtr='Banglalink', time='".time()."', status='4'");
      $nam = getnick_uid($lpt[1]);
      $num = substr($cdno[2],0,4);
      mysql_query("INSERT INTO dcroxx_me_shouts SET shout='Congratulation. ".$nam." just win robi Recharge Card[br/][b]Card No: xxxxxxxxxxx [/b]', shouter='3', shtime='".time()."'");
      mysql_query("UPDATE dcroxx_me_rechrgcrd SET uid='".$lpt[1]."', cno='".$cdno[2]."', gtime='".time()."' WHERE id='".$epp[0]."'");
      mysql_query("DELETE FROM dcroxx_me_token");
      mysql_query("DELETE FROM dcroxx_me_cardno WHERE id='".$cdno[0]."'");
}else if($gertime==Monday && $epp[3]==4)
{
$lpt = mysql_fetch_array(mysql_query("SELECT id, uid, oprtr, time FROM dcroxx_me_token ORDER BY RAND() LIMIT 1"));
$cdno = mysql_fetch_array(mysql_query("SELECT id, oprtr, no FROM dcroxx_me_cardno WHERE oprtr='bl' ORDER BY RAND() LIMIT 1"));
      mysql_query("INSERT INTO dcroxx_me_private SET text='Congratulation[br/]You have win Banglalink Recharge Card[br/]To get your card number contact with [b]Admin Panel[/b][br/][small]p.s: that is an automated pm[/small]', byuid='3', touid='".$lpt[1]."', timesent='".time()."'");
      mysql_query("INSERT INTO dcroxx_me_rechrgcrd SET oprtr='Airtel', time='".time()."', status='1'");
      $nam = getnick_uid($lpt[1]);
      $num = substr($cdno[2],0,4);
      mysql_query("INSERT INTO dcroxx_me_shouts SET shout='Congratulation. ".$nam." just win Banglalink Recharge Card[br/][b]Card No: xxxxxxxxxxx [/b]', shouter='3', shtime='".time()."'");
      mysql_query("UPDATE dcroxx_me_rechrgcrd SET uid='".$lpt[1]."', cno='".$cdno[2]."', gtime='".time()."' WHERE id='".$epp[0]."'");
      mysql_query("DELETE FROM dcroxx_me_token");
      mysql_query("DELETE FROM dcroxx_me_cardno WHERE id='".$cdno[0]."'");
}
?>