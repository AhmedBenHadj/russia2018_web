<?php
/**
 * Created by PhpStorm.
 * User: elossofa
 * Date: 08/04/2018
 * Time: 20:26
 */

namespace ClientBundle\Repository;

use Doctrine\ORM\EntityRepository;

class EntraineurRepository extends EntityRepository
{
    public function findEntraineurs(){
        //$query = $this->getEntityManager()->createQuery("SELECT e FROM ClientBundle:Entraineur e JOIN ClientBundle:Equipe k WHERE e.id<>k.idEntraineur") ;
        //$query = $this->getEntityManager()->createQuery("SELECT e FROM ClientBundle:Entraineur e,ClientBundle:Equipe k WHERE e.id<>k.idEntraineur") ;
        $query = $this->createQueryBuilder('e')
            ->from('ClientBundle:Equipe','k')->where('e.id<>k.idEntraineur') ;
        return $query->getQuery()->getResult();
    }
}