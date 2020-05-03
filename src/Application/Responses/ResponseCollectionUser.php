<?php


namespace App\Application\Responses;

use App\Components\Collection\ResponseCollection;
use App\Interfaces\ResponseCollectionInterface;

/**
 * Class ResponseUser
 * @package App\app\Responses
 */
class ResponseCollectionUser extends ResponseCollection implements ResponseCollectionInterface
{

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [

            'status'=>true,
            'user'=>$this->collection
        ];
    }
}
