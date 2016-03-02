<?php

namespace Traveler\Guessers\Namespaces;

/**
 * Guesses full namespace by root namespace and uri path segments
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
class NamespacesGuesser implements NamespacesGuesserInterface
{
    /**
     * @var string
     */
    private $root;

    /**
     * @param string $rootNamespace
     */
    public function __construct($rootNamespace)
    {
        $this->root = $rootNamespace;
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
        if (count($uriPathSegments) < 3) {
            return $this->root;
        }

        $root            = (strlen($this->root) > 0) ? $this->root.'\\' : '';
        $namespaceChunks = array_map('ucfirst', array_slice($uriPathSegments, 0, -2));
        $namespace       = $root.implode('\\', $namespaceChunks);

        return $namespace;
    }
}
