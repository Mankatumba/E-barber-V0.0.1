<?php

class Router
{
    protected $url;

    public function __construct($url)
    {
        $this->url = trim($url, '/');
    }

    public function dispatch()
    {
        $segments = explode('/', $this->url);

        $controllerName = !empty($segments[0]) ? ucfirst($segments[0]) . 'Controller' : 'AuthController';
        $methodName = $segments[1] ?? 'index';
        $params = array_slice($segments, 2);

        $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            if (class_exists($controllerName)) {
                $controller = new $controllerName();

                // Fallback DELETE via POST form (par exemple /salon/gallery/delete/12)
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && $methodName === 'delete' && isset($params[0])) {
                    $methodName .= '';
                }

                if (method_exists($controller, $methodName)) {
                    call_user_func_array([$controller, $methodName], $params);
                } else {
                    $this->error("Méthode [$methodName] introuvable dans $controllerName");
                }
            } else {
                $this->error("Contrôleur [$controllerName] inexistant");
            }
        } else {
            $this->error("Fichier de contrôleur [$controllerName] manquant");
        }
    }

    protected function error($message)
    {
        http_response_code(404);
        echo "<h1>404 - Not Found</h1><p>$message</p>";
        exit;
    }
}
