<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Player;
use Doctrine\Common\Persistence\ManagerRegistry;
use Dunglas\ApiBundle\Event\DataEvent;

class CreateEventListener
{
    /**
     * @param DataEvent $event
     */
    public function onPreCreate(DataEvent $event)
    {
        $data = $event->getData();

        switch (true) {
            case ($data instanceof Player):
                //$resource = $event->getResource(); // Get the related instance of Dunglas\ApiBundle\Api\ResourceInterface
                
                break;
        }
    }
}
