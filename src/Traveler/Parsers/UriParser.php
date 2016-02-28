<?php

namespace Traveler\Parsers;

use Psr\Http\Message\UriInterface;

/**
 * Description of UriParser
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
class UriParser implements UriParserInterface
{
    /**
     * Get path segments array and query dictionary
     *
     * @param \Psr\Http\Message\UriInterface $uri
     *
     * @return array ['segments' => ['one', 'two', ...], 'query' => ['key' => 'value', ...]]
     */
    public function parse(UriInterface $uri)
    {
        $path = trim($uri->getPath(), '/');
        $segments = (strlen($path) > 0) ? explode('/', $path) : [];

        parse_str($uri->getQuery(), $query);

        return ['segments' => $segments, 'query' => $query];
    }
}
