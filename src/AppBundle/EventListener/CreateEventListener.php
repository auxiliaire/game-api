<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Move;
use AppBundle\Entity\Player;
use AppBundle\Game\Logic;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Dunglas\ApiBundle\Event\DataEvent;

class CreateEventListener
{
    /**
     * @var EntityManager
     */
    protected $em = null;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @param DataEvent $event
     */
    public function onPostCreate(DataEvent $event)
    {
        $data = $event->getData();
        //$resource = $event->getResource(); // Get the related instance of Dunglas\ApiBundle\Api\ResourceInterface

        $gameLogic = new Logic($this->em);
        switch (true) {
            case ($data instanceof Player):
                // Updating availability:
                $gameLogic->updateAvailability($data);
                break;
            case ($data instanceof Move):
                // Updating game:
                $gameLogic->updateGame($data);
                break;
        }
    }
}
