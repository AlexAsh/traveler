<?php

namespace Traveler\Guessers\Namespaces;

/**
 * Realization should guess namespace by uri path segments
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
interface NamespacesGuesserInterface
{
    /**
     * Realization should guess namespace by uri path segments
     *
     * @param array $uriPathSegments
     *
     * @return string Full namespace guessed
     */
    public function guess(array $uriPathSegments);
}
