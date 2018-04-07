<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StadeController extends Controller
{
    public function indexAction()
    {
        $em=$this->getDoctrine()->getManager();
        $stades=$em->getRepository("ClientBundle:Stade")->findAll();


        return $this->render('ClientBundle:Stade:index.html.twig', array(
            'stades'=>$stades// ...
        ));
    }

}
