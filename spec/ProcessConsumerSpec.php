<?php

namespace spec\Webit\MessageBus\Infrastructure\Symfony\Process;

use Webit\MessageBus\Consumer;
use Webit\MessageBus\Infrastructure\Symfony\Process\Launcher\Exception\UnsupportedMessageTypeException;
use Webit\MessageBus\Infrastructure\Symfony\Process\Launcher\ProcessLauncher;
use Webit\MessageBus\Infrastructure\Symfony\Process\ProcessConsumer;

class ProcessConsumerSpec extends AbstractObjectBehaviour
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ProcessConsumer::class);
        $this->shouldBeAnInstanceOf(Consumer::class);
    }

    function let(ProcessLauncher $processLauncher)
    {
        $this->beConstructedWith($processLauncher);
    }

    function it_launches_the_process_for_message(ProcessLauncher $processLauncher)
    {
        $message = $this->randomMessage();
        $processLauncher->launchProcess($message)->shouldBeCalled();
        $this->consume($message);
    }

    function it_throws_cannot_publish_unsupported_message_type_exception(ProcessLauncher $processLauncher)
    {
        $message = $this->randomMessage();
        $processLauncher->launchProcess($message)->willThrow(UnsupportedMessageTypeException::class);
        $this->shouldThrow(Consumer\Exception\UnsupportedMessageTypeException::class)->duringConsume($message);
    }

    function it_throws_cannot_publish_exception_on_unknown_exception(ProcessLauncher $processLauncher)
    {
        $message = $this->randomMessage();
        $processLauncher->launchProcess($message)->willThrow(\Exception::class);
        $this->shouldThrow(Consumer\Exception\CannotConsumeMessageException::class)->duringConsume($message);
    }
}
