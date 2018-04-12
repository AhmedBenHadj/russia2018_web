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
    public function findJPEquipe1($id){
        $query=$this->getEntityManager()
            ->createQuery("select jp from ClientBundle:Joueur j JOIN ClientBundle:JoueurParticipant jp WITH j.id=jp.idJoueur JOIN 
                              ClientBundle:Equipe eq WITH eq.id=j.idEquipe JOIN ClientBundle:Match2018 m WITH eq.id=m.idEquipe1  WHERE m.id=:id")
            ->setParameter('id',$id);
        return $query->getResult();
    }
    public function findJPEquipe2($id){
        $query=$this->getEntityManager()
            ->createQuery("select jp from ClientBundle:Joueur j JOIN ClientBundle:JoueurParticipant jp WITH j.id=jp.idJoueur JOIN 
                              ClientBundle:Equipe eq WITH eq.id=j.idEquipe JOIN ClientBundle:Match2018 m WITH eq.id=m.idEquipe2  WHERE m.id=:id")
            ->setParameter('id',$id);
        return $query->getResult();
    }
}