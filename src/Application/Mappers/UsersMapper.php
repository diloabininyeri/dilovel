<?php


namespace App\Application\Mappers;

use App\Components\Arr\ArrayMapper;

/**
 * Class UsersMapper
 * @package App\Application\Mappers
 */
class UsersMapper extends ArrayMapper
{


    /**
     * @return string
     */
    public function getNameSurname()
    {
        return sprintf('%s %s', $this->name, $this->surname);
    }
}
