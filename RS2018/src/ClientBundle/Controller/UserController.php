<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        $user = $this->getUser();
        $userManager = $this->get('fos_user.user_manager');
        $t=$userManager->findUsers();

        foreach ($t as $u){
            $u->addRole('ROLE_ADMIN');
            $userManager->updateUser($u);

        }
        return $this->render('ClientBundle:User:index.html.twig', array(
            // ...
        ));
    }

}
