<?php

namespace glen\PhpCsFixerConfig;

use Symfony\Component\Process\Process;

class ProcessRunner
{
    /**
     * DRY wrapper to run program and capture it's output using Symfony Process Component
     *
     * @param string $command
     * @return string
     */
    public static function run($command)
    {
        $process = new Process($command);
        $process->mustRun();

        $output = $process->getOutput();

        // omit the final newline from output
        return rtrim($output, PHP_EOL);
    }
}
