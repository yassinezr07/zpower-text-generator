<?php


namespace KnpU\LoremIpsumBundle\EventSubscriber;

use KnpU\LoremIpsumBundle\Event\FilterApiResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AddMessageToIpsumApiSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            FilterApiResponseEvent::NAME => 'onFilterApi'
        ];
    }

    public function onFilterApi(FilterApiResponseEvent $event)
    {

        $data = $event->getData();
        $data['message'] = 'Have a magical day!';
        $event->setData($data);
    }
}