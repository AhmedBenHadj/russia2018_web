<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PariController extends Controller
{
    public function indexAction()
    {
        $em=$this->getDoctrine()->getManager();
        $match=$em->getRepository("ClientBundle:Match2018")->findAll();
        return $this->render('@Client/Pari/index.html.twig',array('matchs'=>$match));
    }
    public function AfficherAction()
    {

    }

    public function AjouterAction(){

    }
    public function historiqueAction(){

        $em=$this->getDoctrine()->getManager();

        $fpari=$em->getRepository("ClientBundle:FichePari")->findBy(array('idUser'=>$this->getUser()->getId()));
        $p=$em->getRepository('ClientBundle:Pari')->findBy(array('idFichePari'=>$fpari->getId()));
        $m=$em->getRepository('ClientBundle:Pari')->findBy(array('idMatch'=>$p->getIdMatch()));
        return $this->render('@Client/Pari/historique.html.twig',array('ficheparis'=>$fpari,'paris'=>$p,'matchs'=>$m));
    }

}
