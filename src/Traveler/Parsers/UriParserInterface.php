<?php

namespace Traveler\Parsers;

use Psr\Http\Message\UriInterface;

/**
 * Realization should extract info for controller mapping
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
interface UriParserInterface
{
    /**
     * Realization should extract info for controller mapping
     *
     * @param \Psr\Http\Message\UriInterface $uri
     */
    public function parse(UriInterface $uri);
}
