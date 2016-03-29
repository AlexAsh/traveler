<?php

namespace Unit\Guessers\Classes;

use Traveler\Guessers\Classes\ClassesGuesser;

/**
 * @author Alex Ash <streamprop@gmail.com>
 */
class ClassesGuesserTest extends \PHPUnit_Framework_TestCase
{
    public function testGuess_WithManyUriPathSegments_GuessClassFromPenultimateSegment()
    {
        $uriPathSegments = ['foo', 'bar', 'baz', 'qux'];
        $guesser = new ClassesGuesser();

        $guessed = $guesser->guess($uriPathSegments);

        $this->assertEquals('BazController', $guessed);
    }

    public function testGuess_WithTwoUriPathSegments_GuessClassFromFirstSegment()
    {
        $uriPathSegments = ['foo', 'bar'];
        $guesser = new ClassesGuesser();

        $guessed = $guesser->guess($uriPathSegments);

        $this->assertEquals('FooController', $guessed);
    }

    public function testGuess_WithOneUriPathSegment_GuessClassFromSegment()
    {
        $uriPathSegments = ['foo'];
        $guesser = new ClassesGuesser();

        $guessed = $guesser->guess($uriPathSegments);

        $this->assertEquals('FooController', $guessed);
    }

    public function testGuess_WithZeroUriPathSegments_GuessClassFromDefaultSegment()
    {
        $uriPathSegments = [];
        $guesser = new ClassesGuesser('index');

        $guessed = $guesser->guess($uriPathSegments);

        $this->assertEquals('IndexController', $guessed);
    }

}
