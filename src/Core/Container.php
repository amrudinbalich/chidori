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

    public function get(string $service) {

        if(array_key_exists($service, $this->resolved)) {
            return $this->resolved[$service];
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