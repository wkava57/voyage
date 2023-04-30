<?php

namespace App\Controller;


use App\Classe\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

//    *************************************************  PANIER  *******************************************************
    #[Route('/panier', name: 'app_cart')]
    public function index(Cart $cart): Response
    {
        $cartAll = [];
        foreach ($cart->get() as $id => $quantity) {
            $cartAll[] = [
                'product' => $this->entityManager->getRepository(Product::class)->findOneById($id),
                'quantity' => $quantity
            ];
        }

        return $this->render('cart/index.html.twig', [
            'cart' => $cartAll
        ]);
    }

//    ************************************************ ADD CART ********************************************************

    #[Route("/cart/add/{id<\d+>}", name: "add_cart")]
    //passer $id dans la function add => paramètre de ma route 'cart/add{$id}' afin de pouvoir l'exploiter
    public function add(Cart $cart,int $id): Response
    {
        //faire un cart add et donner l'id du panier et pour cela créer une function add dans la classe cart
        $cart->add($id);
//        return $this->render('cart/index.html.twig');
        return $this->redirectToRoute('app_cart');
    }

// **************************************************  REMOVE  *********************************************************

    #[Route('/cart/remove', name: 'remove_cart')]
        public function remove(Cart $cart): Response
    {
        $cart->remove();

        return $this->redirectToRoute('app_products');
    }
}