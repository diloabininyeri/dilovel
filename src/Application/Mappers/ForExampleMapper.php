<?php


namespace App\Application\Mappers;

use App\Components\Arr\ArrayMapper;

/**
 * Class ForExampleMapper
 * @package App\Application\Mappers
 */
class ForExampleMapper extends ArrayMapper
{
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}
