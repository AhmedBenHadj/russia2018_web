<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EvenementController extends Controller
{
    public function indexAction()
    {
        return $this->render('ClientBundle:Evenement:index.html.twig', array(
            // ...
        ));
    }


}
