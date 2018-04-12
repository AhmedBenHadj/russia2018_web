<?php
/**
 * Created by PhpStorm.
 * User: hseli
 * Date: 03/04/2018
 * Time: 01:41
 */

namespace ClientBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;

class EquipeRepository extends EntityRepository
{
    public function findByScore1($score){
        $query = $this->getEntityManager()->createQuery("SELECT e FROM ClientBundle:Equipe e JOIN ClientBundle:Match2018 m WITH e.id=m.idEquipe1 WHERE m.id=:id")->setParameter('id',$score->getId()) ;
        try {
            return $query->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }
    public function findByScore2($score){
        $query = $this->getEntityManager()->createQuery("SELECT e FROM ClientBundle:Equipe e JOIN ClientBundle:Match2018 m WITH e.id=m.idEquipe2 WHERE m.id=:id")->setParameter('id',$score->getId()) ;
        try {
            return $query->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }
    public function findEquipeQual($progress){
        $query=$this->getEntityManager()
            ->createQuery("select e from ClientBundle:Equipe e WHERE e.qualification='Qualifie' AND e.progress=:progress")
            ->setParameter('progress',$progress);
        return $query->getResult();

    }
    public function findEquipe_Par_Groupe($nomG){
        $query=$this->getEntityManager()
            ->createQuery("select e from ClientBundle:Equipe e JOIN ClientBundle:Groupe g WITH 
                                      e.idGroupe=g.id WHERE e.qualification='Qualifie' AND g.nom=:nom ORDER BY e.pts DESC ")
            ->setParameter('nom',$nomG);
        return $query->getResult();

    }
}