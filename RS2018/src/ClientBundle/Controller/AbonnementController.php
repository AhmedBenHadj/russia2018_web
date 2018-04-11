<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AbonnementController extends Controller
{
    public function MesAbonnementsAction(){
        $em = $this->getDoctrine()->getManager() ;
        $joueurs = $em->getRepository('ClientBundle:Joueur')->findAll();
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
        return $this->render('ClientBundle:Abonnement:mes_joueurs.html.twig',array('joueurs'=>$abonnements));
    }
}
