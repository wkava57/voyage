<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAddressController extends AbstractController
{
    #[Route('/compte/adresses', name: 'app_account_address')]
    public function index(): Response
    {

        return $this->render('account_address/index.html.twig');
    }

//******************************************  ADD ADDRESSES  ***********************************************************

    #[Route('/compte/ajout_adresses', name: 'app_account_address_add')]
    public function add(): Response
    {

        return $this->render('account_address/index.html.twig');
    }


}
