<?php
namespace AwinTest\DependencyInjection\Fixtures\NonObjectConstructorParams;

class OptionalParams
{
    /**
     * @var string
     */
    public $param1;
    /**
     * @var string
     */
    public $param2;

    /**
     * @param string $param1
     * @param string $param2
     */
    public function __construct($param1 = 'default value defined in class', $param2 = 'default value defined in class')
    {
        $this->param1 = $param1;
        $this->param2 = $param2;
    }
}
