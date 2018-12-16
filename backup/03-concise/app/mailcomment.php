<?php

  $headers  = 'MIME-Version: 1.0' . "\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
  $headers .= "From: camagru-noreply@student.42.fr\n";
  $mailbody = "<html><body>";
  $mailbody .= "<p>Bonjour " . $login_pic . ",</p>";
  $mailbody .= "<p>You have received a new comment from" . $this->login . " for your photo : \"" . $this->comment . "\".</p>";
  $mailbody .= "<p>See you soon!</p>";
  $mailbody .= "<p>Camagru</p>";
  $mailbody .= "</body></html>";

  mail($email, "Camagru - New comment", $mailbody, $headers);

  // mail comment to owner of the picture
 ?>
