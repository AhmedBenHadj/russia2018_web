<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class JoueurParticipantController extends Controller
{
    public function indexAction()
    {
        return $this->render('ClientBundle:JoueurParticipant:index.html.twig', array(
            // ...
        ));
    }

}
