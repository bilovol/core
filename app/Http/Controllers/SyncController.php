<?php

namespace App\Http\Controllers;

use App\Models\Connect,
    App\Models\Event,
    Illuminate\Http\Request,
    Sendpulse\RestApi\ApiClient,
    Sendpulse\RestApi\Storage\SessionStorage,
    Illuminate\Support\Facades\Log,
    Exception;
use App\Repositories\ConnectRepository;
use App\Repositories\EventRepository;

class SyncController extends Controller
{
    /**
     * get active events, available events into crm, available fields into crm
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     **/
    public function getSync(Request $request)
    {
        $data['books'] = [];
        $connect = (new ConnectRepository())->getSpConnectById(1);

        try {
            $data['books'] = (new ApiClient($connect['secret_id'], $connect['secret_key'], new SessionStorage()))->listAddressBooks();
        } catch (Exception $e) {
            return response($e->getMessage(), 403);
        }

        //available events
        $data['events'] = [
            ['key' => 'event_system_key', 'title' => 'Test event 1',],
            ['key' => 'event_s_key', 'title' => 'Test event 3'],
            ['key' => 'event_s_key213', 'title' => 'Test event 213'],
        ];

        //select events from connect
        $data['activeEvents'] = (new EventRepository)->getByListByConnectId(1);
        //all fields
        $data['fields'] = [
            [
                'title' => 'title var1',
                'key' => 'var1',
            ],
            [
                'title' => ' title var2',
                'key' => 'var2',
            ],
            [
                'title' => ' title var3',
                'key' => 'var3',
            ]
        ];

        return response($data, 200);
    }

    /**
     * Set event
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function setSync(Request $request)
    {
        Log::debug('setSync:');
        Log::debug($request->all());

        $connectId = 1;
        $eventId = null;

        if (empty($request->selectedBook)) {
            return response('Укажите книгу!', 403);
        }

        if ($request->has('eventId')) {
            // update event
            $eventId = (new EventRepository)->updateById((int)$request->eventId, [
                'fields' => $request->activeFields,
                'active_book' => $request->selectedBook,
            ]);

        } else {
            // new event
            $eventId = (new EventRepository())->createByConnectId($connectId,
                [
                    'key' => $request->eventKey,
                    'title' => $request->eventTitle,
                    'active_book' => $request->selectedBook,
                    'fields' => $request->activeFields,
                ]);
        }

        return response($eventId);
    }

    /** Delete event from sync
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function deleteSync(Request $request)
    {
        Log::debug('deleteSync:');
        Log::debug($request->all());

        if ((new EventRepository())->deleteById($request->eventId)) {
            return response('Done!');
        }

        return response('404', 404);
    }

}
