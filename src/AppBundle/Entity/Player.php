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
    const CONTROL_AUTO   = 'auto';
    const CONTROL_MANUAL = 'manual';
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
     * @ORM\Column(nullable=false, type="string")
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     * @Assert\Choice(choices = {"auto", "manual"}, message = "The value should be either 'auto' or 'manual'.")
     */
    protected $control;
    /**
     * @var boolean Tells whether the player can join the game
     *
     * @ORM\Column(nullable=false, type="boolean")
     * @Assert\Type(type="boolean")
     */
    protected $canJoin = false;
    /**
     * @var boolean Tells whether the player can start a new game
     *
     * @ORM\Column(nullable=false, type="boolean")
     * @Assert\Type(type="boolean")
     */
    protected $canStart = false;
    /**
     * @var boolean Tells whether the player is in turn
     *
     * @ORM\Column(nullable=false, type="boolean")
     * @Assert\Type(type="boolean")
     */
    protected $hasTurn = false;
    /**
     * @var boolean Tells whether the player is the winner
     *
     * @ORM\Column(nullable=false, type="boolean")
     * @Assert\Type(type="boolean")
     */
    protected $isWinner = false;
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
     * @ORM\Column(nullable=true, type="string")
     * @Assert\Url()
     */
    protected $webhook;

    public function __construct() {
        $this->moves = new ArrayCollection();
    }


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
     * Set name
     *
     * @param string $name
     * @return Player
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set control
     *
     * @param string $control
     * @return Player
     */
    public function setControl($control)
    {
        if (!in_array($control, array(self::CONTROL_AUTO, self::CONTROL_MANUAL))) {
            throw new \InvalidArgumentException("Invalid control type value. Only 'auto' and 'manual' allowed.");
        }
        $this->control = $control;

        return $this;
    }

    /**
     * Get control
     *
     * @return string 
     */
    public function getControl()
    {
        return $this->control;
    }

    /**
     * Set canJoin
     *
     * @param boolean $canJoin
     * @return Player
     */
    protected function setCanJoin($canJoin)
    {
        if ($this->canJoin !== null) {
            $this->canJoin = $canJoin;
        }

        return $this;
    }

    /**
     * Get canJoin
     *
     * @return boolean 
     */
    public function getCanJoin()
    {
        return $this->canJoin;
    }

    /**
     * Set canStart
     *
     * @param boolean $canStart
     * @return Player
     */
    protected function setCanStart($canStart)
    {
        if ($this->canStart !== null) {
            $this->canStart = $canStart;
        }

        return $this;
    }

    /**
     * Get canStart
     *
     * @return boolean 
     */
    public function getCanStart()
    {
        return $this->canStart;
    }

    /**
     * Set hasTurn
     *
     * @param boolean $hasTurn
     * @return Player
     */
    protected function setHasTurn($hasTurn)
    {
        if ($this->hasTurn !== null) {
            $this->hasTurn = $hasTurn;
        }

        return $this;
    }

    /**
     * Get hasTurn
     *
     * @return boolean 
     */
    public function getHasTurn()
    {
        return $this->hasTurn;
    }

    /**
     * Set setIsWinner
     *
     * @param boolean $isWinner
     * @return Player
     */
    protected function setIsWinner($isWinner)
    {
        if ($this->isWinner !== null) {
            $this->isWinner = $isWinner;
        }

        return $this;
    }

    /**
     * Get isWinner
     *
     * @return boolean
     */
    public function getIsWinner()
    {
        return $this->isWinner;
    }

    /**
     * Set webhook
     *
     * @param string $webhook
     * @return Player
     */
    public function setWebhook($webhook)
    {
        $this->webhook = $webhook;

        return $this;
    }

    /**
     * Get webhook
     *
     * @return string 
     */
    public function getWebhook()
    {
        return $this->webhook;
    }

    /**
     * Set game
     *
     * @param \AppBundle\Entity\Game $game
     * @return Player
     */
    public function setGame(Game $game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return \AppBundle\Entity\Game 
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Add moves
     *
     * @param \AppBundle\Entity\Move $moves
     * @return Player
     */
    public function addMove(Move $moves)
    {
        $this->moves[] = $moves;

        return $this;
    }

    /**
     * Remove moves
     *
     * @param \AppBundle\Entity\Move $moves
     */
    public function removeMove(Move $moves)
    {
        $this->moves->removeElement($moves);
    }

    /**
     * Get moves
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMoves()
    {
        return $this->moves;
    }
}
