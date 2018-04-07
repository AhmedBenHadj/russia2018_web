<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire", indexes={@ORM\Index(name="id_publication", columns={"id_publication"}), @ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class Commentaire
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
     * @ORM\Column(name="description", type="string", length=250, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="date", nullable=false)
     */
    private $dateCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="likedislike", type="string", nullable=false)
     */
    private $likedislike;

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
     * @var \Publication
     *
     * @ORM\ManyToOne(targetEntity="Publication")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_publication", referencedColumnName="id")
     * })
     */
    private $idPublication;



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
     * Set description
     *
     * @param string $description
     *
     * @return Commentaire
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Commentaire
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set likedislike
     *
     * @param string $likedislike
     *
     * @return Commentaire
     */
    public function setLikedislike($likedislike)
    {
        $this->likedislike = $likedislike;

        return $this;
    }

    /**
     * Get likedislike
     *
     * @return string
     */
    public function getLikedislike()
    {
        return $this->likedislike;
    }

    /**
     * Set idUser
     *
     * @param \ClientBundle\Entity\User $idUser
     *
     * @return Commentaire
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
     * Set idPublication
     *
     * @param \ClientBundle\Entity\Publication $idPublication
     *
     * @return Commentaire
     */
    public function setIdPublication(\ClientBundle\Entity\Publication $idPublication = null)
    {
        $this->idPublication = $idPublication;

        return $this;
    }

    /**
     * Get idPublication
     *
     * @return \ClientBundle\Entity\Publication
     */
    public function getIdPublication()
    {
        return $this->idPublication;
    }
}
