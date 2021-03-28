<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ResetPassword;
use App\Form\ResetPasswordType;
use App\Classe\Mail;
use App\Entity\User;

class ResetPasswordController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/reset/password", name="reset_password")
     */
    public function index(Request $request): Response
    {
        if ($this->getUser()){
            return $this->redirectToRoute('home');
        }

        if($request->get('email')){
            $user = $this->entityManager->getRepository(User::class)->findOneByEmail($request->get('email'));
            if($user){
                // 1 ; Save in database the reset password request with user, token and createdAt.
                $reset_password = new ResetPassword();
                $reset_password->setUser($user);
                $reset_password->setToken(uniqid());
                $reset_password->setCreatedAt(new \DateTime());
                $this->entityManager->persist($reset_password);
                $this->entityManager->flush();

                // 2 : Email the user with reset password link
                $url = $this->generateUrl('update_password', [
                    'token' => $reset_password->getToken()
                ]);

                $content = "Hello ".$user->getFirstname()."<br/>You asked to reset your password on the fonyshop site<br/>";
                $content .= "Please click the following link to <a href='".$url."'>update your password</a>.";

                $mail = new Mail();
                $mail->send($user->getEmail(), $user->getFirstname().' '.$user->getLastname(), 'Reset your password on fonyshop', $content);
                $this->addFlash('notice', 'You will receive an email in a few seconds with the procedure to reset your password');
            }else{
                $this->addFlash('notice', 'This email address is unknown');
            }
        }

        return $this->render('reset_password/index.html.twig');
    }

    /**
     * @Route("/reset/password/{token}", name="update_password")
     */
    public function update(Request $request, $token, UserPasswordEncoderInterface $encoder): Response
    {
        $reset_password = $this->entityManager->getRepository(ResetPassword::class)->findOneByToken($token);
        if(!$reset_password){
            return $this->redirectToRoute('reset_password');
        }

        // Check if createdAt = now - 3h
        $now = new \DateTime();
        // if($now > $reset_password->getCreatedAt()->modify('+ 3 hour')){
        //     $this->addFlash('notice', 'Your password request has expired. thank you for renewing it');
        //     return $this->redirectToRoute('reset_password');
        // }

        // Render a view with password and confirm your password
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $new_pwd = $form->get('new_password')->getData();
            $user = $reset_password->getUser();
            // Password encoding
            $password = $encoder->encodePassword($user, $new_pwd);
            $user->setPassword($password);

            // Flush fon DB
            $this->entityManager->flush();

            // Redirect user to login page
            $this->addFlash('notice', 'Your password has been updated.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('reset_password/update.html.twig', [
            'form' => $form->createView()
        ]);

    }
}
