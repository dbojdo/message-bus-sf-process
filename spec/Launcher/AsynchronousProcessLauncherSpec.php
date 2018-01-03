<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\Process\Launcher;

use spec\Webit\MessageBus\Infrastructure\Symfony\Process\AbstractObjectBehaviour;
use Symfony\Component\Process\Process;
use Webit\MessageBus\Infrastructure\Symfony\Process\Launcher\AsynchronousProcessLauncher;
use Webit\MessageBus\Infrastructure\Symfony\Process\Launcher\ParallelProcessManager;
use Webit\MessageBus\Infrastructure\Symfony\Process\Launcher\ProcessFactory;
use Webit\MessageBus\Infrastructure\Symfony\Process\Launcher\ProcessLauncher;

class AsynchronousProcessLauncherSpec extends AbstractObjectBehaviour
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AsynchronousProcessLauncher::class);
        $this->shouldBeAnInstanceOf(ProcessLauncher::class);
    }

    function let(ProcessFactory $processFactory, ParallelProcessManager $processManager)
    {
        $this->beConstructedWith($processFactory, $processManager);
    }

    function it_starts_parallel_process(ProcessFactory $processFactory, ParallelProcessManager $processManager, Process $process)
    {
        $processFactory->create($message = $this->randomMessage())->willReturn($process);
        $processManager->startProcess($process)->shouldBeCalled();

        $this->launchProcess($message);
    }
}
