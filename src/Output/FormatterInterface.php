<?php

namespace Asynit\Output;

use Asynit\Test;

interface FormatterInterface
{
    public function format(Test $test) : string;
}