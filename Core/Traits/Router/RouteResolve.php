<?php

namespace Zed\Framework\Traits\Router;

use Zed\Framework\{Controller, Response};
use Exception;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
trait RouteResolve
{
    /**
     * Handling Request And Returning Response.
     * 
     * @since 1.0.0
     * 
     * @return string|null
     */
    public function resolve(): ?string
    {
        $route = $this->mapRoute();
        
        if (! is_null($route)) {
            $this->callMiddleware($route['middlewares']);
            $callback = $route['callback'];
            $this->saveRequest();
        }

        switch (gettype($callback)) {
            case 'NULL':
                return $this->routeNotFound();
            break;
            case 'array':
                return $this->fromArray($callback);
            break;
            case 'string':
                return $this->fromString($callback);
            break;
            case 'object':
                return $this->fromClosure($callback);
            break;
        }
    }

    /**
     * In Case Route Is Set Using "Controller@Action" Syntax.
     * 
     * @since 1.0.0
     * 
     * @param string $map
     * 
     * @return string|null
     */
    private function fromString(string $map): ?string
    {
        try {
            $parts = explode('@', $map);

            $class = "\\App\\Controllers\\$parts[0]";

            $callback = [
                new $class(),
                $parts[1]
            ];

            return call_user_func_array($callback, $this->params);
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * In Case Route Is Set Using [Controller::class, 'action'] Syntax.
     * 
     * @since 1.0.0
     * 
     * @param array $map
     * 
     * @return string|null
     */
    private function fromArray(array $map): ?string
    {
        try {
            $callback = [
                new $map[0],
                $map[1]
            ];

            return call_user_func_array($callback, $this->params);
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * In Case Route Callback Is a Closure.
     * 
     * @since 1.0.0
     * 
     * @param object $callback
     * 
     * @return string|null
     */
    private function fromClosure(object $callback): ?string
    {
        try {
            return call_user_func_array($callback, $this->params);
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * When Requested Route Doesn't Match Match Any Routes In Application.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    private function routeNotFound(): string
    {
        return (new Controller)->error(
            Response::ERROR,
            Response::INVALID_ROUTE,
            Response::HTTP_NOT_FOUND
        );
    }
}
