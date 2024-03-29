<?php

namespace ElleTheDev\Glove\Renderers;

use Throwable;
use Illuminate\Http\Request;

class HandlerTypeRenderer
{
    /** @var HandlersRenderer */
    private $renderer;

    /**
     * @param HandlersRenderer $renderer
     */
    public function __construct(HandlersRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @param array     $exceptions
     * @param Request   $request
     * @param Throwable $e
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function render(array $exceptions, Request $request, Throwable $e)
    {
        foreach ($exceptions as $exceptionClass => $handlers) {
            if (!($e instanceof $exceptionClass)) {
                continue;
            }

            $response = $this->renderer->render($handlers, $request, $e);

            if ($response) {
                return $response;
            }
        }
    }
}
