<?php


namespace App\Components\Http\Controller;

use App\Components\Traits\RequestValidation;

/**
 * Class AbstractController
 * @package App\Application\Controllers
 */
abstract class AbstractController
{
    use RequestValidation;
}
