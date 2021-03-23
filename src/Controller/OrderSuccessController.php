<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Order;
use App\Classe\Cart;

class OrderSuccessController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/order/thanks/{stripeSessionId}", name="order_success")
     */
    public function index(Cart $cart, $stripeSessionId): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);
        if(!$order || $order->getUser() !== $this->getUser()){
            return $this->redirectToRoute('home');
        }
        if(!$order->getIsPaid()){
            // Clear the cart
            $cart->remove();

            // Change order status
            $order->setIsPaid(1);
            $this->entityManager->flush();
            // Send confirm order mail to our client
        }
        return $this->render('order_success/index.html.twig', [
            'order' => $order
        ]);
    }
}
