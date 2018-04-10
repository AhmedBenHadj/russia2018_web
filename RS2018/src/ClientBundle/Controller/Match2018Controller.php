<?php

namespace ClientBundle\Controller;

use ClientBundle\Entity\Match2018;
use ClientBundle\Entity\Score;
use ClientBundle\Form\Match2018Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Match2018Controller extends Controller
{
    public function Gestion_MatchsAction(){

        $em=$this->getDoctrine()->getManager();
        $matchs=$em->getRepository("ClientBundle:Match2018")->findAll();
        return $this->render('ClientBundle:Match2018:Gestion_Matchs.html.twig', array(
           'matchs'=>$matchs // ...
        ));
    }
    public function ModifierMatchAction(Request $request,$id){
        $em=$this->getDoctrine()->getManager();
        $matchs=$em->getRepository("ClientBundle:Match2018")->find($id);
        $Form=$this->createForm(Match2018Type::class,$matchs);

        $Form->handleRequest($request);
        if($Form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($matchs);
            $em->flush();
        }
        if($matchs->getEtat() == 'Termine'){
            $ControllerEquipe = $this->get('update_point');
            $ControllerEquipe->update_points($matchs,$em);
        }
        return $this->render('ClientBundle:Match2018:modifier_matchs.html.twig', array(
             'Form'=>$Form->createView()// ...
        ));

    }

    public function matchDetailAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $match=$em->getRepository("ClientBundle:Match2018")->findMatchs($id);
        $evenement=$em->getRepository("ClientBundle:Evenement")->findEvenementsParIDMATCH($id);
        return $this->render('ClientBundle:Match2018:matchDetail.html.twig', array(
           'matchs1'=>$match , 'evenements'=>$evenement // ...
        ));
    }
    public function matchResultAction(){
        $em=$this->getDoctrine()->getManager();
        $matchs=$em->getRepository("ClientBundle:Match2018")->findAll();
        $dateActuelle=setlocale(LC_ALL,'fr_FR');
        $d=array($dateActuelle);
        $scores=array();
        $tab=array();
        $tabT=array();
        $scoresT=array();

        foreach ($matchs as $m){
            $score=$m->getId();
            array_push($scores,$em->getRepository("ClientBundle:Score")->findScoresParIDMATCH($score));
            //$matchs["score"]=$em->getRepository("ClientBundle:Score")->findScoresParIDMATCH($score);
            //array_push($scores,$em->getRepository("ClientBundle:Score")->findScoresParIDMATCH($score));
        }
        foreach ($matchs as $m){
            foreach ($scores as $s) {
                array_push($tab,array("match"=>$m,"a"=>$s[0]->getA(),"b"=>$s[0]->getB()));
                array_shift($scores);
                break;
            }
        }

        $matchsTermine=$em->getRepository("ClientBundle:Match2018")->findMatchTermine();
        foreach ($matchsTermine as $mt){
            $score=$mt->getId();
            array_push($scoresT,$em->getRepository("ClientBundle:Score")->findScoresParIDMATCH($score));

        }
        foreach ($matchsTermine as $mt){
            foreach ($scoresT as $s) {
                array_push($tabT,array("match"=>$mt,"a"=>$s[0]->getA(),"b"=>$s[0]->getB()));
                array_shift($scoresT);
                break;
            }
        }


        return $this->render('ClientBundle:Match2018:matchResult.html.twig', array(
            'tab'=>$tab,'matchT'=>$matchsTermine,'date'=>$d,'tabT'=>$tabT // ...
        ));


    }

    public function afficherToutAction(){
        $em=$this->getDoctrine()->getManager();
        $match=$em->getRepository("ClientBundle:Match2018")->findAll();
        $firstmatch=$em->getRepository("ClientBundle:Match2018")->findFirstMatch();
        $lastevents=$em->getRepository("ClientBundle:Evenement")->findDerniersEvenements();
        $annee = date('Y');

        $noel = mktime(18, 0, 0, 06, 14, $annee);

        if ($noel < time())
            $noel = mktime(18, 0, 0, 06, 14, ++$annee);

        $tps_restant = $noel - time();

        $i_restantes = $tps_restant / 60;
        $H_restantes = $i_restantes / 60;
        $d_restants = $H_restantes / 24;


        $s_restantes = floor($tps_restant % 60); // Secondes restantes
        $i_restantes = floor($i_restantes % 60); // Minutes restantes
        $H_restantes = floor($H_restantes % 24); // Heures restantes
        $d_restants = floor($d_restants); // Jours restants
        $tabD=array($d_restants);
        $tabI=array($i_restantes);
        $tabH=array($H_restantes);
        $tabS=array($s_restantes);


        return $this->render('@Client/Match2018/index.html.twig',
            array('matchs' => $match , 'firstmatch'=>$firstmatch,'s'=>$tabS,'i'=>$tabI,'H'=>$tabH,'d'=>$tabD,
                'evenements'=>$lastevents));
    }

}
