<?php

namespace App\Http\Controllers;

use App\Models\Connect,
    App\Models\Event,
    Illuminate\Http\Request,
    Sendpulse\RestApi\ApiClient,
    Sendpulse\RestApi\Storage\SessionStorage,
    Illuminate\Support\Facades\Log,
    Exception;

class SyncController extends Controller
{
    /**
     * get active events, available events into crm, available fields into crm
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     **/
    public function getSync(Request $request)
    {
        $connect = $request->get('connect');
        $data['books'] = [];

        try {
            $data['books'] = (new ApiClient($connect->secretId, $connect->secretKey, new SessionStorage()))->listAddressBooks();
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
        $data['activeEvents'] = $connect->events()->get();
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
        Log::debug('Sync set:');
        Log::debug($request->all());

        $connect = $request->get('connect');

        if (empty($request->selectedBook)) {
            return response('Укажите книгу!', 403);
        }

//        update event
        if ($request->has('eventId')) {
            $event = $connect->events()
                ->where('id', $request->eventId)
                ->first();
            $event->activeBook = $request->selectedBook;
            $event->fields = $this->validateFields($request->activeFields);
            $event->save();

            return response($event->id);
        }
//        new event
        $event = $connect->events()->create([
            'key' => $request->eventKey,
            'title' => $request->eventTitle,
            'activeBook' => $request->selectedBook,
            'fields' => $this->validateFields($request->activeFields),
        ]);

        return response($event->id);
    }

    /** Delete event from sync
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function deleteSync(Request $request)
    {
        Log::debug('Sync delete:');
        Log::debug($request->all());

        $connect = $request->get('connect');

        if (!$request->has('eventId')) {
            return response('Erorr empty eventId', 404);
        }

        $connect->events()->where('id', $request->eventId)->delete();

        return response('Done');
    }

    /**
     * validate fields for save event
     * @param  $fields array
     * @return array
     */
    private function validateFields($fields)
    {

        $result = [];
        foreach ($fields as $field) {
            $result[] = $field['key'];
        }

        return $result;
    }
}
