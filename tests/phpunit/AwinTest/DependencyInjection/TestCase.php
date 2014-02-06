<?php
namespace AwinTest\DependencyInjection;

use \PHPUnit_Framework_TestCase;
use Awin\DependencyInjection\DependencyInjector;

abstract class TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var DependencyInjector
     */
    protected $injector;

    public function setUp()
    {
        $this->injector = new DependencyInjector;
    }
}
