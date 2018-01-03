<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\Process\Launcher;

use Symfony\Component\Process\Process;
use Webit\MessageBus\Infrastructure\Symfony\Process\Launcher\ParallelProcessManager;
use PhpSpec\ObjectBehavior;

class ParallelProcessManagerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ParallelProcessManager::class);
    }

    function let()
    {
        $this->beConstructedWith($maxParallelProcesses = 5);
    }

    function it_runs_process_when_pool_is_capable()
    {
        $this->beConstructedWith(1);
        $process = \Mockery::mock(Process::class);
        $process->shouldReceive('start')->once();
        $this->startProcess($process);
    }

    function it_should_wait_until_poll_is_capable()
    {
        $this->beConstructedWith(1);

        $process1 = \Mockery::mock(Process::class);
        $process1->shouldReceive('start')->once();

        $this->startProcess($process1);

        $process1->shouldReceive('isRunning')->andReturn(true, false);

        $process2 = \Mockery::mock(Process::class);
        $process2->shouldReceive('start')->once();

        $this->startProcess($process2);
    }

    function letGo()
    {
        \Mockery::close();
    }
}
