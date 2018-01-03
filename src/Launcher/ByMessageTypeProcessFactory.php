<?php

namespace Webit\MessageBus\Infrastructure\Symfony\Process\Launcher;

use Webit\MessageBus\Infrastructure\Symfony\Process\Launcher\Exception\UnsupportedMessageTypeException;
use Webit\MessageBus\Message;

final class ByMessageTypeProcessFactory implements ProcessFactory
{
    /** @var ProcessFactory[] */
    private $factories;

    public function __construct(array $factories)
    {
        $this->factories = $factories;
    }

    /**
     * @inheritdoc
     */
    public function create(Message $message)
    {
        if (isset($this->factories[$message->type()])) {
            return $this->factories[$message->type()]->create($message);
        }

        throw UnsupportedMessageTypeException::forMessage($message);
    }
}