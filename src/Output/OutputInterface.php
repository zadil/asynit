<?php

namespace Asynit\Output;

use Asynit\Test;

/**
 * Interface for displaying tests.
 */
interface OutputInterface
{
    /**
     * Update output as a test has been updated
     *
     * @param Test   $test
     * @param string $debugOutput
     *
     * @return mixed
     */
    public function update(Test $test, $debugOutput);
}
