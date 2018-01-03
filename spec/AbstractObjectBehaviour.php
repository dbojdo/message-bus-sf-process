<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\Process;

use PhpSpec\ObjectBehavior;
use Webit\MessageBus\Message;
use Webit\Tests\Unit\RandomValuesTrait;

abstract class AbstractObjectBehaviour extends ObjectBehavior
{
    use RandomValuesTrait;

    protected function randomMessage(string $type = null): Message
    {
        return new Message(
            $type ?: $this->randomString(4, 8),
            $this->randomString(4, 8)
        );
    }
}