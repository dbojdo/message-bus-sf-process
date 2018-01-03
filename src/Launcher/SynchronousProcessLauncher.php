<?php

namespace Webit\MessageBus\Infrastructure\Symfony\Process\Launcher;

use Webit\MessageBus\Message;

final class SynchronousProcessLauncher implements ProcessLauncher
{
    /** @var ProcessFactory */
    private $processFactory;

    public function __construct(ProcessFactory $processFactory)
    {
        $this->processFactory = $processFactory;
    }

    public function launchProcess(Message $message)
    {
        $process = $this->processFactory->create($message);
        $process->mustRun();
    }
}
