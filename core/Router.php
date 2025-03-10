<?php

namespace App\Core;

use ReflectionClass;
use ReflectionMethod;

class Router
{
    public function dispatch(string $uri, string $httpMethod = 'GET')
    {
        $uri = rtrim($uri, "/"); // Normaliser l'URL (supprime le / final)
        if ($uri === '') $uri = '/';

        // On récupère la liste des classes contrôleurs
        foreach (glob(__DIR__ . "/../controllers/*.php") as $file) {
            require_once $file;
        }

        $classes = get_declared_classes();

        foreach ($classes as $class) {
            if (is_subclass_of($class, \App\Core\BaseController::class) || str_starts_with($class, "App\\Controllers\\")) {
                $reflection = new ReflectionClass($class);

                foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                    $attributes = $method->getAttributes(Route::class);

                    foreach ($attributes as $attribute) {
                        /** @var Route $routeAttr */
                        $routeAttr = $attribute->newInstance();
                        $pattern = $this->convertToRegex($routeAttr->path);
                        $params = [];

                        // Vérification de correspondance entre l'URI et le pattern
                        if (preg_match($pattern, $uri, $matches)) {
                            array_shift($matches); // On retire le match complet
                            $params = $matches;

                            // Instancier le contrôleur et appeler la méthode avec les paramètres
                            $controller = new $class();
                            return $method->invokeArgs($controller, $params);
                        }
                    }
                }
            }
        }

        // Si aucune route ne correspond
        header("HTTP/1.0 404 Not Found");
        echo "404 - Page non trouvée";
    }

    private function convertToRegex(string $route): string
    {
        return "@^" . preg_replace('/\{([^}]+)\}/', '([^/]+)', $route) . "$@";
    }
}
