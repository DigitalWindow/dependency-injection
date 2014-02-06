<?php
namespace AwinTest\DependencyInjection\Fixtures\Basic;

class UnknownConstructorArg
{
    /**
     * @var mixed
     */
    public $param = 'class default';

    /**
     * @param mixed $param
     */
    public function __construct($param)
    {
        $this->param = $param;
    }
}
