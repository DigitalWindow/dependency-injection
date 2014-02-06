<?php
namespace Awin\DependencyInjection\Exception;

use RuntimeException;

class ClassDoesNotExistException extends RuntimeException
{
    public function __construct($classname, $code = null, $previous = null)
    {
        parent::__construct('Awin\DependencyInjection cannot create a "' . $classname . '": class does not exist');
    }
}
