<?php

namespace App\Service;

use \PHPMailer\PHPMailer\PHPMailer;

class PHPMailService extends \PHPMailer\PHPMailer\PHPMailer
{
    public function __construct()
    {
        //configuration
        $this->isSMTP();                                            //Send using SMTP
        $this->Host       = 'in-v3.mailjet.com';                     //Set the SMTP server to send through
        $this->SMTPAuth   = true;                                   //Enable SMTP authentication
        $this->Username   = '73c0d23ce55843bfc7cb08c0dfedd436';                     //SMTP username
        $this->Password   = '0ec33ec61e981098d5c5a028a34f78b9';                               //SMTP password
        $this->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $this->Port       = 465;
    }
}
