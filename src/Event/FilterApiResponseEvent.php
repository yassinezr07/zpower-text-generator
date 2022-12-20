<?php

namespace KnpU\LoremIpsumBundle\Event;


use Symfony\Contracts\EventDispatcher\Event;

class FilterApiResponseEvent extends Event
{

    const NAME = 'response.filter';

    /**
     * @var array
     */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }


}