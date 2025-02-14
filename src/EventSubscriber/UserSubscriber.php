<?php

namespace App\EventSubscriber;

use App\Service\PHPMailService;
use App\Event\UserAddSuccessEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class UserSubscriber implements EventSubscriberInterface
{
    public function __construct(private PHPMailService $mail) {}

    public static function getSubscribedEvents()
    {
        return [
            'userAdd.success' => 'sendAddUserMail',
        ];
    }

    //
    public function sendAddUserMail(UserAddSuccessEvent $event)
    {
        $user = $event->getUser();
        // envoi de l'email
        $this->mail->setFrom('tsbtoulouse31@gmail.com', 'Mailer');
        $this->mail->addAddress('pelicarpa@hotmail.fr', 'Joe User');

        $this->mail->isHTML(true);
        $this->mail->Subject = 'Nouvel Utilisateur Ajouté';
        $this->mail->Body    = '<b>Nom</b> : ' . $user->getNom()
            . '<b>Prénom</b> : ' . $user->getPrenom();

        $this->mail->send();
    }
}
