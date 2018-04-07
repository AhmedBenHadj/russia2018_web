<?php

namespace ClientBundle\Controller;

use ClientBundle\Entity\Publication;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GalleryController extends Controller
{
    public  function magalerieAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $galerie = $em->getRepository('ClientBundle:Publication')->findBy(['type'=>'galerie','idUser'=>$this->getUser()]);
        $tab=array();
        foreach ($galerie as $item) {
            if(substr($item->getLien(),0,4)!=="LIEN"){
                array_push($tab,$item);
            }
        }
        return $this->render('ClientBundle:Gallery:index.html.twig', array(
            'galeries'=>$tab,'videos'=>null
        ));
        return $this->render("@Client/Gallery/index.html.twig");
    }
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($request->isMethod("POST")){

            if(isset($_FILES['image'])&&$_FILES['image']['name']!=''){
                $file=$_FILES['image'];
                $filename=$file['name'];
                $filesize=$file['size'];
                $filetmp=$file['tmp_name'];
                $fileerror=$file['error'];
                $filetype=$file['type'];
                $fileExt=explode('.', $filename);
                $fileactualExt = strtolower(end($fileExt));
                $allowed = array('jpg','jpeg','png');
                if (!in_array($fileactualExt,$allowed))return;
                if($fileerror!==0)return;
                if($filesize>1000000)return;
                $publication= new Publication();
                $publication->setIdUser($this->getUser());
                $publication->setDateCreation(new \DateTime('now'));
                $publication->setLien("3asba");
                $publication->setDescription($request->get('description'));
                $publication->setTitre($request->get('titre'));
                $publication->setType('galerie');
                $publication->setLiked(0);
                $publication->setDisliked(0);
                $em->persist($publication);
                $em->flush();
                $filenewname="USER-".$this->getUser()->getId()."GALERIE".$publication->getId()."IMAGE-".$filename;
                $dest="../../PI/image/".$filenewname;
                move_uploaded_file($filetmp,$dest);
                $publication->setLien($filenewname);
                $em->persist($publication);
                $em->flush();
            }else{
                $videolien = $request->get("video");
                $description = $request->get("description");
                $titre = $request->get("titre");
                $publication = new Publication();
                $publication->setLien("LIEN:".$videolien);
                $publication->setDisliked(0);
                $publication->setLiked(0);
                $publication->setType('galerie');
                $publication->setTitre($titre);
                $publication->setDescription($description);
                $publication->setDateCreation(new \DateTime('now'));
                $publication->setIdUser($this->getUser());
                $em->persist($publication);
                $em->flush();
            }
        }

        $galerie = $em->getRepository('ClientBundle:Publication')->findBy(['type'=>'galerie']);
        $tab=array();
        foreach ($galerie as $item) {
            if(substr($item->getLien(),0,4)!=="LIEN"){
                array_push($tab,$item);
            }
        }
        $vid=array();
        foreach ($galerie as $item) {
            if(substr($item->getLien(),0,4)==="LIEN"){
                array_push($vid,$item);
            }
        }
        foreach ($vid as $item) {
            $a = substr($item->getLien(),strpos($item->getLien(),"embed")+6,strlen($item->getLien())-1);
            $a=strstr($a,'"',true);
            $item->setLien("https://www.youtube.com/watch?v=".$a);
        }
        return $this->render('ClientBundle:Gallery:index.html.twig', array(
            'galeries'=>$tab,'videos'=>$vid
        ));
    }

}
