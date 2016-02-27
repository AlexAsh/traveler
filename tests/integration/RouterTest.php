<?php

namespace Integration;

use Traveler\Router;
use Zend\Diactoros\Uri;


/**
 * @author Alex Ash <streamprop@gmail.com>
 */
class RouterTest extends \PHPUnit_Framework_TestCase
{
    public function testRoute_WithValidRequest_MapToAppropriateController()
    {
        $controllerNamespace = 'Example\\Namespace';
        $router = new Router($controllerNamespace);
        $uri = new Uri('http://example.com/foo/bar/?a=baz&b=qux');
        $httpMethod = 'GET';

        $controllerInfo = $router->route($uri, $httpMethod);

        $expected = [
            'class'  => 'Example\\Namespace\\FooController',
            'method' => 'getBar',
            'params' => ['a' => 'baz', 'b' => 'qux'],
        ];
        $this->assertEquals($expected, $controllerInfo);
    }
}
