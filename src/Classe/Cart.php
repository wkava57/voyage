<?php

namespace App\Classe;


use Symfony\Component\HttpFoundation\Session\SessionInterface;


class Cart
{
    // créer une variable session pour obtenir la sessionInterface au sein de ma classe
    private $session;

    //ensuite la construire, dès que ma classe sera appelé la function constructeur va être initialiser et lui injecter SessionInterface et lui donner la variable session
    //utiliser la sessionInterface dans la function add et injecter la variable id dans la session
    public function __construct(SessionInterface $session)
    {
//        pour que cela soit accessible
        $this->session = $session;

    }
    public function add($id): void
    {
        //set une session nommé cart tu lui associes un tableau avec tous les produits de mon panier ou je trouve l'id produit et quantité
        $this->session->set('cart', [
            [
                'id' => $id,
                'quantity' => 1
            ]
        ]);
    }

    public function  get()
    {
        return $this->session->get('cart');
    }
}

