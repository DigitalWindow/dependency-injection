<?php
namespace Awin\DependencyInjection;

interface DicInterface
{
    /**
     * @param string $dependencyName
     * @return boolean
     */
    public function has($dependencyName);

    /**
     * @param string $dependencyName
     * @return mixed
     */
    public function get($dependencyName);

    /**
     * @param string $dependencyName
     * @param mixed  $dependency
     */
    public function set($dependencyName, $dependency);
}
