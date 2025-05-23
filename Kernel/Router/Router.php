<?php

namespace App\Kernel\Router;

use App\Kernel\Controller\Controller;
use App\Kernel\database\DatabaseInterface;
use App\Kernel\Http\Redirect;
use App\Kernel\Http\RedirectInterface;
use App\Kernel\Http\RequestInterface;
use App\Kernel\Session\SessionInterface;
use App\Kernel\Storage\StorageInterface;
use App\Kernel\View\View;
use App\Kernel\Http\Request;
use App\Kernel\Session\Session;
use App\Kernel\View\ViewInterface;
use App\Controller\RegisterController;
use App\Controller\LoginController;
use App\Kernel\Auth\AuthInterface;


class Router implements RouterInterface
{
    private array $routes = [
        'GET' => [],
        'POST' => [],
    ];

    public function __construct(
        private ViewInterface $view,
        private RequestInterface $request,
        private RedirectInterface $redirect,
        private SessionInterface $session,
        private DatabaseInterface $database,
        private AuthInterface $auth,
        private StorageInterface $storage,
    )
    {
        $this->initRotes();
    }

    public function dispatch(string $uri, string $method): void
    {
        $route = $this->findRoute($uri, $method);

        if (!$route) {
            $this->notFound();
            return;

        }
        if ($route->hasMiddlewares()) {
            foreach ($route->getMiddlewares() as $middleware) {
                $middlewareInstance = new $middleware($this->request, $this->auth, $this->redirect);
                $middlewareInstance->handle();

                if (headers_sent()) {
                    return;
                }
            }
        }
        if (is_array($route->getAction())) {

            [$controller,$action] = $route->getAction();

            /**@var Controller $controller */
            $controller = new $controller();

            call_user_func([$controller, 'setView'], $this->view);
            call_user_func([$controller, 'setRequest'], $this->request);
            call_user_func([$controller, 'setRedirect'], $this->redirect);
            call_user_func([$controller, 'setSession'], $this->session);
            call_user_func([$controller, 'setDatabase'], $this->database);
            call_user_func([$controller, 'setAuth'], $this->auth);
            call_user_func([$controller, 'setStorage'], $this->storage);

            call_user_func([$controller, $action]);
        }else{
            call_user_func($route->getAction());
            }
        }


    private function notFound(): void
    {
        echo "404 | Route not found";
        exit;
    }

    private function findRoute(string $uri, string $method): Route|false
    {
        if (!isset($this->routes[$method][$uri])) {
            return false;
        }
        return $this->routes[$method][$uri];{
        }
    }


    private function initRotes()
    {
        $routes = $this->getRoutes();

        foreach ($routes as $route) {
            $this->routes[$route->getMethod()][$route->getUri()] = $route;
        }
    }


    /**
     * @return Route[]
     *
     */



    private function getRoutes(): array
    {
        return require_once APP_PATH . "/config/routes.php";
    }

}

