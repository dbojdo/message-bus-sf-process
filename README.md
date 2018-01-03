# Message Bus - Symfony Process Infrastructure

Symfony Process infrastructure for Message Bus

## Installation

```bash
composer require webit/message-bus-sf-process=^1.0.0
```

## Usage

### ProcessFactory

To use both ***ProcessPublisher*** or ***ProcessConsumer*** instance of ***ProcessFactory*** is needed.

```php

use Webit\MessageBus\Infrastructure\Symfony\Process\Launcher\Exception\UnsupportedMessageTypeException;
use Webit\MessageBus\Message;
use Symfony\Component\Process\Process;

class MyProcessFactory implements ProcessFactory
{
    /**
     * @inheritdoc
     */
    public function create(Message $message)
    {
        return new Process(
            sprintf(
                '/usr/local/my-binary.php %s %s',
                $message->type(),
                $message->content()
            )
        );
    }
}
```

#### Synchronous ProcessLauncher

To run process synchronously use ***SynchronousProcessLauncher***

```php

use Webit\MessageBus\Infrastructure\Symfony\Process\Launcher\SynchronousProcessLauncher;

$myFactory = new MyProcessFactory();
$launcher = new SynchronousProcessLauncher($myFactory);
```

#### Asynchronous ProcessLauncher

To run process asynchronously use ***AsynchronousProcessLauncher***

```php

use Webit\MessageBus\Infrastructure\Symfony\Process\Launcher\ParallelProcessManager;
use Webit\MessageBus\Infrastructure\Symfony\Process\Launcher\AsynchronousProcessLauncher;

$myFactory = new MyProcessFactory();
$launcher = new AsynchronousProcessLauncher(
    $myFactory,
    new ParallelProcessManager($maxParallelProcessNumber = 5) // to run at most 5 parallel processes
);

```

### Publisher integration

Configured ***ProcessLauncher*** can be used with ***ProcessPublisher***

```php

use Webit\MessageBus\Infrastructure\Symfony\Process\ProcessPublisher;
use Webit\MessageBus\Message;

$publisher = new ProcessPublisher($launcher);
$publisher->publish(new Message('type', 'content'));
```


### Consumer integration

Configured ***ProcessLauncher*** can be used with ***ProcessConsumer***

```php

use Webit\MessageBus\Infrastructure\Symfony\Process\ProcessConsumer;
use Webit\MessageBus\Message;

$consumer = new ProcessConsumer($launcher);
$consumer->consume(new Message('type', 'content'));
```


## Running tests

Install dependencies with composer

```bash
docker-compose run --rm composer
docker-compose run --rm spec
```