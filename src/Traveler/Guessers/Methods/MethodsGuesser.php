<?php

namespace Traveler\Guessers\Methods;

/**
 * Guesses controller method by uri path segments and http method
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
class MethodsGuesser implements MethodsGuesserInterface
{
    /**
     * @var string
     */
    private $defaultSegment;

    /**
     * @var array
     */
    private $httpMethods = [
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
     * Guesses two-word controller method, e.g. getExample, not getLongExample
     *
     * @param array  $uriPathSegments
     * @param string $httpMethod
     *
     * @return string
     */
    public function guess(array $uriPathSegments, $httpMethod)
    {
        $this->validateHttpMethod($httpMethod);

        $segment = (count($uriPathSegments) > 1) ? end($uriPathSegments) : $this->defaultSegment;
        $method  = strtolower($httpMethod).ucfirst($segment);

        return $method;
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
}
