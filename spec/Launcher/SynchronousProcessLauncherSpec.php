<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\Process\Launcher;

use spec\Webit\MessageBus\Infrastructure\Symfony\Process\AbstractObjectBehaviour;
use Symfony\Component\Process\Process;
use Webit\MessageBus\Infrastructure\Symfony\Process\Launcher\ProcessFactory;
use Webit\MessageBus\Infrastructure\Symfony\Process\Launcher\ProcessLauncher;
use Webit\MessageBus\Infrastructure\Symfony\Process\Launcher\SynchronousProcessLauncher;

class SynchronousProcessLauncherSpec extends AbstractObjectBehaviour
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SynchronousProcessLauncher::class);
        $this->shouldBeAnInstanceOf(ProcessLauncher::class);
    }

    function let(ProcessFactory $factory)
    {
        $this->beConstructedWith($factory);
    }

    function it_must_run_process(ProcessFactory $factory, Process $process)
    {
        $factory->create($message = $this->randomMessage())->willReturn($process);
        $process->mustRun()->shouldBeCalled();
        $this->launchProcess($message);
    }
}
