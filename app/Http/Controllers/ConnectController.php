<?php

namespace App\Http\Controllers;

use App\Models\Connect,
    App\Repositories\ConnectRepository,
    Illuminate\Http\Request,
    Sendpulse\RestApi\ApiClient,
    Sendpulse\RestApi\Storage\SessionStorage,
    Exception;

class ConnectController extends Controller
{

    /**
     * set SP connect
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function setConnect(Request $request)
    {
        $sessionConnectId = 1;
        try {
            new ApiClient($request->secretId, $request->secretKey, new SessionStorage());
            (new ConnectRepository())->setSPConnectById(1, $request->secretId, $request->secretKey);
        } catch (Exception $e) {
            return response($e->getMessage(), 403);
        }

        return response('Done!');
    }

    /**
     * disable SP connnect
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function disconnect(Request $request)
    {
        (new ConnectRepository())->deleteSPConnectById(1);
        return redirect('/connect');
    }
}
