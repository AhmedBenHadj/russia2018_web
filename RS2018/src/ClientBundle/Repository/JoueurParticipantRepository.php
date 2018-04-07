<?php
/**
 * Created by PhpStorm.
 * User: elossofa
 * Date: 03/04/2018
 * Time: 17:44
 */

namespace ClientBundle\Repository;


class JoueurParticipantRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByJoueur_P($id){
        $query = $this->getEntityManager()->createQuery("SELECT j FROM ClientBundle:JoueurParticipant j WHERE j.id=:id")->setParameter('id',$id) ;
        return $query->getResult();
    }
}