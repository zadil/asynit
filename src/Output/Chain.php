<?php

declare(strict_types = 1);

namespace Asynit\Output;

use Asynit\Test;

class Chain implements OutputInterface
{
    /** @var OutputInterface[] */
    private $outputs = [];

    /**
     * Add output to the chain
     *
     * @param OutputInterface $output
     */
    public function addOutput(OutputInterface $output)
    {
        $this->outputs[] = $output;
    }

    /**
     * {@inheritdoc}
     */
    public function update(Test $test, $debugOutput)
    {
        foreach ($this->outputs as $output) {
            $output->update($test, $debugOutput);
        }
    }
}
