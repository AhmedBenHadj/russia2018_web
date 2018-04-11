<?php

namespace ClientBundle\Controller;

use ClientBundle\Entity\Abonnement;
use ClientBundle\Entity\Joueur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class JoueurController extends Controller
{
    public function indexAction()
    {
        return $this->render('ClientBundle:Joueur:index.html.twig', array(
            // ...
        ));
    }
    public function infoAction($id){
        $em = $this->getDoctrine()->getManager();
        $abonnement=null;
        $joueur = $em->getRepository('ClientBundle:Joueur')->find($id);
        $joueur_P = $em->getRepository('ClientBundle:JoueurParticipant')->findOneBy(array('idJoueur'=>$joueur->getId()));
        if($this->getUser()!=null){
            $abonnement = $em->getRepository('ClientBundle:Abonnement')->findOneBy(array('idUser'=>$this->getUser()->getId(),
                'idJoueur'=>$joueur->getId()));
            $allabo = $em->getRepository('ClientBundle:Abonnement')->findBy(array('idJoueur'=>$joueur->getId()));
            $joueur->setRating(count($allabo));
        }
        if($joueur_P != null)
            $evenements = $em->getRepository('ClientBundle:Evenement')->findBy(array('idJoueurParticipant'=>$joueur_P->getId()));
        else
            $evenements = null;
        return $this->render('ClientBundle:Joueur:joueur_detail.html.twig',array('joueur'=>$joueur,'evenements'=>$evenements,'joueur_p'=>$joueur_P,'abonnements'=>$abonnement)) ;
    }
    public function AllAction(){
        $em = $this->getDoctrine()->getManager();
        $joueurs = $em->getRepository('ClientBundle:Joueur')->findAll();
        return $this->render('ClientBundle:Joueur:tout_les_joueurs.html.twig',array('joueurs'=>$joueurs)) ;
    }
    public function RechercheAjaxAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $joueurs = $em->getRepository('ClientBundle:Joueur')->findAll();
        $liste=null ;
        if ($this->getUser() != null) {
            foreach ($joueurs as $joueur){
                $abonnement = $em->getRepository('ClientBundle:Abonnement')->findOneBy(array('idUser' => $this->getUser()->getId(),
                    'idJoueur' => $joueur->getId()));
                if($abonnement!=null)
                    $liste[] = $joueur ;
            }
        }
        dump($request->isXmlHttpRequest());
        if($request->isXmlHttpRequest()){
            $serializer=new Serializer(array(new ObjectNormalizer()));
            if($request->get('recherche') != '')
                $joueurs = $em->getRepository('ClientBundle:Joueur')->findJoueurDQL($request->get('recherche'));
            $data = $serializer->normalize($joueurs);
            return new JsonResponse($data);
        }
        return $this->render('ClientBundle:Joueur:tout_les_joueurs.html.twig',array('joueurs'=>$joueurs,'abonnements'=>$liste));
    }
    public function ModifierJoueurAction(){
        $em = $this->getDoctrine()->getManager();
        $joueurs = $em->getRepository('ClientBundle:Joueur')->findAll();
        return $this->render('ClientBundle:Joueur:modifier_joueur.html.twig',array('joueurs'=>$joueurs));
    }
    public function ModifierJoueurIDAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $joueur = $em->getRepository('ClientBundle:Joueur')->find($id);
        if($request->isMethod('POST')){
            $joueur->setNom($request->get('nom')) ;
            $joueur->setPrenom($request->get('prenom'));
            $joueur->setAge($request->get('age'));
            $joueur->setClub($request->get('club'));
            $joueur->setNumero($request->get('numero'));
            if(isset($_FILES['image'])&&$_FILES['image']['name']!=''){
                $joueur->setImage('aaa');
                $file=$_FILES['image'];
                $filename=$file['name'];
                $filesize=$file['size'];
                $filetmp=$file['tmp_name'];
                $fileerror=$file['error'];
                $filetype=$file['type'];
                $fileExt=explode('.', $filename);
                $fileactualExt = strtolower(end($fileExt));
                $allowed = array('jpg','jpeg','png');
                $em->persist($joueur);
                $em->flush();
                $filenewname="USER-".$this->getUser()->getId()."JOUEUR".$joueur->getId()."IMAGE-".$filename;
                $dest="../../../../PI/image/".$filenewname;
                move_uploaded_file($filetmp,$dest);
                $joueur->setImage($filenewname);
            }
            $em->persist($joueur);
            $em->flush();
            return $this->redirectToRoute('modifier_joueur');
        }
        return $this->render('ClientBundle:Joueur:modifier_joueur_id.html.twig',array('joueur'=>$joueur));
    }
    public function UpdateAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $joueur = $em->getRepository('ClientBundle:Joueur')->find($id);
        if($request->isMethod('POST')){
            $joueur->setNom($request->get('nom')) ;
            $joueur->setPrenom($request->get('prenom'));
            $joueur->setAge($request->get('age'));
            $joueur->setClub($request->get('club'));
            $joueur->setNumero($request->get('numero'));
            if(isset($_FILES['image'])&&$_FILES['image']['name']!=''){
                $joueur->setImage('aaa');
                $file=$_FILES['image'];
                $filename=$file['name'];
                $filesize=$file['size'];
                $filetmp=$file['tmp_name'];
                $fileerror=$file['error'];
                $filetype=$file['type'];
                $fileExt=explode('.', $filename);
                $fileactualExt = strtolower(end($fileExt));
                $allowed = array('jpg','jpeg','png');
                $em->persist($joueur);
                $em->flush();
                $filenewname="USER-".$this->getUser()->getId()."GALERIE".$joueur->getId()."IMAGE-".$filename;
                $dest="../../PI/image/".$filenewname;
                move_uploaded_file($filetmp,$dest);
                $joueur->setImage($filenewname);
            }
            $em->persist($joueur);
            $em->flush();
            return $this->redirectToRoute('modifier_joueur');
        }
    }
    public function DeleteAction($id){
        $em = $this->getDoctrine()->getManager() ;
        $joueur = $em->getRepository('ClientBundle:Joueur')->find($id);
        $em->remove($joueur);
        $em->flush() ;
        return $this->redirectToRoute('modifier_joueur');
    }
    public function S_abonnerAction($id){
        if($this->getUser()!=null){
            $em = $this->getDoctrine()->getManager();
            $joueur = $em->getRepository('ClientBundle:Joueur')->find($id);
            $abonnement = $em->getRepository('ClientBundle:Abonnement')->findOneBy(array('idUser'=>$this->getUser()->getId(),
                'idJoueur'=>$joueur->getId()));
            if($abonnement == null){
                $abo = new Abonnement();
                $abo->setIdJoueur($joueur);
                $abo->setIdUser($this->getUser());
                $em->persist($abo);
                $em->flush();
            }
            else{
                $em->remove($abonnement);
                $em->flush();
            }
        }
        //return $this->redirect($this->container->get('router.request_context')->getBaseUrl());
        //return $this->render('ClientBundle:Abonnement:mes_joueurs.html.twig',array());
        return $this->redirectToRoute('Mes_abonnements');
    }

}
