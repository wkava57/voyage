<?php

namespace App\Controller;

use App\Classe\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

//    *************************************************  PANIER  *******************************************************
    #[Route('/panier', name: 'app_cart')]
    public function index(Cart $cart): Response
    {

        return $this->render('cart/index.html.twig');
    }

//    ************************************************ ADD CART ********************************************************

    #[Route("/cart/add/{id}", name: "add_cart")]

    //passer $id dans la function add => paramètre de ma route 'cart/add{$id}' afin de pouvoir l'exploiter
    public function add(Cart $cart, $id): Response
    {
        //faire un cart add et donner l'id du panier et pour cela créer une function add dans la classe cart
        $cart->add($id);

        return $this->redirectToRoute('app_cart');
    }
}
// ***************************************************  REMOVE  ********************************************************

