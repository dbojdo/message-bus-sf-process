<?php

namespace Webit\MessageBus\Infrastructure\Symfony\Process;

use Webit\MessageBus\Infrastructure\Symfony\Process\Launcher\Exception\UnsupportedMessageTypeException;
use Webit\MessageBus\Infrastructure\Symfony\Process\Launcher\ProcessLauncher;
use Webit\MessageBus\Message;
use Webit\MessageBus\Publisher;
use Webit\MessageBus\Publisher\Exception\CannotPublishMessageException;
use Webit\MessageBus\Publisher\Exception\UnsupportedMessageTypeException as PublisherUnsupportedMessageTypeException;

final class ProcessPublisher implements Publisher
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
    public function publish(Message $message)
    {
        try {
            $this->processLauncher->launchProcess($message);
        } catch (UnsupportedMessageTypeException $e) {
            throw PublisherUnsupportedMessageTypeException::forMessage($message, 0, $e);
        } catch (\Exception $e) {
            throw CannotPublishMessageException::forMessage($message, 0, $e);
        }
    }
}
