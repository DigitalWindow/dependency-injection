<?php
namespace Awin\DependencyInjection;

use Awin\DependencyInjection\ReflectorInterface;

use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;

class Reflector implements ReflectorInterface
{
    /**
     * @var ReflectionClass[]
     */
    protected $reflectionClasses;

    /**
     * @var ReflectionMethod[]
     */
    protected $constructorReflectionMethods;

    /**
     * @var array
     */
    protected $constructorReflectionParameters;

    /**
     * @param string $classname
     * @return ReflectionClass
     */
    public function getReflectionClass($classname)
    {
        if (!isset($this->reflectionClasses[$classname])) {
            $this->reflectionClasses[$classname] = new ReflectionClass($classname);
        }
        return $this->reflectionClasses[$classname];
    }

    /**
     * @param string $classname
     * @return ReflectionMethod
     */
    public function getConstructorReflectionMethod($classname)
    {
        if (!isset($this->constructorReflectionMethods[$classname])) {
            $this->constructorReflectionMethods[$classname] = $this->getReflectionClass($classname)->getConstructor();
        }
        return $this->constructorReflectionMethods[$classname];
    }

    /**
     * @param string $classname
     * @return ReflectionParameter[]
     */
    public function getConstructorReflectionParameters($classname)
    {
        if (!isset($this->constructorReflectionParameters[$classname])) {
            $this->constructorReflectionParameters[$classname] = $this->generateConstructorReflectionParameters($classname);
        }
        return $this->constructorReflectionParameters[$classname];
    }

    /**
     * @param string $classname
     * @return ReflectionParameter[]
     */
    protected function generateConstructorReflectionParameters($classname)
    {
        $constructorReflectionMethod = $this->getConstructorReflectionMethod($classname);

        return
            $constructorReflectionMethod instanceof ReflectionMethod ?
            $constructorReflectionMethod->getParameters()            :
            array();
    }
}
