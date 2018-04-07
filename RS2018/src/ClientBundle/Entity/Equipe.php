<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Equipe
 *
 * @ORM\Table(name="equipe", indexes={@ORM\Index(name="ck_entraineur", columns={"id_entraineur"}), @ORM\Index(name="ck_groupe", columns={"id_groupe"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="ClientBundle\Repository\EquipeRepository")
 */
class Equipe
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=100, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="drapeau", type="string", length=250, nullable=false)
     */
    private $drapeau;

    /**
     * @var string
     *
     * @ORM\Column(name="maillot", type="string", length=250, nullable=false)
     */
    private $maillot;

    /**
     * @var string
     *
     * @ORM\Column(name="progress", type="string", nullable=true)
     */
    private $progress;

    /**
     * @var integer
     *
     * @ORM\Column(name="pts", type="integer", nullable=true)
     */
    private $pts;

    /**
     * @var string
     *
     * @ORM\Column(name="qualification", type="string", nullable=false)
     */
    private $qualification;

    /**
     * @var integer
     *
     * @ORM\Column(name="nb_match_joue", type="integer", nullable=false)
     */
    private $nbMatchJoue;

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
     * @var \Entraineur
     *
     * @ORM\ManyToOne(targetEntity="Entraineur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_entraineur", referencedColumnName="id")
     * })
     */
    private $idEntraineur;



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
     * Set nom
     *
     * @param string $nom
     *
     * @return Equipe
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set drapeau
     *
     * @param string $drapeau
     *
     * @return Equipe
     */
    public function setDrapeau($drapeau)
    {
        $this->drapeau = $drapeau;

        return $this;
    }

    /**
     * Get drapeau
     *
     * @return string
     */
    public function getDrapeau()
    {
        return $this->drapeau;
    }

    /**
     * Set maillot
     *
     * @param string $maillot
     *
     * @return Equipe
     */
    public function setMaillot($maillot)
    {
        $this->maillot = $maillot;

        return $this;
    }

    /**
     * Get maillot
     *
     * @return string
     */
    public function getMaillot()
    {
        return $this->maillot;
    }

    /**
     * Set progress
     *
     * @param string $progress
     *
     * @return Equipe
     */
    public function setProgress($progress)
    {
        $this->progress = $progress;

        return $this;
    }

    /**
     * Get progress
     *
     * @return string
     */
    public function getProgress()
    {
        return $this->progress;
    }

    /**
     * Set pts
     *
     * @param integer $pts
     *
     * @return Equipe
     */
    public function setPts($pts)
    {
        $this->pts = $pts;

        return $this;
    }

    /**
     * Get pts
     *
     * @return integer
     */
    public function getPts()
    {
        return $this->pts;
    }

    /**
     * Set qualification
     *
     * @param string $qualification
     *
     * @return Equipe
     */
    public function setQualification($qualification)
    {
        $this->qualification = $qualification;

        return $this;
    }

    /**
     * Get qualification
     *
     * @return string
     */
    public function getQualification()
    {
        return $this->qualification;
    }

    /**
     * Set nbMatchJoue
     *
     * @param integer $nbMatchJoue
     *
     * @return Equipe
     */
    public function setNbMatchJoue($nbMatchJoue)
    {
        $this->nbMatchJoue = $nbMatchJoue;

        return $this;
    }

    /**
     * Get nbMatchJoue
     *
     * @return integer
     */
    public function getNbMatchJoue()
    {
        return $this->nbMatchJoue;
    }

    /**
     * Set idGroupe
     *
     * @param \ClientBundle\Entity\Groupe $idGroupe
     *
     * @return Equipe
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
     * Set idEntraineur
     *
     * @param \ClientBundle\Entity\Entraineur $idEntraineur
     *
     * @return Equipe
     */
    public function setIdEntraineur(\ClientBundle\Entity\Entraineur $idEntraineur = null)
    {
        $this->idEntraineur = $idEntraineur;

        return $this;
    }

    /**
     * Get idEntraineur
     *
     * @return \ClientBundle\Entity\Entraineur
     */
    public function getIdEntraineur()
    {
        return $this->idEntraineur;
    }

    public function __toString()
    {
        return $this->nom;
    }


}
