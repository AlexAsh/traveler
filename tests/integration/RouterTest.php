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

    public function testRoute_WithCompositeUriPathSegments_MapToAppropriateController()
    {
        $rootNamespace = 'Integration\\Assets\\Controllers';
        $router = $this->getCompositeRouter($rootNamespace);
        $uri = new Uri('http://example.com/foo-bar/earth-moon/run-fly/?a=foo&b=bar');
        $httpMethod = 'GET';

        $controllerInvoker = $router->route($uri, $httpMethod);

        $expected = [
            'class'  => $rootNamespace.'\\FooBar\\EarthMoonController',
            'method' => 'getRunFly',
            'params' => ['a' => 'foo', 'b' => 'bar'],
            'result' => $rootNamespace.'\\FooBar\\EarthMoonController::getRunFly(foo, bar)',
        ];
        $this->assertEquals($expected['class'],  $controllerInvoker->getClass());
        $this->assertEquals($expected['method'], $controllerInvoker->getMethod());
        $this->assertEquals($expected['params'], $controllerInvoker->getParams());
        $this->assertEquals($expected['result'], $controllerInvoker());
    }

    public function testRoute_WithExtraNamespaces_MapToAppropriateController()
    {
        $rootNamespace   = 'Integration\\Assets\\Controllers';
        $extraNamespaces = [$rootNamespace.'\\SubControllers'];
        $router          = $this->getRouter($rootNamespace, $extraNamespaces);
        $uri             = new Uri('http://example.com/foo/action/?a=foo&b=bar');
        $httpMethod      = 'GET';

        $controllerInvoker = $router->route($uri, $httpMethod);

        $expected = [
            'class'  => $rootNamespace.'\\SubControllers\\FooController',
            'method' => 'getAction',
            'params' => ['a' => 'foo', 'b' => 'bar'],
            'result' => $rootNamespace.'\\SubControllers\\FooController::getAction(foo, bar)',
        ];
        $this->assertEquals($expected['result'], $controllerInvoker());
        $this->assertEquals($expected['class'],  $controllerInvoker->getClass());
        $this->assertEquals($expected['method'], $controllerInvoker->getMethod());
        $this->assertEquals($expected['params'], $controllerInvoker->getParams());
    }

    public function testRoute_ThroughPackageHierarchy_MapToAppropriateController()
    {
        $rootNamespace    = 'Integration\\Assets\\Packages';
        $subpackageOffset = 'SubPackages';
        $controllerOffset = 'Controllers';
        $router           = $this->getHierarchicalRouter($rootNamespace, $subpackageOffset, $controllerOffset);
        $uri              = new Uri('http://example.com/package/sub-package/example/action/?a=foo&b=bar');
        $httpMethod       = 'GET';

        $controllerInvoker = $router->route($uri, $httpMethod);

        $expected = [
            'class'  => $rootNamespace.'\\Package\\'.$subpackageOffset.'\\SubPackage\\'.$controllerOffset.'\\ExampleController',
            'method' => 'getAction',
            'params' => ['a' => 'foo', 'b' => 'bar'],
            'result' => $rootNamespace.'\\Package\\'.$subpackageOffset.'\\SubPackage\\'.$controllerOffset.'\\ExampleController::getAction(foo, bar)',
        ];
        $this->assertEquals($expected['class'],  $controllerInvoker->getClass());
        $this->assertEquals($expected['method'], $controllerInvoker->getMethod());
        $this->assertEquals($expected['params'], $controllerInvoker->getParams());
        $this->assertEquals($expected['result'], $controllerInvoker());
    }

    protected function getRouter($rootNamespace, $extraNamespaces = [])
    {
        return
            \Traveler\Bootstrap\bootstrap(
                \Traveler\Bootstrap\configure($rootNamespace, $extraNamespaces)
            )->get('Traveler\\Router');
    }

    protected function getCompositeRouter($rootNamespace, $extraNamespaces = [])
    {
        return
            \Traveler\Bootstrap\bootstrap(
                \Traveler\Bootstrap\configureComposite($rootNamespace, $extraNamespaces)
            )->get('Traveler\\Router');
    }

    protected function getHierarchicalRouter($rootNamespace, $subpackageOffset, $controllerOffset, $extraNamespaces = [])
    {
        return
            \Traveler\Bootstrap\bootstrap(
                \Traveler\Bootstrap\configureHierarchical(
                    $rootNamespace, $subpackageOffset, $controllerOffset, $extraNamespaces
                )
            )->get('Traveler\\Router');
    }
}
