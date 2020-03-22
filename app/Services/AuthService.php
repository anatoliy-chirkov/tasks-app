<?php

namespace Services;

use Core\DotEnv;
use Core\ServiceContainer;
use Repositories\TokenRepository;

class AuthService
{
    private const
        COOKIE_TOKEN_KEY       = '_token',
        COOKIE_EXPIRATION_TIME = 3600
    ;

    private $tokenRepository;

    public function __construct(TokenRepository $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    public function checkCredentials($username, $password)
    {
        /** @var DotEnv $env */
        $env = ServiceContainer::getInstance()->get('env');

        return $username === $env->get('ADMIN_USERNAME') && $password === $env->get('ADMIN_PASSWORD');
    }

    public function setUpToken()
    {
        $token = $this->generateToken();

        $this->setTokenToCookie($token);
        $this->tokenRepository->save($token);
    }

    public function verifyCookieToken()
    {
        $token = $this->getTokenFromCookie();

        if (!$token) {
            return false;
        }

        return !empty($this->tokenRepository->find($token));
    }

    public function removeToken()
    {
        $this->setTokenToCookie(null);

        $this->tokenRepository->removeAllTokens();
    }

    private function getTokenFromCookie()
    {
        return $_COOKIE[self::COOKIE_TOKEN_KEY];
    }

    private function setTokenToCookie($value)
    {
        setcookie(self::COOKIE_TOKEN_KEY, $value, time() + self::COOKIE_EXPIRATION_TIME);
    }

    private function generateToken()
    {
        $tokenSecret = ServiceContainer::getInstance()->get('env')->get('TOKEN_SECRET');

        return hash('md5', time() . $tokenSecret);
    }
}
