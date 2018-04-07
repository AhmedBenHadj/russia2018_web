<?php

namespace ClientBundle\Controller;

use ClientBundle\ClientBundle;
use ClientBundle\Entity\FichePari;
use ClientBundle\Entity\Pari;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FichePariController extends Controller
{
    public function indexAction()
    {
        return $this->render('ClientBundle:FichePari:index.html.twig', array(
            // ...
        ));


    }

    public function AjouterAction(Request $request){
        $fp = new FichePari();

        if($request->isMethod('POST'))
        {  // dump($request);
           // die();
            //Récupération des valeurs à partir du formulaire
           if(isset($_POST['simple'])){



               foreach ($request->get('idmatch') as $k => $item) {
                   $em = $this->getDoctrine()->getManager();
                   $resultat = $request->get('sresultats')[$k];
                   $gain=$request->get('againsimple')[$k];
                   $mise=$request->get('amisesimple')[$k];
                   $cote=$request->get('cotes')[$k];
                   $fp = new FichePari();
                   $fp->setDate(new \DateTime('now'));
                   $fp->setEtat("Encours");
                   $fp->setType(0);
                   $fp->setIdUser($this->getUser());
                   $fp->setGain($gain);
                   $fp->setMisetotal($mise);
                   $fp->setCotetotal($cote);
                   $em->persist($fp);
                   $em->flush();
                   $p = new Pari();
                   $p->setGain($gain);
                   $p->setCote($cote);
                   $p->setIdFichePari($fp);
                   $p->setType(0);
                   $p->setEtat("Encours");
                   if ($resultat == "X") {
                       $p->setResultat("X");
                   } else if ($resultat == "1") {
                       $p->setResultat("un");
                   } else if ($resultat == "2") {
                       $p->setResultat("deux");
                   }
                   $p->setCote($cote);
                   $p->setType(0);
                   $p->setGain($gain);
                   $p->setMise($mise);
                   $match = $em->getRepository("ClientBundle:Match2018")->find($item);

                   $p->setIdMatch($match);
                   $p->setIdFichePari($fp);
                   $em->persist($p);
                   $em->flush();

               }
           }
           else if(isset($_POST['multiple'])) {
               $fp->setCotetotal($request->get('cote'));
               $fp->setDate(new \DateTime('now'));
               $fp->setEtat("Encours");
               $fp->setGain($request->get('gain'));
               $fp->setMisetotal($request->get('misetotal'));
               $fp->setType(1);
               $fp->setIdUser($this->getUser());
               //Ecriture du nouveau modèle
               $em = $this->getDoctrine()->getManager();
               $em->persist($fp);
               $em->flush();
               foreach ($request->get('idmatch') as $k => $item) {
                   $resultat = $request->get('sresultats')[$k];
                   $p = new Pari();
                   $p->setCote(0);
                   $p->setType(0);
                   $p->setGain(0);
                   $p->setEtat("Encours");
                   $p->setMise(0);
                   if ($resultat == "X") {
                       $p->setResultat("X");
                   } else if ($resultat == "1") {
                       $p->setResultat("un");
                   } else if ($resultat == "2") {
                       $p->setResultat("deux");
                   }
                   $match = $em->getRepository("ClientBundle:Match2018")->find($item);
                   $p->setIdMatch($match);
                   $p->setIdFichePari($fp);
                   $em->persist($p);
                   $em->flush();
               }
           }
        }

        return $this->redirectToRoute("indexPari");
    }





}
