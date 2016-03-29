<?php

namespace Traveler\Guessers\Methods;

/**
 * Base implementation details for all method guessers
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
abstract class BaseMethodsGuesser implements MethodsGuesserInterface
{
    /**
     * @var string
     */
    protected $defaultSegment;

    /**
     * @var array
     */
    protected $httpMethods = [
        'GET', 'HEAD', 'POST', 'PATCH', 'PUT', 'DELETE',
        'LINK', 'UNLINK', 'OPTIONS',
    ];

    /**
     * @param string $defaultSegment
     * @param array  $httpMethods    Supported http methods.
     */
    public function __construct($defaultSegment = 'default', array $httpMethods = [])
    {
        $this->defaultSegment = $defaultSegment;

        if (count($httpMethods) > 0) {
            $this->httpMethods = $httpMethods;
        }
    }

    /**
     * Ensure that http method is supported
     *
     * @param string $httpMethod
     *
     * @throws \DomainException
     */
    public function validateHttpMethod($httpMethod)
    {
        if (!in_array($httpMethod, $this->httpMethods, true)) {
            throw new \DomainException(
                "Unsupported http method $httpMethod, supported methods: ".
                implode(', ', $this->httpMethods)
            );
        }
    }
}
