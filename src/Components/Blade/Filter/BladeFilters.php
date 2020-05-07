<?php


namespace App\Components\Blade\Filter;

use App\Application\Filter\MyFilter;
use App\Application\Filter\PhoneFilter;

class BladeFilters extends AbstractBladeFilter
{
    protected array $filters=[

        'phone'=>PhoneFilter::class,
        'my_filter'=>MyFilter::class
    ];
}
