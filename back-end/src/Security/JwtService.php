<?php

namespace App\Security;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtService
{
    public function __construct(private string $secret, private int $accessTtl, private int $refreshTtl,
                                private string $refreshCookieName, private string $issuer)
    {
    }

    public function generateAccessToken(string $userId): string
    {
        $now = new \DateTimeImmutable();
        $exp = $now->getTimestamp() + $this->accessTtl;
        $payload = [
            'sub' => $userId,
            'exp' => $exp,
            'iat' => $now->getTimestamp(),
            'iss' => $this->issuer,
        ];
        return \Firebase\JWT\JWT::encode($payload, $this->secret, 'HS384');
    }

    public function generateRefreshToken(string $userId): string
    {
        $now = new \DateTimeImmutable();
        $exp = $now->getTimestamp() + $this->refreshTtl;
        $payload = [
            'sub' => $userId,
            'exp' => $exp,
            'iat' => $now->getTimestamp(),
            'iss' => $this->issuer,
        ];
        return JWT::encode($payload, $this->secret, 'HS384');
    }

    public function verifyToken(string $token): string
    {
        try {
            $payload = JWT::decode($token, new Key($this->secret, 'HS384'));
            if ($payload->iss !== $this->issuer) {
                throw new \RuntimeException("invalid token");
            }
            if (!isset($payload->sub)) {
                throw new \RuntimeException("invalid token");
            }
            return $payload->sub;
        } catch (\Throwable $th) {
            throw new \RuntimeException("invalid token");
        }
    }

    public function getUserIdFromToken(string $token): string
    {
        $userId = $this->verifyToken($token);
        if (!$userId) {
            throw new \RuntimeException("invalid token");
        }
        return $userId;
    }

    public function addTokenToCookie(Response $response, string $refreshToken): void
    {
        $cookie = Cookie::create(
            $this->refreshCookieName,
            $refreshToken,
            time() + $this->refreshTtl,
            '/',
            null,
            true,
            true,
            Cookie::SAMESITE_LAX
        );
        $response->headers->setCookie($cookie);
    }

    public function removeTokenFromCookie(Response $response): void
    {
        $cookie = Cookie::create(
            $this->refreshCookieName,
            '',
            time() - 3600,
            '/',
            null,
            true,
            true,
            Cookie::SAMESITE_LAX
        );
        $response->headers->setCookie($cookie);
    }

    public function getTokenFromCookie(Request $request): ?string
    {
        return $request->cookies->get($this->refreshCookieName);
    }

    public function refreshAccessToken(Request $request): string
    {
        try {
            $refreshToken = $this->getTokenFromCookie($request);
            if (!$refreshToken) {
                throw new \RuntimeException("invalid token");
            }
            $userId = $this->verifyToken($refreshToken);
            if (!$userId) {
                throw new \RuntimeException("invalid token");
            }
            return $this->generateAccessToken($userId);
        } catch (\Exception $exception) {
            throw new \RuntimeException($exception->getMessage());
        }
    }
}
