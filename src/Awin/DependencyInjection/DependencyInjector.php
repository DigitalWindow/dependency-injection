<?php
namespace Awin\DependencyInjection;

use Awin\DependencyInjection\Exception\ClassDoesNotExistException;
use Awin\DependencyInjection\Exception\BadDiInterfaceConfigurationException;
use Awin\DependencyInjection\Exception\BadDiSubclassConfigurationException;
use Awin\DependencyInjection\DicInterface;
use Awin\DependencyInjection\Dic;
use Awin\DependencyInjection\DependencyConfigurationInterface;
use Awin\DependencyInjection\DependencyConfiguration;
use Awin\DependencyInjection\ReflectorInterface;
use Awin\DependencyInjection\Reflector;
use ReflectionParameter;

class DependencyInjector
{
    /**
     * @var DependencyInjector
     */
    protected static $singleInstace;

    /**
     * @var DicInterface
     */
    protected $container;

    /**
     * @var DependencyConfigurationInterface
     */
    protected $configuration;

    /**
     * @var ReflectorInterface
     */
    protected $reflector;

    /**
     * @param DicInterface                     $container
     * @param DependencyConfigurationInterface $configuration
     * @param ReflectorInterface               $reflector
     */
    public function __construct(
        DicInterface                     $container     = null,
        DependencyConfigurationInterface $configuration = null,
        ReflectorInterface               $reflector     = null
    ) {
        $this->container     = $container     ?: new Dic;
        $this->configuration = $configuration ?: new DependencyConfiguration;
        $this->reflector     = $reflector     ?: new Reflector;
    }

    /**
     * Singleton-like getter.  Privacy of constructor is not inforced, because why bother, but single instance
     * can be accessed statically if desired, e.g. to use the same injector in application and tests.
     *
     * @param DicInterface                     $container
     * @param DependencyConfigurationInterface $configuration
     * @param ReflectorInterface               $reflector
     * @return DependencyInjector
     */
    public static function getSingleInstance(
        DicInterface                     $container     = null,
        DependencyConfigurationInterface $configuration = null,
        ReflectorInterface               $reflector     = null
    ) {
        if (!static::$singleInstace) {
            static::$singleInstace = new static($container, $configuration, $reflector);
        }
        return static::$singleInstace;
    }

    /**
     * @throws ClassDoesNotExistException
     *
     * @param mixed   $dependencyClassname
     * @param boolean $guaranteeNew         Whether or not to store dependencies and return in a singleton-like way.
     *                                      Default false.
     * @return mixed
     */
    public function get($dependencyClassname, $guaranteeNew = false)
    {
        if (!class_exists($dependencyClassname) && !($this->container->has($dependencyClassname) && !$guaranteeNew)) {
            throw new ClassDoesNotExistException($dependencyClassname);
        }

        $dependency = $this->getDependency($dependencyClassname, $guaranteeNew);
        $this->container->set($dependencyClassname, $dependency);
        return $dependency;
    }

    /**
     * @param string $dependencyClassname
     * @param mixed  $dependency
     */
    public function set($dependencyClassname, $dependency)
    {
        $this->container->set($dependencyClassname, $dependency);
    }

    /**
     * @param string  $dependencyClassname
     * @param boolean $guaranteeNew
     * @return mixed  Of type '$dependencyClassname'
     */
    protected function getDependency($dependencyClassname, $guaranteeNew)
    {
        if (!$guaranteeNew && $this->container->has($dependencyClassname)) {
            return $this->container->get($dependencyClassname);
        }
        return $this->getNewDependency($dependencyClassname);
    }

    /**
     * @param string $dependencyClassname
     * @return mixed  Of type '$dependencyClassname'
     */
    protected function getNewDependency($dependencyClassname)
    {
        $reflectionParams = $this->reflector->getConstructorReflectionParameters($dependencyClassname);

        $constructorParamsToUse = array();

        foreach ($reflectionParams as $reflectionParam) {
            $constructorParamsToUse[] = $this->getValueToUseForConstructorParameter($reflectionParam, $dependencyClassname);
        }
        $reflectionClass = $this->reflector->getReflectionClass($dependencyClassname);
        return $reflectionClass->newInstanceArgs($constructorParamsToUse);
    }

    /**
     * @param ReflectionParameter $reflectionParam
     * @param string              $dependencyClassname
     * @return mixed
     */
    protected function getValueToUseForConstructorParameter(ReflectionParameter $reflectionParam, $dependencyClassname)
    {
        if ($this->configuration->hasSubdependencyValue($dependencyClassname, $reflectionParam->name)) {
            $subdependency = $this->configuration->getSubdependencyValue($dependencyClassname, $reflectionParam->name);
        } elseif ($reflectionParam->getClass() instanceof \ReflectionClass) {
            $subdependency = $this->get($this->getSubdependencyType($dependencyClassname, $reflectionParam));
        } elseif ($reflectionParam->isDefaultValueAvailable()) {
            $subdependency = $reflectionParam->getDefaultValue();
        } else {
            $subdependency = null;
        }

        return $subdependency;
    }

    /**
     * @param string $dependencyClassname
     * @param string $dependencyConstructorParamName
     * @param mixed  $dependencyConstructorParamValue
     */
    public function configureDependencyParamValue(
        $dependencyClassname,
        $dependencyConstructorParamName,
        $dependencyConstructorParamValue
    ) {
        $this->configuration->setSubdependencyValue($dependencyClassname, $dependencyConstructorParamName, $dependencyConstructorParamValue);
    }

    /**
     * @param string $dependencyClassname
     * @param string $dependencyConstructorParamName
     * @param string $dependencyConstructorParamClass
     */
    public function configureDependencyParamClass(
        $dependencyClassname,
        $dependencyConstructorParamName,
        $dependencyConstructorParamClass
    ) {
        $this->configuration->setSubdependencyType($dependencyClassname, $dependencyConstructorParamName, $dependencyConstructorParamClass);
    }

    /**
     * @param string              $dependencyClassname
     * @param ReflectionParameter $subdependencyReflectionParam
     * @return string
     */
    protected function getSubdependencyType($dependencyClassname, $subdependencyReflectionParam)
    {
        if ($this->configuration->hasSubdependencyType($dependencyClassname, $subdependencyReflectionParam->name)) {
            $typeToReturn = $this->configuration->getSubdependencyType($dependencyClassname, $subdependencyReflectionParam->name);
            $this->errorCheckConfiguredSubdependencyType($subdependencyReflectionParam, $typeToReturn, $dependencyClassname);
        } else {
            $typeToReturn = $subdependencyReflectionParam->getClass()->name;
        }

        return $typeToReturn;
    }

    /**
     * @throws BadDiInterfaceConfigurationException
     * @throws BadDiSubclassConfigurationException
     *
     * @param ReflectionParameter $subdependencyReflectionParam
     * @param string              $proposedType
     * @param string              $dependencyClassname
     */
    protected function errorCheckConfiguredSubdependencyType($subdependencyReflectionParam, $proposedType, $dependencyClassname)
    {
        $reflectionClassOfParamTypehint = $subdependencyReflectionParam->getClass();
        $paramTypehint                  = $reflectionClassOfParamTypehint->name;

        if ($reflectionClassOfParamTypehint->isInterface())
        {
            $interfacesImplemented = class_implements($proposedType);
            if (!in_array($paramTypehint, $interfacesImplemented)) {
                throw new BadDiInterfaceConfigurationException(
                    "Configured to use type '$proposedType' as implentation of interface '" . $paramTypehint . "' when producing a '$dependencyClassname', but it doesn't implement the interface."
                );
            }
        } else {
            $requiredClassname = '\\' . $paramTypehint;
            if ( ! ($proposedType === $requiredClassname || is_subclass_of($proposedType, $requiredClassname) )) {
                throw new BadDiSubclassConfigurationException(
                    "Configured to use type '$proposedType' as subclass of '$requiredClassname' when producing a '$dependencyClassname', but it is failing an instanceof test."
                );
            }
        }
    }
}
