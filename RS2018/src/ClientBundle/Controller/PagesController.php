<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PagesController extends Controller
{
    public function indexPagesAction()
    {
        return $this->render('ClientBundle:Pages:index_pages.html.twig', array(
            // ...
        ));
    }


}
