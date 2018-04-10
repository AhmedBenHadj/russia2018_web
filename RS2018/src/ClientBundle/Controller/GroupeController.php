<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GroupeController extends Controller
{
    public function indexAction()
    {
        $em=$this->getDoctrine()->getManager();
        $matchs=$em->getRepository("ClientBundle:Match2018")->findAll();
        $groupes=$em->getRepository("ClientBundle:Groupe")->findAll();
        $tab=array();
        $tabqual=array();
        $mat=array();
        $equipe=array();
        foreach ($groupes as $g){
            $id=$g->getId();
            array_push($equipe,$em->getRepository("ClientBundle:Groupe")->findEquipesQualParGroupe($id));
            $nom=$g->getNom();
            array_push($tabqual,array("equipe"=>$equipe,"nom"=>$nom));
            array_shift($equipe);
        }
        foreach ($groupes as $g){
                $id=$g->getId();
                array_push($mat,$em->getRepository("ClientBundle:Groupe")->findMatchsParGroupe($id));
                $nom=$g->getNom();
                array_push($tab,array("match"=>$mat,"nom"=>$nom));
                array_shift($mat);

            }



        return $this->render('ClientBundle:Groupe:index.html.twig', array(
            'tab'=>$tab,'matchs'=>$matchs,'tabqual'=>$tabqual // ...
        ));
    }
}
