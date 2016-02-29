<?php

namespace Traveler;

use Psr\Http\Message\UriInterface;
use Traveler\Parsers\UriParserInterface;
use Traveler\Guessers\ControllerGuesserInterface;

/**
 * Facade for routing library
 *
 * @codeCoverageIgnore
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
class Router
{
    /**
     * @var \Traveler\Parsers\UriParserInterface
     */
    private $parser;

    /**
     * @var \Traveler\Guessers\ControllerGuesserInterface
     */
    private $guesser;

    /**
     * @param \Traveler\Parsers\UriParserInterface          $parser
     * @param \Traveler\Guessers\ControllerGuesserInterface $guesser
     */
    public function __construct(UriParserInterface $parser, ControllerGuesserInterface $guesser)
    {
        $this->parser = $parser;
        $this->guesser = $guesser;
    }

    /**
     * Map uri and http method to callable controller info
     *
     * @param \Psr\Http\Message\UriInterface $uri
     * @param string $httpMethod
     */
    public function route(UriInterface $uri, $httpMethod)
    {
        $parsed = $this->parser->parse($uri);
        $invoker = $this->guesser->guess($parsed['segments'], $httpMethod);
        $invoker->setParams($parsed['query']);

        return $invoker;
    }
}
