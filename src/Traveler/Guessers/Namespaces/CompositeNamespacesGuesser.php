<?php

namespace Traveler\Guessers\Namespaces;

/**
 * Guesses full namespace by root namespace and uri path segments
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
class CompositeNamespacesGuesser implements NamespacesGuesserInterface
{
    /**
     * @var string
     */
    private $root;

    /**
     * @var string
     */
    private $delimiter;

    /**
     * @param string $rootNamespace
     * @param string $delimiter
     */
    public function __construct($rootNamespace, $delimiter = '-')
    {
        $this->root      = $rootNamespace;
        $this->delimiter = $delimiter;
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

        $root              = (strlen($this->root) > 0) ? $this->root.'\\' : '';
        $namespaceSegments = array_slice($uriPathSegments, 0, -2);
        $namespaceChunks   = array_map([$this, 'camelizeSegment'], $namespaceSegments);
        $namespace         = $root.implode('\\', $namespaceChunks);

        return $namespace;
    }

    /**
     * Move from delimited-uri-path-segment to DelimitedUriPathSegment
     *
     * @param string $segment
     *
     * @return string
     */
    private function camelizeSegment($segment)
    {
        return implode('', array_map('ucfirst', explode($this->delimiter, $segment)));
    }
}
