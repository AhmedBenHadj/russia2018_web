<?php
/**
 * Created by PhpStorm.
 * User: elossofa
 * Date: 10/04/2018
 * Time: 12:36
 */

namespace ClientBundle\Services;


use ClientBundle\Entity\Equipe;
use ClientBundle\Entity\Match2018;

class EquipeService
{
    function cmp($a, $b)
    {
        //return strcmp($a->getPts, $b->getPts);
        return $a->getPts() < $b->getPts() ;
    }
    public function Gagnant(Match2018 $match,$em){
        //$em = $this->getDoctrine()->getManager();
        $S = $em->getRepository('ClientBundle:Score')->find($match->getId());
        if($S->getA() > $S->getB()){
            return $em->getRepository('ClientBundle:Equipe')->findByScore1($S) ;
        }
        else if($S->getA() < $S->getB()){
            return $em->getRepository('ClientBundle:Equipe')->findByScore2($S);
        }
        return null ;
    }
    public function ajouter_nb_pts(Equipe $equipe,$nb_pts,$em){
        //$em = $this->getDoctrine()->getManager();
        $somme = $equipe->getPts() + $nb_pts ;
        $equipe->setPts($somme);
        $em->persist($equipe) ;
        $em->flush();
    }
    public function update_points(Match2018 $match,$em){
        //$em = $this->getDoctrine()->getManager();
        $S = $em->getRepository('ClientBundle:Score')->find($match->getId());
        if($this->Gagnant($match,$em) == null){
            $this->ajouter_nb_pts($match->getIdEquipe1(),1,$em);
            $this->ajouter_nb_pts($match->getIdEquipe2(),1,$em);
        }
        else{
            $this->ajouter_nb_pts($this->Gagnant($match,$em),3,$em) ;
        }
        $this->update_match_joue($match->getIdEquipe1(),$em);
        $this->update_match_joue($match->getIdEquipe2(),$em);
        GroupeService::update_etat($em);
        $this->update_qualification_pool($match,$em);
    }
    public function update_qualification_pool(Match2018 $match,$em){

        if($match->getIdGroupe()->getEtat() == 'Finis'){
            //$em = $this->getDoctrine()->getManager();
            $equipes = $em->getRepository('ClientBundle:Equipe')->findBy(array('idGroupe'=>$match->getIdGroupe()));
            usort($equipes, array($this,"cmp"));
            dump($equipes);
            $this->update_qualificiation($equipes[0],'Qualifie',$em) ;
            $this->update_qualificiation($equipes[3],'Disqualifie',$em) ;
            $rencontre = $em->getRepository('ClientBundle:Match2018')->findOneBy(array('idEquipe1'=>$equipes[1]->getId(),
                'idEquipe2'=>$equipes[2]->getId()));
            if($rencontre == null){
                $rencontre = $em->getRepository('ClientBundle:Match2018')->findOneBy(array('idEquipe1'=>$equipes[2]->getId(),
                    'idEquipe2'=>$equipes[1]->getId()));
            }
            if($equipes[1]->getPts() == $equipes[2]->getPts()){
                if($this->Gagnant($rencontre,$em) == null){
                    if($this->nb_but_equipe($equipes[1],$em) > $this->nb_but_equipe($equipes[2],$em)){
                        $this->update_qualificiation($equipes[1],'Qualifie',$em);
                        $this->update_qualificiation($equipes[2],'Disqualifie',$em);
                    }
                    else if($this->nb_but_equipe($equipes[2],$em) > $this->nb_but_equipe($equipes[1],$em)){
                        $this->update_qualificiation($equipes[2],'Qualifie',$em);
                        $this->update_qualificiation($equipes[1],'Disqualifie',$em);
                    }
                    else{
                        $this->update_qualificiation($equipes[1],'Qualifie',$em);
                        $this->update_qualificiation($equipes[2],'Disqualifie',$em);
                    }
                }
                else if($this->Gagnant($rencontre,$em) == $equipes[1]){
                    $this->update_qualificiation($equipes[1],'Qualifie',$em);
                    $this->update_qualificiation($equipes[2],'Disqualifie',$em);
                }
                else if($this->Gagnant($rencontre,$em) == $equipes[1]){
                    $this->update_qualificiation($equipes[2],'Qualifie',$em);
                    $this->update_qualificiation($equipes[1],'Disqualifie',$em);
                }
            }
            else if($equipes[1]->getPts() > $equipes[2]->getPts()){
                $this->update_qualificiation($equipes[1],'Qualifie',$em);
                $this->update_qualificiation($equipes[2],'Disqualifie',$em);
            }
            else if($equipes[1]->getPts() < $equipes[2]->getPts()){
                $this->update_qualificiation($equipes[2],'Qualifie',$em);
                $this->update_qualificiation($equipes[1],'Disqualifie',$em);
            }
        }
    }
    public function update_match_joue(Equipe $equipe,$em){
        //$em = $this->getDoctrine()->getManager() ;
        $somme = $equipe->getNbMatchJoue() + 1  ;
        $equipe->setNbMatchJoue($somme);
        $em->persist($equipe);
        $em->flush();
    }
    public function update_qualificiation(Equipe $equipe,$quali,$em){
        //$em = $this->getDoctrine()->getManager() ;
        $equipe->setQualification($quali);
        $em->persist($equipe);
        $em->flush();
    }
    public function nb_but_equipe(Equipe $equipe,$em){
        //$em = $this->getDoctrine()->getManager();
        $somme = 0 ;
        $joueurs = $em->getRepository('ClientBundle:Joueur')->findBy(array('idEquipe'=>$equipe->getId()));
        foreach ($joueurs as $joueur){
            $joueur_p = $em->getRepository('ClientBundle:JoueurParticipant')->findOneBy(array('idJoueur'=>$joueur->getId()));
            if($joueur_p!=null) {
                $event = $em->getRepository('ClientBundle:Evenement')->findBy(array('idJoueurParticipant' => $joueur_p->getId()));
                foreach ($event as $e) {
                    if ($e->getBut() == 1)
                        $somme++;
                }
            }
        }
        return $somme ;
    }
}