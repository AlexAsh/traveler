<?php

namespace Integration;

use Traveler\Router;
use Zend\Diactoros\Uri;
use Traveler\Parsers\UriParser;
use Traveler\Guessers\ControllerGuesser;
use Traveler\Validators\UriValidator;
use Traveler\Invokers\ControllerInvoker;

/**
 * @author Alex Ash <streamprop@gmail.com>
 */
class RouterTest extends \PHPUnit_Framework_TestCase
{
    private $router;

    public function testRoute_WithValidRequest_MapToAppropriateController()
    {
        $uri = new Uri('http://example.com/example/action/?a=foo&b=bar');
        $httpMethod = 'GET';

        $controllerInvoker = $this->router->route($uri, $httpMethod);

        $expected = [
            'class'  => 'Integration\\ExampleController',
            'method' => 'getAction',
            'params' => ['a' => 'foo', 'b' => 'bar'],
            'result' => 'Integration\\ExampleController::getAction(foo, bar)',
        ];
        $this->assertEquals($expected['class'],  $controllerInvoker->getClass());
        $this->assertEquals($expected['method'], $controllerInvoker->getMethod());
        $this->assertEquals($expected['params'], $controllerInvoker->getParams());
        $this->assertEquals($expected['result'], $controllerInvoker());
    }

    public function setUp()
    {
        parent::setUp();

        $controllerNamespace = 'Integration';
        $controllerInvoker = new ControllerInvoker();
        $controllerGuesser = new ControllerGuesser($controllerNamespace, $controllerInvoker);

        $validator = new UriValidator();
        $uriParser = new UriParser($validator);

        $this->router = new Router($uriParser, $controllerGuesser);
    }
}

/**
 * @author Alex Ash <streamprop@gmail.com>
 */
class ExampleController
{
    public function getAction($alpha, $betta)
    {
        return "Integration\\ExampleController::getAction($alpha, $betta)";
    }
}
