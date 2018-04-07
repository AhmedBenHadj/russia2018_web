<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CommentaireController extends Controller
{
    public function indexAction()
    {
        return $this->render('ClientBundle:Commentaire:index.html.twig', array(
            // ...
        ));
    }

}
