<?php

namespace App\Repositories;

use App\Models\Event;

class EventRepository
{
    /**
     * Update by id
     * @param $id
     * @param $data = array[
     *     'active_book'=>int,
     *     'fields'=> array('key1','key2')];
     * @return int | null
     */
    public function updateById(int $id, array $data): ?int
    {
        $fields = $this->validateFields($data['fields']);
        $event = Event::where('id', $id)->first();

        if (empty($event)) {
            return null;
        }

        $event->active_book = $data['active_book'];
        $event->fields = $fields;
        $event->save();

        return $event->id;
    }

    /**
     * Delete by Id
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool
    {
        if (empty($id)) {
            return false;
        }
        Event::where('id', $id)->delete();

        return true;
    }

    /**
     * Get list by connect id
     * @param int $connectId
     * @return object | null
     */
    public function getByListByConnectId(int $connectId)
    {
        return Event::where('connect_id', $connectId)->get();
    }

    /**
     * Create by connect id
     * @param int $connectId
     * @param array $data = array[
     *     'key'=>string,
     *     'title'=>string,
     *     'active_book'=>int,
     *     'fields'=> array('key1','key2')
     * ]
     * @return int | null
     */
    public function createByConnectId(int $connectId, array $data): ?int
    {

        $fields = $this->validateFields($data['fields']);
        $event = Event::create([
            'connect_id' => $connectId,
            'key' => $data['key'],
            'title' => $data['title'],
            'active_book' => $data['active_book'],
            'fields' => $fields,
        ]);

        return $event->id;

    }

    /**
     * Validate fields
     * @param array|null $fields
     * @return array
     */
    private
    function validateFields(array $fields = null): array
    {

        $result = [];
        foreach ($fields as $field) {
            $result[] = $field['key'];
        }

        return $result;
    }
}
