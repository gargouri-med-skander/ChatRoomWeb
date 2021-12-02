<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\ForgetPassword;
use App\Entity\Membre;
use App\Entity\User;
use App\Form\ForgetType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    /**
     * @var mixed
     */
    /**
     * @Route("/login", name="app_login",methods={"POST","GET"})
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    /**
     * @Route ("/LoggedIn",name="logged",methods={"POST","GET"})
     */
    public function logedIn(): Response
    {$user=new User();
        $user = $this->getUser();
        $testrole=$user->getRoles();
        if(["ROLE_USER"]==$testrole) {
            return $this->render('base.html.twig', [
                'user' => $this->getUser(),
                'username' => ($this->getUser())->getUsername()
            ]);
        }
        return $this->render('admin.html.twig', [
            'user' => $this->getUser(),
            'username' => ($this->getUser())->getUsername()
        ]);
    }
    /**
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return RedirectResponse|Response
     * @Route ("/SignUp",name="signup",methods={"POST","GET"})
     * @throws \App\Security\verifyEmailException
     */
    function AddUser (EntityManagerInterface $em, Request $request)
    {//,UserPasswordEncoderInterface $encoder
        $this->addFlash('info','only for those who want to sign up as admin');
        $verifierEmail=new EmailVerifier();
        $user= new User();
        $admin =new Admin();
        $member=new Membre();
        $form= $this->createForm(RegistrationFormType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            if ($verifierEmail->check($user->getGmail())) {
                $role = $user->getRole();
                if ($role == "admin") {
                    $verification = $request->request->get('verifier');
                    if ($verification == "admin") {
                        //$hash=$encoder->encodePassword($user,$user->getPassword());
                        //$user->setPassword($hash);
                        $admin->setGmail(($user->getGmail()));
                        $admin->setNumPoste(-1);
                        $admin->setAdresse("");
                        $em->persist($admin);
                        $em->persist($user);
                        $em->flush();
                        return $this->redirectToRoute("app_login");
                    } else {
                        $this->addFlash('success', 'wrong verification you cant be admin !!');
                        return $this->render("signup/register.html.twig", [
                            'form' => $form->createView(),
                        ]);
                    }
                } else {
                    //$hash=$encoder->encodePassword($user,$user->getPassword());
                    //$user->setPassword($hash);
                    $member->setGmail(($user->getGmail()));
                    $member->setIdList(-1);
                    $member->setIdProfil(-1);
                    $em->persist($member);
                    $em->persist($user);
                    $em->flush();
                    return $this->redirectToRoute("app_login");
                }

            }
            else
            {
                $this->addFlash('success', 'THIS EMAIL DOSE NOT EXIST !!');

            }
        }

        return $this->render("signup/register.html.twig",[
            'form'=>$form->createView(),
        ]);
    }
    /**
     * @throws \Exception
     */
    public function sendMailCode(\Swift_Mailer $mailer,$emailChangePass): string
    {
        $r1 = random_int(0, 9);
        $r2 = random_int(0, 9);
        $r3 = random_int(0, 9);
        $r4 = random_int(0, 9);
        $code ="$r1$r2$r3$r4";
        $message =(new \Swift_Message('password change'))
            ->setFrom('chat.rooms2022@gmail.com')
            ->setTo($emailChangePass)
            ->setBody("votre code =$code");
        $mailer->send($message);
        return $code ;
    }
    /**
     * @param Request $request
     * @param UserRepository $userRepository
     * @return Response
     * @Route ("/ForgetPassword",name="forgetPasse",methods={"POST","GET"})
     * @throws \Exception
     */
    public function PasswordForget (EntityManagerInterface $em,Request $request, UserRepository $userRepository,\Swift_Mailer $mailer): Response
    {
        $recuperation=new ForgetPassword();
        $form= $this->createForm(ForgetType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $getEmail = $form->getData();
           $emailChangePass = $getEmail['email'];
            $recuperation->setGmail($emailChangePass);
            $test = false ;
            $emails = $userRepository->findAll();
            foreach ($emails as $x){
                $y =$x->getGmail();
                if($y==$emailChangePass){
                    $test = true ;
                }
            }
            if($test) {
               $code= $this->sendMailCode($mailer,$emailChangePass);
                $recuperation->setCode($code);
                $em->persist($recuperation);
                $em->flush();
                return $this->render("security/changePass.html.twig");
            }
            else{
                $this->addFlash('success','email not found !!');
            }
        }
        return $this->render("security/forgetPass.html.twig",[
                'formPass'=>$form->createView(),
                ]);
    }
    /**
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param UserRepository $userRepository
     * @return RedirectResponse|Response
     * @Route ("/changePass",name="change",methods={"POST","GET"})
     */
public function changePassword(EntityManagerInterface $em, Request $request, UserRepository $userRepository,\Swift_Mailer $mailer )
{//,UserPasswordEncoderInterface $encoder
    $recuperation = $em->getRepository(ForgetPassword::class)->findAll();
    $codeSaisie = $request->request->get('code');
    foreach ($recuperation as $rec) {
        $emailTest = $rec->getGmail();
        $codeTest = $rec->getCode();
        $emm= $this->getDoctrine()->getManager();
        $emm->remove($rec);
    }
    if ($codeSaisie == $codeTest) {
            $users = $userRepository->findAll();
            foreach ($users as $x) {
                $y = $x->getGmail();
                if ($y == $emailTest) {
                    $x->setPassword($request->request->get('newpass'));
                    //$hash=$encoder->encodePassword($x,$x->getPassword());
                   // $x->setPassword($hash);
                    $em->persist($x);
                    $em->flush();
                    $message =(new \Swift_Message('password changed !!'))
                  ->setFrom('chat.rooms2022@gmail.com')
                  ->setTo($emailTest)
                  ->setBody('your password changed !');
                  $mailer->send($message);
                    return $this->redirectToRoute("app_login");
                }
            }
        }
        else{
                 $this->addFlash('success', 'wrong code !!');
            }
        return $this->render("security/changePass.html.twig");
}









}
