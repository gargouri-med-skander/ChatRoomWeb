<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\Listami;
use App\Entity\Profil;
use App\Entity\User;
use Knp\Component\Pager\PaginatorInterface;
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
    public function membreList(Request $request, PaginatorInterface $paginator): Response
    {

        $donnees = $this->getDoctrine()
            ->getRepository(Profil::class)
            ->findAll();
        $user =$paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            1 // Nombre de résultats par page
        );
        $userconnecter = $this->getDoctrine()
            ->getRepository(User::class)
            ->find(7);
        $demande = $this->getDoctrine()
            ->getRepository(Demande::class)
            ->findBy(array('idUser'=>$userconnecter));

        return $this->render('demande/membrelist.html.twig', [
            'controller_name' => 'DemandeController',
            'profil'=>$user,
            'userconne'=>$userconnecter,
            'demande'=>$demande
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



    /**
     * @Route("/ListDemande", name="demande_index", methods={"GET"})
     */
    public function index(): Response
    {
        $userconncter = $this->getDoctrine()
            ->getRepository(User::class)
            ->find(7);
        $demande = $this->getDoctrine()
            ->getRepository(Demande::class)
            ->findBy(array('idUser'=>$userconncter));

        $profil = $this->getDoctrine()
            ->getRepository(Profil::class)
            ->findAll();

        return $this->render('demande/index.html.twig', [
            'demande' => $demande,
            'userconnecter'=>$userconncter,
            'profil'=>$profil,
        ]);
    }



    /**
     * @Route("/accepter/{idusermembre}/{idDemande}", name="accepter", methods={"GET","POST"})
     */
    public function accepter($idusermembre,$idDemande, \Swift_Mailer $mailer): Response
    {
        $amis = new Listami();
        $userconncter = $this->getDoctrine()
            ->getRepository(User::class)
            ->find(7);
        $usermembre = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($idusermembre);
        $demande = $this->getDoctrine()
            ->getRepository(Demande::class)
            ->find($idDemande);

        $entityManager = $this->getDoctrine()->getManager();
        $amis->setIdUser($userconncter);
        $amis->setIdAmi($usermembre);
        $entityManager->remove($demande);
        $message = (new \Swift_Message('Your Invitation est accepter'))
            ->setFrom('siwar.brahmi@esprit.tn')
            ->setTo($usermembre->getGmail())
            ->setBody(
                $this->renderView(
                    'profil/email.html.twig',
                    [ 'user' => $usermembre,]
                ),
                'text/html'
            )

            // you can remove the following code if you don't define a text version for your emails
            ->addPart(
                $this->renderView(
                // templates/emails/registration.txt.twig
                    'profil/email.html.twig',
                    [ 'user' => $usermembre,]
                ),
                'text/plain'
            )
        ;

        $mailer->send($message);

        $entityManager->persist($amis);
        $entityManager->flush();

        return $this->redirectToRoute('demande_index');



    }


    /**
     * @Route("/refuser/{idDemande}", name="refuser", methods={"GET","POST"})
     */
    public function refuser($idDemande): Response
    {

        $demande = $this->getDoctrine()
            ->getRepository(Demande::class)
            ->find($idDemande);

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($demande);

        $entityManager->flush();

        return $this->redirectToRoute('demande_index');



    }





}
