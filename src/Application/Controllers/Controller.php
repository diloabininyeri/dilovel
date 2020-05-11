<?php


namespace App\Application\Controllers;


use App\Application\Request\TcNoVerifyRequest;
use App\Components\Http\Request;

/**
 * Class Controller
 * @package App\Controllers
 */
class Controller
{
    /**
     * @param Request $request
     * @return false|string
     */
    public function index(TcNoVerifyRequest $request)
    {
        return redirect()
            ->back()
            ->withError('error', 'custom error as string')
            ->withError('other','optional other error');
    }
}
