<?php

namespace App\EventListener;


use App\Event\UserDeleteSuccessEvent;
use App\Service\PHPMailService;

class UserDeleteListener
{
    public function __construct(private PHPMailService $mail) {}

    public function sendDeleteUserEmail(UserDeleteSuccessEvent $event)
    {
        $user = $event->getUser();

        //envoi du mail
        $this->mail->setFrom('tsbtoulouse31@gmail.com', 'Mailer');
        $this->mail->addAddress('pelicarpa@hotmail.fr', 'Joe User');

        $this->mail->isHTML(true);
        $this->mail->Subject = 'Utilisateur Supprimé';
        $this->mail->Body    = '<b>Nom</b> : ' . $user->getNom()
            . '<b>Prénom</b> : ' . $user->getPrenom();

        $this->mail->send();
    }
}
