<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AbonnementController extends Controller
{
    public function indexAction()
    {
        return $this->render('ClientBundle:Abonnement:index.html.twig', array(
            // ...
        ));
    }
}
