<?php

namespace App\Controller;

use App\Entity\User;
use App\Classe\Mail;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/signup", name="register")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $notification = null;

        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();

            $search_email = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());

            if(!$search_email){
                $password = $encoder->encodePassword($user, $user->getPassword());
                
                $user->setPassword($password);
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $content = "hello ".$user->getFirstname()."<br/>Welcome to fonyshop <br/> Lorem, ipsum dolor sit amet consectetur adipisicing elit. Vitae, temporibus.";
                $mail = new Mail();
                $mail->send($user->getEmail(), $user->getFirstname(), "Welcome to fonyshop", $content);

                $notification = "Your registration was successful. You can now log into your account";
            }else{
                $notification = "The email you entered already exists";
            }
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
