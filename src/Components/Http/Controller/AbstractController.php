<?php


namespace App\Components\Http\Controller;

use App\Components\Http\Request;

/**
 * Class AbstractController
 * @package App\Application\Controllers
 */
abstract class AbstractController
{

    /**
     * @param Request $request
     * @param array $rules
     */
    final public function validate(Request $request, array $rules)
    {
        $inputs = $request->check($rules)->validate();

        if ($inputs->isFailed()) {
            return exit(redirect()
                ->back()
                ->withFormError($inputs->getErrors())
                ->withOldInput()
                ->header());
        }
    }
}
