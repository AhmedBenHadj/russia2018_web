<?php

namespace ClientBundle\Controller;

use ClientBundle\Entity\Entraineur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EntraineurController extends Controller
{
    public function AllAction(){
        $em = $this->getDoctrine()->getManager();
        $entraineurs = $em->getRepository('ClientBundle:Entraineur')->findAll();
        $equipes = $em->getRepository('ClientBundle:Equipe')->findAll();
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
        return $this->render('ClientBundle:Entraineur:gestion_entraineur.html.twig',array('entraineurs'=>$entraineurs,'tableau'=>$tableau)) ;
    }
    public function ModifierEntraineurIDAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $entraineur = $em->getRepository('ClientBundle:Entraineur')->find($id);
        if($request->isMethod('POST')){
            $entraineur->setNom($request->get('nom')) ;
            $entraineur->setPrenom($request->get('prenom'));
            $entraineur->setDescription($request->get('description'));
            $em->persist($entraineur);
            $em->flush();
            return $this->redirectToRoute('Gestion_entraineur');
        }
        return $this->render('ClientBundle:Entraineur:modifier_entraineur.html.twig',array('entraineur'=>$entraineur));
    }
    public function AjoutEntraineurAction(Request $request){
        $entraineur = new Entraineur();
        $em = $this->getDoctrine()->getManager();
        if($request->isMethod('POST')){
            $entraineur->setNom($request->get('nom')) ;
            $entraineur->setPrenom($request->get('prenom'));
            $entraineur->setDescription($request->get('description'));
            $em->persist($entraineur);
            $em->flush();
            return $this->redirectToRoute('Gestion_entraineur');
        }
        return $this->render('ClientBundle:Entraineur:ajout_entraineur.html.twig',array());
    }
    public function DeleteAction($id){
        $em = $this->getDoctrine()->getManager() ;
        $entraineur = $em->getRepository('ClientBundle:Entraineur')->find($id);
        $em->remove($entraineur);
        $em->flush() ;
        return $this->redirectToRoute('Gestion_entraineur');
    }
}
