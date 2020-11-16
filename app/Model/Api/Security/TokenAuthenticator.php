<?php

declare(strict_types=1);

namespace App\Model\Api\Security;

use Psr\Http\Message\ServerRequestInterface;

class TokenAuthenticator extends AbstractAuthenticator
{
    private const HEADER_TOKEN = 'X-Token';
    private const QUERY_TOKEN = '_access_token';

    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function authenticate(ServerRequestInterface $request): bool
    {
        // Parse from request header
        $token = $this->tryHeader($request);

        // Try from URL
        if (!$token) {
            $token = $this->tryQuery($request);
        }

        if (!$token) {
            return false;
        }

        return $token === $this->token;
    }

    private function tryHeader(ServerRequestInterface $request): ?string
    {
        return $request->hasHeader(self::HEADER_TOKEN) ?
            $request->getHeaderLine(self::HEADER_TOKEN)
            : null;
    }

    private function tryQuery(ServerRequestInterface $request): ?string
    {
        return $request->getQueryParams()[self::QUERY_TOKEN] ?? null;
    }
}
