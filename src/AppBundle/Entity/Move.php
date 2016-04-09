<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The Game data container
 *
 * @ORM\Entity
 */
class Move
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
}
