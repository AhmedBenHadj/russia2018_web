<?php
/**
 * Created by PhpStorm.
 * User: hseli
 * Date: 11/04/2018
 * Time: 20:13
 */

namespace ClientBundle\Services;


use ClientBundle\Entity\Equipe;
use ClientBundle\Entity\Match2018;
use ClientBundle\Entity\Score;
use ClientBundle\Entity\Stade;

class FinalService
{
    protected $em;


    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function finale(){
        $matchs=$this->em->getRepository("ClientBundle:Match2018")->findDemiMatch();
        $e=new EquipeService();
        $m1=$e->Gagnant($matchs[0],$this->em);
        $m2=$e->Gagnant($matchs[1],$this->em);
        /*$m3=$e->Perdant($matchs[0],$this->em);
        $m4=$e->Perdant($matchs[1],$this->em);*/
        $this->update_qualificiation_et_progress($m1,'En_attente','final_');
        $this->update_qualificiation_et_progress($m2,'En_attente','final_');
        /*$this->update_qualificiation_et_progress($m3,'En_attente','final');
        $this->update_qualificiation_et_progress($m4,'En_attente','final');*/
        $stade1=$this->em->getRepository("ClientBundle:Stade")->find(7);
        $stade2=$this->em->getRepository("ClientBundle:Stade")->find(12);

        $this->ajouterMatch($m1,$m2,$stade2,new \DateTime("2018-07-10"),new \DateTime("21:00:00"),"Debut","final");
        //$this->ajouterMatch($m3,$m4,$stade1,new \DateTime("2018-07-11"),new \DateTime("21:00:00"),"Debut","demi_final");




    }
    public function retournerEquipeGagnant(){
        $matchs=$this->em->getRepository("ClientBundle:Match2018")->findFinalMatch();
        $e=new EquipeService();
        $EG=$e->Gagnant($matchs[0],$this->em);
        return $EG;

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