<?php


namespace App\Components\Routers;


use App\Components\Collections;
use App\Models\Model;

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
        if ($this->data instanceof Collections) {
            header('Content-type:application/json');
            echo $this->data;

        } else if ($this->data instanceof Model) {
            header('Content-type:application/json');
            echo json_encode($this->data);
        } else if (is_array($this->data) || is_object($this->data)) {
            echo '<pre>';
            print_r($this->data);
        } else {
            echo $this->data;
        }


    }

}