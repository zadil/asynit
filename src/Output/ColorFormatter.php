<?php

declare(strict_types=1);

namespace Asynit\Output;

use Asynit\Test;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class ColorFormatter implements FormatterInterface
{
    /** @var OutputFormatterStyle  */
    private $outputFormatFail;

    /** @var OutputFormatterStyle  */
    private $outputFormatPending;

    /** @var OutputFormatterStyle  */
    private $outputFormatSuccess;

    public function __construct()
    {
        $this->outputFormatFail = new OutputFormatterStyle('white', 'red', ['bold']);
        $this->outputFormatPending = new OutputFormatterStyle('black', 'yellow', ['bold']);
        $this->outputFormatSuccess = new OutputFormatterStyle('black', 'green', ['bold']);
    }

    public function format(Test $test) : string
    {
        if ($test->getStatus() === Test::STATUS_PENDING) {
            return $this->formatStepTest($test);
        }

        if ($test->getStatus() === Test::STATUS_SUCCESS) {
            return $this->formatSuccessTest($test);
        }

        if ($test->getStatus() === Test::STATUS_FAILURE) {
            return $this->formatFailedTest($test);
        }

        return '';
    }

    private function formatStepTest(Test $test) : string
    {
        return sprintf(
            "%s %s%s\n",
            $this->outputFormatPending->apply('Pending'),
            $test->getIdentifier(),
            $this->createAssertionMessage($test)
        );
    }

    private function formatFailedTest(Test $test) : string
    {
        return sprintf(
            "%s %s\n\t\u{2715} %s%s\n",
            $this->outputFormatFail->apply('Failure'),
            $test->getIdentifier(),
            $test->getFailure()->getMessage(),
            $this->createAssertionMessage($test)
        );
    }

    private function formatSuccessTest(Test $test) : string
    {
        return sprintf(
            "%s %s%s\n",
            $this->outputFormatSuccess->apply('Success'),
            $test->getIdentifier(),
            $this->createAssertionMessage($test)
        );
    }

    private function createAssertionMessage(Test $test) : string
    {
        $text = "";

        foreach ($test->getAssertions() as $assertion) {
            $text .= sprintf("\n\t\u{2714} %s", $assertion);
        }

        return $text;
    }
}
