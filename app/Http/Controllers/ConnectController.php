<?php

namespace App\Http\Controllers;

use App\Models\Connect,
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
        $connect = $request->get('connect');

        try {
            new ApiClient($request->secretId, $request->secretKey, new SessionStorage());

            $connect->secretId = $request->secretId;
            $connect->secretKey = $request->secretKey;
            $connect->save();

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
        $connect = $request->get('connect');

        $connect->secretId = null;
        $connect->secretKey = null;
        $connect->save();

        return redirect('/connect');
    }
}
