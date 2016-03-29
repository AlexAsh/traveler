<?php

namespace Traveler\Guessers\Namespaces;

/**
 * Guesses full namespace by root namespace and uri path segments
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
class NamespacesGuesser extends BaseNamespacesGuesser
{
    /**
     * @param string $rootNamespace
     */
    public function __construct($rootNamespace)
    {
        parent::__construct($rootNamespace);
    }

    /**
     * Guesses full namespace by root namespace and uri path segments
     *
     * @param array $uriPathSegments
     *
     * @return string Full namespace guessed
     */
    public function guess(array $uriPathSegments)
    {
        return $this->buildNamespace($uriPathSegments, 'ucfirst');
    }
}
