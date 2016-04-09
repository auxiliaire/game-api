<?php
/**
 * Created by PhpStorm.
 * User: vezir
 * Date: 4/9/16
 * Time: 7:09 PM
 */

namespace AppBundle\Game;


use AppBundle\Entity\Move;
use AppBundle\Entity\Player;
use Doctrine\ORM\EntityManager;

class Logic
{
    const WINNER_NUMBER = 1;

    /**
     * @var EntityManager|null
     */
    private $em = null;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Locks game by setting availability to false when opponent is present
     *
     * @param Player $player
     */
    public function updateAvailability(Player $player)
    {
        if ($player->getOpponent()) {
            $game = $player->getGame();
            $game->manipulateAvailable(false);
            $this->em->persist($game);
            $this->em->flush();
        }
    }

    /**
     * Updates game components according to the result of the move
     *
     * @param Move $move
     */
    public function updateGame(Move $move)
    {
        $player = $move->getPlayer();
        $opponent = $player->getOpponent();
        $game = $player->getGame();
        switch (true) {
            case $player->getCanStart():
                $game->manipulateCurrentNumber($move->getNumber());
                $opponent->manipulateCanJoin(false);
                break;
            case $player->getHasTurn():
                $game->manipulateCurrentNumber($move->getNextNumber());
                break;
        }
        if ($game->getCurrentNumber() == self::WINNER_NUMBER) {
            $game->manipulateOver(true);
            $player->manipulateIsWinner(true);
            $player->manipulateHasTurn(false);
            $opponent->manipulateHasTurn(false);
        } else {
            $player->manipulateCanStart(false);
            $player->manipulateHasTurn(false);
            $opponent->manipulateHasTurn(true);
        }
        $this->em->persist($player);
        $this->em->persist($opponent);
        $this->em->persist($game);
        $this->em->flush();
        if ($webhook = $opponent->getWebhook()) {
            // TODO: call webhook to inform opponent
        }
    }

}