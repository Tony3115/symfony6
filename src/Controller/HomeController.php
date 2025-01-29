<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
