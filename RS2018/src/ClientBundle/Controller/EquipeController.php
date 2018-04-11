<?php

namespace ClientBundle\Controller;

use ClientBundle\Entity\Equipe;
use ClientBundle\Entity\Match2018;
use ClientBundle\Entity\Rating;
use ClientBundle\Form\RatingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EquipeController extends Controller
{
    public function indexAction()
    {
        return $this->render('ClientBundle:Equipe:index.html.twig', array(
            // ...
        ));
    }
    public function detail_equipeAction(){
        $em = $this->getDoctrine()->getManager();
        $equipes = $em->getRepository('ClientBundle:Equipe')->findAll();
        return $this->render('ClientBundle:Equipe:equipe_detail.html.twig',array('equipes'=>$equipes)) ;
    }
    public function equipeAction($id){
        $dql="SELECT a FROM ClientBundle:Joueur a WHERE a.idEquipe=".$id;
        $em = $this->getDoctrine()->getManager() ;
        $rating = new Rating();
        //$form = $this->createForm(RatingType::class,$rating);
        //$form->handleRequest($request);
        $query = $em->createQuery($dql);
        $joueurs=$query->execute();
        $equipe = $em->getRepository('ClientBundle:Equipe')->find($id);
        $abonnements=null ;
        if ($this->getUser() != null) {
            foreach ($joueurs as $joueur){
                $abonnement = $em->getRepository('ClientBundle:Abonnement')->findOneBy(array('idUser' => $this->getUser()->getId(),
                    'idJoueur' => $joueur->getId()));
                if($abonnement!=null) {
                    $abonnements[] = $joueur;
                }
                $allabo = $em->getRepository('ClientBundle:Abonnement')->findBy(array('idJoueur'=>$joueur->getId()));
                $joueur->setRating(count($allabo));
            }
        }
        return $this->render('ClientBundle:Equipe:equipe.html.twig',array('equipe'=>$equipe , 'joueurs'=>$joueurs,'abonnements'=>$abonnements));
    }
    public function GestionEquipeAction(){
        $em = $this->getDoctrine()->getManager();
        $equipes = $em->getRepository('ClientBundle:Equipe')->findAll();
        return $this->render('ClientBundle:Equipe:gestion_equipe.html.twig',array('equipes'=>$equipes));
    }
    public function ModifierEquipeIDAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $groupes= $em->getRepository('ClientBundle:Groupe')->findAll();
        $entraineurs = $em->getRepository('ClientBundle:Entraineur')->findAll();
        $equipes = $em->getRepository('ClientBundle:Equipe')->findAll() ;
        foreach($entraineurs as $en){
            $aux = true;
            foreach($equipes as $eq){
                if($eq->getIdEntraineur()->getId() == $en->getId()) {
                    $aux = false;
                    continue;
                }
            }
            if($aux)
                $tableau[]= $en ;
        }
        $equipe = $em->getRepository('ClientBundle:Equipe')->find($id);
        if($request->isMethod('POST')){
            $equipe->setNom($request->get('nom')) ;
            $equipe->setPts($request->get('points'));
            $equipe->setIdEntraineur($request->get('entraineur'));
            $equipe->setIdGroupe($request->get('groupe'));
            $equipe->setNbMatchJoue($request->get('match_joue'));
            $equipe->setProgress($request->get('progress'));
            $equipe->setQualification($request->get('qualification'));
            if(isset($_FILES['drapeau'])&&$_FILES['drapeau']['name']!=''){
                $equipe->setDrapeau('aaa');
                $file=$_FILES['drapeau'];
                $filename=$file['name'];
                $filesize=$file['size'];
                $filetmp=$file['tmp_name'];
                $fileerror=$file['error'];
                $filetype=$file['type'];
                $fileExt=explode('.', $filename);
                $fileactualExt = strtolower(end($fileExt));
                $allowed = array('jpg','jpeg','png');
                $em->persist($equipe);
                $em->flush();
                $filenewname="USER-".$this->getUser()->getId()."EQUIPE".$equipe->getId()."IMAGE-".$filename;
                $dest="../../../../PI/image/".$filenewname;
                move_uploaded_file($filetmp,$dest);
                $equipe->setDrapeau($filenewname);
            }
            if(isset($_FILES['maillot'])&&$_FILES['maillot']['name']!=''){
                $equipe->setMaillot('aaa');
                $file=$_FILES['maillot'];
                $filename=$file['name'];
                $filesize=$file['size'];
                $filetmp=$file['tmp_name'];
                $fileerror=$file['error'];
                $filetype=$file['type'];
                $fileExt=explode('.', $filename);
                $fileactualExt = strtolower(end($fileExt));
                $allowed = array('jpg','jpeg','png');
                $em->persist($equipe);
                $em->flush();
                $filenewname="USER-".$this->getUser()->getId()."EQUIPE".$equipe->getId()."IMAGE-".$filename;
                $dest="../../../../PI/image/".$filenewname;
                move_uploaded_file($filetmp,$dest);
                $equipe->setMaillot($filenewname);
            }
            $em->persist($equipe);
            $em->flush();
            return $this->redirectToRoute('gestion_equipe');
        }
        return $this->render('ClientBundle:Equipe:modifier_equipe.html.twig',array('equipe'=>$equipe,'entraineurs'=>$tableau,'groupes'=>$groupes));
    }
    public function DeleteAction($id){
        $em = $this->getDoctrine()->getManager() ;
        $equipe = $em->getRepository('ClientBundle:Equipe')->find($id);
        $em->remove($equipe);
        $em->flush() ;
        return $this->redirectToRoute('gestion_equipe');
    }
}
