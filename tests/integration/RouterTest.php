<?php

namespace Integration;

use Zend\Diactoros\Uri;

/**
 * @author Alex Ash <streamprop@gmail.com>
 */
class RouterTest extends \PHPUnit_Framework_TestCase
{
    public function testRoute_WithValidRequest_MapToAppropriateController()
    {
        $rootNamespace = 'Integration\\Assets\\Controllers';
        $router = $this->getRouter($rootNamespace);
        $uri = new Uri('http://example.com/example/action/?a=foo&b=bar');
        $httpMethod = 'GET';

        $controllerInvoker = $router->route($uri, $httpMethod);

        $expected = [
            'class'  => $rootNamespace.'\\ExampleController',
            'method' => 'getAction',
            'params' => ['a' => 'foo', 'b' => 'bar'],
            'result' => $rootNamespace.'\\ExampleController::getAction(foo, bar)',
        ];
        $this->assertEquals($expected['class'],  $controllerInvoker->getClass());
        $this->assertEquals($expected['method'], $controllerInvoker->getMethod());
        $this->assertEquals($expected['params'], $controllerInvoker->getParams());
        $this->assertEquals($expected['result'], $controllerInvoker());
    }

    public function testRoute_WithThreeUriPathSegments_MapToAppropriateController()
    {
        $rootNamespace = 'Integration\\Assets\\Controllers';
        $router = $this->getRouter($rootNamespace);
        $uri = new Uri('http://example.com/special/example/action/?a=foo&b=bar');
        $httpMethod = 'GET';

        $controllerInvoker = $router->route($uri, $httpMethod);

        $expected = [
            'class'  => $rootNamespace.'\\Special\\ExampleController',
            'method' => 'getAction',
            'params' => ['a' => 'foo', 'b' => 'bar'],
            'result' => $rootNamespace.'\\Special\\ExampleController::getAction(foo, bar)',
        ];
        $this->assertEquals($expected['class'],  $controllerInvoker->getClass());
        $this->assertEquals($expected['method'], $controllerInvoker->getMethod());
        $this->assertEquals($expected['params'], $controllerInvoker->getParams());
        $this->assertEquals($expected['result'], $controllerInvoker());
    }

    protected function getRouter($rootNamespace)
    {
        return \Traveler\Bootstrap\bootstrap($rootNamespace)->get('Traveler\\Router');
    }
}
