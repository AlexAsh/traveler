<?php

namespace Traveler\Guessers\Classes;

/**
 * Realization should guess controller class by uri path segements
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
interface ClassesGuesserInterface
{
    /**
     * Realization should guess controller class by uri path segements
     *
     * @param array $uriPathSegments
     *
     * @return string
     */
    public function guess(array $uriPathSegments);
}
