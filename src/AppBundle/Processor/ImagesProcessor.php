<?php

namespace AppBundle\Processor;

use AppBundle\Manager\ImagesManager;
use Swarrot\Broker\Message;
use Swarrot\Processor\ProcessorInterface;

class ImagesProcessor implements ProcessorInterface
{
    private $manager;

    public function __construct(ImagesManager $manager)
    {
        $this->manager = $manager;
    }

    public function process(Message $message, array $options)
    {
        $body = json_decode($message->getBody(), true);

        $this->manager->process($body['filename']);
    }
}
