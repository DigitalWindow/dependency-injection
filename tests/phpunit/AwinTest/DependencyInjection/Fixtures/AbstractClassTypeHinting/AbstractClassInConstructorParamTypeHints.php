<?php
namespace AwinTest\DependencyInjection\Fixtures\AbstractClassTypeHinting;

use AwinTest\DependencyInjection\Fixtures\AbstractClassTypeHinting\AbstractParent;

class AbstractClassInConstructorParamTypeHints
{
    /**
     * @var AbstractParent
     */
    public $param;

    /**
     * @param AbstractParent $param1
     */
    public function __construct(AbstractParent $param1)
    {
        $this->param = $param1;
    }
}
