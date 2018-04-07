<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EquipeFantasy
 *
 * @ORM\Table(name="equipe_fantasy", indexes={@ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class EquipeFantasy
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
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var integer
     *
     * @ORM\Column(name="totalpoints", type="integer", nullable=false)
     */
    private $totalpoints;

    /**
     * @var integer
     *
     * @ORM\Column(name="classement", type="integer", nullable=false)
     */
    private $classement;

    /**
     * @var integer
     *
     * @ORM\Column(name="transfers", type="integer", nullable=false)
     */
    private $transfers;

    /**
     * @var float
     *
     * @ORM\Column(name="valeur", type="float", precision=10, scale=0, nullable=false)
     */
    private $valeur;

    /**
     * @var float
     *
     * @ORM\Column(name="banque", type="float", precision=10, scale=0, nullable=false)
     */
    private $banque;

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
     * Set nom
     *
     * @param string $nom
     *
     * @return EquipeFantasy
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
     * Set totalpoints
     *
     * @param integer $totalpoints
     *
     * @return EquipeFantasy
     */
    public function setTotalpoints($totalpoints)
    {
        $this->totalpoints = $totalpoints;

        return $this;
    }

    /**
     * Get totalpoints
     *
     * @return integer
     */
    public function getTotalpoints()
    {
        return $this->totalpoints;
    }

    /**
     * Set classement
     *
     * @param integer $classement
     *
     * @return EquipeFantasy
     */
    public function setClassement($classement)
    {
        $this->classement = $classement;

        return $this;
    }

    /**
     * Get classement
     *
     * @return integer
     */
    public function getClassement()
    {
        return $this->classement;
    }

    /**
     * Set transfers
     *
     * @param integer $transfers
     *
     * @return EquipeFantasy
     */
    public function setTransfers($transfers)
    {
        $this->transfers = $transfers;

        return $this;
    }

    /**
     * Get transfers
     *
     * @return integer
     */
    public function getTransfers()
    {
        return $this->transfers;
    }

    /**
     * Set valeur
     *
     * @param float $valeur
     *
     * @return EquipeFantasy
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;

        return $this;
    }

    /**
     * Get valeur
     *
     * @return float
     */
    public function getValeur()
    {
        return $this->valeur;
    }

    /**
     * Set banque
     *
     * @param float $banque
     *
     * @return EquipeFantasy
     */
    public function setBanque($banque)
    {
        $this->banque = $banque;

        return $this;
    }

    /**
     * Get banque
     *
     * @return float
     */
    public function getBanque()
    {
        return $this->banque;
    }

    /**
     * Set idUser
     *
     * @param \ClientBundle\Entity\User $idUser
     *
     * @return EquipeFantasy
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
