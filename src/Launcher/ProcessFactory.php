<?php

namespace Webit\MessageBus\Infrastructure\Symfony\Process\Launcher;

use Symfony\Component\Process\Process;
use Webit\MessageBus\Message;

interface ProcessFactory
{
    /**
     * @param Message $message
     * @return Process
     */
    public function create(Message $message);
}
