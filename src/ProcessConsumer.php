<?php

namespace Webit\MessageBus\Infrastructure\Symfony\Process;

use Webit\MessageBus\Consumer;
use Webit\MessageBus\Consumer\Exception\CannotConsumeMessageException;
use Webit\MessageBus\Consumer\Exception\UnsupportedMessageTypeException as ConsumerUnsupportedMessageTypeException;
use Webit\MessageBus\Infrastructure\Symfony\Process\Launcher\Exception\UnsupportedMessageTypeException;
use Webit\MessageBus\Infrastructure\Symfony\Process\Launcher\ProcessLauncher;
use Webit\MessageBus\Message;

final class ProcessConsumer implements Consumer
{
    /** @var ProcessLauncher */
    private $processLauncher;

    public function __construct(ProcessLauncher $processLauncher)
    {
        $this->processLauncher = $processLauncher;
    }

    /**
     * @inheritdoc
     */
    public function consume(Message $message)
    {
        try {
            $this->processLauncher->launchProcess($message);
        } catch (UnsupportedMessageTypeException $e) {
            throw ConsumerUnsupportedMessageTypeException::forMessage($message, 0, $e);
        } catch (\Exception $e) {
            throw CannotConsumeMessageException::forMessage($message, 0, $e);
        }
    }
}