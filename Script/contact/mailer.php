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
    </style>
</head>
<body>

<h1>Contact</h1>

<?php

/* VARIABLES */

// Type in your email address to receive the mail
$to = "bcp.eragon@yahoo.com";

// If you wish to show a logo in the mail, paste the URL here.
// For example: http://mywebsite.com/mylogo.png
// Remember http://
$logo_url = "http://socialbd.net/logo250x250.png";

/* VARIABLES END */

if(isset($_POST['post'])) {
    $name      = $_POST['name'];
    $email      = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $captcha = $_POST['captcha'];
    $captcha_answer = $_SESSION['captcha_answer'];
    $ip_address = $_SERVER['REMOTE_ADDR'];
$brws = explode("/",$_SERVER['HTTP_USER_AGENT']);
$ubr = $brws[0];
    
    if($name == "" or $subject == "empty" or $message == "" or $captcha == "") {
        echo 'One or more fields has not been filled out.<br>
        Please go back and try again.';
    }
    elseif($captcha != $captcha_answer) {
        echo 'The CAPTCHA failed.<br>
        Please go back and verify that you are human.';
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'The email address could not be validated.<br>
        Please go back and verify your email address.';
    }
    else { // All checks passed
        if(isset($logo_url) and strlen($logo_url) > 3) {
            $logo = '<img src="'.$logo_url.'" alt="SocialBD.NeT" style="border:none;" height="150" width="150"><br><br>';
        }
        else { 
            $logo = ""; 
        }
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=utf-8\r\n";
        $message = '<html><head><style>body { font-family: Verdana; font-size: 12px; }</style></head><body>';
        $message .= "<center>$logo</center>

Hello, I'm <b>$name</b> <br>
This is my problem:<br> <b>".nl2br($_POST['message'])."</b><br><br>
IP: $ip_address , Browser: $ubr


</body></html>";
        $sendMail = mail($to, $subject, $message, $headers);
        if($sendMail) {
            echo 'Thank you, the mail has been successfully sent!<br><br>';
echo "<meta http-equiv=\"refresh\" content=\"5; URL= index.php\"/>";
 
        }
        else {
            echo 'An error occured and the mail could not be sent.<br>
            Please try again later.';
        }
    }
}
else {
    header("location:index.php");
}    
?>
    
</body>
</html>