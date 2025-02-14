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
        $this->CharSet = "UTF-8";
        $this->Encoding = "base64";
        $this->Host       = 'whisker.o2switch.net';                     //Set the SMTP server to send through
        $this->SMTPAuth   = true;                                   //Enable SMTP authentication
        $this->Username   = 'sato4773';                     //SMTP username
        $this->Password   = $mailjet_password;                               //SMTP password
        $this->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $this->Port       = 465;
    }
}
