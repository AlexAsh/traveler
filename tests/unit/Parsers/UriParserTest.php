<?php

namespace Unit\Parsers;

use Traveler\Parsers\UriParser;

/**
 * @author Alex Ash <streamprop@gmail.com>
 */
class UriParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParse_WithValidUri_GetParsedPathAndQuery()
    {
        $parser = new UriParser();
        $uriStub = \Mockery::mock('\Psr\Http\Message\UriInterface')
            ->shouldReceive(['getPath' => '/foo/bar/', 'getQuery' => 'a=baz&b=qux'])
            ->mock();

        $parsed = $parser->parse($uriStub);

        $expected = [
            'segments' => ['foo', 'bar'],
            'query'    => ['a' => 'baz', 'b' => 'qux'],
        ];
        $this->assertEquals($expected, $parsed);
    }

    public function testParse_WithEmptyUriPath_GetEmptySegmentsArray()
    {
        $parser = new UriParser();
        $uriStub = \Mockery::mock('\Psr\Http\Message\UriInterface')
            ->shouldReceive(['getPath' => '/', 'getQuery' => 'a=baz&b=qux'])
            ->mock();

        $parsed = $parser->parse($uriStub);

        $expected = [
            'segments' => [],
            'query'    => ['a' => 'baz', 'b' => 'qux'],
        ];
        $this->assertEquals($expected, $parsed);
    }

    public function testParse_WithEmptyQuery_GetEmptyQueryArray()
    {
        $parser = new UriParser();
        $uriStub = \Mockery::mock('\Psr\Http\Message\UriInterface')
            ->shouldReceive(['getPath' => '/foo/bar/', 'getQuery' => ''])
            ->mock();

        $parsed = $parser->parse($uriStub);

        $expected = [
            'segments' => ['foo', 'bar'],
            'query'    => [],
        ];
        $this->assertEquals($expected, $parsed);
    }

    public function tearDown()
    {
        \Mockery::close();

        parent::tearDown();
    }
}
