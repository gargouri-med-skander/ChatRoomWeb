<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;

use Doctrine\DBAL\Types\DateType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use function PHPUnit\Framework\assertStringEndsWith;
use function PHPUnit\Framework\equalTo;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @return Response
     * @Route("/Signin" ,name="signin")
     */
    function showLogIn()
    {
        return $this->render('LogIn.html.twig');
    }

    /**
     * @return Response
     * @Route("/SignUpShow",name="signupShow")
     */
    function showSignUp()
    {
        return $this->render('user/formInscri.html.twig');
    }


    /**
     * @param Request $request
     *
     * @Route ("/SignUp",name="signup",methods={"POST","GET"})
     *
     */
    function AddUser (EntityManagerInterface $em, Request $request)
    {
        $user= new User();
        $form= $this->createForm(UserType::class,$user);
        $form->handleRequest($request);

        if(($form->isSubmitted()) && ($form->isValid())){
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute("signin");
        }
        return $this->render("user/formInscri.html.twig",array('form'=>$form->createView()));
    }





}
