<?php

namespace Unit\Guessers\Namespaces;

use Traveler\Guessers\Namespaces\HierarchicalNamespacesGuesser;

/**
 * @author Alex Ash <streamprop@gmail.com>
 */
class HierarchicalNamespacesGuesserTest extends \PHPUnit_Framework_TestCase
{
    public function testGuess_withFourUriPathSegments_GetSubpackageControllersNamespace()
    {
        $guesser = $this->getGuesser();
        $segments = ['sales', 'user-history', 'customer', 'cart'];

        $namespace = $guesser->guess($segments);

        $this->assertEquals(
            'Root\\Sales\\SubpackageOffset\\UserHistory\\ControllerOffset',
            $namespace
        );
    }

    public function testGuess_WithThreeUriPathSegments_GetPackageControllersNamespace()
    {
        $guesser = $this->getGuesser();
        $segments = ['user-history', 'customer', 'cart'];

        $namespace = $guesser->guess($segments);

        $this->assertEquals(
            'Root\\UserHistory\\ControllerOffset',
            $namespace
        );
    }

    public function testGuess_WithTwoUriPathSegments_GetRootControllersNamespace()
    {
        $guesser = $this->getGuesser();
        $segments = ['customer', 'cart'];

        $namespace = $guesser->guess($segments);

        $this->assertEquals(
            'Root\\ControllerOffset',
            $namespace
        );
    }

    protected function getGuesser(
        $rootNamespace    = 'Root',
        $subpackageOffset = 'SubpackageOffset',
        $controllerOffset = 'ControllerOffset',
        $delimiter        = '-'
    ) {
        return new HierarchicalNamespacesGuesser(
            $rootNamespace, $subpackageOffset, $controllerOffset, $delimiter
        );
    }
}
