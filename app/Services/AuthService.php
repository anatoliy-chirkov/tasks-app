<?php

namespace Services;

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
        $adminData = ServiceContainer::getInstance()->get('env')['admin'];

        return $username === $adminData['username'] && $password === $adminData['password'];
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
        setcookie(self::COOKIE_TOKEN_KEY, $value, self::COOKIE_EXPIRATION_TIME);
    }

    private function generateToken()
    {
        $tokenSecret = ServiceContainer::getInstance()->get('env')['token_secret'];

        return hash('md5', time() . $tokenSecret);
    }
}
