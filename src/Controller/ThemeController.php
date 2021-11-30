<?php

namespace App\Controller;

use App\Entity\Theme;
use App\Entity\ThemeMembre;
use App\Form\ThemeType;
use App\Repository\ThemeMemberRepository;
use App\Repository\ThemeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ThemeController extends AbstractController
{
    /**
     * @return Response
     * @Route ("/loggedIn/Themes",name="theme")
     */
    public function ShowTheme(EntityManagerInterface $em): Response
    {
        $votreList=[];
        $joinedList=[];
        $otherList=[];
        $user =$this->getUser();
        $gmail=$user->getUsername();
        $memberThemes=$em->getRepository(ThemeMembre::class)->findAll();
       foreach ($memberThemes as $m){
            $idtheme=$m->getIdTheme();
           $gmailInTheme =$m->getGmail();
           if($gmail==$gmailInTheme) {
               $VotrethemeSimple = $em->getRepository(Theme::class)->find($idtheme);
               array_push($votreList ,$VotrethemeSimple);
           }
           else
           {    $testExist=false ;
               $AutrethemeSimple = $em->getRepository(Theme::class)->find($idtheme);
               $visibilty=$AutrethemeSimple->getVisibilite();
               $participant=$AutrethemeSimple->getListDeParticipant();
               foreach ($participant as $par){
                   if($par==$gmail){
                       $testExist=true;
                   }
               }
               if( $testExist  ){
                   array_push($joinedList ,$AutrethemeSimple);
               }
               else{
                   if($visibilty && ($AutrethemeSimple->getNbrParticipant()) < ($AutrethemeSimple->getCapacite()+1)) {
                       array_push($otherList, $AutrethemeSimple);
                   }
               }
           }
       }
       return $this->render('theme/theme.html.twig',[
            'YourTheme'=>$votreList,
            'joinedTheme'=>$joinedList,
            'OtherTheme'=>$otherList
        ]);

    }

    /**
     * @Route("/loggedIn/AddTheme",name="addtheme",methods={"POST","GET"})
     */
public function AddTheme(EntityManagerInterface $em, Request $request)
{
    $theme =new Theme();
    $themeMember=new ThemeMembre();
    $user= $this->getUser();
    $mail=$user->getUsername();
    $form= $this->createForm(ThemeType::class,$theme);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()) {
        $file = $theme->getImage();
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        try{
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
        }catch (FileException $e){

        }
        $theme->setImage($fileName);
        if ($theme->getCapacite() < 4) {
            $theme->setCapacite(3);
        }
        $theme->setNbrParticipant(0);
        $theme->setListDeParticipant([]);
        $theme->setEmail($mail);
        $em->persist($theme);
        $em->flush();
        $themeRepo=$em->getRepository(Theme::class)->findAll();
        foreach ($themeRepo as $th) {
            if($th->getNomTheme()==$theme->getNomTheme()) {
                $themeMember->setIdTheme($th->getIdTheme());
                $themeMember->setGmail($mail);
                $em->persist($themeMember);
                $em->flush();
                return $this->redirectToRoute("theme");
            }
        }
            }
    return $this->render('theme/themeForm.html.twig',[
        'themeForm'=>$form->createView()
    ]);
}

    /**
     * @Route("/searchTheme", name="searchThemes")
     * @throws ExceptionInterface
     */
    public function searchTheme(Request $request,NormalizerInterface $Normalizer,ThemeRepository $rt): Response
    {
$requestString=$request->request->get('searchTheme');
$theme = $rt->findByNomTheme($requestString);
$jsonContent = $Normalizer->normalize($theme, 'json',['groups'=>'YourTheme']);
$retour=json_encode($jsonContent);
return new Response($retour);
}


    /**
     * @Route ("/JoinThemes/{idTheme}",name="joinTheme",methods={"POST","GET"})
     */
public function joinTheme(EntityManagerInterface $em,$idTheme): Response
{
    $user= $this->getUser();
    $mail=$user->getUsername();
    $theme=$em->getRepository(Theme::class)->find($idTheme);

    $list=$theme->getListDeParticipant();


     array_push( $list,$mail);
    $theme->setNbrParticipant(count($list));
    $theme->setListDeParticipant($list);
     $em->persist($theme);
     $em->flush();
     return $this->redirectToRoute("theme");



}

    /**
     * @Route ("/DeleteTheme/{idTheme}",name="DeleteTheme",methods={"POST","GET"})
     * @throws NonUniqueResultException
     */
    public function DeleteTheme(EntityManagerInterface $em,$idTheme,ThemeMemberRepository $tm): Response
    {
        $theme=$em->getRepository(Theme::class)->find($idTheme);
        $themeMember=$tm->findOneByIdTheme($idTheme);
        $em->remove($theme);
        $em->remove($themeMember);
        $em->flush();
        return $this->redirectToRoute("theme");



    }



















}
