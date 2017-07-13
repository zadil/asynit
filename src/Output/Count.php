<?php

declare(strict_types = 1);

namespace Asynit\Output;

use Asynit\Test;

class Count implements OutputInterface
{
    private $succeed = 0;
    private $failed = 0;

    /**
     * {@inheritdoc}
     */
    public function update(Test $test, $debugOutput)
    {
        if ($test->getStatus() === Test::STATUS_SUCCESS) {
            $this->succeed++;
        }

        if ($test->getStatus() === Test::STATUS_FAILURE) {
            $this->failed++;
        }
    }

    /**
     * @return int
     */
    public function getSucceed() : int
    {
        return $this->succeed;
    }

    /**
     * @return int
     */
    public function getFailed() : int
    {
        return $this->failed;
    }
}
