<?php
/**
 * Created by PhpStorm.
 * User: vezir
 * Date: 4/9/16
 * Time: 7:09 PM
 */

namespace AppBundle\Game;


use AppBundle\Entity\Move;
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

    public function updateGame(Move $move)
    {
        $player = $move->getPlayer();
        $opponent = $player->getOpponent();
        $game = $player->getGame();
        switch (true) {
            case $player->getCanStart():
                $game->manipulateCurrentNumber($move->getNumber());
                break;
            case $player->getHasTurn():
                $game->manipulateCurrentNumber($move->getNextNumber());
                break;
        }
        if ($game->getCurrentNumber() == self::WINNER_NUMBER) {
            $game->manipulateOver(true);
            $player->manipulateIsWinner(true);
        } else {
            $player->manipulateCanStart(false);
            $opponent->manipulateHasTurn(true);
        }
        if ($webhook = $opponent->getWebhook()) {
            // TODO: call webhook to inform opponent
        }
    }

}