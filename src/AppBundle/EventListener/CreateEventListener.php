<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Move;
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

        switch (true) {
            case ($data instanceof Move):
                //$resource = $event->getResource(); // Get the related instance of Dunglas\ApiBundle\Api\ResourceInterface
                // Updating game:
                $gameLogic = new Logic($this->em);
                $gameLogic->updateGame($data);
                break;
        }
    }
}
