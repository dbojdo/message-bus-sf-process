<?php

namespace Webit\MessageBus\Infrastructure\Symfony\Process\Launcher;

use Webit\MessageBus\Message;

interface ProcessLauncher
{
    public function launchProcess(Message $message);
}