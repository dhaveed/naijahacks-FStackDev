<?php
require 'util/functions.php';
require 'config.php';
require_once 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
$mail = new Mailing();
$mail->mail_verification('ade@adey.com', 'Hello');

?>