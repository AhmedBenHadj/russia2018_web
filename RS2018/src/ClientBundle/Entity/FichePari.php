<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FichePari
 *
 * @ORM\Table(name="fiche_pari", indexes={@ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class FichePari
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
     * @var float
     *
     * @ORM\Column(name="cotetotal", type="float", precision=10, scale=0, nullable=false)
     */
    private $cotetotal;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255, nullable=false)
     */
    private $etat;

    /**
     * @var float
     *
     * @ORM\Column(name="misetotal", type="float", precision=10, scale=0, nullable=false)
     */
    private $misetotal;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var float
     *
     * @ORM\Column(name="gain", type="float", precision=10, scale=0, nullable=false)
     */
    private $gain;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;



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
     * Set cotetotal
     *
     * @param float $cotetotal
     *
     * @return FichePari
     */
    public function setCotetotal($cotetotal)
    {
        $this->cotetotal = $cotetotal;

        return $this;
    }

    /**
     * Get cotetotal
     *
     * @return float
     */
    public function getCotetotal()
    {
        return $this->cotetotal;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return FichePari
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
     * Set misetotal
     *
     * @param float $misetotal
     *
     * @return FichePari
     */
    public function setMisetotal($misetotal)
    {
        $this->misetotal = $misetotal;

        return $this;
    }

    /**
     * Get misetotal
     *
     * @return float
     */
    public function getMisetotal()
    {
        return $this->misetotal;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return FichePari
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
     * Set gain
     *
     * @param float $gain
     *
     * @return FichePari
     */
    public function setGain($gain)
    {
        $this->gain = $gain;

        return $this;
    }

    /**
     * Get gain
     *
     * @return float
     */
    public function getGain()
    {
        return $this->gain;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return FichePari
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set idUser
     *
     * @param \ClientBundle\Entity\User $idUser
     *
     * @return FichePari
     */
    public function setIdUser(\ClientBundle\Entity\User $idUser = null)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return \ClientBundle\Entity\User
     */
    public function getIdUser()
    {
        return $this->idUser;
    }
}
