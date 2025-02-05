<?php

namespace App\Service;

use \PHPMailer\PHPMailer\PHPMailer;

class PHPMailService extends \PHPMailer\PHPMailer\PHPMailer
{

    protected $mailjet_password;

    public function __construct(string $mailjet_password)
    {

        parent::__construct();
        //configuration
        $this->isSMTP();                                            //Send using SMTP
        $this->Host       = 'in-v3.mailjet.com';                     //Set the SMTP server to send through
        $this->SMTPAuth   = true;                                   //Enable SMTP authentication
        $this->Username   = '73c0d23ce55843bfc7cb08c0dfedd436';                     //SMTP username
        $this->Password   = $mailjet_password;                               //SMTP password
        $this->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $this->Port       = 465;
    }
}
