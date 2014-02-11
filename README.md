# Awin\DependencyInjection

Dependency injection for PHP

## Usage Examples

    $injector = new \Awin\DependencyInjection\DependencyInjector;
    $injector->configureDependencyParamValue('Foo', 'param1', 'value to use in constructor');
    $injector->configureDependencyParamClass('Foo', 'param2', '\Bar');
    $foo = $injector->get('Foo')';

## Configuration-Free Usage

Simply type-hint the constructor parameters of your dependency, and you needn't
offer any configuration information to the injector - it will use reflection to
figure out what is needed.

E.g.:

    class Foo
    {
        public function __construct(Bar $param)
        {
            //...
        }
        //...
    }
    $foo = $injector->get('Foo'); // Constructor param retrieved recursively from
                                  // injector at this point, based on type-hint.


[![Build Status](https://travis-ci.org/DigitalWindow/dependency-injection.png?branch=master)](https://travis-ci.org/DigitalWindow/dependency-injection)