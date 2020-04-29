<?php


namespace App\Application\Request;


use App\Application\Rules\TcNoVerifyRule;
use App\Components\Http\Request;
use App\Interfaces\FormRequestInterface;


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