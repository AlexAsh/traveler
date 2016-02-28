<?php

namespace Integration;

use Traveler\Router;
use Zend\Diactoros\Uri;
use Traveler\Parsers\UriParser;
use Traveler\Guessers\ControllerGuesser;

/**
 * @author Alex Ash <streamprop@gmail.com>
 */
class RouterTest extends \PHPUnit_Framework_TestCase
{
    private $router;

    public function testRoute_WithValidRequest_MapToAppropriateController()
    {
        $uri = new Uri('http://example.com/foo/bar/?a=baz&b=qux');
        $httpMethod = 'GET';

        $controllerInfo = $this->router->route($uri, $httpMethod);

        $expected = [
            'class'  => 'Example\\Namespace\\FooController',
            'method' => 'getBar',
            'params' => ['a' => 'baz', 'b' => 'qux'],
        ];
        $this->assertEquals($expected, $controllerInfo);
    }

    public function setUp()
    {
        parent::setUp();

        $controllerNamespace = 'Example\\Namespace';
        $controllerGuesser = new ControllerGuesser($controllerNamespace);

        $uriParser = new UriParser();

        $this->router = new Router($uriParser, $controllerGuesser);
    }
}
