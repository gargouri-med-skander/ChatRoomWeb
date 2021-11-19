<?php

namespace App\Controller;

use App\Entity\Reagir;
use App\Form\ReagirType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reagir")
 */
class ReagirController extends AbstractController
{
    /**
     * @Route("/", name="reagir_index", methods={"GET"})
     */
    public function index(): Response
    {
        $reagirs = $this->getDoctrine()
            ->getRepository(Reagir::class)
            ->findAll();

        return $this->render('reagir/index.html.twig', [
            'reagirs' => $reagirs,
        ]);
    }

    /**
     * @Route("/new", name="reagir_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reagir = new Reagir();
        $form = $this->createForm(ReagirType::class, $reagir);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reagir);
            $entityManager->flush();

            return $this->redirectToRoute('reagir_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reagir/new.html.twig', [
            'reagir' => $reagir,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/reagirnew/{id}", name="reagirnew", methods={"GET","POST"})
     */
    public function reagir(Request $request,$id): Response
    {
        $reagir = new Reagir($id,"like");

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reagir);
            $entityManager->flush();

            return $this->redirectToRoute('reagir_index', [], Response::HTTP_SEE_OTHER);


    }

    /**
     * @Route("/{id}", name="reagir_show", methods={"GET"})
     */
    public function show(Reagir $reagir): Response
    {
        return $this->render('reagir/show.html.twig', [
            'reagir' => $reagir,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reagir_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reagir $reagir): Response
    {
        $form = $this->createForm(ReagirType::class, $reagir);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reagir_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reagir/edit.html.twig', [
            'reagir' => $reagir,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reagir_delete", methods={"POST"})
     */
    public function delete(Request $request, Reagir $reagir): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reagir->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reagir);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reagir_index', [], Response::HTTP_SEE_OTHER);
    }
}
