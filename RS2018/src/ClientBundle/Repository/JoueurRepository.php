<?php
/**
 * Created by PhpStorm.
 * User: elossofa
 * Date: 03/04/2018
 * Time: 17:21
 */

namespace ClientBundle\Repository;


class JoueurRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByEvent($id){
        //$query = $this->getEntityManager()->createQuery("SELECT j FROM ClientBundle:JoueurParticipant j WHERE j.id=:id")->setParameter('id',$id) ;
        //$joueur_p = $this->findByJoueur_P($id);
        $query_1 = $this->getEntityManager()->createQuery("SELECT e FROM ClientBundle:Evenement e WHERE e.idJoueurParticipant=:id")->setParameter('id',$id);
        return $query_1->getResult();
    }
    public function findByJoueur_P($id){
        $query = $this->getEntityManager()->createQuery("SELECT j FROM ClientBundle:JoueurParticipant j WHERE j.id=:id")->setParameter('id',$id) ;
        return $query->getResult();
    }
    public function findJoueurDQL($texte){
        $query = $this->getEntityManager()->createQuery("SELECT j FROM ClientBundle:Joueur j WHERE j.nom LIKE :nom ")
            ->setParameter('nom',"%".$texte."%") ;
        return $query->getResult();
    }
}