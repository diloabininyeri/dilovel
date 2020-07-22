<?php


namespace App\Components\Route;

use App\Components\Collection\Collection;
use App\Components\Database\Model;
use JsonException;

/**
 * Class Printable
 * @package App\Components\Route
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
     * @noinspection NotOptimalIfConditionsInspection
     */

    public function output(): void
    {
        if ($this->data instanceof Collection) {
            header('Content-type:application/json');
            echo $this->data;
        } elseif (is_json($this->data)) {
            header('Content-type:application/json');
            echo $this->data;
        } elseif (is_object($this->data) && method_exists($this->data, '__toString')) {
            header('Content-type:application/json');
            echo $this->data;
        } elseif ($this->data instanceof Model) {
            header('Content-type:application/json');
            echo json_encode($this->data, JSON_THROW_ON_ERROR, 512);
        } elseif (is_array($this->data) || is_object($this->data)) {
            echo '<h2 style="color:#263238;text-align: center;">Debug screen</h2>';
            echo '<style>body{display: grid;place-content: center;background: #ecf0f1}</style>';
            echo '<pre style="width: 100%;padding: 2em;color: #263238;background: #FAFAFA;box-shadow: 0 0 15px #263238;overflow: auto;max-height: 75vh">';
            print_r($this->data);
            echo '</pre>';
        } else {
            echo $this->data;
        }
    }
}
