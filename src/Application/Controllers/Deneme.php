<?php


namespace App\Application\Controllers;

use App\Application\Models\Users;
use App\Components\Database\BuilderQuery;
use App\Components\Database\Migration\MysqlType\PrimaryKeyMigrationType;
use App\Components\Http\Request;
use App\Application\Models\Book;
use App\Components\Http\Response\Response;
use App\Components\Image\Color;
use App\Components\Image\Image;
use App\Components\Reflection\DependencyInject;
use App\Components\Reflection\CodeBeautifier;
use App\Components\Routers\CurrentRouter;
use App\Components\Routers\Dispatcher;
use App\Components\Routers\MainRouter;
use App\Components\Routers\Printable;
use App\Providers\CustomDirectiveProvider;
use Faker\Factory;
use function Symfony\Component\DependencyInjection\Loader\Configurator\ref;

class Deneme
{
    public function index()
    {
        $d= Color::rgbParse('rgb(155,200,55)');
        return Color::rgbParse('rgb(255,200,55)');
    }
}
