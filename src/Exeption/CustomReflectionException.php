<?php


final class CustomReflectionException extends \ReflectionException
{
    public static function forClassUnavailable($fullClassName)
    {
        return new self('Class ' . $fullClassName . ' does not exist');
    }
}