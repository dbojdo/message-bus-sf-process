<?php

namespace Webit\MessageBus\Infrastructure\Symfony\Process\Launcher;

use Symfony\Component\Process\Process;
use Webit\MessageBus\Infrastructure\Symfony\Process\Launcher\Exception\ProcessPoolIsFullException;

class ParallelProcessManager
{
    /** @var int */
    private $maxRunningProcesses;

    /** @var Process[] */
    private $processes;

    public function __construct(int $maxRunningProcesses = 5)
    {
        $this->maxRunningProcesses = $maxRunningProcesses;
        $this->processes = [];
    }

    public function startProcess(Process $process)
    {
        do {
            $exception = null;
            $this->checkRunningProcesses();
            try {
                $this->tryStartProcess($process);
            } catch (ProcessPoolIsFullException $e) {
                $exception = $e;
                usleep(200000); // 0.2 s
            }
        } while ($exception);
    }

    private function checkRunningProcesses()
    {
        $currentProcesses = $this->processes;

        foreach ($currentProcesses as $k => $process) {
            if (!$process->isRunning()) {
                $this->unsetProcess($k);
            }
        }

        $this->processes = array_values($this->processes);
    }

    private function unsetProcess($key)
    {
        unset($this->processes[$key]);
    }

    private function tryStartProcess(Process $process)
    {
        if (count($this->processes) >= $this->maxRunningProcesses) {
            throw ProcessPoolIsFullException::forProcess($process);
        }

        $this->processes[md5(mt_rand(0, mt_rand()).microtime())] = $process;
        $process->start();
    }
}