<?php

namespace App\Controller;

use App\Entity\Theme;
use App\Entity\ThemeMembre;
use App\Entity\User;
use App\Form\ThemeType;
use App\Repository\ThemeMemberRepository;
use App\Repository\ThemeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route ("/JoinTheme/{idTheme}",name="joinThemes",methods={"POST","GET"})
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
    /**
     * @Route ("/LeaveTheme/{idTheme}",name="leaveTheme",methods={"POST","GET"})
     */
public function LeaveTheme($idTheme,EntityManagerInterface $em): \Symfony\Component\HttpFoundation\RedirectResponse
{
    $user= $this->getUser();
    $mail=$user->getUsername();
   $theme= $em->getRepository(Theme::class)->find($idTheme);
    $list=$theme->getListDeParticipant();
    $newlist=array_diff($list,array($mail));
    $theme->setNbrParticipant(count($newlist));
    $theme->setListDeParticipant($newlist);
    $em->persist($theme);
    $em->flush();
    return $this->redirectToRoute("theme");
}

    /**
     * @Route ("/loggedIn/Themes/yourTheme/{idTheme}",name="enterYourTheme",methods={"POST","GET"})
     * @throws NonUniqueResultException
     */
    public function AffichTheme(Request $request,$idTheme,EntityManagerInterface $em,UserRepository $u): Response
    {  $listUsers=[];
        $user= $this->getUser();
        $mail=$user->getUsername();
        $theme= $em->getRepository(Theme::class)->find($idTheme);
        $molaTheme=$u->findBygmail($mail);

            $listParticipe=$theme->getListDeParticipant();
            foreach ($listParticipe as $lp){
                array_push($listUsers,$u->findBygmail($lp));

            }


            $listMessage=$theme->getMessages();



            return $this->render('theme/YourThemechat.html.twig',[

                'theme'=>$theme,'molaTheme'=>$molaTheme,'listUser'=>$listUsers
            ]);
        }

    /**
     * @Route ("/loggedIn/Themes/joinTheme/{idTheme}",name="enterJoinedTheme",methods={"POST","GET"})
     */
        public function AffichJoinedTheme($idTheme,EntityManagerInterface $em,UserRepository $u): Response
        {
            $theme= $em->getRepository(Theme::class)->find($idTheme);
            $user=$u->findBygmail($theme->getEmail());
           $listUsers=[];
            $listParticipe=$theme->getListDeParticipant();
            foreach ($listParticipe as $lp){
                array_push($listUsers,$u->findBygmail($lp));

            }
            $listMessage=$theme->getMessages();


            return $this->render('theme/joinedThemeChat.html.twig',[
               'theme'=>$theme,'user'=>$user,'listUser'=>$listUsers

            ]);
        }

    /**
     * @Route ("/delete",name="kick",methods={"POST","GET"})
     */
    public function kickMember(UserRepository $u,ThemeRepository $t,EntityManagerInterface $em)
    {
        $idtheme=$_POST['idtheme'];
        $idUser=$_POST['idUser'];
        $user=$u->find($idUser);
        $emailUser=$user->getGmail();
        $theme=$t->find($idtheme);
        $list=$theme->getListDeParticipant();
        $newlist=array_diff($list,array($emailUser));
        $theme->setListDeParticipant($newlist) ;
        $theme->setNbrParticipant(count($newlist));
        $em->persist($theme);
        $em->flush();
        $azerty="ok";
           return new Response($azerty);
    }

    /**
     * @Route ("/changeVisibilite",name="visibilite",methods={"POST","GET"})
     */
    public function changeVisibilite(ThemeRepository $t,EntityManagerInterface $em){
        $idtheme=$_POST['idTheme'];
        $theme=$t->find($idtheme);
        $etat=$theme->getVisibilite();
        if($etat==true){
            $theme->setVisibilite(false);
        }
        else{
            $theme->setVisibilite(true);
        }
        $em->persist($theme);
        $em->flush();
        $retour="valider";
        return new Response($retour);

    }



















}
