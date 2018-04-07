<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EquipeFantasyController extends Controller
{
    public function indexAction()
    {
        return $this->render('ClientBundle:EquipeFantasy:index.html.twig', array(
            // ...
        ));
    }

}
