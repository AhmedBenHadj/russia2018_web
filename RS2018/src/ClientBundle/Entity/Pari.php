<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pari
 *
 * @ORM\Table(name="pari", indexes={@ORM\Index(name="id_fiche_pari", columns={"id_fiche_pari"}), @ORM\Index(name="id_match", columns={"id_match"})})
 * @ORM\Entity
 */
class Pari
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
     * @ORM\Column(name="mise", type="float", precision=10, scale=0, nullable=false)
     */
    private $mise;

    /**
     * @var float
     *
     * @ORM\Column(name="gain", type="float", precision=10, scale=0, nullable=false)
     */
    private $gain;

    /**
     * @var float
     *
     * @ORM\Column(name="cote", type="float", precision=10, scale=0, nullable=false)
     */
    private $cote;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255, nullable=false)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="resultat", type="string", nullable=false)
     */
    private $resultat;

    /**
     * @var \FichePari
     *
     * @ORM\ManyToOne(targetEntity="FichePari")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_fiche_pari", referencedColumnName="id")
     * })
     */
    private $idFichePari;

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
     * Set mise
     *
     * @param float $mise
     *
     * @return Pari
     */
    public function setMise($mise)
    {
        $this->mise = $mise;

        return $this;
    }

    /**
     * Get mise
     *
     * @return float
     */
    public function getMise()
    {
        return $this->mise;
    }

    /**
     * Set gain
     *
     * @param float $gain
     *
     * @return Pari
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
     * Set cote
     *
     * @param float $cote
     *
     * @return Pari
     */
    public function setCote($cote)
    {
        $this->cote = $cote;

        return $this;
    }

    /**
     * Get cote
     *
     * @return float
     */
    public function getCote()
    {
        return $this->cote;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Pari
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
     * Set etat
     *
     * @param string $etat
     *
     * @return Pari
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
     * Set resultat
     *
     * @param string $resultat
     *
     * @return Pari
     */
    public function setResultat($resultat)
    {
        $this->resultat = $resultat;

        return $this;
    }

    /**
     * Get resultat
     *
     * @return string
     */
    public function getResultat()
    {
        return $this->resultat;
    }

    /**
     * Set idFichePari
     *
     * @param \ClientBundle\Entity\FichePari $idFichePari
     *
     * @return Pari
     */
    public function setIdFichePari(\ClientBundle\Entity\FichePari $idFichePari = null)
    {
        $this->idFichePari = $idFichePari;

        return $this;
    }

    /**
     * Get idFichePari
     *
     * @return \ClientBundle\Entity\FichePari
     */
    public function getIdFichePari()
    {
        return $this->idFichePari;
    }

    /**
     * Set idMatch
     *
     * @param \ClientBundle\Entity\Match2018 $idMatch
     *
     * @return Pari
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
