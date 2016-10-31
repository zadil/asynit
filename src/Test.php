<?php

namespace Asynit;

use Asynit\Runner\FutureHttp;
use Asynit\Runner\FutureHttpPool;
use Http\Client\HttpAsyncClient;

/**
 * A test.
 */
class Test
{
    /** @var Test[] */
    private $parents = [];

    /** @var Test[] */
    private $children = [];

    /** @var array */
    private $arguments;

    /** @var \ReflectionMethod */
    private $method;

    /** @var FutureHttpPool */
    private $futureHttpPool;

    /** @var HttpAsyncClient */
    private $httpClient;

    public function __construct(\ReflectionMethod $reflectionMethod)
    {
        $this->method = $reflectionMethod;
        $this->arguments = [];
        $this->futureHttpPool = new FutureHttpPool();
    }

    /**
     * Return an unique identifier for this test.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return sprintf(
            '%s::%s',
            $this->method->getDeclaringClass()->getName(),
            $this->method->getName()
        );
    }

    /**
     * @return FutureHttpPool
     */
    public function getFutureHttpPool()
    {
        return $this->futureHttpPool;
    }

    /**
     * @return \ReflectionMethod
     */
    public function getMethod()
    {
        return $this->method;
    }

    public function addChildren(Test $test)
    {
        $this->children[] = $test;
    }

    public function addParent(Test $test)
    {
        $this->parents[] = $test;
    }

    public function addArgument(&$argument, Test $test)
    {
        $this->arguments[$test->getIdentifier()] = &$argument;
    }

    /**
     * @return Test[]
     */
    public function getParents()
    {
        return $this->parents;
    }

    /**
     * @return Test[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        $args = [];

        foreach ($this->getParents() as $parent) {
            $args[] = $this->arguments[$parent->getIdentifier()];
        }

        return $args;
    }

    /**
     * @param FutureHttp[] $futureHttps
     * @param Test         $test
     */
    public function mergeFutureHttp($futureHttps, Test $test)
    {
        foreach ($futureHttps as $futureHttp) {
            $futureHttp->setTest($test);
        }

        $this->futureHttpPool->merge($futureHttps);
    }

    /**
     * @return HttpAsyncClient
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @param HttpAsyncClient $httpClient
     */
    public function setHttpClient($httpClient)
    {
        $this->httpClient = $httpClient;
    }
}
