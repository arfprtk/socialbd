<?php
session_start();
?>
<html>
<head>
    <title>Contact form by IT-DB.com</title>
    <style type="text/css">
        body {
            font-family:Verdana,sans-serif;
            font-size:12px;
        }
        b.red { color:#ff0000; }
    </style>
</head>
<body>

<h1>Contact</h1>

Fields marked with <b class="red">*</b> must be filled out!<br><br>

<form action="mailer.php" method="post">

<b class="red">*</b> Name:<br>
<input type="text" name="name"><br><br>

<b class="red">*</b> E-mail:<br>
<input type="text" name="email"><br><br>

<b class="red">*</b> Subject:<br>
<select name="subject">
    <option value="empty">- Please select -</option>
    <option value="Questions">Questions</option>
    <option value="Complaints">Complaints</option>
    <option value="Other">Other</option>
</select><br><br>

<b class="red">*</b> Message:<br>
<textarea name="message" style="width:400px;height:300px;"></textarea><br><br>

<?php
$rand_int1 = substr(mt_rand(),0,2);
$rand_int2 = substr(mt_rand(),0,1);
$captcha_answer = $rand_int1 + $rand_int2;
$_SESSION['captcha_answer'] = $captcha_answer;
echo '<b class="red">*</b> CAPTCHA: '.$rand_int1.' + '.$rand_int2.'?<br> 
<input type="text" name="captcha"><br><br>';
?>

<input type="submit" name="post" value="Send">
</form>

</body>
</html>