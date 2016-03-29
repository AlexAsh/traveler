<?php

namespace Traveler\Guessers\Namespaces;

/**
 * Base implementation details for all namespace guessers
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
abstract class BaseNamespacesGuesser implements NamespacesGuesserInterface
{
    /**
     * @var string
     */
    protected $root;

    /**
     * @param string $rootNamespace
     */
    public function __construct($rootNamespace)
    {
        $this->root = $rootNamespace;
    }

    /**
     * Configurable namespace building
     *
     * @param array    $uriPathSegments
     * @param callable $uriPathSegmentsConverter Callable for converting uri path segments to namespace chunks.
     * @param string   $namespaceChunksGlue      String for assembling namespace from chunks.
     * @param string   $namespacePostfix         String to add to the end of namespace.
     *
     * @return string
     */
    protected function buildNamespace(
        array $uriPathSegments,
        callable $uriPathSegmentsConverter,
        $namespaceChunksGlue = '\\',
        $namespacePostfix = ''
    ) {
        $namespaceChunks  = array_map($uriPathSegmentsConverter, array_slice($uriPathSegments, 0, -2));
        $partialNamespace = implode($namespaceChunksGlue, $namespaceChunks);

        $rootDelimiter   = (strlen($this->root) > 0 && strlen($partialNamespace) > 0) ? '\\' : '';
        $rootedNamespace = $this->root.$rootDelimiter.$partialNamespace;

        $postfixDelimiter = (strlen($rootedNamespace) > 0 && strlen($namespacePostfix) > 0) ? '\\' : '';
        $fullNamespace    = $rootedNamespace.$postfixDelimiter.$namespacePostfix;

        return $fullNamespace;
    }
}
