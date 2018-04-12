<?php

namespace ClientBundle\Controller;

use ClientBundle\Entity\Evenement;
use ClientBundle\Entity\Match2018;
use ClientBundle\Entity\Score;
use ClientBundle\Form\EvenementType;
use ClientBundle\Form\Match2018Type;
use ICal\ICal;
use Jsvrcek\ICS\Model\Calendar;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;
use Welp\IcalBundle\Response\CalendarResponse;
use Welp\IcalBundle\WelpIcalBundle;




class Match2018Controller extends Controller
{
    public function indexAction()
    {
        return $this->render('ClientBundle:Match2018:index.html.twig', array(
            // ...
        ));
    }
    public function Gestion_MatchsAction(){

        $em=$this->getDoctrine()->getManager();
        $matchs=$em->getRepository("ClientBundle:Match2018")->findMatchDebut();
        return $this->render('ClientBundle:Match2018:Gestion_Matchs.html.twig', array(
            'matchs'=>$matchs // ...
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @return Response
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function ModifierMatchAction(Request $request, $id){
        $em=$this->getDoctrine()->getManager();
        $matchs=$em->getRepository("ClientBundle:Match2018")->find($id);
        $Form=$this->createForm(Match2018Type::class,$matchs);
        $Form->handleRequest($request);
        if($Form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($matchs);
            $em->flush();
        }
        if($matchs->getEtat() == 'Termine' && $matchs->getType()=='pool'){
            $ControllerEquipe = $this->get('update_point');
            $ControllerEquipe->update_points($matchs,$em);
        }
        $matchss=$em->getRepository("ClientBundle:Match2018")->findAll();
        $groupes=$em->getRepository("ClientBundle:Groupe")->findAll();
        if($groupes[0]->getEtat()=="Finis" && $groupes[1]->getEtat()=="Finis"
            && $groupes[2]->getEtat()=="Finis" && $groupes[3]->getEtat()=="Finis"
            && $groupes[4]->getEtat()=="Finis" && $groupes[5]->getEtat()=="Finis" &&
            $groupes[5]->getEtat()=="Finis" && $groupes[6]->getEtat()=="Finis" &&
            $groupes[7]->getEtat()=="Finis"){
            $b=true;
            foreach ($matchss as $m){
                if($m->getType()=="last_16"){
                    $b=false;
                }
            }
            if($b){
                $huit=$this->get('traitement');
                $huit->traitement();
            }
        }else{
            echo "Les groupes ne sont pas encore terminé";
        }
        $matchlast16=$em->getRepository("ClientBundle:Match2018")->findlast_16Match();
        if(empty($matchlast16)){
            echo "pas de quart de finale si il n'ya pas de huitieme de finale";
        }else{
            if($matchlast16[0]->getEtat()=="Termine" && $matchlast16[1]->getEtat()=="Termine" && $matchlast16[2]->getEtat()=="Termine"
                && $matchlast16[3]->getEtat()=="Termine" && $matchlast16[4]->getEtat()=="Termine"
                && $matchlast16[5]->getEtat()=="Termine" && $matchlast16[6]->getEtat()=="Termine" && $matchlast16[7]->getEtat()=="Termine")
            {
                $p=true;
                foreach ($matchss as $m){
                    if($m->getType()=="quart_final"){
                        $p=false;
                    }
                }
                if($p){
                    $quart=$this->get('quart');
                    $quart->quart();
                }
            }else{
                echo "Les matchs de huitieme de finale ne sont pas encore termine";
            }
        }
        $matchquart=$em->getRepository("ClientBundle:Match2018")->findQuartMatch();
        if(empty($matchquart)){
            echo "pas de matchs quart finale";
        }else{
            if($matchquart[0]->getEtat()=="Termine" && $matchquart[1]->getEtat()=="Termine" && $matchquart[2]->getEtat()=="Termine"
                && $matchquart[3]->getEtat()=="Termine"){
                $q=true;
                foreach ($matchss as $m){
                    if($m->getType()=="demi_final"){
                        $q=false;
                    }
                }
                if($q){
                    $demi=$this->get('demi');
                    $demi->demi();
                }

            }else{
                echo "Les matchs de quart de finale ne sont pas encore termine";
            }
        }
        $matchdemi=$em->getRepository("ClientBundle:Match2018")->findDemiMatch();
        if(empty($matchdemi)){
            echo "Pas de matchs demi final";
        }else{
            if($matchdemi[0]->getEtat()=="Termine" && $matchdemi[1]->getEtat()=="Termine"){
                $o=true;
                foreach ($matchss as $m){
                    if($m->getType()=="final"){
                        $o=false;
                    }
                }
                if($o){
                    $finale=$this->get('finale');
                    $finale->finale();
                }

            }else{
                echo "Les matchs demi final pas encore termine";
            }
        }


        return $this->render('ClientBundle:Match2018:modifier_matchs.html.twig', array(
            'Form'=>$Form->createView()// ...
        ));

    }
    public function Ajouter_EvenementAction(Request $request,$id){
        $em=$this->getDoctrine()->getManager();
        $matchs=$em->getRepository("ClientBundle:Match2018")->find($id);

        $jpe1=$em->getRepository("ClientBundle:JoueurParticipant")->findJPEquipe1($id);

        $jpe2=$em->getRepository("ClientBundle:JoueurParticipant")->findJPEquipe2($id);
        $evenement=new Evenement();
        if($request->isMethod('POST')){
            $evenement->setIdMatch($matchs);
            if(isset($_POST['JP1'])){

                $j1=$em->getRepository("ClientBundle:JoueurParticipant")->find($request->get('JP1'));
                $evenement->setIdJoueurParticipant($j1);
            }elseif(isset($_POST['JP2'])){

                $j2=$em->getRepository("ClientBundle:JoueurParticipant")->find($request->get('JP2'));
                $evenement->setIdJoueurParticipant($j2);

            }
            $evenement->setBut($request->get('but'));
            $evenement->setCarton($request->get('carton'));
            $evenement->setTemps($request->get('temps'));

            $em->persist($evenement);
            $em->flush();
            $but=$request->get('but');
            if($but==1){
                $e1=$matchs->getIdEquipe1()->getNom();
                $e2=$matchs->getIdEquipe2()->getNom();
                if(isset($_POST['JP1'])){
                    $em1=$j1->getIdJoueur()->getIdEquipe()->getNom();
                    $score=$em->getRepository("ClientBundle:Score")->find($matchs->getId());
                    if($em1==$e1) {
                        $a = $score->getA();
                        $a++;
                        $score->setA($a);
                        $em->persist($score);
                        $em->flush();
                    }
                }
                elseif (isset($_POST['JP2'])){
                    $em2=$j2->getIdJoueur()->getIdEquipe()->getNom();
                    $score=$em->getRepository("ClientBundle:Score")->find($matchs->getId());
                    if ($em2==$e2){
                        $b=$score->getB();
                        $b++;
                        $score->setB($b);
                        $em->persist($score);
                        $em->flush();
                    }

                }



            }



        }
        return $this->render('ClientBundle:Match2018:ajouter_evenement.html.twig', array(
            'matchs'=>$matchs,'jpe1'=>$jpe1,'jpe2'=>$jpe2// ...
        ));
    }

    public function Ajouter_Joueur_PAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $equipes=$em->getRepository("ClientBundle:Equipe")->findAll();
        $joueur=$em->getRepository("ClientBundle:Joueur")->findAll();
        return $this->render('ClientBundle:Match2018:ajouter_joueur_p.html.twig', array(
            'equipes'=>$equipes,'joueurs'=>$joueur// ...
        ));
    }

    /*public function ModifierAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $matchs=$em->getRepository("ClientBundle:Match2018")->findAll();
        foreach ($matchs as $m){
            $idEquipe1=$m->getIdEquipe1();
            $equipe2=$em->getRepository("ClientBundle:Match2018")->findEquipe2($idEquipe1);
        }

        $Form=$this->createForm(Match2018Type::class,$matchs);

        $Form->handleRequest($request);
        if($Form->isSubmitted() && $Form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($matchs);
            $em->flush();

        }

        return $this->render('ClientBundle:Match2018:Modifier_Match.html.twig', array(
           'Form'=>$Form->createView() // ...
        ));
    }*/

    public function matchDetailAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $match=$em->getRepository("ClientBundle:Match2018")->findMatchs($id);
        $evenement=$em->getRepository("ClientBundle:Evenement")->findEvenementsParIDMATCH($id);
        return $this->render('ClientBundle:Match2018:matchDetail.html.twig', array(
            'matchs1'=>$match , 'evenements'=>$evenement // ...
        ));
    }
    public function matchResultAction(){
        $em=$this->getDoctrine()->getManager();
        $matchs=$em->getRepository("ClientBundle:Match2018")->findAll();
        $lastevents=$em->getRepository("ClientBundle:Evenement")->findDerniersEvenements();
        $dateActuelle=setlocale(LC_ALL,'fr_FR');
        $d=array($dateActuelle);
        $scores=array();
        $tab=array();
        $tabT=array();
        $scoresT=array();

        foreach ($matchs as $m){
            $score=$m->getId();
            array_push($scores,$em->getRepository("ClientBundle:Score")->findScoresParIDMATCH($score));
            //$matchs["score"]=$em->getRepository("ClientBundle:Score")->findScoresParIDMATCH($score);
            //array_push($scores,$em->getRepository("ClientBundle:Score")->findScoresParIDMATCH($score));
        }
        foreach ($matchs as $m){
            foreach ($scores as $s) {
                array_push($tab,array("match"=>$m,"a"=>$s[0]->getA(),"b"=>$s[0]->getB()));
                array_shift($scores);
                break;
            }
        }

        $matchsTermine=$em->getRepository("ClientBundle:Match2018")->findMatchTermine();
        foreach ($matchsTermine as $mt){
            $score=$mt->getId();
            array_push($scoresT,$em->getRepository("ClientBundle:Score")->findScoresParIDMATCH($score));

        }
        foreach ($matchsTermine as $mt){
            foreach ($scoresT as $s) {
                array_push($tabT,array("match"=>$mt,"a"=>$s[0]->getA(),"b"=>$s[0]->getB()));
                array_shift($scoresT);
                break;
            }
        }


        return $this->render('ClientBundle:Match2018:matchResult.html.twig', array(
            'tab'=>$tab,'matchT'=>$matchsTermine,'date'=>$d,'tabT'=>$tabT,'evenements'=>$lastevents // ...
        ));


    }


    public function afficherToutAction(){
        $em=$this->getDoctrine()->getManager();
        $match=$em->getRepository("ClientBundle:Match2018")->findAll();
        $firstmatch=$em->getRepository("ClientBundle:Match2018")->findFirstMatch();
        $lastevents=$em->getRepository("ClientBundle:Evenement")->findDerniersEvenements();


        return $this->render('@Client/Match2018/index.html.twig',
            array('matchs' => $match , 'firstmatch'=>$firstmatch,
                'evenements'=>$lastevents));
    }
    public function icalAction(){

        $icalFactory = $this->get('welp_ical.factory');
        //Create a calendar
        $calendar = $icalFactory->createCalendar();

        //Create an event
        $eventOne = $icalFactory->createCalendarEvent();
        $eventOne->setStart(new \DateTime())
            ->setSummary('Family reunion')
            ->setUid('event-uid');

        //add an Attendee
        $attendee = $icalFactory->createAttendee();
        $attendee->setValue('moe@example.com')
            ->setName('Moe Smith');
        $eventOne->addAttendee($attendee);

        //set the Organizer
        $organizer = $icalFactory->createOrganizer();
        $organizer->setValue('titouan@welp.fr')
            ->setName('Titouan BENOIT')
            ->setLanguage('fr');
        $eventOne->setOrganizer($organizer);

        //new event
        $eventTwo = $icalFactory->createCalendarEvent();
        $eventTwo->setStart(new \DateTime())
            ->setSummary('Dentist Appointment')
            ->setUid('event-uid');

        $calendar
            ->addEvent($eventOne)
            ->addEvent($eventTwo);

        $headers = array();
        $calendarResponse = new CalendarResponse($calendar, 200, $headers);

        return $calendarResponse;

    }
    /*public function parserAction(){

            $ical=new ICal();
            $a=$ical->initFile('ICal.ics');
            // $ical->initUrl('https://raw.githubusercontent.com/u01jmg3/ics-parser/master/examples/ICal.ics');

        dump($a->events());
       return null;

    }*/
    public function downloadICSAction(){
        $r=new Response();
        try{
            return $this->get('nzo_file_downloader')->downloadFile('js/FIFA 2018 World Cup Russia.ics');
        }catch (\Exception $e){
            return $r;
        }

    }
    public function phase_finaleAction(){
        $em=$this->getDoctrine()->getManager();
        $equipes=$em->getRepository("ClientBundle:Equipe")->findAll();
        $qe=array();
        $tab=array();
        $last16=$em->getRepository("ClientBundle:Equipe")->findEquipeQual("last_16");
        $quart_final=$em->getRepository("ClientBundle:Equipe")->findEquipeQual("quart_final");
        $demi_final=$em->getRepository("ClientBundle:Equipe")->findEquipeQual("demi_final");
        $final=$em->getRepository("ClientBundle:Equipe")->findEquipeQual("final_");
        array_push($tab,array("Huitieme de finale"=>$last16,"Quart de finale"=>$quart_final,"Demi-Final"=>$demi_final,"Finale"=>$final));
        dump($tab);

        return $this->render('@Client/Match2018/Phase_Finale.html.twig',
            array('tab'=>$tab

            ));
    }
    public function huitiemeAction(){
        $em=$this->getDoctrine()->getManager();
        $matchs=$em->getRepository("ClientBundle:Match2018")->findlast_16Match();
        $scores=array();
        $tab=array();
        $tabT=array();
        $scoresT=array();
        foreach ($matchs as $m){
            $score=$m->getId();
            array_push($scores,$em->getRepository("ClientBundle:Score")->findScoresParIDMATCH($score));
            //$matchs["score"]=$em->getRepository("ClientBundle:Score")->findScoresParIDMATCH($score);
            //array_push($scores,$em->getRepository("ClientBundle:Score")->findScoresParIDMATCH($score));
        }
        foreach ($matchs as $m){
            foreach ($scores as $s) {
                array_push($tab,array("match"=>$m,"a"=>$s[0]->getA(),"b"=>$s[0]->getB()));
                array_shift($scores);
                break;
            }
        }
        $matchsTermine=$em->getRepository("ClientBundle:Match2018")->findMatchLast_16Termine();
        foreach ($matchsTermine as $mt){
            $score=$mt->getId();
            array_push($scoresT,$em->getRepository("ClientBundle:Score")->findScoresParIDMATCH($score));

        }
        foreach ($matchsTermine as $mt){
            foreach ($scoresT as $s) {
                array_push($tabT,array("match"=>$mt,"a"=>$s[0]->getA(),"b"=>$s[0]->getB()));
                array_shift($scoresT);
                break;
            }
        }

        return $this->render('@Client/Match2018/huitieme_de_finale.html.twig',
            array(
                'tab'=>$tab,'tabT'=>$tabT
            ));
    }
    public function quartAction(){

        $em=$this->getDoctrine()->getManager();
        $matchs=$em->getRepository("ClientBundle:Match2018")->findQuartMatch();
        $scores=array();
        $tab=array();
        $tabT=array();
        $scoresT=array();
        foreach ($matchs as $m){
            $score=$m->getId();
            array_push($scores,$em->getRepository("ClientBundle:Score")->findScoresParIDMATCH($score));
            //$matchs["score"]=$em->getRepository("ClientBundle:Score")->findScoresParIDMATCH($score);
            //array_push($scores,$em->getRepository("ClientBundle:Score")->findScoresParIDMATCH($score));
        }
        foreach ($matchs as $m){
            foreach ($scores as $s) {
                array_push($tab,array("match"=>$m,"a"=>$s[0]->getA(),"b"=>$s[0]->getB()));
                array_shift($scores);
                break;
            }
        }
        $matchsTermine=$em->getRepository("ClientBundle:Match2018")->findMatchQuartTermine();
        foreach ($matchsTermine as $mt){
            $score=$mt->getId();
            array_push($scoresT,$em->getRepository("ClientBundle:Score")->findScoresParIDMATCH($score));

        }
        foreach ($matchsTermine as $mt){
            foreach ($scoresT as $s) {
                array_push($tabT,array("match"=>$mt,"a"=>$s[0]->getA(),"b"=>$s[0]->getB()));
                array_shift($scoresT);
                break;
            }
        }

        return $this->render('@Client/Match2018/quart_finale.html.twig',
            array(
                'tab'=>$tab,'tabT'=>$tabT
            ));
    }
    public function demi_finaleAction(){
        $em=$this->getDoctrine()->getManager();
        $matchs=$em->getRepository("ClientBundle:Match2018")->findDemiMatch();
        $scores=array();
        $tab=array();
        $tabT=array();
        $scoresT=array();
        foreach ($matchs as $m){
            $score=$m->getId();
            array_push($scores,$em->getRepository("ClientBundle:Score")->findScoresParIDMATCH($score));
            //$matchs["score"]=$em->getRepository("ClientBundle:Score")->findScoresParIDMATCH($score);
            //array_push($scores,$em->getRepository("ClientBundle:Score")->findScoresParIDMATCH($score));
        }
        foreach ($matchs as $m){
            foreach ($scores as $s) {
                array_push($tab,array("match"=>$m,"a"=>$s[0]->getA(),"b"=>$s[0]->getB()));
                array_shift($scores);
                break;
            }
        }
        $matchsTermine=$em->getRepository("ClientBundle:Match2018")->findMatchDemiTermine();
        foreach ($matchsTermine as $mt){
            $score=$mt->getId();
            array_push($scoresT,$em->getRepository("ClientBundle:Score")->findScoresParIDMATCH($score));

        }
        foreach ($matchsTermine as $mt){
            foreach ($scoresT as $s) {
                array_push($tabT,array("match"=>$mt,"a"=>$s[0]->getA(),"b"=>$s[0]->getB()));
                array_shift($scoresT);
                break;
            }
        }

        return $this->render('@Client/Match2018/demi_finale.html.twig',
            array(
                'tab'=>$tab,'tabT'=>$tabT
            ));

    }
    public function FinaleAction(){
        $em=$this->getDoctrine()->getManager();
        $matchs=$em->getRepository("ClientBundle:Match2018")->findFinalMatch();
        $scores=array();
        $tab=array();
        $tabT=array();
        $scoresT=array();
        foreach ($matchs as $m){
            $score=$m->getId();
            array_push($scores,$em->getRepository("ClientBundle:Score")->findScoresParIDMATCH($score));
            //$matchs["score"]=$em->getRepository("ClientBundle:Score")->findScoresParIDMATCH($score);
            //array_push($scores,$em->getRepository("ClientBundle:Score")->findScoresParIDMATCH($score));
        }
        foreach ($matchs as $m){
            foreach ($scores as $s) {
                array_push($tab,array("match"=>$m,"a"=>$s[0]->getA(),"b"=>$s[0]->getB()));
                array_shift($scores);
                break;
            }
        }
        $matchsTermine=$em->getRepository("ClientBundle:Match2018")->findMatchFinalTermine();
        foreach ($matchsTermine as $mt){
            $score=$mt->getId();
            array_push($scoresT,$em->getRepository("ClientBundle:Score")->findScoresParIDMATCH($score));

        }
        foreach ($matchsTermine as $mt){
            foreach ($scoresT as $s) {
                array_push($tabT,array("match"=>$mt,"a"=>$s[0]->getA(),"b"=>$s[0]->getB()));
                array_shift($scoresT);
                break;
            }
        }

        $eg=$this->get('finale');
        $a=$eg->retournerEquipeGagnant();

        return $this->render('@Client/Match2018/finale.html.twig',
            array(
                'tab'=>$tab,'tabT'=>$tabT,'a'=>$a
            ));
    }



}
