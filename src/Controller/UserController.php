<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegistrationType;
use App\Service\UserService;
use Doctrine\DBAL\Exception\ServerException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    #[Route('/inscription', name:'app_registration')]
    public function registration(Request $req, UserService $service): Response
    {
        try
        {
            $user = new User();
            $registrationForm = $this->createForm(UserRegistrationType::class,$user);
            $registrationForm->handleRequest($req);

            if($registrationForm->isSubmitted() && $registrationForm->isValid())
            {
                if($service->registerUser($user))
                {
                    $this->addFlash('success', 'Bonjour !');
                    return $this->redirectToRoute('app_login', [
                        "email" => $user->getEmail()
                    ]);
                }
            }

        } catch (ServerException $e)
        {
            dd($e);
        }

        return $this->render('user/registration.html.twig',[
            "registerForm" => $registrationForm->createView(),

        ]);
    }

    #[Route('/user', name: 'app_user')]
    public function profile(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
