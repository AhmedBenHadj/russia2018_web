<?php
/**
 * Created by PhpStorm.
 * User: elossofa
 * Date: 10/04/2018
 * Time: 12:37
 */

namespace ClientBundle\Services;


class GroupeService
{
    public static function update_etat($em){
        //$em = $this->getDoctrine()->getManager();
        $groupes = $em->getRepository('ClientBundle:Groupe')->findAll();
        foreach ($groupes as $groupe){
            $aux=0 ;
            $equipes = $em->getRepository('ClientBundle:Equipe')->findBy(array('idGroupe'=>$groupe->getId()));
            foreach ($equipes as $equipe){
                if($equipe->getNbMatchJoue() == 3)
                    $aux++;
            }
            if($aux == 4){
                $groupe->setEtat('Finis');
            }
        }
    }
}