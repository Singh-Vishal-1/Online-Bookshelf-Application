<?php
require_once "Mail.php";  //this includes the pear SMTP mail library

$from = "Password System Reset <noreply@loki.trentu.ca>";

$to = $email;  //put user's email here

$subject = "Password Reset Confirmation";
$body = "Hey User, This is a Confirmation Email that your password has been Reset.";
$host = "smtp.trentu.ca";
$headers = array ('From' => $from,
  'To' => $to,
  'Subject' => $subject);
$smtp = Mail::factory('smtp',
  array ('host' => $host));
  
$mail = $smtp->send($to, $headers, $body);
if (PEAR::isError($mail)) {
  echo("<p>" . $mail->getMessage() . "</p>");
 } 

?>