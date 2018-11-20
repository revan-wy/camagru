<?php

  $headers  = 'MIME-Version: 1.0' . "\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
  $headers .= "From: camagru-noreply@student.42.fr\n";
  $mailbody = "<html><body>";
  $mailbody .= "<p>Hi " . $this->login . ",</p>";
  $mailbody .= "To confirm your Camagru account, click on the following link within 48 hours  : ";
  $mailbody .= "<a href=http://" . $pwrurl . ">Follow me  </a></p>";
  $mailbody .= "<p>see you soon !</p>";
  $mailbody .= "<p>Camagru</p>";
  $mailbody .= "</body></html>";

  if (mail($this->email, "Camagru - Confirm your account  ", $mailbody, $headers))
    $this->message = "An email has been sent to you to confirm your account.";
  else
    return $this->message = "Registration email could not be sent.";

  // confirmation mail with a link to be followed to confirm the account
?>
