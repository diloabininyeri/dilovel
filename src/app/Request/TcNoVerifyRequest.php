<?php


namespace App\app\Request;


use App\app\Rules\TcNoVerifyRule;
use App\Http\Request;
use App\interfaces\FormRequestInterface;


/**
 * Class TcNoVerifyRequest
 * @package App\app\Request
 */
class TcNoVerifyRequest extends Request implements FormRequestInterface
{

    /**
     * @return TcNoVerifyRule[]|array
     */
    public function rules(): array
    {
        return [
            new TcNoVerifyRule()
        ];
    }
}