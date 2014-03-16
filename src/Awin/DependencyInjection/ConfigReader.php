<?php
namespace Awin\DependencyInjection;

use Awin\DependencyInjection\ConfigReaderInterface;
use Awin\DependencyInjection\DependencyConfigurationInterface;
use \Symfony\Component\Yaml\Yaml;

class ConfigReader implements ConfigReaderInterface
{
    /**
     * @param string                           $path
     * @param DependencyConfigurationInterface $config
     */
    public function addConfigFileToConfiguration($path, $config)
    {
        $configFileAsArray = Yaml::parse($path);

        foreach ($configFileAsArray['awin-dependency-injection'] as $configSetting) {

            $dependencyName = $configSetting['dependency-name'];

            if (isset($configSetting['param-types'])) {
                foreach ($configSetting['param-types'] as $subdependencyName => $subdependencyType) {
                    $config->setSubdependencyType($dependencyName, $subdependencyName, $subdependencyType);
                }
            }

            if (isset($configSetting['param-values'])) {
                foreach ($configSetting['param-values'] as $subdependencyName => $subdependencyValue) {
                    $config->setSubdependencyValue($dependencyName, $subdependencyName, $subdependencyValue);
                }
            }

        }
    }
}
