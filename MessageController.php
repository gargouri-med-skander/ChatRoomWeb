<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use App\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @Route("/message")
 */
class MessageController extends AbstractController
{
    /**
     * @Route("/", name="message_index", methods={"GET"})
     */
    public function index()
    {
        $messages = $this->getDoctrine()
            ->getRepository(Message::class)
            ->findAll();
        $em=$this->getDoctrine()->getManager();
        $commande='SELECT u.nom,m.contenumessage,m.dateEnvoi,m.idMessage
              FROM App\Entity\User u INNER JOIN App\Entity\Message m with u.idUser=m.iduserrecever';


        $query=$em->createQuery($commande);
        $result = $query->getResult();

        return $this->render('message/index.html.twig', [
            'messages' => $messages,
            'users' => $result,
        ]);
    }

    /**
     * @Route("/new", name="message_new", methods={"GET","POST"})
     */
    public function new(Request $request)
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('message/new.html.twig', [
            'message' => $message,

            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idMessage}", name="message_show", methods={"GET"})
     */
    public function show(Message $message)
    {
        return $this->render('message/show.html.twig', [
            'message' => $message,
        ]);
    }

    /**
     * @Route("/{idMessage}/edit", name="message_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Message $message)
    {
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('message/edit.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/deletemessage/{idMessage}", name="message_delete")
     */
    public function deletem(int $idMessage): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $message = $entityManager->getRepository(Message::class)->find($idMessage);
        $entityManager->remove($message);
        $entityManager->flush();

        return $this->redirectToRoute("message_index");
    }
}
