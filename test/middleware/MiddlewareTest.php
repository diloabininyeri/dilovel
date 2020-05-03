<?php


use App\Application\Middleware;
use App\Components\Http\Request;
use PHPUnit\Framework\TestCase;

/**
 * Class MiddlewareTest
 */
class MiddlewareTest extends TestCase
{


    /**
     * @test
     */
    public function testCanPassMiddleware()
    {
        $middleware = new Middleware('must_be_int');
        $middleware->call(new Request());
        $this->assertInstanceOf(Request::class, $middleware->getResponse());
    }

    public function testCantPassedMiddleware()
    {
        $middleware = new Middleware('example');
        $middleware->call(new Request());
        $this->assertNotInstanceOf(Request::class, $middleware->getResponse());
    }
}
