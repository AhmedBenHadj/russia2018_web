<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EntraineurController extends Controller
{
    public function indexAction()
    {
        return $this->render('ClientBundle:Entraineur:index.html.twig', array(
            // ...
        ));
    }

}
