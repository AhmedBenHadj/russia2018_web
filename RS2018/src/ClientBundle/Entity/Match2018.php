<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Match2018
 *
 * @ORM\Table(name="match_2018", indexes={@ORM\Index(name="ck_equipe_1", columns={"id_equipe_1"}), @ORM\Index(name="ck_equipe_2", columns={"id_equipe_2"}), @ORM\Index(name="ck_stade", columns={"id_stade"}), @ORM\Index(name="id", columns={"id"}), @ORM\Index(name="id_groupe", columns={"id_groupe"})})
 * @ORM\Entity(repositoryClass="ClientBundle\Repository\Match2018Repository")
 */
class Match2018
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="time", nullable=false)
     */
    private $time;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", nullable=false)
     */
    private $etat;

    /**
     * @var integer
     *
     * @ORM\Column(name="duree", type="integer", nullable=false)
     */
    private $duree;

    /**
     * @var integer
     *
     * @ORM\Column(name="nombre_spectateur", type="integer", nullable=false)
     */
    private $nombreSpectateur;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", nullable=true)
     */
    private $type;

    /**
     * @var float
     *
     * @ORM\Column(name="cote_eq1", type="float", precision=10, scale=0, nullable=true)
     */
    private $coteEq1;

    /**
     * @var float
     *
     * @ORM\Column(name="cote_eq2", type="float", precision=10, scale=0, nullable=true)
     */
    private $coteEq2;

    /**
     * @var float
     *
     * @ORM\Column(name="cote_nul", type="float", precision=10, scale=0, nullable=true)
     */
    private $coteNul;

    /**
     * @var \Groupe
     *
     * @ORM\ManyToOne(targetEntity="Groupe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_groupe", referencedColumnName="id")
     * })
     */
    private $idGroupe;

    /**
     * @var \Equipe
     *
     * @ORM\ManyToOne(targetEntity="Equipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_equipe_1", referencedColumnName="id")
     *
     *
     * })
     */
    private $idEquipe1;

    /**
     * @var \Stade
     *
     * @ORM\ManyToOne(targetEntity="Stade")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_stade", referencedColumnName="id")
     * })
     */
    private $idStade;

    /**
     * @var \Equipe
     *
     * @ORM\ManyToOne(targetEntity="Equipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_equipe_2", referencedColumnName="id")
     * })
     */
    private $idEquipe2;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Match2018
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     *
     * @return Match2018
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return Match2018
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set duree
     *
     * @param integer $duree
     *
     * @return Match2018
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return integer
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set nombreSpectateur
     *
     * @param integer $nombreSpectateur
     *
     * @return Match2018
     */
    public function setNombreSpectateur($nombreSpectateur)
    {
        $this->nombreSpectateur = $nombreSpectateur;

        return $this;
    }

    /**
     * Get nombreSpectateur
     *
     * @return integer
     */
    public function getNombreSpectateur()
    {
        return $this->nombreSpectateur;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Match2018
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set coteEq1
     *
     * @param float $coteEq1
     *
     * @return Match2018
     */
    public function setCoteEq1($coteEq1)
    {
        $this->coteEq1 = $coteEq1;

        return $this;
    }

    /**
     * Get coteEq1
     *
     * @return float
     */
    public function getCoteEq1()
    {
        return $this->coteEq1;
    }

    /**
     * Set coteEq2
     *
     * @param float $coteEq2
     *
     * @return Match2018
     */
    public function setCoteEq2($coteEq2)
    {
        $this->coteEq2 = $coteEq2;

        return $this;
    }

    /**
     * Get coteEq2
     *
     * @return float
     */
    public function getCoteEq2()
    {
        return $this->coteEq2;
    }

    /**
     * Set coteNul
     *
     * @param float $coteNul
     *
     * @return Match2018
     */
    public function setCoteNul($coteNul)
    {
        $this->coteNul = $coteNul;

        return $this;
    }

    /**
     * Get coteNul
     *
     * @return float
     */
    public function getCoteNul()
    {
        return $this->coteNul;
    }

    /**
     * Set idGroupe
     *
     * @param \ClientBundle\Entity\Groupe $idGroupe
     *
     * @return Match2018
     */
    public function setIdGroupe(\ClientBundle\Entity\Groupe $idGroupe = null)
    {
        $this->idGroupe = $idGroupe;

        return $this;
    }

    /**
     * Get idGroupe
     *
     * @return \ClientBundle\Entity\Groupe
     */
    public function getIdGroupe()
    {
        return $this->idGroupe;
    }

    /**
     * Set idEquipe1
     *
     * @param \ClientBundle\Entity\Equipe $idEquipe1
     *
     * @return Match2018
     */
    public function setIdEquipe1(\ClientBundle\Entity\Equipe $idEquipe1 = null)
    {
        $this->idEquipe1 = $idEquipe1;

        return $this;
    }

    /**
     * Get idEquipe1
     *
     * @return \ClientBundle\Entity\Equipe
     */
    public function getIdEquipe1()
    {
        return $this->idEquipe1;
    }

    /**
     * Set idStade
     *
     * @param \ClientBundle\Entity\Stade $idStade
     *
     * @return Match2018
     */
    public function setIdStade(\ClientBundle\Entity\Stade $idStade = null)
    {
        $this->idStade = $idStade;

        return $this;
    }

    /**
     * Get idStade
     *
     * @return \ClientBundle\Entity\Stade
     */
    public function getIdStade()
    {
        return $this->idStade;
    }

    /**
     * Set idEquipe2
     *
     * @param \ClientBundle\Entity\Equipe $idEquipe2
     *
     * @return Match2018
     */
    public function setIdEquipe2(\ClientBundle\Entity\Equipe $idEquipe2 = null)
    {
        $this->idEquipe2 = $idEquipe2;

        return $this;
    }

    /**
     * Get idEquipe2
     *
     * @return \Equipe
     */
    public function getIdEquipe2()
    {
        return $this->idEquipe2;
    }

    public function __toString()
    {
        return $this->etat;
    }

}
