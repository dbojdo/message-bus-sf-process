<?php

namespace Webit\MessageBus\Infrastructure\Symfony\Process\Launcher\Exception;

use Webit\MessageBus\Message;

class UnsupportedMessageTypeException extends \RuntimeException
{
    /** @var Message */
    private $messageBusMessage;

    public static function forMessage(Message $message, $code = 0, \Exception $previous = null)
    {
        $exception = new self(
            sprintf('Message of type "%s" is not supported by this factory.', $message->type()),
            $code,
            $previous
        );

        $exception->messageBusMessage = $message;

        return $exception;
    }

    /**
     * @return Message
     */
    public function messageBusMessage(): Message
    {
        return $this->messageBusMessage;
    }
}