<?php

namespace App\Http\Controllers;

use App\Repositories\ConnectRepository;
use Illuminate\Http\Request,
    Sendpulse\RestApi\ApiClient,
    Sendpulse\RestApi\Storage\SessionStorage,
    Illuminate\Support\Facades\Log,
    Exception;

class ExportController extends Controller
{
    public function getData(Request $request)
    {
        $id = 1;
        $data = [];
        $connect = (new ConnectRepository())->getSpConnectById($id);

        try {
            $data['books'] = (new ApiClient($connect['secret_id'], $connect['secret_key'], new SessionStorage()))->listAddressBooks();
        } catch (Exception $e) {
            return response($e->getMessage(), 403);
        }

        $data['events'] = [
            [
                'title' => 'Лиды',
                'key' => 'lids',
                'fields' =>
                    [
                        ['title' => 'Имя', 'key' => 'name'],
                        ['title' => 'Телефон', 'key' => 'phone'],
                    ]
            ],
            [
                'title' => 'Аккаунты',
                'key' => 'account',
                'fields' =>
                    [
                        ['title' => 'Фамилия', 'key' => 'second_name'],
                        ['title' => 'Фото', 'key' => 'photo'],
                    ]
            ],
        ];

        return response($data);
    }

    public function doExport(Request $request)
    {
        Log::debug('doExport:');
        Log::debug($request->all());

        if (empty($request->selectedBook)) {
            return response('empty book', 403);
        }

        return response('In progress');
        //тут разбираем основу запроса и смотрим на fields active
        Log::info($request);
    }
}
