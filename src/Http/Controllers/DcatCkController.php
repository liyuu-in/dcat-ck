<?php

namespace Liyuu\DcatCK\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Liyuu\DcatCK\Http\Middleware\CKFinderMiddleware;

class DcatCkController extends Controller
{
    //public function index(Content $content)
    //{
    //    return $content
    //        ->title('Title')
    //        ->description('Description')
    //        ->body(view('dcat-ck::index'));
    //}

    public function __construct()
    {
        $authenticationMiddleware = config('ckfinder.authentication');

        if ($authenticationMiddleware) {
            $this->middleware($authenticationMiddleware);
        } else {

            $this->middleware(CKFinderMiddleware::class);
        }
    }

    public function requestAction(Request $request)
    {
        //dd($request);
        return app('CKConnector')->handle($request);
    }

    public function browserAction(Request $request)
    {
        return view('dcat-ck::browser');
    }
}
