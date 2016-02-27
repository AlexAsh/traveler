<?php

namespace Traveler;

use Psr\Http\Message\UriInterface;

/**
 * Facade for routing library
 *
 * @author Alex Ash <streamprop@gmail.com>
 */
class Router
{
    private $namespace;

    public function __construct($controllerNamespace)
    {
        $this->namespace = $controllerNamespace;
    }

    /**
     * Map uri and http method to callable controller info
     *
     * @param \Psr\Http\Message\UriInterface $uri
     * @param string $httpMethod
     */
    public function route(UriInterface $uri, $httpMethod)
    {
        $path = trim($uri->getPath(), '/');
        $segments = explode('/', $path);
        parse_str($uri->getQuery(), $params);

        $class  = $this->namespace.'\\'.ucfirst($segments[0]).'Controller';
        $method = strtolower($httpMethod).ucfirst($segments[1]);

        return [
            'class'  => $class,
            'method' => $method,
            'params' => $params,
        ];
    }
}
