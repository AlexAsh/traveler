<?php

namespace Traveler\Guessers;

use Traveler\Guessers\Namespaces\NamespacesGuesserInterface;
use Traveler\Guessers\Classes\ClassesGuesserInterface;
use Traveler\Guessers\Methods\MethodsGuesserInterface;
use Traveler\Invokers\ControllerInvoker;

/**
 * Facade for controller guessing module
 *
 * @codeCoverageIgnore
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
class ControllerGuesser implements ControllerGuesserInterface
{
    /**
     * @var \Traveler\Guessers\Namespaces\NamespacesGuesserInterface
     */
    private $namespaceGuesser;

    /**
     * @var \Traveler\Guessers\Classes\ClassesGuesserInterface
     */
    private $classGuesser;

    /**
     * @var \Traveler\Guessers\Methods\MethodsGuesserInterface
     */
    private $methodGuesser;

    /**
     * @param \Traveler\Guessers\Namespaces\NamespacesGuesserInterface $namespaceGuesser
     * @param \Traveler\Guessers\Classes\ClassesGuesserInterface       $classGuesser
     * @param \Traveler\Guessers\Methods\MethodsGuesserInterface       $methodGuesser
     */
    public function __construct(
        NamespacesGuesserInterface $namespaceGuesser,
        ClassesGuesserInterface    $classGuesser,
        MethodsGuesserInterface    $methodGuesser
    ) {
        $this->namespaceGuesser = $namespaceGuesser;
        $this->classGuesser     = $classGuesser;
        $this->methodGuesser    = $methodGuesser;
    }

    /**
     * Guess controller and action, throw \DomainException for unsupported http method
     *
     * @param array  $segments
     * @param string $httpMethod
     *
     * @return \Traveler\Invokers\ControllerInvokerInterface
     *
     * @throws \DomainException
     */
    public function guess(array $segments, $httpMethod)
    {
        $namespace = $this->namespaceGuesser->guess($segments);
        $class     = $this->classGuesser->guess($segments);
        $method    = $this->methodGuesser->guess($segments, $httpMethod);

        $invoker = $this->getInvoker();

        $invoker->setClass((strlen($namespace) > 0) ? $namespace.'\\'.$class : $class);
        $invoker->setMethod($method);

        return $invoker;
    }

    /**
     * Get controller invoker instance
     *
     * @return \Traveler\Invokers\ControllerInvokerInterface
     */
    protected function getInvoker()
    {
        return new ControllerInvoker();
    }
}
