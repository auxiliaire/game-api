<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The Game data container
 *
 * @ORM\Entity
 */
class Game
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var boolean Tells whether the game is available for playing
     *
     * @ORM\Column(nullable=false, type="integer", options={"default":true})
     * @Assert\Type(type="boolean")
     */
    protected $available;
    /**
     * @var int The current number of the game
     *
     * @ORM\Column(nullable=true, type="integer")
     * @Assert\Type(type="int")
     * @Assert\Range(
     *     min="2",
     *     max="100"
     * )
     */
    protected $currentNumber;
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity="Player", mappedBy="game")
     */
    protected $players;
    /**
     * @var boolean Tells whether the game is over
     *
     * @ORM\Column(nullable=false, type="boolean", options={"default":false})
     */
    protected $over;

    public function __construct() {
        $this->players = new ArrayCollection();
    }

}