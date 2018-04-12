<?php
/**
 * Created by PhpStorm.
 * User: hseli
 * Date: 10/04/2018
 * Time: 00:47
 */

namespace ClientBundle\Services;


use ClientBundle\Entity\Equipe;
use ClientBundle\Entity\Match2018;
use ClientBundle\Entity\Score;
use ClientBundle\Entity\Stade;

class TraitementPHF
{
    protected $em;


    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function traitement(){

        $equipesA=$this->em->getRepository("ClientBundle:Equipe")->findEquipe_Par_Groupe("A");
        $equipesB=$this->em->getRepository("ClientBundle:Equipe")->findEquipe_Par_Groupe("B");
        $equipesC=$this->em->getRepository("ClientBundle:Equipe")->findEquipe_Par_Groupe("C");
        $equipesD=$this->em->getRepository("ClientBundle:Equipe")->findEquipe_Par_Groupe("D");
        $equipesE=$this->em->getRepository("ClientBundle:Equipe")->findEquipe_Par_Groupe("E");
        $equipesF=$this->em->getRepository("ClientBundle:Equipe")->findEquipe_Par_Groupe("F");
        $equipesG=$this->em->getRepository("ClientBundle:Equipe")->findEquipe_Par_Groupe("G");
        $equipesH=$this->em->getRepository("ClientBundle:Equipe")->findEquipe_Par_Groupe("H");
        $stade1=$this->em->getRepository("ClientBundle:Stade")->find(1);
        $stade2=$this->em->getRepository("ClientBundle:Stade")->find(2);
        $stade3=$this->em->getRepository("ClientBundle:Stade")->find(3);
        $stade4=$this->em->getRepository("ClientBundle:Stade")->find(4);
        $stade5=$this->em->getRepository("ClientBundle:Stade")->find(5);
        $stade6=$this->em->getRepository("ClientBundle:Stade")->find(6);
        $stade7=$this->em->getRepository("ClientBundle:Stade")->find(7);
        $stade9=$this->em->getRepository("ClientBundle:Stade")->find(9);
        $stade12=$this->em->getRepository("ClientBundle:Stade")->find(12);

        $this->ajouterMatch($equipesA[0],$equipesB[1],$stade9,new \DateTime("2018-06-30"),new \DateTime("21:00:00"),"Debut","last_16");
        $this->ajouterMatch($equipesB[0],$equipesA[1],$stade7,new \DateTime("2018-06-01"),new \DateTime("17:00:00"),"Debut","last_16");
        $this->ajouterMatch($equipesC[0],$equipesD[1],$stade4,new \DateTime("2018-06-30"),new \DateTime("17:00:00"),"Debut","last_16");
        $this->ajouterMatch($equipesD[0],$equipesC[1],$stade12,new \DateTime("2018-07-01"),new \DateTime("17:00:00"),"Debut","last_16");
        $this->ajouterMatch($equipesE[0],$equipesF[1],$stade3,new \DateTime("2018-07-02"),new \DateTime("18:00:00"),"Debut","last_16");
        $this->ajouterMatch($equipesF[0],$equipesE[1],$stade5,new \DateTime("2018-07-03"),new \DateTime("17:00:00"),"Debut","last_16");
        $this->ajouterMatch($equipesG[0],$equipesH[1],$stade6,new \DateTime("2018-07-02"),new \DateTime("21:00:00"),"Debut","last_16");
        $this->ajouterMatch($equipesH[0],$equipesG[1],$stade7,new \DateTime("2018-07-03"),new \DateTime("21:00:00"),"Debut","last_16");
        $this->update_les_equipes();


    }

    /**
     * @param Equipe $equipe1
     * @param Equipe $equipe2
     * @param Stade $stade
     * @param \DateTime $dateTime
     * @param \DateTime $time
     * @param $etat
     * @param $progress
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function ajouterMatch(Equipe $equipe1, Equipe $equipe2, Stade $stade, \DateTime $dateTime, \DateTime $time, $etat, $progress){
        $match=new Match2018();
        $match->setIdEquipe1($equipe1);
        $match->setIdEquipe2($equipe2);
        $match->setIdStade($stade);
        $match->setDate($dateTime);
        $match->setTime($time);
        $match->setEtat($etat);
        $match->setType($progress);
        $this->em->persist($match);
        $this->em->flush();
        $score=new Score();
        $score->setId($match);
        $score->setA(0);
        $score->setB(0);
        $this->em->persist($score);
        $this->em->flush();

    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update_les_equipes(){
        $equipesA=$this->em->getRepository("ClientBundle:Equipe")->findEquipe_Par_Groupe("A");
        $equipesB=$this->em->getRepository("ClientBundle:Equipe")->findEquipe_Par_Groupe("B");
        $equipesC=$this->em->getRepository("ClientBundle:Equipe")->findEquipe_Par_Groupe("C");
        $equipesD=$this->em->getRepository("ClientBundle:Equipe")->findEquipe_Par_Groupe("D");
        $equipesE=$this->em->getRepository("ClientBundle:Equipe")->findEquipe_Par_Groupe("E");
        $equipesF=$this->em->getRepository("ClientBundle:Equipe")->findEquipe_Par_Groupe("F");
        $equipesG=$this->em->getRepository("ClientBundle:Equipe")->findEquipe_Par_Groupe("G");
        $equipesH=$this->em->getRepository("ClientBundle:Equipe")->findEquipe_Par_Groupe("H");
        $this->update_qualificiation_et_progress($equipesA[0],"En_attente","last_16");
        $this->update_qualificiation_et_progress($equipesA[1],"En_attente","last_16");
        $this->update_qualificiation_et_progress($equipesB[0],"En_attente","last_16");
        $this->update_qualificiation_et_progress($equipesB[1],"En_attente","last_16");
        $this->update_qualificiation_et_progress($equipesC[0],"En_attente","last_16");
        $this->update_qualificiation_et_progress($equipesC[1],"En_attente","last_16");
        $this->update_qualificiation_et_progress($equipesD[0],"En_attente","last_16");
        $this->update_qualificiation_et_progress($equipesD[1],"En_attente","last_16");
        $this->update_qualificiation_et_progress($equipesE[0],"En_attente","last_16");
        $this->update_qualificiation_et_progress($equipesE[1],"En_attente","last_16");
        $this->update_qualificiation_et_progress($equipesF[0],"En_attente","last_16");
        $this->update_qualificiation_et_progress($equipesF[1],"En_attente","last_16");
        $this->update_qualificiation_et_progress($equipesG[0],"En_attente","last_16");
        $this->update_qualificiation_et_progress($equipesG[1],"En_attente","last_16");
        $this->update_qualificiation_et_progress($equipesH[0],"En_attente","last_16");
        $this->update_qualificiation_et_progress($equipesH[1],"En_attente","last_16");


    }

    /**
     * @param Equipe $equipe
     * @param $quali
     * @param $progress
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update_qualificiation_et_progress(Equipe $equipe, $quali, $progress){
        $equipe->setProgress($progress);
        $equipe->setQualification($quali);
        $this->em->persist($equipe);
        $this->em->flush();
    }


}