<?php

namespace Asynit\Output;

use Asynit\Test;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class Simple implements OutputInterface
{
    private $formatter;

    public function __construct()
    {
        $this->formatter = new ColorFormatter();
    }

    public function update(Test $test, $debugOutput)
    {
        if ($test->getStatus() !== Test::STATUS_PENDING) {
            fwrite(STDOUT, $this->formatter->format($test));
            fwrite(STDOUT, $debugOutput);
        }
    }
}
