<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\Process\Launcher;

use spec\Webit\MessageBus\Infrastructure\Symfony\Process\AbstractObjectBehaviour;
use Symfony\Component\Process\Process;
use Webit\MessageBus\Infrastructure\Symfony\Process\Launcher\ByMessageTypeProcessFactory;
use Webit\MessageBus\Infrastructure\Symfony\Process\Launcher\Exception\UnsupportedMessageTypeException;
use Webit\MessageBus\Infrastructure\Symfony\Process\Launcher\ProcessFactory;

class ByMessageTypeProcessFactorySpec extends AbstractObjectBehaviour
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ByMessageTypeProcessFactory::class);
        $this->shouldBeAnInstanceOf(ProcessFactory::class);
    }

    function let()
    {
        $this->beConstructedWith([]);
    }

    function it_uses_factory_by_type(ProcessFactory $factory1, ProcessFactory $factory2, Process $process)
    {
        $this->beConstructedWith([
            $type1 = $this->randomString(4, 8) => $factory1,
            $type2 = $this->randomString(4, 8) => $factory2
        ]);

        $message = $this->randomMessage($type2);
        $factory2->create($message)->willReturn($process);
        $factory1->create($message)->shouldNotBeCalled();

        $this->create($message)->shouldBe($process);
    }

    function it_throws_exception_when_no_factory_matches()
    {
        $message = $this->randomMessage();
        $this->shouldThrow(UnsupportedMessageTypeException::class)->duringCreate($message);
    }
}
