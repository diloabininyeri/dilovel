<?php


namespace App\Components\Routers;

use App\Components\Collection\Collection;
use App\Components\Database\Model;
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
        if ($this->data instanceof Collection) {
            header('Content-type:application/json');
            echo $this->data;
        } elseif ($this->data instanceof Model) {
            header('Content-type:application/json');
            echo json_encode($this->data, JSON_THROW_ON_ERROR, 512);
        } elseif (is_array($this->data) || is_object($this->data)) {
            echo '<pre>';
            print_r($this->data);
            echo '</pre>';
        } else {
            echo $this->data;
        }
    }
}
