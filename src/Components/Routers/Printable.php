<?php


namespace App\Components\Routers;


use App\Components\Collections;
use App\Database\Model;
use JsonException;

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
     * @throws JsonException
     */

    public function output(): void
    {
        if ($this->data instanceof Collections) {
            header('Content-type:application/json');
            echo $this->data;
        } else if ($this->data instanceof Model) {
            header('Content-type:application/json');
            echo json_encode($this->data, JSON_THROW_ON_ERROR, 512);
        } else if (is_array($this->data) || is_object($this->data)) {
            echo '<pre>';
            print_r($this->data);
            echo '</pre>';
        } else {
            echo $this->data;
        }


    }

}