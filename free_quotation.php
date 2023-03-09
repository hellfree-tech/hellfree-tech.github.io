<?php
//start building the mail string 
$msg ="Name:   ".$_POST['volunteer-name']."/n";
$msg .="E-Mail:   ".$_POST['volunteer-email']."/n";
$msg .="Service Type:   ".$_POST['job-salary']."/n";
$msg .="Message:   ".$_POST['volunteer-message']."/n";

//set up the mail
$recipent = "babatunderaji2011@gmail.com";
$subject = "Form Submission Results";
$mailheaders = "From: My Web Site <babatunderaji2011@gmail.com> \n";
$mailheaders .= "Reply-To: ".$_POST['volunteer-email'];

//send the mail
if (mail($recipent, $subject, $msg, $mailheaders)) {
	echo "Error";
} else {
	echo "Send Successfully";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Sending mail from the form</title>
</head>
<body>
<p>Thanks, <strong><?php echo $_POST['volunteer-name']; ?></strong>,for your message.</p>
<p>Your e-mail address:<strong><?php echo $_POST['volunteer-email'] ?></strong></p>
<p>Your Service Type:<strong><?php echo $_POST['job-salary'] ?></strong></p>
<p>Your message: <br/> <?php echo $_POST['volunteer-message']; ?> </p>
</body>
</html>