<?php

namespace Unit\Parsers;

use Traveler\Parsers\UriParser;

/**
 * @author Alex Ash <streamprop@gmail.com>
 */
class UriParserTest extends \PHPUnit_Framework_TestCase
{
    private $parser;

    public function testParse_WithValidUri_GetParsedPathAndQuery()
    {
        $uriStub = \Mockery::mock('\Psr\Http\Message\UriInterface')
            ->shouldReceive(['getPath' => '/foo/bar/', 'getQuery' => 'a=baz&b=qux'])
            ->mock();

        $parsed = $this->parser->parse($uriStub);

        $expected = [
            'segments' => ['foo', 'bar'],
            'query'    => ['a' => 'baz', 'b' => 'qux'],
        ];
        $this->assertEquals($expected, $parsed);
    }

    public function testParse_WithEmptyUriPath_GetEmptySegmentsArray()
    {
        $uriStub = \Mockery::mock('\Psr\Http\Message\UriInterface')
            ->shouldReceive(['getPath' => '/', 'getQuery' => 'a=baz&b=qux'])
            ->mock();

        $parsed = $this->parser->parse($uriStub);

        $expected = [
            'segments' => [],
            'query'    => ['a' => 'baz', 'b' => 'qux'],
        ];
        $this->assertEquals($expected, $parsed);
    }

    public function testParse_WithEmptyQuery_GetEmptyQueryArray()
    {
        $uriStub = \Mockery::mock('\Psr\Http\Message\UriInterface')
            ->shouldReceive(['getPath' => '/foo/bar/', 'getQuery' => ''])
            ->mock();

        $parsed = $this->parser->parse($uriStub);

        $expected = [
            'segments' => ['foo', 'bar'],
            'query'    => [],
        ];
        $this->assertEquals($expected, $parsed);
    }

    public function setUp()
    {
        parent::setUp();

        $validatorMock = \Mockery::mock('\Traveler\Validators\UriValidatorInterface')
            ->shouldReceive('validate')
            ->once()
            ->mock();

        $this->parser = new UriParser($validatorMock);
    }

    public function tearDown()
    {
        \Mockery::close();

        parent::tearDown();
    }
}
