<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The Game data container
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Move
{
    const DIVIDER = 3;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var integer The number to start
     *
     * @ORM\Column(nullable=false, type="integer")
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     * @Assert\Range(
     *     min="2",
     *     max="100"
     * )
     */
    protected $number;
    /**
     * @var integer The value of the move
     *
     * @ORM\Column(nullable=false, type="integer")
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     * @Assert\Range(
     *     min="-1",
     *     max="1"
     * )
     */
    protected $step;
    /**
     * @var Player The player taking the move
     *
     * @ORM\ManyToOne(targetEntity="Player")
     * @ORM\JoinColumn(name="player_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank()
     */
    protected $player;


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
     * Set number
     *
     * @param integer $number
     * @return Move
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set step
     *
     * @param integer $step
     * @return Move
     */
    public function setStep($step)
    {
        $this->step = $step;

        return $this;
    }

    /**
     * Get step
     *
     * @return integer
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * Set player
     *
     * @param \AppBundle\Entity\Player $player
     * @return Move
     */
    public function setPlayer(Player $player)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player
     *
     * @return \AppBundle\Entity\Player 
     */
    public function getPlayer()
    {
        return $this->player;
    }

    public function getCalculatedNumber()
    {
        return $this->getNumber() + $this->getStep();
    }

    private $nextNumber = null;

    public function getNextNumber()
    {
        if ($this->nextNumber === null) {
            $this->nextNumber = ($this->getCalculatedNumber() / self::DIVIDER);
        }
        return $this->nextNumber;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $player = $this->getPlayer();
        if ($player->getGame()->getOver()) {
            throw new \InvalidArgumentException("The game is over!");
        } elseif (!$player->getOpponent()) {
            throw new \InvalidArgumentException("At least " . Game::NUM_PLAYERS . " player is required to play this game!");
        } elseif (!($player->getCanStart() || $player->getHasTurn())) {
            throw new \InvalidArgumentException("This move is not allowed for player!");
        } elseif ($player->getHasTurn()) {
            if (($this->getCalculatedNumber() % self::DIVIDER) != 0) {
                throw new \InvalidArgumentException("Step adding to the current number should result a number dividable by " . self::DIVIDER . " without modulus!");
            }
        }
    }
}
