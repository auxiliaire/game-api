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
    const MAX_PLAYERS = 2;
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
     * @ORM\Column(nullable=false, type="boolean")
     * @Assert\Type(type="boolean")
     */
    protected $available = true;
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
     * @ORM\Column(nullable=false, type="boolean")
     * @Assert\Type(type="boolean")
     */
    protected $over = false;

    public function __construct() {
        $this->players = new ArrayCollection();
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
     * Set available
     *
     * @param boolean $available
     * @return Game
     */
    protected function setAvailable($available)
    {
        if ($available !== null) {
            $this->available = $available;
        }

        return $this;
    }

    /**
     * Get available
     *
     * @return boolean
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * Set currentNumber
     *
     * @param integer $currentNumber
     * @return Game
     */
    protected function setCurrentNumber($currentNumber)
    {
        $this->currentNumber = $currentNumber;

        return $this;
    }

    /**
     * Get currentNumber
     *
     * @return integer 
     */
    public function getCurrentNumber()
    {
        return $this->currentNumber;
    }

    /**
     * Set over
     *
     * @param boolean $over
     * @return Game
     */
    protected function setOver($over)
    {
        if ($over !== null) {
            $this->over = $over;
        }

        return $this;
    }

    /**
     * Get over
     *
     * @return boolean 
     */
    public function getOver()
    {
        return $this->over;
    }

    /**
     * Add players
     *
     * @param \AppBundle\Entity\Player $players
     * @return Game
     */
    public function addPlayer(Player $players)
    {
        if ($this->players->count() < self::MAX_PLAYERS) {
            $this->players[] = $players;
            if ($this->players->count() == self::MAX_PLAYERS) {
                $this->setAvailable(false);
            }
        } else {
            throw new \InvalidArgumentException("This is a " . self::MAX_PLAYERS . " players game");
        }

        return $this;
    }

    /**
     * Remove players
     *
     * @param \AppBundle\Entity\Player $players
     */
    public function removePlayer(Player $players)
    {
        $this->players->removeElement($players);
    }

    /**
     * Get players
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPlayers()
    {
        return $this->players;
    }
}
