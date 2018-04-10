<?php
/**
 * Created by PhpStorm.
 * User: hseli
 * Date: 03/04/2018
 * Time: 01:41
 */

namespace ClientBundle\Repository;


use Doctrine\ORM\EntityRepository;

class EquipeRepository extends EntityRepository
{
    public function findByScore1($score){
        $query = $this->getEntityManager()->createQuery("SELECT e FROM ClientBundle:Equipe e WHERE e.id=(SELECT s.idEquipe1 FROM ClientBundle:Match2018 s WHERE s.id=:id)")->setParameter('id',$score->getId()) ;
        return $query->getResult();
    }
    public function findByScore2($score){
        $query = $this->getEntityManager()->createQuery("SELECT e FROM ClientBundle:Equipe e WHERE e.id=(SELECT s.idEquipe2 FROM ClientBundle:Match2018 s WHERE s.id=:id)")->setParameter('id',$score->getId()) ;
        return $query->getResult();
    }
}