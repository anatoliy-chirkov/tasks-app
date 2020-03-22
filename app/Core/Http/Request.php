<?php

namespace Core\Http;

class Request
{
    private $uri;
    private $method;
    private $postData;
    private $getData;

    public function __construct()
    {
        $requestUriArr = explode('?', $_SERVER['REQUEST_URI'], 2);

        $this->uri      = $requestUriArr[0];
        $this->method   = $_SERVER['REQUEST_METHOD'];
        $this->postData = $_POST;
        $this->getData  = $_GET;
    }

    public function redirect(string $to)
    {
        header("Location: http://{$_SERVER['HTTP_HOST']}{$to}");
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function isPost()
    {
        return $this->method === IMethod::POST;
    }

    public function post(string $key = null, $default = null)
    {
        if ($key === null) {
            return $this->postData;
        }

        return isset($this->postData[$key]) ? $this->postData[$key] : $default;
    }

    public function get(string $key = null, $default = null)
    {
        if ($key === null) {
            return $this->getData;
        }

        return isset($this->getData[$key]) ? $this->getData[$key] : $default;
    }
}
