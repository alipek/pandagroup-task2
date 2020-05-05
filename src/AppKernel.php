<?php

namespace Recruitment;


use Recruitment\Dependency\Container;
use Recruitment\Http\Request;
use Recruitment\Http\Response;
use Recruitment\Http\Router;

class AppKernel
{
    private Container $container;

    public function __construct()
    {
        $configContainerPath = $this->getConfigDir() . \DIRECTORY_SEPARATOR . 'container.php';
        $configContainer = require $configContainerPath;
        $this->container = Container::getInstance($configContainer);
    }


    public function handleRequest(): void
    {
        $request = Request::getInstance();
        $this->container->set(Request::class, $request);
        /** @var Router $router */
        $router = $this->container->get(Router::class);
        $controller = $router->getController();
        /** @var Response $response */
        $response = \call_user_func($controller, $request);
        \http_response_code($response->getStatus());

        if (count($response->headers) > 0) {
            foreach ($response->headers->all() as $header => $value) {
                \header("{$header}: {$value}");
            }
        }

        \ob_start();
        echo $response->getBody();
        \ob_end_flush();
    }

    public function getConfigDir()
    {
        return \realpath(__DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'config');
    }
}