<?php
namespace Awin\DependencyInjection;

use Awin\DependencyInjection\DependencyConfigurationInterface;

class DependencyConfiguration implements DependencyConfigurationInterface
{
    /**
     * @var array
     */
    protected $subdependencyValues;

    /**
     * @var string[]
     */
    protected $subdependencyTypes;

    /**
     * @param string $dependencyName
     * @param string $subdependencyName
     * @param mixed  $subdependencyValue
     */
    public function setSubdependencyValue($dependencyName, $subdependencyName, $subdependencyValue)
    {
        if (!isset($this->subdependencyValues[$dependencyName])) {
            $this->subdependencyValues[$dependencyName] = array();
        }

        $this->subdependencyValues[$dependencyName][$subdependencyName] = $subdependencyValue;
    }

    /**
     * @param string $dependencyName
     * @param string $subdependencyName
     * @param string $subdependencyType
     */
    public function setSubdependencyType($dependencyName, $subdependencyName, $subdependencyType)
    {
        if (!isset($this->subdependencyTypes[$dependencyName])) {
            $this->subdependencyTypes[$dependencyName] = array();
        }

        $this->subdependencyTypes[$dependencyName][$subdependencyName] = $subdependencyType;
    }

    /**
     * @param string $dependencyName
     * @param string $subdependencyName
     * @return boolean
     */
    public function hasSubdependencyValue($dependencyName, $subdependencyName)
    {
        return
            isset($this->subdependencyValues[$dependencyName]) &&
            isset($this->subdependencyValues[$dependencyName][$subdependencyName]);
    }

    /**
     * @param string $dependencyName
     * @param string $subdependencyName
     * @return boolean
     */
    public function hasSubdependencyType($dependencyName, $subdependencyName)
    {
        return
            isset($this->subdependencyTypes[$dependencyName]) &&
            isset($this->subdependencyTypes[$dependencyName][$subdependencyName]);
    }

    /**
     * @param string $dependencyName
     * @param string $subdependencyName
     * @return mixed
     */
    public function getSubdependencyValue($dependencyName, $subdependencyName)
    {
        return
            $this->hasSubdependencyValue($dependencyName, $subdependencyName) ?
            $this->subdependencyValues[$dependencyName][$subdependencyName] :
            null;
    }

    /**
     * @param string $dependencyName
     * @param string $subdependencyName
     * @return string|null
     */
    public function getSubdependencyType($dependencyName, $subdependencyName)
    {
        return
            $this->hasSubdependencyType($dependencyName, $subdependencyName) ?
            $this->subdependencyTypes[$dependencyName][$subdependencyName] :
            null;
    }
}
