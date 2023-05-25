<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAddressController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/compte/adresses', name: 'app_account_address')]
    public function index(): Response
    {

        return $this->render('account_address/index.html.twig');
    }

//******************************************  ADD ADDRESSES  ***********************************************************

    #[Route('/compte/ajouter-une-adresse', name: 'app_account_address_add')]
    public function add(Request $request): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());
            $this->entityManager->persist($address);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_account_address');
        }
//            dd($address);
        return $this->render('account_address/address_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

//******************************************  modifier adresse  ********************************************************
    #[Route('/compte/modifier-une-adresse/{id}', name: 'app_account_address_edit')]
    public function edit(Request $request, $id): Response
    {
        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);

        if (!$address || $address->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_account_address');
        }

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            return $this->redirectToRoute('app_account_address');
        }
//            dd($address);
        return $this->render('account_address/address_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

//***********************************************  Supprier adresse  ***************************************************
    #[Route('/compte/supprimer-une-adresse/{id}', name: 'app_account_address_delete')]
    public function delete($id): Response
    {
        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);

//        si l'adresse existe et que l'utilisateur concerné sinon je ne pourrais pas supprimer l'adresse
        if ($address && $address->getUser() == $this->getUser()) {
//            passer l'adresse à supprimer avec remove
            $this->entityManager->remove($address);
//            je valide
            $this->entityManager->flush();
        }
//        rediriger vers app account address soit la page en cours
        return $this->redirectToRoute('app_account_address');
    }


}
