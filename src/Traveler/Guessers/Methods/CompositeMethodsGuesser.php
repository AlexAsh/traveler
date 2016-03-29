<?php

namespace Traveler\Guessers\Methods;

use Traveler\Guessers\CanCamelizeTrait;

/**
 * Guesses controller method by uri path segments and http method
 *
 * Converts such-uri-path-segment and GET http method to getSuchUriPathSegment method name
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
class CompositeMethodsGuesser extends BaseMethodsGuesser
{
    use CanCamelizeTrait;

    /**
     * @var string
     */
    private $delimiter;

    /**
     * @param string $defaultSegment
     * @param array  $httpMethods
     * @param string $delimiter
     */
    public function __construct($defaultSegment = 'default', array $httpMethods = [], $delimiter = '-')
    {
        parent::__construct($defaultSegment, $httpMethods);

        $this->delimiter = $delimiter;
    }

    /**
     * Guesses multi-word controller class name, e.g. getLongExample
     *
     * @param array  $uriPathSegments
     * @param string $httpMethod
     *
     * @return string
     *
     * @throws \DomainException
     */
    public function guess(array $uriPathSegments, $httpMethod)
    {
        $this->validateHttpMethod($httpMethod);

        $segment = (count($uriPathSegments) > 1) ? end($uriPathSegments) : $this->defaultSegment;
        $method  = strtolower($httpMethod).$this->camelize($segment);

        return $method;
    }
}
