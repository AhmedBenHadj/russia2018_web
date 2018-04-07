<?php
/**
 * Created by PhpStorm.
 * User: hseli
 * Date: 30/03/2018
 * Time: 02:06
 */

namespace ClientBundle\Repository;


use Doctrine\ORM\EntityRepository;

class GroupeRepository extends EntityRepository
{
    public function findMatchsParGroupe($id){
        $query=$this->getEntityManager()
            ->createQuery("select e from ClientBundle:Match2018 e WHERE e.idGroupe=:id")
            ->setParameter('id',$id);

        return $query->getResult();

    }
    public function findEquipesQualParGroupe($id){
        $query=$this->getEntityManager()
            ->createQuery("select e from ClientBundle:Equipe e JOIN ClientBundle:Groupe g WHERE  e.qualification='Qualifie'
                           AND g.id=:id")
            ->setParameter('id',$id);

        return $query->getResult();

    }

}