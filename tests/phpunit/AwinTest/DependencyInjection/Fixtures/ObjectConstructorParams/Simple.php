<?php
namespace AwinTest\DependencyInjection\Fixtures\ObjectConstructorParams;

use AwinTest\DependencyInjection\Fixtures\Basic\NoConstructor;

class Simple
{
    /**
     * @var NoConstructor
     */
    public $param1;

    /**
     * @param NoConstructor $param1
     */
    public function __construct(NoConstructor $param1)
    {
        $this->param1 = $param1;
    }
}
