<?php
namespace Awin\DependencyInjection;

use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;

interface ReflectorInterface
{
    /**
     * @param string $classname
     * @return ReflectionClass
     */
    public function getReflectionClass($classname);

    /**
     * @param string $classname
     * @return ReflectionMethod
     */
    public function getConstructorReflectionMethod($classname);

    /**
     * @param string $classname
     * @return ReflectionParameter[]
     */
    public function getConstructorReflectionParameters($classname);
}
