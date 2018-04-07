<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JoueurFantasy
 *
 * @ORM\Table(name="joueur_fantasy", indexes={@ORM\Index(name="id_joueur", columns={"id_joueur"}), @ORM\Index(name="id_equipe", columns={"id_equipe"})})
 * @ORM\Entity
 */
class JoueurFantasy
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
     * @var integer
     *
     * @ORM\Column(name="etat", type="integer", nullable=false)
     */
    private $etat;

    /**
     * @var integer
     *
     * @ORM\Column(name="points", type="integer", nullable=false)
     */
    private $points;

    /**
     * @var \EquipeFantasy
     *
     * @ORM\ManyToOne(targetEntity="EquipeFantasy")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_equipe", referencedColumnName="id")
     * })
     */
    private $idEquipe;

    /**
     * @var \Joueur
     *
     * @ORM\ManyToOne(targetEntity="Joueur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_joueur", referencedColumnName="id")
     * })
     */
    private $idJoueur;



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
     * Set etat
     *
     * @param integer $etat
     *
     * @return JoueurFantasy
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return integer
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set points
     *
     * @param integer $points
     *
     * @return JoueurFantasy
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return integer
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set idEquipe
     *
     * @param \ClientBundle\Entity\EquipeFantasy $idEquipe
     *
     * @return JoueurFantasy
     */
    public function setIdEquipe(\ClientBundle\Entity\EquipeFantasy $idEquipe = null)
    {
        $this->idEquipe = $idEquipe;

        return $this;
    }

    /**
     * Get idEquipe
     *
     * @return \ClientBundle\Entity\EquipeFantasy
     */
    public function getIdEquipe()
    {
        return $this->idEquipe;
    }

    /**
     * Set idJoueur
     *
     * @param \ClientBundle\Entity\Joueur $idJoueur
     *
     * @return JoueurFantasy
     */
    public function setIdJoueur(\ClientBundle\Entity\Joueur $idJoueur = null)
    {
        $this->idJoueur = $idJoueur;

        return $this;
    }

    /**
     * Get idJoueur
     *
     * @return \ClientBundle\Entity\Joueur
     */
    public function getIdJoueur()
    {
        return $this->idJoueur;
    }
}
