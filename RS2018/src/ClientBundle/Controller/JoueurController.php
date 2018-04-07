<?php

namespace ClientBundle\Controller;

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
        $joueur = $em->getRepository('ClientBundle:Joueur')->find($id);
        $joueur_P = $em->getRepository('ClientBundle:JoueurParticipant')->findOneBy(array('idJoueur'=>$joueur->getId()));
        if($joueur_P != null)
            $evenements = $em->getRepository('ClientBundle:Evenement')->findBy(array('idJoueurParticipant'=>$joueur_P->getId()));
        else
            $evenements = null;
        return $this->render('ClientBundle:Joueur:joueur_detail.html.twig',array('joueur'=>$joueur,'evenements'=>$evenements,'joueur_p'=>$joueur_P)) ;
    }
    public function AllAction(){
        $em = $this->getDoctrine()->getManager();
        $joueurs = $em->getRepository('ClientBundle:Joueur')->findAll();
        return $this->render('ClientBundle:Joueur:tout_les_joueurs.html.twig',array('joueurs'=>$joueurs)) ;
    }
    public function RechercheAjaxAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $joueurs = $em->getRepository('ClientBundle:Joueur')->findAll();
        if($request->isXmlHttpRequest()){
            $serializer=new Serializer(array(new ObjectNormalizer()));
            if($request->get('recherche') != '')
                $joueurs = $em->getRepository('ClientBundle:Joueur')->findJoueurDQL($request->get('recherche'));
            $data = $serializer->normalize($joueurs);
            return new JsonResponse($data);
        }
        return $this->render('ClientBundle:Joueur:tout_les_joueurs.html.twig',array('joueurs'=>$joueurs));
    }

}
