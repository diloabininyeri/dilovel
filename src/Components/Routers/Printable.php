<?php


namespace App\Components\Routers;


/**
 * Class Printable
 * @package App\Components\Routers
 */
class Printable
{

    /**
     * @var
     */
    private $data;

    /**
     * Printable constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     *
     */
    public function output(): void
    {
        if (is_array($this->data) || is_object($this->data)) {
            echo '<pre>';
            print_r($this->data);
            return;
        }

        echo $this->data;

    }

}