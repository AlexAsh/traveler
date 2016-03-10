<?php

namespace Traveler\Guessers\Methods;

/**
 * Guesses controller method by uri path segments and http method
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
class MethodsGuesser extends BaseMethodsGuesser
{
    /**
     * Guesses two-word controller method, e.g. getExample, not getLongExample
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
        $method  = strtolower($httpMethod).ucfirst($segment);

        return $method;
    }
}
