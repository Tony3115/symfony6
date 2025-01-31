<?php

namespace App\Controller;

use App\Service\MessageGenerator;
use App\Service\PHPMailService;
use PHPMailer\PHPMailer\PHPMailer;
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

    #[Route('/phpmail', name: 'app_phpmail')]
    public function phpmail(): Response
    {
        //configuration
        $mail = new PHPMailer(true);
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'in-v3.mailjet.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = '73c0d23ce55843bfc7cb08c0dfedd436';                     //SMTP username
        $mail->Password   = '0ec33ec61e981098d5c5a028a34f78b9';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;

        //envoi du mail
        $mail->setFrom('tsbtoulouse31@gmail.com', 'Mailer');
        $mail->addAddress('pelicarpa@hotmail.fr', 'Joe User');

        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Test avec PHPMails';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';

        $mail->send();

        return $this->render(
            'home/email.html.twig',
            [
                'controller_name' => 'envoi réussi',
            ],
        );
    }

    #[Route('/service', name: 'app_service')]
    public function service(MessageGenerator $msg): Response
    {


        return $this->render(
            'home/email.html.twig',
            [
                'controller_name' => $msg->getHappyMessage(),
            ],
        );
    }

    #[Route('/phpmail_service', name: 'app_phpmail_service')]
    public function phpmailService(PHPMailService $mail): Response
    {

        //envoi du mail
        $mail->setFrom('tsbtoulouse31@gmail.com', 'Mailer');
        $mail->addAddress('pelicarpa@hotmail.fr', 'Joe User');

        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Test avec PHPMails';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';

        $mail->send();

        return $this->render(
            'home/email.html.twig',
            [
                'controller_name' => 'envoi réussi',
            ],
        );
    }
}
