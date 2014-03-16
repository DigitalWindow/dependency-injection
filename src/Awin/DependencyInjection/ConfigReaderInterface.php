<?php
namespace Awin\DependencyInjection;

interface ConfigReaderInterface
{
    /**
     * @param string                           $path
     * @param DependencyConfigurationInterface $config
     */
    public function addConfigFileToConfiguration($path, $config);
}
