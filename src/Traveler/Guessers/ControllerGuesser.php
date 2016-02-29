<?php

namespace Traveler\Guessers;

use \Traveler\Invokers\ControllerInvokerInterface;

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
    private $defaultClassSegment  = 'default';

    /**
     * @var array
     */
    private $httpMethods  = [
        'GET', 'HEAD', 'POST', 'PATCH', 'PUT', 'DELETE',
        'LINK', 'UNLINK', 'OPTIONS',
    ];

    /**
     * @var string
     */
    private $namespace;

    /**
     * @var \Traveler\Invokers\ControllerInvokerInterface
     */
    private $invoker;

    /**
     * @param string $controllerNamespace
     * @param \Traveler\Invokers\ControllerInvokerInterface $invoker
     *
     * @codeCoverageIgnore
     */
    public function __construct($controllerNamespace, ControllerInvokerInterface $invoker)
    {
        $this->namespace = $controllerNamespace;
        $this->invoker = $invoker;
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

        $classSegment  = (count($segments) > 0) ? $segments[0] : $this->defaultClassSegment;
        $methodSegment = (count($segments) > 1) ? $segments[1] : $this->defaultMethodSegment;

        $this->invoker->setClass($this->namespace.'\\'.ucfirst($classSegment).'Controller');
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
