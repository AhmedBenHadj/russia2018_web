<?php
/**
 * Created by PhpStorm.
 * User: hseli
 * Date: 11/04/2018
 * Time: 19:48
 */

namespace ClientBundle\Services;


use ClientBundle\Entity\Equipe;
use ClientBundle\Entity\Match2018;
use ClientBundle\Entity\Score;
use ClientBundle\Entity\Stade;

class DemiService
{
    protected $em;


    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function demi(){
        $matchs=$this->em->getRepository("ClientBundle:Match2018")->findQuartMatch();
        $e=new EquipeService();
        $m1=$e->Gagnant($matchs[0],$this->em);
        $m2=$e->Gagnant($matchs[1],$this->em);
        $m3=$e->Gagnant($matchs[2],$this->em);
        $m4=$e->Gagnant($matchs[3],$this->em);
        $this->update_qualificiation_et_progress($m1,'En_attente','demi_final');
        $this->update_qualificiation_et_progress($m2,'En_attente','demi_final');
        $this->update_qualificiation_et_progress($m3,'En_attente','demi_final');
        $this->update_qualificiation_et_progress($m4,'En_attente','demi_final');
        $stade1=$this->em->getRepository("ClientBundle:Stade")->find(7);
        $stade2=$this->em->getRepository("ClientBundle:Stade")->find(12);

        $this->ajouterMatch($m1,$m3,$stade2,new \DateTime("2018-07-10"),new \DateTime("21:00:00"),"Debut","demi_final");
        $this->ajouterMatch($m2,$m4,$stade1,new \DateTime("2018-07-11"),new \DateTime("21:00:00"),"Debut","demi_final");




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