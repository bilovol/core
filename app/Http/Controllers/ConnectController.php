<?php

namespace App\Http\Controllers;

use App\Models\Connect,
    Illuminate\Http\Request,
    Sendpulse\RestApi\ApiClient,
    Sendpulse\RestApi\Storage\SessionStorage,
    Exception;

class ConnectController extends Controller
{
    public function getConnect(Request $request)
    {

        $SPConnect = Connect::where('id', 1)->first();

        $data['secretKey'] = $SPConnect->secretKey;
        $data['secretId'] = $SPConnect->secretId;

        return response($data, 200);
    }

    public function setConnect(Request $request)
    {
        $SPConnect = Connect::where('id', 1)->first();

        try {
            new ApiClient($request->secretId, $request->secretKey, new SessionStorage());
            $SPConnect->secretId = $request->secretId;
            $SPConnect->secretKey = $request->secretKey;
            $SPConnect->save();

        } catch (Exception $e) {
            return response($e->getMessage(), 403);
        }


        return response('Done!');
    }

    public function disconnect(Request $request)
    {
        $SPConnect = $request->get('connect');

        $SPConnect->secretId = null;
        $SPConnect->secretKey = null;
        $SPConnect->save();

        return redirect('/connect');
    }
}
