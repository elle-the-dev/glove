<?php
namespace ElleHamilton\Glove\Handlers;

use ElleHamilton\Glove\Contracts\Handler;
use ElleHamilton\Glove\Http\StatusCodeMatcher;
use Exception;
use Illuminate\Config\Repository as Configuration;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Http\Request;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run as Whoops;

/**
 * Handler for integrating filp/whoops package
 */
class WhoopsHandler implements Handler
{
    /** @var ResponseFactory */
    private $responseFactory;

    /** @var ViewFactory */
    private $viewFactory;

    /** @var Configuration */
    private $config;

    /** @var StatusCodeMatcher */
    private $codeMatcher;

    /**
     * @param ResponseFactory   $responseFactory
     * @param ViewFactory       $viewFactory
     * @param Configuration     $config
     * @param StatusCodeMatcher $codeMatcher
     */
    public function __construct(
        ResponseFactory $responseFactory,
        ViewFactory $viewFactory,
        Configuration $config,
        StatusCodeMatcher $codeMatcher
    ) {
        $this->responseFactory = $responseFactory;
        $this->viewFactory     = $viewFactory;
        $this->config          = $config;
        $this->codeMatcher     = $codeMatcher;
    }

    public function handle(Request $request, Exception $e)
    {
        $debug     = $this->config->get('app.debug');
        $code      = $this->codeMatcher->match($e);
        $showDebug = $this->config->get('glove-codes.'.$code.'.debug', true);
        if ($debug && $showDebug && class_exists(Whoops::class)) {
            return $this->whoopsResponse($e);
        }
    }

    /**
     * @param Exception $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function whoopsResponse(Exception $e)
    {
        $whoops = new Whoops;
        $whoops->pushHandler(new PrettyPageHandler);
        return $this->responseFactory->make(
            $whoops->handleException($e),
            500
        );
    }
}
