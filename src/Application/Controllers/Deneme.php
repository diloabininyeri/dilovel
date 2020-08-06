<?php


namespace App\Application\Controllers;

use App\Application\Elastic\ElasticModelExample;
use App\Components\Collection\Collection;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index():Collection
    {
        $bool=ElasticModelExample::bool();

        return  $bool->mustMatch('name','Dılo')
            ->mustNotMatch('surname','sürücü')
            ->mustMatch('email','berxudar@gmail.com')
            ->filterMatch('is_active',1)
            ->size(50)
            ->sortBy('age')
            ->get();
    }
}
