<?php
namespace AwinTest\DependencyInjection\Fixtures\Basic;

class UnknownConstructorArg
{
    /**
     * @var mixed
     */
    public $param;

    /**
     * @param mixed $param
     */
    public function __construct($param)
    {
        
    }
}
