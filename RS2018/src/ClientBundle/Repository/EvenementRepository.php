<?php
/**
 * Created by PhpStorm.
 * User: elossofa
 * Date: 03/04/2018
 * Time: 17:44
 */

namespace ClientBundle\Repository;


class EvenementRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByEvent($id){
        $query_1 = $this->getEntityManager()->createQuery("SELECT e FROM ClientBundle:Evenement e WHERE e.idJoueurParticipant=:id")->setParameter('id',$id);
        return $query_1->getResult();
    }
    public function findEvenementsParIDMATCH($id){
        $query=$this->getEntityManager()
            ->createQuery("select e from ClientBundle:Evenement e WHERE e.idMatch=:id")
            ->setParameter('id',$id);
        return $query->getResult();

    }
    public function findDerniersEvenements(){
        $query=$this->getEntityManager()
            ->createQuery("select e from ClientBundle:Evenement e WHERE e.but=1 ORDER BY e.id DESC")->setMaxResults(4);
        return $query->getResult();

    }
}