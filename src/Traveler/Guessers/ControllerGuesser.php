<?php

namespace Traveler\Guessers;

use Traveler\Invokers\ControllerInvokerInterface;
use Traveler\Guessers\Namespaces\NamespacesGuesserInterface;

/**
 * Guesses controller to call for router
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
class ControllerGuesser implements ControllerGuesserInterface
{
    /**
     * @var string
     */
    private $defaultMethodSegment = 'default';

    /**
     * @var string
     */
    private $defaultClassSegment = 'default';

    /**
     * @var array
     */
    private $httpMethods = [
        'GET', 'HEAD', 'POST', 'PATCH', 'PUT', 'DELETE',
        'LINK', 'UNLINK', 'OPTIONS',
    ];

    /**
     * @var \Traveler\Guessers\Namespaces\NamespacesGuesserInterface
     */
    private $namespaceGuesser;

    /**
     * @var \Traveler\Invokers\ControllerInvokerInterface
     */
    private $invoker;

    /**
     * @param \Traveler\Guessers\Namespaces\NamespacesGuesserInterface $namespaceGuesser
     * @param \Traveler\Invokers\ControllerInvokerInterface            $invoker
     *
     * @codeCoverageIgnore
     */
    public function __construct(NamespacesGuesserInterface $namespaceGuesser, ControllerInvokerInterface $invoker)
    {
        $this->namespaceGuesser = $namespaceGuesser;
        $this->invoker          = $invoker;
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
        $this->validateHttpMethod($httpMethod);

        $lastSegments  = array_slice($segments, -2);
        $classSegment  = (count($lastSegments) > 0) ? $lastSegments[0] : $this->defaultClassSegment;
        $methodSegment = (count($lastSegments) > 1) ? $lastSegments[1] : $this->defaultMethodSegment;
        $namespace     = $this->namespaceGuesser->guess($segments);

        $this->invoker->setClass($namespace.'\\'.ucfirst($classSegment).'Controller');
        $this->invoker->setMethod(strtolower($httpMethod).ucfirst($methodSegment));

        return $this->invoker;
    }

    /**
     * Ensure that http method is supported
     *
     * @param string $httpMethod
     *
     * @throws \DomainException
     */
    private function validateHttpMethod($httpMethod)
    {
        if (!in_array($httpMethod, $this->httpMethods, true)) {
            throw new \DomainException(
                "Unsupported http method $httpMethod, supported methods: ".
                implode(', ', $this->httpMethods)
            );
        }
    }

    /**
     * @param string $defaultMethodSegment
     *
     * @codeCoverageIgnore
     */
    public function setDefaultMethodSegment($defaultMethodSegment)
    {
        $this->defaultMethodSegment = $defaultMethodSegment;
    }

    /**
     * @param string $defaultClassSegment
     *
     * @codeCoverageIgnore
     */
    public function setDefaultClassSegment($defaultClassSegment)
    {
        $this->defaultClassSegment = $defaultClassSegment;
    }

    /**
     * @param array $httpMethods
     *
     * @codeCoverageIgnore
     */
    public function setSupportedHttpMethods(array $httpMethods)
    {
        $this->httpMethods = $httpMethods;
    }
}
