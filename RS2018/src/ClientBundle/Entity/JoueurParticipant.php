<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JoueurParticipant
 *
 * @ORM\Table(name="joueur_participant", indexes={@ORM\Index(name="ck_joueur", columns={"id_joueur"})})
 * @ORM\Entity
 */
class JoueurParticipant
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
     * @ORM\Column(name="temps_joue", type="integer", nullable=false)
     */
    private $tempsJoue;

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
     * Set tempsJoue
     *
     * @param integer $tempsJoue
     *
     * @return JoueurParticipant
     */
    public function setTempsJoue($tempsJoue)
    {
        $this->tempsJoue = $tempsJoue;

        return $this;
    }

    /**
     * Get tempsJoue
     *
     * @return integer
     */
    public function getTempsJoue()
    {
        return $this->tempsJoue;
    }

    /**
     * Set idJoueur
     *
     * @param \ClientBundle\Entity\Joueur $idJoueur
     *
     * @return JoueurParticipant
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
