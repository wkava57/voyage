<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Product;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(Request $request)
    {
        $product = $this->entityManger->getRepository(Product::class)->findAll();

        $search = new Search();
//  appelé form avec une méthode $this injecte le nom de mon formulaire et passe en deuxième paramètre l'instence de ma class
// que je mets au dessus $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $product = $this->entityManger->getRepository(Product::class)->findWithSearch($search);

//            $search = $form->getData();
        }
//      passer à twig
        return $this->render('product/index.html.twig',[
            'products' => $product,
            'form' => $form->createView()
        ]);
    }



    #[Route('/destination/{slug}', name: 'app_product')]
//    la fonction show que j'ai renommé en one pour un product
    public function one($slug)
    {
        $product = $this->entityManger->getRepository(Product::class)->findOneBySlug($slug);


        if (!$product) {
            return $this->redirectToRoute('app_products');
        }

        return $this->render('product/one.html.twig',[
            'products' => $product
        ]);
    }

}
