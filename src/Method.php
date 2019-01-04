<?php
/**
 * Created by IntelliJ IDEA.
 * User: xooxx
 * Date: 04-01-2019
 * Time: 15:04
 */

namespace Xooxx\Reflection;


use InvalidArgumentException;
use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;

class Method
{

    /**
     * Get method static parameters
     *
     * @param string $class
     * @param string $method
     * @return mixed
     * @throws \ReflectionException
     */
    public static function parameters(string $class = null, string $method = null): array{

        if($class == null){
            $class = debug_backtrace()[1]['class'];
        }

        if($method == null){
            $method= debug_backtrace()[1]['function'];
        }

        $class = new ReflectionClass($class);
        $method = $class->getMethod($method);

        return array_map(function( $item ){
            /**@var ReflectionParameter $item*/
            return $item->getName() ;
        }, $method->getParameters());
    }
}