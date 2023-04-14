<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $entityManger;

    public function  __construct(EntityManagerInterface $entityManager)
    {
//        mécanisme de l'injection dépendance rentrer dans le controller pour prendre l'entity manager
        $this->entityManger = $entityManager;
    }


    #[Route('/destinations', name: 'app_products')]
    public function index(): Response
    {
        $products = $this->entityManger->getRepository(Products::class)->findAll();

        return $this->render('product/index.html.twig',[
            'products' => $products
        ]);
    }

    #[Route('/destination/{slug}', name: 'app_product')]
    public function one($slug)
    {
        $product = $this->entityManger->getRepository(Products::class)->findOneBySlug($slug);


        if (!$product) {
            return $this->redirectToRoute('app_products');
        }

        return $this->render('product/one.html.twig',[
            'products' => $product
        ]);
    }

}
