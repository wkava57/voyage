<?php

namespace App\Classe;


use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
        private  RequestStack $requestStack;



    public function __construct(RequestStack $requestStack)
        {
            $this->requestStack = $requestStack;
        }
// une fonction pour remplir mon panier
        public function add($id): void
        {
//            chercher la session cart s'il ne trouve renvoie un tableau que j'ai mis en deuxième paramètre
            $cart = $this->requestStack->getSession()->get('cart', []);
            if (!empty($cart[$id])) {
                $cart[$id]++;
            } else{
                $cart[$id] = 1;
            }
            $this->getSession()->set('cart', $cart);
//            une fois la condition d'opération effectué plus besoin de set le tableau
//            $this->getSession()->set('cart', [
//                'id' => $id,
//                'quantity' => 1
//            ]);


        }
//        une fonction pour vider mon panier
        public function remove()
        {
            return $this->getSession()->remove('cart');
        }

        public function get()
        {
            return $this->getSession()->get('cart');
        }

        private function getSession(): SessionInterface
        {
            return $this->requestStack->getSession();
        }




}