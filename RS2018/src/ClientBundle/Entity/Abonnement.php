<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Abonnement
 *
 * @ORM\Table(name="abonnement", indexes={@ORM\Index(name="ck_user_1", columns={"id_user"}), @ORM\Index(name="ck_joueur_1", columns={"id_joueur"})})
 * @ORM\Entity
 */
class Abonnement
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
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;

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
     * Set idUser
     *
     * @param \ClientBundle\Entity\User $idUser
     *
     * @return Abonnement
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

    /**
     * Set idJoueur
     *
     * @param \ClientBundle\Entity\Joueur $idJoueur
     *
     * @return Abonnement
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
