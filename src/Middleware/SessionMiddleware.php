<?php

namespace Neoflow\Session\Middleware;

use Neoflow\Session\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class SessionMiddleware implements MiddlewareInterface
{

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * Constructor.
     *
     * @param SessionInterface $session Session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Process an incoming server request.
     *
     * @param ServerRequestInterface $request Server request to process
     * @param RequestHandlerInterface $handler Request handler for the middleware
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$this->session->isStarted()) {
            $this->session->start();
        }

        return $handler->handle($request);
    }
}
