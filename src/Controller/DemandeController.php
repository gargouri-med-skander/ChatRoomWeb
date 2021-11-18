<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\Profil;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/demande")
 */
class DemandeController extends AbstractController
{

    /**
     * @Route("/", name="membrelist")
     */
    public function membreList(): Response
    {
        $user = $this->getDoctrine()
            ->getRepository(Profil::class)
            ->findAll();
        $userconnecter = $this->getDoctrine()
            ->getRepository(User::class)
            ->find(6);
        return $this->render('demande/membrelist.html.twig', [
            'controller_name' => 'DemandeController',
            'profil'=>$user,
            'userconne'=>$userconnecter
        ]);
    }

    /**
     * @Route("/new/{iduserconecter}/{idusermembre}", name="demande_new", methods={"GET","POST"})
     */
    public function new($iduserconecter,$idusermembre): Response
    {
        $demande = new Demande();
        $userconncter = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($iduserconecter);
        $usermembre = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($idusermembre);
        $user = $this->getDoctrine()
            ->getRepository(Profil::class)
            ->findAll();
        $userconnecter = $this->getDoctrine()
            ->getRepository(User::class)
            ->find(6);


            $entityManager = $this->getDoctrine()->getManager();
            $demande->setIdUser($userconncter);
            $demande->setIdMembre($usermembre);
            $entityManager->persist($demande);
            $entityManager->flush();

            return $this->redirectToRoute('membrelist', array('profil' => $user,'userconne'=>$userconnecter));



    }



}
