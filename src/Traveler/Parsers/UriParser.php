<?php

namespace Traveler\Parsers;

use Psr\Http\Message\UriInterface;
use Traveler\Validators\UriValidatorInterface;

/**
 * Parses uri for controller guesser
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
class UriParser implements UriParserInterface
{
    /**
     * @var \Traveler\Validators\UriValidatorInterface
     */
    private $validator;

    /**
     * @param \Traveler\Validators\UriValidatorInterface $validator
     *
     * @codeCoverageIgnore
     */
    public function __construct(UriValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Get path segments array and query dictionary
     *
     * @param \Psr\Http\Message\UriInterface $uri
     *
     * @return array ['segments' => ['one', 'two', ...], 'query' => ['key' => 'value', ...]]
     */
    public function parse(UriInterface $uri)
    {
        $this->validator->validate($uri);

        $path     = trim($uri->getPath(), '/');
        $segments = (strlen($path) > 0) ? explode('/', $path) : [];

        parse_str($uri->getQuery(), $query);

        return ['segments' => $segments, 'query' => $query];
    }
}
