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

class Dispatcher
{

    private $obj;

    /**
     * Dispatcher constructor.
     * @param $obj
     */
    public function __construct($obj)
    {
        $this->obj = $obj;
    }

    /**
     * Get the underlying object
     * @return mixed
     */
    public function obj(){
        return $this->obj;
    }

    /**
     * @param string $method
     * @param array $params
     * @return mixed
     * @throws \ReflectionException
     */
    public function run(string $method, array $params = []){

        $class = new ReflectionClass(get_class($this->obj));
        $method = $class->getMethod($method);
        $injected = self::injectParams($method, $params);
        return $method->invokeArgs($this->obj, $injected);
    }

    /**
     * Create class by name and parameters array
     *
     * @param string $class
     * @param array $params
     * @return Dispatcher
     * @throws \ReflectionException
     */
    public static function create(string $class, array $params = []){
        $class = new ReflectionClass($class);
        $method = $class->getConstructor();
        $injected = self::injectParams($method, $params);
        return new self($class->newInstanceArgs($injected));
    }

    /**
     * Call an static method
     *
     * @param string $class
     * @param string $method
     * @param array $params
     * @return mixed
     * @throws \ReflectionException
     */
    public static function dispatch(string $class, string $method, array $params= []){

        $class = new ReflectionClass($class);
        $method = $class->getMethod($method);

        if(!$method->isStatic()){
            throw new InvalidArgumentException("Method [{$method}] must be static");
        }

        $injected = self::injectParams($method, $params);
        return $method->invokeArgs(null, $injected);
    }

    /**
     * Inject params from array and default values
     *
     * @param ReflectionMethod $method
     * @param array $params
     * @return array
     */
    private static function injectParams(ReflectionMethod $method, array $params): array{
        return array_map(function ($parameter) use ($method, $params) {

            if (array_key_exists($parameter->name, $params)) {
                return $params[$parameter->name];
            }

            /** @var \ReflectionParameter $parameter */
            if ($parameter->isDefaultValueAvailable()) {
                return $parameter->getDefaultValue();
            }

            $sep = $method->isStatic() ? "::" : "->";
            throw new InvalidArgumentException("Unable to map parameter [{$parameter->name}] to  [{$method->class}$sep{$method->name}]");

        }, $method->getParameters());
    }


}