<?php

declare(strict_types=1);

namespace App\Model\Api\Middleware;

use App\Model\Utils\Strings;
use Contributte\Middlewares\IMiddleware;
use Contributte\Middlewares\Security\IAuthenticator;
use Nette\Utils\Json;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthenticationMiddleware implements IMiddleware
{
    private const WHITELIST_PATHS = ['/backend/v1/user/register', '/backend/v1/user/login', '/backend/v1/openapi'];

    /** @var IAuthenticator */
    private IAuthenticator $authenticator;

    public function __construct(IAuthenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    protected function denied(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $response->getBody()->write(Json::encode([
            'status' => 'error',
            'message' => 'Client authentication failed',
            'code' => 401,
        ]));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(401);
    }

    protected function isWhitelisted(ServerRequestInterface $request): bool
    {
        foreach (self::WHITELIST_PATHS as $whitelist) {
            if (Strings::startsWith($request->getUri()->getPath(), $whitelist)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Authenticate user from given request
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface {
        if ($this->isWhitelisted($request)) {
            return $next($request, $response);
        }
        // If we have a identity, then go to next middlewares,
        // otherwise stop and return current response
        if (!$this->authenticator->authenticate($request)) {
            return $this->denied($request, $response);
        }

        // Pass to next middleware
        return $next($request, $response);
    }
}
