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
class Player
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
     * @var string The player's name
     *
     * @ORM\Column(nullable=false, type="string")
     * @Assert\NotBlank()
     * @Assert\Type(type="alpha")
     */
    protected $name;
    /**
     * @var string The type of the control the user has chosen: auto | manual
     *
     * @ORM\Column(nullable=true, type="string", columnDefinition="enum('auto', 'manual')", options={"default":"auto"})
     * @Assert\Type(type="boolean")
     */
    protected $control;
    /**
     * @var boolean Tells whether the player can join the game
     *
     * @ORM\Column(nullable=false, type="boolean")
     * @Assert\NotBlank()
     * @Assert\Type(type="boolean")
     */
    protected $canJoin;
    /**
     * @var boolean Tells whether the player can start a new game
     *
     * @ORM\Column(nullable=false, type="boolean")
     * @Assert\NotBlank()
     * @Assert\Type(type="boolean")
     */
    protected $canStart;
    /**
     * @var boolean Tells whether the player is in turn
     *
     * @ORM\Column(nullable=false, type="boolean")
     * @Assert\NotBlank()
     * @Assert\Type(type="boolean")
     */
    protected $hasTurn;
    /**
     * @var Game The game the player take participate in
     *
     * @ORM\ManyToOne(targetEntity="Game")
     * @ORM\JoinColumn(name="game_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank()
     */
    protected $game;
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity="Move", mappedBy="player")
     */
    protected $moves;
    /**
     * @var string The webhook to call when player is required to take action
     *
     * @ORM\Column(nullable=false, type="string")
     * @Assert\NotBlank()
     * @Assert\Url()
     */
    protected $webhook;

    public function __construct() {
        $this->moves = new ArrayCollection();
    }

}