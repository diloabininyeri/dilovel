<?php


namespace App\Application\Request;

use App\Application\Rules\RequiredNumericRule;
use App\Application\Rules\RequiredRule;
use App\Application\Rules\TcNoVerifyRule;
use App\Components\Http\Request;
use App\Interfaces\FormRequestInterface;
use App\Interfaces\RuleInterface;

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
            new TcNoVerifyRule(),
            new RequiredNumericRule(),
            new RequiredRule(),
        ];
    }
}
