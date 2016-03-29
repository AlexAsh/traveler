<?php

namespace Unit\Guessers;

use Unit\Assets\Traited\CamelizerWithDelimiter;
use Unit\Assets\Traited\CamelizerWithoutDelimiter;

/**
 * @author Alex Ash <streamprop@gmail.com>
 */
class CanCamelizeTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testCamelize_WithClassContainingDelimiterProperty_GetCamelizedConsideringDelimiter()
    {
        $camelizer = new CamelizerWithDelimiter();
        $camelizer->delimiter = '_';

        $camelized = $camelizer->camelize('foo_bar-baz');

        $this->assertEquals('FooBar-baz', $camelized);
    }

    public function testCamelize_WithClassNotContainingDelimiterProperty_GetCamelizedWithDefaultDelimiter()
    {
        $camelizer = new CamelizerWithoutDelimiter();

        $camelized = $camelizer->camelize('foo-bar_baz');

        $this->assertEquals('FooBar_baz', $camelized);
    }
}
