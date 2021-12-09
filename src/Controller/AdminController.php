<?php

namespace App\Controller;

use App\Entity\BanList;
use App\Entity\Membre;
use App\Repository\BanListRepository;
use App\Repository\MemberRepository;
use App\Repository\ThemeMemberRepository;
use App\Repository\ThemeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route ("/loggedIn/MemberTabale",name="memberTable")
     */
    public function AffichMember(UserRepository $u,EntityManagerInterface $em){
        $MembersList=[];
        $MembersBanned=[];
        $users=$u->findAll();
        $banned=$em->getRepository(BanList::class)->findAll();
        foreach ($users as $user){
            if($user->getRole()=="membre"){
                array_push($MembersList,$user);
            }
        }
        foreach ($banned as $ban){
            array_push($MembersBanned,$ban);
        }
        return $this->render('Admin/MemberTable.html.twig',[
            'memberList'=>$MembersList,'banList'=>$MembersBanned
        ]);
    }

    /**
     * @Route ("/ban",name="ban",methods={"POST","GET"})
     * @throws NonUniqueResultException
     */
    public function Ban(UserRepository $u,ThemeRepository $t,ThemeMemberRepository $tm,EntityManagerInterface $em,MemberRepository $m): Response
    {
        $banned=new BanList();
        $idUser=$_POST['idUser'];
        $user=$u->find($idUser);
        $email=$user->getGmail();
        $themes=$t->findByGmailTheme($email);
        $themeMember=$tm->findByGmailThemeMember($email);
        $member=$m->findByGmail($email);
        $em->remove($member);
        foreach ($themes as $tt){
            $em->remove($tt);
        }
        foreach ($themeMember as $ttm){
            $em->remove($ttm);
        }
        $em->remove($user);
        $banned->setGmail($email);
        $em->persist($banned);
        $em->flush();
        $var="Banok";
        return new Response($var);
    }
    /**
     * @Route ("/remove",name="remove",methods={"POST","GET"})
     */
    public function RemoveFromBan(EntityManagerInterface $em,BanListRepository $bl): Response
    {
        $idBan=$_POST['idBan'];
      $emailBanned= $bl->findOneById( $idBan);
      $em->remove($emailBanned);
      $em->flush();
      $var="Removeok";
        return new Response($var);
    }

    /**
     * @Route ("/sendAlert",name="Alert",methods={"POST","GET"})
     */
    public function sendAlert(UserRepository $u,\Swift_Mailer $mailer){
        $idUser=$_POST['iduser'];
        $user=$u->find($idUser);
        $message =(new \Swift_Message('Warning!'))
            ->setFrom('chat.rooms2022@gmail.com')
            ->setTo($user->getGmail())
            ->setBody("THIS IS A WARNING EMAIL BEFORE THE ADMINISTRATOR BAN YOU!!!");
        $mailer->send($message);
        return new Response(0);
    }
    /**
     * @Route ("/loggedIn/ThemeTabale",name="ThemeTable",methods={"POST","GET"})
     */
    public function AffichTheme(ThemeRepository $t): Response
    {
$themes=$t->findAll();
return $this->render("Admin/ThemesTable.html.twig",[
   'ThemeList'=>$themes
]);
    }
    /**
     * @Route ("/showMessage",name="showMessage",methods={"POST","GET"})
     */
    public function ShowMessage(ThemeRepository $t)
    {
        $idTheme=$_POST['idtheme'];
        $theme=$t->find( $idTheme);
        $list=$theme->getMessages();
    if($list==null){
    $rep="";
    return new Response($rep);
    }
    else{
        $rep=implode("/n",$list);
    }
        return new Response($rep);
    }

    /**
     * @Route ("/DeleteTheme",name="delete",methods={"POST","GET"})
     */
    public function Delete(ThemeRepository $t,\Swift_Mailer $mailer,ThemeMemberRepository $tm,EntityManagerInterface $em){
        $idTheme=$_POST['idtheme'];
        $theme=$t->find( $idTheme);
        $email= $theme->getEmail();
        $themeMember=$tm->findOneByIdTheme($idTheme);
       $name=$theme->getNomTheme();
        $message =(new \Swift_Message('Theme'))
            ->setFrom('chat.rooms2022@gmail.com')
            ->setTo($email)
            ->setBody("Your Theme $name got deleted by the administrator after to many reports and some verification.. you may get banned next time");
        $mailer->send($message);
        $em->remove($theme);
        $em->remove( $themeMember);
        $em->flush();
        $rep="delete";
        return new Response($rep);
    }
    /**
     * @Route ("/loggedIn/AdminTabale",name="AdminTable",methods={"POST","GET"})
     */
    public function AffichAdmin(UserRepository $u){
       $userAuthentifier=$this->getUser();
       $email=$userAuthentifier->getUsername();
        $AdminList=[];
        $users=$u->findAll();
        foreach ($users as $user){
            if(($user->getRole()=="admin")&&($user->getGmail()!=$email)){
                array_push($AdminList,$user);
            }
        }
        return $this->render('Admin/AdminTable.html.twig',[
            'AdminList'=>$AdminList
        ]);
    }
    /**
     * @Route("/loggedIn/Contact",name="contact",methods={"POST","GET"})
     */
    public function AdminContact(): Response
    {
return $this->render('Admin/contact.html.twig');
    }

    /**
     * @Route ("/contact/sendEmail",name="sendEmailContact")
     */
    public function SendEmailContact(){

    }
    /*fonction t3mel filitrage f recherche au niveau mt3 email recever*/
}
