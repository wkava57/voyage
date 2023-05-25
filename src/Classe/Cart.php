<?php

namespace App\Classe;


use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
//    ajouter les variable;
    private $entityManager;

    private  RequestStack $requestStack;
    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack)
        {
            $this->requestStack = $requestStack;
            $this->entityManager = $entityManager;

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
//récupérer
        public function get()
        {
            return $this->getSession()->get('cart');
        }

        private function getSession(): SessionInterface
        {
            return $this->requestStack->getSession();
        }

        public function delete(int $id)
        {
            //récupère le contenu du cart à partir de la session en utilisant l'objet $requestSack
            $cart = $this->requestStack->getSession()->get('cart', []);
        //j'enlève l'id du produit de ma session
            unset($cart[$id]);
            //et important pour régéner une nouvelle session
            return $this->getSession()->set('cart', $cart);
        }

        public function decrease($id)
        {
            //Vérifier si la quantité produit = 1
            $cart = $this->requestStack->getSession()->get('cart', []);
                if ($cart[$id] > 1) {
                    //retirer une quantité(-1)
                    $cart[$id]--;
                }else {
                    //supprimer le produit
                    unset($cart[$id]);
                }

            return $this->getSession()->set('cart', $cart);

        }
//*************************************************     getFull           *****************************************************

        public function getFull(): array
        {
            $cartAll = [];

        if ($this->get()) {
            foreach ($this->get() as $id => $quantity) {
                $product_object = $this->entityManager->getRepository(Product::class)->findOneById($id);

                if (!$product_object){
                    $this->delete($id);
                    continue;
                }
//                $cart est défini et il contient un élément composé de 2 clés
                $cartAll[] = [
                    'product' => $product_object,
                    'quantity' => $quantity
                ];
            }
        }
// return la variable une fois la fonction exécuté à cartController pour transmettre à twig
            return $cartAll;
        }

}