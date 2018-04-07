<?php

namespace ClientBundle\Controller;

use ClientBundle\Entity\Publication;
use ClientBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TwitterAPIExchange;


class PublicationController extends Controller
{
    public function mesarticlesAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('ClientBundle:Publication')->findBy(['type'=>'article','idUser'=>$this->getUser()]);
        //paginator
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $articles, /* query NOT result */
        $request->query->getInt('page', 1),10);
        return $this->render('ClientBundle:Publication:index.html.twig', array(
            'pagination'=>$pagination
        ));

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
                $publication->setType('article');
                $publication->setLiked(0);
                $publication->setDisliked(0);
                $em->persist($publication);
                $em->flush();
                $filenewname="USER-".$this->getUser()->getId()."ARTICLE".$publication->getId()."IMAGE-".$filename;
                $dest="../../PI/image/".$filenewname;
                move_uploaded_file($filetmp,$dest);
                $publication->setLien($filenewname);
                $em->persist($publication);
                $em->flush();
            }
        }

        $settings = array(
            'oauth_access_token' => "942261509673111552-ehdzseK78MLzl2HGL3CIi6laXXjI6iu",
            'oauth_access_token_secret' => "Mwxc4Nbb7zgR0Zj7AR2InGBBXnJs9uXtyb982IaEV2PHw",
            'consumer_key' => "tJ36vad6eICClaqxiha6rCdi0",
            'consumer_secret' => "3yZopikINkAEP3WcVBXPcMWG8mh3K4r7n6qtWzuw1jeJuSBrB2"
        );
        $url = 'https://api.twitter.com/1.1/search/tweets.json';
        $getfield = '?q=#Russia2018&result_type=popular&include_entities=true';
        $requestMethod = 'GET';
        $twitter = new TwitterAPIExchange($settings);
        $t= $twitter->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest();
        $t=json_decode($t);
        $t=$t->statuses;

        $dql="SELECT a FROM ClientBundle:Publication a WHERE a.type='article' ORDER BY a.dateCreation DESC ";
        $query = $em->createQuery($dql);
        $articles=$query->execute();

        //$articles = $em->getRepository('ClientBundle:Publication')->findBy(['type'=>'article']);
        foreach ($t as $item) {
            $a = new Publication();

            $a->setDescription($item->text);
            $a->setDateCreation($item->created_at);
            $a->setLien(isset($item->entities->media[0]->media_url)?$item->entities->media[0]->media_url:null);
            $u=new User();
            $u->setUsername($item->user->screen_name);
            $u->setImage($item->user->profile_image_url);
            $u->setEmail("https://twitter.com/statuses/".$item->id_str);
            $a->setIdUser($u);
            array_push($articles,$a);
        }
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $articles, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('ClientBundle:Publication:index.html.twig', array(
            'pagination'=>$pagination
        ));
    }
    public function articleAction(Request $request,$id){
        $settings = array(
            'oauth_access_token' => "942261509673111552-ehdzseK78MLzl2HGL3CIi6laXXjI6iu",
            'oauth_access_token_secret' => "Mwxc4Nbb7zgR0Zj7AR2InGBBXnJs9uXtyb982IaEV2PHw",
            'consumer_key' => "tJ36vad6eICClaqxiha6rCdi0",
            'consumer_secret' => "3yZopikINkAEP3WcVBXPcMWG8mh3K4r7n6qtWzuw1jeJuSBrB2"
        );
        $url = 'https://api.twitter.com/1.1/search/tweets.json';
        $getfield = '?q=#Russia2018&result_type=popular&include_entities=true&count=3';
        $requestMethod = 'GET';
        $twitter = new TwitterAPIExchange($settings);
        $t= $twitter->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest();
        $t=json_decode($t);
        $t=$t->statuses;
        $tw=array();
        foreach ($t as $item) {
            $a = new Publication();

            $a->setDescription($item->text);
            $a->setDateCreation($item->created_at);
            $a->setLien(isset($item->entities->media[0]->media_url)?$item->entities->media[0]->media_url:null);
            $u=new User();
            $u->setUsername($item->user->screen_name);
            $u->setImage($item->user->profile_image_url);
            $u->setEmail("https://twitter.com/statuses/".$item->id_str);
            $a->setIdUser($u);
            array_push($tw,$a);
        }
        $dql   = "SELECT a FROM ClientBundle:Publication a WHERE a.type='article' ORDER BY a.dateCreation DESC ";
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery($dql);
        $r=$query->execute();
        $article = $em->getRepository('ClientBundle:Publication')->find($id);
        $pre=null;
        $next=null;
        foreach ($r as $key=>$value){
            if($value->getID()===$article->getId()){
                if($key==0){
                    $pre=null;
                    $next=$r[$key+1];
                }elseif ($key == count($r)-1){
                    $pre=$r[$key-1];
                    $next=null;
                }else{
                    $pre=$r[$key-1];
                    $next=$r[$key+1];
                }
                break;
            }
        }

        //comment
        $comments = $em->getRepository('ClientBundle:Commentaire')->findBy(['idPublication'=>$id]);

        return $this->render('ClientBundle:Publication:article.html.twig',
            array('article'=>$article,'pre'=>$pre,'next'=>$next,'tw'=>$tw,'comments'=>$comments));
    }

}
