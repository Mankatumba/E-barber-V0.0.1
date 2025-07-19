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

                // Traitement spécial pour les URLs complexes de gallery et rdv
                if ($controllerName === 'SalonController') {
                    // GESTION GALLERY
                    if ($methodName === 'gallery') {
                        if (isset($params[0]) && $params[0] === 'upload') {
                            $methodName = 'uploadImage';
                            $params = [];
                        } elseif (isset($params[0]) && $params[0] === 'delete' && isset($params[1])) {
                            $methodName = 'deleteImage';
                            $params = [$params[1]];
                        }
                    }

                    // GESTION RDV
                    if ($segments[1] === 'rdv') {
                        if (isset($segments[2]) && in_array($segments[2], ['valider', 'refuser', 'attente']) && isset($segments[3])) {
                            $methodName = $segments[2] . 'Rdv'; // Ex: validerRdv
                            $params = [$segments[3]];
                        }
                    }
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
