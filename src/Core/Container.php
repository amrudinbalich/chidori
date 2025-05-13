<?php

namespace Chidori\Foundation\Core;

use Exception;
use ReflectionClass;
use ReflectionFunction;
use ReflectionMethod;

/**
 * Container class for resolving and keeping dependencies and callable functions.
 *
 * This class is responsible for resolving classes, methods, and functions
 * with their dependencies using reflection.
 */
class Container
{
    private array $resolved = [];

    private array $registered = [];

    public function get(string $service) {

        if(array_key_exists($service, $this->resolved)) {
            return $this->resolved[$service];
        }

        if(array_key_exists($service, $this->registered)) {
            return $this->registered[$service]();
        }

        $resolvedService = $this->resolve($service);
        $this->resolved[$service] = $resolvedService;

        return $resolvedService;
    }

    public function resolve(callable|array $callable, array $routeParams = [])
    {
        if (is_array($callable)) {
            [$class, $method] = $callable;
            $object = $this->resolveClass($class);
            $params = $this->resolveMethodDependencies($object, $method, $routeParams);

            return call_user_func_array([$object, $method], $params);
        }
        // LARAVEL OLD STYLE ------->
//        elseif (is_string($callable) && str_contains($callable, '@')) {
//            [$class, $method] = explode('@', $callable);
//            $object = $this->resolveClass($class);
//            $params = $this->resolveMethodDependencies($object, $method, $routeParams);
//
//            return call_user_func_array([$object, $method], $params);
//       } ------- OLD LARAVEL STYLE
        elseif (is_callable($callable)) {
            $params = $this->resolveFunctionDependencies($callable, $routeParams);
            return call_user_func_array($callable, $params);
        }

        throw new Exception("Unresolvable callable.");
    }

    /**
     * Register a complex service/class into a container so it can be resolved when needed.
     * You have a boilerplate constructor or setting-up process that you don't wish to have in your controller/service/ command or any other place?
     * Registering a service gives you a chance to append a resolver callback to your service in the ` config / services.php ` file.
     *
     * Feel free to take a look at the mentioned file to see examples. It should be simple, and it is to: 1. register, 2. call get :)
     *
     * @param string $service classname
     * @param callable $resolver
     * @return void
     */
    public function register(string $service, callable $resolver): void {
        if (!class_exists($service)) {
            throw new Exception("Class [$service] does not exist.");
        }

        // remember the resolver when it gets called
        $this->registered[$service] = $resolver;
    }

    public function resolveClass($class)
    {
        $reflector = new ReflectionClass($class);

        if (!$reflector->isInstantiable()) {
            throw new Exception("Class [$class] is not instantiable.");
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            return new $class;
        }

        $dependencies = $this->resolveParameters($constructor->getParameters());

        return $reflector->newInstanceArgs($dependencies);
    }

    private function resolveMethodDependencies($object, $method, array $routeParams)
    {
        $reflector = new ReflectionMethod($object, $method);
        return $this->resolveParameters($reflector->getParameters(), $routeParams);
    }

    private function resolveFunctionDependencies($function, array $routeParams)
    {
        $reflector = new ReflectionFunction($function);
        return $this->resolveParameters($reflector->getParameters(), $routeParams);
    }

    private function resolveParameters($parameters, array $routeParams = [])
    {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $name = $parameter->getName();
            $type = $parameter->getType();

            if (array_key_exists($name, $routeParams)) {
                $dependencies[] = $routeParams[$name];
            } elseif ($type && !$type->isBuiltin()) {
                $dependencies[] = $this->resolveClass($type->getName());
            } elseif ($parameter->isDefaultValueAvailable()) {
                $dependencies[] = $parameter->getDefaultValue();
            } else {
                throw new Exception("Cannot resolve parameter \${$name}");
            }
        }

        return $dependencies;
    }
}