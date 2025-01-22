<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/product/add', name: 'app_addproduct')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {

        //charger le form
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product); // équivalent à'ProductType'

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('app_product');
        }
        //primo rendu
        return $this->render('product/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
