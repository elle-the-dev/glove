<?php
namespace ElleHamilton\Tests\Glove\Renderers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use ElleHamilton\Glove\Renderers\HandlersRenderer;
use ElleHamilton\Tests\Glove\Stubs\HandlerStub;
use Exception;
use Mockery;

class HandlersRendererTest extends \ElleHamilton\Tests\Glove\TestCase
{
    public function testRender()
    {
        $handlers = [
            HandlerStub::class
        ];
        $renderer = $this->app->make(HandlersRenderer::class);
        $request = $this->app->make(Request::class);
        $e = new Exception;
        $response = $renderer->render($handlers, $request, $e);

        $this->assertInstanceOf(Response::class, $response);
    }

    public function testNoMatch()
    {
        $handlers = [
        ];
        $renderer = $this->app->make(HandlersRenderer::class);
        $request = $this->app->make(Request::class);
        $e = new Exception;
        $response = $renderer->render($handlers, $request, $e);

        $this->assertNull($response);
    }
}
