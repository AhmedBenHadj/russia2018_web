<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Score
 *
 * @ORM\Table(name="score")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="ClientBundle\Repository\ScoreRepository")
 */
class Score
{
    /**
     * @var integer
     *
     * @ORM\Column(name="A", type="integer", nullable=false)
     */
    private $a;

    /**
     * @var integer
     *
     * @ORM\Column(name="B", type="integer", nullable=false)
     */
    private $b;

    /**
     * @var \Match2018
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Match2018")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $id;



    /**
     * Set a
     *
     * @param integer $a
     *
     * @return Score
     */
    public function setA($a)
    {
        $this->a = $a;

        return $this;
    }

    /**
     * Get a
     *
     * @return integer
     */
    public function getA()
    {
        return $this->a;
    }

    /**
     * Set b
     *
     * @param integer $b
     *
     * @return Score
     */
    public function setB($b)
    {
        $this->b = $b;

        return $this;
    }

    /**
     * Get b
     *
     * @return integer
     */
    public function getB()
    {
        return $this->b;
    }

    /**
     * Set id
     *
     * @param \ClientBundle\Entity\Match2018 $id
     *
     * @return Score
     */
    public function setId(\ClientBundle\Entity\Match2018 $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return \ClientBundle\Entity\Match2018
     */
    public function getId()
    {
        return $this->id;

    }



}
