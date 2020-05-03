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
        register_shutdown_function(function (){
            foreach ($this->getRegisters() as $register) {
                /**
                 * @var RegisterShutdownInterface $class
                 */
                $class=new $register();
                $class->appOnShutdown();
            }
        });
    }


    /**
     * @return array
     */
    private function getRegisters():array
    {
        return $this->register;
    }
}