<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AddressType;
use App\Entity\Address;
use App\Classe\Cart;

class AccountAddressController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/account/address", name="account_address")
     */
    public function index(): Response
    {
        return $this->render('account/address.html.twig');
    }

    /**
     * @Route("/account/add-address", name="account_address_add")
     */
    public function add(Cart $cart, Request $request): Response
    { 
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $address->setUser($this->getUser());
            $this->entityManager->persist($address);
            $this->entityManager->flush();
            if($cart->get()){
                return $this->redirectToRoute('order');
            }else{
                return $this->redirectToRoute('account_address');
            }
        }

        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/account/edit-address/{id}", name="account_address_edit")
     */
    public function edit(Request $request, $id): Response
    { 
        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);

        if(!$address || $address->getUser() != $this->getUser()){
            return $this->redirectToRoute('account_address');
        }
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->entityManager->flush();
            return $this->redirectToRoute('account_address');
        }

        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/account/delete-address/{id}", name="account_address_delete")
     */
    public function delete(Request $request, $id): Response
    { 
        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);

        if($address && $address->getUser() == $this->getUser()){
            $this->entityManager->remove($address);
            $this->entityManager->flush();
        }
        return $this->redirectToRoute('account_address');
    }
}
