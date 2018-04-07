<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class JoueurFantasyController extends Controller
{
    public function indexAction()
    {
        return $this->render('ClientBundle:JoueurFantasy:index.html.twig', array(
            // ...
        ));
    }

}
