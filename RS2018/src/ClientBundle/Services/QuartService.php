<?php
/**
 * Created by PhpStorm.
 * User: hseli
 * Date: 11/04/2018
 * Time: 09:39
 */

namespace ClientBundle\Services;


use ClientBundle\Entity\Equipe;
use ClientBundle\Entity\Match2018;
use ClientBundle\Entity\Score;
use ClientBundle\Entity\Stade;

class QuartService
{
    protected $em;


    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function quart(){
        $matchs=$this->em->getRepository("ClientBundle:Match2018")->findlast_16Match();
        $e=new EquipeService();
        $m1=$e->Gagnant($matchs[0],$this->em);
        $m2=$e->Gagnant($matchs[1],$this->em);
        $m3=$e->Gagnant($matchs[2],$this->em);
        $m4=$e->Gagnant($matchs[3],$this->em);
        $m5=$e->Gagnant($matchs[4],$this->em);
        $m6=$e->Gagnant($matchs[5],$this->em);
        $m7=$e->Gagnant($matchs[6],$this->em);
        $m8=$e->Gagnant($matchs[7],$this->em);
        $this->update_qualificiation_et_progress($m1,'En_attente','quart_final');
        $this->update_qualificiation_et_progress($m2,'En_attente','quart_final');
        $this->update_qualificiation_et_progress($m3,'En_attente','quart_final');
        $this->update_qualificiation_et_progress($m4,'En_attente','quart_final');
        $this->update_qualificiation_et_progress($m5,'En_attente','quart_final');
        $this->update_qualificiation_et_progress($m6,'En_attente','quart_final');
        $this->update_qualificiation_et_progress($m7,'En_attente','quart_final');
        $stade1=$this->em->getRepository("ClientBundle:Stade")->find(1);
        $stade2=$this->em->getRepository("ClientBundle:Stade")->find(2);
        $stade3=$this->em->getRepository("ClientBundle:Stade")->find(3);
        $stade4=$this->em->getRepository("ClientBundle:Stade")->find(4);
        $this->ajouterMatch($m1,$m3,$stade1,new \DateTime("2018-07-06"),new \DateTime("17:00:00"),"Debut","quart_final");
        $this->ajouterMatch($m2,$m4,$stade2,new \DateTime("2018-07-07"),new \DateTime("21:00:00"),"Debut","quart_final");
        $this->ajouterMatch($m5,$m7,$stade3,new \DateTime("2018-07-06"),new \DateTime("21:00:00"),"Debut","quart_final");
        $this->ajouterMatch($m6,$m8,$stade4,new \DateTime("2018-07-07"),new \DateTime("18:00:00"),"Debut","quart_final");



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

}