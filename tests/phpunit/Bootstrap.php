<?php

class Bootstrap
{
    public function init()
    {
        $this->autoloadComposer();
        $this->autoloadTestsAndApplication();
    }

    private function autoloadComposer()
    {
        require_once __DIR__ . '/../../vendor/autoload.php';
    }

    private function autoloadTestsAndApplication()
    {
        // Use Symfony component to sort out PSR-0 compatible autoloading
        $loader = new \Symfony\Component\ClassLoader\UniversalClassLoader;
        $loader->registerNamespace('Awin',     __DIR__ . '/../../src');
        $loader->registerNamespace('AwinTest', __DIR__);
        $loader->register();
    }
}

$bootstrap = new Bootstrap;
$bootstrap->init();
