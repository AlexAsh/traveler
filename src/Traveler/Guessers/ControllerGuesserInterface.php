<?php

namespace Traveler\Guessers;

/**
 * Realization should guess controller class and action method
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
interface ControllerGuesserInterface
{
    /**
     * Realization should guess controller class and action method
     *
     * @param array  $uriPathSegments
     * @param string $httpMethod
     */
    public function guess(array $uriPathSegments, $httpMethod);
}
