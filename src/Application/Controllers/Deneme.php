<?php


namespace App\Application\Controllers;

use App\Application\Elastic\ElasticModelExample;
use App\Application\Models\Users;
use App\Components\Collection\Collection;
use App\Components\Elasticsearch\Elastic;
use App\Components\Http\Request;
use App\Components\Reflection\RuleAnnotation;
use Faker\Factory;

/**
 * Class Deneme
 * @package App\Application\Controllers
 */
class Deneme
{
    public function index(Request $request)
    {
        $faker = Factory::create('tr_TR');
        $model=new ElasticModelExample();
        $model->name=$faker->firstName;
        $model->surname=$faker->lastName;
        $model->age=random_int(1, 80);
        $model->save();

        return ElasticModelExample::all();
    }
}
