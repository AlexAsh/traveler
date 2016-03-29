<?php

namespace Traveler\Guessers\Methods;

/**
 * Realization should guess controller method by uri path segments and http method
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
interface MethodsGuesserInterface
{
    /**
     * Realization should guess controller method by uri path segments and http method
     *
     * @param array  $uriPathSegments
     * @param string $httpMethod
     *
     * @return string
     */
    public function guess(array $uriPathSegments, $httpMethod);
}
