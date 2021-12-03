<?php

namespace App\Controller;

use App\Entity\Profil;
use App\Entity\User;
use App\Form\ProfilType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profil")
 */
class ProfilController extends AbstractController
{
    /**
     * @Route("/", name="profil_index", methods={"GET"})
     */
    public function index(): Response
    {
        $profils = $this->getDoctrine()
            ->getRepository(Profil::class)
            ->findAll();
            $user = $this->getDoctrine()
                ->getRepository(Profil::class)
                ->findOneBy([
                    'idUser' => 7,

                ]);
        $userconnecter = $this->getDoctrine()
            ->getRepository(User::class)
            ->find(7);

        return $this->render('profil/index.html.twig', [
            'profils' => $profils,
            'userconnecter'=>$userconnecter,
            'user'=>$user
        ]);
    }


    /**
     * @Route("/back", name="backform", methods={"GET"})
     */
    public function back(): Response
    {


        return $this->render('profil/index.html.twig', [
        ]);
    }


    /**
     * @Route("/new/{iduser}", name="profil_new", methods={"GET","POST"})
     */
    public function new(Request $request, $iduser): Response
    {
        $profil = new Profil();
        $form = $this->createForm(ProfilType::class, $profil);
        $form->handleRequest($request);
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($iduser);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $profil->setIdUser($user);
            $profil->getUploadFile();
            $profil->setNbrPublication(0);
            $entityManager->persist($profil);
            $entityManager->flush();

            return $this->redirectToRoute('profil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profil/new.html.twig', [
            'profil' => $profil,
            'form' => $form->createView(),
            'user'=>$user


        ]);
    }

    /**
       * @Route("/{idProfil}", name="profil_show", methods={"GET"})
     */
    public function show(Profil $profil): Response
    {
        return $this->render('profil/show.html.twig', [
            'profil' => $profil,
        ]);
    }

    /**
     * @Route("/edi/{idProfil}", name="profil_edit")
     */
    public function edit(Request $request, $idProfil)
    {
        $profil = $this->getDoctrine()
            ->getRepository(Profil::class)
            ->find($idProfil);
        $form = $this->createForm(ProfilType::class, $profil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $profil->getUploadFile();
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profil_index');
        }

        return $this->render('profil/edit.html.twig', [
            'profil' => $profil,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idProfil}", name="profil_delete", methods={"POST"})
     */
    public function delete(Request $request, Profil $profil): Response
    {
        if ($this->isCsrfTokenValid('delete'.$profil->getIdProfil(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($profil);
            $entityManager->flush();
        }

        return $this->redirectToRoute('profil_index', [], Response::HTTP_SEE_OTHER);
    }
}
