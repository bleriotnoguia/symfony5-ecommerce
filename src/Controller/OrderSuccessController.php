<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Order;
use App\Classe\Cart;
use App\Classe\Mail;

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
            $content = "hello ".$order->getUser()->getFirstname()."<br/>Thank for you order<br/>Lorem ipsum dolor sit amet. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Vitae, temporibus.";
            $mail = new Mail();
            $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), "Your order on fonyshop has been validated", $content);
        }
        return $this->render('order_success/index.html.twig', [
            'order' => $order
        ]);
    }
}