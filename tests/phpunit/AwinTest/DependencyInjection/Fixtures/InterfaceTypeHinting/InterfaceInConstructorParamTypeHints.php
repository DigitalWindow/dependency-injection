<?php
namespace AwinTest\DependencyInjection\Fixtures\InterfaceTypeHinting;

use AwinTest\DependencyInjection\Fixtures\InterfaceTypeHinting\SimpleInterface;

class InterfaceInConstructorParamTypeHints
{
    /**
     * @var SimpleInterface
     */
    public $param;

    /**
     * @param SimpleInterface $param1
     */
    public function __construct(SimpleInterface $param1)
    {
        $this->param = $param1;
    }
}
