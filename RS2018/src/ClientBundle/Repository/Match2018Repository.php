<?php
/**
 * Created by PhpStorm.
 * User: hseli
 * Date: 20/03/2018
 * Time: 23:42
 */

namespace ClientBundle\Repository;


use ClientBundle\Entity\Match2018;
use Doctrine\Common\Persistence\PersistentObject;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query;
use http\Exception\BadMessageException;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class Match2018Repository extends EntityRepository
{
    public function findMatchs($id){
        $query=$this->getEntityManager()
            ->createQuery("select m from ClientBundle:Match2018 m WHERE m.id=:id")
            ->setParameter('id',$id);
        return $query->getResult();

    }
    public function findFirstMatch(){
        $query=$this->getEntityManager()
            ->createQuery("select m from ClientBundle:Match2018 m 
                   WHERE m.date>=CURRENT_DATE() AND m.etat='Debut'
                   ORDER BY m.date ASC ")->setMaxResults(1)->getResult();
        return $query;

    }
    public function findEquipe2($id_Equipe1){
        $query=$this->getEntityManager()
            ->createQuery("select m.idEquipe2 from ClientBundle:Match2018 m WHERE m.idEquipe1=:id_Equipe1")
            ->setParameter('id_Equipe1',$id_Equipe1);
        return $query->getResult();

    }
    public function findEquipe1(){
        $query=$this->getEntityManager()
            ->createQuery("select m.idEquipe1 from ClientBundle:Match2018 m ");
        return $query->getResult();

    }
    public function findMatchTermine(){
        $query=$this->getEntityManager()
            ->createQuery("select m from ClientBundle:Match2018 m WHERE m.etat='Termine'");
        return $query->getResult();
    }
    public function findMatchLast_16Termine(){
        $query=$this->getEntityManager()
            ->createQuery("select m from ClientBundle:Match2018 m WHERE m.etat='Termine' AND m.type='last_16'");
        return $query->getResult();
    }
    public function findlast_16Match(){
        $query=$this->getEntityManager()
            ->createQuery("select m from ClientBundle:Match2018 m WHERE m.type='last_16'");
        return $query->getResult();
    }
    public function findMatchQuartTermine(){
        $query=$this->getEntityManager()
            ->createQuery("select m from ClientBundle:Match2018 m WHERE m.etat='Termine' AND m.type='quart_final'");
        return $query->getResult();
    }
    public function findQuartMatch(){
        $query=$this->getEntityManager()
            ->createQuery("select m from ClientBundle:Match2018 m WHERE m.type='quart_final'");
        return $query->getResult();
    }
    public function findMatchDemiTermine(){
        $query=$this->getEntityManager()
            ->createQuery("select m from ClientBundle:Match2018 m WHERE m.etat='Termine' AND m.type='demi_final'");
        return $query->getResult();
    }
    public function findDemiMatch(){
        $query=$this->getEntityManager()
            ->createQuery("select m from ClientBundle:Match2018 m WHERE m.type='demi_final'");
        return $query->getResult();
    }
    public function findMatchFinalTermine(){
        $query=$this->getEntityManager()
            ->createQuery("select m from ClientBundle:Match2018 m WHERE m.etat='Termine' AND m.type='final'");
        return $query->getResult();
    }
    public function findFinalMatch(){
        $query=$this->getEntityManager()
            ->createQuery("select m from ClientBundle:Match2018 m WHERE m.type='final'");
        return $query->getResult();
    }
    public function findMatchDebut(){
        $query=$this->getEntityManager()
            ->createQuery("select m from ClientBundle:Match2018 m WHERE m.etat='Debut'");
        return $query->getResult();
    }
    public function findEquipe(){
        $query=$this
            ->createQueryBuilder("m")->orderBy('m.idEquipe1','ASC');
        return $query;

    }


}