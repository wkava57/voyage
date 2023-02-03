<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountForgetPasswordController extends AbstractController
{
    #[Route('/account/forget/password', name: 'app_account_forget_password')]
    public function index(): Response
    {
        return $this->render('account_forget_password/index.html.twig', [
            'controller_name' => 'AccountForgetPasswordController',
        ]);
    }
}
