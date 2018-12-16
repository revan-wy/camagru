<?php

  $headers  = 'MIME-Version: 1.0' . "\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
  $headers .= "From: camagru-noreply@student.42.fr\n";
  $mailbody = "<html><body>";
  $mailbody .= "<p>Bonjour " . $this->login . ",</p>";
  $mailbody .= "<p>To reset your password for Camagru, click on the following link within 48 hours : ";
  $mailbody .= "<a href=http://" . $pwrurl . ">Follow me</a></p>";
  $mailbody .= "<p>See you soon !</p>";
  $mailbody .= "<p>Camagru</p>";
  $mailbody .= "</body></html>";

  if (mail($email, "Camagru - Forgot your password", $mailbody, $headers))
    $this->message = "An email has been sent to reset your password.";
  else
    $this->message = "The reset email could not be sent.";

  // mail to change password with a link to be followed
?>
