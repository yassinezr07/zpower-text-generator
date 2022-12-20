<?php

namespace KnpU\LoremIpsumBundle\Controller;

use KnpU\LoremIpsumBundle\Event\FilterApiResponseEvent;
use KnpU\LoremIpsumBundle\KnpUIpsum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


class IpsumApiController extends AbstractController
{

    /**
     * @var KnpUIpsum
     */
    private $knpUIpsum;
    /**
     * @var EventDispatcherInterface|null
     */
    private $eventDispatcher;

    public function __construct(KnpUIpsum $knpUIpsum, ?EventDispatcherInterface $eventDispatcher)
    {
        $this->knpUIpsum = $knpUIpsum;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function index(): JsonResponse
    {
        $data = [
            'paragraphs' => $this->knpUIpsum->getParagraphs(),
            'sentences' => $this->knpUIpsum->getSentences()
        ];

        $event = new FilterApiResponseEvent($data);
        $this->eventDispatcher->dispatch($event, FilterApiResponseEvent::NAME);

        return $this->json($event->getData());

    }
}