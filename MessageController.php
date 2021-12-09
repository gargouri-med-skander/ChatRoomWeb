<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use \Twilio\Rest\Client;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/message")
 */
class MessageController extends AbstractController
{
    private $twilio;

    public function __construct(Client $twilio) {
        $this->twilio = $twilio;

    }
    /**
     * @Route("/", name="message_index")
     */
    public function index(Request $request,MessageRepository $repo)
    {
        $messages = $this->getDoctrine()
            ->getRepository(Message::class)
            ->findAll();
        $search = $request->query->get("search");


        $result = $repo->findAllWithSearch($search);
        /*$em=$this->getDoctrine()->getManager();
        $commande='SELECT u.nom,m.contenumessage,m.dateEnvoi,m.idMessage
              FROM App\Entity\User u INNER JOIN App\Entity\Message m with u.idUser=m.iduserrecever';


        $query=$em->createQuery($commande);
        $result = $query->getResult();*/

        return $this->render('message/index.html.twig', [
            'messages' => $messages,
            'users' => $result,
        ]);
    }
    /**
     * @Route("/tri", name="tri")
     */
    public function tri(Request $request,MessageRepository $repo)
    {
        $messages = $this->getDoctrine()
            ->getRepository(Message::class)
            ->findAll();



        $tri = $repo->triedecroissant();
        /*$em=$this->getDoctrine()->getManager();
        $commande='SELECT u.nom,m.contenumessage,m.dateEnvoi,m.idMessage
              FROM App\Entity\User u INNER JOIN App\Entity\Message m with u.idUser=m.iduserrecever';


        $query=$em->createQuery($commande);
        $result = $query->getResult();*/

        return $this->render('message/index.html.twig', [
            'messages' => $messages,
            'users' => $tri,
        ]);
    }
    /**
     * @Route("/new", name="message_new")
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
            $m = $this->twilio->messages->create(
                '+21695812880', // Send text to this number
                array(
                    'from' => '+13344630676', // My Twilio phone number
                    'body' => 'hello someone send you a message '
                )
            );
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
     * @Route("/{idMessage}/edit", name="message_edit")
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
    /**
     * @Route("/pdfMessage", name="message_pdf")
     */
    public function pdfGenerator(MessageRepository $repo)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $em=$this->getDoctrine()->getManager();
        $commande='SELECT u.nom,m.contenumessage,m.dateEnvoi,m.idMessage
              FROM App\Entity\User u INNER JOIN App\Entity\Message m with u.idUser=m.iduserrecever';


        $query=$em->createQuery($commande);
        $result = $query->getResult();
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $em = $this->getDoctrine();
        $tab = $result;

        // Retrieve the HTML generated in our twig file
        $html = $this->render('message/pdf.html.twig', [
            'users' => $tab,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }

}
