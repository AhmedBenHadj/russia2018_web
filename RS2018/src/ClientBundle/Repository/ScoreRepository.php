<?php
/**
 * Created by PhpStorm.
 * User: hseli
 * Date: 24/03/2018
 * Time: 15:40
 */

namespace ClientBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;

class ScoreRepository extends EntityRepository
{
    public function findScoresParIDMATCH($id){
        $query=$this->getEntityManager()
            ->createQuery("select s from ClientBundle:Score s  WHERE s.id=:id ")
            ->setParameter('id',$id);


            return $query->getResult();


    }

}