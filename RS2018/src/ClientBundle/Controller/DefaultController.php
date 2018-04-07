<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {

        return $this->render('ClientBundle:Default:index.html.twig');
    }
    public function dashboardAction()
    {

        return $this->render('@Client/Default/dashboard.html.twig');
    }
}
