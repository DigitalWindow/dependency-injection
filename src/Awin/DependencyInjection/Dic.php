<?php
namespace Awin\DependencyInjection;

use Awin\DependencyInjection\DicInterface;

class Dic implements DicInterface
{
    /**
     * @var array
     */
    protected $containerArray;

    /**
     * @param string $dependencyName
     * @return boolean
     */
    public function has($dependencyName)
    {
        return isset($this->containerArray[$dependencyName]);
    }

    /**
     * @param string $dependencyName
     * @return mixed
     */
    public function get($dependencyName)
    {
        return
            $this->has($dependencyName) ?
            $this->containerArray[$dependencyName] :
            null;
    }

    /**
     * @param string $dependencyName
     * @param mixed  $dependency
     */
    public function set($dependencyName, $dependency)
    {
        $this->containerArray[$dependencyName] = $dependency;
    }

    public function reset()
    {
        $this->containerArray = array();
    }
}
