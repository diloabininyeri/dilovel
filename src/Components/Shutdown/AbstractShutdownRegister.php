<?php


namespace App\Components\Shutdown;

use App\Interfaces\RegisterShutdownInterface;

/**
 * Class AbstractShutdownRegister
 * @package App\Components\Shutdown
 */
abstract class AbstractShutdownRegister
{

    /**
     *
     */
    public function onShutdown():void
    {
        register_shutdown_function(function () {
            foreach ($this->getRegisters() as $register) {
                /**
                 * @var RegisterShutdownInterface $class
                 */
                $class=new $register();
                $class->appOnShutdown();
            }
        });
        $this->callDeferObjects();
    }


    /**
     * @return array
     */
    private function getRegisters():array
    {
        return $this->register;
    }

    /**
     *
     */
    private function callDeferObjects():void
    {
        $objects=$this::$dynamicRegister;
        foreach ($objects as $object) {
            $object->appOnShutdown();
        }
    }

    /**
     * @param RegisterShutdownInterface $registerShutdown
     */
    public static function addDeferObject(RegisterShutdownInterface $registerShutdown):void
    {
        static::$dynamicRegister[]=$registerShutdown;
    }
}
