<?php

namespace App\Controller;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'Controller de page Accueil',
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('home/contact.html.twig', [
            'controller_name' => 'Controller de page contact',
            'coordonnees1' => [
                "Nom" => "Sa Bento",
                "Prénom" => "Tony",
                "Adresse" => "8 Rue du Pré Vicinal, 31270 Cugnaux",
                "Email" => "pelicarpa@hotmail.fr",
            ],
            'coordonnees2' => [
                "Nom" => "Houvenaeghel",
                "Prénom" => "Margot",
                "Adresse" => "8 Rue du Pré Vicinal, 31270 Cugnaux",
                "Email" => "houvenaeghel@hotmail.fr",
            ]
        ]);
    }

    #[Route('/mail', name: 'app_mail')]
    public function mail(MailerInterface $mailer): Response
    {

        //envoi du mail
        $email = new Email();
        $email->from('symfony6@gmail.com')
            ->to('pelicarpa@hotmail.fr')
            ->subject('test email symfony')
            ->text('texte email test')
            ->html('<h2>Test email</h2>');

        $mailer->send($email);

        return $this->render(
            'home/email.html.twig',
            [
                'controller_name' => 'envoi réussi',
            ],
        );
    }
}
