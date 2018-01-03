<?php

namespace Webit\MessageBus\Infrastructure\Symfony\Process\Launcher;

use Webit\MessageBus\Message;

final class AsynchronousProcessLauncher implements ProcessLauncher
{
    /** @var ProcessFactory */
    private $processFactory;

    /** @var ParallelProcessManager */
    private $processManager;

    public function __construct(ProcessFactory $processFactory, ParallelProcessManager $processManager)
    {
        $this->processFactory = $processFactory;
        $this->processManager = $processManager;
    }

    public function launchProcess(Message $message)
    {
        $this->processManager->startProcess($this->processFactory->create($message));
    }
}