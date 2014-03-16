<?php
namespace Awin\DependencyInjection;

interface DependencyConfigurationInterface
{
    /**
     * @param string $dependencyName
     * @param string $subdependencyName
     * @param mixed  $subdependencyValue
     */
    public function setSubdependencyValue($dependencyName, $subdependencyName, $subdependencyValue);

    /**
     * @param string $dependencyName
     * @param string $subdependencyName
     * @param string $subdependencyType
     */
    public function setSubdependencyType($dependencyName, $subdependencyName, $subdependencyType);

    /**
     * @param string $dependencyName
     * @param string $subdependencyName
     * @return boolean
     */
    public function hasSubdependencyValue($dependencyName, $subdependencyName);

    /**
     * @param string $dependencyName
     * @param string $subdependencyName
     * @return boolean
     */
    public function hasSubdependencyType($dependencyName, $subdependencyName);

    /**
     * @param string $dependencyName
     * @param string $subdependencyName
     * @return mixed
     */
    public function getSubdependencyValue($dependencyName, $subdependencyName);

    /**
     * @param string $dependencyName
     * @param string $subdependencyName
     * @return string|null
     */
    public function getSubdependencyType($dependencyName, $subdependencyName);

    public function reset();
}
