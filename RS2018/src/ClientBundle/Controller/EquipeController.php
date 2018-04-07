<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
        $query = $em->createQuery($dql);
        $joueurs=$query->execute();
        $equipe = $em->getRepository('ClientBundle:Equipe')->find($id);
        return $this->render('ClientBundle:Equipe:equipe.html.twig',array('equipe'=>$equipe , 'joueurs'=>$joueurs));
    }

}
