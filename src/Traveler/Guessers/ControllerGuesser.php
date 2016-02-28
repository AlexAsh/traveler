<?php

namespace Traveler\Guessers;

/**
 * Description of ControllerGuesser
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
     * @param string $controllerNamespace
     */
    public function __construct($controllerNamespace)
    {
        $this->namespace = $controllerNamespace;
    }

    /**
     * Guess controller and action, throw \DomainException for unsupported http method
     *
     * @param array  $segments
     * @param string $httpMethod
     *
     * @return array ['class' => 'Namespace\Controller', 'method' => 'httpmethodAction']
     *
     * @throws \DomainException
     */
    public function guess(array $segments, $httpMethod)
    {
        $this->validateHttpMethod($httpMethod);

        $classSegment  = (count($segments) > 0) ? $segments[0] : $this->defaultClassSegment;
        $methodSegment = (count($segments) > 1) ? $segments[1] : $this->defaultMethodSegment;

        $class = $this->namespace.'\\'.ucfirst($classSegment).'Controller';
        $method = strtolower($httpMethod).ucfirst($methodSegment);

        return ['class' => $class, 'method' => $method];
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
     */
    public function setDefaultMethodSegment($defaultMethodSegment)
    {
        $this->defaultMethodSegment = $defaultMethodSegment;
    }

    /**
     * @param string $defaultClassSegment
     */
    public function setDefaultClassSegment($defaultClassSegment)
    {
        $this->defaultClassSegment = $defaultClassSegment;
    }

    /**
     * @param array $httpMethods
     */
    public function setSupportedHttpMethods(array $httpMethods)
    {
        $this->httpMethods = $httpMethods;
    }
}
