<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement", indexes={@ORM\Index(name="ck_match", columns={"id_match"}), @ORM\Index(name="ch_joueur_participant", columns={"id_joueur_participant"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="ClientBundle\Repository\EvenementRepository")
 */
class Evenement
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
     * @ORM\Column(name="carton", type="string", nullable=false)
     */
    private $carton;

    /**
     * @var integer
     *
     * @ORM\Column(name="but", type="integer", nullable=true)
     */
    private $but;

    /**
     * @var integer
     *
     * @ORM\Column(name="temps", type="integer", nullable=false)
     */
    private $temps;

    /**
     * @var \JoueurParticipant
     *
     * @ORM\ManyToOne(targetEntity="JoueurParticipant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_joueur_participant", referencedColumnName="id")
     * })
     */
    private $idJoueurParticipant;

    /**
     * @var \Match2018
     *
     * @ORM\ManyToOne(targetEntity="Match2018")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_match", referencedColumnName="id")
     * })
     */
    private $idMatch;



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
     * Set carton
     *
     * @param string $carton
     *
     * @return Evenement
     */
    public function setCarton($carton)
    {
        $this->carton = $carton;

        return $this;
    }

    /**
     * Get carton
     *
     * @return string
     */
    public function getCarton()
    {
        return $this->carton;
    }

    /**
     * Set but
     *
     * @param integer $but
     *
     * @return Evenement
     */
    public function setBut($but)
    {
        $this->but = $but;

        return $this;
    }

    /**
     * Get but
     *
     * @return integer
     */
    public function getBut()
    {
        return $this->but;
    }

    /**
     * Set temps
     *
     * @param integer $temps
     *
     * @return Evenement
     */
    public function setTemps($temps)
    {
        $this->temps = $temps;

        return $this;
    }

    /**
     * Get temps
     *
     * @return integer
     */
    public function getTemps()
    {
        return $this->temps;
    }

    /**
     * Set idJoueurParticipant
     *
     * @param \ClientBundle\Entity\JoueurParticipant $idJoueurParticipant
     *
     * @return Evenement
     */
    public function setIdJoueurParticipant(\ClientBundle\Entity\JoueurParticipant $idJoueurParticipant = null)
    {
        $this->idJoueurParticipant = $idJoueurParticipant;

        return $this;
    }

    /**
     * Get idJoueurParticipant
     *
     * @return \ClientBundle\Entity\JoueurParticipant
     */
    public function getIdJoueurParticipant()
    {
        return $this->idJoueurParticipant;
    }

    /**
     * Set idMatch
     *
     * @param \ClientBundle\Entity\Match2018 $idMatch
     *
     * @return Evenement
     */
    public function setIdMatch(\ClientBundle\Entity\Match2018 $idMatch = null)
    {
        $this->idMatch = $idMatch;

        return $this;
    }

    /**
     * Get idMatch
     *
     * @return \ClientBundle\Entity\Match2018
     */
    public function getIdMatch()
    {
        return $this->idMatch;
    }
}
